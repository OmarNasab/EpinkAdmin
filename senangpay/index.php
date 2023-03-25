<?php
date_default_timezone_set("Asia/Kuala_Lumpur");
$servername = "localhost";
$username = "epink";
$password = "880208Limitless@";
$dbname = "admin_epink";
$itemurl = "http://localhost/eapi/";
// Create connection
$db = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($db->connect_error) {
	echo '{"api":"Fail to connect to database"}';
}
function addTotransaction($transactiontype, $transactionowner, $transactionamount, $transactionoperation){
	global $db;
	$sqldd = "INSERT INTO wallet_transactions (type, amount, owner, operation)
	VALUES ('$transactiontype', '$transactionowner', '$transactionamount', '$transactionoperation')";
	if ($db->query($sqldd) === TRUE) {
		return true;
	} else {
		return false;
	}
}

function insertTotransaction($transaction_note, $transaction_amount, $transaction_date, $transaction_owner){
		global $db;
		$transactionssql = "INSERT INTO transactions (transaction_note, transaction_amount, transaction_date, transaction_owner)
		VALUES ('$transaction_note', '$transaction_amount', '$transaction_date', '$transaction_owner')";
		if ($db->query($transactionssql) === TRUE) {
			return true;
		} else {
			return false;
		}
}
function getDistance($lat1, $lon1, $lat2, $lon2, $unit) {
  if (($lat1 == $lat2) && ($lon1 == $lon2)) {
    return 0;
  }
  else {
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);

    if ($unit == "K") {
      return ($miles * 1.609344);
    } else if ($unit == "N") {
      return ($miles * 0.8684);
    } else {
      return $miles;
    }
  }
}
function cleanInput($input){
	global $db;
	$data = strip_tags($input);
	$data = $db->real_escape_string($data);
	return $data;
}
/**
 * This is a sample code for manual integration with senangPay
 * It is so simple that you can do it in a single file
 * Make sure that in senangPay Dashboard you have key in the return URL referring to this file for example http://myserver.com/senangpay_sample.php
 */

/* Official Key */
$merchant_id = '152166756275433';
$secretkey = '37475-541';
/* Debug Key */

/* $merchant_id = '199163954924885';
$secretkey = '4304-279'; */


if(isset($_POST['detail']) && isset($_POST['amount']) && isset($_POST['order_id']) && isset($_POST['name']) && isset($_POST['email']) && isset($_POST['phone']))
{

    $hashed_string = md5($secretkey.urldecode($_POST['detail']).urldecode($_POST['amount']).urldecode($_POST['order_id']));

    ?>
    <html>
    <head>
    <title>senangPay Sample Code</title>
    </head>
    <body onload="document.order.submit()">
        <form name="order" method="post" action="https://app.senangpay.my/payment/<?php echo $merchant_id; ?>">
            <input type="hidden" name="detail" value="<?php echo $_POST['detail']; ?>">
            <input type="hidden" name="amount" value="<?php echo $_POST['amount']; ?>">
            <input type="hidden" name="order_id" value="<?php echo $_POST['order_id']; ?>">
            <input type="hidden" name="name" value="<?php echo $_POST['name']; ?>">
            <input type="hidden" name="email" value="<?php echo $_POST['email']; ?>">
            <input type="hidden" name="phone" value="<?php echo $_POST['phone']; ?>">
            <input type="hidden" name="hash" value="<?php echo $hashed_string; ?>">
        </form>
    </body>
    </html>
    <?php
}
# this part is to process the response received from senangPay, make sure we receive all required info
else if(isset($_GET['status_id']) && isset($_GET['order_id']) && isset($_GET['msg']) && isset($_GET['transaction_id']) && isset($_GET['hash']))
{
?>
    <html>
    <head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
   <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    </head>
    <body>
		<div class="container">
		<br><br>
<?php 
    $hashed_string = md5($secretkey.urldecode($_GET['status_id']).urldecode($_GET['order_id']).urldecode($_GET['transaction_id']).urldecode($_GET['msg']));
    if($hashed_string == urldecode($_GET['hash'])){
		if(urldecode($_GET['status_id']) == '1'){
			$orderid = $db->real_escape_string($_GET['order_id']);
			$sql = "SELECT * FROM senangpay WHERE id='$orderid' AND order_status='waiting'";
			$result = $db->query($sql);

			if ($result->num_rows > 0) {
				$row = $result->fetch_assoc();
				$uemail = $row["email"];
				$userid = $row["user_id"];
				$totalamount = $row["amount"];
				$checktype = $row["type"];
				if($checktype == "credit" || $checktype == "wallet" || $checktype == "booking"){
					if($row["type"] == "credit"){
					   $sqlz = "UPDATE users SET rider_credit=rider_credit + $totalamount WHERE id='$userid'";
					   insertTotransaction('RM'.$totalamount.' has been credited to your account', $totalamount, $currentdate, $userid);
					  
					}elseif($row["type"] == "wallet"){
					   $sqlz = "UPDATE users SET wallet=wallet + $totalamount WHERE id='$userid'";
					    insertTotransaction('RM'.$totalamount.' has been credited to your wallet', $totalamount, $currentdate, $userid);
					}elseif($row["type"] == "booking"){
						$bookingid = $row["booking_id"];
						$sqlz = "UPDATE bookings SET paid='true' WHERE id='$userid'";
					}
					//echo "Processing";
					if ($db->query($sqlz) === TRUE) {
						$currentdate = date('Y-m-d');
						$sqllast = "UPDATE senangpay SET order_status='successful' WHERE id='$orderid'";
						if ($db->query($sqllast) === TRUE) {
							
							if($row["type"] == "booking"){
								echo '<h3>Payment status</h3>
								<div class="card">
									<div class="card-body">Payment was successful. Our admin will contact you very soon</div>
								</div><p>You can now close this window</p>';
							}else{
								echo '<h3>Payment status</h3>
								<div class="card">
									<div class="card-body">Payment was successful. Your account has been updated.</div>
								</div><p>You can now close this window</p>';
							}
						} else {
							   echo "Error updating record: " . $db->error;
						}
					} else {
						echo '<h3>Payment status</h3>
							 <div class="card">
						<div class="card-body">Payment was successful but fail to update your account. Please contact support at support@epink.health</div>
					  </div><p>You can now close this window</p>';
					   echo "Error updating record: " . $db->error;
					}					
				}else{
	//Cart process start here
	//1. Get order detail
	$temporderid = intval($row["type"]);
	$sqltemp = "SELECT * FROM temp_order WHERE id='$temporderid'";
	$resulttemp = $db->query($sqltemp);

	if ($resulttemp->num_rows > 0) {
		include("speedy.php");
		$temprow = $resulttemp->fetch_assoc();
					$jobrestaurantid = $temprow["restaurant_id"];
					$jobrpayment_type = $temprow["payment_type"];
					$jobcart_price = $temprow["cart_price"];
					$jobcart_restaurantprofit = $temprow["restaurant_profit"];
					$jobdelivery_lat = $temprow["delivery_lat"];
					$jobdelivery_lng = $temprow["delivery_lng"];
					$jobdelivery_price = $temprow["delivery_price"];
					$jobdepromo = $temprow["promo"];
		$orderlat = $temprow["pickup_lat"];
		$orderlng = $temprow["pickup_lng"];
		$ownerid = $temprow["owner"];
		$owner = $temprow["owner"];
		$jobdata =	cleanInput($temprow["data"]);
		$jobdate =	$temprow["order_date"];
		$restaurantid = $temprow["restaurant_id"];
		$sqlspeed = "SELECT phonenumber, vendor_address, vendor_name FROM users WHERE id='$restaurantid'";
		$resultspeed = $db->query($sqlspeed);
		if ($resultspeed->num_rows > 0) {
		  $rowspeed = $resultspeed->fetch_assoc();
		  $speedy_vendor_address = $rowspeed["vendor_address"];
		  $speedy_vendor_name = $rowspeed["vendor_name"];
		  $speedy_vendor_phonenumber = $rowspeed["phonenumber"];
		}
		$sqlspeedowner = "SELECT firstname, lastname, phonenumber FROM users WHERE id='$owner'";
		$resultspeedowner = $db->query($sqlspeedowner);
		if ($resultspeedowner->num_rows > 0) {
		  $rowspeedowner = $resultspeedowner->fetch_assoc();
		  $speedy_first_name = $rowspeedowner["firstname"];
		  $speedy_last_name = $rowspeedowner["lastname"];
		  $speedy_customer_phonenumber = $rowspeedowner["phonenumber"];
		}
		$decodedr = json_decode($temprow["data"]);
		$datax = $temprow["data"];
		$row["vendor_name"] = $speedy_vendor_name;
		$row["vendor_phonenumber"] = $speedy_vendor_phonenumber;
		$row["vendor_address"] = $speedy_vendor_address;
		$row["customer_name"] = $speedy_first_name.' '.$speedy_last_name;
		$row["customer_phonenumber"] = $speedy_customer_phonenumber;
		$row["delivery_address"] = $decodedr->delivery_address;
		//Select rider
		$sqlrun = "SELECT * FROM users WHERE type='0' ORDER BY ((lat-$orderlat)*(lat-$orderlat)) +((lng - $orderlng)*(lng - $orderlng)) ASC LIMIT 1";
		
		$runresult = $db->query($sqlrun);
		if ($runresult->num_rows > 0){
			while($runner = $runresult->fetch_assoc()){
				//Get distance
				$getcurdistance = 5;
				//Check distance
				if($getcurdistance < 100){
					$jobowner =	$temprow["owner"];
					$job_order_status = "New";
					$selectedRunnerid = 0;
					$job_ordersql = "INSERT INTO job_order (owner, data, order_date, order_status, runner, restaurant_id, payment_type, cart_price, restaurant_profit, delivery_lat, delivery_lng, delivery_price, promo)
					VALUES ('$jobowner', '$jobdata', '$jobdate', '$job_order_status', '$selectedRunnerid', '$jobrestaurantid', '$jobrpayment_type', '$jobcart_price', '$jobcart_restaurantprofit', '$jobdelivery_lat', '$jobdelivery_lng', '$jobdelivery_price', '$jobdepromo')";
					
					if ($db->query($job_ordersql) === TRUE){
						$last_id = $db->insert_id;
						$updatesenangpay = "UPDATE senangpay SET order_status='successful' WHERE id='$orderid'";
						$db->query($updatesenangpay);
						$sql = "DELETE FROM carts WHERE owner='$owner'";
						$db->query($sql);
						
							echo '<h3>Payment status</h3>
							<div class="card">
								<div class="card-body">Payment was successful. Our admin will assign a delivery partner to deliver your purchase shortly</div>
							</div><p>You can now close this window</p>';
					}else{
							echo '<h3>Payment status</h3>
							<div class="card">
								<div class="card-body">Error - 002  Payment was successful. But there is no rider. Your payment will be refunded to your wallet.</div>
							</div><p>You can now close this window</p>';
					}
					
				}else{
							echo '<h3>Payment status</h3>
							<div class="card">
								<div class="card-body">Error - 003 Payment was successful. But there is no rider. Your payment will be refunded to your wallet.</div>
							</div><p>You can now close this window</p>';

				}
			}
		}else{				
							echo '<h3>Payment status</h3>
							<div class="card">
								<div class="card-body">Error - 004 Payment was successful. But there is no rider. Your payment will be refunded to your wallet.</div>
							</div><p>You can now close this window</p>';
			
		}
	} else {
		echo '<h3>Payment status</h3><div class="card"><div class="card-body">Order not found '.$checktype.'</div> </div><p>You can now close this window</p>';
	}
	
	
	
	//End Here
				}


			} else {
			   echo '<h3>Payment status</h3>
						 <div class="card">
					<div class="card-body">This order has been processed before or it doesnt exist</div>
				  </div><p>You can now close this window</p>';
			}
			
  
		}else{
			 echo '<h3>Payment status</h3>
		 <div class="card">
    <div class="card-body">'.urldecode($_GET['msg']).'</div>
  </div><p>You can now close this window</p>';
		}
		
	}else{
		 echo '<h3>Payment status</h3>
		 <div class="card">
    <div class="card-body">Hashed value is not correct</div>
  </div><p>You can now close this window</p>';
	}
  


?>
</div>

</body>
</html>
<?php
# this part is to show the form where customer can key in their information
}else{
    # by right the detail, amount and order ID must be populated by the system, in this example you can key in the value yourself
?>
<?php
if(isset($_GET["sessionid"])){
	$orderid = $db->real_escape_string($_GET["sessionid"]);
	$sql = "SELECT * FROM senangpay WHERE id='$orderid'";
	$result = $db->query($sql);

	if ($result->num_rows > 0) {
		$orderdata = $result->fetch_assoc();
		$type= $orderdata["type"];
	} else {
		
	}
}
?>
<!DOCTYPE html>
    <html> 
    <head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
 <!-- Compiled and minified CSS -->
 <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    </head>
	<?php 
		if($type == "wallet"){
			$navtitle = 'Top up your wallet'; 
			$pagedesc = '<p>Top up RM'.$orderdata["amount"].' to your Epink wallet</p>';
			$description = 'MDS Wallet';
		}elseif($type == "credit"){
			$navtitle = 'Topup Rider Credit'; 
			$pagedesc = '<p>Top up RM'.$orderdata["amount"].' to your Epink Credit</p>';
			$description = 'Rider Credit';
		}elseif($type == "booking"){
			$navtitle = 'Pay your booking'; 
			$pagedesc = '<p>Pay your booking - RM'.$orderdata["amount"].'</p>';
			$description = 'MDS Cart';
		}else{
			$navtitle = 'Pay'; 
			$pagedesc = '<p>Pay your cart item - RM'.$orderdata["amount"].'</p>';
			$description = 'MDS Cart';
		}
		?>
    <body>
		<div class="navbar-fixed">
    <nav class="white green-text">
      <div class="nav-wrapper">
		<ul class="left">
          <li ><a href="#!" class="green-text"><i class="material-icons">payment</i></a></li>
		   <li ><a href="#!" class="green-text" style="font-weight: bold; margin-left: -20px"><?php echo $navtitle; ?></a></li>
        </ul>
      </div>
    </nav>
  </div>
		<div class="container">
		<?php echo $pagedesc; ?>
		
		<br>
        <form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
			<div class="input-field">
			  <label for="email">Customer Email:</label>
			  <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" value="<?php echo $orderdata["email"]; ?>" readonly>
			</div>
			<div class="input-field">
			  <label for="phone">Customer Contact No</label>
			  <input type="text" class="form-control" id="phone" placeholder="Enter phone number" name="phone" value="<?php echo $orderdata["phone_number"]; ?>" size="30" readonly>
			</div>
			<div class="input-field">
			  <label for="name">Customer Full name</label>
			  <input type="text" class="form-control" id="name" placeholder="Enter phone number" name="name" value="<?php echo $orderdata["fullname"]; ?>" size="30" readonly>
			</div>
			<input type="text" name="detail" value="<?php echo $description; ?>" placeholder="Description of the transaction" size="30" hidden>
			<input type="text" name="amount" value="<?php echo $orderdata["amount"]; ?>" placeholder="Amount to pay, for example 12.20" size="30" hidden>
			<input type="text" name="order_id" value="<?php echo $orderdata["id"]; ?>" placeholder="Unique id to reference the transaction or order" size="30" hidden>
              
                   
			<div class="red white-text" style="padding-left: 10px; padding-right: 10px; padding-top: 1px; padding-bottom: 1px; border-radius: 5px">
			
			<p class="strong" style="font-weight: bold">WARNING</p>
			<p>Please wait until you get redirected to this page upon completing your payment. If not your payment will be refunded to your account wallet</p>
			</div>
			<br/>
			<button type="submit" value="Submit" class="btn btn-block green text-white" style="width: 100%">Proceed to payment</button>
        </form>
		</div>
    </body>
    </html>
<?php
}
?>