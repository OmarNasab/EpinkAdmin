<?php
$pilotusername = 'epink_pilot';
$pilotpassword = 'YcuLxvMMcXWPLRaw';
$soapurlpilot = "http://103.233.2.69:8080/MTSAPilot/MyTrustSignerAgentWSHC?wsdl";

$soapurl = "http://103.233.2.69:8080/MTSA/MyTrustSignerAgentWSHC?wsdl";
$username = 'epink';
$password = 'nZCNPZT64qD23cb6';



$context = array('http' =>
    array(
      'header'  => "Username: ".$username."\r\n" . "Password: ".$password."\r\n"
    )
);
//Define Parameters
$soapParameters = array('Username' => $username, 'Password' => $password, 'trace'=> 1, 'stream_context' => stream_context_create($context), 'soap_version' => SOAP_1_1);
$client = new SoapClient($soapurl, $soapParameters);
?>