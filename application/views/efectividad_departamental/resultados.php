﻿<style type="text/css">
	select {height: 120px !important}
	#area_seg{height: 400px !important}
	#tblPorcentajes div{
		border: 2px solid #CCC;
		border-radius: 3px;
		margin: 3px;
		height: 15px;
	}
	@media screen and (min-width: 768px) {
		#myModal .modal-dialog {
			width: 1200px;
		}
	}
</style>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#a_efectividad, #a_res_efect').addClass('active-parent active');
		$('#li_his_efect').addClass('activate');

		$("#tblPorcentajes tr td > div").each(function() {
		    $(this).animate({
				width: $(this).data("width")+"%"
			}, 100);
		});
	});

	function graficoBarras(graf_temas, graf_valores){
		var categories = [];
		var seriesArr = [];
		
		$.each(graf_valores, function( index, value ){
			var new_array = [];
			
			for(var xx in graf_valores[index].arrValores){
				new_array.push(parseFloat(graf_valores[index].arrValores[xx]));
			}

			var obj = {'name' : graf_valores[index].fecha, 'data' : new_array};
			
			seriesArr.push(obj);
		});
		
		$.each(graf_temas, function(index, value) {
		    categories.push(value);
		});
		//
		var options = new Highcharts.chart({
	        exporting: {
	            buttons: {
	                contextButton: {
	                    	menuItems: [{
	                            textKey: 'downloadPNG',
	                            onclick: function () {
	                                this.exportChart();
	                            }
	                        }, {
	                            textKey: 'downloadJPEG',
	                            onclick: function () {
	                                this.exportChart({
	                                    type: 'image/jpeg'
	                                });
	                            }
	                        }, {
	                            textKey: 'downloadPDF',
	                            onclick: function () {
	                                this.print()
	                            }
	                        }]
	                }
	            }
	        },
	        chart: {
	        	renderTo: 'mdl_body',
	            type: 'column',
	            width: 1150
	        },
	        title: {
	            text: '<b>Resultados de Encuestas</b>',
	            x: -20 //center
	        },
	        xAxis: {
	            categories:  categories,
            	crosshair: true
	        },
	        yAxis: {
	        	min: 0,
	            max: 5,
	            tickInterval: 0.5,
	            title: {
	                text: 'ESCALAS'
	            }
	        },
	        tooltip: {
	        	headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
	            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
	                '<td style="padding:0"><b>{point.y:.2f} %</b></td></tr>',
	            footerFormat: '</table>',
	            shared: true,
	            useHTML: true
	        },
	        plotOptions: {
	            column: {
	                pointPadding: 0.2,
	                borderWidth: 0
	            }
	        },
	        series: seriesArr
	    });
		
		$('#myModal').modal('show');
	}
</script>
<?php
$sonda = new Efectividad_departamental();
$sonda->select_($_SESSION['Empresa']['id'], $id_s);
$seg = $sonda->getSegmentacion();
$nuevos_criterios = $sonda->getNuevosCriterios();
$criterios_escala = $sonda->getCriteriosEscala();
$criterios_barras_colores = $sonda->getCriteriosBarrasColores();
$criterios_rango_barras = $sonda->getCriteriosRangoBarras();

//print_r($criterios_escala);
//print_r($criterios_barras_colores);
//print_r($criterios_rango_barras);

$x = new Sonda_tema();
$y = new Sonda_pregunta();
$w = new Sonda_respuesta();
$z = new Sonda_user();

$util = new Util();
$promedio_general = $arrPromedios['ICO'] = array();

$ids = $z->get_id_x_sonda($args, $_SESSION['Empresa']['id'], $id_s);
$c_e=$z->get_evaluados($args,$id_s);

echo '<h4>DIAGNÓSTICO DE EFECTIVIDAD ORGANIZACIONAL.- RESULTADOS DE ENCUESTAS</h4>';

?>
<form  action="<?php echo BASEURL.'efectividad_departamental/resultados/'.$id_s ?>" method="POST">
	<h4><a class="btn btn-default" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Filtrar criterios</a></h4>
	<div class="collapse" id="collapseExample">
		<div class="well">
			<?php if (in_array("edad", $seg)): ?>
				<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
					<div class="panel-heading">Edad</div>
					<div class="panel-body">
						<select multiple name="edad[]" class="form-control">
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
						<select multiple name="antiguedad[]" class="form-control">
							<option style="display:none">Seleccione una opción</option>
							<option value="7">De 0 a 3 meses</option>
							<option value="1">De 3 meses a 2 años</option>
							<option value="2">De 2 a 5 años</option>
							<option value="3">De 5 a 10 años</option>
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
						<select multiple name="localidad[]" class="form-control">
							<option style="display:none">Seleccione una opción</option>
							<?php
							$test = new Empresa_local();
							$test->get_select_options_($_SESSION['Empresa']['id']);
							?>
						</select>
					</div>
				</div>
			<?php endif ?>
			<?php if (in_array("norg", $seg)): ?>
				<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
					<div class="panel-heading">Niveles Organizacionales</div>
					<div class="panel-body">
						<select multiple name="norg[]" class="form-control">
							<option style="display:none">Seleccione una opción</option>
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
						<select multiple name="tcont[]" class="form-control">
							<option style="display:none">Seleccione una opción</option>
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
						<select multiple name="educacion[]" class="form-control">
							<option style="display:none">Seleccione una opción</option>
							<option value="0">Primaria incompleta</option>
							<option value="1">Primaria completa</option>
							<option value="2">Secundaria incompleta </option>
							<option value="3">Secundaria completa </option>
							<option value="4">Universitaria incompleta</option>
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
						<select multiple name="sexo[]" class="form-control">
							<option style="display:none">Seleccione una opción</option>
							<option value="0">Masculino</option>
							<option value="1">Femenino</option>
						</select>
					</div>
				</div>
			<?php endif ?>
			<?php if (in_array("departamento", $seg)): ?>
				<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
					<div class="panel-heading">Departamento</div>
					<div class="panel-body">
						<select multiple id="area_seg" name="departamento[]" class="form-control">
							<option style="display:none">Seleccione una opción</option>
							<?php
							$test = new Empresa_area();
							$test->get_select_options($_SESSION['Empresa']['id']);
							?>
						</select>
					</div>
				</div>
			<?php endif ?>
			<div class="clearfix"></div>
		</div>
	</div>
	<h4><a class="btn btn-default" data-toggle="collapse" href="#collapseTemas" aria-expanded="false" aria-controls="collapseTemas">Filtrar temas</a></h4>
	<div class="collapse" id="collapseTemas" style="width: 400px;">
		<div class="well">
			<select multiple name="temas[]" class="form-control">
				<option style="display:none">Seleccione una opción</option>
				<?php
				$x->get_Temas($id_s,$nuevos_criterios,$arrTemas);
				?>
			</select>
		</div>
	</div>
	<div class="clearfix"></div>
	<div class="text-center"><input type="submit" value="Filtrar" name="filtro" class="btn btn-sm btn-default"> </div>
	<div class="clearfix"></div>
</form>
<?php if($c_e){ ?>
<p><br></p>
<h4>Evaluados en proceso: <?php echo $c_e ?></h4>
<?php $util->_x('resultados','segmentacion'); ?>
<p><?php echo $filtros ?></p>
<div class="col-md-12">
	<table class="table table-bordered table-hover" style="margin-top:50px">
		<tr><th colspan="3"><h4><?php $util->_x('resultados','titulo2') ?></h4></th></tr>
		<?php 
		$temas = $sonda->getTemas();
		$xls_prep;
		$preguntas = $preguntas_general = '';
		$graf_barras_valores = $graf_barras_temas = array();

		if (is_array($temas)) {
			foreach ($temas as $key => $value) {
				if (isset($arrTemas) && is_array($arrTemas)) {
					if (in_array($key, $arrTemas)) {
						$x->select($key);
						$tema_nombre = $xls_prep[$key]['tema'] = ucfirst($x->getTema());
						$tema_id = $x->getId();
						$graf_barras_temas[] = $tema_nombre;
						
						$preguntas = implode(",", $temas[$key]);
						$preguntas_general .= implode(",", $temas[$key]).',';

						$promedio = $xls_prep[$key]['promedio'] = $w->get_avg_x_tema($ids,$preguntas,$nuevos_criterios);
						
						if ($nuevos_criterios == 0) {
							$porcentajes = $xls_prep[$key]['porcentajes'] = $w->get_percent($ids,$preguntas);
						}
						else{
							$porcentajes = $xls_prep[$key]['porcentajes'] = $w->get_percent_criterios($sonda, $ids,$preguntas);
						}
						
						array_push($promedio_general, $promedio);
						$arrPromedios['ICO'][] = ($promedio != 0) ? number_format($promedio, 2) : $promedio;
						//
						echo "<tr>";
							echo "<td class='col-md-7'><h4><strong><a href='".BASEURL."efectividad_departamental/resultados_pregunta/".$id_s."/".$tema_id."'>".$tema_nombre."</a></strong></h4>";
							echo "<h5>".$x->getDescripcion()."</h5></td>";
							echo "<td class='text-center' style='background-color: ".$w->get_color($promedio)."'><h4>";
							printf("%.2f", $promedio);
							echo "</h4></td>";
							echo '<td class="col-md-6">';
								echo '<table id="tblPorcentajes" border="0" width="100%">';
									if ($nuevos_criterios == 0) {
										echo '<tr>';
											echo '<td width="90%">';
												echo '<div style="background-color: red;" data-width="'.$porcentajes[0].'">';
											echo '</td>';
											echo '<td width="10%" style="text-align: right;"><h5>'.$porcentajes[0].'% </h5></td>';
										echo '</tr>';
										echo '<tr>';
											echo '<td width="90%">';
												echo '<div style="background-color: yellow;" data-width="'.$porcentajes[1].'">';
											echo '</td>';
											echo '<td width="10%" style="text-align: right;"><h5>'.$porcentajes[1].'% </h5></td>';
										echo '</tr>';
										echo '<tr>';
											echo '<td width="90%">';
												echo '<div style="background-color: limegreen;" data-width="'.$porcentajes[2].'">';
											echo '</td>';
											echo '<td width="10%" style="text-align: right;"><h5>'.$porcentajes[2].'% </h5></td>';
										echo '</tr>';
										echo '<tr>';
											echo '<td width="90%">';
												echo '<div style="background-color: silver;" data-width="'.$porcentajes[3].'">';
											echo '</td>';
											echo '<td width="10%" style="text-align: right;"><h5>'.$porcentajes[3].'% </h5></td>';
										echo '</tr>';
									}
									else{
										if (is_array($criterios_barras_colores)) {
											foreach ($criterios_barras_colores as $clave => $color) {
												if ($clave > 0) {
													echo '<tr>';
														echo '<td width="90%">';
															echo '<div style="background-color: '.$color.';" data-width="'.$porcentajes[$clave].'">';
														echo '</td>';
														echo '<td width="10%" style="text-align: right;"><h5>'.$porcentajes[$clave].'% </h5></td>';
													echo '</tr>';
												}
											}

											echo '<tr>';
												echo '<td width="90%">';
													echo '<div style="background-color: '.$criterios_barras_colores[0].';" data-width="'.$porcentajes[0].'">';
												echo '</td>';
												echo '<td width="10%" style="text-align: right;"><h5>'.$porcentajes[0].'% </h5></td>';
											echo '</tr>';
										}
									}
								echo '</table>';
							echo '</td>';
						echo "</tr>";
					}
				}else{
					$x->select($key);
					$tema_nombre = $xls_prep[$key]['tema'] = ucfirst($x->getTema());
					$tema_id = $x->getId();
					$graf_barras_temas[] = $tema_nombre;
					
					$preguntas = implode(",", $temas[$key]);
					$preguntas_general .= implode(",", $temas[$key]).',';
					$promedio = $xls_prep[$key]['promedio'] = $w->get_avg_x_tema($ids,$preguntas,$nuevos_criterios);

					if ($nuevos_criterios == 0) {
						$porcentajes = $xls_prep[$key]['porcentajes'] = $w->get_percent($ids,$preguntas);
					}
					else{
						$porcentajes = $xls_prep[$key]['porcentajes'] = $w->get_percent_criterios($sonda, $ids,$preguntas);
					}
					
					

					array_push($promedio_general, $promedio);
					$arrPromedios['ICO'][] = ($promedio != 0) ? number_format($promedio, 2) : $promedio;
					//
					if ($nuevos_criterios == 0) {
						echo "<tr>";
							echo "<td class='col-md-7'><h4><strong><a href='".BASEURL."efectividad_departamental/resultados_pregunta/".$id_s."/".$tema_id."'>".$tema_nombre."</a></strong></h4>";
							echo "<h5>".$x->getDescripcion()."</h5></td>";
							echo "<td class='text-center' style='background-color: ".$w->get_color($promedio)."'><h4>";
							printf("%.2f", $promedio);
							echo "</h4></td>";
							echo '<td class="col-md-6">';
								echo '<table id="tblPorcentajes" border="0" width="100%">';
									echo '<tr>';
										echo '<td width="90%">';
											echo '<div style="background-color: red;" data-width="'.$porcentajes[0].'">';
										echo '</td>';
										echo '<td width="10%" style="text-align: right;"><h5>'.$porcentajes[0].'% </h5></td>';
									echo '</tr>';
									echo '<tr>';
										echo '<td width="90%">';
											echo '<div style="background-color: yellow;" data-width="'.$porcentajes[1].'">';
										echo '</td>';
										echo '<td width="10%" style="text-align: right;"><h5>'.$porcentajes[1].'% </h5></td>';
									echo '</tr>';
									echo '<tr>';
										echo '<td width="90%">';
											echo '<div style="background-color: limegreen;" data-width="'.$porcentajes[2].'">';
										echo '</td>';
										echo '<td width="10%" style="text-align: right;"><h5>'.$porcentajes[2].'% </h5></td>';
									echo '</tr>';
									echo '<tr>';
										echo '<td width="90%">';
											echo '<div style="background-color: silver;" data-width="'.$porcentajes[3].'">';
										echo '</td>';
										echo '<td width="10%" style="text-align: right;"><h5>'.$porcentajes[3].'% </h5></td>';
									echo '</tr>';
								echo '</table>';
							echo '</td>';
						echo "</tr>";
					}
					else{
						echo "<tr>";
							echo "<td class='col-md-7'><h4><strong><a href='".BASEURL."efectividad_departamental/resultados_pregunta/".$id_s."/".$tema_id."'>".$tema_nombre."</a></strong></h4>";
							echo "<h5>".$x->getDescripcion()."</h5></td>";
							echo "<td class='text-center' style='background-color: ".$w->get_color($promedio)."'><h4>";
							printf("%.2f", $promedio);
							echo "</h4></td>";
							echo '<td class="col-md-6">';
								echo '<table id="tblPorcentajes" border="0" width="100%">';
									if (is_array($criterios_barras_colores)) {
										foreach ($criterios_barras_colores as $key => $color) {
											if ($key > 0) {
												echo '<tr>';
													echo '<td width="90%">';
														echo '<div style="background-color: '.$color.';" data-width="'.$porcentajes[$key].'">';
													echo '</td>';
													echo '<td width="10%" style="text-align: right;"><h5>'.$porcentajes[$key].'% </h5></td>';
												echo '</tr>';
											}
										}

										echo '<tr>';
											echo '<td width="90%">';
												echo '<div style="background-color: '.$criterios_barras_colores[0].';" data-width="'.$porcentajes[0].'">';
											echo '</td>';
											echo '<td width="10%" style="text-align: right;"><h5>'.$porcentajes[0].'% </h5></td>';
										echo '</tr>';
									}
								echo '</table>';
							echo '</td>';
						echo "</tr>";
					}
				}
			}
		}
		?>
		<tr>
			<th><h4>Promedio General</h4></th>
			<?php 
				$preguntas_general = substr($preguntas_general, 0, -1);
				$p_gen = @(array_sum($promedio_general)/sizeof($promedio_general)); 

				if ($nuevos_criterios == 0) {
					$porcentajes_generales = $w->get_percent($ids,$preguntas_general);
				}
				else{
					$porcentajes_generales = $w->get_percent_criterios($sonda, $ids,$preguntas_general);
				}
				
				array_push($arrPromedios['ICO'], round($p_gen,2));
			?>
			<td class='text-center' style='background-color: <?php echo $w->get_color($p_gen) ?>'>
				<?php 
				echo "<h4>";
				printf("%.2f", $p_gen);
				echo "</h4>"; 
				?>
			</td>
			<td>
				<?php
				if ($nuevos_criterios == 0) {
				?>
				<table id="tblPorcentajes" border="0" width="100%">
					<tr>
						<td width="90%">
							<div style="background-color: red;" data-width="<?php echo $porcentajes_generales[0] ?>">
						</td>
						<td width="10%" style="text-align: right;"><h5><?php echo $porcentajes_generales[0] ?>% </h5></td>
					</tr>
					<tr>
						<td width="90%">
							<div style="background-color: yellow;" data-width="<?php echo $porcentajes_generales[1] ?>">
						</td>
						<td width="10%" style="text-align: right;"><h5><?php echo $porcentajes_generales[1] ?>% </h5></td>
					</tr>
					<tr>
						<td width="90%">
							<div style="background-color: limegreen;" data-width="<?php echo $porcentajes_generales[2] ?>">
						</td>
						<td width="10%" style="text-align: right;"><h5><?php echo $porcentajes_generales[2] ?>% </h5></td>
					</tr>
					<tr>
						<td width="90%">
							<div style="background-color: silver;" data-width="<?php echo $porcentajes_generales[3] ?>">
						</td>
						<td width="10%" style="text-align: right;"><h5><?php echo $porcentajes_generales[3] ?>% </h5></td>
					</tr>
				</table>
				<?php
				}
				else{
					echo '<table id="tblPorcentajes" border="0" width="100%">';
						if (is_array($criterios_barras_colores)) {
							foreach ($criterios_barras_colores as $key => $color) {
								if ($key > 0) {
									echo '<tr>';
										echo '<td width="90%">';
											echo '<div style="background-color: '.$color.';" data-width="'.$porcentajes_generales[$key].'">';
										echo '</td>';
										echo '<td width="10%" style="text-align: right;"><h5>'.$porcentajes_generales[$key].'% </h5></td>';
									echo '</tr>';
								}
							}

							echo '<tr>';
								echo '<td width="90%">';
									echo '<div style="background-color: '.$criterios_barras_colores[0].';" data-width="'.$porcentajes_generales[0].'">';
								echo '</td>';
								echo '<td width="10%" style="text-align: right;"><h5>'.$porcentajes_generales[0].'% </h5></td>';
							echo '</tr>';
						}
					echo '</table>';
				}
				?>
			</td>
			<?php 
				//$filtros = ($filtros=="Todos") ? "" : $filtros;
				$filtros = str_replace(" ", "+", $filtros); 
				$filtros = str_replace("/", "*", $filtros);

				array_push($graf_barras_temas, 'Promedio General');
				//Armar json general
				$arrTot['fecha'] = null;
				$arrTot['arrValores'] = null;
				if (is_array($arrPromedios)) {
					foreach ($arrPromedios as $ico => $arrValores) {
						$arrTot['fecha'] = $ico;
						$arrTot['arrValores'] = $arrValores;
						array_push($graf_barras_valores, $arrTot);
					}
				}
			?>
		</tr>
		<?php
		$array_para_enviar_via_url = serialize($arrTemas);
		$array_para_enviar_via_url = urlencode($array_para_enviar_via_url);
		?>
		<tr>
			<td><h4><b>Grafico Comparativo General</b><img src='<?php echo BASEURL; ?>public/img/line-graph.png' width='40' height='40' style='cursor:pointer;margin-left: 20px;' onclick='graficoBarras(<?php echo json_encode($graf_barras_temas).','.json_encode($graf_barras_valores); ?>);' /></h4></td>
			<td>&nbsp;</td>
			<td class="text-center">
				<div class="btn-group">
					<a target="_blank" href="<?php echo BASEURL ?>efectividad_departamental/top/<?php echo $id_s; ?>/DESC" class="btn btn-default">Mejor puntaje</a>
					<a target="_blank" href="<?php echo BASEURL ?>efectividad_departamental/top/<?php echo $id_s; ?>/ASC" class="btn btn-default">Peor puntaje</a>
					<a target="_blank" href="<?php echo BASEURL ?>efectividad_departamental/comentarios/<?php echo $id_s; ?>" class="btn btn-default">Comentarios Foda</a>
					<a href="<?php echo BASEURL ?>pdf/efectividad_departamental/<?php echo $id_s."/".$filtros."/".$array_para_enviar_via_url ?>" class="btn btn-default">Generar reporte</a>
					<a href="<?php echo BASEURL ?>pdf/sonda_xls/<?php echo $id_s."/".$array_para_enviar_via_url ?>" class="btn btn-default">Descargar en excel</a>
				</div>
			</td>
		</tr>
	</table>
</div>
<!--	IMAGENENES -->
<div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">&nbsp;</h4>
      </div>
      <div class="modal-body" id="mdl_body"></div>
    </div>
  </div>
</div>
<?php }else { ?>
<div class="alert alert-info" role="alert"><h4>Datos Insuficientes</h4></div>
<?php } ?> 