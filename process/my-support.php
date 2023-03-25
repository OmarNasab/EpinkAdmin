<?php
$pagetitle = 'Support Request';
$uid = $_SESSION["id"];

if(isset($_POST["submit_support_request"])){
	$support_title = cleanInput($_POST["support_title"]);
	$thread_content = cleanInput($_POST["thread_content"]);
	$support_owner = $uid;
	$support_date = $currentdatetime;
	$thread_date = $currentdatetime;
	$support_status = 'New';
	if($support_title != "" || $thread_content != ""){
		$sql = "INSERT INTO support_request(support_owner, support_title, support_date, support_status)
		VALUES ('$support_owner', '$support_title', '$support_date', 'New')";

		if ($db->query($sql) === TRUE) {
			$thread_id = $db->insert_id;
			$sql = "INSERT INTO support_content (thread_id, thread_content, thread_date, thread_owner)
			VALUES ('$thread_id', '$thread_content', '$thread_date', 'true')";
			if ($db->query($sql) === TRUE) {
				$response = 'Your request has been received. We will get back to you withing 24 hour';
			} else {
				$response = "Error SR003 - There is an error submitting your request:" . $db->error;
			}
			$thread_content_reply = 'Thank you for contacting us. We will get back to you within 24 hour. <br>-Admin';
			$thread_date_reply = $currentdatetime;
			$sql = "INSERT INTO support_content (thread_id, thread_content, thread_date, thread_owner)
			VALUES ('$thread_id', '$thread_content_reply', '$thread_date_reply', 'false')";
			if ($db->query($sql) === TRUE) {
				$response = 'Your request has been received. We will get back to you withing 24 hour';
			} else {
				$response = "Error SR004 - There is an error submitting your request:" . $db->error;
			}
		} else {
			$response = "Error SR002- There is an error submitting your request";
		}
	}else{
		$response = "Error SV001 - Please fill the form";
	}
	
}




$sql = "SELECT * FROM users WHERE id='$uid'";
$result = $db->query($sql);
$account = $result->fetch_assoc();
if($account["profile_img"] != "img/default_profile_picture.jpg"){
	
}
?>