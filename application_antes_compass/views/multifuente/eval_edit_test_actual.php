<?php
  $meth = new Multifuente();
?>
<?php
if (is_array($evaluado)) {
?>
<form action="<?php echo BASEURL ?>multifuente/eval_edit_test_actual" method="POST">
	<div class="row">
		<p class="text-center">Seleccionar a los evaluados</p>
    	<p class="text-center">&nbsp;</p>
	    <div class="col-sm-5">
			<table class="table table-bordered table-striped table-hover table-heading tablesorter" id="datatable">
			    <thead>
			        <tr>
			            <th class="header">Nombre</th>
			            <th class="header">Cargo</th>
			        </tr>
			    </thead>
			    <tbody>
			    <!-- Start: list_row -->
			        <?php foreach ($evaluado as $a => $b) { 
			            //$b = reset($b); ?>
			            <tr>
			                <td><a href="<?php echo BASEURL.'multifuente/edit_eval_curso/'.$b['id'] ?>"><?php echo  $meth->htmlImage_($b['foto'],'img-rounded sm-img').$meth->htmlprnt($b['nombre']); ?></a></td>
			                <td><?php echo $meth->htmlprnt($b['cargo']); ?></td>
			            </tr>
			        <?php } ?> 
			    <!-- End: list_row -->
			    </tbody>
			</table>
		</div>
</form>
<?php
}else{
	echo "<h3>No hay evaluadores</h3>";
}
?>