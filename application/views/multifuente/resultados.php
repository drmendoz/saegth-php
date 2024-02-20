<style type="text/css">
table#multifuente_resultados tr > td:first-child{
    width: 8px;
    text-align: center;
  }
  .header-tab{width: 81px}
</style>
<?php $meth = new User(); $util = new Util(); ?>
<div class="form-group col-md-12">
  <img src="<?php echo BASEURL ?>img/Compass.png" style="width: 260px;">
</div>
<div class="form-group col-md-12">
  <table class="table-bordered"  style="width: 100%; line-height: 40px;">
    <tr>
      <td class="col-md-4"><b>PERSONAL: </b><?php echo $meth->htmlprnt($nombre); ?></td>
      <td class="col-md-4"><b>CARGO: </b><?php echo $meth->htmlprnt($cargo); ?></td>
      <td class="col-md-4"><b>SUPERVISOR DIRECTO: </b><?php echo $meth->htmlprnt($superior); ?></td>
    </tr>
    <tr>
      <td class="col-md-4"><b>EMPRESA: </b><?php echo $meth->htmlprnt($_SESSION['Empresa']['nombre']); ?></td>
      <td class="col-md-4"><b>&Aacute;REA: </b><?php echo $meth->htmlprnt($area); ?></td>
      <td class="col-md-4"><b>FECHA DE EVALUACION: </b><?php echo $meth->print_fecha($fecha); ?></td>
    </tr>
  </table>
</div>
<div class="form-group clearfix">
  <div class="col-md-8">
    <table id="multifuente_resultados" class="table-bordered" style="width: 100%;  line-height: 15px;">
      <tr>
        <td width="8">#</td>
        <td class="col-md-8">Tema</td>
        <th class="text-center">Persona</th>
        <th class="text-center">Empresa</th>
        <th hidden class="text-center">Mercado</th>
      </tr>
      <?php
      $ger=$auto=$par=$sub=$tem=$promedio['empresa']=$promedio['global']=$promedio['persona']=array();
      ?>

      <?php foreach ($temas as $a => $b) { 
        $tema=$meth->get_tema($b);
        //if($a>3) break;
        array_push($tem, $b);
        array_push($ger, $meth->getAvg_tema_eval_rango($b,$cod_evaluado,"Gerente"));
        array_push($auto, $meth->getAvg_tema_eval_rango($b,$cod_evaluado,"Auto"));
        array_push($par, $meth->getAvg_tema_eval_rango($b,$cod_evaluado,"Par"));
        array_push($sub, $meth->getAvg_tema_eval_rango($b,$cod_evaluado,"Subalterno"));
        ?>
        <tr>
          <td><?php echo ($a+1) ?></td>
          <td class="col-md-8" align="justify">
            <p><a class="ajaxlink" href="<?php echo '#tabs-2/multifuente/tema/'.$id.'/'.$b ?>"><?php echo Util::htmlprnt($tema['tema']) ?></a><?php echo Util::htmlprnt($tema['descripcion']) ?></p>
          </td>
          <!-- PROMEDIO EVALUADO -->
          <?php //$prom = $meth->getAvg_tema_eval($b,$cod_evaluado); ?>
          <?php $prom = $meth->getAvg_tema_eval_($b,$cod_evaluado); if($prom != 0){array_push($promedio['persona'], $prom);} ?>
          <td class="no-padding text-center" bgcolor="<?php echo $meth->get_color($prom); ?>"><font size="-2" color="<?php if ($prom < 1.66) echo "#FFFFFF"; ?>"><b><?php printf("%.2f", $prom); ?></b></font></td>
          <!-- PROMEDIO EMPRESA -->
          <?php //$p_emp = $meth->getInAvg_tema($b,$_SESSION['Empresa']['id']); array_push($promedio['empresa'], $p_emp);  ?>  
          <?php $p_emp = $meth->getInAvg_tema_($b,$_SESSION['Empresa']['id']); if($p_emp != 0){array_push($promedio['empresa'], $p_emp);}  ?>
          <td class="no-padding text-center" bgcolor="<?php echo $meth->get_color($p_emp); ?>"><font size="-2" color="<?php if ($p_emp < 1.66) echo "#FFFFFF"; ?>"><b><?php printf("%.2f", $p_emp); ?></b></font></td>
          <!-- PROMEDIO GLOBAL -->
          <?php // $p_glob = $meth->getAvg_tema($b); array_push($promedio['global'], $p_glob);  ?>  
          <td hidden class="no-padding text-center" bgcolor="<?php // echo $meth->get_color($p_glob); ?>"><font size="-2" color="<?php if ($p_glob < 1.66) echo "#FFFFFF"; ?>"><b><?php // printf("%.2f", $p_glob); ?></b></font></td>
        </tr>      
        <?php } ?>
        <tr>
          <td class="col-md-1">#</td>
          <td class="col-md-10"><h4>Promedio General:</h4></td>
          <?php 
          //$pr_general =  $meth->getAvg_test_eval($cod_evaluado); 
          $pr_general = array_sum($promedio['persona'])/sizeof($promedio['persona']);
          $p_emp = array_sum($promedio['empresa'])/sizeof($promedio['empresa']);
          // $p_glob = array_sum($promedio['global'])/sizeof($promedio['global']);
          ?>
          <td class="col-md-1 text-center" bgcolor="<?php echo $meth->get_color($pr_general); ?>" style="padding: 0 10px;"><font size="-2" color="<?php if ($pr_general < 1.66) echo "#FFFFFF"; ?>"><b><?php printf("%.2f", $pr_general); ?></b></font></td>
          <td class="col-md-1 text-center" bgcolor="<?php echo $meth->get_color($p_emp); ?>" style="padding: 0 10px;"><font size="-2" color="<?php if ($p_emp < 1.66) echo "#FFFFFF"; ?>"><b><?php printf("%.2f", $p_emp); ?></b></font></td>
          <td hidden class="col-md-1 text-center" bgcolor="<?php //echo $meth->get_color($p_glob); ?>" style="padding: 0 10px;"><font size="-2" color="<?php //if ($p_glob < 1.66) echo "#FFFFFF"; ?>"><b><?php // printf("%.2f", $p_glob); ?></b></font></td>
        </tr>
      </table>
    </div>
    <div class="col-md-4 text-center">
      <?php
      $auto = array_sum($auto)/sizeof($auto);
      $ger = array_sum($ger)/sizeof($ger);
      $par = array_sum($par)/sizeof($par);
      $sub = array_sum($sub)/sizeof($sub);
      $array=array($auto,$ger,$par,$sub);
      $array = serialize($array);
      $array = urlencode($array);
      // $graph = new GraficaController('Grafica','grafica','multifuente_op');
      // $testf = $graph->multifuente_op($array,true);
      ?>    
      <div class="box">
        <div class="box-header">
          <div class="box-icons">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>
            <a class="expand-link">
              <i class="fa fa-expand"></i>
            </a>
          </div>
          <div class="no-move"></div>
        </div>
        <div class="box-content text-center expand-link">
          <fieldset>
            <img src="<?php echo BASEURL ?>grafica/multifuente/<?php echo $array; ?>  " style="width:100%; height:auto;" class="col-md-12">
              <table class="table table-bordered">
                <tr>
                  <th colspan="4">
                    Evaluadores seleccionados
                  </th>
                </tr>
                <tr>
                  <td>Auto</td>
                  <td>Gerente</td>
                  <td>Pares</td>
                  <td>Subalternos</td>
                </tr>
                <tr>
                  <td class="col-xs-3">1</td>
                  <td class="col-xs-3"><?php echo Multifuente::getEvaluadores($id,1,$cod_evaluado) ?></td>
                  <td class="col-xs-3"><?php echo Multifuente::getEvaluadores($id,2,$cod_evaluado) ?></td>
                  <td class="col-xs-3"><?php echo Multifuente::getEvaluadores($id,3,$cod_evaluado) ?></td>
                </tr>
                <tr>
                  <th colspan="4">
                    Evaluaciones resueltas
                  </th>
                </tr>
                <tr>
                  <td class="col-xs-3"><?php echo Multifuente::esResuelto($cod_evaluado) ?></td>
                  <td class="col-xs-3"><?php echo Multifuente::countResueltos($id,1,$cod_evaluado) ?></td>
                  <td class="col-xs-3"><?php echo Multifuente::countResueltos($id,2,$cod_evaluado) ?></td>
                  <td class="col-xs-3"><?php echo Multifuente::countResueltos($id,3,$cod_evaluado) ?></td>
                </tr>
              </table>
          </fieldset>
        </div>
      </div>
    </div>
  </div>
  <div class="row form-group text-center">
    <?php $plan_de_accion = ($id==$_SESSION['USER-AD']['id_personal']) ? 'onclick="mostrar_plan()"' : 'href="'.BASEURL.'multifuente/comentarios/'.$id.'"'; ?>
    <a  class="btn-primary btn-xs " <?php echo $plan_de_accion ?> style="padding: 7px 5px; margin:5px 0">Visualizar plan de Acci&oacute;n</a>
    <a  class="btn-primary btn-xs " href="<?php echo BASEURL.'multifuente/comentarios/'.$id ?>"  style="padding: 7px 5px; margin:5px 0">Ver comentarios</a>
    <a href="<?php echo BASEURL.'pdf/multifuente/'.$id.DS.$_SESSION['evaluado']['id'] ?>" class="btn-info btn-xs" style="padding: 7px 5px; margin:5px 0">Descargar resultados como PDF</a>
  </div>
  <?php  if(isset($_SESSION['evaluado']['otras'])) { //var_dump($_SESSION['evaluado']['otras'])?>
  <div class="row form-group text-center col-md-8 col-md-offset-2">
    <p>Ver otras evaluaciones</p>
    <table>
      <thead align="center">
        <tr>
          <th align="center">Reportes Compass 360 previos</th>
          <th align="center">Fecha</th>
        </tr>
      </thead>
      <tbody align="left">
       <?php foreach ($_SESSION['evaluado']['otras'] as $a => $b) { ?>
       <tr>
        <td class="col-md-4"><p><a href="<?php echo BASEURL.'multifuente/resultados/'.$id.'/'.$b['cod_test'].'/'.$b['cod_evaluado'] ?>"><?php echo $meth->get_test($b['cod_test']) ?></a></p></td>
        <td class="col-md-4"><p><?php echo date("F j, Y", strtotime($b['fecha'])); ?></p></td>
      </tr>              
      <?php } ?>
    </tbody>
  </table>
</div>
<?php } ?>