<?php
if(isset($_POST["update_service_car"])){
	$settingvalue = cleanInput($_POST["service_car"]);
	$sql = "UPDATE settings SET setting_value='$settingvalue' WHERE setting_item='service_car'";

	if ($db->query($sql) === TRUE) {
	  $res = "E hailing service has been updated";
	} else {
	   $res =  "Error updating record: " . $db->error;
	}
}

if(isset($_POST["update_service_parcel"])){
	$settingvalue = cleanInput($_POST["service_parcel"]);
	$sql = "UPDATE settings SET setting_value='$settingvalue' WHERE setting_item='service_parcel'";

	if ($db->query($sql) === TRUE) {
	  $res = "Parcel delivery service has been updated";
	} else {
	   $res =  "Error updating record: " . $db->error;
	}
}
if(isset($_POST["update_service_food"])){
	$settingvalue = cleanInput($_POST["service_food"]);
	$sql = "UPDATE settings SET setting_value='$settingvalue' WHERE setting_item='service_food'";
 
	if ($db->query($sql) === TRUE) {
	  $res = "Food delivery service has been updated";
	} else {
	   $res =  "Error updating record: " . $db->error;
	}
}
if(isset($_POST["updatepromodiscount"])){
	$settingvalue = cleanInput($_POST["delivery_discount"]);
	$sql = "UPDATE settings SET setting_value='$settingvalue' WHERE setting_item='delivery_discount'";

	if ($db->query($sql) === TRUE) {
$sqls = "SELECT * FROM products";
$result = $db->query($sqls);

if ($results->num_rows > 0) {
  // output data of each row
  while($row = $results->fetch_assoc()){
    $curproductoriginalprice = $row["originalprice"];
  }
} else {

}
	  $res = "Record updated successfully";
	} else {
	   $res =  "Error updating record: " . $db->error;
	}
}


if(isset($_POST["ridercutupdate"])){
	$settingvalue = cleanInput($_POST["ridercut"]);
	$sql = "UPDATE settings SET setting_value='$settingvalue' WHERE setting_item='parcel_delivery_cut'";

	if ($db->query($sql) === TRUE) {
	  $res = "Record updated successfully";
	} else {
	   $res =  "Error updating record: " . $db->error;
	}
}


if(isset($_POST["updatepriceperkm"])){
	$settingvalue = cleanInput($_POST["priceperkm"]);
	$sql = "UPDATE settings SET setting_value='$settingvalue' WHERE setting_item='delivery_discount'";

	if ($db->query($sql) === TRUE) {
	  $res = "Record updated successfully";
	} else {
	   $res =  "Error updating record: " . $db->error;
	}
}
if(isset($_POST["updatepriceperkm"])){
	$settingvalue = cleanInput($_POST["priceperkm"]);
	$sql = "UPDATE settings SET setting_value='$settingvalue' WHERE setting_item='delivery_discount'";

	if ($db->query($sql) === TRUE) {
	  $res = "Record updated successfully";
$sqlx = "SELECT * FROM products";
$resultx = $db->query($sqlx);

if ($resultx->num_rows > 0) {
	// output data of each row
	while($row = $result->fetch_assoc()){
	   
	}
}  
	  
	  
	} else {
	   $res =  "Error updating record: " . $db->error;
	}
}
if(isset($_POST["productmarginupdate"])){
	$settingvalue = cleanInput($_POST["productmargin"]);
	$sql = "UPDATE settings SET setting_value='$settingvalue' WHERE setting_item='productmargin'";

	if ($db->query($sql) === TRUE) {
			$res = "Record updated successfully";
			$sql = "SELECT * FROM products";
			$result = $db->query($sql); 
			$percentage = $settingvalue; 
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					
					$mainoriginalprice = $row["originalprice"]; 
					$mainprice = $percentage * $mainoriginalprice / 100;
					$mainnewprice = $mainoriginalprice + $mainprice;
					$mainnewprice = number_format($mainnewprice, 2); 
				
					
					
					//Addon processing
					if($row["addondata"] == '""'){
						$newaddonjson = "";
					}elseif($row["addondata"] == ""){ 
						$newaddonjson = "";
					}else{
						$addondata = json_decode($row["addondata"]);
						$addondatacount = count($addondata);
						for ($x = 0; $x <= $addondatacount; $x++){
							if($addondata[$x]->original_price != null){
							$curraddonoriprice = $addondata[$x]->original_price;
							$margin = $percentage * $curraddonoriprice / 100;
							$newaddonprice = $curraddonoriprice + $margin;
							$addondata[$x]->price = number_format($newaddonprice, 2);
							}
						}	
						$addondatacount = 0;
						$x = 0;
						echo '<br>';
						
						$newaddonjson = json_encode($addondata);
					}
					$productid = $row["id"];
					$sql = "UPDATE products SET price='$mainnewprice',  addondata='$newaddonjson' WHERE id='$productid'";

					if ($db->query($sql) === TRUE) {
					
					} else {
					  
					}
					

					
				}
			}	  
	  
	} else {
	   $res =  "Error updating record: " . $db->error;
	}
}

$target_dir = "../img/";


// Check if image file is a actual image or fake image
if(isset($_POST["updatepromoimage"])) {
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
	$filenameo = rand(1000,100000).'.'.$imageFileType;
	$newfilename = $target_dir.$filenameo;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
   $res =  "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $newfilename)) {
   
	$settingvalue = 'https://osocapto.my/img/'.$filenameo;
	$sql = "UPDATE settings SET setting_value='$settingvalue' WHERE setting_item='promotion_image'";

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
$sqldiscount = "SELECT * FROM settings WHERE setting_item='delivery_discount'";
$discountresult = $db->query($sqldiscount);
if ($discountresult->num_rows > 0) {
	$discountrow = $discountresult->fetch_assoc();
	$deliverydiscount = $discountrow["setting_value"];
}
$sqldimg = "SELECT * FROM settings WHERE setting_item='promotion_image'";
$imgresult = $db->query($sqldimg);
if ($imgresult->num_rows > 0) {
	$imgrow = $imgresult->fetch_assoc();
	$promoimg = $imgrow["setting_value"];
}


$sqlpriceperkm = "SELECT * FROM settings WHERE setting_item='parcel_delivery_cut'";
$priceperkmresult = $db->query($sqlpriceperkm);
if ($priceperkmresult->num_rows > 0) {
	$pricerow = $priceperkmresult->fetch_assoc();
	$ridercut = $pricerow["setting_value"];
}
$sqlpriceperkm = "SELECT * FROM settings WHERE setting_item='priceperkm'";
$priceperkmresult = $db->query($sqlpriceperkm);
if ($priceperkmresult->num_rows > 0) {
	$pricerow = $priceperkmresult->fetch_assoc();
	$priceperkm = $pricerow["setting_value"];
}
$sqlpriceperkm = "SELECT * FROM settings WHERE setting_item='productmargin'";
$priceperkmresult = $db->query($sqlpriceperkm);
if ($priceperkmresult->num_rows > 0) {
	$pricerow = $priceperkmresult->fetch_assoc();
	$productmargin = $pricerow["setting_value"];
}
$sqlpriceperkm = "SELECT * FROM settings WHERE setting_item='promodiscount'"; 
$priceperkmresult = $db->query($sqlpriceperkm);
if ($priceperkmresult->num_rows > 0) {
	$pricerow = $priceperkmresult->fetch_assoc();
	$promodiscount = $pricerow["setting_value"];
}
$sqlpriceperkm = "SELECT * FROM settings WHERE setting_item='service_car'"; 
$priceperkmresult = $db->query($sqlpriceperkm);
if ($priceperkmresult->num_rows > 0) {
	$pricerow = $priceperkmresult->fetch_assoc();
	$service_car = $pricerow["setting_value"];
}

$sqlpriceperkm = "SELECT * FROM settings WHERE setting_item='service_parcel'"; 
$priceperkmresult = $db->query($sqlpriceperkm);
if ($priceperkmresult->num_rows > 0) {
	$pricerow = $priceperkmresult->fetch_assoc();
	$service_parcel = $pricerow["setting_value"];
}
$sqlpriceperkm = "SELECT * FROM settings WHERE setting_item='service_food'"; 
$priceperkmresult = $db->query($sqlpriceperkm);
if ($priceperkmresult->num_rows > 0) {
	$pricerow = $priceperkmresult->fetch_assoc();
	$service_food = $pricerow["setting_value"];
}
$sqlpriceperkm = "SELECT * FROM settings WHERE setting_item='service_grocery'"; 
$priceperkmresult = $db->query($sqlpriceperkm);
if ($priceperkmresult->num_rows > 0) {
	$pricerow = $priceperkmresult->fetch_assoc();
	$service_grocery = $pricerow["setting_value"];
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>App Setting</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">App Setting</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
		<?php
		if(isset($res)){
		echo '<div class="card">
			<div class="card-body bg-success">
			'.$res.'
			</div>
		</div>
		';
		}
		?>
<form action="<?php echo $domain; ?>/app-setting/" method="POST">
	  <div class="form-group">
		<label for="priceperkm">Product Margin (%)</label>
		<input type="number" class="form-control" id="productmargin" name="productmargin" value="<?php echo $productmargin; ?>" step=".01">
	  </div>
	  
	 <button type="submit" class="btn btn-default" name="productmarginupdate">Update</button>
</form>
<br>
<form action="<?php echo $domain; ?>/app-setting/" method="POST">
	  <div class="form-group">
		<label for="ridercut">Rider Credit Cut (%)</label>
		<input type="number" class="form-control" id="ridercut" name="ridercut" value="<?php echo $ridercut; ?>" step=".01">
	  </div>
	  
	 <button type="submit" class="btn btn-default" name="ridercutupdate">Update</button>
</form>
<br/>			
<form action="<?php echo $domain; ?>/app-setting/" method="POST">
	  <div class="form-group">
		<label for="priceperkm">Price Per KM</label>
		<input type="number" class="form-control" id="priceperkm" name="priceperkm" value="<?php echo $priceperkm; ?>" step=".01">
	  </div>
	  
	 <button type="submit" class="btn btn-default" name="updatepriceperkm">Update</button>
</form>
<br/>

<form action="<?php echo $domain; ?>/app-setting/" method="POST">
	  <div class="form-group">
		<label for="delivery_discount">Delivery Discount(%)</label>
		<input type="text" class="form-control" id="delivery_discount" name="delivery_discount" value="<?php echo $promodiscount; ?>">
	  </div>
	  
	 <button type="submit" class="btn btn-default" name="updatepromodiscount">Update</button>
</form>
<form action="<?php echo $domain; ?>/app-setting/" method="POST">
	  <div class="form-group">
		<label for="service_car">Ehailing Service</label>
		<select class="form-control" name="service_car"> 
			<?php
			if($service_car == "On"){
				echo '
					<option value="On">On</option>
					<option value="Off">Off</option>
					<option value="" disabled>Select</option>
				
				';
			}elseif($service_car == "Off"){
				echo '
					<option value="Off">Off</option>
					<option value="On">On</option>
					<option value="" disabled>Select</option>
				
				';
			}else{
				echo '
					<option value="" disabled>Select</option>
					<option value="Off">On</option>
					<option value="On">Off</option>
					
				
				';
			}
			?>
		</select>
	  </div>
	  
	 <button type="submit" class="btn btn-default" name="update_service_car">Update</button>
</form>

<form action="<?php echo $domain; ?>/app-setting/" method="POST">
	  <div class="form-group">
		<label for="service_parcel">Parcel Service</label>
		<select class="form-control" name="service_parcel"> 
			<?php
			if($service_parcel == "On"){
				echo '
					<option value="On">On</option>
					<option value="Off">Off</option>
					<option value="" disabled>Select</option>
				
				';
			}elseif($service_parcel == "Off"){
				echo '
					<option value="Off">Off</option>
					<option value="On">On</option>
					<option value="" disabled>Select</option>
				
				';
			}else{
				echo '
					<option value="" disabled>Select</option>
					<option value="Off">On</option>
					<option value="On">Off</option>
					
				
				';
			}
			?>
		</select>
	  </div>
	  
	 <button type="submit" class="btn btn-default" name="update_service_parcel">Update</button>
</form>
<form action="<?php echo $domain; ?>/app-setting/" method="POST">
	  <div class="form-group">
		<label for="service_parcel">Food Service</label>
		<select class="form-control" name="service_food" id="service_food"> 
			<?php
			if($service_food == "On"){
				echo '
					<option value="On">On</option>
					<option value="Off">Off</option>
					<option value="" disabled>Select</option>
				
				';
			}elseif($service_food == "Off"){
				echo '
					<option value="Off">Off</option>
					<option value="On">On</option>
					<option value="" disabled>Select</option>
				
				';
			}else{
				echo '
					<option value="" select>Select</option>
					<option value="Off">On</option>
					<option value="On">Off</option>
					
				
				';
			}
			?>
		</select>
	  </div>
	  
	 <button type="submit" class="btn btn-default" name="update_service_food">Update</button>
</form>
<form action="<?php echo $domain; ?>/app-setting/" method="POST">
	  <div class="form-group">
		<label for="service_parcel">Grocery Service</label>
		<select class="form-control" name="service_grocery"> 
			<?php
			if($service_grocery == "On"){
				echo '
					<option value="On">On</option>
					<option value="Off">Off</option>
					<option value="" disabled>Select</option>
				
				';
			}elseif($service_grocery == "Off"){
				echo '
					<option value="Off">Off</option>
					<option value="On">On</option>
					<option value="" disabled>Select</option>
				
				';
			}else{
				echo '
					<option value="" disabled>Select</option>
					<option value="Off">On</option>
					<option value="On">Off</option>
					
				
				';
			}
			?>
		</select>
	  </div>
	  
	 <button type="submit" class="btn btn-default" name="update_service_food">Update</button>
</form>
<!--<form action="<?php echo $domain; ?>/app-setting/" method="POST" enctype="multipart/form-data">
<p for="promoimage" class="font-weight-bold">Promotion Image</p>
		<img src="<?php echo $promoimg; ?>" width="250px"><br><br>
		<div class="custom-file">
		  <input type="file" class="custom-file-input" id="fileToUpload" name="fileToUpload">
		  <label class="custom-file-label" for="customFile">Choose file</label>
		</div>
		<button type="submit" class="btn btn-default" name="updatepromoimage">Update</button>
</form><br>-->

		 </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->