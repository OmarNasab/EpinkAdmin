<?php
$data = file_get_contents("php://input");
$data = cleanInput($data);
$sqls = "INSERT INTO hookrecord (hook, hookdata)
VALUES ('Update', '$data')";
$db->query($sqls);
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
	echo 'Hello';
}
