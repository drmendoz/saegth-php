<?php
$meth = new Admin();
?>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title" id="myModalLabel">Filtrar Columnas</h4>
      </div>
      <div class="modal-body">
        <form action="<?php BASEURL.'personal/viewall_deprecated' ?>" method="POST" id="fiter-table">
          <table class="col-md-12 table-hover" >
            <tr>
              <td class="col-md-10"><label>Fecha de nacimiento</label></td>
              <td class="col-md-2"><input type="checkbox" name="filtro[]" <?php if(isset($_POST['filtro'])){if(in_array("fecha de nacimiento", $_POST['filtro'])){echo "checked";}} ?> value="fecha de nacimiento"></td>
            </tr>
            <tr>
              <td class="col-md-10"><label>Fecha de ingreso</label></td>
              <td class="col-md-2"><input type="checkbox" name="filtro[]" <?php if(isset($_POST['filtro'])){if(in_array("fecha de ingreso", $_POST['filtro'])){echo "checked";}} ?> value="fecha de ingreso"></td>
            </tr>
            <tr>
              <td class="col-md-10"><label>&Aacute;rea</label></td>
              <td class="col-md-2"><input type="checkbox" name="filtro[]" <?php if(isset($_POST['filtro'])){if(in_array("area", $_POST['filtro'])){echo "checked";}} ?> value="area"></td>
            </tr>
            <tr>
              <td class="col-md-10"><label>Localidad</label></td>
              <td class="col-md-2"><input type="checkbox" name="filtro[]" <?php if(isset($_POST['filtro'])){if(in_array("localidad", $_POST['filtro'])){echo "checked";}} ?> value="localidad"></td>
            </tr>
            <tr>
              <td class="col-md-10"><label>Cargo</label></td>
              <td class="col-md-2"><input type="checkbox" name="filtro[]" <?php if(isset($_POST['filtro'])){if(in_array("cargo", $_POST['filtro'])){echo "checked";}} ?> value="cargo"></td>
            </tr>
            <tr>
              <td class="col-md-10"><label>Nombre del superior</label></td>
              <td class="col-md-2"><input type="checkbox" name="filtro[]" <?php if(isset($_POST['filtro'])){if(in_array("superior", $_POST['filtro'])){echo "checked";}} ?> value="superior"></td>
            </tr>
            <tr>
              <td class="col-md-10"><label>Nivel organizacional</label></td>
              <td class="col-md-2"><input type="checkbox" name="filtro[]" <?php if(isset($_POST['filtro'])){if(in_array("niveles organizacionales", $_POST['filtro'])){echo "checked";}} ?> value="niveles organizacionales"></td>
            </tr>
            <tr>
              <td class="col-md-10"><label>Tipo de contrato</label></td>
              <td class="col-md-2"><input type="checkbox" name="filtro[]" <?php if(isset($_POST['filtro'])){if(in_array("contrato", $_POST['filtro'])){echo "checked";}} ?> value="contrato"></td>
            </tr>
            <?php foreach ($condicionadores as $key => $value) { $value=reset($value); ?>
            <tr>
              <td class="col-md-10"><label><?php echo $value['nombre'] ?></label></td>
              <td class="col-md-2"><input type="checkbox" name="cond[]" value="<?php echo $value['id'] ?>"></td>
            </tr>
            <?php } ?>
            <tr>
              <td class="col-md-10"><label>Estado Civil</label></td>
              <td class="col-md-2"><input type="checkbox" name="filtro[]" <?php if(isset($_POST['filtro'])){if(in_array("estado civil", $_POST['filtro'])){echo "checked";}} ?> value="estado civil"></td>
            </tr>
            <?php foreach ($evaluaciones as $key => $value) {  if($value){?>
            <tr>
              <td class="col-md-10"><label><?php echo ucfirst(str_replace("_", " ", $key))  ?></label></td>
              <td class="col-md-2"><input type="checkbox" name="filtro[]" <?php if(isset($_POST['filtro'])){if(in_array($key, $_POST['filtro'])){echo "checked";}} ?> value="<?php echo $key ?>"></td>
            </tr>
            <?php } } ?>
          </table>
          <div class="clearfix"></div>
        </div>
        <div class="modal-footer">
          <input type="submit" name="filtrar" class="btn btn-sm btn-info pull-right" value="Filtrar">
          <div class="clearfix"></div>
        </div> 
      </form>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-6">
    <div id="dialog-modal" title="Basic modal dialog" style="display:none">
      <form action="<?php BASEURL.'personal/viewall' ?>" method="POST" id="fiter-table">
        <table class="col-md-12 table-hover" >
          <tr>
            <td class="col-md-10"><label>Fecha de nacimiento</label></td>
            <td class="col-md-2"><input type="checkbox" name="filtro[]" <?php if(isset($_POST['filtro'])){if(in_array("fecha de nacimiento", $_POST['filtro'])){echo "checked";}} ?> value="fecha de nacimiento"></td>
          </tr>
          <tr>
            <td class="col-md-10"><label>Fecha de ingreso</label></td>
            <td class="col-md-2"><input type="checkbox" name="filtro[]" <?php if(isset($_POST['filtro'])){if(in_array("fecha de ingreso", $_POST['filtro'])){echo "checked";}} ?> value="fecha de ingreso"></td>
          </tr>
          <tr>
            <td class="col-md-10"><label>&Aacute;rea</label></td>
            <td class="col-md-2"><input type="checkbox" name="filtro[]" <?php if(isset($_POST['filtro'])){if(in_array("area", $_POST['filtro'])){echo "checked";}} ?> value="area"></td>
          </tr>
          <tr>
            <td class="col-md-10"><label>Localidad</label></td>
            <td class="col-md-2"><input type="checkbox" name="filtro[]" <?php if(isset($_POST['filtro'])){if(in_array("localidad", $_POST['filtro'])){echo "checked";}} ?> value="localidad"></td>
          </tr>
          <tr>
            <td class="col-md-10"><label>Cargo</label></td>
            <td class="col-md-2"><input type="checkbox" name="filtro[]" <?php if(isset($_POST['filtro'])){if(in_array("cargo", $_POST['filtro'])){echo "checked";}} ?> value="cargo"></td>
          </tr>
          <tr>
            <td class="col-md-10"><label>Nombre del superior</label></td>
            <td class="col-md-2"><input type="checkbox" name="filtro[]" <?php if(isset($_POST['filtro'])){if(in_array("superior", $_POST['filtro'])){echo "checked";}} ?> value="superior"></td>
          </tr>
          <tr>
            <td class="col-md-10"><label>Nivel organizacional</label></td>
            <td class="col-md-2"><input type="checkbox" name="filtro[]" <?php if(isset($_POST['filtro'])){if(in_array("niveles organizacionales", $_POST['filtro'])){echo "checked";}} ?> value="niveles organizacionales"></td>
          </tr>
          <tr>
            <td class="col-md-10"><label>Tipo de contrato</label></td>
            <td class="col-md-2"><input type="checkbox" name="filtro[]" <?php if(isset($_POST['filtro'])){if(in_array("contrato", $_POST['filtro'])){echo "checked";}} ?> value="contrato"></td>
          </tr>
          <?php foreach ($condicionadores as $key => $value) { $value=reset($value); ?>
          <tr>
            <td class="col-md-10"><label><?php echo $value['nombre'] ?></label></td>
            <td class="col-md-2"><input type="checkbox" name="cond[]" value="<?php echo $value['id'] ?>"></td>
          </tr>
          <?php } ?>
          <tr>
            <td class="col-md-10"><label>Estado Civil</label></td>
            <td class="col-md-2"><input type="checkbox" name="filtro[]" <?php if(isset($_POST['filtro'])){if(in_array("estado civil", $_POST['filtro'])){echo "checked";}} ?> value="estado civil"></td>
          </tr>
          <?php $evaluaciones=reset($evaluaciones); foreach ($evaluaciones as $key => $value) {  if($value){?>
          <tr>
            <td class="col-md-10"><label><?php echo ucfirst(str_replace("_", " ", $key)) ?></label></td>
            <td class="col-md-2"><input type="checkbox" name="filtro[]" <?php if(isset($_POST['filtro'])){if(in_array($key, $_POST['filtro'])){echo "checked";}} ?> value="<?php echo $key ?>"></td>
          </tr>
          <?php } } ?>
        </table>
        <input type="submit" name="filtrar" class="btn btn-sm btn-info pull-right" value="Filtrar">
        <div class="clearfix"></div>
      </form>
    </div>

    <a href="#" class="btn btn-info btn-sm" id="openDialog">Filtrar columnas</a> 

  </div>
  <?php if(isset($resultados)){ ?>
  <div class="col-md-12 no-padding">
    <div class="col-md-3 col-xs-3 form-group">
      <input type="text" id="search" class="form-control" placeholder="Buscar">
    </div>
    <div class="form-group col-md-3 col-md-offset-6 text-right">
      <!-- <a id="imprimir" class="btn btn-success btn-sm" download="recomendaciones">Descargar Tabla</a> -->
    </div>
    <div>

      <!-- Nav tabs -->
      <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#per" aria-controls="per" role="tab" data-toggle="tab">Personal</a></li>
        <li role="presentation"><a href="#ii" aria-controls="ii" role="tab" data-toggle="tab">Ingreso incorrecto</a></li>
      </ul>

      <!-- Tab panes -->
      <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="per">

          <div id="personal" class="col-xs-12">
            <table class="table table-bordered table-striped table-hover table-heading table-datatable" id="table">
              <?php foreach ($resultados as $a => $b){ ?>
              <?php if(!$a){ ?>
              <thead>
                <tr>
                  <th>#</th>
                  <?php foreach ($b as $c => $d) { ?>
                  <?php foreach ($d as $e => $f) { ?>
                  <?php if($e!='id'){ ?>
                  <th>
                    <?php 
                    if(substr($e, 0, 4) == 'cond')
                      echo ucfirst(substr($e, 4)); 
                    else
                      echo ucfirst(str_replace("_", " ", $e)); 
                    ?> 
                  </th>
                  <?php } ?>
                  <?php } ?> 
                  <?php } ?>
                </tr>   
              </thead>
              <?php } ?>
              <tr>
                <td><?php echo $a + 1  ?></td>
                <?php foreach ($b as $c => $d) { ?>
                <?php foreach ($d as $e => $f) { ?>
                <?php if($e!='id'){ ?>
                <td>
                  <?php
                  if($e == 'nombre'){ ?>
                  <a href="<?php echo BASEURL.'personal/view/'.$id ?>"><?php echo $meth->htmlprnt($f) ?></a>
                  <?php   }elseif($e == 'fecha de nacimiento'){
                    echo $meth->print_fecha($f);
                  }elseif($e == 'fecha de ingreso'){
                    echo $meth->print_fecha($f);
                  }elseif($e == 'area'){
                    echo $meth->htmlprnt($meth->get_area($f));
                  }elseif($e == 'localidad'){
                    echo $meth->htmlprnt($meth->get_localidad($f));
                  }elseif($e == 'cargo'){
                    echo $meth->htmlprnt($meth->get_cargo($f));
                  }elseif($e == 'superior'){
                    echo $meth->htmlprnt($meth->get_pname($f));
                  }elseif($e == 'niveles organizacionales'){
                    echo $meth->htmlprnt($meth->get_norg($f));
                  }elseif($e == 'contrato'){
                    echo $meth->htmlprnt($meth->get_tcont($f));
                  }elseif($e == 'estado civil'){
                    echo $meth->htmlprnt($meth->get_eciv($f));
                  }elseif(substr($e, 0, 4) == 'cond'){
                    echo $meth->htmlprnt($meth->get_cond($f));
                  }elseif($e == 'compass_360'){ ?>
                  <div hidden><?php if($f){echo "Habilitado";}else{echo "Deshabilitado";} ?></div>
                  <div class="toggle-switch toggle-switch-success">
                    <label>
                      <input class="compass_personal" type="checkbox" <?php if($f) echo 'checked' ?> value="<?php echo $id ?>">
                      <div class="toggle-switch-inner"></div>
                      <div class="toggle-switch-switch"><i class="fa fa-check"></i></div>
                    </label>
                    <div  class="campo" hidden><input value="compass_360"></div>
                  </div>
                  <?php   }elseif($e == 'scorer'){ ?>
                  <div hidden><?php if($f){echo "Habilitado";}else{echo "Deshabilitado";} ?></div>
                  <div class="toggle-switch toggle-switch-success">
                    <label>
                      <input class="compass_personal" type="checkbox" <?php if($f) echo 'checked' ?> value="<?php echo $id ?>">
                      <div class="toggle-switch-inner"></div>
                      <div class="toggle-switch-switch"><i class="fa fa-check"></i></div>
                    </label>
                    <div  class="campo" hidden><input value="scorer"></div>
                  </div>
                  <?php   }elseif($e == 'matriz'){ ?>
                  <div hidden><?php if($f){echo "Habilitado";}else{echo "Deshabilitado";} ?></div>
                  <div class="toggle-switch toggle-switch-success">
                    <label>
                      <input class="compass_personal" type="checkbox" <?php if($f) echo 'checked' ?> value="<?php echo $id ?>">
                      <div class="toggle-switch-inner"></div>
                      <div class="toggle-switch-switch"><i class="fa fa-check"></i></div>
                    </label>
                    <div  class="campo" hidden><input value="matriz"></div>
                  </div>
                  <?php   }elseif($e == 'clima_laboral'){ ?>
                  <div hidden><?php if($f){echo "Habilitado";}else{echo "Deshabilitado";} ?></div>
                  <div class="toggle-switch toggle-switch-success">
                    <label>
                      <input class="compass_personal" type="checkbox" <?php if($f) echo 'checked' ?> value="<?php echo $id ?>">
                      <div class="toggle-switch-inner"></div>
                      <div class="toggle-switch-switch"><i class="fa fa-check"></i></div>
                    </label>
                    <div  class="campo" hidden><input value="clima_laboral"></div>
                  </div>
                  <?php   }else{
                    echo $f;
                  } ?>
                </td>
                <?php }else{$id = $f;} ?>
                <?php } ?> 
                <?php } ?>
              </tr> 
              <?php } ?>
            </table>
          </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="ii">          
          <table class="table table-bordered table-striped table-hover table-heading table-datatable" id="table2">
            <tr>
              <th>Nombre</th>
            </tr>
            <?php 
            foreach ($resultados2 as $key2 => $value2) {
              ?>
              <tr>
                <td>
                  <a href="<?php echo BASEURL.'personal/editar_datos_empresa/'.$value2['id'].'/1' ?>"><?php echo $meth->htmlprnt($value2['nombre_p']) ?></a>
                </td>
              </tr>
              <?php 
            }
            ?>
          </table>
        </div>
      </div>

    </div>
  </div>
  <?php } ?>    
</div>
<script type="text/javascript">
  $("#imprimir").click(function (e) {
    var html = $('#personal').html();
    html = html.replace(new RegExp('hidden', "g"), '');
    html = html.replace(new RegExp(' ', "g"), '');
    html = $(html).remove('.toggle-switch').html();
    var uri = 'data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,' + html;
    var downloadLink = document.createElement("a");
    downloadLink.href = uri;
    downloadLink.download = "personal.xls";
    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);
  });

  var $rows = $('#table tbody tr');
  $('#search').keyup(function() {

    var val = '^(?=.*\\b' + $.trim($(this).val()).split(/\s+/).join('\\b)(?=.*\\b') + ').*$',
    reg = RegExp(val, 'i'),
    text;

    $rows.show().filter(function() {
      text = $(this).text().replace(/\s+/g, ' ');
      return !reg.test(text);
    }).hide();
  });
  $(function() {
    $( "#openDialog").on("click", function(){ 
      $('#myModal').modal('show');
            /*var h = realHeight($('#fiter-table'));
            $( "#dialog-modal" ).dialog({
                title: "Filtrar Columnas",
                height: (h+90),
                modal: true
            }).prev(".ui-dialog-titlebar").css("color","black");
    $( "#dialog-modal" ).show();*/
  });
  });

  function realHeight(obj){
    var clone = obj.clone();
    clone.css("visibility","hidden");
    $('body').append(clone);
    var height = clone.outerHeight();
    clone.remove();
    return height;
  }
</script>
