<?php

class TempController extends Controller {

	protected $link;
	
	function __construct($model, $controller, $action=null, $type = 0,$full=false,$render=false) {

		parent::__construct($model, $controller, $action, $type,$full,$render);
		$this->link = $this->Temp->getDBHandle();
	}
		
	function home($tab=null) {
		$this->set('title','Alto Desempe&ntilde;o | Home');
		$this->haySession();
	}	
	function evaluacion() {
		$this->set('title','Alto Desempe&ntilde;o | Encuesta Clima Laboral');
		$this->haySession();
	}

	function haySession(){
		Util::sessionStart();
		if (!isset($_SESSION['USER-AD'])){
			$this->logout();
			exit;	
		}
		return true;
	}

	function logout(){
		Util::sessionLogout();
		$this->Temp->disconnect();
	}
}