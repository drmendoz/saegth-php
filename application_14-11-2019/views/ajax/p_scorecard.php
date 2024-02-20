<?php

$meth = new Scorecard();

if($_REQUEST)
{

	$id = $_REQUEST['id'];
	$r_scorer= $_REQUEST['val'];
	
	$scorer_det = $meth->get_scorer($_SESSION["Empresa"]["id"]);
	echo $meth->scorer_rango($scorer_det['detalle'],intval($r_scorer)); 
	

}

?>

