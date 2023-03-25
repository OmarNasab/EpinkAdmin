<?php
	$id = cleanInput($final_identifier);
	if(isset($_POST["delete"])){
		$sql = "DELETE FROM products WHERE id='$id'";
		if ($db->query($sql) === TRUE){
			$cardcolor = "bg-success";
			$response = 'The record has been deleted successfully. <a href="'.$domain.'/pharmacy-panel/products/" class="text-white strong"><b>Back to list</b></a>';
		} else {
			$cardcolor = "bg-warning";
			$response = 'Error deleting record: ' . $db->error;
		}
	}
?>
<header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
	<div class="container-xl px-4">
		<div class="page-header-content">
			<div class="row align-items-center justify-content-between pt-3">
				<div class="col-auto mb-3">
					<h1 class="page-header-title">
						 <div class="page-header-icon"><i data-feather="setting"></i></div>
						 	Delete Product
					 </h1>
				</div>
	 			<div class="col-12 col-xl-auto mb-3"> 
					<a class="btn btn-sm btn-light text-primary" href="<?php echo $domain; ?>/pharmacy-panel/products/">Back </a>
				</div>
			</div>
		</div>
	</div>
</header>
<div class="container-xl px-4 mt-4">
	<div class="row">
		<div class="col-xl-12">
			<div class="card mb-4">
			 <div class="card-header text-dark">Delete item confirmation</div>
			 	<div class="card-body">
			 		<?php if(isset($response)){
			 			echo '
			 				<div class="card mb-4">
			 					<div class="card-body '.$cardcolor.' text-white">
			 						'.$response.'
			 					</div>
			 				</div>
			 				';
			 			}
			 		?>
			 	 <form method="POST">
			 	 	<div class="row gx-3">
			 	 		<div class="col-md-12 mb-3">  
			 	 			<p>After deleting this information there is no way to recover this. Are you sure about this ? </p> 
			 	 		</div>
			 	 		<div class="col-md-8 mb-3"></div>
			 	 		<div class="col-md-2 mb-3"><a href="<?php echo $domain; ?>/pharmacy-panel/products/" class="btn btn-primary" style="width: 100%">Cancel</a></div>
			 	 		<div class="col-md-2 mb-3"><button class="btn btn-warning" type="submit" id="delete" name="delete" style="width: 100%">Confirm</button></div>
			 	 	</div>
			 	 </form>
				</div>
			</div>
		</div>
	</div>
</div>


