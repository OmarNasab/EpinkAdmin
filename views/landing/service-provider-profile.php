<?php
		$uid = cleanInput($page_identifier_action);
		$userssql = "SELECT * FROM users WHERE id='$uid'";
		$usersresult = $db->query($userssql);
		if ($usersresult->num_rows > 0){
			$row = $usersresult->fetch_assoc();
			if($row["organization_name"] == ""){
				$row["organization_name"] = "Organization Not Set";
			}	
			if($row["profile_img"] == "img/default_profile_picture.jpg"){
											$row["profile_img"] = $domain.'/landingasset/assets/img/illustrations/profiles/profile-1.png';
			}
			$usersdata = $row;
		} else {
			$row["card"] = "red";
			$row["status"] = "Fail";
			$row["message"] = '<script>window.location.replace("'.$domain.'/404");</script>';
			$data = $row;
		}
?>
					<header class="page-header-ui page-header-ui-light bg-white">
                        <div class="page-header-ui-content">
                            <div class="container px-5">
                                <div class="row gx-5 justify-content-center">
                                    <div class="col-xl-8 col-lg-10 text-center">
                                        <img class="mb-4 img-thumbnail" src="<?php echo $usersdata["profile_img"]; ?>" style="width: 15rem; border-radius: 50%">
                                        <h1 class="page-header-ui-title"><?php echo $usersdata["firstname"].' '.$usersdata["lastname"]; ?></h1>
                                       
                                        <p class="page-header-ui-text"><?php echo $usersdata["provider_type"]; ?>, <?php echo $usersdata["organization_name"]; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </header>