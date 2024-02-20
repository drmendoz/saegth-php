<?php $meth = new Empresa(); ?>
<style type="text/css">
  td{padding:0 10px;}
</style>
<form action="<?php echo BASEURL ?>empresa/grado_salarial" class="register" method="POST">
  <h4>Grado Salarial</h4>
  <table id="sort" class="table-hover table-bordered">
    <thead>
        <tr>
          <th>#</th>
          <th>Grado</th>
          <th>Rango Min</th>
          <th>Rango Medio</th>
          <th>Rango Max</th>
          <th>Eliminar</th>
        </tr>
    </thead>
    <tbody>
    <?php //var_dump($grados) ?>
      <?php if($grados){ ?>
        <?php foreach ($grados as $key => $value) { $value = new Grado_salarial($value); ?>
          <tr>
            <td><i class="fa fa-arrows"></i></td>
            <td><input name="grado[]" tabIndex="-1" style="width:40px" class="form-control grado_val" readonly="readonly" type="text" value="<?php echo $value->grado ?>"></td>
            <td><input name="r_min[]" class="form-control" type="text" value="<?php echo $value->r_min ?>"></td>
            <td><input name="r_med[]" class="form-control" type="text" value="<?php echo $value->r_med ?>"></td>
            <td><input name="r_max[]" class="form-control" type="text" value="<?php echo $value->r_max ?>"></td>
            <td><p class="text-center"><a tabIndex="-1" class="deleRow" onclick="gs_deleteRow('sort',this)" style="color:red"><i class="fa fa-times"></i></a></p></td>
          </tr>
        <?php } ?>
      <?php }else{ ?>
        <tr>
          <td><i class="fa fa-arrows"></i></td>
          <td><input name="grado[]" tabIndex="-1" style="width:40px" class="form-control grado_val" readonly="readonly" type="text" value="1"></td>
          <td><input name="r_min[]" class="form-control" type="text"></td>
          <td><input name="r_med[]" class="form-control" type="text"></td>
          <td><input name="r_max[]" class="form-control" type="text"></td>
          <td><p class="text-center"><a tabIndex="-1" class="deleRow" onclick="gs_deleteRow('sort',this)" style="color:red"><i class="fa fa-times"></i></a></p></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
    <div class="row">
      <div class="col-md-3 col-md-offset-7 show-grid" style="margin-top:-23px"> 
        <div class="btn-group" role="group" aria-label="...">
          <input type="button" class="btn btn-default btn-xs" value="Agregar" onClick="addRow_grado('sort')" /> 
        </div>
      </div>  
    </div>
    <div class="col-md-3 col-md-offset-9 show-grid">
      <input type="submit" class="btn btn-success btn-sm" name="guardar_datos" value="Guardar">
    </div>
</form>
<script type="text/javascript">
    // Return a helper with preserved width of cells
    var fixHelper = function(e, ui) {
      ui.children().each(function() {
        $(this).width($(this).width());
      });
      return ui;
    };

    function update_var(){
      $('.grado_val').each(function(index,value){
        $(value).val(index+1);
      });
    }

    $("#sort tbody").sortable({
      helper: fixHelper,
      placeholder: "bg-info",
      update: function( event, ui ) { update_var() }
    }).disableSelection();

    $("#sort tbody tr").livequery(function() {
      update_var();
    });

    function gs_deleteRow(tableID, obj) {
      var table = document.getElementById(tableID);
      var rowCount = table.rows.length;
      if ((rowCount - 1) <= 1) { // limit the user from removing all the fields
        alert("Debe existir por lo menos un campo");
      } else {
        table.deleteRow(obj.parentNode.parentNode.parentNode.rowIndex);

        $().toastmessage('showNoticeToast', 'Se ha eliminado una fila');
        update_var();
      }
    }

  </script>