<?php
require_once "../inc/functions.php";
require_once "../inc/headers.php";
require_once "sql-variables.php";

try {
  // Connect to localhost
  $pdo = connectToLocalhost();

  // Create database
  $sql = "DROP DATABASE IF EXISTS kukkakauppa; CREATE DATABASE kukkakauppa;";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();

  // Connect to the newly created database
  $pdo = openDB();

  // Array for queries
  $queries = array();

  // Create tables
  array_push($queries, $tablesSQL);

  // Insert dummy data
  array_push($queries, $dummydataSQL);

  // Execute queries
  foreach ($queries as $query) {
    $stmt = $pdo->prepare($query);
    $stmt->execute();
  }

  echo "Tietokanta palautettu aloitusdatatilaan.";
} catch (PDOException $pdoex) {
  throw $pdoex;
  echo $pdoex;
}

try {
  // Connect to db
  $pdo = openDB();

  // Add admin
  $tunnus = "admin";
  $salasana = "admininsalasana";
  $email = "admin@vihervaja.com";
  
  $sql = "INSERT INTO kayttaja (tunnus, salasana, sposti) VALUES (?, ?, ?)";
  $statement = $pdo->prepare($sql);
  $statement->bindParam(1, $tunnus);
  $hash_pw = password_hash($salasana, PASSWORD_DEFAULT);
  $statement->bindParam(2, $hash_pw);
  $statement->bindParam(3, $email);
  $statement->execute();

  echo " Admin-tunnukset lisätty.";
} catch (PDOException $pdoex) {
  throw $pdoex;
  echo $pdoex;
}

try {
  // Connect to db
  $pdo = openDB();

  // Add Matti
  $tunnus = "matti";
  $salasana = "matti";
  $email = "matti.meikalainen@meikalainen.com";
  $asiakas_id = 1;
  
  $sql = "INSERT INTO kayttaja (tunnus, salasana, sposti, asiakasnro) VALUES (?, ?, ?, ?)";
  $statement = $pdo->prepare($sql);
  $statement->bindParam(1, $tunnus);
  $hash_pw = password_hash($salasana, PASSWORD_DEFAULT);
  $statement->bindParam(2, $hash_pw);
  $statement->bindParam(3, $email);
  $statement->bindParam(4, $asiakas_id);
  $statement->execute();

  echo " Matti Meikäläinen lisätty.";
} catch (PDOException $pdoex) {
  throw $pdoex;
  echo $pdoex;
}
