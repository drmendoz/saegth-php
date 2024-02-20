<?php $meth = new Util(); ?>
  <div class="row">
    <div class="col-md-12 show-grid">
      <h3 align="center">Administrador</h3>
    </div>
  </div>
  <p>&nbsp;</p>
  <div class="row">
    <div class="col-md-12 show-grid">
      <h4 align="center">Temas</h4>
      <h4 align="center"><strong>Evaluaci&oacute;n Multifuentes</strong></h4>
    </div>
  </div>
  <form name="form1" action="<?php echo BASEURL ?>multifuente/crear_temas" method="POST">
    <div class="row">
      <div class="col-md-3 col-md-offset-3 show-grid">
        <h4>Tema</h4>
      </div>
      <div class="col-md-3 show-grid">
        <select required="required" class="form-control" name="tema" onchange="javascript:document.form1.submit();">
          <option>-- Seleccionar Tema --</option>
          <?php
            foreach ($temas as $a => $b) {
              $c = $b['Temas_360'];
              echo '<option value="'. $c['cod_tema'] .'" >'. Util::htmlprnt($c['tema']) .'</option>';
            }
          ?>    
          </select>
      </div>
    </div>
  </form>