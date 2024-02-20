

<?php

// **********************
// CLASS DECLARATION
// **********************

class multifuente_oportunidades extends Model{ 
// class : begin


// **********************
// ATTRIBUTE DECLARATION
// **********************


public $cod_evaluado;   
public $cod_pregunta;   
public $accion;   
public $tipo;   
public $medicion;   
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

function getCod_evaluado(){
return $this->cod_evaluado;
}

function getCod_pregunta(){
return $this->cod_pregunta;
}

function getPregunta(){
return $this->get_preg($this->cod_pregunta);
}

function getAccion(){
return $this->accion;
}

function getTipo(){
return $this->tipo;
}

function getMedicion(){
return $this->medicion;
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

function setCod_evaluado($val){
$this->cod_evaluado =  $val;
}

function setCod_pregunta($val){
$this->cod_pregunta =  $val;
}

function setAccion($val){
$this->accion =  $val;
}

function setTipo($val){
$this->tipo =  $val;
}

function setMedicion($val){
$this->medicion =  $val;
}

function setFecha($val){
$this->fecha =  $val;
}

// **********************
// SELECT METHOD / LOAD
// **********************

function select($id){

$sql =  "SELECT * FROM multifuente_oportunidades WHERE id = $id;";
$row =  $this->query_($sql,1);


$this->id = $row['id'];

$this->cod_evaluado = $row['cod_evaluado'];

$this->cod_pregunta = $row['cod_pregunta'];

$this->accion = $row['accion'];

$this->tipo = $row['tipo'];

$this->medicion = $row['medicion'];

$this->fecha = $row['fecha'];

}

// **********************
// DELETE
// **********************

function delete(){
$sql = "DELETE FROM multifuente_oportunidades WHERE id = $id;";
$result = $this->query_($sql);

}

// **********************
// INSERT
// **********************

function insert(){

$sql = "INSERT INTO multifuente_oportunidades ( cod_evaluado,cod_pregunta,accion,tipo,medicion,fecha ) VALUES ( '$this->cod_evaluado','$this->cod_pregunta','$this->accion','$this->tipo','$this->medicion','$this->fecha' )";
$result = $this->query_($sql);
$this->id = mysqli_insert_id($this->link);

}

// **********************
// UPDATE
// **********************

function update(){



$sql = " UPDATE multifuente_oportunidades SET  cod_evaluado = '$this->cod_evaluado',cod_pregunta = '$this->cod_pregunta',accion = '$this->accion',tipo = '$this->tipo',medicion = '$this->medicion',fecha = '$this->fecha' WHERE id = $id ";

$result = $this->query_($sql);



}


} // class : end

?>
 
