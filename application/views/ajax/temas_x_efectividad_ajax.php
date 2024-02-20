<?php

if($_REQUEST){
	$sonda = new Efectividad_departamental();
	$x = new Sonda_tema();
	$sonda->select_($_SESSION['Empresa']['id'], $_REQUEST['id_s']);
	$temas = $sonda->getTemas();
	$result = array();

	if (is_array($temas)) {
		foreach ($temas as $key => $value) {
			$x->select($key);
			$tema_nombre = ucfirst($x->getTema_());
			$tema_id = $x->getId();

			$result[$key]['value'] = $tema_id;
			$result[$key]['text'] = $tema_nombre;
		}
	}
	echo json_encode($result);
}

?>