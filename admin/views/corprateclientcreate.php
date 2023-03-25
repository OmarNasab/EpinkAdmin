 <?php
 function random_strings($length_of_string) 
{  
    $str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz'; 
    return substr(str_shuffle($str_result), 0, $length_of_string); 
} 
if(isset($_POST["create"])){
	$companyname = cleanInput($_POST["Company-Name"]);
	$accountmanager = cleanInput($_POST["accountmanager"]);
	$sql = "SELECT * FROM users WHERE email ='$accountmanager'";
	$result = $db->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$managerid = $row["id"];
			$code = random_strings(10);
			$sql = "UPDATE users SET company_name='$companyname', company_manager='true', company_code='$code' WHERE id='$managerid'";
			if ($db->query($sql) === TRUE) {
				$res = "Record updated successfully";
			} else {
				$res = "Error updating record: " . $db->error;
			}
		}
	} else {
		$res = 'The email for company manager that you provided doesnt exist';
	}
 }
 ?>
 
 <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Client Corperate Account</h1>
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
			echo '
			<div class="card">
				
			</div>
			';
			echo $res;
		}
		?>

  <form method="post">
	<div class="form-group">
		<label for="title">Company Name</label>
		<input type="text" class="form-control" id="Company-Name" name="Company-Name">   
	</div>
	<div class="form-group">
		<label for="title">Account Manager(Existing customer email)</label>
		<input type="text" class="form-control" id="accountmanager" name="accountmanager">   
	</div>	
	<div class="form-group">
	<button type="submit" class="btn btn-primary" name="create">SUBMIT</button>
	</div>
  </form>
  		</div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>
function convertImage(element, target){
	var file1 = element.files[0];
	var reader = new FileReader();
	reader.onloadend = function() {
		document.getElementById(target).value = reader.result;	
	}
	reader.readAsDataURL(file1);
}
</script>