<?php 
$lp = new listado_personal_op();
$lp->setId($_SESSION['USER-AD']['id_personal']);
$res=$lp->getSubalternos__();
if($res){
	?>
	<div class="col-md-8">
		<table class="table table-bordered">
			<tr>
				<th>#</th>
				<th>Nombre</th>
				<th>Cargo</th>
			</tr>
			<?php 
			foreach ($res as $key => $value) { 
				$lp->cast($value);
				?>
			<tr>
				<td><?php echo $key+1 ?></td>
				<td><a href="<?php echo BASEURL ?>test/desarrollo/<?php echo $lp->getId() ?>"><?php echo $lp->getNombre() ?></a></td>
				<td><?php echo $lp->getCargo() ?></td>
			</tr>
			<?php } ?>
		</table>
	</div>
	<?php }else{ ?>
	<div class="alert alert-warning col-md-12">
		<h2>No tiene subalternos</h2>
	</div>
	<?php } ?>