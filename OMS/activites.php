<?php include __DIR__ . '/includes/activite.inc.php'; ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navigation OMS</title>
    <!-- CSS Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Fichier CSS personnalisé -->
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,400;12..96,600;12..96,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1 class="titre-page">Nos activités/stages</h1>

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
</body>
</html>