<?php
require('fpds/fpdf.php');
$pid = cleanInput($page_identifier_action);
$sql = "SELECT * FROM chats WHERE id= '$pid'";
$result = $db->query($sql);

if ($result->num_rows > 0) {
	$row = $result->fetch_assoc();
	$mc = json_decode($row["mcdata"]);	
	$mcfromdate = $mc->mcfrom;
	$mctodate = $mc->todate;
	$issueddate = $row["enddate"];
	$issuedtime = $row["endtime"];
	$date1 = new DateTime($mcfromdate);
	$date2 = new DateTime($mctodate);
	$days  = $date2->diff($date1)->format('%a');
	$mctodiaog = $mc->diagnosed_with;
	$ownerone = $row["owner_one"];
	$ownertwo = $row["owner_two"];
	$sqls = "SELECT * FROM users WHERE id='$ownerone'";
	$results = $db->query($sqls);
	$owneronedata = $results->fetch_assoc();
	$sqls = "SELECT * FROM users WHERE id='$ownertwo'";
	$results = $db->query($sqls);
	$ownertwodata = $results->fetch_assoc();
	
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
	$datestring = 'Date of consultation: '.$row["session_date"];
	$namestring = 'Name: '.$patient["firstname"].' '.$patient["lastname"];

	$icstrong = 'IC/Passport: '.$patient["ic_number"];	
}
$image1 = "https://epink.health/img/epinkhealth.png";
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell( 40, 40, $pdf->Image($image1, $pdf->GetX(), $pdf->GetY(), 33.78), 0, 0, 'L', false );
$pdf->Cell(40,10,'e-Medical Certificate for sick leave ');
$pdf->Ln();
$pdf->SetFont('Arial','B',10);
$pdf->Cell(100,10,'                                        https://epink.health');
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();

$pdf->SetFont('Arial','B',10);
$pdf->Cell(40,10,'DIGITAL MEDICAL CERTIFICATE FOR SICK LEAVE');
$pdf->SetFont('Arial','',8);
$pdf->Ln();
$pdf->Cell(40,10,  $namestring);
$pdf->Ln(4);
$pdf->Cell(40,10,  $icstrong);
$pdf->Ln(4);
$pdf->Cell(40,10,  $datestring);
$pdf->Ln();
$pdf->SetFont('Arial','B',10);
$pdf->Cell(40,10,  "Diagnosis:");
$pdf->Ln();
$pdf->SetFont('Arial','',8);
$pdf->Cell(40,10,  $mctodiaog);
$pdf->Ln();
$pdf->SetFont('Arial','B',10);
$pdf->Cell(40,10,  "Options:");
$pdf->Ln();
$pdf->SetFont('Arial','',8);
$pdf->Cell(40,10,  "-Incapacitated by illness from the proper performance of his or her duties from Date ".$mcfromdate."  till Date ".$mctodate." (".$days." days).");
$pdf->Ln();
$pdf->Cell(40,10,  "-Exempted from heavy duty works from date ".$mcfromdate." till ".$mctodate." (".$days." days).");
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
$pdf->Cell(40,10,  "Not valid for court case");
$pdf->Ln();
$pdf->SetFont('Arial','B',12);
$pdf->Output(); 
?>