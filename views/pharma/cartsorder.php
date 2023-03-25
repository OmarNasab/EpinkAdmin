<?php
include("./api/speedy.php");
$pid = cleanInput($final_identifier);
function checkDoc($id){
	global $db;
	$sql = "SELECT * FROM users WHERE id='$id'";
	$result = $db->query($sql);
	if ($result->num_rows > 0){
		if($row["type"] == 6){
			return true;
		}else{
			return false;
		}
	} else {
		return false;
	}
}
function sendNotification($owner, $title, $message){
	global $db;
	$message = cleanInput($message);
	$title = cleanInput($title);
	$owner = cleanInput($owner);
	$notifcationssql = "INSERT INTO notifcations (title, title_my, description, description_my, owner) VALUES ('$title', '$title', '$message', '$message', '$owner')";
	if ($db->query($notifcationssql) === TRUE) {
		$row["card"] = "green";
		$row["status"] = "Successful";
		$row["message"] =  "New record successfully created";
		$data = $row;
	} else {
		$row["card"] = "red";
		$row["status"] = "Fail";
		$row["message"] =  "Error: " . $sql . "<br>" . $db->error;
		$data = $row;
	}
}
function insertTransaction($from_user, $to_user, $amount, $tnote){
	global $db, $currentdatetime;
	$transaction_historysql = "INSERT INTO transaction_history (from_user, to_user, amount, transaction_date, transaction_note) VALUES ('$from_user', '$to_user', '$amount', '$currentdatetime', '$tnote')";
	$db->query($transaction_historysql);
}
function getsimpleProfile($id){
	global $db;
	$userid = $db->real_escape_string($id);
	$sql = "SELECT id, firstname, lastname, profile_img, type, ic_number, phonenumber, lat, lng, id_token FROM users WHERE id='$userid'";
	$result = $db->query($sql);
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		$row["status"] = "success";
		if($row["type"] == "6"){
			$row["fee"] = 20;
			$row["full_name"] = $row["firstname"].' '.$row["lastname"];
		}else{
			$row["full_name"] = $row["firstname"].' '.$row["lastname"];
		}
		return $row;
	} else {
		$row["full_name"] = "This user no longer exist";
		return $row;
	}
}


if(isset($_POST["cancelOrder"])){
		$id = cleanInput($_POST["cancelOrder"]);
		$sql = "SELECT * FROM job_order WHERE id='$id'";
		$result = $db->query($sql);
		
		if ($result->num_rows > 0){
			$row = $result->fetch_assoc();
			$vendorprofile = getVendorprofile($row["restaurant_id"]);
			$row["patient_profile"] = getsimpleProfile($row["owner"]);
			$patient = $row["patient_profile"];
			$orderdata = json_decode($row["data"]);
			$patient["patient_delivery_address"] = $orderdata->delivery_address;
			include("api/delyva.php");
			$delyva = new Delyva;
			$accessToken = $delyva->auth();
			$delyvaorderid = $row["delyva_order_id"];
			$delyva_service_code = $row["delyva_service_code"];
			$process = $delyva->cancelOrder($delyvaorderid);
			$sql = "UPDATE job_order SET order_status='Canceled' WHERE id='$id'";

			if ($db->query($sql) === TRUE) {
			  $res =  "Order has been canceled";
			} else {
			  $res = "Error updating record: " . $conn->error;
			}
		}else{
			$row["card"] = "red";
			$row["status"] = "Fail";
			$row["message"] = "Order not found";
			$data = $row;
		}
}
if(isset($_POST["checkDeliveryPartner"])){
	$id = cleanInput($_POST["checkDeliveryPartner"]);
	$sql = "SELECT * FROM job_order WHERE id='$id'";
	$result = $db->query($sql);
	if ($result->num_rows > 0){
		$row = $result->fetch_assoc();
		include("api/delyva.php");
		$delyva = new Delyva;
		$accessToken = $delyva->auth();
		$delyvaorderid = $row["delyva_order_id"];
		$delyva_service_code = $row["delyva_service_code"];
		$process = $delyva->getOrderDetail($delyvaorderid);
		$res = json_encode($process, JSON_PRETTY_PRINT);
	}
}
if(isset($_POST["setPrepared"])){
		$id = cleanInput($_POST["setPrepared"]);
		$sql = "SELECT * FROM job_order WHERE id='$id'";
		$result = $db->query($sql);
		
		if ($result->num_rows > 0){
			$row = $result->fetch_assoc();
			$vendorprofile = getVendorprofile($row["restaurant_id"]);
			$row["patient_profile"] = getsimpleProfile($row["owner"]);
			$patient = $row["patient_profile"];
			$orderdata = json_decode($row["data"]);
			$patient["patient_delivery_address"] = $orderdata->delivery_address;
			$sql = "UPDATE job_order SET order_status='Ready for pickup' WHERE  id='$id' ";
					if ($db->query($sql) === TRUE) {
						$row["card"] = "green";
						$row["status"] = "Successfull";
						if($row["deliverytype"] == "pickup"){
							$row["message"] = "Ready for customer pick up";
						}else{
							if($row["delyva_service_code"] != "" || $row["delyva_service_code"] != null){
								include("api/delyva.php");
								$delyva = new Delyva;
								$accessToken = $delyva->auth();
								$delyvaorderid = $row["delyva_order_id"];
								$delyva_service_code = $row["delyva_service_code"];
								$process = $delyva->processOrder($delyvaorderid, $delyva_service_code);
								$row["message"] = "Delivery partner has been notified";
								$res = json_encode($process, JSON_PRETTY_PRINT);
								$res = $process->status;
								
							}else{
								$res = "Ready for pick up";
							}
							
						}
						
					
					} else {
							$row["card"] = "red";
							$row["status"] = "Fail";
							$row["message"] = "Error updating record: " . $db->error;
							$data = $row;
					}
			/* include("api/delyva.php");
			$delyva = new Delyva;
			$accessToken = $delyva->auth();
			$delyvaorderid = $row["delyva_order_id"];
			$delyva_service_code = $row["delyva_service_code"];
			$process = $delyva->processOrder($delyvaorderid, $delyva_service_code);
			//$process = $delyva->orderHook($delyvaorderid);
			//$process = $delyva->getOrderDetail($delyvaorderid); */
			$res = json_encode($process, JSON_PRETTY_PRINT);
		}else{
			$row["card"] = "red";
			$row["status"] = "Fail";
			$row["message"] = "Order not found";
			$data = $row;
		}
}
if(isset($_POST["setselfpickupfinish"])){
	$storeorderid = cleanInput($_POST["setselfpickupfinish"]);
	$sql = "SELECT * FROM job_order WHERE id='$storeorderid'";
	$result = $db->query($sql);
	if ($result->num_rows > 0){
		$row = $result->fetch_assoc();
		$rid = $row["restaurant_id"];
		$customerid = $row["owner"];
		$cart_price = $row["cart_price"];
		$sqld = "UPDATE job_order SET order_status='Completed' WHERE id='$storeorderid' AND order_status ='New'";
		if ($db->query($sqld) === TRUE){
			$sqlx = "UPDATE users SET wallet=wallet+'$cart_price' WHERE id='$rid'";
			if ($db->query($sqlx) === TRUE) {
				$row["status"] = "successfull";
				$row["message"] = "Update order status";
				$data = $row;
				insertTransaction($patientid, $rid, $serviceproviderrate, "Tele consultation fee");
				sendNotification($spid, 'Payment received', 'You have recieved RM'.$cart_price.'. Please check your wallet.');
				$sqlx = "UPDATE users SET wallet=wallet-'$cart_price' WHERE id='$customerid'";
				if ($db->query($sqlx) === TRUE) {
					$row["status"] = "successfull";
					$row["message"] = "Update order status";
					$data = $row;
					insertTransaction($patientid, $rid, $serviceproviderrate, "Purchase");
					sendNotification($spid, 'Payment received', 'You have recieved RM'.$cart_price.'. Please check your wallet.');
				}else{
					$row["status"] = "fail";
					$row["message"] = "Fail to update order";
					$data = $row;
				}
			}else{
				$row["status"] = "fail";
				$row["message"] = "Fail to update order";
				$data = $row;
			}
		} else {
			$row["status"] = "fail";
			$row["message"] = "Fail to update order";
			$data = $row;
		}
	}
}
if(isset($_POST["setcomplete"])){
	$sql = "SELECT * FROM job_order WHERE id='$pid'";
	$result = $db->query($sql);
	if ($result->num_rows > 0){
		$row = $result->fetch_assoc();
		$vendorprofile = getVendorprofile($row["restaurant_id"]);
		$row["patient_profile"] = getsimpleProfile($row["owner"]);
		$patient = $row["patient_profile"];
		$orderdata = json_decode($row["data"]);
		$sql = "UPDATE job_order SET order_status='Completed' WHERE id='$pid'";
		if ($db->query($sql) === TRUE) {
			$row["card"] = "green";
			$row["status"] = "Successfull";
			$res = "The order has been completed successfully";
			$data = $row;
		} else {
			$row["card"] = "red";
			$row["status"] = "Fail";
			$row["message"] = "Error updating record: " . $db->error;
			$res = "Error updating record: " . $db->error;
			$data = $row;
		}
	}else{
		
	}
}	


if(isset($_POST["setprepareddd"])){
	$sql = "SELECT * FROM job_order WHERE id='$pid'";
	$result = $db->query($sql);

	if ($result->num_rows > 0){
		$row = $result->fetch_assoc();
		$vendorprofile = getVendorprofile($row["restaurant_id"]);
		$row["patient_profile"] = getsimpleProfile($row["owner"]);
		$patient = $row["patient_profile"];
		$orderdata = json_decode($row["data"]);
		$patient["patient_delivery_address"] = $orderdata->delivery_address;
			
		$make = json_decode(requestSpeedy($patient["full_name"], $patient["phonenumber"], $patient["patient_delivery_address"], $vendorprofile["vendor_name"], $vendorprofile["phonenumber"], $vendorprofile["vendor_address"], '$id'));
		$res = $make->is_successful;
		$res = false;
		if($res == true){
						$row["speedyinfo"] = $make;
						$speedyorderid = $make->order->order_id;
						$sql = "UPDATE job_order SET order_status='3rd Party', speedy_order_id='$speedyorderid' WHERE id='$id'";
						if ($db->query($sql) === TRUE) {
							$row["card"] = "green";
							$row["status"] = "Successfull";
							$row["message"] = "The record has been updated successfully";
							$data = $row;
						} else {
							$row["card"] = "red";
							$row["status"] = "Fail";
							$row["message"] = "Error updating record: " . $db->error;
							$data = $row;
						}
		}else{
				$sql = "UPDATE job_order SET order_status='Ready for pickup' WHERE id='$pid'";
				if ($db->query($sql) === TRUE) {
							$row["card"] = "green";
							$row["status"] = "Successfull";
							$res = "Looking for epink rider -".$pid;
							$data = $row;
				} else {
							$row["card"] = "red";
							$row["status"] = "Fail";
							$res = "Error updating record: " . $db->error;
							$data = $row;
						}
				}
			
	}else{
			$row["card"] = "red";
			$row["status"] = "Fail";
			$row["message"] = "Order not found";
			$data = $row;
	}
}

	$job_ordersql = "SELECT * FROM job_order WHERE id='$pid'";
	$job_orderresult = $db->query($job_ordersql);
	if ($job_orderresult->num_rows > 0){
		$row = $job_orderresult->fetch_assoc();
		$row["patient_profile"] = getsimpleProfile($row["owner"]);
		$row["patientprofilepicture"] = $row["patient_profile"]["profile_img"];
		$job_orderdata = $row;
	} else {
		$row["card"] = "red";
		$row["status"] = "Fail";
		$row["message"] = "The record you looking for does not exist<script>window.location.href= ''.$domain.'/404';</script>";
		$data = $row;
	}
?>
<header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
	<div class="container-xl px-4">
		<div class="page-header-content">
			<div class="row align-items-center justify-content-between pt-3">
				<div class="col-auto mb-3">
					<h1 class="page-header-title">
						<div class="page-header-icon"><i data-feather="box"></i></div>
						Manage Order (ID: <?php echo $pid; ?>)
					</h1>
				</div>
				<div class="col-12 col-xl-auto mb-3">  
					<a class="btn btn-sm btn-light text-primary" href="<?php echo $domain; ?>/pharmacy-panel/orders/purchase-order/">Back</a>    
                </div>
			</div>
		</div>
	</div>
</header>
<div class="container-xl px-4">
<?php
	if (isset($res)) {
		echo '<div class="card mb-4"><div class="card-body">' . $res . '</div></div>';
	}
?>
<div class="card mb-3">
	<div class="card-header">
		<span class="text-black">Customer Detail </span>
		<span class="text-black float-end"><?php echo $job_orderdata["order_date"]; ?> </span>
		
	</div>
	<div class="card-body">
		<div class="row">
			<div class="col-4">
				<img src="<?php echo $row["patientprofilepicture"]; ?>" class="img-fluid">
			</div>
			<div class="col-8 text-sm">
				<p><b>Order ID:</b> <?php echo $job_orderdata["id"]; ?></p>
				<p><b>Payment Method:</b> <?php echo $job_orderdata["payment_type"]; ?></p>
				<p><b>Amount To Pay:</b> RM<?php echo $job_orderdata["cart_price"]; ?>(PAID)</p>
				<p><b>Delivery Type:</b> <?php if($job_orderdata["deliverytype"] == "pickup"){ echo 'Self Pick Up'; }else{ echo 'Request Delivery'; } ?></p>
			</div>
		</div>
		
	</div>
</div>
	
<div class="card mb-3">
	<div class="card-header"><span class="text-black">Purchased Item</span></div>
	<div class="card-body">
<table class="table">
  <thead>
    <tr>
      <th scope="col-1">#</th>
      <th scope="col-5">Item</th>
      <th scope="col-3">Quantity</th>
      <th scope="col-3">Price</th>
    </tr>
  </thead>
  <tbody>
    <tr>
     <?php
		$jobdata = json_decode($job_orderdata["data"]);
		$cartitem = $jobdata->cartitem;
		
		$itemcount = COUNT($cartitem);
		
			$count = 1;
		for ($x = 0; $x < $itemcount; $x++) {
			$quantity = round($cartitem[$x]->quantity, 0);
			echo '
			<tr>
				<th scope="row">'.$count.'</th>
				<td>'.$cartitem[$x]->product_name.'</td>
				<td>'.$quantity.'</td>
				<td>RM'.$cartitem[$x]->originalprice.'</td>
			</tr>
			';
			$count++;
			
		}
	?>
    </tr>
  </tbody>
</table>
	
	</div>
</div>
<div class="card mb-3">
	<div class="card-header"><span class="text-black">Action</span></div>
	<div class="card-body">
	<?php
	if(isset($process)){
		echo '<pre>';
		echo json_encode($process, JSON_PRETTY_PRINT);
		echo '</pre>';
	}
	?>
	<?php 
	if($job_orderdata["deliverytype"] == "pickup"){ 
		if($job_orderdata["order_status"] == "New"){
			echo '
			<form method="POST">
				<button type="submit" name="setselfpickupfinish" id="setselfpickupfinish" value="'.$job_orderdata["id"].'" class="btn btn-primary">SET COMPLETE</button>
			</form>
			<p>Set this order complete as soon the customer pick up the item</p>
			';
		}
		if($job_orderdata["order_status"] == "Completed"){
			echo '
			<p>Order completed and the items has been picked up by the customer</p>
			';
		}
		
	}else{
		if($job_orderdata["order_status"] == "New"){
			echo '
			<div class="row">
				<div class="col-2">
					<form method="POST">
						<button type="submit" name="setPrepared" id="setPrepared" value="'.$job_orderdata["id"].'" class="btn btn-primary">SET PREPARED</button>
					</form>	
				</div>
				<div class="col-2">
					<form method="POST">
						<button type="submit" name="cancelOrder" id="cancelOrder" value="'.$job_orderdata["id"].'" class="btn btn-primary">Cancel</button>
					</form>
				</div>
			</div>
			';
		}
		
		if($job_orderdata["order_status"] == "Ready for pickup"){
			if($job_orderdata["delyva_order_id"] != ""){
				echo '
				<div class="row">
					<div class="col-12">
						<form method="POST">
							<button type="submit" name="checkDeliveryPartner" id="checkDeliveryPartner" value="'.$job_orderdata["id"].'" class="btn btn-primary">Check Delivery Status</button>
						</form>
					</div>
				</div>
				';
			}else{
				echo '
				<div class="row">
					<div class="col-12">
						Our delivery partner is on the way to pick up the customer order
					</div>
				</div>
				';
			}
		}
		
		if($job_orderdata["order_status"] == "Completed"){
			echo '
				<div class="row">
					<div class="col-12">
						Delivery Completed
					</div>
				</div>
				';
		}
		
		if($job_orderdata["order_status"] != "Ready for pickup" || $job_orderdata["order_status"] != "New" || $job_orderdata["order_status"] != "Completed"){
			echo '
				<div class="row">
					<div class="col-12">
						Delivery in progress
					</div>
				</div>
				';
		}
	} 
	?>
	</div>
</div>
			