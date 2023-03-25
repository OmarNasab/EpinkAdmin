<?php
    $productmargin = 10;
    $target_dir = "../api/assets/";
    $actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    if(isset($_POST["deleteestablishment"])){
    	$estid = cleanInput($_POST["deleteid"]);
    	$sql = "DELETE FROM users WHERE id='$estid'";
    	if ($db->query($sql) === TRUE) {
    	  $res = "Record deleted successfully";
    	   $notfound = 'location.href = "/admin/dashboard/";';
    	} else {
    	  $res = "Error deleting record: " . $db->error;
    	}
    }
    if(isset($_POST["uploadmenu"])) {
    if(isset($_FILES["menuToUpload"])){
    $target_file = $target_dir . basename($_FILES["menuToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
      $check = getimagesize($_FILES["menuToUpload"]["tmp_name"]);
      if($check !== false) {
        $res =  "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
      } else {
        $res =  "File is not an image.";
        $uploadOk = 0;
    }
    // Check if file already exists
    if (file_exists($target_file)) {
      $res =  "Sorry, file already exists.";
      $uploadOk = 0;
    }
    
    // Check file size
    if ($_FILES["menuToUpload"]["size"] > 500000) {
      $res =  "Sorry, your file is too large.";
      $uploadOk = 0;
    }
    
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
      $res =  "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      
      $uploadOk = 0;
      
    }else{
    	$filenameo = md5(rand(1000000,1000000000).uniqid().rand(1999, 5999)).'.'.$imageFileType;
    	$newfilename = $target_dir.$filenameo;
    }
    
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
      $res =  "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
      if(move_uploaded_file($_FILES["menuToUpload"]["tmp_name"], $newfilename)) {
    		$res =  "The product has been uploaded";
            $owner = cleanInput($_POST["uploadtoid"]);
            $name = cleanInput($_POST["name"]);
            $description = cleanInput($_POST["description"]);
            $addondata = cleanInput($_POST["addondata"]);
            $originalprice = cleanInput($_POST["originalprice"]);
            $price = cleanInput($_POST["price"]);
            $delivery = cleanInput($_POST["delivery"]);
            $picture = "https://epink.health/api/assets/".$filenameo;
            $lat = cleanInput($_POST["lat"]); 
            $lng = cleanInput($_POST["lng"]);
            $stock = cleanInput($_POST["stock"]);
            $available = cleanInput($_POST["available"]);	
    		$selectcategory = cleanInput($_POST["selectcategory"]);	 
			$faq = cleanInput($_POST["faq"]);
			$forgot = cleanInput($_POST["forgot"]);
			$overview = cleanInput($_POST["overview"]);
			$tip = cleanInput($_POST["tip"]);
			$sideeffect = cleanInput($_POST["sideeffect"]);
			$precaution = cleanInput($_POST["precaution"]);
			$about = cleanInput($_POST["about"]);
			$require_prescription = cleanInput($_POST["require_prescription"]);
    	if($owner != "" && $require_prescription != ""){
    		
    			$productssql = "INSERT INTO products (owner, name, description, addondata, originalprice, price, delivery, picture, lat, lng, stock, available, category, faq, forgot, overview, tip, sideeffect, precaution, about, require_prescription)
    			VALUES ('$owner', '$name', '$description', '$addondata', '$originalprice', '$price', '$delivery', '$picture', '$lat', '$lng', '$stock', '$available', '$selectcategory', '$faq', '$forgot', '$overview', '$tip', '$sideeffect', '$precaution', '$about', '$require_prescription')";
    
    			if ($db->query($productssql) === TRUE) {
    				$row["card"] = "green";
    				$row["status"] = "Successful";
    				$row["message"] =  "New record successfully created";
    				$data = $row;
    			} else {
    				$row["card"] = "red";
    				$row["status"] = "Fail";
    				$row["message"] =  "Error: " . $productssql . "<br>" . $db->error;
    				$res = "Error: " . $productssql . "<br>" . $db->error;
    				$data = $row;
    			}
    		}else{
    			$row["card"] = "red";
    			$row["status"] = "Fail";
    			$row["message"] = "Please fill all the form";
    			$data = $row;
    			$res = "Please fill all the form";
    		}	
    	
      } else {
        $res =  "Sorry, there was an error uploading your file.";
      }
    }
    	}else{
    		$res =  'Please select an image';
    		echo $_FILES["menuToUpload"];
    	}
    	 $row["card"]    = "green";
            $row["status"]  = "Successfull";
            $row["message"] = $res;
            $data           = $row;
    }
    
    
    
    if(isset($_POST["updatevendorlogo"])) {
    	$vid = $_POST["vendorid"];
    	if(isset($_FILES["fileToUpload"])){
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
      $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
      if($check !== false) {
        $uploadOk = 1;
      } else {
        echo "File is not an image.";
        $uploadOk = 0;
      }
    
    
    // Check if file already exists
    if (file_exists($target_file)) {
      $res =  "Sorry, file already exists.";
      $uploadOk = 0;
    }
    
    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
       $res =  "Sorry, your file is too large.";
      $uploadOk = 0;
    }
    
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
       $res =  "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      
      $uploadOk = 0;
      
    }else{
    	$filenameo = md5(uniqid().rand(1000,10000000)).'.'.$imageFileType;
    	$newfilename = $target_dir.$filenameo;
    }
    
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
       $res =  "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $newfilename)) {
       
    	$settingvalue = 'https://epink.health/api/assets/'.$filenameo;
    	$sql = "UPDATE users SET profile_img='$settingvalue' WHERE id='$vid'";
    
    	if ($db->query($sql) === TRUE) {
    	  $res =  "Record updated successfully";
    	} else {
    	  $res =  "Error updating record: " . $db->error;
    	}
      } else {
         $res =  "Sorry, there was an error uploading your file.";
      }
    }
    	}else{
    		echo 'Please select an image';
    		echo $_FILES["fileToUpload"];
    	}
    }
    if (isset($_POST["submitupdateusers"]) && $_POST["csrf"] == $_SESSION["csrftoken"]) {
        $id                  = cleanInput($_POST["editid"]);
        $email               = cleanInput($_POST["editemail"]);
        $password            = cleanInput($_POST["editpassword"]);
        $type                = cleanInput($_POST["editvendor_type"]);
        $vendor_name         = cleanInput($_POST["editvendor_name"]);
        $vendor_open_time    = cleanInput($_POST["editvendor_open_time"]);
        $vendor_close_time   = cleanInput($_POST["editvendor_close_time"]);
        $vendor_type         = cleanInput($_POST["editvendor_type"]);
        $vendor_halal        = cleanInput($_POST["editvendor_halal"]);
        $lat                 = cleanInput($_POST["editlat"]);
        $lng                 = cleanInput($_POST["editlng"]);
        $bank_name           = cleanInput($_POST["editbank_name"]);
        $bank_account_number = cleanInput($_POST["editbank_account_number"]);
        $phonenumber = cleanInput($_POST["editphonenumber"]);
        $vendor_address = cleanInput($_POST["pickupaddress"]);
     
    
        $sql = "UPDATE users SET email='$email', phonenumber='$phonenumber', type='$type', vendor_name='$vendor_name', vendor_address='$vendor_address', vendor_open_time='$vendor_open_time', vendor_close_time='$vendor_close_time', vendor_type='$vendor_type', lat='$lat', lng='$lng', bank_name='$bank_name', bank_account_number='$bank_account_number' WHERE  id='$id'";
        if ($db->query($sql) === TRUE) {
            $row["card"]    = "green";
            $row["status"]  = "Successfull";
            $row["message"] = "The record has been updated successfully";
            $data           = $row;
        } else {
            $row["card"]    = "red";
            $row["status"]  = "Fail";
            $row["message"] = "Error updating record: " . $db->error;
            $data           = $row;
        }
    }
    
    $id          = cleanInput($page_identifier_action);
    $userssql    = "SELECT * FROM users WHERE id='$id'";
    $usersresult = $db->query($userssql);
    if ($usersresult->num_rows > 0) {
        $row         = $usersresult->fetch_assoc();
        $usersobject = $row;
    } else {
      
       $notfound = 'location.href = "/admin/dashboard/";';
    }
    
    ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Pharmacist manager</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Pharmacist manager</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <a href="#" onclick="openFullinfo()" class="btn btn-default">Information</a>
            <a href="#" onclick="openCategoryManager()" class="btn btn-default">Category Manager</a>
            <a href="#" onclick="openOrderhistory()"  class="btn btn-default">Order History</a>	
            <a href="#" onclick="openMenuList()"  class="btn btn-default">Products</a>
            <a href="#" onclick="openProductPoster()" class="btn btn-default">Post Product</a>
            <a href="#" onclick="openUpdateAccount()"  class="btn btn-default">Update Vendor</a>
            <a href="#" onclick="openDeleteEst()"  class="btn btn-default">Delete Pharmacist</a>
			<a href="#" onclick="assignDoctor()"  class="btn btn-default">Assign Doctor</a>
        <!--  <a href="#" onclick="openOperation()" class="btn btn-default">Operation Hour & Day</a> -->
            <?php
                if (isset($data)) {
                	echo '<div class="card">
                 <div class="card-body">
                   ' . $data["message"] . '
                 </div>
                </div>
                			
                	
                
                	';
                }
                ?>
            <br><br>
        </div>
        <div id="orderhistory" style="display: none">
            <div class="card">
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Job ID</th>
                                <th>Customer</th>
                                <th>Rider Name</th>
                                <th>Vendor Profit</th>
                                <th>Company Profit</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $resorderhistory = $usersobject["id"];
                                        $sql = "SELECT * FROM job_order WHERE order_status= 'Completed' AND restaurant_id='$resorderhistory' ORDER by id DESC";
										$result = $db->query($sql);
                                                              
                                        if ($result->num_rows > 0) {
                                                               
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
                                	
                                	
                                		<td><a href="'.$domain.'/customers/'.$rows["id"].'/">'. $rows["firstname"].' '. $rows["lastname"].'</a></td>
                                		
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
                                			<td>Date: '.$row["pickup_date"].' 
                                			<img src="'.$row["pickup_image"].'" class="img-fluid">
                                			</td>
                                			<td>Date: '.$row["pickup_date"].'<img src="'.$row["drop_image"].'" class="img-fluid"></td>
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
                                                               
                                                              }
                                                              		
                                                              ?>	  
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->		
        </div>
        <div id="categorymanager" class="container" style="display: none;">
            <div class="row">
                <div class="col-6">
                    <p class="strong">Vendor Category</p>
                    <ul id="listofcategory" class="list-group">
                    </ul>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label>Category Name</label>
                        <input type="text" id="addcat" class="form-control">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary amber darken-2" onclick="addCategory()">Add New</button>
                    </div>
                </div>
            </div>
            <script>
				var serverUrl = 'https://epink.health/api/index.php';
                var listofcategories;
                var curentarray = '<?php echo $usersobject["categories"]; ?>';
                function initCategorylist(){
                	document.getElementById("listofcategory").innerHTML  = "";
                	var cat = '<?php echo $usersobject["categories"]; ?>';
                	listofcategories = JSON.parse(cat);
                	console.log(listofcategories);
                	var i;
                	for (i = 0; i < listofcategories.length; i++) {
                	  document.getElementById("listofcategory").innerHTML += '<li class="list-group-item">'+listofcategories[i].name+' <span class="pull-right"><a href="#!" onclick="removeCategory('+i+', \''+listofcategories[i].name+'\')" class="pull-right"><i class="fas fa-times"></i></a</span></li>';
                	}
                }
		function removeDoctor(){
			var docid = document.getElementById("vdocid").value;
			var dataTopost = 'api=1&auth_token='+authUser.login_token+'&adminremoveassigneddoctor=true&pharmaid=<?php echo $usersobject["id"]; ?>';
                		var xhr = new XMLHttpRequest();
                		xhr.open("POST", serverUrl, true);
                		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                		xhr.onload = function() {
                			if (xhr.status == 200) {
								
                				var json = xhr.responseText;
                				var response = JSON.parse(json);
                				if(response.status == "fail"){
                					alert(response.message);
								
                					
                				}else{
                					alert(response.message);
									document.getElementById("vdocid").innerHTML = '';
									document.getElementById("voname").innerHTML = '';
									document.getElementById("hasdoc").style.display = 'none';
									document.getElementById("nodoc").style.display = 'block	';
                					
                				}
                			} else if (xhr.status == 404) {
                				alert("Fail to connect to our server");
                			} else {
                				alert("Fail to connect to our server");
                			}
                		}
                		xhr.send(dataTopost);
		}	
		function assignADoctor(){
			var doctoremail = document.getElementById("emailtoassign").value;
			var dataTopost = 'api=1&auth_token='+authUser.login_token+'&adminassigndoctor='+doctoremail+'&pharmaid=<?php echo $usersobject["id"]; ?>';
                		var xhr = new XMLHttpRequest();
                		xhr.open("POST", serverUrl, true);
                		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                		xhr.onload = function() {
                			if (xhr.status == 200) {
								
                				var json = xhr.responseText;
                				var response = JSON.parse(json);
                				if(response.status == "fail"){
                					alert(response.message);
                					
                				}else{
                					alert(response.message);
									document.getElementById("vdocid").innerHTML = response.docid;
									document.getElementById("voname").innerHTML = response.docname;
									document.getElementById("hasdoc").style.display = 'block';
									document.getElementById("nodoc").style.display = 'none';
                					
                				}
                			} else if (xhr.status == 404) {
                				alert("Fail to connect to our server");
                			} else {
                				alert("Fail to connect to our server");
                			}
                		}
                		xhr.send(dataTopost);
		}

	
                function addCategory(){
                	console.log(curentarray);
                	var exist = false;
                	var cat = curentarray;
                	var toAdd = document.getElementById("addcat").value;
                	var toAdd = toAdd.replace("&", "and");
                	listofcategories = JSON.parse(cat);
                	var i;
                	for (i = 0; i < listofcategories.length; i++) {
                	  if(listofcategories[i].name == toAdd){
                		  exist = true;
                	  }
                	}
                	if(exist == false){	
                		listofcategories.push({ name: toAdd });
                		curentarray = JSON.stringify(listofcategories);
                		console.log(listofcategories);
                		updateCategoryData("add",  toAdd);
                		
                	}else{
                		alert("This category already existed");
                	}
                }
                
                function updateCategoryData(ops, nameavailable){
            
                		var dataTopost = 'api=1&auth_token='+authUser.login_token+'&adminupdatecarecategory='+curentarray+'&type='+ops+'&nameavailable='+nameavailable;
                		var xhr = new XMLHttpRequest();
                		xhr.open("POST", serverUrl, true);
                		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                		xhr.onload = function() {
                			if (xhr.status == 200) {
								
                				var json = xhr.responseText;
                				var response = JSON.parse(json);
                				if(response.status == "fail"){
                					alert(response.message);
                					location.reload();
                				}else{
                					alert(response.message);
                					location.reload();
                				}
                			} else if (xhr.status == 404) {
                				alert("Fail to connect to our server");
                			} else {
                				alert("Fail to connect to our server");
                			}
                		}
                		xhr.send(dataTopost);
                }
                function removeCategory(id, name){
                	console.log(id);
                	listofcategories.splice(id, 1);
                	curentarray = JSON.stringify(listofcategories);
                	initCategorylist();
                	updateCategoryData("remove", name);
                	
                }
                initCategorylist();
                	
            </script>
            <br>
        </div>
        <div id="manageoperationhour" style="display: none">
            <div id="operationsdays" class="container">
            </div>
            <br>
            <div class="container">
                <button class="btn btn-primary amber white-text" onclick="updateOperation()">UPDATE</button>
                <script>
                    function initOperations(){
                    		var dataTopost = 'api=1&auth_token='+authUser.login_token+"&operationhoursadmin=<?php echo $usersobject["id"]; ?>";
                    		var xhr = new XMLHttpRequest();
                    		xhr.open("POST", serverUrl, true);
                    		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                    		xhr.onload = function() {
                    			if (xhr.status == 200) {
                    				var json = xhr.responseText;
                    				var response = JSON.parse(json);
                    				document.getElementById("operationsdays").innerHTML ="";
                    				var i;
                    				for (i = 0; i < response.length; i++) { 
                    					if(response[i].dayname == "WENESDAY"){
                    						var uiwenesday = "WEDNESDAY";
                    					}else{
                    						var uiwenesday = response[i].dayname;
                    					}
                    					document.getElementById("operationsdays").innerHTML += '<h1 class="strong flow-text">'+uiwenesday+'</h1> <input type="time" id="'+response[i].dayname+'Opentime" value="'+response[i].opentime+'"> <input type="time" id="'+response[i].dayname+'Closetime" value="'+response[i].closetime+'"><br>';
                    					if(response[i].dayopen == "true"){
                    						console.log("am I called");
                    							document.getElementById("operationsdays").innerHTML += '<div id="input-field"><select id="'+response[i].dayname+'Open"><option value="true" selected>Open</option><option value="false">Closed</option><option value="">Please Select</option></select></div>';
                    					}else if(response[i].dayopen == "false"){
                    							document.getElementById("operationsdays").innerHTML += '<div id="input-field"><select id="'+response[i].dayname+'Open"><option value="false" selected>Closed</option><option value="true">Open</option><option value="">Please Select</option></select></div>';
                    					}else{
                    							document.getElementById("operationsdays").innerHTML += '<div id="input-field"><select id="'+response[i].dayname+'Open"><option value="" disabled selected>Please Select</option><option value="false" >Closed</option><option value="true">Open</option></select></div>';
                    					}
                    				}		
                    				
                    			} else if (xhr.status == 404) {
                    				alert("Fail to connect to our server");
                    			} else {
                    				alert("Fail to connect to our server");
                    			}
                    		}
                    		xhr.send(dataTopost);
                    
                    }	
                    //initOperations();
                    function updateOperation(){
                    	
                    	var MONDAYOpentime = document.getElementById("MONDAYOpentime").value;
                    	var MONDAYOpen = document.getElementById("MONDAYOpen").value;
                    	var TUESDAYOpentime = document.getElementById("TUESDAYOpentime").value;
                    	var TUESDAYOpen = document.getElementById("TUESDAYOpen").value;
                    	var WEDNESDAYOpentime = document.getElementById("WENESDAYOpentime").value;
                    	var WEDNESDAYOpen = document.getElementById("WENESDAYOpen").value;
                    	var THURSDAYOpentime = document.getElementById("THURSDAYOpentime").value;
                    	var THURSDAYOpen = document.getElementById("THURSDAYOpen").value;
                    	var FRIDAYOpentime = document.getElementById("FRIDAYOpentime").value;
                    	var FRIDAYOpen = document.getElementById("FRIDAYOpen").value;
                    	var SATURDAYOpentime = document.getElementById("FRIDAYOpentime").value;
                    	var SATURDAYOpen = document.getElementById("SATURDAYOpen").value;
                    	var SUNDAYOpentime = document.getElementById("FRIDAYOpentime").value;
                    	var SUNDAYOpen = document.getElementById("SUNDAYOpen").value;
                    	
                    	var MONDAYClosetime = document.getElementById("MONDAYClosetime").value;
                    	var TUESDAYClosetime = document.getElementById("TUESDAYClosetime").value;
                    	var WEDNESDAYClosetime = document.getElementById("WENESDAYClosetime").value;
                    	var THURSDAYClosetime = document.getElementById("THURSDAYClosetime").value;
                    	var FRIDAYClosetime = document.getElementById("FRIDAYClosetime").value;
                    	var SATURDAYClosetime = document.getElementById("FRIDAYClosetime").value;
                    	var SUNDAYClosetime = document.getElementById("FRIDAYClosetime").value;
                    	
                    		var dataTopost = 'api=1&auth_token='+authUser.login_token+"&updateoperationhouradmin=<?php echo $usersobject["id"]; ?>&MONDAYOpentime="+MONDAYOpentime+"&MONDAYClosetime="+MONDAYClosetime+"&MONDAYOpen="+MONDAYOpen+"&TUESDAYOpentime="+TUESDAYOpentime+"&TUESDAYClosetime="+TUESDAYClosetime+"&TUESDAYOpen="+TUESDAYOpen+"&WEDNESDAYOpentime="+WEDNESDAYOpentime+"&WEDNESDAYClosetime="+WEDNESDAYClosetime+"&WEDNESDAYOpen="+WEDNESDAYOpen+"&THURSDAYOpentime="+THURSDAYOpentime+"&THURSDAYClosetime="+THURSDAYClosetime+"&THURSDAYOpen="+THURSDAYOpen+"&FRIDAYOpentime="+FRIDAYOpentime+"&FRIDAYClosetime="+FRIDAYClosetime+"&FRIDAYOpen="+FRIDAYOpen+"&SATURDAYOpentime="+SATURDAYOpentime+"&SATURDAYOpen="+SATURDAYOpen+"&SATURDAYClosetime="+SATURDAYClosetime+"&SUNDAYOpentime="+SUNDAYOpentime+"&SUNDAYOpen="+SUNDAYOpen+"&SUNDAYClosetime="+SUNDAYClosetime;
                    		
                    		var xhr = new XMLHttpRequest();
                    		xhr.open("POST", serverUrl, true);
                    		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                    		xhr.onload = function() {
                    			if (xhr.status == 200) {
                    				var json = xhr.responseText;
                    				var response = JSON.parse(json);
                    				
                    				
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
        </div>
        <div id="viewaccount" class="container">
            <div class="row">
                <div class="col-sm-4">
                    <div class="card" style="width: 100%;">
                        <?php
                            if($usersobject["profile_img"] == 'img/default_profile_picture.jpg'){
                            	$usersobject["profile_img"] = 'https://via.placeholder.com/500x500';
                            }
                            ?>
                        <img class="card-img-top" src="<?php echo $usersobject["profile_img"]; ?>" alt="Card image cap">
                        <div class="card-body">
                            <table class="table-responsive" >
                                <thead>
                                    <tr>
                                        <th>Account Manager</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td> 
                                            Name
                                        </td>
                                        <td> 
                                            <?php echo $usersobject["firstname"]; ?><?php echo $usersobject["lastname"]; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> 
                                            Email
                                        </td>
                                        <td> 
                                            <?php echo $usersobject["email"]; ?>
                                        </td>
                                    </tr>
                                    <td> 
                                        Phonenumber
                                    </td>
                                    <td> 
                                        <?php echo $usersobject["phonenumber"]; ?>
                                    </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="card">
                        <div class="card-body">
                            <table class="table-responsive" >
                                <thead>
                                    <tr>
                                        <th>Establishment Detail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td> 
                                            Type
                                        </td>
                                        <td> 
                                            <?php if($usersobject["type"] == 4){ echo 'Mart'; }elseif($usersobject["type"] == 1){ echo 'Restaurant';} ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> 
                                            Vendor name
                                        </td>
                                        <td> 
                                            <?php echo $usersobject["vendor_name"]; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> 
                                            Vendor address
                                        </td>
                                        <td> 
                                            <?php echo $usersobject["vendor_address"]; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> 
                                            Vendor open time
                                        </td>
                                        <td> 
                                            <?php echo $usersobject["vendor_open_time"]; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> 
                                            Vendor close time
                                        </td>
                                        <td> 
                                            <?php echo $usersobject["vendor_close_time"]; ?>
                                        </td>
                                    </tr>
                                    <tr style="display: none">
                                        <td> 
                                            Vendor type
                                        </td>
                                        <td> 
                                            <?php if($usersobject["type"] == 1){ echo 'Restaurant';}else{ echo 'Store'; }; ?>
                                        </td>
                                    </tr>
                                    <tr tyle="display: none">
                                        <td> 
                                            Vendor halal
                                        </td>
                                        <td> 
                                            <?php if($usersobject["vendor_halal"] == null ){ echo 'Not set'; }else{ echo $usersobject["vendor_halal"]; } ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> 
                                            Lat
                                        </td>
                                        <td> 
                                            <?php echo $usersobject["lat"]; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> 
                                            Lng
                                        </td>
                                        <td> 
                                            <?php echo $usersobject["lng"]; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> 
                                            Availability
                                        </td>
                                        <td> 
                                            <?php echo $usersobject["availability"]; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> 
                                            Bank name
                                        </td>
                                        <td> 
                                            <?php echo $usersobject["bank_name"]; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> 
                                            Bank account number
                                        </td>
                                        <td> 
                                            <?php echo $usersobject["bank_account_number"]; ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <table class="table-responsive" >
                                <thead>
                                    <tr>
                                        <th>Finance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td> 
                                            Wallet
                                        </td>
                                        <td> 
                                            RM <?php echo $usersobject["wallet"]; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> 
                                            Bank name
                                        </td>
                                        <td> 
                                            <?php echo $usersobject["bank_name"]; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> 
                                            Account number
                                        </td>
                                        <td> 
                                            <?php echo $usersobject["bank_account_number"]; ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script></script>
        <div class="container-fluid" id="deleteest"  style="display: none;">
            <h3>Delete this establishment</h3>
            <p>Are you sure about deleting this establishment? You cant undo this process.</p>
            <form method="POST" action="<?php echo $actual_link; ?>">
                <input type="text" name="deleteid" value="<?php echo $id; ?>" hidden>
                <button type="submit" name="deleteestablishment" class="btn btn-danger">Delete</button>
            </form>
        </div>
        <div class="container-fluid" id="updateaccount"  style="display: none;">
            <div class="card">
                <div class="card-body">
                    <p  class="font-weight-bold">Vendor Logo</p>
                    <form action="<?php echo $actual_link; ?>" method="POST" enctype="multipart/form-data">
                        <input type="text" id="vendorid" name="vendorid" value="<?php
                            echo $usersobject["id"];
                            ?>" hidden>
                        <img src="<?php echo $usersobject["profile_img"]; ?>" width="250px"><br><br>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="fileToUpload" name="fileToUpload">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                        <button type="submit" class="btn btn-default" name="updatevendorlogo">Update</button>
                    </form>
                    <br/>
                    <p>Vendor Information</p>
                    <form id="editusers" method="POST" enctype="multipart/form-data" action="<?php
                        echo $page_url;
                        ?>">
                        <input type="text" id="csrf" name="csrf" value="<?php echo $csrftoken; ?>" hidden>
                        <input type="text" id="editid" name="editid" value="<?php echo $usersobject["id"]; ?>" hidden>
                        <div class="form-group">
                            <label for="editemail">Email</label>
                            <input type="text" id="editemail" class="form-control" name="editemail" value="<?php
                                echo $usersobject["email"];
                                ?>">
                        </div>
                        <div class="form-group">
                            <label for="editemail">Phone Number</label>
                            <input type="text" id="editphonenumber" class="form-control" name="editphonenumber" value="<?php
                                echo $usersobject["phonenumber"];
                                ?>">
                        </div>
                        <div class="form-group">
                            <label for="editvendor_name">Vendor Type</label>
                            <select d="editvendor_type" class="form-control" name="editvendor_type">
                            <?php
                                if($usersobject["type"] == 1){
                                	echo '<option value="1">Restaurant</option><option value="4">Mart</option>';
                                }else{
                                	echo '<option value="4">Mart</option><option value="1">Restaurant</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="editvendor_name">Vendor Name</label>
                            <input type="text" id="editvendor_name" class="form-control" name="editvendor_name" value="<?php
                                echo $usersobject["vendor_name"];
                                ?>">
                        </div>
                        <div class="form-group">
                            <label for="editvendor_open_time">Open time</label>
                            <input type="time" id="editvendor_open_time" class="form-control" name="editvendor_open_time" value="<?php
                                echo $usersobject["vendor_open_time"];
                                ?>">
                        </div>
                        <div class="form-group">
                            <label for="editvendor_close_time">Close time</label>
                            <input type="time" id="editvendor_close_time" class="form-control" name="editvendor_close_time" value="<?php
                                echo $usersobject["vendor_close_time"];
                                ?>">
                        </div>
                       
                        <div class="form-group">
                            <label for="editlat">Lat</label>
                            <input type="text" id="editlat" class="form-control" name="editlat" value="<?php
                                echo $usersobject["lat"];
                                ?>">
                        </div>
                        <div class="form-group">
                            <label for="editlng">Lng</label>
                            <input type="text" id="editlng" class="form-control" name="editlng" value="<?php
                                echo $usersobject["lng"];
                                ?>">
                        </div>                        
						<div class="form-group">
                            <label for="editlng">Address</label>
                            <input type="text" id="pickupaddress" class="form-control" name="pickupaddress" value="<?php
                                echo $usersobject["vendor_address"];
                                ?>">
                        </div>
                        <div class="form-group">
                            <label for="editbank_name">Bank Name</label>
                            <input type="text" id="editbank_name" class="form-control" name="editbank_name" value="<?php
                                echo $usersobject["bank_name"];
                                ?>">
                        </div>
                        <div class="form-group">
                            <label for="editbank_account_number">Bank Account Number</label>
                            <input type="text" id="editbank_account_number" class="form-control" name="editbank_account_number" value="<?php
                                echo $usersobject["bank_account_number"];
                                ?>">
                        </div>
                        <button class="btn btn-primary blue white-text" name="submitupdateusers" id="submitupdateusers" type="submit">UPDATE</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="container-fluid" id="menulist" style="display: none;">
            <div class="card">
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Product Picture</th>
                                <th>Product Name </th>
                                <th>Product Description</th>
                                <th>Category</th>
                                <th>Addon</th>
                                <th>Original Price</th>
                                <th><?php echo $projectname; ?> Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $productssql    = "SELECT * FROM products WHERE owner='$id'";
                                $productsresult = $db->query($productssql);
                                
                                if ($productsresult->num_rows > 0) {
                                    $ppid = 1;
                                    while ($productsobject = $productsresult->fetch_assoc()) {
                                		
                                        echo '<tr>
                                                <td>' .$ppid. '</td>
                                                <td> <img src="' . $productsobject["picture"] . '" class="img-fluid" width="50px"></td>
                                                <td>' . $productsobject["name"] . '</td>
                                                 <td>' . $productsobject["description"] . '</td> <td>' . $productsobject["category"] . '</td><td>';
												if($productsobject["addondata"] == "" || $productsobject["addondata"] == "[]"){
													echo 'No Addon'; 
												}else{
													$addondata = json_decode($productsobject["addondata"]);
													$length = count($addondata);
													for ($x = 0; $x <= $length; $x++) {
													if(isset($addondata[$x]->name)){
														 echo '<p style="font-size: 10px">Name:'.$addondata[$x]->name.'<br> Original Price: '.$addondata[$x]->original_price.' '.$projectname.' Price: '.$addondata[$x]->price.'</p>';
														
														}										 
													}
												}
                                				
                                															
                                				echo 	'</td>
                                							<td>' . $productsobject["originalprice"] . '</td>
                                                            <td>' . $productsobject["price"] . '</td>
                                                            <td> <a href="'.$domain.'/delete-product/'.$productsobject["id"].'/" class="btn btn-primary">DELETE</a> </td>
                                                        </tr>';
                                							$ppid++;
                                        
										}
                                    
                                } else {
                                    
                                }
                                ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Product Picture</th>
                                <th>Product Name </th>
                                <th>Product Description</th>
                                <th>Category</th>
                                <th>Addon</th>
                                <th>Original Price</th>
                                <th><?php echo $projectname; ?> Price</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="container-fluid" id="postmenu" style="display: none;">
            <form action="<?php echo $actual_link; ?>" method="post" enctype="multipart/form-data">
                <input class="form-control" type="number" id="uploadtoid" name="uploadtoid"  value="<?php echo $id ; ?>" hidden/>
                <div class="form-group">
                    <label>Select image to upload:</label>
                    <input type="file" name="menuToUpload" id="menuToUpload" class="form-control" /> 
                </div>
                <div class="form-group">
                    <label for="name">Product Name</label>
                    <input class="form-control" type="text" id="name" name="name" />
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <input class="form-control" type="text" id="description" name="description" />
                </div>
				<div class="form-group">
                    <label for="description">About</label>
                    <input class="form-control" type="text" id="about" name="about" />
                </div>
				<div class="form-group">
                    <label for="description">Precautions</label>
                    <input class="form-control" type="text" id="precaution" name="precaution" />
                </div>
				<div class="form-group">
                    <label for="description">Side Effects</label>
                    <input class="form-control" type="text" id="sideeffect" name="sideeffect" />
                </div>
				<div class="form-group">
                    <label for="description">Quick Tips</label>
                    <input class="form-control" type="text" id="tip" name="tip" />
                </div>				
				
				<div class="form-group">
                    <label for="description">Overview</label>
                    <input class="form-control" type="text" id="overview" name="overview" />
                </div>				
				<div class="form-group">
                    <label for="description">What If You Forget To Take</label>
                    <input class="form-control" type="text" id="forgot" name="forgot" />
                </div>				
				<div class="form-group">
                    <label for="description">FAQS</label>
                    <input class="form-control" type="text" id="faq" name="faq" />
                </div>
				<div class="form-group">
                    <label for="description">Require Prescription?</label>
					<select class="form-control" id="require_prescription" name="require_prescription">
						<option value="">Please select</option>
						<option value="true">True</option>
						<option value="false">False</option>
					</select>
                </div>
                <div class="form-group">
                    <label for="description">Category</label>        
                    <select id="selectcategory" name="selectcategory" class="form-control">
                    </select>
                </div>
                <script>
                    function initiateProductPoster(){
                    	var i;
                    	var ucat = '<?php echo $usersobject["categories"]; ?>';
                    	var postCat = JSON.parse(ucat);
                    	var select = document.getElementById('selectcategory');
                    	var option;
                    	console.log(postCat);
                    	for (i = 0; i < postCat.length; i++) {
                    		//document.getElementById("product_category").innerHTML += '<option value="'+postCat[i].name+'">'+postCat[i].name+'sasa</option>';
                    		option = document.createElement('option');
                    		option.setAttribute('value', postCat[i].name);
                    		option.appendChild(document.createTextNode(postCat[i].name));
                    		select.appendChild(option);
                    		console.log(option);
                    	}
                    }	   
                    initiateProductPoster();
                    	   
                </script>
                <div class="form-group">
                    <label for="price">Price</label>
                    <input class="form-control" type="text" id="originalprice" name="originalprice" onkeyup="updatePricechange(this)"/>
                </div>
                <div class="form-group">
                    <label for="price"><?php echo $projectname; ?> Price</label>
                    <input class="form-control" type="text" id="price" name="price" readonly />
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="addondata">Addon Name</label>
                            <input class="form-control" type="text" id="addonname" name="addonname" />
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="addondata">Addon Price</label>
                            <input class="form-control" type="number" step="0.1" id="addonprice" name="addonprice" />
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <label>Action</label><br>
                        <a href="#" onclick="addAddon()" class="btn btn-sm btn-primary">Add Addon</a>
                    </div>
                    <p>List of addon</p>
                    <div class="col-sm-12 row" id="displayaddon">
                    </div>
                </div>
                <input class="form-control" type="text" id="addondata" name="addondata" hidden/>
                <input class="form-control" type="text" id="delivery" name="delivery" value="Food" hidden />
                <input class="form-control" type="text" id="lat" name="lat"value="<?php echo $usersobject["lat"]; ?>" hidden> <input class="form-control" type="text" id="lng" name="lng" value="<?php echo $usersobject["lng"]; ?>" hidden>
                <div class="form-group">
                    <input class="form-control" type="text" id="stock" name="stock" value="9999999" hidden />
                </div>
                <div class="form-group">
                    <input class="form-control" type="text" id="available" name="available" value="On" hidden />
                </div>
                <input type="submit" value="Post Product" name="uploadmenu" class="btn btn-primary" />
            </form>
        </div>
		<div id="assigndoctor" class="container">
			<h3>Assign Doctor</h3>
			
			<div class="card">
				<div class="card-body" id="assignedDoctor">
					<div id="hasdoc" style="<?php if($usersobject["assigneddoctor"] != 0){ echo 'display: block'; }else{ echo 'display: none';} ?>">
					<?php 
					$ad = $usersobject["assigneddoctor"];
					$sqlad = "SELECT id, fullname FROM users WHERE id='$ad'";
						$resultad = $db->query($sqlad);

						if ($resultad->num_rows > 0) {
							$ad = $resultad->fetch_assoc();
						}
					?>
					<p>ID<span id="vdocid"><?php echo $ad["id"]; ?></span> - DR <span id="voname"><?php echo $ad["fullname"]; ?></span> <a href="#!" onclick="removeDoctor()">Remove</a></p>
					</div>
					<div id="nodoc" style="<?php if($usersobject["assigneddoctor"] == 0){ echo 'display: block'; }else{ echo 'display: none';} ?>">There is no virtual doctor assigned to this pharmacy</div>
				</div>
			</div>
			<div class="form-group">
				<label>Please enter the email of doctor you would like to assign to this pharmacy</label>
				<input type="email" id="emailtoassign" class="form-control">
			</div>
			<button name="updatedoctor" class="btn btn-primary" onclick="assignADoctor()">ASSIGN</button>
		</div>
		
        <?php
            $sqlpriceperkm = "SELECT * FROM settings WHERE setting_item='productmargin'";
            $priceperkmresult = $db->query($sqlpriceperkm);
            if ($priceperkmresult->num_rows > 0) {
            	$pricerow = $priceperkmresult->fetch_assoc();
            	$productmargin = $pricerow["setting_value"];
            }
            ?>
        <script>
            function openCategoryManager(){
            		document.getElementById("manageoperationhour").style.display = "none";
            		document.getElementById("categorymanager").style.display = "block";
            		document.getElementById("updateaccount").style.display = "none";
            		document.getElementById("menulist").style.display = "none";
            		document.getElementById("viewaccount").style.display = "none";
            		document.getElementById("postmenu").style.display = "none";
            		document.getElementById("deleteest").style.display = "none";
            		document.getElementById("orderhistory").style.display = "none";
					document.getElementById("assigndoctor").style.display = "none";
            }
            	function openUpdateAccount(){
            		document.getElementById("manageoperationhour").style.display = "none";
            		document.getElementById("updateaccount").style.display = "block";
            		document.getElementById("menulist").style.display = "none";
            		document.getElementById("viewaccount").style.display = "none";
            		document.getElementById("postmenu").style.display = "none";
            		document.getElementById("categorymanager").style.display = "none";
            		document.getElementById("deleteest").style.display = "none";
            		document.getElementById("orderhistory").style.display = "none";
					document.getElementById("assigndoctor").style.display = "none";
            		
            	}
            	function openMenuList(){
            		document.getElementById("manageoperationhour").style.display = "none";
            		document.getElementById("viewaccount").style.display = "none";
            		document.getElementById("updateaccount").style.display = "none";
            		document.getElementById("menulist").style.display = "block";
            		document.getElementById("postmenu").style.display = "none";
            		document.getElementById("deleteest").style.display = "none";
            		document.getElementById("categorymanager").style.display = "none";
            		document.getElementById("orderhistory").style.display = "none";
					document.getElementById("assigndoctor").style.display = "none";
            	}	
            	function openOrderhistory(){
            		document.getElementById("manageoperationhour").style.display = "none";
            		document.getElementById("viewaccount").style.display = "none";
            		document.getElementById("updateaccount").style.display = "none";
            		document.getElementById("menulist").style.display = "none";
            		document.getElementById("postmenu").style.display = "none";
            		document.getElementById("deleteest").style.display = "none";
            		document.getElementById("categorymanager").style.display = "none";
            		document.getElementById("orderhistory").style.display = "block";
					document.getElementById("assigndoctor").style.display = "none";
            	}
            	function openFullinfo(){
            		document.getElementById("manageoperationhour").style.display = "none";
            		document.getElementById("viewaccount").style.display = "block";
            		document.getElementById("updateaccount").style.display = "none";
            		document.getElementById("menulist").style.display = "none";
            		document.getElementById("postmenu").style.display = "none";
            		document.getElementById("deleteest").style.display = "none";
            		document.getElementById("categorymanager").style.display = "none";
            		document.getElementById("orderhistory").style.display = "none";
					document.getElementById("assigndoctor").style.display = "none";
            	}
            	function openOperation(){
            		
            		document.getElementById("viewaccount").style.display = "none";
            		document.getElementById("manageoperationhour").style.display = "block";
            		document.getElementById("updateaccount").style.display = "none";
            		document.getElementById("menulist").style.display = "none";
            		document.getElementById("postmenu").style.display = "none";
            		document.getElementById("deleteest").style.display = "none";
            		document.getElementById("categorymanager").style.display = "none";
            		document.getElementById("orderhistory").style.display = "none";
					document.getElementById("assigndoctor").style.display = "none";
            	}
            	function openProductPoster(){
            		document.getElementById("manageoperationhour").style.display = "none";
            		document.getElementById("postmenu").style.display = "block";
            		document.getElementById("viewaccount").style.display = "none";
            		document.getElementById("updateaccount").style.display = "none";
            		document.getElementById("menulist").style.display = "none";
            		document.getElementById("deleteest").style.display = "none";
            		document.getElementById("categorymanager").style.display = "none";
            		document.getElementById("orderhistory").style.display = "none";
					document.getElementById("assigndoctor").style.display = "none";
            	}
            	function openDeleteEst(){
					document.getElementById("assigndoctor").style.display = "none";
            		document.getElementById("manageoperationhour").style.display = "none";
            		document.getElementById("deleteest").style.display = "block";
            		document.getElementById("postmenu").style.display = "none";
            		document.getElementById("viewaccount").style.display = "none";
            		document.getElementById("updateaccount").style.display = "none";
            		document.getElementById("menulist").style.display = "none";
            		document.getElementById("categorymanager").style.display = "none";
            		document.getElementById("orderhistory").style.display = "none";
            	}
				function assignDoctor(){
            		document.getElementById("assigndoctor").style.display = "block";
            		document.getElementById("manageoperationhour").style.display = "none";
            		document.getElementById("deleteest").style.display = "none";
            		document.getElementById("postmenu").style.display = "none";
            		document.getElementById("viewaccount").style.display = "none";
            		document.getElementById("updateaccount").style.display = "none";
            		document.getElementById("menulist").style.display = "none";
            		document.getElementById("categorymanager").style.display = "none";
            		document.getElementById("orderhistory").style.display = "none";
            	}
            var addonadata = [];
            function addAddon(){
				var data = {
					name: "",
					original_price: "",
					price: "",
					checked: false
				};
				
					data.name = document.getElementById("addonname").value;
					data.price = parseFloat(document.getElementById("addonprice").value).toFixed(2);
					data.original_price = parseFloat(document.getElementById("addonprice").value).toFixed(2);
            
				if(data.name != "" && data.price != ""){
            	var vappymargin = <?php echo $productmargin; ?> * parseFloat(data.original_price) / 100;
            
            	data.price = parseFloat(data.original_price) + parseFloat(vappymargin);
            	
            	data.price = data.price.toFixed(2)
            	data.checked = false;
            	addonadata.push(data);
            	console.log(addonadata);
            	document.getElementById("addonname").value = "";
            	document.getElementById("addonprice").value = "";
            	document.getElementById("displayaddon").innerHTML = "";
            	console.log(data);
            	var i;
            	for (i = 0; i < addonadata.length; i++) {
            		document.getElementById("displayaddon").innerHTML += '<div class="col-sm-3">' + addonadata[i].name + '</div><div class="col-sm-3">RM' + addonadata[i].price + '</div><div class="col-sm-6"><a href="#" onclick="deleteaddon('+i+')" class="btn btn-primary btn-sm">Delete</div>';
            	}
            	document.getElementById("addondata").value = JSON.stringify(addonadata);
            	}else{
            		alert("Please fill the form");
            	}
            }
            function deleteaddon(id){
            	document.getElementById("displayaddon").innerHTML = "";
            	addonadata.splice(id, 1);
            	
            	var i;
            	for (i = 0; i < addonadata.length; i++) {
            		document.getElementById("displayaddon").innerHTML += '<div class="col-sm-3">' + addonadata[i].name + '</div><div class="col-sm-3">RM' + addonadata[i].price + '</div><div class="col-sm-6"><a href="#" onclick="deleteaddon('+i+')" class="btn btn-primary btn-sm">Delete</div>';
            	}
            	document.getElementById("addondata").value = JSON.stringify(addonadata);
            }
            function updatePricechange(element){
            	var initialPrice = parseFloat(element.value);
            	var initialPrice = initialPrice.toFixed(2);
            	var initialPrice = parseFloat(initialPrice);
            	var margin = <?php echo $productmargin; ?> * initialPrice / 100;
            	margin = parseFloat(margin);
            	var totalprice = initialPrice + margin;
            	if(isNaN(totalprice)== false){
            		 document.getElementById("price").value = totalprice.toFixed(2);
            	}
            }
        </script>
    </section>
</div>
<script>
    <?php echo $notfound; ?>
</script>