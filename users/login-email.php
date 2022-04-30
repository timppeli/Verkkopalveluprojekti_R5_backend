<?php

require_once "../inc/functions.php";
require_once '../inc/headers.php';

// Haetaan tiedot inputista
$input = json_decode(file_get_contents("php://input"));
$salasana = filter_var($input->salasana);
$email = filter_var($input->email, FILTER_SANITIZE_EMAIL);

try {
  $db = openDB();
  $sql = "SELECT tunnus, sposti, salasana FROM kayttaja WHERE sposti = ?";
  $statement = $db->prepare($sql);
  $statement->bindParam(1, $email);
  $statement->execute();

  if ($statement->rowCount() <= 0) {
    throw new Exception("Käyttäjää ei löytynyt.");
  }

  $row = $statement->fetch(PDO::FETCH_ASSOC);

  // Tarkistetaan sähköposti varmuuden vuoksi uudestaan
  if ($email != $row["sposti"]) {
    throw new Exception("Väärä sähköpostiosoite.");
  }

  // Tarkistetaan salasana
  if (!password_verify($salasana, $row["salasana"])) {
    throw new Exception("Väärä salasana.");
  }

  // Haetaan käyttäjätunnus
  $tunnus = $row["tunnus"];

  header('HTTP/1.1 200 OK');
  $data = array('tunnus' => $tunnus, 'sposti' => $email);
  echo json_encode($data);
} catch (PDOException $pdoex) {
  returnError($pdoex);
}
