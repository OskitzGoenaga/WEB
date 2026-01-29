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
    <?php include_once "konexioa.php"; ?>
 <?php include_once "navbar.php"; ?>
    <div class="galdetegia">
        <div class="taula">
            <h2>HORNITZAILE BIHURTU</h2>
            <p>Bete formulario hau eta jarri gurekin harremanetan!</p>
            <form action="hornitzaile.php" method="POST">
                <div>
                    <div class="izenburuak">
                        <label>Izena: </label>
                        <input type="text" name="izena" placeholder="Izena" required/><br>
                    </div>
                    <div class="izenburuak">
                        <label>Abizena: </label>
                        <input type="text" name="abizena" placeholder="Abizena" required/><br>
                    </div>
                    <div class="izenburuak">
                        <label>Email-a: </label>
                        <input type="email" name="email" placeholder="Email" required/><br>
                    </div>
                    <div class="izenburuak">
                        <label>Telefonoa: </label>
                        <input type="tel" name="telefonoa" placeholder="Telefonoa" required/><br>
                    </div>
                        <input type="submit" name="bidali" class="bidali" value="BIDALI"></input><br>
                </div>
            </form>  
        </div>
    </div>
    <?php include_once "footer.php"; ?>
</body>

</html>