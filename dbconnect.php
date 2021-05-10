<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "exo-json";

    try {
    $db = new PDO('mysql:host='.$servername.';dbname='.$dbname.';charset=utf8mb4', $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    // * connecté à la base de données
    } catch (PDOException $e) {
    echo "Connexion à la base de donnée échouée : ". $e->getMessage();
    }
?>