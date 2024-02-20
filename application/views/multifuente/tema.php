<?php $meth = new User(); $util = new Util(); //var_dump($preg)?>
<div class="form-group col-md-12">
  <img src="<?php echo BASEURL ?>img/Compass.png" style="width: 260px;">
</div>
<div class="form-group col-md-12">
  <table class="table-bordered"  style="width: 100%; line-height: 40px;">
    <tr>
      <td class="col-md-4"><b>PERSONAL: </b><?php echo $meth->htmlprnt($nombre);?></td>
      <td class="col-md-4"><b>CARGO: </b><?php echo $meth->htmlprnt($cargo);?></td>
      <td class="col-md-4"><b>SUPERVISOR DIRECTO: </b><?php echo $meth->htmlprnt($superior);?></td>
    </tr>
    <tr>
      <td class="col-md-4"><b>EMPRESA: </b><?php echo $meth->htmlprnt($_SESSION['Empresa']['nombre']); ?></td>
      <td class="col-md-4"><b>&Aacute;REA: </b><?php echo $meth->htmlprnt($area);?></td>
      <td class="col-md-4"><b>FECHA DE EVALUACION: </b><?php echo $meth->print_fecha($fecha); ?></td>
    </tr>
  </table>
</div>
<div class="form-group">
<div class="col-md-8">
    <table class="table-bordered" style="width: 100%;  line-height: 15px;">
      <tr>
        <td colspan="2" class="col-md-12"><p><b><?php echo Util::htmlprnt($pr['tema']) ?></b><a class="ajaxlink" href="<?php echo "#tabs-2/".$backlink ?>"><?php echo Util::htmlprnt($pr['descripcion']) ?></a></p></td>
        <th class="text-center">Persona</th>
        <th class="text-center">Empresa</th>
        <th hidden class="text-center">Mercado</th>
      </tr>
      <?php
      $ger=$auto=$par=$sub=$tick=$promedio['empresa']=$promedio['global']=array();
      ?>
      <?php foreach ($preg as $a => $b) { 
        $p=$meth->get_preg($b);
        array_push($tick, $a + 1);
        array_push($ger, $meth->getAvg_preg_rang($b,$cod_evaluado,"Gerente"));
        array_push($auto, $meth->getAvg_preg_rang($b,$cod_evaluado,"Auto"));
        array_push($par, $meth->getAvg_preg_rang($b,$cod_evaluado,"Par"));
        array_push($sub, $meth->getAvg_preg_rang($b,$cod_evaluado,"Subalterno"));
        ?>
        <tr>
          <td class="col-md-1"><?php echo ($a+1) ?></td>
          <td class="col-md-10" align="justify">
            <p><a class="ajaxlink" href="<?php echo '#tabs-2/multifuente/pregunta/'.$id.'/'.$b ?>"><?php echo $meth->htmlprnt_win($p) ?></a></p>
          </td>
          <!-- PROMEDIO EVALUADO -->
          <?php $prom = $meth->getAvg_preg_eval($b,$cod_evaluado); ?>
          <td class="no-padding text-center" bgcolor="<?php echo $meth->get_color($prom); ?>" style="padding: 0 10px;"><font size="-2" color="<?php if ($prom < 1.66) echo "#FFFFFF"; ?>"><b><?php printf("%.2f", $prom); ?></b></font></td>
          <?php //$p_emp = $meth->getInAvg_preg($preg[$a],$_SESSION['Empresa']['id']); array_push($promedio['empresa'], $p_emp);?>  
          <?php $p_emp = $meth->getInAvg_preg_($preg[$a],$_SESSION['Empresa']['id']); array_push($promedio['empresa'], $p_emp);?>  
          <!-- PROMEDIO EMPRESA -->
          <td class="no-padding text-center" bgcolor="<?php echo $meth->get_color($p_emp); ?>" style="padding: 0 10px;"><font size="-2" color="<?php if ($p_emp < 1.66) echo "#FFFFFF"; ?>"><b><?php printf("%.2f", $p_emp); ?></b></font></td>
          <?php //$p_glob = $meth->getAvg_preg($preg[$a]); array_push($promedio['global'], $p_glob);?>  
          <!-- PROMEDIO GLOBAL -->
          <td hidden class="no-padding text-center" bgcolor="<?php // echo $meth->get_color($p_glob); ?>" style="padding: 0 10px;"><font size="-2" color="<?php // if ($p_glob < 1.66) echo "#FFFFFF"; ?>"><b><?php // printf("%.2f", $p_glob); ?></b></font></td>
        </tr>      
        <?php  } ?>
        <tr>
          <td class="col-md-1">#</td>
          <td class="col-md-10"><h4>Promedio General:</h4></td>
          <?php 
          //$pr_general = $meth->getAvg_tema_eval($cod_tema,$cod_evaluado);
          //$p_emp = array_sum($promedio['empresa'])/sizeof($promedio['empresa']);
          $pr_general = $meth->getAvg_tema_eval_($cod_tema,$cod_evaluado);
          $p_emp = $meth->getInAvg_tema_($cod_tema,$_SESSION['Empresa']['id']);
          //$p_glob = array_sum($promedio['global'])/sizeof($promedio['global']);
          ?>
          <td class="col-md-1 text-center" bgcolor="<?php echo $meth->get_color($pr_general); ?>" style="padding: 0 10px;"><font size="-2" color="<?php if ($pr_general < 1.66) echo "#FFFFFF"; ?>"><b><?php printf("%.2f", $pr_general); ?></b></font></td>
          <td class="col-md-1 text-center" bgcolor="<?php echo $meth->get_color($p_emp); ?>" style="padding: 0 10px;"><font size="-2" color="<?php if ($p_emp < 1.66) echo "#FFFFFF"; ?>"><b><?php printf("%.2f", $p_emp); ?></b></font></td>
          <td hidden class="col-md-1 text-center" bgcolor="<?php //echo $meth->get_color($p_glob); ?>" style="padding: 0 10px;"><font size="-2" color="<?php //if ($p_glob < 1.66) echo "#FFFFFF"; ?>"><b><?php //printf("%.2f", $p_glob); ?></b></font></td>
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
      // $testf = $graph->multifuente_op($array,false);
        //var_dump($array);
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
        <div class="box-content no-padding text-center expand-link">
          <fieldset>
            <img src="<?php echo BASEURL ?>grafica/multifuente/<?php echo $array; ?>  " style="width:100%; height:auto;" class="col-md-12">
            <!-- <img src="<?php //echo BASEURL."img/tmp/tmpres.png" ?>" style="width:100%; height:auto;" class="col-md-12"> -->
          </fieldset>
        </div>
      </div>
    </div>
</div>
</div>