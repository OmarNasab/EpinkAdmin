 <?php
	$id = cleanInput($page_action_identifier);
	$volsql = "SELECT * FROM vol WHERE id='$id'";
	$volresult = $db->query($volsql);
	if ($volresult->num_rows > 0){
		$row = $volresult->fetch_assoc();
		$voldata = $row;
		
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
                    <h1>Detail</h1>
                </div>
                <div class="col-sm-6">
                   
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
		<?php
		if(isset($res)){
			echo $res;
		}
		?>

<p>Email:<?php echo $voldata["email"]; ?></p>
<p>Position:<?php echo $voldata["position"]; ?></p>
<p>Fullname:<?php echo $voldata["fullname"]; ?></p>
<p>Ic:<?php echo $voldata["ic"]; ?></p>
<p>Current address:<?php echo $voldata["current_address"]; ?></p>
<p>Permanent address:<?php echo $voldata["permanent_address"]; ?></p>
<p>Phone number:<?php echo $voldata["phone_number"]; ?></p>
<p>Whatsapp telegram number:<?php echo $voldata["whatsapp_telegram_number"]; ?></p>
<p>Gender:<?php echo $voldata["gender"]; ?></p>
<p>Nationality:<?php echo $voldata["nationality"]; ?></p>
<p>Bank:<?php echo $voldata["bank"]; ?></p>
<p>Bank account number:<?php echo $voldata["bank_account_number"]; ?></p>
<p>Counsil number:<?php echo $voldata["counsil_number"]; ?></p>
<p>Type of healthcare services center:<?php echo $voldata["type_of_healthcare_services_center"]; ?></p>
<p>Ic front: <br><img src="<?php echo $voldata["ic_front"]; ?>" width="250px"></p>
<p>Ic back: <br><img src="<?php echo $voldata["ic_back"]; ?>" width="250px"></p>
<p>Upload apc: <a href="<?php echo $voldata["upload_apc"]; ?>">View Here</a></p>
<p>Pdpa clause:<?php echo $voldata["pdpa_clause"]; ?></p>
</div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
