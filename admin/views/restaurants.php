<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Restaurants</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Restaurants</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
										<th>No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                        <th>Restaurant Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $sql = "SELECT * FROM users WHERE type=1 ORDER by id DESC";
                                        $result = $db->query($sql);
                                        
                                        if ($result->num_rows > 0) {
                                          // output data of each row
										  $ppid = 1;
                                          while($row = $result->fetch_assoc()) {
                                        	if($row["type"] == "0"){
                                        		$type="Customer";
                                        	}elseif($row["type"] == "1"){
                                        		$type="Restaurant Owner";
                                        	}elseif($row["type"] == "2"){
                                        		$type="Rider";
                                        	}elseif($row["type"] == "4"){
                                        		$type="Grocery Owner";
                                        	}
                                        	echo '
                                                          <tr>
															 <td>'. $ppid.'
                                                            </td>
                                                            <td>'. $row["firstname"].' '. $row["lastname"].'</td>
                                                            <td>'. $row["email"].'
                                                            </td>
                                                            <td>'. $row["phonenumber"].'</td>
                                                            <td> '. $row["vendor_name"].'</td>
                                                            <td><a href="'.$domain.'/establishment-manager/'.$row["id"].'/">Open Manager</a></td>
                                                          </tr>
                                        ';	
										$ppid++;
                                          }
                                        } else {
                                          echo "0 results";
                                        }
                                        		
                                        ?>	  
                                </tbody>
                                <tfoot>
                                     <tr>
										<th>No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                        <th>Restaurant Name</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<div class="modal fade" id="modal-xl">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <p class="modal-title">
User Management
                </p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
				<ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link" id="one-tab" data-toggle="tab" href="#view" role="tab" aria-controls="One" aria-selected="true">View</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="two-tab" data-toggle="tab" href="#update" role="tab" aria-controls="Two" aria-selected="false">Update</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="three-tab" data-toggle="tab" href="#delete" role="tab" aria-controls="Three" aria-selected="false">Delete</a>
                    </li>
					<li class="nav-item">
                        <a class="nav-link" id="four-tab" data-toggle="tab" href="#postmenu" role="tab" aria-controls="Three" aria-selected="false">Post Menu</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active p-3" id="view" role="tabpanel" aria-labelledby="one-tab">
                    </div>
                    <div class="tab-pane fade p-3" id="update" role="tabpanel" aria-labelledby="two-tab">
                    </div>
                    <div class="tab-pane fade p-3" id="delete" role="tabpanel" aria-labelledby="three-tab">
                    </div>
					<div class="tab-pane fade p-4" id="postmenu" role="tabpanel" aria-labelledby="four-tab">
					          
     

        <div class="container bottom-pad">
			<p class="strong">Product Picture</p>
			<div class="row picselectrow">
				<div class="col s6 img-col"> 
					<label id="labels" for="productpic1" style="">
						<img class="" id="postproductplaceholder" src="img/product-placeholder.jpg" height="100%" width="100%">
					</label>
					<input style="width: 0.1px; height: 0.1px;opacity: 0;overflow: hidden; position: absolute; z-index: -1;" type="file" id="productpic1" class="" onchange="uploadImage1(this)" class="inputizer" />
				</div>
				<div class="col s6 img-col"> 
					<label id="labels" for="productpic2" style="">
						<img class="" id="postproductplaceholder2" src="img/product-placeholder.jpg" height="100%" width="100%">
					</label>
					<input style="width: 0.1px; height: 0.1px;opacity: 0;overflow: hidden; position: absolute; z-index: -1;" type="file" id="productpic2" class="" onchange="uploadImage2(this)" class="inputizer" />
				</div>
				<div class="col s6 img-col"> 
					<label id="labels" for="productpic3" style="">
						<img class="" id="postproductplaceholder3" src="img/product-placeholder.jpg" height="100%" width="100%">
					</label>
					<input style="width: 0.1px; height: 0.1px;opacity: 0;overflow: hidden; position: absolute; z-index: -1;" type="file" id="productpic3" class="" onchange="uploadImage3(this)" class="inputizer" />
				</div>
				<div class="col s6 img-col"> 
					<label id="labels" for="productpic4" style="">
						<img class="" id="postproductplaceholder4" src="img/product-placeholder.jpg" height="100%" width="100%">
					</label>
						<input style="width: 0.1px; height: 0.1px;opacity: 0;overflow: hidden; position: absolute; z-index: -1;" type="file" id="productpic4" class="" onchange="uploadImage4(this)" class="inputizer" />
				</div>
			</div>
			


			
            <p class="strong">Product information</p>
            <form id="inserttoproducts" method="POST" />
            <div class="pages">
                <select id="delivery">
                    <option value="Food" selected>Food</option>
                    <option value="Buah">Fruits</option>
                    <option value="Raw">Raw Material</option>
                </select>
                <label>Category</label>
            </div>
            <div class="form-group">
                <label for="name">Product Name</label>
                <input type="text" id="name" name="name"  class="form-control" >
            </div>

            <div class="form-group">
				<label for="description">Description</label>
                <textarea id="description" name="description"  class="form-control"  placeholder="Please write down description of your product"></textarea>
            </div>
			<div class="form-group">
                <label for="price"><span id="post_product_price">Price</span></label>
                <input type="number" id="price" name="price" step=".01" onkeyUp="updateSalePrice(this)"  class="form-control">
            </div>
			<p>Your Price: RM <span id="totalclientprice"></span> <span class="small right"></span></p>
			<p>Vappy Price: RM <span id="vappymarkup"></span></p>
			<p>Total Price: RM <span id="totalpricetosell"></span> <span class="small right"></span></p>
			<p class="font-weight-bold">Addon Manager</p>
			<div class="row">
				<div class="col">
					<div class="form-group">
					<label>Addon Name</label>
					<input type="text" id="addonname" name="addonname" placeholder="Add on name" class="form-control">
					</div>
				</div>
				<div class="col">
				<div class="form-group">
					<label>Addon Price</label> 
					<input type="number" id="addonprice" name="addonprice" step=".01" placeholder="0.00" class="form-control">
					</div>
				</div>
				<div class="col s12">
				<a class="btn btn-primary green" onclick="addAddon()">Add on</a>
				</div>
				
			</div>
			<div class="col s12">
					<p class="font-weight-bold">Addon Item</p>
				</div>
			
			<div class="row" id="displayaddon">
				
			</div>
			<input type="text" id="addondata" style="display: none">
            
            <div class="form-group pages" style="display: none">
                <label for="name">Stock</label>
                <input type="number" id="stock" name="stock" value="10000000">
            </div>

            <div class="form-group">
                <input type="text" id="picture" name="picture" hidden>
                <input type="text" id="picture_two" name="picture_two" hidden>
                <input type="text" id="picture_three" name="picture_three" hidden>
                <input type="text" id="picture_four" name="picture_four" hidden>
            </div>
            <button class="btn green white-text btn-block" name="submitproducts" id="submitproducts" type="submit">SUBMIT</button>
            </form>
					</div></div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script>
var addonadata = [];
function updateSalePrice(elements) { 
    var initialPrice = parseFloat(elements.value);
	var initialPrice = initialPrice.toFixed(2);
	var initialPrice = parseFloat(initialPrice);
	var margin = 8 * initialPrice / 100;
	margin = parseFloat(margin);
	var totalprice = initialPrice + margin;
	if(isNaN(totalprice)== false){
		 document.getElementById("totalpricetosell").innerHTML = totalprice.toFixed(2);
		 document.getElementById("vappymarkup").innerHTML = margin.toFixed(2);
		 document.getElementById("totalclientprice").innerHTML = initialPrice.toFixed(2);
	}
}
function addAddon() {
	var data = {
		name: "",
		price: ""
	};
	data.name = document.getElementById("addonname").value;
	data.price = parseFloat(document.getElementById("addonprice").value).toFixed(2);
	data.checked = false;
	addonadata.push(data);
	console.log(addonadata);
	document.getElementById("addonname").value = "";
	document.getElementById("addonprice").value = "";
	document.getElementById("displayaddon").innerHTML = "";
	var i;
	for (i = 0; i < addonadata.length; i++) {
		document.getElementById("displayaddon").innerHTML += '<div class="col-sm">' + addonadata[i].name + '</div><div class="col-sm">' + addonadata[i].price + '</div>';
	}
	document.getElementById("addondata").value = JSON.stringify(addonadata);
}
</script>
	<script type="text/javascript" src="js/productmanagement.js"></script>
<script>
var serverUrl = 'https://vappy.my/api/index.php';
var apiVersion = 1;
var authUser = {"login_token":""};
authUser.login_token = '<?php echo $authuser["login_token"]; ?>';
function viewThisusers(id){
    var dataTopost = "api=1&auth_token=" + authUser.login_token + "&viewThisusers="+id;
    var users = new XMLHttpRequest();
    users.open("POST", serverUrl, true);
    users.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    users.onload = function() {
        if (users.status == 200) {
            var json = users.responseText;
            var response = JSON.parse(json);
			if(response.profile_img != "img/default_profile_picture.jpg"){
				var imgviewer = '<p><span class="font-weight-bold">Profile Image:</span></p><img src="'+response.profile_img+'" width="200px">';
			}else{
				var imgviewer ='<p><span class="font-weight-bold">Profile Image:</span> Not set</p>';
			}
			
			if(response.type == "0"){
				var usertype = "Customer";
			}else if(response.type == "1"){
				var usertype = "Restaurant owner / Manager";
			}else if(response.type == "2"){
				var usertype = "Rider";
			}else if(response.type == "4"){
				var usertype = "Grocery owner / Manager";
			}else if(response.type == "3"){
				var usertype = "Admin";
			}
			document.getElementById("view").innerHTML = '<p>Viewing user information</p>'+imgviewer+'<p><span class="font-weight-bold">Name:</span> '+response.firstname+' '+response.lastname+'</p><p><span class="font-weight-bold">Email:</span> '+response.email+'</p><p><span class="font-weight-bold">Phone number:</span> '+response.phonenumber+'</p>';
			document.getElementById("delete").innerHTML = '<p>Are you sure about deleting this account? This action is ireverseable</p><button class="btn btn-primary" onclick="deleteAccount('+response.id+')">Yes</button>';
			//document.getElementById("view").innerHTML = '<img src="'+response.profile_img+'"><p>'+response.email+'</p><p>'+response.firstname+'</p><p>'+response.lastname+'</p><p>'+response.profile_img+'</p><p>'+response.hash+'</p><p>'+response.phonenumber+'</p><p>'+response.type+'</p><p>'+response.login_token+'</p><p>'+response.visitors+'</p><p>'+response.vendor_name+'</p><p>'+response.vendor_address+'</p><p>'+response.vendor_open_time+'</p><p>'+response.vendor_close_time+'</p><p>'+response.vendor_type+'</p><p>'+response.lat+'</p><p>'+response.lng+'</p><p>'+response.availability+'</p><p>'+response.wallet+'</p><p>'+response.bank_name+'</p><p>'+response.bank_account_number+'</p><p>'+response.card_id+'</p><p>'+response.rider_type+'</p><p>'+response.rider_credit+'</p>';
           
        } else if (users.status == 404) {
            alert("Fail to connect to our server");
        } else {
            alert("Fail to connect to our server");
        }
    }
    users.send(dataTopost);
}

</script>