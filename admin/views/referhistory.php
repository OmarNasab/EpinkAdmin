<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Referral History</h1>
                </div>

            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
										<th>ID</th>
                                        <th>Referrer</th>                                
                                        <th>User</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $sql = "SELECT * FROM referral_usage"; 
                                        $result = $db->query($sql);
                                        
                                        if ($result->num_rows > 0) {
                                          // output data of each row
                                         while($row = $result->fetch_assoc()) {
											$reffererfulname = getfullname($row["code_owner"]);
											$reffereruser = getfullname($row["code_uwer"]);
											$hdate = humanDate($row["referral_date"]);
                                        	echo '
											<tr>
												<td>'.$row["id"].'</td>
												<td>'.$reffererfulname.'</td>
												<td>'.$reffereruser.'</td>
												<td>'.$hdate.'</td>
												
											</tr>';
										 }
                                                          
                                        } else {
											echo '<tr><td></td></tr>';
                                        }
                                        		
                                        ?>	  
                                </tbody>
                                <tfoot>
                                   
                                </tfoot>
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
