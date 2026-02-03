<?php
include_once "konexioa.php";
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: hasiSaioa.php");
    exit();
}

$produktuaId = $_POST["produktuak_id"];

if (!$produktuaId) {
    die("Errorea: Produktua ez da balioduna.");
}

$stmt = $pdo->prepare("
    INSERT INTO saskia (kantitatea, data, bezeroa_id, produktua_id, salmenta_id)
    VALUES (1, CURRENT_DATE, :bezeroa, :produktua, NULL)
");

$stmt->execute([
    ":bezeroa"   => $_SESSION["id"],
    ":produktua" => $produktuaId    
]);


header("Location: saskia.php");
exit();