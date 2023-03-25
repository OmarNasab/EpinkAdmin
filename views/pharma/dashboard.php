
                   <header class="page-header bg-primary pb-5">
                        <div class="container-xl px-4">
                            <div class="page-header-content pt-4">
                                <div class="row align-items-center justify-content-between mb-3">
                                    <div class="col-auto mt-4">
                                        <h1 class="page-header-title text-white">
                                            <div class="page-header-icon"><i data-feather="activity"></i></div>
                                            <?php echo $authuser["vendor_name"]; ?>
                                        </h1>
                                        <div class="text-white">
											<?php echo $membershiprender; ?> <?php echo '<span class="text-xs"> (Expiring on '.$membership["expire"].')<span>'; ?> 
											<?php
											if ($expiry_date < $today_date) { 
												echo "EXPIRED";
											}
											?>
										</div>
                                    </div>
                                    <div class="col-12 col-xl-auto mt-4">

                                    </div>
								</div>
						<div class="row">
							<div class="col-lg-6 col-xl-3 mb-4">
                                <div class="card bg-green text-white h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="me-3">
                                                <div class="text-white-75 small">WALLET</div>
                                                <div class="text-lg fw-bold">RM<?php echo $authuser["wallet"]; ?></div>
                                            </div>
                                            <i class="feather-xl text-white-50" data-feather="credit-card"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-xl-3 mb-4">
                                <div class="card bg-primary text-white h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="me-3">
                                                <div class="text-white-75 small">Sessions (Monthly)</div>
                                                <div class="text-lg fw-bold"><?php echo $membership["session"]; ?></div>
                                            </div>
                                            <i class="feather-xl text-white-50" data-feather="message-circle"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-xl-3 mb-4">
                                <div class="card bg-pink text-white h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="me-3">
                                                <div class="text-white-75 small">Prescription (Monthly)</div>
                                                <div class="text-lg fw-bold"><?php echo $membership["prescount"]; ?></div>
                                            </div>
                                            <i class="feather-xl text-white-50" data-feather="calendar"></i>
                                        </div>
                                    </div> 
                                </div>
                            </div>
							 <div class="col-lg-6 col-xl-3 mb-4">
                                <div class="card bg-light text-dark h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="me-3">
                                                <div class="text-dark-75 small">Assigned Doctor</div>
												<?php
												if($assignedoctor["profile_img"] != null){
													echo '<img src="'.$assignedoctor["profile_img"].'" width="25%" class="rounded">';
												}
												?>
                                                <div class="text-dark text-xs mt-3">  <i class="text-dark-50" data-feather="user"></i> <?php echo $assignedoctor["fullname"]; ?></div>
                                            </div>
                                          
                                        </div>
                                    </div> 
                                </div>
                            </div>
                        </div>                            
                            </div>
                        </div>
                    </header>
                    <!-- Main page content-->
                    <div class="container-xl px-4 mt-n10">
                        <div class="row">
                            <div class="col-xxl-4 col-xl-12 mb-4">
                                <div class="card h-100">
                                    <div class="card-body h-100 p-5">
                                        <div class="row align-items-center">
                                            <div class="col-xl-8 col-xxl-12">
                                                <div class="text-center text-xl-start text-xxl-center mb-4 mb-xl-0 mb-xxl-4">
                                                    <h1 class="text-primary">Welcome to you adminsitrative panel</h1>
                                                    <p class="text-gray-700 mb-2">Welcome to your adminsitrative panel what would you like to do?</p>
													<a href="<?php echo $domain; ?>/pharmacy-panel/orders/" class="btn btn-sm btn-primary">View Orders</a>
													<a href="<?php echo $domain; ?>/pharmacy-panel/products/" class="btn btn-sm btn-primary">Manage Products</a>
													<a href="<?php echo $domain; ?>/pharmacy-panel/account/" class="btn btn-sm btn-primary">Manage Account</a>
													<a href="<?php echo $domain; ?>/pharmacy-panel/establishment-information/" class="btn btn-sm btn-primary">Pharmacy information</a>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-xxl-12 text-center"><img class="img-fluid" src="https://epink.health/img/epinkhealth.png" style="width: 50%" /></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                   </div>