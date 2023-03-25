<?php
	$requestid = cleanInput($page_identifier_action);
	if(isset($_POST["fullname"])){
		$fullname = cleanInput($_POST["fullname"]);
		$uid = cleanInput($_POST["uid"]);
		$sql = "UPDATE users SET fullname='$fullname' WHERE id='$uid'";
		if ($db->query($sql) === TRUE) {
			$row["card"] = "green";
			$row["status"] = "Successfull";
			$row["message"] = "The record has been updated successfully";
			$data = $row;
		} else {
			$row["card"] = "red";
			$row["status"] = "Fail";
			$row["message"] = "Error updating record: " . $db->error;
			$data = $row;
		}
	}
	if(isset($_GET["reset"])){
		$sql = "UPDATE accounts_verification SET trustgate_status = 0 WHERE id='$requestid' ";
		if ($db->query($sql) === TRUE) {
			$row["card"] = "green";
			$row["status"] = "Successfull";
			$row["message"] = "The record has been updated successfully";
			$data = $row;
		} else {
			$row["card"] = "red";
			$row["status"] = "Fail";
			$row["message"] = "Error updating record: " . $db->error;
			$data = $row;
		}
	}
	if(isset($_POST["uploadDegree"])){
		$education_certification = processFile($_POST["base64degree"]);
		$requestid = cleanInput($page_identifier_action);
		$sql = "UPDATE accounts_verification SET education_certification='$education_certification' WHERE id='$requestid' ";
		if ($db->query($sql) === TRUE) {
			$row["card"] = "green";
			$row["status"] = "Successfull";
			$row["message"] = "The record has been updated successfully";
			$data = $row;
		} else {
			$row["card"] = "red";
			$row["status"] = "Fail";
			$row["message"] = "Error updating record: " . $db->error;
			$data = $row;
		}
	}
	if(isset($_POST["uploadApc"])){
		$apc_file = processFile($_POST["base64apc"]);
		$requestid = cleanInput($page_identifier_action);
		$sql = "UPDATE accounts_verification SET apc_file='$apc_file' WHERE id='$requestid' ";
		if ($db->query($sql) === TRUE) {
			$row["card"] = "green";
			$row["status"] = "Successfull";
			$row["message"] = "The record has been updated successfully";
			$data = $row;
		} else {
			$row["card"] = "red";
			$row["status"] = "Fail";
			$row["message"] = "Error updating record: " . $db->error;
			$data = $row;
		}
	}
	if(isset($_POST["uploadIcback"])){
		$ic_back = processFile($_POST["base64icfback"]);
		$requestid = cleanInput($page_identifier_action);
		$sql = "UPDATE accounts_verification SET ic_back='$ic_back' WHERE id='$requestid' ";
		if ($db->query($sql) === TRUE) {
			$row["card"] = "green";
			$row["status"] = "Successfull";
			$row["message"] = "The record has been updated successfully";
			$data = $row;
		} else {
			$row["card"] = "red";
			$row["status"] = "Fail";
			$row["message"] = "Error updating record: " . $db->error;
			$data = $row;
		}
	}
	if(isset($_POST["uploadIcFront"])){
		$ic_front = processFile($_POST["base64icfton"]);
		$requestid = cleanInput($page_identifier_action);
		$sql = "UPDATE accounts_verification SET ic_font='$ic_front' WHERE id='$requestid' ";
		if ($db->query($sql) === TRUE) {
			$row["card"] = "green";
			$row["status"] = "Successfull";
			$row["message"] = "The record has been updated successfully";
			$data = $row;
		} else {
			$row["card"] = "red";
			$row["status"] = "Fail";
			$row["message"] = "Error updating record: " . $db->error;
			$data = $row;
		}
	}
	$soapurl = "http://103.233.2.69:8080/MTSA/MyTrustSignerAgentWSHC?wsdl";
	$username = 'epink';
	$password = 'nZCNPZT64qD23cb6';
	$context = array('http' =>
		array(
		  'header'  => "Username: ".$username."\r\n" . "Password: ".$password."\r\n"
		)
	);
	$soapParameters = array('Username' => $username, 'Password' => $password, 'trace'=> 1, 'stream_context' => stream_context_create($context), 'soap_version' => SOAP_1_1);
	$client = new SoapClient($soapurl, $soapParameters);
	
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
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>Trustgate Verification</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item active"><a href="<?php echo $domain; ?>/trustgate/<?php echo $requestid; ?>/?reset=true">Reset</a></li>
				</ol>
			</div>
		</div>
	</div>
	<!-- /.container-fluid -->
	<div class="container-fluid">
<?php
	
	$sqlv = "SELECT * FROM accounts_verification WHERE id='$requestid'";
	$resultv = $db->query($sqlv);
	if ($resultv->num_rows > 0) {
		$application = $resultv->fetch_assoc();
		
		$ownerid = $application["owner"];
		$sqlowner = "SELECT * FROM users WHERE id='$ownerid'";
		$resultowner = $db->query($sqlowner);
		$owner = $resultowner->fetch_assoc();
		$orgName = $owner["organization_name"];
		$orgUserDesignation = $owner["organization_designation"];
		$orgAddress = $owner["organization_address"];
		$orgAddressCity =  $owner["organization_city"];
		$orgAddressState =  $owner["organization_state"];
		$orgAddressPostcode =  $owner["organization_postcode"];
		$orgAddressCountry = 'MY';
		$orgRegistationNo = '';
		$orgPhoneNo = '';
		$orgFaxNo = '';
		$OrganisationInfo = array('orgName' => $orgName,'orgUserDesignation' => $orgUserDesignation, 'orgAddress' => $orgAddress,'orgAddressCity' => $orgAddressCity,'orgAddressState' => $orgAddressState,'orgAddressPostcode' => $orgAddressPostcode,'orgAddressCountry' => $orgAddressCountry,'orgRegistationNo' => $orgRegistationNo,'orgPhoneNo' => $orgPhoneNo,'orgFaxNo' => $orgFaxNo,);
		$FullName = $owner["fullname"];
		$UserID = $owner["ic_number"];
		$IDType = "N";
		$Nationality = 'MY';
		$EmailAddress = $owner["email"];
		$MobileNo = $owner["phonenumber"];
		$CertValidity = 'L';
		$Designation =  $owner["organization_designation"];
		$MembershipNo =  $application["apc_number"];
		
		
		if(isset($_GET["start"])){
			$DegreeCert = pdfToBase64($application["education_certification"]);
			sleep(3);
			$PassportImage = "";
			$NRICFront = imgToBase64($application["ic_font"]);
			sleep(3);
			$NRICBack = imgToBase64($application["ic_back"]);
			sleep(3);
			$requestParameters = array('UserID' => $UserID, 'IDType' => $IDType, 'FullName' => $FullName, 'Nationality' => $Nationality, 'EmailAddress' => $EmailAddress, 'MobileNo' => $MobileNo, 'CertValidity' => $CertValidity,'Designation' => $Designation, 'MembershipNo' => $MembershipNo, 'DegreeCert' => $DegreeCert, 'PassportImage' => $PassportImage, 'NRICFront' => $NRICFront, 'NRICBack' => $NRICBack, 'OrganisationInfo' => $OrganisationInfo,);
			$json = json_encode($requestParameters);
			$organizationjson = json_encode($OrganisationInfo);
			$result = $client->RequestCertificateForHealthcare($requestParameters);
			$response = json_encode($result->return);
			$results = $result->return;
			$statusMsg = $results->statusMsg;
			$certRequestID = $results->certRequestID;
			$userID = $results->userID;
			$certRequestID = $results->certRequestID;
			$statusMsg = $results->statusMsg;
			$userID = $results->userID;
			$statCode = $results->statusCode;
			$verifiedstatus = $results->statusCode;
			$responsedecode = json_encode($response);
			$res = $statCode;
			$ownerid = $ownerid;
			$rtype = "Verification Requst";
			$trustgate_requestsql = "INSERT INTO trustgate_request (certRequestID, rtype, statusMsg, userID, owner, status_code, url, responsedata)
			VALUES ('$certRequestID', '$rtype', '$statusMsg', '$userID', '$ownerid', '$statCode', '', '$responsedecode')";
			if ($db->query($trustgate_requestsql) === TRUE) {
				$row["card"] = "green";
				$row["status"] = "Successful";
				$row["message"] =  "New record successfully created";
				$data = $row;
				$verifiedstatus = 'Requested';
				if($certRequestID != null){
					$sqlxu = "UPDATE accounts_verification SET trustgate_certRequestID='$certRequestID', trustgate_userID='$userID' WHERE id='$requestid'";
					$db->query($sqlxu);
				}
				if($statCode == 000 || $statCode == "000"){
					$sqlxu = "UPDATE accounts_verification SET trustgate_status='1' WHERE id='$requestid'";
					$db->query($sqlxu);
					$res = "File sent successfully";
				}
				if($statCode == "WS119"){
					$res = "File too big. Please lower the file resolutions";
					$sqlxu = "UPDATE accounts_verification SET trustgate_status='0' WHERE id='$requestid'";
					$db->query($sqlxu);
				}
			} else {
				$row["card"] = "red";
				$row["status"] = "Fail";
				$row["message"] =  "Error: " . $sql . "<br>" . $db->error;
				$data = $row;
				$verifiedstatus = 'Fail to save process';
			}
		}
			if(isset($_GET["continue"])){
					$certrequestid = $application["trustgate_certRequestID"];
					$certuserid = $application["trustgate_userID"];
					$requestParameters = array('RequestID'=> $certrequestid, 'UserID' => $UserID,);
					$result = $client->GetActivation($requestParameters);
					//$res = json_encode($result);
					$response = json_encode($result->return);
					$results = $result->return;
					$statCode = $results->statusCode;
					$statusMsg = $results->statusMsg;
					$res = $statCode;
					$activationlink = $results->activationLink;
					$statusmessage = 'Activation Link Status - '.$statusMsg;
					$urlsz = $activationlink;
					$rtype = "Activation Link";
					$trustgate_requestsql = "INSERT INTO trustgate_request (rtype, certRequestID, statusMsg, userID, owner, status_code, url)
					VALUES ('$rtype', '$certrequestid', '$statusmessage', '$UserID', '$oid', '$statCode', '$urlsz')";
						if ($db->query($trustgate_requestsql) === TRUE) {
							$row["card"] = "green";
							$row["status"] = "Successful";
							$row["message"] =  "New record successfully created";
							$data = $row;
							if($statCode == "000" || $statCode == 000){
								$sqltrust = "UPDATE accounts_verification SET trustgate_link='$activationlink', trustgate_status = '2' WHERE  id='$requestid' ";

								if ($db->query($sqltrust) === TRUE) {
									$row["card"] = "green";
									$row["status"] = "Successfull";
									$row["message"] = "The record has been updated successfully";
									$data = $row;
									$res = 'Successfull. Activation link sent to the user app';
								} else {
									$row["card"] = "red";
									$row["status"] = "Fail";
									$row["message"] = "Error updating record: " . $db->error;
									$data = $row;
								}
							}else{
								//$res = $statusMsg;
							}
							
						} else {
							$row["card"] = "red";
							$row["status"] = "Fail";
							$row["message"] =  "Error: " . $sql . "
							<br>" . $db->error;
							$data = $row;
							$res = $row["message"];
						}
				
	
			}
			if(isset($_GET["status"])){
				
					$certrequestid = $application["trustgate_certRequestID"];
					$certuserid = $application["trustgate_userID"];
					$requestParameters = array('requestID'=> $certrequestid, 'userID' => $certuserid,);
					$finalparameter = array('UserRequestList'=>$requestParameters,);
					$result = $client->GetRequestStatus($finalparameter);
					$json = json_encode($result->return);
					$response = json_encode($result->return);
					
					$results = $result->return;
					$statCode = $results->statusCode;
					$statusMsg = $results->statusMsg;
					$res = $results->requestStatus;
					$dataList = $results->dataList;
					$requestStatus = $dataList->requestStatus;
					$requestStatusCode = $dataList->statusCode;
					$requestdata = $results->dataList;
					$statusMsg = $requestdata->requestStatus;
					$res = $statusMsg;
					if($res == "Pending Activation"){
						$res = "Waiting for the user to activate his/her account via the link provided to her";
					}
					if($res == "Completed"){
						$sqltrust = "UPDATE accounts_verification SET trustgate_status = '3' WHERE  id='$requestid' ";

						if ($db->query($sqltrust) === TRUE) {
							$row["card"] = "green";
								$row["status"] = "Successfull";
								$row["message"] = "The record has been updated successfully";
								$data = $row;
								$res = 'Successfull. Activation link sent to the user app';
						} else {
								$row["card"] = "red";
								$row["status"] = "Fail";
								$row["message"] = "Error updating record: " . $db->error;
								$data = $row;
						}
					}
					//$res = $results->dataList;
					$trustgate_requestsql = "INSERT INTO trustgate_request (certRequestID, rtype, statusMsg, userID, owner, status_code, responsedata)
					VALUES ('$certrequestid', 'Request Status', '$statusMsg', '$UserID', '$oid', '$statCode', '$json')";
					if ($db->query($trustgate_requestsql) === TRUE) {
						$row["card"] = "green";
						$row["status"] = "Successful";
						$row["message"] =  "New record successfully created";
						$data = $row;
						
					} else {
						$row["card"] = "red";
						$row["status"] = "Fail";
						$row["message"] =  "Error: " . $sql . "
	<br>" . $db->error;
						$data = $row;
					}
					
			}
		
	}else{
		echo 'Not found';
	}
?>
<?php
if(isset($res)){
	echo'
	<div class="card">
		<div class="card-body">
			'.$res.'
		</div>
	</div>
	';
}
?>
<div id="stepone" class="card">
	<div class="card-body">
		<h4>1. Check information</h4>
		<p>Please check all the information provided by the requester.</p>
		<form method="POST">
			<p><b>Fullname</b></p>
			<input type="text" value="<?php echo $FullName; ?>" id="fullname" name="fullname" class="form-control"><br>
			<input type="text" value="<?php echo $owner["id"]; ?>" id="uid" name="uid" hidden>
			<p class="text-sm">Make sure the user name follow identification card</p>
			<button class="btn btn-primary" type="submit" name="updatename">Update</button>
		</form>
		<br>
		<p><b>IC - Front</b></p>
		<img id="icfton" src="<?php echo $application["ic_font"]; ?>" width="200px">
		<form method="POST" action="https://epink.health/admin/trustgate/<?php echo $requestid; ?>">
			<div class="form-group">
				<input type="file" id="file" onchange="processFile(this, 'base64icfton', 'icfton')" class="form-control">
				<input type="text" id="base64icfton" name="base64icfton" hidden>
			</div>
			<button class="btn btn-primary" type="submit" name="uploadIcFront">Update</button>
		</form>
				
		<br>
		<p><b>IC - Back</b></p>
		<img id="icback" src="<?php echo $application["ic_back"]; ?>" width="200px">
		
		<form method="POST" action="https://epink.health/admin/trustgate/<?php echo $requestid; ?>/">
			<div class="form-group">
				<input type="file" id="file" onchange="processFile(this, 'base64icfback', 'icback')">
				<input type="text" id="base64icfback" name="base64icfback" hidden class="form-control">
			</div>
			<button class="btn btn-primary" type="submit" name="uploadIcback">Update</button>
		</form>
		<br>
		<p><b>Education Certificate <a href="<?php echo $application["education_certification"]; ?>" target="_blank">View </a></b>
		</p>
		<embed src="<?php echo $application["education_certification"]; ?>" width="100%" height="25%" />

		<input type="file" id="file" onchange="processPdf(this, 'base64degree', null)" >
		<form method="POST" action="https://epink.health/admin/trustgate-new/<?php echo $requestid; ?>/">
			<div class="form-group">
				<input type="text" id="base64degree" name="base64degree" hidden  class="form-control">
			</div>
			<button class="btn btn-primary" type="submit" name="uploadDegree">Update</button>
		</form>		
		<br>
		<p><b>MCC Certificate <a href="<?php echo $application["apc_file"]; ?>" target="_blank">View </a></b>
		<embed src="<?php echo $application["apc_file"]; ?>" width="100%" height="25%" />
			<input type="file" id="file" onchange="processPdf(this, 'base64apc', null)" >
			<form method="POST" action="https://epink.health/admin/trustgate/<?php echo $requestid; ?>/">
				<div class="form-group">
					<input type="text" id="base64apc" name="base64apc"  class="form-control" hidden>
				</div>
				<button class="btn btn-primary" type="submit" name="uploadApc">Update</button>
			</form>		
		<br>
		<h4>2. Start verification</h4>
		<p>If all the document is true. Please start verification</p>
		<a href="<?php echo $domain; ?>/trustgate/<?php echo $requestid; ?>/?start=true" class="btn btn-primary">Start</a>
	</div>
</div>
<div id="hasactiverequest" class="card">
	<div class="card-body">
		<h4>2. Verification in progress</h4>
		<p>This user has an active request</p>
		<a href="<?php echo $domain; ?>/trustgate/<?php echo $requestid; ?>/?continue" class="btn btn-primary">Send Activation Link</a>
		 <a href="<?php echo $domain; ?>/trustgate/<?php echo $requestid; ?>/?status" class="btn btn-primary">Check status</a>
	</div>
</div>
<div id="waitingactivation" class="card">
	<div class="card-body">
		<h4>3. Waiting for user to activate account</h4>
		<p>Activation link has been sent to the user. Once verified you can activate this user.</p>
		<a href="<?php echo $domain; ?>/trustgate/<?php echo $requestid; ?>/?status">Check status</a>
	</div>
</div>

<div id="useractivated" class="card">
	<div class="card-body">
		<h4>4. User is verified by trustgate</h4>
		<p>You can now activate this user. Please remind them to setup their signature </p>
		<?php echo '<a href="https://epink.health/admin/verification-request/approve/'.$requestid.'/">Activate Account </a>'; ?>
	</div>
</div>



	</div>
</section>
</div>

<?php
if($application["trustgate_status"] == 0){
	//Have error from trust gate
	echo '
	<script>
		document.getElementById("stepone").style.display = "block"; 
		document.getElementById("hasactiverequest").style.display = "none"; document.getElementById("waitingactivation").style.display = "none";
		document.getElementById("useractivated").style.display = "none";
	</script>
	';
}elseif($application["trustgate_status"] == 1){
	//Is waiting for trust gate to verified
	echo '
	<script>
		document.getElementById("stepone").style.display = "none"; 
		document.getElementById("hasactiverequest").style.display = "block"; document.getElementById("waitingactivation").style.display = "none";
		document.getElementById("useractivated").style.display = "none";
	</script>
	';
}elseif($application["trustgate_status"] == 2){
	//Verified by trust gate dont have link to verify
	echo '
	<script>
		document.getElementById("stepone").style.display = "none"; 
		document.getElementById("hasactiverequest").style.display = "none"; document.getElementById("waitingactivation").style.display = "block";
		document.getElementById("useractivated").style.display = "none";
	</script>
	';
}elseif($application["trustgate_status"] == 3){
	//Verified by trust gate dont have link to verify
	echo '
	<script>
		document.getElementById("stepone").style.display = "none"; 
		document.getElementById("hasactiverequest").style.display = "none"; document.getElementById("waitingactivation").style.display = "none";
		document.getElementById("block").style.display = "none";
	</script>
	';
}

?>


<script>
	function processFile(element, target, imgtarget) {
	  var file1 = element.files[0];
	  var reader = new FileReader();
	  reader.onloadend = function() {
	    var checkfiletype = reader.result;
	    document.getElementById(target).value = reader.result;
	    document.getElementById(imgtarget).src = reader.result;
	  }
	  reader.readAsDataURL(file1);
	}
	function processPdf(element, target, imgtarget) {
		var file1 = element.files[0];
		var reader = new FileReader();
		reader.onloadend = function() {
			var checkfiletype = reader.result;
			var checkfiletype = reader.result;			
			if(checkfiletype.includes("image") == true){			
				document.getElementById(target).value = reader.result;
			}else if(checkfiletype.includes("application/pdf") == true){
				document.getElementById(target).value = reader.result;
			}else{
				alert("File type not allowed");
			}
		}
		reader.readAsDataURL(file1);
	}
</script>
