<?php

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
						<li><a href="#" class="pink-text"><b>PAY WITH IOUPAY</b></a></li>
					</ul>
				</div>
			</nav>
		</div>
		<div class="container">
			<h5>PAYMENT CANCELED</h5>
<?php
$rid = cleanInput($_GET["x_reference"]);
$rid = str_replace('O0000', '', $rid);
$sql = "SELECT * FROM ioupayrequest WHERE id='$rid'";
$result = $db->query($sql);

if ($result->num_rows > 0) {
	$row = $result->fetch_assoc();
	if($row["status"] == "Waiting"){
		$sql = "UPDATE ioupayrequest SET status='Canceled' WHERE id='$rid'";
			if ($db->query($sql) === TRUE) {
			  echo "<p>This payment has been canceled</p>";
			} else {
			  echo "Failed to execute. Please try again";
		}
	}
}
?>
			<p>You have cancel this payment.</p>
		</div>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
	</body>
</html>