<!-- Page Header-->
<header class="page-header-ui page-header-ui-dark bg-img-cover overlay overlay-80" style="background-image: url(https://epink.health/img/1-consult-a-doctor.png)">
	<div class="page-header-ui-content position-relative">
		<div class="container text-center">
			<div class="container">
				<div class="row gx-5">
					<div class="col-lg-8" data-aos="fade-right">
						<img class="z-3" src="https://epink.health/img/diagram.png" width="100%" />
					</div>
					<div class="col-lg-4 z-1 text-light" data-aos="fade-left">
						<div class="mb-5 mb-lg-0">
							<h1 class="text-light mt-5">Consult A Doctor</h1>
							<p class="text-light">Consult doctors on our platform</p>
							<a class="me-3" href="#!"><img src="<?php echo $domain; ?>/landingasset/assets/img/app-badges/app-store-badge.svg" style="height: 3rem" /></a>
							<a href="#!"><img src="<?php echo $domain; ?>/landingasset/assets/img/app-badges/google-play-badge.svg" style="height: 3rem" /></a>
							&nbsp &nbsp 
							<div class="page-header-ui-text mt-2 text-xs font-italic">* Requires Android OS 4.3+ or Apple iOS 9.3+ </div>
							<a href="https://app.epink.health/?redirect=mart"class="btn btn-teal fw-500 mt-5" type="submit" >USE WEBAPP</a>
							<div class="page-header-ui-text mt-2 text-xs font-italic">* Requires chromium based browser</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>
<script>
	function showPoints(id){
		if(id == 1){
			document.getElementById("pointone").style.display ="block";
		}
		if(id == 2){
			document.getElementById("pointtwo").style.display ="block";
		}			
		if(id == 3){
			document.getElementById("pointthree").style.display ="block";
		}		
		if(id == 4){
			document.getElementById("pointfour").style.display ="block";
		}		
		if(id == 5){
			document.getElementById("pointfive").style.display ="block";
		}
		if(id == 6){
			document.getElementById("pointsix").style.display ="block";
		}
		if(id == 7){
			document.getElementById("pointseven").style.display ="block";
		}			
		if(id == 8){
			document.getElementById("pointeight").style.display ="block";
		}	
		if(id == 9){
			document.getElementById("pointnine").style.display ="block";
		}	
		if(id == 10){
			document.getElementById("pointten").style.display ="block";
		}								
	}
	function closePoint(id){
		if(id == 1){
			document.getElementById("pointone").style.display ="none";
		}
		if(id == 2){
			document.getElementById("pointtwo").style.display ="none";
		}	
		if(id == 3){
			document.getElementById("pointthree").style.display ="none";
		}	
		if(id == 4){
			document.getElementById("pointfour").style.display ="none";
		}	
		if(id == 5){
			document.getElementById("pointfive").style.display ="none";
		}	
		if(id == 6){
			document.getElementById("pointsix").style.display ="none";
		}	
		if(id == 7){
			document.getElementById("pointseven").style.display ="none";
		}		
	if(id == 8){
			document.getElementById("pointeight").style.display ="none";
		}	
	if(id == 9){
			document.getElementById("pointnine").style.display ="none";
		}	
	if(id == 10){
			document.getElementById("pointten").style.display ="none";
		}								
	}
</script>
<section class="py-10">
	<div class="container px-5">
		<div class="row gx-5 justify-content-center">
			<div class="col-lg-6">
				<div class="mb-5 text-center">
					<div class="text-xs text-uppercase-expanded text-light mb-2" style="font-size: 40px">Condition for Tele-medicine</div>
					<p class="lead mb-0 text-light">Wide range of conditions suitable for telemedicine</p>
				</div>
			</div>
		</div>
		<div class="row gx-5 justify-content-center">
			<div class="col-md-6 col-lg-4 col-xl-3 mb-5">
				<a class="card lift" href="#!" onmouseover="showPoints(1)" onmouseout="closePoint(1)">
					<img class="card-img-top" src="https://epink.health/img/cadwhy/1-headaches-and-migraines.png" alt="..." />
					<div class="card-body text-center py-3">
						<h6 class="card-title mb-0">Headache & Migraines</h6>
						<div id="pointone" style="display: none">
							<br>
							<p>Vertigo</p>
							<p>Dizziness & giddiness</p>
							<p>Headaches & migraine</p>
							<p>Numbness & tingling</p>
						</div>
					</div>
				</a>
			</div>
			<div class="col-md-6 col-lg-4 col-xl-3 mb-5">
				<a class="card lift" href="#!" onmouseover="showPoints(2)" onmouseout="closePoint(2)">
					<img class="card-img-top" src="https://epink.health/img/cadwhy/2-eye-and-ear-discomfort.png" alt="..." />
					<div class="card-body text-center py-3">
						<h6 class="card-title mb-0">Eye and Ear Discomfort</h6>
						<div id="pointtwo" style="display: none">
							<br>
							<p>Red eye</p>
							<p>Conjunctivitis</p>
						</div>
					</div>
				</a>
			</div>
			<div class="col-md-6 col-lg-4 col-xl-3 mb-5">
				<a class="card lift" href="#!" onmouseover="showPoints(3)" onmouseout="closePoint(3)">
					<img class="card-img-top" src="https://epink.health/img/cadwhy/5-respiratory-tract-URTI.png" alt="..." />
					<div class="card-body text-center py-3">
						<h6 class="card-title mb-0">Respiratory Problems</h6>
						<div id="pointthree" style="display: none">
							<br>
							<p>Cough & sore throat</p>
							<p>Flue</p>
							<p>Pneumonia</p>
							<p>Asthma</p>
							<p>Fever</p>
						</div>
					</div>
				</a>
			</div>
			<div class="col-md-6 col-lg-4 col-xl-3 mb-5">
				<a class="card lift" href="#!" onmouseover="showPoints(4)" onmouseout="closePoint(4)">
					<img class="card-img-top" src="https://epink.health/img/cadwhy/4-pain.png" alt="..." />
					<div class="card-body text-center py-3">
						<h6 class="card-title mb-0">Pain</h6>
						<div id="pointfour" style="display: none">
							<br>
							<p>Gout</p>
							<p>Muscle aches & strains</p>
						</div>
					</div>
				</a>
			</div>
			<div class="col-md-6 col-lg-4 col-xl-3 mb-5">
				<a class="card lift" href="#!" onmouseover="showPoints(5)" onmouseout="closePoint(5)">
					<img class="card-img-top" src="https://epink.health/img/cadwhy/6-women-wellbeing.png" alt="..." />
					<div class="card-body text-center py-3">
						<h6 class="card-title mb-0">Women’s Wellbeing</h6>
						<div id="pointfive" style="display: none">
							<br>
							<p>Menstrual disorders</p>
							<p>Contraception (including emergency contraceptives)</p>
						</div>
					</div>
				</a>
			</div>
			<div class="col-md-6 col-lg-4 col-xl-3 mb-5">
				<a class="card lift" href="#!"  onmouseover="showPoints(7)" onmouseout="closePoint(7)">
					<img class="card-img-top" src="https://epink.health/img/cadwhy/7-skin-rashes.png" alt="..." />
					<div class="card-body text-center py-3">
						<h6 class="card-title mb-0">Skin Rashes</h6>
						<div id="pointseven" style="display: none">
							<br>
							<p>Acne</p>
							<p>Eczema</p>
							<p>Psoriasis</p>
							<p>Rashes & dermatitis</p>
						</div>
					</div>
				</a>
			</div>
			<div class="col-md-6 col-lg-4 col-xl-3 mb-5">
				<a class="card lift" href="#!" onmouseover="showPoints(6)" onmouseout="closePoint(6)">
					<img class="card-img-top" src="https://epink.health/img/cadwhy/9-specialist-referrals.png" alt="..." />
					<div class="card-body text-center py-3">
						<h6 class="card-title mb-0">Specialist Referrals</h6>
						<div id="pointsix" style="display: none">
							<br>
							<p>Referrals to specialists including cardiologists and urologists</p>
						</div>
					</div>
				</a>
			</div>
			<div class="col-md-6 col-lg-4 col-xl-3 mb-5">
				<a class="card lift" href="#!" onmouseover="showPoints(8)" onmouseout="closePoint(8)">
					<img class="card-img-top" src="https://epink.health/img/cadwhy/8-chronic-condition-follow-ups.png" alt="..." />
					<div class="card-body text-center py-3">
						<h6 class="card-title mb-0">Chronic Condition Follow Ups</h6>
						<div id="pointeight" style="display: none">
							<br>
							<p>Diabetes</p>
							<p>Hypertension</p>
							<p>High cholesterol</p>
							<p>Thyroid conditions</p>
						</div>
					</div>
				</a>
			</div>
			<div class="col-md-6 col-lg-4 col-xl-3 mb-5">
				<a class="card lift" href="#!" onmouseover="showPoints(9)" onmouseout="closePoint(9)">
					<img class="card-img-top" src="https://epink.health/img/cadwhy/3-gastrointestinal-tomach-discomfort.png" alt="..." />
					<div class="card-body text-center py-3">
						<h6 class="card-title mb-0">Gastrointestinal / Stomach Discomfort</h6>
						<div id="pointnine" style="display: none">
							<br>
							<p>Diarrhoea & loose stool</p>
							<p>Nausea & vomiting</p>
							<p>Abdominal pain & discomfort</p>
							<p>Constipation</p>
						</div>
					</div>
				</a>
			</div>
			<div class="col-md-6 col-lg-4 col-xl-3 mb-5">
				<a class="card lift" href="#!" onmouseover="showPoints(10)" onmouseout="closePoint(10)">
					<img class="card-img-top" src="https://epink.health/img/cadwhy/10-other-non-emergency-medical-needs.png" alt="..." />
					<div class="card-body text-center py-3">
						<h6 class="card-title mb-0">Other Non Emergency Medical Needs</h6>
						<div id="pointten" style="display: none">
							<br>
							<p>Have a question or medical need that does not require a physical visit by a doctor? Get advice online with a tele-consultation.</p>
						</div>
					</div>
				</a>
			</div>
		</div>
	</div>
</section>
<section class="mt-5 mb-5">
	<div class="container">
		<div class="row mt-10 mb-10">
			<div class="col-lg-2 col-12">
			</div>
			<div class="col-lg-4 col-12">
				<img class="img-fluid z-1" src="https://epink.health/img/apppreview.png">
			</div>
			<div class="col-lg-6 col-12">
				<br>
				<br>
				<br>
				<br>
				<p class="text-light font-weigth-bolder py-6" style="font-size: 40px">HOW IT WORK</p>
				<p class="text-light">
					<svg xmlns="http://www.w3.org/2000/svg" style="vertical-align: middle;" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download-cloud">
						<polyline points="8 17 12 21 16 17"></polyline>
						<line x1="12" y1="12" x2="12" y2="21"></line>
						<path d="M20.88 18.09A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.29"></path>
					</svg>
					&nbsp &nbsp 	 Download the ePink Health app or use ePink Health web app
				</p>
				<p class="text-light">
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-video">
						<polygon points="23 7 16 12 23 17 23 7"></polygon>
						<rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect>
					</svg>
					&nbsp &nbsp Make a request for tele-consultation (video call) 
				</p>
				<p class="text-light">
					<svg xmlns="http://www.w3.org/2000/svg" style="vertical-align: middle;" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-credit-card">
						<rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
						<line x1="1" y1="10" x2="23" y2="10"></line>
					</svg>
					&nbsp &nbsp Review the charges and complete the booking
				</p>
				<p class="text-light">
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
						<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
						<circle cx="12" cy="7" r="4"></circle>
					</svg>
					&nbsp &nbsp Talk to the doctor
				</p>
				<p class="text-light">
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-minus">
						<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
						<polyline points="14 2 14 8 20 8"></polyline>
						<line x1="9" y1="15" x2="15" y2="15"></line>
					</svg>
					&nbsp &nbsp Get prescription
				</p>
				<p class="text-light">
					<svg xmlns="http://www.w3.org/2000/svg" style="vertical-align: middle;"width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-archive">
						<polyline points="21 8 21 21 3 21 3 8"></polyline>
						<rect x="1" y="3" width="22" height="5"></rect>
						<line x1="10" y1="12" x2="14" y2="12"></line>
					</svg>
					&nbsp &nbsp	Have medication delivered to your doorstep
				</p>
			</div>
		</div>
	</div>
</section>
<section class="bg-white py-10">
	<div class="container px-5">
		<div class="accordion shadow mb-5" id="accordionAuth">
			<div class="accordion-item">
				<div class="d-flex align-items-center justify-content-between px-4 py-5">
					<div class="me-3">
						<h4 class="mb-0">FAQ</h4>
						<p class="card-text text-gray-500">Frequently Asked Question</p>
					</div>
				</div>
			</div>
			<script></script>
			<div class="accordion-item">
				<h5 class="accordion-header" id="headingOne"><button id="q1" onclick="changeColor(1)"  class="accordion-button p-4 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">1) Who are We?</button></h5>
				<div class="accordion-collapse collapse" id="collapseOne" aria-labelledby="headingOne" data-bs-parent="#accordionAuth">
					<div class="accordion-body p-4">e-Pink Health is a tele-medicine platform which offers personalized healthcare via an instant virtual consultation at the comfort of your own home. </div>
				</div>
			</div>
			<div class="accordion-item">
				<h5 class="accordion-header" id="headingTwo"><button class="accordion-button p-4 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">2) Who are the doctors in our ePink Health?</button></h5>
				<div class="accordion-collapse collapse" id="collapseTwo" aria-labelledby="headingTwo" data-bs-parent="#accordionAuth">
					<div class="accordion-body p-4">The doctors and experts in our ePink Health are experienced and well-accredited doctors by the Medical Council of Malaysia. We ensure our medical professionals have an incredible background and are committed to our patient’s trust and well-being at all times. We also provide detailed information on our application regarding our doctors, allowing our customers to do a background check and liaise with them pertaining to their medical concerns.</div>
				</div>
			</div>
			<div class="accordion-item">
				<h5 class="accordion-header" id="headingThree"><button class="accordion-button p-4 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">3) The advantage of virtual consultation?
					</button>
				</h5>
				<div class="accordion-collapse collapse" id="collapseThree" aria-labelledby="headingThree" data-bs-parent="#accordionAuth">
					<div class="accordion-body p-4">Through virtual consultation, our patients eliminate the necessities of having them leaving the house or be in a long queue to get a consultation. Everything is ready with a single click. If our doctor feels the need to have a physical consultation, our doctors will recommend  right away because there are obviously some limitations with virtual consultation. </div>
				</div>
			</div>
			<div class="accordion-item">
				<h5 class="accordion-header" id="headingThree"><button class="accordion-button p-4 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">4) Can I get MC from ePink Health?
					</button>
				</h5>
				<div class="accordion-collapse collapse" id="collapseFour" aria-labelledby="headingFour" data-bs-parent="#accordionAuth">
					<div class="accordion-body p-4">Absolutely Yes, but our online doctor will determine if an MC is clinically appropriate and prepare everything for you.
					</div>
				</div>
			</div>
			<div class="accordion-item">
				<h5 class="accordion-header" id="headingThree"><button class="accordion-button p-4 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">5) Is ePink Health available on mobile App?
					</button>
				</h5>
				<div class="accordion-collapse collapse" id="collapseFive" aria-labelledby="headingFive" data-bs-parent="#accordionAuth">
					<div class="accordion-body p-4">Yes! We have our platform on both website and on mobile application. 
					</div>
				</div>
			</div>
			<div class="accordion-item">
				<h5 class="accordion-header" id="headingThree"><button class="accordion-button p-4 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsesix" aria-expanded="false" aria-controls="collapsesix">6) How to get your prescription?
					</button>
				</h5>
				<div class="accordion-collapse collapse" id="collapsesix" aria-labelledby="headingsix" data-bs-parent="#accordionAuth">
					<div class="accordion-body p-4">After your consultation, our doctors will prescribe the respective medicines through an e-prescription where the medicine can be obtained from our partnering pharmacies.  Once your prescription is ready and approved, the payment can be made via online banking, credit or debit card or e-Wallets (Boost, GrabPay)
					</div>
				</div>
			</div>
			<div class="accordion-item">
				<h5 class="accordion-header" id="headingThree"><button class="accordion-button p-4 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">7) How fast we deliver your medication?
					</button>
				</h5>
				<div class="accordion-collapse collapse" id="collapseSeven" aria-labelledby="headingSeven" data-bs-parent="#accordionAuth">
					<div class="accordion-body p-4">At the moment, we are providing our delivery service within Klang Valley area, and we expect your medications to reach you within an hour. However, we are working towards the expansion of our service, so stay tuned for more updates. 
					</div>
				</div>
			</div>
			<div class="accordion-item">
				<h5 class="accordion-header" id="headingThree"><button class="accordion-button p-4 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">8) What are the operating hours for ePink Health?
					</button>
				</h5>
				<div class="accordion-collapse collapse" id="collapseEight" aria-labelledby="headingEight" data-bs-parent="#accordionAuth">
					<div class="accordion-body p-4">Our operating hours are from 8 am to 12 am, midnight everyday including Public Holidays.
					</div>
				</div>
			</div>
			<div class="accordion-item">
				<h5 class="accordion-header" id="headingThree"><button class="accordion-button p-4 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">9) How we reserve our patient’s confidentiality? 
					</button>
				</h5>
				<div class="accordion-collapse collapse" id="collapseNine" aria-labelledby="headingNine" data-bs-parent="#accordionAuth">
					<div class="accordion-body p-4">Our system operates under maximum privacy and all of our patient’s data are well-encrypted and will only be disclosed to the doctor of your choice. 
					</div>
				</div>
			</div>
			<div class="accordion-item">
				<h5 class="accordion-header" id="headingThree"><button class="accordion-button p-4 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen">10) What if a physical examination is needed?
					</button>
				</h5>
				<div class="accordion-collapse collapse" id="collapseTen" aria-labelledby="headingTen" data-bs-parent="#accordionAuth">
					<div class="accordion-body p-4">All our patient’s data and medical history are well-studied by our doctors before giving out a diagnosis. If there’s an examination needed, our doctor will reach you via house call or a referral letter to the nearest clinic or hospital will be provided.  
					</div>
				</div>
			</div>
		</div>
	</div>
</section>