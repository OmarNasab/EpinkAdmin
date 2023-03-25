<?php
if(isset($_POST["inserttozumba"])){
	$ownerid = $authUser["id"];
        $name = cleanInput($_POST["name"]);
        $phone_number = cleanInput($_POST["phone_number"]);
        $email = cleanInput($_POST["email"]);
        $session = cleanInput($_POST["session"]);
        $pain = cleanInput($_POST["pain"]);
		if($pain == ""){
			$pain = "No";
		}
        $zumba_love = cleanInput($_POST["zumba_love"]);

	if($name != "" &&  $phone_number != "" &&  $email != "" &&  $session != "" &&  $pain != "" &&  $zumba_love != ""){
		$zumbasql = "INSERT INTO zumba (name, phone_number, email, session, pain, zumba_love)
		VALUES ('$name', '$phone_number', '$email', '$session', '$pain', '$zumba_love')";

		if ($db->query($zumbasql) === TRUE) {
			$row["card"] = "green";
			$row["status"] = "Successful";
			$row["message"] =  "Your request has been recieved";
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
<section class="bg-white">
	<div class="container px-5 py-10">
		<?php
		if(isset($row)){
			echo '<div class="card bg-success mb-3"><div class="card-body text-white">'.$row["message"].'</div></div>';
			
		}
		?>
		<h1>About The FREE Zumba Programme</h1>
<p>Date : 12th March 2022</p>
<p>Time : 5pm - 6pm</p>
<p>Venue : Virtual / ePink Health Center (Space U8)</p>

<p class="mb-5">In conjunction with International Women Day, ePink Health is organizing FREE Zumba session for all the women out there!!! Wait no more!! Sign up now for our FREE Zumba  and other FREE health sessions. Hurry Up and register before the deal is gone!!!</p>

		<form id="inserttozumba" method="POST" action="<?php echo $page_url; ?>" > 
		<input type="text" id="csrf" name="csrf" value="<? echo $csrftoken; ?>" hidden>

		<div class="form-group mb-5">
			<label for="name">Name as per IC/Passport</label>
			<input class="form-control" type="text" id="name" name="name">
		</div>

		<div class="form-group mb-5">
			<label for="phone_number">Contact No</label>
			<input class="form-control" type="text" id="phone_number" name="phone_number">
		</div>

		<div class="form-group mb-5">
			<label for="email">Email Address</label>
			<input class="form-control" type="email" id="email" name="email">
		</div>

		<div class="form-group mb-5">
			<label for="session">Zumba Session</label>
			<select class="form-control" id="session" name="session">
				<option value="Walk In">Walk In</option>
				<option value="Virtual">Virtual</option>
			</select>
		</div>

		<div class="form-group mb-5">
			<label for="pain">Do you have any physical pain? (eg. knee pain, back pain, etc.)</label>
			<input class="form-control" type="text" id="pain" name="pain">
			<p class="helper">If yes, please specify. If no please leave empty</p>
		</div>

		<div class="form-group mb-5 mb-5">
			<label for="zumba_love">Do you love to spend time for fitness?</label>
			<select class="form-control" type="text" id="zumba_love" name="zumba_love">
				<option value="Yes">Yes</option>
				<option value="No">No</option>
			</select>
			
		</div>
		<div class="form-group">
		<button class="btn btn-primary white-text" name="inserttozumba" id="inserttozumba" type="submit" >SUBMIT</button> 
		</div>
		</form>
	</div>
</section>