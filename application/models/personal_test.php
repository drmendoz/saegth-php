<?php
class Personal_test extends Model {
	public $id_personal;
	public $compass_360;
	public $scorer;
  public $matriz;
	public $valoracion;

	public function __construct($parameters = array()) {
		parent::__construct();
    foreach($parameters as $key => $value) {
        $this->$key = $value;
    }
  }

  function insert(){
		$this->query_('INSERT INTO `personal_test` (`id_personal`) VALUES ('.$this->id_personal.')');
  }

  function update(){
		$this->query_('UPDATE `personal_test` SET compass_360='.$this->compass_360.', scorer='.$this->scorer.', matriz='.$this->matriz.', valoracion='.$this->valoracion.' WHERE id_personal='.$this->id_personal.'');
  }

  function loadFromId(){
		$res =$this->query_('SELECT * FROM personal_test WHERE id_personal='.$this->id_personal.'',1);
		return new self($res);
  }

  public static function insertById($id) {
  	$tmp = new self(array('id_personal' => $id));	
  	$tmp->insert();
    return $tmp->loadFromId();
  }

  public static function withID($id) {
    $tmp = new self(array('id_personal' => $id));  
    return $tmp->loadFromId();
  }

}