<?php 
include_once "konexioa.php";
session_start();
 

if (!isset($_SESSION['bezero_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saskia</title>
    <style>
        body{
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Erosketa saskia</h1>
    <p>Kaixo, <?php echo $_SESSION['bezero_izena']; ?>. Hemen dago zure saskia.</p>
</body>
</html>



