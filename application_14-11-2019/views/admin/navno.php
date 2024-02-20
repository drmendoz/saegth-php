<?php 

$meth=new Empresa();
//ADMIN
  $nav_admin ='<ul class="nav main-menu">
        <li>
          <a href="#">
            <i class="fa fa-building-o"></i>
            <span class="hidden-xs">Empresa</span>
          </a>
          <ul>
            <li><a href=LINKHEREadmin/ingresar_nueva >Ingresar nueva</a></li>
            <li><a href=LINKHEREadmin/viewall >Ver</a></li>
          </ul>
        </li> 
        <!--   
        <li>
          <a href="#">
            <i class="fa fa-user"></i>
            <span class="hidden-xs">Personal</span>
          </a>
          <ul>
            <li><a href=LINKHEREadmin/personal_viewall >Ver</a></li>
          </ul>
        </li>
        --> 
        <li>
          <a href="#">
            <i class="fa fa-area-chart"></i>
             <span class="hidden-xs">Evaluaciones</span>
          </a>
          <ul>
            <li>
              <a href="#">
                <span class="hidden-xs">Multifuentes</span>
              </a>
              <ul>
                <li>
                  <a href="#">
                    <span class="hidden-xs">Test</span>
                  </a>
                  <ul>
                    <li><a href=LINKHEREmultifuente/crear >Crear test</a></li>
                    <li><a href=LINKHEREmultifuente/ver >Ver test</a></li>
                  </ul>
                </li>
                <li>
                  <a href="#">
                    <span class="hidden-xs">Temas/Preguntas</span>
                  </a>
                  <ul>
                    <li><a href=LINKHEREmultifuente/temas_crear >Crear temas</a></li>
                    <li><a href=LINKHEREmultifuente/preguntas_crear >Crear Preguntas</a></li>
                  </ul>
                </li>
                <li>
                  <a href="#">
                    <span class="hidden-xs">Evaluados</span>
                  </a>
                  <ul>
                    <li><a href=LINKHEREmultifuente/eliminar >Eliminar</a></li>
                    <li><a href=LINKHEREmultifuente/ver_evaluados >Ver Evaluados</a></li>
                  </ul>
                </li>
              </ul>
            </li>  
            <li><a href=LINKHEREadmin/scorecard >ScorerCard</a></li>
          </ul>
        </li>
      </ul>';
//USERS
$nav_user='<ul class="nav main-menu"> 
        <li>
          <a href="#">
            <i class="fa fa-building-o"></i>
            <span class="hidden-xs">Empresa</span>
          </a>
          <ul>
            <li><a href=LINKHEREempresa/consolidado >Ver datos de empresa</a></li>
          </ul>
        </li>      
        <li>
          <a href="#">
            <i class="fa fa-user"></i>
            <span class="hidden-xs">Personal</span>
          </a>
          <ul>
            <li><a href=LINKHEREuser/view >Ver datos</a></li>
            <li>
              <a href="#">
                <span class="hidden-xs">Ingresar datos</span>
              </a>
              <ul>
                <li><a href=LINKHEREpersonal/datos >Datos personales</a></li>
                <li><a href=LINKHEREpersonal/datos_familiar >Estado Civil</a></li>
                <li><a href=LINKHEREpersonal/educacion >Educaci&oacute;n</a></li>
                <li><a href=LINKHEREpersonal/ubicacion >Ubicaci&oacute;n</a></li>
              </ul>
            </li>
          </ul>
        </li> 
        <li>
          <a href="#">
            <i class="fa fa-area-chart"></i>
            <span class="hidden-xs">Compass 360</span>
          </a>
          <ul>
            <li><a href=LINKHEREmultifuente/home >Principal</a></li>
            <li><a href=LINKHEREmultifuente/resultados >Resultados</a></li>
            <li><a href=LINKHEREmultifuente/fortalezas >Items mejor puntuados</a></li>
            <li><a href=LINKHEREmultifuente/oportunidades >Oportunidades de mejora</a></li>
            <li><a href=LINKHEREmultifuente/comentarios >Recomendaciones</a></li>
          </ul>
        </li>
        <li>
          <a href="#">
            <i class="fa fa-line-chart"></i>
            <span class="hidden-xs">ScoreCard</span>
          </a>
          <ul>
            <li><a href=LINKHEREuser/tests/scorer >Tablero de control</a></li>
            <li><a href=LINKHEREscorecard/home >Información General</a></li>
          </ul>
        </li>
      </ul>';
      //EMPRESA
$nav_empresa = '<ul class="nav main-menu">
        <li>
          <a href="#">
            <i class="fa fa-building-o"></i>
            <span class="hidden-xs">Empresa</span>
          </a>
          <ul>
            <li>
              <a href="#">
                <span class="hidden-xs">Modificar</span>
              </a>
              <ul>
                <li><a href=LINKHEREempresa/crear_areas>&Aacute;reas</a></li>
                <li><a href=LINKHEREempresa/localidades>Localidades</a></li>
                <li><a href=LINKHEREempresa/cargo>Cargos</a></li>
                <li><a href=LINKHEREempresa/niveles_organizacionales>Niveles Organizacionales</a></li>
                <li><a href=LINKHEREempresa/condicionadores>Condicionadores</a></li>
                <li><a href=LINKHEREempresa/logo>Logo</a></li>
              </ul>
            </li>
            <li><a href=LINKHEREempresa/consolidado>Ver</a></li>
          </ul>
        </li>    
        <li>
          <a href="#">
            <i class="fa fa-user"></i>
            <span class="hidden-xs">Personal</span>
          </a>
          <ul>
            <li><a href=LINKHEREpersonal/datos_empresa>Ingresar Nuevo</a></li>
            <li><a href=LINKHEREpersonal/viewall>Ver</a></li>
          </ul>
        </li>
        <li>
          <a href="#">
            <i class="fa fa-area-chart"></i>
            <span class="hidden-xs">Compass 360</span>
          </a>
          <ul>
            <li><a href=LINKHEREmultifuente/home >Información general</a></li>
            <li><a href=LINKHEREmultifuente/eliminar >Eliminar evaluados</a></li>
          </ul>
        </li>
        <li>
          <a href="#">
            <i class="fa fa-line-chart"></i>
            <span class="hidden-xs">ScoreCard</span>
          </a>
          <ul>
            <li><a href=LINKHEREempresa/scorecard >Ficha scorecard</a></li>
            <li><a href=LINKHEREscorecard/admin >Información general</a></li>
          </ul>
        </li>
        <li>
          <a href=LINKHEREtest/matriz>
            <i class="fa fa-bar-chart-o"></i>
            <span class="hidden-xs">Matriz</span>
          </a>
        </li>
      </ul>';
  $nav_admin = Util::nav_encode($nav_admin);
  $meth->query('UPDATE navbar SET navbar="'.$nav_admin.'" WHERE user_rol=0');
  echo mysqli_error($meth->link);
  $nav_empresa = Util::nav_encode($nav_empresa);
  $meth->query('UPDATE navbar SET navbar="'.$nav_empresa.'" WHERE user_rol=1');
  echo mysqli_error($meth->link);
  $nav_user = Util::nav_encode($nav_user);
  $meth->query('UPDATE navbar SET navbar="'.$nav_user.'" WHERE user_rol=2');
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
  }

  
?>
