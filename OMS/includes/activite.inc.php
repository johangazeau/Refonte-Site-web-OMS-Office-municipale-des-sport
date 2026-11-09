<?php

try {
    // Connexion à la base de données
    $pdo = new PDO('mysql:host=localhost;dbname=OMS;charset=utf8', 'omsActiviteADD', 'omsActiviteADD');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);}
    catch (PDOException $e) {}
