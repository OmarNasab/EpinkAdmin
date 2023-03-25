
<?php
	$id = cleanInput($page_action_identifier);
	$accounts_verificationsql = "SELECT * FROM accounts_verification WHERE id='$id'";
	$accounts_verificationresult = $db->query($accounts_verificationsql);
	if ($accounts_verificationresult->num_rows > 0){
		$row = $accounts_verificationresult->fetch_assoc();
		$accounts_verificationdata = $row;
		$owners = $accounts_verificationdata["owner"];
		$userssql = "SELECT * FROM users WHERE id='$owners'";
		$usersresult = $db->query($userssql);
		if ($usersresult->num_rows > 0){
			$row = $usersresult->fetch_assoc();
			$usersdata = $row;
			
		} else {
			$row["card"] = "red";
			$row["status"] = "Fail";
			$row["message"] = "The record you looking for does not exist<script>window.location.href= ''.$domain.'/404';</script>";
			$data = $row;
		}
	} else {
		$row["card"] = "red";
		$row["status"] = "Fail";
		$row["message"] = "The record you looking for does not exist<script>window.location.href= ''.$domain.'/404';</script>";
		$data = $row;
	}
?>

 

 
 <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
				
                    <h1>Detail - Request ID <?php echo $accounts_verificationdata["id"]; ?> for UID <?php echo $accounts_verificationdata["owner"]; ?></h1>
                </div>
                <div class="col-sm-6">
                   
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->

        <div class="container-fluid">
<p>Request status:<?php echo $accounts_verificationdata["request_status"]; ?></p>
<p>Owner:<?php echo $accounts_verificationdata["owner"]; ?></p>
<p>Firstname:<?php echo $usersdata["firstname"]; ?></p>
<p>Lastname:<?php echo $usersdata["lastname"]; ?></p>
<p>Email:<?php echo $usersdata["email"]; ?></p>
<p>Phone Number:<?php echo $usersdata["phonenumber"]; ?></p>
<p>IC Number:<?php echo $usersdata["ic_number"]; ?></p>
<p>Verifying for:<?php echo $accounts_verificationdata["verifying_for"]; ?></p>
<p>Ic font:</p>
<img src="<?php echo $accounts_verificationdata["ic_font"]; ?>" width="200px">
<p>Ic back:</p>
<img src="<?php echo $accounts_verificationdata["ic_back"]; ?>" width="200px">
<p>Educations place: <?php echo $accounts_verificationdata["educations_place"]; ?></p>
<p>Education certification: <a href="<?php echo $accounts_verificationdata["education_certification"]; ?>">view</a></p>
<p>Apc number:<?php echo $accounts_verificationdata["apc_number"]; ?></p>
<p>Apc file:</p>
 <a href="<?php echo $accounts_verificationdata["apc_file"]; ?>">view</a>
 <br>
<p>Registeration body:<?php echo $accounts_verificationdata["registeration_body"]; ?></p>



		</div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
