<?php
include("config.php"); 
if($page_identifier == "" || $page_identifier == "home"){
		$pagetitle = 'Homepage';
		include("views/landing/header.php");
		include("views/landing/nav.php");
		include("views/landing/base.php");
		include("views/landing/appdownload.php");
		include("views/landing/footer.php");
}elseif($page_identifier == "insight"){
	if($page_identifier_action == "read"){
		$pagetitle = 'Read Article';
		include("views/landing/header.php");
		include("views/landing/nav.php");
		include("views/landing/blog-read.php");
		include("views/landing/appdownload.php");	
		include("views/landing/footer.php");
	}else{
		$pagetitle = 'Insight';
		include("views/landing/header.php");
		include("views/landing/nav.php");
		include("views/landing/blogs.php");
		include("views/landing/appdownload.php");	
		include("views/landing/footer.php");
	}
}elseif($page_identifier == "pharmacist-panel"){
	$pagetitle = 'Pharmacist Panel';
	include("pharmacy.php");
}elseif($page_identifier == "corporate"){
		$pagetitle = 'Corporate Partner';
		include("corporate.php");
}elseif($page_identifier == "healthcare-provider"){
	if(isset($page_identifier_action) != true){
		$page_identifier_action = "";
	}
	if($page_identifier_action == ""){
		$pagetitle = 'Healthcare Provider';
		include("views/landing/header.php");
		include("views/landing/nav.php");
		include("views/landing/service-provider.php");
		include("views/landing/appdownload.php");
		include("views/landing/footer.php");
	}else{
		$pagetitle = 'Healthcare Provider';
		include("views/landing/header.php");
		include("views/landing/nav.php");
		include("views/landing/service-provider-profile.php");
		include("views/landing/appdownload.php");
		include("views/landing/footer.php");
	}
}elseif($page_identifier == "featured"){
	if(isset($page_identifier_action) != true){
		$page_identifier_action = "";
	}
	if($page_identifier_action == ""){
		$pagetitle = 'Healthcare Provider';
		include("views/landing/header.php");
		include("views/landing/nav.php");
		include("views/landing/appdownload.php");
		include("views/landing/footer.php");
	}elseif($page_identifier_action == "consult-a-doctor"){
		$pagetitle = 'Healthcare Provider';
		include("views/landing/header.php");
		include("views/landing/nav.php");
		include("views/landing/featured-consultadoctor.php");
		include("views/landing/appdownload.php");
		include("views/landing/footer.php");
	}elseif($page_identifier_action == "consult-with-healthcare-personnel"){
		$pagetitle = 'Healthcare Provider';
		include("views/landing/header.php");
		include("views/landing/nav.php");
		include("views/landing/featured-consult-with-healthcare-personnel.php");
		include("views/landing/appdownload.php");
		include("views/landing/footer.php");
	}elseif($page_identifier_action == "corporate-wellness"){
		$pagetitle = 'Corporate Wellness';
		include("views/landing/header.php");
		include("views/landing/nav.php");
		include("views/landing/featured-corporate-wellness.php");
		include("views/landing/appdownload.php");
		include("views/landing/footer.php");
	}elseif($page_identifier_action == "health-screening"){
		$pagetitle = 'Health Screening';
		include("views/landing/header.php");
		include("views/landing/nav.php");
		include("views/landing/featured-health-screening.php");
		include("views/landing/appdownload.php");
		include("views/landing/footer.php");
	}
}elseif($page_identifier == "covid-19-management"){
	if(isset($page_identifier_action) != true){
		$page_identifier_action = "";
	}
	if($page_identifier_action == ""){
		$pagetitle = 'Healthcare Provider';
		include("views/landing/header.php");
		include("views/landing/nav.php");
		include("views/landing/covid-19-management.php");
		include("views/landing/appdownload.php");
		include("views/landing/footer.php");
	}elseif($page_identifier_action == "home-covid-19-test"){
		$pagetitle = 'COVID-19 Test';
		include("views/landing/header.php");
		include("views/landing/nav.php");
		include("views/landing/covid19management-home-test.php");
		include("views/landing/appdownload.php");
		include("views/landing/footer.php");
	}elseif($page_identifier_action == "covid-19-vaccination"){
		$pagetitle = 'COVID-19 Vaccination';
		include("views/landing/header.php");
		include("views/landing/nav.php");
		include("views/landing/covid19management-vaccination.php");
		include("views/landing/appdownload.php");
		include("views/landing/footer.php");
	}elseif($page_identifier_action == "post-vaccination-antibody-test"){
		$pagetitle = 'COVID-19 Post vaccination antibody test';
		include("views/landing/header.php");
		include("views/landing/nav.php");
		include("views/landing/covid19management-post-vaccination-antibody-test.php");
		include("views/landing/appdownload.php");
		include("views/landing/footer.php");
	}elseif($page_identifier_action == "post-covid-screening-and-rehabilitation"){
		$pagetitle = 'COVID-19 Post Covid Screening And Rehabilitation';
		include("views/landing/header.php");
		include("views/landing/nav.php");
		include("views/landing/covid19management-post-covid-screening-and-rehabilitation.php");
		include("views/landing/appdownload.php");
		include("views/landing/footer.php");
	}elseif($page_identifier_action == "quarantine-services"){
		$pagetitle = 'COVID-19 Quarantine Services';
		include("views/landing/header.php");
		include("views/landing/nav.php");
		include("views/landing/covid19management-quarantine-services.php");
		include("views/landing/appdownload.php");
		include("views/landing/footer.php");
	}
}elseif($page_identifier == "privacy"){
		$pagetitle = 'Privacy Policy';
		include("views/landing/header.php");
		include("views/landing/nav.php");
		include("views/landing/privacy.php");
		include("views/landing/footer.php");
}elseif($page_identifier == "tele-medicine-consent"){
		$pagetitle = 'Tele-medicine Consent';
		if($page_identifier_action == ""){
		include("views/landing/header.php");
		include("views/landing/nav.php");
		include("views/landing/telemedicineconsent.php");
		include("views/landing/footer.php");
		}else{
			include("views/landing/pdfgenerator.php");
		}
}elseif($page_identifier == "gig-form"){
		$pagetitle = 'Flood Victim Health Care Service';
		include("views/landing/header.php");
		include("views/landing/nav.php");
		include("views/landing/gig_form.php");
		include("views/landing/footer.php");
}elseif($page_identifier == "privacy"){
		$pagetitle = 'Privacy Policy';
		include("views/landing/header.php");
		include("views/landing/nav.php");
		include("views/landing/privacy.php");
		include("views/landing/footer.php");
}elseif($page_identifier == "home-care"){
		$pagetitle = 'Home Care';
		include("views/landing/bookingprocess.php");
		include("views/landing/home-care.php");
		include("views/landing/nav.php");
		include("views/landing/covid-19-bookingform.php");
		include("views/landing/footer.php");
}elseif($page_identifier == "booking"){
		$pagetitle = 'Book Our Services';
		include("views/landing/bookingprocess.php");
		include("views/landing/header.php");
		include("views/landing/nav.php");
		include("views/landing/covid-19-bookingform.php");
		include("views/landing/footer.php");
}elseif($page_identifier == "loop"){
	for ($x = 1; $x <= 21; $x++) {
		echo '
			<div class="slide">
				<img src="https://epink.health/img/partners/logo ('.$x.').png">
			</div>
		';
	}
		
}elseif($page_identifier == "career"){
		$pagetitle = 'Privacy Policy';
		include("views/landing/header.php");
		include("views/landing/nav.php");
		include("views/landing/carreer.php");
		include("views/landing/footer.php");
}elseif($page_identifier == "homedesign"){
		$pagetitle = 'homedesign';
		include("views/landing/header.php");
		include("views/landing/nav.php");
		include("views/landing/homedesign.php");
		include("views/landing/appdownload.php");
		include("views/landing/footer.php");
}elseif($page_identifier == "terms-and-conditions"){
		$pagetitle = 'Term & Conditions';
		include("views/landing/header.php");
		include("views/landing/nav.php");
		include("views/landing/tnc.php");
		include("views/landing/footer.php");
}elseif($page_identifier == "health-screening"){
		$pagetitle = 'Health Screening';
		include("views/landing/header.php");
		include("views/landing/nav.php");
		include("views/landing/footer.php");
}elseif($page_identifier == "healthcare-services"){
	$pagetitle = 'Healthcare Services';
	if(isset($page_identifier_action) != true){
		$page_identifier_action = "";
	}
	if($page_identifier_action == ""){
		$pagetitle = 'Healthcare Services';
		include("views/landing/header.php");
		include("views/landing/nav.php");
		include("views/landing/services.php");
		include("views/landing/appdownload.php");
		include("views/landing/footer.php");
	}else{
		include("views/landing/header.php");
		include("views/landing/nav.php");
		include("views/landing/service-detail.php");
		include("views/landing/appdownload.php");	
		include("views/landing/footer.php");
	}
}elseif($page_identifier == "login"){
		include("process/login-processor.php");
		$pagetitle = 'Term & Conditions';
		include("views/landing/header.php");
		include("views/landing/nav.php");
		include("views/landing/login.php");
		include("views/landing/footer.php");
}elseif($page_identifier == "dashboard"){
		include("process/session-processor.php");
		$pagetitle = 'Dashboard';
		include("views/users/header.php");
		include("views/users/nav.php");
		include("views/users/base.php");
		include("views/users/footer.php");
}elseif($page_identifier == "tech"){
		$pagetitle = 'Dashboard';
		include("views/landing/header.php");
		include("views/landing/nav.php");
		include("views/landing/tech.php");
		include("views/landing/appdownload.php");	
		include("views/landing/footer.php");
}elseif($page_identifier == "e-pharmacy"){
		$pagetitle = 'Medical Consumables';
		if($page_identifier_action == ""){
			$pagetitle = 'ePharmacy';
			include("views/landing/header.php");
			include("views/landing/nav.php");
			include("views/landing/medical-consumables.php");
			include("views/landing/appdownload.php");	
			include("views/landing/footer.php");
		}else{
			$pagetitle = 'Product Info';
			include("views/landing/header.php");
			include("views/landing/nav.php");
			include("views/landing/productinfo.php");
			include("views/landing/appdownload.php");				
			include("views/landing/footer.php");
		}
		
}elseif($page_identifier == "outreach"){
		$pagetitle = 'Outreach Program';
		if($page_identifier_action == ""){
			include("views/landing/header.php");
			include("views/landing/nav.php");
			include("views/landing/outreach.php");
			include("views/landing/appdownload.php");	
			include("views/landing/footer.php");
		}elseif($page_identifier_action == "individual"){
			$pagetitle = 'Product Info';
			include("views/landing/header.php");
			include("views/landing/nav.php");
			include("views/landing/promo-vaccine.php");	
			include("views/landing/appdownload.php");				
			include("views/landing/footer.php");
		}elseif($page_identifier_action == "corporate-ngo"){
				$pagetitle = 'Outreach Program - Corporate / NGO';
			include("views/landing/header.php");
			include("views/landing/nav.php");
			include("views/landing/promo-vaccine-outreach.php");	
			include("views/landing/appdownload.php");				
			include("views/landing/footer.php");
		}elseif($page_identifier_action == "volunteers"){
				$pagetitle = 'Outreach Program - Volunters';
			include("views/landing/header.php");
			include("views/landing/nav.php");
			include("views/landing/volunteer-registeration.php");	
			include("views/landing/appdownload.php");				
			include("views/landing/footer.php");
		}elseif($page_identifier_action == "volunteers-slot"){
			$pagetitle = 'Outreach Program Slot';
			include("views/landing/header.php");
			include("views/landing/nav.php");
			include("views/landing/volunteer-slot.php");	
			include("views/landing/appdownload.php");				
			include("views/landing/footer.php");
		}
		
}elseif($page_identifier == "about-us"){
		$pagetitle = 'About Us';
		$pagedescription ='About ePink Health';
		include("views/landing/header.php");
		include("views/landing/nav.php");
		include("views/landing/about-us.php");
		include("views/landing/appdownload.php");	
		include("views/landing/footer.php");
}elseif($page_identifier == "zumba"){
		$pagetitle = 'Zumba';
		$pagedescription ='About ePink Health';
		include("views/landing/header.php");
		include("views/landing/nav.php");
		include("views/landing/zumba.php");
		include("views/landing/appdownload.php");	
		include("views/landing/footer.php");
}elseif($page_identifier == "digital-marketing"){
		$pagetitle = 'Medical Consumables';
		include("views/landing/header.php");
		include("views/landing/nav.php");
		include("views/landing/coming-soon.php");	
		include("views/landing/footer.php");
}elseif($page_identifier == "frequently-asked-question"){
		$pagetitle = 'Frequently Asked Question';
		include("views/landing/header.php");
		include("views/landing/nav.php");
		include("views/landing/frequently-asked-question.php");	
		include("views/landing/appdownload.php");
		include("views/landing/footer.php");
}elseif($page_identifier == "pwa"){
		$pagetitle = 'Test';
		include("views/landing/header.php");
		include("views/landing/nav.php");
		include("views/landing/pwa.php");	
		include("views/landing/footer.php");
}elseif($page_identifier == "genset"){
		$pagetitle = 'Test';
		include("views/landing/header.php");
		include("views/landing/nav.php");
		include("views/landing/genset.php");	
		include("views/landing/footer.php");
}elseif($page_identifier == "settlement"){
		$pagetitle = 'Test';
		include("views/landing/header.php");
		include("views/landing/nav.php");
		include("views/landing/settlement.php");	
		include("views/landing/footer.php");
}elseif($page_identifier == "covid-19-mobile-vaccination-outreach"){
		$pagetitle = 'COVID-19 Vaccination Outreach Program';
		include("views/landing/header.php");
		include("views/landing/nav.php");
		include("views/landing/promo-vaccine.php");	
		include("views/landing/footer.php");
}elseif($page_identifier == "adminmaker"){
		$pagetitle = 'adminmaker';
		include("views/landing/header.php");
		include("views/landing/nav.php");
		include("views/landing/adminmaker.php");	
		include("views/landing/footer.php");
}elseif($page_identifier == "volunter-registeration"){
		$pagetitle = 'Volunter Registeration';
		include("views/landing/header.php");
		include("views/landing/nav.php");
		include("views/landing/volunteer-registeration.php");	
		include("views/landing/footer.php");
}elseif($page_identifier == "volunter-registeration"){
		$pagetitle = 'Volunter Registeration';
		include("views/landing/header.php");
		include("views/landing/nav.php");
		include("views/landing/volunteer-registeration.php");	
		include("views/landing/footer.php");
}elseif($page_identifier == "pharmacy-panel"){
		include("pharmacy.php");
}elseif($page_identifier == "covid-19-vaccination-consent"){
	if($page_identifier_action == ""){
		$pagetitle = 'COVID-19 VACCINATION CONSENT FORM';
		include("views/landing/header.php");
		include("views/landing/nav.php");
		include("views/landing/covid-19-vaccination-consent-form.php");	
		include("views/landing/footer.php");
	}else{
		include("views/landing/pdfgenerator.php");
	}
}elseif($page_identifier == "recovery"){
		$pagetitle = 'Account Recovery';
		include("views/landing/header.php");
		include("views/landing/nav.php");
		include("views/recovery.php");	
		include("views/landing/footer.php");
}elseif($page_identifier == "ioupay"){
		include("ioupay.php");	
}elseif($page_identifier == "master-category"){
		$pagetitle = 'Account Recovery';
		include("views/landing/header.php");
		include("views/landing/nav.php");
		include("views/master-category.php");	
		include("views/landing/footer.php");
}elseif($page_identifier == "inhouse-provider"){
		$pagetitle = 'Account Recovery';
		include("views/landing/header.php");
		include("views/landing/nav.php");
		include("views/inhouse-provider.php");	
		include("views/landing/footer.php");
}elseif($page_identifier == "rest"){
		$pagetitle = 'restdata';
		include('rest.php');
}elseif($page_identifier == "payment-processor"){ 
		//$pagetitle = 'Processing Payment';
		include("views/landing/paymentprocessor.php");	
}elseif($page_identifier == "prescription"){

	include("views/landing/prescription.php");
	
	 
}elseif($page_identifier == "referdoc"){

	include("views/landing/referto.php");
	
	 
}elseif($page_identifier == "clinicalnote"){

	include("views/landing/clinicalnote.php");
	
	 
}elseif($page_identifier == "mc"){

	include("views/mc.php");
	
	 
}elseif($page_identifier == "mcs"){

	include("views/mcs.php");
	
	 
}elseif($page_identifier == "certs"){

	include("views/cert.php");
	
	 
}elseif($page_identifier == "invoice"){

	include("invoice.php");
	
	 
}elseif($page_identifier == "delyvahook"){

	include("delyvahook.php");
	
	 
}elseif($page_identifier == "delyvacreated"){

	include("delyvahook.php");
	
	 
}elseif($page_identifier == "delyvafailed"){

	include("delyvafailed.php");
	
	 
}elseif($page_identifier == "delyvatracking"){

	include("delyvatracking.php");
	
	 
}elseif($page_identifier == "delyvaupdate"){

	include("delyvaupdate.php");
	
	 
}elseif($page_identifier == "auth-verification"){
	$pagetitle = 'Verification';
	include("views/landing/header.php");
	include("views/landing/nav.php");
	include("views/auth-verification.php");	
	include("views/landing/footer.php");
}elseif($page_identifier == "tracking"){
	$data = '{
  "companyId": "77e8372a-fc30-4f3e-8692-ae8380c87ce9",
  "orderId": "77e8372a-fc30-4f3e-8692-ae8380c87ce9",
  "customerId": 32,
  "userId": "33aee880-003c-11ea-b96b-d53dda460f07",
  "consignmentNo": "000002009ASD",
  "statusCode": 400,
  "statusText": "In transit",
  "description": "In-transit by personnel",
  "location": "-",
  "driverId": 126,
  "taskId": 2149,
  "createdAt": "2021-01-11T16:10:48.237Z",
  "id": 2641,
  "coord": {
    "lon": 101.7381374,
    "lat": 3.1401939
  },
  "personnel": {
    "name": "Suhaimi Pic1",
    "phone": "60137778595",
    "vehicleName": "-",
    "vehicleType": "-",
    "vehicleRegNo": "-"
  },
  "arrival": {
    "distance": {
      "value": 2232,
      "unit": "m"
    },
    "duration": {
      "value": 286,
      "unit": "s"
    },
    "accuracy": 1
  },
  "invoiceId": null
}';
	$dat = json_decode($data, true);
	//var_dump($dat);
	$delyva_order_id = $dat["orderId"];
	$statusCode = $dat["statusCode"];
	$sql = "SELECT * FROM job_order WHERE delyva_order_id='$delyva_order_id'";
	$result = $db->query($sql);
	if ($result->num_rows > 0){
		$row = $result->fetch_assoc();
		if($statusCode == "100"){
			$order_status = "Order created. Cust. account charged";
		}
		if($statusCode == "100"){
			$order_status = "Order created. Cust. account charged";
		}
		if($statusCode == "400"){
			$order_status = "Pick up in progress";
		}
		if($statusCode == "450"){
			$order_status = "Arrived to pick up address";
		}
		if($statusCode == "475"){
			$order_status = "Fail to pick up";
		}
		if($statusCode == "500"){
			$order_status = "Order picked up";
		}
		if($statusCode == "600"){
			$order_status = "Delivery start";
		}
		if($statusCode == "625"){
			$order_status = "Arrived for deliver";
		}
		if($statusCode == "650"){
			$order_status = "Failed to deliver";
		}
		if($statusCode == "661"){
			$order_status = "Returning to sender";
		}
		if($statusCode == "663"){
			$order_status = "Failed to return";
		}
		if($statusCode == "700"){
			$order_status = "Item Delivered";
		}
		if($statusCode == "701"){
			$order_status = "Item Returned";
		}
		if($statusCode == "654"){
			$order_status = "Failed - Driver cancel";
		}
		if($statusCode == "655"){
			$order_status = "Failed (generic/reason)";
		}
		if($statusCode == "900"){
			$order_status = "Order Cancelled";
		}
		if($statusCode == "1000"){
			$order_status = "Order completed";
		}
		$sqlu = "UPDATE job_order SET delyva_order_status='$statusCode', order_status='$order_status' WHERE delyva_order_id='$delyva_order_id'";
		$db->query($sqlu);
	}
	//echo $dat["statusCode"];
	
	 
}elseif($page_identifier == "logout"){
	session_destroy();
	$pagetitle = 'Logout';
	include("views/landing/header.php");
	include("views/landing/nav.php");
	include("views/landing/logout.php");	
	include("views/landing/footer.php");
	
	 
}