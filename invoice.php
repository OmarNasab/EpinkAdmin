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
		$doctorname = $ownertwodata["firstname"].' '.$ownertwodata["lastname"];
	}else{
		$patient = $ownertwodata;
		$doctorname = $owneronedata["firstname"].' '.$owneronedata["lastname"];
	}
	$datestring = 'Issued Date: '.$currentdatetime;
	$namestring = 'Patient Name: '.$patient["firstname"].' '.$patient["lastname"];
	$icstrong = 'Patient IC/Passport: '.$patient["ic_number"];
	$icstrong = 'Patient IC/Passport: '.$patient["ic_number"];
	$prescription = json_decode($row["prescription"]);
	$itemcount = count($prescription);
	
}
$image1 = "https://res.cloudinary.com/crunchbase-production/image/upload/c_lpad,f_auto,q_auto:eco,dpr_1/v1440533562/mhx0qhbidmajjwgcrxxz.png";
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell( 40, 40, $pdf->Image($image1, $pdf->GetX(), $pdf->GetY(), 33.78), 0, 0, 'L', false );
$pdf->Cell(40,10,'INVOICE');
$pdf->Ln(5);
$pdf->SetFont('Arial','',8);
$pdf->Cell(40,10,'																																																			Ananta Lab');
$pdf->Ln(4);
$pdf->Cell(40,10,'																																																			'.$currentdatetime.'');
$pdf->Ln(4);
$pdf->Cell(40,10,'																																																			INVOICE ID 00282');

$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Arial','B',10);
$pdf->Cell(40,10,'BILL TO');
$pdf->Ln(4);
$pdf->SetFont('Arial','',8);
$pdf->Cell(40,10,'Getspos Digital Signage Solution');
$pdf->Ln(4);
$pdf->Cell(40,10,'2C, Jalan Rambai 5, Paya Terubong, 11060, Penang');
$pdf->Ln(4);
$pdf->Cell(40,10,'+60124831711');


$pdf->Ln();
$pdf->SetFont('Arial','B',10);
$pdf->Ln();
$pdf->SetFont('Arial','B',10);
$pdf->Cell(40,10, 'Item																																																																																																																														Quantity																					Price');
$pdf->Ln();
$pdf->SetFont('Arial','',10);
$pdf->Cell(40,10, 'Web & App development Service Deposit																																																																									1																		RM5000.00');

$pdf->SetFont('Arial','',10);
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Cell(40,10, '																																																																																																																																												Total Price: RM5000.00');
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Arial','B',10);
$pdf->Cell(40,10,'Payment Note');
$pdf->Ln(4);
$pdf->SetFont('Arial','',8);
$pdf->Cell(40,10,'Please make a payment to Ananta Lab with the account number 25901005769 on Hong Leong Bank');
$pdf->Output(); 
?>