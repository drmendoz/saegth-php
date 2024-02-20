<?php $meth = new Multifuente(); ?>
<div class="row">
	<div class="col-md-12 show-grid">
		<h3 align="center">SISTEMA DE INFORMACIÓN GENERAL DEL PROCESO</h3>
	</div>
</div>
<div class="row form-group col-md-12">
	<table class="table-bordered"  style="width: 100%; line-height: 40px;">
	    <tr>
        	<td class="col-md-12" colspan="2"><b>Empresa: </b><?php echo $meth->htmlprnt(strtoupper($_SESSION['Empresa']['nombre'])) ?></td>
	    </tr>
	    <tr>
		    <td class="col-md-6">
		    	<table>
		    		<tr>
		    			<td><a class="txt-info" href="<?php echo BASEURL.'multifuente/resultados_evaluados' ?>">Resultados por evaluado</a></td>
		    		</tr>
		    		<tr>
		    			<td><a class="txt-info" target="_blank" href="<?php echo BASEURL.'multifuente/plan_de_accion' ?>">Plan de Acción General</a></td>
		    		</tr>
		<?php if($_SESSION['USER-AD']['user_rol']!=2){ ?>
		    		<tr>
		    			<td><a class="txt-info" href="<?php echo BASEURL.'multifuente/resultados_departamentos' ?>">Resultados por departamento</a></td>
		    		</tr>
		    		<tr>
		    			<td><a class="txt-info" href="<?php echo BASEURL.'multifuente/estatus_evaluados' ?>">Estatus del Proceso Por Evaluado</a></td>
		    		</tr>
		    		<tr>
		    			<td><a class="txt-info" href="<?php echo BASEURL.'multifuente/estatus_departamento' ?>">Estatus del Proceso Por Departamento</a></td>
		    		</tr>
		    		<tr>
		    			<td><a class="txt-info" href="<?php echo BASEURL.'multifuente/estatus_gerentes' ?>">Estatus del Proceso Por Gerente</a></td>
		    		</tr>
    		<?php } ?>
		    	</table>
		    </td>
		    <td class="col-md-6">
		    	<table>
		<?php if($_SESSION['USER-AD']['user_rol']==1){ ?>
		    		<tr>
		    			<td><a class="txt-success" href="<?php echo BASEURL.'multifuente/asignar_test' ?>">Asignar evaluaci&oacute;n</a></td>
		    		</tr>
    		<?php } ?>
		    	</table>
		    </td>
	    </tr>
	</table>
</div>