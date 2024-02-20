<?php $meth = new Scorecard(); echo $fecha ?>
<style type="text/css">
  textarea{resize: vertical; }
  table tr, table td{padding:10px;}
  table#revision_emp th{text-align: center}
  table#revision_eval th{text-align: center}
</style>
<div class="clearfix"></div>
<h4>Revisión</h4>
<?php if(isset($obj_)) $obj_ = reset($obj_); ?>
<form id="revisionform" action="<?php echo BASEURL ?>scorecard/revision/<?php echo $id; ?> " method="POST">
<input type="hidden" id="fecha2" value="<?php echo $fecha ?>"></input>
  <div style="overflow-x: auto;">
    <table id="holder" class="col-md-8 col-offset-2 valign" style="min-width:100%;">
      <tr>
        <td class="col-md-6">
          <table id="revision_emp" class="table-bordered" class="no-padding " style="min-width:100%;">
            <thead>
              <tr>
                <th>Comentarios Empleado</th>
                <th>Fecha</th>
              </tr> 
            </thead>
            <tbody>
              <?php 
              if(isset($revision_emp)){
                $e0 = array_filter($revision_emp); 
              }else{
                $e0=null;
              }

              if($e0!=null){
                foreach ($e0 as $key => $value) { ?>
                <tr>
                  <td class="col-md-6"><textarea name="emp[]" class="empleado form-control"><?php if($value->tipo==0 && $value->autor==0) echo $meth->htmlprnt($value->comentario) ?></textarea></td>
                  <td class="col-md-6"><input type="date" class="fecha_empleado form-control" value="<?php if($value->tipo==0 && $value->autor==0) echo date($value->fecha) ?>"></td>
                  <td class="col-md-6"><?php if($value->tipo==0 && $value->autor==0) echo $value->periodo ?></td>
                </tr>
                <?php }
              }else{ ?>
              <tr>
                <td class="col-md-6"><textarea name="emp[]" class="empleado form-control"></textarea></td>
                <td class="col-md-6"><input  type="date" class="fecha_empleado form-control"></td>
              </tr>
              <?php } ?>  
            </tbody>  
          </table>  
        </td>
        <td class="col-md-6">
          <table id="revision_eval" class="table-bordered" class="no-padding " style="min-width:100%;">
            <thead>
              <tr>
                <th>Comentarios del Evaluador</th>
                <th>Comentarios Fecha</th>
              </tr> 
            </thead>
            <tbody>
              <?php 
              if(isset($revision_eval)){
                $e1 = array_filter($revision_eval); 
              }else{
                $e1=null;
              }$e1 = array_filter($revision_eval); ?>
              <?php if($e1){
                foreach ($revision_eval as $key => $value) { ?>
                <tr>
                  <td class="col-md-6"><textarea name="eval[]" class="evaluador form-control"><?php if($value->tipo==0 && $value->autor==1) echo $meth->htmlprnt($value->comentario) ?></textarea></td>
                  <td class="col-md-6"><input type="date" class="fecha_evaluador form-control" value="<?php if($value->tipo==0 && $value->autor==1) echo date($value->fecha) ?>"></td>
                  <td class="col-md-6"><?php if($value->tipo==0 && $value->autor==1) echo $value->periodo ?></td>
                </tr>
                <?php }
              }else{ ?>
              <tr>
                <td class="col-md-6"><textarea name="eval[]" class="evaluador form-control"></textarea></td>
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
  <div class="col-md-12 text-center">
    <div class="btn-group" role="group" aria-label="...">
      <input type="submit"  id="addrow2" class="btn btn-sm btn-info" data-loading-text="Guardando..." value="Agregar c. empleado">
      <input type="submit"  id="addrow2_" class="btn btn-sm btn-info" data-loading-text="Guardando..." value="Agregar c. evaluador">
      <input type="submit" id="submit2" name="guardar" data-loading-text="Guardando..." class="btn btn-sm btn-success" value="Guardar Comentarios">
      <!-- <a href="<?php echo $backlink ?>" class="btn btn-sm btn-danger" >Salir</a> -->
    </div>
  </div>
  <input hidden name="bloqueo" id="bloqueo">
  <div id="response"></div>
</form>

<script type="text/javascript">
  $('#revisionform').submit(function(){
    event.preventDefault();
  });

  $('#addrow2').click(function(){
    event.preventDefault();
    saveeval(this,true);
    table = "revision_emp"
    addRow(table);
  });

  $('#addrow2_').click(function(){
    event.preventDefault();
    saveeval(this,true);
    table = "revision_eval"
    addRow(table);
  });

  $('#submit2').click(function(){
    event.preventDefault();
    saveeval(this,true);
  });
</script>