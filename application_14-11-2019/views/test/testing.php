<script src="<?php echo BASEURL ?>public/js/angular.min.js"></script>
<style type="text/css">
	
.animate {
	-webkit-transition: all 0.3s ease-out;
	transition: all 0.3s ease-out;
}

.drop-area {
	position: fixed;
	top: 50px;
	left: 100%;
	z-index: 99;
	width: 	103em;
	height: 100%;
	overflow-y: auto;
	overflow-x: hidden;
	background: #34495e;
	text-align: left;
	-webkit-transition: -webkit-transform 0.5s;
	transition: transform 0.5s;
	-webkit-transform: translate3d(20px,0,0);
	transform: translate3d(20px,0,0);
}

.drop-area.show {
	-webkit-transform: translate3d(-16em,0,0);
	transform: translate3d(-100em,0,0);
}

.drop-area > div {
	width: 100%;
	height: 100%;
	-webkit-transition: -webkit-transform 0.4s 0.1s;
	transition: transform 0.4s 0.1s;
	-webkit-transform: translate3d(50%,0,0);
	transform: translate3d(50%,0,0);
}

.drop-area.show > div {
	-webkit-transform: translate3d(0,0,0);
	transform: translate3d(0,0,0);
}

.drop-area__item {
	position: relative;
	display: inline-block;
	margin: 3em 0 1em 2em;
	width: 12em;
	height: 12em;
	border-radius: 4px;
	background: #6686a7;
	text-align: center;
	-webkit-transition: -webkit-transform 0.3s, background 0.3s;
  transition: transform 0.3s, background 0.3s;
}

.drop-area__item.highlight {
	background: #84a4c4;
	-webkit-transform: scale3d(1.08,1.08,1);
	transform: scale3d(1.08,1.08,1);
}

.drop-area__item::before,
.drop-area__item::after {
	position: absolute;
	top: 50%;
	left: 0;
	width: 100%;
	color: rgba(0,0,0,0.15);
	font-size: 1.5em;
	margin-top: -0.35em;
	font-family: FontAwesome;
	pointer-events: none;
}

.drop-area__item::before {
	content: '\f067';
}

.drop-feedback.drop-area__item::before {
	opacity: 0;
	-webkit-transform: scale3d(0,0,1);
	transform: scale3d(0,0,1);
}

.drop-area__item::after {
	color: rgba(52,73,94,0.6);
	content: '\f00c';
	font-size: 3em;
	margin-top: -0.5em;
	opacity: 0;
	-webkit-transition: opacity 0.3s, -webkit-transform 0.3s;
	transition: opacity 0.3s, transform 0.3s;
	-webkit-transform: scale3d(2,2,1);
	transform: scale3d(2,2,1);
}

.drop-feedback.drop-area__item::after {
	opacity: 1;
	-webkit-transform: scale3d(1,1,1);
	transform: scale3d(1,1,1);
}

.dummy,
.dummy::after {
	position: absolute;
	bottom: 100%;
	left: 0;
	margin: 0.25em 0;
	height: 0.65em;
	border-radius: 2px;
	background: rgba(255,255,255,0.1);
	-webkit-backface-visibility: hidden;
}

.dummy {
	width: 80%;
}

.dummy::after {
	width: 90%;
	content: '';
}

.drop-overlay {
	position: fixed;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	background: rgba(0,0,0,0.3);
	opacity: 0;
	-webkit-transition: opacity 0.3s;
	transition: opacity 0.3s;
	pointer-events: none;
}

.drop-area.show + .drop-overlay {
	opacity: 1;
}

</style>
<div id="app" ng-app="myApp" ng-controller="formCtrl">
	<form class="form-horizontal col-md-4" role="form" ng-submit="addRow()">
		<div class="form-group">
			<label class="col-md-2 control-label">Item</label>
			<div class="col-md-6">
				<input type="text" class="form-control" required id="set" name="name"	ng-model="name" />
			</div>
		</div>
		<div class="form-group">								
			<div style="padding-left:110px">
				<input type="submit" value="Submit" class="btn btn-primary"/>
			</div>
		</div>
	</form>
	<div class="col-md-8">
	<pre>{{sidebar}}</pre>
		<table id="table" class="table">
			<tr>
				<th>#</th>
				<th>Item</th>
				<th>Acción</th>
				<th>Eliminar</th>
			</tr>
			<tr ng-repeat="item in items track by $index">
				<td>{{$index+1}}</td>
				<td>
					<span ng-hide="editingData[$index]">{{item.name}}</span>
					<input type="text" ng-show="editingData[$index]" ng-model="item.name" class="col-md-12 form-control">
				</td>
				<td class="col-md-4" compile="item.accion"></td>
				<td class="col-md-1" compile="item.elim"></td>
			</tr>
		</table>
	</div>

		<div id="drop-area" class="drop-area" ng-class="sidebar ? 'show':''">
		<!-- <div id="drop-area" class="drop-area" ng-class="{'show': sidebar}"> -->
			<div class="bg-info col-md-12">
				<a ng-click="toggleSidebar()" style="padding-top:15px; color:666"><i class="fa fa-times fa-2x"></i></a>
			</div>
		</div>
		<div ng-click="toggleSidebar()" class="drop-overlay"></div>

</div>
<script type="text/javascript">
	var myApp = angular.module("myApp", []);

	myApp.directive('compile', ['$compile', function ($compile) {
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

	myApp.controller("formCtrl", function($scope,$window) {
		$scope.sidebar = false;
		$scope.items = [];
		$scope.accion='<div class="btn-group"><a ng-click="modify($event,$index)" ng-hide="editingData[$index]" class="btn btn-info">Modificar</a><a ng-click="update($event,$index)" ng-show="editingData[$index]" class="btn btn-info">Actualizar</a><button ng-click="toggleSidebar()" class="btn btn-default">Definir</button></div>';
		$scope.elim = '<a  style="color:red" ng-click="deleteItem($index)" class="text-center"><i class="fa fa-times-circle grow fa-2x"></i></a>';
		$scope.addRow = function(){	
			$('#set').focus();
			$scope.items.push({ 
				'name':$scope.name, 
				'accion': $scope.accion,
				'elim':$scope.elim,
				'edit':false
			});
			$scope.name='';
		};
    $scope.editingData = {};
		$scope.deleteItem = function(i){
			$scope.items.splice(i,1);
		}
    $scope.modify = function($event,i){
    	$($event.currentTarget).parent().parent().parent().find('input').focus();
        $scope.editingData[i] = true;
    };
    $scope.update = function($event,i){
        $scope.editingData[i] = false;
    };
    $scope.toggleSidebar = function(){
        $scope.sidebar = !$scope.sidebar;
    };
	});
</script>
<script type="text/javascript" defer>
	$(document).ready(function() {
		setTimeout(function(){  }, 2000);
	} );
</script>