<?php
$data = file_get_contents("php://input");
$datas = cleanInput($datas);
$sql = "INSERT INTO hookrecord (hook, hookdata)
VALUES ('Tracking', '$datas')";
$db->query($sql);
$dat = json_decode($data);
$delyva_order_id = $dat->orderId;
$statusCode = $dat->statusCode;
$sql = "SELECT * FROM job_order WHERE delyva_order_id='$delyva_order_id'";
$result = $db->query($sql);
if ($result->num_rows > 0){
	$row = $result->fetch_assoc();

	if($statusCode == 700){
		$sqlu = "UPDATE job_order SET order_status='Completed', delyva_order_status='$statusCode' WHERE delyva_order_id='$delyva_order_id'";
		$db->query($sqlu);
	}elseif($statusCode == 600){
		$sqlu = "UPDATE job_order SET order_status='Delivering', delyva_order_status='$statusCode' WHERE delyva_order_id='$delyva_order_id'";
		$db->query($sqlu);
	}elseif($statusCode == 400){
		$sqlu = "UPDATE job_order SET order_status='Accepted', delyva_order_status='$statusCode' WHERE delyva_order_id='$delyva_order_id'";
		$db->query($sqlu);
	}else{
		$sqlu = "UPDATE job_order SET delyva_order_status='$statusCode' WHERE delyva_order_id='$delyva_order_id'";
		$db->query($sqlu);
	}
}else{
	$sql = "SELECT * FROM chats WHERE delyva_order_id='$delyva_order_id'";
	$result = $db->query($sql);
	if ($result->num_rows > 0){
		if($statusCode == "700"){
			$sqlu = "UPDATE chats SET delivery_completed='Completed', delyva_order_status='$statusCode' WHERE delyva_order_id='$delyva_order_id'";
			$db->query($sqlu);
		}elseif($statusCode == "600"){
			$sqlu = "UPDATE chats SET delivery_completed='Delivering', delyva_order_status='$statusCode' WHERE delyva_order_id='$delyva_order_id'";
			$db->query($sqlu);
		}else{
			$sqlu = "UPDATE chats SET delyva_order_status='$statusCode' WHERE delyva_order_id='$delyva_order_id'";
			$db->query($sqlu);
		}
	}
}
