<?php
//API Server Config
date_default_timezone_set("Asia/Kuala_Lumpur");
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

//DB Config
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "epink";
$productmargin = 35;

$itemurl = "https://localhost:8888/api/";
$domain = "https://localhost:8888/api";
$db = new mysqli($servername, $username, $password, $dbname);
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

function truncateString($str, $chars, $to_space, $replacement="...") {
   if($chars > strlen($str)) return $str;

   $str = substr($str, 0, $chars);
   $space_pos = strrpos($str, " ");
   if($to_space && $space_pos >= 0) 
       $str = substr($str, 0, strrpos($str, " "));

   return($str . $replacement);
}
function processFile($base64file){
	global $domain;
	define('UPLOAD_DIR', 'files/');
	$files = $base64file;		
	if (strpos($files, 'data:image/png;base64,') !== false) {
		$filetype = ".png";
		$files = str_replace('data:image/png;base64,', '', $files);
		$files = str_replace(' ', '+', $files);
	}
	if (strpos($files, 'data:image/jpeg;base64,') !== false) {
		$filetype = ".jpg";
		$files = str_replace('data:image/jpeg;base64,', '', $files);
		$files = str_replace(' ', '+', $files);
	}
	if (strpos($files, 'data:image/gif;base64,') !== false) {
		$filetype = ".gif";
		$files = str_replace('data:image/gif;base64,', '', $files);
		$files = str_replace(' ', '+', $files);
	}
	if (strpos($files, 'data:application/pdf;base64,') !== false) {
		$filetype = ".pdf";
		$files = str_replace('data:application/pdf;base64,', '', $files);
		$files = str_replace(' ', '+', $files);
	}
	if (strpos($files, 'data:application/docx;base64,') !== false) {
		$filetype = ".docx";
		$files = str_replace('data:application/docx;base64,', '', $files);
		$files = str_replace(' ', '+', $files);
	}	
	if (strpos($files, 'data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,') !== false) {
		$filetype = ".xlsx";
		$files = str_replace('data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,', '', $files);
		$files = str_replace(' ', '+', $files);
	}	
	$data = base64_decode($files);
	$filearea = UPLOAD_DIR . uniqid() . uniqid() . uniqid() .$filetype;
	$success = file_put_contents($filearea, $data);
	$fileurl = $domain.'/'.$filearea;
	return $fileurl;
}
function cleanInput($input){
	global $db;
	$data = strip_tags($input);
	$data = rawUrlDecode($data);
	$data = $db->real_escape_string($data);
	$data = rtrim($data);
	$data = ltrim($data);
	return $data;
}
$sqlsetting = "SELECT * FROM settings WHERE setting_item='ecarecategory'";
$resultsetting = $db->query($sqlsetting);
if ($resultsetting->num_rows > 0) {
	$rowsetting = $resultsetting->fetch_assoc();
	$ecarecategory = $rowsetting["setting_value"];
}
$sqlsetting = "SELECT * FROM settings WHERE setting_item='elabcategory'";
$resultsetting = $db->query($sqlsetting);
if ($resultsetting->num_rows > 0) {
	$rowsetting = $resultsetting->fetch_assoc();
	$elabcategory = $rowsetting["setting_value"];
}
function getUni($uid){
	global $db;
	$id = cleanInput($uid);
	$accounts_verificationsql = "SELECT * FROM accounts_verification WHERE owner='$id'";
	$accounts_verificationresult = $db->query($accounts_verificationsql);
	if ($accounts_verificationresult->num_rows > 0){
		$row = $accounts_verificationresult->fetch_assoc();
		$uni = $row["educations_place"];
		return $uni;
	} else {
		return "Not set";
	}
}
?>