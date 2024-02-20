<?php $meth = new User(); $util = new Util(); ?>

  <div class="row form-group col-md-12">
      <img src="<?php echo BASEURL ?>img/logolargoalde.bmp">
      <p>&nbsp;</p>
      <h1 class="text-center">PLAN DE ACCI&Oacute;N PARA DESARROLLO DE COMPETENCIAS</h1>
  </div>
  <form method="POST" action="<?php BASEURL.'multifuente/definir_plan' ?>">
    <div class="row form-group">
      <table class="table-bordered">
        <tr>
          <th class="col-md-4 text-center">Item a mejorar</th>
          <th class="col-md-2 text-center">Acci&oacute;n a tomar</th>
          <th class="col-md-2 text-center">Tipo de acci&oacute;n a tomar</th>
          <th class="col-md-2 text-center">Medici&oacute;n de acci&oacute;n</th>
          <th class="col-md-2 text-center">Fecha de cumplimiento</th>
        </tr>
        <?php $opt= array_unique($_POST['opt_m']); ?>
    <?php foreach ($opt as $a => $b) { ?>
        <tr>
          <td class="col-md-4">
            <?php echo $meth->get_preg($b); ?>
            <div hidden><input type="text" name="cod_p[]" value="<?php echo $b; ?>"></div>
          </td>
          <td class="col-md-2">
            <textarea class="form-control" required="required" name="accion[]"></textarea>
          </td>
          <td class="col-md-2">
            <select class="form-control" required="required" name="tipo[]">
              <option>- Seleccionar tipo-</option>
              <option name="Coaching">Coaching</option>
              <option name="Mentoring">Mentoring</option>
              <option name="Proyecto">Proyecto</option>
              <option name="Rotación">Rotación</option>
              <option name="Curso">Curso</option>
            </select>
          </td>
          <td class="col-md-2">
            <textarea class="form-control" required="required" name="medicion[]"></textarea>
          </td>
          <td class="col-md-2">
            <input type="date" class="form-control" required="required" name="fecha[]">
          </td>
        </tr>
    <?php }  ?>
      </table>
    </div>
    <div class="row text-center">
      <input type="submit" class="btn btn-default btn-xs" name="plan" value="guardar">
    </div>
  </form>