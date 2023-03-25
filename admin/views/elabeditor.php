 <?php
$bid = cleanInput($page_action_identifier);
$sql = "SELECT * FROM elab_service WHERE id='$bid'";
$result = $db->query($sql);

if ($result->num_rows > 0) {
	$row = $result->fetch_assoc();
} else {
	echo "Not FOund";
}
if(isset($_POST["updateservice"])){
	    $title = cleanInput($_POST["name"]);
	    $price = cleanInput($_POST["price"]);
	    $walkinprice = cleanInput($_POST["walkinprice"]);
	    $description = cleanInput($_POST["description"]);
	    $category = cleanInput($_POST["editcategory"]);
	    $subcategory = cleanInput($_POST["subeditcategory"]);
	    $description = cleanInput($_POST["description"]);
		if($_POST["thumbnail"] != ""){
			$thumbnail = processFile($_POST["thumbnail"]);
		}else{
			$thumbnail = $row["image"];
		}
	if($title != "" &&  $description != "" && $price != ""){
		$sql = "UPDATE elab_service SET name='$title', image='$thumbnail', description='$description', price='$price', category='$category', subcategory='$subeditcategory', walkinprice='$walkinprice' WHERE id='$bid'";

		if ($db->query($sql) === TRUE) {
		  $res = 'Record updated successfully <a href="'.$domain.'/elab/">Back</a>';
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
                    <h1>Edit E-Service</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active"><a href="<?php echo $domain; ?>/elab/">Back to elab</a></li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->

        <div class="container-fluid">
		<?php
		if(isset($res)){
			echo '<div class="card"><div class="card-body">'.$res.'</div></div>';
			
		}
		?>

  <form method="post">
  <div class="form-group">
	<label for="title">Name</label>
	<input class="form-control" type="text" id="name" name="name"  value="<?php echo $row["name"]; ?>">
</div>
<div class="form-group">
	<label for="content">Description</label>
	<input class="form-control" type="text" id="description" name="description" value="<?php echo $row["description"]; ?>">
</div>
<div class="form-group">
	<label for="content">House Call Price</label>
	<input class="form-control" type="number" step="0.01" id="price" name="price"  value="<?php echo $row["price"]; ?>">
</div>
<div class="form-group">
	<label for="content">Walk In Price</label>
	<input class="form-control" type="number" step="0.01" id="walkinprice" name="walkinprice"  value="<?php echo $row["walkinprice"]; ?>">
</div>
  <div class="form-group">
	<label for="title">Header Image</label>
	<br>
	<img src="<?php echo $row["image"]; ?>" width="250px"><br><br>
    <input type="file" class="form-control" id="image" name="image" onchange="convertImage(this, 'thumbnail')">
    <input type="text" class="form-control" id="thumbnail" name="thumbnail" hidden>
      
	</div>
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
	<button type="submit" class="btn btn-primary" name="updateservice">SUBMIT</button>
	</div>
	<br>
  </form>
  		</div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
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
	var select = document.getElementById('editcategory');
	var option;
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
	setCurrentcategory();
}
function setSubcategory(val){
	var catname = val.value;
	document.getElementById('subeditcategory').innerHTML = "";
	for (let i = 0; i < postCat.length; i++) {
		if(postCat[i].name == catname){
			var j;
			$("#subcategory").empty();
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
function setSubcategorysecondary(val){
	var catname = val;
	document.getElementById('subeditcategory').innerHTML = "";
	for (let i = 0; i < postCat.length; i++) {
		if(postCat[i].name == catname){
			var j;
			
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

function convertImage(element, target){
	var file1 = element.files[0];
	var reader = new FileReader();
	reader.onloadend = function() {
		document.getElementById(target).value = reader.result;	
	}
	reader.readAsDataURL(file1);
}

var currentproductsubcategory;
function setCurrentcategory(){
	var currentproductcategory = '<?php echo $row["category"]; ?>';
	setSubcategorysecondary(currentproductcategory);
	currentproductsubcategory = '<?php echo $row["subcategory"]; ?>';
	document.getElementById("editcategory").value = currentproductcategory;
	document.getElementById("subeditcategory").value = currentproductsubcategory;
}

</script>