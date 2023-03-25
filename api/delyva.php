<?php
//DEBUG DETAIL
$delyvaurl = 'https://api.delyva.app/v1.0';

/* $user_ID = 'b2e5a220-5ea2-11ed-af50-4f3ef7f1d1c8';
$company_ID = '9e0aed8a-5c67-42a4-82b6-e01bf7687f31';
$companyCode = 'demo';
$username = 'anantateordev@gmail.com';
$password = 'password';
$accessToken = ''; */

$delyvaurl = 'https://api.delyva.app/v1.0';
$user_ID = '7c7af270-f6f7-11ec-a412-29a941f9f665';
$company_ID = 'b12b9045-82f9-40f6-9a87-cdf9bb25f281';
$customer_ID = '105310';
$companyCode = 'my';
$delyvausername = 'hello@epink.health';
$delyvapassword = 'Suthan@1889';
$accessToken = '';

$delyvaApiKey = 'dx827c5f0161a688449208feadfadef97aa493e52f';
class Delyva{
	function auth(){
		global $delyvaurl, $delyvausername, $delyvapassword, $companyCode;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $delyvaurl.'/auth/login');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		$datas = [
			'companyCode' => $companyCode,
			'username' => $delyvausername,
			'password' => $delyvapassword,
		];
		$json = json_encode($datas, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
		$headers = array();
		$headers[] = 'Content-Type: application/json';
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$result = curl_exec($ch);
		if (curl_errno($ch)) {
			echo 'Error:' . curl_error($ch);
		}else{
			$res = json_decode($result);
			$error = $res->error;
			if(isset($error->message)){
				return "error";
			}else{
				$data = $res->data;
				$data->accessToken;
				return $data->accessToken;
			}
			
		}
		curl_close($ch);
	}
	
	function getQuote($origin, $destination, $weight, $dimension){
		global $delyvaurl, $company_ID, $accessToken;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $delyvaurl.'/service/instantQuote');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		$datas["companyId"] = $company_ID;
		$datas["origin"] = $origin;
		$datas["destination"] = $destination;
		$datas["weight"] = $weight;
		$datas["dimension"] = $dimension;		
		$json = json_encode($datas, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
		$headers = array();
		$headers[] = 'Content-Type: application/json';
		$headers[] = 'Authorization: Bearer '.$accessToken.'';
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$result = curl_exec($ch);
		if (curl_errno($ch)) {
			return 'Error:' . curl_error($ch);
		}else{
			$res = json_decode($result);
			
			if($res->error != null){
				return null;
			}else{
				$courier = [];
				$data = $res->data;
				$services = $data->services;
				sleep(1);
				if($services == null){
					return $result;
					/* return null; */
				}else{
					$alength = count($services);
					for ($x = 0; $x < $alength; $x++) {
						$pricedata = $services[$x]->price;
						$distancedata = $services[$x]->distance;
						$distance = $distancedata->value;
						$distanceunit = $distancedata->unit;
						$price = $pricedata->amount;
						$currency = $pricedata->currency;
						$providerdata =  $services[$x]->service;
						$name = $providerdata->name;
						$serviceType = $providerdata->serviceType;
						$vehicleType = $providerdata->vehicleType;
						$serviceCompany = $providerdata->serviceCompany;
						$companyCode = $serviceCompany->companyCode;
						$companyId = $serviceCompany->id;
						$deliverydetail = '{"name":"'.$name.'", "description":"'.$serviceType.'", "Price":"'.$price.'", "service_code":"'.$companyCode.'", "service_id":"'.$companyCode.'"}';
						$array = json_decode($deliverydetail);
						$courier[] = $array;
					}
					return json_encode($courier, JSON_PRETTY_PRINT);
				}

				
			}

		}
		curl_close($ch);	
	}
	
	function createOrder($data){
		global $delyvaurl, $company_ID, $accessToken;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $delyvaurl.'/order');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_POST, 1);
		$datas = $data;
		$json = json_encode($datas, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
		$headers = array();
		$headers[] = 'Content-Type: application/json';
		$headers[] = 'Authorization: Bearer '.$accessToken.'';
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$result = curl_exec($ch);
		if (curl_errno($ch)) {
			echo 'Error:' . curl_error($ch);
		}else{
			return json_decode($result);
		/* 	$result = json_decode($result);
			$data = $result->data;
			$oderid = $data->orderId;
			$orderstatuscode = $data->statusCode;
			$status = $data->status; */
		}
		curl_close($ch);
	}
	
	function processOrder($orderid, $servicecode){
		global $delyvaurl, $company_ID, $accessToken, $currentdatetime;
		$originScheduledAt = date(DATE_ISO8601, strtotime($currentdatetime));
		$new_time = date($currentdatetime, strtotime('+1 hours'));
		$DestinationScheduledAt = date(DATE_ISO8601, strtotime($new_time));
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $delyvaurl.'/order/'.$orderid.'/process');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_POST, 1);
		$datas = [
			"serviceCode" => $servicecode,
			"originScheduledAt" => $originScheduledAt,
			"destinationScheduledAt" => $DestinationScheduledAt,
		];
		$json = json_encode($datas, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
		$headers = array();
		$headers[] = 'Content-Type: application/json';
		$headers[] = 'Authorization: Bearer '.$accessToken.'';
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$result = curl_exec($ch);
		if (curl_errno($ch)) {
			echo 'Error:' . curl_error($ch);
		}else{
			return json_decode($result);
		}
		curl_close($ch);

		
	}
	function cancelOrder($orderid){
		global $delyvaurl, $company_ID, $accessToken, $currentdatetime;
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $delyvaurl.'/order/'.$orderid.'/cancel');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);

		$headers = array();
		$headers[] = 'Content-Type: application/json';
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$result = curl_exec($ch);
		if (curl_errno($ch)) {
			echo 'Error:' . curl_error($ch);
		}else{
			return json_decode($result);
		}
		
		curl_close($ch);
	}
	function orderHook(){
		global $delyvaurl, $company_ID, $accessToken, $currentdatetime;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $delyvaurl.'/webhook/1');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
		$datas = [
			"event" => "order.updated",
			"url" => "https://staging-api.delyva.app/webhook/test",
		];
		$json = json_encode($datas, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
		$headers = array();
		$headers[] = 'Content-Type: application/json';
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$result = curl_exec($ch);
		if (curl_errno($ch)) {
			echo 'Error:' . curl_error($ch);
		}else{
			return json_decode($result);
		}
		curl_close($ch);
	}
	function getOrderDetail($orderid){
		global $delyvaurl, $company_ID, $accessToken, $currentdatetime;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $delyvaurl.'/order/'.$orderid.'');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		$headers = array();
		$headers[] = 'Content-Type: application/json';
		$headers[] = 'Authorization: Bearer '.$accessToken.'';
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$result = curl_exec($ch);
		if (curl_errno($ch)) {
			echo 'Error:' . curl_error($ch);
		}else{
			return json_decode($result);
		}
		curl_close($ch);
	}
	function createeOrder($data){
		global $delyvaurl, $company_ID, $customer_ID;
		$curl = curl_init();

	curl_setopt_array($curl, array(
  CURLOPT_URL => $delyvaurl.'/order',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => $data,
	  CURLOPT_HTTPHEADER => array(
		'Content-Type: application/json'
	  ),
	));

	$response = curl_exec($curl);

	curl_close($curl);
	echo $response;
	}
}