<?php
//LOGIN 
if(isset($_POST["login"])){
	$response = "Service Unvailable";
	$email = cleanInput($_POST["email"]);
	$password = cleanInput($_POST["password"]);
	if($email != "" && $password != ""){
		$sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
		$result = $db->query($sql);
		if ($result->num_rows > 0){
			$row = $result->fetch_assoc();
			$token = rand(10000,1000000).uniqid().rand(100,100000);
			$sql = "UPDATE users SET login_token='$token' WHERE email='$email'";
			if ($db->query($sql) === TRUE) {
				$_SESSION["id"] = $row["id"];
				$row["login_token"] = $token;		
				$row["status"] = "Successful";
				$row["card"] = "green";
				header("location: ".$domain."/corporate/");
			} else {
				$response = "Error updating record: " . $db->error;
				echo '{"status":"fail", "message":"'.$response.'"}';
			}

		} else {
			$row["status"] = "Fail";
			$row["message"] = "The record you looking for does not exist";
			$row["card"] = 'red';
			$data = $row;
		}
	}else{
		$row["status"] = "Fail";
		$row["message"] = "Please fill all the form";
		$row["card"] = 'red';
		$data = $row;
	} 
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Login - SB Admin Pro</title>
        <link href="<?php echo $domain; ?>/adminasset/css/styles.css" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container-xl px-4">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <!-- Basic login form-->
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header justify-content-center"><h3 class="fw-light my-4">Login</h3></div>
                                    <div class="card-body">
                                        <!-- Login form-->
										<?php 
							if(isset($data)){
								echo $data["message"]; 
							}
							?>
                                        <form method="POST" >
                                            <!-- Form Group (email address)-->
                                            <div class="mb-3">
                                                <label class="small mb-1" for="email">Email</label>
                                                <input class="form-control" id="email" name="email" type="email" placeholder="Enter email address" />
                                            </div>
                                            <!-- Form Group (password)-->
                                            <div class="mb-3">
                                                <label class="small mb-1" for="inputPassword">Password</label>
                                                <input class="form-control" id="password" name="password" type="password" placeholder="Enter password" />
                                            </div>
                                            <!-- Form Group (remember password checkbox)-->
                                            <div class="mb-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" id="rememberPasswordCheck" type="checkbox" value="" />
                                                    <label class="form-check-label" for="rememberPasswordCheck">Remember password</label>
                                                </div>
                                            </div>
                                            <!-- Form Group (login box)-->
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <a class="small" href="auth-password-basic.html">Forgot Password?</a>
                                                <button type="submit" class="btn btn-primary" name="login" id="login">Login</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center">
                                        <div class="small"><a href="auth-register-basic.html">Need an account? Sign up!</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="footer-admin mt-auto footer-dark">
                    <div class="container-xl px-4">
                        <div class="row">
                            <div class="col-md-6 small">Copyright &copy; Epink Health Sdn Bhd 2021</div>
                            <div class="col-md-6 text-md-end small">
                                <a href="<?php echo $domain; ?>/privacy/">Privacy Policy</a>
                                &middot;
                                <a href="<?php echo $domain; ?>/terms-and-conditions/">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="<?php echo $domain; ?>/adminasset/js/scripts.js"></script>
    </body>
</html>
