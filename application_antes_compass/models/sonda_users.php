

<?php

// **********************
// CLASS DECLARATION
// **********************

class Sonda_user extends Model{ 
// class : begin


// **********************
// ATTRIBUTE DECLARATION
// **********************


public $user_name;   
public $password;   
public $id_empresa;   
public $edad;   
public $antiguedad;   
public $localidad;   
public $departamento;   
public $norg;   
public $tcont;   
public $eduacion;   
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

function getUser_name(){
return $this->user_name;
}

function getPassword(){
return $this->password;
}

function getId_empresa(){
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

function getEduacion(){
return $this->eduacion;
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

function setUser_name($val){
$this->user_name =  $val;
}

function setPassword($val){
$this->password =  $val;
}

function setId_empresa($val){
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

function setEduacion($val){
$this->eduacion =  $val;
}

function setSexo($val){
$this->sexo =  $val;
}

// **********************
// SELECT METHOD / LOAD
// **********************

function select($id){

$sql =  "SELECT * FROM $this->_table WHERE id = $id;";
$row =  $this->query_($sql,1);


$this->id = $row['id'];

$this->user_name = $row['user_name'];

$this->password = $row['password'];

$this->id_empresa = $row['id_empresa'];

$this->edad = $row['edad'];

$this->antiguedad = $row['antiguedad'];

$this->localidad = $row['localidad'];

$this->departamento = $row['departamento'];

$this->norg = $row['norg'];

$this->tcont = $row['tcont'];

$this->eduacion = $row['eduacion'];

$this->sexo = $row['sexo'];

}

// **********************
// DELETE
// **********************

function delete(){
$sql = "DELETE FROM $this->_table WHERE id = $id;";
$result = $this->query_($sql);

}

// **********************
// INSERT
// **********************

function insert(){

$sql = "INSERT INTO $this->_table ( user_name,password,id_empresa,edad,antiguedad,localidad,departamento,norg,tcont,eduacion,sexo ) VALUES ( '$this->user_name','$this->password','$this->id_empresa','$this->edad','$this->antiguedad','$this->localidad','$this->departamento','$this->norg','$this->tcont','$this->eduacion','$this->sexo' )";
$result = $this->query_($sql);
$this->id = mysqli_insert_id($this->link);

}

// **********************
// UPDATE
// **********************

function update(){



$sql = " UPDATE $this->_table SET  user_name = '$this->user_name',password = '$this->password',id_empresa = '$this->id_empresa',edad = '$this->edad',antiguedad = '$this->antiguedad',localidad = '$this->localidad',departamento = '$this->departamento',norg = '$this->norg',tcont = '$this->tcont',eduacion = '$this->eduacion',sexo = '$this->sexo' WHERE id = $id ";

$result = $this->query_($sql);



}


} // class : end

?>
 
