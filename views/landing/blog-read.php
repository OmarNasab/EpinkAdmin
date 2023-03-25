                    <section class="bg-light py-10">
                        <div class="container px-5">
                            <div class="row gx-5 justify-content-center">
                                <div class="col-lg-10 col-xl-8">
                                    <div class="single-post">
                                        
			<?php
	$id = cleanInput($page_action_identifier);
	$blogssql = "SELECT * FROM blogs WHERE permalink='$id'";
	$blogsresult = $db->query($blogssql);
	if ($blogsresult->num_rows > 0){
		$row = $blogsresult->fetch_assoc();
		echo '
<h1>'.$row["title"].'</h1>
                                       
                                        <div class="d-flex align-items-center justify-content-between mb-5">
                                            <div class="single-post-meta me-4">
                                                <img class="single-post-meta-img" src="'.$domain.'/landingasset/assets/img/illustrations/profiles/profile-1.png" />
                                                <div class="single-post-meta-details">
                                                    <div class="single-post-meta-details-name">Admin</div>
                                                    <div class="single-post-meta-details-date">'.$row["publishing_date"].'</div>
                                                </div>
                                            </div>
											
                                            <div class="single-post-meta-links">
                                                <a href="#!"><i class="fab fa-twitter fa-fw"></i></a>
                                                <a href="https://www.facebook.com/sharer/sharer.php?'.$domain.'/insight/'.$row["permalink"].'" target="_blank"><i class="fab fa-facebook-f fa-fw"></i></a>
                                                <a href="#!"><i class="fas fa-bookmark fa-fw"></i></a>
                                            </div>
                                        </div>	
										<img class="img-fluid mb-2 rounded" src="'.$row["thumbnail"].'" width="100%"/>
                                        <div class="small text-gray-500 text-center">Photo Credit: Unsplash</div>
                                        <div class="single-post-text my-5">
'. $row["content"].'		
</div>								
		
		';

		
	} else {
		$row["card"] = "red";
		$row["status"] = "Fail";
		$row["message"] = "The record you looking for does not exist<script>window.location.href= ''.$domain.'/404';</script>";
		$data = $row;
		echo '<div class="card"><div class="card-body">The article you looking for does not exist. Redirecting in 3 second. <script>window.location.href = "https://epink.health/blogs/"</script></div></div>';
	}
?>
                                            <hr class="my-5" />
                                            <div class="text-center"><a class="btn btn-transparent-dark" href="<?php echo $domain; ?>/insight/">Back to insight overview</a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>