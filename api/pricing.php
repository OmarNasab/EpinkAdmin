<?php
date_default_timezone_set("Asia/Kuala_Lumpur");
$servername = "localhost";
$username = "vappymy_app";
$password = "8802Limitless@";
$dbname = "vappymy_app";
$db = new mysqli($servername, $username, $password, $dbname);
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
echo '<table>  <tr>
<th>Product ID</th>
 <th>Product Name</th>
	 <th>Current Price</th>
    <th>Original Price</th>
    <th>New Margin Price</th>
    <th>New Price</th>
  </tr>';
	$sql = "SELECT * FROM products";
	$result = $db->query($sql);
	if ($result->num_rows > 0) {
	  while($row = $result->fetch_assoc()){
		    $pid = $row["id"];
			$currentprice = $row["price"];
			$orignalmargin = 6.5;
			$margincost = ($orignalmargin / 100) * $currentprice;
			$priginalprice = round($currentprice - $margincost, 2);
			//echo $row["name"].' Original Price = RM'.$priginalprice.'-';
			$newmargin = 15;
			$newmarginprice = round(($newmargin / 100) * $priginalprice, 2);
			$newerprice = $newmarginprice + $priginalprice;
			//echo 'New Margin = '.$newmarginprice.' New Price = RM'.$newerprice;
		    //echo '<br><br>';
			$updateprice = round($newerprice, 2);
			$addondata = $row["addondata"];
			if($addondata != null || $addondata != ""){
				$editdata = json_decode($addondata);
				$length = count($editdata);
				$display = '';
				for ($x = 0; $x < $length; $x++) {
					$currentaddonitemprice = number_format($editdata[$x]->price, 2, '.', ''); 
					$editdata[$x]->price = $currentaddonitemprice;
					$currentaddonmargin = 6.6;
					$currentmarginprice = ($currentaddonmargin / 100) * $currentaddonitemprice;
					$currentmarginpricer = round($currentmarginprice, 2);
					$curentaddonitemoriginalprice = $currentaddonitemprice -$currentmarginpricer;
					$editdata[$x]->originalprice = number_format($curentaddonitemoriginalprice, 2, '.', '');
				  
				}
				$newdata = json_encode($editdata);
				$sql = "UPDATE products SET addondata='$newdata' WHERE id='$pid'";

				/* if ($db->query($sql) === TRUE) {
				} else {
				  echo "Error updating record: " . $db->error;
				} */
			}else{
				$newdata = 'No addon data';
			}
			echo '<tr><td>'.$pid.'</td><td>'.$row["name"].'</td><td>RM'.$currentprice.'</td><td>RM'.round($priginalprice, 2).'</td><td>RM'.$newmarginprice.'</td><td>RM'.round($newerprice, 2).'</td><td>'.$newdata.'</td></tr>';
			
	/* 	$sql = "UPDATE products SET originalprice='$priginalprice' WHERE id='$pid'";

			if ($db->query($sql) === TRUE) {
			  
			
			} else {
			  echo "Error updating record: " . $conn->error;
			}   */
	  }
	} else {
	  echo "0 results";
	}
echo '</table>';