<script type="text/javascript" src="<?php echo BASEURL ?>public/plugins/tree/treejs.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo BASEURL ?>public/plugins/tree/treejs.css">

<style type="text/css">
	.nested-list li:before {
	    content: "";
	    counter-increment: item;
	}
</style>

<script type="text/javascript">
	window.onload = function () {
        $('#file_1').val("C:/AiOLog.txt");
    }
	$(document).ready(function() {

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
				str +=  '<input type="file" class="color input-small" name="simbolo[]" required/>';
				str +=  '</td>';
				str +=  '<td>';
				str +=  '<img width="300" src="<?php echo BASEURL.'files/evaluacion_desempenio/status.gif' ?>">';
				str +=  '</td>';
				str +=  '<td><input class="input_criterios" name="rango_desde[]" type="number" value="" step="any" required></td>';
				str +=  '<td><input class="input_criterios" name="rango_hasta[]" type="number" value="" step="any" required></td>';
				str +=  '</tr>';
	      
	      $('#tbl_barras tbody').append(str);
	    });

	    $('#remove_barra').on('click',function(){
	      $('#tbl_barras tbody').find( 'tr.remove_tr_barras:last' ).remove();
	    });
    });

    function preview(id) {
    	$('#'+id).attr('src', URL.createObjectURL(event.target.files[0]));
	}
</script>

<form id="frmDefinir" class="register" method="POST" enctype="multipart/form-data" action="<?php echo BASEURL ?>evaluacion_desempenio/definir">
	<div>
		<div class="tab-content" style="margin-top:15px">
			<h4>GENERAL:</h4>
			<div class="row">
				<label class="col-xxs-6 col-xs-4 col-sm-3 col-md-2 control-label">Fecha máxima:</label>
				<div class="col-xs-4">
					<input type="date" name="fecha" class="form-control" required>
				</div>
			</div>

			<div class="row">
				<label class="col-xxs-6 col-xs-4 col-sm-3 col-md-2 control-label">Email:</label>
				<div class="col-xs-4">
					<input  class="form-control" placeholder="Email" 
						name="email" 
						type="email" 
						title="Email (formato: xxx@xxx.xxx)" 
						required
						pattern="[a-zA-Z0-9!#$%&amp;'*+\/=?^_`{|}~.-]+@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*">
				</div>
			</div>

			<div class="row">
				<label class="col-xxs-6 col-xs-4 col-sm-3 col-md-2 control-label">Objetivos individuales:</label>
				<div class="col-xs-4">
					<input id="calificacion_scorecard" name="calificacion_scorecard" type="checkbox" value="1">
				</div>
			</div>
			<!--	END TAB - 1	-->
			<div class="clearfix"><br></div>
			<h4>
				<span>Criterios de escala:</span>
				<!--
				<a class="btn btn-info btn-sm" id="add_escala">
					<span class="glyphicon glyphicon-plus-sign"></span>
				</a>
				<a class="btn btn-info btn-sm" id="remove_escala">
					<span class="glyphicon glyphicon-minus-sign"></span>
				</a>
				-->
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
							<tr class="remove_tr_escala">
								<td><input class="input_criterios" name="escala_etiqueta[]" type="text" value="Deficiente" required></td>
								<td><input class="input_criterios" name="escala_valor[]" type="number" value="1" step="any" required></td>
							</tr>
							<tr class="remove_tr_escala">
								<td><input class="input_criterios" name="escala_etiqueta[]" type="text" value="Regular" required></td>
								<td><input class="input_criterios" name="escala_valor[]" type="number" value="2" step="any" required></td>
							</tr>
							<tr class="remove_tr_escala">
								<td><input class="input_criterios" name="escala_etiqueta[]" type="text" value="Promedio" required></td>
								<td><input class="input_criterios" name="escala_valor[]" type="number" value="3" step="any" required></td>
							</tr>
							<tr class="remove_tr_escala">
								<td><input class="input_criterios" name="escala_etiqueta[]" type="text" value="Bueno" required></td>
								<td><input class="input_criterios" name="escala_valor[]" type="number" value="3.5" step="any" required></td>
							</tr>
							<tr class="remove_tr_escala">
								<td><input class="input_criterios" name="escala_etiqueta[]" type="text" value="Muy Bueno" required></td>
								<td><input class="input_criterios" name="escala_valor[]" type="number" value="4" step="any" required></td>
							</tr>
							<tr class="remove_tr_escala">
								<td><input class="input_criterios" name="escala_etiqueta[]" type="text" value="Sobresaliente" required></td>
								<td><input class="input_criterios" name="escala_valor[]" type="number" value="4.5" step="any" required></td>
							</tr>
							<tr class="remove_tr_escala">
								<td><input class="input_criterios" name="escala_etiqueta[]" type="text" value="Extraordinario" required></td>
								<td><input class="input_criterios" name="escala_valor[]" type="number" value="5" step="any" required></td>
							</tr>								
						</tbody>
					</table>
				</div>
			</div>

			<div class="clearfix"><br></div>
			<h4>
				<span>Criterios de barras:</span>
				<!--
				<a class="btn btn-info btn-sm" onclick="addRow('tbl_barras')">
					<span class="glyphicon glyphicon-plus-sign"></span>
				</a>
				<a class="btn btn-info btn-sm" onclick="deleteRow('tbl_barras')">
					<span class="glyphicon glyphicon-minus-sign"></span>
				</a>
				-->
			</h4>
			<div class="row">
				<div class="col-md-5">
					<table class="table table-bordered" id="tbl_barras">
						<thead>
							<tr>
								<th scope="col">Simbolo</th>
								<th scope="col">Rango Desde</th>
								<th scope="col">Rango Hasta</th>
							</tr>
						</thead>
						<tbody>
							<tr class="remove_tr_barras">
								<td>
									<input type="hidden" name="simbolo[]" value="Deficiente.png" />
									<img id="simb_1" style="height: 25px; width: 25px;" src="<?php echo BASEURL.'public/uploads/evaluacion_desempenio/Deficiente.png' ?>">
								</td>
								<td><input class="input_criterios" name="rango_desde[]" type="number" value="0" step="any" required></td>
								<td><input class="input_criterios" name="rango_hasta[]" type="number" value="49.9" step="any" required></td>
							</tr>
							<tr class="remove_tr_barras">
								<td>
									<input type="hidden" name="simbolo[]" value="Regular.png" />
									<img id="simb_2" style="height: 25px; width: 25px;" src="<?php echo BASEURL.'public/uploads/evaluacion_desempenio/Regular.png' ?>">
								</td>
								<td><input class="input_criterios" name="rango_desde[]" type="number" value="50" step="any" required></td>
								<td><input class="input_criterios" name="rango_hasta[]" type="number" value="59.9" step="any" required></td>
							</tr>
							<tr class="remove_tr_barras">
								<td>
									<input type="hidden" name="simbolo[]" value="Promedio.png" />
									<img id="simb_3" style="height: 25px; width: 25px;" src="<?php echo BASEURL.'public/uploads/evaluacion_desempenio/Promedio.png' ?>">
								</td>
								<td><input class="input_criterios" name="rango_desde[]" type="number" value="60" step="any" required></td>
								<td><input class="input_criterios" name="rango_hasta[]" type="number" value="74.9" step="any" required></td>
							</tr>
							<tr class="remove_tr_barras">
								<td>
									<input type="hidden" name="simbolo[]" value="Bueno.png" />
									<img id="simb_4" style="height: 25px; width: 25px;" src="<?php echo BASEURL.'public/uploads/evaluacion_desempenio/Bueno.png' ?>">
								</td>
								<td><input class="input_criterios" name="rango_desde[]" type="number" value="75" step="any" required></td>
								<td><input class="input_criterios" name="rango_hasta[]" type="number" value="84.9" step="any" required></td>
							</tr>
							<tr class="remove_tr_barras">
								<td>
									<input type="hidden" name="simbolo[]" value="Muy_Bueno.png" />
									<img id="simb_5" style="height: 25px; width: 25px;" src="<?php echo BASEURL.'public/uploads/evaluacion_desempenio/Muy_Bueno.png' ?>">
								</td>
								<td><input class="input_criterios" name="rango_desde[]" type="number" value="85" step="any" required></td>
								<td><input class="input_criterios" name="rango_hasta[]" type="number" value="89.9" step="any" required></td>
							</tr>
							<tr class="remove_tr_barras">
								<td>
									<input type="hidden" name="simbolo[]" value="Sobresaliente.png" />
									<img id="simb_6" style="height: 25px; width: 25px;" src="<?php echo BASEURL.'public/uploads/evaluacion_desempenio/Sobresaliente.png' ?>">
								</td>
								<td><input class="input_criterios" name="rango_desde[]" type="number" value="90" step="any" required></td>
								<td><input class="input_criterios" name="rango_hasta[]" type="number" value="94.9" step="any" required></td>
							</tr>
							<tr class="remove_tr_barras">
								<td>
									<input type="hidden" name="simbolo[]" value="Extraordinario.png" />
									<img id="simb_7" style="height: 25px; width: 25px;" src="<?php echo BASEURL.'public/uploads/evaluacion_desempenio/Extraordinario.png' ?>">
								</td>
								<td><input class="input_criterios" name="rango_desde[]" type="number" value="95" step="any" required></td>
								<td><input class="input_criterios" name="rango_hasta[]" type="number" value="100" step="any" required></td>
							</tr>								
						</tbody>
					</table>
				</div>
			</div>
			<!--	END TAB - 2	-->
			<div class="clearfix"><br></div>
			<h4>TEMAS:</h4>
			<div class="col-md-12 nested-list">
				<?php
											
					$x = new Evaluacion_Desempenio_tema();
					$temas = $x->select_all_temas();
					foreach ($temas as $key => $value) {
						echo '<ul class="jtree_parent_node">';
							echo '<li>';
								echo '<span class="jtree_expand jtree_node_close"></span>';
								echo '<label><input type="checkbox" id="'. $value['id'] .'" name="temas[]" value="'. $value['id'] .'" parent-id="" class="jtree_parent_checkbox" checked> '. $x->htmlprnt($value['tema']) .'</label>';

								echo '<ul class="jtree_child_node" style="display: none;">';
								$y = new Evaluacion_desempenio_pregunta();
								$preguntas = $y->select_x_tema__($value['id'],$_SESSION['USER-AD']['id_empresa']);
								foreach ($preguntas as $id_p => $value_p) {
									echo '<li><label><input type="checkbox" id="'. $value_p['id'] .'" name="preguntas[]" value="'. $value['id'] .','. $value_p['id'] .'" parent-id="'. $value['id'] .'" class="jtree_child_checkbox" checked> '. $x->htmlprnt($value_p['pregunta']) .'</label></li>';
								}
								echo '</ul>';

							echo '<li>';
						echo '</ul>';
					}
				?>
			</div>
			<!--	END TAB - 3	-->

			<div class="clearfix"><br></div>
			<h4>TEXTO ENCUESTA:</h4>
			<div class="row">
				<label class="col-xxs-6 col-xs-4 col-sm-3 col-md-2 control-label">Texto:</label>
				<div class="col-md-8">
					<textarea name="texto_encuesta" id="texto_encuesta" rows="10" cols="150">Es imprescindible que responda con absoluta sinceridad y que sus respuestas se basen exclusivamente en su propia experiencia.  Encontrará más instrucciones una vez que haya ingresado su usuario y contraseña.  Este vínculo quedará desactivado una vez que haya respondiedo el cuestionario. La Escala de Calificación desde 1 a 5, siendo 1 la respuesta menos favorable y 5 la más favorable. Si Usted no conoce lo suficiente como para responder de una u otra forma cualquiera de las preguntas, por favor haga click en la Opción 'No sé' que está al extremo izquierdo de la escala de calificación.	Su Anotimato y Confidencialidad de las respuestas están garantizadas a pesar de que la primera parte del cuestionario le pide indicar alguna información organizacional, lo cual cumple el exclusivo propósito de poder estratificar y segmentar los resultados según esos criterios demográficos y así ayudar a los clientes a tomar mejores acciones correctivas sobre su Clima Organizacional.  Gracias anticipadas por su dedicación y confianza.</textarea>
				</div>
			</div>
		</div>
	</div>

	<div class="clearfix"><br></div>
	<div class="col-md-12 text-center">
		<div class="clearfix"></div>
		<input type="submit" name="guardar" value="Guardar" class="btn-lg btn btn-default">
	</div>

</form>