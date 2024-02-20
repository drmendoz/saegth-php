<style type="text/css">
	select.cmbSondas{height: 26px !important}
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
		$('#a_sonda, #g_af').addClass('active-parent active');
		$('#af_an').addClass('activate');
		
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
		var chart;
		var points=[];
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
	            shared : true,
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
$sonda = new Sonda();
$x = new Sonda_tema();
$y = new Sonda_pregunta();
$z = new Sonda_user();
$w = new Sonda_respuesta();
$util = new Util();

echo '<h4>DIAGNÓSTICO DE CLIMA ORGANIZACIONAL.- GRUPOS CRITICOS / SONDAS ANTERIORES</h4>';
echo "<br>";
?>
<form action="<?php echo BASEURL.'sonda/otros_promedios_bajos' ?>" method="POST">
	<h4><a class="btn btn-default" data-toggle="collapse" href="#collapseEncuentas" aria-expanded="false" aria-controls="collapseEncuentas">Mostrar Encuestas</a></h4>
	<div class="collapse" id="collapseEncuentas" style="width: 230px;">
		<div class="well">
			<select name="sondas" class="form-control cmbSondas" style="height: 26px">
				<?php
				$sonda->get_Sondas_Empresa($_SESSION['Empresa']['id'], 'S');
				?>
			</select>
		</div>
	</div>
	<!-- ///////////////////////////////////// -->
	<div class="clearfix"></div>
	<div class="text-center"><input type="submit" value="Filtrar" name="filtro" class="btn btn-sm btn-default"> </div>
	<div class="clearfix"></div>
</form>
<?php
if($sondas != ''){
	
	$rendimiento = unserialize($rendimiento);
	$sonda->select_($_SESSION['Empresa']['id'], $sondas);
	$explode = explode('-', $sonda->fecha);
	$fecha_sonda = $explode[2].'-'.$sonda->parseMonth($explode[1]).'-'.$explode[0];

	if (is_array($arrDatos)) {
		$i = 1;
		foreach ($arrDatos as $key => $value) {
			$collapseExample = 'collapseExample'.$i;
			foreach ($value as $tipo => $valor) {
				if ($tipo != 'c_e') {
					$filtro["tipo"] = $tipo;
					$filtro["valor"] = $valor;
					$rendimiento->filtros_criterios($filtro);
					$rendimiento->get_criterios();
				}
			}
			$rendimiento->resetVariables();
			$i++;

			$args = $rendimiento->getArgs();
			$filtros .= $rendimiento->getCriterios();

			$ids = $z->get_id_x_sonda($args, $_SESSION['Empresa']['id'], $sondas);
			$c_e=$z->get_evaluados($args,$sondas);
?>
<h4>Evaluados en proceso: <?php echo $c_e ?> - <a class="btn btn-default" data-toggle="collapse" href="#<?php echo$collapseExample; ?>" aria-expanded="false" aria-controls="<?php echo$collapseExample; ?>">Mostrar filtros</a></h4>
<?php $util->_x('resultados','segmentacion'); ?>
<p><?php echo 'Sonda: '.$fecha_sonda; ?></p>
<p><?php echo $rendimiento->criterios; ?></p>
<div class="collapse" id="<?php echo$collapseExample; ?>">
	<div class="well">
		<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
			<div class="panel-heading">Edad</div>
			<div class="panel-body">
				<select multiple name="edad[]" class="form-control" disabled="disabled">
					<option style="display:none">Seleccione una opción</option>
					<option value="0" <?php if (in_array(0, $rendimiento->getEdad())): echo "selected='selected'"; endif ?>>Menor a 20 años</option>
					<option value="1" <?php if (in_array(1, $rendimiento->getEdad())): echo "selected='selected'"; endif ?>>De 20 a 25 años</option>
					<option value="2" <?php if (in_array(2, $rendimiento->getEdad())): echo "selected='selected'"; endif ?>>De 25 a 30 años</option>
					<option value="3" <?php if (in_array(3, $rendimiento->getEdad())): echo "selected='selected'"; endif ?>>De 30 a 40 años</option>
					<option value="4" <?php if (in_array(4, $rendimiento->getEdad())): echo "selected='selected'"; endif ?>>De 40 a 50 años</option>
					<option value="5" <?php if (in_array(5, $rendimiento->getEdad())): echo "selected='selected'"; endif ?>>Más 50 años</option>
				</select>
			</div>
		</div>
		<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
			<div class="panel-heading">Antigüedad</div>
			<div class="panel-body">
				<select multiple name="antiguedad[]" class="form-control" disabled="disabled">
					<option style="display:none">Seleccione una opción</option>
					<option value="0" <?php if (in_array(0, $rendimiento->getAntiguedad())): echo "selected='selected'"; endif ?>>Menor a 1 años</option>
					<option value="1" <?php if (in_array(1, $rendimiento->getAntiguedad())): echo "selected='selected'"; endif ?>>De 1 a 2 años</option>
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

<div>
	<table class="table table-bordered table-hover" style="margin-top:50px">
		<tr><th colspan="3"><h4><?php $util->_x('resultados','titulo2') ?></h4></th></tr>
		<?php
		$temas = $sonda->getTemas();
		$xls_prep;
		$preguntas = $preguntas_general = '';
		$promedio_general = array();
		$arrPromedios = array();
		$graf_barras_valores = $graf_barras_temas = array();
		if (is_array($temas)) {
			foreach ($temas as $key => $value) {
				$x->select($key);
				echo "<tr>";
				$tema_nombre = $xls_prep[$key]['tema'] = ucfirst($x->getTema());
				$tema_id = $x->getId();
				$graf_barras_temas[] = $tema_nombre;

				if($_SESSION['Empresa']['id']==440){
					echo "<td class='col-md-7'><h4><strong><a href='".BASEURL."sonda/resultados_pregunta/".$sondas."/".$tema_id."'>".$tema_nombre.".-</a></strong></h4>";
					echo "<h5>".$x->getDescripcion()."</h5></td>";
				}else{
					echo "<td class='col-md-7'><h4><strong><a href='".BASEURL."sonda/resultados_pregunta/".$sondas."/".$tema_id."'>".$tema_nombre."</a></strong></h4></td>";
				}
				
				$preguntas = implode(",", $temas[$key]);
				$preguntas_general .= implode(",", $temas[$key]).',';

				$promedio = $xls_prep[$key]['promedio'] = $w->get_avg_x_tema($ids,$preguntas);
				$porcentajes = $xls_prep[$key]['porcentajes'] = $w->get_percent($ids,$preguntas);
				array_push($promedio_general, $promedio);
				$arrPromedios['ICO'][] = ($promedio != 0) ? number_format($promedio, 2) : 0;
				
				echo "<td class='text-center' style='background-color: ".$w->get_color($promedio)."'><h4>";
				printf("%.2f", $promedio);
				echo "</h4></td>";
				?>
				<td class="col-md-6">
					<table id="tblPorcentajes" border="0" width="100%">
						<tr>
							<td width="90%">
								<div style="background-color: red;" data-width="<?php echo $porcentajes[0] ?>">
							</td>
							<td width="10%" style="text-align: right;"><h5><?php echo $porcentajes[0] ?>% </h5></td>
						</tr>
						<tr>
							<td width="90%">
								<div style="background-color: yellow;" data-width="<?php echo $porcentajes[1] ?>">
							</td>
							<td width="10%" style="text-align: right;"><h5><?php echo $porcentajes[1] ?>% </h5></td>
						</tr>
						<tr>
							<td width="90%">
								<div style="background-color: limegreen;" data-width="<?php echo $porcentajes[2] ?>">
							</td>
							<td width="10%" style="text-align: right;"><h5><?php echo $porcentajes[2] ?>% </h5></td>
						</tr>
					</table>
				</td>
				<?php
				echo "</tr>";
			}
		}
		?>
		<tr>
			<th><h4>Promedio General</h4></th>
			<?php 
				$preguntas_general = substr($preguntas_general, 0, -1);
				$p_gen = @(array_sum($promedio_general)/sizeof($promedio_general)); 
				$porcentajes_generales = $w->get_percent($ids,$preguntas_general);
				array_push($arrPromedios['ICO'], round($p_gen,2));
			?>
			<td class='text-center' style='background-color: <?php echo $w->get_color($p_gen) ?>'>
				<h4><?php printf("%.2f", $p_gen); ?></h4>
			</td>
			<td>
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
				</table>
			</td>
			<?php 
				$filtros = ($filtros=="Todos") ? "" : $filtros; 
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
	</table>
</div>
<?php
		}
	}
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