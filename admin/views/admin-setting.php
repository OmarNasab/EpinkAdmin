<?php
if(isset($_POST["update_parcel"])){
	$uid = $authuser["id"];
	$password = cleanInput($_POST["password"]);

	$sql1 = "UPDATE users SET password='$password' WHERE id='$uid'";

	if ($db->query($sql1) === TRUE) {

	   $res = "Record updated successfully";
	} else {
	   $res =  "Error updating record: " . $db->error;
	}
}
$uid = $authuser["id"];
$sqlpriceperkm = "SELECT * FROM users WHERE id='$uid'";
$priceperkmresult = $db->query($sqlpriceperkm);
if ($priceperkmresult->num_rows > 0) {
	$userobject = $priceperkmresult->fetch_assoc();
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Admin Account Setting</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Change admin account password</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
			<?php
			if(isset($response)){
				echo '<p>'.$response.'</p>';
			}
			?>
			<form method="POST">
				<div class="form-group">
					<label for="">Email</label>
					<input type="text" name="email" id="parcel_first_km" class="form-control" value="<?php echo $authuser["email"]; ?>" readonly>
				</div>
				<div class="form-group">
					<label for="">Password</label>
					<input type="password" name="password" id="password" class="form-control" value="<?php echo $authuser["password"]; ?>">
				</div>
				<div class="form-group">
					<input type="submit" name="update_parcel" id="update_parcel" class="btn btn-primary">
				</div>					
			</form>
		</div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->