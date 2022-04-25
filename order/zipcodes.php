<?php
require_once "../inc/functions.php";
require_once '../inc/headers.php';

$uri = parse_url(filter_input(INPUT_SERVER, 'PATH_INFO'), PHP_URL_PATH);
$parameters = explode("/", $uri);
$inputzip = $parameters[1];

$json = file_get_contents("zipcodes.json");
$data = json_decode($json, true);

$orderzip = array();

foreach ($data as $d) {
    if ($d["postinro"] === $inputzip) {
        $orderzip["postinro"] = $d["postinro"];
        $orderzip["toimipaikka"] = $d["toimipaikka"];
    }
}

header("HTTP/1.1 200 OK");
echo json_encode($orderzip, JSON_PRETTY_PRINT);
