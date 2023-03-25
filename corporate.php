<?php
if($page_identifier_action == ""){
	include('process/c-session-processor.php');
	$pagetitle = "Corporate Wellness";
	include('views/corporate/header.php');
	include('views/corporate/nav.php');
	include('views/corporate/mystaff.php');
	include('views/corporate/footer.php');
}elseif($page_identifier_action == "login"){
	include('views/corporate/login.php');
}elseif($page_identifier_action == "my-support"){
	$pagetitle = "Corporate Wellness - Support";
	include('views/corporate/header.php');
	include('views/corporate/nav.php');
	include('views/corporate/my-support.php');
	include('views/corporate/footer.php');
}elseif($page_identifier_action == "staff"){
	$pagetitle = "View staff";
	include('views/corporate/header.php');
	include('views/corporate/nav.php');
	include('views/corporate/viewstaff.php');
	include('views/corporate/footer.php');
}elseif($page_identifier_action == "my-account"){
	$pagetitle = "Corporate Wellness - Account";
	include('controllers/my-account.php');
	include('views/corporate/header.php');
	include('views/corporate/nav.php');
	include('views/corporate/my-account.php');
	include('views/corporate/footer.php');
}elseif($page_identifier_action == "logout"){
	$pagetitle = "Logout";
session_destroy();
header('location: https://epink.health/');
}
?>