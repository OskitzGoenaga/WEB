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
session_start();
include_once "konexioa.php";

$zenb = 0;

if (isset($_SESSION['id'])) {
    $stmt = $pdo->prepare("
        SELECT COUNT(kantitatea) AS kant FROM saskiak WHERE bezeroa_id = :id
    ");
    $stmt->execute([":id" => $_SESSION["id"]]);
    $r = $stmt->fetch(PDO::FETCH_ASSOC);
    $zenb = $r["kant"] ?? 0;
}
?>
<div class="head">
    <div class="menu-desplegablea">
        <img src="Argazkiak/Menu_desplegablea.jpg">
    </div>
    <div class="logo">
        <a href="sarrera.php"><img src="Argazkiak/logoa.jpg"></a>
    </div>
    <form action="produktuak.php" method="get">
        <div class="buscadorea">
            <input type="text" name="bilatzailea" placeholder="Buscar...">
        </div>
    </form>
    <nav class="navbar">
        <a href="sarrera.php">Sarrera</a>
        <a href="kontaktua.php">Kontaktua</a>
        <a href="produktuak.php">Produktuak</a>
        <a href="hornitzaile.php">Hornitzaile Bihurtu</a>
        <div class="saskia">
            <i class="fa fa-shopping-cart" aria-hidden="true" ></i>
            <p id="zenbakia"><strong><?= $zenb;?></strong></p>
        </div>
        <img class= "perfila" src="Argazkiak/perfila.jpg">
        <div id="perfil-menu" class="perfil-dropdown">
            <?php if (isset($_SESSION['id'])): ?>
                <p class="perfil-izena">Kaixo, <?= $_SESSION['izena'] ?>!</p>
                <a href="itxiSaioa.php" class="itxi-saioa">Itxi saioa</a>
            <?php else: ?>
                <a href="hasiSaioa.php">Hasi saioa</a>
                <a href="login.php">Erregistratu</a>
            <?php endif; ?>
        </div>
    </nav>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>

    $(".saskia i").click(function () {
        window.location.href = "saskia.php"; 
    });
    
    $(".perfila").click(function () {
        $("#perfil-menu").toggleClass("erakutsi");
    });
    
    $(document).click(function (e) {
        if (!$(e.target).closest('.perfila, #perfil-menu').length) {
            $("#perfil-menu").removeClass("erakutsi");
        }
        $("#ME").removeClass("irekita").addClass("itxita");
    });
    
    $(".menu-desplegablea img").click(function () {
        $("#ME").removeClass("itxita").addClass("irekita");
        return false;
    });
</script>