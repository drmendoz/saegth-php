<?php $meth = new Util(); ?>
  <div class="row">
    <div class="col-md-12 show-grid">
      <h3 align="center">Administrador</h3>
    </div>
  </div>
  <p>&nbsp;</p>
  <div class="row">
    <div class="col-md-12 show-grid">
      <h4 align="center">Preguntas</h4>
      <h4 align="center"><strong>Evaluaci&oacute;n Multifuentes</strong></h4>
    </div>
  </div>
  <form name="form1" action="<?php echo BASEURL ?>multifuente/crear_preguntas" method="POST">
    <div class="row">
      <div class="col-md-12 show-grid">
        <table class="table">
          <th>#</th>
          <th>Pregunta</th>
          <?php
            foreach ($preguntas as $a => $b) { 
              $c = $b['Preguntas_360']; ?>
              <tr>
                <td><input type="checkbox" name="chk[]" value="<?php echo $c['cod_pregunta'].','.$a ?>"></td>
                <td><input type="text" class="form-control" name="pregunta[]" readonly="readonly" value="<?php echo Util::htmlprnt($c['pregunta'])  ?>"></td>
              <tr>
  <?php     } ?>
          </table>
      </div>
    </div>
    <div class="row">
      <div class="col-md-3 col-md-offset-6 show-grid">
        <input class="btn btn-default btn-xs" type="submit" name="button" value="Guardar">
      </div>
    </div>
  </form>