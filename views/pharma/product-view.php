<?php
$owner = cleanInput($authuser["id"]);
$pid = cleanInput($final_identifier);
if(isset($_POST["updateproduct"])){
	$name = cleanInput($_POST["name"]);
	$description = cleanInput($_POST["description"]);
	$width = cleanInput($_POST["width"]);
	$height = cleanInput($_POST["height"]);
	$length = cleanInput($_POST["length"]);
	$unit = cleanInput($_POST["unit"]);
	$weight = cleanInput($_POST["weight"]);
	$weightunit = cleanInput($_POST["weightunit"]);
	

	
	
	
	$addondata = cleanInput($_POST["addondata"]);
	$originalprice = cleanInput($_POST["originalprice"]);
	$price = cleanInput($_POST["price"]);
	$lat = cleanInput($_POST["lat"]);
	$lng = cleanInput($_POST["lng"]);
	$stock = cleanInput($_POST["stock"]);
	$available = cleanInput($_POST["available"]);
	$require_prescription = cleanInput($_POST["require_prescription"]);
	$category = cleanInput($_POST["category"]);
	$subcategory = cleanInput($_POST["subcategory"]);
	$faq = cleanInput($_POST["faq"]);
	$forgot = cleanInput($_POST["forgot"]);
	$overview = cleanInput($_POST["overview"]);
	$tip = cleanInput($_POST["tip"]);
	$sideeffect = cleanInput($_POST["sideeffect"]);
	$precaution = cleanInput($_POST["precaution"]);
	$about = cleanInput($_POST["about"]);
	$product_form = cleanInput($_POST["product_form"]);
	$expiry_date = cleanInput($_POST["expiry_date"]);
	
	if($_POST["productpicture"] == ""){
		$sql = "UPDATE products SET owner='$owner', name='$name', description='$description', addondata='$addondata', originalprice='$originalprice', price='$price', lat='$lat', lng='$lng', stock='$stock', available='$available', require_prescription='$require_prescription', category='$category', subcategory='$subcategory', faq='$faq', forgot='$forgot', overview='$overview', tip='$tip', sideeffect='$sideeffect', precaution='$precaution', about='$about', product_form='$product_form', expiry_date='$expiry_date', width='$width', width = '$width', height='$height', length='$length', unit='$unit', weight='$weight', weightunit='$weightunit' WHERE  id='$pid' ";
	}else{
		$picture = processFile($_POST["productpicture"]);
		$sql = "UPDATE products SET owner='$owner', name='$name', description='$description', addondata='$addondata', originalprice='$originalprice', price='$price', lat='$lat', picture='$picture', lng='$lng', stock='$stock', available='$available', require_prescription='$require_prescription', category='$category', subcategory='$subcategory', faq='$faq', forgot='$forgot', overview='$overview', tip='$tip', sideeffect='$sideeffect', precaution='$precaution', about='$about', product_form='$product_form', expiry_date='$expiry_date', width = '$width', height='$height', length='$length', unit='$unit', weight='$weight', weightunit='$weightunit' WHERE  id='$pid' ";
	}
	

	if ($db->query($sql) === TRUE) {
		$row["card"] = "green";
		$row["status"] = "Successfull";
		$row["message"] = "The record has been updated successfully".$picture;
		$res = $row["message"];
		$data = $row;
	} else {
		$row["card"] = "red";
		$row["status"] = "Fail";
		$row["message"] = "Error updating record: " . $db->error;
		$res = $row["message"];
		$data = $row;
	}	
}




$query = "SELECT * FROM products WHERE id='$pid'"; 
$result = $db->query($query); 
if($result->num_rows > 0){
    $products = $result->fetch_assoc();
    $products["status"] = "success";
}else{

}
?>
<header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
	<div class="container-xl px-4">
		<div class="page-header-content">
			<div class="row align-items-center justify-content-between pt-3">
				<div class="col-auto mb-3">
					<h1 class="page-header-title">
						<div class="page-header-icon"><i data-feather="box"></i></div>
						Edit Product
					</h1>
				</div>
				<div class="col-12 col-xl-auto mb-3">  
					<a class="btn btn-sm btn-light text-primary" href="<?php echo $domain; ?>/pharmacy-panel/products/">Back</a>    
                </div>
			</div>
		</div>
	</div>
</header>
<div class="container-xl px-4">
<?php
	if (isset($res)) {
		echo '<div class="card mb-4"><div class="card-body">' . $res . '</div></div>';
	}
?>
	<div class="card mb-4">
		<div class="card-header text-dark">Product Information </div>
		<div class="card-body">
		<form action="<?php echo $actual_link; ?>" method="post" enctype="multipart/form-data">
			<div class="form-group mb-4">
				<label>Product Image *</label><br>
				<img width="200px" src="<?php echo $products["picture"]; ?>"><br>
				<input type="file" name="menuToUpload" id="menuToUpload" class="form-control" onchange="processFile(this, 'productpicture')"/> 
				<input type="text" name="productpicture" id="productpicture" class="form-control" hidden /> 
			</div>
			<div class="form-group mb-4">
				<label for="name">Name *</label>
				<input class="form-control" type="text" id="name" name="name" value="<?php echo $products["name"]; ?>"/>
			</div>
			<div class="form-group mb-4">
				<label for="name">Expiry Date *</label>
				<input class="form-control" type="date" id="expiry_date" name="expiry_date" value="<?php echo $products["expiry_date"]; ?>" />
			</div>
			<div class="form-group mb-4">
				<label for="name">Stock *</label>
				<input class="form-control" type="number" id="stock" name="stock" value="<?php echo $products["stock"]; ?>"/>
			</div>
			<div class="form-group mb-4">
				<label for="require_prescription">Require Prescription? *</label>
				<select class="form-control" id="require_prescription" name="require_prescription">
					<?php
					if($products["require_prescription"] == "true"){
						echo '
							<option value="true">Yes</option>
							<option value="false">No</option>
							<option value="">Please select</option>
						';
					}elseif($products["require_prescription"] == "false"){
						echo '
							<option value="false">No</option>
							<option value="true">Yes</option>
							<option value="">Please select</option>
						';
					}else{
						echo '
							<option value="">Please select</option>
							<option value="true">Yes</option>
							<option value="false">No</option>
						';
					}
					?>
					
				</select>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group mb-4">
						<label for="category">Category *</label>        
						<select id="category" name="category" class="form-control" onchange="setSubcategory(this)" >
						</select>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group mb-4">
						<label for="subcategory">Sub Category</label>        
						<select id="subcategory" name="subcategory" class="form-control">
						</select>
					</div>				
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
			<div class="form-group mb-4">
				<label for="price">Price *</label>
				<input class="form-control" type="text" id="originalprice" name="originalprice" onkeyup="updatePricechange(this)" value="<?php echo $products["originalprice"]; ?>"/>
			</div>				
				</div>
				<div class="col-sm-6">
					<div class="form-group mb-4">
						<label for="price"><?php echo $projectname; ?> Price</label>
						<input class="form-control" type="text" id="price" name="price" value="<?php echo $products["price"]; ?>" readonly />
					</div>	
				</div>
			</div>
			<div class="form-group mb-4">
				<label for="category">Product Form</label>        
				<select id="product_form" name="product_form" class="form-control">
					<option value="">Please select</option>
					<option value="Syrup">Syrup</option>
					<option value="Tablet">Tablet</option>
					<option value="Capsule">Capsule</option>
					<option value="Sachets">Sachets</option>
					<option value="Patches">Patches</option>
					<option value="Ointment">Ointment</option>
					<option value="Cream">Cream</option>
					<option value="Drops">Drops</option>
					<option value="Spray">Spray</option>
					<option value="Inhaler">Inhaler</option>
					<option value="Suppository">Suppository</option>
					<option value="Pessary">Pessary</option>
					<option value="Pack">Pack</option>
					<option value="Tube">Tube</option>
					<option value="Bottle">Bottle</option>
				</select>
			</div>
			<div class="form-group mb-4">
				<label for="description">Description *</label>
				<input class="form-control" type="text" id="description" name="description" value="<?php echo $products["description"]; ?>"/>
			</div>

			<div class="form-group mb-4">
				<label for="description mb-4">About</label>
				<input class="form-control" type="text" id="about" name="about" value="<?php echo $products["about"]; ?>"/>
			</div>
			<div class="form-group mb-4">
				<label for="description mb-4">Precautions</label>
				<input class="form-control" type="text" id="precaution" name="precaution" value="<?php echo $products["precaution"]; ?>"/>
			</div>
			<div class="form-group mb-4">
				<label for="description mb-4">Side Effects</label>
				<input class="form-control" type="text" id="sideeffect" name="sideeffect" value="<?php echo $products["sideeffect"]; ?>"/>
			</div>
			<div class="form-group mb-4">
				<label for="description mb-4">Quick Tips</label>
				<input class="form-control" type="text" id="tip" name="tip" value="<?php echo $products["tip"]; ?>"/>
			</div>
			<div class="form-group mb-4">
				<label for="description mb-4">Overview</label>
				<input class="form-control" type="text" id="overview" name="overview" value="<?php echo $products["overview"]; ?>" />
			</div>
			<div class="form-group mb-4">
				<label for="description mb-4">What If You Forget To Take</label>
				<input class="form-control" type="text" id="forgot" name="forgot" value="<?php echo $products["forgot"]; ?>"/>
			</div>
			<div class="form-group mb-4">
				<label for="description mb-4">FAQS</label>
				<input class="form-control" type="text" id="faq" name="faq" value="<?php echo $products["faq"]; ?>"/>
			</div>


			<div class="row mb-4">
				<div class="col-sm-4">
					<div class="form-group mb-4">
						<label for="addonname">Addon Name</label>
						<input class="form-control" type="text" id="addonname" name="addonname" />
					</div>
				</div>
				<div class="col-sm-4">
					<div class="form-group mb-4">
						<label for="addonprice">Addon Price</label>
						<input class="form-control" type="number" step="0.1" id="addonprice" name="addonprice" />
					</div>
				</div>
				<div class="col-sm-4">
					<label>Action</label><br>
					<a href="#!" onclick="addAddon()" class="btn btn-primary">Add Addon</a>
				</div>
				<p>List of addon</p>
				<div class="col-sm-12 row" id="displayaddon">
				</div>
			</div>
			
			<textarea id="addondata" name="addondata" hidden><?php echo $products["addondata"]; ?></textarea>
			<input class="form-control" type="text" id="delivery" name="delivery" value="Prods" hidden />
			<input class="form-control" type="text" id="lat" name="lat"value="<?php echo $usersobject["lat"]; ?>" hidden> <input class="form-control" type="text" id="lng" name="lng" value="<?php echo $usersobject["lng"]; ?>" hidden>
			<div class="form-group">
				<input class="form-control" type="text" id="available" name="available" value="On" hidden />
			</div>
			<div class="form-group mb-4">
				<label for="description mb-4">Width</label>
				<input class="form-control" type="number" id="width" name="width" value="<?php echo $products["width"]; ?>" />
			</div>
			<div class="form-group mb-4">
				<label for="description mb-4">Height</label>
				<input class="form-control" type="number" id="height" name="height" value="<?php echo $products["height"]; ?>"/>
			</div>
			<div class="form-group mb-4">
				<label for="description mb-4">Length</label>
				<input class="form-control" type="number" id="length" name="length" value="<?php echo $products["length"]; ?>"/>
			</div>
			<div class="form-group mb-4">
				<label for="description mb-4">Measurement Unit</label>
				<input class="form-control" type="text" id="unit" name="unit" value="cm" readonly/>
			</div>
			<div class="form-group mb-4">
				<label for="description mb-4">Weight (NO DECIMAL)</label>
				<input class="form-control" type="number" id="weight" name="weight" value="<?php echo $products["weight"]; ?>"/>
			</div>
			<div class="form-group mb-4">
				<label for="description mb-4">Measurement Unit</label>
				<select name="weightunit" id="weightunit" class="form-control">
					<option value="g" selected>Gram</option>
				</select>
			</div>
			<input type="submit" value="Update Product" name="updateproduct" class="btn btn-primary" />
		</form>
			
		</div>
	</div>
</div>
<?php

	$sql = "SELECT * FROM users WHERE id='$owner'";
	$result = $db->query($sql);
	$cat = $result->fetch_assoc();
	$categories = $cat["pharma_categories"];
	$productmargin = 30;
	if($products["addondata"] == ""){
		$products["addondata"] = '[]';
	}
?>
<script>
var postCat = JSON.parse('<?php echo $categories; ?>');

function initiateProductPoster() {
	document.getElementById("product_form").value = '<?php echo $products["product_form"]; ?>';
	var i;
	console.log(postCat);
	var select = document.getElementById('category');
	var option;
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
	document.getElementById("category").value = '<?php echo $products["category"]; ?>';
	setSubcategorysec('<?php echo $products["category"]; ?>');
}
function setSubcategorysec(val) {
	var catname = val;
	document.getElementById('subcategory').innerHTML = "";
	for (let i = 0; i < postCat.length; i++) {
		if (postCat[i].name == catname) {
			var j;
			console.log(postCat[i].sub);
			var subcat = postCat[i].sub;
			var select = document.getElementById('subcategory');
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
	document.getElementById("subcategory").value = '<?php echo $products["subcategory"]; ?>';
}
function setSubcategory(val) {
	var catname = val.value;
	document.getElementById('subcategory').innerHTML = "";
	for (let i = 0; i < postCat.length; i++) {
		if (postCat[i].name == catname) {
			var j;
			console.log(postCat[i].sub);
			var subcat = postCat[i].sub;
			var select = document.getElementById('subcategory');
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

var addonadata = <?php echo $products["addondata"]; ?>;
function renderAddon(){
	console.log(addonadata);
	for (i = 0; i < addonadata.length; i++) {
			document.getElementById("displayaddon").innerHTML += '<div class="col-sm-3">' + addonadata[i].name + '</div><div class="col-sm-3">RM' + addonadata[i].price + '</div><div class="col-sm-6"><a href="#!" onclick="deleteaddon(' + i + ')" class="btn btn-primary btn-sm">Delete</div>';
	}
}

function addAddon() {
	var data = {
		name: "",
		original_price: "",
		price: "",
		checked: false
	};

	data.name = document.getElementById("addonname").value;
	data.price = parseFloat(document.getElementById("addonprice").value).toFixed(2);
	data.original_price = parseFloat(document.getElementById("addonprice").value).toFixed(2);

	if (data.name != "" && data.price != "") {
		var vappymargin = <?php echo $productmargin; ?> * parseFloat(data.original_price) / 100;

		data.price = parseFloat(data.original_price) + parseFloat(vappymargin);

		data.price = data.price.toFixed(2)
		data.checked = false;
		addonadata.push(data);
		console.log(addonadata);
		document.getElementById("addonname").value = "";
		document.getElementById("addonprice").value = "";
		document.getElementById("displayaddon").innerHTML = "";
		console.log(data);
		var i;
		for (i = 0; i < addonadata.length; i++) {
			document.getElementById("displayaddon").innerHTML += '<div class="col-sm-3">' + addonadata[i].name + '</div><div class="col-sm-3">RM' + addonadata[i].price + '</div><div class="col-sm-6"><a href="#" onclick="deleteaddon(' + i + ')" class="btn btn-primary btn-sm">Delete</div>';
		}
		document.getElementById("addondata").value = JSON.stringify(addonadata);
	} else {
		alert("Please fill the form");
	}
}

function deleteaddon(id) {
	document.getElementById("displayaddon").innerHTML = "";
	addonadata.splice(id, 1);
	var i;
	for (i = 0; i < addonadata.length; i++) {
		document.getElementById("displayaddon").innerHTML += '<div class="col-sm-3">' + addonadata[i].name + '</div><div class="col-sm-3">RM' + addonadata[i].price + '</div><div class="col-sm-6"><a href="#" onclick="deleteaddon(' + i + ')" class="btn btn-primary btn-sm">Delete</div>';
	}
	document.getElementById("addondata").value = JSON.stringify(addonadata);
}

function updatePricechange(element) {
	var initialPrice = parseFloat(element.value);
	var initialPrice = initialPrice.toFixed(2);
	var initialPrice = parseFloat(initialPrice);
	var margin = <?php echo $productmargin; ?> * initialPrice / 100;
	margin = parseFloat(margin);
	var totalprice = initialPrice + margin;
	if (isNaN(totalprice) == false) {
		document.getElementById("price").value = totalprice.toFixed(2);
	}
}



function processFile(element, target){
	var file1 = element.files[0];
	var reader = new FileReader();
	reader.onloadend = function() {
		var checkfiletype = reader.result;
		var checkfiletype = reader.result;			
		if(checkfiletype.includes("image") == true){			
			document.getElementById(target).value = reader.result;
		}else if(checkfiletype.includes("application/pdf") == true){
			document.getElementById(target).value = reader.result;
		}else{
			alert("File type not allowed");
		}
	}
	reader.readAsDataURL(file1);
}
document.addEventListener("DOMContentLoaded", function(event) { 
	initiateProductPoster();
	renderAddon();
});
</script>