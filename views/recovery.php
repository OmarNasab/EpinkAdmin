                    <section class="bg-white py-10">
                        <div class="container px-5">
                            <div class="row gx-5 justify-content-center">
		<?php
		if(isset($_GET["hash"])){
			$recoverycode = cleanInput($_GET["hash"]);
			$sql = "SELECT * FROM users WHERE reset_code='$recoverycode'";
			$result = $db->query($sql);
			if ($result->num_rows > 0) {
			  $row = $result->fetch_assoc();
			  if(isset($_POST["resetpassword"])){
				  
				  
			  }else{
			  echo '
			  <h1>Password Recovery</h1>
			  <p>This page only available for 24 hour. Please reset your password</p>
			  <br/>
		<form method="POST">
			<div class="form-group">
				<label for="newpassword">Password</label>
				<input type="password" name="newpassword" class="form-control">
			</div>
			<div class="form-group">
				<label for="passwordconfirmation">Password Confirmation</label>
				<input type="password" name="passwordconfirmation" class="form-control">
			</div>
			<div class="form-group">
				
				<button type="submit" class="btn btn-primary" name="resetpassword">
				SUBMIT
				</button> 
			</div>
		</form>			  
			  ';
			  } 
			  
			} else {
				echo '<div class="card"><div class="card-body">This recovery code is no longer valid</div></div>';
			}	
			
			if(isset($_POST["resetpassword"])){
				$recoverycode = cleanInput($_GET["hash"]);
				$newpassword = cleanInput($_POST["newpassword"]);
				if($recoverycode != ""){
				$sql = "UPDATE users SET password='$newpassword', reset_code=NULL WHERE reset_code='$recoverycode'";

				if ($db->query($sql) === TRUE) {
				  echo '<div class="card"><div class="card-body">Your password has been reset successfully</div></div>';
				} else {
				  echo '<div class="card"><div class="card-body">Error updating record: ' . $db->error;
				  echo '</div></div>';
				}
				}else{
					echo '<div class="card"><div class="card-body">This recovery code is no longer valid</div></div>';
				}				
			}			
		}
		?>
		
    </div>
    </div>

  </section>