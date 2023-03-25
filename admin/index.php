<?php
	include("config.php");
if($page_identifier == "" || $page_identifier == "dashboard"){
	include("controllers/session.php");
	include("views/header.php");
	include("views/navigation.php");
	include("views/dashboard.php");
	include("views/footer.php");
}elseif($page_identifier == "products"){
	$pagename = 'Product Manager';
	if($page_identifier_action == ""){
		include("controllers/session.php");
		include("views/header.php");
		include("views/navigation.php");
		include("views/productlist.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "delete"){
		include("views/header.php");
		include("views/navigation.php");
		include("views/elabrequestdelete.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "create"){
		include("views/header.php");
		include("views/navigation.php");
		include("views/postproduct.php");
		include("views/footer.php");
	}
}elseif($page_identifier == "finance"){
	include("controllers/session.php");
	$pagename = 'Finance';
	if($page_identifier_action == ""){
		include("views/header.php");
		include("views/navigation.php");
		include("views/finance.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "set-paid"){
		include("views/header.php");
		include("views/navigation.php");
		include("views/financeedit.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "create"){
		include("views/header.php");
		include("views/navigation.php");
		include("views/postproduct.php");
		include("views/footer.php");
	}
}elseif($page_identifier == "flood-victim-health-care"){
	$pagename = 'Flood Victim Health Care';
	if($page_identifier_action == ""){
		include("controllers/session.php");
		include("views/header.php");
		include("views/navigation.php");
		include("views/floodvictim.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "delete"){
		include("views/header.php");
		include("views/navigation.php");
		include("views/elabrequestdelete.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "create"){
		include("views/header.php");
		include("views/navigation.php");
		include("views/postproduct.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "view"){
		include("views/header.php");
		include("views/navigation.php");
		include("views/floodvictim-view.php");
		include("views/footer.php");
	}
}elseif($page_identifier == "zumba"){
	$pagename = 'Zumba';
	if($page_identifier_action == ""){
		include("controllers/session.php");
		include("views/header.php");
		include("views/navigation.php");
		include("views/zumba.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "delete"){
		include("views/header.php");
		include("views/navigation.php");
		include("views/elabrequestdelete.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "create"){
		include("views/header.php");
		include("views/navigation.php");
		include("views/postproduct.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "view"){
		include("views/header.php");
		include("views/navigation.php");
		include("views/floodvictim-view.php");
		include("views/footer.php");
	}
}elseif($page_identifier == "consent"){
	$pagename = 'Covid-19 Vaccination Consent';
	if($page_identifier_action == ""){
		include("controllers/session.php");
		include("views/header.php");
		include("views/navigation.php");
		include("views/c19consent-list.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "delete"){
		include("views/header.php");
		include("views/navigation.php");
		include("views/elabrequestdelete.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "create"){
		include("views/header.php");
		include("views/navigation.php");
		include("views/postproduct.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "view"){
		include("views/header.php");
		include("views/navigation.php");
		include("views/floodvictim-view.php");
		include("views/footer.php");
	}
}elseif($page_identifier == "blogs"){
	$pagename = 'Blog Manager';
	if($page_identifier_action == ""){
		include("controllers/session.php");
		include("views/header.php");
		include("views/navigation.php");
		include("views/bloglist.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "delete"){

		include("views/header.php");
		include("views/navigation.php");
		include("views/blogdelete.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "create"){
		include("views/header.php");
		include("views/navigation.php");
		include("views/post-blog.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "edit"){
		include("views/header.php");
		include("views/navigation.php");
		include("views/edit-blog.php");
		include("views/footer.php");
	}
}elseif($page_identifier == "mobile-vaccination"){
	include("controllers/session.php");
	$pagename = 'Mobile Vaccination';
	if($page_identifier_action == ""){
		include("views/header.php");
		include("views/navigation.php");
		include("views/mv-list.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "delete"){
		include("views/header.php");
		include("views/navigation.php");
		include("views/mv-delete.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "full"){
		include("views/header.php");
		include("views/navigation.php");
		include("views/mv-list-full.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "create"){
		include("views/header.php");
		include("views/navigation.php");
		include("views/post-blog.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "view"){
		include("views/header.php");
		include("views/navigation.php");
		include("views/mv-view.php");
		include("views/footer.php");
	}
}elseif($page_identifier == "volunteer-application"){
	$pagename = 'Volunteer Application';
	if($page_identifier_action == ""){
		include("controllers/session.php");
		include("views/header.php");
		include("views/navigation.php");
		include("views/va-list.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "delete"){

		include("views/header.php");
		include("views/navigation.php");
		include("views/va-delete.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "create"){

	}elseif($page_identifier_action == "view"){
		include("views/header.php");
		include("views/navigation.php");
		include("views/va-view.php");
		include("views/footer.php");
	}
}elseif($page_identifier == "mobile-vaccination-corporate"){
	$pagename = 'Mobile Vaccination';
	if($page_identifier_action == ""){
		include("controllers/session.php");
		include("views/header.php");
		include("views/navigation.php");
		include("views/mvc-list.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "delete"){

		include("views/header.php");
		include("views/navigation.php");
		include("views/mvc-delete.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "create"){
		include("views/header.php");
		include("views/navigation.php");
		include("views/post-blog.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "view"){
		include("views/header.php");
		include("views/navigation.php");
		include("views/mvc-view.php");
		include("views/footer.php");
	}
}elseif($page_identifier == "pharmacist-manager"){
	include("controllers/session.php");
	include("views/header.php");
	include("views/navigation.php");
	include("views/estmanage.php");
	include("views/footer.php");

}elseif($page_identifier == "pharmacist-manager"){
	include("controllers/session.php");
	include("views/header.php");
	include("views/navigation.php");
	include("views/estmanage.php");
	include("views/footer.php");

}elseif($page_identifier == "ecare-job-manager"){
	if($page_identifier_action == ""){
		include("controllers/session.php");
		include("views/header.php");
		include("views/navigation.php");
		include("views/ecare-job-manager.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "update"){
		include("controllers/session.php");
		include("views/header.php");
		include("views/navigation.php");
		include("views/ecare-job-manager-update.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "delete"){
		include("controllers/session.php");
		include("views/header.php");
		include("views/navigation.php");
		include("views/ecare-job-manager-delete.php");
		include("views/footer.php");
	}


}elseif($page_identifier == "booking-management"){

	if($page_identifier_action == ""){
		include("controllers/session.php");
		include("views/header.php");
		include("views/navigation.php");
		include("views/booking-management.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "update"){

		include("views/header.php");
		include("views/navigation.php");
		include("views/booking-management-update.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "create"){
		include("views/header.php");
		include("views/navigation.php");
		include("views/post-blog.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "delete"){
		include("views/header.php");
		include("views/navigation.php");
		include("views/booking-delete.php");
		include("views/footer.php");
	}else{
		include("views/header.php");
		include("views/navigation.php");
		include("views/viewbooking.php");
		include("views/footer.php");
	}
}elseif($page_identifier == "master-category"){
	include("controllers/session.php");
	include("views/header.php");
	include("views/navigation.php");
	include("views/master-category.php");
	include("views/footer.php");
}elseif($page_identifier == "inhouse-provider"){
	include("controllers/session.php");
	include("views/header.php");
	include("views/navigation.php");
	include("views/inhouse-provider.php");
	include("views/footer.php");
}elseif($page_identifier == "privacy-policy-manager"){
	include("controllers/session.php");
	include("views/header.php");
	include("views/navigation.php");
	include("views/privacypolicymanager.php");
	include("views/footer.php");

}elseif($page_identifier == "telemed"){
	include("controllers/session.php");
	include("views/header.php");
	include("views/navigation.php");
	include("views/telemedicineconsent.php");
	include("views/footer.php");

}elseif($page_identifier == "tnc-manager"){
	include("controllers/session.php");
	include("views/header.php");
	include("views/navigation.php");
	include("views/tncmanager.php");
	include("views/footer.php");
}elseif($page_identifier == "post-blog"){
	include("controllers/session.php");
	include("views/header.php");
	include("views/navigation.php");
	include("views/post-blog.php");
	include("views/footer.php");
}elseif($page_identifier == "sessions"){
	include("controllers/session.php");
	$pagename = 'Patients Sessions';
	if($page_identifier_action == ""){

		include("views/header.php");
		include("views/navigation.php");
		include("views/patientsessions.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "delete"){
		include("views/header.php");
		include("views/navigation.php");
		include("views/sessiondelete.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "view"){
		include("views/header.php");
		include("views/navigation.php");
		include("views/sessionviewer.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "update"){
		include("views/header.php");
		include("views/navigation.php");
		include("views/elabcreator.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "archive"){
		include("views/header.php");
		include("views/navigation.php");
		include("views/sessionarchive.php");
		include("views/footer.php");
	}
}elseif($page_identifier == "corporate-client"){
	$pagename = 'Corporate Client';
	if($page_identifier_action == ""){
		include("controllers/session.php");
		include("views/header.php");
		include("views/navigation.php");
		include("views/corperateclientlist.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "delete"){
		include("views/header.php");
		include("views/navigation.php");
		include("views/corprateclientdelete.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "create"){
		include("views/header.php");
		include("views/navigation.php");
		include("views/corprateclientcreate.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "update"){
		include("views/header.php");
		include("views/navigation.php");
		include("views/elabcreator.php");
		include("views/footer.php");
	}
}elseif($page_identifier == "elab-requests"){
	$pagename = 'E-Lab Request';
	if($page_identifier_action == ""){
		include("controllers/session.php");
		include("views/header.php");
		include("views/navigation.php");
		include("views/elabrequest.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "delete"){
		include("views/header.php");
		include("views/navigation.php");
		include("views/elabrequestdelete.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "update"){
		include("views/header.php");
		include("views/navigation.php");
		include("views/elabupdate.php");
		include("views/footer.php");
	}
}elseif($page_identifier == "ecare-manager"){
	include("controllers/session.php");
	$pagename = 'E-Care';
	if($page_identifier_action == ""){

		include("views/header.php");
		include("views/navigation.php");
		include("views/ecarelist.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "delete"){

		include("views/header.php");
		include("views/navigation.php");
		include("views/ecaredelete.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "create"){
		include("views/header.php");
		include("views/navigation.php");
		include("views/ecarecreate.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "edit"){
		include("views/header.php");
		include("views/navigation.php");
		include("views/ecaremanagereditor.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "category-manager"){
		include("views/header.php");
		include("views/navigation.php");
		include("views/ecarecategorymanager.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "sub-category-manager"){
		include("views/header.php");
		include("views/navigation.php");
		include("views/subecarecategorymanager.php");
		include("views/footer.php");
	}
}elseif($page_identifier == "promotions"){
	if($page_identifier_action == ""){
		include("controllers/session.php");
		include("views/header.php");
		include("views/navigation.php");
		include("views/promotionlisting.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "delete"){
		include("views/header.php");
		include("views/navigation.php");
		include("views/promotionsliderdelete.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "create"){
		include("views/header.php");
		include("views/navigation.php");
		include("views/promotionscreator.php");
		include("views/footer.php");
	}
}elseif($page_identifier == "elab"){
	include("controllers/session.php");
	$pagename = 'E-lab Service';
	if($page_identifier_action == ""){

		include("views/header.php");
		include("views/navigation.php");
		include("views/elabservices.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "delete"){
		include("views/header.php");
		include("views/navigation.php");
		include("views/elabdelete.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "create"){
		include("views/header.php");
		include("views/navigation.php");
		include("views/elabcreator.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "edit"){
		include("views/header.php");
		include("views/navigation.php");
		include("views/elabeditor.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "category-manager"){
		include("views/header.php");
		include("views/navigation.php");
		include("views/elabcategory.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "sub-category-manager"){
		include("views/header.php");
		include("views/navigation.php");
		include("views/elabsubcategory.php");
		include("views/footer.php");
	}
}elseif($page_identifier == "notify-user"){
	include("controllers/session.php");
	include("views/header.php");
	include("views/navigation.php");
	include("views/notifcationlist.php");
	include("views/footer.php");
}elseif($page_identifier == "delete-notifcation"){
	include("controllers/session.php");
	include("views/header.php");
	include("views/navigation.php");
	include("views/deletenotification.php");
	include("views/footer.php");

}elseif($page_identifier == "create-notifcation"){
	include("controllers/session.php");
	include("views/header.php");
	include("views/navigation.php");
	include("views/notify-user.php");
	include("views/footer.php");

}elseif($page_identifier == "latest-order"){
	include("controllers/session.php");
	include("views/header.php");
	include("views/navigation.php");
	include("views/neworder.php");
	include("views/footer.php");

}elseif($page_identifier == "order-report"){
	include("controllers/session.php");
	include("views/header.php");
	include("views/navigation.php");
	include("views/orderreport.php");
	include("views/footer.php");

}elseif($page_identifier == "refer-history"){
	include("controllers/session.php");
	include("views/header.php");
	include("views/navigation.php");
	include("views/referhistory.php");
	include("views/footer.php");

}elseif($page_identifier == "ehailing-activation"){
	include("controllers/session.php");
	include("views/header.php");
	include("views/navigation.php");
	include("views/ehailingactivation.php");
	include("views/footer.php");

}elseif($page_identifier == "login"){
	include("controllers/logincontroller.php");
	include("views/login.php");
}elseif($page_identifier == "register"){
	include("views/export.php");
}elseif($page_identifier == "patients"){
	$pagename = 'Patients';
	include("controllers/session.php");
	if($page_identifier_action == ""){
		include("views/header.php");
		include("views/navigation.php");
		include("views/customers.php");
		include("views/footer.php");
	}else{
		include("views/header.php");
		include("views/navigation.php");
		include("views/customermanager.php");
		include("views/footer.php");
	}
}elseif($page_identifier == "healthcare-personel"){
	include("controllers/session.php");
	if($page_identifier_action == ""){
		include("views/header.php");
		include("views/navigation.php");
		include("views/doctors.php");
		include("views/footer.php");
	}else{
		include("views/header.php");
		include("views/navigation.php");
		include("views/doctormanagement.php");
		include("views/footer.php");
	}
}elseif($page_identifier == "pharmacists"){
	include("controllers/session.php");
	if($page_identifier_action == ""){
		include("views/header.php");
		include("views/navigation.php");
		include("views/pharmacists.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "products"){
		include("views/header.php");
		include("views/navigation.php");
		include("views/pharmaproductlist.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "products-create"){
		include("views/header.php");
		include("views/navigation.php");
		include("views/pharmaproductcreate.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "category-manager"){
		include("views/header.php");
		include("views/navigation.php");
		include("views/pharmacategorymanager.php");
		include("views/footer.php");
	}
}elseif($page_identifier == "establishment-settlement"){
	include("controllers/session.php");
	include("views/header.php");
	include("views/navigation.php");
	include("views/estsettlement.php");
	include("views/footer.php");

}elseif($page_identifier == "membership-management"){
	include("controllers/session.php");
	include("views/header.php");
	include("views/navigation.php");
	include("views/membershipmanagement.php");
	include("views/footer.php");

}elseif($page_identifier == "rider-settlement"){
	include("controllers/session.php");
	include("views/header.php");
	include("views/navigation.php");
	include("views/ridersettlement.php");
	include("views/footer.php");

}elseif($page_identifier == "settlement"){
	include("controllers/session.php");
	include("views/header.php");
	include("views/navigation.php");
	include("views/settlement.php");
	include("views/footer.php");

}elseif($page_identifier == "mr-speedy-job"){
	include("controllers/session.php");
	include("views/header.php");
	include("views/navigation.php");
	include("views/speedyjob.php");
	include("views/footer.php");
}elseif($page_identifier == "delete-product"){
	include("controllers/session.php");
	include("views/header.php");
	include("views/navigation.php");
	include("views/deleteproduct.php");
	include("views/footer.php");
}elseif($page_identifier == "edit-product"){
	include("controllers/session.php");
	include("views/header.php");
	include("views/navigation.php");
	include("views/editproduct.php");
	include("views/footer.php");
}elseif($page_identifier == "suspend-product"){
	include("controllers/session.php");
	include("views/header.php");
	include("views/navigation.php");
	include("views/suspendproduct.php");
	include("views/footer.php");
}elseif($page_identifier == "activation-request"){
	include("controllers/session.php");
	include("views/header.php");
	include("views/navigation.php");
	include("views/activation.php");
	include("views/footer.php");
}elseif($page_identifier == "restaurants"){
	include("controllers/session.php");
	include("views/header.php");
	include("views/navigation.php");
	include("views/restaurants.php");
	include("views/footer.php");
}elseif($page_identifier == "grocery-store"){
	include("controllers/session.php");
	include("views/header.php");
	include("views/navigation.php");
	include("views/grocerystore.php");
	include("views/footer.php");
}elseif($page_identifier == "delivery-job-manager-store"){
	include("controllers/session.php");
	include("views/header.php");
	include("views/navigation.php");
	include("views/delivery-job-manager-store.php");
	include("views/footer.php");
}elseif($page_identifier == "riders"){
	include("controllers/session.php");
	if($page_identifier_action == ""){
		include("views/header.php");
		include("views/navigation.php");
		include("views/riders.php");
		include("views/footer.php");
	}else{
		include("views/header.php");
		include("views/navigation.php");
		include("views/ridermanagement.php");
		include("views/footer.php");
	}
}elseif($page_identifier == "delivery-tele-medicine"){
	include("controllers/session.php");
	$pagename = 'Delivery Request';
	if($page_identifier_action == ""){
		include("views/header.php");
		include("views/navigation.php");
		include("views/tele-delivery.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "delete"){
		include("views/header.php");
		include("views/navigation.php");
		include("views/sessiondelete.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "view"){
		include("views/header.php");
		include("views/navigation.php");
		include("views/tele-delivery-view.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "update"){
		include("views/header.php");
		include("views/navigation.php");
		include("views/elabcreator.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "archive"){
		include("views/header.php");
		include("views/navigation.php");
		include("views/sessionarchive.php");
		include("views/footer.php");
	}
}elseif($page_identifier == "top-up"){
	include("controllers/session.php");
	include("views/header.php");
	include("views/navigation.php");
	include("views/topup.php");
	include("views/footer.php");
}elseif($page_identifier == "withdrawal-request"){
	include("controllers/session.php");
	include("views/header.php");
	include("views/navigation.php");
	include("views/withdraw.php");
	include("views/footer.php");
}elseif($page_identifier == "job-request"){
	include("controllers/session.php");
	include("views/header.php");
	include("views/navigation.php");
	include("views/jobrequest.php");
	include("views/footer.php");
}elseif($page_identifier == "job-request"){
	include("controllers/session.php");
	include("views/header.php");
	include("views/navigation.php");
	include("views/jobrequest.php");
	include("views/footer.php");
}elseif($page_identifier == "app-setting"){
	include("controllers/session.php");
	include("views/header.php");
	include("views/navigation.php");
	include("views/setting.php");
	include("views/footer.php");
}elseif($page_identifier == "supports"){
	include("controllers/session.php");
	include("views/header.php");
	include("views/navigation.php");
	include("views/supportrequestliust.php");
	include("views/footer.php");

}elseif($page_identifier == "rider-activation"){
	include("controllers/session.php");
	include("views/header.php");
	include("views/navigation.php");
	include("views/rideractivation.php");
	include("views/footer.php");
}elseif($page_identifier == "establishment-manager"){
	include("controllers/session.php");
	include("views/header.php");
	include("views/navigation.php");
	include("views/estmanage.php");
	include("views/footer.php");
}elseif($page_identifier == "pharmacist-manager"){
	include("controllers/session.php");
	include("views/header.php");
	include("views/navigation.php");
	include("views/estmanage.php");
	include("views/footer.php");

}elseif($page_identifier == "establishment-map"){
	include("controllers/session.php");
	include("views/header.php");
	include("views/navigation.php");
	include("views/estmap.php");
	include("views/footer.php");

}elseif($page_identifier == "rider-map"){
	include("controllers/session.php");
	include("views/header.php");
	include("views/navigation.php");
	include("views/ridermap.php");
	include("views/footer.php");

}elseif($page_identifier == "orders"){
	include("controllers/session.php");
	include("views/header.php");
	include("views/navigation.php");
	include("views/orders.php");
	include("views/footer.php");

}elseif($page_identifier == "product-approval"){
	include("controllers/session.php");
	include("views/header.php");
	include("views/navigation.php");
	include("views/productapproval.php");
	include("views/footer.php");

}elseif($page_identifier == "system-setting"){
	include("controllers/session.php");
	include("views/header.php");
	include("views/navigation.php");
	include("views/systemsetting.php");
	include("views/footer.php");

}elseif($page_identifier == "rate-setting"){
	include("controllers/session.php");
	include("views/header.php");
	include("views/navigation.php");
	include("views/ratesetting.php");
	include("views/footer.php");

}elseif($page_identifier == "staffs"){
	if($page_identifier_action == ""){
		include("controllers/session.php");
		include("views/header.php");
		include("views/navigation.php");
		include("views/stafflist.php");
		include("views/footer.php");
	}else{
		include("controllers/session.php");
		include("views/header.php");
		include("views/navigation.php");
		include("views/staffcreate.php");
		include("views/footer.php");
	}
}elseif($page_identifier == "parcel-delivery-setting"){
		include("controllers/session.php");
		include("views/header.php");
		include("views/navigation.php");
		include("views/parcelsetting.php");
		include("views/footer.php");
}elseif($page_identifier == "specialist-setting"){
		include("controllers/session.php");
		include("views/header.php");
		include("views/navigation.php");
		include("views/specialistsetting.php");
		include("views/footer.php");
}elseif($page_identifier == "parcel-delivery-setting-car"){
		include("controllers/session.php");
		include("views/header.php");
		include("views/navigation.php");
		include("views/parcelsetting2.php");
		include("views/footer.php");
}elseif($page_identifier == "parcel-delivery-setting-van"){
		include("controllers/session.php");
		include("views/header.php");
		include("views/navigation.php");
		include("views/parcelsetting3.php");
		include("views/footer.php");
}elseif($page_identifier == "product-delivery-setting"){
		include("controllers/session.php");
		include("views/header.php");
		include("views/navigation.php");
		include("views/productssetting.php");
		include("views/footer.php");
}elseif($page_identifier == "admin-setting"){
		include("controllers/session.php");
		include("views/header.php");
		include("views/navigation.php");
		include("views/admin-setting.php");
		include("views/footer.php");
}elseif($page_identifier == "trustgate"){
		include("controllers/session.php");
		include("views/header.php");
		include("views/navigation.php");
		include("views/trustgate.php");
		include("views/footer.php");
}elseif($page_identifier == "trustgate-new"){
		include("controllers/session.php");
		include("views/header.php");
		include("views/navigation.php");
		include("views/trustgatenew.php");
		include("views/footer.php");
}elseif($page_identifier == "trustgatenew"){
		include("controllers/session.php");
		include("views/header.php");
		include("views/navigation.php");
		include("views/trustgate.php");
		include("views/footer.php");
}elseif($page_identifier == "promo-codes"){
	if($page_identifier_action == ""){
		include("controllers/session.php");
		include("views/header.php");
		include("views/navigation.php");
		include("views/promocodelist.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "create"){
		include("controllers/session.php");
		include("views/header.php");
		include("views/navigation.php");
		include("views/promocreate.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "delete"){
		include("controllers/session.php");
		include("views/header.php");
		include("views/navigation.php");
		include("views/promodelete.php");
		include("views/footer.php");
	}
}elseif($page_identifier == "verification-request"){
	if($page_identifier_action == ""){
		include("controllers/session.php");
		include("views/header.php");
		include("views/navigation.php");
		include("views/verification-request.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "approve"){
		include("controllers/session.php");
		include("views/header.php");
		include("views/navigation.php");
		include("views/verification-update.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "decline"){
		include("controllers/session.php");
		include("views/header.php");
		include("views/navigation.php");
		include("views/verification-update-decline.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "view"){
		include("controllers/session.php");
		include("views/header.php");
		include("views/navigation.php");
		include("views/verification-views.php");
		include("views/footer.php");
	}
}elseif($page_identifier == "specialityverification"){
	if($page_identifier_action == ""){
		include("controllers/session.php");
		include("views/header.php");
		include("views/navigation.php");
		include("views/specialityverification.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "approve"){
		include("controllers/session.php");
		include("views/header.php");
		include("views/navigation.php");
		include("views/specialityapprove.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "decline"){
		include("controllers/session.php");
		include("views/header.php");
		include("views/navigation.php");
		include("views/specialitydecline.php");
		include("views/footer.php");
	}

}elseif($page_identifier == "rider-verification"){
	if($page_identifier_action == ""){
		include("controllers/session.php");
		include("views/header.php");
		include("views/navigation.php");
		include("views/rider-verification.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "approve"){
		include("controllers/session.php");
		include("views/header.php");
		include("views/navigation.php");
		include("views/specialityapprove.php");
		include("views/footer.php");
	}elseif($page_identifier_action == "decline"){
		include("controllers/session.php");
		include("views/header.php");
		include("views/navigation.php");
		include("views/specialitydecline.php");
		include("views/footer.php");
	}

}elseif($page_identifier == "logout"){
	session_destroy();
	header("location: ".$domain."/login");

}elseif($page_identifier == "recovery"){
	include("views/recovery.php");

}else{
	header("location: ".$domain."/dashboard/");
}



?>
