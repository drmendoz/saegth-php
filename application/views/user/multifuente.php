<?php $meth = new User(); $util = new Util(); ?>
<form name="form1" method="post" action="<?php echo BASEURL.'user/multifuente/'.$cod_evaluado ?>" >
  <div class="row" align="center">
   <div class="row form-group col-md-12">
    <img src="<?php echo BASEURL ?>img/logolargoalde.bmp">
    <p>&nbsp;</p>
    <h1>Evaluación multifuentes</h1>  
    <p>&nbsp;</p>
    <h2>de: <?php echo $meth->htmlprnt($nombre_e);  ?></h2>  
    <p>&nbsp;</p>
    <p>Por favor conteste de la manera más objetiva posible</p>
    <div class="col-md-2 col-md-offset-5">
      <table class="table table-bordered">
        <tr>
          <td>1</td>
          <td>Nunca</td>
        </tr>
        <tr>
          <td>2</td>
          <td>Rara vez</td>
        </tr>
        <tr>
          <td>3</td>
          <td>A veces</td>
        </tr>
        <tr>
          <td>4</td>
          <td>Frecuentemente</td>
        </tr>
        <tr>
          <td>5</td>
          <td>Siempre</td>
        </tr>
        <tr>
          <td>NC</td>
          <td>No conozco lo suficiente</td>
        </tr>
      </table>
    </div>
  </div>
</div>
<?php foreach ($test as $a => $b) { $b = reset($b); ?>
<div class="row">
  <div class="col-md-12 no-padding">
    <table class="table col-md-12" border="0.5" cellpadding="0">
      <tr>
        <td class="col-xs-9">
          <?php echo Util::htmlprnt($b['pregunta']); ?>
        </td>
        <td class="col-xs-3">
          <?php $meth->getResultMulti($a); ?>
          <div hidden>
            <input type="text" name="c_preg[]" value="<?php echo $b['cod_pregunta'] ?>">
            <input type="text" name="c_tema[]" value="<?php echo $b['cod_tema'] ?>">
          </div>
        </td>
      </tr>
    </table>
  </div>
</div>
<?php    }
?>
<div hidden>
  <input type="text" name="cant" value="<?php echo $a ?>">
</div>
<div class="text-center">
  <div class="col-md-12 form-group">
    <p>&nbsp;</p>
    <h3><strong>Comentarios</strong></h3>
    <p>&nbsp;</p>
    <table class="col-md-10 col-md-offset-1" border="1" cellpadding="1">
      <tbody><tr>
        <td class="col-md-3" align="center"><strong>Fortalezas</strong></td>
        <td class="col-md-3" align="center"><strong>Oportunidades de Mejora</strong></td>
        <td class="col-md-3" align="center"><strong><center>
          El evaluado fuera mejor si hiciera lo siguiente:
        </center></strong></td>
      </tr>
      <tr>
        <td class="col-md-3"><textarea required="required" style="min-height: 80px" name="fortalezas" class="form-control"></textarea></td>
        <td class="col-md-3"><textarea required="required" style="min-height: 80px" name="debilidades" class="form-control"></textarea></td>
        <td class="col-md-3"><textarea required="required" style="min-height: 80px" name="comentarios" class="form-control"></textarea></td>
      </tr>
    </tbody></table>
  </div>
  <div class="col-md-12 form-group">
    <input type="submit" name="terminar" value="Terminar" id="terminar" />
    <input type="submit" name="terminar" value="Guardar y terminar m&aacute;s tarde" id="guardar" />
  </div>
</div>
<div class="row">
  <div id="i_error_log">
  </div>
</div>
<div class="row">
  <div class="col-md-12 text-center form-group bg-warning">
    <font style="font-family:Arial, Helvetica, sans-serif"  size="2">ASEGURESE DE HABER VALORADO TODAS Y CADA UNA DE LAS CASILLAS</font>
  </div>
</div>
</form>



