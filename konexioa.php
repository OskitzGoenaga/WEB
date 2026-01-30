<?php

// db.php
$host = "192.168.115.163"; //
$dbname = "db_erronka2";
$user = "kudeatzailea";
$pass = "1MG3_2025"; // XAMPP: sarri hutsik

$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";


try {
    
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // erroreak exception gisa
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // array asoz.
    ]);


    
} catch (PDOException $e) {

    die("DB konexio errorea: " . $e->getMessage());

}
