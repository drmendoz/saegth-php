<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
<div ng-app="myApp" ng-controller="appCtrl">
	<h3>Items:</h3>
	<a href="#" class="btn" ng-click="addRow()">Add Row {{counter}}</a>
	<table class="table">
		<thead>
			<tr>
				<th width="200">Some Header</th>
			</tr>
		</thead>
		<tbody>
			<tr ng-repeat="rowContent in rows track by $index">
				<td>{{rowContent.id}}</td>
				<td>{{rowContent.item}}</td>
				<td compile="elim_tag"></td>
			</tr>
		</tbody>
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

	app.factory('ResulSet', function() {
		function ResultSetInstance(dataSet) { 
			this.filter = function(){ 

			}
		}

		return {
			createNew: function(dataSet) {
				return new ResultSetInstance(dataSet);
			}
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
	app.controller('appCtrl', function($scope,$log,$window,$timeout, $http, $sce, $filter) {
		$scope.rows = [
			{id:1,item:"item 1"},
			{id:2,item:"item 2"},
			{id:3,item:"item 3"},
			{id:4,item:"item 4"},
			{id:5,item:"item 5"}
		];

		$scope.elim_tag='<a tabIndex="-1" class="" ng-click="elim($index)" style="color:red"><i class="fa fa-times fa-lg grow"></i></a>';
		$scope.counter = 3;

		$scope.addRow = function() {

			$scope.rows.push('Row ' + $scope.counter);
			$scope.counter++;
		}

		$scope.elim = function(index) {
			console.log(index);
		}



	});
</script>