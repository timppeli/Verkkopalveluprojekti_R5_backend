<?php
require_once "../inc/functions.php";
require_once '../inc/headers.php';

$uri = parse_url(filter_input(INPUT_SERVER, 'PATH_INFO'), PHP_URL_PATH);
$parameters = explode("/", $uri);
$order_id = $parameters[1];

try {
  $db = openDB();
  // Haetaan tilaus
  $sql = "SELECT tilausnro FROM tilaus WHERE tilausnro = $order_id";
  $query = $db->query($sql);
  $order = $query->fetch(PDO::FETCH_ASSOC)["tilausnro"];

  // Haetaan tilatut tuotteet
  $sql = "SELECT tuotenimi, hinta, kpl, hinta * kpl AS 'tuotesumma' FROM tuote
  LEFT JOIN tilausrivi ON tilausrivi.tuote_id = tuote.tuotenro
  LEFT JOIN tilaus ON tilausrivi.tilaus_id = tilaus.tilausnro
  WHERE tilausnro = $order_id";
  $query = $db->query($sql);
  $products = $query->fetchAll(PDO::FETCH_ASSOC);

  // Haetaan tilauksen loppusumma
  $sql = "SELECT SUM(hinta * kpl) AS 'loppusumma' FROM tuote
  LEFT JOIN tilausrivi ON tilausrivi.tuote_id = tuote.tuotenro
  LEFT JOIN tilaus ON tilausrivi.tilaus_id = tilaus.tilausnro
  WHERE tilausnro = $order_id";
  $query = $db->query($sql);
  $total = $query->fetch(PDO::FETCH_ASSOC)["loppusumma"];

  // Haetaan tilaajan tiedot
  $sql = "SELECT etunimi, sukunimi, osoite, postinro, postitmp FROM asiakas
  LEFT JOIN tilaus ON asiakas.asiakasnro = tilaus.asiakas_id
  WHERE tilausnro = $order_id";
  $query = $db->query($sql);
  $customer = $query->fetch(PDO::FETCH_ASSOC);

  header("HTTP/1.1 200 OK");
  echo json_encode(array(
    "order" => $order,
    "products" => $products,
    "total" => $total,
    "customer" => $customer
  ), JSON_PRETTY_PRINT);
} catch (PDOException $pdoex) {
  returnError($pdoex);
}