<header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
	<div class="container-xl px-4">
		<div class="page-header-content">
			<div class="row align-items-center justify-content-between pt-3">
				<div class="col-auto mb-3">
					<h1 class="page-header-title">
						<div class="page-header-icon"><i data-feather="box"></i></div>
						Products Manager
					</h1>
				</div>
				<div class="col-12 col-xl-auto mb-3">  
					<a class="btn btn-sm btn-light text-primary" href="<?php echo $domain; ?>/pharmacy-panel/products/create/">Post</a>    
                </div>
			</div>
		</div>
	</div>
</header>
<div class="container-xl px-4">
	<div class="card mb-4">
		<div class="card-header text-black">List of products</div>
			<div class="card-body">
                    <table id="myTable" class="table table-responsive">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Picture</th>
                                <th>Name </th>
                                <th>Stock</th>
                                <th>Category</th>
                                <th>Expiry Date</th>
                                                           
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
								$owner = cleanInput($authuser["id"]);
                                $productssql    = "SELECT * FROM products WHERE owner='$owner'";
                                $productsresult = $db->query($productssql);
                                
                                if ($productsresult->num_rows > 0) {
                                    $ppid = 1;
                                    while ($productsobject = $productsresult->fetch_assoc()) {
                                		
                                        echo '<tr>
                                                <td>' .$ppid. '</td>
                                                <td> <img src="' . $productsobject["picture"] . '" class="img-fluid" width="50px"></td>
                                                <td>' . $productsobject["name"] . '</td>
                                                 <td>' . $productsobject["stock"] . '</td> <td>' . $productsobject["category"] . '</td> <td>' . $productsobject["expiry_date"] . '</td>';
											

if($productsobject["available"] == "On"){
	$swith = '<a href="#!" class="mx-2" onclick="switchOff(' . $productsobject["id"] . ')"><i data-feather="toggle-right"></i></a> ';
}else{
	$swith = '<a href="#!" class="mx-2 text-dark" onclick="switchOn(' . $productsobject["id"] . ')"><i data-feather="toggle-left"></i></a> ';
}											
                                				echo 	'
                                							
                                                            <td class="text-xs">Original Price: RM' . $productsobject["originalprice"] . ' <br>ePink Price RM' . $productsobject["price"] . '</td>
                                                            <td> 
															'.$swith.'
															<a href="#!" class="mx-2" onclick="setStockid(' . $productsobject["id"] . ', ' . $productsobject["stock"] . ')" data-bs-toggle="modal" data-bs-target="#exampleModal"><i data-feather="package"></i></a>
															<a href="'.$domain.'/pharmacy-panel/products/view/'.$productsobject["id"].'/" class="mx-2"><i data-feather="settings"></i></a> 
															<a href="'.$domain.'/pharmacy-panel/products/delete/'.$productsobject["id"].'/" ><i data-feather="trash"></i></a> </td>
                                                        </tr>';
                                							$ppid++;
                                        
										}
                                    
                                } else {
                                    
                                }
                                ?>
                        </tbody>
                    </table>
				</div>
				</div>
				</div>
				<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Stock</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="text" class="form-control" id="stockcount">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="updateStock()" data-bs-dismiss="modal">Save changes</button>
      </div>
    </div>
  </div>
</div>
<script>
var stockid;
function setStockid(id, total){
	stockid = id;
	document.getElementById("stockcount").value = total;
}
function updateStock(id){
	var newstockcount = document.getElementById("stockcount").value;
	var dataTopost = "api=1&auth_token=" + authUser.login_token + "&setproductstock="+stockid+"&newstockcount="+newstockcount;
    var products = new XMLHttpRequest();
    products.open("POST", serverUrl, true);
    products.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    products.onload = function() {
        if (products.status == 200) {
            var json = products.responseText;
            var response = JSON.parse(json);
            alert(response.message);
			location.reload();
        } else if (products.status == 404) {
            alert("Fail to connect to our server");
        } else {
            alert("Fail to connect to our server");
        }
    }
    products.send(dataTopost);
}
function switchOn(id){
	var dataTopost = "api=1&auth_token=" + authUser.login_token + "&productavailability="+id+"&editavailable=On";
    var products = new XMLHttpRequest();
    products.open("POST", serverUrl, true);
    products.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    products.onload = function() {
        if (products.status == 200) {
            var json = products.responseText;
            var response = JSON.parse(json);
              alert(response.message);
			location.reload();
        } else if (products.status == 404) {
            alert("Fail to connect to our server");
        } else {
            alert("Fail to connect to our server");
        }
    }
    products.send(dataTopost);
}
function switchOff(id){
	var dataTopost = "api=1&auth_token=" + authUser.login_token + "&productavailability="+id+"&editavailable=Off";
    var products = new XMLHttpRequest();
    products.open("POST", serverUrl, true);
    products.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    products.onload = function() {
        if (products.status == 200) {
            var json = products.responseText;
            var response = JSON.parse(json);
            alert(response.message);
			location.reload();
        } else if (products.status == 404) {
            alert("Fail to connect to our server");
        } else {
            alert("Fail to connect to our server");
        }
    }
    products.send(dataTopost);
}
</script>
<script>
$(document).ready( function () {
    $('#myTable').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
</script>