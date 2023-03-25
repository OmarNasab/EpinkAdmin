<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Med Vac</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">System setting</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->

        <div class="container-fluid">
			<?php
			if(isset($response)){
				echo '<p>'.$response.'</p>';
			}
			?>

		</div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
