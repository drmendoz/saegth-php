<?php

// **********************
// CLASS DECLARATION
// **********************

class scorer_estado_periodo extends Model{ 

// **********************
// ATTRIBUTE DECLARATION
// **********************


    public $id_personal;   
    public $usuario;   
    public $jefe;   
    public $bloqueo;   
    public $revision;   
    public $revision_jefe;   
    public $evaluacion;   
    public $evaluacion_jefe;   
    public $activo;   
    public $ajuste;   
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

function getUsuario(){
    return $this->usuario;
}

function getJefe(){
    return $this->jefe;
}

function getBloqueo(){
    return $this->bloqueo;
}

function getRevision(){
    return $this->revision;
}

function getRevision_jefe(){
    return $this->revision_jefe;
}

function getEvaluacion(){
    return $this->evaluacion;
}

function getEvaluacion_jefe(){
    return $this->evaluacion_jefe;
}

function getActivo(){
    return $this->activo;
}

function getAjuste(){
    return $this->ajuste;
}

function getPeriodo(){
    return $this->periodo;
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

function setUsuario($val){
    $this->usuario =  $val;
}

function setJefe($val){
    $this->jefe =  $val;
}

function setBloqueo($val){
    $this->bloqueo =  $val;
}

function setRevision($val){
    $this->revision =  $val;
}

function setRevision_jefe($val){
    $this->revision_jefe =  $val;
}

function setEvaluacion($val){
    $this->evaluacion =  $val;
}

function setEvaluacion_jefe($val){
    $this->evaluacion_jefe =  $val;
}

function setActivo($val){
    $this->activo =  $val;
}

function setAjuste($val){
    $this->ajuste =  $val;
}

function setPeriodo($val){
    $this->periodo =  $val;
}

// **********************
// SELECT METHOD / LOAD
// **********************

function select($id){

    $sql =  "SELECT * FROM scorer_estado_periodo WHERE id = $id;";
    $row =  $this->query_($sql,1);


    $this->id = $row['id'];

    $this->id_personal = $row['id_personal'];

    $this->usuario = $row['usuario'];

    $this->jefe = $row['jefe'];

    $this->bloqueo = $row['bloqueo'];

    $this->revision = $row['revision'];

    $this->revision_jefe = $row['revision_jefe'];

    $this->evaluacion = $row['evaluacion'];

    $this->evaluacion_jefe = $row['evaluacion_jefe'];

    $this->activo = $row['activo'];

    $this->ajuste = $row['ajuste'];

    $this->periodo = $row['periodo'];

}

// **********************
// DELETE
// **********************

function delete(){
    $sql = "DELETE FROM scorer_estado_periodo WHERE id = $id;";
    $result = $this->query_($sql);

}

// **********************
// INSERT
// **********************

function insert(){

    $sql = "INSERT INTO scorer_estado_periodo ( id_personal,usuario,jefe,bloqueo,revision,revision_jefe,evaluacion,evaluacion_jefe,activo,ajuste,periodo ) VALUES ( '$this->id_personal','$this->usuario','$this->jefe','$this->bloqueo','$this->revision','$this->revision_jefe','$this->evaluacion','$this->evaluacion_jefe','$this->activo','$this->ajuste','$this->periodo' )";
    $result = $this->query_($sql);
    $this->id = mysqli_insert_id($this->link);

}

// **********************
// UPDATE
// **********************

function update(){
    $sql = " UPDATE scorer_estado_periodo SET  id_personal = '$this->id_personal',usuario = '$this->usuario',jefe = '$this->jefe',bloqueo = '$this->bloqueo',revision = '$this->revision',revision_jefe = '$this->revision_jefe',evaluacion = '$this->evaluacion',evaluacion_jefe = '$this->evaluacion_jefe',activo = '$this->activo',ajuste = '$this->ajuste',periodo = '$this->periodo' WHERE id = $id ";
    $result = $this->query_($sql);
}

function count_personal_in($ids,$column,$periodo){
    $sql="SELECT
    count(*) as n_empleados,
    SUM(if(se.usuario = 1, 1, 0)) AS usuario,
    SUM(if(se.jefe = 1, 1, 0)) AS jefe,
    SUM(if(se.revision = 1, 1, 0)) AS r_empleado,
    SUM(if(se.revision_jefe = 1, 1, 0)) AS r_jefe,
    SUM(if(se.evaluacion = 1, 1, 0)) AS e_empleado,
    SUM(if(se.evaluacion_jefe = 1, 1, 0)) AS e_jefe
    FROM
    listado_personal_op lp
    JOIN scorer_estado_periodo se ON lp.id = se.id_personal
    WHERE
    lp.activo = 1
    AND 
    se.activo = 1
    AND 
    se.periodo = $periodo
    AND $column IN ($ids)";
    $res = $this->query_($sql,1);
    return $res;
}

}
?>
