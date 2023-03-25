
<?php

if(isset($_POST["submitupdateelab_request"])){
	$id = cleanInput($page_action_identifier);
	$decline_reason = cleanInput($_POST["decline_reason"]);
	$id = cleanInput($_POST["editid"]);
	$owner = cleanInput($_POST["owner"]);
	$sql = "UPDATE specialist_verification SET status='Declined', decline_reason='$decline_reason' WHERE id='$id' ";
	if ($db->query($sql) === TRUE) {		
		$res = 'Request declined <a href="'.$domain.'/specialityverification/">Back</a>';
		$row["card"] = "green";
		$row["status"] = "Successfull";
		$row["message"] = "The record has been updated successfully";
		$data = $row;
		$sqlcheck = "SELECT * FROM specialist_verification WHERE requester_id='$owner'";
			$resultcheck = $db->query($sqlcheck);
			if($resultcheck->num_rows > 0) {
				$userspeciality = "";
				$counter = 0;
				while($spc = $resultcheck->fetch_assoc()){
					if($spc["status"] == "Approved"){
						$userspeciality .= $spc["specialties"].' ';
						$speciality[] = $spc;
					}
				}
				$specialist = $userspeciality;
				$speciality = json_encode($speciality);
				$sqlspe = "UPDATE users SET specialist='$speciality' WHERE id='$owner'";
				$db->query($sqlspe);
			}
	}else{	
		$row["card"] = "red";
		$row["status"] = "Fail";
		$row["message"] = "Error updating record: " . $db->error;
		$data = $row;	
		$res = 'Failed '.$id.$db->error;	
	}
}

$id = cleanInput($page_action_identifier);
$elab_requestsql = "SELECT * FROM specialist_verification WHERE id='$id'";
$elab_requestresult = $db->query($elab_requestsql);
if ($elab_requestresult->num_rows > 0){
	$row = $elab_requestresult->fetch_assoc();
	$elab_requestobject = $row;
} else {
	$res = 'Not found';
}

?>
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Decline</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
             Decline this verification request
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
	<div class="container-fluid">
		<?php
	
	if(isset($res)){
		echo '
		<div class="card">
			<div class="card-header">Result</div>
			<div class="card-body">'.$res.'</div>
		</div>
		';
		
	}else{
	
	
	?>
		<div id="">
			<div class="card">
				<div class="card-body">
					<p>Decline this specialist verification request</p>
					<form method="POST">
						<input type="text" id="editid" name="editid" value="<?php echo $elab_requestobject["id"]; ?>" >
						<input type="text" id="owner" name="owner" value="<?php echo $elab_requestobject["requester_id"]; ?>" >
						<p>Decline Reason</p>
						<input type="text" id="decline_reason" name="decline_reason" value="" class="form-control">
						<br>
						<a class="btn btn-danger black white-text" href="https://epink.health/admin/specialityverification/">CANCEL</a> 
						<button class="btn btn-primary black white-text" name="submitupdateelab_request" id="submitupdateelab_request" type="submit">Decline</button> 
					</form>
				</div>
			</div>
		</div>
	</div>
	<?php } ?>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->