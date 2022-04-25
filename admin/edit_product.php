<?php
require_once "../inc/functions.php";
require_once '../inc/headers.php';

$input = json_decode(file_get_contents("php://input"));
$tuotenro = filter_var($input->tuotenro, FILTER_SANITIZE_SPECIAL_CHARS);
$hinta = filter_var($input->hinta, FILTER_SANITIZE_SPECIAL_CHARS);
$tuotenimi = filter_var($input->tuotenimi, FILTER_SANITIZE_SPECIAL_CHARS);
$tuotekuvaus = filter_var($input->tuotekuvaus, FILTER_SANITIZE_SPECIAL_CHARS);
$ohje = filter_var($input->ohje, FILTER_SANITIZE_SPECIAL_CHARS);
$tieteellinen_nimi = filter_var($input->tieteellinen_nimi, FILTER_SANITIZE_SPECIAL_CHARS);

try {
    $db = openDB();
    
    $query = $db->prepare("UPDATE tuote SET tuotenimi = :tuotenimi, hinta = :hinta, tuotekuvaus = :tuotekuvaus WHERE tuotenro = :tuotenro");
    $query->bindValue(":tuotenimi", $tuotenimi);
    $query->bindValue(":hinta", $hinta);
    $query->bindValue(":tuotenro", $tuotenro);
    $query->bindValue(":tuotekuvaus", $tuotekuvaus, PDO::PARAM_STR);
    $query->execute();

    $query = $db->prepare("UPDATE tieteellinen_nimi SET tieteellinen_nimi = :tieteellinen_nimi WHERE tuote_id = :tuotenro;");
    $query->bindValue(":tieteellinen_nimi", $tieteellinen_nimi, PDO::PARAM_STR);
    $query->bindValue(":tuotenro", $tuotenro);
    $query->execute();


    $query = $db->prepare("UPDATE hoitoohje SET ohje = :ohje WHERE tuote_id = :tuotenro;");
    $query->bindValue(":ohje", $ohje, PDO::PARAM_STR);
    $query->bindValue(":tuotenro", $tuotenro);
    $query->execute();

    header("HTTP/1.1 200 OK");
    $data = "ok";
    print json_encode($data);
} catch (PDOException $pdoex) {
    header('HTTP/1.1 500 Internal Servel Error');
    $error = array('error' => $pdoex->getMessage());
    print json_encode($error);
}