<?php
include("api/speedy.php");
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
function calculatePrescirbedMedication($prescritionsdata){
	$medications = json_decode($prescritionsdata);
	$medicationscount = count($medications);
	$allitemprice = 0.00;
	for ($x = 0; $x < $medicationscount; $x+=10) {
		$allitemprice = $allitemprice + $medications[$x]->originalprice;
	}
	return $allitemprice;
}
function getsimpleProfile($id){
	global $db;
	$userid = $db->real_escape_string($id);
	$sql = "SELECT id, firstname, lastname, profile_img, type, ic_number, phonenumber, lat, lng, id_token, date_of_birth, gender, height, weight, heart_rate, blood_group, provider_type FROM users WHERE id='$userid'";
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
		$dob = $row["date_of_birth"];
		$row["gender"] = strtolower($row["gender"]);
		$diff = (date('Y') - date('Y',strtotime($dob)));
		$row["age"] =  $diff;
		if($row["heart_rate"] == null){
			$row["heart_rate"] = "Not Set";
		}
		if($row["blood_group"] == null){
			$row["blood_group"] = "Not Set";
		}
		if($row["age"] == 0){
			$row["age"] = "Not Set";
		}
		return $row;
	} else {
		$row["full_name"] = "This user no longer exist";
		return $row;
	}
}
	$pid = cleanInput($final_identifier);
	if(isset($_POST["confirmpickup"])){
		$sql = "UPDATE chats SET delivery_completed='Completed' WHERE id='$pid' ";
		if ($db->query($sql) === TRUE) {
			
		} else {
			$row["card"] = "red";
			$row["status"] = "Fail";
			$row["message"] = "Error updating record: " . $db->error;
			$data = $row;
		}
	}
	if(isset($_POST["approve"])){
		// Approve Order
		$id = cleanInput($_POST["setPrepared"]);
		$chatssql = "SELECT * FROM chats WHERE id='$id'";
		$chatsresult = $db->query($chatssql);
			if ($chatsresult->num_rows > 0){
				$row = $chatsresult->fetch_assoc();
				$storeid = $row["storeid"];
				$doctorid = $row["owner_two"];
				$patientid = $row["owner_one"];
				$pharmacyearning = calculatePrescirbedMedication($row["prescription"]);
				//Check delivery type
				if($row["delivery_type"] == "Pickup"){ // Order is pick up order
					//Get Pharmacy Earning
					
					//Set the pick up order as ready for pick up
					$sql = "UPDATE chats SET delivery_completed='Ready for pickup', storeapprove='true' WHERE  id='$id'";
					if ($db->query($sql) === TRUE) {
						//Send money to pharmacy
						$sql = "UPDATE users SET wallet=wallet + '$pharmacyearning' WHERE id='$storeid'";
						if ($db->query($sql) === TRUE) {
							$row["card"] = "green";
							$row["status"] = "Successfull";
							$row["message"] = "The record has been updated successfully";
							$data = $row;
						}else{
							$row["card"] = "green";
							$row["status"] = "Successfull";
							$row["message"] = "The record has been updated successfully";
							$data = $row;
						}
						
					} else { 
						$row["card"] = "red";
						$row["status"] = "Fail";
						$row["message"] = "Error updating order record: " . $db->error;
						$data = $row;
					}
				}else{ // Order delivery type is Delivery
					if($row["delyva_service_code"] == "EPINK"){ // Check if its in house delivery
						$sql = "UPDATE chats SET delivery_completed='Ready for pickup', storeapprove='true' WHERE  id='$id'";
						if ($db->query($sql) === TRUE) {
							//Send money to pharmacy
							$sql = "UPDATE users SET wallet=wallet + '$pharmacyearning' WHERE id='$storeid'";
							if ($db->query($sql) === TRUE) {
								$row["card"] = "green";
								$row["status"] = "Successfull";
								$row["message"] = "The record has been updated successfully";
								$data = $row;
							}else{
								$row["card"] = "green";
								$row["status"] = "Successfull";
								$row["message"] = "The record has been updated successfully";
								$data = $row;
							}
						} else {
							$row["card"] = "red";
							$row["status"] = "Fail";
							$row["message"] = "Error updating record: " . $db->error;
							$data = $row;
						}
					}else{
						include("api/delyva.php");
						$delyva = new Delyva;
						$accessToken = $delyva->auth();
						$delyvaorderid = $row["delyva_order_id"];
						$delyva_service_code = $row["delyva_service_code"];
						$process = $delyva->processOrder($delyvaorderid, $delyva_service_code);
						$row["message"] = "Delivery partner has been notified";
						//$res = json_encode($process, JSON_PRETTY_PRINT);
						$sql = "UPDATE chats SET delivery_completed='Ready for pickup', storeapprove='true' WHERE  id='$id'";
						if ($db->query($sql) === TRUE) {
							$sql = "UPDATE users SET wallet=wallet + '$pharmacyearning' WHERE id='$storeid'";
							if ($db->query($sql) === TRUE) {
								$row["card"] = "green";
								$row["status"] = "Successfull";
								$row["message"] = "The record has been updated successfully";
								$data = $row;
							}else{
								$row["card"] = "green";
								$row["status"] = "Successfull";
								$row["message"] = "The record has been updated successfully";
								$data = $row;
							}
							$sqlp = "UPDATE pharmacymemberships SET prescount = prescount - 1, session = session - 1 WHERE owner='$storeid'";
							if ($db->query($sqlp) === TRUE) {
								$row["card"] = "green";
								$row["status"] = "Successfull";
								$row["message"] = "The record has been updated successfully";
								$data = $row;
							}		
						} else {
							$row["card"] = "red";
							$row["status"] = "Fail";
							$row["message"] = "Error updating record: " . $db->error;
							$data = $row;
						}
					}
				}
			}else{
				echo 'Order not found';
			}
	}
/* 	if(isset($_POST["approve"])){
		$id = cleanInput($_POST["setPrepared"]);
		$type = "pharma";
		if($type == "pharma"){
			$chatssql = "SELECT * FROM chats WHERE id='$id'";
			$chatsresult = $db->query($chatssql);
			if ($chatsresult->num_rows > 0){
				$row = $chatsresult->fetch_assoc();
				$owneroneisdoctor = checkDoc($row["owner_one"]);
				if($owneroneisdoctor == true){
					$row["patient_id"] = $row["owner_two"];
					$row["patient_profile"] = getsimpleProfile($row["owner_two"]);
					$row["doctor_id"] = $row["owner_one"];
					$row["doctor_profile"] = getsimpleProfile($row["owner_one"]);
				}else{
					$row["patient_id"] = $row["owner_one"];
					$row["patient_profile"] = getsimpleProfile($row["owner_one"]);
					$row["doctor_id"] = $row["owner_two"];
					$row["doctor_profile"] = getsimpleProfile($row["owner_two"]);
				}
				$vendorprofile = getVendorprofile($row["storeid"]);
				
				$patient = $row["patient_profile"];
				
				$row["patient_full_name"] = $patient["full_name"];
				$row["patient_phone_number"] = $patient["phonenumber"];
				$row["patient_delivery_address"] = $row["delivery_address"];
				/* $make = json_decode(requestSpeedy($row["patient_full_name"], $row["patient_phone_number"], $row["patient_delivery_address"], $vendorprofile["vendor_name"], $vendorprofile["phonenumber"], $vendorprofile["vendor_address"], '$id')); 
				include("api/delyva.php");
				$delyva = new Delyva;
				$accessToken = $delyva->auth();
				$delyvaorderid = $row["delyva_order_id"];
				$delyva_service_code = $row["delyva_service_code"];
				$process = $delyva->processOrder($delyvaorderid, $delyva_service_code);
				$row["message"] = "Delivery partner has been notified";
				$res = json_encode($process, JSON_PRETTY_PRINT);
				$iscussssfull = false;
				if($iscussssfull == true){
						$sql = "UPDATE chats SET delivery_completed='3rd Party', storeapprove='true' WHERE  id='$id' ";
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
						if($row["delivery_type"] == "Delivery"){
							if($row["delyva_service_code"] == "EPINK"){
								$sql = "UPDATE chats SET delivery_completed='Ready for pickup', storeapprove='true' WHERE  id='$id'";
						
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
							
								$delyvaorderid = $row["delyva_order_id"];
								$delyva_service_code = $row["delyva_service_code"];
								$process = $delyva->processOrder($delyvaorderid, $delyva_service_code);
								$row["message"] = "Delivery partner has been notified";
								$res = json_encode($process, JSON_PRETTY_PRINT);
								$sql = "UPDATE chats SET delivery_completed='Ready for pickup', storeapprove='true' WHERE  id='$id'";
								
						
								if ($db->query($sql) === TRUE) {
									$pharmacistid = $authuser["id"];
									$sqlp = "UPDATE pharmacymemberships SET prescount = prescount - 1, session = session - 1 WHERE owner='$pharmacistid'";
									if ($db->query($sqlp) === TRUE) {
										$row["card"] = "green";
										$row["status"] = "Successfull";
										$row["message"] = "The record has been updated successfully";
										$data = $row;
									}
									
								} else {
									$row["card"] = "red";
									$row["status"] = "Fail";
									$row["message"] = "Error updating record: " . $db->error;
									$data = $row;
								}
							}

						}else{
							$sql = "UPDATE chats SET delivery_completed='Completed', storeapprove='true' WHERE  id='$id'";
					
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
						}
				}

				$data = $row;
			}else{
				$row["card"] = "red";
				$row["status"] = "Fail";
				$row["message"] = "The record you looking for does not exist<script>window.location.href= ''.$domain.'/404';</script>";
				$data = $row;
			}
		}else{
			$sql = "SELECT * FROM job_order WHERE id='$id'";
			$result = $db->query($sql);
			if ($result->num_rows > 0){
				$row = $result->fetch_assoc();
				$vendorprofile = getVendorprofile($row["restaurant_id"]);
				$row["patient_profile"] = getsimpleProfile($row["owner"]);
				$patient = $row["patient_profile"];
				$orderdata = json_decode($row["data"]);
				$patient["patient_delivery_address"] = $orderdata->delivery_address;
				$borzostatus = "Off";
				if($borzostatus == "Off"){
						$sql = "UPDATE job_order SET order_status='Ready for pickup' WHERE  id='$id' ";
						
						if ($db->query($sql) === TRUE) {
							
							
							$row["card"] = "green";
							$row["status"] = "Successfull";
							if($row["deliverytype"] == "pickup"){
								$row["message"] = "Ready for customer pick up";
							}else{
								$row["message"] = "Looking for rider";
							}
							
							$row["speedy"] = $make;
							$data = $row;
						} else {
								$row["card"] = "red";
								$row["status"] = "Fail";
								$row["message"] = "Error updating record: " . $db->error;
								$data = $row;
						}
				}else{
					
					$make = json_decode(requestSpeedy($patient["full_name"], $patient["phonenumber"], $patient["patient_delivery_address"], $vendorprofile["vendor_name"], $vendorprofile["phonenumber"], $vendorprofile["vendor_address"], '$id'));

					if($make->is_successful == true){
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
							$sql = "UPDATE job_order SET order_status='Ready for pickup' WHERE  id='$id' ";
						
							if ($db->query($sql) === TRUE) {
								$row["card"] = "green";
								$row["status"] = "Successfull";
								$row["message"] = "Looking for rider - ";
								$row["speedy"] = $make;
								$data = $row;
							} else {
								$row["card"] = "red";
								$row["status"] = "Fail";
								$row["message"] = "Error updating record: " . $db->error;
								$data = $row;
							}
					}
				}
				
			}else{
				$row["card"] = "red";
				$row["status"] = "Fail";
				$row["message"] = "Order not found";
				$data = $row;
			}

		}


		
	}
	
	 */
	
	$chatssql = "SELECT * FROM chats WHERE id='$pid'";
	$chatsresult = $db->query($chatssql);
	if ($chatsresult->num_rows > 0){
		$row = $chatsresult->fetch_assoc();
		$chatsdata = $row;
		$owner_one = $chatsdata["owner_one"];
		$owner_two = $chatsdata["owner_two"];
		
	} else {
		$row["card"] = "red";
		$row["status"] = "Fail";
		$row["message"] = "The record you looking for does not exist<script>window.location.href= ''.$domain.'/404';</script>";
		$data = $row;
	}
	
	$userssql = "SELECT * FROM users WHERE id='$owner_one'";
	$usersresult = $db->query($userssql);
	if ($usersresult->num_rows > 0){
		$row = $usersresult->fetch_assoc();
		$usersdata = $row;
		
	} else {
		$row["card"] = "red";
		$row["status"] = "Fail";
		$row["message"] = "The record you looking for does not exist<script>window.location.href= ''.$domain.'/404';</script>";
		$data = $row;
	}
	$userssql = "SELECT * FROM users WHERE id='$owner_two'";
	$docresult = $db->query($userssql);
	if ($docresult->num_rows > 0){
		$doc = $docresult->fetch_assoc();
		$docdata = $doc;
		
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
						View Order 
						<?php 
						if($chatsdata["delivery_type"] == "Pickup"){ 
							echo '(Self pick up order)';
						}else{
							echo '(Require Delivery)';
						}
						?>
					</h1>
				</div>
				<div class="col-12 col-xl-auto mb-3">  
					<a class="btn btn-sm btn-light text-primary" href="<?php echo $domain; ?>/pharmacy-panel/orders/tele-consultation/">Back</a>    
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
<?php
	if (isset($data)) {
		echo '<div class="card mb-4"><div class="card-body">' . $data["message"] . '</div></div>';
	}
?>
<div class="row">
	<div class="col-lg-6">
<div class="card mb-5">
	<div class="card-header text-black">Patient Info</div>
	<div class="card-body">
	<div class="row">
		<div class="col-lg-4">
			<img src="<?php echo $usersdata["profile_img"]; ?>" class="img-fluid">
		</div>
		<div class="col-lg-8">
			<p class="text-xs">Name: <?php echo $usersdata["firstname"]; ?> <?php echo $usersdata["lastname"]; ?></p>
			<p class="text-xs">Height: <?php echo $usersdata["height"]; ?> CM</p>
			<p class="text-xs">Weight: <?php echo $usersdata["weight"]; ?> KG</p>
			<p class="text-xs">IC/Passport: <?php echo $usersdata["ic_number"]; ?></p>
		</div>
	</div>
	
	
	</div>
</div>
	</div>
	<div class="col-lg-6">
<div class="card mb-5">
	<div class="card-header text-black">Doctor Info</div>
	<div class="card-body">
	<div class="row">
		<div class="col-lg-4">
			<img src="<?php echo $docdata["profile_img"]; ?>" class="img-fluid">
		</div>
		<div class="col-lg-8">
			<p class="text-xs">Name: <?php echo $docdata["firstname"]; ?> <?php echo $docdata["lastname"]; ?></p>
			<p class="text-xs">APC: <?php echo $docdata["doctor_apc"]; ?></p>
			<p class="text-xs">Organization: <?php echo $docdata["organization_name"]; ?></p>
			<p class="text-xs">IC/Passport: <?php echo $docdata["ic_number"]; ?></p>
		</div>
	</div>
	
	
	</div>
</div>	
	</div>
</div>
<div class="card mb-3">
	<div class="card-header"><span class="text-black">Prescribed Medication</span> <span class="float-end"><a href="<?php echo $chatsdata["signedpres"]; ?>" target="_blank">Signed Prescription</a></span></div>
	<div class="card-body">
	<?php

		$medications = json_decode($chatsdata["prescription"]);
		$medicationscount = count($medications);
		$allitemprice = 0.00;
		$topay = 0.00;
		for ($x = 0; $x < $medicationscount; $x+=10) {
			$allitemprice = $allitemprice + $medications[$x]->originalprice;
			$topay = $topay + $medications[$x]->price;
			echo '<div class="card"><div class="card-body">';
			echo '<p class="text-xs"><b>'.$medications[$x]->name.'('.$medications[$x]->product_form.')</b></p>';
			echo '<p class="text-xs"><b>Route</b>: '.$medications[$x]->route.'</p>';
			echo '<p class="text-xs"><b>Dosage</b>: '.$medications[$x]->dosage.' / in take</p>';
			$intaketiming = $medications[$x]->intaketiming;
			if($medications[$x]->beforeafter == "After"){
				$beforeafter = ' Before <i data-feather="square" style="vertical-align: middle;"></i> After <i data-feather="check-square" style="vertical-align: middle;"></i>';
			}else{
				$beforeafter = ' Before <i data-feather="check-square" style="vertical-align: middle;"></i> After <i data-feather="square" style="vertical-align: middle;"></i>';
			}
			if($intaketiming->Morning == null){
				$morningintake = '<i data-feather="square" style="vertical-align: middle;"></i>';
			}else{
				
				$morningintake = '<i data-feather="check-square" style="vertical-align: middle;"></i>';
			}
			if($intaketiming->Afternoon == null){
				$afternoonintake = '<i data-feather="square" style="vertical-align: middle;"></i>';
			}else{
				$afternoonintake = '<i data-feather="check-square" style="vertical-align: middle;"></i>';
			}
			if($intaketiming->Evening == null){
				$eveningintake = '<i data-feather="square" style="vertical-align: middle;"></i>';
			}else{
				$eveningintake = '<i data-feather="check-square" style="vertical-align: middle;"></i>';
			}
			if($intaketiming->Night == null){
				$Nightintake = '<i data-feather="square text-primary" style="vertical-align: middle;"></i>';
			}else{
				$Nightintake = '<i data-feather="check-square text-primary primary-text" style="vertical-align: middle;"></i>';
			}
			echo '<p class="text-xs"><b>Time:</b> Morning '.$morningintake.'';
			echo ' Afternoon '.$afternoonintake.'';
			echo ' Evening '.$eveningintake.'';
			echo ' Night '.$afternoonintake.'</p>';
			echo '<p class="text-xs"><b>Meals:</b>'.$beforeafter.'</p>';
			echo '<p class="text-xs"><b>Remarks:</b>'.$medications[$x]->remark.'</p>';
			echo '</div></div>';
		}

	?>
		
	</div>
</div>
<div class="card mb-3">
	<div class="card-header"><span class="text-black">Finance</span></div>
	<div class="card-body">
		<p>Total Earning: RM<?php echo number_format((float)$allitemprice, 2, '.', ''); ?></p>
		<p>Customer Pay: RM<?php echo number_format((float)$topay, 2, '.', ''); ?></p>
	</div>
</div>

<div class="card mb-3">
	<div class="card-header"><span class="text-black">Action Panel</span></div>
	<div class="card-body">
		<?php
			if($chatsdata["paid"] == "true"){
				if($chatsdata["storeapprove"] == "" && $chatsdata["delivery_completed"] == "waiting"){
					echo '<p>Prepare the requested medication and approve this orders</p><form method="POST"><input type="text" name="setPrepared" value="'.$final_identifier.'" hidden><button type="submit" name="approve" class="btn btn-primary">Approve</button></form>';
				}
			}
			if($chatsdata["paid"] == "true" && $chatsdata["delivery_completed"] == "Completed" && $chatsdata["delivery_type"] == "Pickup"){
				echo 'You have approved this order. Please hand over the medication to the patient';
			}
			if($chatsdata["paid"] == "true" && $chatsdata["delivery_completed"] == "Completed" && $chatsdata["delivery_type"] == "Delivery"){
				echo 'Delivery has been completed';
			}
			if($chatsdata["paid"] == "true" && $chatsdata["delivery_completed"] == "Ready for pickup" && $chatsdata["delivery_type"] == "Delivery"){
				echo 'Our delivery partner has been notified. Please hand over the medication to our delivery partner upon arrival';
			}
			if($chatsdata["paid"] == "true" && $chatsdata["delivery_completed"] == "Picked Up" && $chatsdata["delivery_type"] == "Delivery"){
				echo 'Medication has been picked up';
			}
			if($chatsdata["paid"] == "true" && $chatsdata["delivery_completed"] == "Delivering" && $chatsdata["delivery_type"] == "Delivery"){
				echo 'Delivering';
			}
		?>		
	</div>
</div>
</div>

