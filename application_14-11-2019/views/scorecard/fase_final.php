<?php $meth = new Scorecard(); ?>
<div class="hidden-xs">
<h4>Matriz De Desempeño</h4>
<div class="col-md-6 form-group">
  <table width="360" class="center-block table" style="margin-top:115px;font-size: 14px;">
    <tr>
      <th colspan="2">Resultado de evaluaciones</th>
    </tr>
    <tr>
      <td class="text-left col-md-6"><b>Puntaje Scorecard:     </b></td>
      <td class="text-left col-md-6"><?php echo $scorer //echo round($scorer) ?></td>
    </tr>
    <tr>
      <td class="text-left col-md-6"><b>Puntaje Compass 360:     </b></td>
      <td class="text-left col-md-6"><?php echo $compass//echo round($compass) ?></td>
    </tr>
    <tr>
      <td class="text-left col-md-6"><b>Puntaje Ponderado:     </b></td>
      <td class="text-left col-md-6"><?php echo $pond//echo round($pond)  ?></td>
    </tr>
  </table>
</div>
  <div class="col-md-6" height="600px"> 
    <div id="chart_div" style="width: 600px; height: 600px; margin: 0 auto; position: relative; z-index:500"></div>
    <div id="chartBackground" style="background-image: url(<?php echo BASEURL ?>/img/matriz_bg.jpg); width: 371px; height: 371px; position: relative; z-index:-500; margin: 0 auto"></div>
      <!--
      <div style="width:100px; height 100px; border: 1px solid black; background: green;"></div>
      <div style="width:100px; height 100px; border: 1px solid black; background: yellow;"></div>
      <div style="width:100px; height 100px; border: 1px solid black; background: red;"></div>
      -->
  </div> 
</div> 

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
  google.load("visualization", "1", {packages:["corechart"]});
  google.setOnLoadCallback(drawChart);
  function drawChart() {
    var data = new google.visualization.DataTable();
      data.addColumn('number', 'Scorcard');
      data.addColumn('number', 'Compass');

      // column for tooltip content
      data.addColumn({type: 'string', role: 'tooltip'});
      data.addRows([
          [<?php echo $scorer?>, <?php echo $compass?>, 'Puntaje ponderado: <?php echo $pond ?>'],
      ]);

    var options = {
      tooltip: {isHtml: true,trigger: 'both'},
      // title: 'MATRIZ DE DESEMPEÑO',
      hAxis: {title: 'Scorecard', minValue: 0, maxValue: 5, ticks: [0,1,2,3,4,5], viewWindowMode:'explicit', viewWindow:{ min: 0.009 }},
      //hAxis: { ticks: [0,0.5,1,1.5,2,2.5,3,3.5,4,4.5,5] },
      vAxis: {title: 'Compass 360', minValue: 0, maxValue: 5, ticks: [0,1,2,3,4,5], viewWindowMode:'explicit', viewWindow:{ min: 0.009 } },
      backgroundColor: 'none',
      //vAxis: { ticks: [0,0.5,1,1.5,2,2.5,3,3.5,4,4.5,5] },
      legend: {position: 'none'},
      width: 600,
      height: 600,  
      pointSize: 30,
      pointShape: 'star',
    };

    var chart = new google.visualization.ScatterChart(document.getElementById('chart_div'));

    chart.draw(data, options);
    
    var boundingBox = chart.getChartLayoutInterface().getChartAreaBoundingBox(); 
    $('#chartBackground').css('top',"-" + (boundingBox.top+boundingBox.width-1) + "px").css('background-size', boundingBox.width + "px " + boundingBox.height + "px")
  }

</script>
