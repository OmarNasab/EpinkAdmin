 <?php
if(isset($_POST["createstaff"])){
	$code = cleanInput($_POST["staffmail"]);
	$percentage = cleanInput($_POST["staffpassword"]);
	$amount = cleanInput($_POST["type"]);
	$sql = "INSERT INTO vourchers (code, percentage, amounts)
	VALUES ('$code', '$percentage', '$amount')";

	if ($db->query($sql) === TRUE) {
	  $response = "New promo code has been created successfully. <a href='".$domain."/promo-codes/'>Back to promotion code list</a>";
	} else {
	   $response = "Error: " . $sql . "<br>" . $db->error;
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
            <h1>Create Promotion Code</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
             Create promotion code
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
				<div class="form-group">
					<label for="staffmail">CODE</label>
					<input type="text" id="staffmail" name="staffmail"class="form-control">
				</div>
				<div class="form-group">
					<label for="staffpassword">Discount Percentage(%)</label>
					<input type="number" id="staffpassword" name="staffpassword" class="form-control">
				</div>
				<div class="form-group">
					
					<label for="type">Amount</label>
					<input type="number" id="type" name="type" class="form-control">
					
				</div>
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