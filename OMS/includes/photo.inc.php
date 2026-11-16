<?php
function db(): PDO
{
    static $pdo = null;
    if ($pdo === null) {
        try {
            // 127.0.0.1 (et pas "localhost") : force une connexion TCP au lieu du socket Unix
            $pdo = new PDO('mysql:host=127.0.0.1;dbname=OMS;charset=utf8mb4', 'omsPhotoADD', 'omsPhotoADD', [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            die('Erreur de connexion à la base de données : ' . $e->getMessage());
        }
    }
    return $pdo;
}
