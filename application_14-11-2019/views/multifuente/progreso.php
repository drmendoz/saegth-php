<h5>Proceso de selección de evaluadores.<br>Se muestra el progreso de quienes hayan iniciado su selección.</h5>
<?php 
$mr = new Multifuente_relacion();
$resultados = $mr->list_progress($_SESSION['Empresa']['id']);

$success = '<h2><i class="fa fa-check" style="color:green"></i></h2>';
$error = '<h2><i class="fa fa-times" style="color:red"></i></h2>';
?>

<div class="col-md-3 col-xs-3 form-group">
	<input type="text" id="search" class="form-control" placeholder="Buscar">
</div>
<div id="personal" class="col-xs-12">
	<table class="table table-bordered table-striped table-hover table-heading table-datatable" id="table">
		<thead>
			<tr>
				<th>#</th>
				<th colspan="2">Nombre</th>
				<th colspan="2">Aprobación nivel 1</th>
				<th colspan="2">Aprobación nivel 2</th>
				<th colspan="2">Completo</th>
			</tr>   
		</thead>
		<?php foreach ($resultados as $a => $b){ ?>
		<tr>
			<td><?php echo ++$a ?></td>
			<td><?php echo $mr->htmlprnt($b['nombre']) ?></td>
			<td><?php echo $tmp = (($b['aprovado']-1)>=0) ? $success : $error ; ?></td>
			<td><?php echo $mr->htmlprnt($b['nombre_pid']) ?></td>
			<td><?php echo $tmp = (($b['aprovado']-1)>=1) ? $success : $error ; ?></td>
			<td>
				<?php 
				if($b['p_pid']==6015){
					echo "PLAZAS CRESPO CAROLINA";
				}else{
					echo $mr->htmlprnt($b['nombre_ppid']);
				}
				?>
			</td>
			<td><?php echo $tmp = (($b['aprovado']-1)>=2) ? $success : $error ; ?></td>
			<?php 
			if ($b['aprovado']==1) {
				$attr = array(
					'nivel' => 1, 
					'id' => $b['id'], 
					'nombre' => $mr->htmlprnt($b['nombre']), 
					'pid' => $b['pid'], 
					'n_pid' => $mr->htmlprnt($b['nombre_pid']), 
					);
			}elseif($b['aprovado']==2){
				$attr = array(
					'nivel' => 2, 
					'id' => $b['id'], 
					'nombre' => $mr->htmlprnt($b['nombre']), 
					'pid' => $b['pid'], 
					'n_pid' => $mr->htmlprnt($b['nombre_pid']), 
					'p_pid' => $b['p_pid'], 
					'n_ppid' => $mr->htmlprnt($b['nombre_ppid']), 
					);
			}
			?>
			<?php 
			if($b['aprovado']==3){
				?>
				<td colspan="2">Sí</td>
				<?php 
			}else{ 
				?>
				<td>No</td> 
				<td>
					<div class="row text-center" style="display: inline-block; float: none; white-space: nowrap;">
						<button type="button"  class="btn btn-sm btn-default center-block mailer" data-tipo="5" data-attr='<?php echo json_encode($attr) ?>' data-loading-text="Procesando..." style="padding:6px 12px" autocomplete="off">
							Enviar recordatorio
						</button>
					</div>
				</td> 
				<?php } ?>
			</tr>
			<?php } ?>
		</table>
	</div>
	<script type="text/javascript">

		$('.mailer').on('click', function () {
			var $btn = $(this).button('loading')
			var tipo = $(this).attr('data-tipo');
			var id = $(this).attr('data-attr');
			var holder = "mailer"
			$.post(AJAX + holder, {
				tipo: tipo,
				id: id,
			}, function(response) {
				$btn.button('reset')
			});
		})
		$('#search').keyup(function() {

			var val = '^(?=.*\\b' + $.trim($(this).val()).split(/\s+/).join('\\b)(?=.*\\b') + ').*$',
			reg = RegExp(val, 'i'),
			text;

			var $rows = $('#table tbody tr');
			$rows.show().filter(function() {
				text = $(this).text().replace(/\s+/g, ' ');
				return !reg.test(text);
			}).hide();
		});
	</script>