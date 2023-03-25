<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Customers</h1>
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
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                        <th>Type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $sql = "SELECT * FROM users WHERE type=0";
                                        $result = $db->query($sql);
                                        
                                        if ($result->num_rows > 0) {
                                          // output data of each row
                                          while($row = $result->fetch_assoc()) {
                                        	if($row["type"] == "0"){
                                        		$type="Customer";
                                        	}elseif($row["type"] == "1"){
                                        		$type="Restaurant Owner";
                                        	}elseif($row["type"] == "2"){
                                        		$type="Rider";
                                        	}elseif($row["type"] == "4"){
                                        		$type="Grocery Owner";
                                        	}
                                        	echo '
                                                          <tr>
                                                            <td>'. $row["firstname"].' '. $row["firstname"].'</td>
                                                            <td>'. $row["email"].'
                                                            </td>
                                                            <td>'. $row["phonenumber"].'</td>
                                                            <td> '. $type.'</td>
                                                            <td><center><button type="button" class="btn btn-lg" data-toggle="modal" data-target="#modal-xl" onclick="viewThisusers('.$row["id"].')"><i class="fas fa-cogs"></i></button></center></td>
                                                          </tr>
                                        ';	
                                          }
                                        } else {
                                          echo "0 results";
                                        }
                                        		
                                        ?>	  
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                        <th>Type</th>
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
var serverUrl = 'http://localhost/vappyapi/index.php';
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