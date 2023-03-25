<?php
if(isset($_POST["update_parcel"])){
	$video_call_rate = cleanInput($_POST["video_call_rate"]);
	$spcommision = cleanInput($_POST["spcommision"]);
	$productmargin = cleanInput($_POST["productmargin"]);
	$ridercommision = cleanInput($_POST["ridercommision"]);
	$inhouserate = cleanInput($_POST["inhouserate"]);
	$chat_rate = cleanInput($_POST["chat_rate"]);
	$walkincenter = $_POST["walkincenter"];
	$sql1 = "UPDATE settings SET setting_value='$video_call_rate' WHERE setting_item='video_call_rate'";

	if ($db->query($sql1) === TRUE) {
	   $res = "Record updated successfully";
	} else {
	   $res =  "Error updating record: " . $db->error;
	}
	$sql1 = "UPDATE settings SET setting_value='$chat_rate' WHERE setting_item='chat_rate'";

	if ($db->query($sql1) === TRUE) {
	   $res = "Record updated successfully";
	} else {
	   $res =  "Error updating record: " . $db->error;
	}
	$sql1 = "UPDATE settings SET setting_value='$walkincenter' WHERE setting_item='epinkcenter'";

	if ($db->query($sql1) === TRUE) {
	   $res = "Record updated successfully";
	} else {
	   $res =  "Error updating record: " . $db->error;
	}
	$sql1 = "UPDATE settings SET setting_value='$spcommision' WHERE setting_item='spcommision'";

	if ($db->query($sql1) === TRUE) {
	   $res = "Record updated successfully";
	} else {
	   $res =  "Error updating record: " . $db->error;
	}
	$sql1 = "UPDATE settings SET setting_value='$inhouserate' WHERE setting_item='inhouserate'";

	if ($db->query($sql1) === TRUE) {
	   $res = "Record updated successfully";
	} else {
	   $res =  "Error updating record: " . $db->error;
	}
	$sql1 = "UPDATE settings SET setting_value='$ridercommision' WHERE setting_item='ridercommision'";

	if ($db->query($sql1) === TRUE) {
	   $res = "Record updated successfully";
	} else {
	   $res =  "Error updating record: " . $db->error;
	}
	$sql1 = "UPDATE settings SET setting_value='$productmargin' WHERE setting_item='productmargin'";

	if ($db->query($sql1) === TRUE) {
	   $res = "Record updated successfully";
	} else {
	   $res =  "Error updating record: " . $db->error;
	}
}

$sqlpriceperkm = "SELECT * FROM settings WHERE setting_item='video_call_rate'";
$priceperkmresult = $db->query($sqlpriceperkm);
if ($priceperkmresult->num_rows > 0) {
	$settingobject = $priceperkmresult->fetch_assoc();
	$videcallrate = $settingobject["setting_value"];
}
$sqlpriceperkm = "SELECT * FROM settings WHERE setting_item='chat_rate'";
$priceperkmresult = $db->query($sqlpriceperkm);
if ($priceperkmresult->num_rows > 0) {
	$settingobject = $priceperkmresult->fetch_assoc();
	$chat_rate = $settingobject["setting_value"];
}

$sqlpriceperkm = "SELECT * FROM settings WHERE setting_item='epinkcenter'";
$priceperkmresult = $db->query($sqlpriceperkm);
if ($priceperkmresult->num_rows > 0) {
	$settingobject = $priceperkmresult->fetch_assoc();
	$epinkcenter = $settingobject["setting_value"];
}

$sqlpriceperkm = "SELECT * FROM settings WHERE setting_item='spcommision'";
$priceperkmresult = $db->query($sqlpriceperkm);
if ($priceperkmresult->num_rows > 0) {
	$settingobject = $priceperkmresult->fetch_assoc();
	$spcommision = $settingobject["setting_value"];
}

$sqlpriceperkm = "SELECT * FROM settings WHERE setting_item='ridercommision'";
$priceperkmresult = $db->query($sqlpriceperkm);
if ($priceperkmresult->num_rows > 0) {
	$settingobject = $priceperkmresult->fetch_assoc();
	$ridercommision = $settingobject["setting_value"];
}

$sqlpriceperkm = "SELECT * FROM settings WHERE setting_item='inhouserate'";
$priceperkmresult = $db->query($sqlpriceperkm);
if ($priceperkmresult->num_rows > 0) {
	$settingobject = $priceperkmresult->fetch_assoc();
	$inhouserate = $settingobject["setting_value"];
}

$sqlpriceperkm = "SELECT * FROM settings WHERE setting_item='productmargin'";
$priceperkmresult = $db->query($sqlpriceperkm);
if ($priceperkmresult->num_rows > 0) {
	$settingobject = $priceperkmresult->fetch_assoc();
	$productmargin = $settingobject["setting_value"];
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>System Setting</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">System setting</li>
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
				<div style="display: none">
					<div class="form-group">
					
						<label for="">Video Call Rate</label>
						<input type="number" step="0.1" name="video_call_rate" id="video_call_rate" class="form-control" value="<?php echo $videcallrate; ?>">
					</div>			
					<div class="form-group">
						<label for="">Chat Rate</label>
						<input type="number" step="0.1" name="chat_rate" id="chat_rate" class="form-control" value="<?php echo $chat_rate; ?>">
					</div>
				</div>
				<div class="form-group">
						<label for="">Deducttion percentage(%) from service provider</label>
						<input type="number" step="0.1" name="spcommision" id="spcommision" class="form-control" value="<?php echo $spcommision; ?>">
					</div>
					<div class="form-group">
						<label for="">Product Margin(%)</label>
						<input type="number" step="0.1" name="productmargin" id="productmargin" class="form-control" value="<?php echo $productmargin; ?>">
					</div>
				<div class="form-group">
						<label for="">Inhouse Rate/Session(RM)</label>
						<input type="number" step="0.1" name="inhouserate" id="inhouserate" class="form-control" value="<?php echo $inhouserate; ?>">
				</div>
				<div class="form-group">
						<label for="">Rider Commision(%)</label>
						<input type="number" step="0.1" name="ridercommision" id="ridercommision" class="form-control" value="<?php echo $ridercommision; ?>">
				</div>					
				<div class="form-group">
					<p class="strong"><b>Walk In Center</b></p>
					<div class="card">
						<div class="card-body">
							<div class="row">
							<div class="col-sm-3"><b>Name</b></div><div class="col-sm-3"><b>Address</b></div><div class="col-sm-3"><b>Cordinate</b></div><div class="col-sm-3"><b>Action</b></div>
							</div>
							<div class="row" id="walkincenterlist">
							</div>
						</div>
						<div class="card-footer">
							<div class="row">
								<div class="col-sm-2">
									<input type="text" id="nametoadd" class="form-control" placeholder="Name">
								</div>
								<div class="col-sm-3">
									<input type="text" id="addresstoadd" class="form-control" placeholder="Address">
								</div>
								<div class="col-sm-2">
									<input type="text" id="lattoadd" class="form-control" placeholder="Latitude">
								</div>
								<div class="col-sm-2">
									<input type="text" id="lngtoadd" class="form-control" placeholder="Longitude">
								</div>
								<div class="col-sm-3">
									<input type="text" id="phonetoadd" class="form-control" placeholder="Number phone">
								</div>
								<div class="col-sm-12">
								<br>
									<a href="#!" class="btn btn-primary " style="width: 100%" onclick="addCenter()">Add</a>
									<p>Dont forget to save changes after every update</p>
								</div>
							</div>
						</div>
					</div>
					<textarea class="form-control" id="walkincenter" name="walkincenter" hidden><?php echo $epinkcenter; ?>
					</textarea>
				</div>
				<div class="form-group">
					<button type="submit" name="update_parcel" id="update_parcel" class="btn btn-primary">Save Changes</button>
				</div>					
			</form>
		</div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>
function addCenter(){
	var walkingCenter = JSON.parse(document.getElementById("walkincenter").value);
	var centerName = document.getElementById("nametoadd").value;
	var centerAddress = document.getElementById("addresstoadd").value;
	var centerLat = document.getElementById("lattoadd").value;
	var centerLng = document.getElementById("lngtoadd").value;
	var phonenumber = document.getElementById("phonetoadd").value;
	var data = {"name": centerName, "address": centerAddress, "lat": centerLat, "lng": centerLng, "phone_number":phonenumber};
	walkingCenter.push(data);
	var inner = JSON.stringify(walkingCenter);
	document.getElementById("walkincenter").value = inner;
	initWalkingCenter();
	document.getElementById("nametoadd").value = "";
	document.getElementById("addresstoadd").value = "";
	document.getElementById("lattoadd").value = "";
	document.getElementById("lngtoadd").value = "";
	document.getElementById("lngtoadd").value = "";
	
}

function removeCenter(id){
	var walkingCenter = JSON.parse(document.getElementById("walkincenter").value);
	walkingCenter.splice(id, 1);
	document.getElementById("walkincenter").value = JSON.stringify(walkingCenter);
	initWalkingCenter();
}
function initWalkingCenter(){
	document.getElementById("walkincenterlist").innerHTML = "";
	console.log(document.getElementById("walkincenter").value);
	var walkingCenter = JSON.parse(document.getElementById("walkincenter").value);
	console.log(walkingCenter);
	for (let i = 0; i < walkingCenter.length; i++) {
		document.getElementById("walkincenterlist").innerHTML += '<div class="col-sm-3">'+walkingCenter[i].name+'<br>'+walkingCenter[i].phone_number+'</div><div class="col-sm-3">'+walkingCenter[i].address+'</div><div class="col-sm-3">Latitude: '+walkingCenter[i].lat+'<br>Longitude: '+walkingCenter[i].lng+'</div><div class="col-sm-3"><a href="#!" class="btn btn-primary" onclick="removeCenter('+i+')">Remove</a></div>';
	}
}
initWalkingCenter();
</script>