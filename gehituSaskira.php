<?php
// Datu-baseko konexioa kargatu
include_once "konexioa.php";

// Saioa hasi
session_start();

// Erabiltzailea saioa hasita dagoen egiaztatu
// Bestela login orrira bidali
if (!isset($_SESSION['id'])) {
    header("Location: hasiSaioa.php");
    exit();
}

// Formetik jasotako produktuaren ID-a hartu
$produktuaId = $_POST["produktuak_id"];

// Produktu ID-a baliozkoa den egiaztatu
if (!$produktuaId) {
    die("Errorea: Produktua ez da balioduna.");
}

// Saioan gordetako bezeroaren ID-a hartu
$bezeroa = $_SESSION["id"];

// Produktua dagoeneko saskian dagoen begiratu (kantitatea jakiteko)
$stmt = $pdo->prepare("
    SELECT kantitatea FROM saskiak
    WHERE produktua_id = :produktua AND bezeroa_id = :bezeroa
");
$stmt->execute([
    "produktua" => $produktuaId,
    "bezeroa"   => $bezeroa
]);
$enSaskia = $stmt->fetch(PDO::FETCH_ASSOC);

// Uneko kantitatea hartu (ez badago, 0)
$kantitateaActual = $enSaskia['kantitatea'] ?? 0;

// Produktuaren stock-a datu-basetik eskuratu
$stmt = $pdo->prepare("
    SELECT stock FROM produktuak
    WHERE id = :produktua
");
$stmt->execute([
    "produktua" => $produktuaId
]);
$produktua = $stmt->fetch(PDO::FETCH_ASSOC);

// Produktua existitzen den egiaztatu
if (!$produktua) {
    die("Errorea: Produktua ez da aurkitu.");
}

// Stock kopurua gorde
$stock = $produktua['stock'];

// Saskian dagoen kantitatea stock-a baino handiagoa edo berdina bada,
// ez dugu gehiago gehituko eta alert bat erakutsiko dugu
if ($kantitateaActual >= $stock) {
    echo "<script>alert('Stocka amaitu da.'); window.location.href='produktuak.php';</script>";
    exit();
}

// Produktua saskian badago -> kantitatea handitu
// Bestela -> saski erregistro berria sortu
if ($kantitateaActual > 0) {

    // Saskian dagoen erregistroa bilatu baina salmenta egin gabe dagoena (salmenta_id NULL)
    $stmt = $pdo->prepare("
        SELECT * FROM saskiak
        WHERE produktua_id = :produktua AND bezeroa_id = :bezeroa AND salmenta_id IS NULL");
    $stmt->execute([
        "produktua" => $produktuaId,
        "bezeroa"   => $bezeroa
    ]);
    $errenkada = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($errenkada) {
        // Erregistroa existitzen bada -> kantitatea +1 egin
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
        // Produktua saskian egon bada lehenago baina salmenta eginda badago,
        // saski berria sortu behar da (salmenta_id NULL)
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
    // Produktua ez badago saskian -> saskian gehitu lehen aldiz
    $stmt = $pdo->prepare("
        INSERT INTO saskiak (kantitatea, data, bezeroa_id, produktua_id, salmenta_id)
        VALUES (1, CURRENT_DATE, :bezeroa, :produktua, NULL)
    ");
    $stmt->execute([
        "bezeroa"   => $bezeroa,
        "produktua" => $produktuaId
    ]);
}

// Azkenik, produktuen orrira bueltatu
header("Location: produktuak.php");
exit();
?>
