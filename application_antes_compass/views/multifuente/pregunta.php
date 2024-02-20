<?php $meth = new User(); $util = new Util(); //var_dump($sub)?>
<div class="row form-group col-md-12">
  <img src="<?php echo BASEURL ?>img/Compass.png" style="width: 260px;">
</div>
<div class="form-group col-md-12">
  <table class="table-bordered text-left"  style="width: 100%; line-height: 40px;">
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
  <div class="col-md-7">
    <table class="table-bordered" style="width: 100%;  line-height: 15px;">
      <tr>
        <td class="col-md-11" colspan="2" align="justify">
          <?php $p=$meth->get_preg($cod); ?>
          <p><a class="ajaxlink" href="<?php echo "#tabs-2/".$backlink ?>"><?php echo $meth->htmlprnt_win($p) ?></a></p>
        </td>
        <th class="text-center">Persona</th>
        <th class="text-center">Empresa</th>
        <th hidden class="text-center">Mercado</th>
      </tr>   
        <?php // gerente par sub auto 
        $_auto=$meth->getAvg_preg_rang($cod,$cod_evaluado,"Auto");
        $_ger=$meth->getAvg_preg_rang($cod,$cod_evaluado,"Gerente");
        $_par=$meth->getAvg_preg_rang($cod,$cod_evaluado,"Par");
        $_sub=$meth->getAvg_preg_rang($cod,$cod_evaluado,"Subalterno");
        ?>  
        <tr>
          <td class="col-md-1">#</td>
          <td class="col-md-10"><h4>Promedio:</h4></td>
          <?php $prom=$meth->getAvg_preg_eval($cod,$cod_evaluado); ?>
          <!-- PROMEDIO EVALUADO -->          
          <td class="no-padding text-center" bgcolor="<?php echo $meth->get_color($prom); ?>" style="padding: 0 10px;"><font size="-2" color="<?php if ($prom < 1.66) echo "#FFFFFF"; ?>"><b><?php printf("%.2f", $prom); ?></b></font></td>
          <?php $p_emp = $meth->getInAvg_preg($cod,$_SESSION['Empresa']['id']);?>  
          <!-- PROMEDIO EMPRESA -->
          <td class="no-padding text-center" bgcolor="<?php echo $meth->get_color($p_emp); ?>" style="padding: 0 10px;"><font size="-2" color="<?php if ($p_emp < 1.66) echo "#FFFFFF"; ?>"><b><?php printf("%.2f", $p_emp); ?></b></font></td>
          <?php $p_glob = $meth->getAvg_preg($cod); ?>  
          <!-- PROMEDIO GLOBAL -->
          <td hidden class="no-padding text-center" bgcolor="<?php// echo $meth->get_color($p_glob); ?>" style="padding: 0 10px;"><font size="-2" color="<?php// if ($p_glob < 1.66) echo "#FFFFFF"; ?>"><b><?php //printf("%.2f", $p_glob); ?></b></font></td>
          
        </tr>
      </table>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <table class="table-bordered" style="width: 100%;  line-height: 15px;">  
        <tr>
          <th colspan="3">Promedio por evaluadores</th>
        </tr>
        <?php if(isset($_ger)){ ?>
        <tr>
          <td class="col-md-1">#</td>
          <td class="col-md-10"><h4>Gerente:</h4></td>
          <td class="no-padding text-center" bgcolor="<?php echo $meth->get_color($_ger); ?>" style="padding: 0 10px;"><font size="-2" color="<?php if ($_ger < 1.66) echo "#FFFFFF"; ?>"><b><?php printf("%.2f", $_ger); ?></b></font></td>
        </tr>
        <?php } ?>
        <?php if(isset($_par)){ ?>
        <tr>
          <td class="col-md-1">#</td>
          <td class="col-md-10"><h4>Pares:</h4></td>
          <td class="no-padding text-center" bgcolor="<?php echo $meth->get_color($_par); ?>" style="padding: 0 10px;"><font size="-2" color="<?php if ($_par < 1.66) echo "#FFFFFF"; ?>"><b><?php printf("%.2f", $_par); ?></b></font></td>
        </tr>
        <?php } ?>
        <?php if(isset($_sub)){ ?>
        <tr>
          <td class="col-md-1">#</td>
          <td class="col-md-10"><h4>Subalternos:</h4></td>
          <td class="no-padding text-center" bgcolor="<?php echo $meth->get_color($_sub); ?>" style="padding: 0 10px;"><font size="-2" color="<?php if ($_sub < 1.66) echo "#FFFFFF"; ?>"><b><?php printf("%.2f", $_sub); ?></b></font></td>
        </tr>
        <?php } ?>
      </table>
      <p>&nbsp;</p>
      <div hidden><input type="text" id="cod_eval" value="<?php echo $_SESSION['evaluado']['id'] ?>" ></div>
      <div hidden><input type="text" id="cod_preg" value="<?php echo $cod ?>" ></div>
      <button class="btn-info btn-xs btn agregar_plan" data-loading-text="...">Agregar</button>
    </div>
    <?php
    $array=array($_auto,$_ger,$_par,$_sub);
    $array = serialize($array);
    $array = urlencode($array);
        //var_dump($array);
    ?>
    <div class="col-md-5 text-center">
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
          </fieldset>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    $('#tabs-2').on('click', '.agregar_plan', function() {

      event.preventDefault();
      var $btn = $(this).button('loading');
      var holder = "agregar_plan_compass";
      var cod_eval = $('#cod_eval').val();
      var cod_preg = $('#cod_preg').val();
      $.post(AJAX + holder, {
        cod_evaluado: cod_eval,
        cod_pregunta:cod_preg,
      }, function(data) {
        $btn.button('reset');
        if(data){
          $().toastmessage('showNoticeToast', "Se ha agregado objetivo al plan de acción");
          $('#plan tbody').append(data);
        }
      });
    });
  </script>