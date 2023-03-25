<header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
	<div class="container-xl px-4">
		<div class="page-header-content">
			<div class="row align-items-center justify-content-between pt-3">
				<div class="col-auto mb-3">
					<h1 class="page-header-title">
						<div class="page-header-icon"><i data-feather="clipboard"></i></div>
						New Orders
					</h1>
				</div>
				<div class="col-12 col-xl-auto mb-3">      
					<a class="btn btn-sm btn-light text-dark" href="<?php echo $domain; ?>/pharmacy-panel/orders/purchase-order/all/">Order History</a>  
                </div>
			</div>
		</div>
	</div>
</header>
<div class="container-xl px-4">
	<div class="card mb-4">
		<div class="card-header text-black">New order from customer</div>
			<div class="card-body">
			 	<table id="myTable">
			 		<thead>
			 			<tr>
							<th>Order ID</th>
							<th>Customer</th>	
							<th>Type</th>	
							<th>Status</th>
			 				<th>Action</th>
			 			</tr>
			 		</thead>
			 		<tbody>
			 			<?php
							function checkDoc($id){
								global $db;
								$sql = "SELECT * FROM users WHERE id='$id'";
								$result = $db->query($sql);
								if ($result->num_rows > 0){
									if($row["type"] == 6){
										return true;
									}else{
										return false;
									}
								} else {
									return false;
								}
							}
							function getsimpleProfile($id){
								global $db;
								$userid = $db->real_escape_string($id);
								$sql = "SELECT id, firstname, lastname, profile_img, type, ic_number, phonenumber, lat, lng, id_token FROM users WHERE id='$userid'";
								$result = $db->query($sql);
								if ($result->num_rows > 0) {
									$row = $result->fetch_assoc();
									$row["status"] = "success";
									if($row["type"] == "6"){
										$row["fee"] = 20;
										$row["full_name"] = $row["firstname"].' '.$row["lastname"];
									}else{
										$row["full_name"] = $row["firstname"].' '.$row["lastname"];
									}
									return $row;
								} else {
									$row["full_name"] = "This user no longer exist";
									return $row;
								}
							}
							
							$vendorid = $authuser["id"];
							$sql = "SELECT * FROM job_order WHERE restaurant_id='$vendorid' AND order_status = 'New' ORDER BY id DESC";
							$result = $db->query($sql);
							if ($result->num_rows > 0){
								
							
								while($rows = $result->fetch_assoc()) {
										if($rows["deliverytype"] == "pickup"){
									$renderdeliverytype = "Self Pickup";
								}else{
									$renderdeliverytype = "Require Delivery";
								}
									$rows["patient_id"] = $rows["owner"];
									$rows["patient_profile"] = getsimpleProfile($rows["owner"]);
									$storepurchase[] = $rows;
										echo '
											<tr>
												<td>'.$rows["id"].'</td>
												
												<td>'.$rows["patient_profile"]["full_name"].' <br><span class="text-xs">'.$rows["order_date"].'</span></td>
												<td>'.$renderdeliverytype.'</td>
												<td>'.$rows["order_status"].'</td>
												<td>
													<a href="'.$domain.'/pharmacy-panel/orders/carts/'.$rows["id"].'/" class="mx-2 btn btn-primary btn-sm"> 	<i data-feather="eye" class="float-start" style="padding-right: 5px"></i>  View </a>
												</td>
											</tr>
										';
									}
								} else {
									$rowf["status"] = "fail";
									$rowf["message"] = "Database is empty";
									$storepurchase = null;
								}
			 			?>
			 		</tbody>
			 </table>
		</div>
	</div>
</div>
<script>
$(document).ready( function () {
    $('#myTable').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
</script>
