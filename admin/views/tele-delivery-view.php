<?php
	$pid = cleanInput($page_action_identifier);
	$chatssql = "SELECT * FROM chats WHERE id='$pid'";
	$chatsresult = $db->query($chatssql);
	if ($chatsresult->num_rows > 0){
		$row = $chatsresult->fetch_assoc();
		$chatsdata = $row;
		$owner_one = $chatsdata["owner_one"];
		$owner_two = $chatsdata["owner_two"];
		$storeid = $chatsdata["storeid"];
		$rid = $chatsdata["runnedid"];
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
	$userssql = "SELECT * FROM users WHERE id='$storeid'";
	$usersresult = $db->query($userssql);
	if ($usersresult->num_rows > 0){
		$storeinfo = $usersresult->fetch_assoc();		
	}
	
	$userssql = "SELECT * FROM users WHERE id='$rid'";
	$usersresult = $db->query($userssql);
	if ($usersresult->num_rows > 0){
		$runner = $usersresult->fetch_assoc();		
	}else{
		$runner = "3RD Party Delivery Partner";
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
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Delivery Detail</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active"><a href="<?php echo $domain; ?>/delivery-tele-medicine/">Back</a></li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
        <div class="container-fluid">
		
		<?php
		if(isset($res)){
			echo '<div class="card"><div class="card-body">'.$res.'</div></div>';
			
		}
		?>
<div class="card mb-3" style="display: none">
	<div class="card-header"><span class="text-black">Session Detail</span></div>
	<div class="card-body">
	<?php
		$sessionstatus = "";
		if($chatsdata["session_status"] == "new" ){
			$sessionstatus = 'Tele consultation session ongoing.';
		}elseif($chatsdata["session_status"] == "Ended"){
			if($chatsdata["paid"] == "" && $chatsdata["signedpres"] != ""){
				$sessionstatus = 'Waiting for customer to make payment.';
			}elseif($chatsdata["paid"] == "true" && $chatsdata["signedpres"] != ""){
				if($chatsdata["delivery_completed"] == "waiting"){
					$sessionstatus = 'Medication paid by customer, waiting for pharmacy to approve the order.';
				}elseif($chatsdata["delivery_completed"] == "Ready for pickup"){
					$sessionstatus = 'Pharmacy approved. Waiting for rider to accept delivery request.';
				}elseif($chatsdata["delivery_completed"] == "Accepted"){
					$sessionstatus = 'Medication delivery request accepted by delivery partner.';
				}elseif($chatsdata["delivery_completed"] == "Delivering"){
					$sessionstatus = 'Delivery partner picked up the medication and on his way to deliver to patient.';
				}elseif($chatsdata["delivery_completed"] == "Completed"){
					$sessionstatus = 'Medication delivered to the customer.';
				}
			}elseif($chatsdata["paid"] == "" && $chatsdata["signedpres"] == ""){
				$sessionstatus = 'Session Ended';
			}
		}
	?>
	<p><b>Consultation ID: </b><?php echo $chatsdata["id"]; ?></p>
	<p><b>Status: </b><?php echo $sessionstatus; ?></p>
	<p><b>Clinical Note: </b><?php if($chatsdata["signedclinicalnote"] != "" || $chatsdata["signedclinicalnote"] != null){ echo '<a href="'.$chatsdata["signedclinicalnote"].'" target="_blank">View</a>'; }else{ echo 'Waiting for session ended'; } ?></p>
	<p><b>Medical Leave Certificate: </b><?php if($chatsdata["signedmc"] != "" || $chatsdata["signedmc"] != null){ echo ' <a href="'.$chatsdata["signedmc"].'" target="_blank">View</a>'; }else{ echo 'None Prepared'; } ?></p>
	<p><b>Refer Letter: </b><?php if($chatsdata["signedrefer"] != "" || $chatsdata["signedrefer"] != null){ echo ' <a href="'.$chatsdata["signedrefer"].'" target="_blank">View</a>'; }else{ echo 'None Prepared'; } ?></p>
	<p><b>Prescription: </b><?php if($chatsdata["signedpres"] != "" || $chatsdata["signedpres"] != null){ echo ' <a href="'.$chatsdata["signedpres"].'" target="_blank">View</a>'; }else{ echo 'None Prepared'; } ?></p>
	<p><b>Pharmacy Approval :</b>
	<?php 
	if($sessionstatus == "Medication paid by customer, waiting for pharmacy to approve the order."){
		echo 'Waiting for approval';
	}else if($sessionstatus == "Pharmacy approved. Waiting for rider to accept delivery request."){
		echo 'Approved by Pharmacy';
	}else if($sessionstatus == "Medication delivery request accepted by delivery partner."){
		echo 'Approved by Pharmacy';
	}else if($sessionstatus == "Delivery partner picked up the medication and on his way to deliver to patient."){
		echo 'Approved by Pharmacy';
	}else if($sessionstatus == "Medication delivered to the customer."){
		echo 'Approved by Pharmacy';
	}else if($sessionstatus == "Session Ended"){
		echo 'Not required';
	}else{
		echo $sessionstatus;
	}
	?></p>
	
	</div>
</div>
<div class="row" style="display: none">
	<div class="col-lg-6">
	
<div class="card mb-3">
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
<div class="card mb-3">
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
			<p class="text-xs">Paid: RM<?php echo $chatsdata["doctorearning"]; ?></p>
		</div>
	</div>
	
	
	</div>
</div>	
	</div>
</div>


<div class="card mb-3" style="display: none">
	<div class="card-header"><span class="text-black"><b>Finance</b></span></div>
	<div class="card-body">
		<p>Epink profit: RM<?php echo number_format((float)$epinkearn, 2, '.', ''); ?></p>
		<p>Vendor profit: RM<?php echo number_format((float)$allitemprice, 2, '.', ''); ?></p>
		<p>Doctor profit: RM<?php echo number_format((float)$chatsdata["doctorearning"], 2, '.', ''); ?></p>
		<p>Rider Earning: RM<?php echo number_format((float)$chatsdata["delivery_fee"], 2, '.', ''); ?></p>
		
	</div>
</div>

<div class="card mb-3" 
<?php
if($chatsdata["session_status"] == "ended" && $chatsdata["paid"] == "" || $chatsdata["paid"] == null){
		echo 'style="display: none;"';
}


?>
>
	<div class="card-header">
		<span class="text-black"><b>Delivery Detail</b></span>
	</div>
	<div class="card-body">
		
		<div id="gotdelivery" style="">
		
		<p>Delivery Status : 
<?php
if($chatsdata["delivery_completed"] == "Waiting"){
	echo 'Waiting for driver to pick up';
}elseif($chatsdata["delivery_completed"] == "Accepted"){
	echo 'Accepted by runner';
}elseif($chatsdata["delivery_completed"] == "Delivering"){
	echo 'Picked up and on the way to deliver medication to customer';
}elseif($chatsdata["delivery_completed"] == "Completed"){
	echo 'Completed';
}elseif($chatsdata["delivery_completed"] == "Ready for pickup"){
	echo 'Waiting for delivery partner to pick up the medication';
}
?>
</p>
		<p>Runner : 
<?php
if($chatsdata["delivery_completed"] == "Waiting"){
	echo 'Waiting for driver to pick up';
}elseif($chatsdata["delivery_completed"] == "Accepted"){
	echo $runner["firstname"].' '.$runner["lastname"];
}elseif($chatsdata["delivery_completed"] == "Delivering"){
	echo $runner["firstname"].' '.$runner["lastname"];
}elseif($chatsdata["delivery_completed"] == "Completed"){
	echo $runner["firstname"].' '.$runner["lastname"];
}elseif($chatsdata["delivery_completed"] == "Ready for pickup"){
	echo 'Searching	';
}

?>
</p>
		<p>Delivery fee: RM<?php echo $chatsdata["delivery_fee"]; ?></p>
		<p><b>Pick up</b></p>
		<p>Pharmacy: <?php echo $storeinfo["vendor_name"]; ?></p>
		<?php echo $storeinfo["vendor_address"]; ?>
		<br>
		<br>
		<p><b>Drop Off</b></p>
		<p>Patient: <?php echo $usersdata["firstname"]; ?> <?php echo $usersdata["lastname"]; ?></p>
		<?php echo $chatsdata["delivery_address"]; ?>
		</div>
	</div>
</div>
<div class="card mb-3" style="
<?php 
if($chatsdata["session_status"] == "new"){
	echo 'display: none';
}elseif($chatsdata["session_status"] == "Ended" && $chatsdata["signedpres"] == ""){
	echo 'display: none';
}
?>">
	<div class="card-header"><span class="text-black"><b>Items</b></span></div>
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
			$intaketiming = $medications[$x]->intaketiming;
			
			if($medications[$x]->beforeafter == "After"){
				$beforeafter = ' Before <i class="fa fa-stop" aria-hidden="true"></i> After <i class="fa fa-check" aria-hidden="true"></i>';
			}else{
				$beforeafter = ' Before  <i class="fa fa-check" aria-hidden="true"></i> After <i class="fa fa-stop" aria-hidden="true"></i>';
			}
			
			if($intaketiming->Morning == null){
				$morningintake = '<i class="fa fa-stop" aria-hidden="true"></i>';
			}else{
				
				$morningintake = '<i class="fa fa-check" aria-hidden="true"></i>';
			}
			if($intaketiming->Afternoon == null){
				$afternoonintake = '<i class="fa fa-stop" aria-hidden="true"></i>';
			}else{
				$afternoonintake = '<i class="fa fa-check" aria-hidden="true"></i>';
			}
			if($intaketiming->Evening == null){
				$eveningintake = '<i class="fa fa-stop" aria-hidden="true"></i>';
			}else{
				$eveningintake = '<i class="fa fa-check" aria-hidden="true"></i>';
			}
			if($intaketiming->Night == null){
				$Nightintake = '<i class="fa fa-stop" aria-hidden="true"></i>';
			}else{
				$Nightintake = '<i class="fa fa-check" aria-hidden="true"></i>';
			}
			echo '</div></div>';
		}
		$epinkearn = $topay-$allitemprice;

	?>
	</div>
</div>
<div class="card mb-3"
<?php
if($sessionstatus == "Medication paid by customer, waiting for pharmacy to approve the order."){
		echo 'style="display: block"';
	}else if($sessionstatus == "Pharmacy approved. Waiting for rider to accept delivery request."){
		echo 'style="display: block"';
	}else if($sessionstatus == "Medication delivery request accepted by delivery partner."){
		echo 'style="display: block"';
	}else if($sessionstatus == "Delivery partner picked up the medication and on his way to deliver to patient."){
		echo 'style="display: block"';
	}else if($sessionstatus == "Medication delivered to the customer."){
		echo 'style="display: none"';
	}else if($sessionstatus == "Session Ended"){
		echo 'style="display: none"';
	}else{
		echo $sessionstatus;
	}
?>

>
	<div class="card-header"><span class="text-black"><b>Action Panel</b></span></div>
	<div class="card-body">
		<br><br>
		<?php
		/* if($chatsdata["paid"] == "true" && $chatsdata["delivery_completed"] == "Completed"){
			echo 'This order has been completed and the medication has been delivered';
		}elseif($chatsdata["session_status"] == "new"){
			echo '
				<a href="#"  class="btn btn-primary" data-toggle="modal" data-target="#assigndoctor">Assign To Other</a>
			
			';
		}elseif($chatsdata["session_status"] == "ended" && $chatsdata["signedpres"] == "" || $chatsdata["signedpres"] == null){
			echo 'This session has been ended. No action can be taken';
		}elseif($chatsdata["session_status"] == "ended" && $chatsdata["paid"] == "" || $chatsdata["paid"] == null){
			echo 'Waiting for customer to pay for the medication';
		} */
		?>

	</div>
</div>
</div>
  		</div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<div class="modal fade" id="assigndoctor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Assign a doctor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
			<div class="form-group">
				<label>Please enter the email of doctor you would like to assign to this pharmacy</label>
				<input type="email" id="emailtoassign" class="form-control">
			</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button name="updatedoctor" class="btn btn-primary" onclick="assignADoctor()">ASSIGN</button>
      </div>
    </div>
  </div>
</div>

<script>
var serverUrl = 'https://epink.health/api/index.php';
function assignADoctor(){
			var doctoremail = document.getElementById("emailtoassign").value;
			var dataTopost = 'api=1&auth_token='+authUser.login_token+'&adminassigndoctor='+doctoremail+'&pharmaid=<?php echo $usersobject["id"]; ?>';
                		var xhr = new XMLHttpRequest();
                		xhr.open("POST", serverUrl, true);
                		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                		xhr.onload = function() {
                			if (xhr.status == 200) {
								
                				var json = xhr.responseText;
                				var response = JSON.parse(json);
                				if(response.status == "fail"){
                					alert(response.message);
                					
                				}else{
                					alert(response.message);
									location.reload();
                					
                				}
                			} else if (xhr.status == 404) {
                				alert("Fail to connect to our server");
                			} else {
                				alert("Fail to connect to our server");
                			}
                		}
                		xhr.send(dataTopost);
		}

</script>

