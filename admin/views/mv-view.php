 <?php
$bid = cleanInput($page_action_identifier);
$sql = "SELECT * FROM promo_vaccine WHERE id='$bid'";
$result = $db->query($sql);

if ($result->num_rows > 0) {
	$row = $result->fetch_assoc();
} else {
	echo "Articel Not Found";
}
if(isset($_POST["blog"])){
	    $title = cleanInput($_POST["title"]);
		$permalink = str_replace(" ", "-", $title).'-'.date("Y-m-d");
		$permalink = strtolower($permalink);
		$permalink =str_replace("!", "", $permalink);
		$permalink =str_replace("&", "", $permalink);
		$permalink =str_replace("?", "", $permalink);
        $content = $_POST["mytextarea"];
        $publishing = $currentdatetime;
		if($_POST["thumbnail"] != null){
			$thumbnail = processFile($_POST["thumbnail"]);
		}else{
			$thumbnail = $row["thumbnail"];
		}

	if($title != "" &&  $content != "" &&  $permalink != "" &&  $publishing != ""){
		$sql = "UPDATE blogs SET title='$title', content='$content', thumbnail='$thumbnail', publishing_date='$publishing_date'  WHERE id='$bid'";

		if ($db->query($sql) === TRUE) {
		  $res = "Record updated successfully";
		} else {
		  $res = "Error updating record: " . $db->error;
		}
	}else{
		$row["card"] = "red";
		$row["status"] = "Fail";
		$row["message"] = "Please fill all the form";
		$res = "Please fill all the form";
		$data = $row;
	}
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


<p>Name : <?php echo $row["full_name"]; ?> </p>
<p>Ic/Passport : <?php echo $row["ic_passport_no"]; ?> </p>
<p>Age : <?php echo $row["age"]; ?> </p>
<p>Gender : <?php echo $row["gender"]; ?> </p>
<p>My Sejahtera ID : <?php echo $row["my_sejahtera_id"]; ?> </p>
<p>Contact Number : <?php echo $row["contact_number"]; ?> </p>
<p>Nationality : <?php echo $row["nationality"]; ?> </p>
<p>Ethnicity : <?php echo $row["ethnicity"]; ?> </p>
<p>Second Dose Date : <?php echo $row["second_dose_date"]; ?> </p>
<p>Decond Dose Vaccine_name : <?php echo $row["second_dose_vaccine_name"]; ?> </p>
<p>State : <?php echo $row["state"]; ?> </p>
<p>District : <?php echo $row["district"]; ?> </p>
</div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>
