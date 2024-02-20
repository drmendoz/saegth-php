

<?php

// **********************
// CLASS DECLARATION
// **********************

class empresa_cargo extends Model{ 
// class : begin


// **********************
// ATTRIBUTE DECLARATION
// **********************


	public $id_empresa;   
	public $nivel;   
	public $nombre;   
	public $id_superior;   



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

	function getNivel(){
		return $this->nivel;
	}

	function getNombre(){
		return $this->htmlprnt($this->nombre);
	}

	function getId_superior(){
		return $this->id_superior;
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

	function setNivel($val){
		$this->nivel =  $val;
	}

	function setNombre($val){
		$this->nombre =  $val;
	}

	function setId_superior($val){
		$this->id_superior =  $val;
	}

// **********************
// SELECT METHOD / LOAD
// **********************

	function select($id){

		$sql =  "SELECT * FROM empresa_cargo WHERE id = $id;";
		$row =  $this->query_($sql,1);


		$this->id = $row['id'];

		$this->id_empresa = $row['id_empresa'];

		$this->nivel = $row['nivel'];

		$this->nombre = $row['nombre'];

		$this->id_superior = $row['id_superior'];

	}

	function select_all($id){

		$sql =  "SELECT * FROM empresa_cargo WHERE id_empresa = $id order by nombre ASC;";
		return  $this->query_($sql);
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
		$sql = "DELETE FROM empresa_cargo WHERE id = $this->id;";
		$result = $this->query_($sql);

	}

	function delete_all($id){
		$sql = "DELETE FROM empresa_cargo WHERE id_empresa = $id;";
		$result = $this->query_($sql);

	}

// **********************
// INSERT
// **********************

	function insert(){

		$sql = "INSERT INTO empresa_cargo ( id_empresa,nivel,nombre,id_superior ) VALUES ( '$this->id_empresa','$this->nivel','$this->nombre','$this->id_superior' )";
		$result = $this->query_($sql);
		$this->id = mysqli_insert_id($this->link);

	}

// **********************
// UPDATE
// **********************

	function update(){



		$sql = " UPDATE empresa_cargo SET  nombre = '$this->nombre',id_superior = '$this->id_superior' WHERE id = $this->id ";

		$result = $this->query_($sql);



	}


  function get_select_options($id,$sel=null){
    $ctrl = new self();
    $result = $ctrl->select_all($id);
    foreach ($result as $key => $value) {
      $tmp = new self($value);
      $t = ($sel == $tmp->getId()) ? "selected" : "" ;
      echo "<option value='".$tmp->getId()."' ".$t." >".$tmp->getNombre()."</option>";
    }
  }

} // class : end

?>
 
