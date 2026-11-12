<?php
/**
 * Déconnexion : détruit la session et redirige vers l'accueil.
 */
session_start();
$_SESSION = [];
session_destroy();

header('Location: index.php');
exit;
