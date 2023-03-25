<?php
$uid = cleanInput($page_identifier_action);
$sql = "SELECT * FROM ecare_services WHERE id='$uid'";
$result = $db->query($sql);

if ($result->num_rows > 0) {
	$row = $result->fetch_assoc();
	$booking_type = $row["name"];
	$booking_data = $row["name"];
	$bookingdataset = '{"testName":"'.$row["name"].'", "testType": "ECare"}';
	$booking_price = $row["price"];
} else {
	
}
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
}		

?>
                    <header class="page-header-ui epink-page-header-ui-dark epink-bg-gradient-primary-to-secondary">
                        <div class="page-header-ui-content mb-n5">
                            <div class="container px-5">
                                <div class="row gx-5 justify-content-center align-items-center">
                                    <div class="col-lg-6" data-aos="fade-right">
                                        <h1 class="page-header-ui-title text-light"><?php echo $row["name"]; ?></h1>
										<p>PRICE: RM<?php echo $row["price"]; ?></p>
                                        <p class="page-header-ui-text mb-5"><?php echo $row["description"]; ?></p>
										<p>Download our mobile app now!</p>
                                        <div class="mb-5 mb-lg-0 ">
                                            <a class="me-3" href="#!"><img src="<?php echo $domain; ?>/landingasset/assets/img/app-badges/app-store-badge.svg" style="height: 3rem" /></a>
                                            <a href="#!"><img src="<?php echo $domain; ?>/landingasset/assets/img/app-badges/google-play-badge.svg" style="height: 3rem" /></a>
											
                                        </div>
										<p class=" mb-5 mt-5">Use our web application <a href="https://app.epink.health" class="text-white strong"><strong>Click Here</strong></a></p>
										<div class="mb-5 mb-lg-0">
                                           
                                        </div>
                                    </div>
                                    <div class="col-lg-6 z-1" data-aos="fade-left">
										<center><img class="card-team-img mb-3" src="<?php echo $row["icon"]; ?>" alt="..." width="50%" style="border-radius: 50%"></center>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="svg-border-waves text-white">
                            <!-- Wave SVG Border-->
                            <svg class="wave" style="pointer-events: none" fill="currentColor" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1920 75">
                                <defs>
                                    <style>
                                        .a {
                                            fill: none;
                                        }
                                        .b {
                                            clip-path: url(#a);
                                        }
                                        .d {
                                            opacity: 0.5;
                                            isolation: isolate;
                                        }
                                    </style>
                                </defs>
                                <clippath id="a"><rect class="a" width="1920" height="75"></rect></clippath>
                                <g class="b"><path class="c" d="M1963,327H-105V65A2647.49,2647.49,0,0,1,431,19c217.7,3.5,239.6,30.8,470,36,297.3,6.7,367.5-36.2,642-28a2511.41,2511.41,0,0,1,420,48"></path></g>
                                <g class="b"><path class="d" d="M-127,404H1963V44c-140.1-28-343.3-46.7-566,22-75.5,23.3-118.5,45.9-162,64-48.6,20.2-404.7,128-784,0C355.2,97.7,341.6,78.3,235,50,86.6,10.6-41.8,6.9-127,10"></path></g>
                                <g class="b"><path class="d" d="M1979,462-155,446V106C251.8,20.2,576.6,15.9,805,30c167.4,10.3,322.3,32.9,680,56,207,13.4,378,20.3,494,24"></path></g>
                                <g class="b"><path class="d" d="M1998,484H-243V100c445.8,26.8,794.2-4.1,1035-39,141-20.4,231.1-40.1,378-45,349.6-11.6,636.7,73.8,828,150"></path></g>
                            </svg>
                        </div>
                    </header> 
						<section class="bg-white py-10">
						<div class="container">
						<h3 class="">Book right away</h3>
		<form id="bookingformmain" method="POST" action="">
			<input type="number" class="form-control" id="final_total_price" name="final_total_price" step="0.01"  value="<?php echo $booking_price; ?>" hidden>
			
			<div class="mb-3 pages" style="display: none">
				<label for="booking_type" class="form-label">Booking Type</label>
				<input type="text" class="form-control" id="booking_type" name="booking_type" value="<?php echo $booking_type; ?>">
			</div>
			<div class="mb-3 " style="display: none">
				<label for="booking_data" class="form-label">Booking Data</label>
				<input type="text" class="form-control" id="booking_data" name="booking_data" value="<?php echo $bookingdataset; ?>">
			</div>
			<div class="row">
				<div id="bookingdetail"></div>
				<div class="col-12">
					<p class="">
						<strong>Your information</strong>
					</p>
				</div>
				<div class="col-6">
					<div class="mb-3">
						<label for="name" class="form-label">Full name</label>
						<input type="text" class="form-control" id="name" name="name" onchange="updateFormData(this, 'name')">
					</div>
				</div>
				<div class="col-6">
					<div class="mb-3">
						<label for="ic_passport" class="form-label">IC / Passport</label>
						<input type="text" class="form-control" id="ic_passport" name="ic_passport" onchange="updateFormData(this, 'ic_passport')">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-6">
					<div class="mb-3">
						<label for="email" class="form-label">Email address</label>
						<input type="email" class="form-control" id="email" name="email" onchange="updateFormData(this, 'email')">
					</div>
				</div>
				<div class="col-6">
					<div class="mb-3">
						<label for="phone_number" class="form-label">Phone Number</label>
						<input type="text" class="form-control" id="phone_number" name="phone_number" onchange="updateFormData(this, 'phone_number')">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<p class="">
						<strong>Appointment Detail</strong>
					</p>
				</div>
				<div class="col-6">
					<div class="mb-3">
						<label for="booking_date" class="form-label">Date</label>
						<input type="date" class="form-control" id="booking_date" name="booking_date" 
						<?php
						if($_GET["quarantine-services"] == "quarantine-services"){
							echo 'onclick="getQuarantineData()"';
						}
						?>>
					</div>
				</div>
				<div class="col-6">
					<div class="mb-3">
						<label for="booking_data" class="form-label">Time</label>
						<input type="time" class="form-control" id="booking_time" name="booking_time">
					</div>
				</div>
			</div>
			<button type="submit" class="btn btn-primary" name="submit_booking">SUBMIT</button>
		</form>				
</div>		
						</section>
					
					<script src="<?php echo $domain; ?>/js/webapp.js"></script>