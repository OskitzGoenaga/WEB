<?php
session_start();
include_once "konexioa.php";
include_once "navbar.php";

if (!isset($_SESSION["id"])) {
    header("Location: hasiSaioa.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["produktuak_id"])) {

    $produktuaId = $_POST["produktuak_id"];
    $bezeroa = $_SESSION["id"];

    $stmt = $pdo->prepare("
        SELECT kantitatea 
        FROM saskia 
        WHERE produktua_id = :produktua AND bezeroa_id = :bezeroa
    ");
    $stmt->execute([
        "produktua" => $produktuaId,
        "bezeroa"   => $bezeroa
    ]);

    $errenkada = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($errenkada) {
        if ($errenkada["kantitatea"] <= 1) {

            $stmt = $pdo->prepare("
                DELETE FROM saskia 
                WHERE produktua_id = :produktua AND bezeroa_id = :bezeroa
            ");
            $stmt->execute([
                "produktua" => $produktuaId,
                "bezeroa"   => $bezeroa
            ]);

        } else {
            $stmt = $pdo->prepare("
                UPDATE saskia 
                SET kantitatea = kantitatea - 1
                WHERE produktua_id = :produktua AND bezeroa_id = :bezeroa
            ");
            $stmt->execute([
                "produktua" => $produktuaId,
                "bezeroa"   => $bezeroa
            ]);
        }
    }

    header("Location: saskia.php");
    exit();
}

$stmt = $pdo->prepare("
    SELECT p.id, p.izena, p.prezioa, s.kantitatea, p.argazkia
    FROM saskia s
    JOIN produktuak p ON s.produktua_id = p.id
    WHERE s.bezeroa_id = :id
");
$stmt->execute([":id" => $_SESSION["id"]]);
$produktua = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="eu">
<head>
    <meta charset="UTF-8">
    <title>Erosketa Saskia</title>
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="orokorra.css">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <style>
        .erosketa {
            display: flex;
            flex-direction: row;
        }

        .saskia2 {
            background-color: white;
            width: 70%;
            margin: 135px 3%;
            padding: 50px;
            box-shadow: 2px 4px 12px #00000014;
        }

        h1 {
            font-size: 40px;
        }

        .item {
            background-color: #f5f5f7;
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            align-items: center;
            padding: 50px;
            margin: 30px;
            border-radius: 5px;
            box-shadow: 2px 4px 12px #00000061;
        }

        .item>img {
            height: auto;
            width: 150px;
        }

        .tamaina {
            font-size: 20px;
        }

        .ordainketa {
            width: 25%;
            height: auto;
            background-color: white;
            margin: 135px 3% auto 0px;
            padding: 50px;
            box-shadow: 2px 4px 12px #00000014;
        }

        .erosketaPrezioa {
            min-height: 150px;
            background-color: #f5f5f7;
            box-shadow: 2px 4px 12px #00000061;
            width: 300px;
            margin-top: 50px;
            margin-bottom: 10px;
            font-size: 20px;
        }

        .erosketaPrezioa>button {
            color: white;
            margin: 20px 0px;
            padding: 10px 25px;
            background: #000000;
            font-size: 18px;
            border-radius: 8px;
        }

        .item2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            align-items: center;
            padding: 20px;
        }

        #prezTot {
            background-color: white;
            padding: 20px;
            width: 60%;
            margin: auto;
        }

        #ezabatu {
            background-color: red;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            width: 30%;
            margin: auto;
            cursor: pointer;
        }
    </style>
</head>

<body>

<div class="erosketa">


    <div class="saskia2">
        <h1>Erosketa saskia</h1>
        <p>Kaixo, <?= $_SESSION["izena"] ?>. Hemen dago zure saskia.</p>


        <form action="saskia.php" method="post">

            <?php foreach ($produktua as $p): ?>
                <div class="item">
                    <?php $linka = 'Argazkiak/' . $p['argazkia']; ?>
                    <img src="<?= $linka ?>">

                    <h3 class="tamaina"><?= $p["izena"] ?></h3>
                    <p class="tamaina"><?= $p["prezioa"] ?> €</p>
                    <p class="tamaina">Kantitatea: <?= $p["kantitatea"] ?></p>


                    <button type="submit" id="ezabatu"
                            name="produktuak_id"
                            value="<?= $p["id"] ?>">X</button>
                </div>
            <?php endforeach; ?>

        </form>
    </div>


    <div class="ordainketa">
        <h1>Erosi</h1>

        <div class="erosketaPrezioa">
            <?php
            $i = 1;
            $preziototala = 0;
            ?>

            <?php foreach ($produktua as $p): ?>
                <?php $prezioKant = $p["prezioa"] * $p["kantitatea"]; ?>

                <div class="item2">
                    <p>Produktua-<?= $i ?></p>
                    <p class="tamaina"><?= $prezioKant ?> €</p>
                </div>

                <?php
                $preziototala += $prezioKant;
                $i++;
                ?>
            <?php endforeach; ?>

            <p id="prezTot">TOTALA: <?= $preziototala ?> €</p>
            <button type="button">EROSI</button>
        </div>
    </div>
</div>

</body>
</html>