<?php
// Datu-baseko konexioa eta nabigazio barra kargatu
include_once "konexioa.php";
include_once "navbar.php";

// Hasieratu aldagaia mezuak gordetzeko
$emailOkerra = false;
$mezua = "";

// Formularioa bidali denean
if (isset($_POST['bidali'])) {
    $email = $_POST['email'] ?? '';

    // Begiratu email hori dagoeneko bezeroak taulan
    $sql = "SELECT * FROM bezeroak WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email]);

    $bezeroa = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($bezeroa) {
        // Bezeroa existitzen bada -> arazoa datu-basera sartu
        $bezeroa_id = $bezeroa['id'];
        $arazoa = $_POST['arazoa'] ?? '';
        $sql_inserta = "INSERT INTO arazoak (bezeroa_id, arazoa) VALUES (:bezeroa_id, :arazoa)";
        $stmt_inserta = $pdo->prepare($sql_inserta);
        $stmt_inserta->execute([
            'bezeroa_id' => $bezeroa_id,
            'arazoa' => $arazoa
        ]);?>
        <!-- Alert bat erakutsi datuak ongi sartu direla -->
        <script>
            alert("Datuak ongi sartuta")
        </script>
        <?php
    } else {
        // Email-a ez badago datu-basean -> aldagaia true egin
        $emailOkerra = true; 
    }
}
?>

<!DOCTYPE html>
<html lang="eu">
<head>
    <meta charset="UTF-8">
    <title>Kontaktua</title>
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="kontaktua.css">
    <link rel="stylesheet" href="orokorra.css">
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="footer.css">
</head>
<body>

<!-- Kontakturako formularioa -->
<div class="galdetegia">
    <div class="taula">
        <div class="soporteform">
            <h2>SOPORTEA</h2>
            <p>Bete formulario hau eta jarri gurekin harremanetan!</p>
        
            <!-- Mezu bat erakutsi nahi izanez gero -->
            <?php if (!empty($mezua)): ?>
                <p class="mezua"><?= $mezua ?></p>
            <?php endif; ?>

            <!-- Formularioa -->
            <form action="kontaktua.php" method="POST">
                <div class="izenburuak">
                    <label>Email-a:</label>
                    <input type="email" name="email" required>
                </div>

                <div class="izenburuak">
                    <label>Arazoa:</label>
                    <textarea name="arazoa" required></textarea>
                </div>

                <!-- Bidali botoia -->
                <input type="submit" name="bidali" class="bidali" value="BIDALI">
            </form>
        </div> 

        <!-- Email okerra denean agertzen den mezua -->
        <div id="okerra" class="mensajea">
            <p>Email hori ez dago erregistratuta edo datu okerrak sartu dituzu.</p>
            <input type="submit" id="saioaEraman" class="bidali" value="Hasi saioa!">
        </div> 
    </div>
</div>

<!-- jQuery erabiliz email okerra badago formuak ezkutatu eta mezua erakutsi -->
<script src="https://code.jquery.com/jquery-4.0.0.js" integrity="sha256-9fsHeVnKBvqh3FB2HYu7g2xseAZ5MlN6Kz/qnkASV8U=" crossorigin="anonymous"></script>
<script>
var emailOkerra = <?= $emailOkerra ? 'true' : 'false'; ?>;
console.log(emailOkerra)
if (emailOkerra === true) {
    // Formularioa ezkutatu eta mezua erakutsi
    $(".mensajea").css("display","block" );
    $(".soporteform").css("display","none" );
}

// "Hasi saioa" botoia sakatuz login orrira birbideratu
$("#saioaEraman").click(function(){
    window.location.href="login.php";
});
</script>

<!-- Footer kargatu -->
<?php include_once "footer.php"; ?>
</body>
</html>
