<?php

$meth = new Ajax();

if($_REQUEST)
{

	$id = $_REQUEST['emp_id'];
	$table = $_REQUEST['table_name'];
	$holder = $_REQUEST['holder'];

	$table='listado_personal_op';
	$results = $meth->DB_exists($table,'empresa',$id);
	// $_SESSION['Empresa']['id'] = $id;
	if(array_filter($results)){?>	
	<div class="col-xs-12 col-sm-12 holder">
		<table class="table table-bordered table-striped table-hover table-heading tablesorter" id="datatable">
			<thead>
				<tr>
					<th>#</th>
					<th class="header">Nombre</th>
					<th class="header">Cargo</th>
					<th class="header">&Aacute;rea</th>
				</tr>
			</thead>
			<tbody>
				<!-- Start: list_row -->
				<?php foreach ($results as $a => $b) { 
					$b = reset($b); ?>
					<tr>
						<td><input type="radio" name="id_per" value="<?php echo $b['id']; ?>" ></td>
						<td><a href="<?php echo BASEURL.'admin/personal_view/'.$b['id'] ?>"><?php echo  $meth->htmlImage_($b['foto'],'img-rounded sm-img').$meth->htmlprnt($b['nombre']); ?></a></td>
						<td><?php echo $meth->htmlprnt($b['cargo']); ?></td>
						<td><?php echo $meth->htmlprnt($b['area']); ?></td>
					</tr>
					<?php } ?> 
					<!-- End: list_row -->
				</tbody>
			</table>
			<div class="row">
				<div class="col-md-3 col-md-offset-9 show-grid">
					<input class="btn btn-default btn-xs" type="submit" name="button" value="Continuar">
				</div>
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
			<h2>No hay personal ingresado</h2>
		</div>
	</div>
	<?php	}
}
/*
*/
?>

