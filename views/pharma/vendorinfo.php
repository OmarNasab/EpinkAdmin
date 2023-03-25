<?php

$usersid = $authuser["id"];

if(isset($_POST["updateusers"])){
	$merchant_name = cleanInput($_POST["merchant_name"]); 
	$merchant_address = cleanInput($_POST["merchant_address"]); 
	$vendor_street_address = cleanInput($_POST["vendor_street_address"]); 
	$vendor_street_address_2 = cleanInput($_POST["vendor_street_address_2"]); 
	$vendor_city = cleanInput($_POST["vendor_city"]); 
	$vendor_postcode = cleanInput($_POST["vendor_postcode"]); 
	$vendor_state = cleanInput($_POST["vendor_state"]); 
	$vendor_country = cleanInput($_POST["vendor_country"]);
	$merchant_lat = cleanInput($_POST["lat"]); 
	$merchant_lng = cleanInput($_POST["lng"]); 
	$merchant_type = cleanInput($_POST["merchant_type"]); 
	if($_POST["merchant_logo"] != ""){
		$merchant_logo = processFile($_POST["merchant_logo"]); 
	}else{
		$merchant_logo = "";
	}
    if($merchant_name != "" && $merchant_address != "" && $merchant_lat != "" && $merchant_lng != "" &&  $vendor_street_address != "" &&  $vendor_street_address_2 != ""&& $vendor_postcode != "" && $vendor_state != "" && $vendor_city != ""){
				if($merchant_logo == ""){
					$sql = "UPDATE users SET vendor_name = '$merchant_name',  vendor_address ='$merchant_address', vendor_street_address='$vendor_street_address', vendor_street_address_2 ='$vendor_street_address_2', vendor_city='$vendor_city', vendor_postcode='$vendor_postcode', vendor_country='$vendor_country', vendor_state='$vendor_state',  lat = '$merchant_lat',  lng = '$merchant_lng'  WHERE id='$usersid'";
				}else{
					$sql = "UPDATE users SET vendor_name = '$merchant_name',  vendor_address ='$merchant_address', vendor_street_address='$vendor_street_address', vendor_street_address_2 ='$vendor_street_address_2', vendor_city='$vendor_city', vendor_postcode='$vendor_postcode', vendor_country='$vendor_country', vendor_state='$vendor_state',  lat = '$merchant_lat',  lng = '$merchant_lng', vendor_logo='$merchant_logo'  WHERE id='$usersid'";
					
				}
                if ($db->query($sql) === TRUE) {
                        $response = 'Your establishement information has been updated successfully.'; 
                        $cardcolor = 'bg-success'; 
                }else{
                        $response = 'Error updating record';
                        $cardcolor = 'bg-warning'; 
                }
	}else{
		 $response = 'Please fill up all the form';
                        $cardcolor = 'bg-warning'; 
	}

}

$query = "SELECT *  FROM users WHERE id='$usersid'"; 

$result = $db->query($query); 

if($result->num_rows > 0){

    	$users = $result->fetch_assoc();

    	$users["status"] = "success";

}else{

	header('location: '.$domain.'/admin/users/');

}

?>
<header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
	<div class="container-xl px-4">
		<div class="page-header-content">
			<div class="row align-items-center justify-content-between pt-3">
				<div class="col-auto mb-3">
					<h1 class="page-header-title">
						<div class="page-header-icon"><i data-feather="map"></i></div>
						Pharmacy Information
					</h1>
				</div>
	 				
			</div>
		</div>
	</div>
</header>
<div class="container-xl px-4 mt-4">
	<div class="row">
		<div class="col-xl-12">
			<div class="card mb-4">
				<div class="card-header text-black">Update your pharmacy information</div>
					<div class="card-body">
						<?php if(isset($response)){
							echo '
							<div class="card mb-4">
								<div class="card-body '.$cardcolor.' text-white">'.$response.'</div>
							</div>
							';
						}?>
						<form method="POST">
							<div class="row gx-3 mb-3">
										<div class="col-md-12 mb-3">
												<label class="small" for="merchant_logo">Establishment Logo</label>
												<br>
												<img src="<?php echo $users["vendor_logo"]; ?>" id="vimage" width="100px">
												<br>
												<br>
												<input class="form-control" id="pr" name="pr" type="file" onchange="photoBase64(this, 'merchant_logo', 'vimage')"/>
												<input class="form-control" id="merchant_logo" name="merchant_logo" type="text" hidden/>
										</div>
										<div class="col-md-12 mb-3">
												<label class="small" for="merchant_name">Establishment Name</label>
												<input class="form-control" id="merchant_name" name="merchant_name" type="text" placeholder="" value="<?php echo $users["vendor_name"]; ?>" />
										</div>
										<div class="col-md-12 mb-3">
												<label class="small" for="merchant_address">Geolocation Address (For On Demand Delivery)</label>
												<input class="form-control" id="merchant_address" name="merchant_address" type="text" placeholder="" value="<?php echo $users["vendor_address"]; ?>" />
										</div>
										<div class="col-md-12 mb-3">
												<label class="small" for="vendor_street_address">Street Address 1</label>
												<input class="form-control" id="vendor_street_address" name="vendor_street_address" type="text" placeholder="" value="<?php echo $users["vendor_street_address"]; ?>" />
										</div>
										<div class="col-md-12 mb-3">
												<label class="small" for="vendor_street_address_2">Street Address 2</label>
												<input class="form-control" id="vendor_street_address_2" name="vendor_street_address_2" type="text" placeholder="" value="<?php echo $users["vendor_street_address_2"]; ?>" />
										</div>
										<div class="col-md-12 mb-3">
												<label class="small" for="vendor_city">City</label>
												<input class="form-control" id="vendor_city" name="vendor_city" type="text" placeholder="" value="<?php echo $users["vendor_city"]; ?>" />
										</div>
										<div class="col-md-12 mb-3">
												<label class="small" for="vendor_postcode">Post Code</label>
												<input class="form-control" id="vendor_postcode" name="vendor_postcode" type="text" placeholder="" value="<?php echo $users["vendor_postcode"]; ?>" />
										</div>
										<div class="col-md-12 mb-3">
												<label class="small" for="vendor_state">State</label>
												<input class="form-control" id="vendor_state" name="vendor_state" type="text" placeholder="" value="<?php echo $users["vendor_state"]; ?>" />
										</div>
										<div class="col-md-12 mb-3">
												<label class="small" for="vendor_country">Country</label>
												<input class="form-control" id="vendor_country" name="vendor_country" type="text" placeholder="" value="<?php echo $users["vendor_country"]; ?>" />
										</div>
										<div class="col-md-12 mb-3">
												<label class="small" for="lat">Latitute</label>
												<input class="form-control" id="lat" name="lat" type="text" placeholder="" value="<?php echo $users["lat"]; ?>"  />
										</div>
										<div class="col-md-12 mb-3">
												<label class="small" for="lng">Longitude</label>
												<input class="form-control" id="lng" name="lng" type="text" placeholder="" value="<?php echo $users["lng"]; ?>"  />
										</div>
							<div class="form-group"><button type="submit" class="btn btn-primary" name="updateusers" id="updateusers">Submit</button></div>
							</div>
						</form>
					</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAZlGMK1RAFDzW04ANQrTPDnKv4E5JGCFA&libraries=places"></script>
    <script>
		function photoBase64(element, targetinput, targetimage){
		  var file1 = element.files[0];
		  var reader = new FileReader();
		  reader.onloadend = function(){
			  document.getElementById(targetimage).src = reader.result;
			  document.getElementById(targetinput).value = reader.result;
				
		  }
		  reader.readAsDataURL(file1);
		}
        function initialize() {
          var input = document.getElementById('merchant_address');
          var autocomplete = new google.maps.places.Autocomplete(input);
            google.maps.event.addListener(autocomplete, 'place_changed', function () {
                var place = autocomplete.getPlace();
				console.log(place);
                document.getElementById('lat').value = place.geometry.location.lat();
                document.getElementById('lng').value = place.geometry.location.lng();
				var addressComponent = place.address_components;
						for (let i = 0; i < addressComponent.length; i++) {
							components = addressComponent[i];
							console.log(components);
							var componenttype = components.types;
							for (let j = 0; j < componenttype.length; j++) {
								console.log(componenttype[j]);
								if(componenttype[j] == "locality" || componenttype[j] == "political"){
									address_city = addressComponent[i].long_name;
									if(address_city != "Malaysia"){
										//document.getElementById("vendor_city").value = address_city;
									}
									
								}
								if(componenttype[j] == "postal_code"){
									address_postcode = addressComponent[i].long_name;
									document.getElementById("vendor_postcode").value = address_postcode;
								}
								if(componenttype[j] == "country"){
									address_country = addressComponent[i].long_name;
									document.getElementById("vendor_country").value = address_country;
								}
								if(componenttype[j] == "administrative_area_level_1"){
									address_state = addressComponent[i].long_name;
									document.getElementById("vendor_state").value = address_state;
								}
								
							}
						}
            });
        }
        google.maps.event.addDomListener(window, 'load', initialize);
    </script>
