                    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
                        <div class="container-xl px-4">
                            <div class="page-header-content">
                                <div class="row align-items-center justify-content-between pt-3">
                                    <div class="col-auto mb-3">
                                        <h1 class="page-header-title">
                                            <div class="page-header-icon"><i data-feather="file"></i></div>
                                            View Ticket
                                        </h1>
                                    </div>
                                    <div class="col-12 col-xl-auto mb-3">Requested on <?php echo $requestinfo["support_date"]; ?></div>
                                </div>
                            </div>
                        </div>
                    </header>
                    <!-- Main page content-->
                    <div class="container-xl px-4 mt-4">
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
						<div class="row">
							<div class="col-12 col-lg-4">
							<?php
							echo '
												<div class="card mb-4">
													<div class="card-header">Ticket Information</div>
													<div class="card-body">
														<p><strong>#0'.$requestinfo["id"].' - '.$requestinfo["support_title"].'</strong></p>
														<span class="badge bg-secondary">'.$requestinfo["support_status"].'</span>
														<p class="mt-3"><small>Requested on '.$requestinfo["support_date"].'</small></p>
														<p></p>
													</div>
													<div class="card-footer">
														<div class="row">
															<div class="col-12 col-lg-6 d-grid gap-2 ">
																<a href="'.$domain.'/dashboard/my-support/" class="btn btn-danger">Back</a>
															</div>
															<div class="col-12 col-lg-6 d-grid gap-2">
																<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Reply</button>
															</div>
														</div>
													</div>
												</div>											
												';
							
							?>
							</div>
							<div class="col-12 col-lg-8">
							<?php
								$sql = "SELECT * FROM support_content WHERE thread_id='$rid' ORDER BY id DESC";
								$result = $db->query($sql);

								if ($result->num_rows > 0) {
								  // output data of each row
								  while($row = $result->fetch_assoc()) {
									  if($row["thread_owner"] == "true"){
										  echo '
												<div class="card mb-4">
													<div class="card-header">'.$authuser["firstname"].' '.$authuser["lastname"].'
														<br><small>Client</small></div>
													<div class="card-body">
														
														
														
														<p>'.$row["thread_content"].'</p>
														<hr>
														<p><small><i>'.$row["thread_date"].'</i></small></p>
													</div>
												</div>											
												';
											
									  }else{
										    echo '
												<div class="card mb-4">
													<div class="card-header">Epink Tech
														<br><small>Staff</small></div>
													<div class="card-body">
														
														
														
														<p>'.$row["thread_content"].'</p>
														<hr>
														<p><small><i>'.$row["thread_date"].'</i></small></p>
													</div>
												</div>											
												';
										
									  }
										
								  }
								} else {
								  echo "0 results";
								}							
							?>
							</div>
							</div>

                    </div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Reply to support</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form method="POST">				
					<div class="mb-3">
						<label for="thread_content" class="form-label">Message</label>
						<textarea class="form-control" id="thread_content" name="thread_content" rows="3" placeholder=""></textarea>
					</div>
			</div>
			<div class="modal-footer">
			<button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
			<button type="submit" name="reply" id="reply" class="btn btn-primary">Reply</button>
			</form>
			</div>
		</div>
	</div>
</div>