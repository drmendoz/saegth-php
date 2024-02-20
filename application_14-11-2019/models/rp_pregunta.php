<?php

class Rp_pregunta extends Model{ 

public $id;   // (normal Attribute)
public $id_tema;   // (normal Attribute)
public $pregunta;   // (normal Attribute)
public $inverso;   // (normal Attribute)
public $op_respuesta;   // (normal Attribute)


public function __construct($parameters = array()) {
	parent::__construct();
	foreach($parameters as $key => $value) {
		$this->$key = $value;
	}
}



function getId(){
	return $this->id;
}

function getId_tema(){
	return $this->id_tema;
}

function getPregunta(){
	return $this->htmlprnt($this->pregunta);
}

function getPregunta_(){
	return $this->htmlprnt_win($this->pregunta);
}

function getInverso(){
	return $this->inverso;
}

function getOp_respuesta(){
	return $this->op_respuesta;
}



function setId($val){
	$this->id =  $val;
}

function setId_tema($val){
	$this->id_tema =  $val;
}

function setPregunta($val){
	$this->pregunta =  $val;
}

function setInverso($val){
	$this->inverso =  $val;
}

function setOp_respuesta($val){
	$this->op_respuesta =  $val;
}

function select($id){

	$sql =  "SELECT * FROM $this->_table WHERE id = $id;";
	$row = $this->query_($sql,1);

	$this->id = $row['id'];

	$this->id_tema = $row['id_tema'];

	$this->pregunta = $row['pregunta'];

	$this->inverso = $row['inverso'];

	$this->op_respuesta = $row['op_respuesta'];

}

function select_x_tema($id_tema){

	$sql =  "SELECT * FROM $this->_table WHERE id_tema=$id_tema";
	$row = $this->query_($sql);
	$result = array();
	foreach ($row as $key => $value) {
		$tmp = new self($value);
		// $tmp->select($value['id']);
		array_push($result, $tmp);
	}
	return $result;
}

function select_x_tema_($id_tema, $ids=''){

	$sql =  "SELECT * FROM $this->_table WHERE id_tema=$id_tema";
	$row = $this->query_($sql);
	$result = array();
	$w=new rp_respuesta();
	foreach ($row as $key => $value) {
		$tmp = new self($value);
		$row[$key]['pregunta']=$tmp->getPregunta();
		$row[$key]['porcentaje']=$w->get_percent_x_pregunta($ids,$tmp);
		$row[$key]['style']=$w->get_color($row[$key]['porcentaje']);
	}
	return $row;
}

function select_x_tema__($id_tema){

	$sql =  "SELECT * FROM $this->_table WHERE id_tema=$id_tema";
	$row = $this->query_($sql);
	$result = array();
	$w=new rp_respuesta();
	foreach ($row as $key => $value) {
		$tmp = new self($value);
		$row[$key]['id']=$tmp->getId();
		$row[$key]['pregunta']=$tmp->getPregunta_();
		$row[$key]['porcentaje']=$w->get_percent_x_pregunta($_SESSION['rp_ids'],$tmp);
		$row[$key]['style']=$w->get_color($row[$key]['porcentaje']);
	}
	return $row;
}

function select_ids_x_tema($id_tema){

	$sql =  "SELECT id FROM $this->_table WHERE id_tema=$id_tema";
	$row = $this->query_($sql);
	$result = array();
	foreach ($row as $key => $value) {
		array_push($result, $value['id']);
	}
	return implode(",", $result);
}

function delete(){
	$sql = "DELETE FROM $this->_table WHERE  = $this->id;";
	$this->query_($sql);
}

// **********************
// INSERT
// **********************

function insert(){

	$sql = "INSERT INTO $this->_table ( id,id_tema,pregunta,inverso,op_respuesta ) VALUES ( '$this->id','$this->id_tema','$this->pregunta','$this->inverso','$this->op_respuesta' )";
	$this->query_($sql);
	$this->id = mysql_insert_id($this->link);

}

// **********************
// UPDATE
// **********************

function update(){
	$sql = " UPDATE $this->_table SET  id_tema = '$this->id_tema',pregunta = '$this->pregunta',inverso = '$this->inverso',op_respuesta = '$this->op_respuesta' WHERE  = $this->id ";
	$this->query_($sql);
}

// **********************
// EXTRA METHOD
// **********************

function getOptions($tabindex){
	switch ($this->op_respuesta) {
		case 1:
		$opciones = array("muy alta","alta","media","baja","muy baja");
		$respuestas = array("5","4","3","2","1");
		$nr= false;
		break;
		case 2:
		$opciones = array("excesiva","elevada","adecuada","escasa","muy escasa");
		$respuestas = array("5","4","3","2","1");
		$nr= false;
		break;
		case 3:
		$opciones = array("Siempre o casi siempre","a menudo","a veces","nunca o casi nunca","no tengo, no trato");
		$respuestas = array("4","3","2","1");
		$nr= true;
		break;
		case 4:
		$opciones = array("Siempre o casi siempre","a menudo","a veces","nunca o casi nunca");
		$respuestas = array("4","3","2","1");
		$nr= false;
		break;
		case 5:
		$opciones = array("muy clara","clara","poco clara","nada clara");
		$respuestas = array("4","3","2","1");
		$nr= false;
		break;
		case 6:
		$opciones = array("no hay información","insuficiente","es adecuada");
		$respuestas = array("3","2","1");
		$nr= false;
		break;
		case 7:
		$opciones = array("adecuadamente","regular","insuficientemente","no existe la posibilidad de desarrollo personal");
		$respuestas = array("4","3","2","1");
		$nr= false;
		break;
		case 8:
		$opciones = array("muy adecuada","suficiente","insuficiente en algunos casos","totalmente insuficiente");
		$respuestas = array( "4","3","2","1");
		$nr= false;
		break;
		case 9:
		$opciones = array("muy satisfecho","satisfecho","insatisfecho","muy insatisfecho");
		$respuestas = array("4","3","2","1");
		$nr= false;
		break;
		case 10:
		$opciones = array("puedo decidir","se me consulta","sólo recibo información","ninguna participación");
		$respuestas = array("4","3","2","1");
		$nr= false;
		break;
		case 11:
		$opciones = array("insuficiente","adecuada","excesiva","no interviene");
		$respuestas = array("1","2","3","4");
		$nr= false;
		break;
		case 12:
		$opciones = array("Siempre o casi siempre","a menudo","a veces","nunca o casi nunca","no tengo, no hay otras personas");
		$respuestas = array("4","3","2","1");
		$nr= true;
		break;
		case 13:
		$opciones = array("buenas","regulares","malas","no tengo compañeros");
		$respuestas = array("3","2","1");
		$nr= true;
		break;
		case 14:
		$opciones = array("no existen","raras veces","con frecuencia","constantemente");
		$respuestas = array("4","3","2","1");
		$nr= false;
		break;
		case 15:
		$opciones = array("deja que sean los implicados quienes solucionen el tema","pide a los mandos de los afectados que traten de buscar una solución al problema","tiene establecido un procedimiento formal de actuación","no lo sé");
		$respuestas = array("3","2","1");
		$nr= true;
		break;
		case 16:
		$opciones = array("no","a veces","bastante","mucho");
		$respuestas = array("4","3","2","1");
		$nr= false;
		break;
		case 17:
		$opciones = array("mucho", "bastante", "poco", "nada");
		$respuestas = array("4","3","2","1");
		$nr= false;
		break;
		case 18:
		$opciones = array("no es muy importante", "es importante", "es muy importante", "no lo sé");
		$respuestas = array("3","2","1");
		$nr= true;
		break;
	}

	$result = "<table class='table' style='margin-bottom:0;'>";
	$result .= "<tr>";
	if($_SESSION['USER-AD']['user_rol'] == 6 || $_SESSION['USER-AD']['user_rol'] == 9){
		$y = sizeof($opciones);
		$z = 12/$y;
		foreach ($opciones as $key => $value) {
			$result .= "<th col-md-$z>";
			$result .= $value;
			$result .= "</th>";
		}
		$result .= "</tr>";

		$result .= "<tr>";
		$x = sizeof($respuestas);
		foreach ($respuestas as $key => $value) {
			$result .= "<td class='text-center'>";
			$result .= "<input type='radio' name='".$this->id."' value='";
			/*if ($this->inverso) {
				$value = $value-(--$x);
				$x--;
			}*/
			$result .= $key+1;
			$result .= "'></td>";
		}
		if($nr){
			$result .= "<td class='text-center'>";
			$result .= "<input type='radio' name='".$this->id."' value='0'></td>";
		}
	}else{
		$min = 1;
		$max = sizeof($respuestas);

		if($nr)
			$min = 0;

		$result .= "<td class='text-center'>";
		$result .= "<input type='text' name='".$this->id."' maxlength='1' tabindex='".$tabindex."' onkeyup='validaCaja(\"$min\",\"$max\",\"$tabindex\", this)' style='width: 40px; text-align:center;' />";
		$result .= "</td>";
	}
	
	$result .= "</tr>";
	$result .= "</table>";
	echo $result;
}

function getMaxval(){
	switch ($this->op_respuesta) {
		case 1:
		$respuestas = array("1","5");
		break;
		case 2:
		$respuestas = array("1","5");
		break;
		case 3:
		$respuestas = array("1","4");
		break;
		case 4:
		$respuestas = array("1","4");
		break;
		case 5:
		$respuestas = array("1","4");
		break;
		case 6:
		$respuestas = array("1","3");
		break;
		case 7:
		$respuestas = array("1","4");
		break;
		case 8:
		$respuestas = array("1","4");
		break;
		case 9:
		$respuestas = array("1","4");
		break;
		case 10:
		$respuestas = array("1","4");
		break;
		case 11:
		$respuestas = array("1","4");
		break;
		case 12:
		$respuestas = array("1","4");
		break;
		case 13:
		$respuestas = array("1","3");
		break;
		case 14:
		$respuestas = array("1","4");
		break;
		case 15:
		$respuestas = array("1","3");
		break;
		case 16:
		$respuestas = array("1","4");
		break;
		case 17:
		$respuestas = array("1","4");
		break;
		case 18:
		$respuestas = array("1","3");
		break;
	}

	return $respuestas;
}

function getResults($ids){
	switch ($this->op_respuesta) {
		case 1:
		$opciones = array("muy alta","alta","media","baja","muy baja");
		$respuestas = array("5","4","3","2","1");
		$nr= false;
		break;
		case 2:
		$opciones = array("excesiva","elevada","adecuada","escasa","muy escasa");
		$respuestas = array("5","4","3","2","1");
		$nr= false;
		break;
		case 3:
		$opciones = array("Siempre o casi siempre","a menudo","a veces","nunca o casi nunca","no tengo, no trato");
		$respuestas = array("4","3","2","1");
		$nr= true;
		break;
		case 4:
		$opciones = array("Siempre o casi siempre","a menudo","a veces","nunca o casi nunca");
		$respuestas = array("1","2","3","4");
		$nr= false;
		break;
		case 5:
		$opciones = array("muy clara","clara","poco clara","nada clara");
		$respuestas = array("4","3","2","1");
		$nr= false;
		break;
		case 6:
		$opciones = array("no hay información","insuficiente","es adecuada");
		$respuestas = array("3","2","1");
		$nr= false;
		break;
		case 7:
		$opciones = array("adecuadamente","regular","insuficientemente","no existe la posibilidad de desarrollo personal");
		$respuestas = array("4","3","2","1");
		$nr= false;
		break;
		case 8:
		$opciones = array("muy adecuada","suficiente","insuficiente en algunos casos","totalmente insuficiente");
		$respuestas = array( "4","3","2","1");
		$nr= false;
		break;
		case 9:
		$opciones = array("muy satisfecho","satisfecho","insatisfecho","muy insatisfecho");
		$respuestas = array("4","3","2","1");
		$nr= false;
		break;
		case 10:
		$opciones = array("puedo decidir","se me consulta","sólo recibo información","ninguna participación");
		$respuestas = array("4","3","2","1");
		$nr= false;
		break;
		case 11:
		$opciones = array("insuficiente","adecuada","excesiva","no interviene");
		$respuestas = array("4","3","2","1");
		$nr= false;
		break;
		case 12:
		$opciones = array("Siempre o casi siempre","a menudo","a veces","nunca o casi nunca","no tengo, no hay otras personas");
		$respuestas = array("4","3","2","1");
		$nr= true;
		break;
		case 13:
		$opciones = array("buenas","regulares","malas","no tengo compañeros");
		$respuestas = array("3","2","1");
		$nr= true;
		break;
		case 14:
		$opciones = array("no existen","raras veces","con frecuencia","constantemente");
		$respuestas = array("4","3","2","1");
		$nr= false;
		break;
		case 15:
		$opciones = array("deja que sean los implicados quienes solucionen el tema","pide a los mandos de los afectados que traten de buscar una solución al problema","tiene establecido un procedimiento formal de actuación","no lo sé");
		$respuestas = array("3","2","1");
		$nr= true;
		break;
		case 16:
		$opciones = array("no","a veces","bastante","mucho");
		$respuestas = array("4","3","2","1");
		$nr= false;
		break;
		case 17:
		$opciones = array("mucho", "bastante", "poco", "nada");
		$respuestas = array("4","3","2","1");
		$nr= false;
		break;
		case 18:
		$opciones = array("no es muy importante", "es importante", "es muy importante", "no lo sé");
		$respuestas = array("3","2","1");
		$nr= true;
		break;
	}

	$result = "<table class='table' style='margin-bottom:0;'>";
	$result .= "<tr>";
	$y = sizeof($opciones);
	$z = 12/$y;
	foreach ($opciones as $key => $value) {
		$result .= "<th class='text-center col-md-$z'>";
		$result .= $value;
		$result .= "</th>";
	}
	$result .= "</tr>";
	$result .= "<tr>";
	$x = sizeof($respuestas);
	$rp_res = new Rp_respuesta();
	$count_total = $rp_res->count($ids,$this->id);
	foreach ($respuestas as $key => $value) {
		$result .= "<td class='text-center'>";
		// if ($this->inverso) {
		// 	$value = $value-(--$x);
		// 	$x--;
		// }
		// var_dump($key+1);echo "<br>";
		$count = $rp_res->count_respuesta($ids,$this->id,$key+1);
		$result .= @(round($count*100/$count_total,2));
		$result .= "</td>";
	}

	if($nr){
		$count = $rp_res->count_respuesta($ids,$this->id,0);
		$result .= "<td class='text-center'>";
		$result .= @(round($count*100/$count_total,2));
		$result .= "</td>";
	}
	
	$result .= "</tr>";
	$result .= "</table>";
	return $result;
}

function getOptions_(){ 	
	$result = "<input type='text' pattern='\d*' required='required' class='speed form-control' maxlength='1' name='".$this->id."'>";
	echo $result;
}

}

?>