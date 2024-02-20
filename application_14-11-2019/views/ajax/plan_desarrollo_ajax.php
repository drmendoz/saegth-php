<?php
if($_REQUEST){
	$id_p = $_SESSION['Personal']['id'];
	$ret = array();
	// var_dump($_REQUEST);
	foreach ($_REQUEST['action'] as $key => $value) {
		$desarrollo = new Plan_desarrollo();
		$desarrollo->setId_personal($id_p);
		$desarrollo->setId_area($_REQUEST['area'][$key]);
		$desarrollo->setId_cargo($_REQUEST['cargo'][$key]);
		$desarrollo->setOpc_plazo($_REQUEST['plazo'][$key]);
		$desarrollo->setAccion($_REQUEST['accion'][$key]);
		$desarrollo->setTipo($_REQUEST['tipo'][$key]);
		$desarrollo->setFecha($_REQUEST['fecha'][$key]);
		
		if($value=='update')
			$desarrollo->setId($_REQUEST['id'][$key]);
		$desarrollo->{$value}();
		$ret[$key]['id']= $desarrollo->getId();
	}
		
		echo json_encode($ret);
}
?>