<?php 
$uid = $_SESSION["id"];
$sql = "SELECT * FROM users WHERE id='$uid'";
$result = $db->query($sql);
$account = $result->fetch_assoc();
if($account["profile_img"] != "img/default_profile_picture.jpg"){
	
}
$company_name = $account["company_name"];
$company_code = $account["company_code"];

?>
<header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
	<div class="container-fluid px-4">
		<div class="page-header-content">
			<div class="row align-items-center justify-content-between pt-3">
				<div class="col-auto mb-3">
					<h1 class="page-header-title">
						<div class="page-header-icon"><i data-feather="list"></i></div>
						STAFF - <?php echo $account["company_name"]; ?>
						 [<?php echo $account["company_code"]; ?>]
					</h1>
				</div>
			</div>
		</div>
	</div>
</header>
<!-- Main page content-->
<div class="container-fluid px-4">
				<?php

				$sql = "SELECT * FROM users WHERE company_name='$company_name'";
				$result = $db->query($sql);

				if ($result->num_rows > 0) {
				  // output data of each row
				  while($row = $result->fetch_assoc()) {
					   echo '
												<div class="card mb-4">
													<div class="card-header"><a href="'.$domain.'/corporate/staff/'.$row["id"].'/">'.$row["firstname"].' '.$row["lastname"].'</a>
														</div>
													
												</div>											
												';
					
				  }
				} else {
				  echo '<tr>
						No staff linked to your company account<br>
						
					</tr>';
				}				
				?>

</div>
