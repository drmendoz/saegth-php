<?php

class ValoracionController extends Controller {

	protected $link;
	
	function __construct($model, $controller, $action, $type = 0, $full = false,$render=false) {

		parent::__construct($model, $controller, $action, $type, $type, $full,$render);

		$this->link = $this->Valoracion->getDBHandle();
	}

	function crear($args=null){
		$this->haySession();


		if(isset($_POST['button'])){
			$obj = array(
				'id_empresa' => $_SESSION['Empresa']['id'], 
				'position' => $_POST['textfield'], 
				'kh_col1' => $_POST['z'], 
				'kh_col2' => $_POST['z2'], 
				'ps_col1' => $_POST['y1'], 
				'ps_col2' => $_POST['y2'], 
				'ac_col1' => $_POST['x1'], 
				'ac_col2' => $_POST['x2'], 
				'total' => $_POST['x4'], 
				'profile' => $_POST['7'], 
			);
			$ent = new Valoracion($obj);
			$ent->insert();
		}

		if(isset($args)){
			$this->set('action',$args['action']);
			$this->set('ent',$args['ent']);
			$this->set('id',$args['id']);
		}else{
			$this->set('action','crear');
		}
		
	}

	function home(){
		$this->haySession();
	}

	function ver(){
		$this->haySession();
		$ent = new Valoracion(array('id_empresa' => $_SESSION['Empresa']['id']));
		$this->set('res',$ent->select_all());
	}

	function editar($id="null"){
		$this->haySession();


		if(isset($_POST['button'])){
			$this->set('fixed_back','valoracion/home');
			$obj = array(
				'id' => $id, 
				'id_empresa' => $_SESSION['Empresa']['id'], 
				'position' => $_POST['textfield'], 
				'kh_col1' => $_POST['z'], 
				'kh_col2' => $_POST['z2'], 
				'ps_col1' => $_POST['y1'], 
				'ps_col2' => $_POST['y2'], 
				'ac_col1' => $_POST['x1'], 
				'ac_col2' => $_POST['x2'], 
				'total' => $_POST['x4'], 
				'profile' => $_POST['7'], 
			);
			$ent = new Valoracion($obj);
			$ent->update();
		}
		$_POST=null;
		if(isset($id)){
			$ent = Valoracion::withID($id);
			$this->set('args',
				$args = array(
					'action' => 'editar/'.$id, 
					'ent' => $ent, 
					'id' => $id, 
				)
			);
		}
	}

	function clonar($id="null"){
		$this->haySession();


		if(isset($_POST['button'])){
			$this->set('fixed_back','valoracion/home');
			$obj = array(
				'id_empresa' => $_SESSION['Empresa']['id'], 
				'position' => $_POST['textfield'], 
				'kh_col1' => $_POST['z'], 
				'kh_col2' => $_POST['z2'], 
				'ps_col1' => $_POST['y1'], 
				'ps_col2' => $_POST['y2'], 
				'ac_col1' => $_POST['x1'], 
				'ac_col2' => $_POST['x2'], 
				'total' => $_POST['x4'], 
				'profile' => $_POST['7'], 
			);
			$ent = new Valoracion($obj);
			$ent->insert();
			header('Location: '.BASEURL.'valoracion/ver');
		}
		$_POST=null;
		if(isset($id)){
			$ent = Valoracion::withID($id);
			$this->set('args',
				$args = array(
					'action' => 'clonar/'.$id, 
					'ent' => $ent, 
					'id' => $id, 
				)
			);
		}
	}

	function local_holder(){
		$this->haySession();
	}

	function empresa_holder(){
		$this->haySession();
	}

	function mailer(){
		$this->haySession();
	}


	function p_scorecard(){
		$this->haySession();
	}

	function personal_search(){
		$this->haySession();
		static $personal;
		if($_REQUEST){
			if(@array_search($_REQUEST['personal'], $personal)){
				exit();
			}else{
				$personal[] = $_REQUEST['personal'];
			}
		}
	}
	
	function haySession(){
		Util::sessionStart();
		if (!isset($_SESSION['USER-AD'])){
			$this->logout();	
		}
		return true;
	}

	function hayEmpresa(){
		$this->haySession();
		if (!isset($_SESSION['Empresa'])){
			$this->_template = new Template('Admin','empresa_seleccion');
			$this->empresa_seleccion(Controller::getAction());
			exit();
		}
	}

	function hayPersonal(){
		$this->haySession();
		if (!isset($_SESSION['personal'])){
			$this->_template = new Template('Admin','personal_ingreso');
			$this->personal_ingreso();
			exit();
		}
	}
	function logout(){
		Util::sessionLogout();
		$this->Valoracion->disconnect();
		$this->_template = new Template('Inicio','principal', false);
	}
}






