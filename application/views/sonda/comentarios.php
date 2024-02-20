

<?php
$filtros = (isset($_SESSION['filtros'])) ? $_SESSION['filtros'] : "" ;
$user_foda = new Sonda_user_foda();
$arrCom = $user_foda->select_x_user($id_s, $ids);
$newArray = array();
$cont = 1;
$util = new Util();

if (is_array($arrCom)) {
	foreach ($arrCom as $cont => $value) {
		$newArray[$value['tipo']][$cont] = $value;
		$cont++;
	}
}
?>
<h4>Comentarios FODA</h4>
<?php echo $filtros ?>
<br>
<table class="table table-bordered col-md-9">
	<tr>
		<th width="5%" class="text-center">#</th>
		<th>Fortalezas</th>
	</tr>
	<?php
	if (isset($newArray['F']) && is_array($newArray['F'])) {
		$cont = 1;
		foreach ($newArray['F'] as $key => $value) {
	?>
	<tr>
		<td class="text-center"><?php echo $cont; ?></td>
		<td><?php echo $util->htmlprnt($value['comentario']); ?></td>
	</tr>
	<?php
			$cont++;
		}
	}
	?>
</table>
<br>
<table class="table table-bordered col-md-9">
	<tr>
		<th width="5%" class="text-center">#</th>
		<th>Oportunidades</th>
	</tr>
	<?php
	if (isset($newArray['O']) && is_array($newArray['O'])) {
		$cont = 1;
		foreach ($newArray['O'] as $key => $value) {
	?>
	<tr>
		<td class="text-center"><?php echo $cont; ?></td>
		<td><?php echo $util->htmlprnt($value['comentario']); ?></td>
	</tr>
	<?php
			$cont++;
		}
	}
	?>
</table>
<br>
<table class="table table-bordered col-md-9">
	<tr>
		<th width="5%" class="text-center">#</th>
		<th>Debilidades</th>
	</tr>
	<?php
	if (isset($newArray['D']) && is_array($newArray['D'])) {
		$cont = 1;
		foreach ($newArray['D'] as $key => $value) {
	?>
	<tr>
		<td class="text-center"><?php echo $cont; ?></td>
		<td><?php echo $util->htmlprnt($value['comentario']); ?></td>
	</tr>
	<?php
			$cont++;
		}
	}
	?>
</table>
<br>
<table class="table table-bordered col-md-9">
	<tr>
		<th width="5%" class="text-center">#</th>
		<th>Amenazas</th>
	</tr>
	<?php
	if (isset($newArray['A']) && is_array($newArray['A'])) {
		$cont = 1;
		foreach ($newArray['A'] as $key => $value) {
	?>
	<tr>
		<td class="text-center"><?php echo $cont; ?></td>
		<td><?php echo $util->htmlprnt($value['comentario']); ?></td>
	</tr>
	<?php
			$cont++;
		}
	}
	?>
</table>
<br>