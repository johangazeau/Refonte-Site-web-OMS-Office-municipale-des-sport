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
<?php
$sql = "SELECT * FROM 'activites'.*,activites.description,DATE_FORMAT(activites.date_fin_inscription, '%d/%m/%Y') AS 'date',DATE_FORMAT(activites.hdebut,'%H:%i') AS Heure,activites.hfin,activites.nb_place,activites.nb_inscription,activites.age_min,activites.age_max,activites.age_recommander,activites.titre,activites.date";
$stmt = $pdo->query($sql);




?> 


</body>
</html>