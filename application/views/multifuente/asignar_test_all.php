<?php
  $meth = new Multifuente();
?>
<p>&nbsp;</p>
<form action="<?php echo BASEURL ?>multifuente/asignar_test_all" method="POST">
  <div class="row">
    <p class="text-center">&nbsp;</p>
    <div class="col-xs-12 col-sm-12">
<?php if($evaluado){ ?>
        <table class="table table-bordered table-striped table-hover table-heading tablesorter" id="datatable">
            <thead>
                <tr>
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
