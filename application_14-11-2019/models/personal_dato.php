<?php
class Personal_dato extends Model {
	public $id_persona;
	public $pais;
	public $ciudad;
	public $sector;
	public $calles;
	public $manz;
	public $villa;
	public $num_con;
	public $num_cel;
	public $cedula;
	public $fecha_nac;
	public $fecha_ing;
	public $email;
	public $sexo;


	public function __construct($parameters = array()) {
		parent::__construct();
		foreach($parameters as $key => $value) {
			$this->$key = $value;
		}
	}

	function insert(){
		$this->query_('INSERT INTO `personal_datos` (`id_persona`,`pais`,`ciudad`,`sector`,`calles`,`manz`,`villa`, `num_con`, `num_cel`, `cedula`, `fecha_nac`, `fecha_ing`, `email`, `sexo`) VALUES ('.$this->id_persona.',"'.$this->pais.'","'.$this->ciudad.'","'.$this->sector.'","'.$this->calles.'","'.$this->manz.'","'.$this->villa.'"," '.$this->num_con.'"," '.$this->num_cel.'"," '.$this->cedula.'"," '.$this->fecha_nac.'"," '.$this->fecha_ing.'","'.$this->email.'","'.$this->sexo.'")');
	}

	public static function loadFromId($id){
		$obj = new self();
		$d_per = $obj->query_('SELECT * FROM `personal_datos` WHERE `id_persona`='. $id .'',1);
		if($d_per)
			return new self($d_per);
		else
			return null;
	}

	public function get_pais(){
		return $this->htmlprnt($this->pais);
	}
	public function get_ciudad(){
		return $this->htmlprnt($this->ciudad);
	}
	public function get_sector(){
		return $this->htmlprnt($this->sector);
	}
	public function get_calles(){
		return $this->htmlprnt($this->calles);
	}
	public function get_manz(){
		return $this->htmlprnt($this->manz);
	}
	public function get_villa(){
		return $this->htmlprnt($this->villa);
	}
	public function get_num_con(){
		return $this->htmlprnt($this->num_con);
	}
	public function get_num_cel(){
		return $this->htmlprnt($this->num_cel);
	}
	public function get_cedula(){
		return $this->htmlprnt($this->cedula);
	}
	public function get_fecha_nac(){
		return $this->print_fecha($this->fecha_nac);
	}
	public function get_fecha_ing(){
		return $this->print_fecha($this->fecha_ing);
	}
	public function get_email(){
		return $this->htmlprnt($this->email);
	}
	public function get_sexo(){
		return $this->htmlprnt($this->sexo);
	}
	public function set_id_persona($var){
		$this->id_persona = $var;
	}
	public function set_pais($var){
		$this->pais = $var;
	}
	public function set_ciudad($var){
		$this->ciudad = $var;
	}
	public function set_sector($var){
		$this->sector = $var;
	}
	public function set_calles($var){
		$this->calles = $var;
	}
	public function set_manz($var){
		$this->manz = $var;
	}
	public function set_villa($var){
		$this->villa = $var;
	}
	public function set_num_con($var){
		$this->num_con = $var;
	}
	public function set_num_cel($var){
		$this->num_cel = $var;
	}
	public function set_cedula($var){
		$this->cedula = $var;
	}
	public function set_fecha_nac($var){
		$this->fecha_nac = $var;
	}
	public function set_fecha_ing($var){
		$this->fecha_ing = $var;
	}
	public function set_email($var){
		$this->email = $var;
	}
	public function set_sexo($var){
		$this->sexo = $var;
	}

}