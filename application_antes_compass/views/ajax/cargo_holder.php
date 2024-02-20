<?php

$meth = new Ajax();

if($_REQUEST)
{

	$id = $_REQUEST['crg_id'];
	$table = $_REQUEST['table_name'];
	$holder = $_REQUEST['holder'];

	$results = $meth->query('SELECT `id_personal` FROM '.$table.' WHERE `id_cargo`='.$id.'');

	if(array_filter($results))
	{?>	
		<div class="form-group">
            <label class="col-md-5">Nombre Superior</label> 
            <div class="col-md-6 <?php echo $id ?>" id="show_sub_categories">
				<select name="pid_sup" required="required" class="form-control">
					  <option value="" selected="selected">-- Seleccionar una opci&oacute;n --</option>
				<?php
				foreach ($results as $a => $b)
				{ $b = reset($b); ?>
					<option value="<?php echo $b['id_personal'];?>"><?php echo $meth->htmlprnt($meth->get_pname($b['id_personal']));?></option>
				<?php
				}?>
				</select>	
			</div>
		</div>
	<?php	
	}
}
?>