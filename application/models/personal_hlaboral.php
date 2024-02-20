<?php
class Personal_hlaboral extends Model {
	public $id;
	public $id_persona;
	public $cargo;
	public $empresa;
	public $f_inicio;
	public $f_fin;
	public $descripcion;

	public function __construct($parameters = array()) {
		parent::__construct();
    foreach($parameters as $key => $value) {
        $this->$key = $value;
    }
  }

	public static function select_all($id){
		$obj = new Personal_hlaboral();
		return $obj->query_('SELECT * FROM `personal_hlaboral` WHERE `id_persona`='. $id .'');
	}

	public function get_cargo_(){
		return $this->htmlprnt($this->cargo);
	}
	public function get_empresa(){
		return $this->htmlprnt($this->empresa);
	}
	public function get_f_inicio(){
		return $this->print_fecha($this->f_inicio);
	}
	public function get_f_fin(){
		return $this->print_fecha($this->f_fin);
	}
	public function get_descripcion(){
		return $this->htmlprnt($this->descripcion);
	}

}