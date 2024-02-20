<?php

// **********************
// CLASS DECLARATION
// **********************

class multifuente_evaluado extends Model{ 

// **********************
// ATTRIBUTE DECLARATION
// **********************


	public $id_personal;   
	public $cod_evaluado;   
	public $cod_test;   
	public $fecha;   
	public $fecha_max;   
	public $id_empresa;   
	public $relacion;   
	public $resuelto;   
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

	function getCod_evaluado(){
		return $this->cod_evaluado;
	}

	function getCod_test(){
		return $this->cod_test;
	}

	function getFecha(){
		return $this->fecha;
	}

	function getFecha_max(){
		return $this->fecha_max;
	}

	function getId_empresa(){
		return $this->id_empresa;
	}

	function getRelacion(){
		return $this->relacion;
	}

	function getResuelto(){
		return $this->resuelto;
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

	function setCod_evaluado($val){
		$this->cod_evaluado =  $val;
	}

	function setCod_test($val){
		$this->cod_test =  $val;
	}

	function setFecha($val){
		$this->fecha =  $val;
	}

	function setFecha_max($val){
		$this->fecha_max =  $val;
	}

	function setId_empresa($val){
		$this->id_empresa =  $val;
	}

	function setRelacion($val){
		$this->relacion =  $val;
	}

	function setResuelto($val){
		$this->resuelto =  $val;
	}

// **********************
// SELECT METHOD / LOAD
// **********************

	function select($id){

		$sql =  "SELECT * FROM multifuente_evaluado WHERE id = $id;";
		$row =  $this->query_($sql,1);


		$this->id = $row['id'];

		$this->id_personal = $row['id_personal'];

		$this->cod_evaluado = $row['cod_evaluado'];

		$this->cod_test = $row['cod_test'];

		$this->fecha = $row['fecha'];

		$this->fecha_max = $row['fecha_max'];

		$this->id_empresa = $row['id_empresa'];

		$this->relacion = $row['relacion'];

		$this->resuelto = $row['resuelto'];

	}

	function getCodEvaluados($test){
		$sql = "SELECT cod_evaluado FROM multifuente_evaluado WHERE cod_test=\"$test\"";
		return $this->query_($sql);
	}

	function getByEmpresa($id){
		$sql = "SELECT id_personal, cod_evaluado FROM multifuente_evaluado WHERE id_empresa=$id";
		return $this->query_($sql);
	}
	
	function getLastCodEvaluado($id_personal,$test,$periodo_evaluador){
		$sql = "SELECT cod_evaluado FROM multifuente_evaluado WHERE id_personal = $id_personal AND cod_test=\"$test\" AND periodo_evaluador = ".$periodo_evaluador." LIMIT 1";
		return $this->query_($sql,1);
	}

// **********************
// DELETE
// **********************

	function delete(){
		$sql = "DELETE FROM multifuente_evaluado WHERE id = $id;";
		$result = $this->query_($sql);

	}

// **********************
// INSERT
// **********************

	function insert(){

		$sql = "INSERT INTO multifuente_evaluado ( id_personal,cod_evaluado,cod_test,fecha,fecha_max,id_empresa,relacion,resuelto ) VALUES ( '$this->id_personal','$this->cod_evaluado','$this->cod_test','$this->fecha','$this->fecha_max','$this->id_empresa','$this->relacion','$this->resuelto' )";
		$result = $this->query_($sql);
		$this->id = mysqli_insert_id($this->link);

	}

// **********************
// UPDATE
// **********************

	function update(){
		$sql = " UPDATE multifuente_evaluado SET  id_personal = '$this->id_personal',cod_evaluado = '$this->cod_evaluado',cod_test = '$this->cod_test',fecha = '$this->fecha',fecha_max = '$this->fecha_max',id_empresa = '$this->id_empresa',relacion = '$this->relacion',resuelto = '$this->resuelto' WHERE id = $id ";
		$result = $this->query_($sql);
	}

}
?>
