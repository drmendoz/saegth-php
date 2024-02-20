<?php 
if($_SESSION['USER-AD']['user_rol']==0){
	$id_e = 0;
}else{
	$id_e=$_SESSION['Empresa']['id'];
}

$tema = new Sonda_tema();
$tema->select($id);
?>
<h4>Tema</h4>
<div class="col-md-4 no-padding">
	<input type="text" name="txtTema" id="txtTema" class="form-control" value="<?php echo ucfirst($tema->getTema()); ?>" />
</div>
<div class="clearfix"></div>
<h4>Descripción</h4>
<div class="col-md-4 no-padding">
	<input type="hidden" id="id_tema" value="<?php echo $id ?>">
	<input type="hidden" id="id_empresa" value="<?php echo $id_e ?>">
	<textarea id="descripcion" class="form-control"><?php echo $tema->getDescripcion() ?></textarea>
</div>
<div class="clearfix"></div>
<h4>Agregar pregunta</h4>
<div class="col-md-4 no-padding">
	<div class="input-group">
		<input type="text" id="add_text" class="form-control" placeholder="Pregunta" aria-describedby="basic-addon2">
		<span class="input-group-btn">
			<button id="add" class="btn btn-default btn-sm" type="button" data-loading-text="Guardando...">Agregar</button>
			<input type="hidden" name="action" id="action" value="agrega">
			<input type="hidden" name="id_p" id="id_p" value="">
		</span>
	</div>
</div>
<div class="clearfix"></div>
<h4>Preguntas Creadas</h4>
<ul style="list-style-type: none;" id="pregunta_g">
	<?php
	$tema = new Sonda_pregunta();
	$res = $tema->select_x_tema_($id, 0, 1);
	foreach ($res as $key => $value) {
		$preg = new Sonda_pregunta($value);
		echo "<li id='li_".$preg->getId()."'>";
		$rutina = "elimina(".$preg->getId().",'pregunta_g')";
		echo '<a tabIndex="-1" class="elim_g" style="color:red; cursor:pointer;" onclick="'.$rutina.'"><i class="fa fa-times grow"></i></a>&nbsp;&nbsp;';
		$rutina = "edita(".$preg->getId().",'pregunta_g')";
		echo '<span class="glyphicon glyphicon-edit grow edit" style="color:blue; margin-right: 15px; cursor:pointer;" onclick="'.$rutina.'"></span>';
		echo $preg->getPregunta();
		echo "</li>";
	}
	?>
</ul>
<h4>Preguntas de la Empresa</h4>
<ul style="list-style-type: none;" id="pregunta">
	<?php
	$tema = new Sonda_pregunta();
	$res = $tema->select_x_tema_($id,$_SESSION['Empresa']['id'], 1);
	foreach ($res as $key => $value) {
		$preg = new Sonda_pregunta($value);
		echo "<li id='li_".$preg->getId()."'>";
		$rutina = "elimina(".$preg->getId().",'pregunta')";
		echo '<a tabIndex="-1" class="elim_g" style="color:red; cursor:pointer;" onclick="'.$rutina.'"><i class="fa fa-times grow"></i></a>&nbsp;&nbsp;';
		$rutina = "edita(".$preg->getId().",'pregunta')";
		echo '<span class="glyphicon glyphicon-edit grow edit" style="color:blue; margin-right: 15px; cursor:pointer;" onclick="'.$rutina.'"></span>';
		echo $preg->getPregunta();
		echo "</li>";
	}
	?>
</ul>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content panel-warning">
			<div class="modal-header panel-heading">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Advertencia</h4>
			</div>
			<div id="mbody" class="modal-body">
				<h5>Esta seguro de querer eliminar esta pregunta.</h5>
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

	function elimina(id_p,ul_id){
		$('#drop_tema').attr('onClick', "delete_pregunta('"+id_p+"','"+ul_id+"');");
		$('#preloader').empty();
		$(preloader).css('display','block');
        $('#preloader').append('<div style="position:absolute;left:50%;top:50%;color:white"><i class="fa fa-spinner fa-pulse fa-5x"></i></div>');
        $('#preloader').delay(250).fadeOut('slow');
        $('#myModal').modal('show');
	}

	function delete_pregunta(id_p,ul_id){
		var holder = 'elim_pregunta';
		var li = 'li_'+id_p;
		$.post(AJAX + holder, {
			id_p:id_p
		}, function(response) {
			var data = response.split(',');
			if(data[0] == 0){
				alert(data[1]);
			}else{
				$('#'+ul_id+ ' #'+li).remove();
			}
		});
	}

	function edita(id_p,ul_id){
		$('#action').val('actualiza');
		$('#id_p').val(id_p);
		var li = $('#li_'+id_p).text().trim();
		$('#add_text').val(li);
	}

	$('#add').on('click', function () {
		var $btn = $(this).button('loading')
		$.post(AJAX + 'sonda_pregunta_ajax', {
			tema:$('#id_tema').val(),
			empresa:$('#id_empresa').val(),
			pregunta:$('#add_text').val(),
			action:$('#action').val(),
			id_p:$('#id_p').val(),
		}, function(response) {
			$btn.button('reset');
			var data = response.split(',');
			if(data[0].search("error") != -1)
				$().toastmessage('showErrorToast', "Ocurrió un error");
			else{
				/*
				var node = document.createElement("LI"); 
				var textnode = document.createTextNode($('#add_text').val() ); 
				node.appendChild(textnode);      
				document.getElementById("pregunta").appendChild(node);
				$('.page-404').remove()
				$('#add_text').val("");
				*/
				location.reload();
			}
		});
	})

	$('#txtTema, #descripcion').on('blur', function () {
		$.post(AJAX + 'sonda_tema_desc_ajax', {
			id:$('#id_tema').val(),
			tema:$('#txtTema').val(),
			desc:$('#descripcion').val(),
		}, function(response) {
			var data = response.split(',');
		});
	})
</script>