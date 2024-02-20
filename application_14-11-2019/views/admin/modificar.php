	<div class="row">
		<div class="col-md-12 show-grid">
			<h3 align="center">Administrador</h3>
		</div>
	</div>
	<p>&nbsp;</p>
	<form action="<?php echo BASEURL ?>admin/empresa_ingreso" method="POST">
		<div class="row">
			<div class="col-md-3 col-md-offset-3 show-grid">
				<h4>Crear Empresa</h4>
			</div>
			<div class="col-md-3 show-grid">
				<input type="text" required="required" name="nuevaEmpresa" class="form-control" placeholder="Ingreso de nueva empresa">
			</div>
		</div>
		<div class="row">
			<div class="col-md-3 col-md-offset-6 show-grid">
				<input class="btn btn-default btn-xs" type="submit" name="button" value="Continuar">
			</div>
		</div>
	</form>

