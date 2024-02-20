<?php

class NominaController extends Controller {

	protected $link;
	
	function __construct($model, $controller, $action=null, $type = 0,$full=false,$render=false) {

		parent::__construct($model, $controller, $action, $type,$full,$render);
		$this->link = $this->Nomina->getDBHandle();
	}

	function items(){
		$this->haySession();
	}
	
	function esGerente(){
		Util::sessionStart();
		$res=$this->Nomina->query('SELECT * FROM personal WHERE id IN(SELECT DISTINCT id_evaluado FROM multifuente_evaluadores WHERE relacion=0 AND id_personal='.$_SESSION['USER-AD']['id_personal'].')');
		if($res)
			return true;
		return false;
	}

	function haySession(){
		Util::sessionStart();
		if (!isset($_SESSION['USER-AD'])){
			$this->logout();
			exit;	
		}
		return true;
	}

}