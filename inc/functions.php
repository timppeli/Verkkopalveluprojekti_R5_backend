<?php
function openDB(): object
{
    $init = parse_ini_file("config.ini", true);
    $host = $init["host"];
    $dbname = $init["dbname"];
    $user = $init["username"];
    $password = $init["password"];
    
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8",$user,$password);
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    return $db;
}

function returnError(PDOException $pdoex): void {
    header("HTTP/1.1 500 Internal Server Error");
    $error = array("error" => $pdoex->getMessage());
    echo json_encode($error);
    exit;
}