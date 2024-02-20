<?php
$competencias = new Evaluacion_Desempenio_Competencia();
$result = $competencias->select_all_competencias();
?>
<h4>Temas Creados</h4>
<p>(Seguir el vinculo lleva a las preguntas del tema.)</p>
<div class="col-md-4 no-padding">
	<div class="input-group">
		<select name="tipo" id="tipo" class="form-control" placeholder="Competencias" aria-describedby="basic-addon2">
			<?php $competencias->get_competencias_combo(); ?>
		</select>
		<div class="clearfix"></div>
		<input type="text" id="add_text" class="form-control" placeholder="Tema" aria-describedby="basic-addon2">
		<span class="input-group-btn">
			<button id="add" class="btn btn-default btn-sm" type="button" data-loading-text="Guardando...">Agregar</button>
		</span>
	</div>
</div>
<div class="clearfix"></div>
<div id="tema">
	<?php

	$tema = new evaluacion_desempenio_tema();
	foreach ($result as $key => $value_comp) {
		echo "<h4>".$value_comp['competencias']."</h4>";
		$res = $tema->select_all_($value_comp['id']);
		foreach ($res as $key => $value) {
			echo "<h5>";
			$rutina = 'elimina('.$value["id"].')';
			echo '<a tabIndex="-1" class="elim" style="color:red; cursor:pointer;" onclick="'.$rutina.'"><i class="fa fa-times grow"></i></a>&nbsp;&nbsp;';
			echo "<a href='".BASEURL."evaluacion_desempenio/pregunta/".$value['id']."' class='text-upper'>".ucfirst($tema->htmlprnt($value['tema']))."</a>";
			echo "</h5>";
		}
	}
	
	?>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content panel-warning">
			<div class="modal-header panel-heading">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Advertencia</h4>
			</div>
			<div id="mbody" class="modal-body">
				<h5>Esta seguro de querer eliminar este tema, podría tener preguntas asignadas.</h5>
			</div>
			<div class="modal-footer" id="md_footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="button" class="btn btn-warning" id="drop_tema" data-dismiss="modal">Continuar</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$('#myModal').on('hidden.bs.modal', function (event) {
      	$('#mbody > .response').empty();
    })

	function elimina(id_t){
		$('#drop_tema').attr('onClick', 'delete_tema('+id_t+');');
		$('#preloader').empty();
		$(preloader).css('display','block');
        $('#preloader').append('<div style="position:absolute;left:50%;top:50%;color:white"><i class="fa fa-spinner fa-pulse fa-5x"></i></div>');
        $('#preloader').delay(250).fadeOut('slow');
        $('#myModal').modal('show');
	}

	function delete_tema(id_t){
		$.post(AJAX + 'eval_desemp_tema_elimina', {
			id_t:id_t
		}, function(response) {
			var data = response.split(',');
			if(data[0].search("error") != -1)
				$().toastmessage('showErrorToast', "Ocurrió un error: "+data[1]);
			else{
				location.reload();
			}
		});
	}

	$('#add').on('click', function () {
		var $btn = $(this).button('loading')
		$.post(AJAX + 'eval_desemp_tema_ajax', {
			tema:$('#add_text').val(),
			competencias:$('#tipo').val(),
		}, function(response) {
			$btn.button('reset');
			var res = response
			res = res.split(",")
			if(res[0]=="error")
				$().toastmessage('showErrorToast', "Ocurrió un error");
			else{
				/*
				$().toastmessage('showSuccessToast', "Se ha guardado con éxito");
				$('#tema').append(res[1]);
				$('.page-404').remove()
				$('#add_text').val("")
				*/
				location.reload();
			}
		});
	})
</script>