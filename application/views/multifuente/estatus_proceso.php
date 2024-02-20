<?php $meth = new Multifuente(); ?>
<!-- <form method="POST" action="<?php //echo BASEURL.'multifuente/estatus_proceso' ?>"> -->
	<div class="row form-group col-md-9" align="left">
		<div class="col-md-9 show-grid">
			<h3 align="left">Estado del Proceso Compass al <strong><?php echo date('d-M-Y'); ?></strong></h3>
		</div>
	</div>
	<div class="row form-group col-md-12" align="left">
		<table class=""  style="width: 50%; line-height: 20px; border: solid 1px #51c3eb;">
			<tr>
				<td class="col-md-8"><label class="">Fecha inicio:</label></td>
				<td align="center"><?php echo $fecha_inicio; ?></td>
				<td class="col-md-8"><label class="">Días transcurridos:</label></td>
				<td class="col-md-8" align="right"><?php echo $dias_transcurridos; ?></td>
			</tr>
			<tr>
				<td class="col-md-8"><label class="">Fecha tope:</label></td>
				<td align="center"><?php echo $fecha_tope; ?></td>
				<td class="col-md-8"><label class="">Días restantes:</label></td>
				<td class="col-md-8" align="right"><?php echo $dias_restantes; ?></td>
			</tr>
			<tr>
				<td class="col-md-8"><label class="">Fecha actual:</label></td>
				<td align="center"><?php echo $fecha_actual; ?></td>
				<td class="col-md-8"><label class="">Días adicionales:</label></td>
				<td class="col-md-8" align="right"><?php echo $dias_adicionales; ?></td>
			</tr>
			<tr>
				<td class="col-md-8"><label class="">Cuestionarios totales asignados:</label></td>
				<td align="right"><?php echo $cuestionarios_asignados; ?></td>
				<td class="col-md-8"><label class="">&nbsp;</label></td>
				<td align="right">&nbsp;</td>
			</tr>
			<tr>
				<td class="col-md-8"><label class="">Cuestionarios respondidos:</label></td>
				<td align="right"><?php echo $cuestionarios_respondidos; ?></td>
				<td class="col-md-8"><label class="">&nbsp;</label></td>
				<td class="col-md-8" align="right">&nbsp;</td>
			</tr>
			<tr>
				<td class="col-md-8"><label class="">Cuestionarios No respondidos:</label></td>
				<td align="right"><?php echo $cuestionarios_no_respondidos; ?></td>
				<td class="col-md-8"><label class="">&nbsp;</label></td>
				<td class="col-md-8" align="right">&nbsp;</td>
			</tr>
			<tr>
				<td class="col-md-8"><label class="">Ratio de cumplimiento diario:</label></td>
				<td align="right"><?php echo $ratio_cumplimiento_dia1; ?></td>
				<td class="col-md-8"><label class="">&nbsp;</label></td>
				<td class="col-md-8" align="right"><?php echo $ratio_cumplimiento_dia2; ?>%</td>
			</tr>
			<tr>
				<td class="col-md-8"><label class="">Ratio de cumplimiento proyectado a fecha tope:</label></td>
				<td align="right"><?php echo $ratio_cumplimiento_proyectado1; ?></td>
				<td class="col-md-8"><label class="">&nbsp;</label></td>
				<td class="col-md-8" align="right"><?php echo $ratio_cumplimiento_proyectado2; ?>%</td>
			</tr>
			<tr>
				<td class="col-md-8"><label class="">Ratio de cumplimiento proyectado a fecha actual:</label></td>
				<td align="right"><?php echo $ratio_cumplimiento_proyectado_actual1; ?></td>
				<td class="col-md-8"><label class="">&nbsp;</label></td>
				<td class="col-md-8" align="right">&nbsp;</td>
			</tr>
		</table>
	</div>
	<div class="row form-group col-md-9" align="left">
		<table border="0" cellpadding="20" cellspacing="20" style="width: 100%;">
			<thead>
				<tr>
					<th colspan="4"><h4>EVALUADORES</h4></th>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td align="center"><h5><strong>NOMBRE</strong></h5></td>
					<td align="center"><h5><strong>CARGO</strong></h5></td>
					<td align="center"><h5><strong>% CUMPLIMIENTO</strong></h5></td>
					<td align="center">
						<button class="btn btn-default btn-xs btnNotificacion" type="button" name="mail_evaluador" id="mail_evaluador" codigo_evaluador="X">Recordatorio Masivo</button>
					</td>
					<td>&nbsp;</td>
				</tr>
			</thead>
			<tbody>
				<?php
				if (count($listado) > 0){
					$i = 1;
					foreach ($listado as $cod_evaluador => $arrayEvaluados) {
						$explode = explode('-', $cod_evaluador);
						$sql = 'select * from listado_personal_op where id = '.$explode[0];
						$result = $meth->query_($sql, 1);
						$id = 'mail_evaluador'.$explode[0];

						echo '<tr>';
							echo '<td>'.$i.'</td>';
							echo '<td><strong>'.$meth->htmlprnt($result["nombre"]).'</strong></td>';
							echo '<td align="center">'.$meth->htmlprnt($result["cargo"]).'</td>';
							echo '<td align="center">'.$explode[1].'%</td>';
							echo '<td align="center"><button class="btn btn-default btn-xs btnNotificacion" type="button" name="'.$id.'" id="'.$id.'" codigo_evaluador="'.$explode[0].'">Recordatorio</button></td>';
							//echo '<td><input class="btn btn-default btn-xs btnNotificacion" type="button" name="$id" id="$id" codigo_evaluador="'.$explode[0].'" value="Recordatorio"></td>';
						echo '</tr>';

						$i++;
						if (count($arrayEvaluados) > 0) {
							foreach ($arrayEvaluados as $key => $value) {
								$sql = 'select * from listado_personal_op where id = '.$value["id_evaluado"];
								$result2 = $meth->query_($sql, 1);

								echo '<tr>';
									echo '<td colspan="3" style="padding-left:50px"><label id="evaluados" class="evaluados" style="color:#337ab7; cursor:pointer;" codigo="'.$result2["id"].'">'.$meth->htmlprnt($result2["nombre"]).'</label></td>';
									echo '<td align="center">'.$value["cumplimiento"].'%</td>';
									echo '<td></td>';
								echo '</tr>';
							}
						}
					}
				}
				?>
			</tbody>
		</table>
    </div>
<!-- </form> -->
<div class="col-md-12">
	<a href="<?php echo BASEURL ?>pdf/estatus_proceso_xls/<?php echo $filtro ?>" class="btn btn-sm btn-success">Descargar XLS</a>
</div>


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Evaluadores</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table-bordered" id="tblDetalle" style="width: 100%; line-height: 20px; border: solid 1px #51c3eb;">
        	<thead>
        		<th style="width: 50%;">Evaluador</th>
        		<th style="width: 30%; text-align: center;">Rol de Evaluador</th>
        		<th style="width: 20%; text-align: center;">Cumplimiento</th>
        	</thead>
        	<tbody>
        		<!-- <tr>
        			<td style="text-align: left; padding-left: 5px;">Jhen Pazmiño</td>
        			<td style="text-align: center;">100%</td>
        		</tr> -->
        	</tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="<?php echo BASEURL ?>public/plugins/tree/treejs.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo BASEURL ?>public/plugins/tree/treejs.css">

<style type="text/css">
	.nested-list li:before {
	    content: "";
	    counter-increment: item;
	}
</style>

<script type="text/javascript">
	$(document).ready(function(){
		$(document).on('click', '.jtree_expand', function(){
			if( $(this).hasClass('jtree_node_open') )
			{
				$(this).removeClass('jtree_node_open').addClass('jtree_node_close');
				$(this).next().next('ul').hide();
			}
			else
			{
				$(this).removeClass('jtree_node_close').addClass('jtree_node_open');
				$(this).next().next('ul').show();
			}
		});

		$(document).on('change', '.jtree_parent_checkbox', function(){
			
			if( $(this).is(':checked') )
			{
				var childUL = $(this).parent().next('ul');
				$(childUL).each(function(){
					$(this).find('li > label').find('input[type="checkbox"]').prop('checked', true);
				});
			}
			else
			{
				var childUL = $(this).parent().next('ul');
				$(childUL).each(function(){
					$(this).find('li > label').find('input[type="checkbox"]').prop('checked', false);
				});	
			}

		});

		$('.evaluados').click(function(event){
			$.post(AJAX + 'evaluadores_por_evaluado_ajax', {
				id_evaluado:$(this).attr('codigo'),
			}, function(result) {
				var data = $.parseJSON(result);
				var tabla = "";
				$.each(data, function (indice, valor) {
		            tabla += "<tr>";
		            	tabla += '<td style="text-align: left; padding-left: 5px;">'+valor.nombre+'</td>';
		            	tabla += '<td style="text-align: center;">'+valor.relacion+'</td>';
		            	tabla += '<td style="text-align: center;">'+valor.cumplimiento+'%</td>';
		            tabla += "</tr>";
		        });

		        $('#tblDetalle tbody').html(tabla);
			});

			$('#myModal').modal('show');
		});

		$('.btnNotificacion').click(function(e){
			var id = this.id;
			$('#' + id).prop('disabled', true);

			if($(this).attr('codigo_evaluador') == 'X'){
				$(this).html('Recordatorio Masivo <i class="fa fa-refresh fa-spin"></i>');
			}
			else{
				$(this).html('Recordatorio <i class="fa fa-refresh fa-spin"></i>');
			}

			$.post(AJAX + 'notificacion_compass_ajax', {
				codigo_evaluador:$(this).attr('codigo_evaluador'),
			}, function(response) {
				$('#' + id).html('');
				$('#' + id).prop('disabled', false);
				if($('#' + id).attr('codigo_evaluador') == 'X')
					$('#' + id).html('Recordatorio Masivo');
				else
					$('#' + id).html('Recordatorio');

				var data = response.split(',');
				if(data[0].search("error") == 0)
					$().toastmessage('showErrorToast', "Ocurrió un error: "+data[1]);
				else{
					$().toastmessage('showNoticeToast', "Notificación enviada");
				}
			});
		});
	});
</script>