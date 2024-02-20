<?php

// **********************
// CLASS DECLARATION
// **********************

class Evaluacion_Desempenio_Competencia extends Model{
	// class : begin


	// **********************
	// ATTRIBUTE DECLARATION
	// **********************


	public $id;
	public $competencias;
	public $activo;
	public $id_empresa;


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

	
	function getCompetencias(){
		return $this->htmlprnt_win($this->competencias);
	}


	function getActivo(){
		return $this->activo;
	}

	function getIdEmpresa(){
		return $this->id_empresa;
	}

	// **********************
	// SETTER METHODS
	// **********************


	function setId($val){
		$this->id =  $val;
	}

	
	function setCompetencias($val){
		$this->competencias =  $val;
	}

	function setActivo($val){
		$this->activo =  $val;
	}

	function SetIdEmpresa($val){
		$this->id_empresa =  $val;
	}

	// **********************
	// SELECT METHOD / LOAD
	// **********************

	function select($id=false){
		if(!$id)
			$id = $this->id;
		$sql =  "SELECT * FROM $this->_table WHERE  id= $id;";
		$row =  $this->query_($sql,1);


		$this->id = $row['id'];
		$this->tema = $row['competencias'];
		$this->activo = $row['activo'];
		$this->id_empresa = $row['id_empresa'];

	}

	function select_all(){

		$sql =  "SELECT id FROM $this->_table WHERE activo = 1 and id_empresa = ".$_SESSION['USER-AD']['id_empresa'];
		$row = $this->query_($sql);
		$result = array();
		foreach ($row as $key => $value) {
			$tmp = new self();
			$tmp->select($value['id']);
			array_push($result, $tmp);
		}
		return $result;
	}

	function select_all_competencias(){

		$sql =  "SELECT id,competencias FROM $this->_table WHERE activo = 1 and id_empresa = ".$_SESSION['USER-AD']['id_empresa'];
		return $this->query_($sql);
	}

	// **********************
	// DELETE
	// **********************

	function delete(){
		$sql = "DELETE FROM $this->_table WHERE  id= $id;";
		$result = $this->query_($sql);

	}

	// **********************
	// INSERT
	// **********************

	function insert(){

		$sql = "INSERT INTO $this->_table (competencias, id_empresa ) VALUES ('$this->competencias', '".$_SESSION["USER-AD"]["id_empresa"]."' )";
		$result = $this->query_($sql);
		$this->id = mysqli_insert_id($this->link);

	}

	// **********************
	// UPDATE
	// **********************

	function update(){

		$sql = " UPDATE $this->_table SET competencias = '$this->competencias' WHERE id = $this->id ";

		$result = $this->query_($sql);

	}

	function activa_inactiva(){
		$sql = "UPDATE $this->_table SET activo = '$this->activo' WHERE id = $this->id ";

		$result = $this->query_($sql);
	}

	//
	function get_competencias_combo($id_s, $arrTemas = ''){
		
		$x = new Evaluacion_Desempenio_Competencia();
		$competencias = $x->select_all_competencias();

		if (is_array($competencias)) {
			foreach ($competencias as $key => $value) {
				$competencias_nombre = ucfirst($value['competencias']);
				$competencias_id = $value['id'];
				echo "<option value='".$competencias_id."'>".$competencias_nombre."</option>";
			}
		}
	}
} // class : end

?>