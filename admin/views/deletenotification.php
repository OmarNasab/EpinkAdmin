 <?php
 if(isset($_POST["delete"])){
	 $pid = cleanInput($_POST["productid"]);
	$sql = "DELETE FROM notifcations WHERE id='$pid'";

	if ($db->query($sql) === TRUE) {
	  $data["message"] = 'Notification Deleted <a href="'.$domain.'/notify-user/">Back</a>';
	} else {
	  $data["message"] =  "Error deleting record: " . $db->error;
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
            <h1>Delete Notification</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Delete Notification</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <section class="content">
	<?php
	if (isset($data)) {
		
		echo '<div class="card">
		  <div class="card-body">
			' . $data["message"] . '
		  </div>
		</div>';
		
	}else{
	?>
		<form method="POST" action="">
			<p>Are you sure about deleting this vendor product?</p>
			<input type="text" id="productid" name="productid" value="<?php echo $page_identifier_action; ?>" hidden>
			<button type="submit" name="delete" id="delete" class="btn btn-danger">Delete</button>
		</form>
	</section>
	<?php } ?>
</div>