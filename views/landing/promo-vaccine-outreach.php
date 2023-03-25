<?php 
    if(isset($_POST["form-submit"])){
        $company_name = cleanInput($_POST["company_name"]);
        $company_state = cleanInput($_POST["company_state"]);
        $company_phone_number = cleanInput($_POST["company_phone_number"]);
        $excel_file = processFile($_POST["excel_file"]);
		$postcode = cleanInput($_POST["postcode"]);
        $company_email = cleanInput($_POST["company_email"]);
        $pic_name = cleanInput($_POST["pic_name"]);
        $company_address = cleanInput($_POST["company_address"]);
        $pic_contact_no = cleanInput($_POST["pic_contact_no"]);
        $quantity = cleanInput($_POST["quantity"]);
		
		if($company_name != "" && $company_state != "" && $company_phone_number != "" && $excel_file != "" && $postcode != "" && $company_email != "" && $pic_name != "" && $company_address != "" && $pic_contact_no != "" && $quantity != ""){

			$sql = "INSERT INTO outreach_corporate (company_name, company_state, company_phone_number, excel_file, postcode, company_email, pic_name, company_address, pic_contact_no, quantity) VALUES ('$company_name', '$company_state', '$company_phone_number', '$excel_file', '$postcode', '$company_email', '$pic_name', '$company_address', '$pic_contact_no', '$quantity')";
			
			if ($db->query($sql) === TRUE) {
				$response = "Your submission has been submitted successfully"; 
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
		 echo ' <div class="card mb-5 mt-5 '.$cardtype.' text-white">
					<div class="card-body">'.$response.'</div>
				</div>';
    } 
    ?>
<h1>Corporate / NGO Registeration</h1>
<p>Register as corporate or non goverment organization</p>

<p><strong>Sample File</strong></p>
<p>Download and fill this excel sample file before submitting <a href="https://epink.health/files/out-reach-corporate.xlsx">Sample File</a></p>

	
</div>
<div class="container py-5 px-10">

<form method="POST"  enctype="multipart/form-data">
        <div class="form-group">
            <label>Company Name</label>
            <input type="text" class="form-control" id="company_name" name="company_name">
        </div>
        <div class="form-group">
            <label>Company Phone Number</label>
            <input type="text" class="form-control" id="company_phone_number" name="company_phone_number">
        </div>
        <div class="form-group">
            <label>Excel File</label>
            <input type="file" class="form-control" id="filex" name="filex" onchange="convertImage(this, 'excel_file')" accept="application/vnd.ms-excel">
            <input type="text" class="form-control" id="excel_file" name="excel_file" hidden>
        </div>
		<div class="form-group">
            <label>Postcode</label>
            <input type="text" class="form-control" id="postcode" name="postcode">
        </div>
        <div class="form-group">
            <label>Company Email</label>
            <input type="text" class="form-control" id="company_email" name="company_email">
        </div>
        
        <div class="form-group">
            <label>Company Address</label>
            <input type="text" class="form-control" id="company_address" name="company_address">
        </div>
		<div class="form-group">
            <label>Company State</label>
            <input type="text" class="form-control" id="company_state" name="company_state">
        </div>
		<div class="form-group">
            <label>PIC Name</label>
            <input type="text" class="form-control" id="pic_name" name="pic_name">
        </div>
        <div class="form-group">
            <label>PIC contact no</label>
            <input type="text" class="form-control" id="pic_contact_no" name="pic_contact_no">
        </div>
        <div class="form-group">
            <label>Quantity</label>
            <input type="number" class="form-control" id="quantity" name="quantity">
        </div>
        <button type="submit" name="form-submit" class="btn epink-btn-primary mt-3">Submit</button>
    </form>
    <script>
	function convertImage(element, target){
		var file1 = element.files[0];
		var reader = new FileReader();
		reader.onloadend = function() {
			document.getElementById(target).value = reader.result;	
		}
		reader.readAsDataURL(file1);
	}
	</script>
</div>
</section>
