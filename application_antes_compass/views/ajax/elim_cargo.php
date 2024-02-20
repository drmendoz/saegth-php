<?php

if($_REQUEST){
	$cargo = new Empresa_cargo();
	$cargo->select($_REQUEST["id_s"]);
	$cargo->delete();	
}

?>