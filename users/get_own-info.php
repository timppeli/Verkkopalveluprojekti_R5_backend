<?php
require_once "../inc/functions.php";
require_once '../inc/headers.php';

$uri = parse_url(filter_input(INPUT_SERVER, 'PATH_INFO'), PHP_URL_PATH);
$parameters = explode("/", $uri);
$tunnus = $parameters[1];

try {
  $db = openDB();

  // Haetaan tilaajan tiedot
  $sql = "SELECT * FROM kayttaja LEFT JOIN asiakas ON asiakas.asiakasnro = kayttaja.asiakasnro WHERE tunnus = ?";
  $statement = $db->prepare($sql);
  $statement->bindParam(1, $tunnus);
  $statement->execute();
  $userinfo = $statement->fetch(PDO::FETCH_ASSOC);

  header("HTTP/1.1 200 OK");
  echo json_encode($userinfo, JSON_PRETTY_PRINT);
} catch (PDOException $pdoex) {
  returnError($pdoex);
}