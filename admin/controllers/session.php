<?php 
if(isset($_SESSION["id"])){ 
	$id = cleanInput($_SESSION["id"]);
	$sql = "SELECT * FROM users WHERE id='$id'";
	$result = $db->query($sql);
	if ($result->num_rows > 0){
		$row = $result->fetch_assoc();
		$authuser = $row;
		if($authuser["type"] == 8 || $authuser["type"] == 7){
			
		}else{
			session_destroy();
			header("location: ".$domain."/login");
		}
	} else {
		header("location: ".$domain."/login");
	}
}else{
		header("location: ".$domain."/login");
}
?>