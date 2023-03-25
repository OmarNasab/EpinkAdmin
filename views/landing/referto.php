<?php
require('fpds/fpdf.php');
$pid = cleanInput($page_identifier_action);
$sql = "SELECT * FROM chats WHERE id= '$pid'";
$result = $db->query($sql);

if ($result->num_rows > 0) {
	$row = $result->fetch_assoc();
	$ownerone = $row["owner_one"];
	$ownertwo = $row["owner_two"];
	$sqls = "SELECT * FROM users WHERE id='$ownerone'";
	$results = $db->query($sqls);
	$owneronedata = $results->fetch_assoc();
	$sqls = "SELECT * FROM users WHERE id='$ownertwo'";
	$results = $db->query($sqls);
	$ownertwodata = $results->fetch_assoc();
	$issueddate = $row["enddate"];
	$issuedtime = $row["endtime"];
	if($owneronedata["type"] == 0){
		$patient = $owneronedata;
		$doctor = $ownertwodata;
		$doctorname = $ownertwodata["firstname"].' '.$ownertwodata["lastname"];
		$doctorapc = $doctor["doctor_apc"];
		
	}else{
		$patient = $ownertwodata;
		$doctorname = $owneronedata["firstname"].' '.$owneronedata["lastname"];
		$doctor = $owneronedata;
		$doctorapc = $doctor["doctor_apc"];
	}
	
	$datestring = 'Date: '.$currentdatetime;
	$namestring = 'Patient Name: '.$patient["firstname"].' '.$patient["lastname"];
	$icstrong = 'Patient IC/Passport: '.$patient["ic_number"];
	$icstrong = 'Patient IC/Passport: '.$patient["ic_number"];
	$height = 'Height: '.$patient["height"];
	$weight = 'Weight: '.$patient["weight"];
	$referdata = json_decode($row["referto"]);
}
$image1 = "https://epink.health/img/epinkhealth.png";
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell( 40, 40, $pdf->Image($image1, $pdf->GetX(), $pdf->GetY(), 33.78), 0, 0, 'L', false );
$pdf->Cell(40,10,'Digital Referral letter');
$pdf->Ln();
$pdf->SetFont('Arial','B',10);
$pdf->Cell(100,10,'                                        https://epink.health');
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();

$pdf->SetFont('Arial','B',7);
$pdf->Cell(40,10,'Healthcare Facility: ');
$pdf->SetFont('Arial','', 7);
$pdf->Cell(40,10,'sasas');
$pdf->Ln();


$pdf->SetFont('Arial','B',7);
$pdf->Cell(40,10,'Consultant /Specialist: ');
$pdf->SetFont('Arial','', 7);
$pdf->Cell(40,10,'sasas');
$pdf->Ln();

$pdf->SetFont('Arial','B',7);
$pdf->Cell(40,10,'Visit Notes: ');
$pdf->SetFont('Arial','', 7);
$pdf->Cell(40,10,'sasas');
$pdf->Ln();

$pdf->SetFont('Arial','B',7);
$pdf->Cell(40,10,'Diagnosis: ');
$pdf->SetFont('Arial','', 7);
$pdf->Cell(40,10,'sasas');
$pdf->Ln();

$pdf->SetFont('Arial','B',7);
$pdf->Cell(40,10,'Reason for referral: ');
$pdf->SetFont('Arial','', 7);
$pdf->Cell(40,10,'sasas');
$pdf->Ln();

$pdf->SetFont('Arial','B',10);
$pdf->Cell(40,10,  "Issued By:");
$pdf->Ln();
$pdf->SetFont('Arial','',8);
$pdf->Cell(40,10,  "Dr. ".$doctorname);
$pdf->SetFont('Arial','',8);
$pdf->Ln(4);
$pdf->Cell(40,10,  "APC number: ".$doctorapc);
$pdf->Ln(4);
$pdf->SetFont('Arial','',8);
$pdf->Cell(40,10,  "Time: ".$issuedtime);
$pdf->Ln(4);
$pdf->SetFont('Arial','',8);
$pdf->Cell(40,10,  "Date: ".$issueddate);
$pdf->SetFont('Arial','',8);
$pdf->Ln();

$pdf->Output(); 
?>