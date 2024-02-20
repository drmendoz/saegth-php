
<p>&nbsp;</p>
<div class="col-xs-12 col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
	<div class="box">
		<div class="box-content">
			<div class="text-center">
				<h3 class="page-header">Iniciar Sesi&oacute;n</h3>
			</div>
			<form action="<?php echo BASEURL ?>user/login/<?php echo $tk ?>" method="POST">
				<div class="form-group">
					<label class="control-label">Usuario</label>
					<input type="text" class="form-control" name="username" />
				</div>
				<div class="form-group">
					<label class="control-label">Contrase&ntilde;a</label>
					<input type="password" class="form-control" name="password" />
				</div>
				<?php if(isset($disc)) { ?>
					<div class="text-center">
						<p><?php echo $disc ?></p>
					</div>
				<?php } ?>
				<div class="text-center">
					<input class="btn btn-primary btn-xs" type="submit" name="button" value="Continuar">
				</div>
			</form>
		</div>
	</div>
</div>
