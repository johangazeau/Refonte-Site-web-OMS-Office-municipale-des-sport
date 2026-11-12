<?php
/**
 * Gestion de la session et de l'authentification.
 *
 * Inclure CE fichier au tout début de chaque page (via header.php).
 * Il démarre la session et expose :
 *
 *   $est_connecte  (bool)  — l'utilisateur est-il connecté ?
 *   $est_admin      (bool)  — l'utilisateur est-il administrateur ?
 *   $utilisateur    (array) — les infos de l'utilisateur connecté (ou null)
 */

// Démarrer la session si ce n'est pas déjà fait
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// --- Variables globales accessibles partout sur le site ---

/** @var bool  L'utilisateur est-il connecté ? */
$est_connecte = isset($_SESSION['user_id']);

/** @var bool  L'utilisateur est-il administrateur ? (permission = 2 en BDD) */
$est_admin = !empty($_SESSION['est_admin']);

/** @var array|null  Infos de l'utilisateur connecté */
$utilisateur = $_SESSION['utilisateur'] ?? null;
