<header class="  bgsecondary ">
	<div class="container client ">
		<center>
				<div class="mb-10">
				<br>
				<br>
					<h1 class="text-center text-light " style="font-size: 30px; font-weight: bolder;">Consult With Healthcare Personnel</h1>
				</div>
				<div id="navbar-example2" class="carousel-client" style="width: 100% !important">
					<div class="slide" onmousedown="scrolltoDiv(1)">
						<img id="pictone" src="https://epink.health/img/otherconsult/1.png">
					</div>
					<div class="slide" onmousedown="scrolltoDiv(2)">
						<img src="https://epink.health/img/otherconsult/2.png">
					</div>
					<div class="slide" onmousedown="scrolltoDiv(3)">
						<img src="https://epink.health/img/otherconsult/3.png">
					</div>
					<div class="slide" onmousedown="scrolltoDiv(4)">
						<img src="https://epink.health/img/otherconsult/4.png">
					</div>
					<div class="slide" onmousedown="scrolltoDiv(5)">
						<img src="https://epink.health/img/otherconsult/5.png">
					</div>
					<div class="slide" onmousedown="scrolltoDiv(6)">
						<img src="https://epink.health/img/otherconsult/6.png">
					</div>
					<div class="slide" onmousedown="scrolltoDiv(7)">
						<img src="https://epink.health/img/otherconsult/7.png">
					</div>
					<div class="slide" onmousedown="scrolltoDiv(8)">
						<img src="https://epink.health/img/otherconsult/8.png">
					</div>
					<div class="slide" onmousedown="scrolltoDiv(9)">
						<img src="https://epink.health/img/otherconsult/9.png">
					</div>
					<div class="slide" onmousedown="scrolltoDiv(10)">
						<img src="https://epink.health/img/otherconsult/10.png">
					</div>
					<div class="slide" onmousedown="scrolltoDiv(11)">
						<img src="https://epink.health/img/otherconsult/11.png">
					</div>
					<div class="slide" onmousedown="scrolltoDiv(12)">
						<img src="https://epink.health/img/otherconsult/12.png">
					</div>
				</div>
				<br>
				<br>
		</center>
	</div>
</header>
<script>
	jQuery.event.special.touchstart = {
	  setup: function( _, ns, handle ){
	    if ( ns.includes("noPreventDefault") ) {
	      this.addEventListener("touchstart", handle, { passive: false });
	    } else {
	      this.addEventListener("touchstart", handle, { passive: true });
	    }
	  }
	};
		$('.carousel-client').bxSlider({
			auto: true,
		    slideWidth: 280,
		    minSlides: 2,
		    maxSlides: 5,
		    controls: false
		});
		
		
		function scrolltoDiv(id) {
			if(id == 1){
				var elemX = document.getElementById("pageone");
				elemX.scrollIntoView();
			}else if(id == 2){
				var elemX = document.getElementById("pagetwo");
				elemX.scrollIntoView();					
			}else if(id == 3){
				var elemX = document.getElementById("pagethree");
				elemX.scrollIntoView();					
			}else if(id == 4){
				var elemX = document.getElementById("pageone");
				elemX.scrollIntoView();					
			}else if(id == 5){
				var elemX = document.getElementById("pagefive");
				elemX.scrollIntoView();					
			}else if(id == 6){
				var elemX = document.getElementById("pagesix");
				elemX.scrollIntoView();					
			}else if(id == 7){
				var elemX = document.getElementById("pageseven");
				elemX.scrollIntoView();					
			}else if(id == 8){
				var elemX = document.getElementById("pageeight");
				elemX.scrollIntoView();					
			}else if(id == 9){
				var elemX = document.getElementById("pagenine");
				elemX.scrollIntoView();					
			}else if(id == 10){
				var elemX = document.getElementById("pageten");
				elemX.scrollIntoView();					
			}else if(id == 11){
				var elemX = document.getElementById("pageeleven");
				elemX.scrollIntoView();					
			}else if(id == 12){
				var elemX = document.getElementById("pagetwelve");
				elemX.scrollIntoView();					
			}       
	    }
</script>
<div id="pageone" class="py-10" style="background-color: white;">
	<div class="container">
		<h1 class="epink-text-primary"><strong>Mental Wellness</strong></h1>
		<p><small>Are you having this?</small></p>
		<div class="row ">
			<div class="col-lg-6 col-12">
				<video width="100%" controls>
				  <source src="https://epink.health/videos/mental wellness.mp4" type="video/mp4">
				  <source src="movie.ogg" type="video/ogg">
				Your browser does not support the video tag.
				</video>	
				<div id="">
				<p class="mb-3 mt-3"><strong>SERVICE</strong></p>
				<div class="badge rounded-pill epinkbglight epink-text-primary badge-marketing mb-3">Stress and Anxiety management</div>
				<div class="badge rounded-pill epinkbglight epink-text-primary badge-marketing mb-3"> Solution focussed therapy</div>
				<div class="badge rounded-pill epinkbglight epink-text-primary badge-marketing mb-3"> Cognitive Behavioral Therapy (CBT)</div>
				<div class="badge rounded-pill epinkbglight epink-text-primary badge-marketing mb-3">  Ecotherapy/ Nature Therapy</div>
			
			
				<div class="page-header-ui-text mt-2 text-xs font-italic">* Provided by our trained & licensed Psychologist</div>
				</div>
			</div>
			<div class="col-lg-1 col-12"></div>
			<div class="col-lg-5 col-12">
				<p class="mb-3 mt-3"><strong><span class="epink-text-primary">DON'T STRUGGLE IN SILENCE,<br>
					BOOK US NOW</span>
					</strong>
				</p>
				<p><small>Online Consultation</small></p>
				<p><small>Walk-In appointments</small></p>
				<p><small>House Call Services </small></p>
				<a class="me-3" href="#!"><img src="<?php echo $domain; ?>/landingasset/assets/img/app-badges/app-store-badge.svg" style="height: 3rem" /></a>
				<a href="#!"><img src="<?php echo $domain; ?>/landingasset/assets/img/app-badges/google-play-badge.svg" style="height: 3rem" /></a>
				&nbsp &nbsp 
				<div class="page-header-ui-text mt-2 text-xs font-italic">* Requires Android OS 4.3+ or Apple iOS 9.3+ </div>
				<a href="https://app.epink.health/?redirect=carenewpage"class="btn btn-teal fw-500 mt-5">USE WEBAPP</a>
				<div class="page-header-ui-text mt-2 text-xs font-italic">* Requires chromium based browser</div>			
			</div>
		</div>
	</div>
</div>
<div id="pageone" class="py-10" style="background-color: white;">
	<div class="container">
		<h1 class="epink-text-primary"><strong>Medication advice</strong></h1>
		<p><small>Do you need advice?</small></p>
		<div class="row ">
			<div class="col-lg-6 col-12">
				<video width="100%" controls>
				  <source src="https://epink.health/videos/medication advice.mp4" type="video/mp4">
				  <source src="movie.ogg" type="video/ogg">
				Your browser does not support the video tag.
				</video>	
				<div id="">
				<p class="mb-3 mt-3"><strong>SERVICES</strong></p>
				<div class="badge rounded-pill epinkbglight epink-text-primary badge-marketing mb-3">Medication  advice</div>
				<div class="badge rounded-pill epinkbglight epink-text-primary badge-marketing mb-3"> Track your side effects</div>
				<div class="badge rounded-pill epinkbglight epink-text-primary badge-marketing mb-3">Changing Medication</div>
				
			
			
				<div class="page-header-ui-text mt-2 text-xs font-italic">* Provided by our licensed pharmacist</div>
				</div>
			</div>
			<div class="col-lg-1 col-12"></div>
			<div class="col-lg-5 col-12">
				<p class="mb-3 mt-3"><strong><span class="epink-text-primary text-uppercase">Book us now for <br> medication guidance<br>
					</span>
					</strong>
				</p>
				<p><small>Online Consultation</small></p>
				<p><small>Walk-In appointments</small></p>
				<p><small>House Call Services </small></p>
				<a class="me-3" href="#!"><img src="<?php echo $domain; ?>/landingasset/assets/img/app-badges/app-store-badge.svg" style="height: 3rem" /></a>
				<a href="#!"><img src="<?php echo $domain; ?>/landingasset/assets/img/app-badges/google-play-badge.svg" style="height: 3rem" /></a>
				&nbsp &nbsp 
				<div class="page-header-ui-text mt-2 text-xs font-italic">* Requires Android OS 4.3+ or Apple iOS 9.3+ </div>
				<a href="https://app.epink.health/?redirect=carenewpage"class="btn btn-teal fw-500 mt-5" type="submit">USE WEBAPP</a>
				<div class="page-header-ui-text mt-2 text-xs font-italic">* Requires chromium based browser</div>			
			</div>
		</div>
	</div>
</div>
<div id="pageone" class="py-10" style="background-color: white;">
	<div class="container">
		<h1 class="epink-text-primary"><strong>Physical Wellness</strong></h1>
		<p><small>Have these problems?</small></p>
		<div class="row ">
			<div class="col-lg-6 col-12">
				<video width="100%" controls>
				  <source src="https://epink.health/videos/Physical wellness.mp4" type="video/mp4">
				  <source src="movie.ogg" type="video/ogg">
				Your browser does not support the video tag.
				</video>	
				<div id="">
				<p class="mb-3 mt-3"><strong>SERVICES</strong></p>
				<div class="badge rounded-pill epinkbglight epink-text-primary badge-marketing mb-3">Pain management</div>
				<div class="badge rounded-pill epinkbglight epink-text-primary badge-marketing mb-3"> Musculoskeletal Management</div>
				<div class="badge rounded-pill epinkbglight epink-text-primary badge-marketing mb-3">Neurological Rehabilitation</div>
				<div class="badge rounded-pill epinkbglight epink-text-primary badge-marketing mb-3">Occupational Therapy</div>
				<div class="badge rounded-pill epinkbglight epink-text-primary badge-marketing mb-3">Speech and Language Therapy</div>
				
			
			
				<div class="page-header-ui-text mt-2 text-xs font-italic">* Provided by our physiotherapist, occupational therapist and speech & language specialist</div>
				</div>
			</div>
			<div class="col-lg-1 col-12"></div>
			<div class="col-lg-5 col-12">
				<p class="mb-3 mt-3"><strong><span class="epink-text-primary text-uppercase">Book as per your choice and availability<br>
					</span>
					</strong>
				</p>
				<p><small>Online Consultation</small></p>
				<p><small>Walk-In appointments</small></p>
				<p><small>House Call Services </small></p>
				<a class="me-3" href="#!"><img src="<?php echo $domain; ?>/landingasset/assets/img/app-badges/app-store-badge.svg" style="height: 3rem" /></a>
				<a href="#!"><img src="<?php echo $domain; ?>/landingasset/assets/img/app-badges/google-play-badge.svg" style="height: 3rem" /></a>
				&nbsp &nbsp 
				<div class="page-header-ui-text mt-2 text-xs font-italic">* Requires Android OS 4.3+ or Apple iOS 9.3+ </div>
				<a href="https://app.epink.health/?redirect=carenewpage"class="btn btn-teal fw-500 mt-5" type="submit">USE WEBAPP</a>
				<div class="page-header-ui-text mt-2 text-xs font-italic">* Requires chromium based browser</div>			
			</div>
		</div>
	</div>
</div>
<div id="pageone" class="py-10" style="background-color: white;">
	<div class="container">
		<h1 class="epink-text-primary"><strong>Wound Care</strong></h1>
		<p><small>Have these problems?</small></p>
		<div class="row ">
			<div class="col-lg-6 col-12">
				<video width="100%" controls>
				  <source src="https://epink.health/videos/wound care.mp4" type="video/mp4">
				  <source src="movie.ogg" type="video/ogg">
				Your browser does not support the video tag.
				</video>	
				<div id="">
				<p class="mb-3 mt-3"><strong>SERVICES</strong></p>
				<div class="badge rounded-pill epinkbglight epink-text-primary badge-marketing mb-3">Simple Wound Dressing at Home</div>
				<div class="badge rounded-pill epinkbglight epink-text-primary badge-marketing mb-3"> Complex Wound Dressing</div>
				<div class="badge rounded-pill epinkbglight epink-text-primary badge-marketing mb-3">Krub Bandaging</div>
				<div class="badge rounded-pill epinkbglight epink-text-primary badge-marketing mb-3">Suture Removal</div>
				<div class="badge rounded-pill epinkbglight epink-text-primary badge-marketing mb-3">Increase Wound Healing</div>
				<div class="badge rounded-pill epinkbglight epink-text-primary badge-marketing mb-3">Follow up on Wound Condition</div>
				
			
			
				<div class="page-header-ui-text mt-2 text-xs font-italic">*  Provided by our certified doctors and nurses</div>
				</div>
			</div>
			<div class="col-lg-1 col-12"></div>
			<div class="col-lg-5 col-12">
				<p class="mb-3 mt-3"><strong><span class="epink-text-primary text-uppercase">Book as per your choice and availability<br>
					</span>
					</strong>
				</p>
				<p><small>Schedule a walk-in appointment</small></p>
				<p><small>Schedule our house call service</small></p>
				<p><small>Don’t have time? Book our: Online Consultation and Management</small></p>
				<a class="me-3" href="#!"><img src="<?php echo $domain; ?>/landingasset/assets/img/app-badges/app-store-badge.svg" style="height: 3rem" /></a>
				<a href="#!"><img src="<?php echo $domain; ?>/landingasset/assets/img/app-badges/google-play-badge.svg" style="height: 3rem" /></a>
				&nbsp &nbsp 
				<div class="page-header-ui-text mt-2 text-xs font-italic">* Requires Android OS 4.3+ or Apple iOS 9.3+ </div>
				<a href="https://app.epink.health/?redirect=carenewpage"class="btn btn-teal fw-500 mt-5" type="submit">USE WEBAPP</a>
				<div class="page-header-ui-text mt-2 text-xs font-italic">* Requires chromium based browser</div>			
			</div>
		</div>
	</div>
</div>
<div id="pageone" class="py-10" style="background-color: white;">
	<div class="container">
		<h1 class="epink-text-primary"><strong>Body Wellness</strong></h1>
		<p><small>Want to tackle these?</small></p>
		<div class="row ">
			<div class="col-lg-6 col-12">
				<video width="100%" controls>
				  <source src="https://epink.health/videos/body wellness.mp4" type="video/mp4">
				  <source src="movie.ogg" type="video/ogg">
				Your browser does not support the video tag.
				</video>	
				<div id="">
				<p class="mb-3 mt-3"><strong>SERVICES</strong></p>
				<div class="badge rounded-pill epinkbglight epink-text-primary badge-marketing mb-3">Personal Gym Coach</div>
				<div class="badge rounded-pill epinkbglight epink-text-primary badge-marketing mb-3">Zumba and Yoga Trainer</div>
				<div class="badge rounded-pill epinkbglight epink-text-primary badge-marketing mb-3">Nutrition Prescription</div>
				<div class="badge rounded-pill epinkbglight epink-text-primary badge-marketing mb-3">Diet Plan</div>
				
			
			
				<div class="page-header-ui-text mt-2 text-xs font-italic">*  Provided by our certified dietician, nutritionist and certified wellness coaches</div>
				</div>
			</div>
			<div class="col-lg-1 col-12"></div>
			<div class="col-lg-5 col-12">
				<p class="mb-3 mt-3"><strong><span class="epink-text-primary text-uppercase">Book as per your choice and availability<br>
					</span>
					</strong>
				</p>
				<p><small>Schedule a walk-in appointment</small></p>
				<p><small>Schedule our house call service</small></p>
				<p><small>Don’t have time? Book our: Online Consultation and Management</small></p>
				<a class="me-3" href="#!"><img src="<?php echo $domain; ?>/landingasset/assets/img/app-badges/app-store-badge.svg" style="height: 3rem" /></a>
				<a href="#!"><img src="<?php echo $domain; ?>/landingasset/assets/img/app-badges/google-play-badge.svg" style="height: 3rem" /></a>
				&nbsp &nbsp 
				<div class="page-header-ui-text mt-2 text-xs font-italic">* Requires Android OS 4.3+ or Apple iOS 9.3+ </div>
				<a href="https://app.epink.health/?redirect=carenewpage"class="btn btn-teal fw-500 mt-5" type="submit">USE WEBAPP</a>
				<div class="page-header-ui-text mt-2 text-xs font-italic">* Requires chromium based browser</div>			
			</div>
		</div>
	</div>
</div>

