<?php
include("process/pharmasession.php");
if($page_identifier_action == ""){
	$pagetitle = 'Dashboard';
	include("controllers/pharmacydashboardcontroller.php");
	include("views/pharma/header.php");
	include("views/pharma/nav.php");
	include("views/pharma/dashboard.php");	
	include("views/pharma/footer.php");
}elseif($page_identifier_action == "category-manager"){
	$pagetitle = 'Category Manager';
	include("views/pharma/header.php");
	include("views/pharma/nav.php");
	include("views/pharma/categorymanager.php");	
	include("views/pharma/footer.php");
}elseif($page_identifier_action == "order-history"){
	$pagetitle = 'Orders';
	include("views/pharma/header.php");
	include("views/pharma/nav.php");
	include("views/pharma/completed-orders.php");	
	include("views/pharma/footer.php");
}elseif($page_identifier_action == "account"){
	$pagetitle = 'Account Manager';
	include("views/pharma/header.php");
	include("views/pharma/nav.php");
	include("views/pharma/account.php");	
	include("views/pharma/footer.php");
}elseif($page_identifier_action == "expired"){
	$pagetitle = 'Membership Expired';
	include("views/pharma/header.php");
	include("views/pharma/nav-expired.php");
	include("views/pharma/membershipexpired.php");	
	include("views/pharma/footer.php");
}elseif($page_identifier_action == "establishment-information"){
	$pagetitle = 'Establishment Information';
	include("views/pharma/header.php");
	include("views/pharma/nav.php");
	include("views/pharma/vendorinfo.php");	
	include("views/pharma/footer.php");
}elseif($page_identifier_action == "products"){
	if($page_action_identifier == ""){
		$pagetitle = 'Product List';
		include("views/pharma/header.php");
		include("views/pharma/nav.php");
		include("views/pharma/product-list.php");	
		include("views/pharma/footer.php");
	}elseif($page_action_identifier == "create"){
		$pagetitle = 'Post Product';
		include("views/pharma/header.php");
		include("views/pharma/nav.php");
		include("views/pharma/product-post.php");	
		include("views/pharma/footer.php");
	}elseif($page_action_identifier == "delete"){
		$pagetitle = 'Post Product';
		include("views/pharma/header.php");
		include("views/pharma/nav.php");
		include("views/pharma/product-delete.php");	
		include("views/pharma/footer.php");
	}elseif($page_action_identifier == "view"){
		$pagetitle = 'Edit product';
		include("views/pharma/header.php");
		include("views/pharma/nav.php");
		include("views/pharma/product-view.php");	
		include("views/pharma/footer.php");
	}else{
		$pagetitle = 'Product List';
		include("views/pharma/header.php");
		include("views/pharma/nav.php");
		include("views/pharma/product-list.php");	
		include("views/pharma/footer.php");
	}
}elseif($page_identifier_action == "orders"){
	if($page_action_identifier == ""){
		$pagetitle = 'Orders';
		include("views/pharma/header.php");
		include("views/pharma/nav.php");
		include("views/pharma/latestorder.php");	
		include("views/pharma/footer.php");
	}elseif($page_action_identifier == "tele"){
		$pagetitle = 'View Orders';
		include("views/pharma/header.php");
		include("views/pharma/nav.php");
		include("views/pharma/vieworder.php");	
		include("views/pharma/footer.php");
	}elseif($page_action_identifier == "purchase-order"){
		if($final_identifier == ""){
			$pagetitle = 'Latest Orders';
			include("views/pharma/header.php");
			include("views/pharma/nav.php");
			include("views/pharma/purchaseorder.php");	
			include("views/pharma/footer.php");
		}else{
			$pagetitle = 'Orders History';
			include("views/pharma/header.php");
			include("views/pharma/nav.php");
			include("views/pharma/purchaseorderall.php");	
			include("views/pharma/footer.php");
		}
	}elseif($page_action_identifier == "tele-consultation"){
		$pagetitle = 'View Orders';
		include("views/pharma/header.php");
		include("views/pharma/nav.php");
		include("views/pharma/teleorders.php");	
		include("views/pharma/footer.php");
	}elseif($page_action_identifier == "history"){
		$pagetitle = 'View Orders';
		include("views/pharma/header.php");
		include("views/pharma/nav.php");
		include("views/pharma/orders.php");	
		include("views/pharma/footer.php");
	}elseif($page_action_identifier == "carts"){
		$pagetitle = 'View Orders';
		include("views/pharma/header.php");
		include("views/pharma/nav.php");
		include("views/pharma/cartsorder.php");	
		include("views/pharma/footer.php");
	}elseif($page_action_identifier == "both"){
		$pagetitle = 'View Orders';
		include("views/pharma/header.php");
		include("views/pharma/nav.php");
		include("views/pharma/vieworder.php");	
		include("views/pharma/footer.php");
	}else{
	
	}
}
?>