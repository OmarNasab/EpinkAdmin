<?php
	$uid = cleanInput($page_action_identifier);
	if(isset($_POST["updatepaidamount"])){
		    $paidamount = cleanInput($_POST["paidamount"]);
			$sql = "UPDATE users SET wallet= wallet - '$paidamount' WHERE id='$uid'";
			if ($db->query($sql) === TRUE) {
			  $res = 'Record updated successfully <a href="'.$domain.'/finance/">Back</a>';
			} else {
			  $res = "Error updating record: " . $db->error;
			}
		
	}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Set paid</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item active"><a href="<?php echo $domain; ?>/finance/">Back to finance</a></li>
					</ol>
				</div>
			</div>
		</div>
		<!-- /.container-fluid -->
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<?php
				if(isset($res)){
					echo '<div class="card"><div class="card-body">'.$res.'</div></div>';
					
				}
				?>
			<form method="post">
				<div class="form-group">
					<label for="title">Amount you paid</label>
					<input class="form-control" type="text" id="paidamount" name="paidamount"  value="">
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-primary" name="updatepaidamount">SUBMIT</button>
				</div>
			</form>
		</div>
		<!-- /.container-fluid -->
	</section>
	<!-- /.content -->
</div>