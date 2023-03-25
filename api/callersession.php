<?php
//REGISTER
date_default_timezone_set("Asia/Kuala_Lumpur");
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json'); 
$servername = "localhost";
$username = "epink";
$password = "880208Limitless@";
$dbname = "admin_epink";
$productmargin = 35;
$itemurl = "https://epink.health/api/";
$domain = "https://epink.health/api";
$db = new mysqli($servername, $username, $password, $dbname);
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
function cleanInput($input){
	global $db;
	$data = strip_tags($input);
	$data = rawUrlDecode($data);
	$data = $db->real_escape_string($data);
	return $data;
}

if(isset($_POST["checkcall"]) && isset($_POST["tracker"])){
	$callerid = cleanInput($_POST["callerid"]);
	$opponentid = cleanInput($_POST["opid"]);
	$sql = "DELETE FROM callsession WHERE starter='$callerid' AND receiver='$opponentid' OR starter='$opponentid' AND receiver='$callerid'";
	if ($db->query($sql) === TRUE) {
		$sql = "INSERT INTO callsession (starter, receiver, status)
		VALUES ('$callerid', '$opponentid', 'New')";
		if ($db->query($sql) === TRUE) {
			echo "New";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	} else {
		echo "Error deleting record: " . $db->error;
	}
}

if(isset($_POST["endcall"]) && isset($_POST["tracker"])){
	$callerid = cleanInput($_POST["callerid"]);
	$opponentid = cleanInput($_POST["opid"]);
	$sql = "SELECT * FROM callsession WHERE starter='$callerid' AND receiver='$opponentid'";
	$result = $db->query($sql);
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		$sql = "UPDATE callsession SET status='Ended' WHERE starter='$callerid' AND receiver='$opponentid'";
		if ($db->query($sql) === TRUE) {
		  echo "Call Ended";
		} else {
		  echo "Error updating record: " . $db->error;
		}
	} else {
		echo "Empty";
	}
}

if(isset($_POST["endmycall"]) && isset($_POST["tracker"])){
	$opponentid = cleanInput($_POST["opid"]);
		$sql = "UPDATE callsession SET status='Ended' WHERE starter='$opponentid' OR receiver='$opponentid'";
		if ($db->query($sql) === TRUE) {
		  echo "Call Ended";
		} else {
		  echo "Error updating record: " . $db->error;
		}
}

if(isset($_POST["checkstatus"]) && isset($_POST["tracker"])){
	$callerid = cleanInput($_POST["callerid"]);
	$opponentid = cleanInput($_POST["opid"]);
	$sql = "SELECT * FROM callsession WHERE starter='$callerid' AND receiver='$opponentid'";
	$result = $db->query($sql);
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		echo $row["status"];
	} else {
		echo "Empty";
	}
}

if(isset($_POST["checkmystatus"]) && isset($_POST["tracker"])){
	$opponentid = cleanInput($_POST["opid"]);
	$sql = "SELECT * FROM callsession WHERE receiver='$opponentid' AND status='New' OR starter='$opponentid' AND status='New'";
	$result = $db->query($sql);
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		echo $row["status"];
	} else {
		echo "Ended";
	}
}
