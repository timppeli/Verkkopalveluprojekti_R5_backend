<?php

require_once "../inc/functions.php";
require_once '../inc/headers.php';

// Haetaan tiedot inputista
$input = json_decode(file_get_contents("php://input"));
$salasana = filter_var($input->salasana);
$tunnus = filter_var($input->tunnus, FILTER_SANITIZE_SPECIAL_CHARS);

try {
  $db = openDB();

  $sql = "SELECT tunnus, salasana FROM kayttaja WHERE tunnus = ?";
  $statement = $db->prepare($sql);
  $statement->bindParam(1, $tunnus);
  $statement->execute();

  if ($statement->rowCount() <= 0) {
    throw new Exception("Käyttäjää ei löytynyt.");
  }

  $row = $statement->fetch(PDO::FETCH_ASSOC);

  // Tarkistetaan tunnus varmuuden vuoksi uudestaan
  if ($tunnus != $row["tunnus"]) {
    throw new Exception("Väärä käyttäjätunnus.");
  }

  // Tarkistetaan salasana
  if (!password_verify($salasana, $row["salasana"])) {
    throw new Exception("Väärä salasana.");
  }

  header('HTTP/1.1 200 OK');
  $data = array('tunnus' => $tunnus);
  echo json_encode($data);
} catch (PDOException $pdoex) {
  returnError($pdoex);
}
