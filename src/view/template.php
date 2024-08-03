<!DOCTYPE html>
<html lang="fi">
<head>
    <link href="<?=BASEURL?>/styles/styles.css" rel="stylesheet">
    <title>acroyogaworkshops - <?=$this->e($title)?></title>
    <meta charset="UTF-8">    
</head>
<body>
    <header>
        <div class="header-content">
            <h1><a href="<?=BASEURL?>">Akrojooga Ikaalinen</a></h1>
            <img src="<?=BASEURL?>/images/Akrokuva1.png" alt="Akrojooga logo" class="logo">
        </div>
        <div class="profile">
        <?php
          if (isset($_SESSION['user'])) {
            echo "<div>$_SESSION[user]</div>";
            echo "<div><a href='logout'>Kirjaudu ulos</a></div>";
            if (isset($_SESSION['admin']) && $_SESSION['admin']) {
              echo "<div><a href='admin'>Ylläpitosivut</a></div>";  
            }
          } else {
            echo "<div><a href='kirjaudu'>Kirjaudu</a></div>";
          }
        ?>
      </div>
    </header>
    <section>
        <?=$this->section('content')?>
    </section>
    <div class="image-container">
        <img src="<?=BASEURL?>/images/Akrokuva.png" alt="Akrojooga kuva" id="image2" class="image">
    </div>
    <footer>
        <hr>
        <div>Ikaalisten akrojoogit</div>
    </footer>
</body>
</html>
