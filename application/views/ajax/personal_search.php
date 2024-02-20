<?php

$meth = new Ajax();

if($_REQUEST)
{
	if($_REQUEST['personal'] != ''){
		$personal = mysqli_real_escape_string($meth->link,$_REQUEST['personal']);
		$exclude = mysqli_real_escape_string($meth->link,$_REQUEST['exclude']);

		$results = $meth->query_('SELECT id,nombre,cargo,foto from listado_personal_op WHERE nombre LIKE "%'.$personal.'%" AND empresa='.$_SESSION['USER-AD']['id_empresa'].' AND id NOT IN('.$exclude.')');
		
		if($_REQUEST['id_input'] == 'id_per_edit')
			$class = 'style="background-color: lightblue;"';
		else
			$class = '';
		
		if($results){ ?>
		<table id="personal_search" class="table table-bordered table-striped table-hover table-heading table-datatable">
			<?php			foreach ($results as $a => $b) { ?>
			<tr <?php echo $class ?>>
				<td><input class="id_search" type="checkbox" name="<?php echo $_REQUEST['id_input'] ?>[]" value="<?php echo $b['id'].',2'; ?>" ></td>
				<td><a href="<?php echo BASEURL.'user/view/'.$b['id'] ?>" target="_blank"><?php echo  $meth->htmlImage_($b['foto'],'img-rounded sm-img').$meth->htmlprnt($b['nombre']); ?></a></td>
				<td><?php echo $meth->htmlprnt($b['cargo']); ?><div ><input class="relacion" type="hidden" name="rel[]" value="2"></div></td>
			</tr>
			<?php
		} ?>
	</table>
	<?php	}else{
		echo "<p class='errmsg'>No hay resultados</p>";
	}
}
}

?>
<script type="text/javascript">
	$('#personal_search tbody').sortable({
		connectWith: '.table tbody',
		helper: 'clone',
  cursor: "move",
  revert: true
	}).disableSelection();
</script>