<?php
$query = "SELECT setting_item, setting_value FROM settings WHERE id='8'"; 
$result = $db->query($query); 
if($result->num_rows > 0){
    	$settings = $result->fetch_assoc();
		$settings["setting_value"] = str_replace("{{website_name}}", $project_name, $settings["setting_value"]);
		$settings["setting_value"] = str_replace("{{company_name}}", $company_name, $settings["setting_value"]);
		$settings["setting_value"] = str_replace("{{website_url}}", $domain, $settings["setting_value"]);
}
?>
                    <section class="bg-white py-10">
                        <div class="container px-5">
                            <div class="row gx-5 justify-content-center">
                                <div class="col-lg-10 col-xl-8">
                                    <div class="single-post"><?php echo $settings["setting_value"]; ?>
									</div>
								</div>
							</div>
						</div>
					</section>