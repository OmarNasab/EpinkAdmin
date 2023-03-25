 <?php
if(isset($_POST["deletethis"])){
	$codeid = cleanInput($_POST["deleteid"]);
	$sql = "UPDATE chats SET archive='true' WHERE id='$codeid'";

	if ($db->query($sql) === TRUE) {
	   $response = "This session has been archived. <a href='".$domain."/sessions/'>Back to tele consultation list</a>";
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
            <h1>Archive Sessions</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            Archive Sessions
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
			<p>Are you sure about archiving this patient session?</p>
				<input type="number" name="deleteid" id="deleteid" value="<?php echo $page_action_identifier; ?>" hidden>
				<div class="form-group">
					<input type="submit" name="deletethis">
				</div>
			</form>
		</div>
	</div>
	<?php } ?>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->