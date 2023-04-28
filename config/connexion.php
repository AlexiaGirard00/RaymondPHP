<?php

$host = "localhost";
$dbUser = "root";
$dbPass = "";
$dbName = "raymond";

$connect = mysqli_connect($host, $dbUser, $dbPass, $dbName);

if (mysqli_connect_errno()) {
    echo "Échec de la connexion à la base de donnée. <br> Code d\'erreur: " . mysqli_connect_errno();
    die();
}

mysqli_set_charset($connect, 'utf8');   //Pour écrire les caractères spéciaux

try {
    $pdo = new PDO("mysql:host=" . $host . ";dbname=" . $dbName, $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("ERREUR: Connexion impossible");
}


       
?>