<?php
$oid = $authuser["id"];
$sql = "SELECT * FROM pharmacymemberships WHERE owner ='$oid' ";
$result = $db->query($sql);
if ($result->num_rows > 0) {
	$membership = $result->fetch_assoc();
	if($membership["membershiptype"] == 5){
		$membershiprender = '<span class="badge badge-success">Premium membership</span>';
	}elseif($membership["membershiptype"] == 4){
		$membershiprender = '<span class="badge badge-success">Advanced membership</span>';
	}elseif($membership["membershiptype"] == 3){
		$membershiprender = '<span class="badge badge-success">Basic membership</span>';
	}elseif($membership["membershiptype"] == 2){
		
		$membershiprender = '<span class="badge badge-success">Apprentice membership</span>';
	}elseif($membership["membershiptype"] == 1){
		
		$membershiprender = '<span class="badge badge-success">Test membership</span>';
	}
} else {
	$membershiprender = "You are not subscribe to any membership type";
}
$doctorid = $authuser["assigneddoctor"];
$sqlx = "SELECT fullname, profile_img FROM users WHERE id='$doctorid'";
$resultx = $db->query($sqlx);
if ($resultx->num_rows > 0) {
	$assignedoctor = $resultx->fetch_assoc();
}
$today = date("Y-m-d H:i:s");  
$startdate = $membership["expire"];   
$offset = strtotime("+1 day");
$enddate = date($startdate, $offset);    
$today_date = new DateTime($today);
$expiry_date = new DateTime($enddate);
if ($expiry_date < $today_date) { 
	header("location:".$domain."/pharmacy-panel/expired/");
}
?>