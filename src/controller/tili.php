<?php
function lisaaTili($formdata, $baseurl='') {

  // Tuodaan henkilo-mallin funktiot, joilla voidaan lisätä henkilön tiedot tietokantaan.
  require_once(MODEL_DIR . 'henkilo.php');

  // Alustetaan virhetaulukko, joka palautetaan lopuksi joko tyhjänä tai virheillä täytettynä.
  $error = [];

  // Tarkistetaan onko nimi määritelty ja se täyttää mallin.
  if (!isset($formdata['nimi']) || !$formdata['nimi']) {
    $error['nimi'] = "Anna nimesi.";
  } else {
    if (!preg_match("/^[- '\p{L}]+$/u", $formdata["nimi"])) {
      $error['nimi'] = "Syötä nimesi ilman erikoismerkkejä.";
    }
  }

  // Tarkistetaan, että sähköpostiosoite on määritelty ja se on oikeassa muodossa.
  if (!isset($formdata['email']) || !$formdata['email']) {
    $error['email'] = "Anna sähköpostiosoitteesi.";
  } else {
    if (!filter_var($formdata['email'], FILTER_VALIDATE_EMAIL)) {
      $error['email'] = "Sähköpostiosoite on virheellisessä muodossa.";
    } else {
      if (haeHenkiloSahkopostilla($formdata['email'])) {
        $error['email'] = "Sähköpostiosoite on jo käytössä.";
      }
    }
  }

  // Tarkistetaan, että kummatkin salasanat on annettu ja että ne ovat keskenään samat.
  if (isset($formdata['salasana1']) && $formdata['salasana1'] &&
      isset($formdata['salasana2']) && $formdata['salasana2']) {
    if ($formdata['salasana1'] != $formdata['salasana2']) {
      $error['salasana'] = "Salasanasi eivät olleet samat!";
    }
  } else {
    $error['salasana'] = "Syötä salasanasi kahteen kertaan.";
  }

  // Lisätään tiedot tietokantaan, jos edellä syötetyissä tiedoissa ei ollut virheitä.
  if (!$error) {
    $nimi = $formdata['nimi'];
    $email = $formdata['email'];
    $salasana = password_hash($formdata['salasana1'], PASSWORD_DEFAULT);

    $idhenkilo = lisaaHenkilo($nimi, $email, $salasana);

    if ($idhenkilo) {
      require_once(HELPERS_DIR . "secret.php");
      $avain = generateActivationCode($email);
      $url = 'https://' . $_SERVER['HTTP_HOST'] . $baseurl . "/vahvista?key=$avain";

      if (paivitaVahvavain($email, $avain) && lahetaVahvavain($email, $url)) {
        return [
          "status" => 200,
          "id"     => $idhenkilo,
          "data"   => $formdata
        ];
      } else {
        return [
          "status" => 500,
          "data"   => $formdata
        ];
      }
    } else {
      return [
        "status" => 500,
        "data"   => $formdata
      ];
    }
  } else {
    return [
      "status" => 400,
      "data"   => $formdata,
      "error"  => $error
    ];
  }
}

function lahetaVahvavain($email, $url) {
  $message = "Hei!\n\n" .
             "Olet luonut tilin Akrojooga Ikaalinen -sivustolle tällä\n" .
             "sähköpostiosoitteella. Klikkaamalla alla olevaa\n" .
             "linkkiä vahvistat käyttämäsi sähköpostiosoitteen\n" .
             "ja pääset ilmoittautumaan tapahtumiin.\n\n" .
             "$url\n\n" .
             "Jos et ole luonut tiliä, niin\n" .
             "silloin tämä sähköposti on tullut sinulle\n" .
             "vahingossa. Siinä tapauksessa ole hyvä ja\n" .
             "poista tämä viesti.\n\n" .
             "Terveisin, Ikaalisten akrojoogit";
  return mail($email, 'Akrojooga Ikaalinen, tilin aktivointilinkki', $message);
}
function lahetaVaihtoavain($email,$url) {
  $message = "Hei!\n\n" .
             "Olet pyytänyt tilisi salasanan vaihtoa, klikkaamalla\n" .
             "alla olevaa linkkiä pääset vaihtamaan salasanasi.\n" .
             "Linkki on voimassa 30 minuuttia.\n\n" .
             "$url\n\n" .
             "Jos et ole pyytänyt tilisi salasanan vaihtoa, niin\n" .
             "voit poistaa tämän viestin turvallisesti.\n\n" .
             "Terveisin, Ikaalisten akrojoogit";
  return mail($email,'Ikaalinen akrojooga -tilin salasanan vaihtaminen',$message);
}
function luoVaihtoavain($email, $baseurl='') {

  // Luodaan käyttäjälle vaihtoavain ja muodostetaan vaihtolinkki.
  require_once(HELPERS_DIR . "secret.php");
  $avain = generateResetCode($email);
  $url = 'https://' . $_SERVER['HTTP_HOST'] . $baseurl . "/reset?key=$avain";

  // Tuodaan henkilo-mallin funktiot, joilla voidaan lisätä vaihtoavaimen tiedot kantaan.
  require_once(MODEL_DIR . 'henkilo.php');

  // Lisätään vaihtoavain tietokantaan ja lähetetään
  // käyttäjälle sähköpostia. Jos tämä onnistui, niin palautetaan
  // palautusarvona vaihtoavain ja sähköpostiosoite. Muuten
  // palautetaan virhekoodi, joka ilmoittaa, että jokin lisäyksessä
  // epäonnistui.
  if (asetaVaihtoavain($email,$avain) && lahetaVaihtoavain($email,$url)) {
    return [
      "status"   => 200,
      "email"    => $email,
      "resetkey" => $avain
    ];
  } else {
    return [
      "status" => 500,
      "email"   => $email
    ];
  }

}

?>
