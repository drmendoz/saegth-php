<?php

// **********************
// CLASS DECLARATION
// **********************

class scorer_estado extends Model{ 

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

// **********************
// SETTER METHODS
// **********************


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

// **********************
// SELECT METHOD / LOAD
// **********************

  function select($id){

    $sql =  "SELECT * FROM scorer_estado WHERE id_personal = $id;";
    $row =  $this->query_($sql,1);


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

  }

// **********************
// DELETE
// **********************

  function delete(){
    $sql = "DELETE FROM scorer_estado WHERE id_personal = $id;";
    $result = $this->query_($sql);

  }

// **********************
// INSERT
// **********************


  function insert(){
    $this->query('INSERT INTO `scorer_estado`(`id_personal`) VALUES ('.$this->id_personal.')');
    $this->id = mysqli_insert_id($this->link);
  }

// **********************
// UPDATE
// **********************

  function update(){
    $sql = " UPDATE scorer_estado SET usuario = '$this->usuario',jefe = '$this->jefe',bloqueo = '$this->bloqueo',revision = '$this->revision',revision_jefe = '$this->revision_jefe',evaluacion = '$this->evaluacion',evaluacion_jefe = '$this->evaluacion_jefe',activo = '$this->activo',ajuste = '$this->ajuste' WHERE id_personal = $this->id_personal ";
    $result = $this->query_($sql);
  }

  function getById(){
    $res =$this->query_('SELECT * FROM scorer_estado WHERE id_personal='.$this->id_personal.'',1);
    return new self($res);
  }

  function select_all($sql=""){
    $sql = "SELECT se.*,lpo.nombre,lpo.cedula,lpo.cargo  FROM scorer_estado as se JOIN listado_personal_op as lpo ON se.id_personal = lpo.id WHERE lpo.activo=1 AND empresa=".$_SESSION["Empresa"]["id"]." $sql";
    // echo $sql;
    return $this->query_($sql);
  }

  function select_all_by_ids($ids){
    return $this->query_("SELECT se.*,lpo.nombre,lpo.cargo  FROM scorer_estado as se JOIN listado_personal_op as lpo ON se.id_personal = lpo.id WHERE lpo.activo=1 AND id_personal IN ($ids) ");
  }

  function count(){
    $res = $this->query_('SELECT count(*) as count FROM scorer_estado as se JOIN listado_personal_op as lpo ON se.id_personal = lpo.id WHERE lpo.activo=1 AND empresa='.$_SESSION["Empresa"]["id"].'',1);
    return $res['count'];
  }

  function getIcon($x){
    $success = '<h2><i class="fa fa-check" style="color:green"></i></h2>';
    $error = '<h2><i class="fa fa-times" style="color:red"></i></h2>';
    switch ($x) {
      case 0:
      return $error;
      break;
      case 1:
      return $success;
      break;
    }
  }

  public static function withID($id) {
    $tmp = new self(array('id_personal' => $id)); 
    return $tmp->getById();
  }

  public static function insertById($id) {
    $tmp = new self(array('id_personal' => $id)); 
    $tmp->insert();
    return $tmp->getById();
  }

  function count_personal_in($ids,$column){
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
    JOIN scorer_estado se ON lp.id = se.id_personal
    WHERE
    lp.activo = 1
    AND 
    se.activo = 1
    AND $column IN ($ids)";
    $res = $this->query_($sql,1);
    return $res;
  }

}
?>
