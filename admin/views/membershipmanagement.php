<?php
$sqlpriceperkm = "SELECT * FROM settings WHERE setting_item='spcommision'";
$priceperkmresult = $db->query($sqlpriceperkm);
if ($priceperkmresult->num_rows > 0) {
	$settingobject = $priceperkmresult->fetch_assoc();
	$spcommision = $settingobject["setting_value"];
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Membership Management</h1>
                </div>
                <div class="col-sm-6"> 
                    <ol class="breadcrumb float-sm-right">
						
                        <li class="breadcrumb-item active">Membership Management</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
			<p>Search for Pharmacy(use email)</p>
			<input id="searchinput" type="text" class="form-control" onkeyup="searchUser(this)">
			<br>
		
			<div id="pharmacylist">
			
			</div>
			<br>
			<div id="selectedpharma" style="display: none">
				<div class="card">
					<div class="card-body">
						<p class="font-weight-bold" id="pharmaname">Pharmacy Name</p>
						<p class="text-sm" id="pharmacistname">Pharmacist name</p>
						<p>Current Membership: <span id="pharmacurmembership"></span></p>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12 col-lg-4">
						<div class="card">
							<div class="card-body">
								<div id="">
									<p class="font-weight-bold">Test Package</p>
									<p>Customised EPS</p>
									<p>1 e-Rx or</p>
									<p>1 Consultations</p>
									<p>Daily doctor on duty</p>
									<p>Dashboard</p>
									<p>No. of outlet: 1</p>
									<p>Support: Email</p>
									<p>Unused e-rx : Will expire</p>
								</div>		
								<button class="btn btn-primary" style="width: 100%" onclick="subThisUser(1, 10)">Subscribe (RM1/month)</button>
							</div>
						</div>
					</div>
					<div class="col-sm-12 col-lg-4">
						<div class="card">
							<div class="card-body">
								<div id="">
								<p class="font-weight-bold">Apprentice Package</p>
								<p>Customised EPS</p>
								<p>50 e-Rx or</p>
								<p>50 Consultations</p>
								<p>Daily doctor on duty</p>
								<p>Dashboard</p>
								<p>No. of outlet: 1</p>
								<p>Support: Email</p>
								<p>Unused e-rx : Will expire</p>
								</div>		
								<button class="btn btn-primary" style="width: 100%" onclick="subThisUser(2, 259)">Subscribe (RM259/month)</button>
							</div>
						</div>
					</div>
					<div class="col-sm-12 col-lg-4">
						<div class="card">
							<div class="card-body">
								<div id="">
								<p class="font-weight-bold">Basic Package</p>
								<p>Customised EPS</p>
								<p>100 e-Rx or</p>
								<p>100 Consultations</p>
								<p>Daily doctor on duty</p>
								<p>Dashboard</p>
								<p>No. of outlet: 1 - 3</p>
								<p>Support: Email or WhatsApp</p>
								<p>Unused e-rx : Share and bring forward</p>
								</div>		
								<button class="btn btn-primary" style="width: 100%" onclick="subThisUser(3, 399)">Subscribe (RM 399/month)</button>
							</div>
						</div>
					</div>
					<div class="col-sm-12 col-lg-4">
						<div class="card">
							<div class="card-body">
								<div id="">
									<p class="font-weight-bold">Advanced Package</p>
									<p>Customised EPS</p>
									<p>200 e-Rx or</p>
									<p>200 Consultations</p>
									<p>Daily doctor on duty</p>
									<p>Dashboard</p>
									<p>No. of outlet: 1 - 3</p>
									<p>Support: Email or WhatsApp</p>
									<p>Unused e-rx : Share and bring forward</p>
								</div>		
								<button class="btn btn-primary" style="width: 100%" onclick="subThisUser(4, 699)">Subscribe (RM 699/month)</button>
							</div>
						</div>
					</div>
					<div class="col-sm-12 col-lg-4">
						<div class="card">
							<div class="card-body">
								<div id="">
								<p class="font-weight-bold">Premium  Package</p>
								<p>Customised EPS</p>
								<p>500 e-Rx or</p>
								<p>500 Consultations</p>
								<p>Daily doctor on duty</p>
								<p>Dashboard</p>
								<p>No. of outlet: 1 - 3</p>
								<p>Support: Email or WhatsApp</p>
								<p>Unused e-rx : Share and bring forward</p>
								</div>		
								<button class="btn btn-primary" style="width: 100%" onclick="subThisUser(5, 1199)">Subscribe RM 1 199/month</button>
							</div>
						</div>
					</div>
				</div>
				<br>
				
			</div>
			
        </div>
		
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>



<script>
var gid = '';
var serverUrl = 'https://epink.health/api/index.php';
var selectedPharma = 0;
var userwallet = 0;
var pwallet = 0;
function subThisUser(id, price){
	selectedPlan = id;
	console.log(price);
	console.log(pwallet);
	if(parseFloat(pwallet) >= parseFloat(price)){
		document.getElementById("pharmacylist").innerHTML = "";
		var dataTopost = 'api=1&auth_token='+authUser.login_token+"&subuserto="+selectedPlan+"&uid="+selectedPharma;
			var xhr = new XMLHttpRequest();
			xhr.open("POST", serverUrl, true);
			xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			xhr.onload = function() {
				if (xhr.status == 200) {
					var json = xhr.responseText;
					var response = JSON.parse(json);
					console.log(response);
					var expire = response.expire;
					var render_expire = 'Active';
					alert("Plan updated");
					if(response.membershiptype == "1"){
						document.getElementById("pharmacurmembership").innerHTML = 'Test Package (Expire Date: '+expire+' - '+render_expire+')';
					}else if(response.membershiptype == "2"){
						document.getElementById("pharmacurmembership").innerHTML = 'Apprentice Package (Expire Date: '+expire+' - '+render_expire+')';
					}else if(response.membershiptype == "3"){
						document.getElementById("pharmacurmembership").innerHTML = 'Basic Package (Expire Date: '+expire+' - '+render_expire+')';
					}else if(response.membershiptype == "4"){
						document.getElementById("pharmacurmembership").innerHTML = 'Advanced Package (Expire Date: '+expire+' - '+render_expire+')';
					}else if(response.membershiptype == "5"){
						document.getElementById("pharmacurmembership").innerHTML = 'Premium Package (Expire Date: '+expire+' - '+render_expire+')';
					}
				} else if (xhr.status == 404) {
					alert("Fail to connect to our server");
				} else {
					alert("Fail to connect to our server");
				}
			}
		xhr.send(dataTopost);
	}else{
		alert("Insufficient Balance");
		
	}	
	
	
}
function selectThispharma(id){
	selectedPharma = id;
	document.getElementById("pharmacylist").innerHTML = "";
	var dataTopost = 'api=1&auth_token='+authUser.login_token+"&getpharmamembership="+selectedPharma;
		var xhr = new XMLHttpRequest();
		xhr.open("POST", serverUrl, true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhr.onload = function() {
			if (xhr.status == 200) {
				var json = xhr.responseText;
				var response = JSON.parse(json);
				document.getElementById("pharmaname").innerHTML = response.vendor_name;
				document.getElementById("pharmacistname").innerHTML = response.fullname+' - Wallet: RM'+response.wallet;
				pwallet = parseFloat(response.wallet);
				if(response.membership_data == null){
					document.getElementById("pharmacurmembership").innerHTML = "No membership";
				}else{
					var membershipdata = response.membership_data;
					console.log(membershipdata)
					var expire = membershipdata.expire;
					var render_expire = membershipdata.render_expire;
					if(membershipdata.membershiptype == "1"){
						document.getElementById("pharmacurmembership").innerHTML = 'Test Package (Expire Date: '+expire+' - '+render_expire+')';
					}else if(membershipdata.membershiptype == "2"){
						document.getElementById("pharmacurmembership").innerHTML = 'Apprentice Package (Expire Date: '+expire+' - '+render_expire+')';
					}else if(membershipdata.membershiptype == "3"){
						document.getElementById("pharmacurmembership").innerHTML = 'Basic Package (Expire Date: '+expire+' - '+render_expire+')';
					}else if(membershipdata.membershiptype == "4"){
						document.getElementById("pharmacurmembership").innerHTML = 'Advanced Package (Expire Date: '+expire+' - '+render_expire+')';
					}else if(membershipdata.membershiptype == "5"){
						document.getElementById("pharmacurmembership").innerHTML = 'Premium Package (Expire Date: '+expire+' - '+render_expire+')';
					}
					//document.getElementById("pharmacurmembership").innerHTML = "Has Memebership"+response.membership_data.;
				}
				document.getElementById("selectedpharma").style.display = "block";
				
				
			} else if (xhr.status == 404) {
				alert("Fail to connect to our server");
			} else {
				alert("Fail to connect to our server");
			}
		}
	xhr.send(dataTopost);
}
function searchUser(elem){
	var gid = elem.value;
	var dataTopost = 'api=1&auth_token='+authUser.login_token+"&adminfindpharmacy="+gid;
		var xhr = new XMLHttpRequest();
		xhr.open("POST", serverUrl, true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhr.onload = function() {
			if (xhr.status == 200) {
				var json = xhr.responseText;
				var response = JSON.parse(json);
				
				document.getElementById("pharmacylist").innerHTML = "";
				for (let i = 0; i < response.length; i++) {
					document.getElementById("pharmacylist").innerHTML += '<div class="card" onclick="selectThispharma('+response[i].id+')"><div class="card-body"><a href="#!" >'+response[i].vendor_name+'</a></div></div>';
				}
				
				
			} else if (xhr.status == 404) {
				alert("Fail to connect to our server");
			} else {
				alert("Fail to connect to our server");
			}
		}
	xhr.send(dataTopost);
}
</script>