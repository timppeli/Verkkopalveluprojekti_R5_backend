<?php
require_once "inc/functions.php";
require_once 'inc/headers.php';

try {
    openDB();
    echo "Yhteys tietokantaan muodostettu!";
}
catch (PDOException $pdoex) {
    returnError($pdoex);
}