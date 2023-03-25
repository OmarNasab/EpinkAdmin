<?php
$owner = cleanInput($authuser["id"]);
function cleanInputProds($input){
	global $db;
	$data = strip_tags($input);
	$data = $db->real_escape_string($data);
	$data = str_replace("&", "and", $data);
	$data = str_replace("'", "", $data);
	return $data;
}
if (isset($_POST["uploadmenu"])) {
				$owner = $authuser["id"];
                $res = "The product has been uploaded";
				$width = cleanInput($_POST["width"]);
				$height = cleanInput($_POST["height"]);
				$length = cleanInput($_POST["length"]);
				$unit = cleanInput($_POST["unit"]);
				$weight = cleanInput($_POST["weight"]);
				$weightunit = cleanInput($_POST["weightunit"]);
                $name = cleanInputProds($_POST["name"]);
                $description = cleanInputProds($_POST["description"]);
                $addondata = cleanInputProds($_POST["addondata"]);
                $originalprice = cleanInputProds($_POST["originalprice"]);
                $price = cleanInputProds($_POST["price"]);
                $delivery = cleanInputProds($_POST["delivery"]);
				$picture = processFile($_POST["productpicture"]);
                $lat = cleanInputProds($_POST["lat"]);
                $expiry_date = cleanInputProds($_POST["expiry_date"]);
                $lng = cleanInputProds($_POST["lng"]);
                $expirydate = cleanInputProds($_POST["expirydate"]);
                $stock = cleanInputProds($_POST["stock"]);
                $available = cleanInputProds($_POST["available"]);
                $selectcategory = cleanInputProds($_POST["category"]);
                $subcategory = cleanInputProds($_POST["subcategory"]);
                $productform = cleanInputProds($_POST["productform"]);
                $faq = cleanInputProds($_POST["faq"]);
                $forgot = cleanInputProds($_POST["forgot"]);
                $overview = cleanInputProds($_POST["overview"]);
                $tip = cleanInputProds($_POST["tip"]);
                $sideeffect = cleanInputProds($_POST["sideeffect"]);
                $precaution = cleanInputProds($_POST["precaution"]);
                $about = cleanInputProds($_POST["about"]);
                $require_prescription = cleanInputProds($_POST["require_prescription"]);
                if ($owner != "" && $require_prescription != "" && $name != "" && $price != "") {
                    $productssql = "INSERT INTO products (owner, name, description, addondata, originalprice, price, delivery, picture, lat, lng, stock, available, category, subcategory, faq, forgot, overview, tip, sideeffect, precaution, about, require_prescription, product_form, expiry_date, width, height, length, unit, weight, weightunit)
					VALUES ('$owner', '$name', '$description', '$addondata', '$originalprice', '$price', '$delivery', '$picture', '$lat', '$lng', '$stock', '$available', '$selectcategory', '$subcategory', '$faq', '$forgot', '$overview', '$tip', '$sideeffect', '$precaution', '$about', '$require_prescription', '$productform', '$expiry_date', '$width', '$height', '$length', '$unit', '$weight', '$weightunit')";
                    if ($db->query($productssql) === TRUE) {
                        $row["card"] = "green";
                        $row["status"] = "Successful";
                        $row["message"] = "New record successfully created";
                        $data = $row;
                    } else {
                        $row["card"] = "red";
                        $row["status"] = "Fail";
                        $row["message"] = "Error: " . $productssql . "<br>" . $db->error;
                        $res = "Error: " . $productssql . "<br>" . $db->error;
                        $data = $row;
                    }
                } else {
                    $row["card"] = "red";
                    $row["status"] = "Fail";
                    $row["message"] = "Please fill all the required field *".$require_prescription;
                    $data = $row;
                    $res = "Please fill all the required field *";
                }
            
}
?>
<header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
	<div class="container-xl px-4">
		<div class="page-header-content">
			<div class="row align-items-center justify-content-between pt-3">
				<div class="col-auto mb-3">
					<h1 class="page-header-title">
						<div class="page-header-icon"><i data-feather="box"></i></div>
						Post Product
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
				<label>Product Image * <?php echo $owner; ?></label><br>
				<img width="200px" src=""><br>
				<input type="file" name="menuToUpload" id="menuToUpload" class="form-control" onchange="processFile(this, 'productpicture')"/> 
				<input type="text" name="productpicture" id="productpicture" class="form-control" hidden /> 
			</div>
			<div class="form-group mb-4">
				<label for="name">Name *</label>
				<input class="form-control" type="text" id="name" name="name" />
			</div>
			<div class="form-group mb-4">
				<label for="name">Expiry Date *</label>
				<input class="form-control" type="date" id="expiry_date" name="expiry_date" />
			</div>
			<div class="form-group mb-4">
				<label for="name">Stock *</label>
				<input class="form-control" type="number" id="stock" name="stock" />
			</div>
			<div class="form-group mb-4">
				<label for="description">Require Prescription? *</label>
				<select class="form-control" id="require_prescription" name="require_prescription">
					<option value="">Please select</option>
					<option value="true">Yes</option>
					<option value="false">No</option>
				</select>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group mb-4">
						<label for="category">Category *</label>        
						<select id="category" name="category" class="form-control" onchange="setSubcategory(this)">
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
				<label for="originalprice">Price *</label>
				<input class="form-control" type="text" id="originalprice" name="originalprice" onkeyup="updatePricechange(this)"/>
			</div>				
				</div>
				<div class="col-sm-6">
					<div class="form-group mb-4">
						<label for="price"><?php echo $projectname; ?> Price</label>
						<input class="form-control" type="text" id="price" name="price" />
					</div>	
				</div>
			</div>
			<div class="form-group mb-4">
				<label for="category">Product Form</label>        
				<select id="productform" name="productform" class="form-control">
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
				<input class="form-control" type="text" id="description" name="description" />
			</div>

			<div class="form-group mb-4">
				<label for="description mb-4">About</label>
				<input class="form-control" type="text" id="about" name="about" />
			</div>
			<div class="form-group mb-4">
				<label for="description mb-4">Precautions</label>
				<input class="form-control" type="text" id="precaution" name="precaution" />
			</div>
			<div class="form-group mb-4">
				<label for="description mb-4">Side Effects</label>
				<input class="form-control" type="text" id="sideeffect" name="sideeffect" />
			</div>
			<div class="form-group mb-4">
				<label for="description mb-4">Quick Tips</label>
				<input class="form-control" type="text" id="tip" name="tip" />
			</div>
			<div class="form-group mb-4">
				<label for="description mb-4">Overview</label>
				<input class="form-control" type="text" id="overview" name="overview" />
			</div>
			<div class="form-group mb-4">
				<label for="description mb-4">What If You Forget To Take</label>
				<input class="form-control" type="text" id="forgot" name="forgot" />
			</div>
			<div class="form-group mb-4">
				<label for="description mb-4">FAQS</label>
				<input class="form-control" type="text" id="faq" name="faq" />
			</div>
			<div class="row mb-4">
				<div class="col-sm-4">
					<div class="form-group mb-4">
						<label for="addondata">Addon Name</label>
						<input class="form-control" type="text" id="addonname" name="addonname" />
					</div>
				</div>
				<div class="col-sm-4">
					<div class="form-group mb-4">
						<label for="addondata">Addon Price</label>
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
			<input class="form-control" type="text" id="addondata" name="addondata"  value="[]" hidden/>
			<input class="form-control" type="text" id="delivery" name="delivery" value="Food" hidden />
			<input class="form-control" type="text" id="lat" name="lat"value="<?php echo $usersobject["lat"]; ?>" hidden> <input class="form-control" type="text" id="lng" name="lng" value="<?php echo $usersobject["lng"]; ?>" hidden>
			<div class="form-group">
				<input class="form-control" type="text" id="available" name="available" value="On" hidden />
			</div>
			<div class="form-group mb-4">
				<label for="description mb-4">Width</label>
				<input class="form-control" type="number" id="width" name="width" />
			</div>
			<div class="form-group mb-4">
				<label for="description mb-4">Height</label>
				<input class="form-control" type="number" id="height" name="height" />
			</div>
			<div class="form-group mb-4">
				<label for="description mb-4">Length</label>
				<input class="form-control" type="number" id="length" name="length" />
			</div>
			<div class="form-group mb-4">
				<label for="description mb-4">Measurement Unit</label>
				<input class="form-control" type="text" id="unit" name="unit" value="cm" readonly/>
			</div>
			<div class="form-group mb-4">
				<label for="description mb-4">Weight (NO DECIMAL)</label>
				<input class="form-control" type="number" id="weight" name="weight"/>
			</div>
			<div class="form-group mb-4">
				<label for="description mb-4">Measurement Unit</label>
				<select name="weightunit" id="weightunit">
					
					<option value="g" selected>Gram</option>
					
				</select>
			</div>
			<input type="submit" value="Post Product" name="uploadmenu" class="btn btn-primary" />
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
	?>
<script>
var postCat = JSON.parse('<?php echo $categories; ?>');

function initiateProductPoster() {
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

var addonadata = [];

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

initiateProductPoster();
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
</script>