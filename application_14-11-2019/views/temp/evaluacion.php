<?php 
/* 
	user_rol
	
	4 => Sonda - En linea
	5 => Sonda - Manual
	8 => Sonda - En linea(1 sola vez)

	6 => Riesgo - En linea
	7 => Riesgo - Manual
	9 => Riesgo - En linea(1 sola vez)
*/

if ($_SESSION['USER-AD']["user_rol"] == 4 || $_SESSION['USER-AD']["user_rol"] == 5 || $_SESSION['USER-AD']["user_rol"] == 8) {
	$sonda = new Sonda();
	$sonda->setId_empresa($_SESSION['Empresa']['id']);
	$sonda->select__();	
	
	if($sonda){
		$test = new SondaController('Sonda','sonda','test_temp',0,true,true); 
		$test->test_temp($sonda->id_empresa,$sonda->id); 
		$test->ar_destruct();
		unset($test);
	}else{
		echo "<h1>Error</h1>";
	}
}elseif ($_SESSION['USER-AD']["user_rol"] == 6 || $_SESSION['USER-AD']["user_rol"] == 7 || $_SESSION['USER-AD']["user_rol"] == 9) {
	$riesgo = new Riesgo_psicosocial();
	$riesgo->setId_empresa($_SESSION['Empresa']['id']);
	$riesgo->select_last();	
	
	if($riesgo){
		$test = new Riesgo_psicosocialController('Riesgo_psicosocial','riesgo_psicosocial','test',0,true,true); 
		$test->test($riesgo->id_empresa,$riesgo->id);
		$test->ar_destruct();
		unset($test);
	}else{
		echo "<h1>Error</h1>";
	}
}

?>