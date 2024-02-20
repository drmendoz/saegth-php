<?php
class Grado_salarial extends Model {
  public $grado;
  public $r_min;
  public $r_med;
  public $r_max;
	public $id_empresa;
	
	public function __construct($parameters = array()) {
			parent::__construct();
      foreach($parameters as $key => $value) {
          $this->$key = $value;
      }
  }

  function insert(){
		$this->query('INSERT INTO grado_salarial (grado,r_min,r_med,r_max,id_empresa) VALUES ('.$this->grado.','.$this->r_min.','.$this->r_med.','.$this->r_max.','.$this->id_empresa.')');
    $this->id = mysqli_insert_id($this->link);
  }

  function update(){
    $this->query('UPDATE grado_salarial SET grado='.$this->grado.', r_min='.$this->r_min.', r_med='.$this->r_med.', r_max='.$this->r_max.' WHERE id='.$this->id.'');
  }

  function delete(){
    $this->query('DELETE FROM grado_salarial WHERE id='.$this->id.'');
  }

  public static function clear_db($id){
    $tmp = new self(array('id_empresa'=>$id));
    $tmp->query_('DELETE FROM grado_salarial WHERE id_empresa='.$id.'');
  }

  public static function select_all($id){
    $tmp = new self(array('id_empresa'=>$id));
    return $tmp->query_('SELECT * FROM grado_salarial WHERE id_empresa='.$tmp->id_empresa.'');
  }

  public static function create($grado, $r_min, $r_med, $r_max, $id_empresa){
		return new self(
      array(
        'grado' => $grado, 
        'r_min' => $r_min, 
        'r_med' => $r_med, 
        'r_max' => $r_max, 
        'id_empresa' => $id_empresa, 
      )
    );
  }

}