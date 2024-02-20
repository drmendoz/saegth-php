<?php

// **********************
// CLASS DECLARATION
// **********************

class multifuente_test extends Model{ 

// **********************
// ATTRIBUTE DECLARATION
// **********************


	public $id_empresa;   
	public $cod_tema;   
	public $cod_pregunta;   
	public $pregunta;   
	public $cod_test;   
	public $nombre_test;   
	public $descripcion;   
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

	function getCod_tema(){
		return $this->cod_tema;
	}

	function getCod_pregunta(){
		return $this->cod_pregunta;
	}

	function getPregunta(){
		return $this->pregunta;
	}

	function getCod_test(){
		return $this->cod_test;
	}

	function getNombre_test(){
		return $this->nombre_test;
	}

	function getDescripcion(){
		return $this->descripcion;
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

	function setCod_tema($val){
		$this->cod_tema =  $val;
	}

	function setCod_pregunta($val){
		$this->cod_pregunta =  $val;
	}

	function setPregunta($val){
		$this->pregunta =  $val;
	}

	function setCod_test($val){
		$this->cod_test =  $val;
	}

	function setNombre_test($val){
		$this->nombre_test =  $val;
	}

	function setDescripcion($val){
		$this->descripcion =  $val;
	}

// **********************
// SELECT METHOD / LOAD
// **********************

	function select($id){

		$sql =  "SELECT * FROM multifuente_test WHERE cod_test = $id;";
		$row =  $this->query_($sql,1);

		$this->id = $row['id'];
		$this->id_empresa = $row['id_empresa'];
		$this->cod_tema = $row['cod_tema'];
		$this->cod_pregunta = $row['cod_pregunta'];
		$this->pregunta = $row['pregunta'];
		$this->cod_test = $row['cod_test'];
		$this->nombre_test = $row['nombre_test'];
		$this->descripcion = $row['descripcion'];

	}

	function getTest($id){
		$sql = "SELECT DISTINCT(cod_test) as cod_test,nombre_test from multifuente_test where id_empresa=$id;";
		return $this->query_($sql);
	}

	function getTemas($id){
		$sql = "SELECT DISTINCT (mt.cod_tema), t.tema FROM multifuente_test mt JOIN temas_360 t ON mt.cod_tema = t.cod_tema WHERE cod_test =\"$id\";";
		// echo $sql;
		return $this->query_($sql);
	}

// **********************
// DELETE
// **********************

	function delete(){
		$sql = "DELETE FROM multifuente_test WHERE id = $id;";
		$result = $this->query_($sql);

	}

// **********************
// INSERT
// **********************

	function insert(){

		$sql = "INSERT INTO multifuente_test ( id_empresa,cod_tema,cod_pregunta,pregunta,cod_test,nombre_test,descripcion ) VALUES ( '$this->id_empresa','$this->cod_tema','$this->cod_pregunta','$this->pregunta','$this->cod_test','$this->nombre_test','$this->descripcion' )";
		$result = $this->query_($sql);
		$this->id = mysqli_insert_id($this->link);

	}

// **********************
// UPDATE
// **********************

	function update(){
		$sql = " UPDATE multifuente_test SET  id_empresa = '$this->id_empresa',cod_tema = '$this->cod_tema',cod_pregunta = '$this->cod_pregunta',pregunta = '$this->pregunta',cod_test = '$this->cod_test',nombre_test = '$this->nombre_test',descripcion = '$this->descripcion' WHERE id = $id ";
		$result = $this->query_($sql);
	}

}
?>