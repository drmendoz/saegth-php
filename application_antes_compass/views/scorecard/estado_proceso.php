<script src="<?php echo BASEURL ?>public/js/angular.min.js"></script>
<?php 
$tmp = array(
	'id' => null,
	'nombre' => null, 
	'nivel' => null, 
	'status' => 'loading', 
	'icon' => '<i class="fa fa-spinner fa-pulse fa-2x"></i>',
	'n_empleados' => null,
	'usuario' => array('n' => null, 'p' => null), 
	'jefe' => array('n' => null, 'p' => null), 
	'r_empleado' => array('n' => null, 'p' => null), 
	'r_jefe' => array('n' => null, 'p' => null), 
	'e_empleado' => array('n' => null, 'p' => null), 
	'e_jefe' => array('n' => null, 'p' => null), 
	);
$final = array();

$ea = new empresa_area();
$hey = $ea->select_nivel($_SESSION['Empresa']['id'],1);
$inicial = $hey[0]['Empresa_area'];

$tmp['id'] = $inicial['id'];
$tmp['nombre'] = $ea->htmlprnt_win($inicial['nombre']);
array_push($final, $tmp);

$res = $ea->getTree($inicial['id']);
// var_dump($res);

if($res){
	foreach ($res as $key => $value) {
		$tmp['id'] = $value['id'];
		$tmp['nombre'] = $ea->htmlprnt_win($value['nombre_']);
		array_push($final, $tmp);
	}
	$json = json_encode($final);

	$el = new empresa_local();
	$res = $el->select_all_nivel($_SESSION['Empresa']['id'],0);
	$final = array();
	if($res){
		foreach ($res as $key => $value) {
			$tmp['id'] = $value['id'];
			$tmp['nombre'] = $ea->htmlprnt_win($value['nombre']);
			array_push($final, $tmp);
		}
		$json_local = json_encode($final);

	}

	?>


	<div class="col-md-12" ng-app="myApp" ng-controller="formCtrl" id="myApp">
		<div class="table-responsive">
		<!-- <button class="btn-info btn-sm" ng-click="get">Cargar datos</button> -->
			<table class="table table-bordered">
				<tr>
					<td rowspan="2">SEGMENTO ORGANIZACIONAL</td>
					<td rowspan="2">Empleados totales</td>
					<td colspan="2">Ingreso de Objetivos del Empleado</td>
					<td colspan="2">Revisión del Superior Inmediato</td>
					<td colspan="2">Comentarios de Revisión de Empleado</td>
					<td colspan="2">Comentarios de Revisión de Superior Inmediato</td>
					<td colspan="2">Comentarios de Evaluación de Empleado</td>
					<td colspan="2">Comentarios de Evaluación de Superior Inmediato</td>
				</tr>
				<tr>
					<td># Cumplido</td>
					<td>% Cumplido</td>
					<td># Cumplido</td>
					<td>% Cumplido</td>
					<td># Cumplido</td>
					<td>% Cumplido</td>
					<td># Cumplido</td>
					<td>% Cumplido</td>
					<td># Cumplido</td>
					<td>% Cumplido</td>
					<td># Cumplido</td>
					<td>% Cumplido</td>
				</tr>
				<tr class="info">
					<td colspan="{{colnum}}">CORTE POR PAIS (RESUMEN)</td>
				</tr>
				<tr ng-repeat="item in local">
					<td ng-bind-html="item.nombre | unsafe"></td>
					<td style="text-align: right" ng-hide="item.status=='empty'">{{item.n_empleados}}</td>
					<td style="text-align: right" ng-hide="item.status=='empty'">{{item.usuario.n}}</td>
					<td style="text-align: right" ng-hide="item.status=='empty'">{{item.usuario.p}}%</td>
					<td style="text-align: right" ng-hide="item.status=='empty'">{{item.jefe.n}}</td>
					<td style="text-align: right" ng-hide="item.status=='empty'">{{item.jefe.p}}%</td>
					<td style="text-align: right" ng-hide="item.status=='empty'">{{item.r_empleado.n}}</td>
					<td style="text-align: right" ng-hide="item.status=='empty'">{{item.r_empleado.p}}%</td>
					<td style="text-align: right" ng-hide="item.status=='empty'">{{item.r_jefe.n}}</td>
					<td style="text-align: right" ng-hide="item.status=='empty'">{{item.r_jefe.p}}%</td>
					<td style="text-align: right" ng-hide="item.status=='empty'">{{item.e_empleado.n}}</td>
					<td style="text-align: right" ng-hide="item.status=='empty'">{{item.e_empleado.p}}%</td>
					<td style="text-align: right" ng-hide="item.status=='empty'">{{item.e_jefe.n}}</td>
					<td style="text-align: right" ng-hide="item.status=='empty'">{{item.e_jefe.p}}%</td>
					<td ng-show="item.status=='loading'"><div compile="item.icon"></div></td>
					<td ng-show="item.status=='empty'" colspan="15" class="warning">No hay datos</td>
				</tr>
				<tr class="info">
					<td colspan="{{colnum}}">CORTE POR UNIDAD ORGANIZACIONAL</td>
				</tr>
				<tr ng-repeat="item in areas">
					<td ng-bind-html="item.nombre | unsafe"></td>
					<td style="text-align: right" ng-hide="item.status=='empty'">{{item.n_empleados}}</td>
					<td style="text-align: right" ng-hide="item.status=='empty'">{{item.usuario.n}}</td>
					<td style="text-align: right" ng-hide="item.status=='empty'">{{item.usuario.p}}%</td>
					<td style="text-align: right" ng-hide="item.status=='empty'">{{item.jefe.n}}</td>
					<td style="text-align: right" ng-hide="item.status=='empty'">{{item.jefe.p}}%</td>
					<td style="text-align: right" ng-hide="item.status=='empty'">{{item.r_empleado.n}}</td>
					<td style="text-align: right" ng-hide="item.status=='empty'">{{item.r_empleado.p}}%</td>
					<td style="text-align: right" ng-hide="item.status=='empty'">{{item.r_jefe.n}}</td>
					<td style="text-align: right" ng-hide="item.status=='empty'">{{item.r_jefe.p}}%</td>
					<td style="text-align: right" ng-hide="item.status=='empty'">{{item.e_empleado.n}}</td>
					<td style="text-align: right" ng-hide="item.status=='empty'">{{item.e_empleado.p}}%</td>
					<td style="text-align: right" ng-hide="item.status=='empty'">{{item.e_jefe.n}}</td>
					<td style="text-align: right" ng-hide="item.status=='empty'">{{item.e_jefe.p}}%</td>
					<td ng-show="item.status=='loading'"><div compile="item.icon"></div></td>
					<td ng-show="item.status=='empty'" colspan="15" class="warning">No hay datos</td>
				</tr>
			</table>
		</div>
	</div>

	<script type="text/javascript">

		var app = angular.module('myApp',[]);
		app.filter('unsafe', function($sce) { return $sce.trustAsHtml; });
		app.filter('iif', function () {
			return function(input, trueValue, falseValue) {
				return input ? trueValue : falseValue;
			};
		});
		app.directive('compile', ['$compile', function ($compile) {
			return function(scope, element, attrs) {
				scope.$watch(
					function(scope) {
						return scope.$eval(attrs.compile);
					},
					function(value) {
						element.html(value);
						$compile(element.contents())(scope);
					}
					)};
			}]);

		app.controller('formCtrl', function($scope,$log,$window,$timeout, $http, $sce) {
			$scope.colnum = 14;
			$scope.areas = <?php echo $json ?>;
			$scope.periodo = <?php echo $periodo ?>;
			$scope.local = <?php echo $json_local ?>;
			var url=$window.AJAX;
			$scope.get_data = function(k,id_t,type,periodo){
				url_ = url + "estado_proceso_scorecard_"+type+"/";
				var result = $http.get(url_+id_t+"/"+periodo,{ cache: true});
				result.success(function(data){
					console.log(data)
					
					var dat =  angular.fromJson(data);
					if(!dat)
						$scope.temas[k].loading = '<a  style="color:red" ng-click="$parent.get_data('+k+','+id_t+')" class="text-center"><i class="fa fa-times-circle fa-2x"></i></a>';
					else{
						if(type=="pais"){
							$scope.local[k]=dat;
						}else{
							$scope.areas[k]=dat;
							console.log($scope.areas[k]);
						}
					}
				});
			}
			// $scope.get_data(4,158,"pais");

				angular.forEach($scope.local, function(value, key) {
					$scope.get_data(key,value.id,"pais",$scope.periodo);
				});
				angular.forEach($scope.areas, function(value, key) {
					$scope.get_data(key,value.id,"area",$scope.periodo);
				});


		});
	</script>
	<?php 
}
?>
