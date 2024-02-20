
<?php $meth = new Scorecard(); ?>
<div class="col-md-12">
	<a class="btn btn-default" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Mostrar filtros</a>
	<div class="collapse" id="collapseExample">
		<div class="well">
			<?php // var_dump($areas); ?>
			<form  action="<?php BASEURL.'test/matriz' ?>" method="POST">
				<!-- AREAS -->
				<div class="panel panel-success col-md-4 no-padding">
					<div class="panel-heading">&Aacute;reas</div>
					<div class="panel-body">
						<select name="areas[]" multiple="" class="form-control">
							<?php foreach ($areas as $key => $value) { $value=reset($value); ?>
							<option value="<?php echo $value['id'] ?>"><?php echo  $meth->htmlprnt($value['nombre']); ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<!-- LOCALIDADES -->
				<div class="panel panel-success col-md-4 no-padding">
					<div class="panel-heading">Localidades</div>
					<div class="panel-body">
						<select name="localidades[]" multiple="" class="form-control">
							<?php foreach ($local as $key => $value) { $value=reset($value); ?>
							<option value="<?php echo $value['id'] ?>"><?php echo  $meth->htmlprnt($value['nombre']); ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<!-- CARGOS -->
				<div class="panel panel-success col-md-4 no-padding">
					<div class="panel-heading">Cargos</div>
					<div class="panel-body">
						<select name="cargos[]" multiple="" class="form-control">
							<?php foreach ($cargos as $key => $value) { $value=reset($value); ?>
							<option value="<?php echo $value['id'] ?>"><?php echo  $meth->htmlprnt($value['nombre']); ?></option>
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
							<option value="<?php echo $value['id'] ?>"><?php echo  $meth->htmlprnt($value['nombre']); ?></option>
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
							<option value="<?php echo $value['id'] ?>"><?php echo  $meth->htmlprnt($value['nombre']); ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
		  		<!-- CONDICIONADORES 
			<?php 
				$condp = $condh = array();
				foreach ($cond as $key => $value) { 
				 	$value=reset($value);
			 		if(!$value['nivel'])
			 			array_push($condp, $value);
			 		else
			 			array_push($condh, $value);
				 } 
			 	foreach ($condp as $key => $value) { ?>
					<div class="panel panel-success col-md-4 no-padding">
						<div class="panel-heading"><?php echo $meth->htmlprnt($value['nombre']); ?></div>
						<div class="panel-body">
							<select name="cond_[]" multiple="" class="form-control">
						<?php foreach ($condh as $a => $b) { ?>
							<?php if($value['id'] == $b['id_superior']){ ?>
								<option value="<?php echo $value['id'].','.$b['id'] ?>"><?php echo  $meth->htmlprnt($b['nombre']); ?></option>
							<?php } ?>
						<?php } ?>
							</select>
						</div>
					</div>
		<?php   } ?>
	-->
	<div class="clearfix"></div>
	<input type="submit" value="Filtrar" name="filtro" class="btn btn-sm btn-default pull-right"> 
	<div class="clearfix"></div>
</form>
</div>
</div>
</div> 
<div class="clearfix"></div>
<hr>
<div class="col-md-12"> 
	<div id="chart_div" style="width: 600px; height: 600px; margin: 0 auto; position: relative; z-index:500"></div>
</div> 
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				<h4 class="modal-title" id="myModalLabel">Grafica Matriz Desempeño - Potencial</h4>
			</div>
			<div class="modal-body">
				<h4>Sobre la matriz desempeño - potencial</h4>
				<p>Esta matriz es de 3X3. En el eje x muestra el puntaje consolidado de Scorecard y Compass360, calculado en base a su ponderación; previamente defina <a target="_blank" href="<?php echo BASEURL.'empresa/scorecard' ?>">aquí</a>.</p>
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
</div>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script>
	google.load("visualization", "1", {packages:["corechart"]});
	google.setOnLoadCallback(drawChart);
	function drawChart() {
		var data = new google.visualization.DataTable();
		data.addColumn('number', 'Desempeño');
		data.addColumn('number', 'Potencial');

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
	      		echo ",'<table width=150 style=\"margin:10px;font-size:16px;\"><tr><th colspan=2><b>";
	      		echo $value['nombre'];
	      		echo "</b></th></tr><tr> <td>Potencial:</td><td>".$pot."</td></tr>";
	      		echo "<tr> <td>Desempeño:</td><td>".$total."</td></tr>";
	      		echo "</table>'],";
	      	}
	      	?>
	      	]);

	      var options = {
	      	tooltip: {isHtml: true,trigger: 'both'},
	      	title: 'MATRIZ DESEMPEÑO - POTENCIAL',
	      	hAxis: {title: 'Desempeño', minValue: 0, ticks: [0,(5/3).toFixed(2),((5/3)*2).toFixed(2),5]},
	      //hAxis: { ticks: [0,0.5,1,1.5,2,2.5,3,3.5,4,4.5,5] },
	      vAxis: {title: 'Potencial', minValue: 0, ticks: [0,33.33,66.66,100] },
	      backgroundColor: 'none',
	      //vAxis: { ticks: [0,0.5,1,1.5,2,2.5,3,3.5,4,4.5,5] },
	      width: 600,
	      height: 600,  
	    };

	    var chart = new google.visualization.ScatterChart(document.getElementById('chart_div'));

	    chart.draw(data, options);
	    
	    // var boundingBox = chart.getChartLayoutInterface().getChartAreaBoundingBox(); 
	    // console.log(boundingBox);
	    // $('#chartBackground').css('top',"-" + (boundingBox.top+boundingBox.width-1) + "px").css('background-size', boundingBox.width + "px " + boundingBox.height + "px")
	  }
	  $(window).load(function(){
	  	<?php if($mod){ ?>
	  		$('#myModal').modal('show');
	  		<?php } ?>
	  	});
	  $('#modalG').click(function(event){
	  	var $btn = $(this).button('loading')
	    // business logic...
	    var holder = 'modal';
	    var chkd;
	    if($('#dshow').is(':checked')){
	    	chkd = 0;
	    }else{
	    	chkd = 1;
	    }
	    $.post(AJAX+holder, {
	    	id: 2,
	    	id_e: <?php echo $_SESSION['Empresa']['id'] ?>,
	    	val:chkd,
	    }, function(response){
	    	$btn.button('reset');
	    	$('#myModal').modal('hide');
	    });	
	  });
	</script>