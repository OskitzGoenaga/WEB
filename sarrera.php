<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sarrera</title>
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="sarrera.css">
    <link rel="stylesheet" href="orokorra.css">
    <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="slick/slick-theme.css"/>
    <style>
    .slider {
        width: 70%;
        margin: auto;
    }

    .slick-slide {
        height: initial;
    }

    .slick-prev:before,
    .slick-next:before {
        color: black;
        font-size: 40px;
    }
    </style>
</head>
<body>
    <?php include_once "navbar.php"; ?>
    <?php include_once "konexioa.php"; ?>

<?php 
    $kontsulta = "select id, izena, argazkia, prezioa from produktuak limit 8";
    $stmt = $pdo->query($kontsulta);
?>
    <section class="berriak">
    <h1 class="teknologia">Teknologia berriena!</h1>
    <div class="kutxa-edukia slider">
         <?php while ($produktua = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                <form action="saskia.php" method="POST">
                    <div class="kutxa">
                        <div class="zatia1">
                            <h3><?= $produktua["izena"]; ?></h3>
                            <div class="erdian">
                                <?php $linka = 'Argazkiak/' . $produktua['argazkia']; ?>
                                <img src="<?= $linka ?>" alt="">
                            </div>
                        </div>
                        <div class="lineaKutxak"></div>
                        <div class="zatia2">
                            <input type="hidden" name="id" value="<?= $produktua['id'] ?>">
                            <input type="submit" name="erosi" class="erosiBotoia" value="EROSI"></input>
                            <span class="balioa"><?= $produktua["prezioa"] . " €"; ?></span>

                        </div>
                    </div>
                </form>
            <?php endwhile; ?>
    </div>
    </section>
     <section class="prezioa">
        <article>
      <img src="../WEB/Argazkiak/argazkia.jpg" />
      <div class="jasangarritasuna">
      <h2>Prezioak jasangarriak, etorkizun berriak.</h2>
        <p>
        Rebizi-n <strong>9, 11, 12 eta 13. GJHen</strong> alde egiten dugu:  
        teknologia berriztuz, <strong>aurreztu</strong> eta <strong>planeta babesten duzu</strong>!  
        Gailuak kalitatezkoak, <strong>prezio justuetan</strong> eta <strong>bigarren bizitza batekin</strong>.  
        <i>— Zuk aukeratu, guk berriztuko dugu. Munduak eskertuko du!</i>
        </p>
      </div>
      </article>
         </section>
      <section class="gu" id="norgara">
    <h2 class="title1">Nor gara Rebizi-n?</h2>
    <p>
      Pasioz beteriko talde bat gara, teknologia eta jasangarritasuna uztartzen dituena. Gure helburua zure gailuak
      berrerabiltzea da, ingurumena zainduz eta aurrezpena eskainiz.
    </p>
    <div class="kutxa-edukia2">
      <div class="kutxa">
        <h3>OIER MAIZA UGARTEMENDIA</h3>
        <p>
          Antolatzailea, proiektu hau aurrera eramatera ahalbidetu duen pertsona.
        </p>
      </div>

      <div class="kutxa">
        <h3>ANDER ORMAZABAL GARCIANDIA</h3>
        <p>
          Taldearen burbuina, denak funtzionatzearen arduraduna.
        </p>

      </div>

      <div class="kutxa">
        <h3>OSKITZ GOENAGA URRETABIZKAIA</h3>
        <p>
          Gure programatzaile aditua, webaren sortzailea.
        </p>
      </div>
    </div>
  </section>
  
     <?php include_once "footer.php"; ?>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-migrate-3.6.0.js" integrity="sha256-K+9TyQ575NpZ999iNVvO9DXK2mBqL7jOryAz2FuQpcs=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="slick/slick.min.js"></script>

    <script>
    $(".erosiBotoia").click(function(){
        var a = parseInt($("#zenbakia").text());
        a = a + 1;
        $("#zenbakia").text(a);
    });
    $(document).ready(function(){
        $('.slider').slick({
        slidesToShow: 3,
        slidesToScroll: 1
        });
    });
</script>

</body>
</html>