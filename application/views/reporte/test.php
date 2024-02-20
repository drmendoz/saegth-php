
<script src="<?php echo BASEURL ?>public/js/angular.min.js"></script>


<div ng-app="myApp" ng-controller="formCtrl">
	<table class="table table-bordered">
		<tr ng-repeat="item in count">
			<td>{{item.id_personal}}</td>
			<td>{{item.cod_evaluado}}</td>
			<td ng-repeat="item.data"></td>
		</tr>
	</table>
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
		$scope.count = <?php echo json_encode($_SESSION['respaldo']['compass']['evaluados'],JSON_PRETTY_PRINT); ?>;

		var url=$scope.baseurl+"reporte/"


		var req = {
			method: 'POST',
			url: 'http://example.com',
			headers: {
				'Content-Type': 'application/json'
			},
			data: { test: 'test' }
		}

		$http(req).
		then(
			function(){
			}, 
			function(){
			}
			);


		$scope.getData = function(){
			tmp_url = url + "calificacion_desemp/";
			var result = $http.get(tmp_url+lim+"/2015",{cache: true,params:{"lim": lim}});
			result.success(function(data){
				if(lim<$scope.count){
					$scope.CalifDesemp.progress = p
					$scope.getCalifDesemp(next);
				}else{
					$scope.CalifDesemp.progress = 100
					$scope.getCompassTest()
				}
			});
		}

	});
</script>

<pre>
	<?php 
	echo json_encode($_SESSION['respaldo']['compass']['evaluados'],JSON_PRETTY_PRINT); 
// echo json_encode($_SESSION['respaldo']['compass']['compass_test']['data'],JSON_PRETTY_PRINT); 


// $me = new Multifuente_evaluado();

// $cod_test = "test214715-07-17"; 
// $ids = $me->getCodEvaluados($cod_test);

// $ger=$auto=$par=$sub=$tem=array();

// foreach ($ids as $key => $value) { 
// 	foreach ($_SESSION['respaldo']['compass']['compass_test']['data'][1]['temas']['data'] as $key_ => $value_) { 
// 		$x1 = $me->getAvg_tema_eval_rango($value_['cod_tema'],$value['cod_evaluado'],"Gerente");
// 		$x2 = $me->getAvg_tema_eval_rango($value_['cod_tema'],$value['cod_evaluado'],"Auto");
// 		$x3 = $me->getAvg_tema_eval_rango($value_['cod_tema'],$value['cod_evaluado'],"Par");
// 		$x4 = $me->getAvg_tema_eval_rango($value_['cod_tema'],$value['cod_evaluado'],"Subalterno");
// 		?>

<?php //echo $x1 ?>
<!-- -> -->
<?php //echo $x2 ?>
<!-- -> -->
<?php //echo $x3 ?>
<!-- -> -->
<?php //echo $x4 ?>
<!-- => -->
<?php 
// 	}
// 	echo "<br>";
// }
?>
</pre>