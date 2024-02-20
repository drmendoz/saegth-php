<style type="text/css">
	.progress{height: 40px;}
	.progress-bar{
		font-size: 24px;
		padding-top: 8px;
		border-color: rgba(0, 0, 0, 0.3);
		width: calc(100%/3);
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
<script type="text/javascript">
	$(document).ready(function(){
		$('#a_sonda, #a_res').addClass('active-parent active');
		$('#li_his').addClass('activate');

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
if(isset($_SESSION['args']))
	$args=$_SESSION['args'];
else
	$args="";

$filtros = (isset($_SESSION['filtros'])) ? $_SESSION['filtros'] : "Todos" ;
$util = new Util();
echo '<h4>DIAGNÓSTICO DE CLIMA ORGANIZACIONAL.- RESULTADOS DE ENCUESTAS</h4>';
?>
<?php $util->_x('resultados','segmentacion'); ?>
<p><?php echo $filtros ?></p>
<div class="col-md-12">
	<?php $x = new Sonda_tema(); $x->select($id_tema); ?>
	<table class="table table-bordered table-hover" style="margin-top:50px">
		<tr><th colspan="4"><h4><strong><a href="<?php echo BASEURL ?>efectividad_departamental/resultados/<?php echo $id_s ?>"><?php echo ucfirst($x->getTema()) ?>.-</a></strong></h4><?php $x->getDescripcion() ?></th></tr>
		<?php 

		$xxx = new Efectividad_departamental();
		$xxx->select_($_SESSION['Empresa']['id'],$id_s);
		$temas = $xxx->getTemas();
		$nuevos_criterios = $xxx->getNuevosCriterios();
		$criterios_escala = $xxx->getCriteriosEscala();
		$criterios_barras_colores = $xxx->getCriteriosBarrasColores();
		$criterios_rango_barras = $xxx->getCriteriosRangoBarras();

		$y = new Sonda_pregunta();
		$z = new Sonda_user();
		$w = new Sonda_respuesta();
		$ids = $z->get_id_x_sonda($args, $_SESSION['Empresa']['id'],$id_s);
		$id_p = $id_p_general = '';
		$preguntas = $temas[$id_tema];
		$graf= $promedio_general = array();
		$graf_barras_valores = $graf_barras_temas = array();

		foreach ($preguntas as $key => $value) {
			$y->select($value);
			$graf_barras_temas[] = $y->getPregunta();

			echo "<tr>";
				echo "<td>". ++$key ."</td>";
				$id_p = $y->getId();
				$id_p_general .= $y->getId().',';
				echo "<td><h5>".$y->getPregunta()."</h5></td>";
				$promedio = $w->get_avg_x_pregunta($ids,$id_p,$nuevos_criterios);
				array_push($promedio_general, $promedio);

				if($nuevos_criterios == 0)
					$porcentajes = $w->get_percent_x_pregunta($ids,$id_p);
				else
					$porcentajes = $w->get_percent_x_pregunta_criterios($xxx,$ids,$id_p);
				
				$arrPromedios['ICO'][] = ($promedio != 0) ? number_format($promedio, 2) : $promedio;

				echo "<td class='text-center' style='background-color: ".$w->get_color($promedio)."'><h4>";
				printf("%.2f", $promedio);
				echo "</h4></td>";
				?>
				<td class="col-md-6">
					<table id="tblPorcentajes" border="0" width="100%">
						<?php
						if ($nuevos_criterios == 0) {
						
						?>
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
						<?php
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
						?>
					</table>
				</td>
			<?php
			echo "</tr>";

		}
		echo "<tr>";
			echo "<th colspan='2'><h4>Promedio General</h4></th>";
			$p_gen = array_sum($promedio_general)/sizeof($promedio_general);
			$id_p_general = substr($id_p_general, 0, -1);
			
			if($nuevos_criterios == 0)
				$porcentajes_g = $w->get_percent_x_pregunta($ids,$id_p_general);
			else
				$porcentajes_g = $w->get_percent_x_pregunta_criterios($xxx,$ids,$id_p_general);

			
			array_push($arrPromedios['ICO'], round($p_gen,2));
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

			echo "<td class='text-center' style='background-color: ".$w->get_color($p_gen)."'>";
			echo "<h4>";
			printf("%.2f", $p_gen);
			echo "</h4>";
			echo "</td>";
			?>
			<td>
				<table id="tblPorcentajes" border="0" width="100%">
					<?php
					if ($nuevos_criterios == 0) {
						
					?>
					<tr>
						<td width="90%">
							<div style="background-color: red;" data-width="<?php echo $porcentajes_g[0] ?>">
						</td>
						<td width="10%" style="text-align: right;"><h5><?php echo $porcentajes_g[0] ?>% </h5></td>
					</tr>
					<tr>
						<td width="90%">
							<div style="background-color: yellow;" data-width="<?php echo $porcentajes_g[1] ?>">
						</td>
						<td width="10%" style="text-align: right;"><h5><?php echo $porcentajes_g[1] ?>% </h5></td>
					</tr>
					<tr>
						<td width="90%">
							<div style="background-color: limegreen;" data-width="<?php echo $porcentajes_g[2] ?>">
						</td>
						<td width="10%" style="text-align: right;"><h5><?php echo $porcentajes_g[2] ?>% </h5></td>
					</tr>
					<tr>
						<td width="90%">
							<div style="background-color: silver;" data-width="<?php echo $porcentajes_g[3] ?>">
						</td>
						<td width="10%" style="text-align: right;"><h5><?php echo $porcentajes_g[3] ?>% </h5></td>
					</tr>
					<?php
					}
					else{
						if (is_array($criterios_barras_colores)) {
							foreach ($criterios_barras_colores as $key => $color) {
								if ($key > 0) {
									echo '<tr>';
										echo '<td width="90%">';
											echo '<div style="background-color: '.$color.';" data-width="'.$porcentajes_g[$key].'">';
										echo '</td>';
										echo '<td width="10%" style="text-align: right;"><h5>'.$porcentajes_g[$key].'% </h5></td>';
									echo '</tr>';
								}
							}

							echo '<tr>';
								echo '<td width="90%">';
									echo '<div style="background-color: '.$criterios_barras_colores[0].';" data-width="'.$porcentajes_g[0].'">';
								echo '</td>';
								echo '<td width="10%" style="text-align: right;"><h5>'.$porcentajes_g[0].'% </h5></td>';
							echo '</tr>';
						}
					}
					?>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2"><h4><b>Grafico Comparativo General</b><img src='<?php echo BASEURL; ?>public/img/line-graph.png' width='40' height='40' style='cursor:pointer;margin-left: 20px;' onclick='graficoBarras(<?php echo json_encode($graf_barras_temas).','.json_encode($graf_barras_valores); ?>);' /></h4></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
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