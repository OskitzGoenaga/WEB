<?php
// Saioa hasi (session-ak erabiltzeko)
session_start();

// Datu-baseko konexioa kargatu
require 'konexioa.php';
?>
<!DOCTYPE html>
<html lang="eu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saioa hasi</title>
    <link rel="stylesheet" href="orokorra.css" />
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <style>
        body {
            background-color: #f5f5f7;
        }

        #testua{
            color: #444;
            padding:0px 50px 30px;
        }
        
        .formularioa {
            text-align: center;
            width: 30%;
            margin: 120px auto;
            background-color: white;
            box-shadow: 0 10px 18px rgba(0, 0, 0, 0.30);
            padding: 50px 0px;
            border-radius: 20px;
        }
        .formularioa>h1{
            font-size: 40px;
        }

        .formularioa>form>input {
            border-radius: 7px;
            border: 1px solid black;
            padding: 10px 30px;
        }

        .formularioa>form>#saioaBtn {
            margin-top: 10px;
            background-color: black;
            color: white;
            padding: 10px 30px;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <!-- Erregistro formulario nagusia -->
    <div class="formularioa">

        <h1 >SORTU KONTUA</h1><br>
        <p id="testua">Saskia ikusteko edo arazoak bidaltzeko kontu bat sortu behar duzu!</p>

        <!-- Formularioa: datuak login.php-ra bidaltzen dira -->
        <form action="login.php" method="POST">
            <label>Izena:</label><br>
            <input type="text" name="izena" required><br><br>

            <label>Abizena:</label><br>
            <input type="text" name="abizena" required><br><br>

            <label>Email:</label><br>
            <input type="email" name="email" required><br><br>

            <label>Pasahitza:</label><br>
            <input type="password" name="pasahitza" required><br><br>

            <label>Telefonoa:</label><br>
            <input type="text" name="telefonoa" required><br><br>

            <label>Helbidea:</label><br>
            <input type="text" name="helbidea" required><br><br>

            <!-- Erregistratu botoia -->
            <button type="submit" name="bidali" id="saioaBtn">ERREGISTRATU</button>
        </form>

        <!-- Jadanik kontua dutenentzako esteka -->
        <a href="hasiSaioa.php">Jadanik kontua duzu?</a>
    </div>
</body>

</html>

<?php
// Formularioa bidali denean (POST eskaera)
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Begiratu emaila eta pasahitza datu-basetan dagoen
    $sql = "SELECT * FROM bezeroak WHERE email = :em AND pasahitza = :pas";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':em' => $_POST["email"],
        ':pas' => $_POST["pasahitza"]
    ]);

    // Email edo pasahitza jada existitzen badira alert bat erakutsi
    if ($stmt->rowCount() != 0) { ?>
        <script>
            alert("Telefono edo email hori jada sartuta dago!");    
        </script>
        <?php
        exit;
    } else {
        // Bezero berria sartu datu-basera
        $bezeroak = "INSERT INTO bezeroak (id, izena, abizena, email, pasahitza, telefonoa, helbidea) VALUES (null, :iz, :ab, :em, :pas, :tel, :hel)";
        $stmt = $pdo->prepare($bezeroak);

        $stmt->execute([
            ':iz' => $_POST["izena"],
            ':ab' => $_POST["abizena"],
            ':em' => $_POST["email"],
            ':pas' => $_POST["pasahitza"],
            ':tel' => $_POST["telefonoa"],
            ':hel' => $_POST["helbidea"]
        ]);

        if ($stmt) {
            // Sesioan gorde erabiltzailearen datuak
            $_SESSION['id'] = $bezeroa['id'];
            $_SESSION['izena'] = $bezeroa['izena'];

            // Sarrera orrira bidali eta alert bat erakutsi
            header("Location: sarrera.php?ok=1");
            exit();
        }
    }
}
?>

<?php if (isset($_GET['ok'])): ?>
    <!-- jQuery eta alert bat erregistratu ondoren -->
    <script src="https://code.jquery.com/jquery-4.0.0.js"
        integrity="sha256-9fsHeVnKBvqh3FB2HYu7g2xseAZ5MlN6Kz/qnkASV8U=" crossorigin="anonymous"></script>
    <script>
        alert("Erregistratu zara!");
    </script>
<?php endif; ?>
