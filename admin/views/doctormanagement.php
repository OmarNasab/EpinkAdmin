<?php
$target_dir = "../api/assets/";
$actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if(isset($_POST["refunduser"])){
	$id = cleanInput($page_identifier_action);
	$refundamount = cleanInput($_POST["refundamount"]);
	$sql = "UPDATE users SET wallet=wallet + $refundamount WHERE id='$id'";
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
if (isset($_POST["deleteestablishment"]))
{
    $estid = cleanInput($_POST["deleteid"]);
    $sql = "DELETE FROM users WHERE id='$estid'";
    if ($db->query($sql) === true)
    {
        $res = "Record deleted successfully";
        $notfound = 'location.href = "/admin/customers/";';
    }
    else
    {
        $res = "Error deleting record: " . $db->error;
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
                $picture = $appasseturl.$filenameo;
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

                $settingvalue = $appasseturl.$filenameo;
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
	$editwallet = cleanInput($_POST["editwallet"]);
	$phonenumber = cleanInput($_POST["editphonenumber"]);
    
    $sql = "UPDATE users SET email='$email', phonenumber='$phonenumber', wallet='$editwallet' WHERE  id='$id'";
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
                    <h1>Doctor Manager</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Doctor Account Manager</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <a href="#" onclick="openFullinfo()" class="btn btn-default">Information</a>
            <a href="#" onclick="openMenuList()"  class="btn btn-default">Top Up History</a>
            <a href="#" onclick="openProductPoster()" class="btn btn-default">Order History</a>
            <a href="#" onclick="openRefund()" class="btn btn-default">Refund</a>
            <a href="#" onclick="openUpdateAccount()"  class="btn btn-default">Update</a>
            <a href="#" onclick="openDeleteEst()"  class="btn btn-default">Delete</a>

            <?php
                if (isset($data)) {
                	echo '
                			<div id="response"><br>
                			
                	<div id="action_response" class="card ' . $data["card"] . ' darken-1" onclick="removeResponse()">
                
                		<div class="card-body">
                			<span class="card-title">
                			<p>' . $data["message"] . '</p>
                		</div>
                		
                	</div>
                	</div>
                
                	';
                }
                ?>
            <br><br>
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
                                        Phone Number
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
                        <input type="text" id="vendorid" name="vendorid" value="<?php
                            echo $usersobject["id"];
                            ?>" hidden>
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
                            <label for="editwallet">Wallet</label>
                            <input type="text" id="editwallet" class="form-control" name="editwallet" value="<?php
                                echo $usersobject["wallet"];
                                ?>">
                        </div>
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
                                $productssql    = "SELECT * FROM senangpay WHERE user_id='$id' AND type='wallet' AND order_status='successful'";
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
        <div class="container-fluid" id="postmenu" style="display: none;">
            <div class="card">
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
								<th>Payment Type</th>
								<th>Cart Data</th>
								<th>Cart Price</th>
								<th>Delivery Price</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $productssql    = "SELECT * FROM job_order WHERE owner='$id'";
                                $productsresult = $db->query($productssql);
                                if ($productsresult->num_rows > 0) {
                                    while ($productsobject = $productsresult->fetch_assoc()) {
										$orderdata = json_decode($productsobject["data"]);
										$cartdata = $orderdata->cartitem;
										$itemlength = count($cartdata);
                                        echo '<tr>
                                               <td>' . $productsobject["id"] . '</td>
                                               <td> ' . $productsobject["order_date"] . '</td>
                                               <td> ' . $productsobject["payment_type"] . '</td>
											   <td>';
											  
						
											   for ($x = 0; $x <= $itemlength; $x++) {
												    echo '<p><span class="font-weight-bold">'.$cartdata[$x]->product_name.'</span> <br>Original Price: RM'.$cartdata[$x]->originalprice.'<br>'.$projectname.' Price: RM'.$cartdata[$x]->product_price.'</p>';
													
												}

											echo '</td>
												<td>RM'.$productsobject["cart_price"].'</td>
												<td>RM'.$productsobject["delivery_price"].'</td>
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
								<th>Payment Type</th>
								<th>Cart Data</th>
								<th>Cart Price</th>
								<th>Delivery Price</th>
                                <th>Status</th>	
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
		<div class="container-fluid" id="refund" style="display: none;">
                   <form id="refundfotm" method="POST" action="<?php
                        echo $page_url;
                        ?>">
                        <input type="text" id="csrf" name="csrf" value="<?php
                            echo $csrftoken;
                            ?>" hidden>
                        <input type="text" id="refundto" name="editid" value="<?php echo $usersobject["id"]; ?>"  hidden>
                        <div class="form-group">
                            <label for="refundamount">Amount</label>
                            <input type="number" id="refundamount" class="form-control" step="0.1" name="refundamount">
                        </div>
                        <button class="btn btn-primary blue white-text" name="refunduser" id="refunduser" type="submit">Refund</button>
                    </form>
		</div>
    </section>
</div>
        <script>
		     function openRefund(){
            	document.getElementById("refund").style.display = "block";
            	document.getElementById("menulist").style.display = "none";
            	document.getElementById("viewaccount").style.display = "none";
            	document.getElementById("postmenu").style.display = "none";
				document.getElementById("deleteest").style.display = "none";
				document.getElementById("updateaccount").style.display = "none";
            	
            }
            function openUpdateAccount(){
            	document.getElementById("updateaccount").style.display = "block";
            	document.getElementById("menulist").style.display = "none";
            	document.getElementById("viewaccount").style.display = "none";
            	document.getElementById("postmenu").style.display = "none";
				document.getElementById("deleteest").style.display = "none";
				document.getElementById("refund").style.display = "none";
            	
            }
            function openMenuList(){
            	document.getElementById("viewaccount").style.display = "none";
            	document.getElementById("updateaccount").style.display = "none";
            	document.getElementById("menulist").style.display = "block";
            	document.getElementById("postmenu").style.display = "none";
            	document.getElementById("deleteest").style.display = "none";
				document.getElementById("refund").style.display = "none";
            }
            function openFullinfo(){
            	document.getElementById("viewaccount").style.display = "block";
            	document.getElementById("updateaccount").style.display = "none";
            	document.getElementById("menulist").style.display = "none";
            	document.getElementById("postmenu").style.display = "none";
            	document.getElementById("deleteest").style.display = "none";
				document.getElementById("refund").style.display = "none";
            }
            function openProductPoster(){
            	document.getElementById("postmenu").style.display = "block";
            	document.getElementById("viewaccount").style.display = "none";
            	document.getElementById("updateaccount").style.display = "none";
            	document.getElementById("menulist").style.display = "none";
            	document.getElementById("deleteest").style.display = "none";
				document.getElementById("refund").style.display = "none";
            }
            function openDeleteEst(){
            	document.getElementById("deleteest").style.display = "block";
            	document.getElementById("postmenu").style.display = "none";
            	document.getElementById("viewaccount").style.display = "none";
            	document.getElementById("updateaccount").style.display = "none";
            	document.getElementById("menulist").style.display = "none";
				document.getElementById("refund").style.display = "none";
            }
        </script>
<script>
    <?php echo $notfound; ?>
</script>