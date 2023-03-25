<?php
$debugurl = 'https://bpg.iou-pay.com/payment/';
$debugaccountid = 'D00077';
$debugsecretkey = 'WpMJRB3a';
$productionurl = 'https://epayment.iou-pay.com/payment/';
$productionaccountid = '';
$productionsecretkey = '';

$urltouse = $debugurl;
$accountid = $debugaccountid;
$secretkey = $debugsecretkey;


$rid = cleanInput($page_identifier_action);
$x_reference = 'O'.$rid;
$sql = "SELECT * FROM ioupayrequest WHERE id='$rid'";
$result = $db->query($sql);

if ($result->num_rows > 0) {
	$row = $result->fetch_assoc();
	$x_amount = $row["amount"];
}


function generateSignature(){
		global $secretkey, $x_amount, $rid;
		$string = 'x_account_idD00077x_additional_merchantEPINK HEALTH SDN BHDx_amount'.$x_amount.'x_currencyMYRx_descriptionOrderPayment for Order #0000'.$rid.'x_invoiceINV0000'.$rid.'x_referenceO0000'.$rid.'x_store_countryMYRx_store_nameEPINK HEALTH SDN BHDx_test1x_url_callbackhttps://epink.health/ioupay/callback/x_url_cancelhttps://epink.health/ioupay/cancel/x_url_completehttps://epink.health/ioupay/complete/';
		$signature = hash_hmac('sha256', $string, $secretkey);
		return $signature;
}
?>