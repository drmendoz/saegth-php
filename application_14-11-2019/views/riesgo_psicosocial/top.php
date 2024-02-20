<?php 
$tipo = ($order) ? "alto" : "bajo" ; 
$filtros = (isset($_SESSION['RR']['filtros'])) ? $_SESSION['RR']['filtros'] : "" ;
?>
<h4>Preguntas con puntaje más <?php echo $tipo ?></h4>
<p><?php echo $filtros ?></p>
<table class="table table-bordered col-md-9">
	<tr>
		<th class="text-center">#</th>
		<th>Pregunta</th>
		<th class="text-center">Puntaje</th>
	</tr>
	<?php 
	foreach ($res as $key => $value) {
		?>
		<tr>
			<td class="text-center"><?php echo $key+1 ?></td>
			<td><?php echo $value['pregunta']; ?></td>
			<td class="text-center"><?php echo number_format($value['porcentaje'],2) ?></td>
		</tr>
		<?php 
	}
	?>
</table>