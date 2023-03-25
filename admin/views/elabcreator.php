<?php
if(isset($_POST["inserttoelab_service"])){
	$category = cleanInput($_POST["editcategory"]);
	$subcategory = cleanInput($_POST["subeditcategory"]);
	$name = cleanInput($_POST["editname"]);
	$description = cleanInput($_POST["editdescription"]);
	$forusertype = 0;
	
	$image = uploadFile(cleanInput($_POST["editicon"]));
	$price = cleanInput($_POST["editprice"]);
	$walkinprice = cleanInput($_POST["editwalkinprice"]);

	if($name != ""){
		$elab_servicesql = "INSERT INTO elab_service (name, description, image, price, walkinprice,  type, category, subcategory)
		VALUES ('$name', '$description', '$image', '$price', '$walkinprice', '$type', '$category', '$subcategory')";

		if ($db->query($elab_servicesql) === TRUE) {
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
                    <h1>Create E-Lab Service</h1>
                </div>
                <div class="col-sm-6"> 
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active"><a href="<?php echo $domain; ?>/elab/">BACK</a></li>
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
		echo '
		<div class="card">
			<div class="card-header">Result</div>
			<div class="card-body">'.$res.'</div>
		</div>
		';
		
	}
	
	
	?>
<form id="editecare_services" method="POST" action="" >
<input type="text" id="csrf" name="csrf" value="<?php echo $csrftoken; ?>" hidden>
<input type="text" id="editid" name="editid" value="<?php echo $ecare_servicesobject["id"]; ?>" hidden>
<div class="form-group">
	<label for="title">Category</label>
	<select id="editcategory" name="editcategory" class="form-control" onchange="setSubcategory(this)">
	</select>
	

</div>
<div class="form-group">
	<label for="title">Sub Category</label>
		<select id="subeditcategory" name="subeditcategory" class="form-control">
	</select>

</div>	


<div class="form-group">
	<label for="editname">Name</label>
	<input type="text" id="editname" class="form-control" name="editname" value="" >
</div>

<div class="form-group">
	<label for="editdescription">Description</label>
	<input type="text" id="editdescription" class="form-control" name="editdescription" value="">
</div>

<div class="form-group">
	<label for="editicon">Icon</label>
	<input type="text" id="editicon" class="form-control" name="editicon" value="" hidden><br/>
	<input type="file" onchange="convertImage(this, 'editicon')" accept="image/png, image/gif, image/jpeg">
</div>

<div class="form-group">
	<label for="editprice">House Call Price</label>
	<input type="number" id="editprice" step="0.01" name="editprice" class="form-control" value="">
</div>
<div class="form-group">
	<label for="editprice">Walk In Price</label>
	<input type="number" id="editwalkinprice" step="0.01" name="editwalkinprice" class="form-control" value="">
</div>
<div class="form-group">
	<button class="btn btn-primary white-text" name="inserttoelab_service" id="inserttoelab_service" type="submit">Submit</button>
</div>
</form>
<br>

    </section>
    <!-- /.content -->
</div>
<?php
	$sql = "SELECT * FROM settings WHERE setting_item='elabcategory'";
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
	var select = document.getElementById('editcategory');
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
	document.getElementById('subeditcategory').innerHTML = "";
	for (let i = 0; i < postCat.length; i++) {
		if(postCat[i].name == catname){
			var j;
			$("#sub-category").empty();
			console.log(postCat[i].sub);
			var subcat = postCat[i].sub;
			var select = document.getElementById('subeditcategory');
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
