<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json'); 

$application_id = 5541;
$auth_key = "EKVj4mcNayC3cPF";
$authSecret = "vNZZEYh5-V9UacN";

$nonce = rand();
//echo "<br>nonce: " . $nonce;

$timestamp = time();
//echo "<br>timestamp: " . $timestamp ."<br>";

$stringForSignature = "application_id=".$application_id."&auth_key=".$auth_key."&nonce=".$nonce."&timestamp=".$timestamp;
//echo $stringForSignature."<br>";

$signature = hash_hmac('sha1', $stringForSignature , $authSecret);
echo $signature;

?>