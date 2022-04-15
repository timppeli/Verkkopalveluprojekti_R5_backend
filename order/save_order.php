<?php

require_once "../inc/functions.php";
require_once '../inc/headers.php';

// Haetaan tiedot inputista
$input = json_decode(file_get_contents("php://input"));
$etunimi = filter_var($input->etunimi, FILTER_SANITIZE_SPECIAL_CHARS);
$sukunimi = filter_var($input->sukunimi, FILTER_SANITIZE_SPECIAL_CHARS);
$osoite = filter_var($input->osoite, FILTER_SANITIZE_SPECIAL_CHARS);
$postinro = filter_var($input->postinro, FILTER_SANITIZE_SPECIAL_CHARS);
$postitmp = filter_var($input->postitmp, FILTER_SANITIZE_SPECIAL_CHARS);
$ostoskori = $input->ostoskori;

try {
    $db = openDB();
    $db->beginTransaction();

    // Lisätään asiakas
    $sql = "INSERT INTO asiakas (etunimi, sukunimi, osoite, postinro, postitmp) VALUES ('" .
        filter_var($etunimi, FILTER_SANITIZE_FULL_SPECIAL_CHARS) . "','" .
        filter_var($sukunimi, FILTER_SANITIZE_FULL_SPECIAL_CHARS) . "','" .
        filter_var($osoite, FILTER_SANITIZE_FULL_SPECIAL_CHARS) . "','" .
        filter_var($postinro, FILTER_SANITIZE_FULL_SPECIAL_CHARS) . "','" .
        filter_var($postitmp, FILTER_SANITIZE_FULL_SPECIAL_CHARS)
        . "')";

    $asiakasnro = executeInsert($db, $sql);

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
    $data = array('id' => $asiakasnro);
    echo json_encode($data);
} catch (PDOException $pdoex) {
    $db->rollback();
    returnError($pdoex);
}
