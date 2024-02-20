<style type="text/css">
	select {height: 120px !important}
	#area_seg{height: 400px !important}
	.f_fechas{width: 150px;}
	#mdl_body{
		min-width: 900px; 
		height: 400px; 
		margin: 0 auto;
	}
	table.consulta thead .expande {
	    background-image: url(../public/img/asc.gif);
	    background-repeat: no-repeat;
	    background-position: top right;
	    cursor: pointer;
	}
	table.consulta thead .contrae {
	    background-image: url(../public/img/desc.gif);
	    background-repeat: no-repeat;
	    background-position: top right;
	    cursor: pointer;
	}
	#tblPorcentajes div{
		border: 2px solid #CCC;
		border-radius: 3px;
		margin: 3px;
		height: 15px;
	}
	@media (min-width: 992px) {
		.container-fluid.my-own-class {
			overflow-x: scroll;
			white-space: nowrap;
		}
		.container-fluid.my-own-class .col-md-12 {
			display: inline-block;
			vertical-align: top;
			float: none;
		}
	}
	@media screen and (min-width: 768px) {
		#myModal .modal-dialog {
			width: 1200px;
		}
	}
</style>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="<?php echo BASEURL ?>public/js/jquery.columnmanager.js" type="text/javascript" ></script>
<script type="text/javascript">
	$(document).ready(function(){
		
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
	            text: '<b>Comparar Preguntas</b>',
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
$rendimiento = new Rendimiento();
$sonda = new Sonda();
$x = new Sonda_tema();
$y = new Sonda_pregunta();
$z = new Sonda_user();
$w = new Sonda_respuesta();
$util = new Util();

echo '<h4>DIAGNÓSTICO DE CLIMA ORGANIZACIONAL.- GRUPOS CRITICOS</h4>';
echo "<br>";
?>
<form action="<?php echo BASEURL.'sonda/grupos_criticos' ?>" method="POST">
	<h4><a class="btn btn-default" data-toggle="collapse" href="#collapseEncuentas" aria-expanded="false" aria-controls="collapseEncuentas">Mostrar Encuestas</a></h4>
	<div class="collapse" id="collapseEncuentas" style="width: 230px;">
		<div class="well">
			<select multiple name="sondas[]" class="form-control cmbSondas" style="height: 26px">
				<?php
				$sonda->get_Sondas_Empresa($_SESSION['Empresa']['id'], 'S', $arrSondas);
				?>
			</select>
		</div>
	</div>
	<!-- ///////////////////////////////////// -->
	<div class="clearfix"></div>
	<div class="text-center"><input type="submit" value="Filtrar" name="filtro" class="btn btn-sm btn-default"> </div>
	<div class="clearfix"></div>
</form>
<br><br>
<?php 
if (is_array($arrSondas)) {
	$rendimiento->select($_SESSION['Empresa']['id']);
	$ids = $z->get_id_x_empresa($rendimiento->getId(),$_SESSION['Empresa']['id'],'');
	$temas = $rendimiento->getTemas();
	$last_id = $rendimiento->getId();

	$preguntas = '';
	$pagina = "promedios_bajos";
	$th = 3;

	foreach ($temas as $key => $value) {
		$preguntas = implode(",", $temas[$key]);
		$rendimiento->calculo_prom_bajos($ids,$key,$preguntas);
	}

	$rendimiento->promedios_bajos($_SESSION['Empresa']['id']);
	//
	if (is_array($rendimiento->arrDatos)) {
		$i = 1;
		foreach ($rendimiento->arrDatos as $key => $arrValores) {
			$unserialize = unserialize($key);
			$collapseExample = 'collapseExample'.$i;
			foreach ($unserialize as $tipo => $valor) {
				if ($tipo != 'c_e') {
					$filtro["tipo"] = $tipo;
					$filtro["valor"] = $valor;
					$rendimiento->filtros_criterios($filtro);
					$rendimiento->get_criterios();
				}else{
					$c_e = $unserialize['c_e'];
				}
			}
			$rendimiento->resetVariables();
			$args = $rendimiento->getArgs();
			$graf_barras_valores = $graf_barras_temas = $arrPromedios = array();
?>
<a class="btn btn-default" data-toggle="collapse" href="#<?php echo$collapseExample; ?>" aria-expanded="false" aria-controls="<?php echo$collapseExample; ?>">Mostrar filtros</a>
<h4>Evaluados en proceso: <?php echo $c_e ?></h4>
<?php $util->_x('resultados','segmentacion'); ?>
<p><?php echo $rendimiento->criterios; ?></p>
<div class="collapse" id="<?php echo$collapseExample; ?>">
	<div class="well">
		<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
			<div class="panel-heading">Edad</div>
			<div class="panel-body">
				<select multiple name="edad[]" class="form-control" disabled="disabled">
					<option style="display:none">Seleccione una opción</option>
					<option value="0" <?php if (in_array(0, $rendimiento->getEdad())): echo "selected='selected'"; endif ?>>Menor a 20 años</option>
					<option value="1" <?php if (in_array(1, $rendimiento->getEdad())): echo "selected='selected'"; endif ?>>De 21 a 25 años</option>
					<option value="2" <?php if (in_array(2, $rendimiento->getEdad())): echo "selected='selected'"; endif ?>>De 26 a 30 años</option>
					<option value="3" <?php if (in_array(3, $rendimiento->getEdad())): echo "selected='selected'"; endif ?>>De 31 a 40 años</option>
					<option value="4" <?php if (in_array(4, $rendimiento->getEdad())): echo "selected='selected'"; endif ?>>De 41 a 50 años</option>
					<option value="5" <?php if (in_array(5, $rendimiento->getEdad())): echo "selected='selected'"; endif ?>>Mas de 50 años</option>
				</select>
			</div>
		</div>
		<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
			<div class="panel-heading">Antigüedad</div>
			<div class="panel-body">
				<select multiple name="antiguedad[]" class="form-control" disabled="disabled">
					<option style="display:none">Seleccione una opción</option>
					<option value="7" <?php if (in_array(7, $rendimiento->getAntiguedad())): echo "selected='selected'"; endif ?>>De 0 a 3 meses</option>
					<option value="1" <?php if (in_array(1, $rendimiento->getAntiguedad())): echo "selected='selected'"; endif ?>>De 3 meses a 2 años</option>
					<option value="2" <?php if (in_array(2, $rendimiento->getAntiguedad())): echo "selected='selected'"; endif ?>>De 2 a 5 años</option>
					<option value="3" <?php if (in_array(3, $rendimiento->getAntiguedad())): echo "selected='selected'"; endif ?>>De 5 a 10 años</option>
					<option value="4" <?php if (in_array(4, $rendimiento->getAntiguedad())): echo "selected='selected'"; endif ?>>De 10 a 15 años</option>
					<option value="5" <?php if (in_array(5, $rendimiento->getAntiguedad())): echo "selected='selected'"; endif ?>>De 15 a 20 años</option>
					<option value="6" <?php if (in_array(6, $rendimiento->getAntiguedad())): echo "selected='selected'"; endif ?>>Más 20 años</option>
				</select>
			</div>
		</div>
		<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
			<div class="panel-heading">Localidades</div>
			<div class="panel-body">
				<select multiple name="localidad[]" class="form-control" disabled="disabled">
					<option style="display:none">Seleccione una opción</option>
					<?php
					$test = new Empresa_local();
					$test->get_select_options_selected_($_SESSION['Empresa']['id'],$rendimiento->getLocalidad());
					?>
				</select>
			</div>
		</div>
		<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
			<div class="panel-heading">Niveles Organizacionales</div>
			<div class="panel-body">
				<select multiple name="norg[]" class="form-control" disabled="disabled">
					<option style="display:none">Seleccione una opción</option>
					<?php
					$test = new Empresa_norg();
					$test->get_select_options_selected($_SESSION['Empresa']['id'],$rendimiento->getNorg());
					?>
				</select>
			</div>
		</div>
		<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
			<div class="panel-heading">Tipo de contrato</div>
			<div class="panel-body">
				<select multiple name="tcont[]" class="form-control" disabled="disabled">
					<option style="display:none">Seleccione una opción</option>
					<?php
					$test = new Empresa_tcont();
					$test->get_select_options_selected($_SESSION['Empresa']['id'],$rendimiento->getTcont());
					?>
				</select>
			</div>
		</div>
		<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
			<div class="panel-heading">Educación</div>
			<div class="panel-body">
				<select multiple name="educacion[]" class="form-control" disabled="disabled">
					<option style="display:none">Seleccione una opción</option>
					<option value="0" <?php if (in_array(0, $rendimiento->getEducacion())): echo "selected='selected'"; endif ?>>Primaria incompleta</option>
					<option value="1" <?php if (in_array(1, $rendimiento->getEducacion())): echo "selected='selected'"; endif ?>>Primaria completa</option>
					<option value="2" <?php if (in_array(2, $rendimiento->getEducacion())): echo "selected='selected'"; endif ?>>Secundaria incompleta </option>
					<option value="3" <?php if (in_array(3, $rendimiento->getEducacion())): echo "selected='selected'"; endif ?>>Secundaria completa </option>
					<option value="4" <?php if (in_array(4, $rendimiento->getEducacion())): echo "selected='selected'"; endif ?>>Universitaria incompleta</option>
					<option value="5" <?php if (in_array(5, $rendimiento->getEducacion())): echo "selected='selected'"; endif ?>>Universitaria completa</option>
					<option value="6" <?php if (in_array(6, $rendimiento->getEducacion())): echo "selected='selected'"; endif ?>>Postgrado</option>
				</select>
			</div>
		</div>
		<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
			<div class="panel-heading">Sexo</div>
			<div class="panel-body">
				<select multiple name="sexo[]" class="form-control" disabled="disabled">
					<option style="display:none">Seleccione una opción</option>
					<option value="0" <?php if (in_array(0, $rendimiento->getSexo())): echo "selected='selected'"; endif ?>>Masculino</option>
					<option value="1" <?php if (in_array(1, $rendimiento->getSexo())): echo "selected='selected'"; endif ?>>Femenino</option>
				</select>
			</div>
		</div>
		<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
			<div class="panel-heading">Departamento</div>
			<div class="panel-body">
				<select multiple id="area_seg" name="departamento[]" class="form-control" disabled="disabled">
					<option style="display:none">Seleccione una opción</option>
					<?php
					$test = new Empresa_area();
					$test->get_select_options_selected($_SESSION['Empresa']['id'],$rendimiento->getDepartamento());
					?>
				</select>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="clearfix"></div>
	</div>
</div>
<!-- /////////////////// -->
<div class="container-fluid my-own-class">
<table id="tableall" class="table table-bordered" style="margin-top:50px">
	<thead>
		<tr>
			<th width="600px"><h4><?php $util->_x('resultados','titulo2'); ?></h4></th>
			<?php
			foreach ($arrSondas as $key => $id_sonda) {
				$id_th = 'th_'.$id_sonda;
				$fecha_sonda = $sonda->get_fecha_x_id($_SESSION['Empresa']['id'], $id_sonda);
				$arrFechas[$id_sonda] = $fecha_sonda;
			?>
			<th width="350px" class="text-center"><h4><b><?php echo $fecha_sonda; ?></b></h4></th>
			<?php
			$th++;
			$th++;
			}
			?>
		</tr>
	</thead>
	<tbody>
<?php
		foreach ($arrValores as $id_tema => $arrTema) {
			$x->select($id_tema);
			$tema_nombre = ucfirst($x->getTema());
			$arrUsers = $arrTema['id_suser'];
			$arrPreguntas = $arrTema['preguntas'];

			$preguntas = implode(",", $arrPreguntas);
			//
			echo "<tr>";
				echo "<td>";
				echo "<h4><strong><a style='cursor:pointer;'>".$tema_nombre."</a></strong></h4>";
				if (is_array($arrPreguntas)) {
					foreach ($arrPreguntas as $key => $id_preg) {
						$key++;
						$y->select($id_preg);
						$graf_barras_temas[] = $y->getPregunta();
						echo '<table border="0" width="100%" height="110">';
							echo '<tr>';
								echo '<td style="min-width:450px; white-space:normal;">';
									echo "<h5 style='margin-left:10px;'>".$key." - ".$y->getPregunta()."</h5>";
								echo '</td>';
							echo '</tr>';
						echo '</table>';
					}
				}
				echo "</td>";
				//
				foreach ($arrSondas as $key => $id_sonda) {
					$rendimiento->select_($_SESSION['Empresa']['id'], $id_sonda);
					$temas = $rendimiento->getTemas();

					if($id_sonda == $last_id){
						$ids = implode(",", $arrUsers);
					}else{
						$ids = $z->get_id_x_sonda($args, $_SESSION['Empresa']['id'], $id_sonda);
					}
					//
					if (is_array($temas)) {
						if(array_key_exists($id_tema, $temas)){
							echo "<td>";
								echo "<h4>&nbsp;</h4>";
								if (is_array($arrPreguntas)) {
									foreach ($arrPreguntas as $key => $id_preg) {
										$arrTemasPreguntas = $temas[$id_tema];
										if (in_array($id_preg, $arrTemasPreguntas)) {
											echo '<table border="0" width="100%">';
												echo '<tr>';
													if($id_sonda == $last_id){
														$promedio = $w->get_avg_x_pregunta($ids,$id_preg, 3);
														$porcentajes = $w->get_percent_x_pregunta($ids,$id_preg, 3);
													}else{
														$promedio = $w->get_avg_x_pregunta($ids,$id_preg);
														$porcentajes = $w->get_percent_x_pregunta($ids,$id_preg);
													}

													$arrPromedios[$id_sonda][] = number_format($promedio, 2);
													//
													echo "<td width='50px' class='text-center' style='background-color: ".$w->get_color($promedio)."'><h4>";
													printf("%.2f", $promedio);
													echo "</h4></td>";

													//$porcentajes = array(0,100,0);
													echo '<td style="min-width: 400px;">';
														echo '<table id="tblPorcentajes" border="0" width="100%" height="110">';
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
														echo '</table>';
													echo '</td>';
												echo '</tr>';
											echo '</table>';
											//echo "<br>";
										}else{
											$promedio = 0;
											$arrPromedios[$id_sonda][] = number_format($promedio, 2);
											//
											echo '<table border="0" width="100%">';
												echo '<tr>';
													echo "<td></td>";

													echo '<td class="col-md-6">';
														echo '<table id="tblPorcentajes" border="0" width="100%" height="110">';
															echo '<tr>';
																echo '<td width="90%"></td>';
																echo '<td></td>';
															echo '</tr>'; 
															echo '<tr>';
																echo '<td width="90%"></td>';
																echo '<td></td>';
															echo '</tr>';
															echo '<tr>';
																echo '<td width="90%"></td>';
																echo '<td></td>';
															echo '</tr>';
														echo '</table>';
													echo '</td>';
												echo '</tr>';
											echo '</table>';
											//echo "<br>";
										}
									}
								}
							echo "</td>";
						}else{
							echo "<td>";
								echo "<h4>&nbsp;</h4>";
								if (is_array($arrPreguntas)) {
									foreach ($arrPreguntas as $key => $id_preg) {
										$promedio = 0;
										$arrPromedios[$id_sonda][] = number_format($promedio, 2);
										//
										echo '<table border="0" width="100%">';
											echo '<tr>';
												echo "<td></td>";

												echo '<td class="col-md-6">';
													echo '<table id="tblPorcentajes" border="0" width="100%" height="110">';
														echo '<tr>';
															echo '<td width="90%"></td>';
															echo '<td></td>';
														echo '</tr>'; 
														echo '<tr>';
															echo '<td width="90%"></td>';
															echo '<td></td>';
														echo '</tr>';
														echo '<tr>';
															echo '<td width="90%"></td>';
															echo '<td></td>';
														echo '</tr>';
													echo '</table>';
												echo '</td>';
											echo '</tr>';
										echo '</table>';
									}
								}
							echo "</td>";
						}
					}else{
						echo "<td>";
						echo "</td>";
					}
				}
			echo "</tr>";
		}

		$arrTot['fecha'] = null;
		$arrTot['arrValores'] = null;
		if (is_array($arrFechas) && is_array($arrPromedios)) {
			foreach ($arrFechas as $id_sonda => $fecha) {
				$arrTot['fecha'] = $fecha;
				$arrTot['arrValores'] = $arrPromedios[$id_sonda];
				array_push($graf_barras_valores, $arrTot);
			}
		}
?>
		<tr>
			<td colspan="<?php echo (count($arrSondas) + 1) ?>">
				<h4>Grafico Comparativo General<img src='<?php echo BASEURL; ?>public/img/line-graph.png' width='40' height='40' style='cursor:pointer;margin-left: 20px;' onclick='graficoBarras(<?php echo json_encode($graf_barras_temas).','.json_encode($graf_barras_valores); ?>);' /></h4>
			</td>
		</tr>
	</tbody>
</table>
</div>
<?php
			$i++;
			echo "<br><br><br>";
		}
	}
//
$array_para_enviar_via_url = serialize($arrSondas);
$array_para_enviar_via_url = urlencode($array_para_enviar_via_url);
//
echo '<table class="table table-bordered table-hover" style="margin-top:50px">';
echo "<tr>";
echo "<td width='70%'><h4>Descargar</h4></td>";
echo '<td width="30%" class="text-center">';
	echo '<div class="btn-group">';
		echo '<a href="'.BASEURL.'pdf/grupos_criticos/'.$_SESSION['Empresa']['id'].'/'.$rendimiento->getId().'/'.$array_para_enviar_via_url.'" class="btn btn-default">Generar reporte</a><br>';
		echo '<a href="'.BASEURL.'pdf/grupos_criticos_xls/'.$_SESSION['Empresa']['id'].'/'.$rendimiento->getId().'/'.$array_para_enviar_via_url.'" class="btn btn-default">Descargar en excel</a>';
	echo '</div>';
echo '</td>';
echo "</tr>";
echo '<table>';
}
?>
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