<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="orokorra.css" />
    <link rel="stylesheet" href="produktuak.css">
    <link rel="stylesheet" href="navbar.css" />
    <link rel="stylesheet" href="footer.css" />
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <title>Produktuak</title>
</head>

<body>
    <?php
    include_once "konexioa.php";
    include_once "navbar.php";
    ?>

    <form class="filtratu" action="produktuak.php" method="get">
        <label for="mota">Mota: </label>
        <select class="mota" name="mota" id="mota">
            <option value="">-- Aukeratu --</option>
            <option value="telefonoa">Telefonoak</option>
            <option value="ordenagailua">Ordenagailuak</option>
            <option value="tablet">Tabletak</option>
        </select>
        <label for="asc">ASC</label>
        <input type="radio" name="orden" id="asc" value="ASC" checked>
        <label for="desc">DESC</label>
        <input type="radio" name="orden" id="desc" value="DESC">
        <input class="filtratu-botoia" type="submit" value="Filtratu">
    </form>

    <?php
    $mota = $_GET["mota"] ?? "";
    $ordena = $_GET["orden"] ?? "ASC";
    $letra = $_GET["bilatzailea"] ?? "";
    if ($mota == "") {
        $stmt = $pdo->query("select id, izena, argazkia, prezioa from produktuak where izena like '%$letra%' order by izena $ordena;");
    } else {
        $kontsulta = "select id, izena, argazkia, prezioa from produktuak where mota='$mota' order by izena $ordena;";
        $stmt = $pdo->query($kontsulta);
    }
    ?>

    <section class="edukia">
        <div class="kutxa-edukia">
            <?php while ($produktua = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                <form action="gehituSaskira.php" method="POST">
                    <div class="kutxa">
                        <div class="zatia1">
                            <h3><?= $produktua["izena"]; ?></h3>
                            <div class="erdian">
                                <?php $linka = 'Argazkiak/' . $produktua['argazkia']; ?>
                                <img src="<?= $linka ?>" alt="">
                            </div>
                        </div>
                        <div class="linea2"></div>
                        <div class="zatia2">
                            <input type="hidden" name="id" value="<?= $produktua['id'] ?>">
                            <button type="submit" class="erosiBotoia" name="produktuak_id" value="<?= (int)$produktua['id'] ?>">
                                SASKIRATU
                            </button>
                            <span class="balioa"><?= $produktua["prezioa"] . " €"; ?></span>
                        </div>
                    </div>
                </form>
            <?php endwhile; ?>
        </div>
    </section>
    <?php include_once "footer.php"; ?>
</body>

</html>