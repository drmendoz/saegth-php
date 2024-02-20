<?php
$meth = new Admin();
$util = new Util();
?>
<div class="row">
  <div class="col-md-3 col-xs-3 form-group">
    <input type="text" id="search" class="form-control" placeholder="Buscar">
  </div>
  <div class="col-xs-12">
    <table class="table table-bordered table-striped table-hover table-heading table-datatable" id="table">
      <thead>
        <tr>
          <th>#</th>
          <th>Nombre</th>
          <th>Administrador</th>
          <th>Correo</th>
          <th>Activo</th>
          <th>Compass 360</th>
          <th>Scorer</th>
          <th>Matriz</th>
          <th>Valoración</th>
          <th>Riesgo retención</th>
          <th>Clima Laboral</th>
          <th>Cobertura</th>
          <th>Riesgo de psicosocial</th>
        </tr>
      </thead>
      <tbody>
        <!-- Start: list_row -->
        <?php foreach ($empresa as $a => $b) { 
          $b = reset($b); ?>
          <tr>
            <td><?php echo ($a+1); ?></td>
            <td><a href="<?php echo BASEURL.'empresa/consolidado/'.$b['id'] ?>"><?php echo $util->htmlprnt($b['nombre']); ?></a></td>
            <td><?php if(isset($b['admin'])){ echo $util->htmlprnt($b['admin']);}else{ echo "N/A";} ?></td>
            <td><?php if(isset($b['email'])){ echo $b['email'];}else{ echo "N/A";} ?></td>
            <td>
              <div class="toggle-switch toggle-switch-success">
                <label>
                  <input class="compass_empresa" type="checkbox" <?php if($b['activo']) echo "checked"; ?> value="<?php echo $b['id'] ?>">
                  <div class="toggle-switch-inner"></div>
                  <div class="toggle-switch-switch"><i class="fa fa-check"></i></div>
                </label>
                <div  class="campo" hidden><input value="activo"></div>
              </div>
            </td>
            <td>
              <div class="toggle-switch toggle-switch-success">
                <label>
                  <input class="compass_empresa" type="checkbox" <?php if($b['compass_360']) echo "checked"; ?> value="<?php echo $b['id'] ?>">
                  <div class="toggle-switch-inner"></div>
                  <div class="toggle-switch-switch"><i class="fa fa-check"></i></div>
                </label>
                <div  class="campo" hidden><input value="compass_360"></div>
              </div>
            </td>
            <td>
              <div class="toggle-switch toggle-switch-success">
                <label>
                  <input class="compass_empresa" type="checkbox" <?php if($b['scorer']) echo "checked"; ?> value="<?php echo $b['id'] ?>">
                  <div class="toggle-switch-inner"></div>
                  <div class="toggle-switch-switch"><i class="fa fa-check"></i></div>
                </label>
                <div  class="campo" hidden><input value="scorer"></div>
              </div>
            </td>
            <td>
              <div class="toggle-switch toggle-switch-success">
                <label>
                  <input class="compass_empresa" type="checkbox" <?php if($b['matriz']) echo "checked"; ?> value="<?php echo $b['id'] ?>">
                  <div class="toggle-switch-inner"></div>
                  <div class="toggle-switch-switch"><i class="fa fa-check"></i></div>
                </label>
                <div  class="campo" hidden><input value="matriz"></div>
              </div>
            </td>
            <td>
              <div class="toggle-switch toggle-switch-success">
                <label>
                  <input class="compass_empresa" type="checkbox" <?php if($b['valoracion']) echo "checked"; ?> value="<?php echo $b['id'] ?>">
                  <div class="toggle-switch-inner"></div>
                  <div class="toggle-switch-switch"><i class="fa fa-check"></i></div>
                </label>
                <div  class="campo" hidden><input value="valoracion"></div>
              </div>
            </td>
            <td>
              <div class="toggle-switch toggle-switch-success">
                <label>
                  <input class="compass_empresa" type="checkbox" <?php if($b['retencion']) echo "checked"; ?> value="<?php echo $b['id'] ?>">
                  <div class="toggle-switch-inner"></div>
                  <div class="toggle-switch-switch"><i class="fa fa-check"></i></div>
                </label>
                <div  class="campo" hidden><input value="retencion"></div>
              </div>
            </td>
            <td>
              <div class="toggle-switch toggle-switch-success">
                <label>
                  <input class="compass_empresa" type="checkbox" <?php if($b['clima_laboral']) echo "checked"; ?> value="<?php echo $b['id'] ?>">
                  <div class="toggle-switch-inner"></div>
                  <div class="toggle-switch-switch"><i class="fa fa-check"></i></div>
                </label>
                <div  class="campo" hidden><input value="clima_laboral"></div>
              </div>
            </td>
            <td>
              <div class="toggle-switch toggle-switch-success">
                <label>
                  <input class="compass_empresa" type="checkbox" <?php if($b['cobertura']) echo "checked"; ?> value="<?php echo $b['id'] ?>">
                  <div class="toggle-switch-inner"></div>
                  <div class="toggle-switch-switch"><i class="fa fa-check"></i></div>
                </label>
                <div  class="campo" hidden><input value="cobertura"></div>
              </div>
            </td>
            <td>
              <div class="toggle-switch toggle-switch-success">
                <label>
                  <input class="compass_empresa" type="checkbox" <?php if($b['psicosocial']) echo "checked"; ?> value="<?php echo $b['id'] ?>">
                  <div class="toggle-switch-inner"></div>
                  <div class="toggle-switch-switch"><i class="fa fa-check"></i></div>
                </label>
                <div  class="campo" hidden><input value="psicosocial"></div>
              </div>
            </td>
            <!--<td><a href="<?php //echo BASEURL.'admin/empresa_ingreso/'.$b['id'] ?>">Modificar</a></td>-->
          </tr>
          <?php } ?> 
          <!-- End: list_row -->
        </tbody>
      </table>
    </div>
  </div>

  <script type="text/javascript">
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
  </script>
