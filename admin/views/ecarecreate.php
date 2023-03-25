<?php
if (isset($_POST["submitnews"]))
{
    $title = cleanInput($_POST["name"]);
    $image = "Available";
    $content = cleanInput($_POST["description"]);
    $requireattachment = cleanInput($_POST["requireattachment"]);
    $packages = cleanInput($_POST["packagesystem"]);
    $category = cleanInput($_POST["category"]);
    $subcategory = cleanInput($_POST["sub-category"]);
    $price = cleanInput($_POST["price"]);
    $walkinprice = cleanInput($_POST["walkinprice"]);

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
                $newssql = "INSERT INTO ecare_services (category, name, icon, description, price, subcategory, walkinprice, requireattachment, packages)
		VALUES ('$category', '$title', '$settingvalue', '$content', '$price', '$subcategory', '$walkinprice', '$requireattachment', '$packages')";

                if ($db->query($newssql) === true)
                {
                    $row["status"] = "successful";
                    $res = "Ecare service has been added <a href='/admin/ecare-manager/'>Back</a>";
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
            <h1>Create Ecare Service</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
				<li class="breadcrumb-item active"><a href="<?php echo $domain; ?>/ecare-manager/">Back</a></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->

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
	<label for="title">Name</label>
	<input class="form-control" type="text" id="name" name="name">
</div>
<div class="form-group">
	<label for="content">Require Attachment?</label>
	<select class="form-control" name="requireattachment" id="requireattachment">
		<option value="">Please select</option>
		<option value="true">Yes</option>
		<option value="false">No</option>
	</select>
</div>
<div class="form-group">
	<label for="title">Category</label> 
	<select id="category" name="category" class="form-control"  onchange="setSubcategory(this)">

	</select>
	
	</div>
</div>
<div class="form-group">
	<label for="sub-category">Sub Category</label>
		<select id="sub-category" name="sub-category" class="form-control">
		</select>

</div>
<?php
	$sql = "SELECT * FROM settings WHERE setting_item='ecarecategory'";
	$result = $db->query($sql);
	$ecare = $result->fetch_assoc();
	$ecaremain = $ecare["setting_value"];
	/* $catlength = count($ecaremain);
	for ($x = 0; $x < $catlength; $x++) {
	  echo '<option value="'.$ecaremain["$x"]->name.'" onselect>'.$ecaremain["$x"]->name.'</option>';
	} */
?>
<script>
var postCat = JSON.parse('<?php echo $ecaremain; ?>');
function initiateProductPoster(){
	var i;
	
	console.log(postCat);
	var select = document.getElementById('category');
	var option;
	//document.getElementById("productcategorysorter").innerHTML = '';
	console.log(postCat);
	option = document.createElement('option');
	option.appendChild(document.createTextNode("Please select a category"));
	option.setAttribute('value', "");
	select.appendChild(option);
	for (i = 0; i < postCat.length; i++) {
		firstcategory = postCat[0].name;
		var cate = postCat[i].name;
		var cate = cate.replace(/\s+/g, '-').toLowerCase();
		option = document.createElement('option');
		option.setAttribute('value', postCat[i].name);
		option.appendChild(document.createTextNode(postCat[i].name));
		select.appendChild(option);
	}
}
function setSubcategory(val){
	var catname = val.value;
	for (let i = 0; i < postCat.length; i++) {
		if(postCat[i].name == catname){
			var j;
			$("#sub-category").empty();
			console.log(postCat[i].sub);
			var subcat = postCat[i].sub;
			var select = document.getElementById('sub-category');
			var option;
			option = document.createElement('option');
			option.appendChild(document.createTextNode("Please select a sub category"));
			option.setAttribute('value', "");
			select.appendChild(option);
			for (j = 0; j < subcat.length; j++) {
				firstcategory = subcat[0].name;
				var cate = subcat[j].name;
				var cate = cate.replace(/\s+/g, '-').toLowerCase();
				option = document.createElement('option');
				option.setAttribute('value', subcat[j].name);
				option.appendChild(document.createTextNode(subcat[j].name));
				select.appendChild(option);
			}
		}
	}
}
initiateProductPoster();
</script>
<div class="form-group">
	<label for="content">Description</label>
	<input class="form-control" type="text" id="description" name="description" value="">
</div>

<div class="form-group">
	<label for="content">House Call Price (Leave empty if not accepting house call request)</label>
	<input class="form-control" type="number" step="0.01" id="price" name="price" value="">
</div>
<div class="form-group">
	<label for="walkinprice">Walk In Price  (Leave empty if not accepting walkin in request)</label>
	<input class="form-control" type="number" step="0.01" id="walkinprice" name="walkinprice" value="120.00">
</div>
<div class="form-group">
	<label for="content">Package System (Set to 0 if its a one time request)</label>
	<input class="form-control" type="number" id="packagesystem" name="packagesystem" value="0" onchange="">
</div>

<div id=""></div>
<button class="btn btn-primary black white-text" name="submitnews" id="submitnews" type="submit">SUBMIT</button> <br>

			</form>
		</div>
	</div>
	<?php } ?>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->