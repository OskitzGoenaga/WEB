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
    <link rel="stylesheet" href="orokorra.css" />
    <link rel="stylesheet" href="produktuak.css">
    <link rel="stylesheet" href="navbar.css" />
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <style>
        body {
            text-align: center;
            background-color: #f5f5f7;
        }

        .saskia2 {
            background-color: white;
            margin: 160px 400px;
            padding: 30px;
        }

        .saskia2>h1 {
            font-size: 40px;
        }
    </style>
</head>

<body>
    <?php include_once "navbar.php"; ?>
    <div class="saskia2">
        <h1>Erosketa saskia</h1>
        <p>Kaixo, <?php echo $_SESSION['bezero_izena']; ?>. Hemen dago zure saskia.</p>
    </div>
</body>

</html>