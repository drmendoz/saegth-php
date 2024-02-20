<?php

// **********************
// CLASS DECLARATION
// **********************

class sonda_tema extends Model{ 
	// class : begin


	// **********************
	// ATTRIBUTE DECLARATION
	// **********************


	public $id;   
	public $tema;   
	public $descripcion;   
	public $preguntas;
	public $activo;



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

	function getTema(){
		return $this->htmlprnt($this->tema);
	}

	function getDescripcion(){
		return $this->htmlprnt($this->descripcion);
	}
	function getTema_(){
		return $this->htmlprnt_win($this->tema);
	}

	function getDescripcion_(){
		return $this->htmlprnt_win($this->descripcion);
	}

	function getPreguntas(){
		return $this->preguntas;
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

	function setTema($val){
		$this->tema =  $val;
	}

	function setDescripcion($val){
		$this->descripcion =  $val;
	}

	function setPreguntas($val){
		$this->preguntas =  $val;
	}

	function setActivo($val){
		$this->activo =  $val;
	}

	// **********************
	// SELECT METHOD / LOAD
	// **********************

	function select($id=false){
		if(!$id)
			$id = $this->id;
		$sql =  "SELECT * FROM $this->_table WHERE  id= $id;";
		$row =  $this->query_($sql,1);


		$this->id = $row['id'];

		$this->tema = $row['tema'];

		$this->descripcion = $row['descripcion'];

		$this->preguntas = $row['preguntas'];

		$this->activo = $row['activo'];

	}

	function select_all(){

		$sql =  "SELECT id FROM $this->_table WHERE activo = 1 ";
		$row = $this->query_($sql);
		$result = array();
		foreach ($row as $key => $value) {
			$tmp = new self();
			$tmp->select($value['id']);
			array_push($result, $tmp);
		}
		return $result;
	}
	function select_all_(){

		$sql =  "SELECT id,tema FROM $this->_table WHERE activo = 1 ";
		return $this->query_($sql);
	}

	// **********************
	// DELETE
	// **********************

	function delete(){
		$sql = "DELETE FROM $this->_table WHERE  id= $id;";
		$result = $this->query_($sql);

	}

	// **********************
	// INSERT
	// **********************

	function insert(){

		$sql = "INSERT INTO $this->_table (tema,descripcion,preguntas ) VALUES ('$this->tema','$this->descripcion','$this->preguntas' )";
		$result = $this->query_($sql);
		$this->id = mysqli_insert_id($this->link);

	}

	// **********************
	// UPDATE
	// **********************

	function update(){

		$sql = " UPDATE $this->_table SET  id = '$this->id',tema = '$this->tema',descripcion = '$this->descripcion',preguntas = '$this->preguntas' WHERE id = $this->id ";

		$result = $this->query_($sql);

	}

	function activa_inactiva(){
		$sql = "UPDATE $this->_table SET activo = '$this->activo' WHERE id = $this->id ";echo "$sql";

		$result = $this->query_($sql);
	}

	//
	function get_Temas($id_s, $arrTemas = ''){
		$sonda = new Sonda();
		$x = new Sonda_tema();
		$sonda->select_($_SESSION['Empresa']['id'], $id_s);
		$temas = $sonda->getTemas();
		$selected = '';

		if (is_array($temas)) {
			foreach ($temas as $key => $value) {
				$x->select($key);
				$tema_nombre = ucfirst($x->getTema());
				$tema_id = $x->getId();

				if (isset($arrTemas) && is_array($arrTemas)) {
					if (in_array($tema_id, $arrTemas))
						$selected = 'selected';
					else
						$selected = '';
				}

				echo "<option value='".$tema_id."' ".$selected.">".$tema_nombre."</option>";
			}
		}
	}
} // class : end

?>