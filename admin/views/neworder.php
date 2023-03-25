<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>In Progress</h1>
					<p>List of orders that are in progress.</p>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">In Progress</li> 
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
										<th>Date</th>
										<th>Job ID</th>
										<th>Customer</th>
                                        <th>Vendor Name</th>
										<th>Rider Name</th>
									
										<th>Vendor Profit</th>
										<th>Company Profit</th>
										<th>Payment Type</th>
											<th>Status</th>
										<th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $sql = "SELECT * FROM job_order WHERE order_status='New' OR order_status='Preparing' OR order_status='Delivering' ORDER by id DESC";
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
											  echo '
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
												<td><button class="btn btn-primary" onclick="completeThis('.$row["id"].', '. $row["customerneedtopay"].', '. $row["runner"].')">Complete</button></td> 
											
											  </tr>';
										  }
											
											  

                                          
                                        } else {
                                          
                                        }
                                        		
                                        ?>	  
                                </tbody>
                                <tfoot>
									<tr>
										<th>Date</th>
										<th>Job Type</th>
										<th>Customer</th>
                                        <th>Vendor Name</th>
										<th>Rider Name</th>
										<th>Vendor Profit</th>
										<th>Company Profit</th>
										<th>Payment Type</th>
										<th>Status</th>
										<th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
							<script>
								function completeThis(id, customerpay, riderid){
									var dataTopost = 'api=1&auth_token='+authUser.login_token+"&adminsetcompleted="+id+"&customerneedtopay="+customerpay+"&riderid="+riderid;
									var xhr = new XMLHttpRequest();
									xhr.open("POST", serverUrl, true);
									xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
									xhr.onload = function() {
										if (xhr.status == 200) {
											var json = xhr.responseText;
											var response = JSON.parse(json);
											alert(response.message);	
											location.reload();
										} else if (xhr.status == 404) {
											alert("Fail to connect to our server");
										} else {
											alert("Fail to connect to our server");
										}
									}
									xhr.send(dataTopost);
								}
							</script>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<div class="modal fade" id="modal-xl">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <p class="modal-title">
User Management
                </p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
				<ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link" id="one-tab" data-toggle="tab" href="#view" role="tab" aria-controls="One" aria-selected="true">View</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="two-tab" data-toggle="tab" href="#update" role="tab" aria-controls="Two" aria-selected="false">Update</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="three-tab" data-toggle="tab" href="#delete" role="tab" aria-controls="Three" aria-selected="false">Delete</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active p-3" id="view" role="tabpanel" aria-labelledby="one-tab">
                    </div>
                    <div class="tab-pane fade p-3" id="update" role="tabpanel" aria-labelledby="two-tab">
                    </div>
                    <div class="tab-pane fade p-3" id="delete" role="tabpanel" aria-labelledby="three-tab">
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
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