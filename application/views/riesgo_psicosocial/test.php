<style type="text/css">
	.table > tbody > tr > th,
	.table > tbody > tr > td{
		padding: 5px !important;
	}
</style>
<script type="text/javascript">
	
	$(document).ready(function() {
		$( "#target" ).submit(function( event ) {
        	var user_rol = '<?php echo $_SESSION["USER-AD"]["user_rol"] ?>';
        	var continua = true;

        	if(user_rol == 6 || user_rol == 9){
        		$(this).find('select').each(function(){
			 		var elemento = this.value;
			 		if(elemento == ''){
			 			$().toastmessage('showErrorToast', 'Todos los filtros son necesarios!!!');
			 			event.preventDefault();
			 			continua = false;
			 			return false;
			 		}
			 	});

			 	if(continua){
	        		$('#tblRspEnc tr.tr_preg').each(function(){
						var count_check = 0;
						$(this).find('input').each(function(){
							var type = $(this).attr('type');
							if(type == 'text'){
								count_check = 1;
			        			var respEnc = $(this).val();
			        			if(respEnc == ''){
			        				$().toastmessage('showErrorToast', 'Todas las preguntas deben ser contestadas!!!');
						 			event.preventDefault();
						 			return false;
			        			}
			        		}else{
			        			if($(this).is(':checked')){
			        				count_check++;
			        			}
			        		}
						});

						if(count_check < 1){
	        				$().toastmessage('showErrorToast', 'Todas las preguntas deben ser contestadas!!!');
				 			event.preventDefault();
				 			return false;
	        			}
					});
	        	}
        	}
        });
	});

	function validaCaja(min, max, tabindex, obj){
		obj.value = (obj.value + '').replace(/[^0-9]/g, '');

		if(obj.value < min || obj.value > max){
			obj.value = '';
		}else{
			var cb = parseInt(tabindex);
			if ( $(':input[tabindex=\'' + (cb + 1) + '\']') != null) {
				$(':input[tabindex=\'' + (cb + 1) + '\']').focus();
				$(':input[tabindex=\'' + (cb + 1) + '\']').select();
			return false;
			}
		}
	}

</script>
<?php
$riesgo = new Riesgo_psicosocial();
$riesgo->setId_empresa($_SESSION['Empresa']['id']);
$riesgo->select_last();
$seg = $riesgo->getSegmentacion();
//$seg = array("edad","antiguedad","localidad","departamento","norg","tcont","educacion","sexo");
?>
<form id="target" class="form" method="POST" action="<?php echo BASEURL ?>riesgo_psicosocial/test/<?php echo $id_e ?>/<?php echo $id_t ?>">
<?php if (in_array("edad", $seg)): ?>
	<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
		<div class="panel-heading">Edad</div>
		<div class="panel-body">
			<select name="edad" class="form-control">
				<option value="">Seleccione una opción</option>
				<option value="0">Menor a 20 años</option>
				<option value="1">De 20 a 25 años </option>
				<option value="2">De 25 a 30 años </option>
				<option value="3">De 30 a 40 años</option>
				<option value="4">De 40 a 50 años</option>
				<option value="5">Más 50 años</option>
				<option value="6">N/E</option>
			</select>
		</div>
	</div>
<?php endif ?>
<?php if (in_array("antiguedad", $seg)): ?>
	<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
		<div class="panel-heading">Antigüedad</div>
		<div class="panel-body">
			<select name="antiguedad" class="form-control">
				<option value="">Seleccione una opción</option>
				<option value="1">Menos de 2 años </option>
				<option value="2">De 2 a 5 años </option>
				<option value="3">De 5 a 10 años </option>
				<option value="4">De 10 a 15 años</option>
				<option value="5">De 15 a 20 años</option>
				<option value="6">Más 20 años</option>
				<option value="7">N/E</option>
			</select>
		</div>
	</div>
<?php endif ?>
<?php if (in_array("localidad", $seg)): ?>
	<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
		<div class="panel-heading">Localidades</div>
		<div class="panel-body">
			<select name="localidad" class="form-control">
				<option value="">Seleccione una opción</option>
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
			<select name="area" class="form-control">
				<option value="">Seleccione una opción</option>
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
			<select name="norg" class="form-control">
				<option value="">Seleccione una opción</option>
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
			<select name="tcont" class="form-control">
				<option value="">Seleccione una opción</option>
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
			<select name="educacion" class="form-control">
				<option value="">Seleccione una opción</option>
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
			<select name="sexo" class="form-control">
				<option value="">Seleccione una opción</option>
			 	<option value="0">Masculino</option>
				<option value="1">Femenino</option>
			</select>
		</div>
	</div>
<?php endif ?>
<?php if (in_array("hijos", $seg)): ?>
	<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
		<div class="panel-heading">Hijos</div>
		<div class="panel-body">
			<select name="hijos" class="form-control">
				<option value="">Seleccione una opción</option>
			 	<option value="0">Sí</option>
				<option value="1">No</option>
			</select>
		</div>
	</div>
<?php endif ?>
<div class="clearfix"></div>
<table class="table table-bordered table-hover" id="tblRspEnc">
<?php 
	$x = new Rp_tema();
	$arr=$x->select_all();
	$y = new Rp_pregunta();
	$tabindex = 1;
	foreach ($arr as $key => $value) {
		echo "<tr class='info'><td colspan='2'><strong>".ucfirst($value->getTema())."</strong></tr></td>";
		$preguntas = $y->select_x_tema($value->getId());
		foreach ($preguntas as $s_key => $s_value) {
			echo "<tr class='tr_preg'>";
			echo "<td class='col-md-8'>".ucfirst($s_value->getPregunta())."</td>";
			echo "<td class='col-md-3'>";
			$s_value->getOptions($tabindex);
			echo "</td>";
			echo "</tr>";

			$tabindex++;
		}
	}
?>
</table>
<input type="hidden" name="id_test" value="<?php echo $id_t ?>">
<input type="submit" class="btn btn-default btn-block btn-lg" value="GUARDAR">
<script type="text/javascript">
	$('input.speed').on('keyup', function(){
		if ((isNumeric(this.value) && this.value<=5) || this.value=="N" || this.value=="n") {
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