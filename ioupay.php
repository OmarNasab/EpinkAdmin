<?php
if($page_identifier_action == "cancel"){
	include("views/ioupay/header.php");
	include("views/ioupay/cancelpayment.php");
}elseif($page_identifier_action == "complete"){
	include("views/ioupay/header.php");
	include("views/ioupay/completepayment.php");
}elseif($page_identifier_action == "callback"){
	include("views/ioupay/header.php");
	include("views/ioupay/callbackpayment.php");
}else{
	include("views/ioupay/header.php");
	include("views/ioupay/preparepayment.php");
}
?>