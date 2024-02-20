<style type="text/css">
	.progress{height: 40px;}
	.progress-bar{
		font-size: 24px;
		padding-top: 8px;
		border-color: rgba(0, 0, 0, 0.3);
	}
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
		$('#a_riesgo, #a_riesgo_res').addClass('active-parent active');
		$('#li_r_his').addClass('activate');

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
	            max: 100,
	            tickInterval: 10,
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
$riesgo = new Riesgo_psicosocial();
$w = new Rp_respuesta();
$x = new Rp_tema();
$y = new Rp_pregunta();
$z = new Rp_user();
$util = new Util();


$riesgo->select_x_id($_SESSION['Empresa']['id'], $id_s);
$seg = $riesgo->getSegmentacion();
$temas = $x->select_all_();
$promedio_general = array();
$graf_barras_valores = $graf_barras_temas = array();
$preguntas = $preguntas_general = '';


$ids = $z->get_id_x_riesgo($args, $id_s);
$c_e=$z->get_evaluados($args,$id_s);

$args_url = serialize($args);
$args_url = urlencode($args_url);

$explode = explode('<br>', $filtros);
$filtros_url = serialize($explode);
$filtros_url = urlencode($filtros_url);
?>

<h4>DIAGNÓSTICO DE RIESGO PSICOSOCIAL.- RESULTADOS DE ENCUESTAS</h4>
<a class="btn btn-default" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Filtrar criterios</a>
<form action="<?php echo BASEURL.'riesgo_psicosocial/riesgo_resultados/'.$id_s ?>" method="POST">
	<div class="collapse" id="collapseExample">
		<div class="well">
			<?php if (in_array("edad", $seg)): ?>
				<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
					<div class="panel-heading">Edad</div>
					<div class="panel-body">
						<select multiple name="edad[]" class="form-control">
							<option style="display:none">Seleccione una opción</option>
							<option value="0">Menor a 20 años</option>
							<option value="1">De 20 a 25 años</option>
							<option value="2">De 25 a 30 años</option>
							<option value="3">De 30 a 40 años</option>
							<option value="4">De 40 a 50 años</option>
							<option value="5">Más 50 años</option>
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
							<option value="1">Menos de 2</option>
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
						<select multiple name="sexo[]" class="form-control">
							<option style="display:none">Seleccione una opción</option>
							<option value="0">Masculino</option>
							<option value="1">Femenino</option>
						</select>
					</div>
				</div>
			<?php endif ?>
			<?php if (in_array("hijos", $seg)): ?>
				<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
					<div class="panel-heading">Hijos</div>
					<div class="panel-body">
						<select multiple name="hijos[]" class="form-control">
							<option style="display:none">Seleccione una opción</option>
							<option value="0">Si</option>
							<option value="1">No</option>
							<option value="2">N/E</option>
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
			<div class="text-center"><input type="submit" value="Filtrar" name="filtro" class="btn btn-sm btn-default"> </div>
			<div class="clearfix"></div>
			
		</div>
	</div>
</form>
<?php if($c_e >= 3){ ?>
<p><br></p>
<h4>Evaluados en proceso: <?php echo $c_e ?></h4>
<?php $util->_x('resultados','segmentacion'); ?>
<p><?php echo $filtros ?></p>
<table class="table table-bordered table-hover" style="margin-top:50px">
	<thead>
		<tr><th colspan="2"><h4><?php $util->_x('resultados','titulo2') ?></h4></th></tr>
	</thead>
	<tbody>
	<?php
	if (is_array($temas)) {
		foreach ($temas as $key => $value) {
			$id_t = $value['id'];
			$preguntas = $y->select_ids_x_tema($id_t);
			$preguntas_general .= $preguntas.',';
			$porcentajes = number_format($w->get_percent($ids,$preguntas), 2);
			$graf_barras_temas[] = ucfirst($value['tema']);
			array_push($promedio_general, $porcentajes);
			$arrPromedios['IRSP'][] = ($porcentajes != 0) ? number_format($porcentajes, 2) : $porcentajes;

			if ($porcentajes < 65){
				$color="#00FF00";
			}else if (($porcentajes >= 65)&&($porcentajes < 75)) {
				$color="#FFFF00";
			}else if (($porcentajes >= 75)&&($porcentajes < 85)) {
				$color="#FFA500";
			}else if ($porcentajes >= 85) {
				$color="#990000; color: #f8f8f8;";
			}
	?>
		<tr>
			<td class="col-md-7" style="font-size: 14px">
				<h5>
					<strong>
						<a href="<?php echo BASEURL ?>riesgo_psicosocial/riesgo_resultados_p/<?php echo $id_s.'/'.$id_t ?>">
							<span class="text-capitalize"><?php echo ucfirst($value['tema']); ?></span>
						</a>
					</strong>
				</h5>
				<h6>
					<span><?php echo $value['descripcion'] ?></span>
				</h6>
			</td>
			<td class='col-md-5 popover'>
				<div class="progress" role="tooltip" data-toggle="popover" data-trigger="hover" data-content="" data-placement="top">
					<div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $porcentajes ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $porcentajes ?>%;background-color: <?php echo $color ?>">
						<span ><?php echo $porcentajes ?>% </span>
					</div>
				</div>
			</td>
		</tr>
	<?php
		}
	}
	?>
		<tr>
			<td><h4>Promedio General</h4></td>
			<?php
			$preguntas_general = substr($preguntas_general, 0, -1);
			$p_gen = number_format($w->get_percent($ids,$preguntas_general), 2);
			array_push($arrPromedios['IRSP'], number_format($p_gen,2));
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

			if ($p_gen < 65){
				$color="#00FF00";
			}else if (($p_gen >= 65)&&($p_gen < 75)) {
				$color="#FFFF00";
			}else if (($p_gen >= 75)&&($p_gen < 85)) {
				$color="#FFA500";
			}else if ($p_gen >= 85) {
				$color="#990000; color: #f8f8f8;";
			}
			?>
			<td class='col-md-5 popover'>
				<div class="progress" role="tooltip" data-toggle="popover" data-trigger="hover" data-content="" data-placement="top">
					<div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $p_gen ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $p_gen ?>%;background-color: <?php echo $color ?>">
						<span ><?php echo $p_gen ?>% </span>
					</div>
				</div>
			</td>
		</tr>
		<tr>
			<td colspan="2"><h4><b>Grafico Comparativo General</b><img src='<?php echo BASEURL; ?>public/img/line-graph.png' width='40' height='40' style='cursor:pointer;margin-left: 20px;' onclick='graficoBarras(<?php echo json_encode($graf_barras_temas).','.json_encode($graf_barras_valores); ?>);' /></h4></td>
		</tr>
	</tbody>
</table>
<div class="btn-group">
	<a href="<?php echo BASEURL ?>riesgo_psicosocial/top/1/<?php echo $id_s ?>/RR" class="btn btn-default">Puntaje más alto</a>
	<a href="<?php echo BASEURL ?>riesgo_psicosocial/top/0/<?php echo $id_s ?>/RR" class="btn btn-default">Puntaje más bajo</a>
	<a href="<?php echo BASEURL.'pdf/rp/'.$_SESSION['Empresa']['id'].'/'.$id_s.'/'.$args_url.'/'.$filtros_url ?>" class="btn btn-default">Generar reporte</a>
	<a href="<?php echo BASEURL.'pdf/rp_xls/'.$_SESSION['Empresa']['id'].'/'.$id_s.'/'.$args_url.'/'.$filtros_url?>" class="btn btn-default">Descargar en excel</a>
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