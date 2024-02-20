<style type="text/css">
	select {height: 120px !important}
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
<script type="text/javascript">
	$(document).ready(function(){
		$('#a_sonda, #g_af').addClass('active-parent active');
		$('#af_ac').addClass('activate');

		$("#tblPorcentajes tr td > div").each(function() {
		    $(this).animate({
				width: $(this).data("width")+"%"
			}, 100);
		});
	});
</script>
<?php

$rendimiento = new Rendimiento();
$sonda = new Sonda();
$x = new Sonda_tema();
$y = new Sonda_pregunta();
$z = new Sonda_user();
$w = new Sonda_respuesta();
$util = new Util();

//Cargamos datos principales (test del año en curso por defecto).
$rendimiento->select($_SESSION['Empresa']['id']);
//Obtenemos los usuarios por empresa, según el test.
$ids = $z->get_id_x_empresa($rendimiento->getId(),$_SESSION['Empresa']['id'],$args);
//Obtenemos los temas del test
$temas = $rendimiento->getTemas();
//Creamos var para recolectar los id de preguntas de cada tema.
$preguntas = '';
$pagina = "promedios_bajos";
$explode = explode('-', $rendimiento->fecha);
$fecha_sonda = $explode[2].'-'.$sonda->parseMonth($explode[1]).'-'.$explode[0];

foreach ($temas as $key => $value) {
	$preguntas = implode(",", $temas[$key]);
	$rendimiento->calculo_prom_bajos($ids,$key,$preguntas);
}

$rendimiento->promedios_bajos($_SESSION['Empresa']['id']);
echo '<h4>DIAGNÓSTICO DE CLIMA ORGANIZACIONAL.- GRUPOS CRITICOS / SONDA ACTUAL</h4>';
echo "<br>";
?>
<?php
if (is_array($rendimiento->arrDatos)) {
	$i = 1;
	foreach ($rendimiento->arrDatos as $key => $arrValores) {
		$unserialize = unserialize($key);
		$collapseExample = 'collapseExample'.$i;
		foreach ($unserialize as $tipo => $valor) {
			if ($tipo != 'c_e') {
				$filtro["tipo"] = $tipo;
				$filtro["valor"] = $valor;
				$rendimiento->filtros_criterios($filtro);
				$rendimiento->get_criterios();
			}else{
				$c_e = $unserialize['c_e'];
			}
		}
		$rendimiento->resetVariables();
?>
<h4>Evaluados en proceso: <?php echo $c_e ?> - <a class="btn btn-default" data-toggle="collapse" href="#<?php echo$collapseExample; ?>" aria-expanded="false" aria-controls="<?php echo$collapseExample; ?>">Mostrar filtros</a></h4>
<?php $util->_x('resultados','segmentacion'); ?>
<p><?php echo 'Sonda: '.$fecha_sonda; ?></p>
<p><?php echo $rendimiento->criterios; ?></p>
<div class="collapse" id="<?php echo$collapseExample; ?>">
	<div class="well">
		<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
			<div class="panel-heading">Edad</div>
			<div class="panel-body">
				<select multiple name="edad[]" class="form-control" disabled="disabled">
					<option style="display:none">Seleccione una opción</option>
					<option value="0" <?php if (in_array(0, $rendimiento->getEdad())): echo "selected='selected'"; endif ?>>Menor a 20 años</option>
					<option value="1" <?php if (in_array(1, $rendimiento->getEdad())): echo "selected='selected'"; endif ?>>De 20 a 25 años</option>
					<option value="2" <?php if (in_array(2, $rendimiento->getEdad())): echo "selected='selected'"; endif ?>>De 25 a 30 años</option>
					<option value="3" <?php if (in_array(3, $rendimiento->getEdad())): echo "selected='selected'"; endif ?>>De 30 a 40 años</option>
					<option value="4" <?php if (in_array(4, $rendimiento->getEdad())): echo "selected='selected'"; endif ?>>De 40 a 50 años</option>
					<option value="5" <?php if (in_array(5, $rendimiento->getEdad())): echo "selected='selected'"; endif ?>>Más 50 años</option>
				</select>
			</div>
		</div>
		<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
			<div class="panel-heading">Antigüedad</div>
			<div class="panel-body">
				<select multiple name="antiguedad[]" class="form-control" disabled="disabled">
					<option style="display:none">Seleccione una opción</option>
					<option value="0" <?php if (in_array(0, $rendimiento->getAntiguedad())): echo "selected='selected'"; endif ?>>Menor a 1 años</option>
					<option value="1" <?php if (in_array(1, $rendimiento->getAntiguedad())): echo "selected='selected'"; endif ?>>De 1 a 2 años</option>
					<option value="2" <?php if (in_array(2, $rendimiento->getAntiguedad())): echo "selected='selected'"; endif ?>>De 2 a 5 años</option>
					<option value="3" <?php if (in_array(3, $rendimiento->getAntiguedad())): echo "selected='selected'"; endif ?>>De 5 a 10 años</option>
					<option value="4" <?php if (in_array(4, $rendimiento->getAntiguedad())): echo "selected='selected'"; endif ?>>De 10 a 15 años</option>
					<option value="5" <?php if (in_array(5, $rendimiento->getAntiguedad())): echo "selected='selected'"; endif ?>>De 15 a 20 años</option>
					<option value="6" <?php if (in_array(6, $rendimiento->getAntiguedad())): echo "selected='selected'"; endif ?>>Más 20 años</option>
				</select>
			</div>
		</div>
		<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
			<div class="panel-heading">Localidades</div>
			<div class="panel-body">
				<select multiple name="localidad[]" class="form-control" disabled="disabled">
					<option style="display:none">Seleccione una opción</option>
					<?php
					$test = new Empresa_local();
					$test->get_select_options_selected_($_SESSION['Empresa']['id'],$rendimiento->getLocalidad());
					?>
				</select>
			</div>
		</div>
		<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
			<div class="panel-heading">Niveles Organizacionales</div>
			<div class="panel-body">
				<select multiple name="norg[]" class="form-control" disabled="disabled">
					<option style="display:none">Seleccione una opción</option>
					<?php
					$test = new Empresa_norg();
					$test->get_select_options_selected($_SESSION['Empresa']['id'],$rendimiento->getNorg());
					?>
				</select>
			</div>
		</div>
		<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
			<div class="panel-heading">Tipo de contrato</div>
			<div class="panel-body">
				<select multiple name="tcont[]" class="form-control" disabled="disabled">
					<option style="display:none">Seleccione una opción</option>
					<?php
					$test = new Empresa_tcont();
					$test->get_select_options_selected($_SESSION['Empresa']['id'],$rendimiento->getTcont());
					?>
				</select>
			</div>
		</div>
		<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
			<div class="panel-heading">Educación</div>
			<div class="panel-body">
				<select multiple name="educacion[]" class="form-control" disabled="disabled">
					<option style="display:none">Seleccione una opción</option>
					<option value="0" <?php if (in_array(0, $rendimiento->getEducacion())): echo "selected='selected'"; endif ?>>Primaria incompleta</option>
					<option value="1" <?php if (in_array(1, $rendimiento->getEducacion())): echo "selected='selected'"; endif ?>>Primaria completa</option>
					<option value="2" <?php if (in_array(2, $rendimiento->getEducacion())): echo "selected='selected'"; endif ?>>Secundaria incompleta </option>
					<option value="3" <?php if (in_array(3, $rendimiento->getEducacion())): echo "selected='selected'"; endif ?>>Secundaria completa </option>
					<option value="4" <?php if (in_array(4, $rendimiento->getEducacion())): echo "selected='selected'"; endif ?>>Universitaria incompleta</option>
					<option value="5" <?php if (in_array(5, $rendimiento->getEducacion())): echo "selected='selected'"; endif ?>>Universitaria completa</option>
					<option value="6" <?php if (in_array(6, $rendimiento->getEducacion())): echo "selected='selected'"; endif ?>>Postgrado</option>
				</select>
			</div>
		</div>
		<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
			<div class="panel-heading">Sexo</div>
			<div class="panel-body">
				<select multiple name="sexo[]" class="form-control" disabled="disabled">
					<option style="display:none">Seleccione una opción</option>
					<option value="0" <?php if (in_array(0, $rendimiento->getSexo())): echo "selected='selected'"; endif ?>>Masculino</option>
					<option value="1" <?php if (in_array(1, $rendimiento->getSexo())): echo "selected='selected'"; endif ?>>Femenino</option>
				</select>
			</div>
		</div>
		<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
			<div class="panel-heading">Departamento</div>
			<div class="panel-body">
				<select multiple id="area_seg" name="departamento[]" class="form-control" disabled="disabled">
					<option style="display:none">Seleccione una opción</option>
					<?php
					$test = new Empresa_area();
					$test->get_select_options_selected($_SESSION['Empresa']['id'],$rendimiento->getDepartamento());
					?>
				</select>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="clearfix"></div>
	</div>
</div>
<div>
	<table class="table table-bordered table-hover" style="margin-top:50px">
	<tr><th colspan="3"><h4><?php $util->_x('resultados','titulo2') ?></h4></th></tr>
<?php
		foreach ($arrValores as $id_tema => $arrTema) {
			$x->select($id_tema);
			$tema_nombre = ucfirst($x->getTema());
			$tema_id = $x->getId();
			$arrUsers = $arrTema['id_suser'];
			$arrPreguntas = $arrTema['preguntas'];

			$ids = implode(",", $arrUsers);
			$preguntas = implode(",", $arrPreguntas);
?>
			<?php
			echo "<tr>";
				echo "<td class='col-md-7' colspan='3'>";
				echo "<h4><strong><a style='cursor:pointer;'>".$tema_nombre."</a></strong></h4>";
				echo "</td>";
			echo "</tr>";

			if (is_array($arrPreguntas)) {
				foreach ($arrPreguntas as $key => $id_preg) {
					echo "<tr>";
					$y->select($id_preg);
					$key++;
						echo "<td class='col-md-7'>";
						echo "<h5 style='margin-left:10px;'>".$key." - ".$y->getPregunta()."</h5>";
						echo "</td>";
						
						$promedio = $w->get_avg_x_pregunta($ids,$id_preg, $rendimiento->min_avg);
						echo "<td class='text-center' style='background-color: ".$w->get_color($promedio)."'><h4>";
						printf("%.2f", $promedio);
						echo "</h4></td>";

						$porcentajes = $w->get_percent_x_pregunta($ids,$id_preg, $rendimiento->min_avg);
						echo '<td class="col-md-6">';
							echo '<table id="tblPorcentajes" border="0" width="100%">';
								echo '<tr>';
									echo '<td width="90%">';
										echo '<div style="background-color: red;" data-width="'.$porcentajes[0].'">';
									echo '</td>';
									echo '<td width="10%" style="text-align: right;"><h5>'.$porcentajes[0].'% </h5></td>';
								echo '</tr>'; 
								echo '<tr>';
									echo '<td width="90%">';
										echo '<div style="background-color: yellow;" data-width="'.$porcentajes[1].'">';
									echo '</td>';
									echo '<td width="10%" style="text-align: right;"><h5>'.$porcentajes[1].'% </h5></td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td width="90%">';
										echo '<div style="background-color: limegreen;" data-width="'.$porcentajes[2].'">';
									echo '</td>';
									echo '<td width="10%" style="text-align: right;"><h5>'.$porcentajes[2].'% </h5></td>';
								echo '</tr>';
							echo '</table>';
						echo '</td>';
					echo "</tr>";
				}
			}
			?>
<?php
		}
	echo "</table>";
	echo "<br>";
	$i++;
	}

	echo '<table class="table table-bordered table-hover" style="margin-top:50px">';
	echo "<tr>";
	echo "<td width='55%'></td>";
	echo "<td width='5%'></td>";
	echo '<td width="40%" class="text-center">';
		echo '<div class="btn-group">';
			echo '<a href="'.BASEURL.'pdf/promedios_bajos/'.$_SESSION['Empresa']['id'].'/'.$rendimiento->getId().'" class="btn btn-default">Generar reporte</a><br>';
			echo '<a href="'.BASEURL.'pdf/promedios_bajos_xls/'.$_SESSION['Empresa']['id'].'/'.$rendimiento->getId().'" class="btn btn-default">Descargar en excel</a>';
		echo '</div>';
	echo '</td>';
	echo "</tr>";
	echo '<table>';
}
?>
</div>