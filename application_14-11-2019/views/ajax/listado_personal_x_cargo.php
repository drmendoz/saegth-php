<?php

if($_REQUEST){
	$p_emp = new Personal_empresa();
	$method = "select_from_".$_REQUEST["tname"];
	$listado = $p_emp->{$method}($_REQUEST["id_s"]);
	if($listado){
		$result = "<ul class='response'>";
		foreach ($listado as $key => $value) {
			$p = Personal::withID($value['id_personal']);
			$result.="<li>".$p->getNombre_p()."</li>";
		}
		$result .= "</ul>";
		echo $result;
	}else{
		echo 0;
	}
}

?>