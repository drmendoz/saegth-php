<?php

class Sonda_user extends Model{ 


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

	function select($id){

		$sql =  "SELECT * FROM sonda_users WHERE id = $id;";
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

	}


	function delete(){
		$sql = "DELETE FROM sonda_users WHERE id = $id;";
		$result = $this->query_($sql);

	}

	function insert(){

		$sql = "INSERT INTO sonda_users ( user_name,password,id_personal,id_empresa,id_test,edad,antiguedad,localidad,departamento,norg,tcont,educacion,sexo ) VALUES ( '$this->user_name','$this->password','$this->id_personal','$this->id_empresa','$this->id_test','$this->edad','$this->antiguedad','$this->localidad','$this->departamento','$this->norg','$this->tcont','$this->educacion','$this->sexo' )";
		$result = $this->query_($sql);
		$this->id = mysqli_insert_id($this->link);

	}


	function update(){



		$sql = " UPDATE sonda_users SET  user_name = '$this->user_name',password = '$this->password',id_personal = '$this->id_personal',id_empresa = '$this->id_empresa',id_test = '$this->id_test',edad = '$this->edad',antiguedad = '$this->antiguedad',localidad = '$this->localidad',departamento = '$this->departamento',norg = '$this->norg',tcont = '$this->tcont',educacion = '$this->educacion',sexo = '$this->sexo' WHERE id = $id ";

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
			$sql .= "AND id_test = (SELECT MAX(id) FROM sonda WHERE id_empresa = $id_e) ";
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

	function get_id_compara($id_e, $sondas, $tema="", $args=""){
		if($args != "")
			$args = implode("", $args);

		$sql = "SELECT u.id, s.segmentacion, s.temas ";
		$sql .= "FROM $this->_table u, sonda s ";
		$sql .= "WHERE u.id_empresa = s.id_empresa ";
		$sql .= "AND s.id = u.id_test ";
		$sql .= "AND u.id_test IN(	SELECT id 
									FROM sonda 
									WHERE id_empresa = $id_e 
									AND `id` IN ($sondas)) ";
		$sql .= "AND s.id_empresa = $id_e ";
		$sql .= $args;

		//echo "$sql<br>";
		$this->id_empresa = $id_e;
		$row = $this->query_($sql);
		$result = array();
		foreach ($row as $cont => $arrDatos) {
			$ids = $arrDatos['id'];
			$segmentacion = unserialize($arrDatos['segmentacion']);
			$temas = unserialize($arrDatos['temas']);

			if (is_array($temas)) {
				if($tema){
					if (array_key_exists($tema, $temas)) {
						array_push($result, $ids);
					}
				}else{
					array_push($result, $ids);
				}
			}
		}

		return implode(",", $result);
	}

	function get_id_x_segmentacion($id_e, $sonda, $tema, $campo, $valor){
		$sql = "SELECT u.id, s.segmentacion, s.temas ";
		$sql .= "FROM sonda_users u, sonda s ";
		$sql .= "WHERE u.id_empresa = s.id_empresa ";
		$sql .= "AND s.id = u.id_test ";
		$sql .= "AND s.id_empresa = $id_e ";
		$sql .= "AND s.id = $sonda ";
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
			$segmentacion = unserialize($arrDatos['segmentacion']);
			$temas = unserialize($arrDatos['temas']);

			if (is_array($temas)) {
				if($tema){
					if (array_key_exists($tema, $temas)) {
						array_push($result, $ids);
					}
				}else{
					array_push($result, $ids);
				}
			}
		}

		return implode(",", $result);
	}

	function get_id_x_sonda($args="", $id_e, $id_s){
		if($args != "")
			$args = implode("", $args);

		$sql = "SELECT id ";
		$sql .= "FROM $this->_table ";
		$sql .= "WHERE id_empresa = $id_e ";
		$sql .= "AND id_test = $id_s ";
		$sql .= $args;
		//echo $sql;
		$this->id_empresa = $id_e;
		$row = $this->query_($sql);
		$result = array();
		foreach ($row as $key => $value) {
			array_push($result, $value['id']);
		}
		return implode(",", $result);
	}

	function get_id_x_et($id_e,$id_t){
		$sql =  "SELECT id FROM $this->_table WHERE id_empresa=$id_e";
		$row = $this->query_($sql);
		$result = array();
		foreach ($row as $key => $value) {
			array_push($result, $value['id']);
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
		$sql .= "AND id_test = (SELECT MAX(id) FROM sonda WHERE id_empresa = ".$_SESSION['Empresa']['id'].") ";
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

	function getEvaluadosCompletadosEncuenta($id_s)
	{
		$sql = 	"SELECT id_personal ";
		$sql .= "FROM $this->_table ";
		$sql .= "WHERE id_empresa=$this->id_empresa ";
		$sql .= "AND id_test = ".$id_s;

		$row = $this->query_($sql);
		$result = array();
		foreach ($row as $key => $value) {
			array_push($result, $value['id_personal']);
		}
		return $result;
	}

	function credencialesSondaTemporal($id_personal, $id_test, $tipo_sonda)
	{
		if ($tipo_sonda == 'Sonda')
			$user_rol = 8;
		else
			$user_rol = 12;

		$sql =  "SELECT p.id, p.nombre_p, u.user_name, u.password, u.token ";
		$sql .= "FROM personal p
		        INNER JOIN users u ON(u.id_personal = p.id)
		        INNER JOIN sonda_test_users st ON(st.id_user = u.id) ";
		$sql .= "WHERE p.id_empresa = ".$_SESSION['Empresa']['id']." ";
		$sql .= "AND p.activo = 1 ";
		$sql .= "AND u.user_rol = $user_rol ";
		$sql .= "AND p.id = $id_personal ";
		$sql .= "AND st.id_test = $id_test ";

		$result = $this->query_($sql,1);
		return $result;
	}
	
	function comentariosFODA($id_test)
	{
		$sql = 	"SELECT * ";
		$sql .= "FROM sonda_users_foda ";
		$sql .= "WHERE id_test = $id_test ";
		$sql .= "ORDER BY id";

		$result = $this->query_($sql);
		$new_result = "";

		foreach ($result as $key => $value) {
			if ($value['tipo'] == 'F') {
				$new_result['FORTALEZAS'][$key] = $this->htmlprnt_win($value['comentario']);
			}
			else if ($value['tipo'] == 'O') {
				$new_result['OPORTUNIDADES'][$key] = $this->htmlprnt_win($value['comentario']);
			}
			else if ($value['tipo'] == 'D') {
				$new_result['DEBILIDADES'][$key] = $this->htmlprnt_win($value['comentario']);
			}
			else{
				$new_result['AMENAZAS'][$key] = $this->htmlprnt_win($value['comentario']);
			}
		}

		return $new_result;
	}
} 	
?>