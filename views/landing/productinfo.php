<?php
$uid = cleanInput($page_identifier_action);
$sql = "SELECT * FROM products WHERE id='$uid'";
$result = $db->query($sql);

if ($result->num_rows > 0) {
	$row = $result->fetch_assoc();
    
} else {
}

?>
                    <header class="page-header-ui epink-page-header-ui-dark epink-bg-gradient-primary-to-secondary">
                        <div class="page-header-ui-content mb-n5">
                            <div class="container px-5">
                                <div class="row gx-5 justify-content-center align-items-center">
                                    <div class="col-lg-6" data-aos="fade-right">
                                        <h1 class="page-header-ui-title text-light"><?php echo $row["name"]; ?></h1>
										<p>PRICE: RM<?php echo $row["price"]; ?></p>
                                        <p class="page-header-ui-text mb-5"><?php echo $row["description"]; ?></p>
										<p>Download our mobile app now!</p>
                                        <div class="mb-5 mb-lg-0 ">
                                            <a class="me-3" href="#!"><img src="<?php echo $domain; ?>/landingasset/assets/img/app-badges/app-store-badge.svg" style="height: 3rem" /></a>
                                            <a href="#!"><img src="<?php echo $domain; ?>/landingasset/assets/img/app-badges/google-play-badge.svg" style="height: 3rem" /></a>
											
                                        </div>
										<p class=" mb-5 mt-5">Use our web application <a href="https://app.epink.health" class="text-white strong"><strong>Click Here</strong></a></p>
										<div class="mb-5 mb-lg-0">
                                           
                                        </div>
                                    </div>
                                    <div class="col-lg-6 z-1" data-aos="fade-left">
										<center><img class="card-team-img mb-3" src="<?php echo $row["picture"]; ?>" alt="..." width="200px" height="200px" style="border-radius: 50%"></center>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="svg-border-waves text-white">
                            <!-- Wave SVG Border-->
                            <svg class="wave" style="pointer-events: none" fill="currentColor" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1920 75">
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
                                <clippath id="a"><rect class="a" width="1920" height="75"></rect></clippath>
                                <g class="b"><path class="c" d="M1963,327H-105V65A2647.49,2647.49,0,0,1,431,19c217.7,3.5,239.6,30.8,470,36,297.3,6.7,367.5-36.2,642-28a2511.41,2511.41,0,0,1,420,48"></path></g>
                                <g class="b"><path class="d" d="M-127,404H1963V44c-140.1-28-343.3-46.7-566,22-75.5,23.3-118.5,45.9-162,64-48.6,20.2-404.7,128-784,0C355.2,97.7,341.6,78.3,235,50,86.6,10.6-41.8,6.9-127,10"></path></g>
                                <g class="b"><path class="d" d="M1979,462-155,446V106C251.8,20.2,576.6,15.9,805,30c167.4,10.3,322.3,32.9,680,56,207,13.4,378,20.3,494,24"></path></g>
                                <g class="b"><path class="d" d="M1998,484H-243V100c445.8,26.8,794.2-4.1,1035-39,141-20.4,231.1-40.1,378-45,349.6-11.6,636.7,73.8,828,150"></path></g>
                            </svg>
                        </div>
                    </header> 

					
					<script src="<?php echo $domain; ?>/js/webapp.js"></script>