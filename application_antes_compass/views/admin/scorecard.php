<form action="<?php echo BASEURL ?>admin/scorecard " method="POST">
	<div class="row">
		<div class="col-md-12" >
			<div class="col-md-6 show-grid">
				<p>Empresa</p>
				<select required="required" class="form-control" name="selectEmpresa" placeholder="Ingreso de nueva empresa">
					<option>-- Empresa --</option>
					<?php
						foreach ($empresas as $a => $b) {
							$c = $b['Empresa'];
							echo '<option value="'. $c['id'] .'" >'. Util::htmlprnt($c['nombre']) .'</option>';
						}
					?>		
					</select>
			</div>
			<div class="col-md-6 show-grid">
				<p>Valoraci&oacute;n Scorecard</p>
				<table class="table-bordered" style="width:100%;">
					<tr>
						<th>Resultado</th>
						<th style="text-align: center;">Min</th>
						<th style="text-align: center;">Max</th>
					</tr>
					<tr>
						<td style="text-align: center;">1</td>
						<td><input type="text" name="valmin[]" required="required" class="form-control"></td>
						<td><input type="text" name="valmax[]" required="required" class="form-control"></td>
					</tr>
					<tr>
						<td style="text-align: center;">2</td>
						<td><input type="text" tabindex="-1" readonly="readonly" name="valmin[]" required="required" class="form-control"></td>
						<td><input type="text" name="valmax[]" required="required" class="form-control"></td>
					</tr>
					<tr>
						<td style="text-align: center;">3</td>
						<td><input type="text" tabindex="-1" readonly="readonly" name="valmin[]" required="required" class="form-control"></td>
						<td><input type="text" name="valmax[]" required="required" class="form-control"></td>
					</tr>
					<tr>
						<td style="text-align: center;">4</td>
						<td><input type="text" tabindex="-1" readonly="readonly" name="valmin[]" required="required" class="form-control"></td>
						<td><input type="text" name="valmax[]" required="required" class="form-control"></td>
					</tr>
					<tr>
						<td style="text-align: center;">5</td>
						<td><input type="text" tabindex="-1" readonly="readonly" name="valmin[]" required="required" class="form-control"></td>
						<td><input type="text" name="valmax[]" required="required" class="form-control"></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12" >
			<div class="col-md-6" >
				<p>Progresi&oacute;n Scorecard</p>
				<table class="table-bordered" style="width:100%;">
					<tr>
						<td>V. Inicial (%)</td>
						<td><input type="text" id="vinicial" name="vinicial" class="form-control"></td>
					</tr>
					<tr>
						<td>Columnas</td>
						<td>
							<select name="col" id="col" class="form-control">
							<?php for ($i=1; $i < 15; $i++) { ?>
								<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
							<?php } ?>
							</select>
						</td>
					</tr>
					<tr>
						<td>Razon</td>
						<td><input type="text" id="razon" name="razon" class="form-control"></td>
					</tr>
					<tr>
						<td>V. Final</td>
						<td><input type="text" tabindex="-1" id="vfinal" name="vfinal" readonly="readonly" class="form-control"></td>
					</tr>
				</table>
			</div>
			<div class="col-md-6" >
				<p>Ponderaci&oacute;n Scorecard VS 360</p>
				<table class="table-bordered" style="width:100%;">
					<tr>
						<td>Scorecard</td>
						<td>
							<select id="scorep" name="scorep" class="form-control">
							<?php for ($i=10; $i <= 100; $i+=10) { ?>
								<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
							<?php } ?>
							</select>
						</td>
					</tr>
					<tr>
						<td>360</td>
						<td><input type="text" id="compassp" name="compassp" readonly="readonly" class="form-control"></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-3 col-md-offset-6 show-grid">
			<input class="btn btn-default btn-xs" type="submit" id="submit" name="button" value="Continuar">
		</div>
	</div>
</form>
<script type="text/javascript">
	
	$("#vinicial").change(function(){
		$("#vfinal").val(getFval());
	})
	$("#col").change(function(){
		$("#vfinal").val(getFval());
	})
	$("#razon").change(function(){
		$("#vfinal").val(getFval());
	})

	$("#scorep").change(function(){
		var score = parseInt($("#scorep").val());
		$("#compassp").val(100-score);
	})

	$("input[name='valmax[]']").change(function(){
		$(this).parent().parent().next().children().children("input[name='valmin[]']").val($(this).val());
	})

	$("#submit").click(function(){
		var err1 = false;
		var err2 = false;
		$('form').find(':input').not(':input[type=button], :input[type=submit]').each(function(){
			if(isNaN(parseInt($(this).val()))) {
				err1 = true;
				console.log(parseInt($(this).val()));
				event.preventDefault();
				$(this).css("border", "red solid 1px");
			}else{
				$(this).css("border", "0");
			}
		});
		$('form').find("input[name='valmax[]']").each(function(){
			var max = parseInt($(this).val());
			var min = parseInt($(this).parent().siblings().children("input[name='valmin[]']").val());
			if(min > max){
				err2 = true;
				$(this).css("border", "red solid 1px");
			}
		});
		console.log(err1 + " " + err2);
		if(err1 && err2)
			alert("Los valores deben ser numericos y no deben haber campos vacios. Los valores Max deben ser mayores que Min");
		else if(err1 && !err2)
			alert("Los valores deben ser numericos y no deben haber campos vacios.");
		else if(err2 && !err1)
			alert("Los valores Max deben ser mayores que Min");
	})

	function getFval(){
		var vinicial = parseInt($("#vinicial").val());
		var col = parseInt($("#col").val());
		var razon = parseInt($("#razon").val());
		console.log(vinicial);
		console.log(col);
		console.log(razon);
		if(!isNaN(vinicial))
			if(!isNaN(col))
				if(!isNaN(razon))
					return vinicial + (col * razon);
	}

	$(document).ready(function() {
		$("#vinicial").keydown(function(event){
			if(event.keyCode == 13) {
			  	event.preventDefault();
			  	return false;
			}
		});
		$("#razon").keydown(function(event){
			if(event.keyCode == 13) {
			  	event.preventDefault();
			  	return false;
			}
		});

		var score = parseInt($("#scorep").val());
		$("#compassp").val(100-score);

	});

</script>

