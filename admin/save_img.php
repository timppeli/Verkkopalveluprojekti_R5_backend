<?php

require_once "../inc/functions.php";
require_once '../inc/headers.php';

$folderPath = "../images/";

$tuotenro = filter_input(INPUT_POST, "tuotenro");

$file_tmp = $_FILES['file']['tmp_name'];
$file_ext = strtolower(end(explode('.',$_FILES['file']['name'])));
$file = $folderPath . "tuotenro_" . $tuotenro . '.'.$file_ext;
unlink($file);
move_uploaded_file($file_tmp, $file);

print json_encode($tuotenro);
