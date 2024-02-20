<?php $meth = new Ajax(); ?>
<style type="text/css">
	#selector.ui-sortable {
		/*width: 350px;*/
		/*margin: 50px auto;*/
		background-color: #ccc;
		-webkit-box-shadow:  0px 0px 10px 1px rgba(0, 0, 0, .1);
		box-shadow:  0px 0px 10px 1px rgba(0, 0, 0, .1);
		list-style-type: none; 
		padding: 0; 
	}
	#selector.ui-sortable li.ui-sortable-handle { 
		margin: 0; 
		height: 45px;
		line-height: 48px;
		font-size: 1.4em; 
		color: #fff;
		outline: 0;
		padding: 0;
		margin: 0;
		text-indent: 15px;
		/*background: -moz-linear-gradient(top,  rgb(0, 74, 88) 0%, rgb(10, 62, 62) 100%);
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgb(0, 74, 88)), color-stop(100%,rgb(10, 62, 62)));
		background: -webkit-linear-gradient(top,  rgb(0, 74, 88) 0%,rgb(10, 62, 62) 100%);
		background: -o-linear-gradient(top,  rgb(0, 74, 88) 0%,rgb(10, 62, 62) 100%);
		background: -ms-linear-gradient(top,  rgb(0, 74, 88) 0%,rgb(10, 62, 62) 100%);
		background: linear-gradient(to bottom,  rgb(0, 74, 88) 0%,rgb(10, 62, 62) 100%);
		border-top: 1px solid rgba(255,255,255,.2);*/
		border-bottom: 1px solid rgba(0,0,0,.5);
		text-shadow: -1px -1px 0px rgba(0,0,0,.5);
		font-size: 1.1em;
		position: relative;
		cursor: pointer;
	}
	.ui-sortable li.ui-sortable-handle:first-child {
		border-top: 0; 
	}
	.ui-sortable li.ui-sortable-handle:last-child {
		border-bottom: 0;
	}
	.ui-sortable-placeholder {
		border: 3px dashed #aaa;
		height: 45px;
		/*width: 344px;*/
		background: #ccc;
	}
	.crit-u{background: rgb(0, 74, 88);}
	.crit-h{background: red;}
	.crit-n{background: yellow; color: black;}
	.crit-l{background: green;}

	select{height: 200px !important;	}
</style>
<div class="col-md-12">
	<a class="btn btn-default" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Mostrar filtros</a>
	<div class="collapse" id="collapseExample">
		<div class="well">
			<form  action="<?php echo BASEURL.'test/riesgo_retencion' ?>" method="POST">
				<!-- AREAS -->
				<div class="panel panel-success col-md-4 no-padding">
					<div class="panel-heading">&Aacute;reas</div>
					<div class="panel-body">
						<select name="areas[]" multiple="" class="form-control">
							<?php
							$test = new Empresa_area();
							$test->get_select_options($_SESSION['Empresa']['id']);
							?>
						</select>
					</div>
				</div>
				<!-- LOCALIDADES -->
				<div class="panel panel-success col-md-4 no-padding">
					<div class="panel-heading">Localidades</div>
					<div class="panel-body">
						<select name="localidades[]" multiple="" class="form-control">
							<?php
							$test = new Empresa_local();
							$test->get_select_options($_SESSION['Empresa']['id']);
							?>
						</select>
					</div>
				</div>
				<!-- CARGOS -->
				<div class="panel panel-success col-md-4 no-padding">
					<div class="panel-heading">Cargos</div>
					<div class="panel-body">
						<select name="cargos[]" multiple="" class="form-control">
							<?php foreach ($cargos as $key => $value) { $value=reset($value); ?>
							<option value="<?php echo $value['id'] ?>" <?php if(isset($_POST['cargos'])){ if(in_array($value['id'], $_POST['cargos'])) echo "selected";} ?>><?php echo  $meth->htmlprnt($value['nombre']); ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<!-- NIVELES ORGANIZACIONALES -->
				<div class="panel panel-success col-md-4 no-padding">
					<div class="panel-heading">Niveles Organizacionales</div>
					<div class="panel-body">
						<select name="norgs[]" multiple="" class="form-control">
							<?php foreach ($norgs as $key => $value) { $value=reset($value); ?>
							<option value="<?php echo $value['id'] ?>" <?php if(isset($_POST['norgs'])){ if(in_array($value['id'], $_POST['norgs'])) echo "selected";} ?>><?php echo  $meth->htmlprnt($value['nombre']); ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<!-- TIPOS DE CONTRATO -->
				<div class="panel panel-success col-md-4 no-padding">
					<div class="panel-heading">Tipos de contrato</div>
					<div class="panel-body">
						<select name="tconts[]" multiple="" class="form-control">
							<?php foreach ($tconts as $key => $value) { $value=reset($value); ?>
							<option value="<?php echo $value['id'] ?>" <?php if(isset($_POST['tconts'])){ if(in_array($value['id'], $_POST['tconts'])) echo "selected";} ?>><?php echo  $meth->htmlprnt($value['nombre']); ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				
				<div class="clearfix"></div>
				<div class="text-center"><input type="submit" value="Filtrar" name="filtro" class="btn btn-sm btn-default"> </div>
				<div class="clearfix"></div>
				</form>
			</div>
		</div>
</div>
<div class="col-md-2">
	<ul id="selector" class="sortable">
		<li>Nombre del presonal</li>
		<?php 
		if(isset($resultados)){ 
			foreach ($resultados as $key => $value) { 
				$per = $value;
				switch ($per['criticidad']) {
					case 0:
						$crit_class="crit-l";
						break;
					case 1:
						$crit_class="crit-n";
						break;
					case 2:
						$crit_class="crit-h";
						break;
					
					default:
						$crit_class="crit-u";
						break;
				}
				?>
				<li class="<?php echo $crit_class ?>">
					<input type="hidden" name="id_personal[]" value="<?php echo $per['id'] ?>">
					<input type="hidden" name="posicion[]" class="position">
					<?php echo $meth->htmlprnt($per['nombre']); ?>
				</li>
				<?php	
			}	
		} 
		?>  
	</ul>
</div>
<div class="col-md-10">
	<form id="riesgo_form">
		<?php 
		$riesgo = new Riesgo_retencion(); 
		$riesgo->setId_empresa($_SESSION['Empresa']['id']);
		?>
		<table class="table table-bordered sortable-table">
			<tr>
				<th rowspan="2">N=0</th>
				<th colspan="3">CRITICALLY TO BUSINESS</th>
			</tr>
			<tr>
				<td>Low (0) 0%</td>
				<td>Medium (0) 0%</td>
				<td>High (0) 0%</td>
			</tr>
			<tr>
				<th>PROPENSITY TO LEAVE</th>
				<td>NOT CRITICAL (1 Rating)</td>
				<td>CRITICAL (2 Rating)</td>
				<td>EXTREMELY CRITICAL (3 Rating)</td>
			</tr>
			<tr>
				<td>HIGH (1 Rating)<br>0-3 months<br>(0) 0%</td>
				<td>
					<ul id="1" class="sortable">
						<?php
						$res = $riesgo->select_x_posicion(1);
						if(array_filter($res)){
							foreach ($res as $key => $value) {
								$obj = new riesgo_retencion($value);
							?>
							<li>
								<input type="hidden" name="id_personal[]" value="<?php echo $obj->getId_personal() ?>">
								<input type="hidden" class="position" name="posicion[]" value="<?php echo $obj->getPosicion() ?>">
								<?php echo $meth->htmlprnt($meth->get_pname($obj->getId_personal())) ?>
							</li>
							<?php
							}
						}else{
						?>
						<li></li>
						<?php
						}
						?>
					</ul>
				</td>
				<td>
					<ul id="2" class="sortable">
						<?php
						$res = $riesgo->select_x_posicion(2);
						if(array_filter($res)){
							foreach ($res as $key => $value) {
								$obj = new riesgo_retencion($value);
							?>
							<li>
								<input type="hidden" name="id_personal[]" value="<?php echo $obj->getId_personal() ?>">
								<input type="hidden" class="position" name="posicion[]" value="<?php echo $obj->getPosicion() ?>">
								<?php echo $meth->htmlprnt($meth->get_pname($obj->getId_personal())) ?>
							</li>
							<?php
							}
						}else{
						?>
						<li></li>
						<?php
						}
						?>
					</ul>
				</td>
				<td>
					<ul id="3" class="sortable">
						<?php
						$res = $riesgo->select_x_posicion(3);
						if(array_filter($res)){
							foreach ($res as $key => $value) {
								$obj = new riesgo_retencion($value);
							?>
							<li>
								<input type="hidden" name="id_personal[]" value="<?php echo $obj->getId_personal() ?>">
								<input type="hidden" class="position" name="posicion[]" value="<?php echo $obj->getPosicion() ?>">
								<?php echo $meth->htmlprnt($meth->get_pname($obj->getId_personal())) ?>
							</li>
							<?php
							}
						}else{
						?>
						<li></li>
						<?php
						}
						?>
					</ul>
				</td>
			</tr>
			<tr>
				<td>MEDIUM (2 Rating)<br>Within the next 12 months<br>(0) 0%</td>
				<td><ul id="4" class="sortable">
						<?php
						$res = $riesgo->select_x_posicion(4);
						if(array_filter($res)){
							foreach ($res as $key => $value) {
								$obj = new riesgo_retencion($value);
							?>
							<li>
								<input type="hidden" name="id_personal[]" value="<?php echo $obj->getId_personal() ?>">
								<input type="hidden" class="position" name="posicion[]" value="<?php echo $obj->getPosicion() ?>">
								<?php echo $meth->htmlprnt($meth->get_pname($obj->getId_personal())) ?>
							</li>
							<?php
							}
						}else{
						?>
						<li></li>
						<?php
						}
						?>
						</ul>
						</td>
				<td><ul id="5" class="sortable">
						<?php
						$res = $riesgo->select_x_posicion(5);
						if(array_filter($res)){
							foreach ($res as $key => $value) {
								$obj = new riesgo_retencion($value);
							?>
							<li>
								<input type="hidden" name="id_personal[]" value="<?php echo $obj->getId_personal() ?>">
								<input type="hidden" class="position" name="posicion[]" value="<?php echo $obj->getPosicion() ?>">
								<?php echo $meth->htmlprnt($meth->get_pname($obj->getId_personal())) ?>
							</li>
							<?php
							}
						}else{
						?>
						<li></li>
						<?php
						}
						?>
				</ul></td>
				<td><ul id="6" class="sortable">

						<?php
						$res = $riesgo->select_x_posicion(6);
						if(array_filter($res)){
							foreach ($res as $key => $value) {
								$obj = new riesgo_retencion($value);
							?>
							<li>
								<input type="hidden" name="id_personal[]" value="<?php echo $obj->getId_personal() ?>">
								<input type="hidden" class="position" name="posicion[]" value="<?php echo $obj->getPosicion() ?>">
								<?php echo $meth->htmlprnt($meth->get_pname($obj->getId_personal())) ?>
							</li>
							<?php
							}
						}else{
						?>
						<li></li>
						<?php
						}
						?></ul></td>
			</tr>
			<tr>
				<td>MEDIUM TO LOW (3 Rating)<br>12-24 months<br>(0) 0%</td>
				<td><ul id="7" class="sortable">
						<?php
						$res = $riesgo->select_x_posicion(7);
						if(array_filter($res)){
							foreach ($res as $key => $value) {
								$obj = new riesgo_retencion($value);
							?>
							<li>
								<input type="hidden" name="id_personal[]" value="<?php echo $obj->getId_personal() ?>">
								<input type="hidden" class="position" name="posicion[]" value="<?php echo $obj->getPosicion() ?>">
								<?php echo $meth->htmlprnt($meth->get_pname($obj->getId_personal())) ?>
							</li>
							<?php
							}
						}else{
						?>
						<li></li>
						<?php
						}
						?></ul></td>
				<td><ul id="8" class="sortable">
						<?php
						$res = $riesgo->select_x_posicion(8);
						if(array_filter($res)){
							foreach ($res as $key => $value) {
								$obj = new riesgo_retencion($value);
							?>
							<li>
								<input type="hidden" name="id_personal[]" value="<?php echo $obj->getId_personal() ?>">
								<input type="hidden" class="position" name="posicion[]" value="<?php echo $obj->getPosicion() ?>">
								<?php echo $meth->htmlprnt($meth->get_pname($obj->getId_personal())) ?>
							</li>
							<?php
							}
						}else{
						?>
						<li></li>
						<?php
						}
						?></ul></td>
				<td><ul id="9" class="sortable">
						<?php
						$res = $riesgo->select_x_posicion(9);
						if(array_filter($res)){
							foreach ($res as $key => $value) {
								$obj = new riesgo_retencion($value);
							?>
							<li>
								<input type="hidden" name="id_personal[]" value="<?php echo $obj->getId_personal() ?>">
								<input type="hidden" class="position" name="posicion[]" value="<?php echo $obj->getPosicion() ?>">
								<?php echo $meth->htmlprnt($meth->get_pname($obj->getId_personal())) ?>
							</li>
							<?php
							}
						}else{
						?>
						<li></li>
						<?php
						}
						?></ul></td>
			</tr>
			<tr>
				<td>LOW (4 rating)<br>3 years +<br>(0) 0%</td>
				<td><ul id="10" class="sortable">
						<?php
						$res = $riesgo->select_x_posicion(10);
						if(array_filter($res)){
							foreach ($res as $key => $value) {
								$obj = new riesgo_retencion($value);
							?>
							<li>
								<input type="hidden" name="id_personal[]" value="<?php echo $obj->getId_personal() ?>">
								<input type="hidden" class="position" name="posicion[]" value="<?php echo $obj->getPosicion() ?>">
								<?php echo $meth->htmlprnt($meth->get_pname($obj->getId_personal())) ?>
							</li>
							<?php
							}
						}else{
						?>
						<li></li>
						<?php
						}
						?></ul></td>
				<td><ul id="11" class="sortable">
						<?php
						$res = $riesgo->select_x_posicion(11);
						if(array_filter($res)){
							foreach ($res as $key => $value) {
								$obj = new riesgo_retencion($value);
							?>
							<li>
								<input type="hidden" name="id_personal[]" value="<?php echo $obj->getId_personal() ?>">
								<input type="hidden" class="position" name="posicion[]" value="<?php echo $obj->getPosicion() ?>">
								<?php echo $meth->htmlprnt($meth->get_pname($obj->getId_personal())) ?>
							</li>
							<?php
							}
						}else{
						?>
						<li></li>
						<?php
						}
						?></ul></td>
				<td><ul id="12" class="sortable">
						<?php
						$res = $riesgo->select_x_posicion(12);
						if(array_filter($res)){
							foreach ($res as $key => $value) {
								$obj = new riesgo_retencion($value);
							?>
							<li>
								<input type="hidden" name="id_personal[]" value="<?php echo $obj->getId_personal() ?>">
								<input type="hidden" class="position" name="posicion[]" value="<?php echo $obj->getPosicion() ?>">
								<?php echo $meth->htmlprnt($meth->get_pname($obj->getId_personal())) ?>
							</li>
							<?php
							}
						}else{
						?>
						<li></li>
						<?php
						}
						?></ul></td>
			</tr>
		</table>
	</form>
	<div class="btn-group col-md-2 col-md-offset-5" role="group" aria-label="...">
		<input type="submit" id="submit" name="guardar" data-loading-text="Guardando..." class="btn btn-sm btn-success" value="Guardar">
	</div>
</div>
<script>
	$(function() {
		$( "#selector.sortable" ).sortable({ 
			placeholder: "ui-sortable-placeholder",
			connectWith: 'ul.sortable',
			helper: 'clone',
			items: "> li:gt(0)", 
			revert: true,
			receive: function(event, ui) {
				// var chk = ui.item.find('.temas')
	      // console.log(this.id);
	      // if(this.id == 1)
	      // 	console.log(chk[0].checked = true);
	      // else
	      // 	console.log(chk[0].checked = false);
	    }
	  });
		$( ".sortable" ).sortable({ 
			placeholder: "ui-sortable-placeholder",
			connectWith: 'ul.sortable',
			helper: 'clone',
			items: "> li", 
			revert: true,
			receive: function(event, ui) {
				var chk = ui.item.find('.position')
				$(chk).val(this.id);
	      // console.log(this.id);
	      // if(this.id == 1)
	      // 	console.log(chk[0].checked = true);
	      // else
	      // 	console.log(chk[0].checked = false);
	    }
	  });
	});
	$('#submit').click(function(){
		riesgo_save(this);
	});

	function riesgo_save(obj){
		var $btn = $(obj).button('loading'); 
		var form = $('#riesgo_form');
		$.ajax({
      url: AJAX+"/riesgo_ajax", // Get the action URL to send AJAX to
      type: "POST",
      data: form.serialize(), // get all form variables
      success: function(result){
      	$().toastmessage('showSuccessToast', 'Se ha guardado el formulario');
      	window.oneye = result;
      	$btn.button('reset');
      	$('body').append(result);
      }
    });
	}
</script>