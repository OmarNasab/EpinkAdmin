<?php
if(isset($_POST["submitupdateecare_services"]) &&  $_POST["csrf"] == $_SESSION["csrftoken"]){
	$id = cleanInput($_POST["editid"]);
	$owner = $authUser["id"];
	$category = cleanInput($_POST["category"]);
	$subcategory = cleanInput($_POST["sub-category"]);
	$name = cleanInput($_POST["editname"]);
	$description = cleanInput($_POST["editdescription"]);
	$forusertype = cleanInput($_POST["editforusertype"]);
	$icon = uploadFile(cleanInput($_POST["editicon"]));
	$price = cleanInput($_POST["editprice"]);
	$packages = cleanInput($_POST["packages"]);
	$requireattachment = cleanInput($_POST["requireattachment"]);
	$walkinprice = cleanInput($_POST["walkinprice"]);
	if (strpos($_POST["editicon"], 'epink')) { 
		$sql = "UPDATE ecare_services SET category='$category', subcategory='$subcategory', name='$name', description='$description', forusertype='$forusertype', price='$price', walkinprice='$walkinprice', requireattachment='$requireattachment', packages='$packages'  WHERE id='$id'";
	}else{
		$icon = uploadFile(cleanInput($_POST["editicon"]));
		$sql = "UPDATE ecare_services SET category='$category', subcategory='$subcategory', name='$name', description='$description', forusertype='$forusertype', icon='$icon', price='$price', walkinprice='$walkinprice', requireattachment='$requireattachment', packages='$packages' WHERE  id='$id'";
	}
	
	

	if ($db->query($sql) === TRUE) {
		$row["card"] = "green";
		$row["status"] = "Successfull";
		$row["message"] = "The record has been updated successfully";
		$data = $row;
	} else {
		$row["card"] = "red";
		$row["status"] = "Fail";
		$row["message"] = "Error updating record: " . $db->error;
		$data = $row;
	}
}

$id = cleanInput($page_action_identifier);
$ecare_servicessql = "SELECT * FROM ecare_services WHERE id='$id'";
$ecare_servicesresult = $db->query($ecare_servicessql);
if ($ecare_servicesresult->num_rows > 0){
	$row = $ecare_servicesresult->fetch_assoc();
	$ecare_servicesobject = $row;
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
                    <h1>E-CARE Manager</h1>
                </div>
                <div class="col-sm-6"> 
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active"><a href="<?php echo $domain; ?>/ecare-manager/">Back</a></li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->

        <div class="container-fluid">
<form id="editecare_services" method="POST" action="<?php echo $page_url; ?>" >
<input type="text" id="csrf" name="csrf" value="<?php echo $csrftoken; ?>" hidden>
<input type="text" id="editid" name="editid" value="<?php echo $ecare_servicesobject["id"]; ?>" hidden>
<div class="form-group">
	<label for="editname">Name</label>
	<input type="text" id="editname" class="form-control" name="editname" value="<?php echo $ecare_servicesobject["name"]; ?>">
</div>

<div class="form-group">
	<label for="editdescription">Description</label>
	<input type="text" id="editdescription" class="form-control" name="editdescription" value="<?php echo $ecare_servicesobject["description"]; ?>">
</div>
<div class="form-group">
	<label for="title">Category</label>
	<select id="category" name="category" class="form-control" onchange="setSubcategory(this)">

	</select>
	<p class="text-xs">Category doesnt exist? <a href="<?php echo $domain; ?>/ecare-manager/category-manager/">edit here</a></p>
	</div>

<div class="form-group">
	<label for="sub-category">Sub Category</label>
		<select id="sub-category" name="sub-category" class="form-control">
			<option value="">Please select a sub category</option>
		</select>
		<p class="text-xs">Sub category doesnt exist? <a href="<?php echo $domain; ?>/ecare-manager/category-manager/">edit here</a></p>
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
	setSubAndMainCategory();
}
function setSubcategory(val){
	var catname = val.value;
	$("#sub-category").empty();
	for (let i = 0; i < postCat.length; i++) {
		if(postCat[i].name == catname){
			var j;
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
function initSubcategory(namee){
	var catname = namee;
	document.getElementById('sub-category').innerHTML = "";
	for (let i = 0; i < postCat.length; i++) {
		if(postCat[i].name == catname){
			var j;
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

function setSubAndMainCategory(){
	document.getElementById('category').value= '<?php echo $ecare_servicesobject["category"]; ?>';
	initSubcategory('<?php echo $ecare_servicesobject["category"]; ?>');
	setTimeout(function(){ document.getElementById('sub-category').value= '<?php echo $ecare_servicesobject["subcategory"]; ?>';}, 1000);
}
initiateProductPoster();
</script>



<div class="form-group">
	<label for="editicon">Icon</label>
	<br>
	<img src="<?php echo $ecare_servicesobject["icon"]; ?>" width="25%">
	<input type="text" id="editicon" class="form-control" name="editicon" value="<?php echo $ecare_servicesobject["icon"]; ?>" hidden><br/>
	<input type="file" onchange="convertImage(this, 'editicon')">
</div>

<div class="form-group">
	<label for="editprice">Price</label>
	<input type="number" id="editprice" step="0.01" name="editprice" class="form-control" value="<?php echo $ecare_servicesobject["price"]; ?>">
</div>
<div class="form-group">
	<label for="walkinprice">Walkin Price</label>
	<input class="form-control" type="number" step="0.01" id="walkinprice" name="walkinprice" value="<?php echo $ecare_servicesobject["walkinprice"]; ?>">
</div>
<div class="form-group">
	<label for="content">Package System (Set to 0 if its a one time request)</label>
	<input class="form-control" type="number" id="packages" name="packages" value="<?php echo $ecare_servicesobject["packages"]; ?>" onchange="">
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
	<button class="btn btn-primary white-text" name="submitupdateecare_services" id="submitupdateecare_services" type="submit">Submit</button>
</div>

</form>

    </section>
    <!-- /.content -->
</div>
<script>
var reqttac = '<?php echo $ecare_servicesobject["requireattachment"]; ?>';
if(reqttac == 'true'){
	document.getElementById("requireattachment").value = 'true';
}else{
	document.getElementById("requireattachment").value = 'false';
}
</script>