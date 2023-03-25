<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Outreach Vaccination - Corporate</h1>
                </div>
                <div class="col-sm-6"> 
                    
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
										<th>Company Name</th>
                                        <th>Company State</th>                             
                                        <th>Company Phone Number</th>                             
                                        <th>Excel File</th>                             
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $sql = "SELECT * FROM outreach_corporate";
                                        $result = $db->query($sql);
                                        
                                        if ($result->num_rows > 0) {
                                          // output data of each row
										  $noid = 1;
                                          while($row = $result->fetch_assoc()) {                                        	
                                        	echo '
                                                          <tr>
														  <td>'.$row["company_name"].'</td>
                                                          
                                                            <td>'. $row["company_state"].'
                                                            </td>                                                    <td>'. $row["company_phone_number"].'
                                                            </td>     
															<td><a href="'. $row["excel_file"].'">Download<a>
                                                            </td>          															
                                                            <td><a class="btn btn-primary" href="https://epink.health/admin/mobile-vaccination-corporate/view/'.$row["id"].'/">View</a> <a class="btn btn-primary" href="'.$domain.'/mobile-vaccination-corporate/delete/'.$row["id"].'/">Delete</a></td>
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