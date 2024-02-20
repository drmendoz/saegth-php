<style type="text/css">
	.table > tbody > tr > th,
	.table > tbody > tr > td{
		padding: 5px !important;
	}
</style>
<script type="text/javascript">
	$(document).ready(function() {

		var escala_valor = $('#escala_valor').val();

		$('#tblRspEnc input[type=text]').keyup(function (){
			if (escala_valor.indexOf($(this).val()) != -1)
			{
				var cb = parseInt($(this).attr('tabindex'));
				if ( $(':input[tabindex=\'' + (cb + 1) + '\']') != null) {
					$(':input[tabindex=\'' + (cb + 1) + '\']').focus();
					$(':input[tabindex=\'' + (cb + 1) + '\']').select();
				return false;
				}
			}
			else
			{
				$(this).val('');
			}
		});
		
		$( "#target" ).submit(function( event ) {

			var tipo_evaluacion = 0;
			$('input[type=checkbox]').each(function(){
				if($(this).is(':checked') == true)
				{
					tipo_evaluacion = 1;
					return false;
				}
		    });

		    if (tipo_evaluacion == 0) {
				$('#btnTipEval').focus();
				$().toastmessage('showErrorToast', 'Eliga el tipo de evaluación !!!');
				event.preventDefault();
				return false;
		    }

			$('#tbl_Comp_Org tr.tr_preg, #tbl_Comp_Adm tr.tr_preg, #tbl_Comp_Lab tr.tr_preg').each(function(){
				var count_check = 0;
				$(this).find('input').each(function(){
					var type = $(this).attr('type');
					if(type == 'text'){
						count_check = 1;
	        			var respEnc = $(this).val();
	        			if(respEnc == ''){
	        				$().toastmessage('showErrorToast', 'Todas las preguntas deben ser contestadas !!!');
				 			event.preventDefault();
				 			return false;
	        			}
	        		}else{
	        			if($(this).is(':checked')){
	        				count_check++;
	        			}
	        		}
				});

				if(count_check < 1){
    				$().toastmessage('showErrorToast', 'Todas las preguntas deben ser contestadas !!!');
		 			event.preventDefault();
		 			return false;
    			}
			});

		});
		
	});
</script>
<?php
$i = 1;
$sonda = new Evaluacion_desempenio();
$sonda->select_($id_e,$id_t);
$seg = $sonda->getSegmentacion();
$temas = $sonda->getTemas();
$criterios_escala = array_reverse($sonda->getCriteriosEscala(), true);
$criterios_rango = array_reverse($sonda->getCriteriosRangoBarras(), true);
$criterios_simbolo = array_reverse($sonda->getCriteriosSimbolos(), true);

$puntaje = array();
$calificacion = array();
foreach ($criterios_escala as $key => $array) {
	array_push($puntaje, $criterios_escala[$key]['escala_valor']);
	array_push($calificacion, $criterios_escala[$key]['escala_etiqueta']);
}

$rango = array();
foreach ($criterios_rango as $key => $array) {
	array_push($rango,array_reverse($array, true));
}

if($_SESSION['USER-AD']['user_rol'] == 13 || $_SESSION['USER-AD']['user_rol'] == 15){
	$width = "300px";
}else{
	$width = "800px";
}
?>
<form id="target" class="form" method="POST" action="<?php echo BASEURL ?>evaluacion_desempenio/test_temp/<?php echo $id_e ?>/<?php echo $id_t ?>">
	<?php if (in_array("edad", $seg)): ?>
		<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
			<div class="panel-heading">Edad</div>
			<div class="panel-body">
				<select name="edad" class="form-control">
					<option style="display:none">Seleccione una opción</option>
					<option value="0">Menor a 20 años</option>
					<option value="1">De 21 a 25 años</option>
					<option value="2">De 26 a 30 años</option>
					<option value="3">De 31 a 40 años</option>
					<option value="4">De 41 a 50 años</option>
					<option value="5">Mas de 50 años</option>
				</select>
			</div>
		</div>
	<?php endif ?>
	<?php if (in_array("antiguedad", $seg)): ?>
		<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
			<div class="panel-heading">Antigüedad</div>
			<div class="panel-body">
				<select name="antiguedad" class="form-control">
					<option value="" style="display:none">Seleccione una opción</option>
					<option value="7">De 0 a 3 meses</option>
					<option value="1">De 3 meses a 2 años</option>
					<option value="2">De 2 a 5 años </option>
					<option value="3">De 5 a 10 años </option>
					<option value="4">De 10 a 15 años</option>
					<option value="5">De 15 a 20 años</option>
					<option value="6">Más 20 años</option>
				</select>
			</div>
		</div>
	<?php endif ?>
	<?php if (in_array("localidad", $seg)): ?>
		<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
			<div class="panel-heading">Localidades</div>
			<div class="panel-body">
				<select name="localidad" class="form-control">
					<option value="" style="display:none">Seleccione una opción</option>
					<?php
					$test = new Empresa_local();
					$test->get_select_options($_SESSION['Empresa']['id']);
					?>
				</select>
			</div>
		</div>
	<?php endif ?>
	<?php if (in_array("departamento", $seg)): ?>
		<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
			<div class="panel-heading">Departamento</div>
			<div class="panel-body">
				<select name="area" class="form-control">
					<option value="" style="display:none">Seleccione una opción</option>
					<?php
					$test = new Empresa_area();
					$test->get_select_options($_SESSION['Empresa']['id']);
					?>
				</select>
			</div>
		</div>
	<?php endif ?>
	<?php if (in_array("norg", $seg)): ?>
		<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
			<div class="panel-heading">Niveles Organizacionales</div>
			<div class="panel-body">
				<select name="norg" class="form-control">
					<option value="" style="display:none">Seleccione una opción</option>
					<?php
					$test = new Empresa_norg();
					$test->get_select_options($_SESSION['Empresa']['id']);
					?>
				</select>
			</div>
		</div>
	<?php endif ?>
	<?php if (in_array("tcont", $seg)): ?>
		<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
			<div class="panel-heading">Tipo de contrato</div>
			<div class="panel-body">
				<select name="tcont" class="form-control">
					<option value="" style="display:none">Seleccione una opción</option>
					<?php
					$test = new Empresa_tcont();
					$test->get_select_options($_SESSION['Empresa']['id']);
					?>
				</select>
			</div>
		</div>
	<?php endif ?>
	<?php if (in_array("educacion", $seg)): ?>
		<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
			<div class="panel-heading">Educación</div>
			<div class="panel-body">
				<select name="educacion" class="form-control">
					<option value="" style="display:none">Seleccione una opción</option>
					<option value="0">Primaria incompleta</option>
					<option value="1">Primaria completa</option>
					<option value="2">Secundaria incompleta </option>
					<option value="3">Secundaria completa </option>
					<option value="4">Universidtaria incompleta</option>
					<option value="5">Universitaria completa</option>
					<option value="6">Postgrado</option>
				</select>
			</div>
		</div>
	<?php endif ?>
	<?php if (in_array("sexo", $seg)): ?>
		<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
			<div class="panel-heading">Sexo</div>
			<div class="panel-body">
				<select name="sexo" class="form-control">
					<option value="" style="display:none">Seleccione una opción</option>
					<option value="0">Masculino</option>
					<option value="1">Femenino</option>
				</select>
			</div>
		</div>
	<?php endif ?>
	<?php
	$model = new Model();
	$meth = new Empresa();
	$cond = $model->DB_exists_double('empresa_cond','id_empresa',$_SESSION["Empresa"]["id"],'nivel','0');
	if (is_array($cond)) {
		foreach ($cond as $key => $value) {
			$descripcion = $value['Empresa_cond']['nombre'];
			$id_superior = $value['Empresa_cond']['id'];
			if (in_array("cond_".$id_superior, $seg)) {
	?>
		<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
			<div class="panel-heading"><?php echo ucfirst($descripcion); ?></div>
			<div class="panel-body">
				<select name="sexo" class="form-control">
					<option value="" style="display:none">Seleccione una opción</option>
					<?php
					$opc = $meth->query('select id,nombre,id_superior from empresa_cond WHERE nivel=1 AND id_superior='.$id_superior.'');
                    echo mysqli_error($meth->link);
                    $tmp =array_filter($opc); 
                    if (!empty($tmp)){ 
                        foreach ($opc as $a => $b) {
                            if(($id_superior === $b["Empresa_cond"]['id_superior'])){
                            	$new_id = $b['Empresa_cond']['id'];
                            	$new_descripcion = $b['Empresa_cond']['nombre'];
                            	echo '<option value="'.$new_id.'">'.ucfirst($new_descripcion).'</option>';
                            }
                        }
                    }
					?>
				</select>
			</div>
		</div>
	<?php
			}
		}
	}
	?>
	<div class="clearfix"></div>
	<h4><b>CLAVE DE RESPUESTAS:</b></h4>
	<?php
	foreach ($criterios_escala as $key => $value) {
		echo '<p><b>'.$value['escala_valor'].' - </b>'.utf8_encode($value['escala_etiqueta']).'</p>';
	}
	?>

	<table class="table table-bordered table-hover" id="tblRspEnc">
		<tbody>
			<tr>
				<th><h4 align="center">FORMULARIO DE EVALUACION DE DESEMPEÑO</h4></th>
			</tr>
			<tr>
				<th><h4 align="center">AÑO <?php echo date('Y'); ?></h4></th>
			</tr>
			<tr>
				<th><h6 align="left">
					<p>La Evaluación de Desempeño, es un instrumento diseñado con el propósito de que tanto el Colaborador como Jefe Inmediato, puedan "RECONOCER, RESALTAR o IDENTIFICAR" fortalezas y/o oportunidades de mejoras del desempeño organizacional en pro del logro de los objetivos.</p>
				</h6></th>
			</tr>
			<tr>
				<th>
					<table>
						<tbody>
							<tr><td>Las Escalas de Evaluación utilizada en el instrumento son las siguientes::</td></tr>
							<tr>
								<td>
									<table class="table table-bordered">
										<tbody>
											<tr>
												<td>Puntaje</td>
												<?php
												foreach ($puntaje as $key => $valor) {
													echo "<td>".$valor."</td>";
												}
												?>
											</tr>
											<tr>
												<td>Calificaci&oacute;n</td>
												<?php
												foreach ($calificacion as $key => $valor) {
													echo "<td>".$valor."</td>";
												}
												?>
											</tr>
											<tr>
												<td>Rango</td>
												<?php
												foreach ($rango as $key => $valor) {
													echo "<td>".$valor['hasta']." al ".$valor['desde']."</td>";
												}
												?>
											</tr>
											<tr>
												<td>Simbolo</td>
												<?php
												foreach ($criterios_simbolo as $key => $valor) {
													echo '<td align="center"><img id="simb_6" style="height: 25px; width: 25px;" src="'.BASEURL.'public/uploads/evaluacion_desempenio/'.$valor.'"></td>';
												}
												?>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
				</th>
			</tr>
			<tr>
				<th>
					<p>Instrucciones:</p>
					<p>1.- Leer detenidamente, cada una de los factores ha evaluar.</p>
					<p>2.- Responder objetivamente cada una de ellas, en base a tu evaluación del Desempeño del evaluado.</p>
					<p>3.- Completa todas las preguntas, marcando con un "X", en la casilla que considera representa el desempeño obtenido.</p>
					<p>4.- Al finalizar, revisa que todas las preguntas tenga una respuesta de tu parte.</p>
					<p>5.- Recuerda que la idea <strong>Es Reconocer el Desempeño Alcanzado"</strong>.</p>
				</th>
			</tr>
			<tr>
				<th colspan="3">
					<table class="table table-bordered table-hover">
						<tbody>
							<tr>
								<td colspan="2">DATOS DE IDENTIFICACIÓN EVALUADO:</td>
								<td colspan="2">DATOS DE IDENTIFICACIÓN EVALUADOR:</td>
								<td colspan="2">
									TIPO DE EVALUACION :
									<p>Marcar con una "X" , a que tipo corresponde.</p>
								</td>
							</tr>
							<tr>
								<td>Nombres y Apellidos :</td>
								<td>Jhen Pazmiño</td>
								<td>Nombres y Apellidos :</td>
								<td>Mauricio Valdiviezo</td>
								<td>Auto- Evaluación</td>
								<td><input type="checkbox" name="btnTipEval" value="AE" /></td>
							</tr>
							<tr>
								<td>Cargo :</td>
								<td>Gerente de Sistemas</td>
								<td>Cargo :</td>
								<td>Jefe Desarrollo</td>
								<td>Evaluación Inicial</td>
								<td><input type="checkbox" name="btnTipEval" value="EI" /></td>
							</tr>
							<tr>
								<td>Area :</td>
								<td>Sistemas</td>
								<td>Area :</td>
								<td>Sistemas</td>
								<td>Evaluación Final</td>
								<td><input type="checkbox" name="btnTipEval" value="EF" /></td>
							</tr>
						</tbody>
					</table>
				</th>
			</tr>

			<!--	Competencias Organizacionales		-->
			<tr>
				<td colspan="3"><h4 align="center"><strong>Competencias Organizacionales</strong></h4></td>
			</tr>
			<tr>
				<th colspan="3">
					<p>A continuación,se presentan las Competencias Organizacionales con los comportamientos que ubican el grado de cumplimiento por parte del colaborador, por favor leeer cada uno</p>
					<p>de ellos y posterior marca con una "X" la casilla que mejor identifica la evaluación del desempeño del colaborador.</p>
				</th>
			</tr>
			<tr>
				<th colspan="3">
					<table class="table table-bordered table-hover" id="tbl_Comp_Org">
						<tbody>
							<tr>
								<td align="center" width="<?php echo $width; ?>"></td>
								<?php
								if($_SESSION['USER-AD']['user_rol'] == 13 || $_SESSION['USER-AD']['user_rol'] == 15){
									foreach ($puntaje as $key => $valor) {
										echo "<td align='center'>".$valor."</td>";
									}
								}else{
									echo '<td align="center"></td>';
								}
								
								?>
							</tr>
							<tr>
								<td align="center"></td>
								<?php
								if($_SESSION['USER-AD']['user_rol'] == 13 || $_SESSION['USER-AD']['user_rol'] == 15){
									foreach ($calificacion as $key => $valor) {
										echo "<td align='center'>".$valor."</td>";
									}
								}else{
									echo '<td align="center"></td>';
								}
								?>
							</tr>
							<tr>
								<td align="center"></td>
								<?php
								if($_SESSION['USER-AD']['user_rol'] == 13 || $_SESSION['USER-AD']['user_rol'] == 15){
									foreach ($criterios_simbolo as $key => $valor) {
										echo '<td align="center"><img id="simb_6" style="height: 25px; width: 25px;" src="'.BASEURL.'public/uploads/evaluacion_desempenio/'.$valor.'"></td>';
									}
								}else{
									echo '<td align="center"></td>';
								}
								?>
							</tr>
							<?php												
							$x = new Evaluacion_Desempenio_tema();
							$temas = $x->select_all_(1);
							
							foreach ($temas as $key => $value) {
								echo "<tr>";
									echo "<td align='left'><strong>".$x->htmlprnt($value['tema'])."</strong></td>";
									if($_SESSION['USER-AD']['user_rol'] == 13 || $_SESSION['USER-AD']['user_rol'] == 15){
										foreach ($puntaje as $key => $valor) {
											echo "<td align='center'></td>";
										}
									}else{
										echo '<td align="center"></td>';
									}
									
								echo "</tr>";

								$y = new Evaluacion_desempenio_pregunta();								
								$preguntas = $y->select_x_tema__($value['id'],$_SESSION['USER-AD']['id_empresa']);
								foreach ($preguntas as $id_p => $value_p) {
									echo "<tr class='tr_preg'>";
										echo "<td align='left' style='font-size: 11px;'>".$y->htmlprnt($value_p['pregunta'])."</td>";
										if($_SESSION['USER-AD']['user_rol'] == 13 || $_SESSION['USER-AD']['user_rol'] == 15){
											foreach ($puntaje as $key => $valor) {
												echo "<td align='center'>";
													echo '<input type="radio" name="'.$value_p['id'].'" value="'.$valor.'">';
												echo "</td>";
											}
										}else{
											echo '<td align="center">';
											echo "<input type='text' name='".$value_p['id']."' maxlength='1' tabindex='$i' style='width: 40px; text-align:center;' />";
											echo '</td>';
											$i++;
										}
										
									echo "</tr>";
								}
							}
							?>
						</tbody>
					</table>	
				</th>
			</tr>


			<!--	Competencias Administrativas		-->
			<tr>
				<td colspan="3"><h4 align="center"><strong>Competencias Administrativas</strong></h4></td>
			</tr>
			<tr>
				<th colspan="3">
					<p>A continuación,se presentan las Competencias Administrativas, para que ubican el grado de cumplimiento por parte del colaborador, leeer cada uno de ellos;</p>
					<p>y  marca con una "X" la casilla que mejor identifica la evaluación del desempeño del colaborador.</p>
				</th>
			</tr>
			<tr>
				<th colspan="3">
					<table class="table table-bordered table-hover" id="tbl_Comp_Adm">
						<tbody>
							<tr>
								<td align="center" width="<?php echo $width; ?>"></td>
								<?php
								if($_SESSION['USER-AD']['user_rol'] == 13 || $_SESSION['USER-AD']['user_rol'] == 15){
									foreach ($puntaje as $key => $valor) {
										echo "<td align='center'>".$valor."</td>";
									}
								}else{
									echo '<td align="center"></td>';
								}								
								?>
							</tr>
							<tr>
								<td align="center"></td>
								<?php
								if($_SESSION['USER-AD']['user_rol'] == 13 || $_SESSION['USER-AD']['user_rol'] == 15){
									foreach ($calificacion as $key => $valor) {
										echo "<td align='center'>".$valor."</td>";
									}
								}else{
									echo '<td align="center"></td>';
								}
								?>
							</tr>
							<tr>
								<td align="center"></td>
								<?php
								if($_SESSION['USER-AD']['user_rol'] == 13 || $_SESSION['USER-AD']['user_rol'] == 15){
									foreach ($criterios_simbolo as $key => $valor) {
										echo '<td align="center"><img id="simb_6" style="height: 25px; width: 25px;" src="'.BASEURL.'public/uploads/evaluacion_desempenio/'.$valor.'"></td>';
									}
								}else{
									echo '<td align="center"></td>';
								}
								?>
							</tr>
							<?php												
							$x = new Evaluacion_Desempenio_tema();
							$temas = $x->select_all_(2);
							foreach ($temas as $key => $value) {
								echo "<tr>";
									echo "<td align='left'><strong>".$x->htmlprnt($value['tema'])."</strong></td>";
									if($_SESSION['USER-AD']['user_rol'] == 13 || $_SESSION['USER-AD']['user_rol'] == 15){
										foreach ($puntaje as $key => $valor) {
											echo "<td align='center'></td>";
										}
									}else{
										echo '<td align="center"></td>';
									}
								echo "</tr>";

								$y = new Evaluacion_desempenio_pregunta();
								$preguntas = $y->select_x_tema__($value['id'],$_SESSION['USER-AD']['id_empresa']);
								foreach ($preguntas as $id_p => $value_p) {
									echo "<tr class='tr_preg'>";
										echo "<td align='left' style='font-size: 11px;'>".$y->htmlprnt($value_p['pregunta'])."</td>";
										if($_SESSION['USER-AD']['user_rol'] == 13 || $_SESSION['USER-AD']['user_rol'] == 15){
											foreach ($puntaje as $key => $valor) {
												echo "<td align='center'>";
													echo '<input type="radio" name="'.$value_p['id'].'" value="'.$valor.'">';
												echo "</td>";
											}
										}else{
											echo '<td align="center">';
											echo "<input type='text' name='".$value_p['id']."' maxlength='1' tabindex='$i' style='width: 40px; text-align:center;' />";
											echo '</td>';
											$i++;
										}
									echo "</tr>";
								}
							}
							?>
						</tbody>
					</table>	
				</th>
			</tr>

			<!--	Competencias Laborales		-->
			<tr>
				<td colspan="3"><h4 align="center"><strong>Competencias Laborales</strong></h4></td>
			</tr>
			<tr>
				<th colspan="3">
					<p>A continuación,se presentan las Competencias Laborales para que ubican el grado de cumplimiento por parte del colaborador, por favor leeer cada uno y posterior marca con una "X" la casilla que mejor</p>
					<p>identifica la evaluación del desempeño del colaborador.</p>
				</th>
			</tr>
			<tr>
				<th colspan="3">
					<table class="table table-bordered table-hover" id="tbl_Comp_Lab">
						<tbody>
							<tr>
								<td align="center" width="<?php echo $width; ?>" rowspan="3" style="vertical-align: middle;">Rango Alcanzado / Competencia</td>
								<?php
								if($_SESSION['USER-AD']['user_rol'] == 13 || $_SESSION['USER-AD']['user_rol'] == 15){
									foreach ($puntaje as $key => $valor) {
										echo "<td align='center'>".$valor."</td>";
									}
								}else{
									echo '<td align="center"></td>';
								}
								?>
							</tr>
							<tr>
								<?php
								if($_SESSION['USER-AD']['user_rol'] == 13 || $_SESSION['USER-AD']['user_rol'] == 15){
									foreach ($calificacion as $key => $valor) {
										echo "<td align='center'>".$valor."</td>";
									}
								}else{
									echo '<td align="center"></td>';
								}
								?>
							</tr>
							<tr>
								<?php
								if($_SESSION['USER-AD']['user_rol'] == 13 || $_SESSION['USER-AD']['user_rol'] == 15){
									foreach ($criterios_simbolo as $key => $valor) {
										echo '<td align="center"><img id="simb_6" style="height: 25px; width: 25px;" src="'.BASEURL.'public/uploads/evaluacion_desempenio/'.$valor.'"></td>';
									}
								}else{
									echo '<td align="center"></td>';
								}
								?>
							</tr>
							<?php												
							$x = new Evaluacion_Desempenio_tema();
							$temas = $x->select_all_(3);
							foreach ($temas as $key => $value) {
								echo "<tr>";
									echo "<td align='left'><strong>".$x->htmlprnt($value['tema'])."</strong></td>";
									if($_SESSION['USER-AD']['user_rol'] == 13 || $_SESSION['USER-AD']['user_rol'] == 15){
										foreach ($puntaje as $key => $valor) {
											echo "<td align='center'></td>";
										}
									}else{
										echo '<td align="center"></td>';
									}
								echo "</tr>";

								$y = new Evaluacion_desempenio_pregunta();
								$preguntas = $y->select_x_tema__($value['id'],$_SESSION['USER-AD']['id_empresa']);
								foreach ($preguntas as $id_p => $value_p) {
									echo "<tr class='tr_preg'>";
										echo "<td align='left' style='font-size: 11px;'>".$y->htmlprnt($value_p['pregunta'])."</td>";
										if($_SESSION['USER-AD']['user_rol'] == 13 || $_SESSION['USER-AD']['user_rol'] == 15){
											foreach ($puntaje as $key => $valor) {
												echo "<td align='center'>";
													echo '<input type="radio" name="'.$value_p['id'].'" value="'.$valor.'">';
												echo "</td>";
											}
										}else{
											echo '<td align="center">';
											echo "<input type='text' name='".$value_p['id']."' maxlength='1' tabindex='$i' style='width: 40px; text-align:center;' />";
											echo '</td>';
											$i++;
										}
										
									echo "</tr>";
								}
							}
							?>
						</tbody>
					</table>	
				</th>
			</tr>

			<!--	Cumplimiento de Objetivos Departamentales		-->
			<tr>
				<td colspan="3"><h4 align="center"><strong>Cumplimiento de Objetivos Departamentales</strong></h4></td>
			</tr>
			<tr>
				<th colspan="3">
					<p>A continuación,se presentan el porcentaje de cumplimiento alcanzado por parte del colaborador en el logro de los objetivos departamentales, por favor  marca con una "X" la casilla</p>
					<p>que mejor identifica la evaluación del desempeño del colaborador.</p>
				</th>
			</tr>
			<tr>
				<th colspan="3">
					<table class="table table-bordered table-hover" id="tbl_Cump_Obj_Dep">
						<tbody>
							<tr>
								<td align="center" width="<?php echo $width; ?>" rowspan="3" style="vertical-align: middle;">Rango Alcanzado</td>
								<?php
								if($_SESSION['USER-AD']['user_rol'] == 13 || $_SESSION['USER-AD']['user_rol'] == 15){
									foreach ($calificacion as $key => $valor) {
										echo "<td align='center'>".$valor."</td>";
									}
								}else{
									echo '<td align="center"></td>';
								}
								?>
							</tr>
							<tr>
								<?php
								if($_SESSION['USER-AD']['user_rol'] == 13 || $_SESSION['USER-AD']['user_rol'] == 15){
									foreach ($rango as $key => $valor) {
										echo "<td align='center'>".$valor['hasta']." al ".$valor['desde']."</td>";
									}
								}else{
									echo '<td align="center"></td>';
								}
								?>
							</tr>
							<tr>
								<?php
								if($_SESSION['USER-AD']['user_rol'] == 13 || $_SESSION['USER-AD']['user_rol'] == 15){
									foreach ($criterios_simbolo as $key => $valor) {
										echo '<td align="center"><img id="simb_6" style="height: 25px; width: 25px;" src="'.BASEURL.'public/uploads/evaluacion_desempenio/'.$valor.'"></td>';
									}
								}else{
									echo '<td align="center"></td>';
								}
								?>
							</tr>
						</tbody>
					</table>
				</th>
			</tr>

			<!--	Cumplimiento de Objetivos Individuales		-->
			<tr>
				<td colspan="3"><h4 align="center"><strong>Cumplimiento de Objetivos Individuales</strong></h4></td>
			</tr>
			<tr>
				<th colspan="3">
					<p>A continuación,se presentan el porcentaje de cumplimiento alcanzado por parte del colaborador en el logro de los objetivos individuales, por favor  marca con una "X" la casilla</p>
					<p>que mejor identifica la evaluación del desempeño del colaborador.</p>
				</th>
			</tr>
			<tr>
				<th colspan="3">
					<table class="table table-bordered table-hover" id="tbl_Cump_Obj_Ind">
						<tbody>
							<tr>
								<td align="center" width="<?php echo $width; ?>" rowspan="3" style="vertical-align: middle;">Rango Alcanzado</td>
								<?php
								if($_SESSION['USER-AD']['user_rol'] == 13 || $_SESSION['USER-AD']['user_rol'] == 15){
									foreach ($calificacion as $key => $valor) {
										echo "<td align='center'>".$valor."</td>";
									}
								}else{
									echo '<td align="center"></td>';
								}
								?>
							</tr>
							<tr>
								<?php
								if($_SESSION['USER-AD']['user_rol'] == 13 || $_SESSION['USER-AD']['user_rol'] == 15){
									foreach ($rango as $key => $valor) {
										echo "<td align='center'>".$valor['hasta']." al ".$valor['desde']."</td>";
									}
								}else{
									echo '<td align="center"></td>';
								}
								?>
							</tr>
							<tr>
								<?php
								if($_SESSION['USER-AD']['user_rol'] == 13 || $_SESSION['USER-AD']['user_rol'] == 15){
									foreach ($criterios_simbolo as $key => $valor) {
										echo '<td align="center"><img id="simb_6" style="height: 25px; width: 25px;" src="'.BASEURL.'public/uploads/evaluacion_desempenio/'.$valor.'"></td>';
									}
								}else{
									echo '<td align="center"></td>';
								}
								?>
							</tr>
						</tbody>
					</table>
				</th>
			</tr>

			<!--	Conclusiones Generales de la Evaluación de Desempeño		-->
			<tr>
				<td colspan="3"><h4 align="center"><strong>Conclusiones Generales de la Evaluaci&oacute;n de Desempe&ntilde;o</strong></h4></td>
			</tr>
			<tr>
				<th colspan="3">
					<table class="table table-bordered table-hover">
						<tbody>
							<tr>
								<td align="center"><strong>Fortalezas del Evaluado:</strong></td>
								<td align="center"><strong>Oportunidades de Mejora del Evaluado:</strong></td>
								<td align="center"><strong>Compromisos Adquiridos:</strong></td>
							</tr>
							<tr>
								<td><textarea class="form-control" name="comentario[FO]" ></textarea></td>
								<td><textarea class="form-control" name="comentario[OP]" ></textarea></td>
								<td><textarea class="form-control" name="comentario[CO]" ></textarea></td>
							</tr>
							<tr>
								<td align="center"><strong>Comentarios del Evaluado:</strong></td>
								<td align="center"><strong>Comentarios del Evaluador:</strong></td>
								<td align="center" colspan="2"><strong>Firmas</strong></td>
							</tr>
							<tr>
								<td rowspan="3"><textarea class="form-control" name="comentario[C_EVALUADO]" ></textarea></td>
								<td rowspan="3"><textarea class="form-control" name="comentario[C_EVALUADOR]" ></textarea></td>
								<td>
									<table class="table table-bordered table-hover">
										<tbody>
											<tr>
												<td>Nombre Evaluado</td>
												<td>Nombre Evaluador</td>
											</tr>
											<tr>
												<td colspan="2" align="center"><strong>Fecha de Evaluación</strong></td>
											</tr>
											<tr align="center">
												<td colspan="2"><input class="text-center" type="text" name="comentario[FEC]" value="<?php echo date('d/m/Y'); ?>" disabled /></td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
				</th>
			</tr>
		</tbody>
	</table>
	
	<input type="hidden" id="id_test" name="id_test" value="<?php echo $id_t ?>">
	<input type="hidden" id="hay_caracter" name="hay_caracter" value="<?php echo $hay_caracter ?>">
	<input type="hidden" id="max_escala" name="max_escala" value="<?php echo $max_escala ?>">
	<input type="hidden" id="min_escala" name="min_escala" value="<?php echo $min_escala ?>">
	<input type="hidden" id="escala_valor" name="escala_valor" value="<?php echo $escala_valor ?>">
	<input type="submit" class="btn btn-default btn-block btn-lg" value="GUARDAR">
</form>

<script type="text/javascript">
	$('input.speed').on('keyup', function(){
		if (isNumeric(this.value) && this.value<=5) {
			var $this = $(this);
			console.log($this);
			console.log($(':input:eq(' + ($(':input').index(this) + 1) + ')'));
			$(':input:eq(' + ($(':input').index(this) + 1) + ')').focus();
		}
	})
	function isNumeric(n) {
		return !isNaN(parseFloat(n)) && isFinite(n);
	}	
</script>