<?php
$staffid = cleanInput($page_action_identifier);
$sql = "SELECT * FROM users WHERE id='$staffid'";
$result = $db->query($sql);
$staff = $result->fetch_assoc();
if($staff["profile_img"] != "img/default_profile_picture.jpg"){
	
}
function getProfile2($id){
	global $db;
	$userid = $db->real_escape_string($id);
	$sql = "SELECT * FROM users WHERE id='$userid'";
	$result = $db->query($sql);
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		$row["password"] = "*********";
		$row["status"] = "success";
		$row["message"] = "User Exist";
		$row["login_token"] = "public";
		return $row;
	} else {
		$row["status"] = "fail";
		$row["message"] = "This user no longer exist";
		return json_encode($row, JSON_PRETTY_PRINT);
	}
}
function getProfilePicture($id){
	global $db;
	$userid = $db->real_escape_string($id);
	$sql = "SELECT * FROM users WHERE id='$userid'";
	$result = $db->query($sql);
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		$row["password"] = "*********";
		$row["status"] = "success";
		$row["message"] = "User Exist";
		$row["login_token"] = "public";
		return $row["profile_img"];
	} else {
		$row["status"] = "fail";
		$row["message"] = "This user no longer exist";
		return json_encode($row, JSON_PRETTY_PRINT);
	}
}
?>
<header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
	<div class="container-fluid px-4">
		<div class="page-header-content">
			<div class="row align-items-center justify-content-between pt-3">
				<div class="col-auto mb-3">
					<h1 class="page-header-title">
						<div class="page-header-icon"><i data-feather="list"></i></div>
						Staff Information
					</h1>
				</div>
			</div>
		</div>
	</div>
</header>
<div class="container-fluid px-4">
	<div class="card">
		<div class="card-header">
			Patient Information
		</div>
		<div class="card-body">
			<img src="<?php echo $staff["profile_img"]; ?>" width="200px">
			<p><strong>Name: </strong><?php
				echo $staff["firstname"].' '.$staff["lastname"];
			?></p>
			<p><strong>IC/Passport: </strong><?php
				echo $staff["ic_number"];
			?></p>

		</div>
	</div>
	<div class="row mt-4">
		<div class="col">
		<div class="card">
			<div class="card-header">
				Medical leave certificate
			</div>
			<div class="card-body">
				<?php
					$ownerid = $staff["id"];
					$sql = "SELECT * FROM chats WHERE owner_one='$ownerid' OR owner_two='$ownerid'";
					$result = $db->query($sql);
					if ($result->num_rows > 0) {
						// output data of each row
						$hasmc = 0;
						while($row = $result->fetch_assoc()){
							
							if($row["signedmc"] != ""){
								echo '<a href="'.$row["signedmc"].'" target=”_blank”> '.$row["session_date"].' - Medical Leave Certificate</a><br>';
								$hasmc++;
							}
							
						}
						if($hasmc == 0){
							echo 'No medical leave certificate';
						}
					} else {
						echo 'No medical leave certificate';
					}
					
				?>
			</div>
	</div>		
		</div>
		<div class="col">
		<div class="card">
			<div class="card-header">
				Lab Test
			</div>
			<div class="card-body">
				<?php
						$requester =  $staff["id"];
						$sql = "SELECT * FROM elab_request WHERE requester='$requester'";
						$result = $db->query($sql);
						if ($result->num_rows > 0) {
							// output data of each row
							while($row = $result->fetch_assoc()) {
								$row["sample_collection_date"] = date("F jS, Y", strtotime($row["sample_collection_date"]));
								$data[] = $row;
								echo '<a href="'.$row["attachments"].'" target=”_blank”> '.$row["sample_collection_date"].' - '.$row["service_name"].'</a><br>';
							}
						} else {
							$row["status"] = "fail";
							$row["message"] = "Database is empty";
							$data = $row;
						}
				?>
			</div>
	</div>			
		</div>
	</div>
	<div class="row mt-4 mb-4">
		<div class="col">
		<div class="card">
			<div class="card-header">
				Hospital/Clinic Refferal
			</div>
			<div class="card-body">
				<?php
					$ownerid = $staff["id"];
					$sql = "SELECT * FROM chats WHERE owner_one='$ownerid' OR owner_two='$ownerid'";
					$result = $db->query($sql);
					if ($result->num_rows > 0) {
						// output data of each row
						$hasmc = 0;
						while($row = $result->fetch_assoc()){
							
							if($row["signedrefer"] != ""){
								echo '<a href="'.$row["signedrefer"].'" target=”_blank”> '.$row["session_date"].' - Reffer letter</a><br>';
								$hasmc++;
							}
							
						}
						if($hasmc == 0){
							echo 'No referral record';
						}
					} else {
						echo 'No referral record';
					}
					
				?>
			</div>
	</div>		
		</div>
		<div class="col">
		<div class="card">
			<div class="card-header">
				Consultation
			</div>
			<div class="card-body">
				<?php
					$ownerid = $staff["id"];
					$sql = "SELECT * FROM chats WHERE owner_one='$ownerid' OR owner_two='$ownerid'";
					$result = $db->query($sql);
					if ($result->num_rows > 0) {
						// output data of each row
					
						
							while($row = $result->fetch_assoc()){
								if($row["owner_one"] == $ownerid){
									$userischatingwith = $row["owner_two"];
									$profile = getProfile2($userischatingwith);
									$row["profile_picture"] = getProfilePicture($userischatingwith);
									$row["fullname"] = $profile["firstname"].' '.$profile["lastname"];
								}else{
									$userischatingwith = $row["owner_one"];
									$profile = getProfile2($userischatingwith);
									$row["profile_picture"] = getProfilePicture($userischatingwith);
									$row["fullname"] = $profile["firstname"].' '.$profile["lastname"];
								}
								$chatid = $row["id"];
								$row["human_session_date"] = date("F jS, Y", strtotime($row["session_date"]));
								$data[] = $row;
								echo 'Dr.'.$row["fullname"].' - '.$row["human_session_date"].'<br>';
							}
							
							
							
						
						
					} else {
						echo 'No medical leave certificate';
					}
					
				?>
			</div>
	</div>			
		</div>
	</div>
</div>