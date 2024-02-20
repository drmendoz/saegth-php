<style type="text/css">
  .preloader{
    background-color: rgba(0,0,0,0.6) !important;
  }
  .panel-heading
  {
    border-top-left-radius: inherit; 
    border-top-right-radius: inherit;
  }
</style>
<form action="<?php echo BASEURL ?>empresa/tipo_contrato" class="register" method="POST">
   
  <fieldset>
    <legend>Tipos de contrato</legend>
    <div class="row">
      <div class="col-md-6 show-grid">
        <table id="tcont_table" class="table table-bordered" border="1">
          <thead>
            <th>#</th>
            <th>Nombre</th>
          </thead>    
          <tbody>
            <?php 
            $cargos = new Empresa_tcont(); 
            $tmp = $cargos->select_all($_SESSION['Empresa']['id']);

            if (!empty($tmp)){ 
              foreach ($tmp as $a => $b) {
                $cargos->init_array($b);
                ?>
                <tr>
                  <p>
                    <td>
                      <a tabIndex="-1" class="elim" style="color:red"><i class="fa fa-times"></i></a>
                      <input type="hidden" type="checkbox" required="required" name="chk[]" value="<?php if(isset($cargos->id)){echo $cargos->id;}else{echo "";}?>" checked="checked" />
                    </td>
                    <td>
                      <input type="text" class="form-control" required="required" class="small" value="<?php if(isset($cargos->nombre)){echo $cargos->getNombre();}else{echo "";}?>"  name="tc_nombre[]">
                    </td>
                  </p>
                </tr>
                <?php   }
              }else{  ?>
              <tr>
                <p>
                  <td>
                    <input type="hidden" type="checkbox" required="required" name="chk[]" checked="checked" />
                  </td>
                  <td>
                    <input type="text" class="form-control" required="required" class="small"  name="tc_nombre[]">
                  </td>
                </p>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>  
      </div>    
      <div class="row">

        <div class="col-md-3 col-md-offset-6 show-grid" style="margin-top:-70px"> 
          <input type="button" class="btn btn-default btn-xs" value="Agregar" onClick="addRow('tcont_table')" /> 
        </div>  
      </div>    
      <div class="col-md-3 col-md-offset-9 show-grid">
        <input type="submit" class="btn btn-default btn-xs" name="guardar_datos" value="Guardar">
      </div>
    </fieldset>
  </form>

  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content panel-warning">
        <div class="modal-header panel-heading">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Advertencia</h4>
        </div>
        <div id="mbody" class="modal-body">
          <p>Este tipo de contrato tiene personal asociado. Al eliminarlo puede causar problemas con otros módulos del sistema.</p>
          <p>Considere modificar el nombre del tipo de contrato o asignar otro tipo de contrato al siguiente personal:</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-warning" onclick="delete_element_row('tcont_table',window.tcont)" data-dismiss="modal">Continuar</button>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    var tcont;
    $('#myModal').on('hidden.bs.modal', function (event) {
      $('#mbody > .response').empty();
    })
    function delete_element_row(t_id,element){
      var holder = 'elim_tcont'
      $.post(AJAX + holder, {
        id_s: $(this).siblings().val(),
      }, function(response) {
        _deleteRow(t_id,element);
      });
    }
    $('#tcont_table').on('click', '.elim', function() {
      var obj = this;
      if($(this).siblings().val()!=""){
        window.tcont = this;
        var holder = "listado_personal_x_cargo";
        $.post(AJAX + holder, {
          tname: "tcont",
          id_s: $(this).siblings().val(),
        }, function(response) {
          $('#preloader').empty();
          if(response!=0){
            $(preloader).css('display','block');
            $('#preloader').append('<div style="position:absolute;left:50%;top:50%;color:white"><i class="fa fa-spinner fa-pulse fa-5x"></i></div>');
            $('#preloader').delay(250).fadeOut('slow');
            $('#mbody').append(response);
            $('#myModal').modal('show');
          }else{
            $('#preloader').fadeOut('slow');
            var holder = 'elim_tcont'
            $.post(AJAX + holder, {
              id_s: $(obj).siblings().val(),
            }, function(response) {
              $('body').append(response);
              _deleteRow('tcont_table',obj);
            });
          }
        });
      }
    });
  </script>