<?php
/**
 * Header commun à toutes les pages du site OMS.
 *
 * Utilisation dans une page :
 *   <?php $page_active = 'accueil'; // accueil | photo | presentation | activites | contact
 *         include 'includes/header.php'; ?>
 *
 * La variable $titre_page permet de personnaliser le <title> (optionnel).
 */

// Valeurs par défaut
if (!isset($page_active))  $page_active  = '';
if (!isset($titre_page))   $titre_page   = 'OMS';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= htmlspecialchars($titre_page) ?></title>
	<!-- CSS Bootstrap 5 -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- FontAwesome (icônes) -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,400;12..96,600;12..96,800&display=swap" rel="stylesheet">
	<!-- Fichier CSS personnalisé -->
	<link rel="stylesheet" href="style.css">
</head>
<body>

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
						<a class="nav-link <?= $page_active === 'accueil' ? 'active-link' : '' ?>" href="index.php">Accueil</a>
					</li>
					<li class="nav-item">
						<a class="nav-link <?= $page_active === 'photo' ? 'active-link' : '' ?>" href="photo.php">Photo</a>
					</li>
					<li class="nav-item">
						<a class="nav-link <?= $page_active === 'presentation' ? 'active-link' : '' ?>" href="presentation.php">Présentation</a>
					</li>
					<li class="nav-item">
						<a class="nav-link <?= $page_active === 'activites' ? 'active-link' : '' ?>" href="activites.php">Activités</a>
					</li>
					<li class="nav-item">
						<a class="nav-link <?= $page_active === 'contact' ? 'active-link' : '' ?>" href="contact.php">Contact</a>
					</li>
				</ul>

				<!-- Bouton Connexion (à droite) -->
				<button class="btn btn-connexion ms-lg-3" data-bs-toggle="modal" data-bs-target="#loginModal">
					<i class="fas fa-user"></i> Connexion
				</button>
			</div>

		</div>
	</nav>

	<!-- Modal de connexion -->
	<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content login-modal-content">

				<div class="modal-header login-modal-header border-0">
					<h5 class="modal-title" id="loginModalLabel">Connexion</h5>
					<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
				</div>

				<div class="modal-body px-4 pb-4">
					<form>
						<div class="mb-3">
							<label for="login-user" class="form-label text-white fw-bold">Identifiant</label>
							<input type="text" class="form-control login-input" id="login-user" placeholder="Votre identifiant">
						</div>
						<div class="mb-4">
							<label for="login-password" class="form-label text-white fw-bold">Mot de passe</label>
							<input type="password" class="form-control login-input" id="login-password" placeholder="Votre mot de passe">
						</div>
						<div class="text-center">
							<button type="submit" class="btn btn-login-submit" onclick="event.preventDefault();">Se connecter</button>
						</div>
					</form>
				</div>

			</div>
		</div>
	</div>
