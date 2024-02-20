<?php

// **********************
// CLASS DECLARATION
// **********************

class Riesgo_retencion extends Model{ 
// class : begin


// **********************
// ATTRIBUTE DECLARATION
// **********************


public $id_personal;   
public $posicion;   
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


function getId_personal(){
return $this->id_personal;
}

function getPosicion(){
return $this->posicion;
}

function getId_empresa(){
return $this->id_empresa;
}

// **********************
// SETTER METHODS
// **********************


function setId_personal($val){
$this->id_personal =  $val;
}

function setPosicion($val){
$this->posicion =  $val;
}

function setId_empresa($val){
$this->id_empresa =  $val;
}

// **********************
// SELECT METHOD / LOAD
// **********************

function select($id){

$sql =  "SELECT * FROM riesgo_retencion WHERE id_personal = $id;";
$row =  $this->query_($sql,1);


$this->id_personal = $row['id_personal'];

$this->posicion = $row['posicion'];

$this->id_empresa = $row['id_empresa'];

}

function select_all_ids($id){

$sql =  "SELECT id_personal FROM riesgo_retencion WHERE id_empresa = $id;";
return  $this->query_($sql);
}

function select_x_posicion($id){

$sql =  "SELECT * FROM riesgo_retencion WHERE id_empresa = $this->id_empresa AND posicion = $id ";
return  $this->query_($sql);
}

// **********************
// DELETE
// **********************

function delete(){
$sql = "DELETE FROM riesgo_retencion WHERE id_personal = $this->id_personal;";
$result = $this->query_($sql);

}

function delete_all($id){
$sql = "DELETE FROM riesgo_retencion WHERE id_empresa = $id;";
$result = $this->query_($sql);

}

// **********************
// INSERT
// **********************

function insert(){

$sql = "INSERT INTO riesgo_retencion ( id_personal, posicion,id_empresa ) VALUES ( '$this->id_personal','$this->posicion','$this->id_empresa' )";
$result = $this->query_($sql);
$this->id_personal = mysqli_insert_id($this->link);

}

// **********************
// UPDATE
// **********************

function update(){



$sql = " UPDATE riesgo_retencion SET  posicion = '$this->posicion',id_empresa = '$this->id_empresa' WHERE id_personal = $id ";

$result = $this->query_($sql);



}


} // class : end

?>
 
