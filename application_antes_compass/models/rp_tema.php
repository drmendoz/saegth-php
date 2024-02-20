<?php

// **********************
// CLASS DECLARATION
// **********************

class Rp_tema extends Model{ 
// class : begin


// **********************
// ATTRIBUTE DECLARATION
// **********************


	public $id;   
	public $tema;   
	public $descripcion;   
	public $preguntas;   



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

	function getTema(){
		return $this->htmlprnt($this->tema);
	}

	function getDescripcion(){
		return $this->htmlprnt($this->descripcion);
	}

	function getTema_(){
		return $this->htmlprnt_win($this->tema);
	}

	function getDescripcion_(){
		return $this->htmlprnt_win($this->descripcion);
	}

	function getPreguntas(){
		return $this->preguntas;
	}

// **********************
// SETTER METHODS
// **********************


	function setId($val){
		$this->id =  $val;
	}

	function setTema($val){
		$this->tema =  $val;
	}

	function setDescripcion($val){
		$this->descripcion =  $val;
	}

	function setPreguntas($val){
		$this->preguntas =  $val;
	}

// **********************
// SELECT METHOD / LOAD
// **********************

	function select($id){

		$sql =  "SELECT * FROM $this->_table WHERE id  = $id;";
		$row = $this->query_($sql,1);

		$this->id = $row['id'];

		$this->tema = $row['tema'];

		$this->descripcion = $row['descripcion'];

		$this->preguntas = $row['preguntas'];

	}

	function select_all(){
		$sql =  "SELECT id FROM $this->_table";
		$row = $this->query_($sql);
		$result = array();
		foreach ($row as $key => $value) {
			$tmp = new self();
			$tmp->select($value['id']);
			array_push($result, $tmp);
		}
		return $result;
	}

	function select_all_(){
		$sql =  "SELECT id,tema,descripcion FROM $this->_table";
		$row = $this->query_($sql);
		$result = array();
		foreach ($row as $key => $value) {
			$tmp = new self($value);
			$row[$key]['tema'] = $tmp->getTema();
			$row[$key]['descripcion'] = $tmp->getDescripcion();
		}
		return $row;
	}

	function select_all__(){
		$sql =  "SELECT id,tema,descripcion FROM $this->_table";
		$row = $this->query_($sql);
		$result = array();
		foreach ($row as $key => $value) {
			$tmp = new self($value);
			$row[$key]['tema'] = $tmp->getTema_();
			$row[$key]['descripcion'] = $tmp->getDescripcion_();
		}
		return $row;
	}

// **********************
// DELETE
// **********************

	function delete(){
		$sql = "DELETE FROM $this->_table WHERE  = $id;";
		$result = $this->query_($sql);

	}

// **********************
// INSERT
// **********************

	function insert(){

		$sql = "INSERT INTO $this->_table (tema,descripcion,preguntas ) VALUES ('$this->tema','$this->descripcion','$this->preguntas' )";
		$result = $this->query_($sql);
		$this->id = mysql_insert_id($this->link);

	}

// **********************
// UPDATE
// **********************

	function update(){



		$sql = " UPDATE $this->_table SET  id = '$this->id',tema = '$this->tema',descripcion = '$this->descripcion',preguntas = '$this->preguntas' WHERE  = $id ";

		$result = $this->query_($sql);



	}


} // class : end

?>