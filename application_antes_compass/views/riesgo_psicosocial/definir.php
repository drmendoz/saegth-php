<form class="form-horizontal" method="POST" action="<?php echo BASEURL ?>riesgo_psicosocial/evaluacion">
	<h4>Seleccionar opciones de segmentación:</h4>
  <div class="row">
    <label class="col-xxs-6 col-xs-4 col-sm-3 col-md-2 control-label">Edad</label>
    <div class="col-xxs-6 col-xs-8 col-sm-9 col-md-10">
      <input name="segmentacion[]" type="checkbox" value="edad">
    </div>
  </div>
  <div class="row">
    <label class="col-xxs-6 col-xs-4 col-sm-3 col-md-2 control-label">Antigüedad</label>
    <div class="col-xxs-6 col-xs-8 col-sm-9 col-md-10">
      <input name="segmentacion[]" type="checkbox" value="antiguedad">
    </div>
  </div>
  <div class="row">
    <label class="col-xxs-6 col-xs-4 col-sm-3 col-md-2 control-label">Localidad</label>
    <div class="col-xxs-6 col-xs-8 col-sm-9 col-md-10">
      <input name="segmentacion[]" type="checkbox" value="localidad">
    </div>
  </div>
  <div class="row">
    <label class="col-xxs-6 col-xs-4 col-sm-3 col-md-2 control-label">Departamento</label>
    <div class="col-xxs-6 col-xs-8 col-sm-9 col-md-10">
      <input name="segmentacion[]" type="checkbox" value="departamento">
    </div>
  </div>
  <div class="row">
    <label class="col-xxs-6 col-xs-4 col-sm-3 col-md-2 control-label">Nivel Organizacional</label>
    <div class="col-xxs-6 col-xs-8 col-sm-9 col-md-10">
      <input name="segmentacion[]" type="checkbox" value="norg">
    </div>
  </div>
  <div class="row">
    <label class="col-xxs-6 col-xs-4 col-sm-3 col-md-2 control-label">Tipo de contrato</label>
    <div class="col-xxs-6 col-xs-8 col-sm-9 col-md-10">
      <input name="segmentacion[]" type="checkbox" value="tcont">
    </div>
  </div>
  <div class="row">
    <label class="col-xxs-6 col-xs-4 col-sm-3 col-md-2 control-label">Educación</label>
    <div class="col-xxs-6 col-xs-8 col-sm-9 col-md-10">
      <input name="segmentacion[]" type="checkbox" value="educacion">
    </div>
  </div>
  <div class="row">
    <label class="col-xxs-6 col-xs-4 col-sm-3 col-md-2 control-label">Sexo</label>
    <div class="col-xxs-6 col-xs-8 col-sm-9 col-md-10">
      <input name="segmentacion[]" type="checkbox" value="sexo">
    </div>
  </div>
  <!--
  <div class="row">
    <label class="col-xxs-6 col-xs-4 col-sm-3 col-md-2 control-label">Tiene hijos</label>
    <div class="col-xxs-6 col-xs-8 col-sm-9 col-md-10">
      <input name="segmentacion[]" type="checkbox" value="hijos">
    </div>
  </div>
  -->
  <h4>Fecha máxima de resolución:</h4>
  <div class="row">
    <label class="col-xxs-6 col-xs-4 col-sm-3 col-md-2 control-label">Fecha máxima</label>
    <div class="col-xs-4">
      <input type="date" name="fecha" class="form-control">
    </div>
  </div>


  <h4>Email Link:</h4>
  <div class="row">
    <label class="col-xxs-6 col-xs-4 col-sm-3 col-md-2 control-label">Email</label>
    <div class="col-xs-4">
      <input  class="form-control" placeholder="Email" 
              name="email" 
              type="email" 
              title="Email (formato: xxx@xxx.xxx)" 
              required
              pattern="[a-zA-Z0-9!#$%&amp;'*+\/=?^_`{|}~.-]+@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*">
    </div>
  </div>

  <br><br>
  <br><br>
  <br><br>
  <br><br>
  <div class="row">
    <div class="col-xxs-6 col-xs-4 col-sm-3 col-md-3">
      <label class="control-label" style="margin-right: 10px;">Envio Personalizado</label>
      <input id="custom_email" name="custom_email" type="checkbox" value="1">
    </div>
    <div class="col-xxs-6 col-xs-8 col-sm-9 col-md-9">
      <input type="submit" name="guardar" value="Guardar" class="btn-lg btn btn-default">
    </div>
  </div>
  <div class="clearfix"></div>
</form>