<?php

?>

 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Create Promotion Code</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
             Create promotion code
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
			<form method="POST" enctype="multipart/form-data">
			<input type="text" id="csrf" name="csrf" value="<? echo $csrftoken; ?>" hidden>
<div class="form-group">
	<label for="image">Image</label>
	<input  type="file" class="form-control" id="fileToUpload" name="fileToUpload">
</div>
<div class="form-group">
	<label for="title">Title</label>
	<input class="form-control" type="text" id="title" name="title">
</div>
<div class="form-group">
	<label for="content">content</label>
	<input class="form-control" type="text" id="content" name="content">
</div>
<button class="btn btn-primary black white-text" name="submitnews" id="submitnews" type="submit">SUBMIT</button> 
			</form>
		</div>
	</div>
	<?php } ?>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->