<style type="text/css">
	.table > tbody > tr > th,
	.table > tbody > tr > td{
		padding: 5px !important;
	}
</style>
<script type="text/javascript">
	$(document).ready(function() {
		$('#tblRspEnc input[type=text]').keyup(function (){
            this.value = (this.value + '').replace(/[^0-9]/g, '');
            if(this.value < 1 || this.value > 6){
				$(this).val('');
			}else{
				var cb = parseInt($(this).attr('tabindex'));
				if ( $(':input[tabindex=\'' + (cb + 1) + '\']') != null) {
					$(':input[tabindex=\'' + (cb + 1) + '\']').focus();
					$(':input[tabindex=\'' + (cb + 1) + '\']').select();
				return false;
				}
			}
        });

        $( "#target" ).submit(function( event ) {
        	var user_rol = '<?php echo $_SESSION["USER-AD"]["user_rol"] ?>';
        	var continua = true;

        	if(user_rol == 4 || user_rol == 8){
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
</script>
<?php
$sonda = new Sonda();
$sonda->select($id_e,$id_t);
$seg = $sonda->getSegmentacion();
$temas = $sonda->getTemas();
?>
<form id="target" class="form" method="POST" action="<?php echo BASEURL ?>sonda/test_temp/<?php echo $id_e ?>/<?php echo $id_t ?>">
	<?php if (in_array("edad", $seg)): ?>
		<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
			<div class="panel-heading">Edad</div>
			<div class="panel-body">
				<select name="edad" class="form-control">
					<option style="display:none">Seleccione una opción</option>
					<option value="0">Menor a 20 años</option>
					<option value="1">De 21 a 25 años</option>
					<option value="2">De 26 a 30 años</option>
					<option value="3">De 31 a 40 años</option>
					<option value="4">De 41 a 50 años</option>
					<option value="5">Mas de 50 años</option>
				</select>
			</div>
		</div>
	<?php endif ?>
	<?php if (in_array("antiguedad", $seg)): ?>
		<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
			<div class="panel-heading">Antigüedad</div>
			<div class="panel-body">
				<select name="antiguedad" class="form-control">
					<option value="" style="display:none">Seleccione una opción</option>
					<option value="7">De 0 a 3 meses</option>
					<option value="1">De 3 meses a 2 años</option>
					<option value="2">De 2 a 5 años </option>
					<option value="3">De 5 a 10 años </option>
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
				<select name="localidad" class="form-control">
					<option value="" style="display:none">Seleccione una opción</option>
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
					<option value="" style="display:none">Seleccione una opción</option>
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
					<option value="" style="display:none">Seleccione una opción</option>
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
					<option value="" style="display:none">Seleccione una opción</option>
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
					<option value="" style="display:none">Seleccione una opción</option>
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
					<option value="" style="display:none">Seleccione una opción</option>
					<option value="0">Masculino</option>
					<option value="1">Femenino</option>
				</select>
			</div>
		</div>
	<?php endif ?>
	<?php
	$model = new Model();
	$meth = new Empresa();
	$cond = $model->DB_exists_double('empresa_cond','id_empresa',$_SESSION["Empresa"]["id"],'nivel','0');
	if (is_array($cond)) {
		foreach ($cond as $key => $value) {
			$descripcion = $value['Empresa_cond']['nombre'];
			$id_superior = $value['Empresa_cond']['id'];
			if (in_array("cond_".$id_superior, $seg)) {
	?>
		<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
			<div class="panel-heading"><?php echo ucfirst($descripcion); ?></div>
			<div class="panel-body">
				<select name="sexo" class="form-control">
					<option value="" style="display:none">Seleccione una opción</option>
					<?php
					$opc = $meth->query('select id,nombre,id_superior from empresa_cond WHERE nivel=1 AND id_superior='.$id_superior.'');
                    echo mysqli_error($meth->link);
                    $tmp =array_filter($opc); 
                    if (!empty($tmp)){ 
                        foreach ($opc as $a => $b) {
                            if(($id_superior === $b["Empresa_cond"]['id_superior'])){
                            	$new_id = $b['Empresa_cond']['id'];
                            	$new_descripcion = $b['Empresa_cond']['nombre'];
                            	echo '<option value="'.$new_id.'">'.ucfirst($new_descripcion).'</option>';
                            }
                        }
                    }
					?>
				</select>
			</div>
		</div>
	<?php
			}
		}
	}
	?>
	<div class="clearfix"></div>
	<h4 class="form-group">Esta encuesta es absolutamente anónima y confidencial o sea, No interesa saber quien contestó de una u otra forma. lo que <strong>SI</strong> interesa es que sea <u>muy sincero</u> en sus respuestas.</h4>
	<?php
	//if($_SESSION['USER-AD']['user_rol'] == 4){
	?>
	<h4><b>CLAVE DE RESPUESTAS:</b></h4>
	<p><b>1 - </b>Totalmente en desacuerdo</p>
	<p><b>2 - </b>En desacuerdo</p>
	<p><b>3 - </b>Termino Medio</p>
	<p><b>4 - </b>De acuerdo</p>
	<p><b>5 - </b>Totalmente de acuerdo</p>
	<p><b>6 - </b>No sé</p>
	<?php
	//}
	?>
	<table class="table table-bordered table-hover" id="tblRspEnc">
		<?php 
		$x = new Sonda_tema();
		$y = new Sonda_pregunta();
		$i = 1;
		foreach ($temas as $tkey => $tval) {
			$x->select($tkey);
			echo "<tr class='info text-uppercase'><td colspan='2'><h6>".$x->getTema()."</h6></tr></td>";
			$preguntas = $temas[$tkey];
			foreach ($preguntas as $s_key => $s_value) {
				$y->select($s_value);
				echo "<tr class='tr_preg'>";
				echo "<td class='col-md-8'>".ucfirst($y->getPregunta())."</td>";
				echo "<td class='col-md-3'>";
				if($_SESSION['USER-AD']['user_rol'] == 4 || $_SESSION['USER-AD']['user_rol'] == 8){
					$y->getOptions();
				}else{
					echo "<input type='text' name='".$y->getId()."' maxlength='1' tabindex='$i' style='width: 40px; text-align:center;' />";
					$i++;
				}
				
				echo "</td>";
				echo "</tr>";
			}
		}
		?>
	</table>
	<?php
	$sonda_f = new SondaController('Sonda','sonda','test_temp_foda',0,true,true);
	$sonda_f->test_temp_foda($id_e,$id_t);
	$sonda_f->ar_destruct();
	unset($sonda_f);
	?>
	<input type="hidden" name="id_test" value="<?php echo $id_t ?>">
	<input type="submit" class="btn btn-default btn-block btn-lg" value="GUARDAR">
</form>

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