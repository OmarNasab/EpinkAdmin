<?php
if(isset($_POST["confirm"])){
        $name = cleanInput($_POST["name"]);
        $icpassport = cleanInput($_POST["icpassport"]);
        $mysejahteraid = cleanInput($_POST["mysejahteraid"]);
        $consentdate = cleanInput($_POST["consentdate"]);
        $agreed = cleanInput($_POST["agreed"]);
        $medicalhistoryone = cleanInput($_POST["medicalhistoryone"]);
        $medicalhistorytwo = cleanInput($_POST["medicalhistorytwo"]);
        $medicalhistorythree = cleanInput($_POST["medicalhistorythree"]);
        $medicalhistoryfour = cleanInput($_POST["medicalhistoryfour"]);

	if($name != "" &&  $icpassport != "" &&  $mysejahteraid != "" &&  $consentdate != "" &&  $agreed != ""){
		$c19consentsql = "INSERT INTO c19consent (name, icpassport, mysejahteraid, consentdate, agreed, medicalhistoryone, medicalhistorytwo, medicalhistorythree, medicalhistoryfour)
		VALUES ('$name', '$icpassport', '$mysejahteraid', '$consentdate', '$agreed', '$medicalhistoryone', '$medicalhistorytwo', '$medicalhistorythree', '$medicalhistoryfour')";

		if ($db->query($c19consentsql) === TRUE) {
			$row["card"] = "green";
			$row["status"] = "Successful";
			$response =  "New record successfully created";
			$data = $row;
		} else {
			$row["card"] = "red";
			$row["status"] = "Fail";
			$response =  "Error: " . $sql . "<br>" . $db->error;
			$data = $row;
		}
	}else{
		$row["card"] = "red";
		$row["status"] = "Fail";
		$response = "Please fill all the form";
		$data = $row;
	}
}

?>

<section class="bg-white py-5">
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
        <h1>COVID-19 VACCINATION CONSENT FORM</h1>
        <p>The COVID-19 vaccine is provided to control the spread of COVID-19 in the country. As the number of those vaccinated increase, so too will the number of those that develop antibodies which will lessen the probability of a more severe illness from COVID-19. Indirectly, we can protect those at risk who are ineligible to receive vaccine injections.</p>
        <p>The Special Committee Meeting of the National Muzakarah Meeting Council on Islamic Religious Affairs Malaysia that was held on 3 December 2020 declared that COVID-19 vaccines were permissible and mandatory for those determined by the Government.</p>
        <p>The COVID-19 injection vaccines will be administered in either one (1) or two (2) doses according to the type of vaccine. The injection is generally administered into the shoulder muscle except in certain circumstances. The type of vaccine that would be provided is subject to the current vaccine supply.</p>
        <p>Receiving COVID-19 vaccines may result in mild side effects and other side effects that may be reported from time to time.</p>
        <p>I have read / it as been read to me the information regarding COVID-19 vaccine, its purpose and the method of administration of the vaccine as provided in the COVID-19 Information Sheet for vaccine recipients.</p>
        <p>I hereby understand that: </p>
        <ol type="1">
            <li>Receiving the COVID-19 vaccines may cause reactions and side effects as stated in the vaccine information;</li>
            <li>I am responsible for any risk that may arise as a result of my decision / action in receiving the vaccine as the benefits of the vaccine outweighs its side effects;</li>
            <li>The vaccine dose not fully guarantee that I will not be infected with COVID-19 in the future;</li>
            <li>By signing this consent to receive the COVID-19 vaccine, I voluntarily agree to complete the number of vaccine doses as scheduled.</li>
        </ol>
        <p>Medical History (Please tick relevant fields)</p>
        <form method="POST">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Experienced severe side effects (such as seizures, fainting spells, and hospital admissions) after obtaining any previous vaccination(s)?" id="medicalhistoryone" name="medicalhistoryone">
                <label class="form-check-label" for="flexCheckDefault">Experienced severe side effects (such as seizures, fainting spells, and hospital admissions) after obtaining any previous vaccination(s)?</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Ever had a history of severe allergy?" name="medicalhistorytwo">
                <label class="form-check-label" for="flexCheckDefault">
                Ever had a history of severe allergy?
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Pregnant or planing to conceive (for women)" name="medicalhistorythree">
                <label class="form-check-label" for="flexCheckDefault">
                Pregnant or planing to conceive (for women)
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Currently breastfeeding? (for women)" id="flexCheckDefault" name="medicalhistoryfour">
                <label class="form-check-label" for="flexCheckDefault">
                Currently breastfeeding? (for women)
                </label>
            </div>
            <div class="form-group mt-5">
                <label>Name as per IC / Passport</label>
                <input type="text" class="form-control" id="" name="name">
            </div>
            <div class="form-group mt-5">
                <label>IC No / Passport No</label>
                <input type="text" class="form-control" id="" name="icpassport">
            </div>
            <div class="form-group mt-5">
                <label>MySejahtera ID</label>
                <input type="text" class="form-control" id="" name="mysejahteraid">
            </div>
            <div class="form-group mt-5">
                <label>Date</label>
                <input type="date" class="form-control" id="" name="consentdate" value="<?php echo date('Y-m-d'); ?>">
            </div>
			            <div class="form-check mt-5">
                <input class="form-check-input" type="checkbox" value="I hereby declare that I agree to receive the COVID-19 Vaccination Injection" name="agreed">
                <label class="form-check-label" for="flexCheckDefault">
                <strong>I hereby declare that I agree to receive the COVID-19 Vaccination Injection</strong>
                </label>
            </div>
            <div class="form-group mt-5">
                <button class="btn epink-btn-primary" id="confirm" name="confirm">CONFIRM</button>
            </div>
        </form>
    </div>
</section>