<?php

class InicioController extends Controller {

	protected $Admin;
	protected $link;
	
	function __construct($model, $controller, $action, $type = 0) {
		
		parent::__construct($model, $controller, $action, $type);
		
		$this->Admin = new Admin;
		$this->link = $this->Inicio->getDBHandle();
		
	}
	
	function genTK($a){
		if (($a % 2)!= 0){
			$a++;
		}
		$A = array();
		for ($x = 0; $x < ($a/2) ; $x++){
			$A[$x]=chr(rand(65,90));
		}
		for ($x = ($a/2); $x < $a ; $x++){
			$A[$x]=rand(0,9);
		}
		for ($x = 0; $x < $a ; $x++){
			$y = rand(0,($a-1));
			$z = rand(0,($a-1));
			$tmp = $A[$y];
			$A[$y] = $A[$z];
			$A[$z] = $tmp;
		}
		return implode('', $A);		
	}

	#Realiza funciones de log-in
	
	function principal($logout=false) {
		$this->set('title','Alto Desempe&ntilde;o');
		Util::sessionStart();
		if(!$logout){
			if (isset($_SESSION['USER-AD'])){
				if ($_SESSION['USER-AD']["user_rol"] == 0){
					$this->_template = new Template('Void','render');
					$dispatch = new AdminController('Admin','admin','home',0);
					$dispatch->home();
				}elseif($_SESSION['USER-AD']["user_rol"] == 1){
					$this->_template = new Template('Void','render');
					$dispatch = new EmpresaController('Empresa','empresa','home',0);
					$dispatch->home();
				}elseif($_SESSION['USER-AD']["user_rol"] == 2){
					$this->_template = new Template('Void','render');
					$dispatch = new UserController('User','user','home',0);
					$dispatch->home();
				}elseif($_SESSION['USER-AD']["user_rol"] == 4){
					$this->_template = new Template('Void','render');
					$dispatch = new TempController('Temp','temp','home',0);
					$dispatch->home();
				}elseif($_SESSION['USER-AD']["user_rol"] == 5){
					$this->_template = new Template('Void','render');
					$dispatch = new TempController('Temp','temp','home',0);
					$dispatch->home();
				}elseif($_SESSION['USER-AD']["user_rol"] == 6){
					$this->_template = new Template('Void','render');
					$dispatch = new TempController('Temp','temp','home',0);
					$dispatch->home();
				}elseif($_SESSION['USER-AD']["user_rol"] == 7){
					$this->_template = new Template('Void','render');
					$dispatch = new TempController('Temp','temp','home',0);
					$dispatch->home();
				}elseif($_SESSION['USER-AD']["user_rol"] == 8){
					$this->_template = new Template('Void','render');
					$dispatch = new TempController('Temp','temp','home',0);
					$dispatch->home();
				}elseif($_SESSION['USER-AD']["user_rol"] == 9){
					$this->_template = new Template('Void','render');
					$dispatch = new TempController('Temp','temp','home',0);
					$dispatch->home();
				}else{
					$this->logout();
				}
			}else{
				if(isset($_POST['usuario']) && isset($_POST['password'])){
					$user = mysqli_real_escape_string($this->link,$_POST['usuario']);
					$password = mysqli_real_escape_string($this->link,$_POST['password']);
					
					$userArr = $this->Inicio->query(' select * from users where user_name = \''. $user .'\' and password = \''. Util::passHasher($password,6) .'\' order by id desc limit 1');
					
					if (!$userArr){
						$this->addLoginAttempt($_SERVER['REMOTE_ADDR']);
						$this->set('disclaimer','Por favor verifique los datos');
					}else{
						$this->clearLoginAttempts($_SERVER['REMOTE_ADDR']);
						$_SESSION['USER-AD'] = $userArr[0]["User"];
						$header_info=$this->getHeaderInfo($_SESSION['USER-AD']["user_rol"]);
						$_SESSION['link']=$header_info['link'];
						$empresa = new Empresa;
						$empresa->select($userArr[0]["User"]['id_empresa']);
						if($_SESSION['USER-AD']["user_rol"] != 0){
							if(!$empresa->getActivo()){
								$this->logout();
								header("Location: ".BASEURL);
								exit();
							}
						}
						if ($_SESSION['USER-AD']["user_rol"] == 0){
							header("Location: ".BASEURL."admin/home");
						}elseif ($_SESSION['USER-AD']["user_rol"] == 1){
							$_SESSION['Empresa']['id'] = $userArr[0]["User"]['id_empresa'];
							$res = $this->Inicio->query_('SELECT nombre,admin FROM empresa WHERE id="'. $_SESSION['Empresa']['id'] .'"',1);
							$_SESSION['Empresa']['nombre'] = $res['nombre'];
							$_SESSION['Empresa']['admin'] = $res['admin'];
							header("Location: ".BASEURL."empresa/home");
						}elseif ($_SESSION['USER-AD']["user_rol"] == 2){
							$_SESSION['Empresa']['id'] = $userArr[0]["User"]['id_empresa'];
							$res = $this->Inicio->query_('SELECT nombre FROM empresa WHERE id="'. $_SESSION['Empresa']['id'] .'"',1);
							$_SESSION['Empresa']['nombre'] = $res['nombre'];
							$lp = new listado_personal_op();
							$lp->select($_SESSION['USER-AD']["id_personal"]);
							$lp->unlinkAll();
							$_SESSION['info_personal'] = $lp;
							$_SESSION['Personal']['nombre'] = $lp->nombre;
							header("Location: ".BASEURL."user/home");
						}elseif ($_SESSION['USER-AD']["user_rol"] == 4){
							$_SESSION['Empresa']['id'] = $userArr[0]["User"]['id_empresa'];
							$res = $this->Inicio->query_('SELECT nombre FROM empresa WHERE id="'. $_SESSION['Empresa']['id'] .'"',1);
							$_SESSION['Empresa']['nombre'] = $res['nombre'];
							header("Location: ".BASEURL."temp/home");
						}elseif ($_SESSION['USER-AD']["user_rol"] == 5){
							$_SESSION['Empresa']['id'] = $userArr[0]["User"]['id_empresa'];
							$res = $this->Inicio->query_('SELECT nombre FROM empresa WHERE id="'. $_SESSION['Empresa']['id'] .'"',1);
							$_SESSION['Empresa']['nombre'] = $res['nombre'];
							header("Location: ".BASEURL."temp/home");
						}elseif ($_SESSION['USER-AD']["user_rol"] == 6){
							$_SESSION['Empresa']['id'] = $userArr[0]["User"]['id_empresa'];
							$res = $this->Inicio->query_('SELECT nombre FROM empresa WHERE id="'. $_SESSION['Empresa']['id'] .'"',1);
							$_SESSION['Empresa']['nombre'] = $res['nombre'];
							header("Location: ".BASEURL."temp/home");
						}elseif ($_SESSION['USER-AD']["user_rol"] == 7){
							$_SESSION['Empresa']['id'] = $userArr[0]["User"]['id_empresa'];
							$res = $this->Inicio->query_('SELECT nombre FROM empresa WHERE id="'. $_SESSION['Empresa']['id'] .'"',1);
							$_SESSION['Empresa']['nombre'] = $res['nombre'];
							header("Location: ".BASEURL."temp/home");
						}elseif ($_SESSION['USER-AD']["user_rol"] == 8){
							$_SESSION['Empresa']['id'] = $userArr[0]["User"]['id_empresa'];
							$res = $this->Inicio->query_('SELECT nombre FROM empresa WHERE id="'. $_SESSION['Empresa']['id'] .'"',1);
							$_SESSION['Empresa']['nombre'] = $res['nombre'];
							header("Location: ".BASEURL."temp/home");
						}elseif ($_SESSION['USER-AD']["user_rol"] == 9){
							$_SESSION['Empresa']['id'] = $userArr[0]["User"]['id_empresa'];
							$res = $this->Inicio->query_('SELECT nombre FROM empresa WHERE id="'. $_SESSION['Empresa']['id'] .'"',1);
							$_SESSION['Empresa']['nombre'] = $res['nombre'];
							header("Location: ".BASEURL."temp/home");
						}
					}
				}
			}

			// $info = "<b>Atención:</b> el sitio www.saegth.com estará disponible a partir del 01/01/2016. Toda información registrada en el sitio <a href='http://www.aldesis.com'>http://www.aldesis.com</a> permanecerá intacta en el proceso. y será trasladada a este sitio.";
			// $this->set("info",$info);
			$this->set("isBlocked",$this->confirmIPAddress($_SERVER['REMOTE_ADDR'],$time_block));
			$this->set("time_block",$time_block);

		}
	}

	#Carga las vistas unicas iniciales
	
	function administracion_del_desempenio(){
		$this->set('title','Alto Desempe&ntilde;o | Administraci&oacute;n del Desempe&ntilde;o');
	}
	
	function diagnostico_laboral_de_clima(){
		$this->set('title','Alto Desempe&ntilde;o | Diagnostico Laboral del Clima');
	}

	function estructura_y_planes_salariales(){
		$this->set('title','Alto Desempe&ntilde;o | Estructura y Planes Salariales');
	}
	
	function evaluaciones_psicometricas(){
		$this->set('title','Alto Desempe&ntilde;o | Evaluaciones Psicom&eacute;tricas');
	}

	function modelos_de_competencias(){
		$this->set('title','Alto Desempe&ntilde;o | Modelos de Competencias');
	}
	
	function reclutamiento_y_seleccion(){
		$this->set('title','Alto Desempe&ntilde;o | Reclutamiento y Selecci&oacute;n');
	}
	
	function entrenamiento_y_desarrollo(){
		$this->set('title','Alto Desempe&ntilde;o | Entrenamiento y Desarrollo');
	}

	function diseno_de_politicas_rh(){
		$this->set('title','Alto Desempe&ntilde;o | Dise&ntilde;o y Pol&iacute;ticas de RRHH');
	}

	
	function nomina_confidencial(){
		$this->set('title','Alto Desempe&ntilde;o | Nomina Confidencial');
	}
	function contacto(){
		$this->set('title','Alto Desempe&ntilde;o | Contácto');
	}

	function logout(){
		Util::sessionLogout();
		$this->Inicio->disconnect();
	}

	function getHeaderInfo($rol){
		$res = $this->Inicio->query('SELECT navbar,link FROM navbar WHERE user_rol='.$rol.'',1);
		return $res['Navbar'];
	}

	function confirmIPAddress($value,&$time) { 

		$q = "SELECT attempts, lastlogin, (CASE when lastlogin is not NULL and DATE_ADD(LastLogin, INTERVAL ".TIME_PERIOD." MINUTE)>NOW() then 1 else 0 end) as Denied FROM ".TBL_ATTEMPTS." WHERE ip = '$value'"; 
		$data = $this->Inicio->query_($q,1); 

		if (!$data) { 
			return 0; 
		} 
		if ($data["attempts"] >= ATTEMPTS_NUMBER) 
		{ 
			if($data["Denied"] == 1) 
			{ 
				$time = $data['lastlogin'];
				// $time = explode(" ", $data['lastlogin']);
				// $time = $time[1];
				return 1; 
			} 
			else 
			{ 
				$this->clearLoginAttempts($value); 
				return 0; 
			} 
		} 
		return 0; 
	} 

	function addLoginAttempt($value) {

   //Increase number of attempts. Set last login attempt if required.

		$q = "SELECT * FROM ".TBL_ATTEMPTS." WHERE ip = '$value'"; 
		$data = $this->Inicio->query_($q,1); 
		if($data)
		{
			$attempts = $data["attempts"]+1;         

			if($attempts==3) {
				$q = "UPDATE ".TBL_ATTEMPTS." SET attempts=".$attempts.", lastlogin=NOW() WHERE ip = '$value'";
				$result = $this->Inicio->query_($q,1); 
			}
			else {
				$q = "UPDATE ".TBL_ATTEMPTS." SET attempts=".$attempts." WHERE ip = '$value'";
				$result = $this->Inicio->query_($q,1); 
			}
		}
		else {
			$q = "INSERT INTO ".TBL_ATTEMPTS." (attempts,IP,lastlogin) values (1, '$value', NOW())";
			$result = $this->Inicio->query_($q,1); 
		}
	}

	function clearLoginAttempts($value) {
		$q = "UPDATE ".TBL_ATTEMPTS." SET attempts = 0 WHERE ip = '$value'"; 
		return $this->Inicio->query_($q,1); 
	}
}






