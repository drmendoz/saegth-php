<?php

// **********************
// CLASS DECLARATION
// **********************

class matriz_filtros extends Model{ 

// **********************
// ATTRIBUTE DECLARATION
// **********************


	public $id_empresa;   
	public $nombre;   
	public $sql;   
	public $verbal;   
// **********************
// CONSTRUCTOR METHOD
// **********************


	public function __construct($parameters = array()) {
		parent::__construct();
		foreach($parameters as $key => $value) {
			$this->$key = $value;
		}
	}	

	public function cast($parameters = array()) {
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

	function getNombre(){
		return $this->htmlprnt($this->nombre);
	}

	function getSql(){
		return $this->sql;
	}

	function getVerbal(){
		return html_entity_decode($this->htmlprnt($this->verbal));
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

	function setNombre($val){
		$this->nombre =  $val;
	}

	function setSql($val){
		$this->sql =  $val;
	}

	function setVerbal($val){
		$this->verbal =  $val;
	}

// **********************
// SELECT METHOD / LOAD
// **********************

	function select($id){
		$sql =  "SELECT * FROM matriz_filtros WHERE id = $id;";
		$row =  $this->query_($sql,1);
		$this->id = $row['id'];
		$this->id_empresa = $row['id_empresa'];
		$this->nombre = $row['nombre'];
		$this->sql = $row['sql'];
		$this->verbal = $row['verbal'];
	}

	function select_all($id){
		$sql =  "SELECT * FROM matriz_filtros WHERE id_empresa = $id;";
		return $this->query_($sql);
	}

	function get_select_options($id,$_id=null){
		$ctrl = new self();
		$ptr = $ctrl->select_all($id);
		foreach ($ptr as $key => $value) {
			$ctrl->cast($value);
			if($_id == $ctrl->getId())
				$t = "selected";
			else
				$t = "";
			echo "<option value='".$ctrl->getId()."'  ".$t." >".$ctrl->getNombre()."</option>";
		}

	}

// **********************
// DELETE
// **********************

	function delete(){
		$sql = "DELETE FROM matriz_filtros WHERE id = $id;";
		$result = $this->query_($sql);

	}

// **********************
// INSERT
// **********************

	function insert(){

		$sql = "INSERT INTO matriz_filtros ( id_empresa,nombre,sql,verbal ) VALUES ( '$this->id_empresa','$this->nombre','$this->sql','$this->verbal' )";
		$result = $this->query_($sql);
		$this->id = mysqli_insert_id($this->link);

	}

// **********************
// UPDATE
// **********************

	function update(){
		$sql = " UPDATE matriz_filtros SET  id_empresa = '$this->id_empresa',nombre = '$this->nombre',sql = '$this->sql' WHERE id = $id ";
		$result = $this->query_($sql);
	}

}
?>