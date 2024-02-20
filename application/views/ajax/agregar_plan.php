
<?php

if($_REQUEST)
{
  $oportunidad = new Multifuente_oportunidades($_POST);
  $oportunidad->insert();
}

?>

<tr>
  <td>
    <a tabIndex="-1" class="elim picon" style="color:red"><i class="fa fa-times"></i></a>
    <div hidden><input type="text" class="evaluacion" name="evaluacion[]" value="1"></div>
    <div hidden><input type="text" class="id" name="id[]" value="<?php echo  $oportunidad->id ?>"></div>
    <div hidden><input type="text" class="uori" name="uori[]" value="insert"></div>
    
  </td>
  <td><a tabIndex="-1" class="addm picon"style="color:green"><i class="fa fa-plus-square"></i></a></td>
  <td class="col-md-4">
    <?php echo $oportunidad->htmlprnt($oportunidad->objetivo); ?>
  </td>
  <td class="col-md-2">
    <textarea class="form-control" required="required" name="accion[]"></textarea>
  </td>
  <td class="col-md-2">
    <select class="form-control" required="required" name="tipo[]">
      <option value="">- Seleccionar tipo-</option>
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