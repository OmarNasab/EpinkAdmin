<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $projectname; ?> | <?php echo $pagename; ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo $domain; ?>/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="<?php echo $domain; ?>/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css"> 
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo $domain; ?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="<?php echo $domain; ?>/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo $domain; ?>/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?php echo $domain; ?>/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo $domain; ?>/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="<?php echo $domain; ?>/plugins/summernote/summernote-bs4.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo $domain; ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo $domain; ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo $domain; ?>/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo $domain; ?>/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <?php if($page_identifier == "blogs" || $page_identifier == "privacy-policy-manager" || $page_identifier == "tnc-manager" || $page_identifier == "telemed"){
	 echo '  <script src="https://cdn.tiny.cloud/1/11htuontzgh2ggim1oefm3q4w75lsgmnkxa48k10qmcyz54l/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
	 <script>
 tinymce.init({
      selector: \'textarea\',
      plugins: \'\',
      toolbar: \'a11ycheck addcomment showcomments casechange checklist code formatpainter pageembed permanentpen table\',
      toolbar_mode: \'floating\',
      tinycomments_mode: \'embedded\',
      tinycomments_author: \'Author name\',
	  height: \'50vh\'
   });
  </script>
	 '; 
  }?>
 <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.1/css/buttons.dataTables.min.css">
   <script>
	var serverUrl = '<?php echo $appapiurl; ?>';
	var apiVersion = 1;
	var authUser = {"login_token":""};
	authUser.login_token = '<?php echo $authuser["login_token"]; ?>';
  </script>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">