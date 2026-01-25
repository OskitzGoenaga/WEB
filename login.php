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
    <style>
        body{
            background-color: #f5f5f7;
            font-family: "Lucida Console", "Courier New", monospace;
        }
        .formularioa{
            text-align: center;
            padding: 50px;
            background-color: white;
            margin:50px 400px;
            box-shadow: 0 10px 18px rgba(0,0,0,0.30);
        }
        .formularioa>form>input{
            border-radius: 7px;
            padding: 10px 30px;
        }
        .formularioa>form>#saioaBtn{
            margin-top: 10px;
            background-color: black;
            color: white;
            padding: 10px 30px;
            border-radius: 5px;
        }
    </style>
 </head>
 <body>
     <div class="formularioa">
            <h1>HASI SAIOA</h1>
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
 
    header("Location: saskia.php");
    exit();
    } else {
    echo "Datu okerrak";
    }
}
?>


 

