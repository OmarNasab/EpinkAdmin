<?php 
    if(isset($_POST["form-submit"])){
				$preferred_district = cleanInput($_POST["preferred_district"]);
				$preferred_date = cleanInput($_POST["preferred_date"]);
				$preferred_time = cleanInput($_POST["preferred_time"]);
				$preferred_state = cleanInput($_POST["preferred_state"]);
				$ic = cleanInput($_POST["ic"]);
				
				$sql = "SELECT * FROM vol WHERE ic='$ic'";
				$result = $db->query($sql);

				if ($result->num_rows > 0){
					if($preferred_district != "" && $preferred_date != "" && $preferred_time != "" && $preferred_state != "" && $ic != ""){
						$sql = "UPDATE vol SET preferred_district = '$preferred_district',  preferred_date = '$preferred_date',  preferred_time = '$preferred_time',  preferred_state = '$preferred_state',  ic = '$ic'  WHERE ic='$ic'";
						if ($db->query($sql) === TRUE) {
							$response = 'Your submission has been submitted successfully'; 
						}else{
							$response = 'Error updating record';
						}
					}else{
						$response='Please fill all the form'; 
					}
				}else{
					$response='We cant find your IC here. Please sign up as volunteer before booking your slot <a href="https://epink.health/outreach/volunteers/" class="text-white"><strong>here</strong></a>'; 
				}



		
    } 
?>
<section class="bg-white py-5">
<div class="container px-3">
	<h1>Volunteer Slot Management</h1>
	
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
	    <div class="form-group">
            <label>IC</label>
            <input type="text" class="form-control" id="ic" name="ic">
        </div>
		<div class="form-group mb-5">
            <label>Preferred State</label>
			<select class="form-control" id="preferred_state" name="preferred_state">
			      <option  value="Johor">Johor</option>
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
        <div class="form-group mb-5">
            <label>Preferred District</label>
            <input type="text" class="form-control" id="preferred_district" name="preferred_district">
        </div>
		<div class="form-group mb-5">
            <label>Preferred Date</label>
            <input type="date" class="form-control" id="preferred_date" name="preferred_date" >
        </div>     
        <div class="form-group mb-5">
            <label>Preferred Time</label>
            <input type="text" class="form-control" id="preferred_time" name="preferred_time" hidden>
			<div class="card mb-3">
				<div class="card-body" id="timeselectedui">
				
				</div>
			</div>
			<p>Select prefered time slot</p>
			<a class="badge badge-marketing bg-primary-soft rounded-pill text-primary mb-3" href="#!" onclick="setPreferedtime('9AM -10 AM')">9-10 AM</a> 
			<a class="badge badge-marketing bg-primary-soft rounded-pill text-primary mb-3" href="#!" onclick="setPreferedtime('10AM - 11AM')">10-11 AM</a> 
			<a class="badge badge-marketing bg-primary-soft rounded-pill text-primary mb-3" href="#!" onclick="setPreferedtime('11AM - 12PM')">11-12 PM</a> 
			<a class="badge badge-marketing bg-primary-soft rounded-pill text-primary mb-3" href="#!" onclick="setPreferedtime('12PM - 01PM')">12-01 PM</a> 
			<a class="badge badge-marketing bg-primary-soft rounded-pill text-primary mb-3" href="#!" onclick="setPreferedtime('01PM - 02PM')">01-02 PM</a> 
			<a class="badge badge-marketing bg-primary-soft rounded-pill text-primary mb-3" href="#!" onclick="setPreferedtime('02PM - 03PM')">02-03 PM</a> 
			<a class="badge badge-marketing bg-primary-soft rounded-pill text-primary mb-3" href="#!" onclick="setPreferedtime('03PM - 04PM')">03-04 PM</a> 
			<a class="badge badge-marketing bg-primary-soft rounded-pill text-primary mb-3" href="#!" onclick="setPreferedtime('04PM - 05PM')">04-05 PM</a> 
			<a class="badge badge-marketing bg-primary-soft rounded-pill text-primary mb-3" href="#!" onclick="setPreferedtime('05PM - 06PM')">05-06 PM</a> 
        </div>
        <button type="submit" name="form-submit" class="btn epink-btn-primary">Submit</button>
    </form>

</div>
</section>
<script>
	var times = [];
	function setPreferedtime(time){
		if (!times.includes(time)) {
				times.push(time);
				document.getElementById("preferred_time").value = JSON.stringify(times);
				render();
		}else{
			alert("Already added");
		}
	}
	function render(){
		document.getElementById("timeselectedui").innerHTML = '';
		for(let i = 0; i < times.length; i++){
			document.getElementById("timeselectedui").innerHTML += '<span class="badge badge-marketing epink-bg-primary rounded-pill text-white mb-3" href="#!" onclick="deletePreferedTime('+i+')">'+times[i]+' X</span>';
		}
	}
	
	function deletePreferedTime(id){
		times.splice(id, 1);
		render();
	}
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