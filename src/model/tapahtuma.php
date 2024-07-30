<?php

  require_once HELPERS_DIR . 'DB.php';
  function haeTapahtuma($id) {
    return DB::run('SELECT * FROM akrotapahtumat WHERE idtapahtuma = ?;',[$id])->fetch();
  }

?>
