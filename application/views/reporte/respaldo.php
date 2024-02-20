<?php  
if(!$denied){
	?>
	<script src="<?php echo BASEURL ?>public/js/angular.min.js"></script>
	<h3>Preparando información para la descarga</h3>
	<p>&nbsp;</p>
	<div ng-app="myApp" ng-controller="formCtrl">
		<pre ng-if="cache">Cargando último reporte generado el: {{latest}}</pre>
		<div class="progress">
			<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{{CalifDesemp.progress}}" aria-valuemin="0" aria-valuemax="100" ng-style="{width : ( CalifDesemp.progress + '%' ) }">
				{{CalifDesemp.progress | number:2}}% Preparando "Calificación ponderada de desempeño"
			</div>
		</div>
		<div class="progress">
			<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{{CompassTest.progress}}" aria-valuemin="0" aria-valuemax="100" ng-style="{width : ( CompassTest.progress + '%' ) }">
				{{CompassTest.progress | number:2}}% Preparando "Calificación Compass 360"
			</div>
		</div>
		<p>&nbsp;</p>
		<a ng-show="CompassTest.progress==100" href="{{baseurl + 'pdf/descarga'}}" >Descargar</a>
		<div class="row form-group col-md-12 table-responsive">

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

		app.controller('formCtrl', function($scope,$log,$window,$location,$timeout, $http, $sce) {
			$scope.baseurl = $window.BASEURL+"/";
			$scope.count = <?php echo $count ?> || 0;
			$scope.cache = <?php echo $cache ?>;
			$scope.latest = "<?php echo $_SESSION['reporte_tiempo'] ?>";

			var template = function(p){
				progress:p
			}

			$scope.CalifDesemp = new template(0)
			$scope.CompassTest = new template(0)

			$scope.CompassFinal;

			$scope.items=[];

			var url=$scope.baseurl+"reporte/"

			$scope.getCalifDesemp = function(lim){
				console.log($scope.CalifDesemp)
				tmp_url = url + "calificacion_desemp/";
				var result = $http.get(tmp_url+lim+"/2015",{cache: true,params:{"lim": lim}});
				result.success(function(data){
					var next = lim+10
					var p = next * 100 / $scope.count;
					if(lim<$scope.count){
						$scope.CalifDesemp.progress = p
						$scope.getCalifDesemp(next);
					}else{
						$scope.CalifDesemp.progress = 100
						$scope.getCompassTest()
					}
				});
			}

			$scope.getCompassTest = function(){
				tmp_url = url + "compass_test/";
				var result = $http.get(tmp_url,{cache: true});
				result.success(function(data){
					$scope.CompassFinal = data;
					$scope.CompassTest.progress = 100
						$scope.getCompassEvaluado()
				});
			}

			$scope.getCompassEvaluado = function(){
				tmp_url = url + "compass_evaluado/";
				var result = $http.get(tmp_url,{cache: true});
				result.success(function(data){
					// $scope.CompassFinal = data;
					// $scope.CompassTest.progress = 100
				});
			}

			if(!$scope.cache){
				// $scope.getCalifDesemp(0);
				$scope.getCompassTest()
			}else{
				// $scope.getCompassTest()
				$scope.CalifDesemp.progress = 100
				$scope.CompassTest.progress = 100
			}

		});
	</script>
	<?php  
}
?>