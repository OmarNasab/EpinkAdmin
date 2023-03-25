<?php
if(isset($_POST["submit_booking"])){
	$name = cleanInput($_POST["name"]);
    $ic_passport = cleanInput($_POST["ic_passport"]);
    $phone_number = cleanInput($_POST["phone_number"]);
    $booking_date = cleanInput($_POST["booking_date"]);
    $booking_time = cleanInput($_POST["booking_time"]);
    $email = cleanInput($_POST["email"]);
    $booking_type = cleanInput($_POST["booking_type"]);
    $booking_data = cleanInput($_POST["booking_data"]);
    $total_price = cleanInput($_POST["final_total_price"]);
	
	if($booking_type == "COVID-19 Test"){
		if($name != "" &&  $ic_passport != "" &&  $phone_number != "" &&  $booking_date != "" &&  $booking_time != "" &&  $email != "" &&  $booking_type != "" &&  $booking_data != ""){
			$bookingssql = "INSERT INTO bookings (name, ic_passport, phone_number, booking_date, booking_time, email, booking_type, booking_data, paid, total_price)
			VALUES ('$name', '$ic_passport', '$phone_number', '$booking_date', '$booking_time', '$email', '$booking_type', '$booking_data', 'false', '$total_price')";

			if ($db->query($bookingssql) === TRUE){
				$last_id = $db->insert_id;
				$user_id = 0;
		
				$databooking = json_decode($bookingsdata["booking_data"]);
				$price = number_format($databooking->testTotalPrice);
				$amount = $total_price;
				$order_status = 'waiting';
				$fullname = $name;
				$type = 'booking';
				$senang_date = date('Y-m-d H:i:s');
				$booking_id = $last_id;
				
				$senangpaysql = "INSERT INTO senangpay (user_id, amount, order_status, phone_number, email, fullname, type, senang_date, booking_id)
				VALUES ('$user_id', '$amount', '$order_status', '$phone_number', '$email', '$fullname', '$type', '$senang_date', '$booking_id')";

				if ($db->query($senangpaysql) === TRUE) {
					$last_id_senang_pay = $db->insert_id;
					header("Location: https://epink.health/senangpay/index.php?sessionid=".$last_id_senang_pay);
					
				} else {
					$row["card"] = "red";
					$row["status"] = "Fail";
					$row["message"] =  "Error: " . $sql . "<br>" . $db->error;
					$data = $row;
				}
				$row["card"] = "green";
				$row["status"] = "Successful";
				$row["message"] =  "New record successfully created";
				$data = $row;
			} else {
				$row["card"] = "red";
				$row["status"] = "Fail";
				$row["message"] =  "Error: " . $sql . "<br>" . $db->error;
				$data = $row;
			}
		}else{
			$row["card"] = "red";
			$row["status"] = "Fail";
			$row["message"] = "Please fill all the form";
			$data = $row;
		}		
		
	}elseif($booking_type == "COVID-19 Rehabilitation"){
		if($name != "" &&  $ic_passport != "" &&  $phone_number != "" &&  $booking_date != "" &&  $booking_time != "" &&  $email != "" &&  $booking_type != "" &&  $booking_data != ""){
			$bookingssql = "INSERT INTO bookings (name, ic_passport, phone_number, booking_date, booking_time, email, booking_type, booking_data, paid, total_price)
			VALUES ('$name', '$ic_passport', '$phone_number', '$booking_date', '$booking_time', '$email', '$booking_type', '$booking_data', 'false', '$total_price')";

			if ($db->query($bookingssql) === TRUE){
				$last_id = $db->insert_id;
				$user_id = 0;
		
				$databooking = json_decode($bookingsdata["booking_data"]);
				$price = number_format($databooking->testTotalPrice);
				$amount = $total_price;
				$order_status = 'waiting';
				$fullname = $name;
				$type = 'booking';
				$senang_date = date('Y-m-d H:i:s');
				$booking_id = $last_id;
				
				$senangpaysql = "INSERT INTO senangpay (user_id, amount, order_status, phone_number, email, fullname, type, senang_date, booking_id)
				VALUES ('$user_id', '$amount', '$order_status', '$phone_number', '$email', '$fullname', '$type', '$senang_date', '$booking_id')";

				if ($db->query($senangpaysql) === TRUE) {
					$last_id_senang_pay = $db->insert_id;
					header("Location: https://epink.health/senangpay/index.php?sessionid=".$last_id_senang_pay);
					
				} else {
					$row["card"] = "red";
					$row["status"] = "Fail";
					$row["message"] =  "Error: " . $sql . "<br>" . $db->error;
					$data = $row;
				}
				$row["card"] = "green";
				$row["status"] = "Successful";
				$row["message"] =  "New record successfully created";
				$data = $row;
			} else {
				$row["card"] = "red";
				$row["status"] = "Fail";
				$row["message"] =  "Error: " . $sql . "<br>" . $db->error;
				$data = $row;
			}
		}else{
			$row["card"] = "red";
			$row["status"] = "Fail";
			$row["message"] = "Please fill all the form";
			$data = $row;
		}	
	}elseif($booking_type == "COVID-19 Vaccination Antibody Test"){
		if($name != "" &&  $ic_passport != "" &&  $phone_number != "" &&  $booking_date != "" &&  $booking_time != "" &&  $email != "" &&  $booking_type != "" &&  $booking_data != ""){
			$bookingssql = "INSERT INTO bookings (name, ic_passport, phone_number, booking_date, booking_time, email, booking_type, booking_data, paid, total_price)
			VALUES ('$name', '$ic_passport', '$phone_number', '$booking_date', '$booking_time', '$email', '$booking_type', '$booking_data', 'false', '$total_price')";

			if ($db->query($bookingssql) === TRUE){
				$last_id = $db->insert_id;
				$user_id = 0;
		
				$databooking = json_decode($bookingsdata["booking_data"]);
				$price = number_format($databooking->testTotalPrice);
				$amount = $total_price;
				$order_status = 'waiting';
				$fullname = $name;
				$type = 'booking';
				$senang_date = date('Y-m-d H:i:s');
				$booking_id = $last_id;
				
				$senangpaysql = "INSERT INTO senangpay (user_id, amount, order_status, phone_number, email, fullname, type, senang_date, booking_id)
				VALUES ('$user_id', '$amount', '$order_status', '$phone_number', '$email', '$fullname', '$type', '$senang_date', '$booking_id')";

				if ($db->query($senangpaysql) === TRUE) {
					$last_id_senang_pay = $db->insert_id;
					header("Location: https://epink.health/senangpay/index.php?sessionid=".$last_id_senang_pay);
					
				} else {
					$row["card"] = "red";
					$row["status"] = "Fail";
					$row["message"] =  "Error: " . $sql . "<br>" . $db->error;
					$data = $row;
				}
				$row["card"] = "green";
				$row["status"] = "Successful";
				$row["message"] =  "New record successfully created";
				$data = $row;
			} else {
				$row["card"] = "red";
				$row["status"] = "Fail";
				$row["message"] =  "Error: " . $sql . "<br>" . $db->error;
				$data = $row;
			}
		}else{
			$row["card"] = "red";
			$row["status"] = "Fail";
			$row["message"] = "Please fill all the form";
			$data = $row;
		}	
	}elseif($booking_type == "COVID-19 Quarantine Service"){
		if($name != "" &&  $ic_passport != "" &&  $phone_number != "" &&  $booking_date != "" &&  $booking_time != "" &&  $email != "" &&  $booking_type != "" &&  $booking_data != ""){
			$bookingssql = "INSERT INTO bookings (name, ic_passport, phone_number, booking_date, booking_time, email, booking_type, booking_data, paid, total_price)
			VALUES ('$name', '$ic_passport', '$phone_number', '$booking_date', '$booking_time', '$email', '$booking_type', '$booking_data', 'false', '$total_price')";

			if ($db->query($bookingssql) === TRUE){
				$last_id = $db->insert_id;
				$user_id = 0;
		
				$databooking = json_decode($bookingsdata["booking_data"]);
				$price = number_format($databooking->testTotalPrice);
				$amount = $total_price;
				$order_status = 'waiting';
				$fullname = $name;
				$type = 'booking';
				$senang_date = date('Y-m-d H:i:s');
				$booking_id = $last_id;
				
				$senangpaysql = "INSERT INTO senangpay (user_id, amount, order_status, phone_number, email, fullname, type, senang_date, booking_id)
				VALUES ('$user_id', '$amount', '$order_status', '$phone_number', '$email', '$fullname', '$type', '$senang_date', '$booking_id')";

				if ($db->query($senangpaysql) === TRUE) {
					$last_id_senang_pay = $db->insert_id;
					header("Location: https://epink.health/senangpay/index.php?sessionid=".$last_id_senang_pay);
					
				} else {
					$row["card"] = "red";
					$row["status"] = "Fail";
					$row["message"] =  "Error: " . $sql . "<br>" . $db->error;
					$data = $row;
				}
				$row["card"] = "green";
				$row["status"] = "Successful";
				$row["message"] =  "New record successfully created";
				$data = $row;
			} else {
				$row["card"] = "red";
				$row["status"] = "Fail";
				$row["message"] =  "Error: " . $sql . "<br>" . $db->error;
				$data = $row;
			}
		}else{
			$row["card"] = "red";
			$row["status"] = "Fail";
			$row["message"] = "Please fill all the form";
			$data = $row;
		}	
	}elseif($booking_type == "COVID-19 Vaccination"){
		if($name != "" &&  $ic_passport != "" &&  $phone_number != "" &&  $booking_date != "" &&  $booking_time != "" &&  $email != "" &&  $booking_type != "" &&  $booking_data != ""){
					if($total_price != "0.00"){
						$paid = 'false';
					}else{
						$paid = 'true';
					}
			$bookingssql = "INSERT INTO bookings (name, ic_passport, phone_number, booking_date, booking_time, email, booking_type, booking_data, paid, total_price)
			VALUES ('$name', '$ic_passport', '$phone_number', '$booking_date', '$booking_time', '$email', '$booking_type', '$booking_data', '$paid', '$total_price')";

			if ($db->query($bookingssql) === TRUE){
				$last_id = $db->insert_id;
				if($paid == "false"){
					$user_id = 0;
					$databooking = json_decode($bookingsdata["booking_data"]);
					$price = number_format($databooking->testTotalPrice);
					$amount = $total_price;
					$order_status = 'waiting';
					$fullname = $name;
					$type = 'booking';
					$senang_date = date('Y-m-d H:i:s');
					$booking_id = $last_id;
					
					$senangpaysql = "INSERT INTO senangpay (user_id, amount, order_status, phone_number, email, fullname, type, senang_date, booking_id)
					VALUES ('$user_id', '$amount', '$order_status', '$phone_number', '$email', '$fullname', '$type', '$senang_date', '$booking_id')";

					if ($db->query($senangpaysql) === TRUE) {
						$last_id_senang_pay = $db->insert_id;
						header("Location: https://epink.health/senangpay/index.php?sessionid=".$last_id_senang_pay);
						
					} else {
						$row["card"] = "red";
						$row["status"] = "Fail";
						$row["message"] =  "Error: " . $sql . "<br>" . $db->error;
						$data = $row;
					}
				}else{
					$row["card"] = "green";
					$row["status"] = "Successful";
					$row["message"] =  "New record successfully created";
					$data = $row;
				}
				$row["card"] = "green";
				$row["status"] = "Successful";
				$row["message"] =  "Your booking has been recieved. Our sales team will be incontact with you ";
				$data = $row;
			} else {
				$row["card"] = "red";
				$row["status"] = "Fail";
				$row["message"] =  "Error: " . $sql . "<br>" . $db->error;
				$data = $row;
			}
		}else{
			$row["card"] = "red";
			$row["status"] = "Fail";
			$row["message"] = "Please fill all the form";
			$data = $row;
		}	
	}else{
				if($name != "" &&  $ic_passport != "" &&  $phone_number != "" &&  $booking_date != "" &&  $booking_time != "" &&  $email != "" &&  $booking_type != "" &&  $booking_data != ""){
					if($total_price != "0.00"){
						$paid = 'false';
					}else{
						$paid = 'true';
					}
			$bookingssql = "INSERT INTO bookings (name, ic_passport, phone_number, booking_date, booking_time, email, booking_type, booking_data, paid, total_price)
			VALUES ('$name', '$ic_passport', '$phone_number', '$booking_date', '$booking_time', '$email', '$booking_type', '$booking_data', '$paid', '$total_price')";

			if ($db->query($bookingssql) === TRUE){
				$last_id = $db->insert_id;
				if($paid == "false"){
					$user_id = 0;
					$databooking = json_decode($bookingsdata["booking_data"]);
					$price = number_format($databooking->testTotalPrice);
					$amount = $total_price;
					$order_status = 'waiting';
					$fullname = $name;
					$type = 'booking';
					$senang_date = date('Y-m-d H:i:s');
					$booking_id = $last_id;
					
					$senangpaysql = "INSERT INTO senangpay (user_id, amount, order_status, phone_number, email, fullname, type, senang_date, booking_id)
					VALUES ('$user_id', '$amount', '$order_status', '$phone_number', '$email', '$fullname', '$type', '$senang_date', '$booking_id')";

					if ($db->query($senangpaysql) === TRUE) {
						$last_id_senang_pay = $db->insert_id;
						header("Location: https://epink.health/senangpay/index.php?sessionid=".$last_id_senang_pay);
						
					} else {
						$row["card"] = "red";
						$row["status"] = "Fail";
						$row["message"] =  "Error: " . $sql . "<br>" . $db->error;
						$data = $row;
					}
				}else{
					$row["card"] = "green";
					$row["status"] = "Successful";
					$row["message"] =  "New record successfully created";
					$data = $row;
				}
				$row["card"] = "green";
				$row["status"] = "Successful";
				$row["message"] =  "Your booking has been recieved. Our sales team will be incontact with you ";
				$data = $row;
			} else {
				$row["card"] = "red";
				$row["status"] = "Fail";
				$row["message"] =  "Error: " . $sql . "<br>" . $db->error;
				$data = $row;
			}
		}else{
			$row["card"] = "red";
			$row["status"] = "Fail";
			$row["message"] = "Please fill all the form";
			$data = $row;
		}	
	}


}
if($_GET["form"] == "home-covid-19-test"){
	$booking_type = "COVID-19 Test";
}elseif($_GET["form"] == "covid-19-vaccination"){
	$booking_type = "COVID-19 Vaccination";
}elseif($_GET["form"] == "vaccination-antibody-test"){
	$booking_type = "COVID-19 Vaccination Antibody Test";
}elseif($_GET["form"] == "quarantine-services"){
	$booking_type = "COVID-19 quarantine services";
}elseif($_GET["form"] == "post-covid-screening-and-rehabilitation"){
	$booking_type = "COVID-19 Rehabilitation";
}elseif($_GET["form"] == "corporate-wellness"){
	$booking_type = "Corporate Wellness";
}
?>