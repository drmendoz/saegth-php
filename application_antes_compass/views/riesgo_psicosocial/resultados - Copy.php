<script src= "http://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js"></script>
<style type="text/css">
	.progress{height: 40px;}
	.progress-bar{
		font-size: 30px;
		padding-top: 8px;
		border-color: rgba(0, 0, 0, 0.3);
	}
</style>
<div class="col-md-12">
	<table class="table table-bordered table-hover" style="">
		<tr><th colspan="2">Temas</th></tr>

		<?php 
		set_time_limit(0);
		$x = new Rp_tema();
		$arr = $x->select_all();
		$y = new Rp_pregunta();
		$z = new Rp_user();
		$w = new Rp_respuesta();
		$ids = $z->get_id_x_empresa($_SESSION['Empresa']['id']);
		$graf  = $promedio_general  = array();
		foreach ($arr as $key => $value) {
			echo "<tr>";
			$tema_nombre = ucfirst($value->getTema());
			$tema_id = $value->getId();
			echo "<td class='col-md-7'><strong><a href='".BASEURL."riesgo_psicosocial/resultados_pregunta/".$tema_id."'>".$tema_nombre.".-</a></strong> 	".$value->getDescripcion()."</td>";
			$preguntas = $y->select_ids_x_tema($tema_id);
			// $promedio = $w->get_avg_x_tema($ids,$preguntas);
			$porcentajes = $w->get_percent($ids,$preguntas);
			array_push($promedio_general, $porcentajes);
			// $graf[$tema_nombre] = $porcentajes;
			// echo "<td class='text-center' style='background-color: ".$w->get_color($porcentajes)."'>";
			// printf("%.2f", $porcentajes);
			// echo "</td>";
			?>
			<td class='col-md-5'>
				<div class="progress">
					<div class="progress-bar" role="progressbar" aria-valuenow="<?php printf("%.2f", $porcentajes); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php printf("%.2f", $porcentajes) ?>%;background-color: <?php echo $w->get_color($porcentajes) ?>">
						<span><?php printf("%.2f", $porcentajes); ?>% </span>
					</div>
				</div>
			</td>
			<?php
			echo "</tr>";

		}
		echo "<tr>";
		echo "<th>Promedio General</th>";
		$p_gen = array_sum($promedio_general)/sizeof($promedio_general);
		echo "<td class='text-center' style='background-color: ".$w->get_color($p_gen)."'><h3>";
		echo round($p_gen,2);
		echo "</h3></td>";
		echo "</tr>";
		// echo "<input type='hidden' id='graf' value='".json_encode($graf)."'/>";
		?>
	</table>
</div>
<div class="col-md-12" ng-app="myApp" ng-controller="formCtrl" id="myApp">
	<table class="table table-bordered table-hover" style="">
		<tr><th colspan="2">Temas</th></tr>
		<tr ng-repeat="item in temas track by $index">
			<td class='col-md-7'>
				<strong><a href='<?php echo BASEURL ?>riesgo_psicosocial/resultados_pregunta/{{item.id}}'><span class="text-capitalize" ng-bind-html="item.tema | unsafe"></span>.-</a></strong> <span ng-bind-html="item.descripcion | unsafe"></span>
			</td>
			<td class='col-md-5'>
				<div class="progress">
					<div class="progress-bar" role="progressbar" aria-valuenow="{{item.porcentaje | number:2}}" aria-valuemin="0" aria-valuemax="100" style="width: {{item.porcentaje | number:2}}%;background-color: {{item.style}}">
						<span >{{item.porcentaje | number:2}}% </span>
					</div>
				</div>
			</td>
			<td  ng-bind-html="item.loading"></td>
		</tr>
	</table>
</div>
<!-- <div class="col-md-6">
	<div id="chart_div" style="height: 450px ;margin: 0 auto;"></div>
</div> -->
<!-- <script type="text/javascript" src="https://www.google.com/jsapi"></script> -->
<script type="text/javascript">
	// google.load('visualization', '1', {packages: ['corechart', 'bar']});
	// google.setOnLoadCallback(drawStacked);

	// function drawStacked() {

	// 	var obj = JSON.parse($('#graf').val());
	// 	var a = ['Legend','Muy elevado','Elevado','Moderado', 'Situación adecuada', { role: 'annotation' }]
	// 	var dat = [];
	// 	dat.push(a);
	// 	$.each(obj,function(index,value){
	// 		console.log(obj[index]);
	// 		if (value<64.99) {
	// 			var cars = [index, 0, 0, 0, value,index];
	// 		} else if (value=>64.99 && value<74.99) {
	// 			var cars = [index, 0, 0, value, 0,index];
	// 		} else if (value=>74.99 && value<84.99) {
	// 			var cars = [index, 0, value, 0, 0,index];
	// 		} else if (value=>84.99) {
	// 			var cars = [index, value, 0, 0, 0,index];
	// 		}
	// 		console.log(cars);
	// 		dat.push(cars);
	// 	});
	// 	var data = google.visualization.arrayToDataTable(dat);
	// 	var options = {
	// 		title: 'Resultado de encuestas',
	// 		legend: {position: 'top', maxLines: 3},
	// 		chartArea: {width: '100%'},
	// 		isStacked: 'percent',
	// 		hAxis: {
	// 			minValue: 0,
	// 			ticks: [0, .3, .6, .9, 1]
	// 		},

	// 		vAxis: {
	// 			title: 'Temas'
	// 		},
	// 		colors: ['#f00','orange','yellow','limegreen'],
	// 	};
	// 	var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
	// 	chart.draw(data, options);
	// }
</script>

<script type="text/javascript">
	
	var app = angular.module('myApp',[]);
	app.filter('unsafe', function($sce) { return $sce.trustAsHtml; });
	app.filter('iif', function () {
		return function(input, trueValue, falseValue) {
			return input ? trueValue : falseValue;
		};
	});
	app.controller('formCtrl', function($scope,$log,$window,$document, $http, $sce) {
		$scope.temas = angular.fromJson(<?php echo json_encode($x->select_all_()); ?>);
		// $scope.loading = $sce.trustAsHtml('<p class="text-center"><i class="fa fa-spinner fa-pulse fa-5x"></i></p>');
		var url=$window.AJAX;
		url = url + "get_porcentaje_rp/";
		$scope.get_percent = function(k,id_t){
			var result = $http.get(url+id_t,{ cache: true});
			result.success(function(data){
				var res =  data.split(',');
				console.log(res);
				if(res[0]=="error")
					$scope.temas[k].loading = $sce.trustAsHtml('<p class="text-center"><i class="fa fa-times-circle fa-2x"></i></p>');
				else{
					$scope.temas[k].loading = $sce.trustAsHtml('<p class="text-center"><i class="fa fa-check fa-2x"></i></p>');
					$scope.temas[k].porcentaje = res[0];
					if (res[0] < 65){
						var color="#00FF00";
					}else if ((res[0] >= 65)&&(res[0] < 75)) {
						var color="#FFFF00";
					}else if ((res[0] >= 75)&&(res[0] < 85)) {
						var color="#FFA500";
					}else if (res[0] >= 85) {
						var color="#990000; color: #f8f8f8;";
					}
					$scope.temas[k].style = color;
					
				}
			});
		}
		angular.forEach($scope.temas, function(value, key) {
			console.log(value)
			console.log(key)
			$scope.temas[key].loading = $sce.trustAsHtml('<p class="text-center"><i class="fa fa-spinner fa-pulse fa-2x"></i></p>');
			$scope.get_percent(key,value.id);
		});

	});
</script>
