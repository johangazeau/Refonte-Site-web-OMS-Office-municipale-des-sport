<?php include __DIR__ . '/includes/activite.inc.php'; ?>
<?php
$page_active = 'activites';
$titre_page  = 'Nos activités - OMS';
include __DIR__ . '/includes/header.php';
?>
    <?php
    $sql = "
        SELECT
            activite_club.*,
            DATE_FORMAT(activite_club.date_fin_inscription, '%d/%m/%Y') AS date_fin_inscription_formatee,
            DATE_FORMAT(activite_club.hdebut, '%H:%i') AS heure_debut
        FROM activite_club
    ";
    $stmt = $pdo->query($sql);

    while ($activite = $stmt->fetch(PDO::FETCH_ASSOC)) {
    ?>
        <article class="carte-activite">
            <h2><?php echo htmlspecialchars($activite['titre'], ENT_QUOTES, 'UTF-8'); ?></h2>
            <p><?php echo nl2br(htmlspecialchars($activite['description'], ENT_QUOTES, 'UTF-8')); ?></p>
            <p>Date de fin d'inscription : <?php echo htmlspecialchars($activite['date_fin_inscription_formatee'] ?? $activite['date_fin_inscription'], ENT_QUOTES, 'UTF-8'); ?></p>
            <div class="carte-bas">
                <p>Heure : <?php echo htmlspecialchars($activite['heure_debut'] ?? $activite['hdebut'], ENT_QUOTES, 'UTF-8'); ?> - <?php echo htmlspecialchars($activite['hfin'], ENT_QUOTES, 'UTF-8'); ?></p>
                <p>Nombre de places : <?php echo htmlspecialchars($activite['nb_place'], ENT_QUOTES, 'UTF-8'); ?></p>
                <p>Nombre d'inscriptions : <?php echo htmlspecialchars($activite['nb_inscription'], ENT_QUOTES, 'UTF-8'); ?></p>
                <p>Âge minimum : <?php echo htmlspecialchars($activite['age_min'], ENT_QUOTES, 'UTF-8'); ?></p>
                <p>Âge maximum : <?php echo htmlspecialchars($activite['age_max'], ENT_QUOTES, 'UTF-8'); ?></p>
                <p>Âge recommandé : <?php echo htmlspecialchars($activite['age_recommander'], ENT_QUOTES, 'UTF-8'); ?></p>
            </div>
        </article>
    <?php
    }
    ?>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>