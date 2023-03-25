<?php
$data = file_get_contents("php://input");
$data = cleanInput($data);
$sql = "INSERT INTO hookrecord (hook, hookdata)
VALUES ('Created', '$data')";
$db->query($sql);
$events = json_decode($data, true);
$dat = json_decode($data, true);
$delyva_order_id = $dat["id"];
$statusCode = $dat["statusCode"];
$sql = "SELECT * FROM job_order WHERE delyva_order_id='$delyva_order_id'";
$result = $db->query($sql);
if ($result->num_rows > 0){
	$row = $result->fetch_assoc();
	$sqlu = "UPDATE job_order SET delyva_order_status='$statusCode' WHERE delyva_order_id='$delyva_order_id'";
	$db->query($sqlu);
}else{
	$sql = "SELECT * FROM chats WHERE delyva_order_id='$delyva_order_id'";
	$result = $db->query($sql);
	if ($result->num_rows > 0){
		$sqlu = "UPDATE chats SET delyva_order_status='$statusCode' WHERE delyva_order_id='$delyva_order_id'";
		$db->query($sqlu);
	}
}
