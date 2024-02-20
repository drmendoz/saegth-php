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

          <li><a href='<?php echo BASEURL ?>empresa/crear_areas'>&Aacute;reas</a></li>

          <li><a href='<?php echo BASEURL ?>empresa/localidades'>Localidades</a></li>

          <li><a href='<?php echo BASEURL ?>empresa/cargo'>Cargos</a></li>

          <li><a href='<?php echo BASEURL ?>empresa/niveles_organizacionales'>Niveles Organizacionales</a></li>

          <li><a href='<?php echo BASEURL ?>empresa/condicionadores'>Condicionadores</a></li>

          <li><a href='<?php echo BASEURL ?>empresa/tipo_contrato'>Tipos de contrato</a></li>

          <li><a href='<?php echo BASEURL ?>empresa/grado_salarial'>Grado Salarial</a></li>

          <li><a href='<?php echo BASEURL ?>empresa/logo'>Logo</a></li>

        </ul>

      </li>

      <li><a href='<?php echo BASEURL ?>empresa/consolidado'>Ver</a></li>

    </ul>

  </li>    

  <li class="dropdown">

    <a href="#" class="dropdown-toggle">

      <i class="fa fa-user"></i>

      <span class="hidden-xs">Personal</span>

    </a>

    <ul class="dropdown-menu">

      <li><a href='<?php echo BASEURL ?>personal/datos_empresa'>Ingresar Nuevo</a></li>

      <!-- <li><a href='<?php echo BASEURL ?>personal/viewall_deprecated'>Ver</a></li> -->

      <li><a href='<?php echo BASEURL ?>personal/viewall'>Ver</a></li>

    </ul>

  </li>

  <!-- Compass 360 -->

  <?php if ($permiso['compass_360']) { ?>

  <li class="dropdown">

    <a href="#" class="dropdown-toggle">

      <i class="fa fa-bar-chart"></i>

      <span class="hidden-xs">Compass 360</span>

    </a>

    <ul class="dropdown-menu">

      <li><a href='<?php echo BASEURL ?>multifuente/home' >Información general</a></li>

      <li><a href='<?php echo BASEURL ?>multifuente/progreso' >Estado de selección de evaluadores</a></li>

      <li><a href='<?php echo BASEURL ?>multifuente/asignar_test' >Asignar evaluacion</a></li>

      <li><a href='<?php echo BASEURL ?>multifuente/eliminar' >Eliminar evaluados</a></li>

    </ul>

  </li>

  <?php } else { ?>

  <li>

    <a href='#' class="denied" >

      <i class="fa fa-bar-chart"></i>

      <span class="hidden-xs">Compass 360</span>

    </a>

  </li>

  <?php } ?>

  <!-- Score Card -->

  <?php if ($permiso['scorer']) { ?>

  <li class="dropdown">

    <a href="#" class="dropdown-toggle">

      <i class="fa fa-line-chart"></i>

      <span class="hidden-xs">ScoreCard</span>

    </a>

    <ul class="dropdown-menu">

      <li><a href='<?php echo BASEURL ?>scorecard/ficha' >Ficha scorecard</a></li>

      <li><a href='<?php echo BASEURL ?>scorecard/admin' >Información general</a></li>

      <?php  

      $sd = new scorecard();

      $sd->select($_SESSION['Empresa']['id']);

      $hey = $sd->getPeriodos();

      if (sizeof($hey)>1) {

        unset($hey[0]);

        foreach ($hey as $key => $value) {

          ?>

          <li><a href='<?php echo BASEURL ?>scorecard/periodo/<?php echo $value ?>' >Información periodo - <?php echo $value; ?></a></li>

          <?php  

        }

      }

      ?>

      <li class="dropdown">

        <a href="#" class="dropdown-toggle">

          <span class="hidden-xs">Estado del proceso por periodo</span>

        </a>



        <ul class="dropdown-menu">

        <li><a href='<?php echo BASEURL ?>scorecard/estado_proceso' >Actual</a></li>

          <?php 

          foreach ($hey as $key => $value) {

            ?>

            <li><a href='<?php echo BASEURL ?>scorecard/estado_proceso/<?php echo $value ?>' ><?php echo $value; ?></a></li>

            <?php  

          }

          ?>

        </ul>

      </li>

    </ul>

  </li>

  <?php } else { ?>

  <li>

    <a href="#" class="denied">

      <i class="fa fa-line-chart"></i>

      <span class="hidden-xs">ScoreCard</span>

    </a>

  </li>

  <?php } ?>

  <?php if ($permiso['matriz']) { ?>

  <li>

    <a href='<?php echo BASEURL ?>test/matriz' class="dropdown-toggle">

      <i class="glyphicon glyphicon-tasks fa-rotate-270"></i>

      <span class="hidden-xs">Matriz</span>

    </a>

  </li>

  <?php } else { ?>

  <li>

    <a class="denied">

      <i class="glyphicon glyphicon-tasks fa-rotate-270"></i>

      <span class="hidden-xs">Matriz</span>

    </a>

  </li>

  <?php } ?>

  <?php if ($permiso['cobertura']) { ?>

  <li>

    <a href='<?php echo BASEURL ?>test/cobertura' >

      <i class="fa fa-rss"></i>

      <span class="hidden-xs">Cobertura</span>

    </a>

  </li>

  <?php } else { ?>

  <li>

    <a href='#' class="denied">

      <i class="fa fa-rss"></i>

      <span class="hidden-xs">Cobertura</span>

    </a>

  </li>

  <?php } ?>

  <?php if ($permiso['retencion']) { ?>

  <li>

    <a href='<?php echo BASEURL ?>test/riesgo_retencion'>

      <i class="fa fa-lock"></i>

      <span class="hidden-xs">Riesgo de retención</span>

    </a>

  </li>

  <?php } else { ?>

  <li>

    <a href='#' class="denied">

      <i class="fa fa-lock"></i>

      <span class="hidden-xs">Riesgo de retención</span>

    </a>

  </li>

  <?php } ?>

  <?php if ($permiso['valoracion']) { ?>

  <li class="dropdown">

    <a href='<?php echo BASEURL ?>user/tests/valoracion' class="dropdown-toggle">

      <i class="fa fa-star-half-o"></i>

      <span class="hidden-xs">Valoracion de cargos</span>

    </a>

  </li>

  <?php } else { ?>

  <?php } ?>

  <?php if ($permiso['clima_laboral']) { ?>

  <li class="dropdown">

    <a id="a_sonda" href="#" class="dropdown-toggle">

      <i class="fa fa-signal"></i>

      <span class="hidden-xs">Sonda</span>

    </a>

    <ul class="dropdown-menu">

      <li><a href='<?php echo BASEURL ?>sonda/tema' >Crear Temas</a></li>

      <li><a href='<?php echo BASEURL ?>sonda/clima_laboral' >Definir</a></li>

      <li class="dropdown">
        <!--<a href='<?php //echo BASEURL ?>user/tests/s_res' >Resultados</a>-->
        <a id="a_res" href="#" class="dropdown-toggle">

          <i class="fa fa-signal"></i>

          <span class="hidden-xs">Resultados</span>

        </a>
        
        <ul class="dropdown-menu">

          <li><a id="li_his" style="margin-left: 30px;" href='<?php echo BASEURL ?>user/tests/s_his' >Resultados de Encuestas</a></li>

          <li><a id="li_cres" style="margin-left: 30px;" href='<?php echo BASEURL ?>user/tests/s_cres' >Comparar Encuestas</a></li>

          <li><a id="li_seg" style="margin-left: 30px;" href='<?php echo BASEURL ?>sonda/segmentacion' >Comparar Criterios</a></li>

        </ul>
      
      </li>

      <li class="dropdown">
        
        <a id="g_af" href="#" class="dropdown-toggle">

          <i class="fa fa-signal"></i>

          <span class="hidden-xs">Identificador de Grupos Cr&iacute;ticos</span>

        </a>
        
        <ul class="dropdown-menu">

          <li><a id="af_ac" style="margin-left: 30px;" href='<?php echo BASEURL ?>user/tests/periodo_actual' >Sonda Actual</a></li>

          <li><a id="af_an" style="margin-left: 30px;" href='#' >Sondas Anteriores</a></li>
          
        </ul>
      
      </li>

    </ul>

  </li>

  <?php } else { ?>

  <li>

    <a href="#" class="denied">

      <i class="fa fa-signal"></i>

      <span class="hidden-xs">Sonda</span>

    </a>

  </li>

  <?php } ?>

  <?php if ($permiso['psicosocial']) { ?>

  <li class="dropdown">

    <a href="#" class="dropdown-toggle">

      <i class="fa fa-exclamation"></i>

      <span class="hidden-xs">Riesgo Psicosocial</span>

    </a>

    <ul class="dropdown-menu">

      <li><a href='<?php echo BASEURL ?>riesgo_psicosocial/evaluacion' >Definir</a></li>

      <li><a href='<?php echo BASEURL ?>riesgo_psicosocial/resultados' >Resultados</a></li>

    </ul>

  </li>

  <?php } else { ?>

  <li>

    <a href="#" class="denied">

      <i class="fa fa-exclamation"></i>

      <span class="hidden-xs">Riesgo Psicosocial</span>

    </a>

  </li>

  <?php } ?>

  <li>

    <a href='<?php echo BASEURL ?>reporte/respaldo'>

      <i class="fa fa-download" aria-hidden="true"></i>

      <span class="hidden-xs">Respaldo</span>

    </a>

  </li>

  <li>

    <a href='<?php echo BASEURL ?>user/logout' >

      <i class="fa fa-power-off"></i>

      <span class="hidden-xs">Cerrar sesi&oacute;n</span>

    </a>

  </li>

</ul>