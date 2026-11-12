<?php
/**
 * Traite le formulaire de connexion (POST uniquement).
 * Redirige vers la page d'origine avec un message d'erreur ou de succès.
 */

require_once 'includes/db.php';
require_once 'includes/auth.php';

// Uniquement en POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$email = trim($_POST['login_email'] ?? '');
$mdp   = $_POST['login_password']   ?? '';

// Vérification basique
if ($email === '' || $mdp === '') {
    $_SESSION['login_erreur'] = 'Veuillez remplir tous les champs.';
    header('Location: ' . ($_POST['redirect'] ?? 'index.php'));
    exit;
}

// Chercher l'utilisateur en BDD par email
$stmt = db()->prepare('SELECT * FROM omsuser WHERE email = :email LIMIT 1');
$stmt->execute(['email' => $email]);
$user = $stmt->fetch();

/*
 * IMPORTANT — Sécurité du mot de passe
 * ------------------------------------
 * La table actuelle stocke le mdp en clair (varchar 30).
 * Pour l'instant on compare en clair, mais il faudra migrer vers
 * password_hash() / password_verify() dès que possible.
 */
if (!$user || $user['mdp'] !== $mdp) {
    $_SESSION['login_erreur'] = 'Email ou mot de passe incorrect.';
    header('Location: ' . ($_POST['redirect'] ?? 'index.php'));
    exit;
}

// --- Connexion réussie : on remplit la session ---
$_SESSION['user_id']     = $user['id'];
$_SESSION['est_admin']   = ($user['permission'] == 2);  // permission 2 = admin
$_SESSION['utilisateur'] = [
    'id'         => $user['id'],
    'prenom'     => $user['prenom'],
    'nom'        => $user['nom'],
    'email'      => $user['email'],
    'permission' => $user['permission'],
];

// Rediriger vers la page d'où venait l'utilisateur
header('Location: ' . ($_POST['redirect'] ?? 'index.php'));
exit;
