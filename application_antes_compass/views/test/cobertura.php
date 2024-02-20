<?php 
if(sizeof($ids)>0){
	$personal_empresa = new personal_empresa;
	$empresa_area = new empresa_area;
	?>
	<div class="col-md-8 col-offset-md-2">
		<table class="table table-bordered">
			<tr>
				<th>Nombre</th>
				<th>Area</th>
			</tr>
			<?php
			foreach ($ids as $key => $value) {
			echo '<tr>';
				$actual = Personal::withID($value['id_personal']);
				echo "<td><a href='".BASEURL."test/cover/".$value['id_personal']."'>".$actual->getNombre_p()."</a></td>";
				$personal_empresa->select($value['id_personal']);
				$empresa_area->select($personal_empresa->id_area);
				echo "<td>".$empresa_area->getNombre()."</td>";
			echo '</tr>';
			}
			?>
			</tr>
		</table>
	</div>
	<?php 
}else{
?>
<h4 class="bg-warning">No hay personal que haya completado sus Preferencias de desarrollo de Carrera.</h4>
<?php 
}
?>