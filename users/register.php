<?php

require_once "../inc/functions.php";
require_once '../inc/headers.php';

// Haetaan tiedot inputista
$input = json_decode(file_get_contents("php://input"));
$etunimi = filter_var($input->etunimi, FILTER_SANITIZE_SPECIAL_CHARS);
$sukunimi = filter_var($input->sukunimi, FILTER_SANITIZE_SPECIAL_CHARS);
$salasana = filter_var($input->salasana);
$email = filter_var($input->email, FILTER_SANITIZE_EMAIL);

try {
  $db = openDB();

  // Generoidaan käyttäjätunnus nimistä
  $tunnus = strtolower(substr($sukunimi, 0, 4)) . strtolower(substr($etunimi, 0, 3)) . rand();

  $db->beginTransaction();
  
  // Lisätään lähtötiedot asiakastauluun
  $sql = "INSERT INTO asiakas (etunimi, sukunimi, sposti) VALUES (?, ?, ?)";
  $statement = $db->prepare($sql);
  $statement->bindParam(1, $etunimi, PDO::PARAM_STR);
  $statement->bindParam(2, $sukunimi, PDO::PARAM_STR);
  $statement->bindParam(3, $email, PDO::PARAM_STR);
  $statement->execute();
  $customer_id = $db->lastInsertId(); // id seuraavaan vaiheeseen

  // Lisätään uusi käyttäjä
  $sql = "INSERT INTO kayttaja (tunnus, salasana, sposti, asiakasnro) VALUES (?, ?, ?, ?)";
  $statement = $db->prepare($sql);
  $statement->bindParam(1, $tunnus, PDO::PARAM_STR);
  $hash_pw = password_hash($salasana, PASSWORD_DEFAULT);
  $statement->bindParam(2, $hash_pw);
  $statement->bindParam(3, $email, PDO::PARAM_STR);
  $statement->bindParam(4, $customer_id, PDO::PARAM_INT);
  $statement->execute();

  $db->commit();

  header('HTTP/1.1 200 OK');
  $data = array('tunnus' => $tunnus, 'etunimi' => $etunimi, 'asiakasnro' =>  $customer_id, 'salasana' => $salasana);
  echo json_encode($data);
} catch (PDOException $pdoex) {
  $db->rollback();
  returnError($pdoex);
}
