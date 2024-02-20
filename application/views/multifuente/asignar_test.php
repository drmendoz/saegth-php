<?php
  $meth = new Multifuente();
?>
<p>&nbsp;</p>
<form action="<?php echo BASEURL ?>multifuente/asignar_test" method="POST">
  <div class="row">
    <div class="col-md-9 form-group">
        <label class="col-md-offset-3 col-md-4">Test</label>
        <div class="col-md-5">
            <?php //var_dump($test); ?>
           <select required="required" class="form-control empresa-select" name="test" placeholder="Ingreso de nueva empresa">
              <option value="">-- Seleccione un test --</option>
            <?php    
              foreach ($test as $a => $b) {
                $c = $b['Multifuente_test'];
                // var_dump($c);
                echo '<option value="'. $c['cod_test'] . '" >'. Util::htmlprnt($c['nombre_test']) . '</option>';
              }
            ?>    
            </select> 
        </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-9 form-group">
        <label class="col-md-offset-3 col-md-4">Fecha m&aacute;xima de resoluci&oacute;n</label>
        <div class="col-md-5">
            <input type="date"  required="required" class="form-control" name="f_max" min="<?php echo date('dd/mm/yyyy'); ?>" placeholder="Fecha M&aacute;xima" >
        </div>
    </div>
  </div>
  <div class="row">
    <p class="text-center"><a href="<?php echo BASEURL.'multifuente/asignar_test_all'; ?>">Historial de Test Asignados</a></p>
    <p class="text-center">&nbsp;</p>
    <p class="text-center">Seleccionar a los evaluados</p>
    <p class="text-center">&nbsp;</p>
    <div class="col-xs-12 col-sm-12">
<?php if($evaluado){ ?>
        <table class="table table-bordered table-striped table-hover table-heading tablesorter" id="datatable">
            <thead>
                <tr>
                    <th>#</th>
                    <th class="header">Nombre</th>
                    <th class="header">Cargo</th>
                    <th class="header">&Aacute;rea</th>
                    <th class="header">Evaluación</th>
                    <th class="header">Fecha</th>
                </tr>
            </thead>
            <tbody>
            <!-- Start: list_row -->
                <?php foreach ($evaluado as $a => $b) { 
                    //$b = reset($b); ?>
                    <tr>
                        <td><input type="checkbox" name="id_per[]" value="<?php echo $b['id']; ?>" ></td>
                        <td><a href="<?php echo BASEURL.'personal/view/'.$b['id'] ?>"><?php echo  $meth->htmlImage_($b['foto'],'img-rounded sm-img').$meth->htmlprnt($b['nombre']); ?></a></td>
                        <td><?php echo $meth->htmlprnt($b['cargo']); ?></td>
                        <td><?php echo $meth->htmlprnt($b['area']); ?></td>
                        <td><?php echo $meth->htmlprnt($b['codigo']); ?></td>
                        <td><?php echo $meth->htmlprnt($b['fecha_e']); ?></td>
                    </tr>
                <?php } ?> 
            <!-- End: list_row -->
            </tbody>
        </table>
    </div>
    <div class="row">
        <div class="col-md-3 col-md-offset-9 show-grid">
            <input class="btn btn-default btn-xs" type="submit" name="button" value="Continuar">
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function()
            {
                $("#datatable").tablesorter(); 
            }
        );
    </script>
                        
    <?php   
    }else{ ?>
        <div class="row text-center page-404 holder">
            <div class="col-md-12">
                <h2>No hay personal disponible</h2>
                <h3>Verifique si el personal esta habilitado para la evaluacion Compass 360 </h3>
                <small>"Filtrar columna Compass 360 "</small>
                <p><a href="<?php echo BASEURL.'personal/viewall'; ?>">Ver listado del personal</a></p>
            </div>
        </div>
<?php   } ?>
    </div>
</form>
