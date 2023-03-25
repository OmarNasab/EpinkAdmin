    <!-- NAVBAR
    ================================================== -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
      <div class="container-fluid">
        <!-- Brand -->
        <a class="navbar-brand" href="<?php echo $domain; ?>">
		<img src="https://epink.health/img/epinkhealth.png" width="100px">
        
        </a>

        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon" style="color: red"></span>
        </button>

        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="navbarCollapse">

          <!-- Toggler -->
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fe fe-x"></i>
          </button>

          <!-- Navigation -->
          <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link text-pink" href="<?php echo $domain; ?>/home/">
                        <span class="text-pink">HOME</span>
                    </a>
                </li>
				<li class="nav-item">
                    <a class="nav-link text-pink" href="https://app.epink.health/">
                        <span class="text-pink">WEBAPP</span>
                    </a>
                </li>
				<li class="nav-item">
                    <a class="nav-link text-pink" href="<?php echo $domain; ?>/healthcare-provider/">
                        <span class="text-pink">HEALTHCARE PROVIDER</span>
                    </a>
                </li>
				<li class="nav-item">
                    <a class="nav-link text-pink" href="<?php echo $domain; ?>/medical-consumables/">
                        <span class="text-pink">MEDICAL CONSUMABLES</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-pink" href="<?php echo $domain; ?>/more/">
                       <span class="text-pink">MORE</span>
                    </a>
                </li>
            </ul>
        </div>

      </div>
    </nav>