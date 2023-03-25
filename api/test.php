<?php
$string = 'Test%20&%20Test';
$string = rawUrlDecode($string);
echo $string;
?>