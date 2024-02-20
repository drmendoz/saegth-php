<?php 
$sonda = new Sonda();
$sonda->setId_empresa($_SESSION['Empresa']['id']);
$sonda->select__();	
// var_dump($sonda);
if($sonda){
	$test = new SondaController('Sonda','sonda','test_temp',0,true,true); 
	$test->test_temp($sonda->id_empresa,$sonda->id); 
	$test->ar_destruct();
	unset($test);
}else{
	echo "<h1>Error</h1>";
}
?>