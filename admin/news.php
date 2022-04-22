<?php
require_once "../inc/functions.php";
require_once '../inc/headers.php';

try {
    $db = openDB();
  
    // Haetaan uutisten tiedot
$sql = "SELECT id, otsikko, pvm, viesti FROM uutiset";
$statement = $db->prepare($sql);
  $statement->execute();


?>

