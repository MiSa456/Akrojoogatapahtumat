<!DOCTYPE html>
<html lang="fi">
<head>
    <link href="styles/styles.css" rel="stylesheet">
    <title>acroyogaworkshops - <?=$this->e($title)?></title>
    <meta charset="UTF-8">    
</head>
<body>
    <header>
        <h1><a href="<?=BASEURL?>">Akrojooga Ikaalinen</a></h1>
    </header>
    <section>
        <?=$this->section('content')?>
    </section>
    <footer>
        <hr>
        <div>Ikaalisten akrojoogit</div>
    </footer>
</body>
</html>
