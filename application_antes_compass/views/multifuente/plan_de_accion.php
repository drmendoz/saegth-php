<?php $meth = new Empresa(); $util = new Util(); //var_dump($temas)?>
  <style type="text/css">
    #sidebar-left,#breadcrumb{display: none}
    #content{width:100%;}
  </style>
  <p>&nbsp;</p>
  <div class="col-md-12">
      <img src="<?php echo BASEURL ?>img/Compass.png" style="width: 200px;">
      <!-- <a id="imprimir" class="btn btn-success btn-xs pull-right" download="recomendaciones">Imprimir formulario</a> -->
      <div class="clearfix"></div>
      <h1 class="text-center">Plan de Acción General</h1>
      <a href="<?php echo BASEURL ?>pdf/plan_de_accion_xls" class="btn btn-sm btn-success">Descargar XLS</a>
  </div>
  <div id="plan_de_accion" class="row">
      <table class="table-bordered"  style="width: 100%; line-height: 15px;">
        <tr>
          <th class="col-md-1">Nombre</th>
          <th class="col-md-1">Cargo</th>
          <th class="col-md-1">Departamento</th>
          <th class="col-md-1">Gerente</th>
          <th class="col-md-2">Item a desarrollar</th>
          <th class="col-md-2">Acción</th>
          <th class="col-md-1">Tipo</th>
          <th class="col-md-2">Medicion</th>
          <th class="col-md-1">Fecha de cumplimiento</th>
        </tr>
<?php foreach ($evaluados as $a => $b) {; 
        // $id = $meth->get_id($b['cod_evaluado']);
        // $dat = $meth->get_empdat($id,$b['cod_evaluado']);  ?>
        <tr>
          <td class="col-md-1"><?php echo $meth->htmlprnt($b['nombre']) ?></td>
          <td class="col-md-1"><?php echo $meth->htmlprnt($b['cargo']) ?></td>
          <td class="col-md-1"><?php echo $meth->htmlprnt($b['area']) ?></td>
          <td class="col-md-1"><?php echo $meth->htmlprnt($b['pid_nombre']) ?></td>
          <td class="col-md-2"><?php echo $meth->get_preg($b['cod_pregunta']) ?></td>
          <td class="col-md-2"><?php echo $meth->htmlprnt($b['accion']) ?></td>
          <td class="col-md-1"><?php echo $meth->htmlprnt($b['tipo']) ?></td>
          <td class="col-md-2"><?php echo $meth->htmlprnt($b['medicion']) ?></td>
          <td class="col-md-1"><?php echo $meth->print_fecha($b['fecha']); ?></td>
        </tr>
<?php } ?>

      </table>
  </div>
<script type="text/javascript">
  $("#imprimir").click(function (e) {
    var html = $('#plan_de_accion').html().replace(new RegExp('class="col-md-4 text-center"', "g"), '');
    html = html.replace(new RegExp('class="col-md-4"', "g"), '');
    html = html.replace(new RegExp('class="table-bordered" style="line-height: 25px;"', "g"), '');
    console.log(html);
    var uri = 'data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=UTF-8,' + html;

    var downloadLink = document.createElement("a");
    downloadLink.href = uri;
    downloadLink.download = "plan_de_accion.xls";

    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);
  });
</script>















          

