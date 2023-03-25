<?php
$servername = "localhost";
$username = "vappymy_capto";
$password = "880208Limitless@";
$dbname = "vappymy_capto";


$db = new mysqli($servername, $username, $password, $dbname);
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
$productmargin = 15;
$sql = "SELECT * FROM products";
$result = $db->query($sql);

if ($result->num_rows > 0) {
	// output data of each row
	while($row = $result->fetch_assoc()) {
		$originalprice = $row["originalprice"];
		echo $row["name"];
		echo '<br>Original Price: '.$originalprice;
		echo '<br>';
		
		//Update price here
		
		
		
		$profit = $productmargin * $originalprice / 100;
		echo 'Margin = RM';
		echo $profit;
		echo '<br>';
		$newprice = $profit + $originalprice;
		echo 'New Price: RM'.$newprice.'<br><br><br><br>';
		
		
		//Addon data here
		
		$addondata = json_decode($row["addondata"]);
		$addoncount =  count($addondata);
		
		if($addoncount > 0){
			echo 'Has Addon<br>';
			for ($x = 0; $x <= $addoncount; $x+=10) {
			  echo "The number is: $x <br>";
			}
		}
		
		
		/* $profit = round($profit, 2);
		echo 'Profit = '.$profit;
		$newprice = $originalprice + $profit;
		echo round($newprice, 2);
		echo '<br><br>'; */
		
	}
} else {
	echo "0 results";
}
?>