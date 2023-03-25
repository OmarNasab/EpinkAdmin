<?php

function pdfToBase64($url){
	$pdf = file_get_contents('https://pdfmyurl.com/api?license=yourlicensekey&url='.$url);
	$pdfbase64 = base64_encode($pdf);
	return $pdfbase64;
}

function imgToBase64($url){
	$png = file_get_contents($url);
	$pngbase64 = base64_encode($png);
	return $pngbase64;
}
$pdf = file_get_contents('https://pdfmyurl.com/api?license=yourlicensekey&url=https://www.example.com');
$pdfbase64 = base64_encode($pdf);
echo $pdfbase64;
//file_put_contents('./unprocessedpdf/test.pdf', $pdf);