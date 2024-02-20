<ul class="nav main-menu"> 
  <li class="dropdown">
    <a href="<?php echo BASEURL ?>empresa/consolidado" class="dropdown-toggle">
      <i class="fa fa-building-o"></i>
      <span class="hidden-xs">Empresa</span>
    </a>
  </li>      
  <li class="dropdown">
    <a href="#" class="dropdown-toggle">
      <i class="fa fa-user"></i>
      <span class="hidden-xs">Datos personales</span>
    </a>
    <ul class="dropdown-menu">
      <li><a class="ajaxlink_navbar" href='#ajax-content/tabs-1' >Mis datos</a></li>
      <li><a href="<?php echo BASEURL ?>personal/datos_personales" >Modificar datos personales</a></li>
      <li><a href="<?php echo BASEURL ?>personal/subalternos" >Subalternos</a></li>
    </ul>
  </li> 
<li class="dropdown">
  <a href="#" class="dropdown-toggle">
    <i class="fa fa-area-chart"></i>
    <span class="hidden-xs">Compass 360</span>
	<span id="sp_compass"></span>
  </a>
  <ul class="dropdown-menu">
    <li class="dropdown">
      <a href="#" class="dropdown-toggle">Mi Compass 360</a>
      <ul class="dropdown-menu">
        <li><a class="ajaxlink_navbar" href='#ajax-content/tabs-2' >- Resultados</a></li>
        <li><a href="<?php echo BASEURL ?>multifuente/fortalezas/<?php echo $_SESSION['USER-AD']['id_personal'] ?>" >- Items mejor puntuados</a></li>
        <li><a href="<?php echo BASEURL ?>multifuente/oportunidades/<?php echo $_SESSION['USER-AD']['id_personal'] ?>" >- Oportunidades de mejora</a></li>
        <li><a href="<?php echo BASEURL ?>multifuente/comentarios/<?php echo $_SESSION['USER-AD']['id_personal'] ?>" >- Comentarios</a></li>
      </ul>
    </li>
    <li class="dropdown">
      <a href="#" class="dropdown-toggle">
        Aprobación de evaluadores<span id="navbar_aprovacion" class="badge"></span>
      </a>
      <ul class="dropdown-menu">
        <li><a class="ajax_link" href="<?php echo BASEURL ?>multifuente/directos">- Subalternos Directos <span id="navbar_directo" class="badge"></span></a></li>
        <li><a class="ajax_link" href="<?php echo BASEURL ?>multifuente/indirectos">- Subalternos Indirectos <span id="navbar_indirecto" class="badge"></span></a></li>
      </ul>
    </li>
    <li><a class="ajax_link" href="<?php echo BASEURL ?>multifuente/evaluaciones_pendientes" class="dropdown-toggle">Cuestionarios Pendientes <span id="navbar_pendiente" class="badge"></a></li>
    <li><a class="ajax_link" href="<?php echo BASEURL ?>multifuente/home" class="dropdown-toggle">Resultados de subalternos</a></li>
	<li><a href='<?php echo BASEURL ?>multifuente/eval_edit_test_actual'>Editar selección de evaluadores</a></li>
  </ul>
</li>
<li class="dropdown">
  <a href="#" class="dropdown-toggle">
    <i class="fa fa-area-chart"></i>
    <span class="hidden-xs">Evaluaci&oacute;n de desempe&ntilde;o</span>
  <span id="sp_compass"></span>
  </a>
  <ul class="dropdown-menu">
    <li>
      <a class="ajax_link" href="<?php echo BASEURL ?>evaluacion_desempenio/seleccion_evaluadores" class="dropdown-toggle">Selecci&oacute;n de Evaluadores<span id="" class="badge"></a>
    </li>
    <li class="dropdown">
      <a href="#" class="dropdown-toggle">
        Aprobación de evaluadores<span id="navbar_aprovacion" class="badge"></span>
      </a>
      <ul class="dropdown-menu">
        <li><a class="ajax_link" href="<?php echo BASEURL ?>evaluacion_desempenio/directos">- Subalternos Directos <span id="navbar_directo" class="badge"></span></a></li>
        <li><a class="ajax_link" href="<?php echo BASEURL ?>evaluacion_desempenio/indirectos">- Subalternos Indirectos <span id="navbar_indirecto" class="badge"></span></a></li>
      </ul>
    </li>
    <li>
      <a class="ajax_link" href="<?php echo BASEURL ?>evaluacion_desempenio/evaluaciones_pendientes" class="dropdown-toggle">Cuestionarios Pendientes <span id="navbar_pendiente" class="badge"></a>
    </li>
  </ul>
</li>
<li class="dropdown">
  <a href="#" class="dropdown-toggle">
    <i class="fa fa-line-chart"></i>
    <span class="hidden-xs">ScoreCard</span>
  </a>
  <ul class="dropdown-menu">
    <li><a class="ajaxlink_navbar" href='#ajax-content/tabs-3' >Mi scorecard</a></li>
    <li><a href="<?php echo BASEURL ?>scorecard/home" >Scorecard de subalternos</a></li>
	<li><a href="<?php echo BASEURL ?>scorecard/vista_scorecard" >Vista Scorecards</a></li>
  </ul>
</li>
<li>
  <a class="ajaxlink_navbar" href='#ajax-content/tabs-4' >
    <i class="fa fa-calendar-minus-o"></i>
    <span class="hidden-xs">Plan de accion</span>
  </a>
</li>
<li class="dropdown">
  <a href="#" class="dropdown-toggle">
    <i class="fa fa-calendar-minus-o"></i>
    <span class="hidden-xs">Preferencias de Desarrollo de Carrera</span>
  </a>
  <ul class="dropdown-menu">
    <li><a class="ajaxlink_navbar" href='#ajax-content/tabs-5' >Mis preferencias</a></li>
    <li><a href="<?php echo BASEURL ?>test/preferencias_sublaternos" >Preferencias de subalternos</a></li>
  </ul>
</li>
<li>
  <a href="<?php echo BASEURL ?>user/logout" >
    <i class="fa fa-power-off"></i>
    <span class="hidden-xs">Cerrar sesi&oacute;n</span>
  </a>
</li>
</ul>