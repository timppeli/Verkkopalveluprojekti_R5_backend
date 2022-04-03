<?php
require_once "../inc/functions.php";
require_once '../inc/headers.php';

$input = json_decode(file_get_contents("php://input"));
$trnimi = filter_var($input->trnimi, FILTER_SANITIZE_SPECIAL_CHARS);

try {
  $db = openDB();

  $query = $db->prepare("INSERT INTO tuoteryhma (trnimi) VALUES (:trnimi)");
  $query->bindValue(":trnimi", $trnimi, PDO::PARAM_STR);
  $query->execute();

  header("HTTP/1.1 200 OK");
  $data = array("id" => $db->lastInsertId(), "trnimi" => $trnimi);
  print json_encode($data);
} catch (PDOException $pdoex) {
  header('HTTP/1.1 500 Internal Servel Error');
  $error = array('error' => $pdoex->getMessage());
  print json_encode($error);
}