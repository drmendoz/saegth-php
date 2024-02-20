
<?php 

$meth=new Empresa();
//ADMIN
$nav_admin ='
<ul class="nav main-menu">
  <li class="dropdown">
    <a href="#" class="dropdown-toggle">
      <i class="fa fa-building-o"></i>
      <span class="hidden-xs">Empresa</span>
    </a>
    <ul class="dropdown-menu">
      <li><a href=LINKHEREadmin/ingresar_nueva >Ingresar nueva</a></li>
      <li><a href=LINKHEREadmin/viewall >Ver</a></li>
    </ul>
  </li> 
  <!--   
  <li class="dropdown">
    <a href="#" class="dropdown-toggle">
      <i class="fa fa-user"></i>
      <span class="hidden-xs">Personal</span>
    </a>
    <ul class="dropdown-menu">
      <li><a href=LINKHEREadmin/personal_viewall >Ver</a></li>
    </ul>
  </li>
--> 
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
            <li><a href=LINKHEREmultifuente/crear >Crear test</a></li>
            <li><a href=LINKHEREmultifuente/ver >Ver test</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle">
            <span class="hidden-xs">Temas/Preguntas</span>
          </a>
          <ul class="dropdown-menu">
            <li><a href=LINKHEREmultifuente/temas_crear >Crear temas</a></li>
            <li><a href=LINKHEREmultifuente/preguntas_crear >Crear Preguntas</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle">
            <span class="hidden-xs">Evaluados</span>
          </a>
          <ul class="dropdown-menu">
            <li><a href=LINKHEREmultifuente/eliminar >Eliminar</a></li>
            <li><a href=LINKHEREmultifuente/ver_evaluados >Ver Evaluados</a></li>
          </ul>
        </li>
      </ul>
    </li>  
    <li><a href=LINKHEREadmin/scorecard >ScorerCard</a></li>
  </ul>
</li>
<li>
  <a href=LINKHEREuser/logout >
    <i class="fa fa-power-off"></i>
    <span>Cerrar sesi&oacute;n</span>
  </a>
</li>
</ul>';
//USERS
$nav_user='
<ul class="nav main-menu"> 
  <li class="dropdown">
    <a href=LINKHEREempresa/consolidado class="dropdown-toggle">
      <i class="fa fa-building-o"></i>
      <span class="hidden-xs">Empresa</span>
    </a>
  </li>      
  <li>
    <a href=LINKHEREpersonal/datos_personales >
      <i class="fa fa-user"></i>
      <span class="hidden-xs">Modificar datos personales</span>
    </a>
  </li> 
  <li class="dropdown">
    <a href="#" class="dropdown-toggle">
      <i class="fa fa-area-chart"></i>
      <span class="hidden-xs">Compass 360</span>
    </a>
    <ul class="dropdown-menu">
      <li class="dropdown">
        <a href="#" class="dropdown-toggle">
          <span>Mi Compass 360</span>
        </a>
        <ul class="dropdown-menu">
          <li><a class="ajaxlink_navbar" href=#ajax-content/tabs-2 >Resultados</a></li>
          <li><a href=LINKHEREmultifuente/home >Información General</a></li>
          <li><a href=LINKHEREmultifuente/fortalezas >Items mejor puntuados</a></li>
          <li><a href=LINKHEREmultifuente/oportunidades >Oportunidades de mejora</a></li>
          <li><a href=LINKHEREmultifuente/comentarios >Comentarios</a></li>
        </ul>
      </li>
      <li><a href=LINKHEREmultifuente/home class="dropdown-toggle">Resultados de subalternos</a></li>
    </ul>
  </li>
  <li class="dropdown">
    <a href="#" class="dropdown-toggle">
      <i class="fa fa-line-chart"></i>
      <span class="hidden-xs">ScoreCard</span>
    </a>
    <ul class="dropdown-menu">
      <li><a class="ajaxlink_navbar" href=#ajax-content/tabs-3 >Mi scorecard</a></li>
      <li><a href=LINKHEREscorecard/home >Scorecard de subalternos</a></li>
    </ul>
  </li>
  <li>
    <a class="ajaxlink_navbar" href=#ajax-content/tabs-4 >
      <i class="fa fa-calendar-minus-o"></i>
      <span class="hidden-xs">Plan de accion</span>
    </a>
  </li>
  <li>
    <a class="ajaxlink_navbar" href=#ajax-content/tabs-5 >
      <i class="fa fa-calendar-minus-o"></i>
      <span class="hidden-xs">Preferencias de Desarrollo de Carrera</span>
    </a>
  </li>
  <li>
    <a href=LINKHEREuser/logout >
      <i class="fa fa-power-off"></i>
      <span class="hidden-xs">Cerrar sesi&oacute;n</span>
    </a>
  </li>
</ul>';
//EMPRESA
$nav_empresa = '
<ul class="nav main-menu">
  <li class="dropdown">
    <a href="#" class="dropdown-toggle">
      <i class="fa fa-building-o"></i>
      <span class="hidden-xs">Empresa</span>
    </a>
    <ul class="dropdown-menu">
      <li class="dropdown">
        <a href="#" class="dropdown-toggle">
          <span class="hidden-xs">Modificar</span>
        </a>
        <ul class="dropdown-menu">
          <li><a href=LINKHEREempresa/crear_areas>&Aacute;reas</a></li>
          <li><a href=LINKHEREempresa/localidades>Localidades</a></li>
          <li><a href=LINKHEREempresa/cargo>Cargos</a></li>
          <li><a href=LINKHEREempresa/niveles_organizacionales>Niveles Organizacionales</a></li>
          <li><a href=LINKHEREempresa/condicionadores>Condicionadores</a></li>
          <li><a href=LINKHEREempresa/tipo_contrato>Tipos de contrato</a></li>
          <li><a href=LINKHEREempresa/grado_salarial>Grado Salarial</a></li>
          <li><a href=LINKHEREempresa/logo>Logo</a></li>
        </ul>
      </li>
      <li><a href=LINKHEREempresa/consolidado>Ver</a></li>
    </ul>
  </li>    
  <li class="dropdown">
    <a href="#" class="dropdown-toggle">
      <i class="fa fa-user"></i>
      <span class="hidden-xs">Personal</span>
    </a>
    <ul class="dropdown-menu">
      <li><a href=LINKHEREpersonal/datos_empresa>Ingresar Nuevo</a></li>
      <li><a href=LINKHEREpersonal/viewall>Ver</a></li>
    </ul>
  </li>
  <li class="dropdown">
    <a href="#" class="dropdown-toggle">
      <i class="fa fa-bar-chart"></i>
      <span class="hidden-xs">Compass 360</span>
    </a>
    <ul class="dropdown-menu">
      <li><a href=LINKHEREmultifuente/home >Información general</a></li>
      <li><a href=LINKHEREmultifuente/progreso >Estado de selección de evaluadores</a></li>
      <li><a href=LINKHEREmultifuente/asignar_test >Asignar evaluacion</a></li>
      <li><a href=LINKHEREmultifuente/eliminar >Eliminar evaluados</a></li>
    </ul>
  </li>
  <li class="dropdown">
    <a href="#" class="dropdown-toggle">
      <i class="fa fa-line-chart"></i>
      <span class="hidden-xs">ScoreCard</span>
    </a>
    <ul class="dropdown-menu">
      <li><a href=LINKHEREempresa/scorecard >Ficha scorecard</a></li>
      <li><a href=LINKHEREscorecard/admin >Información general</a></li>
    </ul>
  </li>
  <li class="dropdown">
    <a href=LINKHEREtest/matriz class="dropdown-toggle">
      <i class="glyphicon glyphicon-tasks fa-rotate-270"></i>
      <span class="hidden-xs">Matriz</span>
    </a>
  </li>
  <li>
    <a href=LINKHEREtest/cobertura >
      <i class="fa fa-rss"></i>
      <span class="hidden-xs">Cobertura</span>
    </a>
  </li>
  <li>
    <a href=LINKHEREtest/riesgo_retencion>
      <i class="fa fa-lock"></i>
      <span class="hidden-xs">Riesgo de retención</span>
    </a>
  </li>
  <li class="dropdown">
    <a href=LINKHEREuser/tests/valoracion class="dropdown-toggle">
      <i class="fa fa-star-half-o"></i>
      <span class="hidden-xs">Valoracion de cargos</span>
    </a>
  </li>
  <li class="dropdown">
    <a href="#" class="dropdown-toggle">
      <i class="fa fa-signal"></i>
      <span class="hidden-xs">Sonda</span>
    </a>
    <ul class="dropdown-menu">
      <li><a href=LINKHEREsonda/clima_laboral >Definir</a></li>
      <li><a href=LINKHEREuser/tests/s_res >Resultados</a></li>
    </ul>
  </li>
  <li class="dropdown">
    <a href="#" class="dropdown-toggle">
      <i class="fa fa-exclamation"></i>
      <span class="hidden-xs">Riesgo Psicosocial</span>
    </a>
    <ul class="dropdown-menu">
      <li><a href=LINKHEREriesgo_psicosocial/evaluacion >Definir</a></li>
      <li><a href=LINKHEREriesgo_psicosocial/resultados >Resultados</a></li>
    </ul>
  </li>
  <li>
    <a href=LINKHEREuser/logout >
      <i class="fa fa-power-off"></i>
      <span class="hidden-xs">Cerrar sesi&oacute;n</span>
    </a>
  </li>
</ul>';
$nav_temp = '
<ul class="nav main-menu">
  <li>
    <a href=LINKHEREuser/logout >
      <i class="fa fa-power-off"></i>
      <span class="hidden-xs">Cerrar sesi&oacute;n</span>
    </a>
  </li>
</ul>
';

$nav_admin = Util::nav_encode($nav_admin);
$meth->query('UPDATE navbar SET navbar="'.$nav_admin.'" WHERE user_rol=0');
echo mysqli_error($meth->link);
$nav_empresa = Util::nav_encode($nav_empresa);
$meth->query('UPDATE navbar SET navbar="'.$nav_empresa.'" WHERE user_rol=1');
echo mysqli_error($meth->link);
$nav_user = Util::nav_encode($nav_user);
$meth->query('UPDATE navbar SET navbar="'.$nav_user.'" WHERE user_rol=2');
echo mysqli_error($meth->link);
$nav_temp = Util::nav_encode($nav_temp);
$meth->query('UPDATE navbar SET navbar="'.$nav_temp.'" WHERE user_rol=4');
echo mysqli_error($meth->link);
switch ($_SESSION['USER-AD']['user_rol']) {
  case 0:
  $_SESSION['navbar'] = Util::nav_decode($nav_admin);
  break;
  case 1:
  $_SESSION['navbar'] = Util::nav_decode($nav_empresa);
  break;
  case 2:
  $_SESSION['navbar'] = Util::nav_decode($nav_user);
  break;
  case 4:
  $_SESSION['navbar'] = Util::nav_decode($nav_temp);
  break;
}



?>