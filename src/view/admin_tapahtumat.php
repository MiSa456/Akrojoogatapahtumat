<?php $this->layout('template', ['title' => 'Ylläpito: Tapahtumat ja Ilmoittautuneet']) ?>

<h1>Tapahtumat ja Ilmoittautuneet</h1>

<div class='admin-tapahtumat'>
<?php
foreach ($tapahtumat as $tapahtuma) {
    $start = new DateTime($tapahtuma['tap_alkaa']);

    echo "<div>";
    echo "<h2>$tapahtuma[nimi] - " . $start->format('j.n.Y') . " klo " . $start->format('G:i') . "</h2>";
    echo "<p>$tapahtuma[kuvaus]</p>";
    echo "<h3>Ilmoittautuneet:</h3>";

    if (!empty($tapahtuma['ilmoittautuneet'])) {
        echo "<ul>";
        foreach ($tapahtuma['ilmoittautuneet'] as $ilmoittautunut) {
            echo "<li>" . htmlspecialchars($ilmoittautunut['nimi']) . " (" . htmlspecialchars($ilmoittautunut['email']) . ")</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Ei ilmoittautuneita.</p>";
    }

    echo "</div><hr>";
}
?>
</div>

