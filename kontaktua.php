<?php
include_once "konexioa.php";
include_once "navbar.php";

// Inicializamos el mensaje
$emailOkerra = false;
$mezua = "";

if (isset($_POST['bidali'])) {
    $email = $_POST['email'] ?? '';

    $sql = "SELECT * FROM bezeroak WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email]);

    $bezeroa = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($bezeroa) {
        // Guardamos el problema en la base de datos
        $bezeroa_id = $bezeroa['id'];
        $arazoa = $_POST['arazoa'] ?? '';
        $sql_inserta = "INSERT INTO arazoak (bezeroa_id, arazoa) VALUES (:bezeroa_id, :arazoa)";
        $stmt_inserta = $pdo->prepare($sql_inserta);
        $stmt_inserta->execute([
            'bezeroa_id' => $bezeroa_id,
            'arazoa' => $arazoa
        ]);?>
        <script>
            alert("Datuak ongi sartuta")
        </script>
        <?php
    } else {
        $emailOkerra = true; // solo se activa si se envía el formulario y no existe el email
    }
}
?>

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

<div class="galdetegia">
    <div class="taula">
        <div class="soporteform">
            <h2>SOPORTEA</h2>
            <p>Bete formulario hau eta jarri gurekin harremanetan!</p>
        
            <!-- Mensaje -->
            <?php if (!empty($mezua)): ?>
                <p class="mezua"><?= $mezua ?></p>
            <?php endif; ?>
            <!-- Formulario -->
            <form action="kontaktua.php" method="POST">
                <div class="izenburuak">
                <label>Email-a:</label>
                <input type="email" name="email" required>
            </div>

                <div class="izenburuak">
                    <label>Arazoa:</label>
                    <textarea name="arazoa" required></textarea>
                </div>
                <input type="submit" name="bidali" class="bidali" value="BIDALI">
            </form>
        </div> 
        <div id="okerra" class="mensajea">
            <p>Email hori ez dago erregistratuta edo datu okerrak sartu dituzu.</p>
            <input type="submit" id="saioaEraman" class="bidali" value="Hasi saioa!">
        </div> 
    </div>
</div>
<script src="https://code.jquery.com/jquery-4.0.0.js" integrity="sha256-9fsHeVnKBvqh3FB2HYu7g2xseAZ5MlN6Kz/qnkASV8U=" crossorigin="anonymous"></script>
<script>

var emailOkerra = <?= $emailOkerra ? 'true' : 'false'; ?>;
console.log(emailOkerra)
if (emailOkerra===true) {

    $(".mensajea").css("display","block" );
    $(".soporteform").css("display","none" );
}
$("#saioaEraman").click(function(){
window.location.href="login.php";
});
</script>
<?php include_once "footer.php"; ?>
</body>
</html>
