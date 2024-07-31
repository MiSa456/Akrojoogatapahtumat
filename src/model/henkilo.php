<?php

  require_once HELPERS_DIR . 'DB.php';

  function lisaaHenkilo($nimi,$email,$salasana) {
    DB::run('INSERT INTO akrohenkilo (nimi, email, salasana) VALUE  (?,?,?);',[$nimi,$email,$salasana]);
    return DB::lastInsertId();
  }

?>
