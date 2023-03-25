<?php 
$speedyurl = 'https://robotapitest.mrspeedy.my/api/business/1.1/create-order';
$speedyproductionykey = 'C1CCFD8972242D6B997AE64171BB934AE3A7DB79';
$speedydebugkey = '3D3104D392836D67F720494704651081E9DDCBB5';


$productionurl = 'https://robot.mrspeedy.my/api/business/1.1';
$debugurl = 'https://robotapitest.mrspeedy.my/api/business/1.1'; 

$usethisurl = $productionurl;
$speedykey = $speedyproductionykey;

function cancelOrder($oid){
	global $speedykey, $usethisurl;
	$curl = curl_init(); 
	curl_setopt($curl, CURLOPT_URL, $usethisurl.'/cancel-order'); 
	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST'); 
		curl_setopt($curl, CURLOPT_HTTPHEADER, ['X-DV-Auth-Token:'.$speedykey]); 
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
	$data = [
		'order_id' => $oid, 
	]; 
	 
	$json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); 
	curl_setopt($curl, CURLOPT_POSTFIELDS, $json); 
	 
	$result = curl_exec($curl); 
	if ($result === false) { 
		throw new Exception(curl_error($curl), curl_errno($curl)); 
	}else{
		//echo $result;
	} 
}

function requestSpeedy($customername, $customerphonenumber, $customeraddress, $restaurantname, $restaurantphonenumber, $restaurantaddress, $orderid){
	global $speedykey, $usethisurl;
	$curl = curl_init(); 
	curl_setopt($curl, CURLOPT_URL, $usethisurl.'/create-order'); 
	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST'); 
	curl_setopt($curl, CURLOPT_HTTPHEADER, ['X-DV-Auth-Token:'.$speedykey ]); 
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
	 
	$data = [ 
		'matter' => 'Pick up '.$customername.' medications from '.$restaurantname.'', 
		'payment_method' => 'non_cash', 
		'points' => [ 
			[ 
				'address' => ''.$restaurantaddress.'', 
				'contact_person' => [ 
					'phone' => ''.$restaurantphonenumber.'', 
				], 
			], 
			[  
				'address' => ''.$customeraddress.'', 
				'contact_person' => [ 
					'phone' => ''.$customerphonenumber.'', 
				], 
			], 
		], 
	]; 
	 
	$json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); 
	curl_setopt($curl, CURLOPT_POSTFIELDS, $json); 
	 
	$result = curl_exec($curl);	
	if ($result === false) { 
		return "Fail";
	}else{
		
		return $result;
	} 
	 
	
} 

function getPrice($addressfrom, $addressto){
	global $speedykey, $usethisurl;
	$curl = curl_init(); 
	curl_setopt($curl, CURLOPT_URL, $usethisurl.'/calculate-order'); 
	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST'); 
	curl_setopt($curl, CURLOPT_HTTPHEADER, ['X-DV-Auth-Token:'.$speedykey]); 
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
	 
	$data = [ 
		'matter' => 'Pick up '.$customername.' orders from '.$restaurantname.' and deliver to '.$customername.'', 
		'payment_method' => 'non_cash', 
		'points' => [ 
			[ 
				'address' => ''.$addressfrom.'', 
				'contact_person' => [ 
					'phone' => '0146503651', 
				], 
			], 
			[  
				'address' => ''.$addressto.'', 
				'contact_person' => [ 
					'phone' => '0146503651', 
				], 
			], 
		], 
	]; 
	$json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); 
	curl_setopt($curl, CURLOPT_POSTFIELDS, $json); 
	 
	$result = curl_exec($curl); 
	if ($result === false) { 
		throw new Exception(curl_error($curl), curl_errno($curl)); 
		return false;
	}else{
		$result = json_decode($result);
		$is_successful = $result->is_successful;
		return $result;
	} 
}

function getOrders(){
	global $speedykey, $usethisurl;
	$curl = curl_init(); 
	curl_setopt($curl, CURLOPT_URL, $usethisurl.'/orders?status=canceled'); 
	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET'); 
	curl_setopt($curl, CURLOPT_HTTPHEADER, ['X-DV-Auth-Token:'.$speedykey ]); 
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
 
	$result = curl_exec($curl); 
	if ($result === false) { 
		throw new Exception(curl_error($curl), curl_errno($curl)); 
	} 
 
	//echo $result; 
	$jso = json_decode($result);
	echo json_encode($jso, JSON_PRETTY_PRINT);
}