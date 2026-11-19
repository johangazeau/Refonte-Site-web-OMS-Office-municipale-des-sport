<?php
/**
 * Traite les actions admin sur les photos et galeries.
 * Actions possibles : add_galerie, add_images, delete_image, delete_galerie
 */

require_once 'includes/photo.inc.php';
require_once 'includes/auth.php';

// ── Seul un admin peut agir ici ──
if (!$est_admin) {
    $_SESSION['photo_erreur'] = 'Accès refusé.';
    header('Location: photo.php');
    exit;
}

$action = $_POST['action'] ?? '';

// =====================================================================
// 1. Créer une galerie
// =====================================================================
if ($action === 'add_galerie') {
    $titre = trim($_POST['titre'] ?? '');
    $date  = $_POST['date'] ?? '';

    if ($titre === '' || $date === '') {
        $_SESSION['photo_erreur'] = 'Titre et date obligatoires.';
        header('Location: photo.php');
        exit;
    }

    // Prochain ID (auto-increment non configuré sur la table)
    $maxId = db()->query('SELECT COALESCE(MAX(id), 0) + 1 AS next_id FROM galerie')->fetch()['next_id'];

    $stmt = db()->prepare('
        INSERT INTO galerie (id, date, text, permission, activite_id_galerie, galerie_id, titre, id_Activite_Club)
        VALUES (:id, :date, :texte, 1, 0, 0, :titre, NULL)
    ');
    $stmt->execute([
        'id'    => $maxId,
        'date'  => $date,
        'texte' => $titre,
        'titre' => $titre,
    ]);

    $_SESSION['photo_ok'] = 'Galerie "' . $titre . '" créée.';
    header('Location: photo.php');
    exit;
}

// =====================================================================
// 2. Ajouter des images à une galerie
// =====================================================================
if ($action === 'add_images') {
    $galerie_id = (int) ($_POST['galerie_id'] ?? 0);

    if ($galerie_id <= 0 || empty($_FILES['photos']['name'][0])) {
        $_SESSION['photo_erreur'] = 'Aucune image sélectionnée.';
        header('Location: photo.php?galerie=' . $galerie_id);
        exit;
    }

    // Dossier d'upload
    $upload_dir = __DIR__ . '/uploads/photos/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    $extensions_ok = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
    $nb_ajout = 0;

    $fichiers = $_FILES['photos'];
    $nb_fichiers = count($fichiers['name']);

    for ($i = 0; $i < $nb_fichiers; $i++) {
        // Vérifier pas d'erreur
        if ($fichiers['error'][$i] !== UPLOAD_ERR_OK) continue;

        // Vérifier l'extension
        $ext = strtolower(pathinfo($fichiers['name'][$i], PATHINFO_EXTENSION));
        if (!in_array($ext, $extensions_ok)) continue;

        // Nom unique pour éviter les collisions
        $nom_fichier = uniqid('photo_') . '.' . $ext;
        $chemin_dest = $upload_dir . $nom_fichier;
        $chemin_bdd  = 'uploads/photos/' . $nom_fichier;  // chemin relatif pour le HTML

        // Déplacer le fichier
        if (!move_uploaded_file($fichiers['tmp_name'][$i], $chemin_dest)) continue;

        // Insérer dans la table image
        $maxImgId = db()->query('SELECT COALESCE(MAX(id), 0) + 1 AS next_id FROM image')->fetch()['next_id'];

        $stmt = db()->prepare('
            INSERT INTO image (id, titre, text_sup, img_path, permission)
            VALUES (:id, :titre, \'\', :path, 1)
        ');
        $stmt->execute([
            'id'    => $maxImgId,
            'titre' => pathinfo($fichiers['name'][$i], PATHINFO_FILENAME),
            'path'  => $chemin_bdd,
        ]);

        // Lier à la galerie
        $stmt = db()->prepare('
            INSERT INTO galerie_image (galerie_id, image_id)
            VALUES (:gid, :iid)
        ');
        $stmt->execute(['gid' => $galerie_id, 'iid' => $maxImgId]);

        $nb_ajout++;
    }

    $_SESSION['photo_ok'] = $nb_ajout . ' photo(s) ajoutée(s).';
    header('Location: photo.php?galerie=' . $galerie_id);
    exit;
}

// =====================================================================
// 3. Supprimer une image
// =====================================================================
if ($action === 'delete_image') {
    $image_id   = (int) ($_POST['image_id']   ?? 0);
    $galerie_id = (int) ($_POST['galerie_id']  ?? 0);

    if ($image_id <= 0) {
        $_SESSION['photo_erreur'] = 'Image invalide.';
        header('Location: photo.php?galerie=' . $galerie_id);
        exit;
    }

    // Récupérer le chemin du fichier pour le supprimer du disque
    $stmt = db()->prepare('SELECT img_path FROM image WHERE id = :id');
    $stmt->execute(['id' => $image_id]);
    $img = $stmt->fetch();

    if ($img && $img['img_path']) {
        $fichier = __DIR__ . '/' . $img['img_path'];
        if (file_exists($fichier)) {
            unlink($fichier);
        }
    }

    // Supprimer la liaison galerie ↔ image
    $stmt = db()->prepare('DELETE FROM galerie_image WHERE image_id = :id');
    $stmt->execute(['id' => $image_id]);

    // Supprimer l'image de la table image
    $stmt = db()->prepare('DELETE FROM image WHERE id = :id');
    $stmt->execute(['id' => $image_id]);

    $_SESSION['photo_ok'] = 'Photo supprimée.';
    header('Location: photo.php?galerie=' . $galerie_id);
    exit;
}

// =====================================================================
// 4. Supprimer une galerie et ses photos
// =====================================================================
if ($action === 'delete_galerie') {
    $galerie_id = (int) ($_POST['galerie_id'] ?? 0);

    if ($galerie_id <= 0) {
        $_SESSION['photo_erreur'] = 'Galerie invalide.';
        header('Location: photo.php');
        exit;
    }

    // Images liées à cette galerie et à AUCUNE autre galerie
    // (une image partagée avec une autre galerie est conservée)
    $stmt = db()->prepare('
        SELECT i.id, i.img_path
        FROM image i
        JOIN galerie_image gi ON gi.image_id = i.id
        WHERE gi.galerie_id = :gid
          AND NOT EXISTS (
              SELECT 1 FROM galerie_image gi2
              WHERE gi2.image_id = i.id AND gi2.galerie_id <> :gid2
          )
    ');
    $stmt->execute(['gid' => $galerie_id, 'gid2' => $galerie_id]);
    $images = $stmt->fetchAll();

    $pdo = db();
    $pdo->beginTransaction();
    try {
        // Supprimer les liaisons galerie ↔ image
        $pdo->prepare('DELETE FROM galerie_image WHERE galerie_id = :gid')
            ->execute(['gid' => $galerie_id]);

        // Supprimer les images de la table image
        $delImg = $pdo->prepare('DELETE FROM image WHERE id = :id');
        foreach ($images as $img) {
            $delImg->execute(['id' => $img['id']]);
        }

        // Supprimer la galerie
        $pdo->prepare('DELETE FROM galerie WHERE id = :gid')
            ->execute(['gid' => $galerie_id]);

        $pdo->commit();
    } catch (PDOException $ex) {
        $pdo->rollBack();
        $_SESSION['photo_erreur'] = 'Erreur lors de la suppression de la galerie.';
        header('Location: photo.php?galerie=' . $galerie_id);
        exit;
    }

    // Supprimer les fichiers du disque (après le commit)
    foreach ($images as $img) {
        if ($img['img_path']) {
            $fichier = __DIR__ . '/' . $img['img_path'];
            if (file_exists($fichier)) {
                unlink($fichier);
            }
        }
    }

    $_SESSION['photo_ok'] = 'Galerie supprimée (' . count($images) . ' photo(s)).';
    header('Location: photo.php');
    exit;
}

// Action inconnue
header('Location: photo.php');
exit;
