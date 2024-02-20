<?php

// **********************
// CLASS DECLARATION
// **********************

class rp_user extends Model{ 
	// class : begin


	// **********************
	// ATTRIBUTE DECLARATION
	// **********************


	public $user_name;   
	public $password;   
	public $id_empresa;   
	public $id_test;   
	public $edad;   
	public $antiguedad;   
	public $localidad;   
	public $departamento;   
	public $norg;   
	public $tcont;   
	public $educacion;   
	public $sexo;   
	public $hijos;   



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

	function getUser_name(){
	return $this->user_name;
	}

	function getPassword(){
	return $this->password;
	}

	function getId_empresa(){
	return $this->id_empresa;
	}

	function getId_test(){
	return $this->id_test;
	}

	function getEdad(){
	return $this->edad;
	}

	function getAntiguedad(){
	return $this->antiguedad;
	}

	function getLocalidad(){
	return $this->localidad;
	}

	function getDepartamento(){
	return $this->departamento;
	}

	function getNorg(){
	return $this->norg;
	}

	function getTcont(){
	return $this->tcont;
	}

	function getEducacion(){
	return $this->educacion;
	}

	function getSexo(){
	return $this->sexo;
	}

	function getHijos(){
	return $this->hijos;
	}

	// **********************
	// SETTER METHODS
	// **********************


	function setId($val){
	$this->id =  $val;
	}

	function setUser_name($val){
	$this->user_name =  $val;
	}

	function setPassword($val){
	$this->password =  $val;
	}

	function setId_empresa($val){
	$this->id_empresa =  $val;
	}

	function setId_test($val){
	$this->id_test =  $val;
	}

	function setEdad($val){
	$this->edad =  $val;
	}

	function setAntiguedad($val){
	$this->antiguedad =  $val;
	}

	function setLocalidad($val){
	$this->localidad =  $val;
	}

	function setDepartamento($val){
	$this->departamento =  $val;
	}

	function setNorg($val){
	$this->norg =  $val;
	}

	function setTcont($val){
	$this->tcont =  $val;
	}

	function setEducacion($val){
	$this->educacion =  $val;
	}

	function setSexo($val){
	$this->sexo =  $val;
	}

	function setHijos($val){
	$this->hijos =  $val;
	}

	// **********************
	// SELECT METHOD / LOAD
	// **********************

	function select($id){

	$sql =  "SELECT * FROM rp_users WHERE id = $id;";
	$row =  $this->query_($sql,1);


	$this->id = $row['id'];

	$this->user_name = $row['user_name'];

	$this->password = $row['password'];

	$this->id_empresa = $row['id_empresa'];
	$this->id_test = $row['id_test'];

	$this->edad = $row['edad'];

	$this->antiguedad = $row['antiguedad'];

	$this->localidad = $row['localidad'];

	$this->departamento = $row['departamento'];

	$this->norg = $row['norg'];

	$this->tcont = $row['tcont'];

	$this->educacion = $row['educacion'];

	$this->sexo = $row['sexo'];
	$this->hijos = $row['hijos'];

	}

	// **********************
	// DELETE
	// **********************

	function delete(){
	$sql = "DELETE FROM rp_users WHERE id = $id;";
	$result = $this->query_($sql);

	}

	// **********************
	// INSERT
	// **********************

	function insert(){

	$sql = "INSERT INTO rp_users ( user_name,password,id_empresa,id_test,edad,antiguedad,localidad,departamento,norg,tcont,educacion,sexo,hijos ) VALUES ( '$this->user_name','$this->password','$this->id_empresa','$this->id_test','$this->edad','$this->antiguedad','$this->localidad','$this->departamento','$this->norg','$this->tcont','$this->educacion','$this->sexo','$this->hijos' )";
	$result = $this->query_($sql);
	$this->id = mysqli_insert_id($this->link);

	}

	function getQuery($q){
	if($q='insert')
		$sql = "INSERT INTO rp_users ( user_name,password,id_empresa,id_test,edad,antiguedad,localidad,departamento,norg,tcont,educacion,sexo,hijos ) VALUES ( '$this->user_name','$this->password','$this->id_empresa','$this->id_test','$this->edad','$this->antiguedad','$this->localidad','$this->departamento','$this->norg','$this->tcont','$this->educacion','$this->sexo','$this->hijos' )";

	$sql .= "<br>";
	echo $sql;

	}

	// **********************
	// UPDATE
	// **********************

	function update(){



	$sql = " UPDATE rp_users SET  user_name = '$this->user_name',password = '$this->password',id_empresa = '$this->id_empresa',id_test = '$this->id_test',edad = '$this->edad',antiguedad = '$this->antiguedad',localidad = '$this->localidad',departamento = '$this->departamento',norg = '$this->norg',tcont = '$this->tcont',educacion = '$this->educacion',sexo = '$this->sexo',hijos = '$this->hijos' WHERE id = $this->id ";

	$result = $this->query_($sql);



	}

	// **********************
	// CUSTOM METHODS
	// **********************

	function get_id_x_empresa($id_e,$args=""){
		if($args != "")
			$args = implode("", $args);
		$sql =  "SELECT id FROM $this->_table WHERE id_empresa=$id_e ".$args;
		// echo $sql."->";
		$row = $this->query_($sql);
		$this->id_empresa = $id_e;
		$result = array();
		foreach ($row as $key => $value) {
			array_push($result, $value['id']);
		}
		return implode(",", $result);
	}

	function get_id_x_riesgo($args="", $id_s){
		if($args != "")
			$args = implode(" ", $args);

		$sql = "SELECT id ";
		$sql .= "FROM $this->_table ";
		$sql .= "WHERE id_test = $id_s ";
		$sql .= $args;
		//echo $sql;
		$row = $this->query_($sql);
		$result = array();
		foreach ($row as $key => $value) {
			array_push($result, $value['id']);
		}
		return implode(",", $result);
	}

	function get_id_x_segmentacion($id_e, $riesgo, $campo, $valor){
		$sql = "SELECT u.id ";
		$sql .= "FROM rp_users u, riesgo_psicosocial s ";
		$sql .= "WHERE u.id_empresa = s.id_empresa ";
		$sql .= "AND s.id = u.id_test ";
		$sql .= "AND s.id_empresa = $id_e ";
		$sql .= "AND s.id = $riesgo ";
		if($campo != 'departamento'){
			$sql .= "AND u.$campo = $valor ";
		}else{
			$sql .= "AND (u.$campo = $valor 
			or
			u.$campo in(	SELECT e.id
								FROM empresa_area e 
								WHERE e.id_superior = $valor)
			) ";
		}
		//echo "$sql<br>";
		$this->id_empresa = $id_e;
		$row = $this->query_($sql);
		$result = array();
		foreach ($row as $cont => $arrDatos) {
			$ids = $arrDatos['id'];
			array_push($result, $ids);
		}

		return implode(",", $result);
	}

	function get_evaluados($args="", $id_s="", $flag=""){
		if($args != "")
			$args = implode(" ", $args);
		
		if(!$flag){
			$sql =  "SELECT count(id) as count ";
			$sql .= "FROM $this->_table ";
			$sql .= "WHERE id_test = ".$id_s." ";
		}else{
			$sql =  "SELECT count(id) as count ";
			$sql .= "FROM $this->_table ";
			$sql .= "WHERE id_test IN(".$id_s.") ";
		}
		
		$sql .= $args;
		//echo $sql;
		$row = $this->query_($sql,1);
		return $row['count'];
	}
} // class : end

?>