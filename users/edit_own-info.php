<?php
require_once "../inc/functions.php";
require_once '../inc/headers.php';

$uri = parse_url(filter_input(INPUT_SERVER, 'PATH_INFO'), PHP_URL_PATH);
$parameters = explode("/", $uri);
$tunnus = $parameters[1];

$input = json_decode(file_get_contents("php://input"));
$sposti = filter_var($input->sposti, FILTER_SANITIZE_EMAIL);
$osoite = filter_var($input->osoite, FILTER_SANITIZE_SPECIAL_CHARS);
$postinro = filter_var($input->postinro, FILTER_SANITIZE_SPECIAL_CHARS);
$postitmp = filter_var($input->postitmp, FILTER_SANITIZE_SPECIAL_CHARS);

try {
  $db = openDB();

  // Haetaan asiakasnumero
  $sql = "SELECT asiakasnro FROM kayttaja WHERE tunnus = ?";
  $statement = $db->prepare($sql);
  $statement->bindParam(1, $tunnus);
  $statement->execute();
  $asiakasnro = $statement->fetch(PDO::FETCH_ASSOC)["asiakasnro"];

  // Muutetaan sähköposti kayttaja-tauluun
  $sql = "UPDATE kayttaja SET sposti = ? WHERE tunnus = ?";
  $statement = $db->prepare($sql);
  $statement->bindParam(1, $sposti, PDO::PARAM_STR);
  $statement->bindParam(2, $tunnus, PDO::PARAM_STR);
  $statement->execute();

  // Muutetaan tiedot asiakas-taulussa
  $sql = "UPDATE asiakas 
  SET sposti = ?, osoite = ?, postinro = ?, postitmp = ? 
  WHERE asiakasnro = ?";
  $statement = $db->prepare($sql);
  $statement->bindParam(1, $sposti, PDO::PARAM_STR);
  $statement->bindParam(2, $osoite, PDO::PARAM_STR);
  $statement->bindParam(3, $postinro, PDO::PARAM_STR);
  $statement->bindParam(4, $postitmp, PDO::PARAM_STR);
  $statement->bindParam(5, $asiakasnro, PDO::PARAM_INT);
  $statement->execute();

  header("HTTP/1.1 200 OK");
  echo json_encode(array(
    "sposti" => $sposti,
    "osoite" => $osoite,
    "postinro" => $postinro,
    "postitmp" => $postitmp,
  ), JSON_PRETTY_PRINT);
} catch (PDOException $pdoex) {
  returnError($pdoex);
}