

<?php

// **********************
// CLASS DECLARATION
// **********************

class empresa_tcont extends Model{ 
// class : begin


// **********************
// ATTRIBUTE DECLARATION
// **********************


  public $id_empresa;   
  public $nombre;   



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

  function getNombre(){
    return $this->htmlprnt($this->nombre);
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

  function setNombre($val){
    $this->nombre =  $val;
  }

// **********************
// SELECT METHOD / LOAD
// **********************

  function select($id){

    $sql =  "SELECT * FROM empresa_tcont WHERE id = $id;";
    $row =  $this->query_($sql,1);


    $this->id = $row['id'];

    $this->id_empresa = $row['id_empresa'];

    $this->nombre = $row['nombre'];

  }

  function select_all($id, $json=false){
    if($json){
      $res = $this->query_('SELECT id,nombre FROM empresa_tcont WHERE `id_empresa`='. $id .' order by nombre ASC');
      if($res){
        $new = array();
        foreach ($res as $key => $value) {
          $tmp = array(
            'id' => $value['id'],
            'nombre' => $this->htmlprnt_win($value['nombre']),
            );
          array_push($new, $tmp);
        }
        return $new;
      }else{
        return $res;
      }
    }else{
      return $this->query_('SELECT id,nombre FROM empresa_tcont WHERE `id_empresa`='. $id .' order by nombre ASC');
    }
  }

  function init_array($parameters){
    foreach($parameters as $key => $value) {
  // var_dump($key."->".$value);
      $this->{$key} = $value;
    }
  }

// **********************
// DELETE
// **********************

  function delete(){
    $sql = "DELETE FROM empresa_tcont WHERE id = $this->id;";
    $result = $this->query_($sql);

  }

// **********************
// INSERT
// **********************

  function insert(){

    $sql = "INSERT INTO empresa_tcont ( id_empresa,nombre ) VALUES ( '$this->id_empresa','$this->nombre' )";
    $result = $this->query_($sql);
    $this->id = mysqli_insert_id($this->link);

  }

// **********************
// UPDATE
// **********************

  function update(){



    $sql = " UPDATE empresa_tcont SET  nombre = '$this->nombre' WHERE id = $this->id ";

    $result = $this->query_($sql);



  }

// **********************
// CUSTOM METHODS
// **********************

  function get_select_options($id){
    $ctrl = new self();
    $ptr = $ctrl->select_all($id);
    foreach ($ptr as $key => $value) {
      $tmp = new self($value);
      echo "<option value='".$tmp->getId()."'>".$tmp->getNombre()."</option>";
    }
  }

  /** 20170101 CTP
   *  Seleccionar tcont desde promedios_bajos y otros_promedios_bajos.
  */
  function get_select_options_selected($id,$filtro){
    $ctrl = new self();
    $ptr = $ctrl->select_all($id);
    foreach ($ptr as $key => $value) {
      $tmp = new self($value);
      if(in_array($tmp->getId(), $filtro))
        $t = "selected='selected'";
      else
        $t = "";
      echo "<option value='".$tmp->getId()."' ".$t.">".$tmp->getNombre()."</option>";
    }
  }

  //******************************************

} // class : end

?>

