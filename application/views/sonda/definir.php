<!--    COLOR PICKER    -->
<link rel="stylesheet" type="text/css" href="<?php echo BASEURL ?>public/plugins/color-picker-master/colorPicker.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo BASEURL ?>public/plugins/color-picker-master/app.css" rel="stylesheet">

<script type="text/javascript" src="<?php echo BASEURL ?>public/plugins/color-picker-master/jquery.colorPicker.js"></script>
<script type="text/javascript" src="<?php echo BASEURL ?>public/plugins/color-picker-master/app.js"></script>
<!------------------------>

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
  .input-small{
    width: 80px;
    pointer-events: none;
  }

  .input_criterios{
    min-width: 150px;
  }
</style>
<script type="text/javascript">
  $(document).on('ready', function(){

    $('#sonda').on('change', function(){
      if($(this).val() != ''){
        document.getElementById("frmDefinir").submit();
      }
    });

    // CRITERIOS ESCALA
    $('#add_escala').on('click',function(){
      var str =   '<tr class="remove_tr_escala">';
          str +=  '<td><input class="input_criterios" name="escala_etiqueta[]" type="text" value="" required></td>';
          str +=  '<td><input class="input_criterios" name="escala_valor[]" type="number" value="" step="any" required></td>';
          str +=  '</tr>';
      $('#tbl_escala tbody').append(str);
    });

    $('#remove_escala').on('click',function(){
      $("#tbl_escala tbody").find( 'tr.remove_tr_escala:last' ).remove();
    });

    // CIRTERIOS BARRAS
    $('#add_barra').on('click',function(){
      var str =   '<tr class="remove_tr_barras">';
          str +=  '<td>';
          str +=  '<div class="control-group" style="margin-bottom: 0px;">';
          str +=  '<div class="input-prepend">';
          str +=  '<div class="colorPicker-picker add-on" style="background-color: rgb(255, 255, 255);">&nbsp;</div>';
          str +=  '<input type="text" class="color input-small" name="barras_color[]" value="#FFFFFF" required />';
          str +=  '</div>';
          str +=  '</div>';
          str +=  '</td>';
          str +=  '<td><input class="input_criterios" name="barras_desde[]" type="number" value="" step="any" required></td>';
          str +=  '<td><input class="input_criterios" name="barras_hasta[]" type="number" value="" step="any" required></td>';
          str +=  '</tr>';
      
      $('#tbl_barras tbody').append(str);
    });

    $('#remove_barra').on('click',function(){
      $('#tbl_barras tbody').find( 'tr.remove_tr_barras:last' ).remove();
    });


    $("#frmDefinir").submit(function(e){
      var rowCount = $('#tbl_escala tbody tr').length;
      if(rowCount < 1)
      {
        e.preventDefault();
        alert('Es necesario definir los criterios de escala');
      }
      else
      {
        $('#frmDefinir').submit();
      }
    });
  });
</script>
<?php
$sonda = new Sonda();
$nuevos_criterios = 1;
if (isset($arrSondas) && is_array($arrSondas))
{
  $sonda->select_($_SESSION['Empresa']['id'], $arrSondas[0]);
  $seg = $sonda->getSegmentacion();
  $temas_vigentes = $sonda->getTemas();
  $nuevos_criterios = $sonda->getNuevosCriterios();
  $criterios_escala = $sonda->getCriteriosEscala();
  $criterios_barras_colores = $sonda->getCriteriosBarrasColores();
  $criterios_rango_barras = $sonda->getCriteriosRangoBarras();
}
?>
<form id="frmDefinir" class="form-horizontal" method="POST" action="<?php echo BASEURL ?>sonda/def_preguntas">
	<h4>Crear a partir de una evaluación existente:</h4>
  <div class="row">
    <div class="col-xxs-6 col-xs-8 col-sm-9 col-md-2">
      <select name="sonda" id="sonda" class="form-control" style="width: 200px">
        <option value="" style="display:none">Seleccione una opción</option>
        <?php
        $sonda->get_Sondas_Empresa($_SESSION['Empresa']['id'], '', (isset($arrSondas)) ? $arrSondas : '');
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

  <br><br>
  <h4><input type="hidden" name="nuevos_criterios" id="nuevos_criterios" value="1" /></h4>
  <h4>
    <span>Criterios de escala:</span>
    <a class="btn btn-info btn-sm" id="add_escala">
      <span class="glyphicon glyphicon-plus-sign"></span>
    </a>
    <a class="btn btn-info btn-sm" id="remove_escala">
      <span class="glyphicon glyphicon-minus-sign"></span>
    </a>
  </h4>
  <div class="row">
    <div class="col-md-5">
      <table class="table table-bordered" id="tbl_escala">
        <thead>
          <tr>
            <th scope="col">Etiqueta</th>
            <th scope="col">Valor</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if (isset($arrSondas) && is_array($arrSondas)) {
            if ($nuevos_criterios == 0) {
          ?>
          <tr id="etiqueta_no_se" style="display: none;">
            <td><input name="escala_etiqueta[]" type="text" value="No se" class="input_criterios input-small"></td>
            <td><input name="escala_valor[]" type="text" value="X" class="input_criterios input-small"></td>
          </tr>
          <?php
            }
            else{
              if (is_array($criterios_escala)) {
                foreach ($criterios_escala as $key => $value) {
                  ?>
                    <tr <?php echo ($key == 0) ? 'id="etiqueta_no_se"' : 'class="remove_tr_escala"' ?> <?php echo ($key == 0) ? 'style="display:none;"' : '' ?>>
                      <td><input name="escala_etiqueta[]" type="text" value="<?php echo $value['escala_etiqueta'] ?>" class="input_criterios input-small"></td>
                      <td><input name="escala_valor[]" type="text" value="<?php echo $value['escala_valor'] ?>" class="input_criterios input-small"></td>
                    </tr>
                  <?php
                }
              }
            }
          }
          else{
          ?>
          <tr id="etiqueta_no_se" style="display: none;">
            <td><input name="escala_etiqueta[]" type="text" value="No se" class="input_criterios input-small"></td>
            <td><input name="escala_valor[]" type="text" value="X" class="input_criterios input-small"></td>
          </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>

  <br><br>
  <h4>
    <span>Criterios de barras:</span>
    <a class="btn btn-info btn-sm" id="add_barra">
      <span class="glyphicon glyphicon-plus-sign"></span>
    </a>
    <a class="btn btn-info btn-sm" id="remove_barra">
      <span class="glyphicon glyphicon-minus-sign"></span>
    </a>
  </h4>
  <div class="row">
    <div class="col-md-5">
      <table class="table table-bordered" id="tbl_barras">
        <thead>
          <tr>
            <th scope="col">Color Barra</th>
            <th scope="col">Promedio Desde</th>
            <th scope="col">Promedio Hasta</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if (isset($arrSondas) && is_array($arrSondas)) {
            if ($nuevos_criterios == 0) {
          ?>
          <tr id="barra_color_no_se" style="display: none;">
            <td>
              <div class="control-group" style="margin-bottom: 0px;">
                <div class="input-prepend">
                  <div class="colorPicker-picker" style="background-color: rgb(192, 192, 192);">&nbsp;</div>
                  <input type="text" class="input-small" name="barras_color[]" value="#C0C0C0" required />
                </div>
              </div>
            </td>
            <td><input class="input_criterios input-small" name="barras_desde[]" type="text" value="X"></td>
            <td><input class="input_criterios input-small" name="barras_hasta[]" type="text" value="X"></td>
          </tr>
          <tr class="remove_tr_barras">
            <td>
              <div class="control-group" style="margin-bottom: 0px;">
                <div class="input-prepend">
                  <input type="text" class="color input-small" name="barras_color[]" value="#FF0000" required/>
                </div>
              </div>
            </td>
            <td><input class="input_criterios" name="barras_desde[]" type="number" value="" step="any" required></td>
            <td><input class="input_criterios" name="barras_hasta[]" type="number" value="" step="any" required></td>
          </tr>
          <tr class="remove_tr_barras">
            <td>
              <div class="control-group" style="margin-bottom: 0px;">
                <div class="input-prepend">
                  <input type="text" class="color input-small" name="barras_color[]" value="#FFFF00" required/>
                </div>
              </div>
            </td>
            <td><input class="input_criterios" name="barras_desde[]" type="number" value="" step="any" required></td>
            <td><input class="input_criterios" name="barras_hasta[]" type="number" value="" step="any" required></td>
          </tr>
          <tr class="remove_tr_barras">
            <td>
              <div class="control-group" style="margin-bottom: 0px;">
                <div class="input-prepend">
                  <input type="text" class="color input-small" name="barras_color[]" value="#32CD32" required />
                </div>
              </div>
            </td>
            <td><input class="input_criterios" name="barras_desde[]" type="number" value="" step="any" required></td>
            <td><input class="input_criterios" name="barras_hasta[]" type="number" value="" step="any" required></td>
          </tr>
          <tr class="remove_tr_barras">
            <td>
              <div class="control-group" style="margin-bottom: 0px;">
                <div class="input-prepend">
                  <input type="text" class="color input-small" name="barras_color[]" value="#004A57" required />
                </div>
              </div>
            </td>
            <td><input class="input_criterios" name="barras_desde[]" type="number" value="" step="any" required></td>
            <td><input class="input_criterios" name="barras_hasta[]" type="number" value="" step="any" required></td>
          </tr>
          <?php
            }
            else{
              $criterios_barras_colores = $sonda->getCriteriosBarrasColores();
              $criterios_rango_barras = $sonda->getCriteriosRangoBarras();
              
              if (is_array($criterios_barras_colores) && is_array($criterios_rango_barras)) {
                foreach ($criterios_barras_colores as $key => $value) {
          ?>
          <tr <?php echo ($key == 0) ? 'id="barra_color_no_se" style="display: none;"' : 'class="remove_tr_barras"' ?>>
            <td>
              <div class="control-group" style="margin-bottom: 0px;">
                <div class="input-prepend">
                  <input type="text" class="color input-small" name="barras_color[]" value="<?php echo $value; ?>" required/>
                </div>
              </div>
            </td>
            <td><input class="input_criterios input-small" name="barras_desde[]" type="text" value="<?php echo $criterios_rango_barras[$key]['desde']; ?>"></td>
            <td><input class="input_criterios input-small" name="barras_hasta[]" type="text" value="<?php echo $criterios_rango_barras[$key]['hasta']; ?>"></td>
          </tr>
          <?php
                }
              }
            }
          }
          else{
          ?>
          <tr id="barra_color_no_se" style="display: none;">
            <td>
              <div class="control-group" style="margin-bottom: 0px;">
                <div class="input-prepend">
                  <div class="colorPicker-picker" style="background-color: rgb(192, 192, 192);">&nbsp;</div>
                  <input type="text" class="input-small" name="barras_color[]" value="#C0C0C0" required />
                </div>
              </div>
            </td>
            <td><input class="input_criterios input-small" name="barras_desde[]" type="text" value="X"></td>
            <td><input class="input_criterios input-small" name="barras_hasta[]" type="text" value="X"></td>
          </tr>
          <tr class="remove_tr_barras">
            <td>
              <div class="control-group" style="margin-bottom: 0px;">
                <div class="input-prepend">
                  <input type="text" class="color input-small" name="barras_color[]" value="#FF0000" required/>
                </div>
              </div>
            </td>
            <td><input class="input_criterios" name="barras_desde[]" type="number" value="" step="any" required></td>
            <td><input class="input_criterios" name="barras_hasta[]" type="number" value="" step="any" required></td>
          </tr>
          <tr class="remove_tr_barras">
            <td>
              <div class="control-group" style="margin-bottom: 0px;">
                <div class="input-prepend">
                  <input type="text" class="color input-small" name="barras_color[]" value="#FFFF00" required/>
                </div>
              </div>
            </td>
            <td><input class="input_criterios" name="barras_desde[]" type="number" value="" step="any" required></td>
            <td><input class="input_criterios" name="barras_hasta[]" type="number" value="" step="any" required></td>
          </tr>
          <tr class="remove_tr_barras">
            <td>
              <div class="control-group" style="margin-bottom: 0px;">
                <div class="input-prepend">
                  <input type="text" class="color input-small" name="barras_color[]" value="#32CD32" required />
                </div>
              </div>
            </td>
            <td><input class="input_criterios" name="barras_desde[]" type="number" value="" step="any" required></td>
            <td><input class="input_criterios" name="barras_hasta[]" type="number" value="" step="any" required></td>
          </tr>
          <tr class="remove_tr_barras">
            <td>
              <div class="control-group" style="margin-bottom: 0px;">
                <div class="input-prepend">
                  <input type="text" class="color input-small" name="barras_color[]" value="#004A57" required />
                </div>
              </div>
            </td>
            <td><input class="input_criterios" name="barras_desde[]" type="number" value="" step="any" required></td>
            <td><input class="input_criterios" name="barras_hasta[]" type="number" value="" step="any" required></td>
          </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>

  <br><br>
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
			$l_temas=$temas->select_all_sonda();
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
      <input type="submit" name="guardar" id="guardar" value="Continuar" class="btn-lg btn btn-default">
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

    // COLOR PICKER
    var $inputs = $('input.color');
    $inputs.colorPicker({pickerDefault: '#99CCFF'});

    $inputs.each(function(idx, item) {
      var $input = $(item);
      var $target = $input.parents('.control-group:first').find('label:first');
      $target.css('color', $input.val());

      $input.on('colorPicker:preview colorPicker:change', function(e, value) {
        $target.css('color', value);
      });

      $input.on('colorPicker:addSwatch', function(e, value) {
        //do something with custom color (e.g. persist on the server-side)
      });
    });

    //$('#tbl_barras').on('click', "td", function() { $( this ).toggleClass("colorPicker-picker"); });
    ////////////////////////////////////

	});
</script>