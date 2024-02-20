<?php

// **********************
// CLASS DECLARATION
// **********************

class sonda_pregunta extends Model{ 
// class : begin


// **********************
// ATTRIBUTE DECLARATION
// **********************


	public $id;   
	public $id_tema;   
	public $pregunta;   
	public $inverso;   
	public $op_respuesta;   
	public $id_empresa;
	public $activo;



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

	function getId_tema(){
		return $this->id_tema;
	}

	function getId_empresa(){
		return $this->id_empresa;
	}

	function getPregunta(){
		return $this->htmlprnt($this->pregunta);
	}

	function getPregunta_(){
		return $this->htmlprnt_win($this->pregunta);
	}

	function getInverso(){
		return $this->inverso;
	}

	function getOp_respuesta(){
		return $this->op_respuesta;
	}

	function getActivo(){
		return $this->activo;
	}

// **********************
// SETTER METHODS
// **********************


	function setId($val){
		$this->id =  $val;
	}

	function setId_tema($val){
		$this->id_tema =  $val;
	}

	function setId_empresa($val){
		$this->id_empresa =  $val;
	}

	function setPregunta($val){
		$this->pregunta =  $val;
	}

	function setInverso($val){
		$this->inverso =  $val;
	}

	function setOp_respuesta($val){
		$this->op_respuesta =  $val;
	}

	function setActivo($val){
		$this->activo =  $val;
	}

// **********************
// SELECT METHOD / LOAD
// **********************

	function select($id){
		$sql =  "SELECT * FROM sonda_preguntas WHERE id = $id;";
		$row =  $this->query_($sql,1);


		$this->id = $row['id'];

		$this->id_tema = $row['id_tema'];
		$this->id_empresa = $row['id_empresa'];

		$this->pregunta = $row['pregunta'];

		$this->inverso = $row['inverso'];

		$this->op_respuesta = $row['op_respuesta'];

		$this->activo = $row['activo'];

	}
	function select_x_tema($id_tema){

		$sql =  "SELECT id FROM sonda_preguntas WHERE id_tema=$id_tema";
		$row = $this->query_($sql);
		$result = array();
		foreach ($row as $key => $value) {
			$tmp = new self();
			$tmp->select($value['id']);
			array_push($result, $tmp);
		}
		return $result;
	}
	function select_x_tema_($id_tema,$id_e=0, $activo=''){

		$sql =  "SELECT * FROM sonda_preguntas WHERE id_tema=$id_tema AND id_empresa=$id_e ";
		if($activo)
			$sql .= "AND activo = $activo ";
		return $this->query_($sql);
	}
	function select_x_tema__($id_tema,$id_e=0){
			$sql =  "SELECT * FROM sonda_preguntas WHERE id_tema=$id_tema AND (id_empresa=$id_e OR id_empresa=0) AND activo = 1 ";
			// echo $sql;
			return $this->query_($sql);
	}

	function select_ids_x_tema($id_tema){

		$sql =  "SELECT id FROM sonda_preguntas WHERE id_tema=$id_tema";
		$row = $this->query_($sql);
		$result = array();
		foreach ($row as $key => $value) {
			array_push($result, $value['id']);
		}
		return implode(",", $result);
	}

// **********************
// DELETE
// **********************

	function delete(){
		$sql = "DELETE FROM sonda_preguntas WHERE id = $id;";
		$result = $this->query_($sql);

	}

// **********************
// INSERT
// **********************

	function insert(){

		$sql = "INSERT INTO sonda_preguntas ( id,id_tema,id_empresa,pregunta,inverso,op_respuesta,activo ) VALUES ( '$this->id','$this->id_tema','$this->id_empresa','$this->pregunta','$this->inverso','$this->op_respuesta','$this->activo' )";
		$result = $this->query_($sql);
		$this->id = mysqli_insert_id($this->link);

	}

// **********************
// UPDATE
// **********************

	function update(){



		$sql = " UPDATE sonda_preguntas SET  id = '$this->id',id_tema = '$this->id_tema',id_empresa = '$this->id_empresa',pregunta = '$this->pregunta',inverso = '$this->inverso',op_respuesta = '$this->op_respuesta',activo = '$this->activo' WHERE id = $this->id ";

		$result = $this->query_($sql);



	}

	function activa_inactiva()
	{
		$sql = "UPDATE sonda_preguntas SET activo = $this->activo WHERE id = $this->id ";

		$result = $this->query_($sql);
	}

	function activa_inactiva_preguntas(){
		$sql = "UPDATE sonda_preguntas SET activo = $this->activo WHERE id_tema = $this->id_tema ";

		$result = $this->query_($sql);
	}


// **********************
// EXTRA METHOD
// **********************
	function getOptions($sonda){
		switch ($this->op_respuesta) {
			case 0:
				if($sonda->getNuevosCriterios() == 0)
				{
					$opciones = array("1","2","3","4","5","6");
				}
				else
				{
					$opciones = array();
					$criterios_escala = $sonda->getCriteriosEscala();
					if (is_array($criterios_escala)) {
						foreach ($criterios_escala as $key => $value) {
							array_push($opciones, $criterios_escala[$key]['escala_valor']);
						}
					}
				}
				
			break;
		}

		$result = "<table class='table' style='margin-bottom:0;'>";
		$result .= "<tr>";
		$y = sizeof($opciones);
		$z = 12/$y;
		foreach ($opciones as $key => $value) {
			$result .= "<th class='text-center'>";
			$result .= $value;
			$result .= "</th>";
		}
		$result .= "</tr>";

		$result .= "<tr>";
		$x = $y - 1;
		foreach ($opciones as $key => $value) {
			$result .= "<td class='text-center'>";
			$result .= "<input type='radio' name='".$this->id."' value='";
				$key = $value;
			$result .= $key;
			$result .= "'></td>";
		}
		$result .= "</tr>";
		$result .= "</table>";
		echo $result;
	}
	
	function getOptions_(){ 	
		$result = "<input type='text' pattern='\d*' required='required' class='speed form-control' maxlength='1' name='".$this->id."'>";
		echo $result;
	}

} // class : end

?>