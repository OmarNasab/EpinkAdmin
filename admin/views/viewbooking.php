<?php
	$id = cleanInput($page_identifier_action);
	$bookingssql = "SELECT * FROM bookings WHERE id='$id'";
	$bookingsresult = $db->query($bookingssql);
	if ($bookingsresult->num_rows > 0){
		$row = $bookingsresult->fetch_assoc();
		$bookingsdata = $row;
		
	} else {
		$row["card"] = "red";
		$row["status"] = "Fail";
		$row["message"] = "The record you looking for does not exist<script>window.location.href= ''.$domain.'/404';</script>";
		$data = $row;
	}

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Booking Detail</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active"><a href="<?php echo $domain; ?>/booking-management/" class="btn btn-primary">BACK</a></li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
<table class="table-responsive" >
		<thead>
			<tr>
				<th>Field</th>
				<th>Content</th>
			</tr>
		</thead>

		<tbody>
		   <tr>
										<td> 
										Name
										</td> 
										<td> 
										<?php echo $bookingsdata["name"]; ?>
										</td> 
									</tr><tr>
										<td> 
										Ic passport
										</td> 
										<td> 
										<?php echo $bookingsdata["ic_passport"]; ?>
										</td> 
									</tr><tr>
										<td> 
										Phone number
										</td> 
										<td> 
										<?php echo $bookingsdata["phone_number"]; ?>
										</td> 
									</tr><tr>
										<td> 
										Booking date
										</td> 
										<td> 
										<?php echo $bookingsdata["booking_date"]; ?>
										</td> 
									</tr><tr>
										<td> 
										Booking time
										</td> 
										<td> 
										<?php echo $bookingsdata["booking_time"]; ?>
										</td> 
									</tr><tr>
										<td> 
										Email
										</td> 
										<td> 
										<?php echo $bookingsdata["email"]; ?>
										</td> 
									</tr><tr>
										<td> 
										Booking type
										</td> 
										<td> 
										<?php echo $bookingsdata["booking_type"]; ?>
										</td> 
									</tr><tr>
										<td> 
										Booking data
										</td> 
										<td> 
										<?php 
										
										echo $bookingsdata["booking_data"]; 
										$databooking = json_decode($bookingsdata["booking_data"]);
										$amount = $databooking->testTotalPrice;
										echo $amount
										
										?>
										</td> 
									</tr><tr>
										<td> 
										Paid
										</td> 
										<td> 
										<?php echo $bookingsdata["paid"]; ?>
										</td> 
									</tr>
		</tbody>
	</table>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>



