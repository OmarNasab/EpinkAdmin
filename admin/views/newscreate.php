 <?php
 if(isset($_POST["blog"])){
	
	    $title = cleanInput($_POST["title"]);
		$permalink = str_replace(" ", "-", $title);
		$permalink = strtolower($permalink);
        $content = $_POST["mytextarea"];
        $publishing = $currentdatetime;

	if($title != "" &&  $content != "" &&  $permalink != "" &&  $publishing != ""){
		$blogssql = "INSERT INTO blogs (title, content, permalink, publishing_date)
		VALUES ('$title', '$content', '$permalink', '$publishing')";

		if ($db->query($blogssql) === TRUE) {
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
                    <h1>Blog Poster</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Post article to your blog</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

  <form method="post">
  <div class="form-group">
	<label for="title">Title</label>
    <input type="text" class="form-control" id="title" name="title">
      
	</div>
  	<div class="form-group">
    <textarea id="mytextarea" name="mytextarea">
      
    </textarea>
	</div>
	<div class="form-group">
	<button type="submit" class="btn btn-primary" name="blog">SUBMIT</button>
	</div>
  </form>
  		</div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->