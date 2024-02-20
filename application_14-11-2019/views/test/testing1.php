<script src="<?php echo BASEURL ?>public/js/angular.min.js"></script>
<?php 

?>
<div class="col-md-12" ng-app="myApp" ng-controller="formCtrl" id="myApp">
	<div class="table-responsive" ng-if="user_rol=='admin'">
		<!-- <button class="btn-info btn-sm" ng-click="get">Cargar datos</button> -->
		<table class="table table-bordered">
			<thead>
				<tr> 
					<td rowspan="2">SEGMENTO ORGANIZACIONAL</td>
					<td colspan="2">Número personal por</td>
					<td rowspan="2">Hombres</td>
					<td rowspan="2">Mujeres</td>
					<td rowspan="2">Edad Promedio</td>
					<td rowspan="2">Antigüedad Promedio</td>
					<td rowspan="2">Sueldos Promedio</td>
					<td class="bg-success" colspan="{{tconts.conteo}}">Tipos de contrato</td>
					<td class="bg-info" colspan="{{norgs.conteo}}">Nivel organizacional</td>
				</tr>
				<tr>
					<td>Específico</td>
					<td>Acumulativo</td>
					<td ng-repeat="item in tconts.tipos" class="bg-success">{{item.nombre}}</td>
					<td ng-repeat="item in norgs.tipos" class="bg-info">{{item.nombre}} {{item.id}}</td>
				</tr>
			</thead>
			<tr class="info">
				<td colspan="100%">CORTE POR UNIDAD ORGANIZACIONAL</td>
			</tr>
			<tr ng-repeat="item in areas">
				<td ng-bind-html="item.nombre | unsafe"></td>
				<td style="text-align: right" ng-hide="item.status=='empty'">{{item.n_empleados.especifico}}</td>
				<td style="text-align: right" ng-hide="item.status=='empty'">{{item.n_empleados.acumulado}}</td>
				<td style="text-align: right" ng-hide="item.status=='empty'">{{item.hombres}}</td>
				<td style="text-align: right" ng-hide="item.status=='empty'">{{item.mujeres}}</td>
				<td style="text-align: right" ng-hide="item.status=='empty'">{{item.edad}}</td>
				<td style="text-align: right" ng-hide="item.status=='empty'">{{item.antiguedad}}</td>
				<td style="text-align: right" ng-hide="item.status=='empty'">{{item.sueldos}}</td>
				<td style="text-align: right" ng-hide="item.status=='empty'" ng-repeat="tcont in item.tconts track by $index" class="bg-success">{{item.tconts[$index]}}</td>
				<td style="text-align: right" ng-hide="item.status=='empty'" ng-repeat="norg in item.norgs track by $index" class="bg-info">{{item.norgs[$index]}}</td>
				<td ng-show="item.status=='loading' " ng-hide="item.status=='done' || item.status=='empty'"><div compile="item.icon">{{item.status}}</div></td>
				<td ng-show="item.status=='empty'" colspan="100%" class="warning">No hay datos</td>

			</tr>
		</table>
	</div>
	<div ng-if="user_rol=='user'">
		<p ng-repeat="item in areas"  ng-bind-html="item.nombre | unsafe"></p>
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
		$scope.areas = <?php  echo $json ?>;
		$scope.tconts = <?php echo $tconts ?>;
		$scope.norgs = <?php echo $norgs ?>;
		$scope.user_rol = "<?php echo $user_rol ?>";
		var url=$window.AJAX;
		$scope.get_data = function(k,id_t){
			url_ = url + "consolidado_empresa/";
			var data_ = $.param({
				id: id_t,
				tconts: $scope.tconts,
				norgs: $scope.norgs
			});
			var config_ = { 
				cache: true,
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8'
				}
			}
			var result = $http.post(url_,data_,config_);
			result.then(
				function(data){
					// console.log(data.data)

					var dat =  angular.fromJson(data.data);
					if(!dat)
						$scope.areas[k].loading = '<a  style="color:red" ng-click="$parent.get_data('+k+','+id_t+')" class="text-center"><i class="fa fa-times-circle fa-2x"></i></a>';
					else{
						$scope.areas[k]=dat;
					}

				});
		}
			// $scope.get_data(4,158,"pais");
			if($scope.user_rol=='admin'){
				angular.forEach($scope.areas, function(value, key) {
					$scope.get_data(key,value.id);
				});
			}


		});
	</script>
