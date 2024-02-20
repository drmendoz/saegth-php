<!-- <script src= "http://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js"></script> -->
<script src="<?php echo BASEURL ?>public/js/angular.min.js"></script>
<style type="text/css">
	.progress{height: 40px;}
	.progress-bar{
		font-size: 24px;
		padding-top: 8px;
		border-color: rgba(0, 0, 0, 0.3);
	}
	select {height: 120px !important}
	#area_seg{height: 400px !important}
</style>
<?php 
$rp = new riesgo_psicosocial();
$rp->select($_SESSION['Empresa']['id']);
$seg = $rp->getSegmentacion();
$x = new Rp_tema(); 
$util = new Util();
$util->_x('resultados','titulo');
?>
<div class="col-md-12" ng-app="myApp" ng-controller="formCtrl" id="myApp">

	<h4>Evaluados en proceso: {{c_e}} - <a class="btn btn-default" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Mostrar filtros</a></h4>
	<?php $util->_x('resultados','segmentacion'); ?>
	<p><?php echo  $filtros ?></p>
	<div class="collapse" id="collapseExample">
		<div class="well">
			<?php // var_dump($areas); ?>
			<form  action="<?php echo BASEURL.'riesgo_psicosocial/resultados' ?>" method="POST">
				<?php if (in_array("edad", $seg)): ?>
					<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
						<div class="panel-heading">Edad</div>
						<div class="panel-body">
							<select multiple name="edad[]" class="form-control">
								<option style="display:none">Seleccione una opción</option>
								<option value="0">Menor a 20 años</option>
								<option value="1">De 20 a 25 años </option>
								<option value="2">De 25 a 30 años </option>
								<option value="3">De 30 a 40 años</option>
								<option value="4">De 40 a 50 años</option>
								<option value="5">Más 50 años</option>
							</select>
						</div>
					</div>
				<?php endif ?>
				<?php if (in_array("antiguedad", $seg)): ?>
					<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
						<div class="panel-heading">Antigüedad</div>
						<div class="panel-body">
							<select multiple name="antiguedad[]" class="form-control">
								<option style="display:none">Seleccione una opción</option>
								<option value="1">Menos de 2 años</option>
								<option value="2">De 2 a 5 años</option>
								<option value="3">De 5 a 10 años </option>
								<option value="4">De 10 a 15 años</option>
								<option value="5">De 15 a 20 años</option>
								<option value="6">Más 20 años</option>
							</select>
						</div>
					</div>
				<?php endif ?>
				<?php if (in_array("localidad", $seg)): ?>
					<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
						<div class="panel-heading">Localidades</div>
						<div class="panel-body">
							<select multiple name="localidad[]" class="form-control">
								<option style="display:none">Seleccione una opción</option>
								<?php
								$test = new Empresa_local();
								$test->get_select_options_($_SESSION['Empresa']['id']);
								?>
							</select>
						</div>
					</div>
				<?php endif ?>
				<?php if (in_array("norg", $seg)): ?>
					<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
						<div class="panel-heading">Niveles Organizacionales</div>
						<div class="panel-body">
							<select multiple name="norg[]" class="form-control">
								<option style="display:none">Seleccione una opción</option>
								<?php
								$test = new Empresa_norg();
								$test->get_select_options($_SESSION['Empresa']['id']);
								?>
							</select>
						</div>
					</div>
				<?php endif ?>
				<?php if (in_array("tcont", $seg)): ?>
					<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
						<div class="panel-heading">Tipo de contrato</div>
						<div class="panel-body">
							<select multiple name="tcont[]" class="form-control">
								<option style="display:none">Seleccione una opción</option>
								<?php
								$test = new Empresa_tcont();
								$test->get_select_options($_SESSION['Empresa']['id']);
								?>
							</select>
						</div>
					</div>
				<?php endif ?>
				<?php if (in_array("educacion", $seg)): ?>
					<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
						<div class="panel-heading">Educación</div>
						<div class="panel-body">
							<select multiple name="educacion[]" class="form-control">
								<option style="display:none">Seleccione una opción</option>
								<option value="0">Primaria incompleta</option>
								<option value="1">Primaria completa</option>
								<option value="2">Secundaria incompleta </option>
								<option value="3">Secundaria completa </option>
								<option value="4">Universidtaria incompleta</option>
								<option value="5">Universitaria completa</option>
								<option value="6">Postgrado</option>
							</select>
						</div>
					</div>
				<?php endif ?>
				<?php if (in_array("sexo", $seg)): ?>
					<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
						<div class="panel-heading">Sexo</div>
						<div class="panel-body">
							<select multiple name="sexo[]" class="form-control">
								<option style="display:none">Seleccione una opción</option>
								<option value="0">Masculino</option>
								<option value="1">Femenino</option>
								<option value="2">N/E</option>
							</select>
						</div>
					</div>
				<?php endif ?>
				<?php if (in_array("hijos", $seg)): ?>
					<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
						<div class="panel-heading">Hijos</div>
						<div class="panel-body">
							<select multiple name="hijos[]" class="form-control">
								<option style="display:none">Seleccione una opción</option>
								<option value="0">Si</option>
								<option value="1">No</option>
								<option value="2">N/E</option>
							</select>
						</div>
					</div>
				<?php endif ?>
				<?php if (in_array("departamento", $seg)): ?>
					<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
						<div class="panel-heading">Departamento</div>
						<div class="panel-body">
							<select multiple id="area_seg" name="departamento[]" class="form-control">
								<option style="display:none">Seleccione una opción</option>
								<?php
								$test = new Empresa_area();
								$test->get_select_options($_SESSION['Empresa']['id']);
								?>
							</select>
						</div>
					</div>
				<?php endif ?>
				<div class="clearfix"></div>
				<div class="text-center"><input type="submit" value="Filtrar" name="filtro" class="btn btn-sm btn-default"> </div>
				<div class="clearfix"></div>
			</form>
		</div>
	</div> 
	<table class="table table-bordered table-hover" style="">
		<tr><th colspan="3"><?php $util->_x('resultados','titulo2') ?></th></tr>
		<tr ng-repeat="item in temas track by $index">
			<td class='col-md-7' style="font-size:14px">
				<h6><strong><a href='<?php echo BASEURL ?>riesgo_psicosocial/resultados_pregunta/{{item.id}}'><span class="text-capitalize" ng-bind-html="item.tema | unsafe"></span>.-</a></strong> <span ng-bind-html="item.descripcion | unsafe"></span></h6>
			</td>
			<td class='col-md-5 popover'>
				<div class="progress" role="tooltip" data-toggle="popover" data-trigger="hover" data-content="Si no muestra valor hacer click en el icono a la derecha." data-placement="top">
					<div class="progress-bar" role="progressbar" aria-valuenow="{{item.porcentaje | number:2}}" aria-valuemin="0" aria-valuemax="100" style="width: {{item.porcentaje | number:2}}%;background-color: {{item.style}}">
						<span >{{item.porcentaje | number:2}}% </span>
					</div>
				</div>
			</td>
			<td><div compile="item.loading"></div></td>
		</tr>
	</table>
</div>

<div class="btn-group">
	<a href="<?php echo BASEURL ?>riesgo_psicosocial/top/1" class="btn btn-default">Puntaje más alto</a>
	<a href="<?php echo BASEURL ?>riesgo_psicosocial/top/0" class="btn btn-default">Puntaje más bajo</a>
	<a href="<?php echo BASEURL ?>pdf/rp" class="btn btn-default">Generar reporte</a>
	<a href="<?php echo BASEURL ?>pdf/rp_xls" class="btn btn-default">Descargar en excel</a>
</div>
<script type="text/javascript">

	$(function () {
		// $('[data-toggle="popover"]').popover()
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
		$scope.temas = angular.fromJson(<?php echo json_encode($x->select_all_()); ?>);
		// $scope.loading = $sce.trustAsHtml('<p class="text-center"><i class="fa fa-spinner fa-pulse fa-5x"></i></p>');
		var url=$window.AJAX;
		url = url + "get_porcentaje_rp/";
		console.log(url);
		$scope.get_percent = function(k,id_t){
			var result = $http.get(url+id_t,{ cache: true});
			result.success(function(data){
				console.log(data);
				var dat =  data.split(';');
				var res =  dat[0].split('-');
				$scope.c_e = res[1];
				if(res[0]=="error")
					$scope.temas[k].loading = '<a  style="color:red" ng-click="$parent.get_percent('+k+','+id_t+')" class="text-center"><i class="fa fa-times-circle fa-2x"></i></a>';
				else{
					$scope.temas[k].loading = '<p class="text-center" style="color:green"><i class="fa fa-check fa-2x"></i></p>';
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
			$scope.temas[key].loading = '<a ng-click="$parent.get_percent('+key+','+value.id+')"   class="text-center"><i class="fa fa-spinner fa-pulse fa-2x"></i></a>';
			$scope.get_percent(key,value.id);
		});

	});
</script>
