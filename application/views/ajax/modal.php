<?php

$meth = new Ajax();

if($_REQUEST)
{

	$id = $_REQUEST['id'];
	$id_e = $_REQUEST['id_e'];
	$val = $_REQUEST['val'];

	$results = $meth->query('DELETE FROM modal WHERE id_empresa='.$id_e.' AND modal_id='.$id.';');
	$results = $meth->query('INSERT INTO modal (modal_id,id_empresa,activo) VALUES('.$id.','.$id_e.','.$val.')');
	echo 1;

}

?>