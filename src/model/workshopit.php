<?php

require_once HELPERS_DIR . 'DB.php';

function haeTapahtumat() {
    return DB::run('SELECT * FROM akrotapahtumat ORDER BY tap_alkaa;')->fetchAll();
}

function haeTapahtumatJaIlmoittautuneet() {
    $sql = '
        SELECT t.idtapahtuma, t.nimi, t.kuvaus, t.tap_alkaa, 
               h.nimi AS ilmoittautunut_nimi, h.email AS ilmoittautunut_email
        FROM akrotapahtumat t
        LEFT JOIN akroilmoittautuminen i ON t.idtapahtuma = i.idtapahtuma
        LEFT JOIN akrohenkilo h ON i.idhenkilo = h.idhenkilo
        ORDER BY t.tap_alkaa, h.nimi;
    ';

    $rows = DB::run($sql)->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_ASSOC);

    $tapahtumat = [];
    foreach ($rows as $idtapahtuma => $tiedot) {
        $tapahtuma = $tiedot[0];
        $tapahtuma['ilmoittautuneet'] = array_map(function($ilmo) {
            return [
                'nimi' => $ilmo['ilmoittautunut_nimi'],
                'email' => $ilmo['ilmoittautunut_email']
            ];
        }, $tiedot);
        $tapahtumat[] = $tapahtuma;
    }

    return $tapahtumat;
}

