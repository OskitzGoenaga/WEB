<?php
session_start();
include_once "konexioa.php";

// Egiaztatu sesioa
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$bezero_id = $_SESSION['id'];

// Salmenta berri bat sortu erosi botoia sakatutakoan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['erosi'])) {
    $stmt = $pdo->prepare("INSERT INTO salmentak (id) VALUES (NULL)");
    $stmt->execute();

    // Salmenta ID-a eskuratu eta saskian gorde
    $stmt = $pdo->prepare("UPDATE saskiak SET salmenta_id = :salmenta_id WHERE bezeroa_id = :bezero_id AND salmenta_id IS NULL");
    $stmt->execute([
        ':salmenta_id' => $pdo->lastInsertId(),
        ':bezero_id' => $bezero_id
    ]);
}

// Bezeroaren salmentak eskuratu
$stmt = $pdo->prepare("
    SELECT DISTINCT s.id, s.faktura_path, MIN(sk.data) as data
    FROM salmentak s
    JOIN saskiak sk ON sk.salmenta_id = s.id
    WHERE sk.bezeroa_id = :bezero_id
    GROUP BY s.id, s.faktura_path
    ORDER BY s.id DESC
");
$stmt->execute([':bezero_id' => $bezero_id]);
$salmentak = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="eu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nire Fakturak</title>
    <link rel="stylesheet" href="orokorra.css">
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <style>
        .fakturak-edukia {
            padding-top: 150px;
            min-height: 80vh;
            background-color: #f5f5f7;
        }

        .fakturak-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 30px;
        }
        
        h1 {
            font-size: 32px;
            margin-bottom: 30px;
            color: #333;
        }
        
        .faktura-taula {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        table {
            width: 100%;
        }
        
        thead {
            background: #333;
            color: white;
            border-radius: 10px 10px 0 0;
        }
        
        th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
        }
        
        td {
            padding: 15px;
            border-bottom: 1px solid #eee;
        }
        .erosketa-titulua>th{
            text-align: center;
            border-radius: 5px
        }
        
        tbody tr:hover {
            background: #f9f9f9;
        }
        
        .deskargatuBotoia {
            background: #007bff;
            color: white;
            padding: 8px 20px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            font-weight: 600;
        }
        
        .deskargatuBotoia:hover {
            background: #0056b3;
        }
        
        .ikusi-botoia {
            background: #28a745;
            color: white;
            padding: 8px 20px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            font-weight: 600;
            margin-left: 10px;
        }
        
        .ikusi-botoia:hover {
            background: #1e7e34;
        }
        
        .hutsik {
            text-align: center;
            padding: 50px;
            color: #666;
        }
    </style>
</head>
<body>
    <?php include_once "navbar.php"; ?>

    <div class="fakturak-edukia">
        <div class="fakturak-container">
            <h1>Nire Fakturak</h1>
            
            <?php if (count($salmentak) > 0): ?>
                <div class="faktura-taula">
                    <table>
                        <thead>
                            <tr class="erosketa-titulua">
                                <th>Faktura Zenbakia</th>
                                <th>Deskargatu</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($salmentak as $salmenta): ?>
                                <tr>
                                    <td><strong>FAK-<?= $salmenta['id'] ?></strong></td>
                                    <td>
                                        <?php if ($salmenta['faktura_path']): ?>
                                            <a href="fakturak/faktura_<?= $salmenta['id'] ?>.pdf" class="ikusi-botoia" target="_blank">Ikusi
                                            </a>
                                            <a href="fakturak/faktura_<?= $salmenta['id'] ?>.pdf" class="deskargatuBotoia" download> Deskargatu
                                            </a>
                                        <?php else: ?>
                                            <span>PDF-rik ez</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="hutsik">
                    <p>Ez duzu fakturarik oraindik.</p>
                    <a href="produktuak.php">Egin erosketa bat!</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>