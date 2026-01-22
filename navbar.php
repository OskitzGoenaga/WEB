<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            border: 0;
            font-size: 100%;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;

        }

        body {
            text-align: center;
        }

        .head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 11%;
            background-color: white;
            position: fixed;
            width: 100%;
            z-index: 100;
        }

        .logo img {
            margin-left: 140px;
            max-width: 100%;
            height: auto;
            width: 120px;
        }
        .buscadorea {
            position: relative;
            width: 300px;
        }
        .buscadorea > input {
            width: 100%;
            padding: 12px 20px 12px 20px;
            border-radius: 30px;
            border: 2px solid black;
            background-color: #fff;
        }

        .navbar {
            display: flex;
            margin-right: 50px;
        }

        .navbar a {
            display: block;
            padding: 25px 20px;
            color: black;
            text-decoration: none;
            text-transform: uppercase;
            font-size: 120%;
        }

        .navbar img {
            width: 101%;
            height: auto;
            max-height: 24px;
        }

        .navbar a:hover {
            background: #e91e63;
        }

    </style>
</head>
<body>
    <div class="head">
        <div class="logo">
            <a href="sarrera.php"><img src="Argazkiak/logoa.jpg"></a>
        </div>
        <form action="produktuak.php" method="get">
            <div class="buscadorea">
                <input type="text"name="bilatzailea"placeholder="Buscar...">
            </div>
        </form>
        <nav class="navbar">
            <a href="sarrera.php">Sarrera</a>
            <a href="kontaktua.php">Kontaktua</a>
            <a href="produktuak.php">Produktuak</a>
            <a href="hornitzaile.php">Hornitzaile Bihurtu</a>
            <a href="../ingles/webIng.html"><img src="Argazkiak/Bandera_Ingelesa.jpg"></a>
        </nav>
    </div>
</body>
</html>