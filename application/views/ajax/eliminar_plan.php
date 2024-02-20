<?php

$meth = new Ajax();

if($_REQUEST)
{
	$id = $_REQUEST['id'];
	$eval = $_REQUEST['evaluacion'];

	if($eval){
		$obj = new Scorer_oportunidad(array('id' => $id ));
		$obj->delete();
	}else{
		$obj = new Compass_oportunidad(array('id' => $id ));
		$obj->delete();
	}
}
?>