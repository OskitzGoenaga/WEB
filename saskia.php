<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="orokorra.css">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
</head>
<body>
    <?php
        include_once "konexioa.php";
        include_once "navbar.php";

        // Datu-basean saskiaren edukia lortu
        $stmt = $pdo->prepare("
            SELECT p.izena, p.prezioa, s.kantitatea 
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
        <h1>Zure erosketa saskia</h1>

        <?php foreach ($produktua as $p): ?>
            <div class="item">
                <h3><?= $p["izena"] ?></h3>
                <p>Prezioa: <?= $p["prezioa"] ?> €</p>
                <p>Kantitatea: <?= $p["kantitatea"] ?></p>
                <hr>
            </div>
    <?php endforeach; ?>
</body>
</html>

