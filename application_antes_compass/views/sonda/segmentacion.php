<style type="text/css">
	select.clase {height: 120px !important}
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
		var cols = [];
		for (var i = 3; i <= 500; i += 2) {
			cols.push(i);
		}

		$('#tableall').columnManager({
            listTargetID:'targetall',
            saveState: false, colsHidden: cols
        });

        $("#tblPorcentajes tr td > div").each(function() {
		    $(this).animate({
				width: $(this).data("width")+"%"
			}, 100);
		});
	});

	function collapse(id, cont) {

		var opt = {
            listTargetID: 'targetall', onClass: 'advon', offClass: 'advoff',
            hide: function(c){
                $(c).fadeOut();
            },
            show: function(c){
                $(c).fadeIn();
            }
        };

        var x = parseInt(cont);

        if ($('#'+id).hasClass('expande')){
            $('#tableall').showColumns([x], opt);
            $('#'+id).removeClass('expande').addClass('contrae');
        } else {
            $('#tableall').hideColumns([x], opt);
            $('#'+id).removeClass('contrae').addClass('expande');
        }
	}

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
	            max: 5,
	            tickInterval: 0.5,
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
	            name: 'ICO',
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
	            text: '<b>Comparar Criterios</b>',
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

$sonda = new Sonda();
$w = new Sonda_respuesta();
$x = new Sonda_tema();
$y = new Sonda_pregunta();
$z = new Sonda_user();

$util = new Util();
$c_e = '';
$th = 3;

if($sondas != '' && isset($arrCompara)){
	$sonda->select_($_SESSION['Empresa']['id'], $sondas);
	$promedio_general = array();
	$c_e=$z->get_evaluados($args,$sondas,'C');
}
echo '<h4>DIAGNÓSTICO DE CLIMA ORGANIZACIONAL.- COMPARAR CRITERIOS</h4>';
?>
<form action="<?php echo BASEURL.'sonda/segmentacion' ?>" method="POST">
	<h4><a class="btn btn-default" data-toggle="collapse" href="#collapseEncuentas" aria-expanded="false" aria-controls="collapseEncuentas">Filtrar Encuestas</a></h4>
	<div class="collapse" id="collapseEncuentas" style="width: 230px;">
		<div class="well">
			<select name="sondas" class="form-control">
				<?php
				$sonda->get_Sondas_Empresa($_SESSION['Empresa']['id']);
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
						<option value="1">De 21 a 25 años</option>
						<option value="2">De 26 a 30 años</option>
						<option value="3">De 31 a 40 años</option>
						<option value="4">De 41 a 50 años</option>
						<option value="5">Mas de 50 años</option>
					</select>
				</div>
			</div>
			<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
				<div class="panel-heading">Antigüedad</div>
				<div class="panel-body">
					<select multiple name="antiguedad[]" class="form-control clase">
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
						<option value="4">Universitaria incompleta</option>
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
	<!-- ///////////////////////////////////// -->
	<div class="clearfix"></div>
	<div class="text-center"><input type="submit" value="Filtrar" name="filtro" class="btn btn-sm btn-default"> </div>
	<div class="clearfix"></div>
</form>

<?php if($sondas != '' && isset($arrCompara)){ ?>
<?php if ($c_e >= 3) { ?>
<p><br></p>
<h4>Evaluados en proceso: <?php echo $c_e ?></h4>
<?php $util->_x('resultados','segmentacion'); ?>
<p><?php echo $filtros; ?></p>
<div class="container-fluid my-own-class">
	<table id="tableall" class="table table-bordered table-hover consulta" style="margin-top:50px">
		<thead>
			<tr>
				<th rowspan="2"><h4><?php $util->_x('resultados','titulo2'); ?></h4></th>
				<?php
				foreach ($arrCompara as $cont => $arrDatos) {
					$id_th = 'th_'.$arrDatos['id'];
				?>
				<th id="<?php echo $id_th; ?>" colspan="2" class="text-center expande" onclick="collapse(<?php echo "'".$id_th."','".$th."'"; ?>)"><h4><b><?php echo $arrDatos['nombre']; ?></b></h4></th>
				<?php
				$th++;
				$th++;
				}
				?>
				<th rowspan="2" class="text-center">Lineal</th>
			</tr>
			<tr>
				<?php
				foreach ($arrCompara as $cont => $arrDatos) {
				?>
				<th class="text-center"><b>Promedio</b></th>
				<th class="text-center col_porc"><b>Porcentajes</b></th>
				<?php
				}
				?>
			</tr>
		</thead>
		<tbody>
			<?php 
			$temas = $sonda->getTemas();
			$xls_prep;
			$ii = $yy = 0;
			$graf = $graf_barras_valores = $graf_barras_temas = array();
			$preguntas = $preguntas_general = '';

			foreach ($temas as $key => $value) {
				$x->select($key);
				echo "<tr>";
				$tema_nombre = $xls_prep[$key]['tema'] = ucfirst($x->getTema());
				$tema_id = $x->getId();
				$graf[$key.'|'.$tema_nombre] = array();
				$graf_barras_temas[] = $tema_nombre;

				echo "<td style='min-width:500px; max-width:500px; white-space:normal;'><h4><strong><a href='".BASEURL."sonda/segmentacion_pregunta/".$tema_id."'>".$tema_nombre."</a></strong></h4>";
				echo "<h5>".$x->getDescripcion()."</h5></td>";

				foreach ($arrCompara as $cont => $arrDatos) {
					$preguntas = implode(",", $temas[$key]);
					$preguntas_general .= implode(",", $temas[$key]).',';
					$ids = $z->get_id_x_segmentacion($_SESSION['Empresa']['id'], $sondas, $key, $arrDatos['campo'], $arrDatos['id']);
					$promedio = $w->get_avg_x_tema($ids,$preguntas);

					if($promedio == '')
						$promedio = 0;
					
					if($promedio != 0){
						$promedio_general[$arrDatos['campo'].'|'.$arrDatos['id']][$ii] = $promedio;
						$ii++;
					}

					$arrFechas[serialize($arrDatos)] = $arrDatos['nombre'];
					$arrPromedios[serialize($arrDatos)][] = number_format($promedio, 2);

					$porcentajes = $xls_prep[$key]['porcentajes'] = $w->get_percent($ids,$preguntas);
					$graf[$key.'|'.$tema_nombre][$arrDatos['nombre']] = ($promedio != 0) ? number_format($promedio, 2) : $promedio;
					echo "<td class='col-md-1 text-center' style='background-color: ".$w->get_color($promedio)."'><h4>";
					printf("%.2f", $promedio);
					echo "</h4></td>";
				?>
					<td style='min-width: 400px;'>
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
							<tr>
								<td width="90%">
									<div style="background-color: silver;" data-width="<?php echo $porcentajes[3] ?>">
								</td>
								<td width="10%" style="text-align: right;"><h5><?php echo $porcentajes[3] ?>% </h5></td>
							</tr>
						</table>
					</td>
			<?php
					$yy++;
				}
			?>
					<td class='text-center col-md-1'><img src='<?php echo BASEURL; ?>public/img/line-graph.png' width='40' height='40' style='cursor:pointer;' onclick='graficoLineal(<?php echo json_encode($graf); ?>);' /></td>
			<?php
				echo "</tr>";
				$graf = null;
			}
			?>
			<tr>
				<th><h4>Promedio General</h4></th>
				<?php
					//$filtros = ($filtros=="Todos") ? "" : $filtros;
					$filtros = str_replace(" ", "+", $filtros);
					$filtros = str_replace("/", "*", $filtros);
					$preguntas_general = substr($preguntas_general, 0, -1);
					$porcentajes_generales = '';
					$graf = array();
					$yy = 0;

					foreach ($arrCompara as $cont => $arrDatos) {
						$p_gen = 0;
						$ids = $z->get_id_x_segmentacion($_SESSION['Empresa']['id'], $sondas, '', $arrDatos['campo'], $arrDatos['id']);
						$porcentajes_generales = $w->get_percent($ids,$preguntas_general);
						

						if (array_key_exists($arrDatos['campo'].'|'.$arrDatos['id'], $promedio_general)) {
							if (is_array($promedio_general[$arrDatos['campo'].'|'.$arrDatos['id']])) {
								$p_gen = array_sum($promedio_general[$arrDatos['campo'].'|'.$arrDatos['id']])/sizeof($promedio_general[$arrDatos['campo'].'|'.$arrDatos['id']]);
							}
						}

						array_push($arrPromedios[serialize($arrDatos)], number_format($p_gen, 2));
						$graf[$sondas.'|'.'Promedio General'][$arrDatos['nombre']] = ($p_gen != 0) ? number_format($p_gen, 2) : $p_gen;
				?>
					<td class='text-center' style='background-color: <?php echo $w->get_color($p_gen) ?>'>
						<h4><?php printf("%.2f", $p_gen); ?></h4>
					</td>
					<td class="text-center">
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
					}
				?>
				<td class='text-center'><img src='<?php echo BASEURL; ?>public/img/line-graph.png' width='40' height='40' style='cursor:pointer;' onclick='graficoLineal(<?php echo json_encode($graf); ?>);' /></td>
				<?php  ?>
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
				<th><h4>Grafico Comparativo General<img src='<?php echo BASEURL; ?>public/img/line-graph.png' width='40' height='40' style='cursor:pointer;margin-left: 20px;' onclick='graficoBarras(<?php echo json_encode($graf_barras_temas).','.json_encode($graf_barras_valores); ?>);' /></h4></th>
				<?php
				foreach ($arrCompara as $cont => $arrDatos) {
				?>
				<td>&nbsp;</td>
				<td class="text-center">
					<div class="btn-group">
						<a href="<?php echo BASEURL ?>sonda/top_seg/<?php echo $sondas; ?>/<?php echo $arrDatos['campo']; ?>/<?php echo $arrDatos['id']; ?>/DESC" class="btn btn-default">Mejor puntaje</a>
						<a href="<?php echo BASEURL ?>sonda/top_seg/<?php echo $sondas; ?>/<?php echo $arrDatos['campo']; ?>/<?php echo $arrDatos['id']; ?>/ASC" class="btn btn-default">Peor puntaje</a>
						<a href="<?php echo BASEURL ?>pdf/sonda_seg/<?php echo $sondas.'/'.$arrDatos['campo'].'/'.$arrDatos['id']; ?>/'<?php echo $filtros ?>'" class="btn btn-default">Generar reporte</a>
						<a href="<?php echo BASEURL ?>pdf/sonda_xls_seg/<?php echo $sondas.'/'.$arrDatos['campo'].'/'.$arrDatos['id']; ?>" class="btn btn-default">Descargar en excel</a>
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
<?php } ?>