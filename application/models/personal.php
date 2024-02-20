<?php

// **********************
// CLASS DECLARATION
// **********************

class personal extends Model{ 

// **********************
// ATTRIBUTE DECLARATION
// **********************


  public $id;   
  public $id_empresa;   
  public $nombre_p;   
  public $foto="";   
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

  function getId_empresa(){
    return $this->id_empresa;
  }

  function getNombre_p(){
    return $this->htmlprnt($this->nombre_p);
  }

  function getFoto(){
    return $this->foto;
  }

// **********************
// SETTER METHODS
// **********************


  function setId($val){
    $this->id =  $val;
  }

  function setId_empresa($val){
    $this->id_empresa =  $val;
  }

  function setNombre_p($val){
    $this->nombre_p =  $val;
  }

  function setFoto($val){
    $this->foto =  $val;
  }

// **********************
// SELECT METHOD / LOAD
// **********************

  function select($id){

    $sql =  "SELECT * FROM personal WHERE id = $id;";
    $row =  $this->query_($sql,1);


    $this->id = $row['id'];

    $this->id_empresa = $row['id_empresa'];

    $this->nombre_p = $row['nombre_p'];

    $this->foto = $row['foto'];

  }


  public static function withID($id) {
    $tmp = new self();  
    $tmp->select($id);
    return $tmp;
  }


// **********************
// DELETE
// **********************

  function delete(){
    $sql = "DELETE FROM personal WHERE id = $id;";
    $result = $this->query_($sql);

  }

// **********************
// INSERT
// **********************

  function insert(){

    $sql = "INSERT INTO personal ( id_empresa,nombre_p,foto ) VALUES ( '$this->id_empresa','$this->nombre_p','$this->foto' )";
    $result = $this->query_($sql);
    $this->id = mysqli_insert_id($this->link);

  }

// **********************
// UPDATE
// **********************

  function update(){
    $sql = " UPDATE personal SET  id_empresa = '$this->id_empresa',nombre_p = '$this->nombre_p',foto = '$this->foto' WHERE id = $id ";
    $result = $this->query_($sql);
  }

  function getErrorMsg(){
    $errno = $this->getErrno();
    switch ($errno) {
      case 1062:
      return $this->getCustomErrmsg($errno).". Ya existe un usuario con ese nombre en la empresa.";
      break;

      default:
      echo "Ocurrió un error en el último proceso";
      break;
    }
  }
}
?>

