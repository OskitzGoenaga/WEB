<?php
include_once "konexioa.php";
session_start();
$stmt = $pdo->prepare("
INSERT INTO salmentak (faktura_path) VALUES (null)
");
$stmt->execute();
$salmentaId = $pdo->lastInsertId();

$stmt = $pdo->prepare("
        UPDATE saskiak 
        SET salmenta_id = :id
        WHERE salmenta_id is null AND bezeroa_id = :bezeroa
    ");

    $bezeroa = $_SESSION["id"];

$stmt->execute([
    "id" => $salmentaId,
    "bezeroa" => $bezeroa
]);

$stmt = $pdo->prepare("
    SELECT p.id, p.izena, p.prezioa, s.kantitatea, p.argazkia
    FROM saskiak s
    JOIN produktuak p ON s.produktua_id = p.id
    WHERE s.bezeroa_id = :id
    ");
$stmt->execute([":id" => $_SESSION["id"]]);
$produktua = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("
        UPDATE produktuak 
        SET stock = :stock
        WHERE produktua_id = :produktua AND bezeroa_id = :bezeroa
    ");


    $bezeroa = $_SESSION["id"];

$stock= $stock - $produktua["kantitatea"];

$stmt->execute([
    "stock" => $stock,
    "produktua" => $produktuaId,
    "bezeroa"   => $bezeroa
]);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erosketa</title>
    <link rel="stylesheet" href="orokorra.css">
    <style>
        #hasiera {
            margin-top: 50px;
            font-size: 50px;
        }

        img {
            height: 100px;
            width: auto;
        }

        .erositakoa {
            width: 50%;
            margin: auto;
            text-align: center;
        }

        table {

            width: 100%;
        }

        th,
        td {

            border: 1px solid;
        }
    </style>
</head>

<body>
    <h1 id="hasiera">Erosketa</h1>
    <p>Erosketa arrakastaz egin da. Eskerrik asko <?= $_SESSION["izena"] ?>! </p>


    <?php $i=1; ?>
    <?php foreach ($produktua as $p): ?>
        <div class="erositakoa">
            <h3><?= $p["izena"] ?></h3>
            <table>
                <tr>
                    <th>
                        Produktua
                    </th>
                    <th>
                        Argazkia
                    </th>
                    <th>
                        Prezioa
                    </th>
                    <th>
                        Kantitatea
                    </th>
                </tr>

                <tr>
                    <td>
                        <?= $i; ?>
                    </td>
                    <td>
                        <?php $linka = 'Argazkiak/' . $p['argazkia']; ?>
                        <img src="<?= $linka ?>">
                    </td>
                    <td>
                        <p class="tamaina"><?= $p["prezioa"] ?> €</p>
                    </td>
                    <td>
                        <p class="tamaina">Kantitatea: <?= $p["kantitatea"] ?></p>
                    </td>
                </tr>
            </table>
        </div>
        <?php $i++; ?>
    <?php endforeach; ?>
</body>

</html>