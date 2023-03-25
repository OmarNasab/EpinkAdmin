<?php
$cid = cleanInput($page_action_identifier);
if(isset($_POST["changesp"])){
	$spemail = cleanInput($_POST["spemail"]);
	$sqlsp = "SELECT * FROM users WHERE email='$spemail'";
	$resultsp = $db->query($sqlsp);
	if ($resultsp->num_rows > 0){
		$sp = $resultsp->fetch_assoc();
		$spuserid = $sp["id"];
		$sqlxo = "UPDATE care SET sp_id='$spuserid' WHERE id='$cid'";
		if ($db->query($sqlxo) === TRUE) {
		  $res = "A health care personal has been assign to this care request";
		} else {
		  $res =  "Error updating record: " . $db->error;
		}
	} else {
		$res = 'User not found';
	}
}

if(isset($_POST["changestatus"])){
	$stats = $_POST["jobstatus"];
	$sqlchange = "SELECT * FROM care WHERE id='$cid'";
	$resultchange = $db->query($sqlchange);
	if ($resultchange->num_rows > 0){
		$care = $resultchange->fetch_assoc();
		$sql = "UPDATE care SET request_status='$stats' WHERE id='$cid'";
		if ($db->query($sql) === TRUE) {
			$res = "Record updated successfully";
		} else {
			$res = "Error updating record: " . $db->error;
		}
	}
}
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
			
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Manage E Care Request</h1>
                </div>
                <div class="col-sm-6">
                   
                </div>
            </div>
        </div>


        <div class="container-fluid">
		<?php
		if(isset($res)){
			echo '
			<div class="card">
				<div class="card-body">
					'.$res.'
				</div>
			</div>
			';
		}?>
		<div class="card">	
			<div class="card-header">E Care Request Detail</div>
			<div class="card-body">
<?php

$sql    = "SELECT * FROM care WHERE id='$cid'";
$result = $db->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        if ($row["caretypeori"] == "House Call") {
            $caretype = "House Call";
        } else {
			if($row["careid"] == 0){
				$caretype = "Online Consultation";
			}else{
				$caretype = "Walk In";
			}
            
        }
		$cid = $row["careid"];
		$sqlservice = "SELECT * FROM ecare_services WHERE id='$cid'";
		$resultserve = $db->query($sqlservice);
		$careinfo = $resultserve->fetch_assoc();
		$requestdate = $row["caredate"] . ' ' . $row["caretime"];
		$requestdate = date("F jS, Y h:i A", strtotime($requestdate));
		
		if($careinfo["subcategory"] == ""){
			$carecategory = $careinfo["category"];
		}else{
			$carecategory = $careinfo["category"].' / '.$careinfo["subcategory"];
		}
		
		$carename = $careinfo["name"];
		if($row["careid"] == 0){
			$carename = "Tele consulation";
			$carecategory = "Public tele consulation request";
		}
		if($row["patientproblem"] == ""){
			$problem = 'Not set by user';
		}else{
			$problem = $row["patientproblem"];
		}
		
		if($row["sp_id"] == 0){
			$spinfo = '<div class="card"><div class="card-body text-xs">No service provider</div></div>';
			if($row["teleid"] != 0){
				$spinfo = '<a href="https://epink.health/admin/sessions/view/'.$row["teleid"].'/">View Tele Consultation Request</a>';
			}
		}else{
			$spid = $row["sp_id"];
			$sqlspin = "SELECT * FROM users WHERE id='$spid'";
			$resultsp = $db->query($sqlspin);
			if ($resultsp->num_rows > 0) {
				$rowsp = $resultsp->fetch_assoc();
				$spinfo = '<a href="https://epink.health/admin/healthcare-personel/'.$rowsp["id"].'/"><div class="card"><div class="card-body text-xs"><b>'.$rowsp["fullname"].'</b><br>Provider Type: '.$rowsp["provider_type"].'</div></div></a>';
			}else{
				$spinfo = '<div class="card"><div class="card-body text-xs">Account Deleted</div></div>';
			}
			
		}
		
		if($row["require_attachment"]){
			$hasattachment = '<p class="text-xs">Vaccination: <a href="https://epink.health/certs/'.$row["id"].'/">VIEW ATTACHMENT</a></p>';
		}
		
        echo '
					<p class="strong">' . $carename . ' Request (Request Id :'.$cid.')</p>
					<p class="text-xs">Category: '.$carecategory.'</p></td>
					<p class="text-xs">Price: RM' . $row["careprice"] . '</p></td>
					<p class="text-xs">Status: ' . $row["request_status"] . '</p>
					<p class="text-xs">Request Date: '.$requestdate.'</p>
					<p class="text-xs">Requested For: '.$row["patientname"].'</p>
					<p class="text-xs">Requested By: <a href="https://epink.health/admin/patients/'.$row["id"].'">'.$row["fullname"].'<a/></p>
					<p class="text-xs">Problem: ' . $problem . '</p><p class="text-xs">Type: '.$caretype.'</p>
					'.$hasattachment.'
					<p class="text-xs">Provider: </p>
					'.$spinfo.'
					
					
			';
    }
} else {
	echo 'sas';
}
?>   
</div>
<div class="card-footer"><button class="btn btn-primary btn-small" data-toggle="modal" data-target="#jobstatus">Set Status</button> <button class="btn btn-primary btn-small" data-toggle="modal" data-target="#exampleModal">Assign to service provider </button>


</div> 
</div> 
</div>
</section>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Assign To</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<form method="POST">
			<p>Email</p>
		<input type="email" id="spemail" name="spemail" class="form-control">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="changesp" id="changesp">Save changes</button>
		</form>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="jobstatus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Set job status</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<form method="POST">
			<p>Status</p>
			<select name="jobstatus" id="jobstatus" class="form-control">
				<option value="">Please select</option>
				<option value="New">New</option>
				<option value="Completed">Completed</option>
				<option value="Canceled">Canceled</option>
			</select>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="changestatus" id="changestatus">Save changes</button>
		</form>
      </div>
    </div>
  </div>
</div>