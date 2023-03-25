<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Product Manager</h1>
                </div>
                <div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active"><a href="<?php echo $domain; ?>/pharmacists/products-create/<?php echo $page_action_identifier; ?>/">CREATE PRODUCTS</a></li>
                        <li class="breadcrumb-item active"><a href="<?php echo $domain; ?>/pharmacists/category-manager/<?php echo $page_action_identifier; ?>/">CATEGORY MANAGER</a></li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    
        <div class="container-fluid" id="menulist">
            <div class="card">
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Product Picture</th>
                                <th>Product Name </th>
                                <th>Product Description</th>
                                <th>Category</th>
                                <th>Addon</th>
                                <th>Original Price</th>
                                <th><?php echo $projectname; ?> Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
								$owner = cleanInput($page_action_identifier);
                                $productssql    = "SELECT * FROM products WHERE owner='$owner'";
                                $productsresult = $db->query($productssql);
                                
                                if ($productsresult->num_rows > 0) {
                                    $ppid = 1;
                                    while ($productsobject = $productsresult->fetch_assoc()) {
                                		
                                        echo '<tr>
                                                <td>' .$ppid. '</td>
                                                <td> <img src="' . $productsobject["picture"] . '" class="img-fluid" width="50px"></td>
                                                <td>' . $productsobject["name"] . '</td>
                                                 <td>' . $productsobject["description"] . '</td> <td>' . $productsobject["category"] . '</td><td>';
												if($productsobject["addondata"] == "" || $productsobject["addondata"] == "[]"){
													echo 'No Addon'; 
												}else{
													$addondata = json_decode($productsobject["addondata"]);
													$length = count($addondata);
													for ($x = 0; $x <= $length; $x++) {
													if(isset($addondata[$x]->name)){
														 echo '<p style="font-size: 10px">Name:'.$addondata[$x]->name.'<br> Original Price: '.$addondata[$x]->original_price.' '.$projectname.' Price: '.$addondata[$x]->price.'</p>';
														
														}										 
													}
												}
                                				
                                															
                                				echo 	'</td>
                                							<td>' . $productsobject["originalprice"] . '</td>
                                                            <td>' . $productsobject["price"] . '</td>
                                                            <td> <a href="'.$domain.'/delete-product/'.$productsobject["id"].'/" class="btn btn-primary">DELETE</a> </td>
                                                        </tr>';
                                							$ppid++;
                                        
										}
                                    
                                } else {
                                    
                                }
                                ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Product Picture</th>
                                <th>Product Name </th>
                                <th>Product Description</th>
                                <th>Category</th>
                                <th>Addon</th>
                                <th>Original Price</th>
                                <th><?php echo $projectname; ?> Price</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        </div>
	</section>