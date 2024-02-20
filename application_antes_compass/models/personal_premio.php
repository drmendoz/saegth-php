<?php

// **********************
// CLASS DECLARATION
// **********************

class personal_premio extends Model{ 

// **********************
// ATTRIBUTE DECLARATION
// **********************


	public $id_personal;   
	public $premio;   
	public $institucion;   
	public $item;   
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

	public function cast($parameters = array()) {
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

	function getPremio(){
		return $this->htmlprnt($this->premio);
	}

	function getInstitucion(){
		return $this->htmlprnt($this->institucion);
	}

	function getPremio_(){
		return $this->htmlprnt_win($this->premio);
	}

	function getInstitucion_(){
		return $this->htmlprnt_win($this->institucion);
	}

	function getItem(){
		return $this->htmlprnt($this->item);
	}

	function getItem_(){
		return $this->htmlprnt_win($this->item);
	}

	function getFecha(){
		return $this->fecha;
	}

	function getFecha_(){
		return $this->htmlprnt(strftime("%d de %B del %Y",strtotime($this->getFecha())));
	}

// **********************
// SETTER METHODS
// **********************


	function setId($val){
		$this->id =  $val;
		return $this;
	}

	function setId_personal($val){
		$this->id_personal =  $val;
		return $this;
	}

	function setPremio($val){
		$this->premio =  $val;
		return $this;
	}

	function setInstitucion($val){
		$this->institucion =  $val;
		return $this;
	}

	function setItem($val){
		$this->item =  $val;
		return $this;
	}

	function setFecha($val){
		$this->fecha =  $val;
		return $this;
	}

// **********************
// SELECT METHOD / LOAD
// **********************

	function select($id){

		$sql =  "SELECT * FROM personal_premio WHERE id = $id;";
		$row =  $this->query_($sql,1);

		$this->id = $row['id'];
		$this->id_personal = $row['id_personal'];
		$this->premio = $row['premio'];
		$this->institucion = $row['institucion'];
		$this->item = $row['item'];
		$this->fecha = $row['fecha'];

	}

	function select_all($id_p=null){
		$ext = (isset($id_p)) ? $id_p : $_SESSION['USER-AD']['id_personal'] ;
		$sql =  "SELECT * FROM personal_premio WHERE id_personal = ".$ext.";";
		return  $this->query_($sql);
	}

// **********************
// DELETE
// **********************

	function delete(){
		$sql = "DELETE FROM personal_premio WHERE id = $id;";
		$result = $this->query_($sql);

	}

// **********************
// INSERT
// **********************

	function insert(){

		$sql = "INSERT INTO personal_premio ( id_personal,premio,institucion,item,fecha ) VALUES ( '$this->id_personal','$this->premio','$this->institucion','$this->item','$this->fecha' )";
		$result = $this->query_($sql);
		$this->id = mysqli_insert_id($this->link);

	}

// **********************
// UPDATE
// **********************

	function update(){
		$sql = " UPDATE personal_premio SET  id_personal = '$this->id_personal',premio = '$this->premio',institucion = '$this->institucion',item = '$this->item',fecha = '$this->fecha' WHERE id = $id ";
		$result = $this->query_($sql);
	}

}
?>