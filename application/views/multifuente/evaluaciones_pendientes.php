<?php 
	$me = new Multifuente_relacion();
	//$res=$me->select_unresolved($_SESSION['USER-AD']['id_personal']);
	if($res){
		?>
		<div class="col-md-8">
			<table class="table table-bordered">
				<tr>
					<th>#</th>
					<th>Nombre del evaluado</th>
					<th>Relación</th>
					<th>Acción</th>
				</tr>
				<?php foreach ($res as $key => $value) { ?>
				<tr>
					<td><?php echo $key+1 ?></td>
					<td><?php echo $me->htmlprnt($value['nombre_p']) ?></td>
					<td><?php echo $me->getRelacion_($value['relacion']) ?></td>
					<td><a href="<?php echo BASEURL."user/multifuente/".$value['cod_evaluado'] ?>">Terminar evaluación</a></td>
				</tr>
				<?php } ?>
			</table>
		</div>
	<?php
	}else{
	?>
	<div class="alert alert-warning col-md-12">
		<!--<h2>No tiene evaluaciones pendientes</h2>-->
		<h3 class="bg-warning text-center" style="padding:10px;">No hay evaluación en curso</h3>
	</div>
	<?php
	}

?>