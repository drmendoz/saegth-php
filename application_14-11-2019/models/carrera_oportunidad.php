<?php
class Carrera_oportunidad extends Model {
  public $id;
  public $id_personal;
  public $id_area;
  public $id_cargo;
  public $accion;
  public $tipo;
  public $medicion;
	public $fecha;
	
	public function __construct($parameters = array()) {
			parent::__construct();
      foreach($parameters as $key => $value) {
          $this->$key = $value;
      }
  }

  function insert(){
		$this->query('INSERT INTO carrera_oportunidades (id_personal,objetivo) VALUES ('.$this->id_personal.',"'.$this->id_area.'","'.$this->id_cargo.'","'.$this->fecha.'")');
		$this->id = mysqli_insert_id($this->link);
  	if(mysqli_error($this->link))
      return 0;
    else
      return 1;
  }

  function update(){
		$this->query('UPDATE carrera_oportunidades SET accion="'.$this->accion.'", tipo="'.$this->tipo.'", medicion="'.$this->medicion.'", fecha="'.$this->fecha.'" WHERE id='.$this->id.'');
  }

  function delete(){
    $this->query('DELETE FROM carrera_oportunidades WHERE id='.$this->id.'');
  }

  function getObj(){
  	$this->objetivo = $this->query_('SELECT objetivo FROM carrera_oportunidades WHERE id='.$this->id.'',1)['objetivo'];
  }

  function selectAll(){
		return $this->query_('SELECT * FROM carrera_oportunidades WHERE id_personal='.$this->id_personal.'');
  }

}