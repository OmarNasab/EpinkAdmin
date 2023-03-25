<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Speciality Verification Request</h1>
                </div>
                <div class="col-sm-6"> 
              
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
										<th>Requester</th>
										<th>Date</th>
                                        
										<th>NSR E-cert</th>
										<th>NSR No</th>
										<th>Speciality</th>
										<th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
										$sql = "SELECT * FROM specialist_verification";
										$result = $db->query($sql);
										if ($result->num_rows > 0){
											while($row = $result->fetch_assoc()){
												$uid = $row["requester_id"];
												$sqlu = "SELECT id, firstname, lastname FROM users WHERE id='$uid'";
												$resultu = $db->query($sqlu);

												if ($resultu->num_rows > 0) {
													$rowu = $resultu->fetch_assoc();
													$fullname = $rowu["firstname"].' '.$rowu["lastname"];
													$ic = $rowu["ic_number"];
												}
												echo '
													<tr>
														<td>'.$fullname.'<br> '.$ic.'</td>
														<td>'.$row["request_date"].'</td>
														<td><a href="'.$row["nsrfile"].'" target="_blank">NSR Ecert</a></td>
														<td>'.$row["nsrid"].'</td>
														<td>'.$row["specialties"].'</td>
														<td>
															<a href="https://epink.health/admin/specialityverification/approve/'.$row["id"].'/">Approve</a>
															<a href="https://epink.health/admin/specialityverification/decline/'.$row["id"].'/">Decline</a>
														</td>
													</tr>
												
												';
											}
										}
									?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>



