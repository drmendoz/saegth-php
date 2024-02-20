<?php

// **********************
// CLASS DECLARATION
// **********************

class log_actividad extends Model{ 

// **********************
// ATTRIBUTE DECLARATION
// **********************


public $autor_id_personal;   
public $objetivo_id_personal;   
public $vista;   
public $descripcion;   
public $fecha;   
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

function getAutor_id_personal(){
return $this->autor_id_personal;
}

function getObjetivo_id_personal(){
return $this->objetivo_id_personal;
}

function getVista(){
return $this->vista;
}

function getDescripcion(){
return $this->descripcion;
}

function getFecha(){
return $this->fecha;
}

// **********************
// SETTER METHODS
// **********************


function setId($val){
$this->id =  $val;
}

function setAutor_id_personal($val){
$this->autor_id_personal =  $val;
}

function setObjetivo_id_personal($val){
$this->objetivo_id_personal =  $val;
}

function setVista($val){
$this->vista =  $val;
}

function setDescripcion($val){
$this->descripcion =  $val;
}

function setFecha($val){
$this->fecha =  $val;
}

// **********************
// SELECT METHOD / LOAD
// **********************

function select($id){

$sql =  "SELECT * FROM log_actividad WHERE id = $id;";
$row =  $this->query_($sql,1);

$this->id = $row['id'];$this->autor_id_personal = $row['autor_id_personal'];$this->objetivo_id_personal = $row['objetivo_id_personal'];$this->vista = $row['vista'];$this->descripcion = $row['descripcion'];$this->fecha = $row['fecha'];
}

// **********************
// DELETE
// **********************

function delete(){
$sql = "DELETE FROM log_actividad WHERE id = $id;";
$result = $this->query_($sql);

}

// **********************
// INSERT
// **********************

function insert(){

$sql = "INSERT INTO log_actividad ( autor_id_personal,objetivo_id_personal,vista,descripcion,fecha ) VALUES ( '$this->autor_id_personal','$this->objetivo_id_personal','$this->vista','$this->descripcion','$this->fecha' )";
$result = $this->query_($sql);
$this->id = mysqli_insert_id($this->link);

}

// **********************
// UPDATE
// **********************

function update(){
$sql = " UPDATE log_actividad SET  autor_id_personal = '$this->autor_id_personal',objetivo_id_personal = '$this->objetivo_id_personal',vista = '$this->vista',descripcion = '$this->descripcion',fecha = '$this->fecha' WHERE id = $id ";
$result = $this->query_($sql);
}

}
?>