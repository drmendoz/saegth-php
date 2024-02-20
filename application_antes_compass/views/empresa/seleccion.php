<?php 
	$meth = new Util();
	$empresas = $_SESSION['USER-AD']['empresas'];
?>
	<div class="row">
		<div class="col-md-12 show-grid">
			<h3 align="center">Administrador</h3>
		</div>
	</div>
	<p>&nbsp;</p>
	<form action="<?php echo BASEURL ?>admin/empresa_seleccion/<?php echo $_SESSION['next'] ?>" method="POST">
		<div class="row">
			<div class="col-md-3 col-md-offset-3 show-grid">
				<h4>Elegir Empresa</h4>
			</div>
			<div class="col-md-3 show-grid">
				<select required="required" class="form-control" name="selectEmpresa" placeholder="Ingreso de nueva empresa">
					<?php
						foreach ($empresas as $a => $b) {
							$c = $b['Empresa'];
							echo '<option value="'. $c['id'] .'" >'. $meth->htmldisplay($c['nombre']) .'</option>';
						}
					?>		
					</select>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3 col-md-offset-6 show-grid">
				<input class="btn btn-default btn-xs" type="submit" name="button" value="Continuar">
			</div>
		</div>
	</form>

