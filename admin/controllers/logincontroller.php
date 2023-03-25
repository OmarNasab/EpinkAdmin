<?php
//LOGIN
if(isset($_POST["login"]) && $_POST["csrf"] == $_SESSION["csrftoken"]){
	$response = "Service Unvailable";
	$email = cleanInput($_POST["email"]);
	$password = cleanInput($_POST["password"]);
	if($email != "" && $password != ""){
		$sql = "SELECT * FROM users WHERE email='$email' AND password='$password' AND type='8' OR email='$email' AND password='$password' AND type='7'";
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
				header("location: ".$domain."/dashboard");
			} else {
				$response = "Error updating record: " . $db->error;
				echo '{"status":"fail", "message":"'.$response.'"}';
			}

		} else {
			$row["status"] = "Fail";
			$row["message"] = "The record you looking for does not exist";
			$row["card"] = 'red';
			$data = $row;
		}
	}else{
		$row["status"] = "Fail";
		$row["message"] = "Please fill all the form";
		$row["card"] = 'red';
		$data = $row;
	} 
}
?>