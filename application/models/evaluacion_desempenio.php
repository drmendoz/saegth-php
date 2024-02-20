<?php

// **********************
// CLASS DECLARATION
// **********************

class Evaluacion_desempenio extends Model{

	// **********************
	// ATTRIBUTE DECLARATION
	// **********************


		public $id;   
		public $id_empresa;
		public $fecha;
		public $email;
		public $periodo;
		public $objetivos_individuales;
		public $criterios_escala;
		public $criterios_simbolos;
		public $criterios_rango_barras;
		public $texto_encuesta;
		public $seleccion_evaluadores;
		public $id_cuestionario;

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

	function getFecha(){
		return $this->print_fecha($this->fecha);
	}

	function getEmail(){
		return $this->email;
	}

	function getPeriodo(){
		return $this->periodo;
	}

	function getObjetivos(){
		return $this->objetivos_individuales;	
	}

	function getCriteriosEscala(){
		return unserialize($this->criterios_escala);
	}

	function getCriteriosSimbolos(){
		return unserialize($this->criterios_simbolos);
	}

	function getCriteriosRangoBarras(){
		return unserialize($this->criterios_rango_barras);
	}

	function getTextoEncuesta(){
		return $this->texto_encuesta;
	}

	function getSeleccionEvaluadores(){
		return $this->seleccion_evaluadores;
	}

	function getCuestionario(){
		return $this->id_cuestionario;
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

	function setFecha($val){
		$this->fecha =  $val;
	}

	function setEmail($val){
		$this->email =  $val;
	}

	function setPeriodo($val){
		$this->periodo =  $val;
	}

	function setObjetivos($val){
		$this->objetivos_individuales = $val;
	}

	function setCriteriosEscala($val){
		$this->criterios_escala = serialize($val);
	}

	function setCriteriosSimbolos($val){
		$this->criterios_simbolos = serialize($val);
	}

	function setCriteriosRangoBarras($val){
		$this->criterios_rango_barras = serialize($val);
	}

	function setTextoEncuesta($val){
		$this->texto_encuesta =  $val;
	}

	function setSeleccionEvaluadores($val){
		$this->seleccion_evaluadores =  $val;
	}

	function setCuestionario($val){
		$this->id_cuestionario =  $val;
	}


	// **********************
	// DELETE
	// **********************

	function delete(){
		$sql = "DELETE FROM evaluacion_desempenio_definicion WHERE id = $this->id";
		$result = $this->query_($sql);

	}

	// **********************
	// INSERT
	// **********************

	function insert(){

		$sql = "INSERT INTO evaluacion_desempenio_definicion 
									( id_empresa,
									fecha,
									email,
									periodo,
									objetivos_individuales,
									criterios_escala,
									criterios_simbolos,
									criterios_rango_barras,
									texto_encuesta,
									seleccion_evaluadores,
									id_cuestionario ) 
							VALUES ( '$this->id_empresa',
									'$this->fecha',
									'$this->email',
									'$this->periodo',
									'$this->objetivos_individuales',
									'$this->criterios_escala',
									'$this->criterios_simbolos',
									'$this->criterios_rango_barras',
									'$this->texto_encuesta',
									'$this->seleccion_evaluadores',
									'$this->id_cuestionario')";
		$result = $this->query_($sql);
		$this->id = mysqli_insert_id($this->link);
	}


	// **********************
	// UPDATE
	// **********************

		function update(){
			
			$sql = " UPDATE evaluacion_desempenio_definicion 
					SET  id_empresa = '$this->id_empresa',
						fecha = '$this->fecha',
						email = '$this->email',
						periodo = '$this->periodo',
						objetivos_individuales = '$this->objetivos_individuales',
						criterios_escala = '$this->criterios_escala',
						criterios_simbolos = '$this->criterios_simbolos',
						criterios_rango_barras = '$this->criterios_rango_barras',
						texto_encuesta = '$this->texto_encuesta',
						seleccion_evaluadores = '$this->seleccion_evaluadores',
						id_cuestionario = '$this->id_cuestionario'
					WHERE id = $this->id ";
			$result = $this->query_($sql);

		}


	// **********************
	// SELECT METHOD / LOAD
	// **********************

	function select($id){
		$sql =  "SELECT * FROM evaluacion_desempenio_definicion WHERE id_empresa = $id order by id desc limit 1";
		$row =  $this->query_($sql,1);
		if($row){
			$this->id = $row['id'];
			$this->id_empresa = $row['id_empresa'];
			$this->fecha = $row['fecha'];
			$this->email = $row['email'];
			$this->periodo = $row['periodo'];
			$this->objetivos_individuales = $row['objetivos_individuales'];
			$this->criterios_escala = $row['criterios_escala'];
			$this->criterios_simbolos = $row['criterios_simbolos'];
			$this->criterios_rango_barras = $row['criterios_rango_barras'];
			$this->texto_encuesta = $row['texto_encuesta'];
			$this->seleccion_evaluadores = $row['seleccion_evaluadores'];
			$this->id_cuestionario = $row['id_cuestionario'];
			return true;
		}
		return false;
	}

	function select__(){

		$sql =  "SELECT * FROM evaluacion_desempenio_definicion WHERE id_empresa = $this->id_empresa AND id=(SELECT max(id) FROM evaluacion_desempenio_definicion WHERE id_empresa = $this->id_empresa );";
		$row =  $this->query_($sql,1);
		if($row){
			$this->id = $row['id'];
			$this->id_empresa = $row['id_empresa'];
			$this->fecha = $row['fecha'];
			$this->email = $row['email'];
			$this->periodo = $row['periodo'];
			$this->objetivos_individuales = $row['objetivos_individuales'];
			$this->criterios_escala = $row['criterios_escala'];
			$this->criterios_simbolos = $row['criterios_simbolos'];
			$this->criterios_rango_barras = $row['criterios_rango_barras'];
			$this->texto_encuesta = $row['texto_encuesta'];
			$this->seleccion_evaluadores = $row['seleccion_evaluadores'];
			$this->id_cuestionario = $row['id_cuestionario'];
			return true;
		}
		return false;
	}

	function select_($id,$idt){

		$sql =  "SELECT * FROM evaluacion_desempenio_definicion WHERE id_empresa = $id AND id=$idt ";
		$row =  $this->query_($sql,1);
		if($row){
			$this->id = $row['id'];
			$this->id_empresa = $row['id_empresa'];
			$this->fecha = $row['fecha'];
			$this->email = $row['email'];
			$this->periodo = $row['periodo'];
			$this->objetivos_individuales = $row['objetivos_individuales'];
			$this->criterios_escala = $row['criterios_escala'];
			$this->criterios_simbolos = $row['criterios_simbolos'];
			$this->criterios_rango_barras = $row['criterios_rango_barras'];
			$this->texto_encuesta = $row['texto_encuesta'];
			$this->seleccion_evaluadores = $row['seleccion_evaluadores'];
			$this->id_cuestionario = $row['id_cuestionario'];
			return true;
		}
		return false;
	}


	// **********************
	// GENERAL METHOD
	// **********************
}

?>