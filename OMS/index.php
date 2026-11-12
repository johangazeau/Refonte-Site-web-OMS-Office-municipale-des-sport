<?php
$page_active = 'accueil';
$titre_page  = 'Navigation OMS';
include 'includes/header.php';
?>
  <main>

	<!-- Zone titre -->
	<section class="container py-5">
		<div class="row align-items-center">

			<!-- Colonne gauche : le titre -->
			<div class="col-lg-6">
				<h1 class="titre-principal">Office Municipal des Sports</h1>
			</div>

			<!-- Colonne droite : pilules + enfant -->
			<div class="col-lg-6">
				<div class="hero-visuel">
					<div class="pilule"></div>
					<div class="pilule"></div>
					<div class="pilule"></div>
					<img src="img/fille.png" alt="Enfant souriant avec un cerceau" class="fille">
				</div>
			</div>

		</div>
	</section>

	<!-- Zone festival -->
	<section class="container pb-5">
		<div class="row align-items-start g-5">

			<div class="col-lg-5">
				<article class="encart">
					<h2>Festival des sports d'eau : Inscrivez-vous !</h2>
					<p>
						La journée d'initiation au kayak et activités nautiques aura lieu
						le samedi 24 mai au plan d'eau municipal. Des créneaux sont ouverts
						pour les enfants (dès 8 ans) et les familles. Équipement fourni sur
						place. Inscriptions ouvertes jusqu'au 18 mai.
					</p>
				</article>
			</div>

			<div class="col-lg-5">
				<img src="img/kayak.jpg" alt="Enfant en kayak sur le plan d'eau" class="img-fluid">
			</div>

		</div>
	</section>

</main>

	<!-- JS Bootstrap (Obligatoire pour l'ouverture du menu mobile) -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
