<script src="<?php echo BASEURL ?>public/js/angular.min.js"></script>
<?php $meth = new Scorecard(); ?>
<style type="text/css">
    input[type="text"]{width: 60px !important; min-width: 75px;}

  table tr, table td{padding:10px;}
  table#scorer th{text-align: center}
  table#scorer tbody tr td input,
  table#scorer tbody tr td{text-align: right;}
  table#scorer tbody tr td input[type="date"]{width: 160px;}
  table#scorer textarea{width:250px; max-width: 250px;}
  table#scorer tr, table#scorer td{padding:10px;}
  table#scorer select{width: 100px !important;}

  table#fasefinal table tr, table#fasefinal table td{padding:inherit;}

  table#obj tbody tr td{text-align: right;}
  table#obj tbody tr td.objind{text-align: left;}
  table#obj tbody tr td:first-child{width: 15px}
  table#obj tbody tr td input[type="date"]{width: 160px;}
</style>
<input type="hidden" id="id" value='<?php echo $id;?>'>
<input type="hidden" id="autor" value='<?php if($_SESSION['USER-AD']['id_personal'] == $id) echo 0; else echo 1 ?>'>

<input type="hidden" id="vinicial" value='<?php echo $scorer->vinicial ?>'>
<input type="hidden" id="razon" value='<?php echo $scorer->razon ?>'>
<input type="hidden" id="periodo" value='<?php echo $fecha ?>'>
<input type="hidden" id="col" value='<?php echo $scorer->col ?>'>
<?php $meth->header_set($id,$fecha); ?>
<div class="clearfix"></div>
<p>&nbsp;</p>
<?php if(isset($obj_sup)){ ?>
<h4 class='form-group'>Objetivos del jefe</h4>
<table class="table-bordered" width="100%" id="obj">
  <thead>
    <tr>
      <th class="first_cell">#</th>
      <th>Objetivo</th>
      <th>Indicador</th>
      <th>Unidad de medida</th>
      <?php
      $m = 15;
      $n = $m / $scorer->col;
      $n = ceil($n); 
      for ($i=0; $i < $scorer->col; $i++) { 
        $fond = "FF".dechex($m).dechex($n)."00";  
        if($scorer->col=="1" || ($scorer->vinicial + ($scorer->razon * $i))==100){ $col_m = $i; ?>
        <th style="background: #<?php echo $fond ?>">
          <?php echo "Meta"; ?>
        </th>
        <?php } $m -= $n;} ?>
        <th>Peso %</th>
    </tr> 
  </thead>
  <tbody >
    <?php
      $num_rows=sizeof($obj_sup);
      $rrr = true;
     for ($i=0; $i < $num_rows; $i++) { if($rrr){$fields=new Scorer_obj($obj_sup[$i]);} ?>
    <tr>
      <td class="first_cell"><p><?php echo $i+1; ?></p></td>
      <td class="col-md-5 objind"><?php if(isset($fields->objetivo)) echo $meth->htmlprnt($fields->objetivo); else echo "N/D";?></td>
      <td class="col-md-4 objind"><?php if(isset($fields->indicador)) echo $meth->htmlprnt($fields->indicador); else echo "N/D";?></td>
      <td class="col-md-1">
        <?php 
        switch ($fields->unidad) {
          case '0':
          echo "US\$M";
          break;
          case '1':
          echo "%";
          break;
          case '2':
          echo "Fecha";
          break;
          case '3':
          echo "#";
          break;
        }
        ?>
      </td>
      <?php if(isset($fields->meta)) $meta = unserialize($fields->meta) ?>
      <?php for ($e=0; $e < $scorer->col; $e++) { ?>
      <?php if($col_m==$e){ ?>
      <td class="col-md-1">
        <?php if(isset($meta[$e])) echo $meta[$e]; else echo "N/D";?>
      </td>
      <?php } ?>
      <?php } ?>
      <td class="col-md-1">
        <?php if(isset($fields->peso)) echo $meth->htmlprnt($fields->peso)."%"; else echo "N/D";?>
      </td>
    </tr>        
    <?php   } unset($fields); ?>
  </tbody>
</table>

      <?php } ?>
<form action="<?php echo BASEURL ?>scorecard/confirmacion/<?php echo $id; ?> " method="POST">
  <div style="overflow-x: auto;">
  <?php  
  $peso=$pond=array();
  ?>
    <table class="table-bordered" id="scorer">
      <thead>
        <tr>
          <th>#</th>
          <th>Objetivo</th>
          <th>Indicador</th>
  <?php if($scorer->col==1){ ?>
          <th>Inverso</th>
  <?php } ?>
          <th>Unidad de medida</th>
          <?php
          $m = 15;
          $n = $m / $scorer->col;
          $n = ceil($n); 
          for ($i=0; $i < $scorer->col; $i++) { 
            $fond = "FF".dechex($m).dechex($n)."00"; ?> 
            <th style="background: #<?php echo $fond ?>">
              <?php 
              if($scorer->col=="1")  
                echo "Meta";
              else
                echo $scorer->vinicial + ($scorer->razon * $i);
              ?>
            </th>
            <?php $m -= $n;} ?>
            <th>Peso %</th>
            <th>Logro Real</th>
            <th>Logro Ponderado %</th>
            <th>Puntaje Ponderado %</th>
          </tr> 
        </thead>
        <tbody>
          <?php if(isset($obj_)){
            $num_rows=sizeof($obj_);
            $rrr = true;
          }else{
            $num_rows=1;
            $rrr = false;
          } for ($i=0; $i < $num_rows; $i++) { if($rrr){$fields=$obj_[$i];$fields=reset($fields);} ?>
          <tr>
            <td><p class='counter'><?php echo $i+1; ?></p></td>
            <td><?php if(isset($fields['objetivo'])) echo $meth->htmlprnt($fields['objetivo']); ?></td>
            <td><?php if(isset($fields['indicador'])) echo $meth->htmlprnt($fields['indicador']); ?></td>
    <?php if($scorer->col==1){ ?>
            <td>
                <?php if(isset($fields['inverso'])){if ($fields['inverso']=="0"){ echo "No";}} ?> 
                <?php if(isset($fields['inverso'])){if ($fields['inverso']=="1"){ echo "Sí";}} ?> 
            </td>
    <?php } ?>
            <td>
                <?php if(isset($fields['unidad'])){if ($fields['unidad']=="0"){ echo "US\$M";}} ?>
                <?php if(isset($fields['unidad'])){if ($fields['unidad']=="1"){ echo "%";}} ?>
                <?php if(isset($fields['unidad'])){if ($fields['unidad']=="2"){ echo "Fecha";}} ?>
                <?php if(isset($fields['unidad'])){if ($fields['unidad']=="3"){ echo "#";}} ?>
            </td>
            <?php if(isset($fields['meta'])) $meta = unserialize($fields['meta']) ?>
            <?php for ($e=0; $e < $scorer->col; $e++) { ?>
            <td>
              <?php if(isset($meta[$e])) echo $meta[$e] ?>
            </td>
            <?php } ?>
            <td>
                <?php if(isset($fields['peso'])){ echo $fields['peso']; array_push($peso, $fields['peso']);} ?>%
            </td>
            <td>
              <?php if(isset($fields['lreal'])) echo $fields['lreal'] ?>
            </td>
            <td>
                <?php if(isset($fields['lpond'])) echo round($fields['lpond'],2) ?>%
            </td>
            <td>
                <?php if(isset($fields['ppond'])){ echo round($fields['ppond'],2);array_push($pond, $fields['ppond']);} ?>%
            </td>
          </tr> 
          <?php   } if($scorer->col==1) $scorer->col++ ;?>
          <tr>
            <td colspan="<?php echo $scorer->col+4 ?>"> Suma Peso %</td>
            <td>
                <?php echo round(array_sum($peso),2)."%"; ?>
            </td>            
            <td colspan="2">Total puntaje ponderado</td>
            <td>
                <?php 
                $tpond=array_sum($pond);
                echo round($tpond,2)."%"; 
                ?>
            </td>
          </tr> 
          <tr>
            <td colspan="<?php echo $scorer->col+5 ?>"></td>
            <td colspan="2">Factor de ajuste</td>
            <?php  ?>
            <td>
            <?php echo $ajuste ?>
            </td>
          </tr> 
          <tr>
            <td colspan="<?php echo $scorer->col+5 ?>"></td>
            <td colspan="2">Total puntaje ponderado ajustado</td>
            <td>
            <?php 
            $total = $tpond + ($tpond*$ajuste/100);
            echo round($total,2);
            ?>
            </td>
          </tr>
          <?php 
          $scorecard_data = new Scorecard();
          $r_score = $scorecard_data->scorer_rango($scorer,intval($total));
    // $compass = round($meth->getAvg_test_eval($meth->get_codEval($id)),2);
    // $p_score = $scorer->p_score;
    // $total = ($r_score * $p_score / 100)+($compass * (100-$p_score) /100);
          ?>
          <tr>
            <td colspan="<?php echo $scorer->col+5 ?>">
            </td>
            <td colspan="2">Puntaje Scorecard</td>
            <td><?php echo $r_score; ?></td>
          </tr> 
        </tbody>
      </table>
      <p>&nbsp;</p>
    </div>
    <p>&nbsp;</p>
  </form>

<?php 
  $scorecard = new ScorecardController('Scorecard','scorecard','revision',0,true,true); 
  $scorecard->revision($id,$fecha); 
  $scorecard->ar_destruct();
  unset($scorecard); 
  $scorecard = new ScorecardController('Scorecard','scorecard','evaluacion',0,true,true); 
  $scorecard->evaluacion($id,$fecha); 
  $scorecard->ar_destruct();
  unset($scorecard); 
  $scorecard = new ScorecardController('Scorecard','scorecard','que_hacer',0,true,true); 
  $scorecard->que_hacer($id,$fecha); 
  $scorecard->ar_destruct();
  unset($scorecard); 
?>