<section id="noform" class="bg-white py-10" style="margin-bottom: -50px; display: none">
	<div class="container px-5">
		<div class="row gx-5 justify-content-center">
			<div class="col-lg-6">
				<div class="text-center mt-4">
					<img class="img-fluid p-4" src="https://epink.health/landingasset/assets/img/illustrations/400-error-bad-request.svg" alt="..." />
					<p class="lead">Your client has issued a malformed or illegal request.</p>
					<a class="text-arrow-icon epink-text-primary" href="<?php echo $domain; ?>/home/">
					<i class="ms-0 me-1" data-feather="arrow-left"></i>
					Return Home
					</a>
				</div>
			</div>
		</div>
	</div>
</section>
<section>
	<div class="container mb-5 mt-5">
		<div id="response"> <?php
			if(isset($data)){
				if($data["status"] == "Fail"){
					$cardcolor = 'bg-danger';
				}else{
					$cardcolor = 'bg-success';
				}
				echo '
					
				<div class="card mb-5 mt-5 '.$cardcolor.' text-white">
					<div class="card-body">
							'.$data["message"].'
						</div>
				</div>
				';
			}
			?> </div>
		<div id="covid19rehab" class="row mb-5" style="display: none">
			<div class="row gx-5">
				<div class="col-12 col-lg-12">
					<p><strong>Post-Covid Screening & Rehabilitation </strong></p>
				</div>
			</div>
				<div class="row gx-5">
					<div class="col-12 col-lg-12">
					<p><strong>Select Package</strong></p>
					</div>
					<div  class="col-lg-4 mb-5 mb-lg-0" onclick="selectRehabOne()">
						<div id="selectRehabOne" class="card pricing h-100">
							<div class="card-body p-5">
								<div class="text-center">
									<div class="badge epinkbglight epink-text-primary rounded-pill badge-marketing">1 Month Package</div>
									<div class="pricing-price">
										<sup>RM</sup> 250
									</div>
								</div>
								<ul class="fa-ul pricing-list">
									<li class="pricing-list-item">
										<span class="fa-li">
										<i class="far fa-check-circle text-pink"></i>
										</span>
										<span class="">Physical examination
										</span>
										<ul class="fa-ul pricing-list">
											<li><small>-Height, weight, Body Mass index(BMI)</small></li>
											<li><small>-Vital sign examination</small></li>
										</ul>
									</li>
									<li class="pricing-list-item">
										<span class="fa-li">
										<i class="far fa-check-circle text-pink"></i>
										</span>
										<span class="">Blood test (Blood & urine)
										</span>
										<ul class="fa-ul pricing-list">
											<li><small>-Full Blood Count (FBC)</small></li>
											<li><small>-Inflammatory markers</small></li>
											<li><small>-Renal Function Test</small></li>
											<li><small>-Liver Function Test</small></li>
											<li><small>-Fasting Glucose</small></li>
											<li><small>-Urine FEME</small></li>
										</ul>
									</li>
									<li class="pricing-list-item">
										<span class="fa-li">
										<i class="far fa-check-circle text-pink"></i>
										</span>
										<span class="">Consultation
										</span>
										<ul class="fa-ul pricing-list">
											<li><small>-Review with Consultant </small></li>
										</ul>
									</li>									
								</ul>
							</div>
						</div>
					</div>
					<div  class="col-lg-4 mb-5 mb-lg-0" onclick="selectRehabTwo()">
						<div id="selectRehabTwo" class="card pricing h-100">
							<div class="card-body p-5">
								<div class="text-center">
									<div class="badge epinkbglight epink-text-primary rounded-pill badge-marketing badge-sm">2 Month Package</div>
									<div class="pricing-price">
										<sup>RM</sup> 500
									</div>
								</div>
								<ul class="fa-ul pricing-list">
									<li class="pricing-list-item">
										<span class="fa-li">
										<i class="far fa-check-circle text-pink"></i>
										</span>
										<span class="">Physical examination
										</span>
										<ul class="fa-ul pricing-list">
											<li><small>-Height, weight, Body Mass index(BMI)</small></li>
											<li><small>-Vital sign examination</small></li>
										</ul>
									</li>
									<li class="pricing-list-item">
										<span class="fa-li">
										<i class="far fa-check-circle text-pink"></i>
										</span>
										<span class="">Blood test (Blood & urine)
										</span>
										<ul class="fa-ul pricing-list">
											<li><small>-Full Blood Count (FBC)</small></li>
											<li><small>-Inflammatory markers</small></li>
											<li><small>-Renal Function Test</small></li>
											<li><small>-Liver Function Test</small></li>
											<li><small>-Lipid Profile</small></li>
											<li><small>-Fasting Glucose</small></li>
											<li><small>-Urine FEME</small></li>
										</ul>
									</li>
									<li class="pricing-list-item">
										<span class="fa-li">
										<i class="far fa-check-circle text-pink"></i>
										</span>
										<span class="">Consultation
										</span>
										<ul class="fa-ul pricing-list">
											<li><small>-Review with Consultant </small></li>
										</ul>
									</li>	
									<li class="pricing-list-item">
										<span class="fa-li">
										<i class="far fa-check-circle text-pink"></i>
										</span>
										<span class="">Physiotherapy session
										</span>
										<ul class="fa-ul pricing-list">
											<li><small>-Lung rehabilitation</small></li>
											<li><small>-Aerobic exercise</small></li>
											<li><small>-Cardiovascular endurance</small></li>
											<li><small>-Health Regime</small></li>
										</ul>
									</li>										
								</ul>
							
							</div>
						</div>
					</div>
					<div  class="col-lg-4 mb-5 mb-lg-0" onclick="selectRehabThree()">
						<div id="selectRehabThree" class="card pricing h-100">
							<div class="card-body p-5">
								<div class="text-center">
									<div class="badge epinkbglight epink-text-primary rounded-pill badge-marketing badge-sm">3 Month Package</div>
									<div class="pricing-price">
										<sup>RM</sup> 750
									</div>
								</div>
								<ul class="fa-ul pricing-list">
									<li class="pricing-list-item">
										<span class="fa-li">
										<i class="far fa-check-circle text-pink"></i>
										</span>
										<span class="">Physical examination
										</span>
										<ul class="fa-ul pricing-list">
											<li><small>-Height, weight, Body Mass index(BMI)</small></li>
											<li><small>-Vital sign examination</small></li>
										</ul>
									</li>
									<li class="pricing-list-item">
										<span class="fa-li">
										<i class="far fa-check-circle text-pink"></i>
										</span>
										<span class="">Blood test (Blood & urine)
										</span>
											<ul class="fa-ul pricing-list">
											<li><small>-Full Blood Count (FBC)</small></li>
											<li><small>-Inflammatory markers</small></li>
											<li><small>-Renal Function Test</small></li>
											<li><small>-Liver Function Test</small></li>
											<li><small>-Lipid Profile</small></li>
											<li><small>-Fasting Glucose</small></li>
											<li><small>-Urine FEME</small></li>
										</ul>
									</li>
									<li class="pricing-list-item">
										<span class="fa-li">
										<i class="far fa-check-circle text-pink"></i>
										</span>
										<span class="">Consultation
										</span>
										<ul class="fa-ul pricing-list">
											<li><small>-Review with Consultant </small></li>
										</ul>
									</li>
									<li class="pricing-list-item">
										<span class="fa-li">
										<i class="far fa-check-circle text-pink"></i>
										</span>
										<span class="">Physiotherapy session
										</span>
										<ul class="fa-ul pricing-list">
											<li><small>-Lung rehabilitation</small></li>
											<li><small>-Aerobic exercise</small></li>
											<li><small>-Cardiovascular endurance</small></li>
											<li><small>-Health Regime</small></li>
										</ul>
									</li>	
									<li class="pricing-list-item">
										<span class="fa-li">
										<i class="far fa-check-circle text-pink"></i>
										</span>
										<span class="">Mental wellbeing session
										</span>
										<ul class="fa-ul pricing-list">
											<li><small>-Stress Management</small></li>
											<li><small>-Wellness talk</small></li>
										</ul>
									</li>
									<li class="pricing-list-item">
										<span class="fa-li">
										<i class="far fa-check-circle text-pink"></i>
										</span>
										<span class="">ePink Health Voucher
										</span>
									</li>	
									<li class="pricing-list-item">
										<span class="fa-li">
										<i class="far fa-check-circle text-pink"></i>
										</span>
										<span class="">Free gift
										</span>
									</li>									
								</ul>
							
							</div>
						</div>
					</div>
				</div>
			<div class="row gx-5">
				<div class="col-6 mt-3">
					<div class="mb-3">
						<label for="rehab_total_pack" class="form-label">
						<strong>Pack</strong>
						</label>
						<input type="number" class="form-control" id="rehab_total_pack" name="rehab_total_pack" value="1" onchange="rehabpackChange()">
					</div>
				</div>
				<div class="col-6 mt-3">
					<div class="mb-3">
						<label for="booking_type" class="form-label">
						<strong>Total Price</strong>
						</label>
						<input type="number" class="form-control" id="rehab_total_price" name="rehab_total_price" value="0.00" step="0.01" readonly>
					</div>
				</div>
			</div>
		</div>
		<div id="quarantineservices" class="row mb-5" style="display: none">
			<div class="col-12 col-lg-12">
				<p class="">
					<strong>Quarantine services</strong>
				</p>
				<p class="mb-3">
					<small></small>
				</p>
				<div class="row gx-5">
					<div  class="col-lg-4 mb-5 mb-lg-0" onclick="qselectBasic()">
						<div id="basicQ" class="card pricing h-100">
							<div class="card-body p-5">
								<div class="text-center">
									<div class="badge bg-light text-dark rounded-pill badge-marketing badge-sm">BASIC</div>
									<div class="pricing-price">
										<sup>RM</sup> 299
									</div>
								</div>
								<ul class="fa-ul pricing-list">
									<li class="pricing-list-item">
										<span class="fa-li">
										<i class="far fa-check-circle text-teal"></i>
										</span>
										<span class="text-dark">3x scheduled video consultation</span>
									</li>
									<li class="pricing-list-item">
										<span class="fa-li">
										<i class="far fa-check-circle text-teal"></i>
										</span>
										<span class="text-dark">Physical assessment</span>
									</li>
									<li class="pricing-list-item">
										<span class="fa-li">
										<i class="far fa-check-circle text-teal"></i>
										</span>
										<span class="text-dark">10 days Virtual Monitoring on vital signs </span>
									</li>
									<li class="pricing-list-item">
										<span class="fa-li">
										<i class="far fa-check-circle text-teal"></i>
										</span>
										<span class="text-dark">Personalize briefing on self-care</span>
									</li>
									<li class="pricing-list-item">
										<span class="fa-li">
										<i class="far fa-check-circle text-teal"></i>
										</span>
										<span class="text-dark">Digital home care guide book</span>
									</li>
									<li class="pricing-list-item">
										<span class="fa-li">
										<i class="far fa-check-circle text-teal"></i>
										</span>
										<span class="text-dark">Free Medication / medical items delivery </span>
									</li>
									<li class="pricing-list-item">
										<span class="fa-li">
										<i class="far fa-check-circle text-teal"></i>
										</span>
										<span class="text-dark">ePink voucher</span>
									</li>
									<li class="pricing-list-item">
										<span class="fa-li">
										<i class="far fa-check-circle text-teal"></i>
										</span>
										<span class="text-dark">Release Order from HSO (GP)</span>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<div  class="col-lg-4 mb-5 mb-lg-0" onclick="qselectMedium()">
						<div id="mediumQ" class="card pricing h-100">
							<div class="card-body p-5">
								<div class="text-center">
									<div class="badge bg-primary-soft rounded-pill badge-marketing badge-sm text-primary">Medium</div>
									<div class="pricing-price">
										<sup>RM</sup> 499
									</div>
								</div>
								<ul class="fa-ul pricing-list">
									<li class="pricing-list-item">
										<span class="fa-li">
										<i class="far fa-check-circle text-teal"></i>
										</span>
										<span class="text-dark">2x scheduled physical consultation </span>
									</li>
									<li class="pricing-list-item">
										<span class="fa-li">
										<i class="far fa-check-circle text-teal"></i>
										</span>
										<span class="text-dark">2x scheduled video consultation</span>
									</li>
									<li class="pricing-list-item">
										<span class="fa-li">
										<i class="far fa-check-circle text-teal"></i>
										</span>
										<span class="text-dark">10 days virtual monitoring on vital signs </span>
									</li>
									<li class="pricing-list-item">
										<span class="fa-li">
										<i class="far fa-check-circle text-teal"></i>
										</span>
										<span class="text-dark">Personalize briefing on self-care </span>
									</li>
									<li class="pricing-list-item">
										<span class="fa-li">
										<i class="far fa-check-circle text-teal"></i>
										</span>
										<span class="text-dark">Digital home care guide book </span>
									</li>
									<li class="pricing-list-item">
										<span class="fa-li">
										<i class="far fa-check-circle text-teal"></i>
										</span>
										<span class="text-dark">Free medication / medical items delivery </span>
									</li>
									<li class="pricing-list-item">
										<span class="fa-li">
										<i class="far fa-check-circle text-teal"></i>
										</span>
										<span class="text-dark">ePink voucher</span>
									</li>
									<li class="pricing-list-item">
										<span class="fa-li">
										<i class="far fa-check-circle text-teal"></i>
										</span>
										<span class="text-dark">Release Order from HSO (GP)</span>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<div  class="col-lg-4 mb-5 mb-lg-0" onclick="qselectPrem()">
						<div id="premQ" class="card pricing h-100">
							<div class="card-body p-5">
								<div class="text-center">
									<div class="badge bg-primary-soft rounded-pill badge-marketing badge-sm text-primary">Premium</div>
									<div class="pricing-price">
										<sup>RM</sup> 999
									</div>
								</div>
								<ul class="fa-ul pricing-list">
									<li class="pricing-list-item">
										<span class="fa-li">
										<i class="far fa-check-circle text-teal"></i>
										</span>
										<span class="text-dark">3x scheduled physical consultation </span>
									</li>
									<li class="pricing-list-item">
										<span class="fa-li">
										<i class="far fa-check-circle text-teal"></i>
										</span>
										<span class="text-dark">2x scheduled video consultation </span>
									</li>
									<li class="pricing-list-item">
										<span class="fa-li">
										<i class="far fa-check-circle text-teal"></i>
										</span>
										<span class="text-dark">Unlimited Tele-consultation (10days) </span>
									</li>
									<li class="pricing-list-item">
										<span class="fa-li">
										<i class="far fa-check-circle text-teal"></i>
										</span>
										<span class="text-dark">10 days virtual monitoring on vital signs </span>
									</li>
									<li class="pricing-list-item">
										<span class="fa-li">
										<i class="far fa-check-circle text-teal"></i>
										</span>
										<span class="text-dark">Personalize briefing on self-care </span>
									</li>
									<li class="pricing-list-item">
										<span class="fa-li">
										<i class="far fa-check-circle text-teal"></i>
										</span>
										<span class="text-dark">Digital home care guide book </span>
									</li>
									<li class="pricing-list-item">
										<span class="fa-li">
										<i class="far fa-check-circle text-teal"></i>
										</span>
										<span class="text-dark">Free medication / medical items delivery </span>
									</li>
									<li class="pricing-list-item">
										<span class="fa-li">
										<i class="far fa-check-circle text-teal"></i>
										</span>
										<span class="text-dark">Free pulse oximeter </span>
									</li>
									<li class="pricing-list-item">
										<span class="fa-li">
										<i class="far fa-check-circle text-teal"></i>
										</span>
										<span class="text-dark">ePink voucher </span>
									</li>
									<li class="pricing-list-item">
										<span class="fa-li">
										<i class="far fa-check-circle text-teal"></i>
										</span>
										<span class="text-dark">Release Order from HSO (GP) </span>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				
				<div class="col-12 col-lg-12 mt-5">
					<p class="">
						<strong>Add On </strong>
					</p>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" value="" id="Thermometer" onclick="qCheckPrice()">
						<label class="form-check-label" for="Thermometer"> Thermometer - RM 80 </label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" value="" id="Oximeter" onclick="qCheckPrice()">
						<label class="form-check-label" for="Oximeter"> Oximeter - RM 55 </label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" value="" id="Spirometer" onclick="qCheckPrice()">
						<label class="form-check-label" for="Spirometer">Spirometer - RM 50 </label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" value="" id="BPmachine" onclick="qCheckPrice()">
						<label class="form-check-label" for="BPmachine"> BP machine RM 125 </label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" value="" id="RT-PCRTest" onclick="qCheckPrice()">
						<label class="form-check-label" for="RT-PCRTest"> RT-PCR Test RM 220 </label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" value="" id="RTK-AntigenTest" onclick="qCheckPrice()">
						<label class="form-check-label" for="RTK-AntigenTest"> RTK-Antigen Test RM 120 </label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" value="" id="Immunebooster" onclick="qCheckPrice()">
						<label class="form-check-label" for="Immunebooster"> Immune booster RM 100 </label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" value="" id="Sanitizer" onclick="qCheckPrice()">
						<label class="form-check-label" for="Sanitizer">Sanitizer RM 20 </label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" value="" id="Homesanitization" onclick="qCheckPrice()">
						<label class="form-check-label" for="Homesanitization"> Home sanitization RM 350 </label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" value="" id="Portableoxygeninhaler" onclick="qCheckPrice()">
						<label class="form-check-label" for="Portableoxygeninhaler">Portable oxygen inhaler RM 250 </label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" value="" id="OxygenTank" onchange="openTankSaleoption()">
						<label class="form-check-label" for="OxygenTank"> Oxygen Tank full set (as per liter) </label>
						<div id="tanksaleoption" style="display: none">
							<form>
								<div class="form-check">
									<input class="form-check-input" type="radio" name="oxytank" id="3litre" value="3litre" onclick="setOxyprice(900)">
									<label class="form-check-label" for="3litre">
									3 Litre RM900
									</label>
								</div>
								<div class="form-check">
									<input class="form-check-input" type="radio" name="oxytank" value="5litre" id="5litre" onclick="setOxyprice(1500)">
									<label class="form-check-label" for="5litre">
									5 Litre RM1500
									</label>
								</div>
								<div class="form-check">
									<input class="form-check-input" type="radio" name="oxytank" id="10litre" value="10litre" onclick="setOxyprice(3000)">
									<label class="form-check-label" for="10litre">
									10 Litre RM3000
									</label>
								</div>
							</form>
						</div>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" value="" id="Oxygentankrental" onclick="openTankRentaloption()">
						<label class="form-check-label" for=" Oxygentankrental"> Oxygen tank rental (as per agreement) </label>
					</div>
					<div id="rentaltanksaleoption" class="row" style="display: none">
						<div class="col-12 col-lg-4">
							<div class="form-check">
								<label class="form-check-label" for="sizepick"> Pick size </label>
								<select id="renttanklitre" class="form-control" onchange="getrentalPrice()">
									<option value="" selected>Please select</option>
									<option value="3 Litre">3 Litre</option>
									<option value="5 Litre">5 Litre</option>
									<option value="10 Litre">10 Litre</option>
								</select>
							</div>
						</div>
						<div class="col-12 col-lg-4">
							<div class="form-check">
								<label class="form-check-label" for="tankrentalduration"> Duration</label>
								<select id="tankrentalduration" class="form-control"  onchange="getrentalPrice()">
									<option value="0" selected>Please select</option>
									<option value="1">1 Month</option>
									<option value="2">2 Month</option>
									<option value="3">3 Month</option>
								</select>
							</div>
						</div>
						<div class="col-12 col-lg-4">
							<div class="form-check">
								<label class="form-check-label" for="totalpriceforrental"> Total Price </label>
								<input type="number" step="0.01" id="totalpriceforrental" class="form-control">
							</div>
						</div>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" value="" id="Healthscreeningtest" onclick="qCheckPrice()">
						<label class="form-check-label" for="Healthscreeningtest"> Health screening test - RM 220 </label>
					</div>
				</div>
				<div class="row">
					<div class="col-6 mt-3">
						<div class="mb-3">
							<label for="vtotal_pack" class="form-label">
							<strong>Pack</strong>
							</label>
							<input type="number" class="form-control" id="qtotal_pack" name="qtotal_pack" value="1" onkeyup="qCheckPrice()">
						</div>
					</div>
					<div class="col-6 mt-3">
						<div class="mb-3">
							<label for="booking_type" class="form-label">
							<strong>Total Price</strong>
							</label>
							<input type="number" class="form-control" id="qtotal_price" name="qtotal_price" value="0.00" step="0.01" readonly>
						</div>
					</div>
				</div>
				<div id="qhomepisitaddress" class="row mt-5">
					<div class="col-12 col-lg-12">
						<p class="">
							<strong>Address </strong>
						</p>
					</div>
					<div class="col-12 col-lg-6">
						<div class="">
							<label for="qaddress" class="form-label">Address</label>
							<input type="email" class="form-control" id="qaddress" name="qaddress" onkeyup="updateFormData(this, 'qaddress')">
						</div>
					</div>
					<div class="col-12 col-lg-6">
						<div class="">
							<label for="qpostcode" class="form-label">Postcode</label>
							<input type="email" class="form-control" id="qpostcode" name="qpostcode" onkeyup="updateFormData(this, 'qpostcode')">
						</div>
					</div>
					<div class="col-12 col-lg-6">
						<div class="">
							<label for="qcity" class="form-label">City</label>
							<input type="text" class="form-control" id="qcity" name="qcity" onkeyup="updateFormData(this, 'qcity')">
						</div>
					</div>
					<div class="col-12 col-lg-6">
						<div class="">
							<label for="qstate" class="form-label">State</label>
							<select class="form-control" name="qstate" id="qstate" onchange="updateFormData(this, 'qstate')">
								<option palue="Johor">Johor</option>
								<option palue="Kedah">Kedah</option>
								<option palue="Kelantan">Kelantan</option>
								<option palue="Kuala Lumpur">Kuala Lumpur</option>
								<option palue="Labuan">Labuan</option>
								<option palue="Melaka">Melaka</option>
								<option palue="Negeri Sembilan">Negeri Sembilan</option>
								<option palue="Pahang">Pahang</option>
								<option palue="Penang">Penang</option>
								<option palue="Perak">Perak</option>
								<option palue="Perlis">Perlis</option>
								<option palue="Putrajaya">Putrajaya</option>
								<option palue="Sabah">Sabah</option>
								<option palue="Sarawak">Sarawak</option>
								<option palue="Selangor" selected>Selangor</option>
								<option palue="Terengganu">Terengganu</option>
							</select>
						</div>
					</div>
					<div class="col-12 col-lg-6">
						<div class="">
							<label for="qcountry" class="form-label">Country</label>
							<input type="text" class="form-control" id="qcountry" name="qcountry" value="Malaysia" onkeyup="updateFormData(this, 'qcountry')" readonly>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="antibodytest" class="row mb-5" style="display: none">
			<div class="col-12 col-lg-12">
				<p class="">
					<strong>Post Vaccination Antibody Test</strong>
				</p>
				<p class="mb-3">
					<small></small>
				</p>
				<div class="row mt-3">
					<div class="col-12 col-lg-6">
						<div class="card" id="pselectWalkin" onclick="pSelectWalkin()">
							<div class="card-body"> Walk - In </div>
						</div>
					</div>
					<div class="col-12 col-lg-6">
						<div class="card" id="pselectHomepisit" onclick="pSelectHomepisit()">
							<div class="card-body"> Home visit </div>
						</div>
					</div>
				</div>
								<div id="phomepisitaddress" style="display: none">
					<div class="col-6 mt-3">
						<div class="mb-3">
							<label for="postcode" class="form-label">Address</label>
							<input type="email" class="form-control" id="paddress" name="paddress" onkeyup="updateFormData(this, 'paddress'); updatePostvacdata();">
						</div>
					</div>
					<div class="col-6 mt-3">
						<div class="mb-3">
							<label for="postcode" class="form-label">Postcode</label>
							<input type="email" class="form-control" id="ppostcode" name="ppostcode" onkeyup="updateFormData(this, 'ppostcode'); updatePostvacdata();">
						</div>
					</div>
					<div class="col-6 mt-3">
						<div class="mb-3">
							<label for="city" class="form-label">City</label>
							<input type="text" class="form-control" id="pcity" name="pcity" onkeyup="updateFormData(this, 'pcity'); updatePostvacdata();">
						</div>
					</div>
					<div class="col-6 mt-3">
						<div class="mb-3">
							<label for="city" class="form-label">State</label>
							<select class="form-control" name="pstate" id="pstate" onchange="updateFormData(this, 'pstate'); updatePostvacdata();">
								<option palue="Johor">Johor</option>
								<option palue="Kedah">Kedah</option>
								<option palue="Kelantan">Kelantan</option>
								<option palue="Kuala Lumpur">Kuala Lumpur</option>
								<option palue="Labuan">Labuan</option>
								<option palue="Melaka">Melaka</option>
								<option palue="Negeri Sembilan">Negeri Sembilan</option>
								<option palue="Pahang">Pahang</option>
								<option palue="Penang">Penang</option>
								<option palue="Perak">Perak</option>
								<option palue="Perlis">Perlis</option>
								<option palue="Putrajaya">Putrajaya</option>
								<option palue="Sabah">Sabah</option>
								<option palue="Sarawak">Sarawak</option>
								<option palue="Selangor" selected>Selangor</option>
								<option palue="Terengganu">Terengganu</option>
							</select>
						</div>
					</div>
					<div class="col-6 mt-3">
						<div class="mb-3">
							<label for="country" class="form-label">Country</label>
							<input type="text" class="form-control" id="pcountry" name="pcountry" palue="Malaysia" onkeyup="updateFormData(this, 'pcountry'); updatePostvacdata();" value="Malaysia"  readonly>
						</div>
					</div>
				</div>
				<div id="pwalkingaddress" style="display: none">
					<div class="col-12 mt-3">
						<div class="mb-3">
							<label for="walkin" class="form-label">
							<strong>Station</strong>
							</label>
							<select class="form-control" id="phqaddress" onchange="pchangeStation(this)">
								<option palue="">Please select</option>
								<option palue="ePink HQ">ePink HQ</option>
								<option palue="ePink Partner">ePink Partner</option>
							</select>
							<div id="">
								<p class="mt-3">
									<strong>Address</strong>
								</p>
								<span id="pepinkaddress">Please select test location</span>
							</div>
						</div>
					</div>
				</div>
				<div class="col-12 mt-3">
					<div class="card" id="postvac">
						<div class="card-body">
							<div class="row">
								<div class="col-12  col-lg-12">
									Post Vaccination Antibody Test 
									<p>
										<small id="postvacprice">RM 109.00 </small>
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>


			</div>
		</div>
		<div id="covidvaccination" class="row mb-5" style="display: none">
			<div class="col-12 col-lg-12">
				<p class="">
					<strong>COVID-19 Vaccination</strong>
				</p>
				<p class="mb-3">
					<small>Select type of COVID-19 Vaccination</small>
				</p>
			</div>
			<div class="col-12 mt-3">
				<div class="card" id="sinovacSelected" onclick="vSelectSINOVAC()">
					<div class="card-body">
						<div class="row">
							<div class="col-12 col-lg-2 py-2" id="">
								<center>
									<strong>SINOVAC</strong>
									<p>RM109.00</p>
								</center>
							</div>
							<div class="col-12  col-lg-10">
								SINOVAC 
								<p>
									<small>Description </small>
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-12 mt-3">
				<div class="card" id="sinovacFreeSelected" onclick="vSelectFreeSINOVAC()">
					<div class="card-body">
						<div class="row">
							<div class="col-12 col-lg-2 py-2" id="">
								<center>
									<strong>SINOVAC</strong>
									<p>FREE</p>
								</center>
							</div>
							<div class="col-12 col-lg-10">
								SINOVAC 
								<p>
									<small>Description </small>
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-12 mt-3">
				<div class="card" id="sinovacPFIZER" onclick="vSelectPFIZER()">
					<div class="card-body">
						<div class="row">
							<div class="col-12 col-lg-2 py-2" id="">
								<center>
									<strong>PFIZER</strong>
									<p>FREE</p>
								</center>
							</div>
							<div class="col-12 col-lg-10">
								Pfizer 
								<p>
									<small>Description </small>
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row mt-3">
				<div class="col-12 col-lg-6">
					<div class="card" id="vselectWalkin" onclick="vSelectWalkin()">
						<div class="card-body"> Walk - In </div>
					</div>
				</div>
				<div class="col-12 col-lg-6">
					<div class="card" id="vselectHomeVisit" onclick="vSelectHomevisit()">
						<div class="card-body"> Home Visit </div>
					</div>
				</div>
			</div>
			<div id="vhomevisitaddress" style="display: none">
				<div class="col-6 mt-3">
					<div class="mb-3">
						<label for="postcode" class="form-label">Address</label>
						<input type="email" class="form-control" id="vaddress" name="vaddress" onkeyup="updateFormData(this, 'vaddress')">
					</div>
				</div>
				<div class="col-6 mt-3">
					<div class="mb-3">
						<label for="postcode" class="form-label">Postcode</label>
						<input type="email" class="form-control" id="vpostcode" name="vpostcode" onkeyup="updateFormData(this, 'vpostcode')">
					</div>
				</div>
				<div class="col-6 mt-3">
					<div class="mb-3">
						<label for="city" class="form-label">City</label>
						<input type="text" class="form-control" id="vcity" name="vcity" onkeyup="updateFormData(this, 'vcity')">
					</div>
				</div>
				<div class="col-6 mt-3">
					<div class="mb-3">
						<label for="city" class="form-label">State</label>
						<select class="form-control" name="vstate" id="vstate" onchange="updateFormData(this, 'vstate')">
							<option value="Johor">Johor</option>
							<option value="Kedah">Kedah</option>
							<option value="Kelantan">Kelantan</option>
							<option value="Kuala Lumpur">Kuala Lumpur</option>
							<option value="Labuan">Labuan</option>
							<option value="Melaka">Melaka</option>
							<option value="Negeri Sembilan">Negeri Sembilan</option>
							<option value="Pahang">Pahang</option>
							<option value="Penang">Penang</option>
							<option value="Perak">Perak</option>
							<option value="Perlis">Perlis</option>
							<option value="Putrajaya">Putrajaya</option>
							<option value="Sabah">Sabah</option>
							<option value="Sarawak">Sarawak</option>
							<option value="Selangor" selected>Selangor</option>
							<option value="Terengganu">Terengganu</option>
						</select>
					</div>
				</div>
				<div class="col-6 mt-3">
					<div class="mb-3">
						<label for="country" class="form-label">Country</label>
						<input type="text" class="form-control" id="vcountry" name="vcountry" value="Malaysia" onkeyup="updateFormData(this, 'vcountry')" readonly>
					</div>
				</div>
			</div>
			<div id="vwalkingaddress" style="display: none">
				<div class="col-12 mt-3">
					<div class="mb-3">
						<label for="walkin" class="form-label">
						<strong>Station</strong>
						</label>
						<select class="form-control" id="vhqaddress" onchange="vchangeStation(this)">
							<option value="">Please select</option>
							<option value="ePink HQ">ePink HQ</option>
							<option value="ePink Partner">ePink Partner</option>
						</select>
						<div id="">
							<p class="mt-3">
								<strong>Address</strong>
							</p>
							<span id="vepinkaddress">Please select test location</span>
						</div>
					</div>
				</div>
			</div>
			<div class="col-6 mt-3">
				<div class="mb-3">
					<label for="vtotal_pack" class="form-label">
					<strong>Pack</strong>
					</label>
					<input type="number" class="form-control" id="vtotal_pack" name="vtotal_pack" value="1" onchange="vpackChange(this)">
				</div>
			</div>
			<div class="col-6 mt-3">
				<div class="mb-3">
					<label for="booking_type" class="form-label">
					<strong>Total Price</strong>
					</label>
					<input type="number" class="form-control" id="vtotal_price" name="total_price" value="0.00" step="0.01" readonly>
				</div>
			</div>
			<div class="col-12 col-lg-12 mt-5">
				<button class="btn btn-primary" onclick="getVacData()">NEXT</button>
			</div>
		</div>
		<div id="covidtest" class="row mb-5" style="display: none">
			<div class="col-12">
				<p class="">
					<strong>COVID-19 TEST</strong>
				</p>
			</div>
			<div class="row">
				<div class="col-12 col-lg-4">
					<div class="card" id="selectWalkin" onclick="selectWalkin()">
						<div class="card-body"> Walk - In </div>
					</div>
				</div>
				<div class="col-12 col-lg-4">
					<div class="card" id="selectHomeVisit" onclick="selectHomevisit('S')">
						<div class="card-body"> Home Visit (Selangor / Klang ) </div>
					</div>
				</div>
				<div class="col-12 col-lg-4">
					<div class="card" id="selectHomeVisitN" onclick="selectHomevisit('N')">
						<div class="card-body"> Home Visit (Outside Selangor / Klang) </div>
					</div>
				</div>
			</div>
			<div id="walkingaddress" style="display: none">
				<div class="col-12 mt-3">
					<div class="">
						<label for="walkin" class="form-label">
						<strong>Station</strong>
						</label>
						<select class="form-control" id="hqaddress" onchange="changeStation(this)">
							<option value="">Please select</option>
							<option value="ePink HQ">ePink HQ</option>
							<option value="ePink Partner">ePink Partner</option>
						</select>
						<div id="">
							<p class="mt-3">
								<strong>Address</strong>
							</p>
							<span id="epinkaddress">Please select test location</span>
						</div>
					</div>
				</div>
			</div>
			<div id="homevisitaddress" style="display: none" class="row">
				<div class="col-12 col-lg-6">
					<div class="">
						<label for="postcode" class="form-label">Address</label>
						<input type="email" class="form-control" id="address" name="address" onkeyup="updateFormData(this, 'address')">
					</div>
				</div>
				<div class="col-12 col-lg-6">
					<div class="">
						<label for="postcode" class="form-label">Postcode</label>
						<input type="email" class="form-control" id="postcode" name="postcode" onkeyup="updateFormData(this, 'postcode')">
					</div>
				</div>
				<div class="col-12 col-lg-6">
					<div class="">
						<label for="city" class="form-label">City</label>
						<input type="text" class="form-control" id="city" name="city" onkeyup="updateFormData(this, 'city')">
					</div>
				</div>
				<div class="col-12 col-lg-6">
					<div class="">
						<label for="city" class="form-label">State</label>
						<select class="form-control" name="state" id="state" onkeyup="updateFormData(this, 'state')">
							<option value="Johor">Johor</option>
							<option value="Kedah">Kedah</option>
							<option value="Kelantan">Kelantan</option>
							<option value="Kuala Lumpur">Kuala Lumpur</option>
							<option value="Labuan">Labuan</option>
							<option value="Melaka">Melaka</option>
							<option value="Negeri Sembilan">Negeri Sembilan</option>
							<option value="Pahang">Pahang</option>
							<option value="Penang">Penang</option>
							<option value="Perak">Perak</option>
							<option value="Perlis">Perlis</option>
							<option value="Putrajaya">Putrajaya</option>
							<option value="Sabah">Sabah</option>
							<option value="Sarawak">Sarawak</option>
							<option value="Selangor" selected>Selangor</option>
							<option value="Terengganu">Terengganu</option>
						</select>
					</div>
				</div>
				<div class="col-6">
					<div class="mb-3">
						<label for="country" class="form-label">Country</label>
						<input type="text" class="form-control" id="country" name="country" value="Malaysia" onkeyup="updateFormData(this, 'country')" readonly>
					</div>
				</div>
			</div>
			<div class="col-12 mt-5">
				<p class="">
					<strong>Type of test</strong>
				</p>
			</div>
			<div class="col-12 mt-3 mb-3">
				<div class="card" id="artselected" onclick="selecctART()">
					<div class="card-body">
						<div class="row">
							<div class="col-2 py-2" id="ARTview">
								<center>
									<strong>ART</strong>
									<p>RM-</p>
								</center>
							</div>
							<div class="col-10">
								Antigen Rapid Test (ART) 
								<p>
									<small>Suitable to screen for the early stage of SARS-CoV-2 infection. </small>
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-12 mt-3 mb-3">
				<div class="card">
					<div class="card-body" id="pcrselected" onclick="selecctPCR()">
						<div class="row">
							<div class="col-2 py-2" id="PCRview">
								<center>
									<strong>PCR</strong>
									<p>RM-</p>
								</center>
							</div>
							<div class="col-10">
								Polymerase Chain Reaction (PCR) (24-48hrs) 
								<p>
									<small>Definitive test for COVID-19 that directly detects the presence of the COVID-19 antigen in an individual.</small>
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-12 mt-3 mb-3">
				<div class="card">
					<div class="card-body" id="rpcrselected" onclick="selecctRPCR()">
						<div class="row">
							<div class="col-2 py-2" id="RPCRview">
								<center>
									<strong>Rapid PCR</strong>
									<p>RM-</p>
								</center>
							</div>
							<div class="col-10">
								Polymerase Chain Reaction (PCR) Rapid PCR (6hrs) 
								<p>
									<small>Definitive test for COVID-19 that directly detects the presence of the COVID-19 antigen in an individual.</small>
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-6 mt-3">
				<div class="mb-3">
					<label for="total_pack" class="form-label">
					<strong>Pack</strong>
					</label>
					<input type="number" class="form-control" id="total_pack" name="total_pack" value="1" onkeyup="packChange(this)">
				</div>
			</div>
			<div class="col-6 mt-3">
				<div class="mb-3">
					<label for="booking_type" class="form-label">
					<strong>Total Price</strong>
					</label>
					<input type="number" class="form-control" id="total_price" name="total_price" value="0.00" step="0.01" readonly>
				</div>
			</div>
			<div class="col-12 mt-3">
				<button class="btn btn-primary" onclick="getAlldata()">NEXT</button>
			</div>
		</div>
		<div id="coprate" style="display: none">
		<div class="col-12">
					<p class="">
						<strong>Company Information</strong>
					</p>
				</div>
		<div class="col-12">
				<div class="mb-3">
					<label for="companyname" class="form-label">Company name</label>
					<input type="text" class="form-control" id="companyname" name="companyname" onchange="updateFormData(this, 'companyname')" onkeyup="updateCoprateWellness()">
				</div>
			</div>
			<div class="col-12">
				<div class="mb-3">
					<label for="companyemail" class="form-label">Company email</label>
					<input type="text" class="form-control" id="companyemail" name="companyemail" onchange="updateFormData(this, 'companyemail')"  onkeyup="updateCoprateWellness()">
				</div>
			</div>
			<div class="col-12">
				<div class="mb-3">
					<label for="copack" class="form-label">Pax</label>
					<input type="text" class="form-control" id="copack" name="copack" onchange="updateFormData(this, 'copack')"  onkeyup="updateCoprateWellness()">
				</div>
			</div>
			<div class="col-12">
				<div class="mb-3">
					<label for="typeofservices" class="form-label">Type of services</label>
					
					<input type="text" class="form-control" id="typeofservices" name="typeofservices" onchange="updateFormData(this, 'typeofservices');"  onkeyup="updateCoprateWellness()">
<div class="row">
	<div class="col-4 mt-3">
		<div class="card" onclick="selectCoprateService(this, 'Work station analysis')">
			<div class="card-body">
				Work station analysis
			</div>
		</div>	
	</div>
</div>
<div class="row">
	<div class="col-4 mt-3">
		<div class="card" onclick="selectCoprateService(this, 'Training and Education to staff')">
			<div class="card-body">
				Training and Education to staff
			</div>
		</div>	
	</div>
</div>
				</div>
			</div>
		</div>
		<?php
		if(isset($_GET["public"])){
			$token = cleanInput($_GET["public"]);
			$sqlp = "SELECT * FROM users WHERE login_token='$token'";
			$resultp = $db->query($sqlp);

			if ($resultp->num_rows > 0) {
				$rowp = $resultp->fetch_assoc();
				echo 'Logged in as '.$rowp["firstname"].' '.$rowp["lastname"];
			}		
		}
		?>
		<form id="bookingformmain" method="POST" action="" style="display: none">
			<input type="number" class="form-control" id="final_total_price" name="final_total_price" step="0.01" hidden>
			
			<div class="mb-3 pages" style="display: none">
				<label for="booking_type" class="form-label">Booking Type</label>
				<input type="text" class="form-control" id="booking_type" name="booking_type" value="
					<?php echo $booking_type; ?>">
			</div>
			<div class="mb-3 " style="display: none">
				<label for="booking_data" class="form-label">Booking Data</label>
				<input type="text" class="form-control" id="booking_data" name="booking_data" value="">
			</div>
			<div class="row">
				<div id="bookingdetail"></div>
				<div class="col-12">
					<p class="">
						<strong>Your information</strong>
					</p>
				</div>
				<div class="col-6">
					<div class="mb-3">
						<label for="name" class="form-label">Full name <?php echo $rowp["firstname"].' '.$rowp["lastname"];  ?></label>
						<input type="text" class="form-control" id="name" name="name" onchange="updateFormData(this, 'name')" value="<?php echo $rowp["firstname"].' '.$rowp["lastname"];  ?>">
						
					</div>
				</div>
				<div class="col-6">
					<div class="mb-3">
						<label for="ic_passport" class="form-label">IC / Passport</label>
						<input type="text" class="form-control" id="ic_passport" name="ic_passport" onchange="updateFormData(this, 'ic_passport')" value="
						<?php if(isset($rowp)){ echo $rowp["ic"]; } ?>">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-6">
					<div class="mb-3">
						<label for="email" class="form-label">Email address</label>
						<input type="email" class="form-control" id="email" name="email" onchange="updateFormData(this, 'email')">
					</div>
				</div>
				<div class="col-6">
					<div class="mb-3">
						<label for="phone_number" class="form-label">Phone Number</label>
						<input type="text" class="form-control" id="phone_number" name="phone_number" onchange="updateFormData(this, 'phone_number')">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<p class="">
						<strong>Appointment Detail</strong>
					</p>
				</div>
				<div class="col-6">
					<div class="mb-3">
						<label for="booking_date" class="form-label">Date</label>
						<input type="date" class="form-control" id="booking_date" name="booking_date" 
						<?php
						if($_GET["quarantine-services"] == "quarantine-services"){
							echo 'onclick="getQuarantineData()"';
						}
						?>>
					</div>
				</div>
				<div class="col-6">
					<div class="mb-3">
						<label for="booking_data" class="form-label">Time</label>
						<input type="time" class="form-control" id="booking_time" name="booking_time">
					</div>
				</div>
			</div>
			<button type="submit" class="btn btn-primary" name="submit_booking">SUBMIT</button>
		</form>
	</div>
</section>
<?php 	if($booking_type == "COVID-19 Test")
	{
		echo '
		
		<script>
			document.getElementById("covidtest").style.display = "block";
			document.getElementById("covidvaccination").style.display = "none";
			document.getElementById("antibodytest").style.display = "none";
			document.getElementById("booking_type").value = "COVID-19 Test";
		</script>										
		';
	}else if($booking_type == "COVID-19 Vaccination"){
		echo '
		
																																			<script>
			document.getElementById("covidtest").style.display = "none";
			document.getElementById("quarantineservices").style.display = "none";
			document.getElementById("covidvaccination").style.display = "block";
			document.getElementById("antibodytest").style.display = "none";
		</script>										
		';					
	}else if($booking_type == "COVID-19 Vaccination Antibody Test"){
		echo '
		
																																			<script>
			document.getElementById("covidtest").style.display = "none";
			document.getElementById("covidvaccination").style.display = "none";
			document.getElementById("quarantineservices").style.display = "none";
			document.getElementById("antibodytest").style.display = "block";
			document.getElementById("bookingformmain").style.display = "block";
			document.getElementById("final_total_price").value = postvaccinationpriceWalkin;
			document.getElementById("booking_type").value = "COVID-19 Vaccination Antibody Test";
			document.getElementById("postvacprice").innerHTML = "Please select area";
		</script>										
		';	
	}else if($booking_type == "COVID-19 quarantine services"){
		echo '
		
																									<script>
			document.getElementById("covidtest").style.display = "none";
			document.getElementById("covidvaccination").style.display = "none";
			document.getElementById("quarantineservices").style.display = "block";
			document.getElementById("antibodytest").style.display = "none";
			document.getElementById("antibodytest").style.display = "none";
			document.getElementById("bookingformmain").style.display = "block";
			document.getElementById("booking_type").value = "COVID-19 Quarantine Service";
			
		</script>										
		';	
	}else if($booking_type == "COVID-19 Rehabilitation"){
		echo '
		
																													<script>
			document.getElementById("covid19rehab").style.display = "block";
			document.getElementById("bookingformmain").style.display = "block";
			document.getElementById("booking_type").value = "COVID-19 Rehabilitation";
		</script>										
		';	
	}else if($booking_type == "Corporate Wellness"){
		echo '
		
																													<script>
			document.getElementById("coprate").style.display = "block";
			document.getElementById("bookingformmain").style.display = "block";
			document.getElementById("booking_type").value = "Corporate Wellness";
			document.getElementById("final_total_price").value = "0.00";
		</script>										
		';	
	}else{
							echo '
		
																													<script>
			document.getElementById("noform").style.display = "block";
		</script>										
		';	
	}
	?> <script src="https://epink.health/js/booking.js"></script>