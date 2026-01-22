<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="produktuak.css">
    <title>Document</title>
</head>
<body>
    <?php
        include_once "navbar.php";

        
        include_once "konexioa.php";

        $stmt = $pdo->query('select izena, argazkia, prezioa from produktuak');
    ?>
    <section class="edukia">
    <div class="kutxa-edukia">
    <?php while ($produktua = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
        <div class="kutxa">
            <div class="zatia1">
                <h3><?= $produktua["izena"];?></h3>
                <div class="erdian">
                <?php $linka ='Argazkiak/' . $produktua['argazkia']; ?>
                <img src="<?= $linka ?>" alt="">
            </div>
        </div>
        <div class="linea2"></div>
            <div class="zatia2">
                <input type="submit" name="erosi" class="erosiBotoia" value="EROSI"></input>
                <span class="balioa"><?= $produktua["prezioa"]." €";?></span><br><br>
            </div>
        </div>
    <?php endwhile; ?>
    </div>
    </section>
</body>
</html>