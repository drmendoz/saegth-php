<?php

class NavbarController extends Controller {
	protected $link;

	function __construct($model, $controller, $action=null, $type = 0) {
		$action = $this->getAction();
		parent::__construct($model, $controller, $action, $type);
		$this->{$action}();
		$this->link = $this->Navbar->getDBHandle();
	}

	function admin(){
		$this->haySession();
	}
	function user(){
		$this->haySession();
	}
	function empresa(){
		$this->haySession();
		$emp = new Empresa();
		$this->set('permiso',$emp->get($_SESSION['Empresa']['id']));
	}
	function temp(){
		$this->haySession();
	}


	function getAction(){
		switch ($_SESSION['USER-AD']['user_rol']) {
			case 0:
			return "admin";
			break;
			case 1:
			return "empresa";
			break;
			case 2:
			return "user";
			break;
			case 4:
			return "temp";
			break;
			case 5:
			return "temp";
			case 6:
			return "temp";
			break;
			case 7:
			return "temp";
			break;
			case 8:
			return "temp";
			break;
			case 9:
			return "temp";
			break;
			case 10:
			return "temp";
			break;
			case 11:
			return "temp";
			break;
			case 12:
			return "temp";
			break;
			case 13:
			return "temp";
			break;
			case 14:
			return "temp";
			break;
			case 15:
			return "temp";
			break;
		}

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







