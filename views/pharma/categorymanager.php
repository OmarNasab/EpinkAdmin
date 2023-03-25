<header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
	<div class="container-xl px-4">
		<div class="page-header-content">
			<div class="row align-items-center justify-content-between pt-3">
				<div class="col-auto mb-3">
					<h1 class="page-header-title">
						<div class="page-header-icon"><i data-feather="user"></i></div>
						Category Manager
					</h1>
				</div>
				<div class="col-12 col-xl-auto mb-3">                                    
                 </div>
			</div>
		</div>
	</div>
</header>
<div class="container-xl px-4">
	<div class="card mb-4">
		<div class="card-header text-black">Category</div>
			<div class="card-body">
				<div id="listofcategory" class="row">
						
				</div>
			</div>
	</div>
	<div class="card mb-4">
		<div class="card-header text-black">Add Category</div>
			<div class="card-body">
				<div class="form-group mb-4">
					<input type="text" class="form-control" id="toAdd">
				</div>
				<button class="btn btn-primary mb-4" onclick="addCategory()">Add</button>
			</div>
	</div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add sub category to <span id="subtoadd"></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
	  <p>Name</p>
      <input type="text" class="form-control" id="subname">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="addTosub()" data-bs-dismiss="modal">Save changes</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="removemaincategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Remove category</h5>
         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
         Are you sure about deleting this category?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="confirmDeleteCategory()" data-bs-dismiss="modal">Save changes</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="deleteSubMobdal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Remove sub category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure about deleting this sub category?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="confirmDeleteSub()">Confirm</button>
      </div>
    </div>
  </div>
</div>
<?php
	$owner = cleanInput($authuser["id"]);
	$sql = "SELECT * FROM users WHERE id='$owner'";
	$result = $db->query($sql);
	$cat = $result->fetch_assoc();
	$categories = $cat["pharma_categories"];
?>
<script>

				
                var listofcategories;
                var curentarray = JSON.parse('<?php echo $categories; ?>');
				var pharmaid = <?php echo $owner; ?>;
				function addTosub(){
					var toadd = document.getElementById("subname").value;
					toadd = toadd.replace("&", "and");
					toadd = toadd.replace("'", "");
					toadd = toadd.replace('"', "");
					let toaddarray ={"name" : toadd};
					if(checkSubExist(toadd) == false){
						var currentsub = curentarray[indextoadd].sub;
						currentsub.push(toaddarray);
						console.log(currentsub);
						
						updateLabcategory();
					}else{
						alert("This sub category already exist");
					}
				}
				function checkSubExist(name){
					var extist = 0;
					var currentsub = curentarray[indextoadd].sub;
					for (i = 0; i < currentsub.length; i++){
							var currentCat = currentsub[i].name;
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
				var maincategorytodelte;
				var subcategorytodelete;
				function removesubCategory(maincatefgoryid, subid){
					maincategorytodelte = maincatefgoryid;
					subcategorytodelete = subid;
					
					
				}
				function confirmRemove(){
					listofcategories.splice(toconfirmid, 1);
					curentarray = listofcategories;
               
					if(listofcategories.length >= 1){
						initCategorylist();
						updateLabcategory();
					}else{
						alert("Fail to remove. You must have atleast 1 category.");
					}
				}
				function confirmDeleteSub(){
					var mainsub = curentarray[maincategorytodelte].sub;
					curentarray[maincategorytodelte].sub.splice(subcategorytodelete, 1);
					updateLabcategory();
					
				}
                function initCategorylist(){
                	document.getElementById("listofcategory").innerHTML  = "";         
                	listofcategories = curentarray;            
                	var i;
                	for (i = 0; i < listofcategories.length; i++) {
					  var subcategory = listofcategories[i].sub;
					  console.log(subcategory);
					  var j;
					  var subto = "";
					  for (j = 0; j < subcategory.length; j++){
						  subto += '<span class="badge bg-secondary">'+subcategory[j].name+'<a href="#!" onclick="removesubCategory('+i+', '+j+')" class="pull-right" data-bs-toggle="modal" data-bs-target="#deleteSubMobdal"> <i class="fas fa-times text-light"></i></a></span> ';
					  }
					  //document.getElementById("listofcategory").innerHTML += '<div class="card"><div class="card-body"></div></div>';
                	  document.getElementById("listofcategory").innerHTML += '<div class="col-sm-6 col-lx-6 mb-3"><div class="card"><div class="card-body">'+listofcategories[i].name+' <span class="float-right"><a href="#!" onclick="removeCategory('+i+', \''+listofcategories[i].name+'\')" class="pull-right" data-bs-toggle="modal" data-bs-target="#removemaincategory"><i class="fas fa-times"></i></a></span><br><a href="#!" onclick="addSubt('+i+')" data-bs-toggle="modal" data-bs-target="#exampleModal" class="text-xs">Add Sub Category</a><br>'+subto+'</div></div></div>';
                	}
                } 
				
				var indextoadd;
				function addSubt(idx){
					indextoadd = idx;
					document.getElementById("subtoadd").innerHTML = curentarray[idx].name;
				}
				function addCategory(){
                	console.log(curentarray);
                	let arraytoAdd = document.getElementById("toAdd").value;
					arraytoAdd = arraytoAdd.replace("&", "and");
					arraytoAdd = arraytoAdd.replace("'", "");
					arraytoAdd = arraytoAdd.replace('"', "");
					if(checkExist(arraytoAdd) == false){
						let toadd ={"name" : arraytoAdd, "sub":[]};
						curentarray.push(toadd);
						console.log(curentarray);
						initCategorylist();
						document.getElementById("toAdd").value = "";
						updateLabcategory();
					}else{
						alert("The category already exist");
					}
                }
				
				var toconfirmid;
				var toconfirmname;
                function removeCategory(id, name){
                	toconfirmid = id;
					toconfirmname = name;
                }
				function confirmDeleteCategory(){
					listofcategories.splice(toconfirmid, 1);
					curentarray = listofcategories;
               
					if(listofcategories.length >= 1){
						initCategorylist();
						updateLabcategory();
					}else{
						alert("Fail to remove. You must have atleast 1 category.");
					}
				}				

				function updateLabcategory(){
						var settingValue = JSON.stringify(curentarray);
					
						var dataTopost = 'api=1&auth_token='+authUser.login_token+"&adminupdatepharmacategory="+settingValue+"&pid="+pharmaid;
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
                		var dataTopost = 'api=1&auth_token='+authUser.login_token+"&subadminupdatelabcategory="+curentarray;
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
