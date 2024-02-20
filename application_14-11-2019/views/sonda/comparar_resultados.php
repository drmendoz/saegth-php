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
		var arrSondas = $('#arrSondas').val();
		$('#TemaSonda').find('option:not(:first)').remove();
		if ($.isArray(arrSondas)) {
			$('#arrSondas option:selected').each(function(){ 
                $('#TemaSonda').append($('<option>', {
			        value: $(this).val(),
			        text : $(this).text()
			    }));
            });
		}

		var TemaSonda = <?= (isset($_SESSION['temaSonda']) && $_SESSION['temaSonda'] != "") ? $_SESSION['temaSonda'] : "''" ?>;
		var Temas = <?= (isset($_SESSION['temas']) && $_SESSION['temas'] != "") ? "'".$_SESSION['temas']."'" : "''" ?>;
		var explode = Temas.split(',');


		if(TemaSonda != ''){
			$('#TemaSonda option').each(function() {
			    if($(this).val() == TemaSonda) {
			        $(this).prop("selected", true);
			    }
			});

			$('#temas option').remove();
        	var holder = 'temas_x_sonda_ajax';
        	var config_ = {
				cache: true,
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8'
				}
			}
            $.post(AJAX + holder, {
              id_s: TemaSonda,
              config_
            }, function(response) {
            	var data = $.parseJSON(response);
				$.each(data, function(i, item) {
					var selected = '';
					if ($.isArray(explode)) {
		            	$.each(explode, function(ii, itm) {
		            		if(item.value == itm) {
						        selected = 'selected';
						    }
		            	});
		            }

					$('#temas')
						.append($("<option "+selected+"></option>")
						.attr("value",item.value)
						.text(item.text));
				});
            });
		}
		//
		$('#a_sonda, #a_res').addClass('active-parent active');
		$('#li_cres').addClass('activate');
		var cols = [];
		for (var i = 3; i <= 500; i += 2) {
			cols.push(i);
		}
		//console.log(cols);
		$('#tableall').columnManager({
            listTargetID:'targetall',
            saveState: false, colsHidden: cols
        });

        $("#tblPorcentajes tr td > div").each(function() {
		    $(this).animate({
				width: $(this).data("width")+"%"
			}, 100);
		});

        $('#arrSondas').change(function(){
        	var arrSondas = $('#arrSondas').val();
			$('#TemaSonda').find('option:not(:first)').remove();
    		if ($.isArray(arrSondas)) {
    			$('#arrSondas option:selected').each(function(){ 
                    $('#TemaSonda').append($('<option>', {
				        value: $(this).val(),
				        text : $(this).text()
				    }));
                });
    		}
        });

        $('#TemaSonda').change(function(){
        	if ($(this).val() != '') {
        		$('#temas option').remove();
	        	var holder = 'temas_x_sonda_ajax';
	        	var config_ = { 
					cache: true,
					headers: {
						'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8'
					}
				}
	            $.post(AJAX + holder, {
	              id_s: $(this).val(),
	              config_
	            }, function(response) {
	            	var data = $.parseJSON(response);
					$.each(data, function(i, item) {
						$('#temas').append($('<option>', {
					        value: item.value,
					        text : item.text
					    }));
					});
	            });
        	}
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
$sonda = new Sonda();
$w = new Sonda_respuesta();
$x = new Sonda_tema();
$y = new Sonda_pregunta();
$z = new Sonda_user();
$util = new Util();

$promedio_general = array();
$c_e = '';
$th = 3;

if ($sondas != '') {
	$sonda->select_compara($_SESSION['Empresa']['id'], $sondas);
	$seg = $sonda->getSegmentacion();
	$sondas_compara = $sonda->getSondasCompara();
	$c_e=$z->get_evaluados($args,$sondas,'C');
	$temas = $sonda->getTemas();
}

?>
<h4>DIAGNÓSTICO DE CLIMA ORGANIZACIONAL.- COMPARAR ENCUESTAS</h4>
<form action="<?php echo BASEURL.'sonda/comparar_resultados' ?>" method="POST">
	<h4>
		<a class="btn btn-default" data-toggle="collapse" href="#collapseEncuentas" aria-expanded="false" aria-controls="collapseEncuentas">Filtrar encuestas</a>
		<a class="btn btn-default" id="temaEncuesta" data-toggle="collapse" href="#collapseTemasEncuentas" aria-expanded="false" aria-controls="collapseTemasEncuentas">Filtrar temas encuesta</a>
		<a class="btn btn-default" data-toggle="collapse" href="#collapseTemas" aria-expanded="false" aria-controls="collapseTemas">Filtrar temas</a>
	</h4>
	<div class="collapse" id="collapseEncuentas" style="width: 200px;">
		<div class="well">
			<select multiple name="sondas[]" id="arrSondas" class="form-control clase">
				<option style="display:none">Seleccione una opción</option>
				<?php
				$sonda->get_Sondas_Empresa($_SESSION['Empresa']['id'], '', $arrSondas);
				?>
			</select>
		</div>
	</div>
	<div class="collapse" id="collapseTemasEncuentas" style="width: 250px;">
		<div class="well">
			<select name="TemaSonda" id="TemaSonda" class="form-control">
				<option value="">Seleccione una opción</option>
			</select>
		</div>
	</div>
	<div class="collapse" id="collapseTemas" style="width: 400px;">
		<div class="well">
			<select multiple name="temas[]" id="temas" class="form-control">
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

<?php if ($sondas != '') { ?>
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
				foreach ($sondas_compara as $key => $id_sonda) {
					$id_th = 'th_'.$id_sonda;
					$fecha_sonda = $sonda->get_fecha_x_id($_SESSION['Empresa']['id'], $id_sonda);
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
				<th class="text-center col_porc"><b>Porcentajes</b></th>
				<?php
				}
				?>
			</tr>
		</thead>
		<tbody>
			<?php 
			$xls_prep;
			$ii = $yy = $zz = 0;
			$graf = $graf_barras_valores = $graf_barras_temas = array();
			$preguntas = $preguntas_general = '';

			foreach ($temas as $key => $value) {
				if (isset($arrTemas) && is_array($arrTemas)) {
					if (in_array($key, $arrTemas)) {
						$x->select($key);				
						$tema_nombre = $xls_prep[$key]['tema'] = ucfirst($x->getTema());
						$tema_id = $x->getId();
						$graf[$key.'|'.$tema_nombre] = array();
						$graf_barras_temas[] = $tema_nombre;

						echo "<tr>";
						echo "<td style='min-width:500px; max-width:500px; white-space:normal;'><h4><strong><a href='".BASEURL."sonda/compara_resultados_pregunta/".$tema_id."'>".$tema_nombre."</a></strong></h4>";
						echo "<h5>".$x->getDescripcion()."</h5></td>";

						foreach ($sondas_compara as $cont => $id_sonda) {
							$fecha_sonda = $sonda->get_fecha_x_id($_SESSION['Empresa']['id'], $id_sonda);
							$preguntas = implode(",", $temas[$key]);
							$preguntas_general .= implode(",", $temas[$key]).',';
							$ids = $z->get_id_compara($_SESSION['Empresa']['id'], $id_sonda, $key, $args);
							$promedio = $w->get_avg_x_tema($ids,$preguntas);

							if($promedio == '')
								$promedio = 0;
							
							if($promedio != 0){
								$promedio_general[$id_sonda][$ii] = $promedio;
								$ii++;
							}

							$arrFechas[$id_sonda] = $fecha_sonda;
							$arrPromedios[$id_sonda][] = number_format($promedio, 2);

							$porcentajes = $xls_prep[$key]['porcentajes'] = $w->get_percent($ids,$preguntas);
							$graf[$key.'|'.$tema_nombre][$fecha_sonda.'|'.$yy] = ($promedio != 0) ? number_format($promedio, 2) : $promedio;

							echo "<td class='text-center' style='background-color: ".$w->get_color($promedio)."'><h4>";
							printf("%.2f", $promedio);
							echo "</h4></td>";

							echo "<td style='min-width: 400px;'>";
								echo '<table id="tblPorcentajes" border="0" width="100%">';
									echo "<tr>";
										echo '<td width="90%">';
											echo '<div style="background-color: red;" data-width="'.$porcentajes[0].'">';
										echo "</td>";
										echo '<td width="10%" style="text-align: right;"><h5>'.$porcentajes[0].'% </h5></td>';
									echo "</tr>";
									echo "<tr>";
										echo '<td width="90%">';
											echo '<div style="background-color: yellow;" data-width="'.$porcentajes[1].'">';
										echo "</td>";
										echo '<td width="10%" style="text-align: right;"><h5>'.$porcentajes[1].'% </h5></td>';
									echo "</tr>";
									echo "<tr>";
										echo '<td width="90%">';
											echo '<div style="background-color: limegreen;" data-width="'.$porcentajes[2].'">';
										echo "</td>";
										echo '<td width="10%" style="text-align: right;"><h5>'.$porcentajes[2].'% </h5></td>';
									echo "</tr>";
									echo "<tr>";
										echo '<td width="90%">';
											echo '<div style="background-color: silver;" data-width="'.$porcentajes[3].'">';
										echo "</td>";
										echo '<td width="10%" style="text-align: right;"><h5>'.$porcentajes[3].'% </h5></td>';
									echo "</tr>";
								echo "</table>";
							echo "</td>";
						
							$yy++;
						}

							echo "<td class='text-center'><img src='".BASEURL."public/img/line-graph.png' width='40' height='40' style='cursor:pointer;' onclick='graficoLineal(".json_encode($graf).");' /></td>";
						echo "</tr>";
						$graf = null;
					}
				}else{
					$x->select($key);				
					$tema_nombre = $xls_prep[$key]['tema'] = ucfirst($x->getTema());
					$tema_id = $x->getId();
					$graf[$key.'|'.$tema_nombre] = array();
					$graf_barras_temas[] = $tema_nombre;

					echo "<tr>";
					echo "<td style='min-width:500px; max-width:500px; white-space:normal;'><h4><strong><a href='".BASEURL."sonda/compara_resultados_pregunta/".$tema_id."'>".$tema_nombre."</a></strong></h4>";
					echo "<h5>".$x->getDescripcion()."</h5></td>";

					foreach ($sondas_compara as $cont => $id_sonda) {
						$fecha_sonda = $sonda->get_fecha_x_id($_SESSION['Empresa']['id'], $id_sonda);
						$preguntas = implode(",", $temas[$key]);
						$preguntas_general .= implode(",", $temas[$key]).',';
						$ids = $z->get_id_compara($_SESSION['Empresa']['id'], $id_sonda, $key, $args);
						$promedio = $w->get_avg_x_tema($ids,$preguntas);

						if($promedio == '')
							$promedio = 0;
						
						if($promedio != 0){
							$promedio_general[$id_sonda][$ii] = $promedio;
							$ii++;
						}

						$arrFechas[$id_sonda] = $fecha_sonda;
						$arrPromedios[$id_sonda][] = number_format($promedio, 2);

						$porcentajes = $xls_prep[$key]['porcentajes'] = $w->get_percent($ids,$preguntas);
						$graf[$key.'|'.$tema_nombre][$fecha_sonda.'|'.$yy] = ($promedio != 0) ? number_format($promedio, 2) : $promedio;

						echo "<td class='text-center' style='background-color: ".$w->get_color($promedio)."'><h4>";
						printf("%.2f", $promedio);
						echo "</h4></td>";

						echo "<td style='min-width: 400px;'>";
							echo '<table id="tblPorcentajes" border="0" width="100%">';
								echo "<tr>";
									echo '<td width="90%">';
										echo '<div style="background-color: red;" data-width="'.$porcentajes[0].'">';
									echo "</td>";
									echo '<td width="10%" style="text-align: right;"><h5>'.$porcentajes[0].'% </h5></td>';
								echo "</tr>";
								echo "<tr>";
									echo '<td width="90%">';
										echo '<div style="background-color: yellow;" data-width="'.$porcentajes[1].'">';
									echo "</td>";
									echo '<td width="10%" style="text-align: right;"><h5>'.$porcentajes[1].'% </h5></td>';
								echo "</tr>";
								echo "<tr>";
									echo '<td width="90%">';
										echo '<div style="background-color: limegreen;" data-width="'.$porcentajes[2].'">';
									echo "</td>";
									echo '<td width="10%" style="text-align: right;"><h5>'.$porcentajes[2].'% </h5></td>';
								echo "</tr>";
								echo "<tr>";
									echo '<td width="90%">';
										echo '<div style="background-color: silver;" data-width="'.$porcentajes[3].'">';
									echo "</td>";
									echo '<td width="10%" style="text-align: right;"><h5>'.$porcentajes[3].'% </h5></td>';
								echo "</tr>";
							echo "</table>";
						echo "</td>";
					
						$yy++;
					}

						echo "<td class='text-center'><img src='".BASEURL."public/img/line-graph.png' width='40' height='40' style='cursor:pointer;' onclick='graficoLineal(".json_encode($graf).");' /></td>";
					echo "</tr>";
					$graf = null;
				}
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

					foreach ($sondas_compara as $cont => $id_sonda) {
						$p_gen = 0;
						$fecha_sonda = $sonda->get_fecha_x_id($_SESSION['Empresa']['id'], $id_sonda);
						$ids = $z->get_id_compara($_SESSION['Empresa']['id'], $id_sonda, '', $args);
						$porcentajes_generales = $w->get_percent($ids,$preguntas_general);
						

						if (array_key_exists($id_sonda, $promedio_general)) {
							if (is_array($promedio_general[$id_sonda])) {
								$p_gen = array_sum($promedio_general[$id_sonda])/sizeof($promedio_general[$id_sonda]);
							}
						}

						array_push($arrPromedios[$id_sonda], number_format($p_gen, 2));

						$graf[$id_sonda.'|'.'Promedio General'][$fecha_sonda.'|'.$yy] = ($p_gen != 0) ? number_format($p_gen, 2) : $p_gen;
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
						<tr>
							<td width="90%">
								<div style="background-color: silver;" data-width="<?php echo $porcentajes_generales[3] ?>">
							</td>
							<td width="10%" style="text-align: right;"><h5><?php echo $porcentajes_generales[3] ?>% </h5></td>
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

			$array_para_enviar_via_url = serialize($arrTemas);
			$array_para_enviar_via_url = urlencode($array_para_enviar_via_url);
			?>
			<tr>
				<th><h4>Grafico Comparativo General<img src='<?php echo BASEURL; ?>public/img/line-graph.png' width='40' height='40' style='cursor:pointer;margin-left: 20px;' onclick='graficoBarras(<?php echo json_encode($graf_barras_temas).','.json_encode($graf_barras_valores); ?>);' /></h4></th>
				<?php
				foreach ($sondas_compara as $cont => $id_sonda) {
				?>
				<td>&nbsp;</td>
				<td class="text-center">
					<div class="btn-group">
						<a href="<?php echo BASEURL ?>sonda/top/<?php echo $id_sonda; ?>/DESC" class="btn btn-default">Mejor puntaje</a>
						<a href="<?php echo BASEURL ?>sonda/top/<?php echo $id_sonda; ?>/ASC" class="btn btn-default">Peor puntaje</a>
						<a href="<?php echo BASEURL ?>pdf/sonda_compara/<?php echo $id_sonda; ?>/'<?php echo $filtros."/".$array_para_enviar_via_url ?>" class="btn btn-default">Generar reporte</a>
						<a href="<?php echo BASEURL ?>pdf/sonda_xls_compara/<?php echo $id_sonda."/".$array_para_enviar_via_url ?>" class="btn btn-default">Descargar en excel</a>
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