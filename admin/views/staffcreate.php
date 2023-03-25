 <?php
if(isset($_POST["createstaff"])){
	$email = cleanInput($_POST["staffmail"]);
	$password = cleanInput($_POST["staffpassword"]);
	$type = cleanInput($_POST["type"]);
	$sql = "INSERT INTO users (email, password, type)
	VALUES ('$email', '$password', '$type')";

	if ($db->query($sql) === TRUE) {
	  $response = "New staff account has been created successfully";
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
            <h1>Create Staff Account</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Welcome back <?php echo $authuser["firstname"].' '.$authuser["lastname"]; ?></li>
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
		
	}
	?>
	<div class="container-fluid">
		<div id="">
			<form method="POST">
				<div class="form-group">
					<label for="staffmail">Email</label>
					<input type="email" id="staffmail" name="staffmail"class="form-control">
				</div>
				<div class="form-group">
					<label for="staffpassword">Password</label>
					<input type="password" id="staffpassword" name="staffpassword" class="form-control">
				</div>
				<div class="form-group">
					<label>Staff Type</label>
					<select class="form-control" id="type" name="type">
						<option value="8">Super Admin</option>
						<option value="7">Normal Staff</option>
					</select>
				</div>
				<div class="form-group">
					<input type="submit" name="createstaff">
				</div>
			</form>
		</div>
	</div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->