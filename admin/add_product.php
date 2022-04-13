<?php
require_once "../inc/functions.php";
require_once '../inc/headers.php';

$input = json_decode(file_get_contents("php://input"));
$trnro = filter_var($input->trnro, FILTER_SANITIZE_SPECIAL_CHARS);
$tuotenimi = filter_var($input->tuotenimi, FILTER_SANITIZE_SPECIAL_CHARS);
$tuotekuvaus = filter_var($input->tuotekuvaus, FILTER_SANITIZE_SPECIAL_CHARS);
$hinta = filter_var($input->hinta, FILTER_SANITIZE_SPECIAL_CHARS);
$ohje = filter_var($input->ohje, FILTER_SANITIZE_SPECIAL_CHARS);
$tieteellinen_nimi = filter_var($input->tieteellinen_nimi, FILTER_SANITIZE_SPECIAL_CHARS);

try {
  $db = openDB();

  $query = $db->prepare("INSERT INTO tuote (trnro, tuotenimi, tuotekuvaus, hinta) VALUES (:trnro, :tuotenimi, :tuotekuvaus, :hinta);");
  $query->bindValue(":trnro", $trnro, PDO::PARAM_STR);
  $query->bindValue(":tuotenimi", $tuotenimi, PDO::PARAM_STR);
  $query->bindValue(":tuotekuvaus", $tuotekuvaus, PDO::PARAM_STR);
  $query->bindValue(":hinta", $hinta, PDO::PARAM_STR);
  $query->execute();
  if($tieteellinen_nimi !== null) {
    $tuotenro = $db->lastInsertId();
    $query = $db->prepare("INSERT INTO hoitoohje (ohje, tuote_id) VALUES (:ohje, :tuotenro); 
    INSERT INTO tieteellinen_nimi (tieteellinen_nimi, tuote_id) VALUES (:tieteellinen_nimi, :tuotenro);");
    $query->bindValue(":ohje", $ohje, PDO::PARAM_STR);
    $query->bindValue(":tieteellinen_nimi", $tieteellinen_nimi, PDO::PARAM_STR);
    $query->bindValue(":tuotenro", $tuotenro, PDO::PARAM_STR);
    $query->execute();
  }
  header("HTTP/1.1 200 OK");
  $data = array("tuotenro" => $tuotenro,"tuotenimi" => $tuotenimi);
  print json_encode($data);
} catch (PDOException $pdoex) {
  header('HTTP/1.1 500 Internal Servel Error');
  $error = array('error' => $pdoex->getMessage());
  print json_encode($error);
}