<?php

require_once "../inc/functions.php";
require_once '../inc/headers.php';

$folderPath = "../uploads/";
    
$file_tmp = $_FILES['file']['tmp_name'];
$file_ext = strtolower(end(explode('.',$_FILES['file']['name'])));
$file = $folderPath . uniqid() . '.'.$file_ext;
move_uploaded_file($file_tmp, $file);

return json_encode(['status'=>true]);
