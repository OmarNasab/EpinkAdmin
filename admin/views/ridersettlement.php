<?php
$sqlpriceperkm = "SELECT * FROM settings WHERE setting_item='spcommision'";
$priceperkmresult = $db->query($sqlpriceperkm);
if ($priceperkmresult->num_rows > 0) {
	$settingobject = $priceperkmresult->fetch_assoc();
	$spcommision = $settingobject["setting_value"];
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Rider Settlements</h1>
                </div>
                <div class="col-sm-6"> 
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Settle rider earnings</li>
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
                        <div class="card-header"><b>To pay rider</b></div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
										<th>Fullname</th>
										<th>Earning</th>
										<th>E pink Cut(<?php echo $spcommision; ?>%)</th>
                                        <th>Amount to settle(RM)</th>
                                        <th>Bank Name</th>
                                        <th>Bank Account Number</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $sql = "SELECT * FROM users WHERE wallet > 0 AND type = 2 ";
                                        $result = $db->query($sql);                                     
                                        if ($result->num_rows > 0) {
                                          // output data of each row
										  $noid = 1;
                                          while($row = $result->fetch_assoc()) {
                                        	if($row["fullname"] == null || $row["fullname"] == ""){
												$row["fullname"] = $row["firstname"].' '.$row["lastname"];
											}
											if($row["bank_name"] == "" || $row["bank_name"] == null){
												$row["bank_name"] = "Not set";
											}
											if($row["bank_account_number"] == "" || $row["bank_account_number"] == null){
												$row["bank_account_number"] = "Not set";
											}
											$spearning = $row["wallet"];
											$commision = $spcommision * $spearning / 100;
											$topay = $spearning - $commision;
											echo '
                                                <tr>
													<td>'. $row["fullname"].'</td>
                                                    <td>RM'. $row["wallet"].'</td>	
                                                    <td>RM'. $commision.'</td>	
                                                    <td>RM'. $topay.'</td>	
                                                    <td>'. $row["bank_name"].'</td>
                                                    <td>'. $row["bank_account_number"].'</td>
													 <td><a href="#" class="btn btn-primary btn-sm"   data-toggle="modal" data-target="#clearwallet" onclick="prepareClear('. $row["id"].')">CLEAR WALLET</a></td>
                                                </tr>
												';	
											$noid++;
                                          }
                                        } else {
                                          
                                        }
                                        		
                                        ?>	  
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    
					 <div class="card">
                        <div class="card-body">
							<p class="font-weight-bold">Guide</p>
							<p  class="text-sm">1. Transfer the Amount to settle to service provider bank account.</p>
							<p  class="text-sm">2. Clear service provider wallet by pressing the clear wallet button</p>
							<p  class="text-sm">-Service provider wallet balance in EPINK.HEALTH will be cleared.</p>
							<p  class="text-sm">-Service provider will be notified on this transaction</p>
						</div>
					</div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<div class="modal fade" id="clearwallet" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Clear Wallet</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<p>Clear all service provider wallet after payment.</p>
				<p class="text-sm">
				Once you have transfer all the amount you need to settle to the service provider to the bank account, you can clear thier wallet using this function.</p>
				<p  class="text-sm">-Service provider wallet balance in EPINK.HEALTH will be cleared and set to 0.</p>
				<p  class="text-sm">-Service provider will be notified on this transaction</p>
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" onclick="emptySpWallet()">Save changes</button>
			</div>
		</div>
	</div>
</div>


<script>
var gid = 0
var serverUrl = 'https://epink.health/api/index.php';
function prepareClear(id){
	gid = id;
}
function emptySpWallet(){
	var dataTopost = 'api=1&auth_token='+authUser.login_token+"&clearwalletuserbase="+gid;
		var xhr = new XMLHttpRequest();
		xhr.open("POST", serverUrl, true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhr.onload = function() {
			if (xhr.status == 200) {
				var json = xhr.responseText;
				var response = JSON.parse(json);
				if(response.status == "Success"){
					location.reload();
				}else{
					alert(response.message);
				}
				
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
				document.getElementById("update_type").value= "0";
			}else if(response.type == "1"){
				var usertype = "Restaurant owner / Manager";
				document.getElementById("update_type").value= "1";
			}else if(response.type == "2"){
				var usertype = "Rider";
				document.getElementById("update_type").value= "2";
			}else if(response.type == "4"){
				var usertype = "Grocery owner / Manager";
				document.getElementById("update_type").value= "4";
			}else if(response.type == "8"){
				var usertype = "Admin";
				document.getElementById("update_type").value= "8";
			}
			
			document.getElementById("view").innerHTML = '<p>Viewing user information</p>'+imgviewer+'<p><span class="font-weight-bold">Name:</span> '+response.firstname+' '+response.lastname+'</p><p><span class="font-weight-bold">Email:</span> '+response.email+'</p><p><span class="font-weight-bold">Phone number:</span> '+response.phonenumber+'</p><p><span class="font-weight-bold">Wallet:RM</span> '+response.wallet+'</p>';
			
			document.getElementById("update_uid").value = response.id;
			document.getElementById("update_firstname").value = response.firstname;
			document.getElementById("update_lastname").value = response.lastname;
			document.getElementById("update_email").value = response.email;
			document.getElementById("update_wallet").value = response.wallet;
			document.getElementById("update_credit").value = response.rider_credit;
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