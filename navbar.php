<div id="ME" class="menu-edukia itxita">
    <div class="menu-barrua">
        <ul class="menu-lista">
            <li><a href="sarrera.php#berriak">Berriak</a></li>
            <li><a href="sarrera.php#prezioa">Jasangarritasuna</a></li>
            <li><a href="sarrera.php#norgara">Nor gara</a></li>
            <li><a href="kontaktua.php">Kontaktua</a></li>
        </ul>
    </div>
</div>

<?php
// Sesioa hasi
session_start();
include_once "konexioa.php";

// Saskiko produktu kopurua hasieratu 0
$zenb = 0;

// Saioa hasi badago, saskiko produktu kopurua lortu
if (isset($_SESSION['id'])) {
    $stmt = $pdo->prepare("
        SELECT COUNT(kantitatea) AS kant FROM saskiak WHERE bezeroa_id = :id AND salmenta_id IS NULL
    ");
    $stmt->execute([":id" => $_SESSION["id"]]);
    $r = $stmt->fetch(PDO::FETCH_ASSOC);
    $zenb = $r["kant"] ?? 0; // Saskia hutsik badago 0 erakutsi
}
?>

<div class="head">
    <!-- Menu botoia mugikorretarako -->
    <div class="menu-desplegablea">
        <img src="Argazkiak/Menu_desplegablea.jpg">
    </div>

    <!-- Logo -->
    <div class="logo">
        <a href="sarrera.php"><img src="Argazkiak/logoa.jpg"></a>
    </div>

    <!-- Bilaketa formularioa -->
    <form action="produktuak.php" method="get">
        <div class="buscadorea">
            <input type="text" name="bilatzailea" placeholder="Buscar...">
        </div>
    </form>

    <!-- Nabigazio barra -->
    <nav class="navbar">
        <a href="sarrera.php">Sarrera</a>
        <a href="kontaktua.php">Kontaktua</a>
        <a href="produktuak.php">Produktuak</a>
        <a href="hornitzaile.php">Hornitzaile Bihurtu</a>

        <!-- Saskia -->
        <div class="saskia">
            <i class="fa fa-shopping-cart" aria-hidden="true" ></i>
            <p id="zenbakia"><strong><?= $zenb;?></strong></p>
        </div>

        <!-- Perfil irudia eta menu drop-down -->
        <img class="perfila" src="Argazkiak/perfila.jpg">
        <div id="perfil-menu" class="perfil-dropdown">
            <?php if (isset($_SESSION['id'])): ?>
                <!-- Erabiltzaile izena eta saioa itxi / fakturak -->
                <p class="perfil-izena">Kaixo, <?= $_SESSION['izena'] ?>!</p>
                <a href="itxiSaioa.php" class="itxi-saioa">Itxi saioa</a>
                <a href="erosketa.php" class="itxi-saioa">Fakturak</a>
            <?php else: ?>
                <!-- Saioa hasi edo erregistratu -->
                <a href="hasiSaioa.php">Hasi saioa</a>
                <a href="login.php">Erregistratu</a>
            <?php endif; ?>
        </div>
    </nav>
</div>

<!-- jQuery menu eta saskia interaktiboak -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    // Saskia ikonoa klik egiterakoan saskira joan
    $(".saskia i").click(function () {
        window.location.href = "saskia.php";
    });
    
    // Perfil irudia klik egiterakoan drop-down erakutsi/ezkutatu
    $(".perfila").click(function () {
        $("#perfil-menu").toggleClass("erakutsi");
    });
    
    // Klik edozein tokitan menuak ixteko logika
    $(document).click(function (e) {
        // Perfil menu eta irudiaren kanpoan klik egiterakoan, ezkutatu
        if (!$(e.target).closest('.perfila, #perfil-menu').length) {
            $("#perfil-menu").removeClass("erakutsi");
        }
        // Mugikorreko menu ixita utzi
        $("#ME").removeClass("irekita").addClass("itxita");
    });
    
    // Menu botoia klik egiterakoan menu irekita utzi
    $(".menu-desplegablea img").click(function () {
        $("#ME").removeClass("itxita").addClass("irekita");
        return false;
    });
</script>
