<?php
class Scorer_reval extends Model {
	public $id;
	public $id_personal;
	public $comentario;
	// autor:
	// 0 = empleado
	// 1 = empleador
	public $autor;
	// tipo:
	// 0 = revision
	// 1 = evaluacion
	public $tipo;
	public $periodo;
	public $fecha;
	
	public function __construct($parameters = array()) {
			parent::__construct();
      foreach($parameters as $key => $value) {
          $this->$key = $value;
      }
  }

  function insert(){
		$this->query('INSERT INTO scorer_reval (id_personal,comentario,autor,tipo,periodo,fecha) VALUES ('.$this->id_personal.',"'.$this->comentario.'",'.$this->autor.','.$this->tipo.','.var_export($this->periodo, true).',"'.$this->fecha.'")');
  }

  function clear_db(){
		$this->query('DELETE FROM scorer_reval WHERE id_personal='.$this->id_personal.' AND tipo='.$this->tipo.' AND periodo='.$this->periodo.'');
  }

  function selectAll(){
		return $this->query_('SELECT * FROM scorer_reval WHERE id_personal='.$this->id_personal.' AND autor='.$this->autor.' AND tipo='.$this->tipo.' AND periodo='.$this->periodo.'');
  }

  public static function withID( $id,$autor,$tipo,$periodo) {
  	return new self(array('id_personal' => $id,'autor' => $autor,'tipo' => $tipo,'periodo' => $periodo));	
  }

}