<?php
require_once "inc/functions.php";
require_once 'inc/headers.php';

try {
    openDB();
    echo "Yhteys tietokantaan muodostettu!<br><br><br>";
}
catch (PDOException $pdoex) {
    returnError($pdoex);
}