<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>ORDER DETAIL</h1>
					<p>Order Full detail </p>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">ORDER DETAIL</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">


                                    <?php
										$id = cleanInput($page_identifier_action);
                                        $sql = "SELECT * FROM job_order WHERE id='$id'";
                                        $result = $db->query($sql);
                                        $neworders = $result->num_rows;
                                        if ($result->num_rows > 0) {
                                          // output data of each row
                                          while($row = $result->fetch_assoc()) {
												$userid = $row["owner"];
												$sqls = "SELECT * FROM users WHERE id='$userid'";
												$results = $db->query($sqls);
												if ($results->num_rows > 0) {
												  $rows = $results->fetch_assoc();
												}											  
												$riderid = $row["runner"];
												$sqlrunner = "SELECT * FROM users WHERE id='$riderid'";
												$resultsrunner = $db->query($sqlrunner);
												if ($resultsrunner->num_rows > 0) {
												  $rowrunner = $resultsrunner->fetch_assoc();
												  $runnerfullname = '<a href="'.$domain.'/riders/'.$rowrunner["id"].'/">'.$rowrunner["firstname"].' '.$rowrunner["lastname"].'</a>';
												}else{
													$runnerfullname = '3rd Party Rider<br>ID '.$row["speedy_order_id"].'';
												}	
											
												$resid = $row["restaurant_id"];
												$sqlsr = "SELECT * FROM users WHERE id='$resid'";
												$resultr = $db->query($sqlsr);
												if ($resultr->num_rows > 0) {
												  $rowsr = $resultr->fetch_assoc();
												}	
											  $company_profit = $row["cart_price"] - $row["restaurant_profit"];
											  
											  $establishment_profit = $row["restaurant_profit"];
											  $row["customerneedtopay"] = $row["cart_price"] + $row["delivery_price"];
											  $curdate = date("F jS, Y g:i a", strtotime($row["order_date"]));
											  echo '
											 
												<p>Order Id - '.$row["id"].' Date & Time - '.$curdate.' </p>
												<div class="row">
												<div class="col-sm-4">
												<div class="card card-widget widget-user-2">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header bg-info">
                <div class="widget-user-image">
                  <img class="img-circle elevation-2" src="'. $rows["profile_img"].'" alt="User Avatar">
                </div>
                <!-- /.widget-user-image -->
                <h3 class="widget-user-username"><a href="'.$domain.'/customers/'.$rows["id"].'/">'. $rows["firstname"].' '. $rows["lastname"].'</a></h3>
                <h5 class="widget-user-desc">'.$rows["phonenumber"].'</h5>
              </div>
            </div>
			</div>

<div class="col-sm-4">
												<div class="card card-widget widget-user-2">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header bg-info">
                <div class="widget-user-image">
                  <img class="img-circle elevation-2" src="'. $rows["profile_img"].'" alt="User Avatar">
                </div>
                <!-- /.widget-user-image -->
                <h3 class="widget-user-username"><a href="'.$domain.'/establishment-manager/'.$rowsr["id"].'/">'. $rowsr["vendor_name"].'</a></h3>
                <h5 class="widget-user-desc">'. $rowsr["phonenumber"].'</h5>
              </div>
            </div>
			</div>	
	
			</div>
												<p><a href="'.$domain.'/customers/'.$rows["id"].'/">'. $rows["firstname"].' '. $rows["lastname"].'</a><br> '.$rows["phonenumber"].'</p>
												<p><a href="'.$domain.'/establishment-manager/'.$rowsr["id"].'/">'. $rowsr["vendor_name"].'</a><br>'. $rowsr["phonenumber"].'</p>
												<p>'.$runnerfullname.'<br> '.$rowrunner["phonenumber"].'</p>
											
												<p>'.$row["order_status"].'</p>
												<p>RM'. $establishment_profit.'</p>
												<p>RM'. $company_profit.'</p>
												<p>'. $row["payment_type"].'</p>
												
											
											  ';
											  
											  
echo '
		  <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Order Detail</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
              <div class="row">
                <div class="col-12 col-sm-4">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Vendor Profit</span>
                      <span class="info-box-number text-center text-muted mb-0">RM'. $establishment_profit.'</span>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-4">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Company Profit</span>
                      <span class="info-box-number text-center text-muted mb-0">RM'. $company_profit.'</span>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-4">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Payment Method</span>
                      <span class="info-box-number text-center text-muted mb-0">'. $row["payment_type"].' <span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                
                    <div class="post">
                      <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="'.$rows["profile_img"].'" alt="user image">
                        <span class="username">
                         <a href="'.$domain.'/customers/'.$rows["id"].'/">'. $rows["firstname"].' '. $rows["lastname"].'</a>(Customer)
                        </span>
                        <span class="description">Order Id - '.$row["id"].' Date & Time - '.$curdate.' </span>
                      </div>
                      <!-- /.user-block -->
                      

                      <p>sasa
                       
                      </p>
                    </div>

                    <div class="post clearfix">
                      <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="'.$rowsr["profile_img"].'" alt="User Image">
                        <span class="username">
                          <a href="'.$domain.'/establishment-manager/'.$rowsr["id"].'/">'. $rowsr["vendor_name"].' </a>(Vendor)
                        </span>
                        <span class="description">Received</span>
                      </div>
                      <!-- /.user-block -->
                      <p>
                       
                      </p>
                      <p>
                       
                      </p>
                    </div>

                    <div class="post">
                      <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="'.$rows["profile_img"].'" alt="user image">
                        <span class="username">
                          <a href="#">'.$runnerfullname.' (Rider)</a>
                        </span>
                        <span class="description"></span>
                      </div>
                      <!-- /.user-block -->
                      <p>
                       
                      </p>

                      <p>
                        
                      </p>
                    </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
              <h3 class="text-primary">Status - '.$row["order_status"].' </h3>
              <h5 class="mt-5 text-muted">Products</h5>
              <ul class="list-unstyled">
                <li>
                 
                </li>
                
              </ul>
             
            </div>
          </div>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

';											  
										  }
											
											  

                                          
                                        } else {
                                          
                                        }
                                        		
                                        ?>	  


        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>



