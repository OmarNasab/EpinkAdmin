<?php
if(isset($_POST["submitupdateelab_request"])){
	$id = cleanInput($page_action_identifier);
	$owner = cleanInput($_POST["ownerid"]);
	$sql = "UPDATE specialist_verification SET status='Approved' WHERE id='$id' ";
	if ($db->query($sql) === TRUE){		
			$row["card"] = "red";
			$row["status"] = "Success";
			$row["message"] = "The record you looking for does not exist<script>window.location.href= ''.$domain.'/404';</script>";
			$res = 'This request has been approved. <a href="'.$domain.'/specialityverification/">Back</a>';
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
					<p>Approve this speciality verification request</p>
					<form method="POST">
						<input type="text" id="editid" name="editid" value="<?php echo $elab_requestobject["id"]; ?>" hidden>
						<input type="text" id="ownerid" name="ownerid" value="<?php echo $elab_requestobject["requester_id"]; ?>" hidden>
						<a class="btn btn-danger black white-text" href="https://epink.health/admin/specialityverification/">CANCEL</a> 
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