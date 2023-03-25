  <?php
$sql = "SELECT id FROM users WHERE type='0'";
$result = $db->query($sql);
$customercount=$result->num_rows;
$sql = "SELECT id FROM users WHERE type='2'";
$result = $db->query($sql);
$ridercount=$result->num_rows;
$sql = "SELECT id FROM users WHERE type='1'	";
$result = $db->query($sql);
$restaurantcount=$result->num_rows;
$sql = "SELECT id FROM users WHERE type='4'";
$result = $db->query($sql);
$pharmacist=$result->num_rows;
$sql = "SELECT id FROM users WHERE type='6'";
$result = $db->query($sql);
$doccount=$result->num_rows;
$sqldimg = "SELECT * FROM settings WHERE setting_item='parcel_delivery_cut'";
$imgresult = $db->query($sqldimg);
if ($imgresult->num_rows > 0) {
	$imgrow = $imgresult->fetch_assoc();
	$parcel_delivery_cut = $imgrow["setting_value"];
}
$sqlx = "SELECT * FROM job_order WHERE order_status='Completed'";
$resultx = $db->query($sqlx);
if ($resultx->num_rows > 0) {
  $totalprofit = 0.00;
  $totalsales = 0.00;
  while($rowx = $resultx->fetch_assoc()) {
	  $job_price = $rowx["cart_price"];
	  $totalsales = $totalsales + $rowx["cart_price"];
	  $companyprofitinthisorder = $parcel_delivery_cut * $job_price / 100;
	  $totalprofit = $totalprofit + $companyprofitinthisorder;
  }
} else {
	  $totalprofit = 0.00;
}
$sql = "SELECT * FROM senangpay WHERE order_status='successful' AND type='credit'";
$result = $db->query($sql);
if ($result->num_rows > 0) {
	$totalcredittopup = 0.00;
  while($row = $result->fetch_assoc()) {
    $totalcredittopup = $totalcredittopup + $row["amount"];
  }
} else {

}
$sql = "SELECT * FROM senangpay WHERE order_status='successful' AND type='wallet'";
$result = $db->query($sql);
if ($result->num_rows > 0) {
	$totalwallettopup = 0.00;
  while($row = $result->fetch_assoc()) {
    $totalwallettopup = $totalwallettopup + $row["amount"];
  }
} else {

}
  ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Dashboard</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Welcome back <?php echo $authuser["firstname"].' '.$authuser["lastname"]; ?></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
	<div class="container-fluid">
	<p>Users</p>
<div class="row">

          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php echo $customercount; ?></h3>

                <p>Patients</p>
              </div>
              <div class="icon">
                <i class="fas fa-users"></i>
              </div>
              <a href="<?php echo $domain;?>/customers/" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php echo $doccount; ?></h3>

                <p>Doctors</p>
              </div>
              <div class="icon">
                <i class=" fas fa-utensils"></i>
              </div>
              <a href="<?php echo $domain;?>/doctors/" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?php echo $pharmacist; ?></h3>

                <p>Pharmacist</p>
              </div>
              <div class="icon">
                <i class="fas fa-store"></i>
              </div>
              <a href="<?php echo $domain;?>/pharmacist/" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?php echo $ridercount; ?></h3>

                <p>Riders</p>
              </div>
              <div class="icon">
                <i class="fas fa-biking"></i>
              </div>
              <a href="<?php echo $domain;?>/riders/" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>	
	<?php if($authuser["type"] == 8){ ?>
		<p>Finance</p>
<div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>RM<?php echo round($totalsales, 2); ?></h3>

                <p>Gross Sales</p>
              </div>
              <div class="icon">
                <i class="fas fa-users"></i>
              </div>
            </div>
          </div>
			<div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>RM<?php echo round($totalprofit, 2); ?></h3>

                <p>Profit</p>
              </div>
              <div class="icon">
                <i class="fas fa-users"></i>
              </div>
             
            </div>
          </div>

          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>RM<?php echo $totalcredittopup; ?></h3>

                <p>Rider Top Up</p>
              </div>
              <div class="icon">
                <i class=" fas fa-utensils"></i>
              </div>
              
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>RM<?php echo $totalwallettopup; ?></h3>

                <p>Customer Top Up</p>
              </div>
              <div class="icon">
                <i class=" fas fa-utensils"></i>
              </div>
              
            </div>
          </div>
        </div>	
	<?php } ?>
</div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->