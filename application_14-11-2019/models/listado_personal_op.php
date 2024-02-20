<?php

// **********************
// CLASS DECLARATION
// **********************

class listado_personal_op extends Model{ 

// **********************
// ATTRIBUTE DECLARATION
// **********************


	public $nombre;   
	public $foto;   
	public $activo;   
	public $cedula;   
	public $email;   
	public $d_pais;   
	public $d_ciudad;   
	public $d_sector;   
	public $d_calles;   
	public $d_manz;   
	public $d_villa;   
	public $numero_convencional;   
	public $numero_celular;   
	public $empresa;   
	public $sexo;   
	public $fecha_de_nacimiento;   
	public $fecha_de_ingreso;   
	public $id_area;   
	public $area;   
	public $departamento;   
	public $area_f;   
	public $id_local;   
	public $local;   
	public $ciudad;   
	public $pais;   
	public $id_cargo;   
	public $cargo;   
	public $id_superior;   
	public $pid_nombre;   
	public $pid_id_cargo;   
	public $pid_cargo;   
	public $id_norg;   
	public $niveles_organizacionales;   
	public $id_tcont;   
	public $tcont;   
	public $id_cond;   
	public $salario;   
	public $sueldo;   
	public $estado_civil;   
	public $compass_360;   
	public $scorer;   
	public $matriz;   
	public $clima_laboral;   
// **********************
// CONSTRUCTOR METHOD
// **********************


	public function __construct($parameters = array()) {
		parent::__construct();
		foreach($parameters as $key => $value) {
			$this->$key = $value;
		}
		return $this;
	}

	public function cast($parameters = array()) {
		foreach($parameters as $key => $value) {
			switch ($key) {
				case 'numero convencional':
				$this->numero_convencional = $value;
				break;
				case 'numero celular':
				$this->numero_celular = $value;
				break;
				case 'fecha de nacimiento':
				$this->fecha_de_nacimiento = $value;
				break;
				case 'fecha de ingreso':
				$this->fecha_de_ingreso = $value;
				break;
				case 'niveles organizacionales':
				$this->niveles_organizacionales = $value;
				break;
				case 'estado civil':
				$this->estado_civil = $value;
				break;
				
				default:
				$this->$key = $value;
				break;
			}
			





		}
	}
// **********************
// GETTER METHODS
// **********************

	function getId(){
		return $this->id;
	}

	function getNombre(){
		return $this->htmlprnt($this->nombre);
	}

	function getNombre_(){
		return $this->htmlprnt_win(ucfirst($this->nombre));
	}

	function getFoto(){
		return $this->foto;
	}

	function getActivo(){
		return $this->activo;
	}

	function getActivo_(){
		$checked = ($this->getActivo()) ? "checked" : "" ;
		$do =  '<div class="toggle-switch toggle-switch-success">';
		$do .= ' <label>';
		$do .= '  <input class="compass_personal" type="checkbox" '.$checked.' value="'.$this->id.'">';
		$do .= '  <div class="toggle-switch-inner"></div>';
		$do .= '  <div class="toggle-switch-switch"><i class="fa fa-check"></i></div>';
		$do .= ' </label>';
		$do .= ' <div  class="campo" hidden><input value="activo"></div>';
		$do .= ' <div  class="tabla" hidden><input value="personal"></div>';
		$do .= '</div>';
		return $do;	
	}//test

	function getCedula(){
		return $this->cedula;
	}

	function getEmail(){
		return $this->email;
	}

	function getD_pais(){
		return $this->htmlprnt($this->d_pais);
	}

	function getD_pais_(){
		return $this->htmlprnt_win($this->d_pais);
	}

	function getD_ciudad(){
		return $this->htmlprnt($this->d_ciudad);
	}

	function getD_ciudad_(){
		return $this->htmlprnt_win($this->d_ciudad);
	}

	function getD_sector(){
		return $this->htmlprnt($this->d_sector);
	}

	function getD_sector_(){
		return $this->htmlprnt_win($this->d_sector);
	}

	function getD_calles(){
		return $this->htmlprnt($this->d_calles);
	}

	function getD_calles_(){
		return $this->htmlprnt_win($this->d_calles);
	}

	function getD_manz(){
		return $this->htmlprnt($this->d_manz);
	}

	function getD_manz_(){
		return $this->htmlprnt_win($this->d_manz);
	}

	function getD_villa(){
		return $this->htmlprnt($this->d_villa);
	}

	function getD_villa_(){
		return $this->htmlprnt_win($this->d_villa);
	}

	function getNumero_convencional(){
		return $this->numero_convencional;
	}

	function getNumero_celular(){
		return $this->numero_celular;
	}

	function getEmpresa(){
		return $this->empresa;
	}

	function getSexo(){
		return $this->sexo;
	}

	function getFecha_de_nacimiento(){
		return $this->fecha_de_nacimiento;
	}

	function getFecha_de_ingreso(){
		return $this->fecha_de_ingreso;
	}

	function getId_area(){
		return $this->id_area;
	}

	function getArea(){
		return $this->htmlprnt($this->area);
	}

	function getArea_(){
		if($this->area_f=="N/E")
			return $this->area_f;
		return $this->htmlprnt_win($this->area);
	}

	function getDepartamento(){
		if($this->area_f=="N/E")
			return $this->htmlprnt($this->area);
		return $this->htmlprnt($this->departamento);
	}

	function getDepartamento_(){
		if($this->area_f=="N/E")
			return $this->htmlprnt_win($this->area);
		return $this->htmlprnt_win($this->departamento);
	}

	function getArea_f(){
		if($this->area_f=="N/E"){
			if($this->departamento=="N/E"){
				return $this->htmlprnt($this->area);
			}
			return $this->htmlprnt($this->departamento);
		}
		return $this->htmlprnt($this->area_f);
	}


	function getArea_f_(){
		if($this->area_f=="N/E"){
			if($this->departamento=="N/E"){
				return $this->htmlprnt_win($this->area);
			}
			return $this->htmlprnt_win($this->departamento);
		}
		return $this->htmlprnt_win($this->area_f);
	}

	function getId_local(){
		return $this->id_local;
	}

	function getLocal(){
		if($this->pais=="N/E")
			return $this->pais;
		return $this->htmlprnt($this->local);
	}

	function getLocal_(){
		if($this->pais=="N/E")
			return $this->pais;
		return $this->htmlprnt_win($this->local);
	}

	function getCiudad(){
		if($this->pais=="N/E"){
			return $this->htmlprnt($this->local);
		}
		return $this->htmlprnt($this->ciudad);
	}

	function getCiudad_(){
		if($this->pais=="N/E"){
			return $this->htmlprnt_win($this->local);
		}
		return $this->htmlprnt_win($this->ciudad);
	}

	function getPais(){
		if($this->pais=="N/E"){
			if($this->ciudad=="N/E"){
				return $this->htmlprnt($this->local);
			}
			return $this->htmlprnt($this->ciudad);
		}
		return $this->htmlprnt($this->pais);
	}

	function getPais_(){
		if($this->pais=="N/E"){
			if($this->ciudad=="N/E"){
				return $this->htmlprnt_win($this->local);
			}
			return $this->htmlprnt_win($this->ciudad);
		}
		return $this->htmlprnt_win($this->pais);
	}

	function getId_cargo(){
		return $this->id_cargo;
	}

	function getCargo(){
		return $this->htmlprnt($this->cargo);
	}

	function getCargo_(){
		return $this->htmlprnt_win($this->cargo);
	}

	function getId_superior(){
		return $this->id_superior;
	}

	function getPid_nombre(){
		return $this->htmlprnt($this->pid_nombre);
	}

	function getPid_nombre_(){
		return $this->htmlprnt_win(ucfirst($this->pid_nombre));
	}

	function getPid_id_cargo(){
		return $this->pid_id_cargo;
	}

	function getPid_cargo(){
		return $this->htmlprnt($this->pid_cargo);
	}

	function getPid_cargo_(){
		return $this->htmlprnt_win($this->pid_cargo);
	}

	function getId_norg(){
		return $this->id_norg;
	}

	function getNiveles_organizacionales(){
		return $this->htmlprnt($this->niveles_organizacionales);
	}

	function getNiveles_organizacionales_(){
		return $this->htmlprnt_win($this->niveles_organizacionales);
	}

	function getId_tcont(){
		return $this->id_tcont;
	}

	function getTcont(){
		return $this->htmlprnt($this->tcont);
	}

	function getTcont_(){
		return $this->htmlprnt_win($this->tcont);
	}

	function getId_cond(){
		return $this->id_cond;
	}

	function getSalario(){
		return $this->salario;
	}

	function getSueldo(){
		return $this->sueldo;
	}

	function getEstado_civil(){
		return $this->estado_civil;
	}

	function getCompass_360(){
		return $this->compass_360;
	}

	function getCompass_360_(){
		$checked = ($this->getCompass_360()) ? "checked" : "" ;
		$do =  '<div class="toggle-switch toggle-switch-success">';
		$do .= ' <label>';
		$do .= '  <input class="compass_personal" type="checkbox" '.$checked.' value="'.$this->id.'">';
		$do .= '  <div class="toggle-switch-inner"></div>';
		$do .= '  <div class="toggle-switch-switch"><i class="fa fa-check"></i></div>';
		$do .= ' </label>';
		$do .= ' <div  class="campo" hidden><input value="compass_360"></div>';
		$do .= ' <div  class="tabla" hidden><input value="personal_test"></div>';
		$do .= '</div>';
		return $do;
	}

	function getScorer(){
		return $this->scorer;
	}

	function getScorer_(){
		$checked = ($this->getScorer()) ? "checked" : "" ;
		$do =  '<div class="toggle-switch toggle-switch-success">';
		$do .= ' <label>';
		$do .= '  <input class="compass_personal" type="checkbox" '.$checked.' value="'.$this->id.'">';
		$do .= '  <div class="toggle-switch-inner"></div>';
		$do .= '  <div class="toggle-switch-switch"><i class="fa fa-check"></i></div>';
		$do .= ' </label>';
		$do .= ' <div  class="campo" hidden><input value="scorer"></div>';
		$do .= ' <div  class="tabla" hidden><input value="personal_test"></div>';
		$do .= '</div>';
		return $do;
	}

	function getMatriz(){
		return $this->matriz;
	}

	function getMatriz_(){
		$checked = ($this->getMatriz()) ? "checked" : "" ;
		$do =  '<div class="toggle-switch toggle-switch-success">';
		$do .= ' <label>';
		$do .= '  <input class="compass_personal" type="checkbox" '.$checked.' value="'.$this->id.'">';
		$do .= '  <div class="toggle-switch-inner"></div>';
		$do .= '  <div class="toggle-switch-switch"><i class="fa fa-check"></i></div>';
		$do .= ' </label>';
		$do .= ' <div  class="campo" hidden><input value="matriz"></div>';
		$do .= ' <div  class="tabla" hidden><input value="personal_test"></div>';
		$do .= '</div>';
		return $do;
	}

	function getClima_laboral(){
		return $this->clima_laboral;
	}

// **********************
// SETTER METHODS
// **********************


	function setId($val){
		$this->id =  $val;
	}

	function setNombre($val){
		$this->nombre =  $val;
	}

	function setFoto($val){
		$this->foto =  $val;
	}

	function setActivo($val){
		$this->activo =  $val;
	}

	function setCedula($val){
		$this->cedula =  $val;
	}

	function setEmail($val){
		$this->email =  $val;
	}

	function setD_pais($val){
		$this->d_pais =  $val;
	}

	function setD_ciudad($val){
		$this->d_ciudad =  $val;
	}

	function setD_sector($val){
		$this->d_sector =  $val;
	}

	function setD_calles($val){
		$this->d_calles =  $val;
	}

	function setD_manz($val){
		$this->d_manz =  $val;
	}

	function setD_villa($val){
		$this->d_villa =  $val;
	}

	function setNumero_convencional($val){
		$this->numero_convencional =  $val;
	}

	function setNumero_celular($val){
		$this->numero_celular =  $val;
	}

	function setEmpresa($val){
		$this->empresa =  $val;
	}

	function setSexo($val){
		$this->sexo =  $val;
	}

	function setFecha_de_nacimiento($val){
		$this->fecha_de_nacimiento =  $val;
	}

	function setFecha_de_ingreso($val){
		$this->fecha_de_ingreso =  $val;
	}

	function setId_area($val){
		$this->id_area =  $val;
	}

	function setArea($val){
		$this->area =  $val;
	}

	function setDepartamento($val){
		$this->departamento =  $val;
	}

	function setArea_f($val){
		$this->area_f =  $val;
	}

	function setId_local($val){
		$this->id_local =  $val;
	}

	function setLocal($val){
		$this->local =  $val;
	}

	function setCiudad($val){
		$this->ciudad =  $val;
	}

	function setPais($val){
		$this->pais =  $val;
	}

	function setId_cargo($val){
		$this->id_cargo =  $val;
	}

	function setCargo($val){
		$this->cargo =  $val;
	}

	function setId_superior($val){
		$this->id_superior =  $val;
	}

	function setPid_nombre($val){
		$this->pid_nombre =  $val;
	}

	function setPid_id_cargo($val){
		$this->pid_id_cargo =  $val;
	}

	function setPid_cargo($val){
		$this->pid_cargo =  $val;
	}

	function setId_norg($val){
		$this->id_norg =  $val;
	}

	function setNiveles_organizacionales($val){
		$this->niveles_organizacionales =  $val;
	}

	function setId_tcont($val){
		$this->id_tcont =  $val;
	}

	function setTcont($val){
		$this->tcont =  $val;
	}

	function setId_cond($val){
		$this->id_cond =  $val;
	}

	function setSalario($val){
		$this->salario =  $val;
	}

	function setSueldo($val){
		$this->sueldo =  $val;
	}

	function setEstado_civil($val){
		$this->estado_civil =  $val;
	}

	function setCompass_360($val){
		$this->compass_360 =  $val;
	}

	function setScorer($val){
		$this->scorer =  $val;
	}

	function setMatriz($val){
		$this->matriz =  $val;
	}

	function setClima_laboral($val){
		$this->clima_laboral =  $val;
	}

// **********************
// SELECT METHOD / LOAD
// **********************

	function select($id){

		$sql =  "SELECT * FROM listado_personal_op WHERE id = $id;";
		$row =  $this->query_($sql,1);

		// echo $row["numero convencional"];

		$this->id = $row['id'];
		$this->nombre = $row['nombre'];
		$this->foto = $row['foto'];
		$this->activo = $row['activo'];
		$this->cedula = $row['cedula'];
		$this->email = $row['email'];
		$this->d_pais = $row['d_pais'];
		$this->d_ciudad = $row['d_ciudad'];
		$this->d_sector = $row['d_sector'];
		$this->d_calles = $row['d_calles'];
		$this->d_manz = $row['d_manz'];
		$this->d_villa = $row['d_villa'];
		$this->numero_convencional = $row['numero convencional'];
		$this->numero_celular = $row['numero celular'];
		$this->empresa = $row['empresa'];
		$this->sexo = $row['sexo'];
		$this->fecha_de_nacimiento = $row['fecha de nacimiento'];
		$this->fecha_de_ingreso = $row['fecha de ingreso'];
		$this->id_area = $row['id_area'];
		$this->area = $row['area'];
		$this->departamento = $row['departamento'];
		$this->area_f = $row['area_f'];
		$this->id_local = $row['id_local'];
		$this->local = $row['local'];
		$this->ciudad = $row['ciudad'];
		$this->pais = $row['pais'];
		$this->id_cargo = $row['id_cargo'];
		$this->cargo = $row['cargo'];
		$this->id_superior = $row['id_superior'];
		$this->pid_nombre = $row['pid_nombre'];
		$this->pid_id_cargo = $row['pid_id_cargo'];
		$this->pid_cargo = $row['pid_cargo'];
		$this->id_norg = $row['id_norg'];
		$this->niveles_organizacionales = $row['niveles organizacionales'];
		$this->id_tcont = $row['id_tcont'];
		$this->tcont = $row['tcont'];
		$this->id_cond = $row['id_cond'];
		$this->salario = $row['salario'];
		$this->sueldo = $row['sueldo'];
		$this->estado_civil = $row['estado civil'];
		$this->compass_360 = $row['compass_360'];
		$this->scorer = $row['scorer'];
		$this->matriz = $row['matriz'];
		$this->clima_laboral = $row['clima_laboral'];

		return $this;
	}

	
// **********************
// CUSTOM METHODS
// **********************

	function select_all($id,$activo=1){
		return $this->query_("SELECT * FROM listado_personal_op WHERE empresa = $id AND activo=$activo;");
	}


	public function getSubalternos_($array = true){
		$ids = array();
		$sql = "SELECT id from listado_personal_op WHERE id_superior=$this->id AND activo=1";
		$res = $this->query_($sql);
		array_push($ids, $this->id);
		if($res){
			foreach ($res as $key => $value) {
				array_push($ids, $value['id']);
			}
		}
		if($array)
			return $ids;
		return implode(',', $ids);
	}

	public function getSubalternos__($array = true){
		$ids = array();
		$sql = "SELECT * from listado_personal_op WHERE id_superior=$this->id AND activo=1";
		$res = $this->query_($sql);
		if($res){
			foreach ($res as $key => $value) {
				array_push($ids, $value);
			}
		}
		return $ids;
	}

	function getEducacionFormal($id, $activo=1){
		return $this->query_("SELECT p.nombre,p.cedula,pf.* FROM `personal_ed_formal` pf join listado_personal_op p on p.id = pf.id_persona where p.empresa=$id AND p.activo=$activo;");
	}

	function getCursos($id, $activo=1){
		return $this->query_("SELECT p.nombre,p.cedula,'E' as donde,pf.* FROM `personal_cursos` pf join listado_personal_op p on p.id = pf.id_persona where p.empresa=$id AND p.activo=$activo;");
	}

	function getCursosInternos($id, $activo=1){
		return $this->query_("SELECT p.nombre,p.cedula,'I' as donde,pf.* FROM `personal_cursos_internos` pf join listado_personal_op p on p.id = pf.id_persona where p.empresa=$id AND p.activo=$activo;");
	}

	function getHlaboral($id, $activo=1){
		return $this->query_("SELECT p.nombre,p.cedula,pf.* FROM `personal_hlaboral` pf join listado_personal_op p on p.id = pf.id_persona  where p.empresa=$id AND p.activo=$activo;");
	}

	function getScorer_objetivos($id,$periodo,$activo=1){
		return $this->query_("SELECT p.nombre,p.cedula,so.* FROM `scorer_objetivo` so join listado_personal_op p on p.id = so.id_personal where p.empresa=$id AND so.periodo=$periodo AND p.activo=$activo;");
	}

	function consolidado_empresa($campo,$ids,$id=null){
		$sql="SELECT";
		if ($id) {
		$sql.="(SELECT count(*) from listado_personal_op WHERE id_area=$id AND activo=1) as n_empleados_especifico,";
		}
		$sql.="
		count(*) as n_empleados_acumulado,
		SUM(if(lp.sexo = 'Masculino', 1, 0)) AS hombres,
		SUM(if(lp.sexo = 'Femenino', 1, 0)) AS mujeres,
		AVG(DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(TRIM(`fecha de nacimiento`), '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(TRIM(`fecha de nacimiento`), '00-%m-%d'))) as edad,
		AVG(DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(TRIM(`fecha de ingreso`), '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(TRIM(`fecha de ingreso`), '00-%m-%d'))) AS antiguedad,
		SUM(sueldo) AS sueldos
		FROM
		listado_personal_op lp
		WHERE
		lp.activo = 1
		AND lp.$campo IN ($ids)";
		return $this->query_($sql,1);
	}

	function count_column_on_value($id, $field_lookup, $field_count, $data){
		// $sql = "SELECT $field_lookup as id,";
		$sql = "SELECT ";
		$sql_array = array();
		foreach ($data as $key => $value) {
			array_push($sql_array, "sum(case when $field_count = ".$value['id']." then 1 else 0 end) as '$key'");
		}
		$sql .= implode(",", $sql_array);
		$sql .="FROM listado_personal_op WHERE $field_lookup = $id AND activo=1 GROUP BY $field_lookup";
		// return $sql;
		return $this->query_($sql,1);
	}

	function getResultadosCompass(){
		
	}


	function unlinkAll(){
		unset($this->_model);
		unset($this->_dbHandle);
		unset($this->_result);
		unset($this->link);
		return $this;
	}

}
?>