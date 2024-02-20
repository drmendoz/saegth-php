<?php $meth = new User(); $util = new Util(); //var_dump($temas)?>
  <div class="row form-group col-md-12">
      <img src="<?php echo BASEURL ?>img/Compass.png" style="width: 200px;">
  </div>
  <div id="header" class="row form-group col-md-12">
          <table class="table-bordered"  style="width: 100%; line-height: 40px;">
        <tr>
          <td class="col-md-4"><b>PERSONAL: </b><?php echo $meth->htmlprnt($nombre); ?></td>
          <td class="col-md-4"><b>CARGO: </b><?php echo $meth->htmlprnt($cargo); ?></td>
          <td class="col-md-4"><b>SUPERVISOR DIRECTO: </b><?php echo $meth->htmlprnt($superior); ?></td>
        </tr>
        <tr>
          <td class="col-md-4"><b>EMPRESA: </b><?php echo $meth->htmlprnt($_SESSION['Empresa']['nombre']); ?></td>
          <td class="col-md-4"><b>&Aacute;REA: </b><?php echo $meth->htmlprnt($area); ?></td>
          <td class="col-md-4"><b>FECHA DE EVALUACION: </b><?php echo $meth->print_fecha($fecha); ?></td>
        </tr>
      </table>
  </div>
  <div class="row form-group col-md-12 text-right">
    <!-- <a id="imprimir" class="btn btn-success btn-xs" download="recomendaciones">Imprimir formulario</a> -->
  </div>
  <div id="comentarios" class="row form-group col-md-12">
    <table class="table-bordered" style="line-height: 25px; width:100%">
      <tr>
        <th class="col-md-4 text-center">Fortalezas</th>
        <th class="col-md-4 text-center">Debilidades</th>
        <th class="col-md-4 text-center">Comentarios</th>
      </tr><?php $comentarios; ?>
<?php foreach ($comentarios as $a => $b) { $b=reset($b);?>
      <tr>
        <td class="col-md-4"><?php echo util::htmlprnt($b['fortalezas']) ?></td>
        <td class="col-md-4"><?php echo util::htmlprnt($b['debilidades']) ?></td>
        <td class="col-md-4"><?php echo util::htmlprnt($b['comentarios']) ?></td>
      </tr>              
<?php } ?>
    </table>
  </div>
<script type="text/javascript">
  $("#imprimir").click(function (e) {
    var header = $('#header').html().replace(new RegExp('class="col-md-4"', "g"), '');
    header = header.replace(new RegExp('class="table-bordered"  style="width: 100%; line-height: 40px;"', "g"), '');
    var html = $('#comentarios').html().replace(new RegExp('class="col-md-4 text-center"', "g"), '');
    html = html.replace(new RegExp('class="col-md-4"', "g"), '');
    html = html.replace(new RegExp('class="table-bordered" style="line-height: 25px;"', "g"), '');
    var uri = 'data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,' + header + '\n' + html;

    var downloadLink = document.createElement("a");
    downloadLink.href = uri;
    downloadLink.download = "comentarios.xls";

    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);
  });
</script>













          

