 <?php
$bid = cleanInput($page_action_identifier);
$sql = "SELECT * FROM blogs WHERE id='$bid'";
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
		<?php
		if(isset($res)){
			echo $res;
		}
		?>

  <form method="post">
  <div class="form-group">
	<label for="title">Title</label>
    <input type="text" class="form-control" id="title" name="title" value="<?php echo $row["title"]; ?>">
      
	</div>
  <div class="form-group">
	<label for="title">Header Image</label>
    <input type="file" class="form-control" id="image" name="image" onchange="convertImage(this, 'thumbnail')">
    <input type="text" class="form-control" id="thumbnail" name="thumbnail" hidden>
      
	</div>
  	<div class="form-group">
    <textarea id="mytextarea" name="mytextarea">
      <?php echo $row["content"]; ?>
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