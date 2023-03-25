                   <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
                        <div class="container-xl px-4">
                            <div class="page-header-content">
                                <div class="row align-items-center justify-content-between pt-3">
                                    <div class="col-auto mb-3">
                                        <h1 class="page-header-title">
                                            <div class="page-header-icon"><i data-feather="user"></i></div>
                                            My Account 
                                        </h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </header>
                    <!-- Main page content-->
                    <div class="container-xl px-4 mt-4">
                        <!-- Account page navigation-->
                        <nav class="nav nav-borders">
                            <a class="nav-link active ms-0" href="<?php echo $domain; ?>/dashboard/my-account/">Account Information</a>               
                        </nav>
                        <hr class="mt-0 mb-4" />
                        <div class="row">
                            <div class="col-xl-12">
                                <!-- Account details card-->
                                <div class="card mb-4">
                                    <div class="card-header">Account Details</div>
                                    <div class="card-body">
										<?php if(isset($response)){
											echo '
											<div class="card mb-4">
												<div class="card-body">
												'.$response.'
												</div>
											</div>
											
											';
										}
										?>
                                        <form method="POST">
                                            <!-- Form Row-->
                                            <div class="row gx-3 mb-3">
                                                <!-- Form Group (first name)-->
                                                <div class="col-md-6">
                                                    <label class="small mb-1" for="firstname">First name</label>
                                                    <input class="form-control" id="firstname" name="firstname" type="text" placeholder="Enter your first name" value="<?php echo $account["firstname"]; ?>" />
                                                </div>
                                                <!-- Form Group (last name)-->
                                                <div class="col-md-6">
                                                    <label class="small mb-1" for="lastname">Last name</label>
                                                    <input class="form-control" id="lastname" name="lastname" type="text" placeholder="Enter your last name" value="<?php echo $account["lastname"]; ?>" />
                                                </div>
                                            </div>
                                            <!-- Form Row        -->
                                            <div class="row gx-3 mb-3">
                                                <!-- Form Group (organization name)-->
                                                <div class="col-md-6">
                                                    <label class="small mb-1" for="email">Personal email</label>
                                                    <input class="form-control" id="email" name="email" type="text" placeholder="Enter your personal email" value="<?php echo $account["email"]; ?>" />
                                                </div>
                                                <!-- Form Group (location)-->
                                                <div class="col-md-6">
                                                    <label class="small mb-1" for="phonenumber">personal Phone Number</label>
                                                    <input class="form-control" id="phonenumber" name="phonenumber" type="text" placeholder="Enter your personal contact number" value="<?php echo $account["phonenumber"]; ?>" />
                                                </div>
                                            </div>
                                            <!-- Form Group (email address)-->
                                            <div class="mb-3">
                                                <label class="small mb-1" for="organization_name">Company name</label>
                                                <input class="form-control" id="organization_name" name="organization_name" type="text" placeholder="Enter your company name" value="<?php echo $account["organization_name"]; ?>" />
                                            </div>
                                            <!-- Form Row-->
                                            <div class="row gx-3 mb-3">
                                                <!-- Form Group (phone number)-->
                                                <div class="col-md-6">
                                                    <label class="small mb-1" for="organization_phone_number">Company phone number</label>
                                                    <input class="form-control" id="organization_phone_number" type="tel" name="organization_phone_number" placeholder="Enter your company phone number" value="<?php echo $account["organization_phone_number"]; ?>" />
                                                </div>
                                                <!-- Form Group (birthday)-->
                                                <div class="col-md-6">
                                                    <label class="small mb-1" for="organization_email">Company email</label>
                                                    <input class="form-control" id="organization_email" type="text" name="organization_email" placeholder="Enter your company email" value="<?php echo $account["organization_email"]; ?>" />
                                                </div>
                                            </div>
                                            <!-- Save changes button-->
                                            <button class="btn btn-primary" type="submit" name="update_account" >Save changes</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>