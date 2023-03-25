<?php
include("config.php");
include("speedy.php");
if (!isset($_SERVER['HTTP_X_DV_SIGNATURE'])) { 
    echo 'Error: Signature not found'; 
    exit; 
} 
 
$data = file_get_contents('php://input'); 
$signature = hash_hmac('sha256', $data, '152DB98993167801285E1BFD9378FCD989DB1122'); 
if ($signature != $_SERVER['HTTP_X_DV_SIGNATURE']) { 
    echo 'Error: Signature is not valid'; 
    exit; 
} 

echo $data; 
?>