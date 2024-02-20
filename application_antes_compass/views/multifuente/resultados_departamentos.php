<?php $meth = new Empresa(); 
if(isset($departamento)){ ?>	
<form method="POST" action="<?php echo BASEURL.'multifuente/estatus_departamento' ?>">
	<div class="col-md-8 col-md-offset-2 holder">
		<div class="row">
			<table class="table table-bordered table-striped table-hover table-heading tablesorter" id="datatable">
				<thead>
					<tr>
						<th class="header">Nombre evaluados</th>
						<th># Evaluados</th>
					</tr>
				</thead>
				<tbody>
					<!-- Start: list_row -->
					<?php foreach ($departamento as $a => $b) { ?>
					<tr>
						<td><a href="<?php echo BASEURL.'multifuente/resultados_departamento/'.$b['id'] ?>"><?php echo  $meth->htmlprnt($b['nombre']); ?></a></td>
						<td><?php echo $b['cant']; ?><div hidden><input type="text" name="id[]" value="<?php echo $b['id']; ?>"></div></td>
					</tr>
					<?php } ?> 
					<!-- End: list_row -->
				</tbody>
			</table>
		</div>
	</div>
</form>

<?php	
}else{ ?>
<div class="row text-center page-404 holder">
	<div class="col-md-12">
		<h2>No hay personal ingresado</h2>
	</div>
</div>
<?php	} ?>

