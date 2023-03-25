<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title><?php echo $projectname; ?> - <?php echo $pagetitle; ?></title>
        <link href="<?php echo $domain; ?>/landingasset/css/styles.css" rel="stylesheet" />
        <link href="<?php echo $domain; ?>/landingasset/css/epink.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
        <link rel="icon" type="image/x-icon" href="<?php echo $domain; ?>/landingasset/assets/img/favicon.png" />
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.24.1/feather.min.js" crossorigin="anonymous"></script>
		
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>
    </head>
    <body>
		
        <div id="layoutDefault">
            <div id="layoutDefault_content">
                <main <?php if($page_identifier == ""){ echo 'class="epink-coding-color"'; }elseif( $page_identifier == "featured" ){  echo 'class="epink-coding-color"'; }elseif( $page_identifier == "booking" ){  echo 'class="formbgcolor"'; }else{  echo 'class="formbgcolor"'; } ?>>