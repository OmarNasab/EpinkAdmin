<?php
if(isset($_POST["submitupdateecare_services"]) &&  $_POST["csrf"] == $_SESSION["csrftoken"]){
	$id = cleanInput($_POST["editid"]);
	$owner = $authUser["id"];
	$category = cleanInput($_POST["editcategory"]);
	$name = cleanInput($_POST["editname"]);
	$description = cleanInput($_POST["editdescription"]);
	$forusertype = cleanInput($_POST["editforusertype"]);
	$icon = uploadFile(cleanInput($_POST["editicon"]));
	$price = cleanInput($_POST["editprice"]);
	$sql = "UPDATE ecare_services SET category='$category', name='$name', description='$description', forusertype='$forusertype', icon='$icon', price='$price' WHERE  id='$id' ";

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
                    <h1>Manage Sub Category</h1>
                </div>
                <div class="col-sm-6"> 
               
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
			<div class="row">
				<div class="col-6">
					<p>Available Category</p>
					<div class="form-group">
						<input type="text" class="form-control" id="toAdd">
						
					</div>
						<button class="btn btn-primary" onclick="addCategory()">Add</button>
				</div>
				<div class="col-6">
					<p>Available Category</p>
					<div id="listofcategory"></div>

				</div>
			</div>
		

		</div>
							<?php
	$sql = "SELECT * FROM settings WHERE setting_item='ecaresubcategory'";
	$result = $db->query($sql);
	$ecare = $result->fetch_assoc();
	$ecaremain = $ecare["setting_value"];
	
?>
    </section>
    <!-- /.content -->
	</div>


<script>
				<?php
				$ecaremain = str_replace("'", "", $ecaremain);
				
				?>
				var serverUrl = 'https://epink.health/api/index.php';
                var listofcategories;
                var curentarray = JSON.parse('<?php echo $ecaremain; ?>');
                function initCategorylist(){
                	document.getElementById("listofcategory").innerHTML  = "";         
                	listofcategories = curentarray;            
                	var i;
                	for (i = 0; i < listofcategories.length; i++) {
                	  document.getElementById("listofcategory").innerHTML += '<li class="list-group-item">'+listofcategories[i].name+' <span class="float-right"><a href="#!" onclick="removeCategory('+i+', \''+listofcategories[i].name+'\')" class="pull-right"><i class="fas fa-times"></i></a</span></li>';
                	}
                } 
				function addCategory(){
                	console.log(curentarray);
                	let arraytoAdd = document.getElementById("toAdd").value;
					arraytoAdd = arraytoAdd.replace("&", "and");
					arraytoAdd = arraytoAdd.replace("'", "");
					arraytoAdd = arraytoAdd.replace('"', "");
					if(checkExist(arraytoAdd) == false){
						let toadd ={"name" : arraytoAdd};
						curentarray.push(toadd);
						console.log(curentarray);
						initCategorylist();
						document.getElementById("toAdd").value = "";
						updateCarecategory();
					}else{
						alert("The category already exist");
					}
					
                }
                function removeCategory(id, name){
					
                	listofcategories.splice(id, 1);
					curentarray = listofcategories;
					if(listofcategories.length >= 1){
						initCategorylist();
						updateCarecategory();
					}else{
						alert("Fail to remove. You must have atleast 1 category.");
					}
                	
                }      

				function updateCarecategory(){
						var settingValue = JSON.stringify(curentarray);
					
						var dataTopost = 'api=1&auth_token='+authUser.login_token+"&subadminupdatecarecategory="+settingValue;
                		var xhr = new XMLHttpRequest();
                		xhr.open("POST", serverUrl, true);
                		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                		xhr.onload = function() {
                			if (xhr.status == 200) {
								
                				var json = xhr.responseText;
                				var response = JSON.parse(json);
                				if(response.status == "fail"){
                					alert(response.message);
                					location.reload();
                				}else{
                					alert(response.message);
                					location.reload();
                				}
                			} else if (xhr.status == 404) {
                				alert("Fail to connect to our server");
                			} else {
                				alert("Fail to connect to our server");
                			}
                		}
                		xhr.send(dataTopost); 
				}
				
				function checkExist(name){
					var extist = 0;
					for (i = 0; i < listofcategories.length; i++){
							var currentCat = listofcategories[i].name;
							if(name == currentCat){
								extist++;
							}
					}
					if(extist == 0){
						return false;
					}else{
						return true;
					}
				}
                function updateCategoryData(ops, nameavailable){
                		console.log(curentarray);
                		var dataTopost = 'api=1&auth_token='+authUser.login_token+"&adminupdatesubcarecategory="+curentarray;
                		var xhr = new XMLHttpRequest();
                		xhr.open("POST", serverUrl, true);
                		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                		xhr.onload = function() {
                			if (xhr.status == 200) {
								
                				var json = xhr.responseText;
                				var response = JSON.parse(json);
                				if(response.status == "fail"){
                					alert(response.message);
                					location.reload();
                				}else{
                					alert(response.message);
                					location.reload();
                				}
                			} else if (xhr.status == 404) {
                				alert("Fail to connect to our server");
                			} else {
                				alert("Fail to connect to our server");
                			}
                		}
                		xhr.send(dataTopost);
                }

				initCategorylist();

</script>