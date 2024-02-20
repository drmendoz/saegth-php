<?php
	class Evaluacion_desempenio_user extends Model{

		public $user_name;   
		public $password;   
		public $id_personal;
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
		public $tipo_test;



		public function __construct($parameters = array()) {
			parent::__construct();
			foreach($parameters as $key => $value) {
				$this->$key = $value;
			}
		}


		function getId(){
			return $this->id;
		}

		function getUser_name(){
			return $this->user_name;
		}

		function getPassword(){
			return $this->password;
		}
		
		function getIdPersonal(){
			return $this->id_personal;
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

		function getTipoTest(){
			return $this->tipo_test;
		}




		function setId($val){
			$this->id =  $val;
		}

		function setUser_name($val){
			$this->user_name =  $val;
		}

		function setPassword($val){
			$this->password =  $val;
		}
		
		function setIdPersonal($val){
			$this->id_personal =  $val;
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

		function setTipoTest($val){
			$this->tipo_test =  $val;
		}




		function select($id){

			$sql =  "SELECT * FROM evaluacion_desempenio_users WHERE id = $id;";
			$row =  $this->query_($sql,1);


			$this->id = $row['id'];

			$this->user_name = $row['user_name'];

			$this->password = $row['password'];
			
			$this->id_personal = $row['id_personal'];

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

			$this->tipo_test = $row['tipo_test'];

		}

		function delete(){
			$sql = "DELETE FROM evaluacion_desempenio_users WHERE id = $id;";
			$result = $this->query_($sql);
		}

		function insert(){

			$sql = "INSERT INTO evaluacion_desempenio_users ( user_name,password,id_personal,id_empresa,id_test,edad,antiguedad,localidad,departamento,norg,tcont,educacion,sexo,tipo_test ) VALUES ( '$this->user_name','$this->password','$this->id_personal','$this->id_empresa','$this->id_test','$this->edad','$this->antiguedad','$this->localidad','$this->departamento','$this->norg','$this->tcont','$this->educacion','$this->sexo','$this->tipo_test' )";
			$result = $this->query_($sql);
			$this->id = mysqli_insert_id($this->link);

		}

		function update(){

			$sql = " UPDATE evaluacion_desempenio_users SET  user_name = '$this->user_name',password = '$this->password',id_personal = '$this->id_personal',id_empresa = '$this->id_empresa',id_test = '$this->id_test',edad = '$this->edad',antiguedad = '$this->antiguedad',localidad = '$this->localidad',departamento = '$this->departamento',norg = '$this->norg',tcont = '$this->tcont',educacion = '$this->educacion',sexo = '$this->sexo',tipo_test = '$this->tipo_test' WHERE id = $id ";

			$result = $this->query_($sql);

		}

		function get_id_x_empresa($id_s='', $id_e,$args=""){
			if($args != "")
				$args = implode("", $args);
			//$sql =  "SELECT id FROM $this->_table WHERE id_empresa=$id_e ".$args;
			$sql = "SELECT id ";
			$sql .= "FROM $this->_table ";
			$sql .= "WHERE id_empresa = $id_e ";
			if(!$id_s)
				$sql .= "AND id_test = (SELECT MAX(id) FROM evaluacion_desempenio_definicion WHERE id_empresa = $id_e) ";
			else
				$sql .= "AND id_test = $id_s ";
			$sql .= $args;
			//echo $sql;
			$this->id_empresa = $id_e;
			$row = $this->query_($sql);
			$result = array();

			if (is_array($row)) {
				foreach ($row as $key => $value) {
					array_push($result, $value['id']);
				}
			}
			return implode(",", $result);
		}

		function count_evaluados($args=""){
			if($args != "")
				$args = implode("", $args);
			//$sql =  "SELECT count(id) as count FROM $this->_table WHERE id_empresa=$this->id_empresa ".$args;
			$sql =  "SELECT count(id) as count ";
			$sql .= "FROM $this->_table ";
			$sql .= "WHERE id_empresa=$this->id_empresa ";
			$sql .= "AND id_test = (SELECT MAX(id) FROM evaluacion_desempenio_definicion WHERE id_empresa = ".$_SESSION['Empresa']['id'].") ";
			$sql .= $args;
			// echo $sql;
			$row = $this->query_($sql,1);
			return $row['count'];
		}

		function get_evaluados($args="", $id_s="", $flag=""){
			if($args != "")
				$args = implode("", $args);
			
			if(!$flag){
				$sql =  "SELECT count(id) as count ";
				$sql .= "FROM $this->_table ";
				$sql .= "WHERE id_empresa=$this->id_empresa ";
				$sql .= "AND id_test = ".$id_s;
			}else{
				$sql =  "SELECT count(id) as count ";
				$sql .= "FROM $this->_table ";
				$sql .= "WHERE id_empresa=".$_SESSION['Empresa']['id'].' ';
				$sql .= "AND id_test IN(".$id_s.")";
			}
			
			$sql .= $args;
			//echo $sql;
			$row = $this->query_($sql,1);
			return $row['count'];
		}
	}
?>