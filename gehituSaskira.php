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

// Produktua saskian dagoen egiaztatu
$stmt = $pdo->prepare("
    SELECT kantitatea FROM saskiak
    WHERE produktua_id = :produktua AND bezeroa_id = :bezeroa
");
$stmt->execute([
    "produktua" => $produktuaId,
    "bezeroa"   => $bezeroa
]);
$enSaskia = $stmt->fetch(PDO::FETCH_ASSOC);
$kantitateaActual = $enSaskia['kantitatea'] ?? 0;

// Produktuaren stock-a lortu
$stmt = $pdo->prepare("
    SELECT stock FROM produktuak
    WHERE id = :produktua
");
$stmt->execute([
    "produktua" => $produktuaId
]);
$produktua = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produktua) {
    die("Errorea: Produktua ez da aurkitu.");
}

$stock = $produktua['stock'];

// Ez badago stockik, ez dugu ezer gehituko eta alert bat erakutsiko dugu
if ($kantitateaActual >= $stock) {
    echo "<script>alert('Stocka amaitu da.'); window.location.href='produktuak.php';</script>";
    exit();
}
// Saskian badago, kantitatea handitu egingo dugu, bestela saskian produktu berria sortuko dugu
if ($kantitateaActual > 0) {
    $stmt = $pdo->prepare("
        SELECT * FROM saskiak
        WHERE produktua_id = :produktua AND bezeroa_id = :bezeroa AND salmenta_id IS NULL");
    $stmt->execute([
        "produktua" => $produktuaId,
        "bezeroa"   => $bezeroa
    ]);
    $errenkada = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($errenkada) {
        // Kantitatea handitu egingo dugu
        $stmt = $pdo->prepare("
            UPDATE saskiak
            SET kantitatea = kantitatea + 1
            WHERE produktua_id = :produktua AND bezeroa_id = :bezeroa AND salmenta_id IS NULL
        ");
        $stmt->execute([
            "produktua" => $produktuaId,
            "bezeroa"   => $bezeroa
        ]);
    }
    else{
        // Saskian badago baina salmenta_id ez da NULL, beraz, saskia berria sortuko dugu
        $stmt = $pdo->prepare("
            INSERT INTO saskiak (kantitatea, data, bezeroa_id, produktua_id, salmenta_id)
            VALUES (1, CURRENT_DATE, :bezeroa, :produktua, NULL)
        ");
        $stmt->execute([
            "bezeroa"   => $bezeroa,
            "produktua" => $produktuaId
        ]);
    }

} else {
    // Saskian ez dago, produktua saskian gehituko dugu
    $stmt = $pdo->prepare("
        INSERT INTO saskiak (kantitatea, data, bezeroa_id, produktua_id, salmenta_id)
        VALUES (1, CURRENT_DATE, :bezeroa, :produktua, NULL)
    ");
    $stmt->execute([
        "bezeroa"   => $bezeroa,
        "produktua" => $produktuaId
    ]);
}
header("Location: produktuak.php");
exit();
?>