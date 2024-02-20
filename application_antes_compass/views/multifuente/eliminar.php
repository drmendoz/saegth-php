<?php

$meth = new Ajax();
if(isset($results)){
  if(array_filter($results))
  {?> 
  <form method="POST" action="<?php echo BASEURL.'multifuente/eliminar' ?>">
    <div class="col-xs-12 col-sm-12 holder">
				<p class="text-center">Al eliminar un evualuado también se elimina a los evaluadores (pares, superiores, subalternos).</p>
    <div class="box">
      <div class="box-header">
        <div class="box-name ui-draggable-handle">
          <i class="fa fa-table"></i>
          <span>Personal</span>
        </div>
        <div class="box-icons">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
          <a class="expand-link">
            <i class="fa fa-expand"></i>
          </a>
        </div>
        <div class="no-move"></div>
      </div>
      <div class="box-content no-padding">
				<table class="table table-bordered table-striped table-hover table-heading table-datatable" id="datatable-1">
					<thead>
              <tr>
                  <th>#</th>
                  <th>Nombre</th>
              </tr>
          </thead>
          <tbody>
          <!-- Start: list_row -->
              <?php foreach ($results as $a => $b) { 
                $b = reset($b); 
                $p = $meth->DB_exists('personal','id',$b['id_personal']);
                $p = $p[0];
                $p = $p['Personal'];
                ?>
                  <tr>
                      <td><input type="checkbox" name="id_per[]" value="<?php echo $b['id_personal'].','.$b['cod_evaluado']; ?>" ></td>
                      <td><a href="<?php echo BASEURL.'personal/view/'.$b['id_personal'] ?>"><?php echo  $meth->htmlImage_($p['foto'],'img-rounded sm-img').$meth->htmlprnt($p['nombre_p']); ?></a></td>
                  </tr>
                        <?php } ?> 
                    <!-- End: list_row -->
                    </tbody>
				</table>
			</div>
		</div>
	<div class="row">
			<div class="col-md-3 col-md-offset-9 show-grid">
				<input class="btn btn-default btn-xs" type="submit" name="button" value="Continuar">
			</div>
		</div>
	</div>
				
  </form>
	<?php	
	}else{ ?>
		<div class="row text-center page-404 holder">
			<div class="col-md-12">
			    <h2><?php echo $msg; ?></h2>
			</div>
		</div>
<?php	}
}
/*
*/
?>

