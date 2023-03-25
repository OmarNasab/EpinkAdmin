<?php
if(isset($_POST["update_parcel"])){
	$parcel_first_km = cleanInput($_POST["parcel_first_km"]);
	$parcel_first_km_price = cleanInput($_POST["parcel_first_km_price"]);
	$parcel_second_km = cleanInput($_POST["parcel_second_km"]);
	$parcel_second_km_price = cleanInput($_POST["parcel_second_km_price"]);
	$parcel_third_km = cleanInput($_POST["parcel_third_km"]);
	$parcel_third_km_price = cleanInput($_POST["parcel_third_km_price"]);
	$multi_stop_car = cleanInput($_POST["multi_stop_car"]);
	$sql1 = "UPDATE settings SET setting_value='$parcel_first_km' WHERE setting_item='parcel_first_km_car'";
	$sql2 = "UPDATE settings SET setting_value='$parcel_first_km_price' WHERE setting_item='parcel_first_km_price_car'";
	$sql3 = "UPDATE settings SET setting_value='$parcel_second_km' WHERE setting_item='parcel_second_km_car'";
	$sql4 = "UPDATE settings SET setting_value='$parcel_second_km_price' WHERE setting_item='parcel_second_km_price_car'";
	$sql6 = "UPDATE settings SET setting_value='$parcel_third_km_price' WHERE setting_item='parcel_third_km_price_car'";
	$sql7 = "UPDATE settings SET setting_value='$multi_stop_car' WHERE setting_item='multi_stop_car'";
	if ($db->query($sql1) === TRUE) {
		$db->query($sql2);
		$db->query($sql3);
		$db->query($sql4);
		$db->query($sql6);
	   $res = "Record updated successfully";
	} else {
	   $res =  "Error updating record: " . $db->error;
	}
}
$sqlpriceperkm = "SELECT * FROM settings WHERE setting_item='parcel_first_km_car'";
$priceperkmresult = $db->query($sqlpriceperkm);
if ($priceperkmresult->num_rows > 0) {
	$pricerow = $priceperkmresult->fetch_assoc();
	$parcel_first_km = $pricerow["setting_value"];
}
$sqlpriceperkm = "SELECT * FROM settings WHERE setting_item='parcel_first_km_price_car'";
$priceperkmresult = $db->query($sqlpriceperkm);
if ($priceperkmresult->num_rows > 0) {
	$pricerow = $priceperkmresult->fetch_assoc();
	$parcel_first_km_price = $pricerow["setting_value"];
}
$sqlpriceperkm = "SELECT * FROM settings WHERE setting_item='parcel_second_km_car'";
$priceperkmresult = $db->query($sqlpriceperkm);
if ($priceperkmresult->num_rows > 0) {
	$pricerow = $priceperkmresult->fetch_assoc();
	$parcel_second_km = $pricerow["setting_value"];
}
$sqlpriceperkm = "SELECT * FROM settings WHERE setting_item='parcel_second_km_price_car'";
$priceperkmresult = $db->query($sqlpriceperkm);
if ($priceperkmresult->num_rows > 0) {
	$pricerow = $priceperkmresult->fetch_assoc();
	$parcel_second_km_price = $pricerow["setting_value"];
}
$sqlpriceperkm = "SELECT * FROM settings WHERE setting_item='parcel_third_km_car'";
$priceperkmresult = $db->query($sqlpriceperkm);
if ($priceperkmresult->num_rows > 0) {
	$pricerow = $priceperkmresult->fetch_assoc();
	$parcel_third_km = $pricerow["setting_value"];
}
$sqlpriceperkm = "SELECT * FROM settings WHERE setting_item='parcel_third_km_price_car'";
$priceperkmresult = $db->query($sqlpriceperkm);
if ($priceperkmresult->num_rows > 0) {
	$pricerow = $priceperkmresult->fetch_assoc();
	$parcel_third_km_price = $pricerow["setting_value"];
}
$sqlpriceperkm = "SELECT * FROM settings WHERE setting_item='multi_stop_car'";
$priceperkmresult = $db->query($sqlpriceperkm);
if ($priceperkmresult->num_rows > 0) {
	$pricerow = $priceperkmresult->fetch_assoc();
	$multi_stop_car = $pricerow["setting_value"];
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Car Parcel Delivery Setting</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Setting for parcel delivery</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
			<form method="POST">
				<div class="form-group">
					<label for="">First KM</label>
					<input type="number" name="parcel_first_km" id="parcel_first_km" class="form-control" value="<?php echo $parcel_first_km; ?>">
				</div>
				<div class="form-group">
					<label for="">First KM Price (RM)</label>
					<input type="number" name="parcel_first_km_price" id="parcel_first_km_price" class="form-control" step=".01" value="<?php echo $parcel_first_km_price; ?>">
				</div>
				<div class="form-group">
					<label for="">Second KM</label>
					<input type="number" name="parcel_second_km" id="parcel_second_km" class="form-control" value="<?php echo $parcel_second_km; ?>">
				</div>
				<div class="form-group">
					<label for="">Second KM Price</label>
					<input type="number" name="parcel_second_km_price" id="parcel_second_km_price" class="form-control" step=".01" value="<?php echo $parcel_second_km_price; ?>">
				</div>
				<div class="form-group">
					<label for="">Third KM Price</label>
					<input type="number" name="parcel_third_km_price" id="parcel_third_km_price" class="form-control" step=".01" value="<?php echo $parcel_third_km_price; ?>">
				</div>
				<div class="form-group">
					<label for="">Car Multi Delivery Stop Charges</label>
					<input type="number" name="multi_stop_car" id="multi_stop_car" class="form-control" step=".01" value="<?php echo $multi_stop_car; ?>">
				</div>				
				<div class="form-group">
					
					<input type="submit" name="update_parcel" id="update_parcel" class="btn btn-primary">
				</div>					
			</form>
		</div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->