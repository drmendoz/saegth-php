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
<script type="text/javascript">
  $(document).on('ready', function(){
    $('#sonda').change(function(){
      if($(this).val() != ''){
        $('#frmDefinir').submit();
      }
    });
  });
</script>
<?php
$sonda = new Sonda();
if (isset($arrSondas) && is_array($arrSondas)) {
  $sonda->select_($_SESSION['Empresa']['id'], $arrSondas[0]);
  $seg = $sonda->getSegmentacion();
  $temas_vigentes = $sonda->getTemas();
}
?>
<form id="frmDefinir" class="form-horizontal" method="POST" action="<?php echo BASEURL ?>sonda/def_preguntas">
	<h4>Crear a partir de una evaluación existente:</h4>
  <div class="row">
    <div class="col-xxs-6 col-xs-8 col-sm-9 col-md-2">
      <select name="sonda" id="sonda" class="form-control" style="width: 200px">
        <option value="" style="display:none">Seleccione una opción</option>
        <?php
        $sonda->get_Sondas_Empresa($_SESSION['Empresa']['id'], '', $arrSondas);
        ?>
      </select>
    </div>
  </div>
  <br><br><br><br>
  <h4>Seleccionar opciones de segmentación:</h4>
  <div class="row">
    <label class="col-xxs-6 col-xs-4 col-sm-3 col-md-2 control-label">Edad</label>
    <div class="col-xxs-6 col-xs-8 col-sm-9 col-md-10">
      <input name="segmentacion[]" type="checkbox" value="edad" <?php echo (isset($arrSondas) && is_array($arrSondas)) ? (in_array('edad', $seg)) ? 'checked' : '' : '' ?>>
    </div>
  </div>
  <div class="row">
    <label class="col-xxs-6 col-xs-4 col-sm-3 col-md-2 control-label">Antigüedad</label>
    <div class="col-xxs-6 col-xs-8 col-sm-9 col-md-10">
      <input name="segmentacion[]" type="checkbox" value="antiguedad" <?php echo (isset($arrSondas) && is_array($arrSondas)) ? (in_array('antiguedad', $seg)) ? 'checked' : '' : '' ?>>
    </div>
  </div>
  <div class="row">
    <label class="col-xxs-6 col-xs-4 col-sm-3 col-md-2 control-label">Localidad</label>
    <div class="col-xxs-6 col-xs-8 col-sm-9 col-md-10">
      <input name="segmentacion[]" type="checkbox" value="localidad" <?php echo (isset($arrSondas) && is_array($arrSondas)) ? (in_array('localidad', $seg)) ? 'checked' : '' : '' ?>>
    </div>
  </div>
  <div class="row">
    <label class="col-xxs-6 col-xs-4 col-sm-3 col-md-2 control-label">Departamento</label>
    <div class="col-xxs-6 col-xs-8 col-sm-9 col-md-10">
      <input name="segmentacion[]" type="checkbox" value="departamento" <?php echo (isset($arrSondas) && is_array($arrSondas)) ? (in_array('departamento', $seg)) ? 'checked' : '' : '' ?>>
    </div>
  </div>
  <div class="row">
    <label class="col-xxs-6 col-xs-4 col-sm-3 col-md-2 control-label">Nivel Organizacional</label>
    <div class="col-xxs-6 col-xs-8 col-sm-9 col-md-10">
      <input name="segmentacion[]" type="checkbox" value="norg" <?php echo (isset($arrSondas) && is_array($arrSondas)) ? (in_array('norg', $seg)) ? 'checked' : '' : '' ?>>
    </div>
  </div>
  <div class="row">
    <label class="col-xxs-6 col-xs-4 col-sm-3 col-md-2 control-label">Tipo de contrato</label>
    <div class="col-xxs-6 col-xs-8 col-sm-9 col-md-10">
      <input name="segmentacion[]" type="checkbox" value="tcont" <?php echo (isset($arrSondas) && is_array($arrSondas)) ? (in_array('tcont', $seg)) ? 'checked' : '' : '' ?>>
    </div>
  </div>
  <div class="row">
    <label class="col-xxs-6 col-xs-4 col-sm-3 col-md-2 control-label">Educación</label>
    <div class="col-xxs-6 col-xs-8 col-sm-9 col-md-10">
      <input name="segmentacion[]" type="checkbox" value="educacion" <?php echo (isset($arrSondas) && is_array($arrSondas)) ? (in_array('educacion', $seg)) ? 'checked' : '' : '' ?>>
    </div>
  </div>
  <div class="row">
    <label class="col-xxs-6 col-xs-4 col-sm-3 col-md-2 control-label">Sexo</label>
    <div class="col-xxs-6 col-xs-8 col-sm-9 col-md-10">
      <input name="segmentacion[]" type="checkbox" value="sexo" <?php echo (isset($arrSondas) && is_array($arrSondas)) ? (in_array('sexo', $seg)) ? 'checked' : '' : '' ?>>
    </div>
  </div>
  <?php
  /*
  $model = new Model();
  $cond = $model->DB_exists_double('empresa_cond','id_empresa',$_SESSION["Empresa"]["id"],'nivel','0');
  if (is_array($cond)) {
    foreach ($cond as $key => $value) {
      $descripcion = $value['Empresa_cond']['nombre'];
      $valor = 'cond_'.$value['Empresa_cond']['id'];
  ?>
  <div class="row">
    <label class="col-xxs-6 col-xs-4 col-sm-3 col-md-2 control-label"><?php echo $descripcion ?></label>
    <div class="col-xxs-6 col-xs-8 col-sm-9 col-md-10">
      <input name="segmentacion[]" type="checkbox" value="<?php echo $valor ?>">
    </div>
  </div>
  <?php
    }
  }
  */
  ?>
  <h4>Fecha máxima de resolución:</h4>
  <div class="row">
    <label class="col-xxs-6 col-xs-4 col-sm-3 col-md-2 control-label">Fecha máxima</label>
    <div class="col-xs-4">
      <input type="date" name="fecha" class="form-control" value="<?php echo (isset($arrSondas) && is_array($arrSondas)) ? $sonda->htmlprnt_win($sonda->fecha) : '' ?>">
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
              pattern="[a-zA-Z0-9!#$%&amp;'*+\/=?^_`{|}~.-]+@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*"
              value="<?php echo (isset($arrSondas) && is_array($arrSondas)) ? $sonda->getEmail() : '' ?>">
    </div>
  </div>
  <h4>Temas:</h4>
  <div class="row">
  	<div class="col-sm-6">
  		<ul id="1" class="sortable">
  			<li class="text-center">Temas a evaluar</li>
        <?php
        if (isset($arrSondas) && is_array($arrSondas)) {
          if (is_array($temas_vigentes)) {
            foreach ($temas_vigentes as $id_tema => $valores) {
              if (is_array($valores))
                $id_t = $id_tema;
              else
                $id_t = $valores;
              
              $obj_sondaTema = new Sonda_tema();
              $obj_sondaTema->select($id_t);
              echo "<li>".ucfirst($obj_sondaTema->getTema())."<input name='temas[]' class='temas' hidden type='checkbox' value='".$obj_sondaTema->getId()."' checked></li>";
            }
          }
        }
        ?>
  		</ul>
  	</div>
  	<div class="col-sm-6">
  		<ul id="0" class="sortable">
  			<li class="text-center">Temas disponibles</li>
			<?php 
      $temas = new Sonda_tema(); 
			$l_temas=$temas->select_all_();
			foreach ($l_temas as $key => $value) {
        $temas->setId($value['id']);
        $temas->setTema($value['tema']);
        //
        if (isset($arrSondas) && is_array($arrSondas)) {
          if (is_array($temas_vigentes)) {
            foreach ($temas_vigentes as $id_tema => $valores) {
              if (is_array($valores)){
                $id_t = $id_tema;
              }
              else{
                $id_t = $valores;
              }

              if($temas->getId() == $id_t)
                continue 2;
            }
          }
        }
        //
				echo "<li>".ucfirst($temas->getTema())."<input name='temas[]' class='temas' hidden type='checkbox' value='".$temas->getId()."'></li>";
			} 
      ?>
  		</ul>
  	</div>
  </div>
  <div class="row">
    <div class="col-xxs-6 col-xs-4 col-sm-3 col-md-5">
      <label class="control-label" style="margin-right: 10px;">Incluir comentarios FODA</label>
      <input id="foda" name="foda" type="checkbox" value="1" <?php echo (isset($arrSondas) && is_array($arrSondas)) ? ($sonda->getFoda() == 1) ? 'checked' : '' : '' ?>>
      <br>
      <label class="control-label" style="margin-right: 10px;">Envio Personalizado</label>
      <input id="custom_email" name="custom_email" type="checkbox" value="1" <?php echo (isset($arrSondas) && is_array($arrSondas)) ? ($sonda->getCustom_email() == 1) ? 'checked' : '' : '' ?>>
    </div>
    <div class="col-xxs-6 col-xs-8 col-sm-9 col-md-7">
      <input type="submit" name="guardar" value="Continuar" class="btn-lg btn btn-default">
    </div>
  </div>
  <div class="clearfix"></div>
</form>
<script>
	$(function() {
		$( ".sortable" ).sortable({ 
			placeholder: "ui-sortable-placeholder",
			connectWith: 'ul.sortable',
			helper: 'clone',
			items: "> li:gt(0)", 
			revert: true,
			receive: function(event, ui) {
				var chk = ui.item.find('.temas')
	      console.log(this.id);
	      if(this.id == 1)
	      	console.log(chk[0].checked = true);
	      else
	      	console.log(chk[0].checked = false);
	    }
		});
	});
</script>