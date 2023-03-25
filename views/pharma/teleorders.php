<header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
	<div class="container-xl px-4">
		<div class="page-header-content">
			<div class="row align-items-center justify-content-between pt-3">
				<div class="col-auto mb-3">
					<h1 class="page-header-title">
						<div class="page-header-icon"><i data-feather="user"></i></div>
						Tele consultation orders sa
					</h1>
				</div>
			</div>
		</div>
	</div>
</header>
<div class="container-xl px-4">
	<div class="card mb-4">
		<div class="card-header text-black">History</div>
			<div class="card-body">
			 	<table id="myTable">
			 		<thead>
			 			<tr>
							<th>Order ID</th>
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
							$vendorid =  $authuser["id"];
							$sql = "SELECT * FROM chats WHERE storeid='$vendorid' AND paid='true' ORDER BY id ASC";
							$result = $db->query($sql);
							if ($result->num_rows > 0) {
								while($row = $result->fetch_assoc()) {
									$owneroneisdoctor = checkDoc($row["owner_one"]);
									if($owneroneisdoctor == true){
										$row["patient_id"] = $row["owner_two"];
										$row["patient_profile"] = getsimpleProfile($row["owner_two"]);
										$row["doctor_id"] = $row["owner_one"];
										$row["doctor_profile"] = getsimpleProfile($row["owner_one"]);
									}else{
										$row["patient_id"] = $row["owner_one"];
										$row["patient_profile"] = getsimpleProfile($row["owner_one"]);
										$row["doctor_id"] = $row["owner_two"];
										$row["doctor_profile"] = getsimpleProfile($row["owner_two"]);
									}
									if($row["paid"] == "true"){
										$pharmapurchase[] = $row;
									}
								if($row["storeapprove"] == ""){
									$row["storeapprove"] = "Waiting for approval";
								}elseif($row["storeapprove"] == "true"){
									$row["storeapprove"] = "Approved";
								}elseif($row["storeapprove"] == null){
									$row["storeapprove"] = "Waiting for approval";
								}
									echo '
											<tr>
												<td>'.$row["id"].'<br><span class="text-xs">'.$row["order_date"].'</span></td>
												<td>Tele consultation</td>
												<td>'.$row["storeapprove"].'</td>
												<td>
													<a href="'.$domain.'/pharmacy-panel/orders/tele/'.$row["id"].'" class="mx-2"><i data-feather="eye"></i></a>
												</td>
											</tr>
										';
								}
							} else {
								$rowc["status"] = "fail";
								$rowc["message"] = "Database is empty";
								$pharmapurchase = $row;
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
		order: [[0, 'desc']],
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
</script>
