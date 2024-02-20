<?php 
$meth = new Scorecard(); 
$success = '<h2><i class="fa fa-check" style="color:green"></i></h2>';
$error = '<h2><i class="fa fa-times" style="color:red"></i></h2>';
?>
<style type="text/css">
  table tr, table td{padding:10px;}
  table.scorecard td{text-align: center;}
</style>
<div class="form-group">
  <img src="<?php echo BASEURL ?>img/scorecard.png" style="width: 200px;">
  <h3 align="center">SISTEMA DE INFORMACIÓN GENERAL DEL PROCESO</h3>

  <table class="table table-bordered"  style="width: 100%;">
    <tr>
      <td><b>PERSONAL: </b><?php echo $meth->htmlprnt_win($nombre); ?></td>
      <td><b>CARGO: </b><?php echo $meth->htmlprnt($cargo); ?></td>
      <td><b>&Aacute;REA: </b><?php echo $meth->htmlprnt($area); ?></td>
    </tr>
    <tr>
      <td colspan="2"><b>EMPRESA: </b><?php echo $meth->htmlprnt($_SESSION['Empresa']['nombre']); ?></td>
      <td><b>PERIODO DE MEDICIÓN: </b><?php echo $fecha; ?></td>
    </tr>
  </table>
</div>
<h4>Ver periodos anteriores:
  <div class="col-md-12">
    <?php  
    $sd = new scorecard();
    $sd->select($_SESSION['Empresa']['id']);
    $hey = $sd->getPeriodos();
    if (sizeof($hey)>1) {
      unset($hey[0]);
      ?>
      <ul>
        <?php  
        foreach ($hey as $key => $value) {
          ?>
          <li><a href='<?php echo BASEURL ?>scorecard/jefe_periodo/<?php echo $value ?>' >Información periodo - <?php echo $value; ?></a></li>
          <?php  
        }
        ?>
      </ul>
      <?php  
    }
    ?>
  </div>
</h4>
<div class="form-group">
	<table class="table-bordered scorecard"  style="width: 100%; line-height: 12px;">
		<thead>
			<tr>
				<th>SUBALTERNOS EN PROCESO</th>
				<th>Ingreso de Usuario</th>
				<th>Ingreso de Jefe</th>
				<th>Bloqueo Jefe</th>
        <th>Revisión</th>
        <th>Revisión del Jefe</th>
        <th>Evaluación</th>
        <th>Evaluación del Jefe</th>
        <th>Resultado Scorercard %</th>
        <th>Resultado Scorercard</th>
        <th>Resultado Compass 360°</th>
        <th>Resultado Ponderado</th>
        <th>Fase Final</th>
      </tr>
    </thead>
    <tbody>
     <?php if(isset($sub_a)){
      $num_rows=sizeof($sub_a);
      $rrr = true;
    }else{
      $num_rows=1;
      $rrr = false;
    } for ($i=0; $i < $num_rows; $i++) { if($rrr){$fields=$sub_a[$i]; $r_scorer = $meth->get_ScorecardRes($fields['id_personal'],$fecha);} //var_dump($scorer)?>
    <tr>
     <td style="text-align: left !important"><a href="<?php echo BASEURL.'user/tests/scorer_sub/'.$fields['id_personal'] ?>"><?php echo $meth->htmlprnt_win($meth->get_pname($fields['id_personal'])) ?></a></td>
     <td><?php if($fields['usuario']) echo $success; else echo $error; ?></td>
     <td><?php if($fields['jefe']) echo $success; else echo $error; ?></td>
     <td><?php if($fields['bloqueo']) echo $success; else echo $error; ?></td>
     <td><?php if($fields['revision']) echo $success; else echo $error; ?></td>
     <td><?php if($fields['revision_jefe']) echo $success; else echo $error; ?></td>
     <td><?php if($fields['evaluacion']) echo $success; else echo $error; ?></td>
     <td><?php if($fields['evaluacion_jefe']) echo $success; else echo $error; ?></td>
     <td><?php echo round($r_scorer,2).'%';  ?></td>
     <td><?php echo $r_score = $meth->scorer_rango($scorer,intval($r_scorer)); ?></td>
     <td><?php echo $compass = round($meth->getAvg_test_eval($meth->get_codEval($fields['id_personal'])),2); ?></td>
     <td>
      <?php 
      $p_score = $scorer->p_score;
      echo $total = ($r_score * $p_score / 100)+($compass * (100-$p_score) /100);
      ?>
    </td>
    <td>
      <form method="post" action="<?php echo BASEURL.'scorecard/fase_final'?>">
        <input type="hidden" name="id_e" value="<?php echo $fields['id_personal'] ?>"> 
        <input type="hidden" name="compass" value="<?php echo $compass ?>"> 
        <input type="hidden" name="r_score" value="<?php echo $r_score ?>"> 
        <input type="hidden" name="total" value="<?php echo $total ?>"> 
        <input type="submit" class="btn btn-info btn-xs" value="Link">
      </form>
    </tr>
    <?php } ?>
  </tbody>
</table>
</div>