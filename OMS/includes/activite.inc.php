<?php

try {
    // Connexion à la base de données
    // 127.0.0.1 (et pas "localhost") : force une connexion TCP au lieu du socket Unix
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=OMS;charset=utf8', 'omsActiviteADD', 'omsActiviteADD');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur de connexion à la base de données : ' . $e->getMessage());
}
