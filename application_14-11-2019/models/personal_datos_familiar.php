<?php

// **********************
// CLASS DECLARATION
// **********************

class personal_datos_familiar extends Model{ 
// class : begin


// **********************
// ATTRIBUTE DECLARATION
// **********************


	public $id_personal;   
	public $estado_civil;   
	public $n_conyugue;   
	public $fn_conyugue;   
	public $f_matrimonio;   
	public $t_hijos;   



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


	function getId_personal(){
		return $this->id_personal;
	}

	function getEstado_civil(){
		return $this->estado_civil;
	}

	function getN_conyugue(){
		return $this->htmlprnt($this->n_conyugue);
	}

	function getFn_conyugue(){
		return $this->fn_conyugue;
	}

	function getF_matrimonio(){
		return $this->f_matrimonio;
	}

	function getT_hijos(){
		return $this->t_hijos;
	}

// **********************
// SETTER METHODS
// **********************


	function setId_personal($val){
		$this->id_personal =  $val;
	}

	function setEstado_civil($val){
		$this->estado_civil =  $this->mres($val);
	}

	function setN_conyugue($val){
		$this->n_conyugue =  $this->mres($val);
	}

	function setFn_conyugue($val){
		$this->fn_conyugue =  $this->mres($val);
	}

	function setF_matrimonio($val){
		$this->f_matrimonio =  $this->mres($val);
	}

	function setT_hijos($val){
		$this->t_hijos =  $this->mres($val);
	}

// **********************
// SELECT METHOD / LOAD
// **********************

	function select($id){

		$sql =  "SELECT * FROM personal_datos_familiar WHERE id_personal = $id;";
		$row =  $this->query_($sql,1);

		if($row){	
			$this->id_personal = $row['id_personal'];
			$this->estado_civil = $row['estado_civil'];
			$this->n_conyugue = $row['n_conyugue'];
			$this->fn_conyugue = $row['fn_conyugue'];
			$this->f_matrimonio = $row['f_matrimonio'];
			$this->t_hijos = $row['t_hijos'];
			return true;
		}else
			return false;

	}

// **********************
// DELETE
// **********************

	function delete(){
		$sql = "DELETE FROM personal_datos_familiar WHERE id_personal = $id_personal;";
		$result = $this->query_($sql);

	}

// **********************
// INSERT
// **********************

	function insert(){

		$sql = "INSERT INTO personal_datos_familiar ( id_personal,estado_civil,n_conyugue,fn_conyugue,f_matrimonio,t_hijos ) VALUES ( $this->id_personal,'$this->estado_civil','$this->n_conyugue','$this->fn_conyugue','$this->f_matrimonio','$this->t_hijos' ) ON DUPLICATE KEY UPDATE estado_civil='$this->estado_civil', n_conyugue='$this->n_conyugue', fn_conyugue='$this->fn_conyugue', f_matrimonio='$this->f_matrimonio', t_hijos='$this->t_hijos'";
		$result = $this->query_($sql);
	}

// **********************
// UPDATE
// **********************

	function update(){



		$sql = " UPDATE personal_datos_familiar SET  estado_civil = '$this->estado_civil',n_conyugue = '$this->n_conyugue',fn_conyugue = '$this->fn_conyugue',f_matrimonio = '$this->f_matrimonio',t_hijos = '$this->t_hijos' WHERE id_personal = $id ";

		$result = $this->query_($sql);



	}


} 

?>