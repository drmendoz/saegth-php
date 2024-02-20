<?php 
$meth=new Ajax();
if($_REQUEST){
	$tekken = array();
	$emp = $eval = 0;
	foreach ($_POST['comentario'] as $key => $value) {
		if($value!=""){
			$atts = array(
				'id_personal' => $_POST['id'],
				'comentario' => $value,
				'autor' => 0,
				'tipo' => $_POST['tipo'],
				'periodo' => $_POST['periodo'],
				'fecha' => $_POST['cmn_fecha'][$key],
				);
			$emp=1;
			$test = new Scorer_reval($atts);
			array_push($tekken, $test);
		}
	}
	foreach ($_POST['com_e'] as $key => $value) {
		if($value!=""){
			$atts = array(
				'id_personal' => $_POST['id'],
				'comentario' => $value,
				'autor' => 1,
				'tipo' => $_POST['tipo'],
				'periodo' => $_POST['periodo'],
				'fecha' => $_POST['cmn_evaluador_fecha'][$key],
				);
			$eval=1;
			$test = new Scorer_reval($atts);
			array_push($tekken, $test);
		}
	}
	$estado = Scorer_estado::withID($_POST['id']);
	if($_POST['tipo'] && $eval){
		$estado->evaluacion_jefe=1;
	}elseif (!$_POST['tipo'] && $eval) {
		$estado->revision_jefe=1;
	}

	if ($_POST['tipo'] && $emp) {
		$estado->evaluacion=1;
	}elseif (!$_POST['tipo'] && $emp) {
		$estado->revision=1;
	}
	$estado->update();
	foreach ($tekken as $key => $value) {
		if(!$key)
			$value->clear_db();
		$value->insert();
		echo $value->comentario." -> ".$value->autor." -> ".$tipo."<br>";
	}
}
// echo mysqli_error($test->link);
?>