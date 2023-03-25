<?php

if(isset($_POST["submitupdateproducts"]) &&  $_POST["csrf"] == $_SESSION["csrftoken"]){
$id = cleanInput($_POST["editid"]);
$owner = $authUser["id"];
$owner = cleanInput($_POST["editowner"]);
$name = cleanInput($_POST["editname"]);
$description = cleanInput($_POST["editdescription"]);
$addondata = cleanInput($_POST["editaddondata"]);
$originalprice = cleanInput($_POST["editoriginalprice"]);
$price = cleanInput($_POST["editprice"]);
$delivery = cleanInput($_POST["editdelivery"]);
$picture = cleanInput($_POST["editpicture"]);
$picture_two = cleanInput($_POST["editpicture_two"]);
$picture_three = cleanInput($_POST["editpicture_three"]);
$picture_four = cleanInput($_POST["editpicture_four"]);
$lat = cleanInput($_POST["editlat"]);
$lng = cleanInput($_POST["editlng"]);
$stock = cleanInput($_POST["editstock"]);
$available = cleanInput($_POST["editavailable"]);
$category = cleanInput($_POST["editcategory"]);
$approved = cleanInput($_POST["editapproved"]);
	$sql = "UPDATE products SET owner='$owner', name='$name', description='$description', addondata='$addondata', originalprice='$originalprice', price='$price', delivery='$delivery', picture='$picture', picture_two='$picture_two', picture_three='$picture_three', picture_four='$picture_four', lat='$lat', lng='$lng', stock='$stock', available='$available', category='$category', approved='$approved' WHERE  id='$id' ";

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

$id = cleanInput($page_identifier_action);
$productssql = "SELECT * FROM products WHERE id='$id'";
$productsresult = $db->query($productssql);
if ($productsresult->num_rows > 0){
	$row = $productsresult->fetch_assoc();
	$productsobject = $row;
} else {
	$row["card"] = "red";
	$row["status"] = "Fail";
	$row["message"] = "The record you looking for does not exist <script>window.location.href= ''.$domain.'404';  </script>";
	$data = $row;
}
	$id = cleanInput($page_action_identifier);
	$settingssql = "SELECT * FROM settings WHERE setting_item='productmargin'";
	$settingsresult = $db->query($settingssql);
	if($settingsresult->num_rows > 0){
		$row = $settingsresult->fetch_assoc();
		$settingsdata = $row;
		$productmargin = $row["setting_value"];
	}else{
		$row["card"] = "red";
		$row["status"] = "Fail";
		$row["message"] = "The record you looking for does not exist<script>window.location.href= ''.$domain.'/404';</script>";
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
            <h1>Edit Product</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Delete Product</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <section class="content">
	<?php
	if (isset($data)) {
		echo '<div class="card">
  <div class="card-body">
    ' . $data["message"] . '
  </div>
</div>';
	}else{
	?>
	<form id="editproducts" method="POST" action="<?php echo $page_url; ?>" >
<input type="text" id="csrf" name="csrf" value="<? echo $csrftoken; ?>" hidden>
<input type="text" id="editid" name="editid" value="<? echo $productsobject["id"]; ?>" hidden>
	
<div class="form-group" style="display: none">
	<label for="editowner">owner</label>
	<input type="text" id="editowner" class="form-control" name="editowner" value="<?php echo $productsobject["owner"]; ?>">
</div>

<div class="form-group">
	<label for="editname">Product Name</label>
	<input type="text" id="editname" class="form-control" name="editname" value="<?php echo $productsobject["name"]; ?>">
</div>

<div class="form-group">
	<label for="editdescription">Description</label>
	<input type="text" id="editdescription" class="form-control" name="editdescription" value="<?php echo $productsobject["description"]; ?>">
</div>
<p class="strong font-weight-bold" id="update_menu_addon_item">Addon Item List</p>
<div class="row" id="editdisplayaddon" style="">

</div>
<br><br>
<p class="strong font-weight-bold">Add product addon</p>
<div class="row">
	<div class="col" style="">
		<label id="name_addon_lang_add" class="active">Addon Name</label>
		<br>
		<input type="text" id="editaddonname" name="editaddonname" placeholder="Add on name">
	</div>
	<div class="col">
		<label id="name_addon_lang_price" class="active">Addon Price</label>
			<br>
			<input type="number" id="editaddonprice" name="editaddonprice" step=".01" placeholder="0.00">
	</div>	
</div>
		<br>
				<a class="btn btn-primary amber darken-2" onclick="editaddAddon()" id="lang_add_addon_button">Add on</a>
				<br>
				<p><span id="appmarginnoteupdate">0</span>% <span id="lang_margin_helper">margin will be applied automatically</span></p><br>
			
<script>
var productmargin = <?php echo $productmargin; ?>;
				var viewaddonData = JSON.parse('<?php echo $productsobject["addondata"]; ?>');
				
				var editaddonadata = viewaddonData;
				var i;
				for (i = 0; i < viewaddonData.length; i++) {
					document.getElementById("editdisplayaddon").innerHTML += '<div class="col-4">' + viewaddonData[i].name + '</div><div class="col-4">RM' + viewaddonData[i].price + '</div><div class="col-4"><a class="btn btn-primary green editaddobbutton" onclick="editDeleteAddon('+i+')">Delete</a></div>';
				}
function editaddAddon(){
	var data = {
		name: "",
		original_price: "",
		price: "",
		checked: false
		
	};
	data.name = document.getElementById("editaddonname").value;
	data.price = parseFloat(document.getElementById("editaddonprice").value).toFixed(2);
	data.original_price = parseFloat(document.getElementById("editaddonprice").value).toFixed(2);
	
	data.checked = false;
	if(data.name != "" && data.price != ""){
	console.log(editaddonadata);
	var marginal = productmargin * data.original_price / 100 ;
	var newprice = parseFloat(data.original_price) + parseFloat(marginal);
	data.price = newprice.toFixed(2);
	editaddonadata.push(data);
	document.getElementById("editaddonname").value = "";
	document.getElementById("editaddonprice").value = "";
	document.getElementById("editdisplayaddon").innerHTML = "";
	var i;
	for (i = 0; i < editaddonadata.length; i++) {
		document.getElementById("editdisplayaddon").innerHTML += '<div class="col-4">' + editaddonadata[i].name + '</div><div class="col-4">RM' + editaddonadata[i].price + '</div><div class="col-4"><button class="btn btn-primary green editaddobbutton" onclick="editDeleteAddon('+i+')">DELETE</button></div>';
	}
	document.getElementById("editaddondata").value = JSON.stringify(editaddonadata);
	}else{
		showLoading();
		loadingResponse("Please set add on name and price");
	}
}
function editDeleteAddon(id){
	editaddonadata.splice(id, 1);
	document.getElementById("editdisplayaddon").innerHTML = "";
	var i;
	for (i = 0; i < editaddonadata.length; i++) {
		document.getElementById("editdisplayaddon").innerHTML += '<div class="col-4">' + editaddonadata[i].name + '</div><div class="col-4">RM' + editaddonadata[i].price + '</div><div class="col-4"><a class="btn btn-primary green editaddobbutton" onclick="editDeleteAddon('+i+')"><i class="material-icons">Delete</i></a></div>';
	}
	console.log(editaddonadata);
	document.getElementById("editaddondata").value = JSON.stringify(editaddonadata);
}
</script>			
			
<div class="form-group" style="display: none">
	<label for="editaddondata">addondata</label>
	<input type="text" id="editaddondata" class="form-control" name="editaddondata" value='<?php echo $productsobject["addondata"]; ?>'>
</div>

<div class="form-group">
	<label for="editoriginalprice">Original price</label>
	<input type="number" id="editoriginalprice" class="form-control" name="editoriginalprice" value="<?php echo $productsobject["originalprice"]; ?>" onchange="updatePricechange(this)" step="0.1">
</div>
<script> 

function updatePricechange(element){
	var initialPrice = parseFloat(element.value);
	var initialPrice = initialPrice.toFixed(2);
	var initialPrice = parseFloat(initialPrice);
	var margin = productmargin * initialPrice / 100; 
	margin = parseFloat(margin);
	var totalprice = initialPrice + margin;
	document.getElementById("editprice").value = totalprice.toFixed(2);
	console.log(totalprice);
}
</script>
<div class="form-group">
	<label for="editprice"><?php echo $projectname; ?> price</label>
	<input type="number" id="editprice" class="form-control" name="editprice" value="<?php echo $productsobject["price"]; ?>" step="0.1" readonly>
</div>

<div class="form-group" style="display: none">
	<label for="editdelivery">Delivery</label>
	<input type="text" id="editdelivery" class="form-control" name="editdelivery" value="<?php echo $productsobject["delivery"]; ?>">
</div>

<div class="form-group" style="display: none">
	<label for="editpicture">picture</label>
	<input type="text" id="editpicture" class="form-control" name="editpicture" value="<?php echo $productsobject["picture"]; ?>">
</div>

<div class="form-group" style="display: none">
	<label for="editpicture_two">picture_two</label>
	<input type="text" id="editpicture_two" class="form-control" name="editpicture_two" value="<?php echo $productsobject["picture_two"]; ?>">
</div>

<div class="form-group" style="display: none">
	<label for="editpicture_three">picture_three</label>
	<input type="text" id="editpicture_three" class="form-control" name="editpicture_three" value="<?php echo $productsobject["picture_three"]; ?>">
</div>

<div class="form-group" style="display: none">
	<label for="editpicture_four">picture_four</label>
	<input type="text" id="editpicture_four" class="form-control" name="editpicture_four" value="<?php echo $productsobject["picture_four"]; ?>">
</div>

<div class="form-group" style="display: none">
	<label for="editlat">lat</label>
	<input type="text" id="editlat" class="form-control" name="editlat" value="<?php echo $productsobject["lat"]; ?>">
</div>

<div class="form-group" style="display: none">
	<label for="editlng">lng</label>
	<input type="text" id="editlng" class="form-control" name="editlng" value="<?php echo $productsobject["lng"]; ?>">
</div>

<div class="form-group" style="display: none">
	<label for="editstock">stock</label>
	<input type="text" id="editstock" class="form-control" name="editstock" value="<?php echo $productsobject["stock"]; ?>">
</div>

<div class="form-group" style="display: none">
	<label for="editavailable">available</label>
	<input type="text" id="editavailable" class="form-control" name="editavailable" value="<?php echo $productsobject["available"]; ?>">
</div>
<div class="row" id="editdisplayaddon" style="margin-left: -10px;"></div>
<div class="form-group" >
	<label for="editcategory">category</label>
	<?php
$ownerid = $productsobject["owner"];
$sqlee = "SELECT * FROM users WHERE id='$ownerid'";
$resultee = $db->query($sqlee);

if ($resultee->num_rows > 0) {
  // output data of each row
  while($rowee = $resultee->fetch_assoc()) {
	$usercategory = $rowee["categories"];
  }
} else {
  
}	
	
	?>
	
	
	
	<select type="text" id="edit_product_category" class="form-control" name="editcategory">
	
	</select>
	
	<script>
function initiateEditProductPoster(){
	var currentproductcategory = '<?php echo $productsobject["category"]; ?>'
	var i;
	var postCat = JSON.parse('<?php echo $usercategory; ?>');
	var select = document.getElementById('edit_product_category');
	var option;
	console.log(postCat);
	for (i = 0; i < postCat.length; i++) {
		//document.getElementById("product_category").innerHTML += '<option value="'+postCat[i].name+'">'+postCat[i].name+'sasa</option>';
		option = document.createElement('option');
		option.setAttribute('value', postCat[i].name);
	
		if(postCat[i].name == currentproductcategory){
				option.setAttribute('selected', 'true');
		}
		option.appendChild(document.createTextNode(postCat[i].name));
		select.appendChild(option);
		console.log(option);
	}
}
initiateEditProductPoster();
</script>
</div>

<div class="form-group" style="display: none">
	<label for="editapproved">approved</label>
	<input type="text" id="editapproved" name="editapproved" value="<?php echo $productsobject["approved"]; ?>">
</div>

<button class="btn blue btn-primary white-text" name="submitupdateproducts" id="submitupdateproducts" type="submit">Submit</button>
<br/><br/>
</form>
	</section>
	<?php } ?>
</div>