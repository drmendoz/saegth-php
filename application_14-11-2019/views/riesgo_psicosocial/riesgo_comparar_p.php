<style type="text/css">
	.progress{height: 40px;}
	.progress-bar{
		font-size: 24px;
		padding-top: 8px;
		border-color: rgba(0, 0, 0, 0.3);
	}
	select {height: 120px !important}
	#area_seg{height: 400px !important}
	.f_fechas{width: 150px;}
	#mdl_body{
		min-width: 800px; 
		min-height: 400px;
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

	#mdl_body2{min-height: 600px; min-width: 1300px}
	@media screen and (min-width: 768px) {
		#myModal2 .modal-dialog {
			width: 1400px;
		}
	}
</style>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="<?php echo BASEURL ?>public/js/jquery.columnmanager.js" type="text/javascript" ></script>
<script type="text/javascript">
	$(document).ready(function(){
		var cols = [];
		for (var i = 4; i <= 500; i += 2) {
			cols.push(i);
		}

		$('#a_riesgo, #a_riesgo_res').addClass('active-parent active');
		$('#li_r_cres').addClass('activate');

		$('#tableall').columnManager({
            listTargetID:'targetall',
            saveState: false, colsHidden: cols
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
		var chart = new Highcharts.chart({
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
	        	renderTo: 'mdl_body2',
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
		
		chart.setSize(1350, 600);

		$('#myModal2').modal('show');
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
$promedio_general = array();
$graf_barras_valores = $graf_barras_temas = array();
$graf= $promedio_general = array();
$ii = $yy = 0;
$th = 4;
$pregunta = $preguntas_general = '';

if ($riesgos != '') {
	$riesgo->select_compara($_SESSION['Empresa']['id'], $riesgos);
	$seg = $riesgo->getSegmentacion();
	$riesgos_compara = $riesgo->getRiesgosCompara();
	$colspan = 3 + (count($riesgos_compara) * 2);
	$c_e=$z->get_evaluados($args,$riesgos,'C');
	$array_para_enviar_via_url = serialize($args);
	$array_para_enviar_via_url = urlencode($array_para_enviar_via_url);

	$x->select($id_tema);
	$objPregunta = $y->select_x_tema($id_tema);
}

?>
<h4>DIAGNÓSTICO DE RIESGO PSICOSOCIAL.- COMPARAR ENCUESTAS</h4>
<h4>Evaluados en proceso: <?php echo $c_e ?></h4>
<?php $util->_x('resultados','segmentacion'); ?>
<p><?php echo $filtros ?></p>
<br>
<div class="container-fluid my-own-class">
	<table id="tableall" class="table table-bordered table-hover consulta">
		<thead>
			<tr><th colspan="<?php echo $colspan; ?>"><h5><strong><a href="<?php echo BASEURL ?>riesgo_psicosocial/riesgo_comparar"><?php echo ucfirst($x->getTema()) ?>.-</a></strong> 	<?php echo $x->getDescripcion() ?></h5></th></tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<?php
				foreach ($riesgos_compara as $key => $id_riesgo) {
					$id_th = 'th_'.$id_riesgo;
					$fecha_riesgo = $riesgo->get_fecha_x_id($_SESSION['Empresa']['id'], $id_riesgo);
				?>
				<td id="<?php echo $id_th; ?>" colspan="2" class="text-center expande" onclick="collapse(<?php echo "'".$id_th."','".$th."'"; ?>)"><h4><b><?php echo $fecha_riesgo; ?></b></h4></td>
				<?php
					$th++;
					$th++;
				}
				?>
				<td class="text-center"><h4><b>Lineal</b></h4></td>
			</tr>
		</thead>
		<tbody>
		<?php
		if (is_array($objPregunta)) {
			foreach ($objPregunta as $key => $value) {
				$pregunta = $y->htmlprnt($value->pregunta);
				$id_pregunta = $value->id;
				$preguntas_general .= $id_pregunta.',';
				$graf_barras_temas[] = $pregunta;
		?>
			<tr>
				<td><?php echo ($key+1); ?></td>
				<td style="min-width: 550px;"><h5><span><?php echo $pregunta; ?></span></h5></td>
				<?php
				foreach ($riesgos_compara as $key => $id_riesgo) {
					$ids = $z->get_id_x_riesgo($args, $id_riesgo);
					$porcentaje = $w->get_percent($ids,$id_pregunta);
					$style = $w->get_color($porcentaje);
					$fecha_riesgo = $riesgo->get_fecha_x_id($_SESSION['Empresa']['id'], $id_riesgo);
					$graf[$key.'|'.$pregunta][$fecha_riesgo.'|'.$yy] = ($porcentaje != 0) ? number_format($porcentaje, 2) : $porcentaje;
					$arrFechas[$id_riesgo] = $fecha_riesgo;
					$arrPromedios[$id_riesgo][] = number_format($porcentaje, 2);

					$objPreg = $y->select($id_pregunta);
					$tbl_show = $y->getResults($ids);
				?>
				<td style="text-align:right;background-color: <?php echo $style; ?> ;min-width:80px;"><h4><?php echo $porcentaje; ?>%</h4></td>
				<td style="min-width: 600px;"><div><?php echo $tbl_show; ?></div></td>
				<?php
					$yy++;
				}
				?>
				<td class='text-center col-md-1'><img src='<?php echo BASEURL; ?>public/img/line-graph.png' width='40' height='40' style='cursor:pointer;' onclick='graficoLineal(<?php echo json_encode($graf); ?>);' /></td>
			</tr>
		<?php
				$graf = null;
			}
		}
		?>
			<tr>
				<th colspan="2"><h4>Promedio General</h4></th>
				<?php
				$graf = array();
				$yy = 0;
				$preguntas_general = substr($preguntas_general, 0, -1);

				foreach ($riesgos_compara as $key => $id_riesgo) {
					$ids = $z->get_id_x_riesgo($args, $id_riesgo);
					$porcentaje = number_format($w->get_percent($ids,$preguntas_general), 2);
					$style = $w->get_color($porcentaje);
					$fecha_riesgo = $riesgo->get_fecha_x_id($_SESSION['Empresa']['id'], $id_riesgo);
					$graf[$id_riesgo.'|'.'Promedio General'][$fecha_riesgo.'|'.$yy] = ($porcentaje != 0) ? number_format($porcentaje, 2) : $porcentaje;
					array_push($arrPromedios[$id_riesgo], number_format($porcentaje, 2));
				?>
				<td style="text-align:right;background-color: <?php echo $style; ?> ;min-width:80px;"><h4><?php echo $porcentaje; ?>%</h4></td>
				<td style="min-width: 600px;">&nbsp;</td>
				<?php
					$yy++;
				}
				?>
				<td class='text-center col-md-1'><img src='<?php echo BASEURL; ?>public/img/line-graph.png' width='40' height='40' style='cursor:pointer;' onclick='graficoLineal(<?php echo json_encode($graf); ?>);' /></td>
			</tr>
			<tr>
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
				<th colspan="2"><h4>Grafico Comparativo General<img src='<?php echo BASEURL; ?>public/img/line-graph.png' width='40' height='40' style='cursor:pointer;margin-left: 20px;' onclick='graficoBarras(<?php echo json_encode($graf_barras_temas).','.json_encode($graf_barras_valores); ?>);' /></h4></th>
				<?php
				foreach ($riesgos_compara as $key => $id_riesgo) {
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

<div class="modal fade bs-example-modal-lg" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">&nbsp;</h4>
      </div>
      <div class="modal-body" id="mdl_body2"></div>
    </div>
  </div>
</div>