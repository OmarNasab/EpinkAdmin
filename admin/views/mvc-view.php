 <?php
$bid = cleanInput($page_action_identifier);
$sql = "SELECT * FROM outreach_corporate WHERE id='$bid'";
$result = $db->query($sql);

if ($result->num_rows > 0) {
	$row = $result->fetch_assoc();
} else {
	echo "Not Found";
}

 
 ?>
 
 <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Detail</h1>
                </div>
                <div class="col-sm-6">
                   
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
		<?php
		if(isset($res)){
			echo $res;
		}
		?>

<p>Company Name : <?php echo $row["company_name"]; ?> </p>
<p>Company State : <?php echo $row["company_state"]; ?> </p>
<p>Company Phone Number : <?php echo $row["company_phone_number"]; ?> </p>
<p>Company postcode: <?php echo $row["postcode"]; ?> </p>
<p>Company email : <?php echo $row["company_email"]; ?> </p>
<p>Company PIC Name : <?php echo $row["pic_name"]; ?> </p>
<p>Staff to be vaccinated : <?php echo $row["quantity"]; ?> </p>
<p>Excel : <a href="<?php echo $row["excel_file"]; ?>">Download</a>
</div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
