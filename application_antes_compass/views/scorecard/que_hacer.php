<?php 
$qhac = new Que_hacer();
$qhac->setId_personal($id);
$qhac->setPeriodo($fecha);
 echo $fecha ;
?>
<div style="margin-top:20px" class="col-md-12">
	<div class="col-md-4">
		<form id="form_hacer_1">
			<input type="hidden" name="periodo" value="<?php echo $fecha ?>">
			<input type="hidden" name="tipo" value="1">
			<input type="hidden" name="id_p" value="<?php echo $id ?>">
			<table class="table table-bordered" id="hacer_1">
				<tr>
					<th class="text-center" colspan="2">Dejar de hacer</th>
				</tr>
				<?php 
				$res = $qhac->select_all("1");
				if($res){
					foreach ($res as $key => $value) {
						$qhac->select($value['id']);
						?>
						<tr>
							<td width="15">
								<a tabIndex="-1" class="elim" style="color:red"><i class="fa fa-times grow"></i></a>
							</td>
							<td>
								<input type="hidden" class="hacer_id" name="id[]" value="<?php echo $qhac->getId() ?>">
								<textarea class="form-control" name="comentario[]" ><?php echo $qhac->getComentario() ?></textarea>
							</td>
						</tr>
						<?php
					}
				}else{
				?>
				<tr>
					<td width="15">
						<a tabIndex="-1" class="elim" style="color:red"><i class="fa fa-times grow"></i></a>
					</td>
					<td>
						<input type="hidden" class="hacer_id" name="id[]">
						<textarea class="form-control" name="comentario[]" ></textarea>
					</td>
				</tr>
				<?php } ?>
				<tr>
					<td colspan="2" class="text-center">
						<div class="btn-group" role="group" aria-label="...">
							<button onclick="add_row_(event,'hacer_1')" class="btn btn-sm btn-info">Agregar fila</button>
							<button onclick="hacer_form_save(event,'form_hacer_1',this)" class="btn btn-sm btn-success" data-loading-text="Guardando...">Guardar</button>
						</div>
					</td>
				</tr>
			</table>
		</form>
	</div>
	<div class="col-md-4">
		<form id="form_hacer_2">
			<input type="hidden" name="periodo" value="<?php echo $fecha ?>">
			<input type="hidden" name="tipo" value="2">
			<input type="hidden" name="id_p" value="<?php echo $id ?>">
			<table class="table table-bordered" id="hacer_2">
				<tr>
					<th class="text-center" colspan="2">Seguir haciendo</th>
				</tr>
				<?php 
				$res = $qhac->select_all("2");
				if($res){
					foreach ($res as $key => $value) {
						$qhac->select($value['id']);
						?>
						<tr>
							<td width="15">
								<a tabIndex="-1" class="elim" style="color:red"><i class="fa fa-times grow"></i></a>
							</td>
							<td>
								<input type="hidden" class="hacer_id" name="id[]" value="<?php echo $qhac->getId() ?>">
								<textarea class="form-control" name="comentario[]" ><?php echo $qhac->getComentario() ?></textarea>
							</td>
						</tr>
						<?php
					}
				}else{
				?>
				<tr>
					<td width="15">
						<a tabIndex="-1" class="elim" style="color:red"><i class="fa fa-times grow"></i></a>
					</td>
					<td>
						<input type="hidden" class="hacer_id" name="id[]">
						<textarea class="form-control" name="comentario[]" ></textarea>
					</td>
				</tr>
				<?php } ?>
				<tr>
					<td colspan="2" class="text-center">
						<div class="btn-group" role="group" aria-label="...">
							<button onclick="add_row_(event,'hacer_2')" class="btn btn-sm btn-info">Agregar fila</button>
							<button onclick="hacer_form_save(event,'form_hacer_2',this)" class="btn btn-sm btn-success" data-loading-text="Guardando...">Guardar</button>
						</div>
					</td>
				</tr>
			</table>
		</form>
	</div>
	<div class="col-md-4">
		<form id="form_hacer_3">
			<input type="hidden" name="periodo" value="<?php echo $fecha ?>">
			<input type="hidden" name="tipo" value="3">
			<input type="hidden" name="id_p" value="<?php echo $id ?>">
			<table class="table table-bordered" id="hacer_3">
				<tr>
					<th class="text-center" colspan="2">Iniciar hacer</th>
				</tr>
				<?php 
				$res = $qhac->select_all("3");
				if($res){
					foreach ($res as $key => $value) {
						$qhac->select($value['id']);
						?>
						<tr>
							<td width="15">
								<a tabIndex="-1" class="elim" style="color:red"><i class="fa fa-times grow"></i></a>
							</td>
							<td>
								<input type="hidden" class="hacer_id" name="id[]" value="<?php echo $qhac->getId() ?>">
								<textarea class="form-control" name="comentario[]" ><?php echo $qhac->getComentario() ?></textarea>
							</td>
						</tr>
						<?php
					}
				}else{
				?>
				<tr>
					<td width="15">
						<a tabIndex="-1" class="elim" style="color:red"><i class="fa fa-times grow"></i></a>
					</td>
					<td>
						<input type="hidden" class="hacer_id" name="id[]">
						<textarea class="form-control" name="comentario[]" ></textarea>
					</td>
				</tr>
				<?php } ?>
				<tr>
					<td colspan="2" class="text-center">
						<div class="btn-group" role="group" aria-label="...">
							<button onclick="add_row_(event,'hacer_3')" class="btn btn-sm btn-info">Agregar fila</button>
							<button onclick="hacer_form_save(event,'form_hacer_3',this)" class="btn btn-sm btn-success" data-loading-text="Guardando...">Guardar</button>
						</div>
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>

<script type="text/javascript">
	function add_row_(event,tableID) {
		event.preventDefault();
		var table = document.getElementById(tableID);
		var rowCount = table.rows.length;
		if (true) {
			var e = 0;
			e = rowCount-1;
			var row = table.insertRow(e);
			var colCount = table.rows[1].cells.length;
			for (var i = 0; i < colCount; i++) {
				var newcell = row.insertCell(i);
				newcell.innerHTML = table.rows[1].cells[i].innerHTML;
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

	function hacer_form_save(event,f_id,obj) {
		event.preventDefault();
		var $btn = $(obj).button('loading'); 
		var form = $('#'+f_id);
		$.ajax({
      url: AJAX+"/hacer_ajax", // Get the action URL to send AJAX to
      type: "POST",
      data: form.serialize(), // get all form variables
      success: function(result){
      	$().toastmessage('showSuccessToast', 'Se ha guardado el formulario');
      	window.oneye = result;
      	$btn.button('reset');
      	$('body').append(result);
      	var inputs = $('#'+ f_id + ' .hacer_id');
      	$.each(JSON.parse(result),function(index,value){
      		$(inputs[index]).val(value.id);
      	});
      }
    });
	}

	$('#hacer_1').on('click','.elim',function(){
		$.ajax({
      url: AJAX+"/delete_entity", // Get the action URL to send AJAX to
      type: "POST",	
      data: {id:$(this).parentsUntil('table').children('td').children('input.hacer_id').val(),model:'que_hacer'}, // get all form variables
      success: function(result){
      	console.log(result);
      }
    });
		_deleteRow_('hacer_1',this);
	});
	$('#hacer_2').on('click','.elim',function(){
		$.ajax({
      url: AJAX+"/delete_entity", // Get the action URL to send AJAX to
      type: "POST",	
      data: {id:$(this).parentsUntil('table').children('td').children('input.hacer_id').val(),model:'que_hacer'}, // get all form variables
      success: function(result){
      	console.log(result);
      }
    });
		_deleteRow_('hacer_2',this);
	});
	$('#hacer_3').on('click','.elim',function(){
		$.ajax({
      url: AJAX+"/delete_entity", // Get the action URL to send AJAX to
      type: "POST",	
      data: {id:$(this).parentsUntil('table').children('td').children('input.hacer_id').val(),model:'que_hacer'}, // get all form variables
      success: function(result){
      	console.log(result);
      }
    });
		_deleteRow_('hacer_3',this);
	});
</script>