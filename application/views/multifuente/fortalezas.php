<?php $meth = new User(); $util = new Util(); //var_dump($final)?>

  <div class="row form-group col-md-12">
      <img src="<?php echo BASEURL ?>img/Compass.png" style="width: 200px;">
  </div>
  <div class="row form-group col-md-12">
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
  <?php if(isset($res_rango)){ ?>
    <form method="POST" action="<?php echo BASEURL.'multifuente/definir_plan' ?>">
      <div class="row form-group">
      <div class="col-md-12">
        <table class="table-bordered" id="fotalezas">
          <tr>
            <th style="padding:5px">#</th>
      <?php
          $col_sep = 12 / $tot_rango;
          foreach ($array_nombres as $key => $rango) { ?>
            <th class="col-md-<?php echo $col_sep ?>"><?php echo $rango ?></th>
      <?php    }
      ?>
          </tr>
      <?php for ($i=0; $i <= 9; $i++) { ?>
          <tr>
            <td style="padding:5px"><?php echo ($i+1) ?></td>
    <?php foreach ($array_nombres as $key => $rango) { ?>
            <td class="col-md-<?php echo $col_sep ?>">
              <?php 
                if(isset($final[$rango][$i])){
                  $val = $final[$rango][$i];
                  if($val['val'] >= 3.33){
                    echo number_format($val['val'], 2).".- ";
                    echo '<div hidden><input type="checkbox" name="opt_m[]" value="'.$val['preg'].'" ></div>';
                    echo $meth->get_preg($val['preg']);
                  }else{
                    echo "";
                  }
                }
              ?>
            </td>
    <?php } ?>
          </tr>
      <?php }  ?>
        </table>
      </div>
      </div>
    </form>
  <?php } ?>