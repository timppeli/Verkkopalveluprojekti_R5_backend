<?php
require_once "../inc/functions.php";
require_once '../inc/headers.php';

try {
  $db = openDB();
  // Haetaan tilausten määrä
  $sql = "SELECT COUNT(tilausnro) AS count FROM tilaus";
  $query = $db->query($sql);
  $numOfOrders = $query->fetch(PDO::FETCH_ASSOC)["count"];

  $ordersArray = array();

  for ($i = 1; $i <= $numOfOrders; $i++) {
    // Haetaan tilaus
    $sql = "SELECT tilausnro, tilausaika, kasitelty FROM tilaus WHERE tilausnro = $i";
    $query = $db->query($sql);
    $order = $query->fetch(PDO::FETCH_ASSOC);

    // Haetaan tilausrivien määrä
    $sql = "SELECT COUNT(*) AS count FROM tilausrivi
    LEFT JOIN tilaus ON tilausrivi.tilaus_id = tilaus.tilausnro";
    $query = $db->query($sql);
    $numOfRows = $query->fetch(PDO::FETCH_ASSOC)["count"];

    // Loopataan tilausrivien läpi
    for ($j = 0; $j < $numOfRows; $j++) {
      // Haetaan tilatut tuotteet
      $sql = "SELECT tuotenro, tuotenimi, kpl FROM tuote
    LEFT JOIN tilausrivi ON tilausrivi.tuote_id = tuote.tuotenro
    LEFT JOIN tilaus ON tilaus.tilausnro = tilausrivi.tilaus_id WHERE tilausnro = $i";
      $query = $db->query($sql);
      $products = $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Haetaan asiakastiedot
    $sql = "SELECT asiakasnro, etunimi, sukunimi, osoite, postinro, postitmp FROM asiakas, tilaus WHERE asiakas.asiakasnro = tilaus.asiakas_id AND asiakasnro = $i";
    $query = $db->query($sql);
    $customer = $query->fetch(PDO::FETCH_ASSOC);

    
    // Lisätään tuotteet ja asiakastiedot tilaukseen
    $order["tuotteet"] = $products;
    $order["tilaaja"] = $customer;

    // Lisätään tilaus tilaustaulukkoon
    array_push($ordersArray, $order);
  }

  header("HTTP/1.1 200 OK");
  echo json_encode($ordersArray, JSON_PRETTY_PRINT);
} catch (PDOException $pdoex) {
  returnError($pdoex);
}
