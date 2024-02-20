<form id="cover_form">
	<input type="hidden" name="id_p" value="<?php echo $id ?>">
	<table id="cover" class="table table-bordered">
		<thead>
			<tr>
				<th colspan="10">Nombre: <?php $per = Personal::withID($id); echo $per->getNombre_p(); ?></th>
			</tr>
			<tr>
				<th width="8">#</th>
				<th>Potencial para cubrir</th>
				<th>Cargo</th>
				<th>Localidad</th>
				<th>Comentarios</th>
				<th>Horizonte temporal</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$cobertura = new Cobertura();
			$res = $cobertura->select_all($id);
			if(array_filter($res)){
				foreach ($res as $key => $value) {
					$obj = new Cobertura($value);
					?>

					<tr>
						<td width="8">
						<a tabIndex="-1" class="elim" style="color:red"><i class="fa fa-times fa-2x grow"></i></a>
						<input type="hidden" class="id" value="<?php echo $obj->getId() ?>">
						</td>
						<td>
							<select name="area[]" class="form-control">
								<option style="display:none" value="">-Seleccionar una opción</option>
								<?php
								$test = new Empresa_area();
								$test->get_select_options($_SESSION['Empresa']['id'],null,$obj->getId_area());
								?>
							</select>
						</td>
						<td>
							<select name="cargo[]" class="form-control">
								<option style="display:none">-Seleccionar una opción</option>
								<?php
								$test = new Empresa_cargo();
								$test->get_select_options($_SESSION['Empresa']['id'],$obj->getId_cargo());
								?>
							</select>
						</td>
						<td>
							<select name="local[]" class="form-control">
								<option style="display:none">-Seleccionar una opción</option>
								<?php
								$test = new Empresa_local();
								$test->get_select_options($_SESSION['Empresa']['id'],$obj->getId_local());
								?>
							</select>
						</td>
						<td><textarea name="comentario[]" class="form-control"><?php echo $obj->getComentario() ?></textarea></td>
						<td>
							<select name="month_1[]" class="form-control">
								<option value="0" <?php if($obj->getMonth_1() == 0) echo "selected"; ?>>Menor a 6 meses</option>
								<option value="1" <?php if($obj->getMonth_1() == 1) echo "selected"; ?>>De 6 a 12 meses</option>
								<option value="2" <?php if($obj->getMonth_1() == 2) echo "selected"; ?>>De 12 a 24 meses</option>
								<option value="3" <?php if($obj->getMonth_1() == 3) echo "selected"; ?>>de 2 a 3 años</option>
								<option value="4" <?php if($obj->getMonth_1() == 4) echo "selected"; ?>>Mayor a 3 años</option>	
							</select>
						</td>
					</tr>
					<?php
				}
			}else{
				$plan_desarrollo = new plan_desarrollo();
				$res = $plan_desarrollo->select_all($id);
				if(array_filter($res)){
					foreach ($res as $key => $value) {
						$obj = new Cobertura($value);
						?>

						<tr>
							<td width="8">
							<a tabIndex="-1" class="elim" style="color:red"><i class="fa fa-times fa-2x grow"></i></a>

							</td>
							<td>
								<select name="area[]" class="form-control">
									<option style="display:none" value="">-Seleccionar una opción</option>
									<?php
									$test = new Empresa_area();
									$test->get_select_options($_SESSION['Empresa']['id'],null,$obj->getId_area());
									?>
								</select>
							</td>
							<td>
								<select name="cargo[]" class="form-control">
									<option style="display:none">-Seleccionar una opción</option>
									<?php
									$test = new Empresa_cargo();
									$test->get_select_options($_SESSION['Empresa']['id'],$obj->getId_cargo());
									?>
								</select>
							</td>
							<td>
								<select name="local[]" class="form-control">
									<option style="display:none">-Seleccionar una opción</option>
									<?php
									$test = new Empresa_local();
									$test->get_select_options($_SESSION['Empresa']['id']);
									?>
								</select>
							</td>
							<td><textarea name="comentario[]" class="form-control"></textarea></td>
							<td>
								<select name="month_1[]" class="form-control">
									<option value="0">Menor a 6 meses</option>
									<option value="1">De 6 a 12 meses</option>
									<option value="2">De 12 a 24 meses</option>
									<option value="3">de 2 a 3 años</option>
									<option value="4">Mayor a 3 años</option>
								</select>
							</td>
						</tr>
						<?php
					}
				}else{
					?>

					<tr>
						<td width="8"><a tabIndex="-1" class="elim" style="color:red"><i class="fa fa-times fa-2x grow"></i></a></td>
						<td>
							<select name="area[]" class="form-control">
								<option style="display:none">-Seleccionar una opción</option>
								<?php
								$test = new Empresa_area();
								$test->get_select_options($_SESSION['Empresa']['id']);
								?>
							</select>
						</td>
						<td>
							<select name="cargo[]" class="form-control">
								<option style="display:none">-Seleccionar una opción</option>
								<?php
								$test = new Empresa_cargo();
								$test->get_select_options($_SESSION['Empresa']['id']);
								?>
							</select>
						</td>
						<td>
							<select name="local[]" class="form-control">
								<option style="display:none">-Seleccionar una opción</option>
								<?php
								$test = new Empresa_local();
								$test->get_select_options($_SESSION['Empresa']['id']);
								?>
							</select>
						</td>
						<td><textarea name="comentario[]" class="form-control"></textarea></td>
						<td>
							<select name="month_1[]" class="form-control">
								<option value="0">Menor a 6 meses</option>
								<option value="1">De 6 a 12 meses</option>
								<option value="2">De 12 a 24 meses</option>
								<option value="3">de 2 a 3 años</option>
								<option value="4">Mayor a 3 años</option>
							</select>
						</td>
					</tr>

					<?php
				}
			}
			?>
		</tbody>
	</table>
	<div class="btn-group col-md-4 col-md-offset-4" role="group" aria-label="...">
		<input type="submit"  id="addrow" class="btn btn-sm btn-info" data-loading-text="Guardando..." value="Agregar nueva fila">
		<input type="submit" id="submit" name="guardar" data-loading-text="Guardando..." class="btn btn-sm btn-success" value="Guardar">
	</div>
	<?php 
	$preferencias = new Plan_desarrollo();
	$preferencias = $preferencias->select_all($id);
	if($preferencias){ 
		?>
		<div class="clearfix"></div>
		<h4>Preferencias de desarrollo</h4>
		<table id="preferencia" class="table table-bordered">
			<tr>
				<th>&Aacute;rea - Cargo</th>
				<th>Plazo</th>
				<th>Acción a tomar</th>
				<th>Tipo de acción</th>
				<th>Fecha de cumplimiento</th>
			</tr>
			<?php
			foreach ($preferencias as $key => $value) {
				$value = new Plan_desarrollo($value);
				?>
				<tr>
					<td><?php echo $value->get_area2()." - ".$value->get_cargo2() ?></td>
					<td><?php echo $value->get_plazo() ?></td>
					<td><?php echo $value->getAccion() ?></td>
					<td><?php echo $value->getTipo() ?></td>
					<td><?php echo $value->getFecha() ?></td>
				</tr>
				<?php
			}
			?>
		</table>
		<?php 
	} 
	?> 
</form>
<div class="clearfix"></div>
<a class="btn btn-primary" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
	Ver información del personal
</a>
<div class="collapse" id="collapseExample">
	<div class="well">
		<?php
		$personal = new personalController('Personal','personal','view',0,true,true); 
		$personal->view($id); 
		$personal->ar_destruct();
		unset($personal);
		?>
	</div>
</div>
<script type="text/javascript">

	$('#cover').on('click','.elim',function(){
		console.log($(this).siblings('.id').val());	
		$.ajax({
      url: AJAX+"/delete_entity", // Get the action URL to send AJAX to
      type: "POST",	
      data: {id:$(this).siblings('.id').val(),model:'plan_desarrollo'}, // get all form variables
      success: function(result){

      }
    });
	_deleteRow_('cover',this);
});


	$('#addrow').click(function(){
		// cover_form_save(this);
		// $('.action').val("update");
		addRow__('cover');
		// $('.action').last().val('insert');
	});
	$('#submit').click(function(){
		cobertura_save(this);
	});

	function addRow__(tableID) {
		var table = document.getElementById(tableID);
		var rowCount = table.rows.length;
		if (true) {
			var e = 0;
			e = rowCount;
			var row = table.insertRow(e);
			var colCount = table.rows[2].cells.length;
			for (var i = 0; i < colCount; i++) {
				var newcell = row.insertCell(i);
				newcell.innerHTML = table.rows[2].cells[i].innerHTML;
				var element = jQuery(newcell).find('input');
				element.removeAttr('value');
				var element = jQuery(newcell).find('textarea');
				$(element).val('');
				var element = jQuery(newcell).find('select');
				$(element).val($(element).find('option:first').val());
				
			}
			$().toastmessage('showNoticeToast', 'Se ha agregado una fila');
		} else {
			alert("Maximum Passenger per ticket is 5.");

		}
	}



	function cobertura_save(obj){
		var $btn = $(obj).button('loading'); 
		var form = $('#cover_form');
		$.ajax({
      url: AJAX+"/cobertura_ajax", // Get the action URL to send AJAX to
      type: "POST",
      data: form.serialize(), // get all form variables
      success: function(result){
      	$().toastmessage('showSuccessToast', 'Se ha guardado el formulario');
      	window.oneye = result;
      	$btn.button('reset');
      	$('body').append(result);
      }
    });
	}

</script>