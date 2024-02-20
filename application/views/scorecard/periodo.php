<script src="<?php echo BASEURL ?>public/js/angular.min.js"></script>
<?php 
$meth = new Scorecard();
?>
<style type="text/css">
  table tr, table td{padding:10px;}
  table.scorecard td{text-align: center;}
  select.input-sm {
    height: 22px;
    line-height: 30px;
  }
  input.input-sm{
    margin-left: 10px;
  }
</style>
<div class="form-group">
  <img src="<?php echo BASEURL ?>img/scorecard.png" style="width: 200px;">
  <h3 align="center">SISTEMA DE INFORMACIÓN GENERAL DEL PROCESO</h3>
</div>
<div ng-app="myApp" ng-controller="formCtrl">
  <div  ng-hide="progress==100" class="progress">
    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{{progress}}" aria-valuemin="0" aria-valuemax="100" ng-style="{width : ( progress + '%' ) }">
      {{progress | number:2}}% Preparando listado
    </div>
  </div>
  <div class="row form-group col-md-12 table-responsive">
    <table class="table-bordered scorecard" id="table" style="width: 100%; line-height: 12px;">
      <thead>
        <tr>
          <th>SUBALTERNOS EN PROCESO</th>
          <th>Cargo</th>
          <th>Periodo</th>
          <th>Resultado Scorercard %</th>
          <th>Resultado Scorercard</th>
          <th>Resultado Compass 360°</th>
          <th>Resultado Ponderado</th>
        </tr>
      </thead>
      <tbody>
        <tr ng-repeat="item in items track by $index">
          <td style="text-align: left !important"><a href="{{baseurl}}scorecard/confirmacion/{{item.id}}/{{item.fecha}}">{{item.nombre}}</a></td>
          <!-- <td style="text-align: left !important">{{item.nombre}}</td> -->
          <td>{{item.cargo}}</td>
          <td>{{item.fecha}}</td>
          <td>{{item.resultado_scorer_p}}</td>
          <td>{{item.resultado_scorer}}</td>
          <td>{{item.resultado_compass}}</td>
          <td>{{item.resultado_ponderado}}</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<script type="text/javascript" defer>
  var datatables = function(){
    setTimeout(function(){ 
      $('#table').DataTable({
        "lengthMenu": [[50, 100, -1], [50, 100, "Todos"]],
        "language": {
          "lengthMenu": "Mostrar _MENU_ entradas por página",
          "zeroRecords": "No hay resultados",
          "info": "Mostrando página _PAGE_ de _PAGES_",
          "infoEmpty": "No hay resultados",
          "infoFiltered": "(Filtrado de _MAX_ entradas totales)",
          "search":         "Buscar:",
          "paginate": {
            "first":      "First",
            "last":       "Last",
            "next":       "Siguiente",
            "previous":   "Anterior"
          },
        }
      });
    }, 100);
  }
</script>
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
    $scope.baseurl = $window.BASEURL+"/";
    $scope.count = <?php echo $count ?> || 0;
    $scope.progress = 0;
    $scope.items=[];

    var periodo = <?php echo $periodo ?> || 0;
    var url=$window.AJAX;
    url = url + "scorecard_periodo/";

    $scope.getData = function(lim){
      var result = $http.get(url+lim+"/"+periodo,{cache: true,params:{"lim": lim}});
      result.success(function(data){
        console.log(data)
        angular.forEach(data, function(value, key) {
          $scope.items.push(value);
        });
        var next = lim+10
        var p = next * 100 / $scope.count;
        if(lim<$scope.count){
          $scope.progress = p
          $scope.getData(next);
        }else{
          $scope.progress = 100
          $window.datatables();
        }
      });
    }

    $scope.getData(0);

  });
</script>