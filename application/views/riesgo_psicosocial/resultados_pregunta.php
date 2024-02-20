
<script src= "http://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js"></script>
<style type="text/css">
	.skin_row{
		width: 10px
	}
</style>

<div class="col-md-12" ng-app="myApp" ng-controller="formCtrl" id="myApp">
	<?php 
	$x = new Rp_tema(); 
	$x->select($id_tema); 
	$y=new rp_pregunta();
	?>

	<table class="table table-bordered table-hover">
		<tr><th colspan="5"><strong><a href="<?php echo BASEURL ?>riesgo_psicosocial/resultados"><?php echo ucfirst($x->getTema()) ?>.-</a></strong> 	<?php echo $x->getDescripcion() ?></th></tr>
		<tr ng-repeat="item in preguntas track by $index">
			<td>{{$index + 1}}</td>
			<td><h6><span ng-bind-html="item.pregunta | unsafe"></span></h6></td>
			<td style="background-color: {{item.style}}"><h6>{{item.porcentaje | number:2}}%</h6></span></td>
			<td width="600"><div ng-bind-html="item.results | unsafe"></td>
			<td><div compile="item.loading"></div></td>
		</tr>
	</table>
</div>
<script type="text/javascript">
	$(function () {
		$('[data-toggle="popover"]').popover()
	})
	
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
		$scope.preguntas = angular.fromJson(<?php echo json_encode($y->select_x_tema_($id_tema)); ?>);
		// $scope.loading = $sce.trustAsHtml('<p class="text-center"><i class="fa fa-spinner fa-pulse fa-5x"></i></p>');
		var url=$window.AJAX;
		url = url + "get_porcentaje_rp_pregunta/";


		$scope.get_result = function(k,id_t){
			var result = $http.get(url+id_t,{ cache: true});
			result.success(function(data){
				console.log(data);
				var dat =  data.split('*');
				dat[0] = dat[0].trim();
				console.log(angular.isString(dat[0]));
				if(dat[0]=="error")
					$scope.preguntas[k].loading = '<a  style="color:red" ng-click="$parent.get_result('+k+','+id_t+')" class="text-center"><i class="fa fa-times-circle fa-2x"></i></a>';
				else{
					$scope.preguntas[k].loading = '<p class="text-center" style="color:green"><i class="fa fa-check fa-2x"></i></p>';
					$scope.preguntas[k].results = dat[0];
				}
			});
		}

		angular.forEach($scope.preguntas, function(value, key) {
			$scope.preguntas[key].loading = '<a ng-click="$parent.get_result('+key+','+value.id+')"   class="text-center"><i class="fa fa-spinner fa-pulse fa-2x"></i></a>';
			$scope.get_result(key,value.id);
		});

	});
</script>