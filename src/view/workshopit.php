<?php $this->layout('template', ['title' => 'Tulevat workshopit']) ?>

<h1>Tulevat kurssit ja workshopit</h1>

<div class='workshopit'>
<?php

foreach ($workshopit as $tapahtuma) {
    $start = new DateTime($tapahtuma['tap_alkaa']);

    echo "<div>";
        echo "<div>$tapahtuma[nimi]</div>";
        echo "<div>" . $start->format('j.n.Y') . " klo " . $start->format('G:i') . "</div>";
        echo "<div><a href='tapahtuma?id=" . $tapahtuma['idtapahtuma'] . "'>Lue lisää</a></div>";
    echo "</div>";
}

?>
</div>

