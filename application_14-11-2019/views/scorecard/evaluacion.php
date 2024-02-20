<?php $meth = new Scorecard(); echo $fecha ?>
<style type="text/css">
  textarea{resize: vertical; }
  table tr, table td{padding:10px;}
  table#evaluacion_emp th{text-align: center}
  table#evaluacion_eval th{text-align: center}
</style>
<h4>Evaluación</h4>
<?php if(isset($obj_)) $obj_ = reset($obj_); ?>
<form id="evaluacionform" action="<?php echo BASEURL ?>scorecard/evaluacion/<?php echo $id; ?> " method="POST">
<input type="hidden" id="fecha2" value="<?php echo $fecha ?>"></input>
  <div style="overflow-x: auto;">
    <table id="holder" class="col-md-8 col-offset-2 valign" style="min-width:100%;">
      <tr>
        <td class="col-md-6">
          <table class="table-bordered" id="evaluacion_emp" class="no-padding" style="min-width:100%;">
            <thead>
              <tr>
                <th>Comentarios Empleado</th>
                <th>Fecha</th>
              </tr> 
            </thead>
            <tbody>
              <?php $e0 = array_filter($evaluacion_emp); ?>
              <?php if($e0!=null){
                foreach ($evaluacion_emp as $key => $value) { ?>
                <tr>
                  <td class="col-md-6"><textarea name="emp" class="form-control empleado"><?php if($value->tipo==1 && $value->autor==0) echo $meth->htmlprnt($value->comentario) ?></textarea></td>
                  <td class="col-md-6"><input type="date" class="fecha_empleado form-control" value="<?php if($value->tipo==1 && $value->autor==0) echo date($value->fecha) ?>"></td>
                </tr>
                <?php }
              }else{ ?>
              <tr>
                <td class="col-md-6"><textarea name="emp" class="form-control empleado"><?php if(isset($obj_['empleado'])) echo $obj_['empleado']; ?></textarea></td>
                <td class="col-md-6"><input type="date" class="fecha_empleado form-control"></td>
              </tr>
            </tbody>
            <?php } ?>  
          </table>
        </td>
        <td class="col-md-6">
          <table class="table-bordered" id="evaluacion_eval" class="no-padding" style="min-width:100%;">
            <thead>
              <tr>
                <th>Comentarios del Evaluador</th>
                <th>Comentarios Fecha</th>
              </tr> 
            </thead>
            <tbody>
              <?php $e1 = array_filter($evaluacion_eval); ?>
              <?php if($e1!=null){
                foreach ($evaluacion_eval as $key => $value) { ?>
                <tr>
                  <td class="col-md-6"><textarea name="eval" class="form-control evaluador"><?php if($value->tipo==1 && $value->autor==1) echo $meth->htmlprnt($value->comentario) ?></textarea></td>
                  <td class="col-md-6"><input type="date" class="fecha_evaluador form-control" value="<?php if($value->tipo==1 && $value->autor==1) echo date($value->fecha) ?>"></td>
                </tr>
                <?php }
              }else{ ?>
              <tr>
                <td class="col-md-6"><textarea name="eval" class="form-control evaluador"><?php if(isset($obj_['evaluador'])) echo $obj_['evaluador']; ?></textarea></td>
                <td class="col-md-6"><input type="date" class="fecha_evaluador form-control"></td>
              </tr>
              <?php } ?>  
            </tbody>
          </table>
        </td>
      </tr>
    </table>

    <div class="clearfix"></div>
  </div>
  <p>&nbsp;</p>
  <?php //if($id == $_SESSION['USER-AD']['id_personal']){ ?>
<!-- <h4>¿Está de acuerdo con esta evaluación?</h4>
<div style="float:left; margin-left: 15px; margin-top:10px">
  <div class="toggle-switch toggle-switch-success">
    <label>
      <input class="eval_revi" type="checkbox" value="<?php echo $id ?>">
      <div class="toggle-switch-inner bg-danger"></div>
      <div class="toggle-switch-switch"><i class="fa fa-check"></i></div>
    </label>
    <div  class="campo" hidden><input value="eval"></div>
  </div>
</div> -->
<?php //} ?>
<div class="clearfix"></div>
<div class="col-md-12 text-center">

  <div class="btn-group" role="group" aria-label="...">
    <input type="submit"  id="addrow3" class="btn btn-sm btn-info" data-loading-text="Guardando..." value="Agregar c. empleado">
    <input type="submit"  id="addrow3_" class="btn btn-sm btn-info" data-loading-text="Guardando..." value="Agregar c. evaluador">
    <input type="submit" id="submit3" name="guardar" class="btn btn-sm btn-success" value="Guardar Comentarios">
    <!-- <a href="<?php echo $backlink ?>" class="btn btn-sm btn-danger" >Salir</a> -->
  </div>
</div>
<input hidden name="bloqueo" id="bloqueo">
</form>


<script type="text/javascript">
  $('#evaluacionform').submit(function(){
    event.preventDefault();
  });

  $('#addrow3').click(function(){
    event.preventDefault();
    saveeval(this,false);
    table = "evaluacion_emp"
    addRow(table);
  });
  $('#addrow3_').click(function(){
    event.preventDefault();
    saveeval(this,false);
    table = "evaluacion_eval"
    addRow(table);
  });

  $('#submit3').click(function(){
    event.preventDefault();
    saveeval(this,false);
  });
</script>