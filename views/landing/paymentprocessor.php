<?php
$merchant_id = '199163954924885';
$secretkey = '4304-279';
$posturl = 'https://sandbox.senangpay.my/payment/'.$merchant_id.'';


?>
<?php
if($page_identifier_action == "booking"){
	$bookingid = $page_action_identifier;
	$sql = "SELECT * FROM bookings WHERE id='$bookingid'";
	$result = $db->query($sql);
	if ($result->num_rows > 0) {
		$bookingdetail = $result->fetch_assoc();
		
		echo "id: " . $bookingdetail["id"]. " - Name: " . $bookingdetail["name"]. "  " . $bookingdetail["email"]. "<br>";	  
	} else {
		echo 'This order does not exist';
	}	
}elseif($page_identifier_action == "others"){
	
}

?>
 <html>
    <head>
    <title>Process Payment</title>
    </head>
    <body onload="<!--document.order.submit()-->">
        <form name="order" method="post" action="<?php echo $posturl; ?>">
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