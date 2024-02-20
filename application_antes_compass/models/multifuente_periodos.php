<?php

class Multifuente_periodos extends Model {
	public $id;
  public $periodo;
  public $id_empresa;
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

  function getId_empresa(){
    return $this->id_empresa;
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

  function setId_empresa($val){
    $this->id_empresa =  $val;
  }

  function setActivo($val){
    $this->activo =  $val;
  }

  // **********************
  // SELECT METHOD / LOAD
  // **********************

  function select($id){

    $sql =  "SELECT * FROM $this->_table WHERE id = $id;";

    $row =  $this->query_($sql,1);

    $this->id = $row['id'];

    $this->periodo = $row['periodo'];

    $this->id_empresa = $row['id_empresa'];

    $this->activo = $row['activo'];

  }

  // **********************
  // INSERT
  // **********************

  function insert(){

    $sql = "INSERT INTO multifuente_periodos ( periodo,id_empresa,activo ) VALUES ( '$this->periodo','$this->id_empresa','$this->activo' )";
    $result = $this->query_($sql);
    $this->id = mysqli_insert_id($this->link);

  }

  function insert_periodos_evaluador($periodo,$id_personal,$id_empresa){

    $sql = "INSERT INTO multifuente_periodos_evaluador ( periodo,id_personal,id_empresa ) VALUES ( '$periodo','$id_personal','$id_empresa' )";
    $result = $this->query_($sql);

  }

  // **********************
  // UPDATE
  // **********************

  function update(){

    $sql = " UPDATE multifuente_periodos SET  activo = '$this->activo' ";
    $result = $this->query_($sql);

  }

}

?>