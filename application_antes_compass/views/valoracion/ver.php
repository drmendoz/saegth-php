<div class="col-md-12">
	<h3 class="form-group">Valoraciones Creadas</h3>
	<table class="table table-hover table-bordered">
		<tr>
			<th class="col-md-3">Position</th>
			<th class="col-md-2" colspan="2">Know How</th>
			<th class="col-md-2" colspan="2">Problem Solving</th>
			<th class="col-md-2" colspan="2">Accountability</th>
			<th class="col-md-1">Total</th>
			<th class="col-md-1">Profile</th>
			<th class="col-md-1">Acciones</th>
		</tr>
	<?php foreach ($res as $key => $value) { $ent = new Valoracion($value); ?>
		<tr>
			<td class="col-md-3"><?php echo $ent->htmlprnt($ent->position); ?></td>
			<td class="col-md-1"><?php echo $ent->knowhowi(); ?></td>
			<td class="col-md-1"><?php echo $ent->knowhowj(); ?></td>
			<td class="col-md-1"><?php echo $ent->problemsoli(); ?></td>
			<td class="col-md-1"><?php echo $ent->problemsolj(); ?></td>
			<td class="col-md-1"><?php echo $ent->accounti(); ?></td>
			<td class="col-md-1"><?php echo $ent->accountj(); ?></td>
			<td class="col-md-1"><?php echo $ent->total; ?></td>
			<td class="col-md-1"><?php echo $ent->profile; ?></td>
			<td class="col-md-1">
				<a href="<?php echo BASEURL ?>valoracion/clonar/<?php echo $ent->id ?>">Clonar</a>
				/
				<a href="<?php echo BASEURL ?>valoracion/editar/<?php echo $ent->id ?>">Editar</a>
			</td>
		</tr>
	<?php } ?>
	</table>
</div>