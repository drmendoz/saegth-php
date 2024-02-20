<form method="POST" action="<?php echo BASEURL ?>sonda/def_preguntas">
	<?php
	if(isset($sonda) && $sonda != ''){
		$sondaObj = new Sonda();
		$sondaObj->select_($_SESSION['Empresa']['id'], $sonda);
		$temas_vigentes = $sondaObj->getTemas();
	}

	$tem = new Sonda_tema();
	foreach ($temas as $key => $value) {
		$tem->setId($value);
		$tem->select();

		if($sonda && $sonda != ''){
			$arrPreguntas = $temas_sonda[$value];
		}
		?>
		<h3 class="text-capitalize"><?php echo $tem->getTema(); ?> - <span><input type="checkbox" onclick="marcar('<?php echo $value ?>')"> <small>marcar todos</small></span></h3>
		<?php
		$preguntas = new Sonda_pregunta();
		$res = $preguntas->select_x_tema__($value,$_SESSION['Empresa']['id']);
		?>
		<table id="<?php echo $tem->getId() ?>">
			<?php
			foreach ($res as $key_ => $value_) {
				$preg = new Sonda_pregunta($value_);
				?>
				<tr>
					<td><input type="checkbox" name="preguntas[]" value="<?php echo $value.",".$preg->getId() ?>" <?php echo ($sonda && $sonda != '') ? (in_array($preg->getId(), $arrPreguntas)) ? 'checked' : '' : '' ?>></td>
					<td><?php echo $preg->getPregunta(); ?></td>
				</tr>
				<?php 
			}
			?>
		</table>
		<?php
	}
	?>
	<input type="submit" name='submit' value="Guardar" class="btn-lg btn btn-default">
</form>
<script type="text/javascript">
	var marcar = function(t_id){
		var inputs = $('#'+t_id).find('input')
		$.each(inputs,function(index,value){
			//$(value).trigger('click')
			if($(value).is(':checked')){
				$(value).prop('checked', false);
			}else{
				$(value).prop('checked', true);
			}
		})
	}
</script>