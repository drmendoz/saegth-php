<?php

$meth = new Ajax();

if($_REQUEST)
{

	$id = $_REQUEST['id'];
	$campo = $_REQUEST['campo'];
	$valor = $_REQUEST['valor'];

	$results = $meth->query('UPDATE `scorer_estado` SET `'.$campo.'`='.$valor.' WHERE id_personal='.$id.'');

	echo mysqli_error($meth->link); 

}

?>