<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Order Report</h1>
					<p>Full report for order <?php $page_identifier_action; ?></p>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Full Order Report</li>  
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
	 <div class="container-fluid">
<?php
										$oid = cleanInput($page_identifier_action);
                                        $sql = "SELECT * FROM job_order WHERE id='$oid'";
                                        $result = $db->query($sql);
                                        $neworders = $result->num_rows;
                                        if ($result->num_rows > 0) {
                                          // output data of each row
                                          while($row = $result->fetch_assoc()) {
												$userid = $row["owner"];
												$sqls = "SELECT * FROM users WHERE id='$userid'";
												$results = $db->query($sqls);
												if ($results->num_rows > 0) {
												  $rows = $results->fetch_assoc();
												}											  
												$riderid = $row["runner"];
												$sqlrunner = "SELECT * FROM users WHERE id='$riderid'";
												$resultsrunner = $db->query($sqlrunner);
												if ($resultsrunner->num_rows > 0) {
												  $rowrunner = $resultsrunner->fetch_assoc();
												  $runnerfullname = '<a href="'.$domain.'/riders/'.$rowrunner["id"].'/">'.$rowrunner["firstname"].' '.$rowrunner["lastname"].'</a>';
												}else{
													$runnerfullname = '3rd Party Rider<br>ID '.$row["speedy_order_id"].'';
												}	
											
												$resid = $row["restaurant_id"];
												$sqlsr = "SELECT * FROM users WHERE id='$resid'";
												$resultr = $db->query($sqlsr);
												if ($resultr->num_rows > 0) {
												  $rowsr = $resultr->fetch_assoc();
												}	
											  $company_profit = $row["cart_price"] - $row["restaurant_profit"];											  
											  $establishment_profit = $row["restaurant_profit"];
											  $row["customerneedtopay"] = $row["cart_price"] + $row["delivery_price"];
											  $curdate = date("F jS, Y g:i a", strtotime($row["order_date"]));
											 /*  echo '
											  <tr>
												<td>'.$curdate.'</td>
												<td><a href="'.$domain.'/orders/'.$row["id"].'/">'.$row["id"].'</a></td>
											
												<td><a href="'.$domain.'/customers/'.$rows["id"].'/">'. $rows["firstname"].' '. $rows["lastname"].'</a><br> '.$rows["phonenumber"].'</td>
												<td><a href="'.$domain.'/establishment-manager/'.$rowsr["id"].'/">'. $rowsr["vendor_name"].'</a><br>'. $rowsr["phonenumber"].'</td>
												<td>'.$runnerfullname.'<br> '.$rowrunner["phonenumber"].'</td>
											
												<td>'.$row["order_status"].'</td>
												<td>RM'. $establishment_profit.'</td>
												<td>RM'. $company_profit.'</td>
												<td>'. $row["payment_type"].'</td>
												
											
											  </tr>'; */
												$data = $row["data"];
												//echo $data;
								
												$jid = json_decode($row["data"]);
												$cartitem = $jid->cartitem;
												$vendor_address = urldecode($cartitem[0]->vendor_address);
												//echo json_encode($jid, JSON_PRETTY_PRINT);
												
											
												$jobtype = $jid->job_type;					
												$multideliverydata = $jid->multideliverydata;
												
												//echo json_encode($multideliverydata, JSON_PRETTY_PRINT);
												if($row["ehailing"] == "true"){
													$jobtype = "E - hailing";
												}
												echo '
												<p><span class="font-weight-bold">Job Type:</span> '.$jobtype.'';
												echo '
												<p><span class="font-weight-bold">Customer:</span> <a href="'.$domain.'/customers/'.$rows["id"].'/">'. $rows["firstname"].' '. $rows["lastname"].'</a></p>';
												echo '
												<p><span class="font-weight-bold">Rider:</span> '.$runnerfullname.'';
												
												if($jobtype == "Goods Delivery"){
													$pikcuppoint = urldecode($cartitem[0]->vendor_address);
												}else{
													$pikcuppoint = urldecode($jid->pickup_location);
												}
												
												
												echo '
												<p><span class="font-weight-bold">Pick Up Point:</span> '.$pikcuppoint.'';
												if($jobtype == "Parcel Delivery"){
														echo '<br>Completed Time: '.$row["pickup_date"];
														echo '<br><a href=""  target="_blank"><img src="'.$row["pickup_image"].'" width="50px" ></a>';
												}
												if($jobtype == "Goods Delivery"){
													echo '<br>Pick up time: '.$row["pickup_date"];
												}
												if($jobtype == "Goods Delivery"){
													$dropoff = urldecode($jid->delivery_address);
												}else{
													$dropoff = urldecode($jid->pickup_location);
												}
												
												echo '<p><span class="font-weight-bold">Drop Off Point:</span> '.$dropoff.'';
												if($jobtype == "Parcel Delivery"){
														echo '<br>Completed Time: '.$row["droped_date"];
														echo '<br><a href=""  target="_blank"><img src="'.$row["drop_image"].'" width="50px" ></a>';
												}
												if($jobtype == "Goods Delivery"){
													echo '<br>Drop off time: '.$row["droped_date"];
														
												}
												echo '<p><span class="font-weight-bold">Customer Payment :</span> RM'.$row["delivery_price"].'';
												echo '<p><span class="font-weight-bold">Payment Type:</span> '.$row["payment_type"].'';
												$mdcount = count($multideliverydata);
												if($multideliverydata != null){
													echo '<p class="font-weight-bold">Multi Delivery Task Detail</p>';
													
													for ($x = 0; $x <= $mdcount; $x++) {
													  echo '<br>';
													  echo '<p class="font-weight-bold">'.$multideliverydata[$x]->type.'</p>';
													  echo $multideliverydata[$x]->address;
													  echo '<br>';
													  $completedtasktime = $multideliverydata[$x]->completed_time_stamp;
													  if($completedtasktime != ""){
														    echo '<p>Completed at: '.$completedtasktime.'</p>';
													  }
													
													  echo '<a href=""  target="_blank"><img src="'.$multideliverydata[$x]->complete_picture.'" width="50px" ></a><br>';
													  $completedtasktime = "";
													  
													}
												}else{
													
													
												}
												if($cartitem != null){
													echo '<p class="strong">Purchase Detail</p>';
													$cartitemcount = count($cartitem);
													for ($x = 0; $x <= $cartitemcount; $x++) {
														if($cartitem[$x]->product_name != null){
														$quantity = round($cartitem[$x]->quantity, 0);
														echo '<br>Item: '. $cartitem[$x]->product_name;
														echo '<br>Quantity: '.$quantity;
														echo '<br>Original Price: RM'.$cartitem[$x]->originalprice;
														echo '<br>Price After Margin: RM'.$cartitem[$x]->product_price;
														echo '<br>';
														}
													}
												}
												
												
												

												
											  
										  }
											
											  

                                          
                                        } else {
                                          
                                        }
                                        		
                                        ?>	  
        <!-- /.container-fluid -->
		</div>
    </section>
    <!-- /.content -->
</div>

<script>
currentNewOrder = <?php echo $neworders; ?>;
function checkForneworder(){
		var dataTopost = 'api=1&auth_token=' + authUser.login_token + "&admincheckneworder=true";
		var xhr = new XMLHttpRequest();
		xhr.open("POST", serverUrl, true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhr.onload = function() {
			if (xhr.status == 200) {
				var json = xhr.responseText;
				var response = JSON.parse(json);
			
				if (response.new_order_count > currentNewOrder){
						location.reload();
						console.log(response.new_order_count+' CURENT ORDERS: '+currentNewOrder);
				}else{
					console.log(response.new_order_count+' CURENT ORDERS: '+currentNewOrder);
				}
				setTimeout(function(){ checkForneworder(); }, 5000);
				
			} else if (xhr.status == 404) {
				location.reload();
			} else {
				location.reload();
			}
		}
		xhr.send(dataTopost);
}
checkForneworder();

</script>