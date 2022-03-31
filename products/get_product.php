<?php
require_once "../inc/functions.php";
require_once '../inc/headers.php';

$uri = parse_url(filter_input(INPUT_SERVER, 'PATH_INFO'), PHP_URL_PATH);
$parameters = explode("/", $uri);
$product_id = $parameters[1];

try {
    $db = openDB();
    selectAsJson($db, "SELECT tuotenro, tuotenimi, tieteellinen_nimi, tuotekuvaus, trnro, hinta, ohje FROM tuote LEFT JOIN hoitoohje ON tuote.tuotenro = hoitoohje.tuote_id LEFT JOIN tieteellinen_nimi ON tuote.tuotenro = tieteellinen_nimi.tuote_id WHERE tuote.tuotenro = $product_id");
} catch (PDOException $pdoex) {
    returnError($pdoex);
}
