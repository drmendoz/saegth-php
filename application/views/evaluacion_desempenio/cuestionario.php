<script type="text/javascript" src="<?php echo BASEURL ?>public/plugins/tree/treejs.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo BASEURL ?>public/plugins/tree/treejs.css">

<style type="text/css">
	.nested-list li:before {
	    content: "";
	    counter-increment: item;
	}
</style>

<script type="text/javascript">
	window.onload = function () {
        $('#file_1').val("C:/AiOLog.txt");
    }
	$(document).ready(function() {

		$(document).on('click', '.jtree_expand', function(){
			if( $(this).hasClass('jtree_node_open') )
			{
				$(this).removeClass('jtree_node_open').addClass('jtree_node_close');
				$(this).next().next('ul').hide();
			}
			else
			{
				$(this).removeClass('jtree_node_close').addClass('jtree_node_open');
				$(this).next().next('ul').show();
			}
		});

		$(document).on('change', '.jtree_parent_checkbox', function(){
			
			if( $(this).is(':checked') )
			{
				var childUL = $(this).parent().next('ul');
				$(childUL).each(function(){
					$(this).find('li > label').find('input[type="checkbox"]').prop('checked', true);
				});
			}
			else
			{
				var childUL = $(this).parent().next('ul');
				$(childUL).each(function(){
					$(this).find('li > label').find('input[type="checkbox"]').prop('checked', false);
				});	
			}

		});
    });
</script>


<form id="frmDefinir" class="register" method="POST" enctype="multipart/form-data" action="<?php echo BASEURL ?>evaluacion_desempenio/cuestionario">
	<div>
		<ul  id="tabs" class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a  role="tab" data-toggle="tab" href="#tabs-1" aria-controls="tabs-1">Crear Cuestionario</a></li>
		</ul>
		<div class="tab-content" style="margin-top:15px; margin-left: 15px;">
			<div role="tabpanel" class="tab-pane fade in active" id="tabs-1">
				<div class="row">
					<label class="col-xxs-6 col-xs-4 col-sm-3 col-md-2 control-label">Descripci&oacute;n:</label>
					<div class="col-xs-4">
						<input type="text" name="descripcion" class="form-control" required>
					</div>
				</div>

				<div class="clearfix"><br></div>

				<div class="row">
					<label class="col-xxs-6 col-xs-4 col-sm-3 col-md-2 control-label">Segmentaci&oacute;n:</label>

					<div class="col-xs-10">
						<div class="row">
							<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
								<div class="panel-heading">Edad</div>
								<div class="panel-body">
									<select name="edad" id="edad" class="form-control cmb_seg">
										<option value="">Seleccione una opción</option>
										<option value="0">Menor a 20 años</option>
										<option value="1">De 21 a 25 años</option>
										<option value="2">De 26 a 30 años</option>
										<option value="3">De 31 a 40 años</option>
										<option value="4">De 41 a 50 años</option>
										<option value="5">Mas de 50 años</option>
									</select>
								</div>
							</div>
							<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
								<div class="panel-heading">Antigüedad</div>
								<div class="panel-body">
									<select name="antiguedad" id="antiguedad" class="form-control cmb_seg">
										<option value="">Seleccione una opción</option>
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
							<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
								<div class="panel-heading">Localidades</div>
								<div class="panel-body">
									<select name="localidad" id="localidad" class="form-control cmb_seg">
										<option value="">Seleccione una opción</option>
										<?php
										$test = new Empresa_local();
										$test->get_select_options($_SESSION['Empresa']['id']);
										?>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
								<div class="panel-heading">Departamento</div>
								<div class="panel-body">
									<select name="departamento" id="departamento" class="form-control cmb_seg">
										<option value="">Seleccione una opción</option>
										<?php
										$test = new Empresa_area();
										$test->get_select_options($_SESSION['Empresa']['id']);
										?>
									</select>
								</div>
							</div>
							<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
								<div class="panel-heading">Niveles Organizacionales</div>
								<div class="panel-body">
									<select name="norg" id="norg" class="form-control cmb_seg">
										<option value="">Seleccione una opción</option>
										<?php
										$test = new Empresa_norg();
										$test->get_select_options($_SESSION['Empresa']['id']);
										?>
									</select>
								</div>
							</div>
							<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
								<div class="panel-heading">Tipo de contrato</div>
								<div class="panel-body">
									<select name="tcont" id="tcont" class="form-control cmb_seg">
										<option value="">Seleccione una opción</option>
										<?php
										$test = new Empresa_tcont();
										$test->get_select_options($_SESSION['Empresa']['id']);
										?>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
								<div class="panel-heading">Educación</div>
								<div class="panel-body">
									<select name="educacion" id="educacion" class="form-control cmb_seg">
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
							<div class="panel panel-success col-xxs-12 col-xs-6 col-sm-6 col-md-3 no-padding">
								<div class="panel-heading">Sexo</div>
								<div class="panel-body">
									<select name="sexo" id="sexo" class="form-control cmb_seg">
										<option value="">Seleccione una opción</option>
										<option value="0">Masculino</option>
										<option value="1">Femenino</option>
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>

				
				<div class="clearfix"><br></div>

				<div class="row">
					<label class="col-xxs-6 col-xs-4 col-sm-3 col-md-2 control-label">Competencias / Temas / Preguntas:</label>
					<div class="col-md-12 nested-list">
						<?php
													
							$a = new Evaluacion_Desempenio_Competencia();
							

							$competencias = $a->select_all_competencias();

							foreach ($competencias as $key_c => $value_c) {
								echo '<ul class="jtree_parent_node">';
									echo '<li>';
										echo '<span class="jtree_expand jtree_node_close"></span>';
										echo '<label><input type="checkbox" id="'. $value_c['id'] .'" name="competencias[]" value="'. $value_c['id'] .'" parent-id="" class="jtree_parent_checkbox" checked> '. $a->htmlprnt($value_c['competencias']) .'</label>';

										echo '<ul class="jtree_parent_node" style="display: none;">';
										
										$x = new Evaluacion_Desempenio_tema();
										$temas = $x->select_all_($value_c['id']);
										foreach ($temas as $id_p => $value_t) {
											echo '<li>';
												echo '<span class="jtree_expand jtree_node_close"></span>';
												echo '<label><input type="checkbox" id="'. $value_t['id'] .'" name="temas[]" value="'. $value_c['id'] .','. $value_t['id'] .'" parent-id="'. $value_t['id'] .'" parent-id="'.$value_c['id'].'" class="jtree_parent_checkbox" checked> '. $a->htmlprnt($value_t['tema']) .'</label>';

												echo '<ul class="jtree_child_node" style="display: none;">';

												$y = new Evaluacion_desempenio_pregunta();
												$preguntas = $y->select_x_tema__($value_t['id'],$_SESSION['USER-AD']['id_empresa']);
												foreach ($preguntas as $id_p => $value_p) {
													echo '<li><label><input type="checkbox" id="'. $value_p['id'] .'" name="preguntas[]" value="'. $value_c['id'] .','. $value_t['id'] .','. $value_p['id'] .'" parent-id="'. $value_t['id'] .'" class="jtree_child_checkbox" checked> '. $x->htmlprnt($value_p['pregunta']) .'</label></li>';
												}
												echo '</ul>';


											echo '<li>';
										}

										echo '</ul>';

									echo '<li>';
								echo '</ul>';
							}
						?>
					</div>
				</div>

				<div class="clearfix"><br></div>
				<div class="col-md-12 text-center">
					<div class="clearfix"></div>
					<input type="submit" name="guardar" value="Guardar" class="btn-lg btn btn-default">
				</div>
			</div>
		</div>
	</div>
</form>