<?php $meth = new Util(); ?>
  <div class="row">
    <div class="col-md-12 show-grid">
      <h3 align="center">Administrador</h3>
    </div>
  </div>
  <p>&nbsp;</p>
  <div class="row">
    <div class="col-md-12 show-grid">
      <h4 align="center">Creacion de Test</h4>
    </div>
  </div>
  <form action="<?php echo BASEURL ?>multifuente/crear" method="POST">
    <div class="row">
      <div class="col-md-3 col-md-offset-3 show-grid">
        <h4>Empresa</h4>
      </div>
      <div class="col-md-3 show-grid">
        <select required="required" class="form-control" name="empresa" placeholder="Ingreso de nueva empresa">
          <option>-- Seleccionar Empresa --</option>
          <?php
            foreach ($empresas as $a => $b) {
              $c = $b['Empresa'];
              echo '<option value="'. $c['id'] .';'. Util::htmlprnt($c['nombre']) .'" >'. Util::htmlprnt($c['nombre']) .'</option>';
            }
          ?>    
          </select>
      </div>
    </div>
    <div class="row">
      <div class="col-md-3 col-md-offset-3 show-grid">
        <h4>Nombre Test</h4>
      </div>
      <div class="col-md-3 show-grid">
        <input type="text" required="required" name="nombre" class="form-control" placeholder="Nombre del test">
      </div>
    </div>
    <div class="row">
      <div class="col-md-3 col-md-offset-3 show-grid">
        <h4>Descripci&oacute;n</h4>
      </div>
      <div class="col-md-3 show-grid">
        <textarea name="descrip" class="form-control"></textarea>
      </div>
    </div>
    <div class="row">
      <div class="col-md-3 col-md-offset-6 show-grid">
        <input class="btn btn-default btn-xs" type="submit" name="button" value="Continuar">
      </div>
    </div>
  </form>