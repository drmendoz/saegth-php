<?php $meth= new Void(); ?>
	<div class="row">
		<div class="col-md-12 show-grid">
			<h3 align="center">Administrador</h3>
		</div>
	</div>
	<p>&nbsp;</p>
	<?php 
		if(isset($id)){
			$fr = "/".$id;
		}else{
			$fr = "";
		}
	?>
	<form action="<?php echo BASEURL ?>admin/empresa_ingreso<?php echo $fr ?>" method="POST">
		<div class="row">
			<div class="col-md-3 col-md-offset-3 show-grid">
				<h4>Nombre de la Empresa</h4>
			</div>
			<div hidden>
				<input type="text" value="<?php if(isset($tk)){echo $tk;} ?>">
			</div>
			<div class="col-md-3 show-grid">
				<input type="text" required="required" name="nuevaEmpresa" <?php if(isset($id)){echo 'readonly="readonly"';} ?> class="form-control" placeholder="Nombre de la empresa" value="<?php if(isset($name)){echo $name;} ?>">
			</div>
		</div>
		<div class="row">
			<div class="col-md-3 col-md-offset-3 show-grid">
				<h4>Administrador de la empresa</h4>
			</div>
			<div class="col-md-3 show-grid">
				<input type="text" required="required" name="admin" class="form-control" placeholder="Nombre del administrador" value="<?php if(isset($admin)){echo $admin;} ?>">
			</div>
		</div>
		<div class="row">
			<div class="col-md-3 col-md-offset-3 show-grid">
				<h4>E-mail</h4>
			</div>
			<div class="col-md-3 show-grid">
				<input type="text" required="required" name="correo" class="form-control" placeholder="Correo del administrador" value="<?php if(isset($email)){echo $email;} ?>">
			</div>
		</div>
		<div class="row">
			<div class="col-md-3 col-md-offset-3">
				<h4>Evaluaciones</h4>
			</div>
<?php foreach ($serv as $key => $value) { $value=reset($value);$sep="";if($key > 0) $sep="row col-md-offset-6"?>
			<div class="<?php echo $sep ?> col-md-3 show-grid">
				<input type="checkbox" name="eval[]" value="<?php echo $value['id'] ?>"> <?php echo $meth->htmlprnt($value['nombre']); ?>
			</div>
<?php } ?>
		</div>
		<div class="row">
			<div class="col-md-3 col-md-offset-6 show-grid">
				<input class="btn btn-default btn-xs" type="submit" name="button" value="Continuar">
			</div>
		</div>
	</form>

