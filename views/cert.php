<?php
require('fpds/fpdf.php');
$certid = cleanInput($page_identifier_action);
$sql = "SELECT * FROM care WHERE id='$certid'";
$result = $db->query($sql);
if ($result->num_rows > 0) {
	$care = $result->fetch_assoc();
	$certificate = json_decode($care["attachments"]);
	$vaccine_name = $certificate->vaccine_name;
	$vaccine_batch = $certificate->vaccine_batch;
	$expiry_date = $certificate->expiry_date;
	$dose_interval = $certificate->dose_interval;
	$vms = $certificate->vms;
	$timeslot = $certificate->time;
	$dateslot = $certificate->date;
	$place = $certificate->place;
	$vaccine_serial = $certificate->vaccine_serial;
	
	$rid = $care["requesterid"];
	$spid = $care["sp_id"];
	$num_padded = sprintf("%07d", $rid);
	$certidpadded = sprintf("%07d", $certid);
	
	$usersql = "SELECT * FROM users WHERE id='$rid'";
	$userresult = $db->query($usersql);
	$users = $userresult->fetch_assoc();
	
	$spsql = "SELECT * FROM users WHERE id='$spid'";
	$spresult = $db->query($spsql);
	$spinfo = $spresult->fetch_assoc();
	$spfullname = $spinfo["firstname"].' '.$spinfo["lastname"];
	$spapc = $spinfo["doctor_apc"];
	if($spapc == ""){
		$spapc = "Not set";
	}
	$name = $care["patientname"];
	$nationality = $care["nationality"];
	if($nationality == ""){
		$nationality = "Not set";
	}
	$industry = $care["industry"];
	if($industry == ""){
		$industry = "Not set";
	}
	$ethnicity = $care["ethnicity"];
	if($ethnicity == ""){
		$ethnicity = "Not set";
	}
	$specification = $care["specification"];
	if($specification == ""){
		$specification = "Not set";
	}
	$ic = $care["noic"];
	$phonenumber = $users["phonenumber"];
	$ic_number = $users["ic_number"];
	$address = $users["address"];
	$country = $users["country"];
	if($address == ""){
		$address = "Not set";
	}
	if($country == ""){
		$country = "Not set";
	}
	
} else {
   die("Certificate not found");
}
$image1 = "https://epink.health/img/epinkhealth.png";
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell( 40, 40, $pdf->Image($image1, $pdf->GetX(), $pdf->GetY(), 30), 0, 0, 'L', false );
$pdf->Cell(40,10,'DIGITAL CERTIFICATE for '.$vaccine_name.' VACCINATION');
$pdf->Ln();
$pdf->SetFont('Arial','',8);
$pdf->Cell(100,10,'                                         											https://wwww.epink.health');
$pdf->Ln(5);
$pdf->SetFont('Arial','',8);
$pdf->Cell(100,10,'                                         											Certtificate ID: '.$certidpadded);
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Arial','B',15);
$pdf->SetFillColor(333,71,89);
$pdf->Cell(0,6,"MAKLUMAT PENERIMA VAKSIN / VACCINEE DETAILS",0,1,'L',true);
$pdf->Ln(4);
$pdf->SetFont('Arial','',8);
$pdf->Cell(40,10,'Name');
$pdf->Ln(4);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,10, $name);
$pdf->Ln(5);
$pdf->SetFont('Arial','',8);
$pdf->Cell(40,10,'Contact Number');
$pdf->Ln(4);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,10, $phonenumber);
$pdf->Ln(5);
$pdf->SetFont('Arial','',8);
$pdf->Cell(40,10,'ePink Health User ID');
$pdf->Ln(4);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,10, $num_padded);
$pdf->Ln(5);
$pdf->SetFont('Arial','',8);
$pdf->Cell(40,10,'IC / Passport');
$pdf->Ln(4);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,10, $ic_number);
$pdf->Ln(5);
$pdf->SetFont('Arial','',8);
$pdf->Cell(40,10,'Address');
$pdf->Ln(4);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,10, $address);
$pdf->Ln(5);
$pdf->SetFont('Arial','',8);
$pdf->Cell(40,10,'Nationality');
$pdf->Ln(4);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,10, $nationality);
$pdf->Ln(5);
$pdf->SetFont('Arial','',8);
$pdf->Cell(40,10,'Ethnicity');
$pdf->Ln(4);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,10, $ethnicity);
$pdf->Ln(5);
$pdf->SetFont('Arial','',8);
$pdf->Cell(40,10,'Industry');
$pdf->Ln(4);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,10, $industry);
$pdf->Ln(5);
$pdf->SetFont('Arial','',8);
$pdf->Cell(40,10,'Special category of population:');
$pdf->Ln(4);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,10,'Not set');
$pdf->Ln(5);
$pdf->Ln();
$pdf->SetFont('Arial','B',15);
$pdf->SetFillColor(333,71,89);
$pdf->Cell(0,6," VACCINATION DETAILS",0,1,'L',true);
$pdf->Ln(5);
$pdf->SetFont('Arial','',8);
$pdf->Cell(40,10,'Healthcare Facility:');
$pdf->Ln(4);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,10,$place);
$pdf->Ln(5);
$pdf->SetFont('Arial','',8);
$pdf->Cell(40,10,'Date of Vaccination');
$pdf->Ln(4);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,10, $dateslot);
$pdf->Ln(5);
$pdf->SetFont('Arial','',8);
$pdf->Cell(40,10,'Time Slot');
$pdf->Ln(4);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,10, $timeslot);

$pdf->Ln(5);
$pdf->SetFont('Arial','',8);
$pdf->Cell(40,10,'Dosage Interval');
$pdf->Ln(4);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,10, $dose_interval);

$pdf->Ln(5);
$pdf->SetFont('Arial','',8);
$pdf->Cell(40,10,'Vaccine Serial Number');
$pdf->Ln(4);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,10, $vaccine_serial);

$pdf->Ln(5);
$pdf->SetFont('Arial','',8);
$pdf->Cell(40,10,'Vaccine Name');
$pdf->Ln(4);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,10,$vaccine_name);

$pdf->Ln(5);
$pdf->SetFont('Arial','',8);
$pdf->Cell(40,10,'Batch No');
$pdf->Ln(4);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,10, $vaccine_batch);

$pdf->Ln(5);
$pdf->SetFont('Arial','',8);
$pdf->Cell(40,10,'Expiry Date');
$pdf->Ln(4);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,10,$expiry_date);

$pdf->Ln(5);
$pdf->SetFont('Arial','',8);
$pdf->Cell(40,10,'(vaccine management system)VMS Status:');
$pdf->Ln(4);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,10,$vms);

$pdf->Ln(5);
$pdf->SetFont('Arial','',8);
$pdf->Cell(40,10,'Doctor Name');
$pdf->Ln(4);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,10, $spfullname);

$pdf->Ln(5);
$pdf->SetFont('Arial','',8);
$pdf->Cell(40,10,'Medical Officer Id');
$pdf->Ln(4);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,10,$spapc);

$pdf->Output(); 
?>