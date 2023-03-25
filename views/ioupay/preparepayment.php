<?php
$x_signature = generateSignature();
?>

<!DOCTYPE html>
<html>
	<head>
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />
	</head>
		<div class="navbar-fixed">
			<nav class="white">
				<div class="nav-wrapper">
					<ul class="left"> 
						<li><a href="#" class="pink-hidden"><b>PAY WITH IOUPAY</b></a></li>
					</ul>
				</div>
			</nav>
		</div>
		<div class="container">
			<h5>CONFIRM PAYMENT</h5>
			<p>Top up your wallet RM<?php echo $x_amount; ?> with IOUPAY. You will be redirected to IOUPAY payment page.</p>
				<form method="POST" name="ioutest" action="<?php echo $urltouse; ?>" target="_blank">
				<input type="hidden" name="x_account_id" value="D00077">
				<input type="hidden" name="x_additional_merchant" value="EPINK HEALTH SDN BHD">
				<input type="hidden" name="x_amount" value="<?php echo $x_amount; ?>">
				<input type="hidden" name="x_currency" value="MYR">
				<input type="hidden" name="x_description" value="OrderPayment for Order #0000<?php echo $rid; ?>">
				<input type="hidden" name="x_invoice" value="INV0000<?php echo $rid; ?>">
				<input type="hidden" name="x_reference" value="O0000<?php echo $rid; ?>">
				<input type="hidden" name="x_signature" value="<?php echo $x_signature; ?>">
				<input type="hidden" name="x_store_country" value="MYR">
				<input type="hidden" name="x_store_name" value="EPINK HEALTH SDN BHD">
				<input type="hidden" name="x_test" value="1">
				<input type="hidden" name="x_url_callback" value="https://epink.health/ioupay/callback/">
				<input type="hidden" name="x_url_cancel" value="https://epink.health/ioupay/cancel/">
				<input type="hidden" name="x_url_complete" value="https://epink.health/ioupay/complete/">
				<button id="m_PaymentBtn" type="submit" value="Submit" class="btn white-hidden pink">PROCEED</button>
			</form>
		</div>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
	</body>
</html>