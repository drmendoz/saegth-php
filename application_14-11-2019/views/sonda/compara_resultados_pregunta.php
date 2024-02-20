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
	    background-image: url(../../public/img/asc.gif);
	    background-repeat: no-repeat;
	    background-position: top right;
	    cursor: pointer;
	}
	table.consulta thead .contrae {
	    background-image: url(../../public/img/desc.gif);
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

		$('#a_sonda, #a_res').addClass('active-parent active');
		$('#li_cres').addClass('activate');

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
	            text: '<b>Pregunta: '+title+'</b>',
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
	            text: '<b>Comparar Encuestas</b>',
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
$util = new Util();
echo '<h4>DIAGNÓSTICO DE CLIMA ORGANIZACIONAL.- COMPARAR ENCUESTAS</h4>';

if ($sondas != '') {
	$xxx = new Sonda();
	$xxx->select_compara($_SESSION['Empresa']['id'], $sondas);
	$temas = $xxx->getTemas();
	$sondas_compara = $xxx->getSondasCompara();
}

$th = 3;
?>
<?php $util->_x('resultados','segmentacion'); ?>
<p><?php echo $filtros ?></p>
<div class="container-fluid my-own-class">
	<?php $x = new Sonda_tema(); $x->select($id_tema); ?>
	<table id="tableall" class="table table-bordered table-hover consulta" style="margin-top:50px">
		<thead>
			<tr>
				<th rowspan="2">
					<h4>
						<strong>
							<a href="<?php echo BASEURL ?>sonda/comparar_resultados"><?php echo ucfirst($x->getTema()) ?>.-</a>
						</strong><?php $x->getDescripcion() ?>
					</h4>
				</th>
				<?php
				foreach ($sondas_compara as $key => $id_sonda) {
					$id_th = 'th_'.$id_sonda;
					$fecha_sonda = $xxx->get_fecha_x_id($_SESSION['Empresa']['id'], $id_sonda);
				?>
				<th id="<?php echo $id_th; ?>" colspan="2" class="text-center expande" onclick="collapse(<?php echo "'".$id_th."','".$th."'"; ?>)"><h4><b><?php echo $fecha_sonda; ?></b></h4></th>
				<?php
				$th++;
				$th++;
				}
				?>
				<th rowspan="2" class="text-center">Lineal</th>
			</tr>
			<tr>
				<?php
				foreach ($sondas_compara as $key => $id_sonda) {
				?>
				<th class="text-center"><b>Promedio</b></th>
				<th class="text-center"><b>Porcentajes</b></th>
				<?php
				}
				?>
			</tr>
		</thead>
		<tbody>
			<?php 
			$y = new Sonda_pregunta();
			$z = new Sonda_user();
			$w = new Sonda_respuesta();
			
			$preguntas = $temas[$id_tema];
			$graf= $promedio_general = array();
			$ii = $yy = 0;
			$graf = $graf_barras_valores = $graf_barras_temas = array();
			$preguntas_general = '';

			foreach ($preguntas as $key => $value) {
				$y->select($value);
				$graf_barras_temas[] = trim($y->getPregunta());

				echo "<tr>";
				echo "<td style='min-width:500px; max-width:500px; white-space:normal;'><h5>". ++$key . ' ' . $y->getPregunta()."</h5></td>";
				foreach ($sondas_compara as $cont => $id_sonda) {
					$fecha_sonda = $xxx->get_fecha_x_id($_SESSION['Empresa']['id'], $id_sonda);
					$id_p = $y->getId();
					$preguntas_general .= $y->getId().',';
					$ids = $z->get_id_compara($_SESSION['Empresa']['id'], $id_sonda, $id_tema, $args);
					$promedio = $w->get_avg_x_pregunta($ids,$id_p);

					if($promedio == '')
						$promedio = 0;

					if($promedio != 0){
						$promedio_general[$id_sonda][$ii] = $promedio;
						$ii++;
					}
					
					$arrFechas[$id_sonda] = $fecha_sonda;
					$arrPromedios[$id_sonda][] = number_format($promedio, 2);
					$porcentajes = $w->get_percent_x_pregunta($ids,$id_p);
					$graf[$key.'|'.$y->getPregunta()][$fecha_sonda.'|'.$yy] = ($promedio != 0) ? number_format($promedio, 2) : $promedio;

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
			<th>Promedio General</th>
				<?php
					
					$filtros = ($filtros=="Todos") ? "" : $filtros;
					$filtros = str_replace(" ", "+", $filtros);
					$filtros = str_replace("/", "*", $filtros);
					$preguntas_general = substr($preguntas_general, 0, -1);
					$porcentajes_generales = '';
					$graf = array();
					$yy = 0;

					foreach ($sondas_compara as $cont => $id_sonda) {
						$p_gen = 0;
						$fecha_sonda = $xxx->get_fecha_x_id($_SESSION['Empresa']['id'], $id_sonda);
						$ids = $z->get_id_compara($_SESSION['Empresa']['id'], $id_sonda, '', $args);
						$porcentajes_generales = $w->get_percent($ids,$preguntas_general);

						if (array_key_exists($id_sonda, $promedio_general)) {
							if (is_array($promedio_general[$id_sonda])) {
								$p_gen = array_sum($promedio_general[$id_sonda])/sizeof($promedio_general[$id_sonda]);
							}
						}

						$graf[$id_sonda.'|'.'Promedio General'][$fecha_sonda.'|'.$yy] = ($p_gen != 0) ? number_format($p_gen, 2) : $p_gen;
						array_push($arrPromedios[$id_sonda], number_format($p_gen, 2));
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
						$yy++;
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
				<td><b>Grafico Comparativo General</b><img src='<?php echo BASEURL; ?>public/img/line-graph.png' width='40' height='40' style='cursor:pointer;margin-left: 20px;' onclick='graficoBarras(<?php echo json_encode($graf_barras_temas).','.json_encode($graf_barras_valores); ?>);' /></td>
				<?php
				foreach ($sondas_compara as $cont => $id_sonda) {
				?>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
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