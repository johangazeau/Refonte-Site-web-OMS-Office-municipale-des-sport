<?php
$page_active = 'photo';
$titre_page  = 'Photos - OMS';
include 'includes/header.php';
require_once 'includes/db.php';

// ── Récupérer la galerie sélectionnée (si on clique sur une catégorie) ──
$galerie_id = isset($_GET['galerie']) ? (int) $_GET['galerie'] : 0;

// ── Messages flash (après ajout/suppression) ──
$flash_ok    = $_SESSION['photo_ok']     ?? null; unset($_SESSION['photo_ok']);
$flash_err   = $_SESSION['photo_erreur'] ?? null; unset($_SESSION['photo_erreur']);

// ── Charger toutes les galeries depuis la BDD ──
$galeries = db()->query('
    SELECT g.id, g.titre, g.date,
           (SELECT i.img_path FROM image i
            JOIN galerie_image gi ON gi.image_id = i.id
            WHERE gi.galerie_id = g.id
            LIMIT 1) AS cover
    FROM galerie g
    ORDER BY g.date DESC
')->fetchAll();

// ── Si une galerie est sélectionnée, charger ses images ──
$images         = [];
$galerie_titre  = '';
if ($galerie_id > 0) {
    // Titre de la galerie
    $stmt = db()->prepare('SELECT titre FROM galerie WHERE id = :id');
    $stmt->execute(['id' => $galerie_id]);
    $gal = $stmt->fetch();
    $galerie_titre = $gal ? $gal['titre'] : '';

    // Ses images
    $stmt = db()->prepare('
        SELECT i.id, i.titre, i.img_path
        FROM image i
        JOIN galerie_image gi ON gi.image_id = i.id
        WHERE gi.galerie_id = :gid
        ORDER BY i.id ASC
    ');
    $stmt->execute(['gid' => $galerie_id]);
    $images = $stmt->fetchAll();
}
?>

    <!-- Contenu Principal -->
    <main class="container my-5">

        <?php if ($flash_ok): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($flash_ok) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <?php if ($flash_err): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($flash_err) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if ($galerie_id === 0): ?>
        <!-- ═══════════════════════════════════════════════════════════
             VUE 1 : Liste des galeries (catégories)
             ═══════════════════════════════════════════════════════════ -->
        <section id="categories-view">

            <?php if ($est_admin): ?>
                <div class="mb-4">
                    <button class="btn btn-admin-action" data-bs-toggle="modal" data-bs-target="#addGalerieModal">
                        <i class="fas fa-plus"></i> Nouvelle galerie
                    </button>
                </div>
            <?php endif; ?>

            <div class="row g-4">
                <?php if (empty($galeries)): ?>
                    <p class="text-muted">Aucune galerie pour le moment.</p>
                <?php endif; ?>

                <?php foreach ($galeries as $gal): ?>
                    <div class="col-md-4">
                        <a href="photo.php?galerie=<?= $gal['id'] ?>" class="text-decoration-none">
                            <div class="category-card">
                                <div class="category-badge"><?= htmlspecialchars($gal['titre']) ?></div>
                                <div class="img-wrapper">
                                    <?php if ($gal['cover']): ?>
                                        <img src="<?= htmlspecialchars($gal['cover']) ?>" alt="<?= htmlspecialchars($gal['titre']) ?>">
                                    <?php else: ?>
                                        <div class="img-placeholder d-flex align-items-center justify-content-center">
                                            <i class="fas fa-image fa-3x text-muted"></i>
                                        </div>
                                    <?php endif; ?>
                                    <span class="btn-voir-plus">voir plus</span>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <?php if ($est_admin): ?>
        <!-- Modal : Créer une galerie -->
        <div class="modal fade" id="addGalerieModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content login-modal-content">
                    <div class="modal-header login-modal-header border-0">
                        <h5 class="modal-title text-white">Nouvelle galerie</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body px-4 pb-4">
                        <form action="photo_action.php" method="POST">
                            <input type="hidden" name="action" value="add_galerie">
                            <div class="mb-3">
                                <label class="form-label text-white fw-bold">Titre</label>
                                <input type="text" class="form-control login-input" name="titre" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-white fw-bold">Date</label>
                                <input type="date" class="form-control login-input" name="date" required>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-login-submit">Créer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php else: ?>
        <!-- ═══════════════════════════════════════════════════════════
             VUE 2 : Photos d'une galerie
             ═══════════════════════════════════════════════════════════ -->
        <section id="gallery-view">
            <div class="d-flex align-items-center mb-4 gap-3 flex-wrap">
                <a href="photo.php" class="btn btn-outline-primary btn-sm rounded-pill px-3">← Retour aux catégories</a>
                <div class="category-badge position-static m-0"><?= htmlspecialchars($galerie_titre) ?></div>

                <?php if ($est_admin): ?>
                    <button class="btn btn-admin-action btn-sm ms-auto" data-bs-toggle="modal" data-bs-target="#addImageModal">
                        <i class="fas fa-plus"></i> Ajouter des photos
                    </button>
                <?php endif; ?>
            </div>

            <div class="row g-4">
                <?php if (empty($images)): ?>
                    <p class="text-muted">Aucune photo dans cette galerie.</p>
                <?php endif; ?>

                <?php foreach ($images as $img): ?>
                    <div class="col-md-4 col-lg-3">
                        <div class="gallery-card position-relative">
                            <img src="<?= htmlspecialchars($img['img_path']) ?>"
                                 class="img-fluid rounded shadow-sm gallery-img"
                                 alt="<?= htmlspecialchars($img['titre']) ?>">

                            <?php if ($est_admin): ?>
                                <form action="photo_action.php" method="POST" class="btn-delete-photo"
                                      onsubmit="return confirm('Supprimer cette photo ?');">
                                    <input type="hidden" name="action" value="delete_image">
                                    <input type="hidden" name="image_id" value="<?= $img['id'] ?>">
                                    <input type="hidden" name="galerie_id" value="<?= $galerie_id ?>">
                                    <button type="submit" class="btn btn-danger btn-sm rounded-circle">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <?php if ($est_admin): ?>
        <!-- Modal : Ajouter des photos -->
        <div class="modal fade" id="addImageModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content login-modal-content">
                    <div class="modal-header login-modal-header border-0">
                        <h5 class="modal-title text-white">Ajouter des photos</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body px-4 pb-4">
                        <form action="photo_action.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="action" value="add_images">
                            <input type="hidden" name="galerie_id" value="<?= $galerie_id ?>">
                            <div class="mb-3">
                                <label class="form-label text-white fw-bold">Sélectionner des images</label>
                                <input type="file" class="form-control login-input" name="photos[]"
                                       accept="image/*" multiple required>
                                <small class="text-white-50">Formats acceptés : JPG, PNG, WEBP. Plusieurs fichiers possibles.</small>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-login-submit">Envoyer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php endif; ?>

    </main>

    <!-- JS Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
