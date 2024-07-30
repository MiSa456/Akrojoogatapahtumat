<?php $this->layout('template', ['title' => $tapahtuma['nimi']]) ?>

<?php
  $start = new DateTime($tapahtuma['tap_alkaa']);
?>

<h1><?=$tapahtuma['nimi']?></h1>
<div><?=$tapahtuma['kuvaus']?></div>
<div>Ajankohta: <?=$start->format('j.n.Y')?> klo <?=$start->format('G:i')?></div>
