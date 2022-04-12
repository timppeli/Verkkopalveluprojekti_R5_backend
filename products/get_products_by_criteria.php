<?php
require_once "../inc/functions.php";
require_once '../inc/headers.php';

$uri = parse_url(filter_input(INPUT_SERVER, 'PATH_INFO'), PHP_URL_PATH);
$parameters = explode("/", $uri);
$search_term = $parameters[1];

try {
    $db = openDB();

    $sql = 
    "SELECT * FROM tuote WHERE tuotenimi LIKE '%$search_term%' 
    OR tuotekuvaus LIKE '%$search_term%'";
    $query = $db->query($sql);
    $products = $query->fetchAll(PDO::FETCH_ASSOC);

    header("HTTP/1.1 200 OK");
    echo json_encode(array(
        "products" => $products
    ),JSON_PRETTY_PRINT);
} catch (PDOException $pdoex) {
    returnError($pdoex);
}
