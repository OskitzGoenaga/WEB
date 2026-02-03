<div id="ME" class="menu-edukia">
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
        SELECT SUM(kantitatea) AS kant FROM saskia WHERE bezeroa_id = :id
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
    </nav>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>

    $(".saskia i").click(function () {
        window.location.href = "saskia.php"; 
    });
    $(".menu-desplegablea img").click(function () {
        $("#ME").removeClass("menu-edukia").addClass("menu-edukia2");
        return false;
    });
    $(document).click(function () {
        $("#ME").removeClass("menu-edukia2").addClass("menu-edukia");
    });
</script>