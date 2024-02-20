
<?php

// **********************
// CLASS DECLARATION
// **********************

class Plan_desarrollo extends Model{ 
// class : begin


// **********************
// ATTRIBUTE DECLARATION
// **********************


  public $id;   
  public $id_personal;   
  public $id_area;   
  public $id_cargo;   
  public $opc_plazo;   
  public $accion;   
  public $tipo;   
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

  function getId_personal(){
    return $this->id_personal;
  }

  function getId_area(){
    return $this->id_area;
  }

  function getId_cargo(){
    return $this->id_cargo;
  }

  function get_area2(){
    return $this->get_area($this->id_area);
  }

  function get_cargo2(){
    return $this->get_cargo($this->id_cargo);
  }

  function getOpc_plazo(){
    return $this->opc_plazo;
  }

  function get_plazo(){
    switch ($this->opc_plazo) {
      case 0:
        return "Menor a 6 meses";
        break;
      case 1:
        return "De 6 a 12 meses";
        break;
      case 2:
        return "De 12 a 24 meses";
        break;
      case 3:
        return "de 2 a 3 años";
        break;
      case 4:
        return "Mayor a 3 años";
        break;
    }
  }

  function getAccion(){
    return $this->htmlprnt($this->accion);
  }

  function getTipo(){
    return $this->htmlprnt($this->tipo);
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

  function setId_personal($val){
    $this->id_personal =  $val;
  }

  function setId_area($val){
    $this->id_area =  $val;
  }

  function setId_cargo($val){
    $this->id_cargo =  $val;
  }

  function setOpc_plazo($val){
    $this->opc_plazo =  $val;
  }

  function setAccion($val){
    $this->accion =  $val;
  }

  function setTipo($val){
    $this->tipo =  $val;
  }

  function setFecha($val){
    $this->fecha =  $val;
  }

// **********************
// SELECT METHOD / LOAD
// **********************

  function select($id){

    $sql =  "SELECT * FROM plan_desarrollo WHERE id = $id;";
    $row =  $this->query_($sql,1);


    $this->id = $row['id'];

    $this->id_personal = $row['id_personal'];

    $this->id_area = $row['id_area'];

    $this->id_cargo = $row['id_cargo'];

    $this->opc_plazo = $row['opc_plazo'];

    $this->accion = $row['accion'];

    $this->tipo = $row['tipo'];

    $this->fecha = $row['fecha'];

  }

  function select_all($id){
    return $this->query_('SELECT * FROM plan_desarrollo WHERE `id_personal`='. $id .'');
  }

  function select_all_x_empresa($id){
    return $this->query_('SELECT DISTINCT pd.id_personal FROM plan_desarrollo as pd
     JOIN personal_empresa as pe
     ON pd.id_personal = pe.id_personal
     WHERE id_empresa='.$id.'
     ');
  }

// **********************
// DELETE
// **********************

  function delete(){
    $sql = "DELETE FROM plan_desarrollo WHERE id = $this->id;";
    $result = $this->query_($sql);

  }

// **********************
// INSERT
// **********************

  function insert(){

    $sql = "INSERT INTO plan_desarrollo ( id_personal,id_area,id_cargo,opc_plazo,accion,tipo,fecha ) VALUES ( '$this->id_personal','$this->id_area','$this->id_cargo','$this->opc_plazo','$this->accion','$this->tipo','$this->fecha' )";
    $result = $this->query_($sql);
    $this->id = mysqli_insert_id($this->link);

  }

// **********************
// UPDATE
// **********************

  function update(){



    $sql = " UPDATE plan_desarrollo SET  id_personal = '$this->id_personal',id_area = '$this->id_area',id_cargo = '$this->id_cargo',opc_plazo = '$this->opc_plazo',accion = '$this->accion',tipo = '$this->tipo',fecha = '$this->fecha' WHERE id = $this->id ";

    $result = $this->query_($sql);



  }


} // class : end

?>
