 <?php
if(isset($_POST["createstaff"])){
	$codeid = cleanInput($_POST["deleteid"]);


$sql = "DELETE FROM bookings WHERE id='$codeid'";

if ($db->query($sql) === TRUE) {
   $response = "This service has been deleted. <a href='".$domain."/booking-management/'>Back to booking management</a>";
} else {
   $response = "Error deleting record: " . $db->error;
}
	
}
 ?>
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Delete Booking</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
				Delete Booking
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
	<?php
	
	if(isset($response)){
		echo '
		<div class="card">
			<div class="card-header">Result</div>
			<div class="card-body">'.$response.'</div>
		</div>
		';
		
	}else{
	?>
	<div class="container-fluid">
		<div id="">
			<form method="POST">
				<p>Are you sure about deleting this request?</p>
				<input type="number" name="deleteid" id="deleteid" value="<?php echo $page_action_identifier; ?>" hidden>
				<div class="form-group">
					<input type="submit" name="createstaff">
				</div>
			</form>
		</div>
	</div>
	<?php } ?>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->