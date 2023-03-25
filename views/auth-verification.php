<?php

?>
<script>
function submitted(){
	document.getElementById("authstatus").innerHTML = 'Verification submitted'
	document.getElementById("vercard").style.display = 'block'
	document.getElementById("verificationform").style.display = 'none'
}
function allowUser(){
	document.getElementById("authstatus").innerHTML = 'Authenticated'
	document.getElementById("vercard").style.display = 'none'
	document.getElementById("verificationform").style.display = 'block'
}

function unallowUser(){
	document.getElementById("authstatus").innerHTML = 'Why are you even here?'
}
function notFound(){
	document.getElementById("authstatus").innerHTML = 'User not found'
}
</script>
<?php
if(isset($page_identifier_action) && $page_identifier_action != ""){
		$login_token = cleanInput($page_identifier_action);
		$sql = "SELECT * FROM users WHERE login_token = '$page_identifier_action'";
		$result = $db->query($sql);
		if ($result->num_rows > 0){
			$row = $result->fetch_assoc();
			$_SESSION["id"] = $row["id"];
			echo '
			<script>
				window.addEventListener("DOMContentLoaded", (event) => {
					allowUser();
				});	
			</script>
			';
			
		} else {
			echo '
			<script>
				window.addEventListener("DOMContentLoaded", (event) => {
					notFound();
				});	
			</script>
			';
			$row["status"] = "Fail";
			$row["message"] = "The record you looking for does not exist";
			$row["card"] = 'red';
			
		}
	$data = $row;
	
}else{
	echo '
			<script>
				window.addEventListener("DOMContentLoaded", (event) => {
					unallowUser();
				});	
			</script>
	';
}

if(isset($_POST["uploadverification"])){
		$login_token = cleanInput($page_identifier_action);
		$sql = "SELECT * FROM users WHERE login_token = '$page_identifier_action'";
		$result = $db->query($sql);
		if ($result->num_rows > 0){
			$row = $result->fetch_assoc();
			$owner = $row["id"];
			$owneremail = $row["email"];
			$organization_name = cleanInput($_POST["organization_name"]);
			$organization_designation = cleanInput($_POST["organization_designation"]);
			$organization_address = cleanInput($_POST["organization_address"]);
			$organization_city = cleanInput($_POST["organization_city"]);
			$organization_state = cleanInput($_POST["organization_state"]);
			$organization_postcode = cleanInput($_POST["organization_postcode"]);
			$organization_country = cleanInput($_POST["organization_country"]);
			$organization_phone_number = cleanInput($_POST["organization_phone_number"]);
			$organization_fax_number = cleanInput($_POST["organization_fax_number"]);
			$organization_registeration_number = cleanInput($_POST["organization_registeration_number"]);
			$sqlu = "UPDATE users SET organization_name='$organization_name', organization_designation='$organization_designation', organization_address='$organization_address', organization_city='$organization_city', organization_state='$organization_state', organization_postcode='$organization_postcode', organization_country='$organization_country', organization_phone_number='$organization_phone_number', organization_fax_number='$organization_fax_number', organization_registeration_number='$organization_registeration_number' WHERE login_token='$login_token'";
			if ($db->query($sqlu) === TRUE) {
				$ic_font = cleanInput($_POST["ic_font"]);
				$ic_back = cleanInput($_POST["ic_back"]);
				$educations_place = cleanInput($_POST["educations_place"]);
				$education_certification = cleanInput($_POST["education_certification"]);
				$apc_number = cleanInput($_POST["apc_number"]);
				$apc_file = cleanInput($_POST["apc_file"]);
				$registeration_body = cleanInput($_POST["registeration_body"]);
				$sql = "INSERT INTO accounts_verification (request_status, owner, verifying_for, ic_font, ic_back, educations_place, education_certification, apc_number, apc_file, registeration_body)
				VALUES ('New', '$owner', '$organization_designation', '$ic_font', '$ic_back', '$educations_place', '$education_certification', '$apc_number', '$apc_file', '$registeration_body')";
				if ($db->query($sql) === TRUE) {
					echo '
					<script>
						window.addEventListener("DOMContentLoaded", (event) => {
							submitted();
						});	
					</script>
					';
				} else {
				 
				}
			}
			
			
		} else {
			echo '
			<script>
				window.addEventListener("DOMContentLoaded", (event) => {
					notFound();
				});	
			</script>
			';
			$row["status"] = "Fail";
			$row["message"] = "The record you looking for does not exist";
			$row["card"] = 'red';
			
		}
}
?>

<header class="bg-white py-10">
	<div class="container bg-white px-5">
		<div id="vercard" class="card"> 
			<div class="card-body">
				<h1>Please wait</h1>
				<p id="authstatus">Authenticating your verification request...</p>
			</div>
		</div>
		<div id="verificationform">
		<form method="POST">
			<h5 class="mb-3">Please complete this form</h5>
			<div class="form-group mb-3">
				<label>IC Front (Image)</label>
				<input class="form-control" type="file" name="icfrontprocessor" onchange="processVerificationfile(this, 'ic_font')" accept="image/png, image/jpeg">
				<input class="form-control  d-none" type="text" id="ic_font" name="ic_font">
				<p class="text-xs">A photo of your IC front</p>
			</div>
			<div class="form-group mb-3">
				<label>IC Back (Image)</label>
				<input class="form-control" type="file" name="icbackprocessor" onchange="processVerificationfile(this, 'ic_back')" accept="image/png, image/jpeg">
				<input class="form-control d-none" type="text" id="ic_back" name="ic_back" >
				<p class="text-xs">A photo of your IC back</p>
			</div>
			<div class="form-group mb-3">
				<label for="educations_place">Place of education</label>
				<input class="form-control" type="text" id="educations_place" name="educations_place" >
				<p class="text-xs">Enter the name of your highest education place (College/University)</p>
			</div>
			<div class="form-group mb-3">
				<label>Diploma / Degree Certificate (PDF)</label>
				<input class="form-control" type="file" name="icbackprocessor" onchange="processVerificationfile(this, 'edufileurl')" accept="application/pdf">
				<input class="form-control d-none" type="text" id="education_certification" name="education_certification" >
				<p class="text-xs">A pdf file of your highest education certificate</p>
			</div>
			<div class="form-group mb-3">
				<label for="apc_number">
				<?php
				if(isset($_GET["pharmacist"])){
					echo 'Pharmacy Board Malaysia Number';
				}else{
					echo 'Malaysian Medical Council Number';
				}
				?>
				</label>
				<input class="form-control" type="text" id="apc_number" name="apc_number" >
				<p class="text-xs">
				<?php
				if(isset($_GET["pharmacist"])){
					echo 'Your number provided by Pharmacy Board Malaysia to you';
				}else{
					echo 'APC Number	';
				}
				?>
				</p>
			</div>
			<div class="form-group mb-3">
				<label>
				<?php
				if(isset($_GET["pharmacist"])){
					echo 'Ceterficiate issued by Pharmacy Board Malaysia(PDF)';
				}else{
					echo 'Ceterficiate issued by Malaysian Medical Council';
				}
				?>
				</label>
				<input class="form-control" type="file" name="icbackprocessor" onchange="processVerificationfile(this, 'edufileurl')" accept="application/pdf">
				<input class="form-control d-none" type="text" id="education_certification" name="education_certification" >
				<p class="text-xs">
				<?php
				if(isset($_GET["pharmacist"])){
					echo 'Ceterficiate issued by Pharmacy Board Malaysia(PDF)';
				}else{
					echo 'Certificate issued by Malaysian Medical Council';
				}
				?>
				</p>
				<div class="form-group mb-3">
					<label for="educations_place">Organization Name</label>
					<input class="form-control" type="text" id="organization_name" name="organization_name" >
					<p class="text-xs">Enter your current practicing place name</p>
				</div>
				<div class="form-group mb-3">
					<label for="organization_registeration_number">Organization registeration number</label>
					<input class="form-control" type="text" id="organization_registeration_number" name="organization_registeration_number">
				</div>
				<div class="form-group mb-3 d-none">
					<label for="organization_designation">Organization Designation</label>
					<input class="form-control" type="text" id="organization_designation" name="organization_designation" value="<?php if(isset($_GET["pharmacist"])){ echo 'Pharmacist'; }else{ echo 'Doctor';}?>">
				</div>
				<div class="form-group mb-3">
					<label for="organization_address">Organization address</label>
					<input class="form-control" type="text" id="organization_address" name="organization_address" >
				</div>
				<div class="form-group mb-3">
					<label for="organization_city">Organization city</label>
					<input class="form-control" type="text" id="organization_city" name="organization_city" >
				</div>
				<div class="form-group mb-3">
					<label for="organization_state">Organization state</label>
					<input class="form-control" type="text" id="organization_state" name="organization_state" >
				</div>
				<div class="form-group mb-3">
					<label for="organization_postcode">Organization postcode</label>
					<input class="form-control" type="text" id="organization_postcode" name="organization_postcode" >
				</div>
				<div class="form-group mb-3">
					<label for="organization_country">Organization country</label>
					<input class="form-control" type="text" id="organization_country" name="organization_country">
				</div>
				<div class="form-group mb-3">
					<label for="organization_phone_number">Organization phone number</label>
					<input class="form-control" type="text" id="organization_phone_number" name="organization_phone_number">
				</div>
				<div class="form-group mb-3">
					<label for="organization_fax_number">Organization Fax</label>
					<input class="form-control" type="text" id="organization_fax_number" name="organization_fax_number">
				</div>
				<div class="form-group mb-3">
					<button type="submit" name="uploadverification" id="uploadverification" class="btn btn-pink">UPLOAD</button>
				</div>
			</form>
			</div>
		</div>
	</div>
</header>
<script>
function processVerificationfile(element, target){
	var fileTypes = ['jpg', 'jpeg', 'png', 'pdf'];  
	var file1 = element.files[0];
	var extension = file1.name.split('.').pop().toLowerCase(),
	 isSuccess = fileTypes.indexOf(extension) 
	var reader = new FileReader();
	reader.onloadend = function() {
		var fileTypes = ['jpg', 'jpeg', 'png', 'pdf'];  
		var file1 = element.files[0];
		var extension = file1.name.split('.').pop().toLowerCase();
		console.log(extension);
		if(extension == "pdf"){
			let dataTopost = "api=1&uploadiconfile="+reader.result;
					let reqSettings = new XMLHttpRequest();
					reqSettings.open("POST", 'https://epink.health/api/', true);
					reqSettings.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
					reqSettings.onload = function() {
						  if(reqSettings.status == 200) {
							let json = reqSettings.responseText;
							let response = JSON.parse(json);
							document.getElementById(target).value = response.iconurl;
						  }else if(reqSettings.status == 404) {
							alert("Fail to connect to our server");
						  }else{
							 alert("Fail to connect to our server"); 
						  } 
					}
			reqSettings.send(dataTopost);
		}else{
			var image = new Image();
			image.src = reader.result;
			image.onload = function() {
					var checkfiletype = reader.result;
					let dataTopost = "api=1&uploadiconfile="+reader.result;
					let reqSettings = new XMLHttpRequest();
					reqSettings.open("POST", 'https://epink.health/api/', true);
					reqSettings.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
					reqSettings.onload = function() {
						  if(reqSettings.status == 200) {
							let json = reqSettings.responseText;
							let response = JSON.parse(json);
							document.getElementById(target).value = response.iconurl;
						  }else if(reqSettings.status == 404) {
							alert("Fail to connect to our server");
						  }else{
							 alert("Fail to connect to our server"); 
						  } 
					}
					reqSettings.send(dataTopost);
		}
			
		};
	}
	reader.readAsDataURL(file1);
}
</script>
