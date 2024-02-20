<?php $meth = new Empresa(); 
	if(isset($departamento)){ ?>	
		<form method="POST" action="<?php echo BASEURL.'multifuente/estatus_departamento' ?>">
			<div class="col-md-8 col-md-offset-2 holder">
				<p>&nbsp;</p>
				<div class="row">
					<div class="col-md-3 col-md-offset-9 show-grid">
						<input class="btn btn-default btn-xs" type="submit" name="button" value="Enviar recoratorio masivo">
					</div>
				</div>
				<div class="row">
					<table class="table table-bordered table-striped table-hover table-heading tablesorter" id="datatable">
						<thead>
		                    <tr>
		                        <th class="header">Nombre evaluados</th>
		                        <th>% Evaluados</th>
		                    </tr>
		                </thead>
		                <tbody>
		                <!-- Start: list_row -->
		                    <?php foreach ($departamento as $a => $b) { 
		                    	$b = reset($b);
		                    	$porcentaje = $meth->get_progressByArea($b['id']); ?>
		                        <tr>
		                            <td><a href="<?php echo BASEURL.'multifuente/estatus_departamentos/'.$b['id'] ?>"><?php echo  $meth->htmlprnt($b['nombre']); ?></a></td>
		                            <td><?php printf("%.2f%%", $porcentaje); ?><div hidden><input type="text" name="id[]" value="<?php echo $b['id']; ?>"></div></td>
		                        </tr>
		                    <?php } ?> 
		                <!-- End: list_row -->
		                </tbody>
					</table>
				</div>
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

