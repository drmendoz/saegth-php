<?php

class Riesgo_psicosocial extends Model{ 

	public $id;
	public $id_empresa;   
	public $segmentacion;   
	public $temas;   
	public $fecha;
	public $email;
	public $periodo;
	public $riesgos_compara;
	public $custom_email;

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

	function getSegmentacion(){
		return unserialize($this->segmentacion);
	}

	function getTemas(){
		return unserialize($this->temas);
	}

	function getFecha(){
		return $this->fecha;
	}
	function getEmail(){
		return $this->email;
	}

	function getPeriodo(){
		return $this->periodo;
	}

	function getRiesgosCompara(){
		return $this->riesgos_compara;
	}

	function getCustom_email(){
		return $this->custom_email;	
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

	function setSegmentacion($val){
			$this->segmentacion =  serialize($val);
	}

	function setTemas($val){
			$this->temas =  serialize($val);
	}

	function setFecha($val){
		$this->fecha =  $val;
	}
    
    function setEmail($val){
		$this->email =  $val;
	}

	function setPeriodo($val){
		$this->periodo =  $val;
	}

	function setRiesgosCompara($val){
		$this->riesgos_compara =  $val;
	}

	function setCustom_email($val){
		$this->custom_email = $val;
	}

// **********************
// SELECT METHOD / LOAD
// **********************

	function select($id){

		$sql =  "SELECT * FROM riesgo_psicosocial WHERE id_empresa = $id order by id desc limit 1";
		$row =  $this->query_($sql,1);
		if($row){
			$this->id = $row['id'];
			$this->id_empresa = $row['id_empresa'];
			$this->segmentacion = $row['segmentacion'];
			$this->temas = $row['temas'];
			$this->fecha = $row['fecha'];
			$this->email = $row['email'];
			$this->periodo = $row['periodo'];
			$this->custom_email = $row['custom_email'];
			return true;
		}
		return false;
	}

	function select_last(){
		$sql =  "SELECT * FROM riesgo_psicosocial WHERE id_empresa = $this->id_empresa AND id=(SELECT max(id) FROM riesgo_psicosocial WHERE id_empresa = $this->id_empresa);";
		$row =  $this->query_($sql,1);
		if($row){
			$this->id = $row['id'];
			$this->id_empresa = $row['id_empresa'];
			$this->segmentacion = $row['segmentacion'];
			$this->temas = $row['temas'];
			$this->fecha = $row['fecha'];
			$this->email = $row['email'];
			$this->periodo = $row['periodo'];
			$this->custom_email = $row['custom_email'];
			return true;
		}
		return false;
	}

	function select_x_id($id_e,$id_r){

		$sql =  "SELECT * FROM riesgo_psicosocial WHERE id_empresa = $id_e AND id=$id_r";
		$row =  $this->query_($sql,1);
		if($row){
			$this->id = $row['id'];
			$this->id_empresa = $row['id_empresa'];
			$this->segmentacion = $row['segmentacion'];
			$this->temas = $row['temas'];
			$this->fecha = $row['fecha'];
			$this->email = $row['email'];
			$this->periodo = $row['periodo'];
			$this->custom_email = $row['custom_email'];
			return true;
		}
		return false;
	}

	function select_compara($id_e,$riesgos = ''){

		$sql =  "SELECT * FROM riesgo_psicosocial WHERE id_empresa = $id_e and fecha != '' ";
		if($riesgos)
			$sql .= "AND id IN(".$riesgos.") ";
		$sql .= "ORDER BY id DESC ";//echo $sql;
		$row =  $this->query_($sql);
		$ids = "";
		if($row){
			$new_seg = array();

			foreach ($row as $campo => $value) {
				$segmentacion = unserialize($value['segmentacion']);
				$new_ids[] = $value['id'];
				$ids .= $value['id'].',';

				if (is_array($segmentacion)) {
					foreach ($segmentacion as $key => $seg) {
						if($clave=(array_search($seg,$new_seg)!== false)){
							continue;
						}else{
							$new_seg[$key] = $seg;
						}
					}
				}
			}

			$new_ids = array_unique($new_ids);

			if($ids != '')
				$ids = substr($ids, 0, -1);
			
			$this->id = $ids;
			$this->id_empresa = $id_e;
			$this->segmentacion = serialize($new_seg);
			$this->temas = '';
			$this->fecha = '';
			$this->email = '';
			$this->periodo = '';
			$this->riesgos_compara = $new_ids;
			return true;
		}
		return false;
	}

	function test_x_user($id_user){
		$sql = "SELECT id_test from riesgo_test_users WHERE id_user = $id_user";
		$row =  $this->query_($sql,1);
		if($row){
			$this->id = $row['id_test'];
		}
	}
	/*
	function select__(){
		$sql =  "SELECT * FROM riesgo_psicosocial WHERE id_empresa = $this->id_empresa AND id=(SELECT max(id) FROM riesgo_psicosocial WHERE id_empresa = $this->id_empresa);";
		$row =  $this->query_($sql,1);
		if($row){
			$this->id = $row['id'];
			$this->id_empresa = $row['id_empresa'];
			$this->segmentacion = $row['segmentacion'];
			$this->temas = $row['temas'];
			$this->fecha = $row['fecha'];
			$this->email = $row['email'];
			$this->periodo = $row['periodo'];
			return true;
		}
		return false;
	}

	function select_($id,$idt){

		$sql =  "SELECT * FROM riesgo_psicosocial WHERE id_empresa = $id AND id=$idt";
		$row =  $this->query_($sql,1);
		if($row){
			$this->id = $row['id'];
			$this->id_empresa = $row['id_empresa'];
			$this->segmentacion = $row['segmentacion'];
			$this->temas = $row['temas'];
			$this->fecha = $row['fecha'];
			$this->email = $row['email'];
			$this->periodo = $row['periodo'];
			return true;
		}
		return false;
	}
	*/

// **********************
// METHODS DML
// **********************
	function delete(){
		
		$sql = "DELETE FROM riesgo_psicosocial WHERE id = $id;";
		$result = $this->query_($sql);

	}

	function insert(){

		$sql = "INSERT INTO riesgo_psicosocial ( id_empresa,segmentacion,temas,fecha,email,periodo,custom_email ) VALUES ( '$this->id_empresa','$this->segmentacion','$this->temas','$this->fecha','$this->email','$this->periodo','$this->custom_email' )";
		$result = $this->query_($sql);
		$this->id = mysqli_insert_id($this->link);

	}

	function insert_test_user($id_user, $id_test){
		$sql = "INSERT INTO `riesgo_test_users` (`id_user`, `id_test`) VALUES ($id_user, $id_test) ";
		$result = $this->query_($sql);
	}

	function update(){

		$sql = " UPDATE riesgo_psicosocial SET  id_empresa = '$this->id_empresa',segmentacion = '$this->segmentacion',temas = '$this->temas',fecha = '$this->fecha', email = '$this->email', periodo = '$this->periodo' WHERE id = $id ";

		$result = $this->query_($sql);

	}

	function parseMonth($mes){
		switch ($mes) {
			case '01':
				return 'Ene';
				break;
			case '02':
				return 'Feb';
				break;
			case '03':
				return 'Mar';
				break;
			case '04':
				return 'Abr';
				break;
			case '05':
				return 'May';
				break;
			case '06':
				return 'Jun';
				break;
			case '07':
				return 'Jul';
				break;
			case '08':
				return 'Ago';
				break;
			case '09':
				return 'Sep';
				break;
			case '10':
				return 'Oct';
				break;
			case '11':
				return 'Nov';
				break;
			case '12':
				return 'Dic';
				break;
			default:
				return 'Ene';
				break;
		}
	}

	function get_fecha_x_id($id_e, $id){
		$sql = "SELECT fecha FROM riesgo_psicosocial WHERE id_empresa = ".$id_e." and id = ".$id;
		$row =  $this->query_($sql,1);
		$new_fecha = '';
		if($row){
			$fecha = $row['fecha'];
			$anio = substr($fecha, 0, 4);
			$mes = substr($fecha, 5, 2);
			$mes = $this->parseMonth($mes);
			$dia = substr($fecha, 8, 2);
			$new_fecha = $dia.'-'.$mes.'-'.$anio;
		}

		return $new_fecha;
	}

	function get_Riesgos_Empresa($id_e, $flag = '', $arrRiesgos = ''){
		$selected = '';
		$sql = "SELECT * FROM riesgo_psicosocial WHERE id_empresa = ".$id_e." and fecha != '' ";
		if ($flag != '') {
			$sql .= "and id <> (select max(id) from riesgo_psicosocial where id_empresa = ".$id_e.") ";
		}
		$sql .= "order by id desc";
		$ptr = $this->query_($sql);
		foreach ($ptr as $key => $value) {
			$fecha = $value['fecha'];
			$anio = substr($fecha, 0, 4);
			$mes = substr($fecha, 5, 2);
			$mes = $this->parseMonth($mes);
			$dia = substr($fecha, 8, 2);
			$new_fecha = $dia.'-'.$mes.'-'.$anio;

			if (isset($arrRiesgos)) {
				if (in_array($value['id'], $arrRiesgos))
					$selected = 'selected';
				else
					$selected = '';
			}

			echo "<option value='".$value['id']."' ".$selected.">".$new_fecha."</option>";
		}
	}


} 

?>