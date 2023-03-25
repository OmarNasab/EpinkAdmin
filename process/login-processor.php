<?php
//LOGIN 
if(isset($_POST["login"]) && $_POST["csrf"] == $_SESSION["csrftoken"]){
	$response = "Service Unvailable";
	$email = cleanInput($_POST["email"]);
	$password = cleanInput($_POST["password"]);
	if($email != "" && $password != ""){
		$sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
		$result = $db->query($sql);
		if ($result->num_rows > 0){
			$row = $result->fetch_assoc();
			
			$token = rand(10000,1000000).uniqid().rand(100,100000);
			
			$sql = "UPDATE users SET login_token='$token' WHERE email='$email'";
			if ($db->query($sql) === TRUE) {
				$_SESSION["id"] = $row["id"];
				$row["login_token"] = $token;		
				$row["status"] = "Successful";
				$row["card"] = "green";
				if($row["provider_type"] == "Pharmacist"){
					header("location: ".$domain."/pharmacy-panel/");
						$row["status"] = "Fail";
					$row["message"] = 'You have been logged in successfully. <script>location.href = "'.$domain.'/pharmacy-panel/";<script>';
				}
				
				
			
				
				
			} else {
			
				$row["status"] = "Fail";
				$row["message"] = "Error updating record: " . $db->error;
				$row["card"] = 'red';
				
			}

		} else {
			$row["status"] = "Fail";
			$row["message"] = "The record you looking for does not exist";
			$row["card"] = 'red';
			
		}
	}else{
		$row["status"] = "Fail";
		$row["message"] = "Please fill all the form";
		$row["card"] = 'red';
		
	} 
	$data = $row;
}
?>