<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="hornitzaile.css">
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="orokorra.css">
    <title>Hornitzailea</title>
</head>

<body>
    </div>
    <?php 
    // Datu-baseko konexioa kargatu
    include_once "konexioa.php"; 

    // Nabigazio barra kargatu
    include_once "navbar.php"; 
    ?>

    <!-- Hornitzaile bihurtzeko formularioa -->
    <div class="galdetegia">
        <div class="taula">
            <h2>HORNITZAILE BIHURTU</h2>
            <p>Bete formulario hau eta jarri gurekin harremanetan!</p>
            <form action="hornitzaile.php" method="POST">
                <div>
                    <!-- Enpresa izena -->
                    <div class="izenburuak">
                        <label>Enpresa: </label>
                        <input type="text" name="enpresa" required /><br>
                    </div>

                    <!-- Email-a -->
                    <div class="izenburuak">
                        <label>Email-a: </label>
                        <input type="email" name="email" required /><br>
                    </div>

                    <!-- Telefonoa -->
                    <div class="izenburuak">
                        <label>Telefonoa: </label>
                        <input type="tel" name="telefonoa"  required /><br>
                    </div>

                    <!-- Eskaintza -->
                    <div class="izenburuak">
                        <label>Eskaintza: </label><br>
                        <textarea name="eskaintza" required></textarea>
                    </div>

                    <!-- Bidali botoia -->
                    <input type="submit" name="bidali" class="bidali" value="BIDALI"></input><br>
                </div>
            </form>
        </div>
    </div>

    <?php
    // Formularioa bidali denean (POST eskaera)
    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        // Begiratu telefono edo email hori jada existitzen den
        $stmt = $pdo->prepare("
        SELECT telefonoa, email FROM hornitzaileak WHERE telefonoa = :tel OR email = :em
        ");
        $stmt->execute([
            ":tel" => $_POST["telefonoa"],
            ":em" => $_POST["email"]
        ]);

        if ($stmt -> rowCount() != 0) { ?> 
        <!-- Dagoeneko existitzen bada alert bat erakutsi -->
        <script>
           alert("Telefono edo email hori jada sartuta dago!");
        </script>  
        <?php
        exit;
        } else{
            // Hornitzaile berria sartu datu-basera
            $hornitzaileak = "INSERT INTO hornitzaileak (id, enpresa, telefonoa, email, eskaintza) VALUES (null, :en, :tel, :ema, :esk)";
            $stmt = $pdo->prepare($hornitzaileak);

            $stmt->execute([
                ':en' => $_POST["enpresa"],
                ':tel' => $_POST["telefonoa"],
                ':ema' => $_POST["email"],
                ':esk' => $_POST["eskaintza"]
            ]);

            // Berriz formulario bera kargatu eta "ok" parametroa pasatu
            header("Location: hornitzaile.php?ok=1");
            exit;
        }
    }
    ?>

    <?php if (isset($_GET['ok'])): ?>
        <!-- Hornitzaile gisa bihurtu ondoren alert bat erakutsi -->
        <script src="https://code.jquery.com/jquery-4.0.0.js" integrity="sha256-9fsHeVnKBvqh3FB2HYu7g2xseAZ5MlN6Kz/qnkASV8U=" crossorigin="anonymous"></script>
        <script>
            alert("Hornitzailea bihurtu zara! Eskerrik asko zure eskaintzarengatik");
        </script>
    <?php endif; ?>

    <!-- Footer kargatu -->
    <?php include_once "footer.php"; ?>
</body>

</html>
