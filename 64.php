<?php
if(isset($_GET["url"])){
	$pdf = file_get_contents('https://epink.health/prescription/114');
	file_put_contents('./api/prescription/saved/114.pdf', $pdf);
}
?>
