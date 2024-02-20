<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title><?php if(isset($title)): echo $title; else: echo "Alto Desempe&ntilde;o"; endif; ?></title>
  <link rel="shortcut icon" href="<?php echo BASEURL ?>public/img/alde1.ico" >
  <!-- CSS -->
  <link href="<?php echo BASEURL ?>public/css/bootstrap.css" rel="stylesheet">  
  <link href="<?php echo BASEURL ?>public/css/preload.css" rel="stylesheet">
  <link href="<?php echo BASEURL ?>public/plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <link href='http://fonts.googleapis.com/css?family=Righteous' rel='stylesheet' type='text/css' async>
  <link href="<?php echo BASEURL ?>public/plugins/fancybox/jquery.fancybox.css" rel="stylesheet" async>
  <link type="text/css" href="<?php echo BASEURL ?>public\plugins\toast\resources/css/jquery.toastmessage.css" rel="stylesheet" async>
  <link href="<?php echo BASEURL ?>public/css/admin/style.css" rel="stylesheet" async>
  <link href="<?php echo BASEURL ?>public/plugins/sorter/themes/blue/style.css" rel="stylesheet" async>
  <link href="<?php echo BASEURL ?>public/plugins/jAlert/jquery.alerts.css" rel="stylesheet" async>
  <link href="<?php echo BASEURL ?>public/plugins/chosen/chosen.css" rel="stylesheet" async>
  <!-- JAVASCRIPT -->
  <script src="<?php echo BASEURL ?>public/plugins/jquery/jquery.min.js"></script>
  <script src="<?php echo BASEURL ?>public/plugins/jquery-ui/jquery-ui.min.js"></script>
  <script src="http://code.jquery.com/jquery-migrate-1.3.0.js"></script>
  <script type="text/javascript" src="<?php echo BASEURL ?>public/js/admin/jquery.livequery.js"></script>
  <script type="text/javascript" src="<?php echo BASEURL ?>public/plugins/sorter/jquery.tablesorter.js" async></script> 
  <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&libraries=place&key=AIzaSyB_BiUrByj2iFhNyapElTfb1SgDmjWlmjY" async></script>
  <script src="<?php echo BASEURL ?>public/plugins/jAlert/jquery.alerts.js" type="text/javascript" async></script>
  <script src="<?php echo BASEURL ?>public/plugins/chosen/chosen.jquery.js" type="text/javascript" async></script>  
</head>
<div id="preloader">
  <div id="status">&nbsp;</div>
</div>
<body>
  <?php  
    $meth = new User();
    $foto = $meth->query_('SELECT `foto` FROM `empresa_datos` WHERE `id_empresa`='. $_SESSION["Empresa"]["id"] .'',1);
  ?>
  <!--Start Header-->
  <header class="navbar">
    <div class="container-fluid expanded-panel">
      <div class="row mainbar">
        <div id="logo" class="col-sm-5" style="padding-left: 0">
          <a href="<?php echo BASEURL.$_SESSION['link']; ?>">
            <img width="300" src="<?php echo BASEURL.'img/header.png' ?>">
          </a>
        </div>
        <div id="top-panel" class="col-sm-7 hidden-xs">
          <div class="row">
            <div class="col-xs-6 text-center">
              <?php 
              if(isset($_SESSION['Empresa']['nombre'])){
                echo $meth->htmlprnt(strtoupper($_SESSION['Empresa']['nombre']));
              }else{
                echo "ALTO DESEMPE&Ntilde;O";
              }
              ?>
            </div>
            <div class="col-xs-6 col-sm-6 text-right">
              <?php 
              if(isset($_SESSION['Personal']['nombre'])){
                echo $meth->htmlprnt(strtoupper($_SESSION['Personal']['nombre']));
              }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>
  <!--End Header-->
  <!--Start Container-->
  <div id="main" class="container-fluid">
    <div class="row">
      <div id="sidebar-left" class="col-xxs-2 col-xs-2 col-sm-2" >
        <?php
        $navbar = new navbarController('Navbar','navbar','view',0,true,true); 
        unset($navbar); 
          // echo '----<br>';
          // echo Util::nav_decode($_SESSION['nav']);
        ?>
      </div>
      <!--Start Content-->
      <div id="content" class="col-xxs-12 col-xs-12 col-sm-10">
        <div class="row">
          <div id="breadcrumb" class="col-xxs-12">
            <a href="#" class="show-sidebar">
              <i class="fa fa-bars"></i>
            </a>
            <ol class="breadcrumb pull-left">
              <?php  $homelink=BASEURL.$_SESSION['link']; ?>
              <li><a href="<?php echo $homelink ?>">Home</a></li>
              <li id="backbutton"><a id="bb_link" href="previous.html">Regresar</a></li>
            </ol>
          </div>
        </div>
        <div id="ajax-content" class="col-md-12 no-padding" style="min-height: 790px;"> 
          <div class="col-md-12">
            <?php
            if(isset($custom_success)){
              ?>
              <div class="alert alert-success  alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h6><?php echo $custom_success  ?></h6>
              </div>
              <?php
            }
            if(isset($custom_info)){
              ?>
              <div class="alert alert-info  alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h6><?php echo $custom_info  ?></h6>
              </div>
              <?php
            }
            if(isset($custom_warning)){
              ?>
              <div class="alert alert-warning  alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h6><?php echo $custom_warning  ?></h6>
              </div>
              <?php
            }
            if(isset($custom_danger)){
              ?>
              <div class="alert alert-danger  alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h6><?php echo $custom_danger  ?></h6>
              </div>
              <?php
            }
            if(isset($custom_text)){
              ?>
              <div class="col-md-12">
                <h3><?php echo $custom_text  ?></h3>
                <p>&nbsp;</p>
              </div>
              <?php
            }
            ?>