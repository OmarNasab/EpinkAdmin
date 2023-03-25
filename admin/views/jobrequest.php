<?php $target = 'base'; 
$sqldimg = "SELECT * FROM settings WHERE setting_item='parcel_delivery_cut'";
$imgresult = $db->query($sqldimg);
if ($imgresult->num_rows > 0) {
	$imgrow = $imgresult->fetch_assoc();
	$parcel_delivery_cut = $imgrow["setting_value"];
}

?> 
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Completed Job</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">List of completed job</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
		   <div class="card">
                <div class="card-body">
				<form method="GET">
				<div class="row">
					<div class="col-sm-4">
						<div class="form-group">
							<label for="to">From</label>
							<input type="date" class="form-control" name="from" id="from">
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label for="to">TO</label>
							<input type="date" class="form-control" name="to" id="to">
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label for="to">&nbsp </label><br>
							<button type="submit" id="getdate" name="getdate" value="true" class="btn btn-primary">SUBMIT</button>
						</div>
						
					</div>
				</div>
				</form>
				
				
				</div>
		   </div>
		   <?php
		   if(isset($_GET["from"])){ ?>
<div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                   <tr>
										<th>Date</th>
										<th>Job Type</th>
										<th>Pick Up</th>
										<th>Drop Off</th>
										<th>Customer</th>
                                        <th>Vendor Name</th>
										<th>Rider Name</th>
										<th>Vendor Profit</th>
										<th>Company Profit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $sql = "SELECT * FROM job_order WHERE order_status= 'Completed' ORDER by id DESC";
                                        $result = $db->query($sql);
                                        
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
												 $runnerfullname= '<a href="'.$domain.'/riders/'.$rowrunner["id"].'/">'.$rowrunner["firstname"].' '.$rowrunner["lastname"].'</a>';
												 
												}else{
													$runnerfullname = '3rd Party Rider';
												}	
											  if($row["restaurant_id"] != 0){
												$resid = $row["restaurant_id"];
												$sqlsr = "SELECT * FROM users WHERE id='$resid'";
												$resultr = $db->query($sqlsr);
												if ($resultr->num_rows > 0) {
												  $rowsr = $resultr->fetch_assoc();
												}	
											  $company_profit = $row["cart_price"] - $row["restaurant_profit"];
											  
											  $establishment_profit = $row["restaurant_profit"];
											  echo '
											  <tr>
												<td>'. $row["order_date"].'</td>
												<td>'.$row["id"].'</td>
												<td>Food / Grocery Delivery</td>
												<td><a href="'.$domain.'/customers/'.$rows["id"].'/">'. $rows["firstname"].' '. $rows["lastname"].'</a></td>
												<td><a href="'.$domain.'/establishment-manager/'.$rowsr["id"].'/">'. $rowsr["vendor_name"].'</a></td>
												<td>'.$runnerfullname.'</td>
												<td>RM'. $establishment_profit.'</td>
												<td>RM'. $company_profit.'</td>
												<td>'.$row["order_status"].'</td>
											
											  </tr>';
											  }else{
												$userid = $row["owner"];
												$sqls = "SELECT * FROM users WHERE id='$userid'";
												$results = $db->query($sqls);
												if ($results->num_rows > 0){
												  $rows = $results->fetch_assoc();
												}		
											$riderid = $row["runner"];
												$sqlrunner = "SELECT * FROM users WHERE id='$riderid'";
												$resultsrunner = $db->query($sqlrunner);
												if ($resultsrunner->num_rows > 0) {
												  $rowrunner = $resultsrunner->fetch_assoc();
												  $runnerfullname = $rowrunner["firstname"].' '.$rowrunner["lastname"];
												}	
												$establishment_profit = "Not applicable";
												$company_profit = $parcel_delivery_cut * $row["cart_price"] / 100;
											    $establishment_profit = "Not applicable";
												  echo '
												  <tr>
													<td>'. $row["order_date"].'</td>
													<td>'.$row["id"].'</td>
													<td> Runner</td>
													<td><a href="'.$domain.'/customers/'.$rows["id"].'/">'. $rows["firstname"].' '. $rows["lastname"].'</a></td>
													<td> Not Applicable </td>
													<td>'. $runnerfullname.'</td>
													<td>'. $establishment_profit.'</td>
													<td>RM'. $company_profit.'</td>
													<td>'.$row["order_status"].'</td>
												  </tr>';
												}
											  

                                          }
                                        } else {
                                          echo "0 results";
                                        }
                                        		
                                        ?>	  
                                </tbody>
 
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>		   
		   <?php }else{ ?>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                           <table id="example1" class="table table-bordered table-striped">
                              <thead>
                                    <tr>
										<th>Date</th>
										<th>Job ID</th>
										<th>Job Type</th>
										<th>Pick Up</th>
										<th>Drop Off</th>
										<th>Customer</th>
                                        <th>Vendor Name</th>
										<th>Rider Name</th>
										<th>Vendor Profit</th>
										<th>Rider Profit</th>
										<th>Company Profit</th>
										<th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $sql = "SELECT * FROM job_order WHERE order_status= 'Completed' ORDER by id DESC";
                                        $result = $db->query($sql);
                                        
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
												 $runnerfullname= '<a href="'.$domain.'/riders/'.$rowrunner["id"].'/">'.$rowrunner["firstname"].' '.$rowrunner["lastname"].'</a>';
												 
												}else{
													$runnerfullname = '3rd Party Rider';
												}	
											  if($row["restaurant_id"] != 0){
												$resid = $row["restaurant_id"];
												$sqlsr = "SELECT * FROM users WHERE id='$resid'";
												$resultr = $db->query($sqlsr);
												if ($resultr->num_rows > 0) {
												  $rowsr = $resultr->fetch_assoc();
											  }
											  $company_profit = $row["cart_price"] - $row["restaurant_profit"];
											  
											  $establishment_profit = $row["restaurant_profit"];
											  echo '
											  <tr>
												<td>'. $row["order_date"].'</td>
												<td><a href="'.$domain.'/order-report/'.$row["id"].'/">'.$row["id"].'</a></td>
												<td>Food / Grocery Delivery</td>
												<td>Not Applicable</td>
												<td>Not Applicable</td>
												<td><a href="'.$domain.'/customers/'.$rows["id"].'/">'. $rows["firstname"].' '. $rows["lastname"].'</a></td>
												<td><a href="'.$domain.'/establishment-manager/'.$rowsr["id"].'/">'. $rowsr["vendor_name"].'</a></td>
												<td>'.$runnerfullname.'</td>
												<td>RM'. $establishment_profit.'</td>
												<td>'. $row["rider_earning"].'</td>
												<td>RM'. $company_profit.'</td>
												<td>'.$row["order_status"].'<br><a href="'.$domain.'/order-report/'.$row["id"].'/">Order Report</a>  </td>
											
											  </tr>';
											  }else{
												$userid = $row["owner"];
												$sqls = "SELECT * FROM users WHERE id='$userid'";
												$results = $db->query($sqls);
												if ($results->num_rows > 0){
												  $rows = $results->fetch_assoc();
												}		
											$riderid = $row["runner"];
												$sqlrunner = "SELECT * FROM users WHERE id='$riderid'";
												$resultsrunner = $db->query($sqlrunner);
												if ($resultsrunner->num_rows > 0) {
												  $rowrunner = $resultsrunner->fetch_assoc();
												  $runnerfullname = $rowrunner["firstname"].' '.$rowrunner["lastname"];
												}	
												$establishment_profit = "Not applicable";
												$company_profit = $parcel_delivery_cut * $row["cart_price"] / 100;
											    $establishment_profit = "Not applicable";
												if($row["message_to_rider"] =="Multi Delivery"){
													$parceldeliverydata = 'Multi Parcel Delivery';
													$row["pickup_date"] = "Not Applicable";
													$row["droped_date"] = "Not Applicable";
												}else{
													$parceldeliverydata = 'Parcel Delivery';
												}
												if($row["ehailing"] == "true"){
													$parceldeliverydata = 'Ehailing';
													
												}
												  echo '
												  <tr>
													<td>'. $row["order_date"].'</td>
													<td><a href="'.$domain.'/order-report/'.$row["id"].'/">'.$row["id"].'</a></td>
													<td>'.$parceldeliverydata.'</td>
													<td>Date: '.$row["pickup_date"].' 
													<img src="'.$row["pickup_image"].'" class="img-fluid">
													</td>
													<td>Date: '.$row["droped_date"].'<img src="'.$row["drop_image"].'" class="img-fluid"></td>
													<td><a href="'.$domain.'/customers/'.$rows["id"].'/">'. $rows["firstname"].' '. $rows["lastname"].'</a></td>
													<td> Not Applicable </td>
													<td>'. $runnerfullname.'</td>
													
													<td>'. $establishment_profit.'</td>
													<td>'. $row["rider_earning"].'</td>
													<td>RM'. $company_profit.'</td>
													<td>'.$row["order_status"].'<br><a href="'.$domain.'/order-report/'.$row["id"].'/">Order Report</a>  </td>
												  </tr>';
												}
											  

                                          }
                                        } else {
                                          echo "0 results";
                                        }
                                        		
                                        ?>	  
                                </tbody>

                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
		   <?php } ?>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>


