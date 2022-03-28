<?php
require_once "inc/functions.php";
require_once 'inc/headers.php';

$id = $_GET["id"];

if( !isset($id) ){
    echo "Parametreja puuttui";
    exit;
}

$SQL = "SELECT * FROM tuote";

if($id > 0){
    $SQL = "SELECT * FROM tuote WHERE trnro = " . $id;
}

try {
    $db = openDB();
    selectAsJson($db, $SQL);
}
catch (PDOException $pdoex) {
    returnError($pdoex);
}
