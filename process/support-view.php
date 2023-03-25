<?php
$rid = cleanInput($final_identifier);
if(isset($_POST["reply"])){
	$thread_content = cleanInput($_POST["thread_content"]);
	if($thread_content != ""){
		$sql = "INSERT INTO support_content (thread_id, thread_content, thread_date, thread_owner)
		VALUES ('$rid', '$thread_content', '$currentdatetime', 'true')";

		if ($db->query($sql) === TRUE) {
			$response = 'Your message successfully sent.';
		} else {
			$response = "Error SV002 - There is an error submitting your request:" . $db->error;
		}
	}else{
		$response = "Error SV001 - Please fill the form";
	}
}
$sql = "SELECT * FROM support_request WHERE id='$rid'";
$result = $db->query($sql);
$requestinfo = $result->fetch_assoc();

?>