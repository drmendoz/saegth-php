<style type="text/css">
	select.clase {height: 120px !important}
	.progress{height: 40px;}
	.progress-bar{
		font-size: 24px;
		padding-top: 8px;
		border-color: rgba(0, 0, 0, 0.3);
	}
	#area_seg{height: 400px !important}
	.f_fechas{width: 150px;}
	#mdl_body{
		min-width: 900px; 
		height: 400px; 
		margin: 0 auto;
	}
	@media (min-width: 992px) {
		.container-fluid.my-own-class {
			overflow-x: scroll;
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
	.box-shadow{
		top: 0;
	    left: 0;
	    z-index: 1060;
	    max-width: 276px;
	    padding: 1px;
	    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
	    font-size: 14px;
	    font-style: normal;
	    font-weight: normal;
	    line-height: 1.42857143;
	    text-align: left;
	    text-align: start;
	    text-decoration: none;
	    text-shadow: none;
	    text-transform: none;
	    letter-spacing: normal;
	    word-break: normal;
	    word-spacing: normal;
	    word-wrap: normal;
	    white-space: normal;
	    background-color: #fff;
	    -webkit-background-clip: padding-box;
	    background-clip: padding-box;
	    border: 1px solid #ccc;
	    border: 1px solid rgba(0, 0, 0, .2);
	    border-radius: 6px;
	    -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, .2);
	    box-shadow: 0 5px 10px rgba(0, 0, 0, .2);
	    line-break: auto;
	}
</style>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="<?php echo BASEURL ?>public/js/jquery.columnmanager.js" type="text/javascript" ></script>
<script type="text/javascript">
	
	function graficoLineal(graf){
		var title = '';
		var categories = [];
		var series = [];
		//
		$.each(graf, function(i, item) {
			title = i.split('|')[1];
		    $.each(item, function(sonda, promedio){
		    	categories.push(sonda.split('|')[0]);
		    	series.push(parseFloat(promedio));
		    });
		});
		//
		Highcharts.chart('mdl_body', {
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
				width: 1150
			},
	        title: {
	            text: '<b>Factor: '+title+'</b>',
	            x: -20 //center
	        },
	        xAxis: {
	            categories:  categories
	        },
	        yAxis: {
	        	min: 0,
	            max: 100,
	            tickInterval: 10,
	            title: {
	                text: 'ESCALAS'
	            },
	            plotLines: [{
	                value: 0,
	                width: 1,
	                color: '#808080'
	            }]
	        },
	        
	        tooltip: {
	            valueSuffix: '%'
	        },
	        legend: {
	            layout: 'vertical',
	            align: 'right',
	            verticalAlign: 'middle',
	            borderWidth: 0
	        },
	        series: [{
	            name: 'IRSP',
	            data: series
	        }]
	    });
	    
	    $('#myModal').modal('show');
	}

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
	            text: '<b>Comparar Encuestas</b>',
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

	$promedio_general = array();
	$c_e = '';
	$th = 3;
	$array_para_enviar_via_url= array();

	if($riesgos != '' && isset($arrCompara)){
		$c_e=$z->get_evaluados($args,$riesgos,'C');
		$temas = $x->select_all_();
		
		$args_url = serialize($args);
		$args_url = urlencode($args_url);

		$explode = explode('<br>', $filtros);
		$filtros_url = serialize($explode);
		$filtros_url = urlencode($filtros_url);
	}
?>
<h4>DIAGNÓSTICO DE RIESGO PSICOSOCIAL.- COMPARAR CRITERIOS</h4>
<form action="<?php echo BASEURL.'riesgo_psicosocial/riesgo_segmentacion'?>" method="POST">
	<h4><a class="btn btn-default" data-toggle="collapse" href="#collapseEncuentas" aria-expanded="false" aria-controls="collapseEncuentas">Filtrar Encuestas</a></h4>
	<div class="collapse" id="collapseEncuentas" style="width: 200px;">
		<div class="well">
			<select name="riesgos" class="form-control">
				<?php
				$riesgo->get_Riesgos_Empresa($_SESSION['Empresa']['id']);
				?>
			</select>
		</div>
	</div>
	<h4><a class="btn btn-default" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Filtrar criterios</a></h4>
	<div class="collapse" id="collapseExample">
		<div class="well">
			<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
				<div class="panel-heading">Edad</div>
				<div class="panel-body">
					<select multiple name="edad[]" class="form-control clase">
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
			<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
				<div class="panel-heading">Antigüedad</div>
				<div class="panel-body">
					<select multiple name="antiguedad[]" class="form-control clase">
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
			<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
				<div class="panel-heading">Localidades</div>
				<div class="panel-body">
					<select multiple name="localidad[]" class="form-control clase">
						<option style="display:none">Seleccione una opción</option>
						<?php
						$test = new Empresa_local();
						$test->get_select_options_($_SESSION['Empresa']['id']);
						?>
					</select>
				</div>
			</div>
			<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
				<div class="panel-heading">Niveles Organizacionales</div>
				<div class="panel-body">
					<select multiple name="norg[]" class="form-control clase">
						<option style="display:none">Seleccione una opción</option>
						<?php
						$test = new Empresa_norg();
						$test->get_select_options($_SESSION['Empresa']['id']);
						?>
					</select>
				</div>
			</div>
			<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
				<div class="panel-heading">Tipo de contrato</div>
				<div class="panel-body">
					<select multiple name="tcont[]" class="form-control clase">
						<option style="display:none">Seleccione una opción</option>
						<?php
						$test = new Empresa_tcont();
						$test->get_select_options($_SESSION['Empresa']['id']);
						?>
					</select>
				</div>
			</div>
			<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
				<div class="panel-heading">Educación</div>
				<div class="panel-body">
					<select multiple name="educacion[]" class="form-control clase">
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
			<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
				<div class="panel-heading">Sexo</div>
				<div class="panel-body">
					<select multiple name="sexo[]" class="form-control clase">
						<option style="display:none">Seleccione una opción</option>
						<option value="0">Masculino</option>
						<option value="1">Femenino</option>
					</select>
				</div>
			</div>
			<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
				<div class="panel-heading">Hijos</div>
				<div class="panel-body">
					<select multiple name="hijos[]" class="form-control clase">
						<option style="display:none">Seleccione una opción</option>
						<option value="0">Si</option>
						<option value="1">No</option>
						<option value="2">N/E</option>
					</select>
				</div>
			</div>
			<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
				<div class="panel-heading">Departamento</div>
				<div class="panel-body">
					<select multiple id="area_seg" name="departamento[]" class="form-control clase">
						<option style="display:none">Seleccione una opción</option>
						<?php
						$test = new Empresa_area();
						$test->get_select_options($_SESSION['Empresa']['id']);
						?>
					</select>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
	<div class="clearfix"></div>
	<div class="text-center"><input type="submit" value="Filtrar" name="filtro" class="btn btn-sm btn-default"> </div>
	<div class="clearfix"></div>
</form>
<?php if($riesgos != '' && isset($arrCompara)){ ?>
<?php if ($c_e >= 3) { ?>
<p><br></p>
<h4>Evaluados en proceso: <?php echo $c_e ?></h4>
<?php $util->_x('resultados','segmentacion'); ?>
<p><?php echo $filtros ?></p>
<div class="container-fluid my-own-class">
	<table class="table table-bordered table-hover" style="margin-top:50px">
		<thead>
			<tr>
				<th><h4><?php $util->_x('resultados','titulo2') ?></h4></th>
				<?php
				foreach ($arrCompara as $cont => $arrDatos) {
				?>
				<th class="text-center"><h4><b><?php echo $arrDatos['nombre']; ?></b></h4></th>
				<?php
				}
				?>
				<th class="text-center">Lineal</th>
			</tr>
		</thead>
		<tbody>
		<?php
		if (is_array($temas)) {
			
			$ii = $yy = $zz = 0;
			$graf = $graf_barras_valores = $graf_barras_temas = array();
			$preguntas = $preguntas_general = '';

			foreach ($temas as $key => $value) {
				$id_t = $value['id'];
				$tema_nombre = $value['tema'];				
				$preguntas = $y->select_ids_x_tema($id_t);
				$preguntas_general .= $preguntas.',';
				$graf[$id_t.'|'.$tema_nombre] = array();
				$graf_barras_temas[] = ucfirst($value['tema']);
		?>
			<tr>
				<td style="font-size: 14px; min-width: 550px;">
					<h5>
						<strong>
							<a href="<?php echo BASEURL ?>riesgo_psicosocial/riesgo_segmentacion_p/<?php echo $id_t ?>">
								<span class="text-capitalize"><?php echo ucfirst($tema_nombre); ?></span>
							</a>
						</strong>
					</h5>
					<h6>
						<span><?php echo $value['descripcion'] ?></span>
					</h6>
				</td>
				<?php
				foreach ($arrCompara as $cont => $arrDatos) {
					$ids = $z->get_id_x_segmentacion($_SESSION['Empresa']['id'], $riesgos, $arrDatos['campo'], $arrDatos['id']);
					$porcentajes = number_format($w->get_percent($ids,$preguntas), 2);
					$graf[$id_t.'|'.$tema_nombre][$arrDatos['nombre']] = ($porcentajes != 0) ? number_format($porcentajes, 2) : $porcentajes;
					$arrFechas[serialize($arrDatos)] = $arrDatos['nombre'];
					$arrPromedios[serialize($arrDatos)][] = number_format($porcentajes, 2);

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
				<td class='box-shadow' style="max-width: 700px">
					<div style="min-width:370px" class="progress" role="tooltip" data-toggle="popover" data-trigger="hover" data-content="" data-placement="top">
						<div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $porcentajes ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $porcentajes ?>%;background-color: <?php echo $color ?>">
							<span ><?php echo $porcentajes ?>% </span>
						</div>
					</div>
				</td>
				<?php
				}
				?>
				<td class='text-center'><img src='<?php echo BASEURL; ?>public/img/line-graph.png' width='40' height='40' style='cursor:pointer;' onclick='graficoLineal(<?php echo json_encode($graf); ?>);' /></td>
			</tr>
		<?php
				$graf = null;
			}
		}
		?>
			<tr>
				<th><h4>Promedio General</h4></th>
				<?php
					$preguntas_general = substr($preguntas_general, 0, -1);
					$porcentajes_generales = '';
					$graf = array();
					$yy = 0;

					foreach ($arrCompara as $cont => $arrDatos) {
						$ids = $z->get_id_x_segmentacion($_SESSION['Empresa']['id'], $riesgos, $arrDatos['campo'], $arrDatos['id']);
						$porcentajes = number_format($w->get_percent($ids,$preguntas_general), 2);
						$graf[$riesgos.'|'.'Promedio General'][$arrDatos['nombre']] = ($porcentajes != 0) ? number_format($porcentajes, 2) : $porcentajes;
						array_push($arrPromedios[serialize($arrDatos)], number_format($porcentajes, 2));

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
					<td class='box-shadow'>
						<div class="progress" role="tooltip" data-toggle="popover" data-trigger="hover" data-content="" data-placement="top">
							<div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $porcentajes ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $porcentajes ?>%;background-color: <?php echo $color ?>">
								<span ><?php echo $porcentajes ?>% </span>
							</div>
						</div>
					</td>
					<?php
					}
				?>
					<td class='text-center'><img src='<?php echo BASEURL; ?>public/img/line-graph.png' width='40' height='40' style='cursor:pointer;' onclick='graficoLineal(<?php echo json_encode($graf); ?>);' /></td>
			</tr>
			<?php 
			//Armar json general
			array_push($graf_barras_temas, 'Promedio General');
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
				<td><h4>Grafico Comparativo General<img src='<?php echo BASEURL; ?>public/img/line-graph.png' width='40' height='40' style='cursor:pointer;margin-left: 20px;' onclick='graficoBarras(<?php echo json_encode($graf_barras_temas).','.json_encode($graf_barras_valores); ?>);' /></h4></td>
				<?php
				foreach ($arrCompara as $cont => $arrDatos) {
					$campo = $arrDatos['campo'];
					$id = $arrDatos['id'];
				?>
				<td class="text-center">
					<div class="btn-group">
						<a href="<?php echo BASEURL ?>riesgo_psicosocial/top/1/<?php echo $riesgos ?>/RS/<?php echo $arrDatos['campo']; ?>/<?php echo $arrDatos['id']; ?>" class="btn btn-default">Puntaje más alto</a>
						<a href="<?php echo BASEURL ?>riesgo_psicosocial/top/0/<?php echo $riesgos ?>/RS/<?php echo $arrDatos['campo']; ?>/<?php echo $arrDatos['id']; ?>" class="btn btn-default">Puntaje más bajo</a>
						<a href="<?php echo BASEURL.'pdf/rp_seg/'.$_SESSION['Empresa']['id'].'/'.$riesgos.'/'.$campo.'/'.$id.'/'.$args_url.'/'.$filtros_url ?>" class="btn btn-default">Generar reporte</a>
						<a href="<?php echo BASEURL.'pdf/rp_xls_seg/'.$_SESSION['Empresa']['id'].'/'.$riesgos.'/'.$campo.'/'.$id.'/'.$args_url.'/'.$filtros_url?>" class="btn btn-default">Descargar en excel</a>
					</div>
				</td>
				<?php
				}
				?>
				<td>&nbsp;</td>
			</tr>
		</tbody>
	</table>
</div>
<?php }else { ?>
<div class="alert alert-info" role="alert"><h4>Datos Insuficientes</h4></div>
<?php } ?> 
<?php } ?>
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