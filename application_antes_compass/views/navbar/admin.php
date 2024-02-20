<ul class="nav main-menu">
  <li class="dropdown">
    <a href="#" class="dropdown-toggle">
      <i class="fa fa-building-o"></i>
      <span class="hidden-xs">Empresa</span>
    </a>
    <ul class="dropdown-menu">
    <li><a href="<?php echo BASEURL ?>admin/ingresar_nueva" >Ingresar nueva</a></li>
      <li><a href="<?php echo BASEURL ?>admin/viewall" >Ver</a></li>
    </ul>
  </li> 
  <li class="dropdown">
    <a href="#" class="dropdown-toggle">
      <i class="fa fa-area-chart"></i>
      <span class="hidden-xs">Evaluaciones</span>
    </a>
    <ul class="dropdown-menu">
      <li class="dropdown">
        <a href="#" class="dropdown-toggle">
          <span class="hidden-xs">Multifuentes</span>
        </a>
        <ul class="dropdown-menu">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle">
              <span class="hidden-xs">Test</span>
            </a>
            <ul class="dropdown-menu">
            <li><a href="<?php echo BASEURL ?>multifuente/crear" >Crear test</a></li>
            <li><a href="<?php echo BASEURL ?>multifuente/ver" >Ver test</a></li>
            </ul>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle">
              <span class="hidden-xs">Temas/Preguntas</span>
            </a>
            <ul class="dropdown-menu">
            <li><a href="<?php echo BASEURL ?>multifuente/temas_crear" >Crear temas</a></li>
            <li><a href="<?php echo BASEURL ?>multifuente/preguntas_crear" >Crear Preguntas</a></li>
            </ul>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle">
              <span class="hidden-xs">Evaluados</span>
            </a>
            <ul class="dropdown-menu">
            <li><a href="<?php echo BASEURL ?>multifuente/eliminar" >Eliminar</a></li>
            <li><a href="<?php echo BASEURL ?>multifuente/ver_evaluados" >Ver Evaluados</a></li>
            </ul>
          </li>
        </ul>
      </li>  
      <li><a href="<?php echo BASEURL ?>admin/scorecard" >ScorerCard</a></li>
    </ul>
  </li>
  <li>
  <a href="<?php echo BASEURL ?>user/logout" >
      <i class="fa fa-power-off"></i>
      <span>Cerrar sesi&oacute;n</span>
    </a>
  </li>
</ul>