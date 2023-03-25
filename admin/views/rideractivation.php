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
                        <li class="breadcrumb-item active">Customers</li>
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
                                        <th>Phone Number</th>
										<th>Rider Type</th>
										<th>Vehicle(Front)</th>
										<th>Vehicle(Side)</th>
                                        <th>IC</th>
                                        <th>Lisence</th>
										<th>Roadtax</th>
										<th>Insurace</th>
										<th>Psv</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $sql = "SELECT * FROM rider_documents WHERE approved='waiting' ORDER by id DESC";
                                        $result = $db->query($sql);
                                        
                                        if ($result->num_rows > 0) {
                                          // output data of each row
                                          while($row = $result->fetch_assoc()) {
												$userid = $row["user_id"];
												$userssql = "SELECT * FROM users WHERE id='$userid'";
												$usersresult = $db->query($userssql);
												if ($usersresult->num_rows > 0){
													$rows = $usersresult->fetch_assoc();
													$usersdata = $rows;
												}
                                        	echo '
                                                          <tr>
                                                            <td>'. $usersdata["firstname"].' '. $usersdata["lastname"].'</td>
                                                            <td>'. $usersdata["phonenumber"].'</td>
															 <td>'. $row["type"].'</td>
															 															 	 <td> <img src="'. $row["front"].'"  class="img-fluid"></td>  <td> <img src="'. $row["side"].'"  class="img-fluid"></td>
                                                            <td><img src="'. $row["ic"].'"  class="img-fluid"></td>
                                                            <td> <img src="'. $row["lisence"].'"  class="img-fluid"></td>
															 <td> <img src="'. $row["roadtax"].'"  class="img-fluid"></td>
															 	 <td> <img src="'. $row["insurance"].'"  class="img-fluid"></td>
																 <td> <img src="'. $row["psv"].'"  class="img-fluid"></td>
																 
                                                            <td>
																<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" onclick="prepareThis(\''. $usersdata["id"].'\', \''. $row["id"].'\', \'On\')">
																ACTION
																</button>
												
															</td>
															
                                                          </tr>
                                        ';	
                                          }
                                        } else {
                                         
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
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<div class="modal fade" id="myModal">
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
				<p>Vehicle Model</p>
				<input type="text" id="carmodel"  class="form-control">
				<p>Plate Number</p>
				<input type="text" id="platenumber"  class="form-control">
					<p>E hailing</p>
					<select id="ehailing" class="form-control">
						
						<option value="false">Off</option>
						<option value="true">On</option>
					</select>
					<br>
				<button class="btn btn-primary" onclick="approve('On')">APPROVE</button> <button class="btn btn-primary" onclick="approve('Off')">DECLINE</button>
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
var userid;
var applicationid;
function prepareThis(uid, aid){
	userid = uid;
	applicationid = aid;
}
function approve(action){
	var carmodel = document.getElementById("carmodel").value;
	var platenumber = document.getElementById("platenumber").value;
	var ehailing = document.getElementById("ehailing").value;
	var dataTopost = "api=1&auth_token=" + authUser.login_token + "&approveuser="+userid+"&applicationid="+applicationid+"&reviewresult="+action+"&carmodel="+carmodel+"&platenumber="+platenumber+"&ehailing="+ehailing;
    var users = new XMLHttpRequest();
    users.open("POST", serverUrl, true);
    users.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    users.onload = function(){
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


</script>