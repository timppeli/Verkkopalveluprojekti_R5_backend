<?php
require_once "../inc/functions.php";
require_once '../inc/headers.php';

$input = json_decode(file_get_contents("php://input"));
$trnro = filter_var($input->trnro, FILTER_SANITIZE_SPECIAL_CHARS);

try {
    $db = openDB();;

    $query = $db->prepare("DELETE FROM tuoteryhma WHERE trnro = (:trnro)");
    $query->bindValue(":trnro", $trnro, PDO::PARAM_INT);
    $query->execute();

    header("HTTP/1.1 200 OK");
    $data = array("trnro" => $trnro);
    print json_encode($data);
} catch (PDOException $pdoex) {
    returnError($pdoex);
}