<?php
if(isset($_POST["update_pnc"])){
	$uid = $authuser["id"];
	$setting_value = $db->real_escape_string($_POST["mytextarea"]);
	$sql1 = "UPDATE settings SET setting_value='$setting_value' WHERE setting_item='privacy_policy'";
	if ($db->query($sql1) === TRUE) {
	   $res = "Record updated successfully";
	} else {
	   $res =  "Error updating record: " . $db->error;
	}
}
$uid = $authuser["id"];
$sqlsetting = "SELECT * FROM settings WHERE setting_item='privacy_policy'";
$settingresult = $db->query($sqlsetting);
if ($settingresult->num_rows > 0) {
	$settingobject = $settingresult->fetch_assoc();
}
?>
 
 <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Privacy Policy</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Privacy policy editor</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

  <form method="post">
  <div class="form-group">   
	</div>
  	<div class="form-group">
		<textarea id="mytextarea" name="mytextarea">
			<?php echo $settingobject["setting_value"]; ?>
		</textarea>
	</div>
	<div class="form-group">
	<button type="submit" class="btn btn-primary" name="update_pnc">SUBMIT</button>
	</div>
  </form>
  		</div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->