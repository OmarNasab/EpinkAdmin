<?php
//Include configuration file
include("config.php");
// Initial delivery price per km
$priceperkm = 1.00;
//Initiate current date time
$currentdatetime = date("Y-m-d H:i:s");
//initiate current time
$currenttime = date("H:i:s");

//Set force app update to false
$update = false;

//Initiating functions
// function to convert mysql datetime data to human readable
function humanreadabledatetime($timestamp){
	$v = strtotime($timestamp);
	return date("D, d M Y, g:i a",$v);
}
//Function to get health care rate
function getHcRate($uid){
	global $db;
	$sql = "SELECT * FROM users WHERE id='$uid'";
	$result = $db->query($sql);
	if ($result->num_rows > 0){
		$row = $result->fetch_assoc();
		$providertype = $row["provider_type"];
		$ratechecker = $providertype.'_rate';
		$settingssql = "SELECT * FROM settings WHERE setting_item='$ratechecker'";
		$settingsresult = $db->query($settingssql);
		if ($settingsresult->num_rows > 0){
			$rowx = $settingsresult->fetch_assoc();
			$rate =  $rowx["setting_value"];
		}
		if($row["specialist"] != "" || $row["specialist"] != null){
			$specialityrate = json_decode($row["specialist"]);
			$sc = count($specialityrate);
			$scprice = 0;
			for ($x = 0; $x < $sc; $x++) {
				$scname = $specialityrate[$x]->specialties;
				
				$settingssqlx = "SELECT * FROM settings WHERE setting_item='$scname'";
				$settingsresultx = $db->query($settingssqlx);
				if ($settingsresultx->num_rows > 0){
					$rowxx = $settingsresultx->fetch_assoc();
					$pp = $rowxx["setting_value"];
					$scprice = $scprice + $pp;
				}
			}
			return $rate + $scprice;
		}else{
			return $rate;
		}
		
	} else {
		return 10;
	}
}

//Get inhouse rate for user
function getInhouseRate(){
	global $db;
	$settingssql = "SELECT * FROM settings WHERE setting_item='inhouserate'";
	$settingsresult = $db->query($settingssql);
	if ($settingsresult->num_rows > 0){
		$row = $settingsresult->fetch_assoc();
		return $row["setting_value"];
	}
}

//Get health care service provider rate
function getRate($type, $uid){
	global $db;
	$utype = $type.'_rate';
	$sql = "SELECT * FROM settings WHERE setting_item='$utype'";
	$result = $db->query($sql);

	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		return $row["setting_value"];
	} else {
		return '20.00';
	}
}

//Send mail with headers
function instaMail($subject, $message, $email){
	$to = $email;
	$headers="MIME-Version: 1.0" . "\r\n";
	$headers .="Content-type:text/html;charset=UTF-8" . "\r\n";
	$headers .='From: EPINK <admin@epink.health>' . "\r\n";
	$headers .="Reply-To: EPINK <admin@epink.health>\r\n";
	$headers .="Return-Path: EPINK <admin@epink.health>\r\n";
	$headers .="Content-type: text/html; charset=utf-8\r\n";
	$headers .="X-Priority: 3\r\n";
	$headers .="X-Mailer: PHP". phpversion() ."\r\n";
	mail($to, $subject, $message, $headers);
}
//function to get distance between 2 cordinate
function getDistance($lat1, $lon1, $lat2, $lon2, $unit) {
	$lat1 = (float)$lat1;
	$lat2 = (float)$lat2;
	$lon1 = (float)$lon1;
	$lon2 = (float)$lon2;
  if (($lat1 == $lat2) && ($lon1 == $lon2)) {
    return 0;
  }else{
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);

    if ($unit == "K") {
      return ($miles * 1.609344);
    } else if ($unit == "N") {
      return ($miles * 0.8684);
    } else {
      return $miles;
    }
  }
}
//Function to create random string
function random_strings($length_of_string) { 
    $str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz'; 
    return substr(str_shuffle($str_result), 0, $length_of_string); 
} 

//Get delivery discount from db
$sqldiscount = "SELECT * FROM settings WHERE setting_item='delivery_discount'";
$discountresult = $db->query($sqldiscount);
if ($discountresult->num_rows > 0) {
	$discountrow = $discountresult->fetch_assoc();
	$deliverydiscount = $discountrow["setting_value"];
}
//Get promotion image from db
$sqldimg = "SELECT * FROM settings WHERE setting_item='promotion_image'";
$imgresult = $db->query($sqldimg);
if ($imgresult->num_rows > 0) {
	$imgrow = $imgresult->fetch_assoc();
	$promoimg = $imgrow["setting_value"];
}


if(isset($_GET["sc"])){
	$uid = $_GET["sc"];
	$sql = "SELECT * FROM users WHERE id='$uid'";
	$result = $db->query($sql);
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		$providertype = $row["provider_type"];
		$ratechecker = $providertype.'_rate';
		$settingssql = "SELECT * FROM settings WHERE setting_item='$ratechecker'";
		$settingsresult = $db->query($settingssql);
		if ($settingsresult->num_rows > 0){
			$rowx = $settingsresult->fetch_assoc();
			$rate =  $rowx["setting_value"];
		}
		$specialityrate = json_decode($row["specialist"]);
		$sc = count($specialityrate);
		$scprice = 0;
		for ($x = 0; $x < $sc; $x++) {
			$scname = $specialityrate[$x]->specialties;
			
			$settingssqlx = "SELECT * FROM settings WHERE setting_item='$scname'";
			$settingsresultx = $db->query($settingssqlx);
			if ($settingsresultx->num_rows > 0){
				$rowxx = $settingsresultx->fetch_assoc();
				$pp = $rowxx["setting_value"];
				$scprice = $scprice + $pp;
			}
		}
		return $rate + $scprice;
	} else {
		return 10;
	}
}

if(isset($_GET["near"])){
	$cart_price = 10.00;
	$first_restaurant_lat = '6.0459';
	$first_restaurant_lng = '116.149';
	$sqlrun = "SELECT *, ( 6371 * acos( cos( radians('$first_restaurant_lat') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('$first_restaurant_lng') ) + sin( radians('$first_restaurant_lat') ) * sin( radians( lat ) ) ) ) AS distance FROM users WHERE type ='2' AND availability='On' AND rider_credit > 10 GROUP BY distance HAVING distance < 2000 ORDER BY distance ASC LIMIT 10";
	/* $sqlrun = "SELECT * FROM users WHERE type='2'"; */
	$runresult = $db->query($sqlrun);
	if ($runresult->num_rows > 0){
		while($row = $runresult->fetch_assoc()){
				$data[] = $row;
		}
		echo json_encode($data, JSON_PRETTY_PRINT);
	}else{
		echo 'Fail to get rider';
	}
}
if(isset($_GET["fblogin"])){
	$email = cleanInput($_GET["email"]);
	$firstname = cleanInput($_GET["firstname"]);
	$lastname = cleanInput($_GET["lastname"]);
	$profile_img = cleanInput($_GET["profilepicture"]);
	$sql = "SELECT * FROM users WHERE email='$email'";
	$result = $db->query($sql);
	if ($result->num_rows > 0){
		$row = $result->fetch_assoc();
		$token = rand(1000,100000).uniqid().rand(100000,100000);
		$row["login_token"] = $token;
		$row["password"] = "*********";
		$row["status"] = "success";
		$row["message"] = "You have successfully logged in";
		$data = $row;
		$sql = "UPDATE users SET login_token='$token' WHERE email='$email'";
		if ($db->query($sql) === TRUE) {
			echo json_encode($data, JSON_PRETTY_PRINT);
		} else {
			$response = "Error updating record: " . $db->error;
			echo '{"status":"fail", "message":"'.$response.'"}';
		}
	}else{
		//Register here
		$login_token = rand(1000,100000).uniqid().rand(100000,100000);
		$sql = "INSERT INTO users (firstname, lastname, email, password, login_token, profile_img, type, availability)
		VALUES ('$firstname', '$lastname', '$email', '$password', '$login_token', '$profile_img', '0', 'Off')";
		if ($db->query($sql) === TRUE) {
				echo '{"status":"success", "message":"Registeration successull", "login_token":"'.$login_token.'"}';
		} else {
				echo "Error: " . $sql . "<br>" . $db->error;
		}
	}
}

if(isset($_GET["off"])){
	$sql = "UPDATE products SET addondata=null, available='On'";

	if ($db->query($sql) === TRUE) {
	  echo "Record updated successfully";
	} else {
	  echo "Error updating record: " . $db->error;
	}
}

if(isset($_GET["lol"])){
	$user_latitude = '6.0890';
	$user_longitude = '116.1949';
	$sqlrun = "SELECT * FROM users WHERE type='2' and availability='On' ORDER BY ((lat-$user_latitude)*(lat-$user_latitude)) +((lng - $user_longitude)*(lng - $user_longitude)) ASC LIMIT 1";
	$runresult = $db->query($sqlrun);
	if ($runresult->num_rows > 0){
		while($runner = $runresult->fetch_assoc()) {
			$selectedRunnerid = $runner["id"];
			$sqlupdaterunner = "UPDATE users SET availability='Completing Task' WHERE id='$selectedRunnerid'";
			$db->query($sqlupdaterunner);
			$runnerlat = $runner["lat"];
			$runnerlng = $runner["lng"];
			$distance = getDistance($user_latitude, $user_longitude, $runnerlat, $runnerlng, "K");
			echo $distance;
		}		
	} else {
		$row["card"] = "red";
		$row["status"] = "Fail";
		$row["message"] = "No runner at your area";
		$data = $row;
		echo 'No';
	}
}

//API BEGIN HERE
//Most of request send via Http Post

//Catch Login request 
if(isset($_POST["login"])){
	// Check for not empty post
	if($_POST["login_email"] != "" && $_POST["login_password"] != "" ){
		$email = $db->real_escape_string($_POST["login_email"]);
		$password = $db->real_escape_string($_POST["login_password"]);
		$email = strip_tags($email);
		$password = strip_tags($password);	
		$sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
		$result = $db->query($sql);
		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			$token = rand(10000,1000000).uniqid().rand(100,100000);
			$row["login_token"] = $token;
			$row["password"] = "*********";
			$row["status"] = "success";
			$row["message"] = "You have successfully logged in";
			$data = $row;
			$sql = "UPDATE users SET login_token='$token' WHERE email='$email'";
			if ($db->query($sql) === TRUE) {
				echo json_encode($data, JSON_PRETTY_PRINT);
			} else {
				$response = "Error updating record: " . $db->error;
				echo '{"status":"fail", "message":"'.$response.'"}';
			}
		} else {
			$response = 'Login detail incorrect or doesn\'t exist';
			$responsetype = 'bg-danger';
			echo '{"status":"fail", "message":"Login detail incorrect or doesn\'t exist"}';
		}
	}else{
		//Return error if form not filled up
		$response = 'Please fill all the form';
		echo '{"status":"fail", "message":"Please fill all the form"}';
	}
}


//Catch Register request
if(isset($_POST["register"])){
	if($_POST["register_email"] != "" && $_POST["register_password"] != "" && $_POST["register_firstname"] != "" && $_POST["register_lastname"] != "" && $_POST["register_type"] != "" && $_POST["register_phonenumber"] != ""  && $_POST["register_gender"] != ""){
		$email = $db->real_escape_string($_POST["register_email"]);
		$phonenumber = cleanInput($_POST["register_phonenumber"]);
		$gender = cleanInput($_POST["register_gender"]);
		$email = strip_tags($email);	
		$sql = "SELECT email FROM users WHERE email='$email'";
		$result = $db->query($sql);
		define('UPLOAD_DIR', 'assets/');
		if ($result->num_rows == 0){
			$img1 = $_POST["register_ic_image"];
			if (strpos($img1, 'data:image/png;base64,') !== false) {
				$imgtype1 = ".png";
				$img1 = str_replace('data:image/png;base64,', '', $img1);
				$img1 = str_replace(' ', '+', $img1);
			}
			if (strpos($img1, 'data:image/jpeg;base64,') !== false) {
				$imgtype1 = ".jpg";
				$img1 = str_replace('data:image/jpeg;base64,', '', $img1);
				$img1 = str_replace(' ', '+', $img1);
			}
			$data1 = base64_decode($img1);
			$namez = rand(100000,100000000).uniqid();
			$namez = md5($namez);
			$imgfile1 = UPLOAD_DIR . uniqid() .$namez.$imgtype1;
			$success1 = file_put_contents($imgfile1, $data1);
			$imgfileurl1 = $itemurl . $imgfile1;
			$firstname = $db->real_escape_string($_POST["register_firstname"]);
			$lastname = $db->real_escape_string($_POST["register_lastname"]);
			$fullname = $db->real_escape_string($_POST["register_fullname"]);
			$password = $db->real_escape_string($_POST["register_password"]);
			$country = $db->real_escape_string($_POST["register_country"]);
			$icnumber = $db->real_escape_string($_POST["register_ic"]);
			$login_token = rand(1000,100000).uniqid().rand(100000,100000);
			$profile_img = "img/default_profile_picture.jpg";  
			$type = $db->real_escape_string($_POST["register_type"]);
			$public_token = rand(100,1000).$firstname.uniqid();
			$public_token = str_replace(" ", "", $public_token);
			
			$secret_token = rand(100,1000).$lastname.uniqid();
			$secret_token = str_replace(" ", "", $secret_token);
			$refferercode = cleanInput($_POST["register_referer"]);
			if($refferercode != ""){
				$sqlrefer = "SELECT * FROM users WHERE my_referral_code ='$refferercode'";
				$resultrefer = $db->query($sqlrefer);

				if ($resultrefer->num_rows > 0) {
					$rowrefer = $resultrefer->fetch_assoc();
					$referedby = $rowrefer["id"];
				} else {
					$referedby = '0';
				}
			}else{
				$referedby = '0';
			}		
			$registeredusercode = random_strings(10);
			
			$sqlreferc = "SELECT * FROM users WHERE my_referral_code='$registeredusercode'";
			$resultreferc = $db->query($sqlreferc);

			if ($resultreferc->num_rows > 0) {
				$registeredusercode = random_strings(10);
			}	
			if($type == 2){
				
				$sql = "INSERT INTO users (firstname, lastname, fullname, country, email, password, login_token, profile_img, type, phonenumber, availability, wallet, rider_credit, ic_number, public_token, secret_token, my_referral_code, my_referrer, customer_approved)
				VALUES ('$firstname', '$lastname', '$fullname', '$country', '$email', '$password', '$login_token', '$profile_img', '$type', '$phonenumber', 'Waiting', '0.00', '0.00', '$icnumber', '$public_token', '$secret_token', '$registeredusercode', '$referedby', 'true')";
				
			}else{

				$sql = "INSERT INTO users (firstname, lastname, fullname, country, email, password, login_token, profile_img, type, phonenumber, wallet, ic, gender, ic_number, public_token, secret_token, my_referral_code, my_referrer, customer_approved)
				VALUES ('$firstname', '$lastname', '$fullname', '$country', '$email', '$password', '$login_token', '$profile_img', '$type', '$phonenumber', '0.00', '$imgfileurl1', '$gender', '$icnumber', '$public_token', '$secret_token', '$registeredusercode', '$referedby', 'true')";
				
			}
			if ($db->query($sql) === TRUE) {
				echo '{"status":"success", "message":"Registeration successull", "login_token":"'.$login_token.'", "public_token":"'.$public_token.'", "secret_token":"'.$secret_token.'"}';
			} else {
				echo "Error: " . $sql . "<br>" . $db->error;
			}
		} else {
			echo '{"status":"fail", "message":"The email has been registered with in our system"}';
		}
	}else{
		$response = 'Please fill all the form';
		echo '{"status":"fail", "message":"Please fill all the form"}';
	}
}
//Catch a login token POST request
if(isset($_POST["login_token"])){
	if($update == true){
		echo '{"status":"update", "message":"This app require update"}';
	}else{
		if($_POST["login_token"] != ""){
		$login_token = $db->real_escape_string($_POST["login_token"]);
		$lat = $db->real_escape_string($_POST["lat"]);
		$lng = $db->real_escape_string($_POST["lng"]);
		$sql = "SELECT * FROM users WHERE login_token='$login_token'";
		$result = $db->query($sql);
		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			$userid = $row["id"];
			$row["delyvaConsumerId"] = '105310';
			$row["password"] = "*********";
			$row["status"] = "success";
			$row["message"] = "Token Exist";
			$row["priceperkm"] = $priceperkm; 
			if($row["type"] == 1){
				$resid = $row["id"];
				$sqldo = "SELECT * FROM job_order WHERE restaurant_id='$resid' AND order_status='New' OR restaurant_id='$resid' AND order_status='Preparing' OR restaurant_id='$resid' AND order_status='Delivering'";
				$jr = $db->query($sqldo);
				$row["active_order"] = $jr->num_rows;
				$row["productmargin"] = $productmargin;
				
				$sqlb = "SELECT * FROM blogs WHERE category = 'Blog' LIMIT 4 ";
				$resultb = $db->query($sqlb);
				if ($resultb->num_rows > 0) {
					while($rowb = $resultb->fetch_assoc()) {
						$blog[] = $rowb;
					}
					$row["blog"] = $blog;
				} else {
					$row["blog"] = 'Empty';
				}
				$row["cardon"] = "false";
				$data = $row;
				echo json_encode($data, JSON_PRETTY_PRINT);
			}
			if($row["type"] == 4){
				$resid = $row["id"];
				$sqldo = "SELECT * FROM job_order WHERE restaurant_id='$resid' AND order_status='New' OR restaurant_id='$resid' AND order_status='Preparing' OR restaurant_id='$resid' AND order_status='Delivering'";
				$jr = $db->query($sqldo);
				$row["active_order"] = $jr->num_rows;
				$row["productmargin"] = $productmargin;
				$sqlb = "SELECT * FROM blogs LIMIT 4";
				$resultb = $db->query($sqlb);
				if ($resultb->num_rows > 0) {
					while($rowb = $resultb->fetch_assoc()) {
						$rowb["content"] = substr($rowb["content"], 0, 20);
						$rowb["title"] = substr($rowb["title"], 0, 20);
						$blog[] = $rowb;
					}
					$row["blog"] = $blog;
				} else {
					$row["blog"] = 'Empty';
				}
				$data = $row;
				echo json_encode($data, JSON_PRETTY_PRINT);
			}
			
			if($row["type"] == 2){
					$riderid = $row["id"];
					$sqlat = "UPDATE users SET lat='$lat', lng='$lng' WHERE id='$riderid'";
					$db->query($sqlat);
					$checkjobsql = "SELECT * FROM job_order WHERE runner='$riderid' AND order_status = 'New' OR runner='$riderid' AND order_status = 'Preparing' OR runner='$riderid' AND order_status = 'Delivering'";
					$jobresult = $db->query($checkjobsql);
					if ($jobresult->num_rows > 0){
						$rows = $jobresult->fetch_assoc();
						$row["job_id"] = $rows["id"]; 
						$row["job_info"] = $rows;
						$customerlat = $rows["delivery_lat"];
						$customerlng = $rows["delivery_lng"];
						$vendorid = $rows["restaurant_id"];
						$scramble = json_decode($rows["data"]);
						$deliveryaddress = $scramble->delivery_address;
						$encodedaddressdelivery = urlencode($deliveryaddress);
						$row["deliver_customer_map_query"] = 'geo:'.$customerlat.','.$customerlng.'?q='.$encodedaddressdelivery;
						$deliveryprice = $scramble->delivery_price; 
						$sqlres = "SELECT * FROM users WHERE id='$vendorid'";
						$resultres = $db->query($sqlres);
						if ($resultres->num_rows > 0) {
						  $rowres = $resultres->fetch_assoc();
						  $row["deliver_vendor_name"] = $rowres["vendor_name"];
						  $row["deliver_vendor_address"] =  $rowres["vendor_address"];
						  $row["deliver_vendor_lat"] =  $rowres["lat"];
						  $row["deliver_vendor_lng"] =  $rowres["lng"];
						  $encodedaddress = urlencode($rowres["vendor_address"]);
						  $row["deliver_vendor_map_query"] = 'geo:'.$rowres["vendor_lat"].','.$rowres["vendor_lng"].'?q='.$encodedaddress;
						}
						if($row["availability"] != "Completing Task"){
							$sqlat = "UPDATE users SET lat='$lat', lng='$lng', availability='Completing Task' WHERE id='$userid'";
							$row["availability"] = "Completing Task";
						}else{
							$sqlat = "UPDATE users SET lat='$lat', lng='$lng' WHERE id='$userid'";
						}
						$db->query($sqlat);
						
					}else{
						
					}		
				$row["productmargin"] = $productmargin;
				$sqlb = "SELECT * FROM blogs LIMIT 4";
				$resultb = $db->query($sqlb);
				if ($resultb->num_rows > 0) {
					while($rowb = $resultb->fetch_assoc()) {
						$blog[] = $rowb;
					}
					$row["blog"] = $blog;
				} else {
					$row["blog"] = 'Empty';
				}
				$data = $row;
				echo json_encode($data, JSON_PRETTY_PRINT);
			}
			
			if($row["type"] == 0){
				$row["hqlat"] = 6.0463;
				$row["hqlng"] = 116.1496;
				$sqlat = "UPDATE users SET lat='$lat', lng='$lng' WHERE id='$userid'";
				$db->query($sqlat);
				$row["delivery_discount"] = $deliverydiscount;
				$row["promo_image"] = $promoimg;
				$row["productmargin"] = $productmargin;
				$sqlb = "SELECT * FROM blogs WHERE category ='Blog' LIMIT 4";
				$resultb = $db->query($sqlb);
				if ($resultb->num_rows > 0) {
					while($rowb = $resultb->fetch_assoc()) {
						$rowb["content"] = substr(strip_tags($rowb["content"]), 0, 100);
						$rowb["content"] = $rowb["content"].'...';
						$rowb["title"] = substr(strip_tags($rowb["title"]), 0, 20);
						$rowb["title"] = $rowb["title"].'...';
						$blog[] = $rowb;
					}
					$row["blog"] = $blog;
				} else {
					$row["blog"] = 'Empty';
				}
				
				$row["cardon"] = false;
				$row["ecarecategory"] = $ecarecategory;
				$row["elabcategory"] = $elabcategory;
				$data = $row;
				echo json_encode($data, JSON_PRETTY_PRINT);
				
			}
			
			if($row["type"] == 6){
				$sqlat = "UPDATE users SET lat='$lat', lng='$lng' WHERE id='$userid'";
				$db->query($sqlat);
				$vid = $row["id"];
				$accounts_verificationsql = "SELECT * FROM accounts_verification WHERE owner='$vid'";
				$accounts_verificationresult = $db->query($accounts_verificationsql);
				if ($accounts_verificationresult->num_rows > 0){
					$vrow = $accounts_verificationresult->fetch_assoc();
					$row["verification_status"] = $vrow["request_status"];
					$row["verifying_for"] = $vrow["verifying_for"];
					
					
				} else {
				
					$row["verification_status"] = "Empty";
					
				}
				$sqlb = "SELECT * FROM blogs LIMIT 4";
				$resultb = $db->query($sqlb);
				if ($resultb->num_rows > 0) {
					while($rowb = $resultb->fetch_assoc()) {
						$blog[] = $rowb;
					}
					$row["blog"] = $blog;
				} else {
					$row["blog"] = 'Empty';
				}

				$row["delivery_discount"] = $deliverydiscount;
				$row["promo_image"] = $promoimg;
				$row["productmargin"] = $productmargin;
				
				$data = $row;
				echo json_encode($data, JSON_PRETTY_PRINT);
			}
			
			
			
		} else {
			$response = 'Login detail incorrect or doesn\'t exist';
			$responsetype = 'bg-danger';
			echo '{"status":"fail", "message":"Token Expired"}';
		}
		}else{
			$response = 'Please fill all the form';
			echo '{"status":"fail", "message":"Token cant be empty"}';
		}
	}
}

//Catch auth token
//Before executing any request check the authenticated user token
if(isset($_POST["auth_token"])){
	$login_token = $db->real_escape_string($_POST["auth_token"]);
	$sql = "SELECT * FROM users WHERE login_token='$login_token'";
	$result = $db->query($sql);
	if ($result->num_rows > 0) {
		$authUser = $result->fetch_assoc();
		//Now include in request
		include("request.php");
		if(isset($data)){
			echo json_encode($data, JSON_PRETTY_PRINT); 
		}else{
			echo '{"status":"fail", "message":"No request"}';
		}
	} else {
		echo '{"status":"fail", "message":"Your session has expired. Please login."}';
	}
} 
if(isset($_POST["recover_account"])){ 
	$email = $db->real_escape_string($_POST["recovery_email"]);
	$sql = "SELECT * FROM users WHERE email='$email'";
	$result = $db->query($sql);
	if ($result->num_rows > 0) {
		$userow = $result->fetch_assoc();
		$message = 'EPINK Password Reminder';
		$recoverypassword = $userow["password"];
		$resetcode = md5(rand(1000,1000000).uniqid().rand(100000,10000000));
		$subject = 'Hello, <br> You have requested a password recovery. We provided you with a link to reset your password. <br> Password reset link : <a href="https://epink.health/recovery/?hash='.$resetcode.'">https://epink.health/recovery/?hash='.$resetcode.'</a>';
		$email = $email;
		
		
		$sqlrec = "UPDATE users SET reset_code='$resetcode', request_reset_date='$currentdate' WHERE email='$email'";
		if ($db->query($sqlrec) === TRUE) {
			instaMail($message, $subject, $email);
			echo '{"status":"success", "message":"A password reset link has been sent to your email"}';
		} else {
			echo '{"status":"fail", "message":"Please try again"}';
		}
	} else {
		echo '{"status":"fail", "message":"Email does not exist"}';
	}
}

if(isset($_POST["teleconsent"])){
	$sql = "SELECT * FROM settings WHERE setting_item='telemed'";
	$result = $db->query($sql);
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		echo json_encode($row, JSON_PRETTY_PRINT);
	} else {
		echo '{"status":"fail", "message":"Content Not Found"}';
	}
}

if(isset($_POST["privacy_policy"])){
	$sql = "SELECT * FROM settings WHERE setting_item='privacy_policy'";
	$result = $db->query($sql);
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		echo json_encode($row, JSON_PRETTY_PRINT);
	} else {
		echo '{"status":"fail", "message":"Content Not Found"}';
	}
}

if(isset($_POST["tnc"])){
	$sql = "SELECT * FROM settings WHERE setting_item='tnc'";
	$result = $db->query($sql);

	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		echo json_encode($row, JSON_PRETTY_PRINT);
	} else {
		echo '{"status":"fail", "message":"Content Not Found"}';
	}
}
function getProfile($id){
	global $db;
	$userid = $db->real_escape_string($id);
	$sql = "SELECT id, firstname, lastname, profile_img, lat, lng type FROM users WHERE id='$userid'";
	$result = $db->query($sql);
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		$row["password"] = "*********";
		$row["status"] = "success";
		$row["message"] = "User Exist";
		$row["login_token"] = "public";
		return json_encode($row);
	} else {
		$row["status"] = "fail";
		$row["message"] = "This user no longer exist";
		$row["firstname"] = "Deleted";
		$row["lastname"] = "Account";
		return json_encode($row);
	}
}

function getVendorprofile($id){
	global $db;
	$userid = $db->real_escape_string($id);
	$sql = "SELECT vendor_name, email, vendor_address, lat, lng, phonenumber, vendor_street_address, vendor_street_address_2, vendor_city, vendor_postcode, vendor_state, vendor_country FROM users WHERE id='$userid'";
	$result = $db->query($sql);
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		
		return $row;
	} else {
		$row["status"] = "fail";
		$row["message"] = "This user no longer exist";
		return $row;
	}
}
function constructDelyvaAddress($id){
	global $db;
	$userid = $db->real_escape_string($id);
	$sql = "SELECT vendor_name, vendor_address, lat, lng, phonenumber, vendor_street_address, vendor_street_address_2, vendor_city, vendor_postcode, vendor_state, vendor_country FROM users WHERE id='$userid'";
	$result = $db->query($sql);
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		$origin = [
				"address1" => "",
				"address2" => "",
				"city" => "",
				"state" => "",
				"postcode" => "",
				"country" => "MY",
				"coord" => ["lat" => "", "lon" => ""]
			];
		$coord = ["lat" => "", "lon" => ""];
		
		$coord["lat"] = $row["lat"];
		$coord["lon"] = $row["lng"];
		$origin["coord"] = $coord;
		$origin["address1"] = $row["vendor_street_address"];
		$origin["address2"] = $row["vendor_street_address_2"];
		$origin["city"] = $row["vendor_city"];
		$origin["state"] = $row["vendor_state"];
		$origin["postcode"] = $row["vendor_postcode"];
		$origin["country"] = "MY";
		return $origin;
	} else {
		$row["status"] = "fail";
		$row["message"] = "This user no longer exist";
		return $row;
	}
}
function getProfile2($id){
	global $db;
	$userid = $db->real_escape_string($id);
	$sql = "SELECT * FROM users WHERE id='$userid'";
	$result = $db->query($sql);
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		$row["password"] = "*********";
		$row["status"] = "success";
		$row["message"] = "User Exist";
		$row["login_token"] = "public";
		return $row;
	} else {
		$row["status"] = "fail";
		$row["message"] = "This user no longer exist";
		return json_encode($row, JSON_PRETTY_PRINT);
	}
}
function getPatientFullname($id){
	global $db;
	$userid = $db->real_escape_string($id);
	$sql = "SELECT * FROM users WHERE id='$userid'";
	$result = $db->query($sql);
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		return $row["firstname"].' '.$row["lastname"];
	} else {
		return 'User does not exist';
	}
}
function getDoctorFullname($id){
	global $db;
	$userid = $db->real_escape_string($id);
	$sql = "SELECT * FROM users WHERE id='$userid'";
	$result = $db->query($sql);
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		return $row["firstname"].' '.$row["lastname"];
	} else {
		return 'User does not exist';
	}
}
function getProfilePicture($id){
	global $db;
	$userid = $db->real_escape_string($id);
	$sql = "SELECT * FROM users WHERE id='$userid'";
	$result = $db->query($sql);
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		$row["password"] = "*********";
		$row["status"] = "success";
		$row["message"] = "User Exist";
		$row["login_token"] = "public";
		return $row["profile_img"];
	} else {
		$row["status"] = "fail";
		$row["message"] = "This user no longer exist";
		return json_encode($row, JSON_PRETTY_PRINT);
	}
}

function getsimpleProfile($id){
	global $db;
	$userid = $db->real_escape_string($id);
	$sql = "SELECT id, firstname, lastname, profile_img, type, ic_number, phonenumber, lat, lng, id_token, date_of_birth, gender, height, weight, heart_rate, blood_group, provider_type FROM users WHERE id='$userid'";
	$result = $db->query($sql);
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		$row["status"] = "success";
		if($row["type"] == "6"){
			$row["fee"] = 20;
			$row["full_name"] = $row["firstname"].' '.$row["lastname"];
		}else{
			$row["full_name"] = $row["firstname"].' '.$row["lastname"];
		}
		$dob = $row["date_of_birth"];
		$row["gender"] = strtolower($row["gender"]);
		$diff = (date('Y') - date('Y',strtotime($dob)));
		$row["age"] =  $diff;
		if($row["heart_rate"] == null){
			$row["heart_rate"] = "Not Set";
		}
		if($row["blood_group"] == null){
			$row["blood_group"] = "Not Set";
		}
		if($row["age"] == 0){
			$row["age"] = "Not Set";
		}
		return $row;
	} else {
		$row["full_name"] = "This user no longer exist";
		return $row;
	}
}
function getsimpleProfiletoken($id){
	global $db;
	$userid = $db->real_escape_string($id);
	$sql = "SELECT id, firstname, lastname, profile_img, type, ic_number, phonenumber, lat, lng, id_token FROM users WHERE id_token='$userid'";
	$result = $db->query($sql);
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		$row["status"] = "success";
		if($row["type"] == "6"){
			$row["fee"] = 20;
			$row["full_name"] = 'DR.'.$row["firstname"].' '.$row["lastname"];
		}else{
			$row["full_name"] = $row["firstname"].' '.$row["lastname"];
		}
		return $row;
	} else {
		$row["full_name"] = "This user no longer exist";
		return $row;
	}
}

function sendNotification($owner, $title, $message){
	global $db;
	$message = cleanInput($message);
	$title = cleanInput($title);
	$owner = cleanInput($owner);
	$notifcationssql = "INSERT INTO notifcations (title, title_my, description, description_my, owner) VALUES ('$title', '$title', '$message', '$message', '$owner')";
	if ($db->query($notifcationssql) === TRUE) {
		$row["card"] = "green";
		$row["status"] = "Successful";
		$row["message"] =  "New record successfully created";
		$data = $row;
	} else {
		$row["card"] = "red";
		$row["status"] = "Fail";
		$row["message"] =  "Error: " . $sql . "<br>" . $db->error;
		$data = $row;
	}
}
function checkDoc($id){
	global $db;
	$sql = "SELECT * FROM users WHERE id='$id'";
	$result = $db->query($sql);
	if ($result->num_rows > 0){
		if($row["type"] == 6){
			return true;
		}else{
			return false;
		}
	} else {
		return false;
	}
}
function insertTransaction($from_user, $to_user, $amount, $tnote){
	global $db, $currentdatetime;
	$transaction_historysql = "INSERT INTO transaction_history (from_user, to_user, amount, transaction_date, transaction_note) VALUES ('$from_user', '$to_user', '$amount', '$currentdatetime', '$tnote')";
	$db->query($transaction_historysql);
}
function getLastmessage($id){
	global $db;
	$sql = "SELECT * FROM chatcontent WHERE chat_thread='$id' ORDER BY id DESC limit 1";
	$result = $db->query($sql);
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		$row["password"] = "*********";
		$row["status"] = "success";
		$row["message"] = "User Exist";
		$row["login_token"] = "public";
		$lastchat = $row["chat_content"];
		$str = substr($lastchat, 0, 30) . '...';
		$row["chat_content"] = $str;
		return $row["chat_content"];
	} else {
		$row["chat_content"] = "";
		return $row["chat_content"];
	}
}
if(isset($_POST["uploadiconfile"])){
	$iconurl = processFile($_POST["uploadiconfile"]);
	$data["status"] = 'successfull'; 
    $data["iconurl"] = $iconurl;
	echo json_encode($data, JSON_PRETTY_PRINT); 
}
if(isset($_GET["getOrders"])){
	include("speedy.php");
	getOrders();
}
if(isset($_POST["filetoupload"])){
	define('UPLOAD_DIR', 'test/');
	
		$img1 = $_POST["filetoupload"];
		if (strpos($img1, 'data:image/png;base64,') !== false) {
			$imgtype1 = ".png";
			$img1 = str_replace('data:image/png;base64,', '', $img1);
			$img1 = str_replace(' ', '+', $img1);
		}
		if (strpos($img1, 'data:image/jpeg;base64,') !== false) {
			$imgtype1 = ".jpg";
			$img1 = str_replace('data:image/jpeg;base64,', '', $img1);
			$img1 = str_replace(' ', '+', $img1);
		}
		$data1 = base64_decode($img1);
		$namez = rand(100000,100000000).uniqid();
		$namez = md5($namez);
		$imgfile1 = UPLOAD_DIR . uniqid() .$namez.$imgtype1;
		$success1 = file_put_contents($imgfile1, $data1);
		$ic_font = $itemurl . $imgfile1;
		$data["file"] = $ic_font;	
		echo json_encode($data, JSON_PRETTY_PRINT);		
}

if(isset($_POST["getmed"])){
	$medname = cleanInput($_POST["getmed"]);
	$sql = "SELECT * FROM meds WHERE medicine_name LIKE '%$medname%' LIMIT 10";
	$result = $db->query($sql);
	if ($result->num_rows > 0) {
	  while($row = $result->fetch_assoc()) {
			$data[] = $row;
	  }
	  echo json_encode($data, JSON_PRETTY_PRINT);	
	} else {
		$data["status"] = "fail";
	    echo json_encode($data, JSON_PRETTY_PRINT);	
	}
}

if(isset($_POST["savePdf"])){
	$savedfile = processFile($_POST["savePdf"]);
	$icpassport = cleanInput($_POST["id"]);
	if($savedfile != ""){
		$sql = "UPDATE c19consent SET pdf='$savedfile' WHERE icpassport='$icpassport'";
		if ($db->query($sql) === TRUE) {
			echo '{"status":"successfull", "message":"'.$savedfile.'"}';
		} else {
			$errmessage =  "Error updating record: " . $db->error;
			echo '{"status":"fail", "message":"'.$errmessage.'"}';
		}
	}
}
$db->close();
?>