<?php

date_default_timezone_set("Asia/Kuala_Lumpur");
$domain = 'http://localhost:8000';
$projectname = 'EPINK HEALTH';
$uploadfolder = 'uploads/';
/* if(!isset($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] != "on")
{
    //Tell the browser to redirect to the HTTPS URL.
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"], true, 301);
    //Prevent the rest of the script from executing.
    exit;
} */
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "epink";
$currentdatetime = date("Y-m-d H:i:s");

$db = new mysqli($servername, $username, $password, $dbname);
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

if(empty($_SESSION['csrftoken'])) {
    $_SESSION['csrftoken'] = bin2hex(random_bytes(32));
}
$csrftoken = $_SESSION['csrftoken'];

$router=[];
foreach (explode ("/", $_SERVER['REQUEST_URI']) as $part){
	$router[] = $part;
    echo $part;
}

$page_identifier = $router[2];

if(isset($router[3])){
	$page_identifier_action =  $router[3];
}
if(isset($router[4])){
	$page_action_identifier =  $router[4];
}
if(isset($router[5])){
	$final_identifier =  $router[5];
}
if(isset($router[6])){
	$final_identifier_data =  $router[6];
}

function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
    $output = NULL;
    if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
        $ip = $_SERVER["REMOTE_ADDR"];
        if ($deep_detect) {
            if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
    }
    $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
    $support    = array("country", "countrycode", "state", "region", "city", "location", "address");
    $continents = array(
        "AF" => "Africa",
        "AN" => "Antarctica",
        "AS" => "Asia",
        "EU" => "Europe",
        "OC" => "Australia (Oceania)",
        "NA" => "North America",
        "SA" => "South America"
    );
    if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
        $ipdat = @json_decode(file_get_contents("https://www.geoplugin.net/json.gp?ip=" . $ip));
        if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
            switch ($purpose) {
                case "location":
                    $output = array(
                        "city"           => @$ipdat->geoplugin_city,
                        "state"          => @$ipdat->geoplugin_regionName,
                        "country"        => @$ipdat->geoplugin_countryName,
                        "country_code"   => @$ipdat->geoplugin_countryCode,
                        "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                        "continent_code" => @$ipdat->geoplugin_continentCode
                    );
                    break;
                case "address":
                    $address = array($ipdat->geoplugin_countryName);
                    if (@strlen($ipdat->geoplugin_regionName) >= 1)
                        $address[] = $ipdat->geoplugin_regionName;
                    if (@strlen($ipdat->geoplugin_city) >= 1)
                        $address[] = $ipdat->geoplugin_city;
                    $output = implode(", ", array_reverse($address));
                    break;
                case "city":
                    $output = @$ipdat->geoplugin_city;
                    break;
                case "region":
                case "state":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "country":
                    $output = @$ipdat->geoplugin_countryName;
                    break;
                case "countrycode":
                    $output = @$ipdat->geoplugin_countryCode;
                    break;
            }
        }
    }
    return $output;
}
function instaMail($subject, $message, $email): void
{
	$to = $email;
	$headers="MIME-Version: 1.0" . "\r\n";
	$headers .="Content-type:text/html;charset=UTF-8" . "\r\n";
	$headers .='From: Tirematic <admin@tirematics.com>' . "\r\n";
	$headers .="Reply-To: Tirematic <admin@tirematics.com>\r\n";
	$headers .="Return-Path: Tirematic <admin@tirematics.com>\r\n";
	$headers .="Content-type: text/html; charset=utf-8\r\n";
	$headers .="X-Priority: 3\r\n";
	$headers .="X-Mailer: PHP". phpversion() ."\r\n";
	mail($to, $subject, $message, $headers);
}
function getdistance($lat1, $lon1, $lat2, $lon2, $unit)
{
  if (($lat1 == $lat2) && ($lon1 == $lon2)) {
    return 0;
  }
  else {
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

function getVendorName($id){
	global $db;
	$id = cleanInput($id);
	$vendorssql = "SELECT * FROM vendors WHERE id='$id'";
	$vendorsresult = $db->query($vendorssql);
	if ($vendorsresult->num_rows > 0){
		$row = $vendorsresult->fetch_assoc();
		$vendorsdata = $row;
		$vendorname = $row["name"];
		
	} else {
		$vendorname = "Not found";
	}
	return $vendorname;
}
function getCompanyname($id){
	global $db;
	$id = cleanInput($id);
	$vendorssql = "SELECT * FROM companies WHERE id='$id'";
	$vendorsresult = $db->query($vendorssql);
	if ($vendorsresult->num_rows > 0){
		$row = $vendorsresult->fetch_assoc();
		$vendorsdata = $row;
		$vendorname = $row["name"];
		
	} else {
		$vendorname = "Not found";
	}
	return $vendorname;
}
function cleanInput($input): string
{
	global $db;
	$data = strip_tags($input);
	$data = $db->real_escape_string($data);
	return $data;
}

function getMilage($tireid){ 
	global $db;
		$gpsql = "SELECT * FROM gps WHERE type='Tire' AND owner_id='$tireid'";
		$pgresult = $db->query($gpsql);
		if ($pgresult->num_rows > 0) {
			$prevlat = '';
			$prevlon = '';
			$traveldistance = 0;
			while($gpdata = $pgresult->fetch_assoc()) {
				if($prevlat == '' && $prevlon == ''){
					//This is the first 
					$prevlat = $gpdata["lat"];
					$prevlon = $gpdata["lon"];
				}else{
					$curlat = $gpdata["lat"];
					$curlon = $gpdata["lon"];
					$getcurdistance = getdistance($prevlat, $prevlon, $curlat, $curlon, "K");
					$traveldistance = $traveldistance + $getcurdistance;
					$prevlat = $curlat;
					$prevlon = $curlon;
				}
			}
			$traveldistance = number_format($traveldistance, 2);
		}else{
			$traveldistance = 0;
		}
		return $traveldistance;
}
function getVendorprofile($id)
{
	global $db;
	$userid = $db->real_escape_string($id);
	$sql = "SELECT vendor_name, vendor_address, lat, lng, phonenumber FROM users WHERE id='$userid'";
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
function processFile($base64file): string
{
	global $domain;
	define('UPLOAD_DIR', 'files/');
	$files = $base64file;		
	if (str_contains($files, 'data:image/png;base64,')) {
		$filetype = ".png";
		$files = str_replace('data:image/png;base64,', '', $files);
		$files = str_replace(' ', '+', $files);
	}
	if (str_contains($files, 'data:image/jpeg;base64,')) {
		$filetype = ".jpg";
		$files = str_replace('data:image/jpeg;base64,', '', $files);
		$files = str_replace(' ', '+', $files);
	}
	if (str_contains($files, 'data:image/gif;base64,')) {
		$filetype = ".gif";
		$files = str_replace('data:image/gif;base64,', '', $files);
		$files = str_replace(' ', '+', $files);
	}
	if (str_contains($files, 'data:application/pdf;base64,')) {
		$filetype = ".pdf";
		$files = str_replace('data:application/pdf;base64,', '', $files);
		$files = str_replace(' ', '+', $files);
	}
	if (str_contains($files, 'data:application/docx;base64,')) {
		$filetype = ".docx";
		$files = str_replace('data:application/docx;base64,', '', $files);
		$files = str_replace(' ', '+', $files);
	}	
	if (str_contains($files, 'data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,')) {
		$filetype = ".xlsx";
		$files = str_replace('data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,', '', $files);
		$files = str_replace(' ', '+', $files);
	}	
	$data = base64_decode($files);
	$filearea = UPLOAD_DIR . uniqid() . $filetype;
	$success = file_put_contents($filearea, $data);
	$fileurl = $domain.'/'.$filearea;
	return $fileurl;
}




$customcolor = 'style="color: #2D75FF !important;" ';
$url =  "https://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
$page_title = 'FUDS';
$page_url = htmlspecialchars( $url, ENT_QUOTES, 'UTF-8' );
$page_img = $domain.'/img/ftmsdefault.jpg';
$page_description = 'Not Set';
$pagename = '';

$websitename = 'EPINK';
$companyaddress = '7. Jalan PJS 7/21, <br>
             Bandar Sunway AY,<br>

46150 Subang Jaya, <br>
             Selangor Malaysia <br><br>';
$companyphonenumber = '0356133339';
$companyemail = 'admin@osocapto.my';
