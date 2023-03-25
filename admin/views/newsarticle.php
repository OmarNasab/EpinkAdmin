 <?php

if(isset($_POST["blog"])){
	    $title = cleanInput($_POST["title"]);
		$permalink = str_replace(" ", "-", $title).'-'.strtotime($currentdatetime);
		$permalink = strtolower($permalink);
		$permalink =str_replace("!", "", $permalink);
		$permalink =str_replace("&", "", $permalink);
		$permalink =str_replace("?", "", $permalink);
        $content = cleanInput($_POST["mytextarea"]);
        $category = cleanInput($_POST["category"]);
        $publishing = $currentdatetime;
		$thumbnail = processFile($_POST["thumbnail"]);

	if($title != "" &&  $content != "" &&  $permalink != "" &&  $publishing != "" && $category != ""){
		$blogssql = "INSERT INTO blogs (title, content, permalink, publishing_date, thumbnail, category)
		VALUES ('$title', '$content', '$permalink', '$publishing', '$thumbnail', '$category')";

		if ($db->query($blogssql) === TRUE) {
			$row["card"] = "green";
			$row["status"] = "Successful";
			$row["message"] =  "New record successfully created";
			$res =  "New record successfully created";
			$data = $row;
		} else {
			$row["card"] = "red";
			$row["status"] = "Fail";
			$row["message"] =  "Error: " . $sql . "<br>" . $db->error;
			$res =  "Error: " . $sql . "<br>" . $db->error;
			$data = $row;
			
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
                    <h1>News Articles</h1>
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
		<?php
		if(isset($res)){
			echo $res;
		}
		?>

  <form method="post">
	<div class="form-group">
		<label for="title">Title</label>
		<input type="text" class="form-control" id="title" name="title">   
	</div>
		<div class="form-group">
		<input type="text" name="category" id="category" value="news-article" hidden>
	</div>
	<div class="form-group">
		<label for="title">Header Image</label>
		<input type="file" class="form-control" id="image" name="image" onchange="convertImage(this, 'thumbnail')">
		<input type="text" class="form-control" id="thumbnail" name="thumbnail" hidden>
	</div>
  	<div class="form-group">
		<label for="title">URL</label>
		<input type="text" class="form-control" id="mytextarea" name="mytextarea">
		
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