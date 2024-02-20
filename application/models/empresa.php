<?php

// **********************
// CLASS DECLARATION
// **********************

class empresa extends Model{ 
// class : begin


// **********************
// ATTRIBUTE DECLARATION
// **********************

	public $id;						
	public $nombre;  						  
	public $activo;  						  
	public $admin;  						  
	public $email;  						  
	public $token;  						  
	public $compass_360;  						  
	public $scorer;  						  
	public $matriz;  						  
	public $valoracion;  						  
	public $retencion;  						  
	public $clima_laboral;  						  
	public $cobertura;  						  
	public $psicosocial;  						  
	public $foto;  						  



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

	function getNombre(){
		return $this->nombre;
	}

	function getActivo(){
		return $this->activo;
	}

	function getAdmin(){
		return $this->admin;
	}

	function getEmail(){
		return $this->email;
	}

	function getToken(){
		return $this->token;
	}

	function getCompass_360(){
		return $this->compass_360;
	}

	function getScorer(){
		return $this->scorer;
	}

	function getMatriz(){
		return $this->matriz;
	}

	function getValoracion(){
		return $this->valoracion;
	}

	function getClima_laboral(){
		return $this->clima_laboral;
	}

	function getRetencion(){
		return $this->retencion;
	}

	function getCobertura(){
		return $this->cobertura;
	}

	function getPsicosocial(){
		return $this->psicosocial;
	}

	function getFoto(){
		$this->foto = $this->query_("select foto from empresa_datos where id_empresa={$this->id}",1);
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

	function setActivo($val){
		$this->activo =  $val;
	}

	function setAdmin($val){
		$this->admin =  ucwords(trim($val));
	}

	function setEmail($val){
		$this->email =  $val;
	}

	function setToken($val){
		$this->token =  $val;
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

	function setValoracion($val){
		$this->valoracion =  $val;
	}

	function setClima_laboral($val){
		$this->clima_laboral =  $val;
	}

	function setRetencion($val){
		$this->retencion =  $val;
	}

	function setCobertura($val){
		$this->cobertura =  $val;
	}

	function setPsicosocial($val){
		$this->psicosocial =  $val;
	}

// **********************
// SELECT METHOD / LOAD
// **********************

	function select($id){

		$sql =  "SELECT * FROM empresa WHERE id = $id;";
		$row =  $this->query_($sql,1);


		$this->id = $row['id'];

		$this->nombre = $row['nombre'];

		$this->activo = $row['activo'];

		$this->admin = $row['admin'];

		$this->email = $row['email'];

		$this->token = $row['token'];

		$this->compass_360 = $row['compass_360'];

		$this->scorer = $row['scorer'];

		$this->matriz = $row['matriz'];

		$this->valoracion = $row['valoracion'];

		$this->retencion = $row['retencion'];

		$this->clima_laboral = $row['clima_laboral'];

		$this->cobertura = $row['cobertura'];

		$this->psicosocial = $row['psicosocial'];

	}

	function get($id){

		$sql =  "SELECT compass_360, scorer, matriz, valoracion, clima_laboral, retencion, cobertura, psicosocial, evaluacion_desempenio FROM empresa WHERE id = $id;";
		$row =  $this->query_($sql,1);
		return $row;
	}

	function selectAll(){
		return $this->query_('SELECT * FROM empresa');
	}

	function getById(){
		$res =$this->query_('SELECT * FROM empresa WHERE id='.$this->id.'',1);
		return new self($res);
	}

	public static function withID($id) {
		$tmp = new self(array('id' => $id));	
		return $tmp->getById();
	}

// **********************
// DELETE
// **********************

	function delete(){
		$sql = "DELETE FROM empresa WHERE id = $this->id;";
		$result = $this->query_($sql);

	}

// **********************
// INSERT
// **********************

	function insert(){

		$sql = "INSERT INTO empresa ( nombre,activo,admin,email,token,compass_360,scorer,matriz,valoracion,retencion,clima_laboral,cobertura,psicosocial ) VALUES ( '$this->nombre',1,'$this->admin','$this->email','$this->token','$this->compass_360','$this->scorer','$this->matriz','$this->valoracion','$this->retencion','$this->clima_laboral','$this->cobertura','$this->psicosocial' )";
		$result = $this->query_($sql);
		$this->id = mysqli_insert_id($this->link);
		if(mysqli_error($this->link))
			return 0;
		else
			return 1;

	}

// **********************
// UPDATE
// **********************

	function update(){



		$sql = " UPDATE empresa SET  nombre = '$this->nombre',activo = '$this->activo',admin = '$this->admin',email = '$this->email',token = '$this->token',compass_360 = '$this->compass_360',scorer = '$this->scorer',matriz = '$this->matriz',valoracion = '$this->valoracion',retencion = '$this->retencion',clima_laboral = '$this->clima_laboral',cobertura = '$this->cobertura',psicosocial = '$this->psicosocial' WHERE id = $id ";

		$result = $this->query_($sql);



	}


} // class : end

?>