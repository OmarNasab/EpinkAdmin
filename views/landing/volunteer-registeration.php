<?php 
    if(isset($_POST["form-submit"])){
        $email = cleanInput($_POST["email"]);
        $position = cleanInput($_POST["position"]);
        $fullname = cleanInput($_POST["fullname"]);
        $ic = cleanInput($_POST["ic"]);
        $current_address = cleanInput($_POST["current_address"]);
        $permanent_address = cleanInput($_POST["permanent_address"]);
        $phone_number = cleanInput($_POST["phone_number"]);
        $whatsapp_telegram_number = cleanInput($_POST["whatsapp_telegram_number"]);
        $gender = cleanInput($_POST["gender"]);
        $nationality = cleanInput($_POST["Nationality"]);
        $bank = cleanInput($_POST["bank"]);
        $bank_account_number = cleanInput($_POST["bank_account_number"]);
        $counsil = cleanInput($_POST["counsil_number"]);
        $counsil_number = cleanInput($_POST["counsil_number"]);
        $type_of_healthcare_services_center = cleanInput($_POST["type_of_healthcare_services_center"]);
        $ic_front = processFile($_POST["ic_front"]);
        $ic_back = processFile($_POST["ic_back"]);
        
        $pdpa_clause = cleanInput($_POST["pdpa_clause"]);
		if($email != "" && $position != "" && $fullname != "" && $ic != "" && $current_address != "" && $permanent_address != "" && $phone_number != "" && $whatsapp_telegram_number != "" && $gender != "" && $nationality != "" && $bank != "" &&$bank_account_number != "" && $counsil != "" && $type_of_healthcare_services_center != "" && $ic_front != "" && $ic_back != "" && $pdpa_clause != ""){
			if($counsil_number == "" && $counsil == "none"){
				$cansubmit = true;
			}elseif($counsil != "none" && $counsil != ""){
				$cansubmit = true;
			}else{
				$cansubmit = false;
			}
			if($counsil != "none"){
				$upload_apc = processFile($_POST["upload_apc"]);
			}else{
				$upload_apc = "none";
			}
			if($cansubmit == true){
				$sql = "INSERT INTO vol (email, position, fullname, ic, current_address, permanent_address, phone_number, whatsapp_telegram_number, gender, nationality, bank, bank_account_number, counsil_number, type_of_healthcare_services_center, ic_front, ic_back, upload_apc, pdpa_clause) VALUES ('$email', '$position', '$fullname', '$ic', '$current_address', '$permanent_address', '$phone_number', '$whatsapp_telegram_number', '$gender', '$nationality', '$bank', '$bank_account_number', '$counsil_number', '$type_of_healthcare_services_center', '$ic_front', '$ic_back', '$upload_apc', '$pdpa_clause')";
				
				if ($db->query($sql) === TRUE) {
					$response = "Your submission has been submitted successfully"; 
				}else{
					$response = "Error: " . $sql . "<br>" . $db->error; 
				}
			}else{
				$response = "Please fill all the form"; 
			}
		}else{
			$response = "Please fill all the form"; 
		}
    } 
?>
<section class="bg-white py-5">
<div class="container px-10">
	<h1>Volunteer Registeration</h1>
	<p>Sign up our volunteers</p>
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
    <form method="POST" class="mt-5">
        <div class="form-group mb-3">
            <label>Email</label>
            <input type="text" class="form-control" id="email" name="email">
        </div>
        <div class="form-groupmb-3">
            <label>Position</label>
			<select class="form-control" id="position" name="position">
				<option value="">Please Select</option>
				<option value="Doctor">Doctor</option>
				<option value="Pharmacist">Pharmacist</option>
				<option value="Nurse">Nurse</option>
				<option value="Non Medical volunteers">Non Medical volunteers</option>
				<option value="Dentist">Dentist</option>
				<option value="Medical Assistant / Assistant Medical Officer">Medical Assistant / Assistant Medical Officer</option>
			</select>
        </div>
        <div class="form-group mb-3">
            <label>Full name</label>
            <input type="text" class="form-control" id="fullname" name="fullname">
        </div>
        <div class="form-group mb-3">
            <label>IC</label>
            <input type="text" class="form-control" id="ic" name="ic">
        </div>
        <div class="form-group mb-3">
            <label>Current Address</label> 
            <input type="text" class="form-control" id="current_address" name="current_address">
        </div>
        <div class="form-group mb-3">
            <label>Permanent Address</label>
            <input type="text" class="form-control" id="permanent_address" name="permanent_address">
        </div>
        <div class="form-group mb-3">
            <label>Phone Number</label>
            <input type="text" class="form-control" id="phone_number" name="phone_number">
        </div>
        <div class="form-group mb-3">
            <label>Whatsapp/Telegram Number</label>
            <input type="text" class="form-control" id="whatsapp_telegram_number" name="whatsapp_telegram_number">
        </div>
        <div class="form-group mb-3">
            <label>Gender</label>
			<select class="form-control" id="gender" name="gender">
				<option value="">Please Select</option>
				<option value="Male">Male</option>
				<option value="Female">Female</option>
			</select>
        </div>
        <div class="form-group mb-3">
            <label>Nationality</label>
			<select class="form-control" id="Nationality" name="Nationality">
				<option value="">Please Select</option>
				<option value="Malaysian">Malaysian</option>
				<option value="Non Malaysian">Non Malaysian</option>
			</select>
        </div>
        <div class="form-group mb-3">
            <label>Bank Name</label>
			<select class="form-control" id="bank" name="bank">
				<option value="">Please Select</option>
				<option value="Affin Bank Berhad">Affin Bank Berhad</option>
				<option value="Alliance  Bank Malaysia Berhad">Alliance  Bank Malaysia Berhad</option>
				<option value="Ambank(M) Berhad">Ambank(M) Berhad</option>
				<option value="CIMB Bank Berhad">CIMB Bank Berhad</option>
				<option value="Malayan Banking Berhad (Maybank)">Malayan Banking Berhad (Maybank)</option>
				<option value="Hong Leong  Bank Berhad">Hong Leong Bank Berhad</option>
				<option value="Public Bank Berhad">Public Bank Berhad</option>
				<option value="RHB Bank Berhad">RHB Bank Berhad</option>
				<option value="Standard Chartered Bank Malaysia Berhad">Standard Chartered Bank Malaysia Berhad</option>
				<option value="Bank Simpanan Nasional Berhad (BSN)">Bank Simpanan Nasional Berhad (BSN)</option>
				<option value="Bank Islam Malaysia Berhad">Bank Islam Malaysia Berhad</option>
				<option value="Bank Muamalat Malaysia Berhad">Bank Muamalat Malaysia Berhad</option>
				<option value="Bank Kerjasama Rakyat Malaysia Berhad (Bank Rakyat)">Bank Kerjasama Rakyat Malaysia Berhad (Bank Rakyat)</option>
			</select>
        </div>
        <div class="form-group mb-3">
            <label>Bank Account Number</label>
            <input type="text" class="form-control" id="bank_account_number" name="bank_account_number">
        </div>
        <div class="form-group mb-3">
            <label>Council</label>
			<select class="form-control" id="counsil" name="counsil">
				<option value="">Please Select</option>
				<option value="none">None</option>
				<option value="Malaysian Medical Council ( Majlis Perubatan Malaysia)">Malaysian Medical Council ( Majlis Perubatan Malaysia)</option>
				<option value="National Specialist Registry">National Specialist Registry</option>
				<option value="Malaysian Dental Council ( Majlis Pergigian Malaysia)   ">Malaysian Dental Council ( Majlis Pergigian Malaysia)</option>
				<option value="Malaysia Pharmacy Board ( Lembaga Farmasi Malaysia )">Malaysia Pharmacy Board ( Lembaga Farmasi Malaysia )</option>
				<option value="National Nursing Board, ( Lembaga  Jururawat Malaysia )">National Nursing Board, ( Lembaga  Jururawat Malaysia )</option>
				<option value="National Midwife Board  ( Lembaga Bidan Malaysia)">National Midwife Board  ( Lembaga Bidan Malaysia)</option>
				<option value="National Nursing Board, ( Lembaga  Jururawat Malaysia )">Medical Assistant Board( Lembaga Pembantu Perubatan)</option>
			</select>
        </div>
        <div class="form-group mb-3">
            <label>Council Number (Please fill your council number if your council is not none)</label>
            <input type="text" class="form-control" id="counsil_number" name="counsil_number">
			
			
        </div>
        <div class="form-group mb-3">
            <label>Type of healthcare services center</label>
			<select class="form-control" id="type_of_healthcare_services_center" name="type_of_healthcare_services_center">
				<option value="">Please Select</option>
				<option value="Government">Government</option>
				<option value="Private">Private</option>
				<option value="Self-empolyed or Freelance healthcare service provider">Self-empolyed or Freelance healthcare service provider</option>
				<option value="Non-medical Executive">Non-medical Executive</option>
			</select>
        </div>
        <div class="form-group mb-3">
            <label>IC front (Photo)</label>
            <input type="file" class="form-control" id="fl3" name="fl3" onchange="convertImage(this, 'ic_front')">
			 <input type="text" class="form-control" id="ic_front" name="ic_front" hidden>
        </div>
        <div class="form-group mb-3">
            <label>IC back (Photo)</label>
            <input type="file" class="form-control" id="fl2" name="fl2" onchange="convertImage(this, 'ic_back')">
            <input type="text" class="form-control" id="ic_back" name="ic_back" hidden>
        </div>
        <div class="form-group mb-3">
            <label>APC (PDF)</label>
            <input type="file" class="form-control" id="fl" name="fl" onchange="convertImage(this, 'upload_apc')" accept="application/pdf">
			<input type="text" class="form-control" id="upload_apc" name="upload_apc" hidden>
        </div>
		<br><br>
        <div class="form-group mb-3">
            <label>PPDA Clause</label>
			<p class="small">By submitting this Form, you hereby agree that ePink Health sdn.bhd. may collect, obtain, store and process your personal data that you provide in this form for the purpose of receiving updates, news, promotional and marketing mails or materials from  ePink Health sdn.bhd. You hereby give your consent to  ePink Health sdn.bhd. to store and process your Personal Data. For the avoidance of doubt, Personal Data includes all data defined within the Personal Data Protection Act 2010 including all data you had disclosed to  ePink Health sdn.bhd. in this Form.</p>
            <input type="text" class="form-control" id="pdpa_clause" name="pdpa_clause" value="I agree" hidden>
        </div>
        <button id="subbutton" type="submit" name="form-submit" class="btn epink-btn-primary">Submit</button>
		<p id="helper" ></p>
    </form>
</div>
</section>
<script>
	function convertImage(element, target){
		document.getElementById("subbutton").disabled = true;
		document.getElementById("helper").innerHTML = 'Please wait processing files...';
		var file1 = element.files[0];
		var reader = new FileReader();
		reader.onloadend = function() {
			document.getElementById(target).value = reader.result;	
			document.getElementById("subbutton").disabled = false;
			document.getElementById("helper").innerHTML = 'Ready to submit';
		}
		reader.readAsDataURL(file1);
	}
	</script>