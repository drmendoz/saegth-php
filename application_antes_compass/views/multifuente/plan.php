  <?php $meth = new User(); $util = new Util(); //var_dump($plan)?>
<style type="text/css">
  .picon i{font-size: medium;padding: 8px}
  table tr, table td{padding:10px;}
</style>
  <div class="form-group col-md-12">
      <table class="table-bordered"  style="width: 100%; line-height: 40px;">
        <tr>
          <td class="col-md-4"><b>PERSONAL: </b><?php echo $meth->htmlprnt($nombre); ?></td>
          <td class="col-md-4"><b>CARGO: </b><?php echo $meth->htmlprnt($cargo); ?></td>
          <td class="col-md-4"><b>SUPERVISOR DIRECTO: </b><?php echo $superior; ?></td>
        </tr>
        <tr>
          <td class="col-md-4"><b>EMPRESA: </b><?php echo $meth->htmlprnt($_SESSION['Empresa']['nombre']) ?></td>
          <td colspan="2" class="col-md-4"><b>&Aacute;REA: </b><?php echo $meth->htmlprnt($area); ?></td>
          <!-- <td class="col-md-4"><b>FECHA DE EVALUACION: </b><?php //echo $meth->print_fecha($fecha); ?></td> -->
        </tr>
      </table>
  </div>  
  <div class="clearfix"></div>
<?php if($plans>0){ ?>
    <form id="plan_final" method="POST" action="<?php echo BASEURL.'multifuente/plan'.DS.$id ?>">
      <div class="form-group">
        <table class="table-bordered" id="plan">
          <tr>
            <th colspan="2"></th>
            <th class="col-md-4 text-center">Item a mejorar</th>
            <th class="col-md-2 text-center">Acci&oacute;n a tomar</th>
            <th class="col-md-2 text-center">Tipo de acci&oacute;n</th>
            <th class="col-md-2 text-center">Medici&oacute;n de acci&oacute;n</th>
            <th class="col-md-2 text-center">Fecha de cumplimiento</th>
          </tr>
          <?php if (isset($plan)): ?>
            <?php foreach ($plan as $a => $b) { $b=reset($b); ?>
          <tr>
            <td class="no-padding">
              <a tabIndex="-1" class="elim picon" style="color:red"><i class="fa fa-times grow"></i></a>
              <div hidden><input type="text" class="evaluacion" name="evaluacion[]" value="0"></div>
              <div hidden><input type="text" class="id" name="id[]" value="<?php echo $b['id'] ?>"></div>
              <div hidden><input type="text" class="uori" name="uori[]" value="update"></div>
              
            </td>
            <td class="no-padding"><a tabIndex="-1" class="addm picon"style="color:green"><i class="fa fa-plus-square grow"></i></a></td>
            <td class="col-md-4">
              <?php echo $meth->htmlprnt_win($meth->get_preg($b['cod_pregunta'])); ?>
              <div hidden><input type="text" name="cod_p[]" value="<?php echo $b['cod_pregunta'] ?>"></div>
            </td>
            <td class="col-md-2">
              <textarea class="form-control" required="required" name="accion[]"><?php echo $meth->htmlprnt($b['accion']) ?></textarea>
            </td>
            <td class="col-md-2">
              <select class="form-control" required="required" name="tipo[]"><?php echo $b['tipo'] ?>
                <option value="">- Seleccionar tipo-</option>
                <option name="Coaching" <?php if($b['tipo']=="Coaching")echo "selected" ?>>Coaching</option>
                <option name="Mentoring" <?php if($b['tipo']=="Mentoring")echo "selected" ?>>Mentoring</option>
                <option name="Proyecto" <?php if($b['tipo']=="Proyecto")echo "selected" ?>>Proyecto</option>
                <option name="Rotación" <?php if($b['tipo']=="Rotación")echo "selected" ?>>Rotación</option>
                <option name="Curso" <?php if($b['tipo']=="Curso")echo "selected" ?>>Curso</option>
              </select>
              <input id="color" list="suggests">
              <datalist id="suggests">
                <option value="Black"></option>
                <option value="Red"></option>
                <option value="Green"></option>
                <option value="Blue"></option>
                <option value="White"></option>
              </datalist>
            </td>
            <td class="col-md-2">
              <textarea class="form-control" required="required" name="medicion[]"><?php echo $meth->htmlprnt($b['medicion']) ?></textarea>
            </td>
            <td class="col-md-2">
              <input type="date" class="form-control" required="required" name="fecha[]" value="<?php echo $b['fecha'] ?>">
            </td>
          </tr>
      <?php }  ?>            
          <?php endif ?>
          <?php if (isset($scorer_plan)): ?>
            <?php foreach ($scorer_plan as $a => $b) { $b=new Scorer_oportunidad($b); ?>
          <tr>
            <td>
              <a tabIndex="-1" class="elim picon" style="color:red"><i class="fa fa-times"></i></a>
              <div hidden><input type="text" class="evaluacion" name="evaluacion[]" value="1"></div>
              <div hidden><input type="text" class="id" name="id[]" value="<?php echo $b->id ?>"></div>
              <div hidden><input type="text" class="uori" name="uori[]" value="update"></div>
            </td>
            <td><a tabIndex="-1" class="addm picon"style="color:green"><i class="fa fa-plus-square"></i></a></td>
            <td class="col-md-4">
              <?php echo $meth->htmlprnt($b->objetivo); ?>
              <div hidden><input type="text" name="cod_p[]"></div>
            </td>
            <td class="col-md-2">
              <textarea class="form-control" required="required" name="accion[]"><?php echo $meth->htmlprnt($b->accion); ?></textarea>
            </td>
            <td class="col-md-2">
              <select class="form-control" required="required" name="tipo[]"><?php echo $b->tipo ?>
                <option value="">- Seleccionar tipo-</option>
                <option name="Coaching" <?php if($b->tipo=="Coaching")echo "selected" ?>>Coaching</option>
                <option name="Mentoring" <?php if($b->tipo=="Mentoring")echo "selected" ?>>Mentoring</option>
                <option name="Proyecto" <?php if($b->tipo=="Proyecto")echo "selected" ?>>Proyecto</option>
                <option name="Rotación" <?php if($b->tipo=="Rotación")echo "selected" ?>>Rotación</option>
                <option name="Curso" <?php if($b->tipo=="Curso")echo "selected" ?>>Curso</option>
              </select>
            </td>
            <td class="col-md-2">
              <textarea class="form-control" required="required" name="medicion[]"><?php echo $meth->htmlprnt($b->medicion) ?></textarea>
            </td>
            <td class="col-md-2">
              <input type="date" class="form-control" required="required" name="fecha[]" value="<?php echo $b->fecha ?>">
            </td>
          </tr>
      <?php }  ?>            
          <?php endif ?>
      
        </table>
      </div>
      <div class="row text-center">
        <input type="hidden" class="btn btn-default btn-xs" name="update" value="guardar">
        <!-- <input type="submit" class="btn btn-default btn-xs" name="update" value="guardar"> -->
      </div>
    </form>
      <div class="row text-center">
        <!-- <input type="submit" class="btn btn-default btn-xs" name="update" value="guardar"> -->
        <button type="text" onclick="form_submit(this);" class="btn btn-success btn-sm">Guardar</button>
      </div>
  <?php } else{ ?>
  <h4 class="bg-warning text-center">No se ha definido un plan de acción</h4>
  <?php } ?>
  <script type="text/javascript">
    function form_submit(obj){

      var $btn = $(obj).button('loading');  
      $.ajax({
        url: AJAX + 'plan_form_submit', // Get the action URL to send AJAX to
        type: "POST",
        data: $("form#plan_final").serialize(), // get all form variables
        success: function(result){
          $btn.button('reset');
          $().toastmessage('showSuccessToast', "Se guardado objetivo al plan de acción");
        }
      });
    }
  </script>