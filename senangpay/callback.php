<?php
$merchant_id = '912159741991652';
$secretkey = '22424-111';
date_default_timezone_set("Asia/Kuala_Lumpur");
$servername = "localhost";
$username = "epink";
$password = "880208Limitless@";
$dbname = "admin_epink";
$itemurl = "http://localhost/eapi/";
// Create connection
$db = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($db->connect_error) {
	echo '{"api":"Fail to connect to database"}';
}
function getDistance($lat1, $lon1, $lat2, $lon2, $unit) {
  if (($lat1 == $lat2) && ($lon1 == $lon2)) {
    return 0;
  }
  else {
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);

    if ($unit == "K") {
      return ($miles * 1.609344);
    } else if ($unit == "N") {
      return ($miles * 0.8684);
    } else {
      return $miles;
    }
  }
}
function cleanInput($input){
	global $db;
	$data = strip_tags($input);
	$data = $db->real_escape_string($data);
	return $data;
}
if(isset($_POST['status_id']) && isset($_POST['order_id']) && isset($_POST['msg']) && isset($_POST['transaction_id']) && isset($_POST['hash'])){
	
	$actual_link = $_SERVER['REQUEST_URI'];
	$postarray = json_encode($_POST);
	$sqlback = "INSERT INTO callback (callback)
	VALUES ('$postarray')";
	$db->query($sqlback);	

    $hashed_string = md5($secretkey.urldecode($_POST['status_id']).urldecode($_POST['order_id']).urldecode($_POST['transaction_id']).urldecode($_POST['msg']));
	
    if($hashed_string == urldecode($_POST['hash'])){
		if(urldecode($_POST['status_id']) == '1'){
			//Start status id
			$order_id = cleanInput($_POST['order_id']);
			$sql = "SELECT * FROM senangpay WHERE id='$order_id' AND order_status='waiting'";
			$result = $db->query($sql);
			if ($result->num_rows > 0) {
				$row = $result->fetch_assoc();
				//Check the type of transaction
				
				$paymenttype = $row["type"];
				
				if($paymenttype == "wallet"){
					//The transaction is wallet top
					$userid = $row["user_id"];
					$amount = $row["amount"];
					$sqlupdatewallet = "UPDATE users SET wallet=wallet + $amount WHERE id='$userid'";
					if ($db->query($sqlupdatewallet) === TRUE) {
						$notifcationssql = "INSERT INTO notifcations (title, title_my, description, description_my, owner)
						VALUES ('Wallet Top Up', 'Wallet Top Up', 'Your top up request has been processed', 'Your top up request has been processed', '$userid')";
						$db->query($notifcationssql);
						$sqld = "UPDATE senangpay SET order_status='successfull' WHERE id='$order_id'";
						$db->query($sqld);
						echo 'OK';
					} else {
					    echo 'OK';
					}
					
				}elseif($paymenttype == "credit"){
					//The transaction is rider credit top up
					$userid = $row["user_id"];
					$amount = $row["amount"];
					$sqlupdatewallet = "UPDATE users SET rider_credit=rider_credit + $amount WHERE id='$userid'";
					if ($db->query($sqlupdatewallet) === TRUE) {
						$notifcationssql = "INSERT INTO notifcations (title, title_my, description, description_my, owner)
						VALUES ('Credit Top Up', 'Credit Top Up', 'Your credit top up request has been processed', 'Your credit top up request has been processed', '$userid')";
						$db->query($notifcationssql);
						
						$sqld = "UPDATE senangpay SET order_status='successfull' WHERE id='$order_id'";
						$db->query($sqld);
						echo 'OK';
					} else {
					 echo 'OK';
					}
					
				}else{
					//failed cart
					$userid = $row["user_id"];
					$amount = $row["amount"];
					$sqlupdatewallet = "UPDATE users SET wallet=wallet + $amount WHERE id='$userid'";
					if ($db->query($sqlupdatewallet) === TRUE) {
						$notifcationssql = "INSERT INTO notifcations (title, title_my, description, description_my, owner)
						VALUES ('Incomplete FPX/Card payment', 'Incomplete FPX/Card payment', 'Due to incomplete FPX/Card payment we have refund your payment. Please check your wallet. Please complete the whole flow before exiting the payment browser.', 'Due to incomplete FPX/Card payment we have refund your payment. Please check your wallet. Please complete the whole flow before exiting the payment browser.', '$userid')";
						$db->query($notifcationssql);
						
						$sqld = "UPDATE senangpay SET order_status='successfull' WHERE id='$order_id'";
						$db->query($sqld);
						
						echo 'OK';
					} else {
					  echo 'OK';
					}

				}
			}else{
				echo 'OK';
			}
			
			//End status id
		}else{
			echo 'OK';
		}
	}else{
	}
}
?>