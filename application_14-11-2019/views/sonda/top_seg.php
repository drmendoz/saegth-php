<?php 
$tipo = ($order=="DESC") ? "mejor" : "peor" ; 
$filtros = (isset($_SESSION['filtros'])) ? $_SESSION['filtros'] : "" ;
?>
<h4>Preguntas con <?php echo $tipo ?> puntaje</h4>
<p><?php echo $filtros ?></p>
<table class="table table-bordered col-md-9">
	<tr>
		<th class="text-center">#</th>
		<th>Pregunta</th>
		<th class="text-center">Puntaje</th>
	</tr>
	<?php 
	$x = new Sonda_pregunta();
	if (is_array($preguntas)) {
		foreach ($preguntas as $key => $value) {
		$x->setPregunta($value['pregunta']);
		?>
		<tr>
			<td class="text-center"><?php echo $key+1 ?></td>
			<td><?php echo $x->getPregunta(); ?></td>
			<td class="text-center"><?php echo number_format($value['res'],2) ?></td>
		</tr>
		<?php 
		}
	}
 	?>
</table>