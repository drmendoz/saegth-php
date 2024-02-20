<?php

$meth = new Ajax();

if($_REQUEST)
{

	$id = $_REQUEST['parent_id'];
	$table = $_REQUEST['table_name'];
	$name = $_REQUEST['name'];
	$holder = $_REQUEST['holder'];
	$step = $_REQUEST['step'];


	$local = new empresa_local();
	$results = $local->select_all_pid($_SESSION["Empresa"]["id"],$id);

	$step++;

	switch ($step) {
		case 2:
		$label = "Ciudad";
		break;
		
		case 3:
		$label = "Sucursal";
		break;
	}

	if(array_filter($results))
		{?>	
	<div class="form-group">
		<label class="col-md-5"><?php echo $label ?></label> 
		<div hidden>
			<input type="text" class="form-control step" value="<?php echo $step ?>" >
		</div>  
		<div class="col-md-6 <?php echo $id ?>" id="show_sub_categories">
			<select name="<?php echo $name ?>" required="required" class="parent form-control <?php echo $id ?>">
				<option value="" selected="selected">-- Seleccionar una opci&oacute;n --</option>
				<?php
				foreach ($results as $a => $b){  ?>
				<option value="<?php echo $b['id'];?>"><?php echo $meth->htmlprnt($b['nombre']);?></option>
				<?php
			}?>
		</select>	
	</div>
</div>
<?php	
}
}
?>