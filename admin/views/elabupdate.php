
<?php

if(isset($_POST["submitupdateelab_request"])){
		$id = cleanInput($page_action_identifier);
		$request_report = cleanInput($_POST["editrequest_report"]);
		$request_status = cleanInput($_POST["request_status"]);
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$target_dir = "../attachments/";
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
       


        if (file_exists($target_file))
        {
            $res = "Sorry, file already exists.";
            $uploadOk = 0;
        }

        if ($_FILES["fileToUpload"]["size"] > 500000)
        {
            $res = "Sorry, your file is too large.";
            $uploadOk = 0;
        }


        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "pdf")
        {
            $res = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";  

            $uploadOk = 0;

        }
        else
        {
            $filenameo = rand(1000, 100000) . '.' . $imageFileType;
            $newfilename = $target_dir . $filenameo;
        }


        if ($uploadOk == 0)
        {
           // $res = "There is a problem with uploading your files";
            
            
        }else
        {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $newfilename))
            {

                $settingvalue = 'https://epink.health/attachments/' . $filenameo;
				$sql = "UPDATE elab_request SET request_report='$request_report', request_status='$request_status', attachments='$settingvalue' WHERE id='$id' ";

				if ($db->query($sql) === TRUE) {
					$row["card"] = "green";
					$row["status"] = "Successfull";
					$res = "The record has been updated successfully back to elab request <a href='https://epink.health/admin/elab-requests/'>Back</a>";
					$data = $row;
				} else {
					$row["card"] = "red";
					$row["status"] = "Fail";
					$res = "Error updating record: " . $db->error;
					$data = $row;
				}

            }
            else
            {
                $res = "Sorry, there was an error uploading your file.";
            }
        }	
	
}

$id = cleanInput($page_action_identifier);
$elab_requestsql = "SELECT * FROM elab_request WHERE id='$id'";
$elab_requestresult = $db->query($elab_requestsql);
if ($elab_requestresult->num_rows > 0){
	$row = $elab_requestresult->fetch_assoc();
	$row["patient_name"] = getfullname($row["requester"]);
	$elab_requestobject = $row;
} else {
	$row["card"] = "red";
	$row["status"] = "Fail";
	$row["message"] = "The record you looking for does not exist <script>window.location.href= ''.$domain.'404';  </script>";
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
            <h1>E-Lab Request</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
             View & update elab request
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

	<div class="container-fluid">
		<?php
	
	if(isset($res)){
		echo '
		<div class="card">
			<div class="card-header">Result</div>
			<div class="card-body">'.$res.'</div>
		</div>
		';
		
	}else{
	
	
	?>
		<div id="">
		<div class="card">

  <div class="card-body">
			<p>Patient: <?php echo $elab_requestobject["patient_name"];?></p>
			<p>Test Type: <?php echo $elab_requestobject["service_name"];?></p>
			<p>Request Date: <?php echo date('F jS, Y h:i A', strtotime($elab_requestobject["sample_collection_date"]));?></p>
			<form method="POST" enctype="multipart/form-data">
			<input type="text" id="editid" name="editid" value="<? echo $page_action_identifier; ?>" hidden>
<div class="form-group">
	<label for="title">Report</label>
	<textarea class="form-control" name="editrequest_report"><?php echo $elab_requestobject["request_report"]; ?></textarea>
</div>
<div class="form-group">
	<label for="title">Report</label>
		<select id="request_status" name="request_status" class="form-control">
		<?php 
		if($elab_requestobject["request_status"] == "New"){
			echo '
			<option value="New">New</option>
			<option value="Completed">Completed</option>
			';
		}else{
			echo '
			<option value="Completed">Completed</option>
			<option value="New">New</option>
			
			';
		}
		?>
		</select>
</div>
<div class="form-group">
	<label for="image">Attachment</label>
	<input  type="file" class="form-control" id="fileToUpload" name="fileToUpload" accept="application/pdf">
</div>

<button class="btn btn-primary black white-text" name="submitupdateelab_request" id="submitupdateelab_request" type="submit">SUBMIT</button> 
			</form>
			  </div>
</div>
		</div>
	</div>
	<?php } ?>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->