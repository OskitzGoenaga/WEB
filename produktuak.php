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
    include_once "konexioa.php"; // Datu-basearekin konektatu
    include_once "navbar.php";   // Nabigazio barra gehitu
    
    // GET parametroak jaso
    $mota = $_GET["mota"] ?? "";
    $ordena = $_GET["orden"] ?? "ASC";
    $letra = $_GET["bilatzailea"] ?? "";
    ?>

    <!-- Produktuen iragazkia eta bilaketa -->
    <form class="filtratu" action="produktuak.php" method="get">
        <input class="bilatzailea" type="text" name="bilatzailea" placeholder="Bilatu..." value="<?=$letra;?>">
        <label for="mota">Mota: </label>
        <select class="mota" name="mota" id="mota">
            <option value="">-- Aukeratu --</option>
            <option value="telefonoa" <?= $mota === "telefonoa" ? "selected" : ""; ?>>Telefonoak</option>
            <option value="ordenagailua" <?= $mota === "ordenagailua" ? "selected" : ""; ?>>Ordenagailuak</option>
            <option value="tablet" <?= $mota === "tablet" ? "selected" : ""; ?>>Tabletak</option>
        </select>
        <label for="asc">ASC</label>
        <input type="radio" name="orden" id="asc" value="ASC" <?= $ordena === "ASC" ? "checked" : ""; ?>>
        <label for="desc">DESC</label>
        <input type="radio" name="orden" id="desc" value="DESC" <?= $ordena === "DESC" ? "checked" : ""; ?>>
        <input class="filtratu-botoia" type="submit" value="Filtratu">
    </form>

    <?php
    // SQL WHERE klausula eraiki iragazkien arabera
    $where = "1=1"; // beti egia
    if ($mota != "") {
        $where .= " AND mota='$mota'";
    }
    if ($letra != "") {
        $where .= " AND izena like '%$letra%'";
    }

    // Produktuak datu-baseatik jaso iragazkien arabera
    $stmt = $pdo->query("select id, izena, argazkia, prezioa from produktuak where $where order by izena $ordena;");
    ?>

    <!-- Produktuen erakusleihoa -->
    <section class="edukia">
        <div class="kutxa-edukia">
            <?php while ($produktua = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                <!-- Produktu bakoitza formulario baten barruan -->
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
                            <!-- Produktu ID gordetzeko input ezkutua -->
                            <input type="hidden" name="id" value="<?= $produktua['id'] ?>">
                            <!-- Saskiratze botoia -->
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
