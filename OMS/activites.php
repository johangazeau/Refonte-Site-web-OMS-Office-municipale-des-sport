<?php include __DIR__ . '/includes/activite.inc.php'; ?>
<?php
require_once __DIR__ . '/includes/auth.php';

// Traitement du formulaire d'ajout d'activité (admin uniquement)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $est_admin && isset($_POST['titre'])) {
    $vide_en_null = fn($v) => ($v === '' || $v === null) ? null : $v;

    $stmt = $pdo->prepare("
        INSERT INTO activite_club
            (titre, description, date, hdebut, hfin, nb_place, nb_inscription,
             age_min, age_max, age_recommander, date_fin_inscription, img_path)
        VALUES
            (:titre, :description, :date, :hdebut, :hfin, :nb_place, 0,
             :age_min, :age_max, :age_recommander, :date_fin_inscription, '')
    ");
    $stmt->execute([
        ':titre'                => trim($_POST['titre']),
        ':description'          => trim($_POST['description'] ?? ''),
        ':date'                 => $_POST['date'] ?? null,
        ':hdebut'               => $_POST['hdebut'] ?? null,
        ':hfin'                 => $_POST['hfin'] ?? null,
        ':nb_place'             => (int) ($_POST['nb_place'] ?? 0),
        ':age_min'              => $vide_en_null($_POST['age_min'] ?? null),
        ':age_max'              => $vide_en_null($_POST['age_max'] ?? null),
        ':age_recommander'      => (int) ($_POST['age_recommander'] ?? 0), // colonne NOT NULL : 0 si vide
        ':date_fin_inscription' => $_POST['date_fin_inscription'] ?? null,
    ]);

    // Redirection (Post/Redirect/Get) : recharge la liste et évite le double envoi en cas de F5
    header('Location: activites.php');
    exit;
}

$page_active = 'activites';
$titre_page  = 'Nos activités - OMS';
include __DIR__ . '/includes/header.php';
?>
    <!-- Contenu Principal (même conteneur que la page photo) -->
    <main class="container my-5">

        <?php if ($est_admin): ?>
            <div class="mb-4">
                <button class="btn btn-admin-action" data-bs-toggle="modal" data-bs-target="#addActivityModal">
                    <i class="fas fa-plus"></i> Ajouter une activité
                </button>
            </div>
        <?php endif; ?>

    <?php
    $sql = "
        SELECT
            activite_club.*,
            DATE_FORMAT(activite_club.date_fin_inscription, '%d/%m/%Y') AS date_fin_inscription_formatee,
            DATE_FORMAT(activite_club.hdebut, '%H:%i') AS heure_debut,
            DATE_FORMAT(activite_club.date, '%d/%m/%Y') AS heure_fin
        FROM activite_club
        ORDER BY activite_club.id DESC
    ";
    $stmt = $pdo->query($sql);

    while ($activite = $stmt->fetch(PDO::FETCH_ASSOC)) {
    ?>
    <?php
$id = (int) $activite['id'];
$e  = fn($v) => htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8');
?>
<article class="carte-activite">
    <h2><?= $e($activite['titre']) ?></h2>
    <p><?= $e(mb_strimwidth($activite['description'] ?? '', 0, 150, '…')) ?></p>
    <p class="date-publication">Publié le <?= $e($activite['date']) ?></p>

    <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalActivite<?= $id ?>">Voir plus</button>
    <a href="inscription.php?activite=<?= $id ?>" class="btn btn-connexion">S'inscrire</a>
</article>

<!-- Popup de l'activité -->
<div class="modal fade" id="modalActivite<?= $id ?>" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?= $e($activite['titre']) ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
        <p><?= nl2br($e($activite['description'])) ?></p>
        <p>Heure : <?= $e($activite['heure_debut']) ?> - <?= $e($activite['hfin']) ?></p>
        <p>Places : <?= $e($activite['nb_inscription']) ?> / <?= $e($activite['nb_place']) ?></p>
        <p>Âge : <?= $e($activite['age_min']) ?> à <?= $e($activite['age_max']) ?> ans (recommandé : <?= $e($activite['age_recommander']) ?>)</p>
        <p>Fin des inscriptions : <?= $e($activite['date_fin_inscription_formatee']) ?></p>
      </div>
      <div class="modal-footer">
        <a href="inscription.php?activite=<?= $id ?>" class="btn btn-connexion">S'inscrire</a>
      </div>
    </div>
  </div>
</div>

    <?php
    }
    ?>

    </main>


<?php if ($est_admin): ?>
<div class="modal fade" id="addActivityModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header login-modal-header border-0">
                        <h5 class="modal-title text-white">Nouvelle activité</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
            <div class="modal-body">
                <form method="POST" action="activites.php">
                    <div class="mb-3">
                        <label for="titre" class="form-label">Titre</label>
                        <input type="text" class="form-control" id="titre" name="titre" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="date" name="date" required>
                    </div>
                    <div class="mb-3">
                        <label for="hdebut" class="form-label">Heure de début</label>
                        <input type="time" class="form-control" id="hdebut" name="hdebut" required>
                    </div>
                    <div class="mb-3">
                        <label for="hfin" class="form-label">Heure de fin</label>
                        <input type="time" class="form-control" id="hfin" name="hfin" required>
                    </div>
                    <div class="mb-3">
                        <label for="nb_place" class="form-label">Nombre de places</label>
                        <input type="number" class="form-control" id="nb_place" name="nb_place" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label for="age_min" class="form-label">Âge minimum</label>
                        <input type="number" class="form-control" id="age_min" name="age_min" min="0">
                    </div>
                    <div class="mb-3">
                        <label for="age_max" class="form-label">Âge maximum</label>
                        <input type="number" class="form-control" id="age_max" name="age_max">
                    </div>
                    <div class="mb-3">
                        <label for="age_recommander" class="form-label">Âge recommandé</label>
                        <input type="number" class="form-control" id="age_recommander" name="age_recommander">
                    </div>
                    <div class="mb-3">
                        <label for="date_fin_inscription" class="form-label">Date de fin d'inscription</label>
                        <input type="date" class="form-control" id="date_fin_inscription" name="date_fin_inscription" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>



	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>