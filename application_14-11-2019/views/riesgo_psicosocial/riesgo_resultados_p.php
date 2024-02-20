<style type="text/css">
	.skin_row{
		width: 10px
	}
    #mdl_body{min-height: 600px; min-width: 1300px}
	@media screen and (min-width: 768px) {
		#myModal .modal-dialog {
			width: 1400px;
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
	        	min: 10,
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
		
		$('#myModal').modal('show');
	}
</script>
<?php 
	$x = new Rp_tema();
	$x->select($id_tema);
	$y=new rp_pregunta();
	$util = new Util();
	$w = new Rp_respuesta();

	if(isset($_SESSION['RR']['args']))
		$args = $_SESSION['RR']['args'];
	else
		$args = "";

	if(isset($_SESSION['RR']['filtros']))
		$filtros = $_SESSION['RR']['filtros'];
	else
		$filtros = "";

	$z = new Rp_user();
	$ids = $z->get_id_x_riesgo($args, $id_riesgo);
	$c_e=$z->get_evaluados($args,$id_riesgo);

	$y = new Rp_pregunta();
	
	$pregunta = $preguntas_general = '';
	$preguntas = $y->select_x_tema_($id_tema, $ids);
	$promedio_general = array();
	$graf_barras_valores = $graf_barras_temas = array();
?>
<h4>DIAGNÓSTICO DE RIESGO PSICOSOCIAL.- RESULTADOS DE ENCUESTAS</h4>
<h4>Evaluados en proceso: <?php echo $c_e ?></h4>
<?php $util->_x('resultados','segmentacion'); ?>
<p><?php echo $filtros ?></p>
<br>
<div class="col-md-12">
	<table class="table table-bordered table-hover">
		<tr><th colspan="4"><h5><strong><a href="<?php echo BASEURL ?>riesgo_psicosocial/riesgo_resultados/<?php echo $id_riesgo ?>"><?php echo ucfirst($x->getTema()) ?>.-</a></strong> 	<?php echo $x->getDescripcion() ?></h5></th></tr>
		<?php
		if (is_array($preguntas)) {
			foreach ($preguntas as $key => $value) {
				$id_pregunta = $value['id'];
				$pregunta = $value['pregunta'];
				$preguntas_general .= $id_pregunta.',';
				$style = $value['style'];
				$porcentaje = $value['porcentaje'];
				array_push($promedio_general, $porcentaje);
				$graf_barras_temas[] = $pregunta;
				$arrPromedios['IRSP'][] = ($porcentaje != 0) ? number_format($porcentaje, 2) : $porcentaje;
				$objPregunta = $y->select($value['id']);
				$tbl_show = $y->getResults($ids);
		?>
		<tr>
			<td><?php echo ($key+1); ?></td>
			<td><h5><span><?php echo $pregunta; ?></span></h5></td>
			<td style="text-align:right;background-color: <?php echo $style; ?>"><h4><?php echo $porcentaje; ?>%</h4></td>
			<td width="600px"><div><?php echo $tbl_show; ?></div></td>
		</tr>
		<?php
			}
		}
		?>
		<tr>
			<td colspan="2"><h4>Promedio General</h4></td>
			<?php
			//$p_gen = @(array_sum($promedio_general)/sizeof($promedio_general));
			//$p_gen = number_format($p_gen, 2);
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
			<td style="text-align:right;background-color: <?php echo $color; ?>"><h4><?php echo $p_gen; ?>%</h4></td>
			<td></td>
		</tr>
		<tr>
			<td colspan="4"><h4><b>Grafico Comparativo General</b><img src='<?php echo BASEURL; ?>public/img/line-graph.png' width='40' height='40' style='cursor:pointer;margin-left: 20px;' onclick='graficoBarras(<?php echo json_encode($graf_barras_temas).','.json_encode($graf_barras_valores); ?>);' /></h4></td>
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