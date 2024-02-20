<?php if(!isset($custom_danger)){ ?>
<?php $meth = new Scorecard(); ?>
  <div class="form-group col-md-12">
      <table class="table-bordered"  style="width: 100%; line-height: 40px;">
        <tr>
          <td class="col-md-4"><b>PERSONAL: </b><?php echo $nombre; ?></td>
          <td class="col-md-4"><b>CARGO: </b><?php echo $cargo; ?></td>
          <td class="col-md-4"><b>SUPERVISOR DIRECTO: </b><?php echo $superior; ?></td>
        </tr>
        <tr>
          <td class="col-md-4"><b>EMPRESA: </b><?php echo $meth->htmlprnt($_SESSION['Empresa']['nombre']) ?></td>
          <td colspan="2" class="col-md-4"><b>&Aacute;REA: </b><?php echo $area; ?></td>
          <!-- <td class="col-md-4"><b>FECHA DE EVALUACION: </b><?php //echo $meth->print_fecha($fecha); ?></td> -->
        </tr>
      </table>
  </div>  

<form id="form_plan_desarrollo">
	<table class="table table-bordered" id="plan_desarrollo">
		<tr>
			<th width="10" class="text-center">#</th>
			<th class="text-center col-md-2">&Aacute;rea</th>
			<th class="text-center col-md-2">Cargo</th>
			<th class="text-center col-md-2">Plazo</th>
			<th class="text-center col-md-2">Acción a tomar</th>
      <th class="text-center col-md-2">Tipo de acci&oacute;n</th>
      <th class="text-center col-md-2">Fecha de cumplimiento</th>
		</tr>
		<?php 
		$it = new plan_desarrollo(); 
		$it = $it->select_all($id);
		?>
		<?php if (array_filter($it)){
		foreach ($it as $key => $value) {
			$obj = new plan_desarrollo($value);
		?>
		<tr>
			<td>
				<a tabIndex="-1" class="elim" style="color:red"><i class="fa fa-times fa-2x grow"></i></a>
				<input type="hidden" name="action[]" class="action" value="update">
				<input type="hidden" name="id[]" class="id" value="<?php echo $obj->getId() ?>">
			</td>
			<td>
				<select name="area[]" class="form-control">
					<?php
					$test = new Empresa_area();
					$test->select($obj->getId_area());
					echo "<option value='".$test->id."'>".$test->getNombre()."</option>";
					$test->get_select_options($_SESSION['Empresa']['id']);
					?>
				</select>
			</td>
			<td>
				<select name="cargo[]" class="form-control">
					<?php
					$test = new Empresa_cargo();
					$test->select($obj->getId_cargo());
					echo "<option value='".$test->id."'>".$test->getNombre()."</option>";
					$test->get_select_options($_SESSION['Empresa']['id']);
					?>
				</select>
			</td>
			<td>
				<?php $opc_plazo = $obj->getOpc_plazo(); ?>
				<select class="form-control plazo" required="required" name="plazo[]">
					<option value="" style='display:none'>Seleccionar plazo</option>
					<option value="0" <?php if($opc_plazo == 0) echo "selected"; ?>>Menor a 6 meses</option>
					<option value="1" <?php if($opc_plazo == 1) echo "selected"; ?>>De 6 a 12 meses</option>
					<option value="2" <?php if($opc_plazo == 2) echo "selected"; ?>>De 12 a 24 meses</option>
					<option value="3" <?php if($opc_plazo == 3) echo "selected"; ?>>de 2 a 3 años</option>
					<option value="4" <?php if($opc_plazo == 4) echo "selected"; ?>>Mayor a 3 años</option>
				</select>
			</td>
			<td>
				<textarea class="form-control" name="accion[]"><?php echo $obj->getAccion(); ?></textarea>
			</td>
      <td>
        <select class="form-control" required="required" name="tipo[]"><?php echo $obj->tipo ?>
          <option value="">- Seleccionar tipo-</option>
          <option name="Coaching" <?php if($obj->tipo=="Coaching")echo "selected" ?>>Coaching</option>
          <option name="Mentoring" <?php if($obj->tipo=="Mentoring")echo "selected" ?>>Mentoring</option>
          <option name="Proyecto" <?php if($obj->tipo=="Proyecto")echo "selected" ?>>Proyecto</option>
          <option name="Rotación" <?php if($obj->tipo=="Rotación")echo "selected" ?>>Rotación</option>
          <option name="Curso" <?php if($obj->tipo=="Curso")echo "selected" ?>>Curso</option>
        </select>
      </td>
      <td>
        <input type="date" class="form-control" required="required" name="fecha[]" value="<?php echo $obj->fecha ?>">
      </td>
		</tr>
		<?php } ?>
		<?php }else{ ?>
		<tr>
			<td>
				<a tabIndex="-1" class="elim" style="color:red"><i class="fa fa-times fa-2x grow"></i></a>
				<input type="hidden" name="action[]" class="action" value="insert">
				<input type="hidden" name="id[]" class="id" value="">
			</td>
			<td>
				<select name="area[]" class="form-control">
					<?php
					$test = new Empresa_area();
					$test->get_select_options($_SESSION['Empresa']['id']);
					?>
				</select>
			</td>
			<td>
				<select name="cargo[]" class="form-control">
					<?php
					$test = new Empresa_cargo();
					$test->get_select_options($_SESSION['Empresa']['id']);
					?>
				</select>
			</td>
			<td>
				<select class="form-control plazo" required="required" name="plazo[]">
					<option value="" style='display:none'>Seleccionar plazo</option>
					<option value="0">Menor a 6 meses</option>
					<option value="1">De 6 a 12 meses</option>
					<option value="2">De 12 a 24 meses</option>
					<option value="3">de 2 a 3 años</option>
					<option value="4">Mayor a 3 años</option>
				</select>
			</td>
			<td>
				<textarea class="form-control" name="accion[]"> </textarea>
			</td>
      <td>
        <select class="form-control" required="required" name="tipo[]">
          <option value="">- Seleccionar tipo-</option>
          <option name="Coaching">Coaching</option>
          <option name="Mentoring">Mentoring</option>
          <option name="Proyecto">Proyecto</option>
          <option name="Rotación">Rotación</option>
          <option name="Curso">Curso</option>
        </select>
      </td>
      <td>
        <input type="date" class="form-control" required="required" name="fecha[]" >
      </td>
		</tr>
		<?php } ?>
	</table>
</form>
	<div class="col-md-4 col-md-offset-4">
		<div class="btn-group btn-group-justified" role="group" aria-label="...">
			<div class="btn-group" role="group">
				<button id="add_plan_desarrollo" type="button" class="btn btn-info">Agregar fila</button>
			</div>
			<div class="btn-group" role="group">
				<a id="save_plan_desarrollo" class="btn btn-success">Guardar</a>
			</div>
		</div>
	</div>
	    <?php 
    //$r_scorer = $meth->get_ScorecardRes($id,(date("Y")-1)); 
	    $r_scorer = $meth->get_ScorecardRes($id,date("Y")); 
    $r_score = $meth->scorer_rango($scorer,intval($r_scorer));
    $compass = round($meth->getAvg_test_eval($meth->get_codEval($id)),2);
    $p_score = $scorer->p_score;
    $total = ($r_score * $p_score / 100)+($compass * (100-$p_score) /100);
    ?>
    <div class="col-md-12 text-center">
      <?php 
      $atts = array('compass'=>$compass,'r_score'=>$r_score,'total'=>$total,'id_e'=>$id); 
      $atts = implode(";", $atts);
      $atts = urlencode($atts);

  $scorecard = new ScorecardController('Scorecard','scorecard','fase_final',0,true,true); 
  $scorecard->fase_final($atts); 
  $scorecard->ar_destruct();
  unset($scorecard); 
  ?>
    </div>

<script type="text/javascript">
	$(document).ready(function(){
		$("#form_plan_desarrollo").submit(function(e){
	    return false;
	});
		$('#add_plan_desarrollo').click(function(){
			desarrollo_form_save(this);
			$('.action').val("update");
			addRow('plan_desarrollo');
			$('.action').last().val('insert');
		});

		
	});

	$('#plan_desarrollo').on('click','.elim',function(){
		console.log($(this).siblings('.id').val());	
		$.ajax({
      url: AJAX+"/delete_entity", // Get the action URL to send AJAX to
      type: "POST",	
      data: {id:$(this).siblings('.id').val(),model:'plan_desarrollo'}, // get all form variables
      success: function(result){
     
      }
    });
		_deleteRow('plan_desarrollo',this);
	});

	$('#save_plan_desarrollo').on('click', function(e){
		e.preventDefault();
		desarrollo_form_save(this);
				$('.action').val("update");
	});

	function desarrollo_form_save(obj){
		var $btn = $(obj).button('loading'); 
		var form = $('#form_plan_desarrollo');
		$.ajax({
      url: AJAX+"/plan_desarrollo_ajax", // Get the action URL to send AJAX to
      type: "POST",
      data: form.serialize(), // get all form variables
      success: function(result){
      	$().toastmessage('showSuccessToast', 'Se ha guardado el formulario');
      	window.oneye = result;
      	$btn.button('reset');
      	var inputs = $('#form_plan_desarrollo .id');
      	$.each(JSON.parse(result),function(index,value){
      		$(inputs[index]).val(value.id);
      	});
      }
    });
	}

</script>
<?php } ?>