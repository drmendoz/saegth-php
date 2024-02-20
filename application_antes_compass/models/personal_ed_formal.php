<?php
class Personal_ed_formal extends Model {
	public $id;
	public $id_persona;
	public $titulo;
	public $carrera;
	public $area_estudio;
	public $institucion;
	public $pais;
	public $ciudad;
	public $fecha;

	public function __construct($parameters = array()) {
		parent::__construct();
    foreach($parameters as $key => $value) {
        $this->$key = $value;
    }
  }

	public static function select_all($id){
		$obj = new Personal_ed_formal();
		return $obj->query_('SELECT * FROM `personal_ed_formal` WHERE `id_persona`='. $id .'');
	}

	public function get_titulo(){
		return $this->htmlprnt($this->titulo);
	}
	public function get_carrera(){
		return $this->htmlprnt($this->carrera);
	}
	public function get_area_estudio(){
		return $this->htmlprnt($this->area_estudio);
	}
	public function get_institucion(){
		return $this->htmlprnt($this->institucion);
	}
	public function get_pais(){
		return $this->htmlprnt($this->pais);
	}
	public function get_ciudad(){
		return $this->htmlprnt($this->ciudad);
	}
	public function get_fecha(){
		return $this->print_fecha($this->fecha);
	} 

}