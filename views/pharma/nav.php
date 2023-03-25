        <nav class="topnav navbar navbar-expand shadow justify-content-between justify-content-sm-start navbar-light bg-white" id="sidenavAccordion">
            <!-- Sidenav Toggle Button-->
            <button class="btn btn-icon btn-transparent-dark order-1 order-lg-0 me-2 ms-lg-2 me-lg-0" id="sidebarToggle"><i data-feather="menu"></i></button>
            <!-- Navbar Brand-->
            <!-- * * Tip * * You can use text or an image for your navbar brand.-->
            <!-- * * * * * * When using an image, we recommend the SVG format.-->
            <!-- * * * * * * Dimensions: Maximum height: 32px, maximum width: 240px-->
            <a class="navbar-brand pe-3 ps-4 ps-lg-2" href="<?php echo $domain; ?>"><?php echo $projectname; ?></a>
            <!-- Navbar Search Input-->
            <!-- * * Note: * * Visible only on and above the lg breakpoint-->
            <form class="form-inline me-auto d-none d-lg-block me-3">
                <div class="input-group input-group-joined input-group-solid">
                    <input class="form-control pe-0" type="search" placeholder="Search" aria-label="Search" />
                    <div class="input-group-text"><i data-feather="search"></i></div>
                </div>
            </form>
            <!-- Navbar Items-->
            <ul class="navbar-nav align-items-center ms-auto">
                <li class="nav-item dropdown no-caret dropdown-user me-3 me-lg-4">
                    <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownUserImage" href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img class="img-fluid" src="<?php echo $authuser["profile_img"]; ?>" /></a>
                    <div class="dropdown-menu dropdown-menu-end border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownUserImage">
                        <h6 class="dropdown-header d-flex align-items-center">
                            <img class="dropdown-user-img" src="<?php echo $authuser["profile_img"]; ?>" alt="<?php echo $authuser["profile_img"]; ?>"/>
                            <div class="dropdown-user-details">
                                <div class="dropdown-user-details-name"><?php echo $authuser["firstname"]; ?> <?php echo $authuser["lastname"]; ?></div>
                                <div class="dropdown-user-details-email"><?php echo $authuser["email"]; ?></div>
                            </div>
                        </h6>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?php echo $domain; ?>/pharmacy-panel/account/">
                            <div class="dropdown-item-icon"><i data-feather="settings"></i></div>
                            Account
                        </a>
                        <a class="dropdown-item" href="<?php echo $domain; ?>/logout/">
                            <div class="dropdown-item-icon"><i data-feather="log-out"></i></div>
                            Logout
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
		        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sidenav shadow-right sidenav-light">
                    <div class="sidenav-menu">
                        <div class="nav accordion" id="accordionSidenav">
                            <div class="sidenav-menu-heading">Core</div>           
							<a class="nav-link " href="<?php echo $domain; ?>/pharmacy-panel/">
                               <div class="nav-link-icon"><i data-feather="codesandbox"></i></div>
                                Dashboard
                            </a>
							<a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseDashboards" aria-expanded="false" aria-controls="collapseDashboards">
                                <div class="nav-link-icon"><i data-feather="clipboard"></i></div>
                                Orders
                                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseDashboards" data-bs-parent="#accordionSidenav">
                                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                                    <a class="nav-link" href="<?php echo $domain; ?>/pharmacy-panel/orders/purchase-order/">Store Purchase</a>
                                    <a class="nav-link" href="<?php echo $domain; ?>/pharmacy-panel/orders/tele-consultation/">Tele consulatation</a>
                                   
                                </nav>
                            </div>
							
							<a class="nav-link " href="<?php echo $domain; ?>/pharmacy-panel/products/">
                                <div class="nav-link-icon"><i data-feather="box"></i></div>
                                Products
                            </a>	
							<a class="nav-link " href="<?php echo $domain; ?>/pharmacy-panel/category-manager/">
                                <div class="nav-link-icon"><i data-feather="filter"></i></div>
                                Category Manager
                            </a>	
							<a class="nav-link " href="<?php echo $domain; ?>/pharmacy-panel/account/">
                                <div class="nav-link-icon"><i data-feather="user"></i></div>
                                Account Manager
                            </a>	
							<a class="nav-link " href="<?php echo $domain; ?>/pharmacy-panel/establishment-information/">
                                <div class="nav-link-icon"><i data-feather="map-pin"></i></div>
                                Establishment Information
                            </a>	
<a class="nav-link " href="<?php echo $domain; ?>/logout/">
                                <div class="nav-link-icon"><i data-feather="log-out"></i></div>
                                Logout
                            </a>							
                            <!-- Sidenav Heading (Custom)-->                      
                        </div>
                    </div>
                    <!-- Sidenav Footer-->
                    <div class="sidenav-footer">
                        <div class="sidenav-footer-content">
                            <div class="sidenav-footer-subtitle">Logged in as:</div>
                            <div class="sidenav-footer-title"><?php echo $authuser["firstname"].' '.$authuser["lastname"]; ?></div>
                        </div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>