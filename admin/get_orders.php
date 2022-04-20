<?php
require_once "../inc/functions.php";
require_once '../inc/headers.php';

try {
  $db = openDB();

  // Haetaan tilausten tiedot
  $sql = "SELECT tilausnro, CONCAT(SUBSTRING(tilausaika, 9, 2), '.', SUBSTRING(tilausaika, 6, 2), '.', YEAR(tilausaika), ' ', TIME(tilausaika)) as tilausaika, kasitelty, asiakas_id FROM tilaus";
  $statement = $db->prepare($sql);
  $statement->execute();

  if ($statement->rowCount() <= 0) {
    throw new Exception("Ei tilauksia");
  }

  $orders = $statement->fetchAll(PDO::FETCH_ASSOC);
  $data = array();

  foreach ($orders as $order) {
    // Asiakas
    $sql = "SELECT etunimi, sukunimi, sposti, osoite, postinro, postitmp FROM asiakas WHERE asiakasnro = ?";
    $statement = $db->prepare($sql);
    $statement->bindParam(1, $order["asiakas_id"], PDO::PARAM_INT);
    $statement->execute();
    $customer = $statement->fetch(PDO::FETCH_ASSOC);

    $order["asiakastiedot"] = $customer;

    // Tuotteet
    $sql = "SELECT tuotenro, tuotenimi, kpl FROM tuote JOIN tilausrivi ON tilausrivi.tuote_id = tuote.tuotenro WHERE tilaus_id = ?";
    $statement = $db->prepare($sql);
    $statement->bindParam(1, $order["tilausnro"], PDO::PARAM_INT);
    $statement->execute();
    $products = $statement->fetchAll(PDO::FETCH_ASSOC);

    $order["tuotteet"] = $products;

    // Pusketaan kaikki tiedot lopulliseen tilaustaulukkoon
    $data[] = $order;
  }

  // Tarkistetaan että tilauksia on
  if ($data == []) {
    throw new Exception("Ei tilauksia");
  }

  header("HTTP/1.1 200 OK");
  echo json_encode($data, JSON_PRETTY_PRINT);
} catch (PDOException $pdoex) {
  throw $pdoex;
  echo $pdoex;
}
