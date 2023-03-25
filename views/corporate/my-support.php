<header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
	<div class="container-fluid px-4">
		<div class="page-header-content">
			<div class="row align-items-center justify-content-between pt-3">
				<div class="col-auto mb-3">
					<h1 class="page-header-title">
						<div class="page-header-icon"><i data-feather="list"></i></div>
						Support Request
					</h1>
				</div>
				<div class="col-12 col-xl-auto mb-3">
					<a class="btn btn-sm btn-light text-primary" href="blog-management-create-post.html" data-bs-toggle="modal" data-bs-target="#exampleModal">
					<i class="me-1" data-feather="plus"></i>
					Create New Request
					</a>
				</div>
			</div>
		</div>
	</div>
</header>
<!-- Main page content-->
<div class="container-fluid px-4">
				<?php
				$sql = "SELECT * FROM support_request WHERE support_owner='$uid' ORDER by id DESC";
				$result = $db->query($sql);

				if ($result->num_rows > 0) {
				  // output data of each row
				  while($row = $result->fetch_assoc()) {
					   echo '
												<div class="card mb-4">
													<div class="card-header"><a href="'.$domain.'/dashboard/my-support/view/'.$row["id"].'/">#'.$row["id"].' - '.$row["support_title"].'</a>
														<br><small>'.$row["support_date"].'</small></div>
													
												</div>											
												';
					
				  }
				} else {
				  echo '<tr>
						<td>No request</td>
					</tr>';
				}				
				?>

</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Support request form</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form method="POST">
					<div class="mb-3">
						<label for="support_title" class="form-label">Title</label>
						<input type="text" class="form-control" id="support_title" name="support_title" placeholder="Please state your problem">
					</div>
					<div class="mb-3">
						<label for="thread_content" class="form-label">Detail</label>
						<textarea class="form-control" id="thread_content" name="thread_content" rows="3" placeholder="Please tell us more about the problem that you are facing"></textarea>
					</div>
			</div>
			<div class="modal-footer">
			<button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
			<button type="submit" name="submit_support_request" class="btn btn-primary">Send</button>
			</form>
			</div>
		</div>
	</div>
</div>