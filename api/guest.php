<?php
include("config.php");
if(isset($_POST["searchterm"])){
	$pname = cleanInput($_POST["searchterm"]);
	$type = cleanInput($_POST["type"]);
	if($type == "Name"){
		$sql = "SELECT id, firstname, lastname, profile_img, provider_type, organization_name  FROM users WHERE verified_service_provider='Approved' AND firstname LIKE '%$pname%'";
	}else{
		
		$sql = "SELECT id, firstname, lastname, profile_img, provider_type, organization_name FROM users WHERE verified_service_provider='Approved' AND provider_type='$type'";
	}
	
	$result = $db->query($sql);

	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) {
			$row["fullname"] = $row["firstname"].' '.$row["lastname"];
			if($row["provider_type"] == ""){
				$row["provider_type"] = "Not Set";
			}										
			if($row["organization_name"] == ""){
											$row["organization_name"] = "Organization Not Set";
			}	
			if($row["profile_img"] == "img/default_profile_picture.jpg"){
											$row["profile_img"] = $domain.'http://localhost/website/landingasset/assets/img/illustrations/profiles/profile-1.png';
			}				
				$fullname = strtolower($row["firstname"].' '.$row["lastname"]);
										$fullname = ucwords($fullname);
										$fullname = (strlen($fullname) > 15) ? substr($fullname,0,10).'...' : $fullname;
										$row["fullname"] = $fullname;
			$data[] = $row;
		}
	} else {
		$row["status"] = "fail";
		$row["message"] = "Not Found";
		$data = $row;
	}
}

if(isset($data)){
	echo json_encode($data, JSON_PRETTY_PRINT);
}