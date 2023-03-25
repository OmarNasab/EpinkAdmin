<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Activation Request</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Restaurant and grocery activation requests</li>
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
                                        <th>Name</th>
										<th>Establishment Name</th>
										<th>Type</th>
										<th>Uploaded Product</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                       
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $sql = "SELECT * FROM users WHERE type=1 AND availability='Waiting' AND  profile_img != 'img/default_profile_picture.jpg' OR type=4 AND availability='Waiting' AND profile_img != 'img/default_profile_picture.jpg'";
                                        $result = $db->query($sql);
                                        
                                        if ($result->num_rows > 0) {
                                          // output data of each row
                                          while($row = $result->fetch_assoc()) {
                                        	if($row["type"] == "0"){
                                        		$type="Customer";
                                        	}elseif($row["type"] == "1"){
                                        		$type="Restaurant";
												$vendor_halal = $row["vendor_halal"];
												if($vendor_halal == "Halal"){
													$halal_cert = '<img src="'.$row["halal_ceterficate"].'" width="100%" >';
												}else{
													$halal_cert = "";
												}
                                        	}elseif($row["type"] == "2"){
                                        		$type="Rider";
                                        	}elseif($row["type"] == "4"){
                                        		$type="Grocery Owner";
                                        	}
											$owner = $row["id"];
$sqlz = "SELECT * FROM products WHERE owner ='$owner'";
$resultz = $db->query($sqlz);
$productcount = $resultz->num_rows;						
                                        	echo '
                                                          <tr>
                                                            <td>'. $row["firstname"].' '. $row["lastname"].'</td>
															 <td>'. $row["vendor_name"].'
                                                            </td>
															 <td> '. $type.' <br>Halal: '.$vendor_halal.'<br>'.$halal_cert.'</td>
															  <td> '. $productcount.'</td>
                                                            <td>'. $row["email"].'
                                                            </td>
                                                            <td>'. $row["phonenumber"].'</td>
                                                           
                                                             <td><button class="btn btn-success" onclick="approve('. $row["id"].')">Activate</button></td>
                                                          </tr>
                                        ';	
                                          }
                                        } else {
                                        	echo '
                                                       
                                        ';
                                        }
                                        		
                                        ?>	  
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Name</th>
										<th>Establishment Name</th>
										<th>Type</th>
										<th>Uploaded Product</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>                                 
                                        <th>Action</th>
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
				Activation Panel
                </p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="view" class="modal-body">
				
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script>

var serverUrl = 'https://osocapto.app/api/index.php';
var apiVersion = 1;
var authUser = {"login_token":""};
authUser.login_token = '<?php echo $authuser["login_token"]; ?>';
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
				document.getElementById("view").innerHTML = '<p>Viewing user information</p>'+imgviewer+'<p><span class="font-weight-bold">Name:</span> '+response.firstname+' '+response.lastname+'</p><p><span class="font-weight-bold">Email:</span> '+response.email+'</p><p><span class="font-weight-bold">Phone number:</span> '+response.phonenumber+'</p><p><span class="font-weight-bold">Establishment Name:</span> '+response.vendor_name+'</p><p>Products</p><ul class="list-group" id="useritem"></ul>';
				var products = JSON.parse(response.products);
				var i;
				for (i = 0; i < products.length; i++) {
				  text += cars[i] + "<br>";
				}
				
			}else if(response.type == "2"){
				var usertype = "Rider";
			}else if(response.type == "4"){
				var usertype = "Grocery owner / Manager";
				document.getElementById("view").innerHTML = '<p>Viewing user information</p>'+imgviewer+'<p><span class="font-weight-bold">Name:</span> '+response.firstname+' '+response.lastname+'</p><p><span class="font-weight-bold">Email:</span> '+response.email+'</p><p><span class="font-weight-bold">Phone number:</span> '+response.phonenumber+'</p><p><span class="font-weight-bold">Establishment Name:</span> '+response.vendor_name+'</p>';
			}else if(response.type == "8"){
				var usertype = "Admin";
			}
		
			//document.getElementById("view").innerHTML = '<img src="'+response.profile_img+'"><p>'+response.email+'</p><p>'+response.firstname+'</p><p>'+response.lastname+'</p><p>'+response.profile_img+'</p><p>'+response.hash+'</p><p>'+response.phonenumber+'</p><p>'+response.type+'</p><p>'+response.login_token+'</p><p>'+response.visitors+'</p><p>'+response.vendor_name+'</p><p>'+response.vendor_address+'</p><p>'+response.vendor_open_time+'</p><p>'+response.vendor_close_time+'</p><p>'+response.vendor_type+'</p><p>'+response.lat+'</p><p>'+response.lng+'</p><p>'+response.availability+'</p><p>'+response.wallet+'</p><p>'+response.bank_name+'</p><p>'+response.bank_account_number+'</p><p>'+response.card_id+'</p><p>'+response.rider_type+'</p><p>'+response.rider_credit+'</p>';
           
        } else if (users.status == 404) {
            alert("Fail to connect to our server");
        } else {
            alert("Fail to connect to our server");
        }
    }
    users.send(dataTopost);
}

function approve(userid){
	var dataTopost = "api=1&auth_token=" + authUser.login_token + "&approveestablishement="+userid;
    var users = new XMLHttpRequest();
    users.open("POST", serverUrl, true);
    users.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    users.onload = function() {
        if (users.status == 200) {
            var json = users.responseText;
            var response = JSON.parse(json);
			location.reload();
        } else if (users.status == 404) {
            alert("Fail to connect to our server");
        } else {
            alert("Fail to connect to our server");
        }
    }
    users.send(dataTopost);
}
</script>