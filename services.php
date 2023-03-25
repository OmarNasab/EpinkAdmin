				<!-- Page Header-->
                    <header class="page-header-ui epink-page-header-ui-dark epink-bg-gradient-primary-to-secondary">
                        <div class="page-header-ui-content pt-10">
                            <div class="container px-5 text-center">
                                <div class="row gx-5 justify-content-center">
                                    <div class="col-lg-8">
                                        <h1 class="page-header-ui-title mb-3 text-white">Healthcare Services</h1>
                                        <p class="page-header-ui-text">EPINK HEALTH’s goal is to give the best personalized healthcare for you and your loved ones at all times of need. We are ready to serve you in just a single click!</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="svg-border-rounded text-white">
                            <!-- Rounded SVG Border-->
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 144.54 17.34" preserveAspectRatio="none" fill="currentColor"><path d="M144.54,17.34H0V0H144.54ZM0,0S32.36,17.34,72.27,17.34,144.54,0,144.54,0"></path></svg>
                        </div>
                    </header>
					<section class="bg-white py-10">
                        <div class="container px-5 bg-whit">
	
							<h3>Health Care</h3>
							<p>Services available in Health Care</p>							
                            <div class="row gx-5" id="searchresult">
										<div class="col-md-6 col-xl-4 mb-5">
											<div class="card card-team">
												<img class="card-img-top" src="https://via.placeholder.com/500x500" alt="...">
												<div class="card-body">
													
													<div class="card-team-name">Doctors</div>
													<div class="card-team-position mb-3"></div>
													<p class="small mb-0"></p>
												</div>
												<div class="card-footer text-center d-grid gap-2">
													<a href="'.$domain.'/healthcare-services/'.$row["id"].'" class="btn epink-btn-primary btn-sm">More information</a>
												</div>
											</div>
										</div>	
										<div class="col-md-6 col-xl-4 mb-5">
											<div class="card card-team">
												<img class="card-img-top" src="https://via.placeholder.com/500x500" alt="...">
												<div class="card-body">
													
													<div class="card-team-name">Physiotherapist</div>
													<div class="card-team-position mb-3"></div>
													<p class="small mb-0"></p>
												</div>
												<div class="card-footer text-center d-grid gap-2">
													<a href="'.$domain.'/healthcare-services/'.$row["id"].'" class="btn epink-btn-primary btn-sm">More information</a>
												</div>
											</div>
										</div>	
										<div class="col-md-6 col-xl-4 mb-5">
											<div class="card card-team">
												<img class="card-img-top" src="https://via.placeholder.com/500x500" alt="...">
												<div class="card-body">
													
													<div class="card-team-name">Psychologist</div>
													<div class="card-team-position mb-3"></div>
													<p class="small mb-0"></p>
												</div>
												<div class="card-footer text-center d-grid gap-2">
													<a href="'.$domain.'/healthcare-services/'.$row["id"].'" class="btn epink-btn-primary btn-sm">More information</a>
												</div>
											</div>
										</div>											
							</div>
                        </div>
                    </section>	
					<section class="bg-white py-10">
                        <div class="container px-5 bg-whit">
	
							<h3>Older Care</h3>
							<p>Services available in older care</p>							
                            <div class="row gx-5" id="searchresult">
								<?php
								if(isset($_GET["filter"])){
									//echo $_GET["filter"];
								}
								$sql = "SELECT * FROM ecare_services WHERE category='Older Care'";
								$result = $db->query($sql);
								if ($result->num_rows > 0) {
									while($row = $result->fetch_assoc()) {
										$des = substr($row["description"],0,35).'...';
										echo '
										<div class="col-md-6 col-xl-4 mb-5">
											<div class="card card-team">
												<img class="card-img-top" src="'.$row["icon"].'" alt="...">
												<div class="card-body">
													
													<div class="card-team-name">'.$row["name"].'</div>
													<div class="card-team-position mb-3">'.$des.'</div>
													<p class="small mb-0">RM'.$row["price"].'</p>
												</div>
												<div class="card-footer text-center d-grid gap-2">
													<a href="'.$domain.'/healthcare-services/'.$row["id"].'" class="btn epink-btn-primary btn-sm">More information</a>
												</div>
											</div>
										</div>										
										';
									}
								} else {
									echo '<div class="col-md-6 col-xl-4 mb-5">No result</div>';
								}
								
								?>
							</div>
                        </div>
                    </section>	
					<section class="bg-white py-10">
                        <div class="container px-5 bg-whit">
	
							<h3>Wound Care</h3>	
							<p>Services available in wound care</p>
                            <div class="row gx-5" id="searchresult">
								<?php
								if(isset($_GET["filter"])){
									//echo $_GET["filter"];
								}
								$sql = "SELECT * FROM ecare_services WHERE category='Wound Care'";
								$result = $db->query($sql);
								if ($result->num_rows > 0) {
									while($row = $result->fetch_assoc()) {
										$des = substr($row["description"],0,35).'...';
										echo '
										<div class="col-md-6 col-xl-4 mb-5">
											<div class="card card-team">
												<img class="card-img-top" src="'.$row["icon"].'" alt="...">
												<div class="card-body">
													
													<div class="card-team-name">'.$row["name"].'</div>
													<div class="card-team-position mb-3">'.$des.'</div>
													<p class="small mb-0">RM'.$row["price"].'</p>
												</div>
												<div class="card-footer text-center d-grid gap-2">
													<a href="'.$domain.'/healthcare-services/'.$row["id"].'" class="btn epink-btn-primary btn-sm">More information</a>
												</div>
											</div>
										</div>										
										';
									}
								} else {
									echo '<div class="col-md-6 col-xl-4 mb-5">No result</div>';
								}
								
								?>
							</div>
                        </div>
                    </section>					
					
					

					
					<section class="bg-white py-10">
                        <div class="container px-5 bg-whit">
	
							<h3>Minor procedure</h3>
							<p>Services available in minor procedure</p>							
                            <div class="row gx-5" id="searchresult">
								<?php
								if(isset($_GET["filter"])){
									//echo $_GET["filter"];
								}
								$sql = "SELECT * FROM ecare_services WHERE category='Minor procedure'";
								$result = $db->query($sql);
								if ($result->num_rows > 0) {
									while($row = $result->fetch_assoc()) {
										$des = substr($row["description"],0,35).'...';
										echo '
										<div class="col-md-6 col-xl-4 mb-5">
											<div class="card card-team">
												
												<img class="card-team-img mb-3" src="'.$row["icon"].'" alt="...">
												<div class="card-body">
												
													<div class="card-team-name">'.$row["name"].'</div>
													<div class="card-team-position mb-3">'.$des.'</div>
													<p class="small mb-0">RM'.$row["price"].'</p>
												</div>
												<div class="card-footer text-center d-grid gap-2">
													<a href="'.$domain.'/healthcare-services/'.$row["id"].'" class="btn epink-btn-primary btn-sm">More information</a>
												</div>
											</div>
										</div>										
										';
									}
								} else {
									echo '<div class="col-md-6 col-xl-4 mb-5">No result</div>';
								}
								
								?>
							</div>
                        </div>
                    </section>					
					
					<section class="bg-white py-10">
                        <div class="container px-5 bg-whit">
	
							<h3>Medical Escort &#38; Transport</h3>
							<p>Services available in Medical Escort &#38; Transport</p>							
                            <div class="row gx-5" id="searchresult">
								<?php
								if(isset($_GET["filter"])){
									//echo $_GET["filter"];
								}
								$sql = "SELECT * FROM ecare_services WHERE category='Medical Escort &#38; Transport'";
								$result = $db->query($sql);
								if ($result->num_rows > 0) {
									while($row = $result->fetch_assoc()) {
										$des = substr($row["description"],0, 35).'...';
										echo '
										<div class="col-md-6 col-xl-4 mb-5">
										
											<div class="card card-team">
											<img class="card-img-top" src="'.$row["icon"].'" alt="...">
												<div class="card-body">													
													<div class="card-team-name">'.$row["name"].'</div>
													<div class="card-team-position mb-3">'.$des.'</div>
													<p class="small mb-0">RM'.$row["price"].'</p>
												</div>
												<div class="card-footer text-center d-grid gap-2">
													<a href="'.$domain.'/healthcare-services/'.$row["id"].'" class="btn epink-btn-primary btn-sm">More information</a>
												</div>
											</div>
										</div>										
										';
									}
								} else {
									echo '<div class="col-md-6 col-xl-4 mb-5">No result</div>';
								}
								
								?>
							</div>
                        </div>
                    </section>						
					<script src="<?php echo $domain; ?>/js/webapp.js"></script>