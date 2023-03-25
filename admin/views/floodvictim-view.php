 <?php
$bid = cleanInput($page_action_identifier);
$sql = "SELECT * FROM gigrequest WHERE id='$bid'";
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


<p>Name : <?php echo $row["Name"]; ?> </p>
<p>Ic : <?php echo $row["Ic"]; ?> </p>
<p>Gender : <?php echo $row["Gender"]; ?> </p>
<p>Address : <?php echo $row["Address"]; ?> </p>
<p>Postcode : <?php echo $row["Postcode"]; ?> </p>
<p>Country : <?php echo $row["Country"]; ?> </p>
<p>Contact_no : <?php echo $row["Contact_no"]; ?> </p>
<p>Email : <?php echo $row["Email"]; ?> </p>
<p>Race : <?php echo $row["Race"]; ?> </p>
<p>Clinical_notes : <?php echo $row["Clinical_notes"]; ?> </p>
<p>Diagnosis : <?php echo $row["Diagnosis"]; ?> </p>
<p>Management : <?php echo $row["Management"]; ?> </p>
<p>Medication : </p>
<?php 
$meds = json_decode($row["Medication"]); 
$medslength = count($meds);
for ($x = 0; $x < $medslength; $x++) {
  echo $meds[$x]."<br>";
}
?>
<p>Doctor name : <?php echo $row["Doctor_name"]; ?> </p>
<p>Date : <?php echo $row["rqDate"]; ?> </p>
</div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>
function convertImage(element, target){
	var file1 = element.files[0];
	var reader = new FileReader();
	reader.onloadend = function() {
		document.getElementById(target).value = reader.result;	
	}
	reader.readAsDataURL(file1);
}
</script>