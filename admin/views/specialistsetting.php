<?php
if(isset($_POST["Anaesthesiology"])){
	$rate = cleanInput($_POST["Anaesthesiology"]);
	$sql = "UPDATE settings SET setting_value='$rate' WHERE setting_item='Anaesthesiology'";
	if ($db->query($sql) === TRUE) {
		$response = 'Anaesthesiology rate updated';
	} else {
		$response = "Error updating record: " . $db->error;
	}
}


$sqlset = "SELECT * FROM settings WHERE setting_item='Anaesthesiology'";
$set = $db->query($sqlset);
if ($set->num_rows > 0) {
	$setrow = $set->fetch_assoc();
	$Anaesthesiology = $setrow["setting_value"];
}


if(isset($_POST["Emergency_medicine"])){
	$rate = cleanInput($_POST["Emergency_medicine"]);
	$sql = "UPDATE settings SET setting_value='$rate' WHERE setting_item='Emergency medicine'";
	if ($db->query($sql) === TRUE) {
		$response = 'Emergency_medicine rate updated';
	} else {
		$response = "Error updating record: " . $db->error;
	}
}


$sqlset = "SELECT * FROM settings WHERE setting_item='Emergency medicine'";
$set = $db->query($sqlset);
if ($set->num_rows > 0) {
	$setrow = $set->fetch_assoc();
	$Emergency_medicine = $setrow["setting_value"];
}

if(isset($_POST["Family_medicine"])){
	$rate = cleanInput($_POST["Family_medicine"]);
	$sql = "UPDATE settings SET setting_value='$rate' WHERE setting_item='Family medicine'";
	if ($db->query($sql) === TRUE) {
		$response = 'Family medicine rate updated';
	} else {
		$response = "Error updating record: " . $db->error;
	}
}


$sqlset = "SELECT * FROM settings WHERE setting_item='Family medicine'";
$set = $db->query($sqlset);
if ($set->num_rows > 0) {
	$setrow = $set->fetch_assoc();
	$Family_medicine = $setrow["setting_value"];
}

if(isset($_POST["Internal_medicine"])){
	$rate = cleanInput($_POST["Internal_medicine"]);
	$sql = "UPDATE settings SET setting_value='$rate' WHERE setting_item='Internal medicine'";
	if ($db->query($sql) === TRUE) {
		$response = 'Internal medicine rate updated';
	} else {
		$response = "Error updating record: " . $db->error;
	}
}


$sqlset = "SELECT * FROM settings WHERE setting_item='Internal medicine'";
$set = $db->query($sqlset);
if ($set->num_rows > 0) {
	$setrow = $set->fetch_assoc();
	$Internal_medicine = $setrow["setting_value"];
}

if(isset($_POST["Nuclear_medicine"])){
	$rate = cleanInput($_POST["Nuclear_medicine"]);
	$sql = "UPDATE settings SET setting_value='$rate' WHERE setting_item='Nuclear medicine'";
	if ($db->query($sql) === TRUE) {
		$response = 'Nuclear medicine rate updated';
	} else {
		$response = "Error updating record: " . $db->error;
	}
}


$sqlset = "SELECT * FROM settings WHERE setting_item='Nuclear medicine'";
$set = $db->query($sqlset);
if ($set->num_rows > 0) {
	$setrow = $set->fetch_assoc();
	$Nuclear_medicine = $setrow["setting_value"];
}

if(isset($_POST["Rehabilitation_medicine"])){
	$rate = cleanInput($_POST["Rehabilitation_medicine"]);
	$sql = "UPDATE settings SET setting_value='$rate' WHERE setting_item='Rehabilitation medicine'";
	if ($db->query($sql) === TRUE) {
		$response = 'Nuclear medicine rate updated';
	} else {
		$response = "Error updating record: " . $db->error;
	}
}


$sqlset = "SELECT * FROM settings WHERE setting_item='Rehabilitation medicine'";
$set = $db->query($sqlset);
if ($set->num_rows > 0) {
	$setrow = $set->fetch_assoc();
	$Rehabilitation_medicine = $setrow["setting_value"];
}

if(isset($_POST["Sports_medicine"])){
	$rate = cleanInput($_POST["Sports_medicine"]);
	$sql = "UPDATE settings SET setting_value='$rate' WHERE setting_item='Sports medicine'";
	if ($db->query($sql) === TRUE) {
		$response = 'Sports medicine rate updated';
	} else {
		$response = "Error updating record: " . $db->error;
	}
}


$sqlset = "SELECT * FROM settings WHERE setting_item='Sports medicine'";
$set = $db->query($sqlset);
if ($set->num_rows > 0) {
	$setrow = $set->fetch_assoc();
	$Sports_medicine = $setrow["setting_value"];
}

if(isset($_POST["Oncology"])){
	$rate = cleanInput($_POST["Oncology"]);
	$sql = "UPDATE settings SET setting_value='$rate' WHERE setting_item='Oncology'";
	if ($db->query($sql) === TRUE) {
		$response = 'Oncology rate updated';
	} else {
		$response = "Error updating record: " . $db->error;
	}
}


$sqlset = "SELECT * FROM settings WHERE setting_item='Oncology'";
$set = $db->query($sqlset);
if ($set->num_rows > 0) {
	$setrow = $set->fetch_assoc();
	$Oncology = $setrow["setting_value"];
}

if(isset($_POST["Clincial_radiology"])){
	$rate = cleanInput($_POST["Clincial_radiology"]);
	$sql = "UPDATE settings SET setting_value='$rate' WHERE setting_item='Clincial radiology'";
	if ($db->query($sql) === TRUE) {
		$response = 'Clincial radiology rate updated';
	} else {
		$response = "Error updating record: " . $db->error;
	}
}


$sqlset = "SELECT * FROM settings WHERE setting_item='Clincial radiology'";
$set = $db->query($sqlset);
if ($set->num_rows > 0) {
	$setrow = $set->fetch_assoc();
	$Clincial_radiology = $setrow["setting_value"];
}


if(isset($_POST["Paediatrics"])){
	$rate = cleanInput($_POST["Paediatrics"]);
	$sql = "UPDATE settings SET setting_value='$rate' WHERE setting_item='Paediatrics'";
	if ($db->query($sql) === TRUE) {
		$response = 'Paediatrics rate updated';
	} else {
		$response = "Error updating record: " . $db->error;
	}
}


$sqlset = "SELECT * FROM settings WHERE setting_item='Paediatrics'";
$set = $db->query($sqlset);
if ($set->num_rows > 0) {
	$setrow = $set->fetch_assoc();
	$Paediatrics = $setrow["setting_value"];
}

if(isset($_POST["General_pathology"])){
	$rate = cleanInput($_POST["General_pathology"]);
	$sql = "UPDATE settings SET setting_value='$rate' WHERE setting_item='General pathology'";
	if ($db->query($sql) === TRUE) {
		$response = 'General pathology rate updated';
	} else {
		$response = "Error updating record: " . $db->error;
	}
}


$sqlset = "SELECT * FROM settings WHERE setting_item='General pathology'";
$set = $db->query($sqlset);
if ($set->num_rows > 0) {
	$setrow = $set->fetch_assoc();
	$General_pathology = $setrow["setting_value"];
}

if(isset($_POST["Anatomical_pathology"])){
	$rate = cleanInput($_POST["Anatomical_pathology"]);
	$sql = "UPDATE settings SET setting_value='$rate' WHERE setting_item='Anatomical pathology'";
	if ($db->query($sql) === TRUE) {
		$response = 'Anatomical pathology rate updated';
	} else {
		$response = "Error updating record: " . $db->error;
	}
}


$sqlset = "SELECT * FROM settings WHERE setting_item='Anatomical pathology'";
$set = $db->query($sqlset);
if ($set->num_rows > 0) {
	$setrow = $set->fetch_assoc();
	$Anatomical_pathology = $setrow["setting_value"];
}if(isset($_POST["Anatomical_pathology"])){
	$rate = cleanInput($_POST["Anatomical_pathology"]);
	$sql = "UPDATE settings SET setting_value='$rate' WHERE setting_item='Anatomical pathology'";
	if ($db->query($sql) === TRUE) {
		$response = 'Anatomical pathology rate updated';
	} else {
		$response = "Error updating record: " . $db->error;
	}
}


$sqlset = "SELECT * FROM settings WHERE setting_item='Anatomical pathology'";
$set = $db->query($sqlset);
if ($set->num_rows > 0) {
	$setrow = $set->fetch_assoc();
	$Anatomical_pathology = $setrow["setting_value"];
}



if(isset($_POST["Haematology"])){
	$rate = cleanInput($_POST["Haematology"]);
	$sql = "UPDATE settings SET setting_value='$rate' WHERE setting_item='Haematology'";
	if ($db->query($sql) === TRUE) {
		$response = 'Haematology rate updated';
	} else {
		$response = "Error updating record: " . $db->error;
	}
}

$sqlset = "SELECT * FROM settings WHERE setting_item='Haematology'";
$set = $db->query($sqlset);
if ($set->num_rows > 0) {
	$setrow = $set->fetch_assoc();
	$Haematology = $setrow["setting_value"];
}

if(isset($_POST["Chemical_pathology"])){
	$rate = cleanInput($_POST["Chemical_pathology"]);
	$sql = "UPDATE settings SET setting_value='$rate' WHERE setting_item='Chemical pathology'";
	if ($db->query($sql) === TRUE) {
		$response = 'Chemical pathology rate updated';
	} else {
		$response = "Error updating record: " . $db->error;
	}
}

$sqlset = "SELECT * FROM settings WHERE setting_item='Chemical pathology'";
$set = $db->query($sqlset);
if ($set->num_rows > 0) {
	$setrow = $set->fetch_assoc();
	$Chemical_pathology = $setrow["setting_value"];
}

if(isset($_POST["Medical_microbiology"])){
	$rate = cleanInput($_POST["Medical_microbiology"]);
	$sql = "UPDATE settings SET setting_value='$rate' WHERE setting_item='Medical microbiology'";
	if ($db->query($sql) === TRUE) {
		$response = 'Medical microbiology rate updated';
	} else {
		$response = "Error updating record: " . $db->error;
	}
}

$sqlset = "SELECT * FROM settings WHERE setting_item='Medical microbiology'";
$set = $db->query($sqlset);
if ($set->num_rows > 0) {
	$setrow = $set->fetch_assoc();
	$Medical_microbiology = $setrow["setting_value"];
}

if(isset($_POST["Forensic_pathology"])){
	$rate = cleanInput($_POST["Forensic_pathology"]);
	$sql = "UPDATE settings SET setting_value='$rate' WHERE setting_item='Forensic pathology'";
	if ($db->query($sql) === TRUE) {
		$response = 'Forensic pathology rate updated';
	} else {
		$response = "Error updating record: " . $db->error;
	}
}

$sqlset = "SELECT * FROM settings WHERE setting_item='Forensic pathology'";
$set = $db->query($sqlset);
if ($set->num_rows > 0) {
	$setrow = $set->fetch_assoc();
	$Forensic_pathology = $setrow["setting_value"];
}
if(isset($_POST["Transfusion_medicine"])){
	$rate = cleanInput($_POST["Transfusion_medicine"]);
	$sql = "UPDATE settings SET setting_value='$rate' WHERE setting_item='Transfusion medicine'";
	if ($db->query($sql) === TRUE) {
		$response = 'Transfusion medicine rate updated';
	} else {
		$response = "Error updating record: " . $db->error;
	}
}

$sqlset = "SELECT * FROM settings WHERE setting_item='Transfusion medicine'";
$set = $db->query($sqlset);
if ($set->num_rows > 0) {
	$setrow = $set->fetch_assoc();
	$Transfusion_medicine = $setrow["setting_value"];
}

if(isset($_POST["Psychiatry"])){
	$rate = cleanInput($_POST["Psychiatry"]);
	$sql = "UPDATE settings SET setting_value='$rate' WHERE setting_item='Psychiatry'";
	if ($db->query($sql) === TRUE) {
		$response = 'Psychiatry rate updated';
	} else {
		$response = "Error updating record: " . $db->error;
	}
}

$sqlset = "SELECT * FROM settings WHERE setting_item='Psychiatry'";
$set = $db->query($sqlset);
if ($set->num_rows > 0) {
	$setrow = $set->fetch_assoc();
	$Psychiatry = $setrow["setting_value"];
}

if(isset($_POST["Public_health"])){
	$rate = cleanInput($_POST["Public_health"]);
	$sql = "UPDATE settings SET setting_value='$rate' WHERE setting_item='Public health'";
	if ($db->query($sql) === TRUE) {
		$response = 'Public health rate updated';
	} else {
		$response = "Error updating record: " . $db->error;
	}
}

$sqlset = "SELECT * FROM settings WHERE setting_item='Public health'";
$set = $db->query($sqlset);
if ($set->num_rows > 0) { 
	$setrow = $set->fetch_assoc();
	$Public_health = $setrow["setting_value"];
}

if(isset($_POST["Obstetrics_and_gynaecology"])){
	$rate = cleanInput($_POST["Obstetrics_and_gynaecology"]);
	$sql = "UPDATE settings SET setting_value='$rate' WHERE setting_item='Obstetrics and gynaecology'";
	if ($db->query($sql) === TRUE) {
		$response = 'Obstetrics and gynaecology rate updated';
	} else {
		$response = "Error updating record: " . $db->error;
	}
}

$sqlset = "SELECT * FROM settings WHERE setting_item='Obstetrics and gynaecology'";
$set = $db->query($sqlset);
if ($set->num_rows > 0) { 
	$setrow = $set->fetch_assoc();
	$Obstetrics_and_gynaecology = $setrow["setting_value"];
}

if(isset($_POST["Surgery"])){
	$rate = cleanInput($_POST["Surgery"]);
	$sql = "UPDATE settings SET setting_value='$rate' WHERE setting_item='Surgery'";
	if ($db->query($sql) === TRUE) {
		$response = 'Surgery rate updated';
	} else {
		$response = "Error updating record: " . $db->error;
	}
}

$sqlset = "SELECT * FROM settings WHERE setting_item='Surgery'";
$set = $db->query($sqlset);
if ($set->num_rows > 0) { 
	$setrow = $set->fetch_assoc();
	$Surgery = $setrow["setting_value"];
}

if(isset($_POST["Cardiothoracic_surgery"])){
	$rate = cleanInput($_POST["Cardiothoracic_surgery"]);
	$sql = "UPDATE settings SET setting_value='$rate' WHERE setting_item='Cardiothoracic surgery'";
	if ($db->query($sql) === TRUE) {
		$response = 'Cardiothoracic surgery rate updated';
	} else {
		$response = "Error updating record: " . $db->error;
	}
}

$sqlset = "SELECT * FROM settings WHERE setting_item='Cardiothoracic surgery'";
$set = $db->query($sqlset);
if ($set->num_rows > 0) { 
	$setrow = $set->fetch_assoc();
	$Cardiothoracic_surgery = $setrow["setting_value"];
}

if(isset($_POST["Neurosurgery"])){
	$rate = cleanInput($_POST["Neurosurgery"]);
	$sql = "UPDATE settings SET setting_value='$rate' WHERE setting_item='Neurosurgery'";
	if ($db->query($sql) === TRUE) {
		$response = 'Neurosurgery rate updated';
	} else {
		$response = "Error updating record: " . $db->error;
	}
}

$sqlset = "SELECT * FROM settings WHERE setting_item='Neurosurgery'";
$set = $db->query($sqlset);
if ($set->num_rows > 0) { 
	$setrow = $set->fetch_assoc();
	$Neurosurgery = $setrow["setting_value"];
}

if(isset($_POST["Plastic_surgery"])){
	$rate = cleanInput($_POST["Plastic_surgery"]);
	$sql = "UPDATE settings SET setting_value='$rate' WHERE setting_item='Plastic surgery'";
	if ($db->query($sql) === TRUE) {
		$response = 'Plastic surgery rate updated';
	} else {
		$response = "Error updating record: " . $db->error;
	}
}

$sqlset = "SELECT * FROM settings WHERE setting_item='Plastic surgery'";
$set = $db->query($sqlset);
if ($set->num_rows > 0) { 
	$setrow = $set->fetch_assoc();
	$Plastic_surgery = $setrow["setting_value"];
}

if(isset($_POST["Paediatric_surgery"])){
	$rate = cleanInput($_POST["Paediatric_surgery"]);
	$sql = "UPDATE settings SET setting_value='$rate' WHERE setting_item='Paediatric surgery'";
	if ($db->query($sql) === TRUE) {
		$response = 'Paediatric surgery rate updated';
	} else {
		$response = "Error updating record: " . $db->error;
	}
}

$sqlset = "SELECT * FROM settings WHERE setting_item='Paediatric surgery'";
$set = $db->query($sqlset);
if ($set->num_rows > 0) { 
	$setrow = $set->fetch_assoc();
	$Paediatric_surgery = $setrow["setting_value"];
}

if(isset($_POST["Ophthalmology"])){
	$rate = cleanInput($_POST["Ophthalmology"]);
	$sql = "UPDATE settings SET setting_value='$rate' WHERE setting_item='Ophthalmology'";
	if ($db->query($sql) === TRUE) {
		$response = 'Ophthalmology rate updated';
	} else {
		$response = "Error updating record: " . $db->error;
	}
}

$sqlset = "SELECT * FROM settings WHERE setting_item='Ophthalmology'";
$set = $db->query($sqlset);
if ($set->num_rows > 0) { 
	$setrow = $set->fetch_assoc();
	$Ophthalmology = $setrow["setting_value"];
}

if(isset($_POST["Otorhinolaryngology"])){
	$rate = cleanInput($_POST["Otorhinolaryngology"]);
	$sql = "UPDATE settings SET setting_value='$rate' WHERE setting_item='Otorhinolaryngology'";
	if ($db->query($sql) === TRUE) {
		$response = 'Otorhinolaryngology rate updated';
	} else {
		$response = "Error updating record: " . $db->error;
	}
}

$sqlset = "SELECT * FROM settings WHERE setting_item='Otorhinolaryngology'";
$set = $db->query($sqlset);
if ($set->num_rows > 0) { 
	$setrow = $set->fetch_assoc();
	$Otorhinolaryngology = $setrow["setting_value"];
}

if(isset($_POST["Orthopaedic_surgery"])){
	$rate = cleanInput($_POST["Orthopaedic_surgery"]);
	$sql = "UPDATE settings SET setting_value='$rate' WHERE setting_item='Orthopaedic surgery'";
	if ($db->query($sql) === TRUE) {
		$response = 'Orthopaedic surgery rate updated';
	} else {
		$response = "Error updating record: " . $db->error;
	}
}

$sqlset = "SELECT * FROM settings WHERE setting_item='Orthopaedic surgery'";
$set = $db->query($sqlset);
if ($set->num_rows > 0) { 
	$setrow = $set->fetch_assoc();
	$Orthopaedic_surgery = $setrow["setting_value"];
}

if(isset($_POST["Urology"])){
	$rate = cleanInput($_POST["Urology"]);
	$sql = "UPDATE settings SET setting_value='$rate' WHERE setting_item='Urology'";
	if ($db->query($sql) === TRUE) {
		$response = 'Urology rate updated';
	} else {
		$response = "Error updating record: " . $db->error;
	}
}

$sqlset = "SELECT * FROM settings WHERE setting_item='Urology'";
$set = $db->query($sqlset);
if ($set->num_rows > 0) { 
	$setrow = $set->fetch_assoc();
	$Urology = $setrow["setting_value"];
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Specialist Setting</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Specialist setting</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="container-fluid">
			<?php
			if(isset($response)){
				echo $response;
			}
			
			?>
		
			
			<form method="POST">
				<div class="form-group">
					<label>Anaesthesiology Rate</label>
					<input type="number" name="Anaesthesiology" id="Anaesthesiology" value="<?php echo $Anaesthesiology; ?>" class="form-control">
				</div>
				<button class="btn btn-primary">SUBMIT</button>
			</form>


			
			<form method="POST">
				<div class="form-group">
					<label>Emergency medicine Rate</label>
					<input type="number" name="Emergency_medicine" id="Emergency_medicine" value="<?php echo $Emergency_medicine; ?>" class="form-control">
				</div>
				<button class="btn btn-primary">SUBMIT</button>
			</form>
			
			<form method="POST">
				<div class="form-group">
					<label>Family medicine Rate</label>
					<input type="number" name="Family_medicine" id="Family_medicine" value="<?php echo $Family_medicine; ?>" class="form-control">
				</div>
				<button class="btn btn-primary">SUBMIT</button>
			</form>

			<form method="POST">
				<div class="form-group">
					<label>Internal medicine Rate</label>
					<input type="number" name="Internal_medicine" id="Internal_medicine" value="<?php echo $Internal_medicine; ?>" class="form-control">
				</div>
				<button class="btn btn-primary">SUBMIT</button>
			</form>	
			
			<form method="POST">
				<div class="form-group">
					<label>Nuclear medicine Rate</label>
					<input type="number" name="Nuclear_medicine" id="Nuclear_medicine" value="<?php echo $Nuclear_medicine; ?>" class="form-control">
				</div>
				<button class="btn btn-primary">SUBMIT</button>
			</form>					
			<form method="POST">
				<div class="form-group">
					<label>Rehabilitation medicine Rate</label>
					<input type="number" name="Rehabilitation_medicine" id="Rehabilitation_medicine" value="<?php echo $Rehabilitation_medicine; ?>" class="form-control">
				</div>
				<button class="btn btn-primary">SUBMIT</button>
			</form>

			<form method="POST">
				<div class="form-group">
					<label>Sports medicine Rate</label>
					<input type="number" name="Sports_medicine" id="Sports_medicine" value="<?php echo $Sports_medicine; ?>" class="form-control">
				</div>
				<button class="btn btn-primary">SUBMIT</button>
			</form>				
			
			<form method="POST">
				<div class="form-group">
					<label>Oncology</label>
					<input type="number" name="Oncology" id="Oncology" value="<?php echo $Oncology; ?>" class="form-control">
				</div>
				<button class="btn btn-primary">SUBMIT</button>
			</form>				
			
			<form method="POST">
				<div class="form-group">
					<label>Clincial radiology</label>
					<input type="number" name="Clincial_radiology" id="Clincial_radiology" value="<?php echo $Clincial_radiology; ?>" class="form-control">
				</div>
				<button class="btn btn-primary">SUBMIT</button>
			</form>	
			<form method="POST">
				<div class="form-group">
					<label>Paediatrics</label>
					<input type="number" name="Paediatrics" id="Paediatrics" value="<?php echo $Paediatrics; ?>" class="form-control">
				</div>
				<button class="btn btn-primary">SUBMIT</button>
			</form>
			<form method="POST">
				<div class="form-group">
					<label>General pathology</label>
					<input type="number" name="General_pathology" id="General_pathology" value="<?php echo $General_pathology; ?>" class="form-control">
				</div>
				<button class="btn btn-primary">SUBMIT</button>
			</form>
			<form method="POST">
				<div class="form-group">
					<label>Anatomical pathology</label>
					<input type="number" name="Anatomical_pathology" id="Anatomical_pathology" value="<?php echo $Anatomical_pathology; ?>" class="form-control">
				</div>
				<button class="btn btn-primary">SUBMIT</button>
			</form>
			<form method="POST">
				<div class="form-group">
					<label>Chemical pathology</label>
					<input type="number" name="Chemical_pathology" id="Chemical_pathology" value="<?php echo $Chemical_pathology; ?>" class="form-control">
				</div>
				<button class="btn btn-primary">SUBMIT</button>
			</form>
			<form method="POST">
				<div class="form-group">
					<label>Haematology Rate</label>
					<input type="number" name="Haematology" id="Haematology" value="<?php echo $Haematology; ?>" class="form-control">
				</div>
				<button class="btn btn-primary">SUBMIT</button>
			</form>
			<form method="POST">
				<div class="form-group">
					<label>Medical microbiology</label>
					<input type="number" name="Medical microbiology" id="Medical microbiology" value="<?php echo $Medical_microbiology; ?>" class="form-control">
				</div>
				<button class="btn btn-primary">SUBMIT</button>
			</form>
			<form method="POST">
				<div class="form-group">
					<label>Forensic pathology</label>
					<input type="number" name="Forensic_pathology" id="Forensic_pathology" value="<?php echo $Forensic_pathology; ?>" class="form-control">
				</div>
				<button class="btn btn-primary">SUBMIT</button>
			</form>	
			<form method="POST">
				<div class="form-group">
					<label>Transfusion medicine</label>
					<input type="number" name="Transfusion_medicine" id="Transfusion_medicine" value="<?php echo $Transfusion_medicine; ?>" class="form-control">
				</div>
				<button class="btn btn-primary">SUBMIT</button>
			</form>	
			<form method="POST">
				<div class="form-group">
					<label>Psychiatry</label>
					<input type="number" name="Psychiatry" id="Psychiatry" value="<?php echo $Psychiatry; ?>" class="form-control">
				</div>
				<button class="btn btn-primary">SUBMIT</button>
			</form>	
			<form method="POST">
				<div class="form-group">
					<label>Public health</label>
					<input type="number" name="Public_health" id="Public_health" value="<?php echo $Public_health; ?>" class="form-control">
				</div>
				<button class="btn btn-primary">SUBMIT</button>
			</form>				
			
			<form method="POST">
				<div class="form-group">
					<label>Obstetrics and gynaecology</label>
					<input type="number" name="Obstetrics_and_gynaecology" id="Obstetrics_and_gynaecology" value="<?php echo $Obstetrics_and_gynaecology; ?>" class="form-control">
				</div>
				<button class="btn btn-primary">SUBMIT</button>
			</form>				
			<form method="POST">
				<div class="form-group">
					<label>Surgery</label>
					<input type="number" name="Surgery" id="Surgery" value="<?php echo $Surgery; ?>" class="form-control">
				</div>
				<button class="btn btn-primary">SUBMIT</button>
			</form>				
			<form method="POST">
				<div class="form-group">
					<label>Cardiothoracic surgery</label>
					<input type="number" name="Cardiothoracic_surgery" id="Cardiothoracic_surgery" value="<?php echo $Cardiothoracic_surgery; ?>" class="form-control">
				</div>
				<button class="btn btn-primary">SUBMIT</button>
			</form>				
			<form method="POST">
				<div class="form-group">
					<label>Neurosurgery</label>
					<input type="number" name="Neurosurgery" id="Neurosurgery" value="<?php echo $Neurosurgery; ?>" class="form-control">
				</div>
				<button class="btn btn-primary">SUBMIT</button>
			</form>
			<form method="POST">
				<div class="form-group">
					<label>Paediatric surgery</label>
					<input type="number" name="Paediatric_surgery" id="Paediatric_surgery" value="<?php echo $Paediatric_surgery; ?>" class="form-control">
				</div>
				<button class="btn btn-primary">SUBMIT</button>
			</form>	
			<form method="POST">
				<div class="form-group">
					<label>Plastic surgery</label>
					<input type="number" name="Plastic_surgery" id="Plastic_surgery" value="<?php echo $Plastic_surgery; ?>" class="form-control">
				</div>
				<button class="btn btn-primary">SUBMIT</button>
			</form>	
			<form method="POST">
				<div class="form-group">
					<label>Ophthalmology</label>
					<input type="number" name="Ophthalmology" id="Ophthalmology" value="<?php echo $Ophthalmology; ?>" class="form-control">
				</div>
				<button class="btn btn-primary">SUBMIT</button>
			</form>		
			<form method="POST">
				<div class="form-group">
					<label>Otorhinolaryngology</label>
					<input type="number" name="Otorhinolaryngology" id="Otorhinolaryngology" value="<?php echo $Otorhinolaryngology; ?>" class="form-control">
				</div>
				<button class="btn btn-primary">SUBMIT</button>
			</form>		
			<form method="POST">
				<div class="form-group">
					<label>Orthopaedic surgery</label>
					<input type="number" name="Orthopaedic_surgery" id="Orthopaedic_surgery" value="<?php echo $Orthopaedic_surgery; ?>" class="form-control">
				</div>
				<button class="btn btn-primary">SUBMIT</button>
			</form>	
			<form method="POST">
				<div class="form-group">
					<label>Urology</label>
					<input type="number" name="Urology" id="Urology" value="<?php echo $Urology; ?>" class="form-control">
				</div>
				<button class="btn btn-primary">SUBMIT</button>
			</form>				
		</div>
	</section>
</div>