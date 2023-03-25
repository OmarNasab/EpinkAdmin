<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>BLOG POST</h1>
                </div>
                <div class="col-sm-6"> 
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active"><a href="<?php echo $domain; ?>/blogs/create/" class="btn btn-primary">POST BLOG</a></li>
						<li class="breadcrumb-item active"><a href="<?php echo $domain; ?>/newsarticle/" class="btn btn-primary">POST NEWS ARTICLE</a></li>
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
                                        <th>Title</th>                             
                                        <th>Category</th>                             
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $sql = "SELECT * FROM blogs";
                                        $result = $db->query($sql);
                                        
                                        if ($result->num_rows > 0) {
                                          // output data of each row
										  $noid = 1;
                                          while($row = $result->fetch_assoc()) {                                        	
                                        	echo '
                                                          <tr>
														  <td>'.$row["publishing_date"].'</td>
                                                          
                                                            <td>'. $row["title"].'
                                                            </td>                                                    <td>'. $row["category"].'
                                                            </td>                    
                                                            <td><a class="btn btn-primary" href="https://epink.health/insight/'.$row["permalink"].'/">View</a> <a class="btn btn-primary" href="'.$domain.'/blogs/edit/'.$row["id"].'/">Edit</a> <a class="btn btn-primary" href="'.$domain.'/blogs/delete/'.$row["id"].'/">Delete</a></td>
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
						<div class="form-group">
							<label for="update_uid">User Id</label>
							<input type="text" id="update_uid" name="update_uid" class="form-control" readonly>
						</div>
						<div class="form-group">
							<label for="update_firstname">Firstname</label>
							<input type="text" id="update_firstname" name="update_firstname" class="form-control">
						</div>
						<div class="form-group">
							<label for="update_lastname">Lastname</label>
							<input type="text" id="update_lastname" name="update_lastname" class="form-control">
						</div>
						<div class="form-group">
							<label for="update_lastname">User type</label>
							<select class="form-control" id="update_type">
								<option id="customerselected" value="0">Customer</option>
								<option id="restaurantselected" value="1">Restaurant</option>
								<option id="grocerryselected" value="4">Grocery</option>
								<option id="riderselected" value="2">Rider</option>
							</select>
						</div>
						<div class="form-group">
							<label for="update_email">Email</label>
							<input type="text" id="update_email" name="update_email" class="form-control">
						</div>
						<div class="form-group">
							<label for="update_email">Wallet</label>
							<input type="number" id="update_wallet" name="update_wallet" class="form-control">
						</div>
						<div class="form-group">
							<label for="update_email">Rider Credit</label>
							<input type="number" id="update_credit" name="update_credit" class="form-control">
						</div>
						<button onclick="updateUser()" class="btn btn-primary ">Update</button>
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
function updateUser(){
	var id = document.getElementById("update_uid").value;
	var firstname = document.getElementById("update_firstname").value;
	var lastname = document.getElementById("update_lastname").value;
	var email = document.getElementById("update_email").value;
	var wallet = document.getElementById("update_wallet").value;
	var credit = document.getElementById("update_credit").value;
	var type = document.getElementById("update_type").value;
	var dataTopost = 'api=1&auth_token='+authUser.login_token+"&adminupdateuser="+id+"&firstname="+firstname+"&lastname="+lastname+"&email="+email+"&wallet="+wallet+"&credit="+credit+"&type="+type;
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