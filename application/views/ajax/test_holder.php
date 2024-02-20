<?php

$meth = new Ajax();
if($_REQUEST)
{
	$arr = $meth->query('SELECT * FROM `empresa` WHERE 1 ORDER BY `nombre` ASC');
			//var_dump($arr);
	$empresas = $arr;

	$id = $_REQUEST['emp_id'];
	$table = $_REQUEST['table_name'];
	$holder = $_REQUEST['holder'];

	$results = $meth->DB_exists($table,'cod_test',$id);

	$_SESSION['Empresa']['id'] = $id;

	if(array_filter($results))
	{?>	
	<form action="<?php echo BASEURL ?>multifuente/ver" method="POST">
		<div class="col-xs-12 col-sm-12 holder">
			<div class="box">
				<div class="box-header">
					<div class="box-name ui-draggable-handle">
						<i class="fa fa-table"></i>
						<span>Test</span>
					</div>
					<div class="box-icons">
						<a class="collapse-link">
							<i class="fa fa-chevron-up"></i>
						</a>
						<a class="expand-link">
							<i class="fa fa-expand"></i>
						</a>
					</div>
					<div class="no-move"></div>
				</div>
				<div class="box-content no-padding">
					<table class="table table-bordered table-striped table-hover table-heading table-datatable" id="datatable-1">
						<thead>
	                        <tr>
	                            <th>#</th>
	                            <th>Pregunta</th>
	                        </tr>
	                    </thead>
	                    <tbody>
	                    <!-- Start: list_row -->
	                        <?php foreach ($results as $a => $b) { 
	                        	$b = reset($b); ?>
	                            <tr>
	                                <td><input type="checkbox" name="chk[]" readonly="readonly" checked="checked" value="<?php echo $b['cod_pregunta'].','.$a.','.$b['cod_tema']; ?>" ></td>
	                                <td><textarea class="form-control col-xs-11 col-sm-11" style="max-width:95%" name="pregunta[]" readonly="readonly"><?php echo Util::htmlprnt($b['pregunta']); ?></textarea></td>
	                            </tr>
	                        <?php } ?> 
	                    <!-- End: list_row -->
	                    </tbody>
					</table>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<div class="row form-group text-center">
						<p>Para clonar el test debe seleccionar la empresa, nombre y descripci&oacute;n</p>
					</div>
					<div class="row form-group">
						<label class="col-md-4">Nombre Empresa</label>
						<div class="col-md-8">
							<select required="required" class="form-control" name="empresa" placeholder="Ingreso de nueva empresa">
            					<option>-- Seleccionar Empresa --</option>
					          <?php
					            foreach ($empresas as $a => $b) {
									$c = $b['Empresa'];
									echo '<option value="'. $c['id'] .';'. Util::htmlprnt($c['nombre']) .'" >'. Util::htmlprnt($c['nombre']) .'</option>';
					            }
					          ?>    
					        </select>
						</div>
					</div>
					<div class="row form-group">
						<label class="col-md-4">Nombre del Test</label>
						<div class="col-md-8">
							<input type="text" class="form-control" name="nombre">
						</div>
					</div>
					<div class="row form-group">
						<label class="col-md-4">Descripci&oacute;n</label>
						<div class="col-md-8">
							<input type="text" class="form-control" name="descrip">
						</div>
					</div>
					<input class="btn btn-default btn-xs" type="submit" name="button" value="Continuar">
				</div>
			</div>
		</div>
	</form>
				
	<?php	
	}else{ ?>
		<div class="row text-center page-404 holder">
			<div class="col-md-12">
			    <h2>No hay personal ingresado</h2>
			</div>
		</div>
<?php	}
}
/*
*/
?>

