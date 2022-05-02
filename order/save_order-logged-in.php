<?php

require_once "../inc/functions.php";
require_once '../inc/headers.php';

// Haetaan tiedot inputista
$input = json_decode(file_get_contents("php://input"));
$asiakasnro = filter_var($input->asiakasnro, FILTER_SANITIZE_SPECIAL_CHARS);
$etunimi = filter_var($input->etunimi, FILTER_SANITIZE_SPECIAL_CHARS);
$sukunimi = filter_var($input->sukunimi, FILTER_SANITIZE_SPECIAL_CHARS);
$sposti = filter_var($input->sposti, FILTER_SANITIZE_EMAIL);
$osoite = filter_var($input->osoite, FILTER_SANITIZE_SPECIAL_CHARS);
$postinro = filter_var($input->postinro, FILTER_SANITIZE_SPECIAL_CHARS);
$postitmp = filter_var($input->postitmp, FILTER_SANITIZE_SPECIAL_CHARS);
$ostoskori = $input->ostoskori;

// Tarkistetaan, ettei ostoskori ole tyhjä
if (count($ostoskori) <= 0) {
    throw new Exception("Ostoskori on tyhjä.");
}

// Tarkistetaan, ettei yksikään kenttä ole tyhjä
if (empty($etunimi) || empty($sukunimi) || empty($osoite) || empty($postinro) || empty($postitmp) || empty($sposti)) {
    throw new Exception("Tarkista, että kaikki kentät on täytetty.");
}

// Tarkistetaan, että postinumeron pituus on viisi merkkiä ja sisältää vain numeroita
if (!ctype_digit($postinro) || strlen($postinro) != 5) {
    throw new Exception("Tarkista, että postinumero on oikein.");
}

try {
    $db = openDB();
    $db->beginTransaction();

    // Lisätään tilaus
    $sql = "INSERT INTO tilaus (asiakas_id) VALUES ($asiakasnro)";
    $tilausnro = executeInsert($db, $sql);

    // Lisätään tilausrivit
    foreach ($ostoskori as $tuote) {
        $sql = "INSERT INTO tilausrivi (tilaus_id, tuote_id, kpl) VALUES ("
            .
            $tilausnro . "," .
            $tuote->tuotenro . "," .
            $tuote->amount
            . ")";
        executeInsert($db, $sql);
    }

    // Commitoidaan transaktio
    $db->commit();

    header('HTTP/1.1 200 OK');
    $data = array('order_id' => $tilausnro);
    echo json_encode($data);
} catch (PDOException $pdoex) {
    $db->rollback();
    returnError($pdoex);
}
