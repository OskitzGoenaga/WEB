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

$bezeroa = $_SESSION["id"];


$stmt = $pdo->prepare("
    SELECT * FROM saskia 
    WHERE produktua_id = :produktua AND bezeroa_id = :bezeroa
");
$stmt->execute([
    "produktua" => $produktuaId,
    "bezeroa"   => $bezeroa
]);


if ($stmt->rowCount() > 0) {

    $stmt = $pdo->prepare("
        UPDATE saskia 
        SET kantitatea = kantitatea + 1
        WHERE produktua_id = :produktua AND bezeroa_id = :bezeroa
    ");
    $stmt->execute([
        "produktua" => $produktuaId,
        "bezeroa"   => $bezeroa
    ]);

} else {


    $stmt = $pdo->prepare("
        INSERT INTO saskia (kantitatea, data, bezeroa_id, produktua_id, salmenta_id)
        VALUES (1, CURRENT_DATE, :bezeroa, :produktua, NULL)
    ");
    $stmt->execute([
        "bezeroa"   => $bezeroa,
        "produktua" => $produktuaId
    ]);
}

header("Location: produktuak.php");
exit();