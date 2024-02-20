<?php

$meth = new Ajax();

if($_REQUEST)
{

	$id = $_REQUEST['id'];
	$campo = $_REQUEST['campo'];
	$valor = $_REQUEST['valor'];

	if($campo=="activo"){
		$meth->query('UPDATE `personal` SET `'.$campo.'`='.$valor.' WHERE id='.$id.'');
	}else{
		$meth->query('UPDATE `personal_test` SET `'.$campo.'`='.$valor.' WHERE id_personal='.$id.'');
		if($campo == 'scorer')
			$meth->query('UPDATE `scorer_estado` SET `activo`='.$valor.' WHERE id_personal='.$id.'');
	}

	echo mysqli_error($meth->link); 
}

?>