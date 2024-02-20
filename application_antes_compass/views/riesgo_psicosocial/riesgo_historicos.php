<style type="text/css">
	select {height: 120px !important}
	#area_seg{height: 400px !important}
	.progress{height: 40px;}
	.progress-bar{
		font-size: 24px;
		padding-top: 8px;
		border-color: rgba(0, 0, 0, 0.3);
		width: calc(100%/3);
	}
</style>
<?php 
$riesgo = new Riesgo_psicosocial();
?>
<h4>DIAGNÓSTICO DE RIESGO PSICOSOCIAL</h4>
<h5>Encuestas Creadas</h5>
<br>
<?php
foreach ($new_arrFechas as $anio => $value) {
	$fecha = $value['fecha'];
	$anio = substr($fecha, 0, 4);
	$mes = substr($fecha, 5, 2);
	$mes = $riesgo->parseMonth($mes);
	$dia = substr($fecha, 8, 2);
	$id_s = $value['id'];		
	?>
	<button type="button" class="btn btn-primary"><a style="color: white" href='<?php echo BASEURL ?>riesgo_psicosocial/riesgo_resultados/<?php echo $id_s; ?>'><?php echo $dia.'-'.$mes.'-'.$anio; ?></a></button>
	<br>
<?php
}
?>