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
