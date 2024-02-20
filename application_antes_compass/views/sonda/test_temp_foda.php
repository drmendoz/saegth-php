<?php 
	if ($foda) {
		if ($foda == 1) {
?>
<div style="margin-top:20px" class="col-md-12">
	<h4>Comentarios FODA</h4>
	<br>
	<div class="col-md-3">
		<table class="table table-bordered" id="hacer_1">
			<tr>
				<th class="text-center" colspan="1">Fortalezas</th>
			</tr>
			<tr>
				<td>
					<textarea class="form-control" name="comentario[F]" ></textarea>
				</td>
			</tr>
		</table>
	</div>
	<div class="col-md-3">
		<table class="table table-bordered" id="hacer_1">
			<tr>
				<th class="text-center" colspan="1">Oportunidades</th>
			</tr>
			<tr>
				<td>
					<textarea class="form-control" name="comentario[O]" ></textarea>
				</td>
			</tr>
		</table>
	</div>
	<div class="col-md-3">
		<table class="table table-bordered" id="hacer_1">
			<tr>
				<th class="text-center" colspan="1">Debilidades</th>
			</tr>
			<tr>
				<td>
					<textarea class="form-control" name="comentario[D]" ></textarea>
				</td>
			</tr>
		</table>
	</div>
	<div class="col-md-3">
		<table class="table table-bordered" id="hacer_1">
			<tr>
				<th class="text-center" colspan="1">Amenazas</th>
			</tr>
			<tr>
				<td>
					<textarea class="form-control" name="comentario[A]" ></textarea>
				</td>
			</tr>
		</table>
	</div>
</div>
<?php
		}
	}
?>