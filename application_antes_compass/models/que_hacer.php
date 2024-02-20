<?php

// **********************
// CLASS DECLARATION
// **********************

class que_hacer extends Model{ 
// class : begin


// **********************
// ATTRIBUTE DECLARATION
// **********************


public $id;   
public $id_personal;   
public $tipo;   
public $comentario;   
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

function getId_personal(){
return $this->id_personal;
}

function getTipo(){
return $this->tipo;
}

function getPeriodo(){
return $this->periodo;
}

function getComentario(){
return $this->htmlprnt($this->comentario);
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

function setTipo($val){
$this->tipo =  $val;
}

function setPeriodo($val){
$this->periodo =  $val;
}

function setComentario($val){
$this->comentario =  $val;
}

// **********************
// SELECT METHOD / LOAD
// **********************

function select($id){

$sql =  "SELECT * FROM que_hacer WHERE id = $id;";
$row =  $this->query_($sql,1);


$this->id = $row['id'];

$this->id_personal = $row['id_personal'];

$this->tipo = $row['tipo'];

$this->comentario = $row['comentario'];

}

function select_all($tipo){

$sql =  "SELECT * FROM que_hacer WHERE id_personal = $this->id_personal AND tipo = '$tipo' AND periodo = $this->periodo;";
// echo $sql;
return $this->query_($sql);

}

// **********************
// DELETE
// **********************

function delete(){
$sql = "DELETE FROM que_hacer WHERE id = $this->id;";
$result = $this->query_($sql);

}

// **********************
// INSERT
// **********************

function insert(){

$sql = "INSERT INTO que_hacer ( id_personal,tipo,periodo,comentario ) VALUES ( '$this->id_personal','$this->tipo','$this->periodo','$this->comentario' )";
$result = $this->query_($sql);
$this->id = mysqli_insert_id($this->link);

}

// **********************
// UPDATE
// **********************

function update(){



$sql = " UPDATE que_hacer SET  id_personal = '$this->id_personal',tipo = '$this->tipo',periodo = '$this->periodo',comentario = '$this->comentario' WHERE id = $this->id ";

$result = $this->query_($sql);



}


} // class : end

?>