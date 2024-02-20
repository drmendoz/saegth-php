<?php

class Sonda extends Model {
// **********************
// CLASS DECLARATION
// **********************


// **********************
// ATTRIBUTE DECLARATION
// **********************


		public $id;   
		public $id_empresa;   
		public $segmentacion;   
		public $temas;   
		public $fecha;
		public $email;
		public $periodo;
		public $sondas_compara;
		public $custom_email;
		public $foda;



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
			return $this->print_fecha($this->fecha);
		}

		function getEmail(){
			return $this->email;
		}

		function getPeriodo(){
			return $this->periodo;
		}

		function getSondasCompara(){
			return $this->sondas_compara;
		}

		function getCustom_email(){
			return $this->custom_email;	
		}

		function getFoda(){
			return $this->foda;	
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

		function setSondasCompara($val){
			$this->sondas_compara =  $val;
		}

		function setCustom_email($val){
			$this->custom_email = $val;
		}

		function setFoda($val){
			$this->foda = $val;
		}

// **********************
// SELECT METHOD / LOAD
// **********************

		function select($id){

			//$sql =  "SELECT * FROM sonda WHERE id_empresa = $id";
			$sql =  "SELECT * FROM sonda WHERE id_empresa = $id order by id desc limit 1";
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
				$this->foda = $row['foda'];
				return true;
			}
			return false;
		}
		function select__(){

			$sql =  "SELECT * FROM sonda WHERE id_empresa = $this->id_empresa AND id=(SELECT max(id) FROM sonda WHERE id_empresa = $this->id_empresa);";
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
				$this->foda = $row['foda'];
				return true;
			}
			return false;
		}
		
		function select_($id,$idt){

			$sql =  "SELECT * FROM sonda WHERE id_empresa = $id AND id=$idt";
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
				$this->foda = $row['foda'];
				return true;
			}
			return false;
		}

		function select_compara($id_e,$sondas = ''){

			$sql =  "SELECT * FROM sonda WHERE id_empresa = $id_e and fecha != '' ";
			if($sondas)
				$sql .= "AND id IN(".$sondas.") ";
			$sql .= "ORDER BY fecha ";//echo $sql;
			$row =  $this->query_($sql);
			$ids = "";
			if($row){
				$new_seg = array();
				$new_temas = array();

				foreach ($row as $campo => $value) {
					$segmentacion = unserialize($value['segmentacion']);
					$temas = unserialize($value['temas']);
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

					if (is_array($temas)) {
						foreach ($temas as $cod_temas => $arrTemas) {
							if (is_array($arrTemas)) {
								if (array_key_exists($cod_temas, $new_temas)) {
									$arrOri = null;
									foreach ($arrTemas as $cont => $cod_pregunta) {
										$arrOri[] = $cod_pregunta;
									}

									foreach ($new_temas[$cod_temas] as $new_cont => $new_cod_preg) {
										$arrOri[] = $new_cod_preg;
									}

									if(is_array($arrOri)){
										$arrOri = array_unique($arrOri);
										sort($arrOri);
										$new_temas[$cod_temas] = $arrOri;
									}
								}else{
									$new_temas[$cod_temas] = $arrTemas;
								}
							}else{
								$new_temas[$cod_temas] = array();
							}
						}
					}
				}

				$new_ids= array_unique($new_ids);

				if($ids != '')
					$ids = substr($ids, 0, -1);
				
				$this->id = $ids;
				$this->id_empresa = $value['id_empresa'];
				$this->segmentacion = serialize($new_seg);
				$this->temas = serialize($new_temas);
				$this->fecha = '';
				$this->email = '';
				$this->periodo = '';
				$this->sondas_compara = $new_ids;
				return true;
			}
			return false;
		}
		
		function count_evaluados(){

			$sql =  "SELECT count(id) as count FROM sonda WHERE id_empresa = $id";
			$row =  $this->query_($sql,1);
			return $row['count'];
		}

		function get_fecha_x_id($id_e, $id){
			$sql = "SELECT fecha FROM sonda WHERE id_empresa = ".$id_e." and id = ".$id;
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

		function test_x_user($id_user){
			$sql = "SELECT id_test from sonda_test_users WHERE id_user = $id_user";
			$row =  $this->query_($sql,1);
			if($row){
				$this->id = $row['id_test'];
			}
		}

// **********************
// DELETE
// **********************

		function delete(){
			$sql = "DELETE FROM sonda WHERE id = $id;";
			$result = $this->query_($sql);

		}

// **********************
// INSERT
// **********************

		function insert(){

			//$sql = "INSERT INTO sonda ( id_empresa,segmentacion,temas,fecha ) VALUES ( '$this->id_empresa','$this->segmentacion','$this->temas','$this->fecha' )";
			$sql = "INSERT INTO sonda ( id_empresa,segmentacion,temas,fecha,email,periodo,custom_email,foda ) VALUES ( '$this->id_empresa','$this->segmentacion','$this->temas','$this->fecha','$this->email','$this->periodo','$this->custom_email', '$this->foda' )";
			$result = $this->query_($sql);
			$this->id = mysqli_insert_id($this->link);

		}

		function insert_test_user($id_user, $id_test){
			$sql = "INSERT INTO `sonda_test_users` (`id_user`, `id_test`,`email_enviado`) VALUES ($id_user, $id_test,0) ";
			$result = $this->query_($sql);
		}

// **********************
// UPDATE
// **********************

		function update(){
			
			//$sql = " UPDATE sonda SET  id_empresa = '$this->id_empresa',segmentacion = '$this->segmentacion',temas = '$this->temas',fecha = '$this->fecha' WHERE id = $this->id ";
			$sql = " UPDATE sonda SET  id_empresa = '$this->id_empresa',segmentacion = '$this->segmentacion',temas = '$this->temas',fecha = '$this->fecha', email = '$this->email', periodo = '$this->periodo', custom_email = '$this->custom_email', foda = '$this->foda' WHERE id = $this->id ";
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

		function get_Sondas_Empresa($id_e, $flag = '', $arrSondas = ''){
			$selected = '';
			$sql = "SELECT * FROM sonda WHERE id_empresa = ".$id_e." and fecha != '' ";
			if ($flag != '') {
				$sql .= "and id <> (select max(id) from sonda where id_empresa = ".$id_e.") ";
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

				if (isset($arrSondas) && is_array($arrSondas)) {
					if (in_array($value['id'], $arrSondas))
						$selected = 'selected';
					else
						$selected = '';
				}

				echo "<option value='".$value['id']."' ".$selected.">".$new_fecha."</option>";
			}
		}
	}
?>