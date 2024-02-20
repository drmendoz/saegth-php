<?php

if($_REQUEST){
	$cargo = new Empresa_tcont();
	$cargo->select($_REQUEST["id_s"]);
	$cargo->delete();	
	echo mysqli_error($cargo->link);
}

?>