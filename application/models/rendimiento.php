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
		public $nuevos_criterios;
		public $criterios_escala;
		public $criterios_barras_colores;
		public $criterios_rango_barras;

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
		public $hijos = array();
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

		function getNuevosCriterios(){
			return $this->nuevos_criterios;
		}

		function getCriteriosEscala(){
			return unserialize($this->criterios_escala);
		}

		function getCriteriosBarrasColores(){
			return unserialize($this->criterios_barras_colores);
		}

		function getCriteriosRangoBarras(){
			return unserialize($this->criterios_rango_barras);
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

		function getHijos(){
			return $this->hijos;
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

		function setNuevosCriterios($val){
			$this->nuevos_criterios = $val;
		}

		function setCriteriosEscala($val){
			$this->criterios_escala = serialize($val);
		}

		function setCriteriosBarrasColores($val){
			$this->criterios_barras_colores = serialize($val);
		}

		function setCriteriosRangoBarras($val){
			$this->criterios_rango_barras = serialize($val);
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
				$this->nuevos_criterios = $row['nuevos_criterios'];
				$this->criterios_escala = $row['criterios_escala'];
				$this->criterios_barras_colores = $row['criterios_barras_colores'];
				$this->criterios_rango_barras = $row['criterios_rango_barras'];
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
				$this->nuevos_criterios = $row['nuevos_criterios'];
				$this->criterios_escala = $row['criterios_escala'];
				$this->criterios_barras_colores = $row['criterios_barras_colores'];
				$this->criterios_rango_barras = $row['criterios_rango_barras'];
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
				$this->nuevos_criterios = $row['nuevos_criterios'];
				$this->criterios_escala = $row['criterios_escala'];
				$this->criterios_barras_colores = $row['criterios_barras_colores'];
				$this->criterios_rango_barras = $row['criterios_rango_barras'];
				return true;
			}
			return false;
		}

		function select_tipo($id,$tipo_sonda){

			$sql =  "SELECT * 
					FROM sonda 
					WHERE tipo_sonda = '$tipo_sonda' 
					AND id_empresa = $id 
					AND id = (SELECT MAX(ID) FROM sonda WHERE tipo_sonda = '$tipo_sonda' AND id_empresa = $id)";

			$row =  $this->query_($sql,1);
			if($row){
				$this->id = $row['id'];
				$this->id_empresa = $row['id_empresa'];
				$this->segmentacion = $row['segmentacion'];
				$this->temas = $row['temas'];
				$this->fecha = $row['fecha'];
				$this->email = $row['email'];
				$this->periodo = $row['periodo'];
				$this->nuevos_criterios = $row['nuevos_criterios'];
				$this->criterios_escala = $row['criterios_escala'];
				$this->criterios_barras_colores = $row['criterios_barras_colores'];
				$this->criterios_rango_barras = $row['criterios_rango_barras'];
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
				return "De 21 a 25 años";
				break;
				case '2':
				return "De 26 a 30 años";
				break;
				case '3':
				return "De 31 a 40 años";
				break;
				case '4':
				return "De 41 a 50 años";
				break;
				case '5':
				return "Mas de 50 años";
				break;
			}
		}

		//Obtenemos el criterio de antiguedad según el código.
		function get_antiguedad($cod){
			switch ($cod) {
				case '7':
				return "De 0 a 3 meses";
				break;
				case '1':
				return "De 3 meses a 2 años";
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

		function get_hijos($cod){
			switch ($cod) {
				case '0':
				return "Sí";
				break;
				case '1':
				return "No";
				break;
				case '2':
				return "N/E";
				break;
			}
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

		function get_criterios($flag = ''){

			$filtros = "";			
			$areas=$edad=$antiguedad=$localidad=$norg=$tcont=$educacion=$sexo=$hijos="";
			
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

					case 'hijos':
						$filtros.="Hijos: ";
						$filtros.=implode(", ", array_map(array($this,'get_hijos'),$value));
						$filtros.=".<br>";
						$this->hijos = array();
						foreach ($value as $key => $value) {
							if(!in_array($value, $this->hijos)){
								array_push($this->hijos, $value);
								array_push($ea_ids, $value);
							}
						}
						$ea_ids=array_unique($ea_ids);
						$hijos = " AND `hijos` IN (".implode(",", $ea_ids).")";
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

			if($flag){
				$this->args['hijos'] = $hijos;
			}

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
				case 'hijos':
					 $this->filtros["hijos"] = array();
					if (!in_array($filtro["valor"], $this->filtros["hijos"])) {
						$this->filtros["hijos"][] = $filtro["valor"];
					}
					break;
			}
		}

		//	SONDA
		function calculo_prom_bajos($ids,$tema,$preguntas) {

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
			$sql .= " AND b.respuesta <> -1";
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

		public function promedios_bajos($id_e,$tipo_sonda)
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

				$this->getFiltros($id_e,$tipo_sonda);
			}
		}

		public function getFiltros($id_e,$tipo_sonda)
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
					$sql .= "AND u.id_test = (SELECT MAX(s.id) FROM sonda s where s.id_empresa = u.id_empresa AND tipo_sonda = '$tipo_sonda') ";
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
							
							if ($c_e >= 3) {
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
								
								foreach ($arrValores as $tema => $arrTema) {
									$this->arrDatos[serialize($args)][$tema] = $arrTema;
								}
							}
						}
					}
				}
			}
		}

		// RIESGO PSICOSOCIAL
		function getGrupos_rp($id_e, $seg){

			$group = 1;
			$sql = "select distinct count(id) AS c_e";

			if (is_array($seg)) {
				foreach ($seg as $key => $campo) {
					switch ($campo) {
						case 'edad':
							$sql .= " ,edad";
							$group++;
							break;
						case 'antiguedad':
							$sql .= " ,antiguedad";
							$group++;
							break;
						case 'localidad':
							$sql .= " ,localidad";
							$group++;
							break;
						case 'departamento':
							$sql .= " ,departamento";
							$group++;
							break;
						case 'norg':
							$sql .= " ,norg";
							$group++;
							break;
						case 'tcont':
							$sql .= " ,tcont";
							$group++;
							break;
						case 'educacion':
							$sql .= " ,educacion ";
							$group++;
							break;
						case 'sexo':
							$sql .= " ,sexo";
							$group++;
							break;
						case 'hijos':
							$sql .= " ,hijos";
							$group++;
							break;
						default:
							$sql .= "";
							break;
					}
				}
			}
			
			$sql .= " from rp_users";
			$sql .= " where id_test = (select max(id) from riesgo_psicosocial where id_empresa = ".$id_e.") ";
			
			if ($group > 1) {
				$sql .= "group by ";
				for ($i=2; $i <= $group; $i++) { 
					if ($i == 2)
						$sql .= $i;
					else
						$sql .= " ,".$i;
				}
			}
			
			$row = $this->query_($sql,0);

			if ($row) {
				$query = "";
				
				foreach ($row as $key => $value) {
					if ($value["c_e"] >= 3) {
						$c_e = $value["c_e"];
						$arrArgs['c_e'] = $c_e;
						
						if(array_key_exists('edad', $value)){
							$edad = $value['edad'];
							$query = "and edad = '".$edad."' ";
							$arrArgs['edad'] = $edad;
						}
						if(array_key_exists('antiguedad', $value)){
							$antiguedad = $value['antiguedad'];
							$query .= "and antiguedad = '".$antiguedad."' ";
							$arrArgs['antiguedad'] = $antiguedad;
						}
						if(array_key_exists('localidad', $value)){
							$localidad = $value['localidad'];
							$query .= "and localidad = '".$localidad."' ";
							$arrArgs['localidad'] = $localidad;
						}
						if(array_key_exists('departamento', $value)){
							$departamento = $value['departamento'];
							$query .= "and departamento = '".$departamento."' ";
							$arrArgs['departamento'] = $departamento;
						}
						if(array_key_exists('norg', $value)){
							$norg = $value['norg'];
							$query .= "and norg = '".$norg."' ";
							$arrArgs['norg'] = $norg;
						}
						if(array_key_exists('tcont', $value)){
							$tcont = $value['tcont'];
							$query .= "and tcont = '".$tcont."' ";
							$arrArgs['tcont'] = $tcont;
						}
						if(array_key_exists('educacion', $value)){
							$educacion = $value['educacion'];
							$query .= "and educacion = '".$educacion."' ";
							$arrArgs['educacion'] = $educacion;
						}
						if(array_key_exists('sexo', $value)){
							$sexo = $value['sexo'];
							$query .= "and sexo = '".$sexo."' ";
							$arrArgs['sexo'] = $sexo;
						}
						if(array_key_exists('hijos', $value)){
							$hijos = $value['hijos'];
							$query .= "and hijos = '".$hijos."' ";
							$arrArgs['hijos'] = $hijos;
						}
						
						//
						$args = $arrArgs;

						$this->arrIds[serialize($args)]['id_rp_user'] = array();
						$this->arrIds[serialize($args)]['preguntas'] = array();

						$new_sql = "select distinct u.id as id_rp_user ";
						$new_sql .= "from rp_users u ";
						$new_sql .= "where u.id_test = (select max(id) from riesgo_psicosocial where id_empresa = ".$id_e.") ";
						$new_sql .= $query;
						$row_sql = $this->query_($new_sql,0);

						$arrIdU = array();
						if ($row_sql) {
							foreach ($row_sql as $idx => $valor) {
								if (!in_array($valor['id_rp_user'], $arrIdU))
									array_push($arrIdU, $valor["id_rp_user"]);
							}
						}

						$this->arrIds[serialize($args)]['id_rp_user'] = $arrIdU;
					}
				}
			}
		}

		function getGruposTemas_rp($tema,$preguntas){

			$arrPreguntas = explode(',', $preguntas);

			if (is_array($this->arrIds)) {
				foreach ($this->arrIds as $args => $arrValores) {
					$this->arrDatos[$args][$tema]['id_rp_user'] = $arrValores['id_rp_user'];
					$this->arrDatos[$args][$tema]['preguntas'] = $arrPreguntas;
				}
			}
		}

		function getPromediosBajos_rp($id_e){

			$w = new Rp_respuesta();
			$x = new Rp_tema();
			$y = new Rp_pregunta();
			$z = new Rp_user();

			$arrDatos = $this->arrDatos;
			$this->arrDatos = null;

			if (is_array($arrDatos)) {
				foreach ($arrDatos as $args => $arrArgs) {
					foreach ($arrArgs as $tema => $arrTema) {
						$arrIdU = $arrTema['id_rp_user'];
						$ids = implode(',', $arrIdU);
						$arrPreguntas = $arrTema['preguntas'];
						$preguntas = implode(',', $arrPreguntas);

						if (is_array($arrPreguntas)) {
							foreach ($arrPreguntas as $cont => $id_pregunta) {
								$porcentaje = $w->get_percent($ids,$id_pregunta);
								if ($porcentaje >= 75) {
									$this->arrDatos[$args][$tema]['id_rp_user'] = $arrTema['id_rp_user'];
									$this->arrDatos[$args][$tema]['preguntas'][$cont] = $id_pregunta;
								}
							}
						}
					}
				}
			}
		}
		///////////////////////////////////////////////////////////
		function calculo_prom_bajos_rp($ids,$tema,$preguntas) {

			$limitador;
			$arrIdU = array();
			$arrIdP = array();
			/*
			$sql = "SELECT 	AVG(b.respuesta) AS respuesta, 
							b.id_rp_user, 
							b.id_pregunta";
			*/
			$sql = "SELECT 	b.respuesta, 
							b.id_rp_user, 
							b.id_pregunta";
			$sql .=	" FROM rp_respuestas AS b ";
			$sql .= " WHERE b.id_rp_user IN (".$ids.")";
			$sql .= " AND b.id_pregunta IN (".$preguntas.")";
			$sql .= " AND b.respuesta <> 0";
			//$sql .= " GROUP BY 2,3";
			$sql .= " ORDER BY respuesta ASC;";//echo "$sql<br><br>";

			$row = $this->query_($sql,0);

			if ($row) {
				foreach ($row as $key => $value) {
					$limitador = $value["respuesta"];

					if (!in_array($value["id_rp_user"], $arrIdU))
						array_push($arrIdU, $value["id_rp_user"]);

					if (!in_array($value["id_pregunta"], $arrIdP))
						array_push($arrIdP, $value["id_pregunta"]);
					
					$this->arrIds[$tema][$limitador]['id_rp_user'] = $arrIdU;
					$this->arrIds[$tema][$limitador]['preguntas'] = $arrIdP;
					$this->arrIds[$tema][$limitador]['promedio'] = $limitador;
				}
			}
		}

		function promedios_bajos_rp($id_e){
			$this->min_avg = 3;
			if (is_array($this->arrIds)) {
				$arrTmp = $this->arrIds;
				$this->arrIds = null;

				foreach ($arrTmp as $tema => $arrTema) {
					foreach ($arrTema as $avg => $value) {
						$serialize = serialize($value['id_rp_user']);
						$this->arrIds[$serialize][$tema] = $value;
					}
				}

				$this->getFiltros_rp($id_e);

			}
		}

		function getFiltros_rp($id_e){

			$this->arrDatos = null;

			if (is_array($this->arrIds)) {
				foreach ($this->arrIds as $arrIds => $arrValores) {
					$unserialize = unserialize($arrIds);
					$idsUser = implode(',', $unserialize);
					//
					$sql = "SELECT DISTINCT COUNT(u.id) AS c_e, u.edad, u.antiguedad, u.localidad, u.departamento, u.norg, u.tcont, u.educacion, u.sexo, u.hijos ";
					$sql .=	"FROM rp_users u ";
					$sql .= "WHERE u.id_empresa = $id_e ";
					$sql .= "AND u.id_test = (SELECT MAX(s.id) FROM riesgo_psicosocial s where s.id_empresa = u.id_empresa) ";
					$sql .= "and u.id in($idsUser) ";
					$sql .= "GROUP BY 2,3,4,5,6,7,8,9,10 ";//echo "$sql<br>";
					
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
							$hijos = $value['hijos'];
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
								'hijos' => $hijos,
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
		///////////////////////////////////////////////////////////
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