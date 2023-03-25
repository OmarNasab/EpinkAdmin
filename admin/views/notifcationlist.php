<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>General Notification List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active"><a href="<?php echo $domain; ?>/create-notifcation/" class="btn btn-primary">Create Notification</a></li>
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
										<th>Id</th>
                                        <th>Title</th>
                                        <th>Content</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
								<?php
$notifcationssql = "SELECT * FROM notifcations WHERE owner='0'";
$notifcationsresult = $db->query($notifcationssql);

if ($notifcationsresult->num_rows > 0) {
 $listid = 1;
    while($notifcationsobject = $notifcationsresult->fetch_assoc()) {
echo '
															  <tr>
																<td>'.$listid.'</td>
																<td>'.$notifcationsobject["title"].'</td>
																<td>'.$notifcationsobject["description"].'</td>
																<td><a href="'.$domain.'/delete-notifcation/'.$notifcationsobject["id"].'">Delete</a></td>
															</tr>
												';	
												$listid++;
    }
	
} else {
    echo "0 results";
}
?>
  
                                </tbody>
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

