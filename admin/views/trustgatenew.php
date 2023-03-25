
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
					<li class="breadcrumb-item active">Version 2</li>
				</ol>
			</div>
		</div>
	</div>
	<!-- /.container-fluid -->
	<div class="container-fluid">
	<?php
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
	$soapurl = "http://103.233.2.69:8080/MTSA/MyTrustSignerAgentWSHC?wsdl";
	$username = 'epink';
	$password = 'nZCNPZT64qD23cb6';
	
	/*$username = 'epink_pilot';
	$password = 'YcuLxvMMcXWPLRaw';
	$soapurl = "http://103.233.2.69:8080/MTSAPilot/MyTrustSignerAgentWSHC?wsdl"; */
	
	$context = array('http' =>
		array(
		  'header'  => "Username: ".$username."\r\n" . "Password: ".$password."\r\n"
		)
	);
	$soapParameters = array('Username' => $username, 'Password' => $password, 'trace'=> 1, 'stream_context' => stream_context_create($context), 'soap_version' => SOAP_1_1);
	
	$client = new SoapClient($soapurl, $soapParameters);
	$requestid = cleanInput($page_identifier_action);
	$sqlv = "SELECT * FROM accounts_verification WHERE id='$requestid'";
	$resultv = $db->query($sqlv);
	if ($resultv->num_rows > 0) {
		$rowv = $resultv->fetch_assoc();
		$oid = $rowv["owner"];
		//Prepare user info
		$sqlu = "SELECT * FROM users WHERE id='$oid'";
		$resultu = $db->query($sqlu);
		$rowu = $resultu->fetch_assoc();
		$FullName = $rowu["fullname"];
		$orgName = $rowu["organization_name"];
		$orgUserDesignation = $rowu["organization_designation"];
		$orgAddress = $rowu["organization_address"];
		$orgAddressCity =  $rowu["organization_city"];
		$orgAddressState =  $rowu["organization_state"];
		$orgAddressPostcode =  $rowu["organization_postcode"];
		$orgAddressCountry = 'MY';
		$orgRegistationNo = '';
		$orgPhoneNo = '';
		$orgFaxNo = '';
		$OrganisationInfo = array('orgName' => $orgName,'orgUserDesignation' => $orgUserDesignation, 'orgAddress' => $orgAddress,'orgAddressCity' => $orgAddressCity,'orgAddressState' => $orgAddressState,'orgAddressPostcode' => $orgAddressPostcode,'orgAddressCountry' => $orgAddressCountry,'orgRegistationNo' => $orgRegistationNo,'orgPhoneNo' => $orgPhoneNo,'orgFaxNo' => $orgFaxNo,);
		$UserID = $rowu["ic_number"];
		$IDType = "N";
		$Nationality = 'MY';
		$EmailAddress = $rowu["email"];
		$MobileNo = $rowu["phonenumber"];
		$CertValidity = 'L';
		$Designation =  $rowu["organization_designation"];
		$MembershipNo =  $rowv["apc_number"];
		$DegreeCert = pdfToBase64($rowv["education_certification"]);
		sleep(3);
		$PassportImage = "";
		$NRICFront = imgToBase64($rowv["ic_font"]);
		sleep(3);
		$NRICBack = imgToBase64($rowv["ic_back"]);
		sleep(3);
		$requestParameters = array('UserID' => $UserID, 'IDType' => $IDType, 'FullName' => $FullName, 'Nationality' => $Nationality, 'EmailAddress' => $EmailAddress, 'MobileNo' => $MobileNo, 'CertValidity' => $CertValidity,'Designation' => $Designation, 'MembershipNo' => $MembershipNo, 'DegreeCert' => $DegreeCert, 'PassportImage' => $PassportImage, 'NRICFront' => $NRICFront, 'NRICBack' => $NRICBack, 'OrganisationInfo' => $OrganisationInfo,);
		
		$trustgate_requestsql = "SELECT * FROM trustgate_request WHERE owner='$oid'";
		$trustgate_requestresult = $db->query($trustgate_requestsql);
		if ($trustgate_requestresult->num_rows > 0){
			$succees = false;
			$linksent = false;
			$allstat = '';
			$certrequestid = '';
			
			while($rowzzz = $trustgate_requestresult->fetch_assoc()) {
				$allstat .= '<p>Request Id: '.$rowzzz["id"].' - Status Code: '.$rowzzz["status_code"].' - Status Message: '.$rowzzz["statusMsg"].' <br>Cert Request Id = '.$rowzzz["	certRequestID"].'</p>';
				$certrequestid = $rowzzz["certRequestID"];
				if($rowzzz["status_code"] == "000"){
					$succees = true;
					$certrequestid = $rowzzz["certRequestID"];
				}else{
					
				}
				if($rowzzz["url"] != ""){
					$linksent = true;
				}
			}
			
			if($succees == true){
				$certrequestParameters = array('UserID' => $UserID);
				$certresult = $client->GetCertInfo($certrequestParameters);
				$certresponse = json_encode($certresult->return);
				$resultsCert = $certresponse->return;
				$statCodeCert = $certresponse->statusCode;
				$statusMsgCert = $certresponse->statusMsg;
				$requestdataCert = $certresponse->dataList;
				$tempcertStats = $statCodeCert;
				$verifiedstatus = "Verified";
				if($linksent == false){
					$action = '
					<a href="'.$domain.'/trustgate-new/'.$requestid.'/?activattion-link" class="btn btn-primary">Send Activation Link</a>';
				}else{
					$action = 'Activation link sent to user';
				}
				
			}else{
				$verifiedstatus = $certrequestid;
				$action = '
				<a href="'.$domain.'/trustgate-new/'.$requestid.'/?retry" class="btn btn-primary">Retry</a>';
			}
			if(isset($_GET["activattion-link"])){
				$linksent = false;
				if($linksent == false){
					$requestParameters = array('RequestID'=> $certrequestid, 'UserID' => $UserID,);
					$result = $client->GetActivation($requestParameters);
					$response = json_encode($result->return);
					$results = $result->return;
					$statCode = $results->statusCode;
					$statusMsg = $results->statusMsg;
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
							if($statCode == 000){
								$sqltrust = "UPDATE accounts_verification SET trustgate_link='$activationlink' WHERE  id='$requestid' ";

								if ($db->query($sqltrust) === TRUE) {
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
							
						} else {
							$row["card"] = "red";
							$row["status"] = "Fail";
							$row["message"] =  "Error: " . $sql . "
	<br>" . $db->error;
							$data = $row;
						}
				}else{
					$allstat .= "WTF";
				}
	
			}
			if(isset($_GET["get-status"])){
					$requestParameters = array('requestID'=> $certrequestid, 'userID' => $UserID,);
					$finalparameter = array('UserRequestList'=>$requestParameters,);
					$result = $client->GetRequestStatus($finalparameter);
					$json = json_encode($result->return);
					$response = json_encode($result->return);
					$results = $result->return;
					$statCode = $results->statusCode;
					$statusMsg = $results->statusMsg;
					$dataList = $results->dataList;
					$requestStatus = $dataList->requestStatus;
					$requestdata = $results->dataList;
					$statusMsg = $statusMsg.'-'.$requestdata->requestStatus;
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
			if(isset($_GET["certinfo"])){
					
					$requestParameters = array('UserID' => $UserID);
					$result = $client->GetCertInfo($requestParameters);
					$response = json_encode($result->return);
					$results = $result->return;
					$statCode = $results->statusCode;
					$statusMsg = $results->statusMsg;
					$requestdata = $results->dataList;
					$trustgate_requestsql = "INSERT INTO trustgate_request (certRequestID, rtype, statusMsg, userID, owner, status_code, url)
					VALUES ('$certrequestid', 'Request Status', '$statusMsg', '$UserID', '$oid', '$statCode', '$url')";
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
			if(isset($_GET["retry"])){
				if($success == true){
					
				}else{
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
					$responsedecode = json_decode($response);
					$owner = $oid;
					$rtype = "Verification Requst";
					$trustgate_requestsql = "INSERT INTO trustgate_request (certRequestID, rtype, statusMsg, userID, owner, status_code, url, responsedata)
					VALUES ('$certRequestID', '$rtype', '$statusMsg', '$userID', '$owner', '$statCode', '', '$responsedecode')";
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
			}
			
			
		} else {
			if(isset($_GET["start"])){
					$json = json_encode($requestParameters);
					$organizationjson = json_encode($OrganisationInfo);
					//$result = $client->RequestCertificateForHealthcare($requestParameters);
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
					$responsedecode = json_decode($response);
					$owner = $oid;
					$rtype = "Verification Requst";
					$trustgate_requestsql = "INSERT INTO trustgate_request (certRequestID, rtype, statusMsg, userID, owner, status_code, url, responsedata)
					VALUES ('$certRequestID', '$rtype', '$statusMsg', '$userID', '$owner', '$statCode', '', '$responsedecode')";
					if ($db->query($trustgate_requestsql) === TRUE) {
						$row["card"] = "green";
						$row["status"] = "Successful";
						$row["message"] =  "New record successfully created";
						$data = $row;
						$verifiedstatus = 'Requested';
					} else {
						$row["card"] = "red";
						$row["status"] = "Fail";
						$row["message"] =  "Error: " . $sql . "
			<br>" . $db->error;
						$data = $row;
						$verifiedstatus = 'Fail to save process';
					}
			}else{
				$action = '
				<a href="'.$domain.'/trustgate-new/'.$requestid.'/?start" class="btn btn-primary">Begin Trustgate Verification</a>';
			}
			//Start request
		}
	}
	
	?>
		Debug Data
		<div id=""><pre><?php var_dump($response); ?></pre></div>
		<div class="row">
			<div class="col-6 col-xs-12">
				
				<p>
					<b>Requesting for ( <?php echo $rowu["id"]; ?> )</b>
				</p>
				<form method="POST">
				<p>Fullname </p>
				<input type="text" value="<?php echo $FullName; ?>" id="fullname" name="fullname"><br>
				<input type="text" value="<?php echo $rowu["id"]; ?>" id="uid" name="uid" hidden>
				<button class="btn btn-primary" type="submit" name="updatename">Update</button>
				</form>
				<p>
					<b>IC</b>
				</p>
				<p> <?php echo $UserID; ?> </p>
				<p>
					<b>IC - Front</b>
				</p>
				<p>
					<img id="icfton" src="
						<?php echo $rowv["ic_font"]; ?>" width="200px">
				</p>
				<form method="POST" action="https://epink.health/admin/trustgate-new/
					<?php echo $requestid; ?>">
					<div class="form-group">
						<input type="file" id="file" onchange="processFile(this, 	'base64icfton', 'icfton')">
						<input type="text" id="base64icfton" name="base64icfton" hidden>
					</div>
					<button class="btn btn-primary" type="submit" name="uploadIcFront">Update</button>
				</form>
				<p>
					<b>IC - Back</b>
				</p>
				<p>
					<img id="icback" src="
						<?php echo $rowv["ic_back"]; ?>" width="200px">
				</p>
				<input type="file" id="file" onchange="processFile(this, 'base64icfback', 'icback')">
				<form method="POST" action="https://epink.health/admin/trustgate-new/
					<?php echo $requestid; ?>">
					<div class="form-group">
						<input type="text" id="base64icfback" name="base64icfback" hidden class="form-control">
					</div>
					<button class="btn btn-primary" type="submit" name="uploadIcback">Update</button>
				</form>
				<p>
					<b>Education Certificate</b>
				</p>
				<embed src="<?php echo $rowv["education_certification"]; ?>" width="100%" height="25%" />
				<p>
					<a href="
						<?php echo $rowv["education_certification"]; ?>" target="_blank">View </a>
				</p>
				
				<input type="file" id="file" onchange="processPdf(this, 'base64degree', null)" >
				<form method="POST" action="https://epink.health/admin/trustgate-new/
					<?php echo $requestid; ?>/">
					<div class="form-group">
						<input type="text" id="base64degree" name="base64degree" hidden  class="form-control">
					</div>
					<button class="btn btn-primary" type="submit" name="uploadDegree">Update</button>
				</form>
				<br>
				<p>
					<b>APC Certificate</b>
				</p>
				<embed src="<?php echo $rowv["apc_file"]; ?>" width="100%" height="25%" />
				<p>
					<a href="
						<?php echo $rowv["apc_file"]; ?>" target="_blank">View </a>
				</p>
				<input type="file" id="file" onchange="processPdf(this, 'base64apc', null)" >
				<form method="POST" action="https://epink.health/admin/trustgate-new/
					<?php echo $requestid; ?>/">
					<div class="form-group">
						<input type="text" id="base64apc" name="base64apc"  class="form-control" hidden>
					</div>
					<button class="btn btn-primary" type="submit" name="uploadApc">Update</button>
				</form>
				
			</div>
			<div class="col-6 col-xs-12" >

				<div class="card">
					<div class="card-header">
						<b>All request history - <?php echo $verifiedstatus; ?> </b>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col s1 strong"> Id </div>
							<div class="col s3 strong"> Type </div>
							<div class="col s5 strong"> StatusMsg </div>
							<div class="col s3 strong"> Status code </div>
						</div>
						<?php
							$trustgate_requestsql = "SELECT * FROM trustgate_request WHERE owner='$oid' AND rtype!='Request Status'";
							$trustgate_requestresult = $db->query($trustgate_requestsql);
							
							if ($trustgate_requestresult->num_rows > 0) {
							 
							    while($trustgate_requestobject = $trustgate_requestresult->fetch_assoc()) {
									echo '
																								<div class="row">';
									echo ' 
									
									
											
																									<div class="col s1 strong">
												'.$trustgate_requestobject["id"].'
											</div>
																									<div class="col s3 strong">
												'.$trustgate_requestobject["rtype"].'
											</div>
																									<div class="col s5 strong">
												'.$trustgate_requestobject["certRequestID"].' - '.$trustgate_requestobject["statusMsg"].'
											</div>
																									<div class="col s3 strong">
												'.$trustgate_requestobject["status_code"].'
											</div>
											
							
											
									
									';
									
									echo '
																								</div>';
							    }
								
							} else {
							    echo "No result";
							}
							?>
					</div>
					<div class="card-footer"> <?php echo $action; ?> </div>
				</div>
									<div class="card">
					<div class="card-header">
					Actions</div>
					<div class="card-body">
					<a href="<?php echo $domain; ?>/trustgate-new/<?php echo $requestid; ?>/?start" class="btn btn-primary">Request Certrificate</a> 
					<a href="<?php echo $domain; ?>/trustgate-new/<?php echo $requestid; ?>/?activattion-link" class="btn btn-primary">Get Activation Link</a> 
					<a href="<?php echo $domain; ?>/trustgate-new/<?php echo $requestid; ?>/?get-status" class="btn btn-primary">Get Status</a>
					
					</div>
					</div>
				<div class="card">
					<div class="card-header">
						<b>Get Status</b>
					</div>
					<div class="card-body"> <?php
						$trustgate_requestsql = "SELECT * FROM trustgate_request WHERE owner='$oid' AND rtype='Request Status'";
						$trustgate_requestresult = $db->query($trustgate_requestsql);
						
						if ($trustgate_requestresult->num_rows > 0) {
						 
						    while($trustgate_requestobject = $trustgate_requestresult->fetch_assoc()) {
								echo '
																							<div class="row">';
								echo ' 
								
								
										
																								<div class="col s1 strong">
											'.$trustgate_requestobject["id"].'
										</div>
																								<div class="col s3 strong">
											'.$trustgate_requestobject["rtype"].'
										</div>
																								<div class="col s5 strong">
											'.$trustgate_requestobject["statusMsg"].'
										</div>
																								<div class="col s3 strong">
											'.$trustgate_requestobject["status_code"].'
										</div>
										
						
										
								
								';
								
								echo '
																							</div>';
						    }
							
						} else {
						    echo "No result";
						}
						?> </div>
					<div class="card-footer">
						<a href="https://epink.health/admin/trustgate-new/
							<?php echo $requestid; ?>/?get-status" class="btn btn-primary">Check Status </a>
					</div>
				</div>
				<div class="card" >
					<div class="card-header">
						<b>Activate User</b>
					</div>
					<div class="card-body">
						<?php
						$tempresult = $certresult->return;
						
						if($tempresult->statusCode == "GC100"){
							echo 'User havent activate his/her pin number';
						}else{
							echo '<a href="https://epink.health/admin/verification-request/approve/'.$requestid.'/">Activate Account </a>';
						}
						?>
					</div>
				</div>
			
			</div>
		</div>
		<div id="action"></div>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
</section>
<!-- /.content -->
</div>
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