<?php
$pagetitle = 'My Account';
$uid = $_SESSION["id"];

if(isset($_POST["update_account"])){
	$firstname = cleanInput($_POST["firstname"]);
	$lastname = cleanInput($_POST["lastname"]);
	$email = cleanInput($_POST["email"]);
	$organization_name = cleanInput($_POST["organization_name"]);
	$organization_phone_number = cleanInput($_POST["organization_phone_number"]);
	$organization_email = cleanInput($_POST["organization_email"]);
	$sql = "UPDATE users SET firstname='$firstname', lastname='$lastname',  email='$email',  organization_name='$organization_name',  organization_phone_number='$organization_phone_number',  organization_email='$organization_email' WHERE id='$uid'";
	if ($db->query($sql) === TRUE) {
	  $response = "Your account information has been updated successfully";
	} else {
	  $response = "Error updating account information: " . $db->error;
	}
}




$sql = "SELECT * FROM users WHERE id='$uid'";
$result = $db->query($sql);
$account = $result->fetch_assoc();
if($account["profile_img"] != "img/default_profile_picture.jpg"){
	
}
?>