<form method="POST" action="<?php echo BASEURL ?>sonda/def_preguntas_v/<?php echo $id_s ?>">
	<?php
	$tem = new Sonda_tema();
	foreach ($temas as $key => $value) {
		$tem->setId($key);
		$tem->select();
		$arrPreguntas = $temas[$key];
		?>
		<h3 class="text-capitalize"><?php echo $tem->getTema(); ?> - <span><input type="checkbox" onclick="marcar('<?php echo $key ?>')"> <small>marcar todos</small></span></h3>
		<?php
		$preguntas = new Sonda_pregunta();
		$res = $preguntas->select_x_tema__($key,$_SESSION['Empresa']['id']);
		?>
		<table id="<?php echo $tem->getId() ?>">
			<?php
			foreach ($res as $key_ => $value_) {
				$preg = new Sonda_pregunta($value_);
				?>
				<tr>
					<td><input type="checkbox" name="preguntas[]" value="<?php echo $key.",".$preg->getId() ?>" <?php echo (in_array($preg->getId(), $arrPreguntas)) ? 'checked' : '' ?>></td>
					<td><?php echo $preg->getPregunta(); ?></td>
				</tr>
				<?php 
			}
			?>
		</table>
		<?php
	}
	?>
	<br><br>
	<input type="submit" name='submit' value="Guardar" class="btn-lg btn btn-default">
</form>
<script type="text/javascript">
	var marcar = function(t_id){
		var inputs = $('#'+t_id).find('input')
		$.each(inputs,function(index,value){
			$(value).trigger('click')
		})
	}
</script>