	 <?php

// **********************
// CLASS DECLARATION
// **********************

class personal_idioma extends Model{ 

// **********************
// ATTRIBUTE DECLARATION
// **********************


	public $id_personal;   
	public $institucion;   
	public $entendimiento;   
	public $escrito;   
	public $hablado;   
	public $leido;   
	public $fecha_desde;   
	public $fecha_hasta;   
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

	function getIdioma(){
		return $this->htmlprnt($this->idioma);
	}

	function getIdioma_(){
		return $this->htmlprnt_win($this->idioma);
	}

	function getInstitucion(){
		return $this->htmlprnt($this->institucion);
	}

	function getInstitucion_(){
		return $this->htmlprnt_win($this->institucion);
	}

	function getEntendimiento(){
		switch ($this->entendimiento) {
		case 0: 
			$x = 'Muy básico';
			break;
		case 1: 
			$x = 'Básico';
			break;
		case 2: 
			$x = 'Intermedio';
			break;
		case 3: 
			$x = 'Avanzado';
			break;
		case 4: 
			$x = 'Nativo';
			break;
		}
		return $x;
	}

	function getEscrito(){
		switch ($this->escrito) {
		case 0: 
			$x = 'Muy básico';
			break;
		case 1: 
			$x = 'Básico';
			break;
		case 2: 
			$x = 'Intermedio';
			break;
		case 3: 
			$x = 'Avanzado';
			break;
		case 4: 
			$x = 'Nativo';
			break;
		}
		return $x;
	}

	function getHablado(){
		switch ($this->hablado) {
		case 0: 
			$x = 'Muy básico';
			break;
		case 1: 
			$x = 'Básico';
			break;
		case 2: 
			$x = 'Intermedio';
			break;
		case 3: 
			$x = 'Avanzado';
			break;
		case 4: 
			$x = 'Nativo';
			break;
		}
		return $x;
	}

	function getLeido(){
		switch ($this->leido) {
		case 0: 
			$x = 'Muy básico';
			break;
		case 1: 
			$x = 'Básico';
			break;
		case 2: 
			$x = 'Intermedio';
			break;
		case 3: 
			$x = 'Avanzado';
			break;
		case 4: 
			$x = 'Nativo';
			break;
		}
		return $x;
	}

	function getFecha_desde(){
		return $this->fecha_desde;
	}

	function getFecha_hasta(){
		return $this->fecha_hasta;
	}

	function getFecha_desde_(){
		return $this->htmlprnt(strftime("%d de %B del %Y",strtotime($this->getFecha_desde())));
	}

	function getFecha_hasta_(){
		return $this->htmlprnt(strftime("%d de %B del %Y",strtotime($this->getFecha_hasta())));
	}

// **********************
// SETTER METHODS
// **********************


	function setId($val){
		$this->id =  $val;
		return $this;
	}

	function setId_personal($val){
		$this->id_personal =  $val;
		return $this;
	}

	function setIdioma($val){
		$this->idioma =  $val;
		return $this;
	}

	function setInstitucion($val){
		$this->institucion =  $val;
		return $this;
	}

	function setEntendimiento($val){
		$this->entendimiento =  $val;
		return $this;
	}

	function setEscrito($val){
		$this->escrito =  $val;
		return $this;
	}

	function setHablado($val){
		$this->hablado =  $val;
		return $this;
	}

	function setLeido($val){
		$this->leido =  $val;
		return $this;
	}

	function setFecha_desde($val){
		$this->fecha_desde =  $val;
		return $this;
	}

	function setFecha_hasta($val){
		$this->fecha_hasta =  $val;
		return $this;
	}

	function setFecha_desde_($val){
		$this->fecha_desde =  $val;
		return $this;
	}

	function setFecha_hasta_($val){
		$this->fecha_hasta =  $val;
		return $this;
	}

// **********************
// SELECT METHOD / LOAD
// **********************

	function select($id){

		$sql =  "SELECT * FROM personal_idioma WHERE id = $id;";
		$row =  $this->query_($sql,1);

		$this->id = $row['id'];
		$this->id_personal = $row['id_personal'];
		$this->idioma = $row['idioma'];
		$this->institucion = $row['institucion'];
		$this->entendimiento = $row['entendimiento'];
		$this->escrito = $row['escrito'];
		$this->hablado = $row['hablado'];
		$this->leido = $row['leido'];
		$this->fecha_desde = $row['fecha_desde'];
		$this->fecha_hasta = $row['fecha_hasta'];

	}

	function select_all($id_p=null){
		$ext = (isset($id_p)) ? $id_p : $_SESSION['USER-AD']['id_personal'] ;
		$sql =  "SELECT * FROM personal_idioma WHERE id_personal = ". $ext .";";
		return $this->query_($sql);
	}

// **********************
// DELETE
// **********************

	function delete(){
		$sql = "DELETE FROM personal_idioma WHERE id = $id;";
		$result = $this->query_($sql);

	}

// **********************
// INSERT
// **********************

	function insert(){

		$sql = "INSERT INTO personal_idioma ( id_personal,idioma,institucion,entendimiento,escrito,hablado,leido,fecha_desde,fecha_hasta ) VALUES ( '$this->id_personal','$this->idioma','$this->institucion','$this->entendimiento','$this->escrito','$this->hablado','$this->leido','$this->fecha_desde','$this->fecha_hasta' )";
		$result = $this->query_($sql);
		$this->id = mysqli_insert_id($this->link);

	}

// **********************
// UPDATE
// **********************

	function update(){
		$sql = " UPDATE personal_idioma SET  id_personal = '$this->id_personal',idioma = '$this->idioma',institucion = '$this->institucion',entendimiento = '$this->entendimiento',escrito = '$this->escrito',hablado = '$this->hablado',leido = '$this->leido',fecha_desde = '$this->fecha_desde',fecha_hasta = '$this->fecha_hasta' WHERE id = $id ";
		$result = $this->query_($sql);
	}

}
?>