<?php
$page_active = 'contact';
$titre_page  = 'Contact - OMS';
include 'includes/header.php';
?>

    <!-- Contenu Principal -->
    <main class="container my-5">

        <!-- VUE 1 : Carte GPS + Réseaux -->
        <section id="contact-info-view">
            <h1 class="titre-principal mb-5">Nous contacter</h1>

            <div class="row align-items-center g-4">
                <!-- Colonne Gauche : Bouton Message + Réseaux -->
                <div class="col-md-5 text-center text-md-start pe-md-5">
                    <button class="btn btn-primary btn-message-custom mb-4" onclick="showForm()">
                        Nous envoyer un<br>message
                    </button>

                    <div class="d-flex justify-content-center justify-content-md-start gap-4 fs-1">
                        <a href="#" class="social-icon icon-facebook" aria-label="Facebook">
                            <i class="fab fa-facebook"></i>
                        </a>
                        <a href="#" class="social-icon icon-instagram" aria-label="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>

                <!-- Colonne Droite : Google Maps -->
                <div class="col-md-7">
                    <h3 class="text-center text-md-start mb-3 fw-bold">Où nous trouver ?</h3>
                    <div class="map-container shadow-sm rounded overflow-hidden">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3454.153942006132!2d31.13130231511475!3d29.97923458190776!2m3!1f0!0!f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14584587ac8f291b%3A0x810c2f3fa2a52424!2sPyramide%20de%20Kh%C3%A9ops!5e0!3m2!1sfr!2sfr!4v1650000000000!5m2!1sfr!2sfr"
                            width="100%"
                            height="380"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>
        </section>

        <!-- VUE 2 : Formulaire de Contact -->
        <section id="contact-form-view" class="d-none mx-auto" style="max-width: 800px;">
            <form onsubmit="event.preventDefault();">
                <div class="row g-4 mb-4">
                    <!-- Nom -->
                    <div class="col-md-6">
                        <label for="nom" class="form-label-custom">Nom</label>
                        <input type="text" id="nom" class="form-control form-input-custom">
                    </div>
                    <!-- Mail -->
                    <div class="col-md-6">
                        <label for="email" class="form-label-custom">mail</label>
                        <input type="email" id="email" class="form-control form-input-custom">
                    </div>
                    <!-- Prénom -->
                    <div class="col-md-6">
                        <label for="prenom" class="form-label-custom">Prénom</label>
                        <input type="text" id="prenom" class="form-control form-input-custom">
                    </div>
                    <!-- Téléphone -->
                    <div class="col-md-6">
                        <label for="telephone" class="form-label-custom">numéro de téléphone</label>
                        <input type="tel" id="telephone" class="form-control form-input-custom">
                    </div>
                </div>

                <!-- Message -->
                <div class="mb-5 text-center">
                    <label for="message" class="form-label-custom fs-4">Message :</label>
                    <textarea id="message" rows="6" class="form-control form-input-custom mt-2"></textarea>
                </div>

                <!-- Bouton Envoyer -->
                <div class="text-center">
                    <button type="submit" class="btn btn-envoyer-custom">Envoyer</button>
                </div>
            </form>
        </section>

    </main>

    <!-- JS Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script de bascule des vues -->
    <script>
        function showForm() {
            document.getElementById('contact-info-view').classList.add('d-none');
            document.getElementById('contact-form-view').classList.remove('d-none');
            window.scrollTo(0, 0);
        }
    </script>
</body>
</html>
