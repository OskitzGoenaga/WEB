<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
            width: 60%;
            margin: 135px 5%;
            padding: 50px;
            box-shadow: 2px 4px 12px #00000014;
        }

        h1 {
            font-size: 40px;
        }

        .item {
            background-color: #f5f5f7;
            display: flex;
            flex-direction: row;
            align-items: center;
            padding: 50px;
            justify-content: space-between;
            margin: 30px;
            border-radius: 5px;
            box-shadow: 2px 4px 12px #00000061;
        }

        .item>img {
            height: 150px;
            width: auto;
        }

        .tamaina {
            font-size: 20px;
        }

        .ordainketa {
            width: 25%;
            height: auto;
            background-color: white;
            margin: 135px 5% auto 0px;
            padding: 50px;
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
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-around;
            padding: 20px;
        }
        #prezTot{
            background-color: white;
            padding: 20px;
            width:60%;
            margin: auto;
        }
    </style>
</head>

<body>
    <?php
    include_once "konexioa.php";
    include_once "navbar.php";

    // Datu-basean saskiaren edukia lortu
    $stmt = $pdo->prepare("
            SELECT p.izena, p.prezioa, s.kantitatea, p.argazkia
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
    </head>

    <body>
        <div class="erosketa">
            <div class="saskia2">
                <h1>Erosketa saskia</h1>
                <p>Kaixo, <?php echo $_SESSION["izena"]; ?>. Hemen dago zure saskia.</p>
                <?php foreach ($produktua as $p): ?>
                    <div class="item">
                        <?php $linka = 'Argazkiak/' . $p['argazkia']; ?>
                        <img src="<?= $linka ?>">
                        <h3 class="tamaina"><?= $p["izena"] ?></h3>
                        <p class="tamaina"><?= $p["prezioa"] ?> €</p>
                        <p class="tamaina">Kantitatea: <?= $p["kantitatea"] ?></p>
                        <hr>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="ordainketa">
                <h1>Erosi</h1>
                <div class="erosketaPrezioa">
                    <?php
                    $i = 1;
                    $preziototala = 0;
                    ?>
                    <?php foreach ($produktua as $p): ?>
                        <?php $preziokant = $p["prezioa"] * $p["kantitatea"];?>
                        <div class="item2">
                            <p>Produktu-<?= $i ?></p>
                            <p class="tamaina"><?= $preziokant ?> €</p>
                            <?php $preziototala += $preziokant ?>
                            <hr>
                        </div>
                        <?php $i += 1; ?>
                    <?php endforeach; ?>
                    <p id="prezTot">TOTALA: <?= $preziototala ?> €</p>
                    <button type="submit">EROSI</button>
                </div>
            </div>
        </div>
    </body>

    </html>