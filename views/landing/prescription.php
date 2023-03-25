<?php
require('fpds/fpdf.php');
$pid = cleanInput($page_identifier_action);
$sql = "SELECT * FROM chats WHERE id= '$pid'";
$result = $db->query($sql);

if ($result->num_rows > 0) {
	$row = $result->fetch_assoc();
	$ownerone = $row["owner_one"];
	$ownertwo = $row["owner_two"];
	$issueddate = $row["enddate"];
	$issuedtime = $row["endtime"];
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
	
	$datestring = 'Date: '.$currentdatetime;
	$namestring = 'Patient Name: '.$patient["firstname"].' '.$patient["lastname"];
	$icstrong = 'Patient IC/Passport: '.$patient["ic_number"];
	$icstrong = 'Patient IC/Passport: '.$patient["ic_number"];
	$height = 'Height: '.$patient["height"];
	$weight = 'Weight: '.$patient["weight"];
	$prescription = json_decode($row["prescription"]);
	$itemcount = count($prescription);
	
}
$image1 = "https://epink.health/img/epinkhealth.png";
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell( 40, 40, $pdf->Image($image1, $pdf->GetX(), $pdf->GetY(), 33.78), 0, 0, 'L', false );
$pdf->Cell(40,10,'ePrescription');
$pdf->Ln();
$pdf->SetFont('Arial','B',10);
$pdf->Cell(100,10,'                                        https://epink.health');
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();

$pdf->SetFont('Arial','B',10);
$pdf->Cell(40,10,'Epink Digital Prescription');
$pdf->Ln(5);
$pdf->SetFont('Arial','', 7);
$pdf->Cell(40,10,  $datestring);
$pdf->Ln(4);
$pdf->Cell(40,10,  $namestring);
$pdf->Ln(4);
$pdf->Cell(40,10,  $icstrong);
$pdf->Ln(4);
$pdf->Cell(40,10,  $weight);
$pdf->Ln(4);
$pdf->Cell(40,10,  $height);

$pdf->Ln();
$pdf->SetFont('Arial','B',10);
$pdf->Cell(40,10,  "Prescribed Medication");


for ($x = 0; $x < $itemcount; $x++) {
		$datax = json_encode($prescription[$x]);
		$medform = $prescription[$x]->product_form;
		$medname = $prescription[$x]->name;
		$medroute = $prescription[$x]->route;
		$meddosage = $prescription[$x]->dosage;
		if($meddosage == "Dosage was not set for this item"){
			$meddosagerender = $meddosage;
		}else{
			$meddosagerender = 'Dosage: '.$meddosage.' per intake.';
		}
		
		$medintake = $prescription[$x]->intake;
		$beforeafter = $prescription[$x]->beforeafter;
		if($beforeafter == ""){
			$beforeafter = "";
			$beforeafter = 'Before / After meal';
		}else{
			$beforeafter = $beforeafter.' meal';
		}
		$intaketiming = $prescription[$x]->intaketiming;
		$intaketimingde = json_encode($prescription[$x]->intaketiming);
		if($intaketiming->Morning == true){
			$morning = 'Morning [ / ]';
		}else{
			$morning = 'Morning [   ]';
		}
		if($intaketiming->Afternoon == true){
			$Afternoon = 'Afternoon [ / ]';
		}else{
			$Afternoon = 'Afternoon [   ]';
		}
		if($intaketiming->Evening == true){
			$Evening = 'Evening [ / ]';
		}else{
			$Evening = 'Evening [   ]';
		}
		if($intaketiming->Night == true){
			$Night = 'Night [ / ]';
		}else{
			$Night = 'Night [   ]';
		}
		
		if($prescription[$x]->remark == ""){
			$medremark = 'Remarks: Not set';
		}else{
			$medremark = 'Remarks: '.$prescription[$x]->remark;
		}
		//$med = ''.$medname.' | Quantity: '.$meddosage.'  | Route: '.$medroute.' '+medintake;
		$med = ''.$medname.'('.$medform.')';
		if($medintake == "undefined"){
			$medintake = 'None';
		}
		if($medroute == "undefined" || $medroute == "undefined"){
			
		}
		$notes = 'Frequency: '.$medintake.' - Route: '.$medroute.'';
		if($medintake == "When Needed"){
			$notes = $medintake.' - '.$medroute.'';
			$timing = '';
		}else{
			
			$timing = $morning.' '.$Afternoon.' '.$Evening.' '.$Night;
		}
		
		
		$pdf->Ln(5);
		$pdf->SetFont('Arial','B',7);
		$pdf->Cell(40,10,  $med);
		$pdf->SetFont('Arial','',7);
		$pdf->Ln(4);
		$pdf->Cell(40,10,  $meddosagerender);
		$pdf->Ln(4);
		$pdf->Cell(40,10,  $notes);
		
		$pdf->Ln(4);
		$pdf->Cell(40,10,  $timing);
		$pdf->Ln(4);
		$pdf->Cell(40,10,  $beforeafter);
		$pdf->Ln(4);
		$pdf->Cell(40,10,  $medremark);
		
		
	}
$pdf->Ln();

$pdf->SetFont('Arial','B',10);
$pdf->Cell(40,10,  "Prescribed by ");
$pdf->Ln(5);
$pdf->SetFont('Arial','',8);
$pdf->Cell(40,10,  'Dr.'.$doctorname);
$pdf->Ln(4);
$pdf->Cell(40,10,  "APC number: ".$doctorapc);
$pdf->Ln(4);
$pdf->SetFont('Arial','',8);
$pdf->Cell(40,10,  "Time: ".$issuedtime);
$pdf->Ln(4);
$pdf->SetFont('Arial','',8);
$pdf->Cell(40,10,  "Date: ".$issueddate);
$pdf->SetFont('Arial','',8);
$pdf->Output(); 
?>