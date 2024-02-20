<?php

class Rendimiento extends Model {
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
		public $args;
		public $arrIds;
		public $new_ids;
		public $min_avg;
		public $arrDatos;

		/** 20170101 CTP
		 *	Filtros de segmentación.
		*/
		public $criterios;
		public $evaluados;
		public $departamento = array();
		public $edad = array();
		public $antiguedad = array();
		public $localidad = array();
		public $norg = array();
		public $tcont = array();
		public $educacion = array();
		public $sexo = array();
		public $idspreguntas = array("ids" => null, "preguntas" => null);
		public $filtros = array(
			"departamento" => array(),
			"edad" => array(),
			"antiguedad" => array(),
			"localidad" => array(),
			"norg" => array(),
			"tcont" => array(),
			"educacion" => array(),
			"sexo" => array()
		);

		//******************************************



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

		function getArgs(){
			return $this->args;
		}

		/** 20170101 CTP
		 * Obtener valores de los filtros.
		*/
		function getDepartamento(){
			return $this->departamento;
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

		function getIdsPreguntas(){
			return $this->idspreguntas;
		}

		function getCriterios(){
			return $this->criterios;
		}

		function getEvaluados(){
			return $this->evaluados;
		}

		//******************************************

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

		function setArgs($val){
			$this->args =  $val;
		}

// **********************
// SELECT METHOD / LOAD
// **********************

		function select($id){

			$sql =  "SELECT * FROM sonda WHERE id_empresa = $id AND id = (SELECT MAX(ID) FROM sonda WHERE id_empresa = $id)";
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
				return true;
			}
			return false;
		}
		
		function count_evaluados(){

			$sql =  "SELECT count(id) as count FROM sonda WHERE id_empresa = $id";
			$row =  $this->query_($sql,1);
			return $row['count'];
		}

		/** 20161229 CTP
		 *	Consulta de segmentación, promedios bajos 
		*/
		//Transformamos caracteres raros a legibles.
		public function htmlprnt($string){
			return htmlentities($string, ENT_COMPAT, "ISO-8859-1");
		}

		//Obtenemos el criterio de edad según el código.
		function get_edad($cod){
			switch ($cod) {
				case '0':
				return "Menor a 20 años";
				break;
				case '1':
				return "De 20 a 25 años";
				break;
				case '2':
				return "De 25 a 30 años";
				break;
				case '3':
				return "De 30 a 40 años";
				break;
				case '4':
				return "De 40 a 50 años";
				break;
				case '5':
				return "Más 50 años";
				break;
			}
		}

		//Obtenemos el criterio de antiguedad según el código.
		function get_antiguedad($cod){
			switch ($cod) {
				case '0':
				return "Menor a 1 años";
				break;
				case '1':
				return "De 1 a 2 años";
				break;
				case '2':
				return "De 2 a 5 años";
				break;
				case '3':
				return "De 5 a 10 años";
				break;
				case '4':
				return "De 10 a 15 años";
				break;
				case '5':
				return "De 15 a 20 años";
				break;
				case '6':
				return "Más 20 años";
				break;
			}
		}

		//Obtenemos el criterio de educación según el código.
		function get_educacion($cod){
			switch ($cod) {
				case '0':
				return "Primaria incompleta";
				break;
				case '1':
				return "Primaria completa";
				break;
				case '2':
				return "Secundaria incompleta";
				break;
				case '3':
				return "Secundaria completa";
				break;
				case '4':
				return "Universitaria incompleta";
				break;
				case '5':
				return "Universitaria completa";
				break;
				case '6':
				return "Postgrado";
				break;
			}
		}

		//Obtenemos el criterio de sexo según el código.
		function get_sexo($cod){
			switch ($cod) {
				case '0':
				return "Masculino";
				break;
				case '1':
				return "Femenino";
				break;
				case '2':
				return "N/E";
				break;
			}
		}

		//Obtenemos el criterio de area según el código.
		function get_area($cod){
			$res = $this->query_('SELECT `nombre` FROM `empresa_area` WHERE `id`="'.$cod.'"',1);
			$res = ($res) ? $res["nombre"] : "Ninguno";
			return $this->htmlprnt($res);
		}

		//Obtenemos el criterio de localidad según el código.
		function get_localidad($cod){
			$res = $this->query_('SELECT `nombre` FROM `empresa_local` WHERE `id`="'.$cod.'"',1);
			$res = ($res) ? $res["nombre"] : "Ninguno";
			return $this->htmlprnt($res);
		}

		//Obtenemos el criterio de cargo según el código.
		function get_cargo($cod){
			$res = $this->query_('SELECT `nombre` FROM `empresa_cargo` WHERE `id`="'.$cod.'"',1);
			$res = ($res) ? $res["nombre"] : "Ninguno";
			return $this->htmlprnt($res);
		}

		//Obtenemos el criterio de organización según el código.
		function get_norg($cod){
			$res = $this->query_('SELECT `nombre` FROM `empresa_norg` WHERE `id`="'.$cod.'"',1);
			$res = ($res) ? $res["nombre"] : "Ninguno";
			return $this->htmlprnt($res);
		}

		//Obtenemos el criterio de contrato según el código.
		function get_tcont($cod){
			$res = $this->query_('SELECT `nombre` FROM `empresa_tcont` WHERE `id`="'.$cod.'"',1);
			$res = ($res) ? $res["nombre"] : "Ninguno";
			return $this->htmlprnt($res);
		}

		//Obtenemos el número real de evaluados en el proceso.
		function get_evaluados_pb(){
			$evaluados = array();

			foreach ($this->idspreguntas["ids"] as $key => $value) {
				$value = explode(",", $value);
				foreach ($value as $key => $valor) {
					if(!in_array($valor, $evaluados)){
						array_push($evaluados, $valor);
					}
				}
			}

			$_SESSION["c_eval_pb"] = count($evaluados);
			$_SESSION["eval_pb"] = $evaluados;
			$this->evaluados = count($evaluados);
		}

		function get_criterios(){

			$filtros = "";			
			$areas=$edad=$antiguedad=$localidad=$norg=$tcont=$educacion=$sexo="";
			
			foreach ($this->filtros as $key => $value) {
				$ea_ids = array();
				switch ($key) {
					case 'departamento':
						$filtros.="Áreas: ";
						$filtros.=implode(", ", array_map(array($this,'get_area'),$value));
						$filtros.=".<br>";
						$this->departamento = array();
						foreach ($value as $key => $value) {
							if(!in_array($value, $this->departamento)){
								array_push($this->departamento, $value);
								array_push($ea_ids, $value);
							} 
						}
						$ea_ids=array_unique($ea_ids);
						$areas = " AND `departamento` IN (".implode(",", $ea_ids).")";
						break;
					
					case 'edad':
						$filtros.="Edad: ";
						$filtros.=implode(", ", array_map(array($this,'get_edad'),$value));
						$filtros.=".<br>";
						$this->edad = array();
						foreach ($value as $key => $value) {
							if(!in_array($value, $this->edad)){
								array_push($this->edad, $value);
								array_push($ea_ids, $value);
							}
						}
						$ea_ids=array_unique($ea_ids);
						$edad = " AND `edad` IN (".implode(",", $ea_ids).")";
						break;

					case 'antiguedad':
						$filtros.="Antigüedad: ";
						$filtros.=implode(", ", array_map(array($this,'get_antiguedad'),$value));
						$filtros.=".<br>";
						$this->antiguedad = array();
						foreach ($value as $key => $value) {
							if(!in_array($value, $this->antiguedad)){
								array_push($this->antiguedad, $value);
								array_push($ea_ids, $value);
							}
						}
						$ea_ids=array_unique($ea_ids);
						$antiguedad = " AND `antiguedad` IN (".implode(",", $ea_ids).")";
						break;

					case 'localidad':
						$filtros.="Localidad: ";
						$filtros.=implode(", ", array_map(array($this,'get_localidad'),$value));
						$filtros.=".<br>";
						$this->localidad = array();
						foreach ($value as $key => $value) {
							if(!in_array($value, $this->localidad)){
								array_push($this->localidad, $value);
								array_push($ea_ids, $value);
							}
						}
						$ea_ids=array_unique($ea_ids);
						$localidad = " AND `localidad` IN (".implode(",", $ea_ids).")";
						break;

					case 'norg':
						$filtros.="Nivel organizacional: ";
						$filtros.=implode(", ", array_map(array($this,'get_norg'),$value));
						$filtros.=".<br>";
						$this->norg = array();
						foreach ($value as $key => $value) {
							if(!in_array($value, $this->norg)){
								array_push($this->norg, $value);
								array_push($ea_ids, $value);
							}
						}
						$ea_ids=array_unique($ea_ids);
						$norg = " AND `norg` IN (".implode(",", $ea_ids).")";
						break;

					case 'tcont':
						$filtros.="Tipo de contrato: ";
						$filtros.=implode(", ", array_map(array($this,'get_tcont'),$value));
						$filtros.=".<br>";
						$this->tcont = array();
						foreach ($value as $key => $value) {
							if(!in_array($value, $this->tcont)){
								array_push($this->tcont, $value);
								array_push($ea_ids, $value);
							}
						}
						$ea_ids=array_unique($ea_ids);
						$tcont = " AND `tcont` IN (".implode(",", $ea_ids).")";
						break;

					case 'educacion':
						$filtros.="Educacion: ";
						$filtros.=implode(", ", array_map(array($this,'get_educacion'),$value));
						$filtros.=".<br>";
						$this->educacion = array();
						foreach ($value as $key => $value) {
							if(!in_array($value, $this->educacion)){
								array_push($this->educacion, $value);
								array_push($ea_ids, $value);
							}
						}
						$ea_ids=array_unique($ea_ids);
						$educacion = " AND `educacion` IN (".implode(",", $ea_ids).")";
						break;

					case 'sexo':
						$filtros.="Sexo: ";
						$filtros.=implode(", ", array_map(array($this,'get_sexo'),$value));
						$filtros.=".<br>";
						$this->sexo = array();
						foreach ($value as $key => $value) {
							if(!in_array($value, $this->sexo)){
								array_push($this->sexo, $value);
								array_push($ea_ids, $value);
							}
						}
						$ea_ids=array_unique($ea_ids);
						$sexo = " AND `sexo` IN (".implode(",", $ea_ids).")";
						break;

					default:
						$filtros.="";
						break;
				}
			}

			$this->args = array(
				'areas' => $areas, 
				'edad' => $edad, 
				'antiguedad' => $antiguedad, 
				'localidad' => $localidad, 
				'edad' => $edad, 
				'tcont' => $tcont, 
				'educacion' => $educacion, 
				'sexo' => $sexo
				);

			//$_SESSION['filtros_pb'] = $filtros;
			$this->criterios =  $filtros;
		}

		function filtros_criterios($filtro){
			
			switch ($filtro["tipo"]) {
				case 'departamento':
					if (!in_array($filtro["valor"], $this->filtros["departamento"])) {
						$this->filtros["departamento"][] = $filtro["valor"];
					}
					break;

				case 'edad':
					if (!in_array($filtro["valor"], $this->filtros["edad"])) {
						$this->filtros["edad"][] = $filtro["valor"];
					}
					break;

				case 'antiguedad':
					if (!in_array($filtro["valor"], $this->filtros["antiguedad"])) {
						$this->filtros["antiguedad"][] = $filtro["valor"];
					}
					break;

				case 'localidad':
					if (!in_array($filtro["valor"], $this->filtros["localidad"])) {
						$this->filtros["localidad"][] = $filtro["valor"];
					}
					break;

				case 'norg':
					if (!in_array($filtro["valor"], $this->filtros["norg"])) {
						$this->filtros["norg"][] = $filtro["valor"];
					}
					break;

				case 'tcont':
					if (!in_array($filtro["valor"], $this->filtros["tcont"])) {
						$this->filtros["tcont"][] = $filtro["valor"];
					}
					break;

				case 'educacion':
					if (!in_array($filtro["valor"], $this->filtros["educacion"])) {
						$this->filtros["educacion"][] = $filtro["valor"];
					}
					break;

				case 'sexo':
					if (!in_array($filtro["valor"], $this->filtros["sexo"])) {
						$this->filtros["sexo"][] = $filtro["valor"];
					}
					break;
			}
		}

		//Calculamos los promedios mas bajos según usuarios pertenecientes al test en cuestión (test actual o test consultado), y las preguntas del test actual.
		function calculo_prom_bajos($ids,$tema,$preguntas) {//echo "$preguntas<br>";

			$filtro = array("tipo" => null, "valor" => null);
			$limitador;
			$contador = 0;
			$p_ids = array();
			$arrIdU = array();
			$arrIdP = array();

			$sql = "SELECT 	AVG(b.respuesta) AS respuesta, 
							b.id_suser, 
							b.id_pregunta";
			$sql .=	" FROM sonda_respuestas AS b ";
			$sql .= " WHERE b.id_suser IN (".$ids.")";
			$sql .= " AND b.id_pregunta IN (".$preguntas.")";
			$sql .= " AND b.respuesta <> 0";
			$sql .= " GROUP BY 2,3";
			$sql .= " ORDER BY respuesta ASC;";//echo "$sql<br><br>";

			$row = $this->query_($sql,0);

			if ($row) {
				foreach ($row as $key => $value) {
					$limitador = $value["respuesta"];
					if ($limitador < 3) {
						if (!in_array($value["id_suser"], $arrIdU))
							array_push($arrIdU, $value["id_suser"]);

						if (!in_array($value["id_pregunta"], $arrIdP))
							array_push($arrIdP, $value["id_pregunta"]);
					}else{
						continue;
					}
					$this->arrIds[$tema][$limitador]['id_suser'] = $arrIdU;
					$this->arrIds[$tema][$limitador]['preguntas'] = $arrIdP;
					$this->arrIds[$tema][$limitador]['promedio'] = $limitador;
				}
			}
		}

		public function promedios_bajos($id_e)
		{
			$this->min_avg = 3;
			if (is_array($this->arrIds)) {
				$arrTmp = $this->arrIds;
				$this->arrIds = null;

				foreach ($arrTmp as $tema => $arrTema) {
					foreach ($arrTema as $avg => $value) {
						$serialize = serialize($value['id_suser']);
						$this->arrIds[$serialize][$tema] = $value;
					}
				}

				$this->getFiltros($id_e);
			}
		}

		public function getFiltros($id_e)
		{
			$count = 0;
			$cadena = '';

			if (is_array($this->arrIds)) {
				foreach ($this->arrIds as $arrIds => $arrValores) {
					$unserialize = unserialize($arrIds);
					$idsUser = implode(',', $unserialize);
					//
					$sql = "SELECT DISTINCT COUNT(u.id) AS c_e, u.edad, u.antiguedad, u.localidad, u.departamento, u.norg, u.tcont, u.educacion, u.sexo ";
					$sql .=	"FROM sonda_users u ";
					$sql .= "WHERE u.id_empresa = $id_e ";
					$sql .= "AND u.id_test = (SELECT MAX(s.id) FROM sonda s where s.id_empresa = u.id_empresa) ";
					$sql .= "and u.id in($idsUser) ";
					$sql .= "GROUP BY 2,3,4,5,6,7,8,9 ";//echo "$sql<br>";

					$row = $this->query_($sql,0);
					if ($row) {
						// Armamos los filtros seleccionados
						foreach ($row as $key => $value) {
							$edad = $value['edad'];
							$antiguedad = $value['antiguedad'];
							$localidad = $value['localidad'];
							$departamento = $value['departamento'];
							$norg = $value['norg'];
							$tcont = $value['tcont'];
							$educacion = $value['educacion'];
							$sexo = $value['sexo'];
							$c_e = $value['c_e'];
							//
							$args = array(
								'edad' => $edad, 
								'antiguedad' => $antiguedad, 
								'localidad' => $localidad, 
								'departamento' => $departamento, 
								'norg' => $norg, 
								'tcont' => $tcont, 
								'educacion' => $educacion, 
								'sexo' => $sexo,
								'c_e' => $c_e

							);
						}

						foreach ($arrValores as $tema => $arrTema) {
							$this->arrDatos[serialize($args)][$tema] = $arrTema;
						}
					}
				}
			}
		}

		public function resetVariables()
		{
			$this->filtros["departamento"] = array();
			$this->filtros["edad"] = array();
			$this->filtros["antiguedad"] = array();
			$this->filtros["localidad"] = array();
			$this->filtros["norg"] = array();
			$this->filtros["tcont"] = array();
			$this->filtros["educacion"] = array();
			$this->filtros["sexo"] = array();
		}

		//Cargamos los datos del test a consultar.
		public function get_test($id_s){
			$sql = "SELECT * FROM sonda WHERE id_empresa = $this->id_empresa AND id = $id_s";
			$row = $this->query_($sql,1);

			if($row){
				$this->id = $row['id'];
				$this->id_empresa = $row['id_empresa'];
				$this->segmentacion = $row['segmentacion'];
				$this->temas = $row['temas'];
				$this->fecha = $row['fecha'];
				$this->email = $row['email'];
				$this->periodo = $row['periodo'];
			}
		}

		//******************************************

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
			$sql = "INSERT INTO sonda ( id_empresa,segmentacion,temas,fecha,email,periodo ) VALUES ( '$this->id_empresa','$this->segmentacion','$this->temas','$this->fecha','$this->email','$this->periodo' )";
			$result = $this->query_($sql);
			$this->id = mysqli_insert_id($this->link);

		}

// **********************
// UPDATE
// **********************

		function update(){



			//$sql = " UPDATE sonda SET  id_empresa = '$this->id_empresa',segmentacion = '$this->segmentacion',temas = '$this->temas',fecha = '$this->fecha' WHERE id = $this->id ";
			$sql = " UPDATE sonda SET  id_empresa = '$this->id_empresa',segmentacion = '$this->segmentacion',temas = '$this->temas',fecha = '$this->fecha', email = '$this->email', periodo = '$this->periodo' WHERE id = $this->id ";
			$result = $this->query_($sql);



		}
	}