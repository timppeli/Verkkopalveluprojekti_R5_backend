<?php
require_once "../inc/functions.php";
require_once '../inc/headers.php';

$uri = parse_url(filter_input(INPUT_SERVER, 'PATH_INFO'), PHP_URL_PATH);
$parameters = explode("/", $uri);
$tunnus = $parameters[1];

try {
  $db = openDB();

  // Haetaan tilaajan tilaukset
  $sql = "SELECT tilausnro, CONCAT(SUBSTRING(tilausaika, 9, 2), '.', SUBSTRING(tilausaika, 6, 2), '.', YEAR(tilausaika), ' ', TIME(tilausaika)) as tilausaika FROM tilaus
  LEFT JOIN kayttaja ON kayttaja.asiakasnro = tilaus.asiakas_id 
  WHERE tunnus = ?";
  $statement = $db->prepare($sql);
  $statement->bindParam(1, $tunnus);
  $statement->execute();

  if ($statement->rowCount() <= 0) {
    throw new Exception("Ei tilauksia");
  }

  $orders = $statement->fetchAll(PDO::FETCH_ASSOC);
  $data = array();

  foreach ($orders as $order) {
    // Haetaan tilauksiin liittyvät tuotteet
    $sql = "SELECT tuotenro, tuotenimi, hinta, kpl FROM tuote JOIN tilausrivi ON tilausrivi.tuote_id = tuote.tuotenro WHERE tilaus_id = ?";
    $statement = $db->prepare($sql);
    $statement->bindParam(1, $order["tilausnro"], PDO::PARAM_INT);
    $statement->execute();
    $products = $statement->fetchAll(PDO::FETCH_ASSOC);

    $order["tuotteet"] = $products;
    $order_id = $order['tilausnro'];

    // Haetaan tilauksen loppusumma
    $sql = "SELECT SUM(hinta * kpl) AS 'loppusumma' FROM tuote
  LEFT JOIN tilausrivi ON tilausrivi.tuote_id = tuote.tuotenro
  LEFT JOIN tilaus ON tilausrivi.tilaus_id = tilaus.tilausnro
  WHERE tilausnro = $order_id";
    $query = $db->query($sql);
    $total = $query->fetch(PDO::FETCH_ASSOC)["loppusumma"];
    
    $order["loppusumma"] = $total;

    // Pusketaan kaikki tiedot lopulliseen tilaustaulukkoon
    $data[] = $order;
  }

  header("HTTP/1.1 200 OK");
  echo json_encode($data, JSON_PRETTY_PRINT);
} catch (PDOException $pdoex) {
  returnError($pdoex);
}
