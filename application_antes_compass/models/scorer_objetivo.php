<?php

// **********************
// CLASS DECLARATION
// **********************

class scorer_objetivo extends Model{ 
// class : begin


// **********************
// ATTRIBUTE DECLARATION
// **********************


	public $id_personal;   
	public $objetivo;   
	public $indicador;   
	public $periodo=2015;   
	public $unidad;   
	public $meta;   
	public $peso;   
	public $lreal;   
	public $lpond;   
	public $ppond;   
	public $inverso;   



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

	function getId_personal(){
		return $this->id_personal;
	}

	function getObjetivo(){
		return $this->htmlprnt($this->objetivo);
	}

	function getIndicador(){
		return $this->htmlprnt($this->indicador);
	}

	function getObjetivo_(){
		return $this->htmlprnt_win($this->objetivo);
	}

	function getIndicador_(){
		return $this->htmlprnt_win($this->indicador);
	}

	function getPeriodo(){
		return $this->periodo;
	}

	function getUnidad(){
		switch ($this->unidad) {
			case '0':
			return "US\$M";
			break;
			case '1':
			return "%";
			break;
			case '2':
			return "Fecha";
			break;
			case '3':
			return "#";
			break;
		}
	}

	function getMeta(){
		return $this->meta;
	}

	function getMeta_(){
		return unserialize($this->meta);
	}

	function getPeso(){
		if(is_nan(floatval($this->peso)) || $this->peso=="" || $this->peso=="NaN")
			return 0;
		else
			return $this->peso;
	}

	function getLreal(){
		if(is_nan(floatval($this->lreal)) || $this->lreal=="" || $this->lreal=="NaN")
			return 0;
		else
			return $this->lreal;
	}

	function getLpond(){
		if(is_nan(floatval($this->lpond)) || $this->lpond=="" || $this->lpond=="NaN")
			return 0;
		else
			return round($this->lpond);
	}

	function getPpond(){
		if(is_nan(floatval($this->ppond)) || $this->ppond=="" || $this->ppond=="NaN")
			return 0;
		else
			return round($this->ppond);
	}

	function getInverso(){
		if($this->inverso)
			return "Sí";
		else
			return "No";
	}

// **********************
// SETTER METHODS
// **********************


	function setId($val){
		$this->id =  $val;
	}

	function setId_personal($val){
		$this->id_personal =  $val;
	}

	function setObjetivo($val){
		$this->objetivo =  $val;
	}

	function setIndicador($val){
		$this->indicador =  $val;
	}

	function setPeriodo($val){
		$this->periodo =  $val;
	}

	function setUnidad($val){
		$this->unidad =  $val;
	}

	function setMeta($val){
		$this->meta =  $val;
	}

	function setPeso($val){
		$this->peso =  $val;
	}

	function setLreal($val){
		$this->lreal =  $val;
	}

	function setLpond($val){
		$this->lpond =  $val;
	}

	function setPpond($val){
		$this->ppond =  $val;
	}

	function setInverso($val){
		$this->inverso =  $val;
	}

// **********************
// SELECT METHOD / LOAD
// **********************

	function select($id){

		$sql =  "SELECT * FROM scorer_objetivo WHERE id = $id;";
		$row =  $this->query_($sql,1);


		$this->id = $row['id'];

		$this->id_personal = $row['id_personal'];

		$this->objetivo = $row['objetivo'];

		$this->indicador = $row['indicador'];

		$this->periodo = $row['periodo'];

		$this->unidad = $row['unidad'];

		$this->meta = $row['meta'];

		$this->peso = $row['peso'];

		$this->lreal = $row['lreal'];

		$this->lpond = $row['lpond'];

		$this->ppond = $row['ppond'];

		$this->inverso = $row['inverso'];

	}

	function cast($parameters){
		foreach($parameters as $key => $value) {
			$this->$key = $value;
		}
	}

	function select_all($id){

		$sql =  "SELECT * FROM scorer_objetivo WHERE id_personal = $id AND periodo = $this->periodo;";
		return  $this->query_($sql);
	}

// **********************
// DELETE
// **********************

	function delete(){
		$sql = "DELETE FROM scorer_objetivo WHERE id = $id;";
		$result = $this->query_($sql);

	}
	function delete_all($id){
		$sql = "DELETE FROM scorer_objetivo WHERE id_personal = $id;";
		$result = $this->query_($sql);

	}

// **********************
// INSERT
// **********************

	function insert(){

		$sql = "INSERT INTO scorer_objetivo ( id_personal,objetivo,indicador,periodo,unidad,meta,peso,lreal,lpond,ppond,inverso ) VALUES ( '$this->id_personal','$this->objetivo','$this->indicador','$this->periodo','$this->unidad','$this->meta','$this->peso','$this->lreal','$this->lpond','$this->ppond','$this->inverso' )";
		$result = $this->query_($sql);
		$this->id = mysqli_insert_id($this->link);

	}

// **********************
// UPDATE
// **********************

	function update(){



		$sql = " UPDATE scorer_objetivo SET  id_personal = '$this->id_personal',objetivo = '$this->objetivo',indicador = '$this->indicador',periodo = '$this->periodo',unidad = '$this->unidad',meta = '$this->meta',peso = '$this->peso',lreal = '$this->lreal',lpond = '$this->lpond',ppond = '$this->ppond',inverso = '$this->inverso' WHERE id = $id ";

		$result = $this->query_($sql);



	}


	public function get_ScorecardRes_(){
		$res = $this->query_('select ifnull(sum(ppond),0) as res from scorer_objetivo where id_personal='.$this->id_personal.'',1);
		$val = $res['res'];
		$val += $val * ($this->get_ajuste($this->id_personal)/100);
		return $val;
	}


}

?>