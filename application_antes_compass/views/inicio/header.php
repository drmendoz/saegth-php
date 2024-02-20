<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" class="container-fluid">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title><?php if(isset($title)): echo $title; else: echo "Alto Desempe&ntilde;o"; endif; ?></title>
  <link rel="shortcut icon" href="<?php echo BASEURL ?>public/img/alde1.ico" >
  <link rel="stylesheet" type="text/css" href="<?php echo BASEURL ?>public/css/styles.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="<?php echo BASEURL ?>public/css/fonts.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="<?php echo BASEURL ?>public/css/bootstrap.css" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <script src="<?php echo BASEURL ?>public/js/jquery.min.js"></script>
  <script src="<?php echo BASEURL ?>public/js/bootstrap.min.js"></script>
</head>

<body class="clearfix">
  <div class="page-width" style="margin-top:15px">
    <div class="form-group clearfix">
      <div class="col-sm-3 form-group">
        <img class="img-responsive center-block" src="<?php echo BASEURL.'img/header.png' ?>">
      </div>
      <div class="col-sm-9">
        <ul class="nav nav-tabs">
          <li role="presentation"><a href="<?php echo BASEURL ?>">Inicio</a></li>
          <li class="dropdown" role="presentation">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Secciones<span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="<?php echo BASEURL ?>inicio/administracion_del_desempenio">Administraci&oacute;n del Desempe&ntilde;o</a></li>
              <li><a href="<?php echo BASEURL ?>inicio/diagnostico_laboral_de_clima">Diagn&oacute;stico de Clima Laboral</a></li>
              <li><a href="<?php echo BASEURL ?>inicio/estructura_y_planes_salariales">Estructuras y Planes Salariales</a></li>
              <li><a href="<?php echo BASEURL ?>inicio/evaluaciones_psicometricas">Evaluaciones Psicom&eacute;tricas</a></li>
              <li><a href="<?php echo BASEURL ?>inicio/modelos_de_competencias">Modelos de Competencias</a></li>
              <li><a href="<?php echo BASEURL ?>inicio/reclutamiento_y_seleccion">Reclutamiento y Selecci&oacute;n</a></li>
              <li><a href="<?php echo BASEURL ?>inicio/entrenamiento_y_desarrollo">Entrenamiento y Desarrollo</a></li>
              <li><a href="<?php echo BASEURL ?>inicio/diseno_de_politicas_rh">Dise&ntilde;o de  Pol&iacute;ticas de RH</a></li>
              <li><a href="<?php echo BASEURL ?>inicio/nomina_confidencial">Nomina Confidencialidad</a></li>              
            </ul>
          </li>
          <li role="presentation"><a href="<?php echo BASEURL ?>inicio/contacto">Contacto</a></li>
          <?php if(!DEBUG){ ?>
          <li id="login" class="pull-right">
            <?php
            if(@!$isBlocked && isset($isBlocked)){
              ?>
              <form  class="form-inline" method="post" action="<?php echo BASEURL; ?>inicio/principal">
                <div class="form-group">
                  <input type="text" name="usuario" class="form-control" id="exampleInputName2" placeholder="Usuario">
                </div>
                <div class="form-group">
                  <input type="password"  name="password"  class="form-control" id="exampleInputEmail2" placeholder="Contraseña">
                </div>
                <button type="submit" class="btn btn-default">Entrar</button>
              </form>
              <?php
            }
            ?>

          </li>
          <?php } ?>
        </ul>
      </div>
    </div>
  </div>


  <script type="text/javascript">
    $(document).ready(function() {
      $('a[href="' + this.location.origin + this.location.pathname + '"]').parents('li[role="presentation"]').addClass('active');
    });
  </script>