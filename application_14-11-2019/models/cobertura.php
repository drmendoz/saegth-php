<?php

// **********************
// CLASS DECLARATION
// **********************

class cobertura extends Model{ 
// class : begin


// **********************
// ATTRIBUTE DECLARATION
// **********************


public $id;   
public $id_personal;   
public $id_area;   
public $id_cargo;   
public $id_local;   
public $comentario;   
public $month_1;   
public $month_2;   
public $month_3;   
public $month_4;   
public $month_5;   



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

function getId_area(){
return $this->id_area;
}

function getId_cargo(){
return $this->id_cargo;
}

function getId_local(){
return $this->id_local;
}

function getComentario(){
return $this->htmlprnt($this->comentario);
}

function getMonth_1(){
return $this->htmlprnt($this->month_1);
}

function getMonth_2(){
return $this->htmlprnt($this->month_2);
}

function getMonth_3(){
return $this->htmlprnt($this->month_3);
}

function getMonth_4(){
return $this->htmlprnt($this->month_4);
}

function getMonth_5(){
return $this->htmlprnt($this->month_5);
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

function setId_area($val){
$this->id_area =  $val;
}

function setId_cargo($val){
$this->id_cargo =  $val;
}

function setId_local($val){
$this->id_local =  $val;
}

function setComentario($val){
$this->comentario =  $val;
}

function setMonth_1($val){
$this->month_1 =  $val;
}

function setMonth_2($val){
$this->month_2 =  $val;
}

function setMonth_3($val){
$this->month_3 =  $val;
}

function setMonth_4($val){
$this->month_4 =  $val;
}

function setMonth_5($val){
$this->month_5 =  $val;
}

// **********************
// SELECT METHOD / LOAD
// **********************

function select($id){

$sql =  "SELECT * FROM cobertura WHERE id = $id;";
$row =  $this->query_($sql,1);


$this->id = $row['id'];

$this->id_personal = $row['id_personal'];

$this->id_area = $row['id_area'];

$this->id_cargo = $row['id_cargo'];

$this->id_local = $row['id_local'];

$this->comentario = $row['comentario'];

$this->month_1 = $row['month_1'];

$this->month_2 = $row['month_2'];

$this->month_3 = $row['month_3'];

$this->month_4 = $row['month_4'];

$this->month_5 = $row['month_5'];

}
function select_all($id){

$sql =  "SELECT * FROM cobertura WHERE id_personal = $id;";
return $this->query_($sql);

}

// **********************
// DELETE
// **********************

function delete(){
$sql = "DELETE FROM cobertura WHERE id = $this->id;";
$result = $this->query_($sql);

}
function delete_all($id){
$sql = "DELETE FROM cobertura WHERE id_personal = $id;";
$result = $this->query_($sql);

}

// **********************
// INSERT
// **********************

function insert(){

$sql = "INSERT INTO cobertura ( id_personal,id_area,id_cargo,id_local,comentario,month_1,month_2,month_3,month_4,month_5 ) VALUES ( '$this->id_personal','$this->id_area','$this->id_cargo','$this->id_local','$this->comentario','$this->month_1','$this->month_2','$this->month_3','$this->month_4','$this->month_5' )";
$result = $this->query_($sql);
$this->id = mysqli_insert_id($this->link);

}

// **********************
// UPDATE
// **********************

function update(){



$sql = " UPDATE cobertura SET  id_personal = '$this->id_personal',id_area = '$this->id_area',id_cargo = '$this->id_cargo',id_local = '$this->id_local',comentario = '$this->comentario',month_1 = '$this->month_1',month_2 = '$this->month_2',month_3 = '$this->month_3',month_4 = '$this->month_4',month_5 = '$this->month_5' WHERE id = $this->id ";

$result = $this->query_($sql);



}


} // class : end

?>
