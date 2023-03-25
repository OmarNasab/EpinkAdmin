<?php
if(isset($_POST["submitupdateelab_request"])){
	$id = cleanInput($page_action_identifier);
	$owner = cleanInput($_POST["owner"]);
	$sql = "UPDATE accounts_verification SET request_status='Approved' WHERE id='$id' ";
	if ($db->query($sql) === TRUE){		
		$accounts_verificationsql = "SELECT * FROM accounts_verification WHERE id='$id'";
		$accounts_verificationresult = $db->query($accounts_verificationsql);
		if ($accounts_verificationresult->num_rows > 0){
			$row = $accounts_verificationresult->fetch_assoc();
			$eduction = $row["educations_place"];
			$eduction_cert = $row["education_certification"];
			$provider_type = $row["verifying_for"];
			$apc_number = $row["apc_number"];
			$categories = '[{"name":"General Item", "sub":{}}]';
			if($provider_type != "Doctor"){
				$doctor = 'false';
			}else{
				$doctor = 'true';
			}
			if($provider_type == "Pharmacist"){
				$sql = "SELECT * FROM settings WHERE setting_item='mastercategory'";
				$result = $db->query($sql);
				$cat = $result->fetch_assoc();
				$mastercategory = $cat["setting_value"];
				$sqlx = "UPDATE users SET doctor='$doctor', verified_service_provider='Approved', doctor_apc='$apc_number', education='$eduction', education_certificate='$eduction_cert', provider_type='$provider_type', categories='$mastercategory'  WHERE id='$owner'";
			}else{
				$sqlx = "UPDATE users SET doctor='$doctor', verified_service_provider='Approved', doctor_apc='$apc_number', education='$eduction', education_certificate='$eduction_cert', provider_type='$provider_type'  WHERE id='$owner'";
			}
			
			
			if ($db->query($sqlx) === TRUE) {
			  $res = 'Account approved <a href="'.$domain.'/verification-request/">Back</a>';
			} else {
			  $res = 'Error updating record: ' . $db->error;
			}
		} else {
			$row["card"] = "red";
			$row["status"] = "Fail";
			$row["message"] = "The record you looking for does not exist<script>window.location.href= ''.$domain.'/404';</script>";
			$data = $row;
		}
	
		$row["card"] = "green";
		$row["status"] = "Successfull";
		$row["message"] = "The record has been updated successfully";
		$data = $row;		
	}else{	
		$row["card"] = "red";
		$row["status"] = "Fail";
		$row["message"] = "Error updating record: " . $db->error;
		$data = $row;	
		$res = 'Failed '.$id.$db->error;	
	}
}

$id = cleanInput($page_action_identifier);
$elab_requestsql = "SELECT * FROM accounts_verification WHERE id='$id'";
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
            <h1>Approve</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
             Approve this verification request
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
<? echo $final_identifier; ?>
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
					<p>Approve this account verification request</p>
					<form method="POST">
						<input type="text" id="editid" name="editid" value="<?php echo $elab_requestobject["id"]; ?>" hidden>
						<input type="text" id="owner" name="owner" value="<?php echo $elab_requestobject["owner"]; ?>" hidden>
						<button class="btn btn-primary black white-text" name="submitupdateelab_request" id="submitupdateelab_request" type="submit">APPROVE</button> 
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