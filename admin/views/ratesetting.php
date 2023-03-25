<?php
if(isset($_POST["update_rate"])){


	$Doctor_rate = cleanInput($_POST["Doctor_rate"]);
	$sql1 = "UPDATE settings SET setting_value='$Doctor_rate' WHERE setting_item='Doctor_rate'";

	if ($db->query($sql1) === TRUE) {
	   $res = "Record updated successfully";
	} else {
	   $res =  "Error updating record: " . $db->error;
	}	
	
	$Dentist_rate = cleanInput($_POST["Dentist_rate"]);
	$sql1 = "UPDATE settings SET setting_value='$Dentist_rate' WHERE setting_item='Dentist_rate'";

	if ($db->query($sql1) === TRUE) {
	   $res = "Record updated successfully";
	} else {
	   $res =  "Error updating record: " . $db->error;
	}	
	
	$Nutritionist_rate = cleanInput($_POST["Nutritionist_rate"]);
	$sql1 = "UPDATE settings SET setting_value='$Nutritionist_rate' WHERE setting_item='Nutritionist_rate'";

	if ($db->query($sql1) === TRUE) {
	   $res = "Record updated successfully";
	} else {
	   $res =  "Error updating record: " . $db->error;
	}	
	
	$Psychologist_rate = cleanInput($_POST["Psychologist_rate"]);
	$sql1 = "UPDATE settings SET setting_value='$Psychologist_rate' WHERE setting_item='Psychologist_rate'";

	if ($db->query($sql1) === TRUE) {
	   $res = "Record updated successfully";
	} else {
	   $res =  "Error updating record: " . $db->error;
	}	
	
	$Dietitian_rate = cleanInput($_POST["Dietitian_rate"]);
	$sql1 = "UPDATE settings SET setting_value='$Dietitian_rate' WHERE setting_item='Dietitian_rate'";

	if ($db->query($sql1) === TRUE) {
	   $res = "Record updated successfully";
	} else {
	   $res =  "Error updating record: " . $db->error;
	}	
	
	$Optometrist_rate = cleanInput($_POST["Optometrist_rate"]);
	$sql1 = "UPDATE settings SET setting_value='$Optometrist_rate' WHERE setting_item='Optometrist_rate'";

	if ($db->query($sql1) === TRUE) {
	   $res = "Record updated successfully";
	} else {
	   $res =  "Error updating record: " . $db->error;
	}	
	
	$Occupational_Therapist_rate = cleanInput($_POST["Occupational_Therapist_rate"]);
	$sql1 = "UPDATE settings SET setting_value='$Occupational_Therapist_rate' WHERE setting_item='Occupational_Therapist_rate'";

	if ($db->query($sql1) === TRUE) {
	   $res = "Record updated successfully";
	} else {
	   $res =  "Error updating record: " . $db->error;
	}	
	$Speech_and_Language_Therapist_rate = cleanInput($_POST["Speech_and_Language_Therapist_rate"]);
	$sql1 = "UPDATE settings SET setting_value='$Speech_and_Language_Therapist_rate' WHERE setting_item='Speech_and_Language_Therapist_rate'";

	if ($db->query($sql1) === TRUE) {
	   $res = "Record updated successfully";
	} else {
	   $res =  "Error updating record: " . $db->error;
	}
	
}

$sqlpriceperkm = "SELECT * FROM settings WHERE setting_item='Doctor_rate'";
$priceperkmresult = $db->query($sqlpriceperkm);
if ($priceperkmresult->num_rows > 0) {
	$settingobject = $priceperkmresult->fetch_assoc();
	$Doctor_rate = $settingobject["setting_value"];
}
$sqlpriceperkm = "SELECT * FROM settings WHERE setting_item='Dentist_rate'";
$priceperkmresult = $db->query($sqlpriceperkm);
if ($priceperkmresult->num_rows > 0) {
	$settingobject = $priceperkmresult->fetch_assoc();
	$Dentist_rate = $settingobject["setting_value"];
}

$sqlpriceperkm = "SELECT * FROM settings WHERE setting_item='Nutritionist_rate'";
$priceperkmresult = $db->query($sqlpriceperkm);
if ($priceperkmresult->num_rows > 0) {
	$settingobject = $priceperkmresult->fetch_assoc();
	$Nutritionist_rate = $settingobject["setting_value"];
}

$sqlpriceperkm = "SELECT * FROM settings WHERE setting_item='Psychologist_rate'";
$priceperkmresult = $db->query($sqlpriceperkm);
if ($priceperkmresult->num_rows > 0) {
	$settingobject = $priceperkmresult->fetch_assoc();
	$Psychologist_rate = $settingobject["setting_value"];
}

$sqlpriceperkm = "SELECT * FROM settings WHERE setting_item='Physiotherapist_rate'";
$priceperkmresult = $db->query($sqlpriceperkm);
if ($priceperkmresult->num_rows > 0) {
	$settingobject = $priceperkmresult->fetch_assoc();
	$Physiotherapist_rate = $settingobject["setting_value"];
}

$sqlpriceperkm = "SELECT * FROM settings WHERE setting_item='Dietitian_rate'";
$priceperkmresult = $db->query($sqlpriceperkm);
if ($priceperkmresult->num_rows > 0) {
	$settingobject = $priceperkmresult->fetch_assoc();
	$Dietitian_rate = $settingobject["setting_value"];
}

$sqlpriceperkm = "SELECT * FROM settings WHERE setting_item='Optometrist_rate'";
$priceperkmresult = $db->query($sqlpriceperkm);
if ($priceperkmresult->num_rows > 0) {
	$settingobject = $priceperkmresult->fetch_assoc();
	$Optometrist_rate = $settingobject["setting_value"];
}
$sqlpriceperkm = "SELECT * FROM settings WHERE setting_item='Occupational_Therapist_rate'";
$priceperkmresult = $db->query($sqlpriceperkm);
if ($priceperkmresult->num_rows > 0) {
	$settingobject = $priceperkmresult->fetch_assoc();
	$Occupational_Therapist_rate = $settingobject["setting_value"];
}

$sqlpriceperkm = "SELECT * FROM settings WHERE setting_item='Speech_and_Language_Therapist_rate'";
$priceperkmresult = $db->query($sqlpriceperkm);
if ($priceperkmresult->num_rows > 0) {
	$settingobject = $priceperkmresult->fetch_assoc();
	$Speech_and_Language_Therapist_rate = $settingobject["setting_value"];
}

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Teleconsultation Rate Setting</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Rate setting</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->

        <div class="container-fluid">
			<?php
			if(isset($response)){
				echo '<p>'.$response.'</p>';
			}
			?>
			<form method="POST">
				<div class="form-group">
					<label for="">Doctor</label>
					<input type="number" step="0.1" name="Doctor_rate" id="Doctor_rate" class="form-control" value="<?php echo $Doctor_rate; ?>">
				</div>				
				<div class="form-group">
					<label for="">Dentist</label>
					<input type="number" step="0.1" name="Dentist_rate" id="Dentist_rate" class="form-control" value="<?php echo $Dentist_rate; ?>">
				</div>					
				<div class="form-group">
					<label for="">Nutritionist_rate</label>
					<input type="number" step="0.1" name="Nutritionist_rate" id="Nutritionist_rate" class="form-control" value="<?php echo $Nutritionist_rate; ?>">
				</div>					
				<div class="form-group">
					<label for="">Psychologist_rate</label>
					<input type="number" step="0.1" name="Psychologist_rate" id="Psychologist_rate" class="form-control" value="<?php echo $Psychologist_rate; ?>">
				</div>					
				<div class="form-group">
					<label for="">Physiotherapist_rate</label>
					<input type="number" step="0.1" name="Physiotherapist_rate" id="Physiotherapist_rate" class="form-control" value="<?php echo $Physiotherapist_rate; ?>">
				</div>						
				<div class="form-group">
					<label for="">Dietitian_rate</label>
					<input type="number" step="0.1" name="Dietitian_rate" id="Dietitian_rate" class="form-control" value="<?php echo $Dietitian_rate; ?>">
				</div>					
				<div class="form-group">
					<label for="">Optometrist_rate</label>
					<input type="number" step="0.1" name="Optometrist_rate" id="Optometrist_rate" class="form-control" value="<?php echo $Optometrist_rate; ?>">
				</div>					
				<div class="form-group">
					<label for="">Occupational_Therapist_rate</label>
					<input type="number" step="0.1" name="Occupational_Therapist_rate" id="Occupational_Therapist_rate" class="form-control" value="<?php echo $Occupational_Therapist_rate; ?>">
				</div>					
				<div class="form-group">
					<label for="">Speech_and_Language_Therapist_rate</label>
					<input type="number" step="0.1" name="Speech_and_Language_Therapist_rate" id="Speech_and_Language_Therapist_rate" class="form-control" value="<?php echo $Speech_and_Language_Therapist_rate; ?>">
				</div>			
			
				<div class="form-group">
					<button type="submit" name="update_rate" id="update_rate" class="btn btn-primary">Save Changes</button>
				</div>					
			</form>
		</div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->