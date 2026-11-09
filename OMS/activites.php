<?php
$page_active = 'activites';
$titre_page  = 'Navigation OMS';
include 'includes/header.php';
?>

	<main>
	<section class="container py-4">

		<h1 class="titre-page">Nos activités/stage</h1>

		<!-- Carte 1 -->
		<article class="carte-activite">
			<h2>Initiation au kayak</h2>
			<p>
				Naviguez à votre rythme et découvrez les plaisirs du kayak en toute
				sécurité. Cette activité d'initiation est idéale pour se dépenser au
				grand air tout en développant son équilibre et son autonomie sur l'eau.
			</p>
			<div class="carte-bas">
				<span class="prix">52€</span>
				<a href="inscription.php" class="btn btn-sm btn-inscrire">S'inscrire</a>
				<span class="date">04/07/2026</span>
			</div>
		</article>

		<!-- Carte 2 -->
		<article class="carte-activite">
			<h2>Découverte du Camping &amp; Vie en Plein Air</h2>
			<p>
				Apprenez les fondamentaux du camping pour réussir vos futures escapades
				en nature. Cet atelier pratique et convivial permet de se familiariser
				avec le matériel et les bons réflexes pour vivre une aventure sous la
				toile en toute sécurité.
			</p>
			<div class="carte-bas">
				<span class="prix">34€</span>
				<a href="inscription.php" class="btn btn-sm btn-inscrire">S'inscrire</a>
				<span class="date">12/07/2026</span>
			</div>
		</article>

		<!-- Carte 3 -->
		<article class="carte-activite">
			<h2>Acrobranche</h2>
			<p>
				Prenez de la hauteur et faites le plein de sensations en toute sécurité.
				Cette activité d'initiation permet de dépasser ses appréhensions, de
				travailler son agilité et de découvrir la forêt sous un nouvel angle,
				de branche en branche.
			</p>
			<div class="carte-bas">
				<span class="prix">40€</span>
				<a href="inscription.php" class="btn btn-sm btn-inscrire">S'inscrire</a>
				<span class="date">19/07/2026</span>
			</div>
		</article>

	</section>
</main>

	<!-- JS Bootstrap (Obligatoire pour l'ouverture du menu mobile) -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
