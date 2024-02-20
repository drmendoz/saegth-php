	
<?php $meth = new scorecard(); ?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<style type="text/css">
	#equalizer p {
		height: 50px;
	}
	.eq_val{
		width: 100px;
		padding: 20px;
	}
	select[multiple=""]{height: 200px !important;	}
</style>
<div class="col-md-12">
	<a class="btn btn-default" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Mostrar filtros</a>
	<div class="collapse" id="collapseExample">
		<div class="well">
			<form  action="<?php echo BASEURL.'test/matriz' ?>" method="POST">
				<div class="col-md-12">
					<select name="previos" class="form-control">
						<option value="" style="display:none">Filtros anteriores</option>
						<?php  
						$mf = new matriz_filtros();
						$mf->get_select_options($_SESSION['Empresa']['id']);
						?>
					</select>
					<input type="submit" name="previos_btn" value="Buscar">
				</div>				
				<!-- AREAS -->
				<div class="panel panel-success col-md-4 no-padding">
					<div class="panel-heading">&Aacute;reas</div>
					<div class="panel-body">
						<select name="areas[]" multiple="" class="form-control">
							<?php
							$test = new Empresa_area();
							$test->get_select_options($_SESSION['Empresa']['id']);
							?>
							<?php //foreach ($areas as $key => $value) { $value=reset($value); ?>
							<!-- <option value="<?php //echo $value['id'] ?>" <?php //if(isset($_POST['areas'])){ if(in_array($value['id'], $_POST['areas'])) //echo "selected";} ?>><?php //echo  $meth->htmlprnt($value['nombre']); ?></option> -->
							<?php //} ?>
						</select>
					</div>
				</div>
				<!-- LOCALIDADES -->
				<div class="panel panel-success col-md-4 no-padding">
					<div class="panel-heading">Localidades</div>
					<div class="panel-body">
						<select name="localidades[]" multiple="" class="form-control">
							<?php
							$test = new Empresa_local();
							$test->get_select_options($_SESSION['Empresa']['id']);
							?>
						</select>
					</div>
				</div>
				<!-- CARGOS -->
				<div class="panel panel-success col-md-4 no-padding">
					<div class="panel-heading">Cargos</div>
					<div class="panel-body">
						<select name="cargos[]" multiple="" class="form-control">
							<?php foreach ($cargos as $key => $value) { $value=reset($value); ?>
							<option value="<?php echo $value['id'] ?>" <?php if(isset($_POST['cargos'])){ if(in_array($value['id'], $_POST['cargos'])) echo "selected";} ?>><?php echo  $meth->htmlprnt($value['nombre']); ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<!-- NIVELES ORGANIZACIONALES -->
				<div class="panel panel-success col-md-4 no-padding">
					<div class="panel-heading">Niveles Organizacionales</div>
					<div class="panel-body">
						<select name="norgs[]" multiple="" class="form-control">
							<?php foreach ($norgs as $key => $value) { $value=reset($value); ?>
							<option value="<?php echo $value['id'] ?>" <?php if(isset($_POST['norgs'])){ if(in_array($value['id'], $_POST['norgs'])) echo "selected";} ?>><?php echo  $meth->htmlprnt($value['nombre']); ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<!-- TIPOS DE CONTRATO -->
				<div class="panel panel-success col-md-4 no-padding">
					<div class="panel-heading">Tipos de contrato</div>
					<div class="panel-body">
						<select name="tconts[]" multiple="" class="form-control">
							<?php foreach ($tconts as $key => $value) { $value=reset($value); ?>
							<option value="<?php echo $value['id'] ?>" <?php if(isset($_POST['tconts'])){ if(in_array($value['id'], $_POST['tconts'])) echo "selected";} ?>><?php echo  $meth->htmlprnt($value['nombre']); ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				
				<div class="clearfix"></div>
				<div class="text-center"><input type="submit" value="Filtrar" name="filtro" class="btn btn-sm btn-default"> </div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div> 
	<div class="clearfix"></div>
	<p><h3>Filtros:</h3><?php if(isset($filtros)){ if($filtros == "") echo "Ninguno"; else echo $filtros; }else echo "Ninguno";  ?><p>
		<hr>
		<h3 id="prompt_result"><?php echo $g_filtro ?></h3>
		<div id="equalizer" style="overflow-x:auto">
			<table>
				<tr>
					<?php 
					if(isset($resultados)){ 
						foreach ($resultados as $key => $value) { 
							$per = $value; 
							$matval = $meth->get_matriz($per['id']);?>
							<td class="eq_val">
								<p class="matval"><?php echo $matval ?></p>
								<input hidden class="matval form-control" type="hidden" name="matval[]" value="<?php echo $matval ?>"/>
								<input hidden type="text" name="id[]" value="<?php echo $per['id']; ?>"/>
								<div class="progress">
									<div class="progress-bar progress-bar-default slider-range-min"><?php echo $matval ?></div>
								</div>
								<p><?php echo $meth->htmlprnt($per['nombre']); ?></p>
							</td>
							<?php	}	
						} ?>    
					</tr>
				</table>
				<div class="clearfix"></div>
			</div>
			<div class="clearfix"></div>
			<div class="text-center">
				<?php if (isset($_SESSION['matriz']['filtro'])) { ?>
				<div style="margin: 15px 0"><input id="prompt_button" type="checkbox" value="1" name="g_filtro"> Guardar filtro</div>
				<br>
				<?php } ?>
				<input type="submit" value="Guardar y actualizar matriz" name="guardar" class="btn btn-sm btn-info"> 
			</div>
			<div class="clearfix"></div>
		</form>
		<div class="col-md-6"> 
			<div id="chart_div" style="width: 600px; height: 600px; position: relative; z-index:500"></div>
		</div> 
		<div class="col-md-6"> 
			<div style="width: 600px; height: 600px; position: relative; z-index:500">
				<svg x="0px" y="0px" width="600px" height="600px" viewBox="0 0 600 600" enable-background="new 0 0 600 600" xml:space="preserve">
					<text text-anchor="start" x="115" y="92.05" font-family="Arial" font-size="13" font-weight="bold" stroke="none" stroke-width="0" fill="#000000">GU&Iacute;A</text>
					<rect x="115" y="115" fill="#FFFFFF" fill-opacity="0" width="371" height="371"/>
					<g>
						<defs>
							<rect id="SVGID_1_" x="115" y="115" width="371" height="371"/>
						</defs>
						<clipPath id="SVGID_2_">
							<use xlink:href="#SVGID_1_"  overflow="visible"/>
						</clipPath>
						<g clip-path="url(#SVGID_2_)">
							<g>
								<rect x="115" y="115" fill="#CCCCCC" width="1" height="371"/>
								<rect x="239" y="115" fill="#CCCCCC" width="1" height="371"/>
								<rect x="361" y="115" fill="#CCCCCC" width="1" height="371"/>
								<rect x="485" y="115" fill="#CCCCCC" width="1" height="371"/>
								<rect x="115" y="485" fill="#CCCCCC" width="371" height="1"/>
								<rect x="115" y="362" fill="#CCCCCC" width="371" height="1"/>
								<rect x="115" y="238" fill="#CCCCCC" width="371" height="1"/>
								<rect x="115" y="115" fill="#CCCCCC" width="371" height="1"/>
							</g>
							<g>
								<rect x="115" y="115" fill="#333333" width="1" height="371"/>
								<rect x="115" y="485" fill="#333333" width="371" height="1"/>
							</g>
						</g>
					</g>
					<text transform="matrix(1 0 0 1 126.5 181.5)" font-family="'Arial'" font-size="12">CRÉDITO PASADO</text>
					<text transform="matrix(1 0 0 1 252.5 182.5)" font-family="'Arial'" font-size="12">ALTO POTENCIAL</text>
					<text transform="matrix(1 0 0 1 389.5 182.5)" font-family="'Arial'" font-size="12">ESTRELLAS</text>
					<text transform="matrix(1 0 0 1 125.8252 287.5)"><tspan x="0" y="0" font-family="'Arial'" font-size="12">TALENTO MAL</tspan><tspan x="10.339" y="28.8" font-family="'Arial'" font-size="12">UTILIZADO</tspan></text>
					<text transform="matrix(1 0 0 1 257.5 301.5)" font-family="'Arial'" font-size="12">JUGADOR ÚTIL</text>
					<text transform="matrix(1 0 0 1 374.5 301.5)" font-family="'Arial'" font-size="12">ALTO POTENCIAL</text>
					<text transform="matrix(1 0 0 1 129.5 423.5)" font-family="'Arial'" font-size="12">DESCARRILADO</text>
					<text transform="matrix(1 0 0 1 263.5 411.5)"><tspan x="0" y="0" font-family="'Arial'" font-size="12">EFECTIVO Y</tspan><tspan x="0" y="28.8" font-family="'Arial'" font-size="12">CONFIABLE</tspan></text>
					<text transform="matrix(1 0 0 1 366.5 423.5)" font-family="'Arial'" font-size="12">ALTO PROFESIONAL</text>
					<g>
						<text transform="matrix(1 0 0 1 265.4512 558.0498)" fill="#222222" font-family="'Arial'" font-style="italic" font-size="13">Desempeño</text>
					</g>
					<g>
						
						<text transform="matrix(6.123234e-017 -1 1 6.123234e-017 36.0498 327.2393)" fill="#222222" font-family="'Arial'" font-style="italic" font-size="13">Potencial</text>
					</g>
				</svg>
			</div>
		</div> 
		<div class="clearfix"></div>
		<div class="col-md-12">
			<div>
				<a href="<?php echo BASEURL.'img/CLC_Guidelines_for_Using_a_Nine_Box_Matrix.pdf' ?>" target="_blank"  class="btn btn-default btn-label-left pull-right">
					<span>
						<i class="fa fa-file"></i>
					</span>
					Descargar guía
				</a> 
			</div>
			<div class="clearfix"></div>
			<div>
				<a href="<?php echo BASEURL.'img/WhatMakesAHigh-Potential_GL_BLG_USeng.pdf' ?>" target="_blank"  class="btn btn-default btn-label-left pull-right">
					<span>
						<i class="fa fa-file"></i>
					</span>
					Descargar pdf
				</a> 
			</div>
		</div>
		<div class="clearfix"></div>
<!-- <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				<h4 class="modal-title" id="myModalLabel">Matriz Desempeño - Potencial</h4>
			</div>
			<div class="modal-body">
				<h4>Sobre la matriz desempeño - potencial</h4>
				<p>Esta matriz es de 3X3. En el eje x muestra el puntaje consolidado de Scorecard y Compass360, calculado en base a su ponderación.</p>
				<p>El eje y se mueve a su discreción y representa el potecial de cada persona</p>
				<hr>
				<h4>Personal</h4>
				<p>En esta pantalla se muestra únicamente a los usuarios que tengan habilitadas las evaluaciones Scorecard y Compass360. Se puede filtrar la lista utilizando los filtros dentro del formulario.</p>
				<h4>Filtros</h4>
				<p>Para acceder a los filtros debe presionar el boton "Mostrar filtros" ubicado en la parte superior de la pantalla.</p>
				<p>Se seleccionan los campos a filtar dentro de la seleccion haciendo ctrl + click sobre los valores a mostrar.</p>
			</div>
			<div class="modal-footer">
				<label><input id="dshow" type="checkbox" name="dismiss">No volver a mostrar</label>
				<button type="button" class="btn btn-xs btn-default" data-dismiss="modal">Cerrar</button>
				<button id="modalG" type="button" data-loading-text="Cargando..." class="btn btn-xs btn-primary">Guardar cambios</button>
			</div>
		</div>
	</div>
</div> -->
<script>
	$( "#equalizer div.progress > div" ).each(function() {
		// read initial values from markup and remove that
		var value = parseInt( $( this ).text(), 10 );
		$( this ).empty().slider({
			value: value,
			range: "min",
			animate: true,
			orientation: "vertical",
			slide: function( event, ui ) {
				$( this ).parent().parent().children('input.matval').val(ui.value);
				$( this ).parent().parent().children('p.matval').empty().append(ui.value);
			}
		});
	});

	google.load("visualization", "1", {packages:["corechart"]});
	google.setOnLoadCallback(drawChart);
	function drawChart() {
		var data = new google.visualization.DataTable();
		data.addColumn('number', 'Desempeño');
		data.addColumn('number', 'Potencial');
		data.addColumn({type: 'string', role: 'annotation'});

      // column for tooltip content
      data.addColumn({type: 'string', role: 'tooltip', 'p': {'html': true}});
      data.addRows([
      	<?php 
      	foreach ($resultados  as $key => $value) {
      		echo "[";
      		$r_scorer = $meth->get_ScorecardRes($value['id']);
      		$r_score = $meth->scorer_rango($scorer,intval($r_scorer));
      		$compass = round($meth->getAvg_test_eval($meth->get_codEval($value['id'])),2);
      		$p_score = $scorer->p_score;
      		echo $total = ($r_score * $p_score / 100)+($compass * (100-$p_score) /100);
      		echo ",";
      		echo $pot = $meth->get_matriz($value['id']);
      		echo ",'";
      		echo $meth->htmlprnt($value['nombre']);
      		echo "','<table width=150 style=\"margin:10px;font-size:16px;\"><tr><th colspan=2><b>";
      		echo $meth->htmlprnt($value['nombre']);
      		echo "</b></th></tr><tr> <td>Potencial:</td><td>".$pot."</td></tr>";
      		echo "<tr> <td>Desempeño:</td><td>".$total."</td></tr>";
      		echo "</table>'],\n";
      	}
      	?>
      	]);

      var options = {
      	tooltip: {isHtml: true,trigger: 'both'},
      	title: 'MATRIZ DESEMPEÑO - POTENCIAL',
      	hAxis: {textPosition: 'none',ticks: [0,(5/3),(5*2/3),5],title: 'Desempeño', minValue: 0},
      //hAxis: { ticks: [0,0.5,1,1.5,2,2.5,3,3.5,4,4.5,5] },
      vAxis: {textPosition: 'none',ticks: [0,(100/3),(200/3),100],title: 'Potencial', minValue: 0},
      backgroundColor: 'none',
      legend: {position: 'none'},
      //vAxis: { ticks: [0,0.5,1,1.5,2,2.5,3,3.5,4,4.5,5] },
      width: 600,
      height: 600,  
    };

    var chart = new google.visualization.ScatterChart(document.getElementById('chart_div'));

    chart.draw(data, options);
    
    google.visualization.events.addListener(chart, 'select', function() {
    	console.log(chart.getSelection());
    });
    // var boundingBox = chart.getChartLayoutInterface().getChartAreaBoundingBox(); 
    // console.log(boundingBox);
    // $('#chartBackground').css('top',"-" + (boundingBox.top+boundingBox.width-1) + "px").css('background-size', boundingBox.width + "px " + boundingBox.height + "px")
  }

  $('#prompt_button').click(function(){
  	jPrompt('Nombre del filtro:', 'ej. \"Gerentes\"', 'Guardar filtro', function(r) {
  		if( r ){ 
  			$('#prompt_result').empty().append(r.trim())
  			$('#prompt_button').val(r.trim())
  		}else
  		$('#prompt_button').click()
  	});
  })

  $('#modalG').click(function(event){
  	var $btn = $(this).button('loading')
	    // business logic...
	    var holder = 'modal';
	    var chkd;
	    if($('#dshow').is(':checked')){
	    	chkd = 1;
	    }else{
	    	chkd = 0;
	    }
	    $.post(AJAX+holder, {
	    	id: 1,
	    	id_e: <?php echo $_SESSION['Empresa']['id'] ?>,
	    	val:chkd,
	    }, function(response){
	    	$btn.button('reset');
	    	$('#myModal').modal('hide');
	    });	
	  });
	</script>
