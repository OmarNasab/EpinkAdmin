<?php
$owner = cleanInput($page_action_identifier);
if (isset($_POST["uploadmenu"])) {
    if (isset($_FILES["menuToUpload"])) {
        $target_file = $target_dir . basename($_FILES["menuToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["menuToUpload"]["tmp_name"]);
        if ($check !== false) {
            $res = "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            $res = "File is not an image.";
            $uploadOk = 0;
        }
        // Check if file already exists
        if (file_exists($target_file)) {
            $res = "Sorry, file already exists.";
            $uploadOk = 0;
        }
        // Check file size
        if ($_FILES["menuToUpload"]["size"] > 500000) {
            $res = "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $res = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        } else {
            $filenameo = md5(rand(1000000, 1000000000) . uniqid() . rand(1999, 5999)) . '.' . $imageFileType;
            $newfilename = $target_dir . $filenameo;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $res = "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
            
        } else {
            if (move_uploaded_file($_FILES["menuToUpload"]["tmp_name"], $newfilename)) {
                $res = "The product has been uploaded";
                $name = cleanInput($_POST["name"]);
                $description = cleanInput($_POST["description"]);
                $addondata = cleanInput($_POST["addondata"]);
                $originalprice = cleanInput($_POST["originalprice"]);
                $price = cleanInput($_POST["price"]);
                $delivery = cleanInput($_POST["delivery"]);
                $picture = "https://epink.health/api/assets/" . $filenameo;
                $lat = cleanInput($_POST["lat"]);
                $lng = cleanInput($_POST["lng"]);
                $stock = cleanInput($_POST["stock"]);
                $available = cleanInput($_POST["available"]);
                $selectcategory = cleanInput($_POST["selectcategory"]);
                $faq = cleanInput($_POST["faq"]);
                $forgot = cleanInput($_POST["forgot"]);
                $overview = cleanInput($_POST["overview"]);
                $tip = cleanInput($_POST["tip"]);
                $sideeffect = cleanInput($_POST["sideeffect"]);
                $precaution = cleanInput($_POST["precaution"]);
                $about = cleanInput($_POST["about"]);
                $require_prescription = cleanInput($_POST["require_prescription"]);
                if ($owner != "" && $require_prescription != "") {
                    $productssql = "INSERT INTO products (owner, name, description, addondata, originalprice, price, delivery, picture, lat, lng, stock, available, category, faq, forgot, overview, tip, sideeffect, precaution, about, require_prescription)
				VALUES ('$owner', '$name', '$description', '$addondata', '$originalprice', '$price', '$delivery', '$picture', '$lat', '$lng', '$stock', '$available', '$selectcategory', '$faq', '$forgot', '$overview', '$tip', '$sideeffect', '$precaution', '$about', '$require_prescription')";
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
                    $row["message"] = "Please fill all the required field *";
                    $data = $row;
                    $res = "Please fill all the required field *";
                }
            } else {
                $res = "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        $res = 'Please select an image';
        
    }
    $row["card"] = "green";
    $row["status"] = "Successfull";
    $row["message"] = $res;
    $data = $row;
}
?>
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
					<li class="breadcrumb-item active"><a href="<?php echo $domain; ?>/pharmacists/">Back</a></li>
				</ol>
			</div>
		</div>
	</div>
	<!-- /.container-fluid -->
	<!-- Main content -->
	<div class="container-fluid" id="postmenu">
		<?php
                if (isset($res)) {
					echo '<div class="card">
							<div class="card-body">
								' . $res . '
							</div>
						</div>
					';
                }
                ?>

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
			$("#sub-category").empty();
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
</script>