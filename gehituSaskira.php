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

// Comprobamos si el producto ya está en la cesta
$stmt = $pdo->prepare("
    SELECT kantitatea FROM saskia 
    WHERE produktua_id = :produktua AND bezeroa_id = :bezeroa
");
$stmt->execute([
    "produktua" => $produktuaId,
    "bezeroa"   => $bezeroa
]);
$enSaskia = $stmt->fetch(PDO::FETCH_ASSOC);
$kantitateaActual = $enSaskia['kantitatea'] ?? 0;

// Obtenemos el stock disponible del producto
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

// Si ya hemos alcanzado el stock, no añadir
if ($kantitateaActual >= $stock) {
    echo "<script>alert('Stocka amaitu da.'); window.location.href='produktuak.php';</script>";
    exit();
}

// Si está en la cesta, aumentamos la cantidad en 1
if ($kantitateaActual > 0) {
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
    // Si no está en la cesta, insertamos
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
?>
