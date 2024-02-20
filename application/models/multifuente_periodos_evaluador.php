<?php

class Multifuente_periodos_evaluador extends Model {
	public $id;
  public $periodo;
  public $id_personal;
  public $id_empresa;
  public $reinicio_indivudual;
  public $activo;

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

  function getPeriodo(){
    return $this->periodo;
  }

  function getId_personal(){
    return $this->id_personal;
  }

  function getId_empresa(){
    return $this->id_empresa;
  }

  function getReinicio_indivudual(){
    return $this->reinicio_indivudual;
  }

  function getActivo(){
    return $this->activo;
  }

  // **********************
  // SETTER METHODS
  // **********************
  function setId($val){
    $this->id =  $val;
  }

  function setPeriodo($val){
    $this->periodo =  $val;
  }

  function setId_personal($val){
    $this->id_personal =  $val;
  }

  function setId_empresa($val){
    $this->id_empresa =  $val;
  }

  function setReinicio_indivudual($val){
    $this->reinicio_indivudual =  $val;
  }

  function setActivo($val){
    $this->activo =  $val;
  }

  // **********************
  // SELECT METHOD / LOAD
  // **********************

  function select($id){

    $sql =  "SELECT * FROM multifuente_periodos_evaluador WHERE id = $id;";

    $row =  $this->query_($sql,1);

    $this->id = $row['id'];

    $this->periodo = $row['periodo'];

    $this->id_personal = $row['id_personal'];

    $this->id_empresa = $row['id_empresa'];

    $this->reinicio_indivudual = $row['reinicio_indivudual'];

    $this->activo = $row['activo'];

  }

  function last_periodoEvaluador($id_personal, $id_empresa)
  {
    $sql =  "SELECT * ";
    $sql .= "FROM multifuente_periodos_evaluador mpe ";
    $sql .= "WHERE mpe.id_empresa = $id_empresa ";
    $sql .= "AND mpe.id_personal = $id_personal ";
    $sql .= "AND mpe.activo = 'A' ";
    $sql .= "AND mpe.periodo = (SELECT id FROM multifuente_periodos WHERE activo = 'A' AND id_empresa = ".$id_empresa." ORDER BY id DESC LIMIT 0,1) ";
    $sql .= "order by mpe.Id desc LIMIT 0,1";
    //echo $sql.PHP_EOL;
    $row =  $this->query_($sql,1);

    if(!isset($row['id']))
    {
      $row['id'] = 0;
      $row['id_personal'] = 0;
    }

    return $row;
  }

  // **********************
  // INSERT
  // **********************

  function insert(){

    $sql = "INSERT INTO multifuente_periodos_evaluador ( periodo,id_personal,id_empresa,reinicio_indivudual,activo ) VALUES ( '$this->periodo','$this->id_personal','$this->id_empresa','$this->reinicio_indivudual','$this->activo' )";
    $result = $this->query_($sql);

  }

  function update(){

    $sql = " UPDATE multifuente_periodos SET periodo = '$this->periodo', id_personal = '$this->id_personal', id_empresa = '$this->id_empresa', reinicio_indivudual = '$this->reinicio_indivudual', activo = '$this->activo' where Id = this->Id ";
    $result = $this->query_($sql);

  }

  function inactiveAllPersonal($id_personal, $id_empresa)
  {
    $sql = "UPDATE multifuente_periodos_evaluador SET activo = 'I' WHERE id_personal = $id_personal AND id_empresa = $id_empresa AND activo = 'A' ";
    $result = $this->query_($sql);
  }

}

?>