<?php
require_once "inc/functions.php";
require_once 'inc/headers.php';

try {
    $db = openDB();
    selectAsJson($db, "SELECT * FROM tuoteryhma");
}
catch (PDOException $pdoex) {
    returnError($pdoex);
}