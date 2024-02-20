<?php $lp = new listado_personal_op; ?>
<table class="table table-bordered">
	<thead>
		<tr>
			<th>#</th>
			<th>Nombre</th>
			<th>Cargo</th>
			<th>Compass 360</th>
			<th>Scorecard</th>
			<th>Plan de acción</th>
			<!-- <th>Preferencia de carrera</th> -->
		</tr>
	</thead>
	<tbody>
	<?php foreach ($res as $key => $value) { ?>
	<?php $lp->cast($value) ?>
		<tr>
			<td><?php echo $key+1 ?></td>
			<td><a href="<?php echo BASEURL ?>user/view/<?php echo $lp->id ?>"><?php echo $lp->getNombre() ?></a></td>
			<td><?php echo $lp->getCargo() ?></td>
			<td>
				<?php if($lp->getCompass_360()){ ?>
				<a href="<?php echo BASEURL ?>multifuente/resultados/<?php echo $lp->id ?>">Ver resulados</a>
				<?php }else{ ?>
				No habilitado
				<?php } ?>
			</td>
			<td>
				<?php if($lp->getScorer()){ ?>
				<a href="<?php echo BASEURL ?>scorecard/confirmacion/<?php echo $lp->id ?>">Ver scorecard</a>
				<?php }else{ ?>
				Scorecard no esta activado
				<?php } ?>
			</td>
			<td>
				<?php if($lp->getCompass_360() || $lp->getScorer()){ ?>
				<a href="<?php echo BASEURL ?>multifuente/plan/<?php echo $lp->id ?>">link</a>
				<?php }else{ ?>
				no-link
				<?php } ?>
			</td>
			<!-- <td></td> -->
		</tr>
		<?php } ?>
	</tbody>
</table>