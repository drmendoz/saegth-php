<style type="text/css">

	select {height: 120px !important}
	input{cursor: pointer;}

	#area_seg{height: 400px !important}

	#tblPorcentajes div{

		border: 2px solid #CCC;

		border-radius: 3px;

		margin: 3px;

		height: 15px;

	}

	@media screen and (min-width: 768px) {

		#myModal .modal-dialog {

			width: 1200px;

		}

	}

</style>

<?php

if(isset($mensaje))
{
	echo '<div class="alert alert-info" role="alert">'.$mensaje.'</div>';
}

if (is_array($evaluado)) {

?>

<form  action="<?php echo BASEURL.'multifuente/reiniciar' ?>" method="POST">

	<h4><a class="btn btn-default" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Filtrar criterios</a></h4>

	<div class="collapse" id="collapseExample">

		<div class="well">

			<?php  ?>

				<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">

					<div class="panel-heading">Edad</div>

					<div class="panel-body">

						<select multiple name="edad[]" class="form-control">

							<option style="display:none">Seleccione una opción</option>

							<option value="0">Menor a 20 años</option>

							<option value="1">De 20 a 25 años</option>

							<option value="2">De 25 a 30 años</option>

							<option value="3">De 30 a 40 años</option>

							<option value="4">De 40 a 50 años</option>

							<option value="5">Más 50 años</option>

						</select>

					</div>

				</div>

			<?php  ?>

			<?php  ?>

				<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">

					<div class="panel-heading">Antigüedad</div>

					<div class="panel-body">

						<select multiple name="antiguedad[]" class="form-control">

							<option style="display:none">Seleccione una opción</option>

							<option value="1">Menos de 2</option>

							<option value="2">De 2 a 5 años</option>

							<option value="3">De 5 a 10 años</option>

							<option value="4">De 10 a 15 años</option>

							<option value="5">De 15 a 20 años</option>

							<option value="6">Más 20 años</option>

						</select>

					</div>

				</div>

			<?php  ?>

			<?php  ?>

				<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">

					<div class="panel-heading">Localidades</div>

					<div class="panel-body">

						<select multiple name="localidad[]" class="form-control">

							<option style="display:none">Seleccione una opción</option>

							<?php

							$test = new Empresa_local();

							$test->get_select_options_($_SESSION['Empresa']['id']);

							?>

						</select>

					</div>

				</div>

			<?php  ?>

			<?php  ?>

				<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">

					<div class="panel-heading">Niveles Organizacionales</div>

					<div class="panel-body">

						<select multiple name="norg[]" class="form-control">

							<option style="display:none">Seleccione una opción</option>

							<?php

							$test = new Empresa_norg();

							$test->get_select_options($_SESSION['Empresa']['id']);

							?>

						</select>

					</div>

				</div>

			<?php  ?>

			<?php  ?>

				<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">

					<div class="panel-heading">Tipo de contrato</div>

					<div class="panel-body">

						<select multiple name="tcont[]" class="form-control">

							<option style="display:none">Seleccione una opción</option>

							<?php

							$test = new Empresa_tcont();

							$test->get_select_options($_SESSION['Empresa']['id']);

							?>

						</select>

					</div>

				</div>

			<?php  ?>

			<?php  ?>

				<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">

					<div class="panel-heading">Educación</div>

					<div class="panel-body">

						<select multiple name="educacion[]" class="form-control">

							<option style="display:none">Seleccione una opción</option>

							<option value="0">Primaria incompleta</option>

							<option value="1">Primaria completa</option>

							<option value="2">Secundaria incompleta </option>

							<option value="3">Secundaria completa </option>

							<option value="4">Universidtaria incompleta</option>

							<option value="5">Universitaria completa</option>

							<option value="6">Postgrado</option>

						</select>

					</div>

				</div>

			<?php  ?>

			<?php  ?>

				<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">

					<div class="panel-heading">Sexo</div>

					<div class="panel-body">

						<select multiple name="sexo[]" class="form-control">

							<option style="display:none">Seleccione una opción</option>

							<option value="0">Masculino</option>

							<option value="1">Femenino</option>

						</select>

					</div>

				</div>

			<?php  ?>

			<?php  ?>

				<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">

					<div class="panel-heading">Departamento</div>

					<div class="panel-body">

						<select multiple id="area_seg" name="departamento[]" class="form-control">

							<option style="display:none">Seleccione una opción</option>

							<?php

							$test = new Empresa_area();

							$test->get_select_options($_SESSION['Empresa']['id']);

							?>

						</select>

					</div>

				</div>

			<?php  ?>

			<div class="clearfix"></div>

		</div>

	</div>

	<div class="clearfix"></div>

	<div class="text-center"><input type="submit" value="Filtrar" name="filtro" class="btn btn-sm btn-default"> </div>

	<div class="clearfix"></div>

	

	<p><br></p>

	<div class="col-md-3 col-xs-3 form-group">

		<input type="text" id="search" class="form-control" placeholder="Buscar">

	</div>

	

	<div id="personal" class="col-xs-10">

		<table class="table table-bordered table-striped table-hover table-heading table-datatable" id="table">

			<thead>

				<tr>

					<th class="header">#</th>

					<th class="header">Nombre</th>

			        <th class="header">Cargo</th>

				</tr>   

			</thead>

			<tbody>

			<?php foreach ($evaluado as $a => $b) { 

				//$b = reset($b); ?>

				<tr>

					<td><input type="checkbox" name="id_per[]" value="<?php echo $b['id']; ?>" ></td>

					<td><?php echo  $meth->htmlImage_($b['foto'],'img-rounded sm-img').$meth->htmlprnt($b['nombre']); ?></td>

					<td><?php echo $meth->htmlprnt($b['cargo']); ?></td>

				</tr>

			<?php } ?> 

			</tbody>

		</table>

	</div>

	<div class="clearfix"></div>
	<div class="text-center">
		<input type="submit" value="Reinicio Individual" id="reinicio_individual" name="reinicio_individual" class="btn btn-default btn-xs">
		<input type="submit" value="Iniciar nuevo perido" id="reinicio_masivo" name="reinicio_masivo" class="btn btn-default btn-xs">
	</div>
	<div class="clearfix"></div>

</form>

<?php

}else{

	echo "<h3>No hay evaluadores</h3>";

}

?>

<script type="text/javascript">

	$('#search').keyup(function() {

		var val = '^(?=.*\\b' + $.trim($(this).val()).split(/\s+/).join('\\b)(?=.*\\b') + ').*$',

		reg = RegExp(val, 'i'),

		text;



		var $rows = $('#table tbody tr');

		$rows.show().filter(function() {

			text = $(this).text().replace(/\s+/g, ' ');

			return !reg.test(text);

		}).hide();

	});

</script>