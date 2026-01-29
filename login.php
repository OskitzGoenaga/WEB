<?php
session_start();
require 'konexioa.php'; // tu conexión a la base de datos
?>
<!-- Formulario simple -->
<!DOCTYPE html>
<html lang="en">

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
            padding-bottom:30px;
        }
        
        .formularioa {
            text-align: center;
            width: 50%;
            margin: 130px 400px;
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
    <link rel="stylesheet" href="navbar.css" />
</head>

<body>
    <?php include_once "navbar.php"; ?>
    <div class="formularioa">

        <h1 >HASI SAIOA</h1><br>
        <p id="testua">Saskia ikusteko edo arazoak bidaltzeko hasi saioa!</p>
        <form action="login.php" method="POST">
            <label>Izena:</label><br>
            <input type="text" name="izena" required><br><br>

            <label>Abizena:</label><br>
            <input type="text" name="abizena" required><br><br>

            <label>Email:</label><br>
            <input type="email" name="email" required><br><br>

            <label>Telefonoa:</label><br>
            <input type="text" name="telefonoa" required><br><br>

            <label>Helbidea:</label><br>
            <input type="text" name="helbidea" required><br><br>

            <button type="submit" id="saioaBtn">SAIOA HASI</button>
        </form>
    </div>
</body>

</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'];
    $telefonoa = $_POST['telefonoa'];

    // Consulta básica
    $sql = "SELECT * FROM bezeroak WHERE email = '$email' AND telefonoa = '$telefonoa'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $bezeroa = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($bezeroa) {
        // Saioan gorde
        $_SESSION['bezero_id'] = $bezeroa['id'];
        $_SESSION['bezero_izena'] = $bezeroa['izena'];

        header("Location: sarrera.php");
        
        exit();
    } else { ?>
      <script> < src="https://code.jquery.com/jquery-4.0.0.js" integrity="sha256-9fsHeVnKBvqh3FB2HYu7g2xseAZ5MlN6Kz/qnkASV8U=" crossorigin="anonymous"></script>  
      <script>alert("Datu okerrak");</script>
    <?php }
}
?>