<?php
$meth = new Empresa();
if(isset($personal)){
?>

<form method="POST" action="<?php echo BASEURL.'sonda/enviar_recordatorio'; ?>">
	<div class="col-md-9">
		<p>&nbsp;</p>
		<div class="row">
			<div class="col-md-9">
				<h4>ESTADO DEL PROCESO.- Porcentaje de Cumplimiento: <?php echo $porc_cumplimiento; ?>%</h4>
			</div>
			<input class="btn btn-default btn-xs" type="submit" name="button" value="Enviar recoratorio">
		</div>
		<?php
		if (isset($alert_email)) {
		?>
		<div class="alert alert-info" role="alert"><h4><?php echo $alert_email ?></h4></div>
		<?php
		}
		?>
	</div>
	<div class="col-md-7">
		<table class="table table-bordered table-striped table-hover table-heading tablesorter" id="datatable">
			<thead>
				<tr>
					<th class="header">#</th>
					<th class="header">Nombre</th>
					<th class="header">Completo</th>
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
					<td><?php echo $b['resuelto']; ?>
					<?php
					if($b['resuelto'] == 'No'){
					?>
					<div hidden><input type="text" name="id[]" value="<?php echo $b['id_personal']; ?>">
					<?php
					}
					?>
				</tr>
			<?php
				$cont++;
			}
			?>
			</tbody>
		</table>
	</div>
</form>

<?php
}else{
?>
	<div class="alert alert-info" role="alert"><h4>No hay evaluaci&oacute;n en curso</h4></div>
<?php
}
?>

<script type="text/javascript">
	$(document).ready(function()
	{
		$("#datatable").tablesorter(); 
	}
	);
</script>