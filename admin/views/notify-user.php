<?php
if(isset($_POST["submitnotifcations"])){
        $title = cleanInput($_POST["title"]);
        $title_my =  cleanInput($_POST["title"]);
        $description = cleanInput($_POST["description"]);
        $description_my = cleanInput($_POST["description"]);
        $owner = 0;
        $news = "empty";
        $image = "empty";
	if($title != "" &&  $title_my != "" &&  $description != "" &&  $description_my != "" && $news != "" &&  $image != ""){
		$notifcationssql = "INSERT INTO notifcations (title, title_my, description, description_my, owner, news, image)
		VALUES ('$title', '$title_my', '$description', '$description_my', '$owner', '$news', '$image')";

		if ($db->query($notifcationssql) === TRUE) {
			$row["card"] = "green";
			$row["status"] = "Successful";
			$row["message"] =  "New record successfully created";
			$data = $row;
		} else {
			$row["card"] = "red";
			$row["status"] = "Fail";
			$row["message"] =  "Error: " . $sql . "<br>" . $db->error;
			$data = $row;
		}
	}else{
		$row["card"] = "red";
		$row["status"] = "Fail";
		$row["message"] = "Please fill all the form";
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
            <h1>Notify User</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content container">
	<?php
	if (isset($data)) {
		echo '<div class="card">
  <div class="card-body">
    ' . $data["message"] . '
  </div>
</div>';
	}
?>
<form id="inserttonotifcations" method="POST" > 

<div class="form-group">
	<label for="title">Title</label>
	<input class="form-control" type="text" id="title" name="title">
</div>

<div class="form-group">
	<label for="description">Content</label>
	<input class="form-control" type="text" id="description" name="description">
</div>

<button class="btn btn-primary white-text" name="submitnotifcations" id="submitnotifcations" type="submit">SUBMIT</button>
</form>	 
     

    </section>
    <!-- /.content -->
  </div>

