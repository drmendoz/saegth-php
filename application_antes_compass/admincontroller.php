<?php

class AdminController extends Controller {

	protected $link;
	
	function __construct($model, $controller, $action, $type = 0) {

		parent::__construct($model, $controller, $action, $type);

		$this->link = $this->Admin->getDBHandle();
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

	function navbar(){
		Util::SessionStart();
	}

	function home(){
		$this->hayPermiso();
		$this->set('title','Alto Desempe&ntilde;o | Administrador');
	}
	
	function empresa_ingreso($id=null) {
		$this->hayPermiso();
		$this->set('title','Alto Desempe&ntilde;o | Ingreso de empresas');
		if (isset($_POST['nuevaEmpresa'])){
			$empresa = new Empresa();
			if(isset($_POST['eval'])){
				foreach ($_POST['eval'] as $key => $eval) {
					$valeval[] = 1;
					switch ($eval) {
						case 1:
						$empresa->setCompass_360(1); 
						break;
						case 2:
						$empresa->setScorer(1); 
						break;
						case 3:
						$empresa->setMatriz(1); 
						break;
						case 4:
						$empresa->setValoracion(1); 
						break;
						case 5:
						$empresa->setClima_laboral(1); 
						break;
						case 6:
						$empresa->setRetencion(1); 
						break;
						case 7:
						$empresa->setCobertura(1); 
						break;
						case 8:
						$empresa->setPsicosocial(1); 
						break;
					}
				}
			}
			$empresa->setNombre($_POST['nuevaEmpresa']);
			$empresa->escape($empresa->nombre);
			$empresa->setAdmin($_POST['admin']);
			$empresa->escape($empresa->admin);
			$empresa->setEmail($_POST['correo']);
			$tk = self::genTK(5);
			$empresa->setToken($tk);
			$empresa->insert();
			if(!$empresa->getError()){
				$user = Util::passHasher($empresa->nombre,rand(1,20));
				$pass = Util::passHasher($empresa->admin,rand(1,20));
				$subject="Nuevo Usuario y Password para ".$empresa->admin;
				$mensaje = "Estimado(a) ".$empresa->admin.", el vínculo adjunto lo conducirá directamente a la pantalla de administracion para la empresa <b>".$this->Admin->htmlprnt($empresa->nombre)."</b>. Por favor ingrese su Usuario y su Contraseña en los campos correspondientes una vez que haya accesado el vínculo adjunto. <br>".
				"<p>&nbsp;</p>Vínculo.- <a href = '".BASEURL."'>".BASEURL."</a><br><p>&nbsp;</p>".
				"<table><tr><td><b>Usuario<b></td><td>".$user."</td></tr><tr><td><b>Contraseña<b></td><td>".$pass."</td></tr></table>";
				if(Util::sendMail($empresa->email,$subject,$mensaje)){
					$this->Admin->query('INSERT INTO `users`(`user_name`, `password`, `user_rol`, `id_empresa`) VALUES ("'.$user.'","'.Util::passHasher($pass,6).'",1,"'.$empresa->id.'")');
					unset($_POST);
					header("Location: " . BASEURL.'admin/empresa_ingreso/success');
				}else{
					header("Location: " . BASEURL.'admin/empresa_ingreso/warning');
				}
			}
		}

		$serv = $this->Admin->query('SELECT `id`,`nombre` FROM `test_list` WHERE `activo`=1');
		$this->set('serv',$serv);
	}

	function insights(){
		$this->set('title','Alto Desempe&ntilde;o | Evaluacion Insights');
		$this->set('backlink','admin/home');
		$this->hayPermiso();
		$arr = $this->Admin->query('SELECT * FROM `empresa` WHERE 1 ORDER BY `nombre` ASC');
		$this->set('empresas',$arr);
		$_SESSION['nav']=Controller::getAction();
		if (isset($_POST['button'])){
			foreach ($_POST['chk'] as $a => $b) {
				$arr = $this->Admin->query('SELECT user_name, token FROM `users` WHERE id_personal="'.$b.'"',1);
				$em = $this->Admin->query('SELECT email FROM `personal_datos` WHERE id_persona="'.$b.'"',1);
				$em = @reset($em); $em = @reset($em);
				$arr = @reset($arr);
				$subject="Evaluación Insights";
				$mensaje = "<p>Estimado(a), el vínculo adjunto lo conducirá directamente a la hoja de respuestas de la evaluación Insights Discovery programada para usted. Por favor ingrese su Usuario y su Contraseña en los campos correspondientes una vez que haya accesado el vínculo adjunto. <br>
				Vínculo.- <a href = '".BASEURL."user/login/insights'>".BASEURL."user/login/insights</a></p><br>".
				"<table><tr><td><b>Usuario<b></td><td>".$arr['user_name']."</td></tr><tr><td><b>Contraseña<b></td><td>".$arr['token']."</td></tr></table>".
				"<p>La evaluación le tomará aproximadamente de 15 a 20 minutos y por razones metodológicas debe ser respondida en una sola operación.- NO puede dejarse pendiente para continuarla después.</p>"
				."<p>En caso de tener alguna pregunta o duda sobre esta evaluación, por favor no dude en <b>contactarnos:  04 229 1645.</b></p>";
				Util::sendMail($em,$subject,$mensaje);

				$this->Admin->query('INSERT INTO `test_insights`(`id_personal`, `completo`) VALUES ("'.$b.'","0") ON DUPLICATE KEY UPDATE `completo`="0"');
			}
		}
	}

	function viewall(){
		$this->set('title','Alto Desempe&ntilde;o | Vista Personal');
		$this->set('backlink','admin/home');
		$this->hayPermiso();
		$arr = $this->Admin->query('SELECT * FROM `empresa` WHERE 1 ORDER BY `nombre` ASC');
		$this->set('empresa',$arr);
	}

	function scorecard(){
		$this->hayPermiso();
		$this->set('title','Alto Desempe&ntilde;o | Scorecard');
		$this->set('empresas',$this->Admin->query('SELECT * FROM empresa WHERE scorer=1'));

		if(isset($_POST['button'])){
			$scorer = new Scorer();
			$scorer->res1_min=$_POST['valmin'][0];
			$scorer->res1_max=$_POST['valmax'][0];
			$scorer->res2_min=$_POST['valmin'][1];
			$scorer->res2_max=$_POST['valmax'][1];
			$scorer->res3_min=$_POST['valmin'][2];
			$scorer->res3_max=$_POST['valmax'][2];
			$scorer->res4_min=$_POST['valmin'][3];
			$scorer->res4_max=$_POST['valmax'][3];
			$scorer->res5_min=$_POST['valmin'][4];
			$scorer->res5_max=$_POST['valmax'][4];
			$scorer->vinicial=$_POST['vinicial'];
			$scorer->col=$_POST['col'];
			$scorer->razon=$_POST['razon'];
			$scorer->vfinal=$_POST['vfinal'];
			$scorer->p_score=$_POST['scorep'];
			$scorer->p_compass=$_POST['compassp'];

			$detalle=serialize($scorer);
			$detalle=mysqli_real_escape_string($this->link,$detalle);

			$fecha=date("Y");

			$this->Admin->query('INSERT INTO scorer_detalle (id_empresa,detalle,estado,periodo) VALUES ('.$_POST['selectEmpresa'].',"'.$detalle.'",1,"'.$fecha.'") ON DUPLICATE KEY UPDATE detalle="'.$detalle.'" ;');
			echo mysqli_error($this->link);
			$_POST=null;
			echo "<script>alert('Se ha guardado correctamente')</script>";

		}
	}


	/*

























	*/

	function logout(){
		Util::sessionLogout();
		$this->Admin->disconnect();
		$this->_template = new Template('Inicio','principal', false);
	}

	function cambiar_empresa(){
		Util::sessionStart();
		$_SESSION['Empresa'] = null;
		$this->hayEmpresa();
	}

	function ingresar_nueva(){
		Util::sessionStart();
		$_SESSION['Empresa'] = null;
		$this->_template = new Template('Admin','empresa_ingreso');
		$this->empresa_ingreso();		
	}

	function haySession(){
		Util::sessionStart();
		if (!isset($_SESSION['USER-AD'])){
			$this->logout();	
		}
		return true;
	}

	function hayPermiso(){
		Util::sessionStart();
		$session = $this->haySession();
		if ($session && $_SESSION['USER-AD']['user_rol']){
			echo "<script>alert('No tiene los permisos necesarios para navegar esta sección');window.location = '".BASEURL.$_SESSION['link']."';</script>";
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
		if (!isset($_SESSION['personal']['id'])){
			$this->_template = new Template('Admin','personal_ingreso');
			$this->personal_ingreso();
			exit();
		}
	}
}