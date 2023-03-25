
                    <header class="page-header-ui page-header-ui-dark bg-img-cover overlay overlay-60" style="background-image: url(https://epink.health/img/sf1.jpg)">
                        <div class="page-header-ui-content position-relative">
                            <div class="container px-5 text-center">
                                <div class="row gx-5 justify-content-center">
                                    <div class="col-lg-8">
                                        <h1 class="page-header-ui-title mb-3">INSIGHT</h1>
                                        <p class="page-header-ui-text mb-0">A read a day keeps your brain active. Read one for some good insights</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="svg-border-rounded text-light">
                            <!-- Rounded SVG Border-->
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 144.54 17.34" preserveAspectRatio="none" fill="currentColor"><path d="M144.54,17.34H0V0H144.54ZM0,0S32.36,17.34,72.27,17.34,144.54,0,144.54,0"></path></svg>
                        </div>
                    </header>
					<section class="bg-light py-10">
                        <div class="container px-5">
							<?php
							if(isset($_GET["category"])){
								$category = cleanInput($_GET["category"]);
								if($category == "news-article"){
									$category = "News Article";
								}
								echo '<h1 class="mb-5">'.$category.'</h1>';
							}
							
							?>
                            <div class="row gx-5">
							
<?php
	
	if(isset($_GET["category"])){
		$category = cleanInput($_GET["category"]);
		$sql = "SELECT * FROM blogs WHERE category='$category'";
	}else{
		$sql = "SELECT * FROM blogs";
	}
	
	$result = $db->query($sql);

	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) {
			$subcontent = substr($row["content"], 0, strpos(wordwrap($row["content"], 100), "\n"));
			if($row["category"] == "news-article"){
				echo '
									<div class="col-md-6 col-xl-4 mb-5">
										<a class="card post-preview lift h-100" href="'.$row["content"].'/">
											<img class="card-img-top" src="'.$row["thumbnail"].'" alt="...">
											<div class="card-body">
												<h5 class="card-title">'.$row["title"].'</h5>
												<p class="card-text">'.$subcontent.'</p>
											</div>
											<div class="card-footer">
												<div class="post-preview-meta">
													<img class="post-preview-meta-img" src="'.$domain.'/landingasset/assets/img/illustrations/profiles/profile-2.png">
													<div class="post-preview-meta-details">
														<div class="post-preview-meta-details-name">ePink Health Press</div>
														<div class="post-preview-meta-details-date">5 min read</div>
													</div>
												</div>
											</div>
										</a>
									</div>			
				';				
				
				
			}else{
				echo '
									<div class="col-md-6 col-xl-4 mb-5">
										<a class="card post-preview lift h-100" href="'.$domain.'/insight/read/'.$row["permalink"].'/">
											<img class="card-img-top" src="'.$row["thumbnail"].'" alt="...">
											<div class="card-body">
												<h5 class="card-title">'.$row["title"].'</h5>
												<p class="card-text">'.$subcontent.'</p>
											</div>
											<div class="card-footer">
												<div class="post-preview-meta">
													<img class="post-preview-meta-img" src="'.$domain.'/landingasset/assets/img/illustrations/profiles/profile-2.png">
													<div class="post-preview-meta-details">
														<div class="post-preview-meta-details-name">EPINK ADMIN</div>
														<div class="post-preview-meta-details-date">Feb 4 · 5 min read</div>
													</div>
												</div>
											</div>
										</a>
									</div>			
				';
			}
			
		}
	} else {
		$row["status"] = "fail";
		$row["message"] = "Database is empty";
		$data = $row;
	}

?>
							</div>
                            <nav aria-label="Page navigation example">
                                <ul class="pagination pagination-blog justify-content-center">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#!" aria-label="Previous"><span aria-hidden="true">«</span></a>
                                    </li>
                                    <li class="page-item active"><a class="page-link" href="#!">1</a></li>
                                   
                                    <li class="page-item">
                                        <a class="page-link" href="#!" aria-label="Next"><span aria-hidden="true">»</span></a>
                                    </li>
                                </ul>
                            </nav>
                        </div>   
                    	<div class="svg-border-waves text-dark">
                    		<svg class="wave" style="pointer-events: none" fill="#ffffff" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1920 75">
                    			<defs>
                    				<style>
                    					.a {
                    						fill: none;
                    					}

                    					.b {
                    						clip-path: url(#a);
                    					}

                    					.d {
                    						opacity: 0.5;
                    						isolation: isolate;
                    					}
                    				</style>
                    			</defs>
                    			<clipPath id="a">
                    				<rect class="a" width="1920" height="75"></rect>
                    			</clipPath>
                    			<g class="b">
                    				<path class="c" d="M1963,327H-105V65A2647.49,2647.49,0,0,1,431,19c217.7,3.5,239.6,30.8,470,36,297.3,6.7,367.5-36.2,642-28a2511.41,2511.41,0,0,1,420,48"></path>
                    			</g>
                    			<g class="b">
                    				<path class="d" d="M-127,404H1963V44c-140.1-28-343.3-46.7-566,22-75.5,23.3-118.5,45.9-162,64-48.6,20.2-404.7,128-784,0C355.2,97.7,341.6,78.3,235,50,86.6,10.6-41.8,6.9-127,10"></path>
                    			</g>
                    			<g class="b">
                    				<path class="d" d="M1979,462-155,446V106C251.8,20.2,576.6,15.9,805,30c167.4,10.3,322.3,32.9,680,56,207,13.4,378,20.3,494,24"></path>
                    			</g>
                    			<g class="b">
                    				<path class="d" d="M1998,484H-243V100c445.8,26.8,794.2-4.1,1035-39,141-20.4,231.1-40.1,378-45,349.6-11.6,636.7,73.8,828,150"></path>
                    			</g>
                    		</svg>
                    	</div>						
                    </section>
