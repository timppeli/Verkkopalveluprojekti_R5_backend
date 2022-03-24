<?php
$init = parse_ini_file("config.ini");
$host = $init["host"];
$db = $init["dbname"];
$user = $init["username"];
$password = $init["password"];

$dsn = "mysql:host=$host;dbname=$db;charset=UTF8";
try {
    $pdo = new PDO($dsn, $user, $password);
    echo "Yhteys tietokantaan <b>" . $db . "</b> onnistui";
} catch (PDOException $e) {
    echo $e->getMessage();
}