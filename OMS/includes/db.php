<?php
function db(): PDO
{
    static $pdo = null;
    if ($pdo === null) {
        $host = getenv('DB_HOST') ?: 'mariadb';
        $name = getenv('DB_NAME') ?: 'OMS';
        $user = getenv('DB_USER') ?: 'OMSdb';
        $pass = getenv('DB_PASS') ?: '';

        $pdo = new PDO("mysql:host=$host;port=3306;dbname=$name;charset=utf8mb4", $user, $pass, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }
    return $pdo;
}

// Affichage sécurisé dans le HTML (protection XSS)
function e(?string $texte): string
{
    return htmlspecialchars($texte ?? '', ENT_QUOTES, 'UTF-8');
}
