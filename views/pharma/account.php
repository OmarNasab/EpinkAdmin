<?php
$pagetitle = 'My Account';
$uid = $_SESSION["id"];

if(isset($_POST["update_account"])){
	$firstname = cleanInput($_POST["firstname"]);
	$vendor_name = cleanInput($_POST["vendor_name"]);
	$lastname = cleanInput($_POST["lastname"]);
	$email = cleanInput($_POST["email"]);
	$sql = "UPDATE users SET firstname='$firstname', lastname='$lastname', WHERE id='$uid'";
	if ($db->query($sql) === TRUE) {
		$cardcolor = "bg-success";
		$response = "Your account information has been updated successfully";
	} else {
		$cardcolor = "bg-warning";
		$response = "Error updating account information";
	}
}

if(isset($_POST["updateprofilepicture"])){
	$uid = $authuser["id"];
	if($_POST["profilepicture"] != ""){
		$profilepicture = processFile($_POST["profilepicture"]); 
		$sql = "UPDATE users SET  profile_img='$profilepicture'  WHERE id='$uid'";
				
        if ($db->query($sql) === TRUE) {
              $response = 'Your profile picture has been updated successfully.'; 
              $cardcolor = 'bg-success'; 
        }else{
              $response = 'Error updating record';
              $cardcolor = 'bg-warning'; 
        }
	}else{
		$response = 'Please select an image';
         $cardcolor = 'bg-warning'; 
	}
}
if(isset($_POST["updatepassword"])){
		$password = cleanInput($_POST["password"]); 
		$oldpassword = cleanInput($_POST["oldpassword"]); 
		$uid = $authuser["id"];
        if($oldpassword == $authuser["password"]){

                $sql = "UPDATE users SET password ='$password'  WHERE id='$uid'";
                if ($db->query($sql) === TRUE) {
                        $response = 'Your account password has been changed successfully'; 
                        $cardcolor = 'bg-success'; 
                }else{
                        $response = 'Error updating record';
                        $cardcolor = 'bg-warning'; 
                }
		}else{
			  $response = 'Password verification failed';
              $cardcolor = 'bg-warning'; 
		}
}



$sql = "SELECT * FROM users WHERE id='$uid'";
$result = $db->query($sql);
$account = $result->fetch_assoc();
if($account["profilepicture"] == ""){
	$account["profilepicture"] = $domain.'/assets/user/assets/img/illustrations/profiles/profile-2.png';
}
?>
                   <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
                        <div class="container-xl px-4">
                            <div class="page-header-content">
                                <div class="row align-items-center justify-content-between pt-3">
                                    <div class="col-auto mb-3">
                                        <h1 class="page-header-title black-text">
                                            <div class="page-header-icon"><i data-feather="user"></i></div>
                                            My Account 
                                        </h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </header>
                    <!-- Main page content-->
                    <div class="container-xl px-4 mt-4">
                        <div class="row">
							<div class="col-xl-12">
								<?php if(isset($response)){
											echo '
											<div class="card mb-4 '.$cardcolor.'">
												<div class="card-body text-light">
												'.$response.'
												</div>
											</div>
											
											';
										}
										?>
                                <!-- Account details card-->
                                <div class="card mb-4">
                                    <div class="card-header text-black">Update profile picture</div>
                                    <div class="card-body">
									<form method="POST">
										<div class="row gx-3 mb-3">
										<div class="col-md-12 mb-3">
												
												<img src="<?php echo $account["profile_img"]; ?>" width="200px" class="mb-3">
												<input class="form-control" type="file" id="formFile" onchange="processFile(this, 'profilepicture')" accept="image/png, image/gif, image/jpeg">
												<input class="form-control" id="profilepicture" name="profilepicture" type="text" placeholder="" value="" hidden/>
										</div>
										</div>
										<div class="form-group"><button type="submit" class="btn btn-primary" name="updateprofilepicture">Update profile picture</button></div>
									</form>
								</div>
							</div>
                            <div class="col-xl-12">
                                <!-- Account details card-->
                                <div class="card mb-4">
                                    <div class="card-header text-black">Update personal information</div>
                                    <div class="card-body">
										
                                        <form method="POST">                                       
                                            <div class="row gx-3 mb-3">
                                                <!-- Form Group (first name)-->
                                                <div class="col-md-6"> 
                                                    <label class="small mb-1" for="firstname">First name</label>
                                                    <input class="form-control" id="firstname" name="firstname" type="text" placeholder="Enter your first name" value="<?php echo $account["firstname"]; ?>" />
                                                </div>
                                                <!-- Form Group (last name)-->
                                                <div class="col-md-6">
                                                    <label class="small mb-1" for="lastname">Last name</label>
                                                    <input class="form-control" id="lastname" name="lastname" type="text" placeholder="Enter your last name" value="<?php echo $account["lastname"]; ?>" />
                                                </div>
                                            </div>
                                            <!-- Form Row        -->
                                            <div class="row gx-3 mb-3">
                                                <!-- Form Group (organization name)-->
                                                <div class="col-md-6">
                                                    <label class="small mb-1" for="email">Personal email</label>
                                                    <input class="form-control" id="email" name="email" type="text" placeholder="Enter your personal email" value="<?php echo $account["email"]; ?>" readonly />
                                                </div>
                                                <!-- Form Group (location)-->
                                                <div class="col-md-6">
                                                    <label class="small mb-1" for="phonenumber">personal Phone Number</label>
                                                    <input class="form-control" id="phonenumber" name="phonenumber" type="text" placeholder="Enter your personal contact number" value="<?php echo $account["phonenumber"]; ?>" />
                                                </div>
                                            </div>
                                            <!-- Save changes button-->
                                            <button class="btn btn-primary" type="submit" name="update_account" >Update Account</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
			<div class="card mb-4">
				<div class="card-header text-dark">Update password</div>
					<div class="card-body">
						<form method="POST">
							<div class="row gx-3 mb-3">
										<div class="col-md-12 mb-3">
												<label class="small" for="oldpassword">Old Password</label>
												<input class="form-control" id="oldpassword" name="oldpassword" type="text" placeholder="Enter your old password" value="" />
										</div>
										<div class="col-md-12 mb-3">
												<label class="small" for="password">New Password</label>
												<input class="form-control" id="password" name="password" type="text" placeholder="Enter your new desired password" value="" />
										</div>
							<div class="form-group"><button type="submit" class="btn btn-primary" name="updatepassword">Update Password</button></div>
							</div>
						</form>
					</div>
			</div>
                        </div>

                    </div>
<script>
function processFile(element, target){
	var file1 = element.files[0];
	var reader = new FileReader();
	reader.onloadend = function() {
		var checkfiletype = reader.result;
		var checkfiletype = reader.result;			
		if(checkfiletype.includes("image") == true){			
			document.getElementById(target).value = reader.result;
		}else if(checkfiletype.includes("application/pdf") == true){
			document.getElementById(target).value = reader.result;
		}else{
			alert("File type not allowed");
		}
	}
	reader.readAsDataURL(file1);
}
</script>