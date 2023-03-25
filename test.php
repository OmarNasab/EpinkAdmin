<?php
//include("controller/functions.php");
include("files.php");
//error_reporting(1);
//Url And Basic Auth information
$username = 'epink_pilot';
$password = 'YcuLxvMMcXWPLRaw';
$soapurl = "http://103.233.2.69:8080/MTSAPilot/MyTrustSignerAgentWSHC?wsdl";
$base64sampleimg ='data:image/jpeg;base64,iVBORw0KGgoAAAANSUhEUgAAASAAAACvCAIAAADScJRuAAAAAXNSR0IArs4c6QAAAARnQU1BAACx'; 
$samplebase64pf = 'test';
$context = array('http' =>
    array(
      'header'  => "Username: ".$username."\r\n" . "Password: ".$password."\r\n"
    )
);


function pdfToBase64($url){
	$pdf = file_get_contents($url);
	$pdfbase64 = base64_encode($pdf);
	return $pdfbase64;
}

function imgToBase64($url){
	$png = file_get_contents($url);
	$pngbase64 = base64_encode($png);
	return $pngbase64;
}

function random_strings($length_of_string) 
{ 
    $str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz'; 
    return substr(str_shuffle($str_result), 0, $length_of_string); 
} 

if(isset($_GET["setcode"])){
	$servername = "localhost";
	$username = "epink";
	$password = "880208Limitless@";
	$dbname = "admin_epink";
	$db = new mysqli($servername, $username, $password, $dbname);
	if ($db->connect_error) {
		die("Connection failed: " . $db->connect_error);
	}
	$sql = "SELECT * FROM users WHERE my_referral_code = ''";
	$result = $db->query($sql);

	if ($result->num_rows > 0) {
	  // output data of each row
	  while($row = $result->fetch_assoc()) {
		  
		$uid = $row["id"];
		$refcode = random_strings(10);
		$sql = "UPDATE users SET my_referral_code='$refcode' WHERE id='$uid'";

		if ($db->query($sql) === TRUE) {
		  echo "Record updated successfully<br>";
		} else {
		  echo "Error updating record: " . $db->error;
		}		  
		  
		  
		
	  }
	} else {
	  echo "0 results";
	}
}
if(isset($_GET["approvecustomer"])){
	$servername = "localhost";
	$username = "epink";
	$password = "880208Limitless@";
	$dbname = "admin_epink";
	$db = new mysqli($servername, $username, $password, $dbname);
	if ($db->connect_error) {
		die("Connection failed: " . $db->connect_error);
	}
	$sql = "UPDATE users SET customer_approved='true'";

	if ($db->query($sql) === TRUE) {
	  echo "Record updated successfully";
	} else {
	  echo "Error updating record: " . $conn->error;
	}
}
//Define Parameters
$soapParameters = array('Username' => $username, 'Password' => $password, 'trace'=> 1, 'stream_context' => stream_context_create($context), 'soap_version' => SOAP_1_1);
$client = new SoapClient($soapurl, $soapParameters);

if(isset($_GET["RequestCertificateForHealthcare"])){
	$id = $_GET["RequestCertificateForHealthcare"];
	//Organization
	$orgName = 'HOSPITAL TAIPING';
	$orgUserDesignation = 'Doctor';
	$orgAddress = 'JALAN TAMING SARI MAIN ROAD';
	$orgAddressCity = 'TAIPING';
	$orgAddressState = 'PERAK';
	$orgAddressPostcode = '34000';
	$orgAddressCountry = 'MY';
	$orgRegistationNo = '';
	$orgPhoneNo = '';
	$orgFaxNo = '';
	$OrganisationInfo = array('orgName' => $orgName,'orgUserDesignation' => $orgUserDesignation, 'orgAddress' => $orgAddress,'orgAddressCity' => $orgAddressCity,'orgAddressState' => $orgAddressState,'orgAddressPostcode' => $orgAddressPostcode,'orgAddressCountry' => $orgAddressCountry,'orgRegistationNo' => $orgRegistationNo,'orgPhoneNo' => $orgPhoneNo,'orgFaxNo' => $orgFaxNo,);
	//User
	$UserID = "930213115305";
	$IDType = "N";
	$FullName = 'MUHAMMAD FAQIHUDDIN BIN AZMAN';
	$Nationality = 'MY';
	$EmailAddress = 'anantateordev@gmail.com';
	$MobileNo = '60146503651';
	$CertValidity = 'L';
	$Designation = 'Doctor';
	$MembershipNo = '91394';
	$DegreeCert = pdfToBase64("https://epink.health/img/apc.pdf");
	$PassportImage = "";
	$NRICFront = imgToBase64("https://epink.health/img/icfront.png");
	$NRICBack = imgToBase64("https://epink.health/img/icback.png");
	$requestParameters = array('UserID' => $UserID, 'IDType' => $IDType, 'FullName' => $FullName, 'Nationality' => $Nationality, 'EmailAddress' => $EmailAddress, 'MobileNo' => $MobileNo, 'CertValidity' => $CertValidity,'Designation' => $Designation, 'MembershipNo' => $MembershipNo, 'DegreeCert' => $DegreeCert, 'PassportImage' => $PassportImage, 'NRICFront' => $NRICFront, 'NRICBack' => $NRICBack,'OrganisationInfo' => $OrganisationInfo,);
	$result = $client->RequestCertificateForHealthcare($requestParameters);
	$response = json_encode($result->return);
	echo $response;
	//saveResponse($response, $id);
}

if(isset($_GET["GetRequestStatus"])){
	$id = $_GET["GetRequestStatus"];
	$requestParameters = array('requestID'=> 1251, 'userID' => '930213115305',);
	$finalparameter = array('UserRequestList'=>$requestParameters);
	$result = $client->GetRequestStatus($finalparameter);
	$response = json_encode($result->return);
	echo $response;
}

if(isset($_GET["GetActivation"])){
	$id = $_GET["GetActivation"];
	$requestParameters = array('RequestID'=> 1251, 'UserID' => '930213115305',);
	$result = $client->GetActivation($requestParameters);
	$response = json_encode($result->return);
	echo $response;
	
	//saveResponse($response, $id);
}

if(isset($_GET["SignPDF"])){
	//1. Get Generated PDF
	$id = $_GET["SignPDF"];
	$pdf = pdfToBase64("https://pdfmyurl.com/api?license=dj8C54zM3GCi&url=https://epink.health/prescription/55");
	$signature = 'iVBORw0KGgoAAAANSUhEUgAAAMgAAADIBAMAAABfdrOtAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAGUExURf///wAAAFXC034AAAAJcEhZcwAADsMAAA7DAcdvqGQAAAF5SURBVHja7ZpbjgIxDATjGzj3v+zCQCYRaLWbEd0SVpUQX0BN4rzs0AAAAAAAAAAAAOCLSYMjkOyQDkk3OCIckjIhcUiiVZGkQRKtiiQNkjheYhLJBtFMEvngyiqSaFUk2QyDyyGJZpAkkg1imr5ckjaJJSQVJOmTaOMeDtUqCa3k8S5LTRdJWCSy6C8jOMWSYwPWzZVFImvIMoJ1ZY8Zd2FFYsZdWL+ZklRLcvZWqCRHQwySc5J0leSexAsl53Ho7K0QSeL+/L9L+gt5QRL9D14/siOZ38nb8B0NOFfiiz/79oBtxH1Wb0Zp7aP711jiR0Mekgv9vimJ/ulRfCTwS2Hlpvj8Gjb2kackVBO+L7lviiR9yX1DtHTFWo4QSXquEl21c4ZEmD44JDPuwuPKlKhPEuIj0bn/Kh3P7KdLr+YcV3KWS+U6EkKyQ507ZYOjzNAq0xDL/y4cjipTpBdxEPQNCPqGI3H8V9EtxywAAAAAAAAAANijtR8j2RFPzU7DhgAAAABJRU5ErkJggg==';
	sleep(3);
	if($pdf != null){
		$SignatureDetails = array('visibility' => true, 'x1' => 300, 'y1' => 20, 'x2' => 500, 'y2' => 100, 'pageNo' => '1', 'pdfInBase64' => $pdf, 'sigImageInBase64' => $signature);
		$requestParameters = array('RequestID'=> 1, 'UserID'=> "930213115305", 'FullName' => 'MUHAMMAD FAQIHUDDIN BIN AZMAN', 'AuthFactor' => 'testpin88', 'SignatureInfo' => $SignatureDetails);
		$result = $client->SignPDF($requestParameters);
		$response = json_encode($result->return);
		$res = $result->return;
		$pdfe = $res->signedPdfInBase64;
		$file = base64_decode($pdfe);
		$filename = rand(10000, 1000000).uniqid();
		file_put_contents($filename.'-signed.pdf',$file);
		echo $filename.'-signed.pdf';
	}else{
		echo 'Fail to load PDF file';
	}
	
	//saveResponse($response, $id);
}
if(isset($_GET["SignPDFWithQRCode"])){
	$id = $_GET["SignPDFWithQRCode"];
	$requestParameters = array('RequestID'=> 0, 'UserID'=> "8802082125493", 'FullName' => 'Ananta Teor bin Albert', 'AuthFactor' => 'none', 'SignatureInfo' => 'test', 'visibility' => true, 'x1' => 0, 'y1' => 0, 'x2' => 0, 'y2' => 0, 'pageNo' => '1', 'pdfInBase64' => 'test', 'sigImageInBase64' => 'test',);
	$result = $client->SignPDFWithQRCode($requestParameters);
	$response = json_encode($result->return);
	echo $response;
	//saveResponse($response, $id);
}

if(isset($_GET["VerifyPDFSignature"])){
	$id = $_GET["VerifyPDFSignature"];
	$requestParameters = array('UserID'=> "8802082125493", 'FullName' => 'Ananta Teor bin Albert', 'AuthFactor' => 'none', 'SignatureInfo' => 'test', 'visibility' => true, 'x1' => 0, 'y1' => 0, 'x2' => 0, 'y2' => 0, 'pageNo' => '1', 'pdfInBase64' => 'test', 'sigImageInBase64' => 'test', 'SignedPdfInBase64' => $samplebase64pf);
	$result = $client->VerifyPDFSignature($requestParameters);
	$response = json_encode($result->return);
	echo $response;
	//saveResponse($response, $id);
}

if(isset($_GET["GetCertInfo"])){
	$id = $_GET["GetCertInfo"];
	$requestParameters = array('UserID'=>'930213115305');
	$result = $client->GetCertInfo($requestParameters);
	$response = json_encode($result->return);
	echo $response;
	//saveResponse($response, $id);
}

if(isset($_GET["RevokeCert"])){
	$id = $_GET["RevokeCert"];
	$requestParameters = array('UserID' => '880208125493', 'CertSerialNo'=> 'test');
	$result = $client->RevokeCert($requestParameters);
	$response = json_encode($result->return);
	echo $response;
	//saveResponse($response, $id);
}

if(isset($_GET["ResetCertificatePin"])){
	$id = $_GET["ResetCertificatePin"];
	$requestParameters = array('UserID' => '880208125493', 'CertSerialNo'=> 'test', 'NewPin'=>'123');
	$result = $client->ResetCertificatePin($requestParameters);
	$response = json_encode($result->return);
	echo $response;
	//saveResponse($response, $id);
}
//var_dump($client->__getLastRequestHeaders());
//var_dump($client->__getLastResponseHeaders());
//var_dump($client->__getLastResponse());
?>


