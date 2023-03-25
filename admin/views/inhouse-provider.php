<?php
if(isset($_POST["email"])){
	$email = cleanInput($_POST["email"]);
	$sql = "UPDATE users SET inhouse='true' WHERE email='$email'";
	if ($db->query($sql) === TRUE) {
		$res = "Record updated successfully";
	} else {
		$res = "Error updating record: " . $db->error;
	}
}
if(isset($_POST["removeemail"])){
	$removeemail = cleanInput($_POST["removeemail"]);
	$sql = "UPDATE users SET inhouse='false' WHERE id='$removeemail'";
	if ($db->query($sql) === TRUE) {
		$res = "Record updated successfully";
	} else {
		$res = "Error updating record: " . $db->error;
	}
}
?>

<div class="content-wrapper">
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Inhouse Manager</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item active"><a href="#!" class="btn btn-primary" data-toggle="modal" data-target="#setuser">Set User</a></li>
					</ol>
				</div>
			</div>
		</div>
	</section>
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
					<?php
					if(isset($res)){
						echo '
						<div class="card">
							<div class="card-body">
							'.$res.'
							</div>
						</div>
						';
					}
					
					?>
					<div class="card">
						<div class="card-body">
							<table id="example1" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>Name</th>
										<th>Position</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$sql = "SELECT * FROM users WHERE type='6' AND inhouse='true'";
										$result = $db->query($sql);
										
										if ($result->num_rows > 0) {
										  // output data of each row
										  while($row = $result->fetch_assoc()) {
											
											echo '
										<tr>                                                 <td>'. $row["firstname"].' '. $row["lastname"].'</td>
										<td>'. $row["provider_type"].'</td>
										<td><center><a class="btn btn-primary" href="#!" data-toggle="modal" data-target="#remove" onclick="setEmailtoremove('. $row["id"].')">Remove</a></center></td>
										                  </tr>';	
										}
										} else {
										  
										}
												
										?>	  
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<!-- Modal -->
<div class="modal fade" id="remove" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Remove user</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="POST">
			<div class="modal-body">
				<p>Are you sure about removing this user from the in house service provider group?</p>
				<input type="number" id="removeemail" name="removeemail" hidden>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" name="remove" id="remove" class="btn btn-primary">Confirm</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="setuser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Promote user to in house provider</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="POST">
			<div class="modal-body">
				<div class="form-group">
					<label for="useremail">Email</label>
					<input type="email" id="email" name="email" class="form-control">
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Save changes</button>
			</div>
			</form>
		</div>
	</div>
</div>
<script>
function setEmailtoremove(val){
	document.getElementById("removeemail").value = val;
}
</script>