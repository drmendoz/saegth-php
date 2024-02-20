<?php

$meth = new Ajax();

if($_REQUEST)
{

	$id = $_REQUEST['id'];
	$campo = $_REQUEST['campo'];
	$valor = $_REQUEST['valor'];

	$results = $meth->query('UPDATE `empresa` SET `'.$campo.'`='.$valor.' WHERE id='.$id.'');

	echo mysqli_error($meth->link);

}

?>