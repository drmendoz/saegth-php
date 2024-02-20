<?php 
	$pe = new Personal_empresa();
	//$res=$pe->get_sub_id_level_op($_SESSION['USER-AD']['id_personal'],1,1);
	// By JPazmino
	$res=$pe->get_sub_id_level_op_($_SESSION['USER-AD']['id_personal'],1,1);
	if($res){
	?>
	<div class="col-md-8">
		<table class="table table-bordered">
			<tr>
				<th>#</th>
				<th>Nombre</th>
				<th>Acción</th>
			</tr>
		
			<?php
				foreach ($res as $key => $value) {
				?>
				<tr>
				<td><?php echo $key+1 ?></td>
				<td><?php echo $pe->htmlprnt($value['nombre']) ?></td>
				<td><a href="<?php echo BASEURL."user/confirmar_relacion/".$value['id'] ?>">Revisar y Aprobar</a></td>
				</tr>
				<?php 
				}
			?>
		</table>
	</div>
	<?php
	}else{
	?>
	<div class="alert alert-warning col-md-12">
		<h2>No tiene pendientes</h2>
	</div>
	<?php
	}
?>