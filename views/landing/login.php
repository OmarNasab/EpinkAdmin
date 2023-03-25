
					<header class="page-header-ui page-header-light py-lg-5 bg-white">
                        <div class="page-header-ui-content">
							
                            <div class="container px-5">
								<?php 
							if(isset($data)){
								echo '
								<div class="card">
									<div class="card-body">'.$data["message"].'</div>
								</div>
								
								';
							}
							?>
                                <div class="row gx-5 align-items-center">
                                    <div class="col-lg-7">
                                        <h1 class="page-header-ui-title">LOGIN</h1>
                                        <p class="page-header-ui-text mb-5">Login to your account</p>
                                        <form class="row row-cols-1 row-cols-md-auto g-3 align-items-center mb-3" method="POST" action="">
											<input type="text" id="csrf" name="csrf" hidden value="<?php echo $csrftoken; ?>">
                                            <div class="col flex-grow-1">
                                                <label class="sr-only" for="inputEmail">Enter your email...</label>
                                                <input class="form-control form-control-solid w-100" id="email" type="email" name="email" placeholder="Enter your email...">
                                            </div>
											<div class="col flex-grow-1">
                                                <label class="sr-only" for="inputEmail">Enter your password</label>
                                                <input class="form-control form-control-solid w-100" id="password" name="password" type="password" placeholder="Enter your password...">
                                            </div>
                                            <div class="col"><button class="btn epink-btn-primary fw-500 epinka" name="login" type="submit">LOGIN</button></div>
                                        </form>
                                        <p class="page-header-ui-text mb-0">
                                           Forgot your password?
                                            <a href="<?php echo $domain; ?>/login/" class="epink-text-primary ">Recover here</a>
                                        </p>
                                    </div>
                                    <div class="col-lg-5 d-none d-lg-block"><img class="img-fluid ps-xl-5" src="<?php echo $domain; ?>/landingasset/assets/img/illustrations/creativity.svg"></div>
                                </div>
                            </div>
                        </div>
                        <div class="svg-border-rounded text-light">
                            <!-- Rounded SVG Border-->
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 144.54 17.34" preserveAspectRatio="none" fill="currentColor"><path d="M144.54,17.34H0V0H144.54ZM0,0S32.36,17.34,72.27,17.34,144.54,0,144.54,0"></path></svg>
                        </div>
                    </header>