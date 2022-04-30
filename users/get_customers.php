<?php
require_once "../inc/functions.php";
require_once '../inc/headers.php';

try {
    $db = openDB();
    selectAsJson($db, "SELECT * FROM asiakas");
}
catch (PDOException $pdoex) {
    returnError($pdoex);
}