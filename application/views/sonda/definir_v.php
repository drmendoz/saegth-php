<style type="text/css">
	.ui-sortable {
		width: 350px;
		margin: 50px auto;
		background-color: #ccc;
		-webkit-box-shadow:  0px 0px 10px 1px rgba(0, 0, 0, .1);
		box-shadow:  0px 0px 10px 1px rgba(0, 0, 0, .1);
		list-style-type: none; 
		padding: 0; 
	}
	.ui-sortable li.ui-sortable-handle { 
		margin: 0; 
		height: 45px;
		line-height: 48px;
		font-size: 1.4em; 
		color: #fff;
		outline: 0;
		padding: 0;
		margin: 0;
		text-indent: 15px;
		background: rgb(0, 74, 88);
		background: -moz-linear-gradient(top,  rgb(0, 74, 88) 0%, rgb(10, 62, 62) 100%);
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgb(0, 74, 88)), color-stop(100%,rgb(10, 62, 62)));
		background: -webkit-linear-gradient(top,  rgb(0, 74, 88) 0%,rgb(10, 62, 62) 100%);
		background: -o-linear-gradient(top,  rgb(0, 74, 88) 0%,rgb(10, 62, 62) 100%);
		background: -ms-linear-gradient(top,  rgb(0, 74, 88) 0%,rgb(10, 62, 62) 100%);
		background: linear-gradient(to bottom,  rgb(0, 74, 88) 0%,rgb(10, 62, 62) 100%);
		border-top: 1px solid rgba(255,255,255,.2);
		border-bottom: 1px solid rgba(0,0,0,.5);
		text-shadow: -1px -1px 0px rgba(0,0,0,.5);
		font-size: 1.1em;
		position: relative;
		cursor: pointer;
	}
	.ui-sortable li.ui-sortable-handle:first-child {
		border-top: 0; 
	}
	.ui-sortable li.ui-sortable-handle:last-child {
		border-bottom: 0;
	}
	.ui-sortable-placeholder {
		border: 3px dashed #aaa;
		height: 45px;
		width: 344px;
		background: #ccc;
	}
</style>
<?php
$sonda = new Sonda();
$sonda->select_($_SESSION['Empresa']['id'], $id_s);
$seg = $sonda->getSegmentacion();
$temas_vigentes = $sonda->getTemas();
?>
<form class="form-horizontal" method="POST" action="<?php echo BASEURL ?>sonda/definir_v/<?php echo $id_s ?>">
	<h4>Seleccionar opciones de segmentación:</h4>
  <div class="row">
    <label class="col-xxs-6 col-xs-4 col-sm-3 col-md-2 control-label">Edad</label>
    <div class="col-xxs-6 col-xs-8 col-sm-9 col-md-10">
      <input name="segmentacion[]" type="checkbox" value="edad" <?php echo (in_array("edad", $seg)) ? 'checked' : '' ?>>
    </div>
  </div>
  <div class="row">
    <label class="col-xxs-6 col-xs-4 col-sm-3 col-md-2 control-label">Antigüedad</label>
    <div class="col-xxs-6 col-xs-8 col-sm-9 col-md-10">
      <input name="segmentacion[]" type="checkbox" value="antiguedad" <?php echo (in_array("antiguedad", $seg)) ? 'checked' : '' ?>>
    </div>
  </div>
  <div class="row">
    <label class="col-xxs-6 col-xs-4 col-sm-3 col-md-2 control-label">Localidad</label>
    <div class="col-xxs-6 col-xs-8 col-sm-9 col-md-10">
      <input name="segmentacion[]" type="checkbox" value="localidad" <?php echo (in_array("localidad", $seg)) ? 'checked' : '' ?>>
    </div>
  </div>
  <div class="row">
    <label class="col-xxs-6 col-xs-4 col-sm-3 col-md-2 control-label">Departamento</label>
    <div class="col-xxs-6 col-xs-8 col-sm-9 col-md-10">
      <input name="segmentacion[]" type="checkbox" value="departamento" <?php echo (in_array("departamento", $seg)) ? 'checked' : '' ?>>
    </div>
  </div>
  <div class="row">
    <label class="col-xxs-6 col-xs-4 col-sm-3 col-md-2 control-label">Nivel Organizacional</label>
    <div class="col-xxs-6 col-xs-8 col-sm-9 col-md-10">
      <input name="segmentacion[]" type="checkbox" value="norg" <?php echo (in_array("norg", $seg)) ? 'checked' : '' ?>>
    </div>
  </div>
  <div class="row">
    <label class="col-xxs-6 col-xs-4 col-sm-3 col-md-2 control-label">Tipo de contrato</label>
    <div class="col-xxs-6 col-xs-8 col-sm-9 col-md-10">
      <input name="segmentacion[]" type="checkbox" value="tcont" <?php echo (in_array("tcont", $seg)) ? 'checked' : '' ?>>
    </div>
  </div>
  <div class="row">
    <label class="col-xxs-6 col-xs-4 col-sm-3 col-md-2 control-label">Educación</label>
    <div class="col-xxs-6 col-xs-8 col-sm-9 col-md-10">
      <input name="segmentacion[]" type="checkbox" value="educacion" <?php echo (in_array("educacion", $seg)) ? 'checked' : '' ?>>
    </div>
  </div>
  <div class="row">
    <label class="col-xxs-6 col-xs-4 col-sm-3 col-md-2 control-label">Sexo</label>
    <div class="col-xxs-6 col-xs-8 col-sm-9 col-md-10">
      <input name="segmentacion[]" type="checkbox" value="sexo" <?php echo (in_array("sexo", $seg)) ? 'checked' : '' ?>>
    </div>
  </div>
  <h4>Fecha máxima de resolución:</h4>
  <div class="row">
    <label class="col-xxs-6 col-xs-4 col-sm-3 col-md-2 control-label">Fecha máxima</label>
    <div class="col-xs-4">
      <input type="date" name="fecha" class="form-control" value="<?php echo $sonda->htmlprnt_win($sonda->fecha) ?>">
    </div>
  </div>
  <div class="clearfix"><br></div>
  <div class="text-center">
    <input type="submit" name="submit" value="Guardar" class="btn-lg btn btn-default">
  </div>
  <div class="clearfix"></div>
</form>