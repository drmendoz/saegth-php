<?php

class Sonda_user_foda extends Model{ 

	public $comentario;
	public $tipo;
	public $id_suser;
	public $id_test;




	public function __construct($parameters = array()) {
		parent::__construct();
		foreach($parameters as $key => $value) {
			$this->$key = $value;
		}
	}

	

	function getComentario(){
		return $this->comentario;
	}

	function getTipo(){
		return $this->tipo;
	}

	function getId_suser(){
		return $this->id_suser;
	}

	function getId_test(){
		return $this->id_test;
	}



	function setComentario($val){
		$this->comentario =  $val;
	}

	function setTipo($val){
		$this->tipo =  $val;
	}

	function setId_suser($val){
		$this->id_suser =  $val;
	}

	function setId_test($val){
		$this->id_test =  $val;
	}


	//
	function insert(){
		$sql = "INSERT INTO sonda_users_foda (comentario, tipo, id_suser, id_test) VALUES('$this->comentario', '$this->tipo', '$this->id_suser', '$this->id_test') ";
		//echo "$sql<br>";
		$result = $this->query_($sql);
	}

	function select_x_user($id_t, $ids){
		$sql = "SELECT * FROM sonda_users_foda WHERE id_suser IN($ids) AND id_test = $id_t";
		//echo "$sql<br>";
		$result = $this->query_($sql);
		return $result;
	}
}