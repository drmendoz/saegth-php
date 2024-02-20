<form method="POST" action="<?php echo BASEURL.'sonda/enviar_email_encuesta'; ?>">
	<div class="col-md-9">
		<p>&nbsp;</p>
		<div class="row">
			<div class="col-md-9">
				<h4>ENVIAR EMAIL DE ENCUESTA ACTUAL</h4>
			</div>
			<input class="btn btn-default btn-xs" type="submit" name="button" value="Enviar email">
		</div>
	</div>
	<div class="col-md-7">
		<table class="table table-bordered table-striped table-hover table-heading tablesorter" id="datatable">
			<thead>
				<tr>
					<th class="header">#</th>
					<th class="header">Nombre</th>
					<th class="header">Email enviado</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$cont = 1;
			foreach ($personal as $a => $b) {
				$res=$meth->query_('SELECT * FROM `personal` WHERE `id`='.$b['id_personal'].'',1);
			?>
				<tr>
					<td><?php echo $cont; ?></td>
				<td><?php echo  $meth->htmlImage_($res['foto'],'img-rounded sm-img').$meth->htmlprnt($res['nombre_p']); ?></td>
					
					<td>
						<?php echo $b['email_enviado']; ?>
						<div hidden>
							<input type="text" name="id[]" value="<?php echo $b['id_personal']; ?>">
							<input type="text" name="email_enviado[]" value="<?php echo $b['e_env']; ?>">
						</div>
					</td>
				</tr>
			<?php
				$cont++;
			}
			?>
			</tbody>
		</table>
	</div>
</form>

<script type="text/javascript">
	$(document).ready(function()
	{
		$("#datatable").tablesorter(); 
	}
	);
</script>
