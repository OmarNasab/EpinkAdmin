<?php 
    if(isset($_POST["form-submit"])){
        $full_name = cleanInput($_POST["full_name"]);
        $ic_passport_no = cleanInput($_POST["ic_passport_no"]);
        $age = cleanInput($_POST["age"]);
        $gender = cleanInput($_POST["gender"]);
        $my_sejahtera_id = cleanInput($_POST["my_sejahtera_id"]);
        $contact_number = cleanInput($_POST["contact_number"]);
        $nationality = cleanInput($_POST["nationality"]);
        $ethnicity = cleanInput($_POST["ethnicity"]);
        $Second_dose_date = cleanInput($_POST["Second_dose_date"]);
        $Second_dose_vaccine_name = cleanInput($_POST["Second_dose_vaccine_name"]);
        $state = cleanInput($_POST["state"]);
        $district = cleanInput($_POST["district"]);
		
		if($full_name != "" && $ic_passport_no != "" && $age != "" && $gender != "" && $my_sejahtera_id != "" && $contact_number != "" && $nationality != "" && $ethnicity != "" && $Second_dose_date != "" && $Second_dose_vaccine_name != "" && $state != "" && $district != ""){
			$sql = "INSERT INTO promo_vaccine (full_name, ic_passport_no, age, gender, my_sejahtera_id,  contact_number, nationality, ethnicity, second_dose_date, second_dose_vaccine_name, state, district) VALUES ('$full_name', '$ic_passport_no', '$age', '$gender', '$my_sejahtera_id', '$contact_number', '$nationality', '$ethnicity', '$Second_dose_date', '$Second_dose_vaccine_name', '$state', '$district')";
			
			if ($db->query($sql) === TRUE) {
				$response = "Your submission has been submitted successfully. We will get back to you in 24 to 48 hour"; 
			}else{
				$response = "Error: " . $sql . "<br>" . $db->error; 
			}
		}else{
			$response = "Please fill all the form"; 
		}
    } 
?>
<section class="bg-white py-5 ">
<div class="container px-10">
<?php 
    if(isset($response)){
		if($response == "Please fill all the form"){
			$cardtype = "bg-warning";
		}else{
			$cardtype = "bg-success";
		}
		 echo '<div class="card mb-5 mt-5 '.$cardtype.' text-white">
					<div class="card-body">'.$response.'</div>
				</div>';
    } 
    ?>
<h1>Individual</h1>
<p>Register to outreach program as individual</p>
	
</div>
<div class="container py-3 px-10">
    
    <form method="POST">
        <div class="form-group mt-3 mb-3">
            <label>Full Name</label>
            <input type="text" class="form-control" id="full name" name="full name">
        </div>
        <div class="form-group mt-3 mb-3">
            <label>IC/Passport No</label>
            <input type="text" class="form-control" id="ic_passport_no" name="ic_passport_no">
        </div>
        <div class="form-group mt-3 mb-3">
            <label>Age</label>
            <input type="number" class="form-control" id="age" name="age">
        </div>
        <div class="form-group mt-3 mb-3">
            <label>Gender</label>
			<select class="form-control" id="gender" name="gender">
				<option value="">Please select</option>
				<option value="Male">Male</option>
				<option value="Female">Female</option>
			</select>
        </div>
        <div class="form-group mt-3 mb-3">
            <label>My Sejahtera Id</label>
            <input type="text" class="form-control" id="my_sejahtera_id" name="my_sejahtera_id">
        </div>
        <div class="form-group mt-3 mb-3">
            <label>Contact Number</label>
            <input type="text" class="form-control" id="contact_number" name="contact_number">
        </div>
        <div class="form-group mt-3 mb-3">
            <label>Nationality</label>
			<select class="form-control" id="nationality" name="nationality">
				<option value="">Please select</option>
				<option value="Malaysian">Malaysian</option>
				<option value="Non Malaysian">Non Malaysian</option>
			</select>
        </div>
        <div class="form-group mt-3 mb-3">
            <label>Ethnicity</label>
         
			<select class="form-control" id="ethnicity" name="ethnicity">
				<option value="">Please select</option>
				<option value="Malay">Malay</option>
				<option value="Chinese">Chinese</option>
				<option value="Indian">Indian</option>
				<option value="Others">Others</option>
			</select>
        </div>
        <div class="form-group mt-3 mb-3">
            <label>2nd Dose Date</label>
            <input type="date" class="form-control" id="Second_dose_date" name="Second_dose_date">
        </div>
        <div class="form-group mt-3 mb-3">
            <label>Second Dose Vaccine Name</label>
			<select class="form-control" id="Second_dose_vaccine_name" name="Second_dose_vaccine_name">
				<option value="">Please select</option>
				<option value="Pfizer">Pfizer</option>
				<option value="Astra">Astra</option>
				<option value="Sinovac">Sinovac</option>
				<option value="Sinopharm">Sinopharm</option>
				<option value="Cansino">Cansino</option>
			</select>
        </div>
        <div class="form-group mt-3 mb-3">
            <label>State</label>
			<select class="form-control" id="state" name="state">
				<option value="">Please select</option>
				<option value="Johor">Johor</option>
				<option value="Kedah">Kedah</option>
				<option value="Kelantan">Kelantan</option>
				<option value="Kuala Lumpur">Kuala Lumpur</option>
				<option value="Labuan">Labuan</option>
				<option value="Melaka">Melaka</option>
				<option value="Negeri Sembilan">Negeri Sembilan</option>
				<option value="Pahang">Pahang</option>
				<option value="Penang">Penang</option>
				<option value="Perak">Perak</option>
				<option value="Perlis">Perlis</option>
				  <option value="Putrajaya">Putrajaya</option>
				  <option value="Sabah">Sabah</option>
				  <option value="Sarawak">Sarawak</option>
				  <option value="Selangor">Selangor</option>
				  <option value="Terengganu">Terengganu</option>
			</select>
        </div>
		<div class="form-group mt-3 mb-3">
            <label>District</label>
            <input type="text" class="form-control" id="district" name="district">
        </div>
        <button type="submit" name="form-submit" class="btn epink-btn-primary">Submit</button>
    </form>
</div>
</section>
