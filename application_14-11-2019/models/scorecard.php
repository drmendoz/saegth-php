<?php

// **********************
// CLASS DECLARATION
// **********************

class scorecard extends Model{ 

// **********************
// ATTRIBUTE DECLARATION
// **********************


	public $id;   
	public $id_empresa;   
	public $detalle;   
	public $estado=1;   
	public $periodo;   
// **********************
// CONSTRUCTOR METHOD
// **********************


	public function __construct($parameters = array()) {
		parent::__construct();
		foreach($parameters as $key => $value) {
			$this->$key = $value;
		}
	}
// **********************
// GETTER METHODS
// **********************

	function getId(){
		return $this->id;
	}

	function getId_empresa(){
		return $this->id_empresa;
	}

	function getDetalle(){
		return $this->detalle;
	}

	function getDetalle_(){
		return unserialize($this->detalle);
	}

	function getEstado(){
		return $this->estado;
	}

	function getPeriodo(){
		return $this->periodo;
	}

// **********************
// SETTER METHODS
// **********************


	function setId($val){
		$this->id =  $val;
	}

	function setId_empresa($val){
		$this->id_empresa =  $val;
	}

	function setDetalle($val){
		$this->detalle =  $val;
	}

	function setEstado($val){
		$this->estado =  $val;
	}

	function setPeriodo($val){
		$this->periodo =  $val;
	}

// **********************
// SELECT METHOD / LOAD
// **********************

	function select($id){

		$sql =  "SELECT * FROM scorer_detalle WHERE id_empresa = $id  ORDER BY id DESC;";
		$row =  $this->query_($sql,1);

		if($row){
			$this->id = $row['id'];
			$this->id_empresa = $row['id_empresa'];
			$this->detalle = $row['detalle'];
			$this->estado = $row['estado'];
			$this->periodo = $row['periodo'];
			return true;
		}else{
			return false;
		}


	}

// **********************
// DELETE
// **********************

	function delete(){
		$sql = "DELETE FROM scorer_detalle WHERE id = $id;";
		$result = $this->query_($sql);

	}

// **********************
// INSERT
// **********************

	function insert(){

		$sql = "INSERT INTO scorer_detalle ( id_empresa,detalle,estado,periodo ) VALUES ( '$this->id_empresa','$this->detalle','$this->estado','$this->periodo' )";
		$result = $this->query_($sql);
		$this->id = mysqli_insert_id($this->link);

	}

// **********************
// UPDATE
// **********************

	function update(){
		$sql = " UPDATE scorer_detalle SET  id_empresa = '$this->id_empresa',detalle = '$this->detalle',estado = '$this->estado',periodo = '$this->periodo' WHERE id = $this->id ";
		$result = $this->query_($sql);
	}

	function header_set($id,$periodo){
		$lpo = new listado_personal_op();
		$lpo->select($id);
		
		$nombre=$lpo->getNombre();
		$cargo=$lpo->getCargo();
		$area=$lpo->getArea();
		$supervisor=$lpo->getPid_nombre();
		echo	'<div class="form-group">
		<img src="'.BASEURL.'img/scorecard.png" style="width: 200px;">
		<h3 class="text-center form-group">TABLERO DE CONTROL DE CUMPLIMIENTO DE OBJETIVOS DE DESEMPE&Ntilde;O</h3>

		<table class="table-bordered"  style="width: 100%;">
			<tr>
				<td class="col-md-4"><b>USUARIO: </b>'.$nombre.' </td>
				<td class="col-md-4"><b>CARGO: </b>'.$cargo.' </td>
				<td class="col-md-4"><b>&Aacute;REA: </b>'.$area.' </td>
			</tr>
			<tr>
				<td class="col-md-4"><b>EMPRESA: </b>'.$this->htmlprnt($_SESSION['Empresa']['nombre']) .' </td>
				<td class="col-md-4"><b>SUPERIOR: </b>'.$supervisor.' </td>
				<td class="col-md-4"><b>PERIODO DE MEDICIÓN: </b>'.$periodo.'</td>
			</tr>
		</table>
	</div>';
}

public function get_scorer($id,$periodo=null){
	if(!$periodo){
		$scorer = $this->query_("SELECT * FROM scorer_detalle WHERE id_empresa=".$id." ORDER BY id DESC;",1);
	}else{
		$scorer = $this->query_("SELECT * FROM scorer_detalle WHERE id_empresa=".$id." and periodo=".$periodo." ORDER BY id DESC;",1);
	}
	$res = array('detalle' => unserialize($scorer['detalle']), 'periodo' => $scorer['periodo']);
	return $res;
}



public function scorer_rango($scorer,$puntaje){

	if ($puntaje <= intval($scorer->res1_min))
		return 0;
	if ($puntaje > intval($scorer->res1_min) && $puntaje <= intval($scorer->res1_max))
		return 1;
	if ($puntaje > intval($scorer->res1_max) && $puntaje <= intval($scorer->res2_max))
		return 2;
	if ($puntaje > intval($scorer->res2_min) && $puntaje <= intval($scorer->res3_max))
		return 3;
	if ($puntaje > intval($scorer->res3_min) && $puntaje <= intval($scorer->res4_max))
		return 4;
	if (($puntaje > intval($scorer->res4_min) && $puntaje <= intval($scorer->res5_max)) || $puntaje > intval($scorer->res5_max))
		return 5;
}

public function getPeriodos(){
	$arr = $this->query_("SELECT periodo FROM scorer_detalle WHERE id_empresa=$this->id_empresa ORDER BY periodo DESC");
	$arr2 = array();
	foreach ($arr as $key => $value) {
		array_push($arr2, $value['periodo']);
	}
	return $arr2;
}

}
?>