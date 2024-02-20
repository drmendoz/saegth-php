<?php 
	$meth = new Util();
?>
	<div class="row">
		<div class="col-md-12 show-grid">
			<h3 align="center">Logo de la empresa</h3>
		</div>
	</div>
	<p>&nbsp;</p>
	<form action="<?php echo BASEURL ?>empresa/logo" method="POST" enctype="multipart/form-data">
		<div class="row">
			<div class="col-md-3 col-md-offset-3 show-grid">
				<h4>Seleccionar imagen</h4>
			</div>
            <div class="col-md-3">
				<input accept="image/jpg, image/gif, image/png, image/jpeg" required="required" type="file" name="file" id="file" class="input-file">
            </div>
		</div>
		<div class="row">
			<div class="col-md-3 col-md-offset-6 show-grid">
				<input class="btn btn-default btn-xs" type="submit" name="button" value="Continuar">
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 text-center show-grid">
				<?php echo $_SESSION['logo']; ?>
			</div>
		</div>
	</form>

