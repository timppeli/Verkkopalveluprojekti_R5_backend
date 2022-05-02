<?php
require_once "../inc/functions.php";
require_once '../inc/headers.php';

$status = $_GET["status"];
$tilausnro = $_GET["tilausnro"];

try {
  $db = openDB();

  // Jos merkitään käsitellyksi, asetetaan käsittelyajaksi nykyhetki. Jos merkitään käsittelemättömäksi, tyhjennetään käsittelyaika
  if ($status == 1) {
    $sql = "UPDATE tilaus SET kasitelty = ?, kasittelyaika = CURRENT_TIMESTAMP WHERE tilausnro = ?";
  } else {
    $sql = "UPDATE tilaus SET kasitelty = ?, kasittelyaika = NULL WHERE tilausnro = ?";
  }
  $statement = $db->prepare($sql);
  $statement->bindParam(1, $status);
  $statement->bindParam(2, $tilausnro);
  $statement->execute();

  header("HTTP/1.1 200 OK");
} catch (PDOException $pdoex) {
  returnError($pdoex);
}
