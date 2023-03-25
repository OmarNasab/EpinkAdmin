<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Order Assigned to Mr.Speedy</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Job Request</li>
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
										<th>Job Type</th>
										<th>Customer</th>
                                        <th>Vendor Name</th>
										<th>Vendor Profit</th>
										<th>Company Profit</th>
										<th>Status</th>
										<th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $sql = "SELECT * FROM job_order WHERE runner='0' ORDER by id ASC";
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
											  if($row["restaurant_id"] != 0){
												  
												$resid = $row["restaurant_id"];
												$sqlsr = "SELECT * FROM users WHERE id='$resid'";
												$resultr = $db->query($sqlsr);
												if ($resultr->num_rows > 0) {
												  $rowsr = $resultr->fetch_assoc();
												}	
											  $company_profit = $row["cart_price"] - $row["restaurant_profit"];
											  $establishment_profit = $row["restaurant_profit"];
											  
											  if($row["order_status"] == "Canceled"){
												  $action = 'Not applicable';
											  }elseif($row["order_status"] == "Completed"){
												  $action = 'Not applicable';
											  }else{
												   $action = '<a href="#" onclick="setComplete('.$row["id"].')">Set Complete</a>';
											  }
											 
											  echo '
											  <tr>
												<td>'. $row["order_date"].'</td>
												<td>'.$row["id"].'</td>
												<td>Food / Grocery Delivery</td>
												<td>'. $rows["firstname"].' '. $rows["lastname"].'</td>
												<td><a href="https://vappy.my/admin/establishment-manager/'. $rowsr["id"].'/">'. $rowsr["vendor_name"].'</a></td>
												<td>RM'. $establishment_profit.'</td>
												<td>RM'. $company_profit.'</td>
												<td>'.$row["order_status"].'</td>
												<td>'.$action.'</td>
											
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
												$company_profit = 8 * $row["cart_price"] / 100;
											    $establishment_profit = "Not applicable";
												  echo '
												  <tr>
													<td>'. $row["order_date"].'</td>
													<td>'.$row["id"].'</td>
													<td> Runner</td>
													<td>'. $rows["firstname"].' '. $rows["lastname"].'</td>
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
                                <tfoot>
									<tr>
										<th>Date</th>
										<th>Job ID</th>
										<th>Job Type</th>
										<th>Customer</th>
                                        <th>Vendor Name</th>
										<th>Vendor Profit</th>
										<th>Company Profit</th>
										<th>Status</th>
										<th>Status</th>
                                    </tr>
                                </tfoot>
                            </table>
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
function setComplete(oid){
		var dataTopost = 'api=1&auth_token='+authUser.login_token+"&speedycomplete="+oid;
		var xhr = new XMLHttpRequest();
		xhr.open("POST", serverUrl, true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhr.onload = function() {
			if (xhr.status == 200) {
				var json = xhr.responseText;
				var response = JSON.parse(json);
				alert(response.message);
				//location.reload();
				
			} else if (xhr.status == 404) {
				alert("Fail to connect to our server");
			} else {
				alert("Fail to connect to our server");
			}
		}
		xhr.send(dataTopost);
}
function viewThisusers(id){
    var dataTopost = "api=1&auth_token=" + authUser.login_token + "&viewThisusers="+id;
    var users = new XMLHttpRequest();
    users.open("POST", serverUrl, true);
    users.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    users.onload = function() {
        if (users.status == 200) {
            var json = users.responseText;
            var response = JSON.parse(json);
			if(response.profile_img != "img/default_profile_picture.jpg"){
				var imgviewer = '<p><span class="font-weight-bold">Profile Image:</span></p><img src="'+response.profile_img+'" width="200px">';
			}else{
				var imgviewer ='<p><span class="font-weight-bold">Profile Image:</span> Not set</p>';
			}
			
			if(response.type == "0"){
				var usertype = "Customer";
			}else if(response.type == "1"){
				var usertype = "Restaurant owner / Manager";
			}else if(response.type == "2"){
				var usertype = "Rider";
			}else if(response.type == "4"){
				var usertype = "Grocery owner / Manager";
			}else if(response.type == "3"){
				var usertype = "Admin";
			}
			document.getElementById("view").innerHTML = '<p>Viewing user information</p>'+imgviewer+'<p><span class="font-weight-bold">Name:</span> '+response.firstname+' '+response.lastname+'</p><p><span class="font-weight-bold">Email:</span> '+response.email+'</p><p><span class="font-weight-bold">Phone number:</span> '+response.phonenumber+'</p><p><span class="font-weight-bold">Phone number:</span> '+response.phonenumber+'</p>';
			//document.getElementById("view").innerHTML = '<img src="'+response.profile_img+'"><p>'+response.email+'</p><p>'+response.firstname+'</p><p>'+response.lastname+'</p><p>'+response.profile_img+'</p><p>'+response.hash+'</p><p>'+response.phonenumber+'</p><p>'+response.type+'</p><p>'+response.login_token+'</p><p>'+response.visitors+'</p><p>'+response.vendor_name+'</p><p>'+response.vendor_address+'</p><p>'+response.vendor_open_time+'</p><p>'+response.vendor_close_time+'</p><p>'+response.vendor_type+'</p><p>'+response.lat+'</p><p>'+response.lng+'</p><p>'+response.availability+'</p><p>'+response.wallet+'</p><p>'+response.bank_name+'</p><p>'+response.bank_account_number+'</p><p>'+response.card_id+'</p><p>'+response.rider_type+'</p><p>'+response.rider_credit+'</p>';
           
        } else if (users.status == 404) {
            alert("Fail to connect to our server");
        } else {
            alert("Fail to connect to our server");
        }
    }
    users.send(dataTopost);
}

</script>