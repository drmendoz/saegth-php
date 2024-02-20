<?php

// **********************
// CLASS DECLARATION
// **********************

class personal_datos_hijos extends Model{ 
// class : begin


// **********************
// ATTRIBUTE DECLARATION
// **********************


	public $id;   
	public $id_personal;   
	public $nombre_hijo;   
	public $fecha_nacimiento;   



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

	function getId_personal(){
		return $this->id_personal;
	}

	function getNombre_hijo(){
		return $this->htmlprnt($this->nombre_hijo);
	}

	function getFecha_nacimiento(){
		return $this->fecha_nacimiento;
	}

// **********************
// SETTER METHODS
// **********************


	function setId($val){
		$this->id =  $val;
	}

	function setId_personal($val){
		$this->id_personal =  $val;
	}

	function setNombre_hijo($val){
		$this->nombre_hijo =  $this->mres($val);
	}

	function setFecha_nacimiento($val){
		$this->fecha_nacimiento =  $this->mres($val);
	}

// **********************
// SELECT METHOD / LOAD
// **********************

	function select($id){

		$sql =  "SELECT * FROM personal_datos_hijos WHERE id = $id;";
		$row =  $this->query_($sql,1);


		$this->id = $row['id'];

		$this->id_personal = $row['id_personal'];

		$this->nombre_hijo = $row['nombre_hijo'];

		$this->fecha_nacimiento = $row['fecha_nacimiento'];

	}

	function select_all($id){
		return $this->query_('SELECT * FROM `personal_datos_hijos` WHERE `id_personal`='. $id .'');
	}

// **********************
// DELETE
// **********************

	function delete(){
		$sql = "DELETE FROM personal_datos_hijos WHERE id = $id;";
		$result = $this->query_($sql);

	}

	function delete_all($id){
		$sql = "DELETE FROM personal_datos_hijos WHERE id_personal = $id;";
		$result = $this->query_($sql);

	}

// **********************
// INSERT
// **********************

	function insert(){

		$sql = "INSERT INTO personal_datos_hijos ( id_personal,nombre_hijo,fecha_nacimiento ) VALUES ( '$this->id_personal','$this->nombre_hijo','$this->fecha_nacimiento' )";
		$result = $this->query_($sql);
		$this->id = mysqli_insert_id($this->link);

	}

// **********************
// UPDATE
// **********************

	function update(){



		$sql = " UPDATE personal_datos_hijos SET  id_personal = '$this->id_personal',nombre_hijo = '$this->nombre_hijo',fecha_nacimiento = '$this->fecha_nacimiento' WHERE id = $id ";

		$result = $this->query_($sql);



	}


} // class : end

?>