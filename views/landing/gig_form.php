<div class="container" id="">
	<?php 
	if(isset($_POST["submitted"])){
$Name = cleanInput($_POST["Name"]);
$Ic = cleanInput($_POST["Ic"]);
$Gender = cleanInput($_POST["Gender"]);
$Address = cleanInput($_POST["Address"]);
$Postcode = cleanInput($_POST["Postcode"]);
$Country = cleanInput($_POST["Country"]);
$Contact_no = cleanInput($_POST["Contact_no"]);
$Email = cleanInput($_POST["Email"]);
$Race = cleanInput($_POST["Race"]);
$Clinical_notes = cleanInput($_POST["Clinical_notes"]);
$Diagnosis = cleanInput($_POST["Diagnosis"]);
$Management = cleanInput($_POST["Management"]);
$Medication = cleanInput($_POST["Medication"]);
$Doctor_name = cleanInput($_POST["Doctor_name"]);
$rqDate = cleanInput($_POST["Date"]);
		if($Name != "" && $Ic != "" && $Gender != "" && $Address != "" && $Postcode != "" && $Country != "" && $Contact_no != "" && $Email != "" && $Race != "" && $Clinical_notes != "" && $Diagnosis != "" && $Management != "" && $Medication != "" && $Doctor_name != "" && $rqDate != ""){
			
			$sql = "INSERT INTO gigrequest (Name, Ic, Gender, Address, Postcode, Country, Contact_no, Email, Race, Clinical_notes, Diagnosis, Management, Medication, Doctor_name, rqDate)
			VALUES ('$Name', '$Ic', '$Gender', '$Address', '$Postcode', '$Country', '$Contact_no', '$Email', '$Race', '$Clinical_notes', '$Diagnosis', '$Management', '$Medication', '$Doctor_name', '$rqDate')";

			if ($db->query($sql) === TRUE) {
				echo '<div class="card mt-10 mb-10" ><div class="card-body">Data saved</div></div>';
			} else {
				echo "Error: " . $sql . "<br>" . $db->error;
			}
		}else{
			echo '<div class="card mt-10 mb-10" ><div class="card-body">Please Fill All The Form</div></div>';
		}
		
		

	}
	?>
	<div class="row mt-5">
		<div class="col">
		<h1>Flood Victim Health Care </h1>
<form method="POST">
<div class="card mt-3">
	<div class="card-header">Patient Detail</div>
	<div class="card-body">
	
    <div class="mb-5">
		<label for="Name" class="form-label">Full Name</label>
		<input type="text" class="form-control" id="Name" name="Name" value="">
	</div>
    <div class="mb-5 mt-5">
		<label for="Ic" class="form-label">IC No / Passport</label>
		<input type="text" class="form-control" id="Ic" name="Ic" value="">
	</div>
    <div class="mb-5 mt-5">
		<label for="Gender" class="form-label">Gender</label>
		<select id="Gender" name="Gender" class="form-control">
			<option value="">Please Select</option>
			<option value="Male">Male</option>
			<option value="Female">Female</option>
		</select>
	</div>
    <div class="mb-5 mt-5">
		<label for="Address" class="form-label">Address</label>
		<input type="text" class="form-control" id="Address" name="Address" value="">
	</div>
    <div class="mb-5 mt-5">
		<label for="Postcode" class="form-label">Postcode</label>
		<input type="text" class="form-control" id="Postcode" name="Postcode" value="">
	</div>
    <div class="mb-5 mt-5">
		<label for="Country" class="form-label">Country</label>
		<select id="Country" name="Country" class="form-control">
								<option value="Afganistan">Afghanistan</option>
								<option value="Albania">Albania</option>
								<option value="Algeria">Algeria</option>
								<option value="American Samoa">American Samoa</option>
								<option value="Andorra">Andorra</option>
								<option value="Angola">Angola</option>
								<option value="Anguilla">Anguilla</option>
								<option value="Antigua & Barbuda">Antigua & Barbuda</option>
								<option value="Argentina">Argentina</option>
								<option value="Armenia">Armenia</option>
								<option value="Aruba">Aruba</option>
								<option value="Australia">Australia</option>
								<option value="Austria">Austria</option>
								<option value="Azerbaijan">Azerbaijan</option>
								<option value="Bahamas">Bahamas</option>
								<option value="Bahrain">Bahrain</option>
								<option value="Bangladesh">Bangladesh</option>
								<option value="Barbados">Barbados</option>
								<option value="Belarus">Belarus</option>
								<option value="Belgium">Belgium</option>
								<option value="Belize">Belize</option>
								<option value="Benin">Benin</option>
								<option value="Bermuda">Bermuda</option>
								<option value="Bhutan">Bhutan</option>
								<option value="Bolivia">Bolivia</option>
								<option value="Bonaire">Bonaire</option>
								<option value="Bosnia & Herzegovina">Bosnia & Herzegovina</option>
								<option value="Botswana">Botswana</option>
								<option value="Brazil">Brazil</option>
								<option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
								<option value="Brunei">Brunei</option>
								<option value="Bulgaria">Bulgaria</option>
								<option value="Burkina Faso">Burkina Faso</option>
								<option value="Burundi">Burundi</option>
								<option value="Cambodia">Cambodia</option>
								<option value="Cameroon">Cameroon</option>
								<option value="Canada">Canada</option>
								<option value="Canary Islands">Canary Islands</option>
								<option value="Cape Verde">Cape Verde</option>
								<option value="Cayman Islands">Cayman Islands</option>
								<option value="Central African Republic">Central African Republic</option>
								<option value="Chad">Chad</option>
								<option value="Channel Islands">Channel Islands</option>
								<option value="Chile">Chile</option>
								<option value="China">China</option>
								<option value="Christmas Island">Christmas Island</option>
								<option value="Cocos Island">Cocos Island</option>
								<option value="Colombia">Colombia</option>
								<option value="Comoros">Comoros</option>
								<option value="Congo">Congo</option>
								<option value="Cook Islands">Cook Islands</option>
								<option value="Costa Rica">Costa Rica</option>
								<option value="Cote DIvoire">Cote DIvoire</option>
								<option value="Croatia">Croatia</option>
								<option value="Cuba">Cuba</option>
								<option value="Curaco">Curacao</option>
								<option value="Cyprus">Cyprus</option>
								<option value="Czech Republic">Czech Republic</option>
								<option value="Denmark">Denmark</option>
								<option value="Djibouti">Djibouti</option>
								<option value="Dominica">Dominica</option>
								<option value="Dominican Republic">Dominican Republic</option>
								<option value="East Timor">East Timor</option>
								<option value="Ecuador">Ecuador</option>
								<option value="Egypt">Egypt</option>
								<option value="El Salvador">El Salvador</option>
								<option value="Equatorial Guinea">Equatorial Guinea</option>
								<option value="Eritrea">Eritrea</option>
								<option value="Estonia">Estonia</option>
								<option value="Ethiopia">Ethiopia</option>
								<option value="Falkland Islands">Falkland Islands</option>
								<option value="Faroe Islands">Faroe Islands</option>
								<option value="Fiji">Fiji</option>
								<option value="Finland">Finland</option>
								<option value="France">France</option>
								<option value="French Guiana">French Guiana</option>
								<option value="French Polynesia">French Polynesia</option>
								<option value="French Southern Ter">French Southern Ter</option>
								<option value="Gabon">Gabon</option>
								<option value="Gambia">Gambia</option>
								<option value="Georgia">Georgia</option>
								<option value="Germany">Germany</option>
								<option value="Ghana">Ghana</option>
								<option value="Gibraltar">Gibraltar</option>
								<option value="Great Britain">Great Britain</option>
								<option value="Greece">Greece</option>
								<option value="Greenland">Greenland</option>
								<option value="Grenada">Grenada</option>
								<option value="Guadeloupe">Guadeloupe</option>
								<option value="Guam">Guam</option>
								<option value="Guatemala">Guatemala</option>
								<option value="Guinea">Guinea</option>
								<option value="Guyana">Guyana</option>
								<option value="Haiti">Haiti</option>
								<option value="Hawaii">Hawaii</option>
								<option value="Honduras">Honduras</option>
								<option value="Hong Kong">Hong Kong</option>
								<option value="Hungary">Hungary</option>
								<option value="Iceland">Iceland</option>
								<option value="Indonesia">Indonesia</option>
								<option value="India">India</option>
								<option value="Iran">Iran</option>
								<option value="Iraq">Iraq</option>
								<option value="Ireland">Ireland</option>
								<option value="Isle of Man">Isle of Man</option>
								<option value="Israel">Israel</option>
								<option value="Italy">Italy</option>
								<option value="Jamaica">Jamaica</option>
								<option value="Japan">Japan</option>
								<option value="Jordan">Jordan</option>
								<option value="Kazakhstan">Kazakhstan</option>
								<option value="Kenya">Kenya</option>
								<option value="Kiribati">Kiribati</option>
								<option value="Korea North">Korea North</option>
								<option value="Korea Sout">Korea South</option>
								<option value="Kuwait">Kuwait</option>
								<option value="Kyrgyzstan">Kyrgyzstan</option>
								<option value="Laos">Laos</option>
								<option value="Latvia">Latvia</option>
								<option value="Lebanon">Lebanon</option>
								<option value="Lesotho">Lesotho</option>
								<option value="Liberia">Liberia</option>
								<option value="Libya">Libya</option>
								<option value="Liechtenstein">Liechtenstein</option>
								<option value="Lithuania">Lithuania</option>
								<option value="Luxembourg">Luxembourg</option>
								<option value="Macau">Macau</option>
								<option value="Macedonia">Macedonia</option>
								<option value="Madagascar">Madagascar</option>
								<option value="Malaysia" selected>Malaysia</option>
								<option value="Malawi">Malawi</option>
								<option value="Maldives">Maldives</option>
								<option value="Mali">Mali</option>
								<option value="Malta">Malta</option>
								<option value="Marshall Islands">Marshall Islands</option>
								<option value="Martinique">Martinique</option>
								<option value="Mauritania">Mauritania</option>
								<option value="Mauritius">Mauritius</option>
								<option value="Mayotte">Mayotte</option>
								<option value="Mexico">Mexico</option>
								<option value="Midway Islands">Midway Islands</option>
								<option value="Moldova">Moldova</option>
								<option value="Monaco">Monaco</option>
								<option value="Mongolia">Mongolia</option>
								<option value="Montserrat">Montserrat</option>
								<option value="Morocco">Morocco</option>
								<option value="Mozambique">Mozambique</option>
								<option value="Myanmar">Myanmar</option>
								<option value="Nambia">Nambia</option>
								<option value="Nauru">Nauru</option>
								<option value="Nepal">Nepal</option>
								<option value="Netherland Antilles">Netherland Antilles</option>
								<option value="Netherlands">Netherlands (Holland, Europe)</option>
								<option value="Nevis">Nevis</option>
								<option value="New Caledonia">New Caledonia</option>
								<option value="New Zealand">New Zealand</option>
								<option value="Nicaragua">Nicaragua</option>
								<option value="Niger">Niger</option>
								<option value="Nigeria">Nigeria</option>
								<option value="Niue">Niue</option>
								<option value="Norfolk Island">Norfolk Island</option>
								<option value="Norway">Norway</option>
								<option value="Oman">Oman</option>
								<option value="Pakistan">Pakistan</option>
								<option value="Palau Island">Palau Island</option>
								<option value="Palestine">Palestine</option>
								<option value="Panama">Panama</option>
								<option value="Papua New Guinea">Papua New Guinea</option>
								<option value="Paraguay">Paraguay</option>
								<option value="Peru">Peru</option>
								<option value="Phillipines">Philippines</option>
								<option value="Pitcairn Island">Pitcairn Island</option>
								<option value="Poland">Poland</option>
								<option value="Portugal">Portugal</option>
								<option value="Puerto Rico">Puerto Rico</option>
								<option value="Qatar">Qatar</option>
								<option value="Republic of Montenegro">Republic of Montenegro</option>
								<option value="Republic of Serbia">Republic of Serbia</option>
								<option value="Reunion">Reunion</option>
								<option value="Romania">Romania</option>
								<option value="Russia">Russia</option>
								<option value="Rwanda">Rwanda</option>
								<option value="St Barthelemy">St Barthelemy</option>
								<option value="St Eustatius">St Eustatius</option>
								<option value="St Helena">St Helena</option>
								<option value="St Kitts-Nevis">St Kitts-Nevis</option>
								<option value="St Lucia">St Lucia</option>
								<option value="St Maarten">St Maarten</option>
								<option value="St Pierre & Miquelon">St Pierre & Miquelon</option>
								<option value="St Vincent & Grenadines">St Vincent & Grenadines</option>
								<option value="Saipan">Saipan</option>
								<option value="Samoa">Samoa</option>
								<option value="Samoa American">Samoa American</option>
								<option value="San Marino">San Marino</option>
								<option value="Sao Tome & Principe">Sao Tome & Principe</option>
								<option value="Saudi Arabia">Saudi Arabia</option>
								<option value="Senegal">Senegal</option>
								<option value="Seychelles">Seychelles</option>
								<option value="Sierra Leone">Sierra Leone</option>
								<option value="Singapore">Singapore</option>
								<option value="Slovakia">Slovakia</option>
								<option value="Slovenia">Slovenia</option>
								<option value="Solomon Islands">Solomon Islands</option>
								<option value="Somalia">Somalia</option>
								<option value="South Africa">South Africa</option>
								<option value="Spain">Spain</option>
								<option value="Sri Lanka">Sri Lanka</option>
								<option value="Sudan">Sudan</option>
								<option value="Suriname">Suriname</option>
								<option value="Swaziland">Swaziland</option>
								<option value="Sweden">Sweden</option>
								<option value="Switzerland">Switzerland</option>
								<option value="Syria">Syria</option>
								<option value="Tahiti">Tahiti</option>
								<option value="Taiwan">Taiwan</option>
								<option value="Tajikistan">Tajikistan</option>
								<option value="Tanzania">Tanzania</option>
								<option value="Thailand">Thailand</option>
								<option value="Togo">Togo</option>
								<option value="Tokelau">Tokelau</option>
								<option value="Tonga">Tonga</option>
								<option value="Trinidad & Tobago">Trinidad & Tobago</option>
								<option value="Tunisia">Tunisia</option>
								<option value="Turkey">Turkey</option>
								<option value="Turkmenistan">Turkmenistan</option>
								<option value="Turks & Caicos Is">Turks & Caicos Is</option>
								<option value="Tuvalu">Tuvalu</option>
								<option value="Uganda">Uganda</option>
								<option value="United Kingdom">United Kingdom</option>
								<option value="Ukraine">Ukraine</option>
								<option value="United Arab Erimates">United Arab Emirates</option>
								<option value="United States of America">United States of America</option>
								<option value="Uraguay">Uruguay</option>
								<option value="Uzbekistan">Uzbekistan</option>
								<option value="Vanuatu">Vanuatu</option>
								<option value="Vatican City State">Vatican City State</option>
								<option value="Venezuela">Venezuela</option>
								<option value="Vietnam">Vietnam</option>
								<option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
								<option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
								<option value="Wake Island">Wake Island</option>
								<option value="Wallis & Futana Is">Wallis & Futana Is</option>
								<option value="Yemen">Yemen</option>
								<option value="Zaire">Zaire</option>
								<option value="Zambia">Zambia</option>
								<option value="Zimbabwe">Zimbabwe</option>
							</select>
	</div>
    <div class="mb-5 mt-5">
		<label for="Contact_no" class="form-label">Contact no</label>
		<input type="text" class="form-control" id="Contact_no" name="Contact_no" value="">
	</div>
    <div class="mb-5 mt-5">
		<label for="Email" class="form-label">Email</label>
		<input type="email" class="form-control" id="Email" name="Email" value="">
	</div>
    <div class="mb-5 mt-5">
		<label for="Race" class="form-label">Race</label>
		<select name="Race" id="Race" class="form-control">
			<option value="">Please Select</option>
			<option value="Malay">Malay</option>
			<option value="Chinese">Chinese</option>
			<option value="Indian">Indian</option>
			<option value="Others">Others</option>
		</select>
	</div>
	</div>
	</div>
	<div class="card mt-3">
	<div class="card-header">Doctor Section</div>
	<div class="card-body">
	    <div class="mb-5 mt-5">
		<label for="Doctor_ name" class="form-label">Doctor name</label>
		<input type="text" class="form-control" id="Doctor_name" name="Doctor_name" value="">
	</div>
    <div class="mb-5 mt-5">
		<label for="Clinical_notes" class="form-label">Clinical notes</label>
		<input type="text" class="form-control" id="Clinical_notes" name="Clinical_notes" value="">
	</div>
    <div class="mb-5 mt-5">
		<label for="Diagnosis" class="form-label">Diagnosis</label>
		<input type="text" class="form-control" id="Diagnosis" name="Diagnosis" value="">
	</div>
   
    <div class="mb-5 mt-5">
		<input type="text" class="form-control" id="Medication" name="Medication" value="" hidden>
		<p><strong>Prescribed Med</strong></p>
		<div class="card">
			<div id="" class="card-body">
			<label for="Medication" class="form-label"><strong>Search Medication</strong></label>
			<input type="text" class="form-control" id="searchmed" name="searchmed" value="" onkeyup="getMeds(this)">
			<p class="mt-3">Search Result</p>
			<div id="suggestion">
			 <p></p>
			</div>
			<p>Prescribed Medication</p>
			<div id="prescibedmed"></div>	
			</div>
		</div>
	</div>
	</div>
	</div>
	    <div class="mb-5 mt-5">
		<label for="Date" class="form-label">Date</label>
		<input type="date" class="form-control" id="Date" name="Date" value="<?php echo date('Y-m-d'); ?>">
	</div>

	 <div class="mb-5 mt-5">
		<label for="Management" class="form-label">Management</label>
		<input type="text" class="form-control" id="Management" name="Management" value="">
	</div>
    <div class="mb-5 mt-5"><button class="btn epink-btn-primary" type="submit" name="submitted" >SUBMIT</button></div>
</form>
		</div>
	</div>
</div>
<script>
function searchMed(element){
	let tosearch = element.value;
}
var inputs = ["Name",
"Ic",
"Gender",
"Address",
"Postcode",
"Country",
"Contact_no",
"Email",
"Race",
"Clinical_notes",
"Diagnosis",
"Management",
"Medication",
"Doctor_ name",
"Date"];

for (let i = 0; i < inputs.length; i++) {
  //document.getElementById("forms").innerHTML += '<div class="mb-5 mt-5"><label for="'+inputs[i]+'" class="form-label">'+inputs[i]+'</label><input type="text" class="form-control" id="'+inputs[i]+'" name="'+inputs[i]+'" value="" ></div>';
}
 //document.getElementById("forms").innerHTML += '<div class="mb-5 mt-5"><button class="btn epink-btn-primary" type="submit">SUBMIT</button></div>';
 
 function getMeds(element){
		var medtosearch = element.value;
		var serverUrl = "https://epink.health/api/index.php";
	 	var dataTopost = "api=1&getmed="+medtosearch;
		var fileupload = new XMLHttpRequest();
			fileupload.open("POST", serverUrl, true);
			fileupload.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			fileupload.onload = function() {
			if (fileupload.status == 200) {
					var json = fileupload.responseText;
					var response = JSON.parse(json);
					document.getElementById("suggestion").innerHTML = '';
						for (let i = 0; i < response.length; i++) {
							document.getElementById("suggestion").innerHTML += '<a href="#!" onclick="setMed(\''+response[i].medicine_name+'\')">'+response[i].medicine_name+'</a><br>';
						}
				} else if (fileupload.status == 404) {
					alert("Fail to connect to our server");
				} else {
					alert("Fail to connect to our server");
				}
			}
			fileupload.send(dataTopost);
 }
 
 var prescribedMed = [];
 function setMed(medname){
	 document.getElementById("suggestion").innerHTML = '';
	 prescribedMed.push(medname);
	 console.log(JSON.stringify(prescribedMed));
	 renderPres();
 }
 function removeFrommed(id){
	 prescribedMed.splice(id, 1);
	 renderPres();
 }
 function renderPres(){
	document.getElementById("prescibedmed").innerHTML = '';
	for (let i = 0; i < prescribedMed.length; i++) {
		 document.getElementById("prescibedmed").innerHTML += '<div class="card mb-3"><div class="card-body"><p>'+prescribedMed[i]+' <a class="float-end" onclick="removeFrommed('+i+')">Remove</a></p></div></div>';
	}
	document.getElementById("Medication").value = JSON.stringify(prescribedMed);
 }
</script>