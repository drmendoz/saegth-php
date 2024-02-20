<?php 
$flag=false;
if($_SESSION['USER-AD']['id_personal']!=6015){
?>
	<?php 
	$pe = new Personal_empresa();
	$res=$pe->multifuente_aprobacion_evaluadores($_SESSION['USER-AD']['id_personal'],2,2);
	$count_dir=$count_ind=0;
	if($res){
	?>
	<div class="col-md-8">
		<table class="table table-bordered">
			<tr>
				<th>#</th>
				<th>Nombre</th>
				<th>Acción</th>
			</tr>
			<?php
			foreach ($res as $key => $value) {
				if($value['level']==1){
					$count_dir++;
					$count_ind=0;
				}else{ 
					$count_ind++;
				}
				$counter = ($value['level']==1) ? $count_dir : $count_dir.".".$count_ind ;
				$counter = ($counter==0) ? 1 : $counter;
			?>
			<tr class="<?php echo ($value['level']==1) ? 'info' : ''  ?>">
				<td><?php echo $counter ?></td>
				<td><?php echo $pe->htmlprnt($value['nombre']) ?></td>
				<td>
					<?php if($value['level']==2){ ?>
					<a href="<?php echo BASEURL."user/confirmar_relacion/".$value['id'] ?>">Revisar y Aprobar</a>
					<?php  } ?>
				</td>
			</tr>
<?php 
			}
	}else{
		$flag = true;
	}

	if($_SESSION['USER-AD']['id_personal']==6018){
		$res=$pe->get_sub_id_level_op(6015,2,2);
		$count_dir=$count_ind=0;
		
		if($res){
	?>
			<tr>
				<td colspan="3" class="bg-info">Confirmaciones de FERNANDO JOSE DE LA PUENTE</td>
			</tr>
			<?php
			foreach ($res as $key => $value) {
				if($value['level']==1){
					$count_dir++;
					$count_ind=0;
				}else{ 
					$count_ind++;
				}
				$counter = ($value['level']==1) ? $count_dir : $count_dir.".".$count_ind ;
				$counter = ($counter==0) ? 1 : $counter ;
				?>
			<tr class="<?php echo ($value['level']==1) ? 'info' : ''  ?>">
				<td><?php echo $counter ?></td>
				<td><?php echo $pe->htmlprnt($value['nombre']) ?></td>
				<td>
					<?php if($value['level']==2){ ?>
					<a href="<?php echo BASEURL."user/confirmar_relacion/".$value['id'] ?>">Revisar y Aprobar</a>
					<?php  } ?>
				</td>
			</tr>
	<?php 
			}
		}else{
			$flag=true;
		}
	?>
		</table>
	</div>
			<?php 
	}
}
?>

<?php if($flag){ ?>
<div class="alert alert-warning col-md-12">
	<h2>No tiene pendientes</h2>
</div>
<?php } ?>