<?php

// **********************
// CLASS DECLARATION
// **********************

class Evaluacion_Desempenio_Cuestionario extends Model{ 
	// class : begin


	// **********************
	// ATTRIBUTE DECLARATION
	// **********************


	public $id;   
	public $descripcion;
	public $temas;
	public $id_empresa;
	public $edad;
	public $antiguedad;
	public $localidad;
	public $departamento;
	public $norg;
	public $tcont;
	public $educacion;
	public $sexo;



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

	function getDescripcion(){
		return $this->htmlprnt($this->descripcion);
	}

	function getTemas(){
		return unserialize($this->temas);
	}

	function getIdEmpresa(){
		return $this->id_empresa;
	}

	function getEdad(){
		return $this->edad;
	}

	function getAntiguedad(){
		return $this->antiguedad;
	}

	function getLocalidad(){
		return $this->localidad;
	}

	function getDepartamento(){
		return $this->departamento;
	}

	function getNorg(){
		return $this->norg;
	}

	function getTcont(){
		return $this->tcont;
	}

	function getEducacion(){
		return $this->educacion;
	}

	function getSexo(){
		return $this->sexo;
	}

	// **********************
	// SETTER METHODS
	// **********************


	function setId($val){
		$this->id =  $val;
	}

	function setDescripcion($val){
		$this->descripcion =  $val;
	}

	function setTemas($val){
		$this->temas =  serialize($val);
	}

	function setIdEmpresa($val){
		$this->id_empresa =  $val;
	}

	function setEdad($val){
		$this->edad =  $val;
	}

	function setAntiguedad($val){
		$this->antiguedad =  $val;
	}

	function setLocalidad($val){
		$this->localidad =  $val;
	}

	function setDepartamento($val){
		$this->departamento =  $val;
	}

	function setNorg($val){
		$this->norg =  $val;
	}

	function setTcont($val){
		$this->tcont =  $val;
	}

	function setEducacion($val){
		$this->educacion =  $val;
	}

	function setSexo($val){
		$this->sexo =  $val;
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
		$this->descripcion = $row['descripcion'];
		$this->segmentacion = $row['segmentacion'];
		$this->temas = $row['preguntas'];
		$this->id_empresa = $row['id_empresa'];
		$this->edad = $row['edad'];
		$this->antiguedad = $row['antiguedad'];
		$this->localidad = $row['localidad'];
		$this->departamento = $row['departamento'];
		$this->norg = $row['norg'];
		$this->tcont = $row['tcont'];
		$this->educacion = $row['educacion'];
		$this->sexo = $row['sexo'];

	}

	function select_all(){

		$sql =  "SELECT id,descripcion,segmentacion,temas,id_empresa,edad, antiguedad,localidad,departamento,norg,tcont,educacion,sexo FROM $this->_table WHERE id_empresa = ".$_SESSION['Empresa']['id'];
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

		$sql = "INSERT INTO $this->_table (descripcion,temas,id_empresa,edad,antiguedad,localidad,departamento,norg,tcont,educacion,sexo ) 
				VALUES ('$this->descripcion',
						'$this->temas',
						'$this->id_empresa',
						'$this->edad',
						'$this->antiguedad',
						'$this->localidad',
						'$this->departamento',
						'$this->norg',
						'$this->tcont',
						'$this->educacion',
						'$this->sexo'
						)";
		$result = $this->query_($sql);
		$this->id = mysqli_insert_id($this->link);

	}

	// **********************
	// UPDATE
	// **********************

	function update(){

		$sql = " UPDATE $this->_table 
				 SET  	id = '$this->id',
				 		descripcion = '$this->descripcion', 
				 		segmentacion = '$this->segmentacion', 
				 		temas = '$this->temas', 
				 		id_empresa = '$this->id_empresa', 
				 		edad = '$this->edad', 
				 		antiguedad = '$this->antiguedad', 
				 		localidad = '$this->localidad', 
				 		departamento = '$this->departamento', 
				 		norg = '$this->norg', 
				 		tcont = '$this->tcont', 
				 		educacion = '$this->educacion', 
				 		sexo = '$this->sexo' 
				 WHERE id = $this->id ";

		$result = $this->query_($sql);

	}


	//
	function get_Cuestionarios_Combo(){
		
		$x = new Evaluacion_Desempenio_Cuestionario();
		$sql =  "SELECT id,descripcion FROM $this->_table WHERE id_empresa = ".$_SESSION['Empresa']['id'];
		$result = $this->query_($sql);

		foreach ($result as $key => $value) {
			$tema_nombre = $value['descripcion'];
			$tema_id = $value['id'];

			echo "<option value='".$tema_id."'>".$tema_nombre."</option>";
		}
	}
} // class : end

?>