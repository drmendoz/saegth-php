
<script src="<?php echo BASEURL ?>public/js/angular.min.js"></script>
<script type="text/javascript" src="<?php echo BASEURL ?>public/plugins/moment/min/moment.min.js"></script>
<script type="text/javascript" src="<?php echo BASEURL ?>public/plugins/angular-ui-calendar/src/calendar.js"></script>
<script type="text/javascript" src="<?php echo BASEURL ?>public/plugins/fullcalendar/dist/fullcalendar.min.js"></script>
<script type="text/javascript" src="<?php echo BASEURL ?>public/plugins/fullcalendar/dist/gcal.js"></script>
<link rel="stylesheet" href="<?php echo BASEURL ?>public/plugins/fullcalendar/dist/fullcalendar.css">
<?php

?>
<style type="text/css">
  .hero-unit .btn, .pagination-centered .btn {
    float: none;
    font-weight: normal;
  }
  .hero-unit p {
    margin: 1em 0;
  }

  /*** Calendar ***/
  .fc-event.alert-danger{
    background-color: #d9534f !important;
    border-color: #d43f3a !important;
    color: white;
  }
  .fc-event.alert-warning{
  background-color: #f0ad4e !important;
  border-color: #eea236 !important;
    color: white;
  }
  .calAlert{
    width: 595px; float: right; margin-bottom: 5px;
  }

  .calXBtn{
    float: right; margin-top: -5px; margin-right: -5px;
  }

  .calWell{
    float: left; margin-bottom: 40px;
  }

  .calTools{
    margin-bottom: 10px;
  }
</style>
<body data-spy="scroll" ng-app="calendarDemoApp">
  <div role="main">
    <div class="container-fluid">
      <section id="directives-calendar" ng-controller="CalendarCtrl">
        <div class="page-header">
          <h1>Calendario</h1>
        </div>
        <div class="well clearfix">
          <div class="row-fluid">
            <div class="col-md-4 no-padding">
              <h3>What?</h3>
              <p>Attach Angular objects to a calendar.</p>
              <p>Show the data binding between two differnet calendars using the same event sources.</p>
              <h3>Why?</h3>
              <p>Why Not?</p>
              <div class="btn-group calTools">       
                <button type="button" class="btn btn-primary" ng-click="addEvent()">
                  Guardar
                </button>
              </div>
              <ul class="unstyled" style="-webkit-padding-start: 10px;">
                <li ng-repeat="e in events">
                  <div class="alert" ng-class="e.className">
                    <a class="close" ng-click="remove($index)"><i class="fa fa-times grow"></i></a>
                    <b> <input ng-model="e.title"></b> 
                    {{e.start | date:"short"}} - {{e.end | date:"short"}}
                  </div>
                </li>
              </ul>
            </div>
            <div class="col-md-8">
              <div class="alert-success calAlert col-md-12" ng-show="alertMessage != undefined && alertMessage != ''">
                <h4>{{alertMessage}}</h4>
              </div>
              <div class="btn-toolbar">
                <div class="btn-group">
                  <button class="btn btn-success" ng-click="changeView('agendaDay', 'myCalendar1')">Día</button>
                  <button class="btn btn-success" ng-click="changeView('agendaWeek', 'myCalendar1')">Semana</button>
                  <button class="btn btn-success" ng-click="changeView('month', 'myCalendar1')">Mes</button>
                </div>
              </div>
              <pre>{{horas}}</pre>
              <div class="col-md-12 no-padding">
                <div class="btn-group" data-toggle="buttons">
                  <input type="radio" ng-model="horas" value="1" checked="checked" /> Horas trabajadas
                  <input type="radio" ng-model="horas" value="2" /> Horas extra
                  <input type="radio" ng-model="horas" value="3" /> Vacaciones
                </div>
              </div>
              <div class="calendar" ng-model="eventSources" calendar="myCalendar1" ui-calendar="uiConfig.calendar"></div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
  <script type="text/javascript">
/**
* calendarDemoApp - 0.9.0
*/
var calendarDemoApp = angular.module('calendarDemoApp', ['ui.calendar']);

calendarDemoApp.controller('CalendarCtrl',
  function($scope, $compile, $timeout, uiCalendarConfig) {
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();

    $scope.eventSource = {
      url: "http://www.google.com/calendar/feeds/usa__en%40holiday.calendar.google.com/public/basic",
className: 'gcal-event',           // an option!
currentTimezone: 'America/Chicago' // an option!
};
/* event source that contains custom events on the scope */
$scope.events = []
/* event source that calls a function on every view switch */
$scope.eventsF = function (start, end, timezone, callback) {
  var s = new Date(start).getTime() / 1000;
  var e = new Date(end).getTime() / 1000;
  var m = new Date(start).getMonth();
  var events = [{title: 'Feed Me ' + m,start: s + (50000),end: s + (100000),allDay: false, className: ['customFeed']}];
  callback(events);
};

$scope.calEventsExt = {
  color: '#f00',
  textColor: 'yellow',
  events: [
  {type:'party',title: 'Lunch',start: new Date(y, m, d, 12, 0),end: new Date(y, m, d, 14, 0),allDay: false},
  {type:'party',title: 'Lunch 2',start: new Date(y, m, d, 12, 0),end: new Date(y, m, d, 14, 0),allDay: false},
  {type:'party',title: 'Click for Google',start: new Date(y, m, 28),end: new Date(y, m, 29),url: 'http://google.com/'}
  ]
};
/* alert on eventClick */
$scope.alertOnEventClick = function( date, jsEvent, view){
  $scope.alertMessage = (date.title + " " + date.confirmado);
};
/* alert on Drop */
$scope.alertOnDrop = function(event, delta, revertFunc, jsEvent, ui, view){
  console.log(event._id);
  var index=event._id-1;
  $scope.alertMessage = ('Event Dropped to make dayDelta ' + delta);
  $scope.events[index].start += delta;
  $scope.events[index].end += delta;
};
/* alert on Resize */
$scope.alertOnResize = function(event, delta, revertFunc, jsEvent, ui, view ){
  $scope.alertMessage = ('Event Resized to make dayDelta ' + delta);
};
/* add and removes an event source of choice */
$scope.addRemoveEventSource = function(sources,source) {
  var canAdd = 0;
  angular.forEach(sources,function(value, key){
    if(sources[key] === source){
      sources.splice(key,1);
      canAdd = 1;
    }
  });
  if(canAdd === 0){
    sources.push(source);
  }
};
/* add custom event*/
$scope.addEvent = function() {
  $scope.events.push({
    title: 'Open Sesame',
    start: new Date(y, m, 28),
    end: new Date(y, m, 29),
    className: ['openSesame']
  });
};
/* remove event */
$scope.remove = function(index) {
  $scope.events.splice(index,1);
};
/* Change View */
$scope.changeView = function(view,calendar) {
  uiCalendarConfig.calendars[calendar].fullCalendar('changeView',view);
};
/* Change View */
$scope.renderCalender = function(calendar) {
  $timeout(function() {
    if(uiCalendarConfig.calendars[calendar]){
      uiCalendarConfig.calendars[calendar].fullCalendar('render');
    }
  });
};
/* Render Tooltip */
$scope.eventRender = function( event, element, view ) {
  element.attr({'tooltip': event.title,
    'tooltip-append-to-body': true});
  $compile(element)($scope);
};
$scope.eventClass = function() {
  console.log($scope.horas);
  switch($scope.horas) {
    case '1':
    return 'alert-info';
    break;
    case '2':
    return 'alert-danger';
    break;
    case '3':
    return 'alert-warning';
    break;
    default:
    return 'alert-info';
  }
};
/* config object */
$scope.uiConfig = {
  calendar:{
    height: 450,
    editable: true,
    selectable: true,
    selectHelper: true,
    header:{
      left: 'title',
      center: '',
      right: 'today prev,next'
    },
    select: function(start, end) {
      var title = prompt('Event Title:');
      if (title) {
        $scope.events.push({
          title: title,
          start: new Date(start),
          end: new Date(end),
          confirmado: false,
          className: $scope.eventClass()
        });

      }
// should call 'unselect' method here
},
eventClick: $scope.alertOnEventClick,
eventDrop: $scope.alertOnDrop,
eventResize: $scope.alertOnResize,
eventRender: $scope.eventRender
}
};
/* event sources array*/
$scope.eventSources = [$scope.events, $scope.eventSource, $scope.eventsF];
$scope.eventSources2 = [$scope.calEventsExt, $scope.eventsF, $scope.events];
});
/* EOF */

</script>
</body>
</html>
