<!DOCTYPE html>
<html lang="en">
<head>
  <title>DIGITAL MEDICAL LEAVE CERTIFICATE</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container " style="width: 90%; padding: 1px">
  
  

  <div class="row">
	<div class="col">  <img src="https://epink.health/assets/img/covers/brand.png" width="100%"></div>
	<div class="col">
	<br><br>
	<h1>EPINK</h1>
  <p>DIGITAL MEDICAL LEAVE CERTIFICATE</p> 
  <p>https://epink.health</p>
	</div>
  </div>
</div>
<div class="container">

<?php 
$pid = cleanInput($page_identifier_action);
$sql = "SELECT * FROM chats WHERE id= '$pid'";
$result = $db->query($sql);

if ($result->num_rows > 0) {
	$row = $result->fetch_assoc();
	$ownerone = $row["owner_one"];
	$ownertwo = $row["owner_two"];
	$sqls = "SELECT * FROM users WHERE id='$ownerone'";
	$results = $db->query($sqls);
	$owneronedata = $results->fetch_assoc();
	$sqls = "SELECT * FROM users WHERE id='$ownertwo'";
	$results = $db->query($sqls);
	$ownertwodata = $results->fetch_assoc();
	if($owneronedata["type"] == 0){
		$patient = $owneronedata;
		$doctor = $ownertwodata;
	}else{
		$patient = $ownertwodata;
		$doctor = $owneronedata;
	}
	
} else {
	echo "0 results";
}







?>


<br>
<p><span class="font-weight-bold">Medical Leave Statement:</span></p>
<?php
$mc = json_decode($row["mcdata"]);



?>
<p>With this I <b>DR <?php echo $doctor["firstname"]; ?> <?php echo $doctor["lastname"]; ?></b> ceterfied that MR  <b><?php echo $patient["firstname"]; ?> <?php echo $patient["lastname"]; ?></b> will not be able to conduct his task from <b><?php echo $mc->mcfrom; ?></b> to <b><?php echo $mc->todate; ?></b></p>
</div>
</body>
</html>
