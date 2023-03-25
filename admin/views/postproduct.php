<?php 
if (isset($_POST["submitnews"]))
{
    $title = cleanInput($_POST["name"]);
    $image = "Available";
    $content = cleanInput($_POST["description"]);
    $price = cleanInput($_POST["price"]);
    $newsdate = $currentdatetime;
    $target_dir = "../assets/";
    if ($title != "" && $image != "" && $content != "" && $newsdate != "")
    {
		
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;

        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false)
        {
            $uploadOk = 1;
        }
        else 
        {
            $res = "File is not an image.";
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($target_file))
        {
            $res = "Sorry, file already exists.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 500000)
        {
            $res = "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
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

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0)
        {
            $res = "There is a problem with uploading your image";
            
            
        }
        else
        {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $newfilename))
            {

                $settingvalue = 'https://epink.health/assets/' . $filenameo;
                $newssql = "INSERT INTO elab_service (name, image, description, price)
		VALUES ('$title', '$settingvalue', '$content', '$newsdate')";

                if ($db->query($newssql) === true)
                {
                    $row["status"] = "successful";
                    $res = "Your promotion slider has been posted <a href='/admin/promotions/'>Back</a>";
                    $data = $row;
                }
                else
                {
                    $row["status"] = "fail";
                    $res = "Error: " . $sql . "<br>" . $db->error;
                    $data = $row;
                }
            }
            else
            {
                $res = "Sorry, there was an error uploading your file.";
            }
        }

    }
    else
    {
        $row["status"] = "fail";
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
            <h1>Post Product</h1> 
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
				Post Product
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
    <form action="<?php echo $actual_link; ?>" method="post" enctype="multipart/form-data">
		<input class="form-control" type="number" id="uploadtoid" name="uploadtoid"  value="<?php echo $id ; ?>" hidden/>
        <div class="form-group">
            <label>Select image to upload:</label>
            <input type="file" name="menuToUpload" id="menuToUpload" class="form-control" /> 
        </div>
        <div class="form-group">
            <label for="name">Product Name</label>
            <input class="form-control" type="text" id="name" name="name" />
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <input class="form-control" type="text" id="description" name="description" />
        </div>
        <div class="form-group">
            <label for="description">Category</label>        
			<select id="selectcategory" name="selectcategory" class="form-control">
			
			</select>
        </div>
       <script>
function initiateProductPoster(){
	var i;
	var ucat = '<?php echo $usersobject["categories"]; ?>';
	var postCat = JSON.parse(ucat);
	var select = document.getElementById('selectcategory');
	var option;
	console.log(postCat);
	for (i = 0; i < postCat.length; i++) {
		//document.getElementById("product_category").innerHTML += '<option value="'+postCat[i].name+'">'+postCat[i].name+'sasa</option>';
		option = document.createElement('option');
		option.setAttribute('value', postCat[i].name);
		option.appendChild(document.createTextNode(postCat[i].name));
		select.appendChild(option);
		console.log(option);
	}
}	   
initiateProductPoster();
	   </script>

        <div class="form-group">
            <label for="price">Price</label>
            <input class="form-control" type="text" id="originalprice" name="originalprice" onkeyup="updatePricechange(this)"/>
        </div>
        <div class="form-group">
            <label for="price"><?php echo $projectname; ?> Price</label>
            <input class="form-control" type="text" id="price" name="price" readonly />
        </div>
		<div class="row">
			<div class="col-sm-4">
				 <div class="form-group">
					<label for="addondata">Addon Name</label>
					<input class="form-control" type="text" id="addonname" name="addonname" />
				</div>
			</div>
			<div class="col-sm-4">
				 <div class="form-group">
					<label for="addondata">Addon Price</label>
					<input class="form-control" type="number" step="0.1" id="addonprice" name="addonprice" />
				 </div>
			</div>
			<div class="col-sm-4">
				<label>Action</label><br>
				<a href="#" onclick="addAddon()" class="btn btn-sm btn-primary">Add Addon</a>
			</div>
			
			<p>List of addon</p>
			<div class="col-sm-12 row" id="displayaddon">
		
			</div>
		</div>
	
            <input class="form-control" type="text" id="addondata" name="addondata" hidden/>
     

        <input class="form-control" type="text" id="delivery" name="delivery" value="Food" hidden />

        <input class="form-control" type="text" id="lat" name="lat"value="<?php echo $usersobject["lat"]; ?>" hidden> <input class="form-control" type="text" id="lng" name="lng" value="<?php echo $usersobject["lng"]; ?>" hidden>

        <div class="form-group">
            <input class="form-control" type="text" id="stock" name="stock" value="9999999" hidden />
        </div>

        <div class="form-group">
            <input class="form-control" type="text" id="available" name="available" value="On" hidden />
        </div>
        <input type="submit" value="Post Product" name="uploadmenu" class="btn btn-primary" />
    </form>
		</div>
		</div>
		
		</div>
	</div><br><br>
	<?php } ?>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->