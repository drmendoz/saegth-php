<?php $meth = new Empresa(); 
if(isset($evaluados)){ ?>	
<form method="POST" action="<?php echo BASEURL.'multifuente/estatus_evaluado/'.$id ?>">
	<div class="col-xs-12 col-sm-12 holder">
		<p>&nbsp;</p>
		<div class="row">
			<div class="col-md-4 show-grid">
				<h3><b>Evaluado: </b><?php echo $n_ev ?></h3>
			</div>
			<div class="col-md-3 col-md-offset-5 show-grid">
				<input class="btn btn-default btn-xs" type="submit" name="button" value="Enviar recoratorio">
			</div>
		</div>
	</div>
	<table class="table table-bordered table-striped table-hover table-heading tablesorter" id="datatable">
		<thead>
			<tr>
				<th class="header">Fecha</th>
				<th class="header">Nombre</th>
				<th class="header">Relacion</th>
				<th class="header">Completo</th>
			</tr>
		</thead>
		<tbody>
			<!-- Start: list_row -->
			<?php foreach ($evaluados as $a => $b) { 
	                    	//$porcentaje = $meth->get_progressByEval($b['id_personal']); 
				switch ($b['relacion']) {
					case 0:
					$relacion = "Superior";
					break;
					case 1:
					$relacion = "Superior";
					break;
					case 2:
					$relacion = "Par";
					break;
					case 3:
					$relacion = "Subalterno";
					break;
					case 4:
					$relacion = "Auto";
					break;
				}
				switch ($b['resuelto']) {
					case 0:
					$resuelto = "No";
					break;
					case 1:
					$resuelto = "Si";
					break;
				}
				$res=$meth->query_('SELECT * FROM `personal` WHERE `id`='.$b['id_personal'].'',1); 
				?>
				<tr>
					<td><?php echo $b['fecha']; ?></td>
					<td><?php echo  $meth->htmlImage_($res['foto'],'img-rounded sm-img').$meth->htmlprnt($res['nombre_p']); ?></td>
					<td><?php echo $relacion ?></td>
					<td><?php echo $resuelto; ?><div hidden><input type="text" name="id[]" value="<?php echo $b['id_personal']; ?>"></div></td>
				</tr>
				<?php } ?> 
				<?php foreach ($evaluado as $a => $b) { 
	                    	//$porcentaje = $meth->get_progressByEval($b['id_personal']); 
					switch ($b['relacion']) {
						case 0:
						$relacion = "Gerente";
						break;
						case 1:
						$relacion = "Gerente";
						break;
						case 2:
						$relacion = "Par";
						break;
						case 3:
						$relacion = "Subalterno";
						break;
						case 4:
						$relacion = "Auto";
						break;
					}
					switch ($b['resuelto']) {
						case 0:
						$resuelto = "No";
						break;
						case 1:
						$resuelto = "Si";
						break;
					}
					$res=$meth->query_('SELECT * FROM `personal` WHERE `id`='.$b['id_personal'].'',1); 
					?>
					<tr>
						<td><?php echo $b['fecha']; ?></td>
						<td><?php echo  $meth->htmlImage_($res['foto'],'img-rounded sm-img').$meth->htmlprnt($res['nombre_p']); ?></td>
						<td><?php echo $relacion ?></td>
						<td><?php echo $resuelto; ?><div hidden><input type="text" name="id[]" value="<?php echo $b['id_personal']; ?>"></div></td>
					</tr>
					<?php } ?> 
					<!-- End: list_row -->
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

	<?php	
}else{ ?>
<div class="row text-center page-404 holder">
	<div class="col-md-12">
		<h2>No hay personal ingresado</h2>
	</div>
</div>
<?php	} ?>

