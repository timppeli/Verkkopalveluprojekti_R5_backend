<?php
require_once "../inc/functions.php";
require_once '../inc/headers.php';

$newcategory = filter_input(INPUT_POST, "newcategory");

if( !isset($newcategory)) {
    echo "Parametreja puuttui. Ei voida lisätä kategoriaa";
    exit;
}

if( empty($newcategory)) {
    echo "Ei voi lisätä tyhjiä arvoja";
    exit;
}

try{
    //Suoritetaan parametrien lisääminen tietokantaan.
    $sql = "INSERT INTO tuoteryhma (trnimi) VALUES (?)";
    $statement = $pdo->prepare($sql);
    $statement->bindParam($newcategory);

    $statement->execute();

    echo "Kategoria ".$newcategory." on lisätty tietokantaan"; 
}catch(PDOException $e){
    echo "Kategoriaa ei voitu lisätä<br>";
    echo $e->getMessage();
}