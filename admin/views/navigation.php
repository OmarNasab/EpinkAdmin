<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
	<ul class="navbar-nav">
		<li class="nav-item">
			<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
		</li>
	</ul>
	<!-- Right navbar links -->
	<ul class="navbar-nav ml-auto">
		<li class="nav-item">
			<a class="nav-link" href="<?php echo $domain; ?>/logout/" role="button">
			LOGOUT
			</a>
		</li>
	</ul>
</nav>
<!-- /.navbar -->
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-primary elevation-4">
	<!-- Brand Logo -->
	<a href="<?php echo $domain;?>/dashboard" class="brand-link">
	<span class="brand-text font-weight-bold " style="color: pink;"><?php echo $projectname; ?></span>
	</a>
	<!-- Sidebar -->
	<div class="sidebar">
		<!-- Sidebar Menu -->
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				<li class="nav-item">
					<a href="<?php echo $domain;?>/dashboard" class="nav-link">
						<p><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</p>
					</a>
				</li>
				<?php if($authuser["email"] == "dev@epink.health"){?>
				<?php }?>
				<li class="nav-item">
					<a href="#" class="nav-link">
						<p>
							<i class="left fa fa-clipboard" aria-hidden="true"></i>
							 Job Manager
							<i class="right fas fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview" style="display: none;">
						<li class="nav-item">
							<a href="<?php echo $domain;?>/sessions/" class="nav-link">
								<p><i class="left fas fa-angle-right"></i> Tele Consultancy Sessions</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo $domain;?>/delivery-tele-medicine/" class="nav-link">
								<p><i class="left fas fa-angle-right"></i> Tele Medicine Delivery</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo $domain;?>/ecare-job-manager/" class="nav-link">
								<p><i class="left fas fa-angle-right"></i>  E Care Request</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo $domain;?>/elab-requests/" class="nav-link">
								<p><i class="left fas fa-angle-right"></i> E-Lab Requests</p>
							</a>
						</li>
					<!--<li class="nav-item">
							<a href="<?php echo $domain;?>/delivery-job-manager-store/" class="nav-link">
								<p><i class="left fas fa-angle-right"></i> Delivery E-Pharmacy</p>
							</a>
						</li> -->
					</ul>
				</li>
				<li class="nav-item">
					<a href="#" class="nav-link">
						<p>
							<i class="left fa fa-mobile" aria-hidden="true"></i> 
							 App Manager
							<i class="right fas fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview" style="display: none;">
						<li class="nav-item">
							<a href="<?php echo $domain;?>/elab/" class="nav-link">
								<p><i class="left fas fa-angle-right"></i> E-Lab Manager</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo $domain;?>/ecare-manager/" class="nav-link">
								<p><i class="left fas fa-angle-right"></i> E-Care Manager</p>
							</a>
						</li>
					</ul>
				</li>
				<li class="nav-item">
					<a href="#" class="nav-link">
						<p>
							<i class="left fa fa-window-maximize" aria-hidden="true"></i> 
							 Website Job Request
							<i class="right fas fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview" style="display: none;">
						<li class="nav-item">
							<a href="<?php echo $domain;?>/mobile-vaccination-corporate/" class="nav-link">
								<p><i class="left fas fa-angle-right"></i> Outreach - Corporate</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo $domain;?>/mobile-vaccination/" class="nav-link">
								<p><i class="left fas fa-angle-right"></i> Outreach</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo $domain;?>/flood-victim-health-care/" class="nav-link">
								<p><i class="left fas fa-angle-right"></i> Flood Relief</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo $domain;?>/zumba/" class="nav-link">
								<p><i class="left fas fa-angle-right"></i> Zumba</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo $domain;?>/booking-management" class="nav-link">
								<p><i class="left fas fa-angle-right"></i> Bookings</p>
							</a>
						</li>
					</ul>
				</li>
				<li class="nav-item">
					<a href="#" class="nav-link">
						<p>
							<i class="left fa fa-user-circle" aria-hidden="true"></i>
							User Management
							<i class="right fas fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview" style="display: none;">
						<li class="nav-item">
							<a href="<?php echo $domain;?>/patients/" class="nav-link">
								<p><i class="left fas fa-angle-right"></i> Patients</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo $domain;?>/healthcare-personel/" class="nav-link">
								<p><i class="left fas fa-angle-right"></i> Healthcare Personel</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo $domain;?>/pharmacists/" class="nav-link">
								<p><i class="left fas fa-angle-right"></i> Pharmacists</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo $domain;?>/riders" class="nav-link">
								<p><i class="left fas fa-angle-right"></i> Rider List</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo $domain;?>/volunteer-application/" class="nav-link">
								<p><i class="left fas fa-angle-right"></i> Volunteer Application</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo $domain;?>/staffs/" class="nav-link">
								<p><i class="left fas fa-angle-right"></i>Staff Manager</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo $domain;?>/membership-management/" class="nav-link">
								<p><i class="left fas fa-angle-right"></i> Pharmacy Membership</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo $domain;?>/corporate-client/" class="nav-link">
								<p><i class="left fas fa-angle-right"></i> Corporate Client</p>
							</a>
						</li>
					</ul>
				</li>
				<li class="nav-item">
					<a href="#" class="nav-link">
						<p>	<i class="left fa fa-list-alt" aria-hidden="true"></i>
							Legal Management
							<i class="right fas fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview" style="display: none;">
						<li class="nav-item">
							<a href="<?php echo $domain;?>/consent/" class="nav-link">
								<p><i class="left fas fa-angle-right"></i> Consent</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo $domain;?>/privacy-policy-manager/" class="nav-link">
								<p><i class="left fas fa-angle-right"></i> Privacy Policy</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo $domain;?>/tnc-manager/" class="nav-link">
								<p><i class="left fas fa-angle-right"></i> Term & condition</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo $domain;?>/telemed/" class="nav-link">
								<p><i class="left fas fa-angle-right"></i> Tele med consent</p>
							</a>
						</li>
					</ul>
				</li>
				
				<li class="nav-item">
					<a href="#" class="nav-link">
						<p>
							<i class="left fa fa-list-alt" aria-hidden="true"></i>
							Settlements
							<i class="right fas fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview" style="display: none;">
						<li class="nav-item">
							<a href="<?php echo $domain;?>/settlement/" class="nav-link">
								<p><i class="left fas fa-angle-right"></i> Service Provider</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo $domain;?>/establishment-settlement/" class="nav-link">
								<p><i class="left fas fa-angle-right"></i> Pharmacy</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo $domain;?>/rider-settlement/" class="nav-link">
								<p><i class="left fas fa-angle-right"></i> Rider</p>
							</a>
						</li>
					</ul>
				</li>
				<li class="nav-item">
					<a href="#" class="nav-link">
						<p>
							<i class="left fa fa-id-badge fa-1"></i> 
							Verifications
							<i class="right fas fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview" style="display: none;">
						<li class="nav-item">
							<a href="<?php echo $domain;?>/verification-request/" class="nav-link">
								<p><i class="left fas fa-angle-right"></i> Service Provider</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo $domain;?>/rider-verification/" class="nav-link">
								<p><i class="left fas fa-angle-right"></i> Logistic</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo $domain;?>/specialityverification/" class="nav-link">
								<p><i class="left fas fa-angle-right"></i> Speciality Verification</p>
							</a>
						</li>
					</ul>
				</li>
				<li class="nav-item">
					<a href="#" class="nav-link">
						<p>
							<i class="left fa fa-cog fa-1"></i>
							Settings
							<i class="right fas fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview" style="display: none;">
						<li class="nav-item">
							<a href="<?php echo $domain;?>/system-setting/" class="nav-link">
								<p><i class="left fas fa-angle-right"></i> System Setting</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo $domain;?>/rate-setting/" class="nav-link">
								<p><i class="left fas fa-angle-right"></i> Tele Rate Setting</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo $domain;?>/inhouse-provider/" class="nav-link">
								<p><i class="left fas fa-angle-right"></i> In house Provider</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo $domain;?>/specialist-setting/" class="nav-link">
								<p><i class="left fas fa-angle-right"></i> Specialist Rate</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo $domain;?>/master-category/" class="nav-link">
								<p><i class="left fas fa-angle-right"></i> Master Category</p>
							</a>
						</li>
					</ul>
				</li>
				<li class="nav-item">
					<a href="#" class="nav-link">
						<p>
							<i class="left fa fa-cog fa-1"></i>
							Others
							<i class="right fas fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview" style="display: none;">
						<li class="nav-item">
							<a href="<?php echo $domain;?>/rider-map" class="nav-link">
								<p><i class="left fas fa-angle-right"></i> Rider Map</p>
							</a>
						</li>

						
						<li class="nav-item">
							<a href="<?php echo $domain;?>/blogs/" class="nav-link">
								<p><i class="left fas fa-angle-right"></i> Blog Manager</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo $domain;?>/admin-setting/" class="nav-link">
								<p><i class="left fas fa-angle-right"></i> My Account</p>
							</a>
						</li>
					</ul>
				</li>
				
			</ul>
		</nav>
		<!-- /.sidebar-menu -->
	</div>
	<!-- /.sidebar -->
</aside>