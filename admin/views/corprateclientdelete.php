 <?php

if(isset($_POST["delete"])){
	$pid = cleanInput($_POST["productid"]);
	$sql = "UPDATE users SET company_name='', company_manager='false', company_code='' WHERE id='$pid'";
	if ($db->query($sql) === TRUE) {
		$res = "Company has been deleted";
	}else{
		$res = "Error updating record: " . $db->error;
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
            <h1>Delete Company</h1>
          </div>
          <div class="col-sm-6">
           
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
			<p>Are you sure about deleting company</p>
			<input type="text" id="productid" name="productid" value="<?php echo $page_identifier_action; ?>" hidden>
			<button type="submit" name="delete" id="delete" class="btn btn-danger">Delete</button>
		</form>
	</section>
	<?php } ?>
</div>