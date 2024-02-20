<style type="text/css">
	.table > tbody > tr > th,
	.table > tbody > tr > td{
		padding: 5px !important;
	}
</style>
<?php
$sonda = new Sonda();
$sonda->select($id_e,$id_t);
$seg = $sonda->getSegmentacion();
$temas = $sonda->getTemas();
?>
<form class="form" method="POST" action="<?php echo BASEURL ?>sonda/test/<?php echo $id_e ?>/<?php echo $id_t ?>">
	<?php if (in_array("edad", $seg)): ?>
		<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
			<div class="panel-heading">Edad</div>
			<div class="panel-body">
				<select required="required" name="edad" class="form-control">
					<option style="display:none">Seleccione una opción</option>
					<option value="0">Menor a 20 años</option>
					<option value="1">De 20 a 25 años </option>
					<option value="2">De 25 a 30 años </option>
					<option value="3">De 30 a 40 años</option>
					<option value="4">De 40 a 50 años</option>
					<option value="5">Más 50 años</option>
				</select>
			</div>
		</div>
	<?php endif ?>
	<?php if (in_array("antiguedad", $seg)): ?>
		<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
			<div class="panel-heading">Antigüedad</div>
			<div class="panel-body">
				<select required="required" name="antiguedad" class="form-control">
					<option style="display:none">Seleccione una opción</option>
					<option value="1">Menos de 2 años</option>
					<option value="2">De 2 a 5 años</option>
					<option value="3">De 5 a 10 años</option>
					<option value="4">De 10 a 15 años</option>
					<option value="5">De 15 a 20 años</option>
					<option value="6">Más 20 años</option>
				</select>
			</div>
		</div>
	<?php endif ?>
	<?php if (in_array("localidad", $seg)): ?>
		<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
			<div class="panel-heading">Localidades</div>
			<div class="panel-body">
				<select required="required" name="localidad" class="form-control">
					<option style="display:none">Seleccione una opción</option>
					<?php
					$test = new Empresa_local();
					$test->get_select_options($_SESSION['Empresa']['id']);
					?>
				</select>
			</div>
		</div>
	<?php endif ?>
	<?php if (in_array("departamento", $seg)): ?>
		<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
			<div class="panel-heading">Departamento</div>
			<div class="panel-body">
				<select required="required" name="area" class="form-control">
					<option style="display:none">Seleccione una opción</option>
					<?php
					$test = new Empresa_area();
					$test->get_select_options($_SESSION['Empresa']['id']);
					?>
				</select>
			</div>
		</div>
	<?php endif ?>
	<?php if (in_array("norg", $seg)): ?>
		<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
			<div class="panel-heading">Niveles Organizacionales</div>
			<div class="panel-body">
				<select required="required" name="norg" class="form-control">
					<option style="display:none">Seleccione una opción</option>
					<?php
					$test = new Empresa_norg();
					$test->get_select_options($_SESSION['Empresa']['id']);
					?>
				</select>
			</div>
		</div>
	<?php endif ?>
	<?php if (in_array("tcont", $seg)): ?>
		<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
			<div class="panel-heading">Tipo de contrato</div>
			<div class="panel-body">
				<select required="required" name="tcont" class="form-control">
					<option style="display:none">Seleccione una opción</option>
					<?php
					$test = new Empresa_tcont();
					$test->get_select_options($_SESSION['Empresa']['id']);
					?>
				</select>
			</div>
		</div>
	<?php endif ?>
	<?php if (in_array("educacion", $seg)): ?>
		<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
			<div class="panel-heading">Educación</div>
			<div class="panel-body">
				<select required="required" name="educacion" class="form-control">
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
	<?php endif ?>
	<?php if (in_array("sexo", $seg)): ?>
		<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
			<div class="panel-heading">Sexo</div>
			<div class="panel-body">
				<select required="required" name="sexo" class="form-control">
					<option style="display:none">Seleccione una opción</option>
					<option value="0">Masculino</option>
					<option value="1">Femenino</option>
				</select>
			</div>
		</div>
	<?php endif ?>
	<div class="clearfix"></div>
	<h4 class="form-group">Esta encuesta es absolutamente anónima y confidencial o sea, No interesa saber quien contestó de una u otra forma. lo que <strong>SI</strong> interesa es que sea <u>muy sincero</u> en sus respuestas.</h4>
	<table class="table table-bordered table-hover">
		<?php 
		$x = new Sonda_tema();
		$y = new Sonda_pregunta();
		foreach ($temas as $tkey => $tval) {
			$x->select($tkey);
			echo "<tr class='info text-uppercase'><td colspan='2'><h6>".$x->getTema()."</h6></tr></td>";
			$preguntas = $temas[$tkey];
			foreach ($preguntas as $s_key => $s_value) {
				$y->select($s_value);
				echo "<tr>";
				echo "<td class='col-md-8'>".ucfirst($y->getPregunta())."</td>";
				echo "<td class='col-md-3'>";
				$y->getOptions();
				echo "</td>";
				echo "</tr>";
			}
		}
		?>
	</table>
	<input type="hidden" name="id_test" value="<?php echo $id_t ?>">
	<input type="submit" class="btn btn-default btn-block btn-lg" value="GUARDAR">
	<script type="text/javascript">
		$('input.speed').on('keyup', function(){
			if (isNumeric(this.value) && this.value<=5) {
				var $this = $(this);
				console.log($this);
				console.log($(':input:eq(' + ($(':input').index(this) + 1) + ')'));
				$(':input:eq(' + ($(':input').index(this) + 1) + ')').focus();
			}
		})
		function isNumeric(n) {
			return !isNaN(parseFloat(n)) && isFinite(n);
		}	
	</script>