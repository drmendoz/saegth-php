<?php $meth = new Empresa(); 
if(isset($evaluados)){ ?>	
<form method="POST" action="<?php echo BASEURL.'multifuente/estatus_departamentos/'.$id ?>">
	<div class="col-md-8 col-md-offset-2">
		<p>&nbsp;</p>
		<div class="row">
			<div class="col-md-3 col-md-offset-9 show-grid">
				<input class="btn btn-default btn-xs" type="submit" name="button" value="Enviar recoratorio masivo">
			</div>
		</div>
		<table class="table table-bordered table-striped table-hover table-heading tablesorter" id="datatable">
			<thead>
				<tr>
					<th class="header">Nombre evaluados</th>
					<th class="header">Cargo</th>
					<th class="header">&Aacute;rea</th>
					<th>% Evaluados</th>
				</tr>
			</thead>
			<tbody>
				<!-- Start: list_row -->
				<?php foreach ($evaluados as $a => $b) { 
					$b = reset($b);
					$porcentaje = $meth->get_progressByEval($b['id']); ?>
					<tr>
						<td><a href="<?php echo BASEURL.'multifuente/estatus_evaluado/'.$b['id'] ?>"><?php echo  $meth->htmlImage_($b['foto'],'img-rounded sm-img').$meth->htmlprnt($b['nombre']); ?></a></td>
						<td><?php echo $meth->htmlprnt($b['cargo']) ?></td>
						<td><?php echo $meth->htmlprnt($b['area']) ?></td>
						<td><?php printf("%.2f%%", $porcentaje); ?><div hidden><input type="text" name="id[]" value="<?php echo $b['id']; ?>"></div></td>
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

