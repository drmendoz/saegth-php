<?php

$meth = new Ajax();

if($_REQUEST)
{
	$id = $_REQUEST['id'];
	$table = $_REQUEST['table_name'];
	$holder = $_REQUEST['holder'];

	$results = $meth->DB_exists_double($table,'id_empresa',$_SESSION["Empresa"]["id"],'id',$id);

	if(array_filter($results))
	{?>	
		<div class="form-group holder">
            <div class="col-md-12">
        <?php 	foreach ($results as $a => $b) { 
        	$b = reset($b); ?>
					<input type="text" class="form-control" readonly="readonly" value="<?php echo $meth->htmlprnt($b['nombre']);?>">
		<?php	}?>  
            </div>
		</div>
	<?php	
	}
}
?>