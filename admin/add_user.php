<?php

require_once "../inc/functions.php";
require_once '../inc/headers.php';

// Haetaan tiedot inputista
$input = json_decode(file_get_contents("php://input"));
$ktunnus = filter_var($input->etunimi, FILTER_SANITIZE_SPECIAL_CHARS);
$salasana = filter_var($input->sukunimi, FILTER_SANITIZE_SPECIAL_CHARS);
$sposti = filter_var($input->sposti, FILTER_SANITIZE_EMAIL);

// Tarkistetaan, ettei yksikään kenttä ole tyhjä
if (empty($ktunnus) || empty($salasana) || empty($sposti)) {
    throw new Exception("Tarkista, että kaikki kentät on täytetty.");
}

try {
    $db = openDB();

    $query = $db->prepare("SELECT asiakasnro FROM asiakas WHERE sposti = :sposti");
    $query->bindValue(":sposti", $sposti, PDO::PARAM_STR);
    $query->execute();
    

    $query = $db->prepare("INSERT INTO tuoteryhma (ktunnus, asiakasnro, admincheck, salasana) VALUES (:ktunnus, :asiakasnro, 0, :salasana)");
    $query->bindValue(":ktunnus", $ktunnus, PDO::PARAM_STR);
    $query->bindValue(":asiakasnro", $asiakasnro, PDO::PARAM_STR);
    $query->bindValue(":salasana", $salasana, PDO::PARAM_STR);

    $query->execute();

    header("HTTP/1.1 200 OK");
    $data = array("id" => $db->lastInsertId(), "trnimi" => $trnimi);
    print json_encode($data);
} catch (PDOException $pdoex) {
    $db->rollback();
    returnError($pdoex);
}
