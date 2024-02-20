<?php 
/* 
	user_rol
	
	4 => Sonda - En linea
	5 => Sonda - Manual
	8 => Sonda - En linea(1 sola vez)

	6 => Riesgo - En linea
	7 => Riesgo - Manual
	9 => Riesgo - En linea(1 sola vez)


	10 => Efectividad - En linea
	11 => Efectividad - Manual
	12 => Efectividad - En linea(1 sola vez)
	
	13 => Evaluación Desempeño - En linea
	14 => Evaluación Desempeño - Manual
	15 => Evaluación Desempeño - En linea(1 sola vez)
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
}elseif ($_SESSION['USER-AD']["user_rol"] == 10 || $_SESSION['USER-AD']["user_rol"] == 11 || $_SESSION['USER-AD']["user_rol"] == 12) {
	$sonda = new Efectividad_departamental();
	$sonda->setId_empresa($_SESSION['Empresa']['id']);
	$sonda->select__();	
	
	if($sonda){
		$test = new Efectividad_departamentalController('Efectividad_departamental','efectividad_departamental','test_temp',0,true,true); 
		$test->test_temp($sonda->id_empresa,$sonda->id); 
		$test->ar_destruct();
		unset($test);
	}else{
		echo "<h1>Error</h1>";
	}
}elseif ($_SESSION['USER-AD']["user_rol"] == 13 || $_SESSION['USER-AD']["user_rol"] == 14 || $_SESSION['USER-AD']["user_rol"] == 15) {
	$sonda = new Evaluacion_desempenio();
	$sonda->setId_empresa($_SESSION['Empresa']['id']);
	$sonda->select__();	
	
	if($sonda){
		$test = new Evaluacion_desempenioController('Evaluacion_desempenio','evaluacion_desempenio','test_temp',0,true,true); 
		$test->test_temp($sonda->id_empresa,$sonda->id); 
		$test->ar_destruct();
		unset($test);
	}else{
		echo "<h1>Error</h1>";
	}
}

?>