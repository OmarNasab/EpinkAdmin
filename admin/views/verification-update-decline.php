
<?php

if(isset($_POST["submitupdateelab_request"])){
	$id = cleanInput($page_action_identifier);
	$owner = cleanInput($_POST["owner"]);
	$decline_reason = cleanInput($_POST["decline_reason"]);
	$sql = "UPDATE accounts_verification SET request_status='Declined', decline_reason='$decline_reason' WHERE id='$id' ";
	if ($db->query($sql) === TRUE) {		
		$sqlx = "UPDATE users SET verified_service_provider='Declined', decline_reason='$decline_reason' WHERE id='$owner'";
		if ($db->query($sqlx) === TRUE) {
		  $res = 'Approval declined <a href="'.$domain.'/verification-request/">Back</a>';
		} else {
		  $res = 'Error updating record: ' . $db->error;
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
						<p>Decline Reason</p>
						<input type="text" id="decline_reason" name="decline_reason" value="" class="form-control">
						<br>
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