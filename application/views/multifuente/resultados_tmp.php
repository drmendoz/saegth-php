<?php $meth = new User(); $util = new Util(); //var_dump($temas)?>
  <div class="row form-group col-md-12">
      <img src="<?php echo BASEURL ?>img/Compass.png" style="width: 200px;">
      <h3 class="text-center">Evaluación multifuentes</h3>
  </div>
  <div class="row form-group col-md-12">
      <table class="table-bordered"  style="width: 100%; line-height: 40px;">
        <tr>
          <td class="col-md-4"><b>PERSONAL: </b><?php echo $nombre; ?></td>
          <td class="col-md-4"><b>CARGO: </b><?php echo $cargo; ?></td>
          <td class="col-md-4"><b>SUPERVISOR DIRECTO: </b><?php echo $superior; ?></td>
        </tr>
        <tr>
          <td class="col-md-4"><b>EMPRESA: </b><?php echo $_SESSION['Empresa']['nombre']; ?></td>
          <td class="col-md-4"><b>&Aacute;REA: </b><?php echo $area; ?></td>
          <td class="col-md-4"><b>FECHA DE EVALUACION: </b><?php echo $meth->print_fecha($fecha); ?></td>
        </tr>
      </table>
  </div>
  
  <div class="row form-group text-center">
    <a href="<?php echo BASEURL.'multifuente/plan/'.$id ?>" class="btn-primary btn-xs" style="padding: 7px 5px; margin:5px 0">Visualizar plan de Acci&oacute;n</a>
    <a href="<?php echo BASEURL.'pdf/multifuente/'.$id.DS.$_SESSION['evaluado']['id'] ?>" class="btn-info btn-xs" style="padding: 7px 5px; margin:5px 0">Descargar resultados como PDF</a>
  </div>
<?php  if(isset($_SESSION['evaluado']['otras'])) { //var_dump($_SESSION['evaluado']['otras'])?>
    <div class="row form-group text-center col-md-8 col-md-offset-2">
      <p>Ver otras evaluaciones</p>
      <table>
        <thead align="center">
        <tr>
          <th align="center">Reportes Compass 360 previos</th>
          <th align="center">Fecha</th>
        </tr>
        </thead>
        <tbody align="left">
 <?php foreach ($_SESSION['evaluado']['otras'] as $a => $b) { $b=reset($b);?>
          <tr>
            <td class="col-md-4"><p><a href="<?php echo BASEURL.'multifuente/resultados/'.$id.'/'.$b['cod_test'].'/'.$b['cod_evaluado'] ?>"><?php echo Util::htmlprnt($meth->get_test($b['cod_test'])) ?></a></p></td>
            <td class="col-md-4"><p><?php echo date("F j, Y", strtotime($b['fecha'])); ?></p></td>
          </tr>              
  <?php } ?>
        </tbody>
      </table>
    </div>
<?php } ?>