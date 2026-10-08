<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Inscription – OMS</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,400;12..96,600;12..96,800&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="style.css">
</head>

<!-- Bandeau de navigation -->
	<nav class="navbar navbar-expand-lg navbar-dark custom-navbar">
		<div class="container-fluid px-4">

			<!-- Logo OMS à gauche -->
			<a class="navbar-brand" href="index.php">
				<img src="img/logo.jpg" alt="Logo OMS" class="navbar-logo">
			</a>

			<!-- Bouton Hamburger (Mobile) -->
			<button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<!-- Liens de navigation centrés sur la page -->
			<div class="collapse navbar-collapse" id="navbarContent">
				<ul class="navbar-nav mx-auto mb-2 mb-lg-0">
					<li class="nav-item">
						<a href="index.php" class="nav-link" href="#">Accueil</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="photo.php">Photo</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="presentation.php">Présentation</a>
					</li>
					<li class="nav-item">
						<a class="nav-link active-link" href="activites.php">Activités</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="contact.php">Contact</a>
					</li>
				</ul>
			</div>

		</div>
	</nav>

<body>

	<!-- Copie ici ta <nav> complète, avec active-link sur "Activités" -->

	<main>
		<section class="container py-4">

			<form action="#" method="post">

				<div class="row justify-content-center g-5">

					<!-- Colonne Enfant -->
					<div class="col-lg-5">
						<h2 class="titre-formulaire">Enfant</h2>

						<div class="mb-3">
							<label for="enfant-nom" class="form-label">Nom</label>
							<input type="text" class="form-control champ" id="enfant-nom" name="enfant_nom" required>
						</div>

						<div class="mb-3">
							<label for="enfant-prenom" class="form-label">Prénom</label>
							<input type="text" class="form-control champ" id="enfant-prenom" name="enfant_prenom" required>
						</div>

						<div class="mb-3">
							<label for="enfant-naissance" class="form-label">Date de naissance</label>
							<input type="date" class="form-control champ" id="enfant-naissance" name="enfant_naissance" required>
						</div>

						<div class="mb-3">
							<label for="enfant-classe" class="form-label">Classe</label>
							<input type="text" class="form-control champ" id="enfant-classe" name="enfant_classe">
						</div>

						<div class="mb-3">
							<label for="enfant-allergies" class="form-label">Allergies</label>
							<input type="text" class="form-control champ" id="enfant-allergies" name="enfant_allergies">
						</div>
					</div>

					<!-- Colonne Responsable -->
					<div class="col-lg-5">
						<h2 class="titre-formulaire">Responsable</h2>

						<div class="mb-3">
							<label for="resp-nom" class="form-label">Nom</label>
							<input type="text" class="form-control champ" id="resp-nom" name="resp_nom" required>
						</div>

						<div class="mb-3">
							<label for="resp-prenom" class="form-label">Prénom</label>
							<input type="text" class="form-control champ" id="resp-prenom" name="resp_prenom" required>
						</div>

						<div class="mb-3">
							<label for="resp-mail" class="form-label">Mail</label>
							<input type="email" class="form-control champ" id="resp-mail" name="resp_mail" required>
						</div>

						<div class="mb-3">
							<label for="resp-tel" class="form-label">Numéro de téléphone</label>
							<input type="tel" class="form-control champ" id="resp-tel" name="resp_tel" required>
						</div>

						<div class="mb-3">
							<label for="resp-adresse" class="form-label">Adresse</label>
							<input type="text" class="form-control champ" id="resp-adresse" name="resp_adresse" required>
						</div>
					</div>

				</div>

				<div class="text-center mt-4">
					<button type="submit" class="btn btn-envoyer">Envoyer</button>
				</div>

			</form>

		</section>
	</main>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>