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

	@media screen and (min-width: 768px) {
		#myModal2 .modal-dialog {
			width: auto;
			max-width: 80%;
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

		$('table.consulta').columnManager({
            listTargetID:'targetall',
            saveState: false, colsHidden: cols
        });
	});

	function collapse(table, id, cont) {

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
            $('#' + table).showColumns([x], opt);
            $('#'+id).removeClass('expande').addClass('contrae');
        } else {
            $('#' + table).hideColumns([x], opt);
            $('#'+id).removeClass('contrae').addClass('expande');
        }
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
	            text: '<b>Comparar Preguntas</b>',
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
		
		//chart.setSize(1350, 800);
		$('#mdl_body2').resizable({
	        resize: function () {
	            chart.setSize(
	                this.offsetWidth - 20,
	                this.offsetHeight - 20,
	                false
	            );
	        }
	    });

		$('#myModal2').modal('show');
	}
</script>
<?php
$rendimiento = new Rendimiento();
$riesgo = new Riesgo_psicosocial();
$w = new Rp_respuesta();
$x = new Rp_tema();
$y = new Rp_pregunta();
$z = new Rp_user();
$util = new Util();
?>
<h4>DIAGNÓSTICO DE RIESGO PSICOSOCIAL.- GRUPOS CRITICOS</h4>
<br>
<form action="<?php echo BASEURL.'riesgo_psicosocial/grupos_criticos' ?>" method="POST">
	<h4><a class="btn btn-default" data-toggle="collapse" href="#collapseEncuentas" aria-expanded="false" aria-controls="collapseEncuentas">Mostrar Encuestas</a></h4>
	<div class="collapse" id="collapseEncuentas" style="width: 200px;">
		<div class="well">
			<select multiple name="riesgos[]" class="form-control">
				<option style="display:none">Seleccione una opción</option>
				<?php
				$riesgo->get_Riesgos_Empresa($_SESSION['Empresa']['id'], 'S', $arrRiesgos);
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
if (is_array($arrRiesgos)) {
	$riesgo->setId_empresa($_SESSION['Empresa']['id']);
	$riesgo->select_last();
	$seg = $riesgo->getSegmentacion();
	$ids = $z->get_id_x_riesgo('', $riesgo->getId());
	$temas = $x->select_all_();
	$last_id = $riesgo->getId();

	$preguntas = '';
	$pagina = "promedios_bajos";
	$colspan = 1;
	$c_e = '';

	$rendimiento->getGrupos_rp($_SESSION['Empresa']['id'], $seg);
	
	foreach ($temas as $key => $value) {
		$id_tema = $value['id'];
		$preguntas = $y->select_ids_x_tema($id_tema);
		//$rendimiento->calculo_prom_bajos_rp($ids,$id_tema,$preguntas);
		$rendimiento->getGruposTemas_rp($id_tema,$preguntas);
	}
	
	$rendimiento->getPromediosBajos_rp($_SESSION['Empresa']['id']);
	//$rendimiento->promedios_bajos_rp($_SESSION['Empresa']['id']);
	//
	if (is_array($rendimiento->arrDatos)) {
		$i = 1;
		foreach ($rendimiento->arrDatos as $key => $arrValores) {
			$unserialize = unserialize($key);
			$collapseExample = 'collapseExample'.$i;
			$table = 'tableall_'.$i;
			foreach ($unserialize as $tipo => $valor) {
				if ($tipo != 'c_e') {
					$filtro["tipo"] = $tipo;
					$filtro["valor"] = $valor;
					$rendimiento->filtros_criterios($filtro);
					$rendimiento->get_criterios('RP');
				}else{
					$c_e = $unserialize['c_e'];
				}
			}
			$rendimiento->resetVariables();
			$args = $rendimiento->getArgs();
			$graf_barras_valores = $graf_barras_temas = $arrPromedios = array();
			$th = 3;
?>
<a class="btn btn-default" data-toggle="collapse" href="#<?php echo$collapseExample; ?>" aria-expanded="false" aria-controls="<?php echo$collapseExample; ?>">Mostrar filtros</a>
<h4>Evaluados en proceso: <?php echo $c_e; ?></h4>
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
			<div class="panel-heading">Hijos</div>
			<div class="panel-body">
				<select multiple name="hijos[]" class="form-control">
					<option style="display:none">Seleccione una opción</option>
					<option value="0" <?php if (in_array(0, $rendimiento->getHijos())): echo "selected='selected'"; endif ?>>Si</option>
					<option value="1" <?php if (in_array(1, $rendimiento->getHijos())): echo "selected='selected'"; endif ?>>No</option>
					<option value="2" <?php if (in_array(2, $rendimiento->getHijos())): echo "selected='selected'"; endif ?>>N/E</option>
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
<table id="<?php echo $table; ?>" class="table table-bordered consulta" style="margin-top:50px">
	<thead>
		<tr>
			<th><h4><?php $util->_x('resultados','titulo2'); ?></h4></th>
			<?php
			foreach ($arrRiesgos as $key => $id_riesgo) {
				$id_th = 'th_'.$id_riesgo.'_'.$i;
				$fecha_riesgo = $riesgo->get_fecha_x_id($_SESSION['Empresa']['id'], $id_riesgo);
				$arrFechas[$id_riesgo] = $fecha_riesgo;
			?>
			<th id="<?php echo $id_th; ?>" colspan="2" class="text-center expande" onclick="collapse(<?php echo "'".$table."','".$id_th."','".$th."'"; ?>)"><h4><b><?php echo $fecha_riesgo; ?></b></h4></th>
			<?php
			$th++;
			$th++;
			$colspan+=2;
			}
			?>
		</tr>
	</thead>
	<tbody>
	<?php
	foreach ($arrValores as $id_tema => $arrTema) {
		$x->select($id_tema);
		$tema_nombre = ucfirst($x->getTema());
		$arrUsers = $arrTema['id_rp_user'];
		$ids = implode(',', $arrUsers);
		$arrPreguntas = $arrTema['preguntas'];
		//
		echo "<tr>";
			echo "<td colspan='$colspan'>";
			echo "<h4><strong><a style='cursor:pointer;'>".$tema_nombre."</a></strong></h4>";
			echo "</td>";
		echo "</tr>";
		//
		if (is_array($arrPreguntas)) {
			foreach ($arrPreguntas as $key => $id_preg) {
				$key++;
				$y->select($id_preg);
				$graf_barras_temas[] = $y->getPregunta();
				echo "<tr>";
					echo '<td style="min-width:450px; white-space:normal;">';
						echo "<h5 style='margin-left:10px;'>".$key." - ".$y->getPregunta()."</h5>";
					echo '</td>';
					//
					foreach ($arrRiesgos as $key => $id_riesgo) {
						//$ids = $z->get_id_x_riesgo($args, $id_riesgo);
						$porcentaje = $w->get_percent($ids,$id_preg);
						$arrPromedios[$id_riesgo][] = number_format($porcentaje, 2);
						$style = $w->get_color($porcentaje);
						$objPreg = $y->select($id_preg);
						$tbl_show = $y->getResults($ids);
						//
						echo '<td style="text-align:right;background-color:'.$style.';min-width:80px;"><h4>'.$porcentaje.'%</h4></td>';
						echo '<td style="min-width: 500px;"><div>'.$tbl_show.'</div></td>';
					}
				echo "</tr>";
			}
		}
	}

	$arrTot['fecha'] = null;
	$arrTot['arrValores'] = null;
	if (is_array($arrFechas) && is_array($arrPromedios)) {
		foreach ($arrFechas as $id_riesgo => $fecha) {
			$arrTot['fecha'] = $fecha;
			$arrTot['arrValores'] = $arrPromedios[$id_riesgo];
			array_push($graf_barras_valores, $arrTot);
		}
	}
	?>
		<tr>
			<td colspan="<?php echo $colspan ?>">
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
$array_para_enviar_via_url = serialize($arrRiesgos);
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