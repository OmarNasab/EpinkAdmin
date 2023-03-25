<?php
$target_dir = "../api/assets/";
$actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if (isset($_POST["requestaddcredit"]))
{
    $rid = cleanInput($_POST["addcreditto"]);
	$amounttoadd = cleanInput($_POST["addcreditamount"]);
    $sql = "UPDATE users SET rider_credit=rider_credit+'$amounttoadd' WHERE  id='$rid'";
    if ($db->query($sql) === true)
    {
		 $row["card"] = "green";
         $row["status"] = "Successful";
         $row["message"] = "Credit top up successful";
         $data = $row;
    }
    else
    {
        $res = "Failed to suspend user";
		 $row["card"] = "green";
         $row["status"] = "Successful";
         $row["message"] = $res;
         $data = $row;
    }
}
if (isset($_POST["requeston"]))
{
    $rid = cleanInput($_POST["onid"]);
    $sql = "UPDATE users SET availability='On' WHERE  id='$rid'";
    if ($db->query($sql) === true)
    {
		 $row["card"] = "green";
         $row["status"] = "Successful";
         $row["message"] = "User availability has been turned On";
         $data = $row;
    }
    else
    {
        $res = "Failed to suspend user";
		 $row["card"] = "green";
         $row["status"] = "Successful";
         $row["message"] = $res;
         $data = $row;
    }
}
if (isset($_POST["requestoff"]))
{
    $rid = cleanInput($_POST["offid"]);
    $sql = "UPDATE users SET availability='Off' WHERE  id='$rid'";
    if ($db->query($sql) === true)
    {
		 $row["card"] = "green";
         $row["status"] = "Successful";
         $row["message"] = "User availability has been turned Off";
         $data = $row;
    }
    else
    {
        $res = "Failed to suspend user";
		 $row["card"] = "green";
         $row["status"] = "Successful";
         $row["message"] = $res;
         $data = $row;
    }
}
if (isset($_POST["requestsuspend"]))
{
    $rid = cleanInput($_POST["suspendid"]);
    $sql = "UPDATE users SET availability='Completing Task' WHERE  id='$rid'";
    if ($db->query($sql) === true)
    {
		 $res = "User has been suspended";
		 		 $row["card"] = "green";
         $row["status"] = "Successful";
         $row["message"] = $res;
         $data = $row;
    }
    else
    {
        $res = "Failed to suspend user";
				 $row["card"] = "green";
         $row["status"] = "Successful";
         $row["message"] = $res;
         $data = $row;
    }
}
if (isset($_POST["requestunsuspend"]))
{
    $rid = cleanInput($_POST["unsuspendid"]);
    $sql = "UPDATE users SET availability='Off' WHERE  id='$rid'";
    if ($db->query($sql) === true)
    {
		 $res = "User has been unsuspended";
		 		 $row["card"] = "green";
         $row["status"] = "Successful";
         $row["message"] = $res;
         $data = $row;
    }
    else
    {
        $res = "Failed to suspend user";
				 $row["card"] = "green";
         $row["status"] = "Successful";
         $row["message"] = $res;
         $data = $row;
    }
}
if (isset($_POST["deleteestablishment"]))
{
    $estid = cleanInput($_POST["deleteid"]);
    $sql = "DELETE FROM users WHERE id='$estid'";
    if ($db->query($sql) === true)
    {
        $res = "Record deleted successfully";
        $notfound = 'location.href = "/admin/rider/";';
				 $row["card"] = "green";
         $row["status"] = "Successful";
         $row["message"] = $res;
         $data = $row;
    }
    else
    {
        $res = "Error deleting record: " . $db->error;
				 $row["card"] = "green";
         $row["status"] = "Successful";
         $row["message"] = $res;
         $data = $row;
    }
}
if (isset($_POST["uploadmenu"]))
{
    if (isset($_FILES["menuToUpload"]))
    {
        $target_file = $target_dir . basename($_FILES["menuToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["menuToUpload"]["tmp_name"]);
        if ($check !== false)
        {
            $res = "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        }
        else
        {
            $res = "File is not an image.";
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($target_file))
        {
            $res = "Sorry, file already exists.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["menuToUpload"]["size"] > 500000)
        {
            $res = "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif")
        {
            $res = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";

            $uploadOk = 0;

        }
        else
        {
            $filenameo = md5(rand(1000000, 1000000000) . uniqid() . rand(1999, 5999)) . '.' . $imageFileType;
            $newfilename = $target_dir . $filenameo;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0)
        {
            $res = "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
            
        }
        else
        {
            if (move_uploaded_file($_FILES["menuToUpload"]["tmp_name"], $newfilename))
            {
                $res = "The file " . $filenameo . " has been uploaded.";
                $owner = cleanInput($_POST["uploadtoid"]);
                $name = cleanInput($_POST["name"]);
                $description = cleanInput($_POST["description"]);
                $addondata = cleanInput($_POST["addondata"]);
                $originalprice = cleanInput($_POST["originalprice"]);
                $price = cleanInput($_POST["price"]);
                $delivery = cleanInput($_POST["delivery"]);
                $picture = 'https://vappy.my/api/assets/' . $filenameo;
                $lat = cleanInput($_POST["lat"]);
                $lng = cleanInput($_POST["lng"]);
                $stock = cleanInput($_POST["stock"]);
                $available = cleanInput($_POST["available"]);
                if ($owner != "")
                {

                    $productssql = "INSERT INTO products (owner, name, description, addondata, originalprice, price, delivery, picture, lat, lng, stock, available)
    			VALUES ('$owner', '$name', '$description', '$addondata', '$originalprice', '$price', '$delivery', '$picture', '$lat', '$lng', '$stock', '$available')";

                    if ($db->query($productssql) === true)
                    {
                        $row["card"] = "green";
                        $row["status"] = "Successful";
                        $row["message"] = "New record successfully created";
                        $data = $row;
                    }
                    else
                    {
                        $row["card"] = "red";
                        $row["status"] = "Fail";
                        $row["message"] = "Error: " . $sql . "<br>" . $db->error;
                        $res = "Error: " . $sql . "<br>" . $db->error;
                        $data = $row;
                    }
                }
                else
                {
                    $row["card"] = "red";
                    $row["status"] = "Fail";
                    $row["message"] = "Please fill all the form";
                    $data = $row;
                    $res = "Please fill all the form";
                }

            }
            else
            {
                $res = "Sorry, there was an error uploading your file.";
            }
        }
    }
    else
    {
        $res = 'Please select an image';
        echo $_FILES["menuToUpload"];
    }
    $row["card"] = "green";
    $row["status"] = "Successfull";
    $row["message"] = $res;
    $data = $row;
}

if (isset($_POST["updatevendorlogo"]))
{
    $vid = $_POST["vendorid"];
    if (isset($_FILES["fileToUpload"]))
    {
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false)
        {
            $uploadOk = 1;
        }
        else
        {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($target_file))
        {
            $res = "Sorry, file already exists.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 500000)
        {
            $res = "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif")
        {
            $res = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";

            $uploadOk = 0;

        }
        else
        {
            $filenameo = md5(uniqid() . rand(1000, 10000000)) . '.' . $imageFileType;
            $newfilename = $target_dir . $filenameo;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0)
        {
            $res = "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
            
        }
        else
        {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $newfilename))
            {

                $settingvalue = 'https://vappy.my/api/assets/' . $filenameo;
                $sql = "UPDATE users SET profile_img='$settingvalue' WHERE id='$vid'";

                if ($db->query($sql) === true)
                {
                    $res = "Record updated successfully";
                }
                else
                {
                    $res = "Error updating record: " . $db->error;
                }
            }
            else
            {
                $res = "Sorry, there was an error uploading your file.";
            }
        }
    }
    else
    {
        echo 'Please select an image';
        echo $_FILES["fileToUpload"];
    }
}
if (isset($_POST["submitupdateusers"]) && $_POST["csrf"] == $_SESSION["csrftoken"])
{

    $id = cleanInput($_POST["editid"]);
    $email = cleanInput($_POST["editemail"]);
    $password = cleanInput($_POST["editpassword"]);
    $type = cleanInput($_POST["editvendor_type"]);
    $vendor_name = cleanInput($_POST["editvendor_name"]);
    $vendor_open_time = cleanInput($_POST["editvendor_open_time"]);
    $vendor_close_time = cleanInput($_POST["editvendor_close_time"]);
    $vendor_type = cleanInput($_POST["editvendor_type"]);
    $vendor_halal = cleanInput($_POST["editvendor_halal"]);
    $lat = cleanInput($_POST["editlat"]);
    $lng = cleanInput($_POST["editlng"]);
    $bank_name = cleanInput($_POST["editbank_name"]);
    $bank_account_number = cleanInput($_POST["editbank_account_number"]);

    $sql = "UPDATE users SET email='$email', phonenumber='$phonenumber', type='$type', vendor_name='$vendor_name', vendor_address='$vendor_address', vendor_open_time='$vendor_open_time', vendor_close_time='$vendor_close_time', vendor_type='$vendor_type', vendor_halal='$vendor_halal', lat='$lat', lng='$lng', bank_name='$bank_name', bank_account_number='$bank_account_number' WHERE  id='$id'";
    if ($db->query($sql) === true)
    {
        $row["card"] = "green";
        $row["status"] = "Successfull";
        $row["message"] = "The record has been updated successfully";
        $data = $row;
    }
    else
    {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "Error updating record: " . $db->error;
        $data = $row;
    }
}

$id = cleanInput($page_identifier_action);
$userssql = "SELECT * FROM users WHERE id='$id'";
$usersresult = $db->query($userssql);
if ($usersresult->num_rows > 0)
{
    $row = $usersresult->fetch_assoc();
    $usersobject = $row;
}
else
{

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
                    <h1>Rider Manager</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Rider Manager</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <a href="#" onclick="openFullinfo()" class="btn btn-default">Information</a>
			<a href="#" onclick="openJobHistory()"  class="btn btn-default">Job History</a>
            <a href="#" onclick="openUpdateAccount()"  class="btn btn-default">Update Account</a>
            <a href="#" onclick="openProductPoster()" class="btn btn-default">Suspend Rider</a>
			<a href="#" onclick="openonOff()" class="btn btn-default">On/Off</a>         
            
			<a href="#" onclick="openDeleteEst()"  class="btn btn-default">Delete</a>
            <?php
                if (isset($data)) {
                	echo '	<br><br>
                			<div id="response">
                			
                	<div id="action_response" class="card ' . $data["card"] . ' darken-1" onclick="removeResponse()">
                
                		<div class="card-body white-text">
                			<span class="card-title">' . $data["status"] . '
                			<p>' . $data["message"] . '</p>
                		</div>
                		
                	</div>
                	<br><br><br>
                	</div>
                
                	';
                }
                ?>
            <br><br>
        </div>
		<div id="jobhistory" style="display: none;">
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
										<th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
										$runnerid = $usersobject["id"];
                                        $sql = "SELECT * FROM job_order WHERE order_status= 'Completed' AND runner='$runnerid' ORDER by id DESC";
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
												<td>Not Applicable</td>
												<td>Not Applicable</td>
												<td><a href="'.$domain.'/customers/'.$rows["id"].'/">'. $rows["firstname"].' '. $rows["lastname"].'</a></td>
												<td><a href="'.$domain.'/establishment-manager/'.$rowsr["id"].'/">'. $rowsr["vendor_name"].'</a></td>
												
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
													<td> Parcel Delivery</td>
													<td>Date: '.$row["pickup_date"].' 
													<img src="'.$row["pickup_image"].'" class="img-fluid">
													</td>
													<td>Date: '.$row["pickup_date"].'<img src="'.$row["drop_image"].'" class="img-fluid"></td>
													<td><a href="'.$domain.'/customers/'.$rows["id"].'/">'. $rows["firstname"].' '. $rows["lastname"].'</a></td>
													<td> Not Applicable </td>
													
													<td>'.$row["order_status"].'</td>
												  </tr>';
												}
											  

                                          }
                                        } 
                                        		
                                        ?>	  
                                </tbody>
   
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
		</div>
        <div id="viewaccount" class="container">
            <div class="row">
                <div class="col-sm-4">
                    <div class="card" style="width: 100%;">
                        <?php
                            if($usersobject["profile_img"] == 'img/default_profile_picture.jpg'){
                            	$usersobject["profile_img"] = 'https://thumbs.dreamstime.com/b/default-avatar-profile-vector-user-profile-default-avatar-profile-vector-user-profile-profile-179376714.jpg';
                            }
                            ?>
                        <img class="card-img-top" src="<?php echo $usersobject["profile_img"]; ?>" alt="Card image cap">
                        <div class="card-body">
                            <table class="table-responsive" >
                                <thead>
                                    <tr>
                                        <th>User Basic Info</th>
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
                                            Credit
                                        </td>
                                        <td> 
                                            RM <?php echo $usersobject["rider_credit"]; ?>
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

        <div class="container-fluid" id="deleteest"  style="display: none;">
            <h3>Delete this user</h3>
            <p>Are you sure about deleting this user? You cant undo this process.</p>
            <form method="POST" action="<?php echo $actual_link; ?>">
                <input type="text" name="deleteid" value="<?php echo $id; ?>" hidden>
                <button type="submit" name="deleteestablishment" class="btn btn-default">Proceed</button>
            </form>
        </div>
        <div class="container-fluid" id="updateaccount"  style="display: none;">
            <div class="card">
                <div class="card-body">
                    <p  class="font-weight-bold">User Profile</p>
                    <form action="<?php echo $actual_link; ?>" method="POST" enctype="multipart/form-data">
                        <input type="text" id="vendorid" name="vendorid" value="<?php echo $usersobject["id"]; ?>" hidden>
                        <img src="<?php echo $usersobject["profile_img"]; ?>" width="250px"><br><br>
                        <div class="custom-file form-group">
                            <input type="file" class="custom-file-input form-control" id="fileToUpload" name="fileToUpload">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                        </br></br>
                        <button type="submit" class="btn btn-default" name="updatevendorlogo">Update Profile Picture</button>
                    </form>
                    <br>
                    <p class="font-weight-bold">User Infromation</p>
                    <form id="editusers" method="POST" enctype="multipart/form-data" action="<?php
                        echo $page_url;
                        ?>">
                        <input type="text" id="csrf" name="csrf" value="<?php
                            echo $csrftoken;
                            ?>" hidden>
                        <input type="text" id="editid" name="editid" value="<?php
                            echo $usersobject["id"];
                            ?>" hidden>
                        <div class="form-group">
                            <label for="editemail">Email</label>
                            <input type="text" id="editemail" class="form-control" name="editemail" value="<?php echo $usersobject["email"]; ?>">
                        </div>
                        <div class="form-group">
                            <label for="editemail">Phone Number</label>
                            <input type="text" id="editphonenumber" class="form-control" name="editphonenumber" value="<?php
                                echo $usersobject["phonenumber"];
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
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $productssql    = "SELECT * FROM senangpay WHERE user_id='$id' AND type='credit' AND order_status != 'waiting'";
                                $productsresult = $db->query($productssql);
                                if ($productsresult->num_rows > 0) {
                                    while ($productsobject = $productsresult->fetch_assoc()) {
                                        echo '<tr>
                                                                                            <td>' . $productsobject["id"] . '</td>
                                                                                             <td> ' . $productsobject["senang_date"] . '</td>
                                                                                            <td>' . $productsobject["amount"] . '</td>
                                                                                            <td>' . $productsobject["order_status"] . '</td>
                                                                                          
                                                                                            
                                                                                          </tr>';
                                        
                                    }
                                    
                                } else {
                                  
                                }
                                ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="container-fluid" id="addcredit" style="display: none;">
            <h3>Add credit</h3>
       
            <form method="POST" action="<?php echo $actual_link; ?>">
                <input type="text" name="addcreditto" id="addcreditto" value="<?php echo $usersobject["id"]; ?>" hidden>
				<input type="text" name="addcreditamount" id="addcreditamount" value="">
                <button type="submit" name="requestaddcredit" id="requestaddcredit" class="btn btn-default">Add</button>
            </form>
        </div>
        <div class="container-fluid" id="postmenu" style="display: none;">
            <h3>Suspend Rider</h3>
       
            <form method="POST" action="<?php echo $actual_link; ?>">
                <input type="text" name="suspendid" id="suspendid" value="<?php echo $usersobject["id"]; ?>" hidden>
                <button type="submit" name="requestsuspend" id="requestsuspend" class="btn btn-default">Suspend</button>
            </form>
			
			 <h3>Unsuspend Rider</h3>
            
			 <form method="POST" action="<?php echo $actual_link; ?>">
                <input type="text" name="unsuspendid" id="unsuspendid" value="<?php echo $usersobject["id"]; ?>" hidden>
                <button type="submit" name="requestunsuspend" id="requestunsuspend" class="btn btn-default">Unsuspend</button>
            </form>
        </div>
		 <div class="container-fluid" id="offrider" style="display: none;">
            <h3>Off Rider</h3>
            
            <form method="POST" action="<?php echo $actual_link; ?>">
                <input type="text" name="offid" value="<?php echo $usersobject["id"]; ?>" hidden>
                <button type="submit" name="requestoff" class="btn btn-default">Off</button>
            </form>
			<h3>On Rider</h3>
            
            <form method="POST" action="<?php echo $actual_link; ?>">
                <input type="text" name="onid" value="<?php echo $usersobject["id"]; ?>" hidden>
                <button type="submit" name="requeston" class="btn btn-default">On</button>
            </form>
        </div>
    </section>
</div>
        <script>
		function openAddCredit(){
				document.getElementById("addcredit").style.display = "block";
				document.getElementById("jobhistory").style.display = "none";
				document.getElementById("offrider").style.display = "none";
				document.getElementById("updateaccount").style.display = "none";
            	document.getElementById("menulist").style.display = "none";
            	document.getElementById("viewaccount").style.display = "none";
            	document.getElementById("postmenu").style.display = "none";
				document.getElementById("deleteest").style.display = "none";
		}		
		function openJobHistory(){
				document.getElementById("jobhistory").style.display = "block";
				document.getElementById("addcredit").style.display = "none";
				document.getElementById("offrider").style.display = "none";
				document.getElementById("updateaccount").style.display = "none";
            	document.getElementById("menulist").style.display = "none";
            	document.getElementById("viewaccount").style.display = "none";
            	document.getElementById("postmenu").style.display = "none";
				document.getElementById("deleteest").style.display = "none";
		}
		    function openonOff(){
            	document.getElementById("offrider").style.display = "block";
				document.getElementById("jobhistory").style.display = "none";
				document.getElementById("updateaccount").style.display = "none";
            	document.getElementById("menulist").style.display = "none";
            	document.getElementById("viewaccount").style.display = "none";
            	document.getElementById("postmenu").style.display = "none";
				document.getElementById("deleteest").style.display = "none";
				document.getElementById("addcredit").style.display = "none";
            	
            }
            function openUpdateAccount(){
					document.getElementById("offrider").style.display = "none";
					document.getElementById("jobhistory").style.display = "none";
            	document.getElementById("updateaccount").style.display = "block";
            	document.getElementById("menulist").style.display = "none";
            	document.getElementById("viewaccount").style.display = "none";
            	document.getElementById("postmenu").style.display = "none";
				document.getElementById("deleteest").style.display = "none";
				document.getElementById("addcredit").style.display = "none";
            	
            }
            function openMenuList(){
				document.getElementById("offrider").style.display = "none";
				document.getElementById("jobhistory").style.display = "none";
            	document.getElementById("viewaccount").style.display = "none";
            	document.getElementById("updateaccount").style.display = "none";
            	document.getElementById("menulist").style.display = "block";
            	document.getElementById("postmenu").style.display = "none";
            	document.getElementById("deleteest").style.display = "none";
				document.getElementById("addcredit").style.display = "none";
            }
            function openFullinfo(){
				document.getElementById("offrider").style.display = "none";
				document.getElementById("jobhistory").style.display = "none";
            	document.getElementById("viewaccount").style.display = "block";
            	document.getElementById("updateaccount").style.display = "none";
            	document.getElementById("menulist").style.display = "none";
            	document.getElementById("postmenu").style.display = "none";
            	document.getElementById("deleteest").style.display = "none";
				document.getElementById("addcredit").style.display = "none";
            }
            function openProductPoster(){
				document.getElementById("offrider").style.display = "none";
				document.getElementById("jobhistory").style.display = "none";
            	document.getElementById("postmenu").style.display = "block";
            	document.getElementById("viewaccount").style.display = "none";
            	document.getElementById("updateaccount").style.display = "none";
            	document.getElementById("menulist").style.display = "none";
            	document.getElementById("deleteest").style.display = "none";
				document.getElementById("addcredit").style.display = "none";
            }
            function openDeleteEst(){
				document.getElementById("offrider").style.display = "none";
				document.getElementById("jobhistory").style.display = "none";
            	document.getElementById("deleteest").style.display = "block";
            	document.getElementById("postmenu").style.display = "none";
            	document.getElementById("viewaccount").style.display = "none";
            	document.getElementById("updateaccount").style.display = "none";
            	document.getElementById("menulist").style.display = "none";
				document.getElementById("addcredit").style.display = "none";
            }
        </script>
<script>
    <?php echo $notfound; ?>
</script>