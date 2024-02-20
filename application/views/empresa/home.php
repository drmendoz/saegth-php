<?php 
?>
<p>&nbsp;</p><?php $meth = new Empresa(); ?>
<div class="row show-grid menu-grid text-center">
	<legend>Empresa</legend>
	<div class="col-sm-3">
		<a href="<?php echo BASEURL.'empresa/modificar' ?>">Editar datos de empresa</a>
	</div>
</div>
<div class="row show-grid menu-grid text-center">
	<legend>Personal</legend>
	<div class="col-sm-3">
		<a href="<?php echo BASEURL.'personal/viewall' ?>">Ver personal</a>
	</div>
	<div class="col-sm-3">
		<a href="<?php echo BASEURL.'personal/datos_empresa' ?>">Ingreso nuevo personal</a>
	</div>
	<!--
	<h1>No hay contenido que mostrar</h1>
	<div class="col-sm-3">
		<a href="<?php echo BASEURL.'user/logout' ?>">HEY HEY THIS DOESNT WORK</a>
	</div>
	<div class="col-sm-3">
		<a href="<?php echo BASEURL.'user/logout' ?>">HEY HEY THIS DOESNT WORK</a>
	</div>
-->
</div>
<div class="row show-grid menu-grid text-center">
	<legend>Evaluaciones</legend>
	<div class="col-sm-3">
		<a href="<?php echo BASEURL.'multifuente/home' ?>">Multifuentes</a>
	</div>
</div>
<?php 
     ?>