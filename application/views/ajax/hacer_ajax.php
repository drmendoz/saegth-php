<?php
if($_REQUEST){
	// var_dump($_REQUEST);
	$id_p = $_REQUEST['id_p'];
	$ret = array();
	foreach ($_REQUEST['comentario'] as $key => $value) {
		if($_REQUEST['comentario'][$key]!=""){
			$desarrollo = new Que_hacer();
			$desarrollo->setId_personal($id_p);
			$desarrollo->setTipo($_REQUEST['tipo']);
			$desarrollo->setComentario($_REQUEST['comentario'][$key]);
			$desarrollo->setPeriodo($_REQUEST['periodo']);
			
			if($_REQUEST['id'][$key] == "")
				$action = "insert";
			else
				$action = "update";

			$desarrollo->setId($_REQUEST['id'][$key]);
			
			$desarrollo->{$action}();
			$ret[$key]['id']= $desarrollo->getId();
			
		}
	}
	
	echo json_encode($ret);
}
?>