<?php

class IndexController extends Controller {

	protected $Pregunta;
	protected $Factura;
	protected $Resultado;
	protected $link;
	
	function __construct($model, $controller, $action, $type = 0) {

		parent::__construct($model, $controller, $action, $type);

		$this->Pregunta = new Pregunta;
		$this->Factura = new Factura;
		$this->link = $this->Index->getDBHandle();
		//$this->Resultado = new Resultado;
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
	
	function login() {
		$this->set('title','Alto Desempe&ntilde;o');
		$this->set('subtitle','Inicio de sesi&oacute;n, ingrese sus datos correctamente.');
		$this->set('subtitle_2','Seleccione una pregunta para recuperar tu usuario');
		if(isset($_POST['ruc']) && isset($_POST['user']) && isset($_POST['password'])){
			$ruc = mysqli_real_escape_string($this->link,$_POST['ruc']);
			$user = mysqli_real_escape_string($this->link,$_POST['user']);
			$password = mysqli_real_escape_string($this->link,$_POST['password']);
			
			$userArr = $this->User->query(' select * from users where ruc = \''. $ruc .'\' and user_name = \''. $user .'\' and password = \''. hash('md5', $password) .'\' and activo = "1" limit 1');
			
			if (!$userArr){
				$this->set('subtitle','Por favor verifique los datos.');
			}else{
				Util::sessionStart();
				$_SESSION['USER'] = $userArr[0]["User"];
				if ($userArr[0]["User"]["activo"]){
					$this->_template = new Template('Users','facturas', 0, true);
					$this->facturas();
				}else{
					$this->_template = new Template('Users','registro');
					$this->registro();
				}
			}
		}
	}
	
	function view($tk=null) {
		$this->set('title','Kronos Facturacion Electronica');
		$this->set('backlink',BASEURL);
		$this->set('subtitle','Aquí puede cambiar sus datos de cuenta');
		Util::sessionStart();
		
			if( isset($tk) ){
				$userArr = $this->User->query(' select * from users where token = \''. $tk .'\' limit 1');
				if ( !$userArr ){
					$this->_template = new Template('Users','login', 0);
					$this->set('subtitle','El tiempo de espera a expirado, vuelva a intentarlo.');
					Util::sessionLogout();
				}else{
					$_SESSION['USER'] = $userArr[0]["User"];
				}
			}
			if(isset($_POST['ruc']) && isset($_POST['user']) && isset($_POST['razonSocial']) && isset($_POST['email'])){
				$ruc = mysqli_real_escape_string($this->link,$_POST['ruc']);
				$user = mysqli_real_escape_string($this->link,$_POST['user']);
				$razon = mysqli_real_escape_string($this->link,$_POST['razonSocial']);
				$email = mysqli_real_escape_string($this->link,$_POST['email']);
				
				$userArr = $this->User->query(' select * from users where ruc = \''. $ruc .'\'');
				
				if (!$userArr){
					$this->set('subtitle','Por favor verifique los datos.');
				}else{
					$query = 'UPDATE `users` SET `razon_social`=\''.$razon.'\',`user_name`=\''.$user.'\',`e_mail`=\''.$email.'\',`activo`=\'1\' WHERE ruc = \''. $ruc .'\'';
					$this->set('users',$this->User->query($query));
					$userArr = $this->User->query(' select * from users where ruc = \''. $ruc .'\'');
					$_SESSION['USER'] = $userArr[0]["User"];
					$this->set('subtitle','Sus datos han sido guardados');
				}
			}
	}
	
	function registro() {
		$this->set('title','Registro - Kronos Facturacion Electronica');
		$this->set('subtitle','Ingresa tu RUC y el token que fue entregado por parte de Kronos.');
		
		if(isset($_POST["ruc"]) && isset($_POST["token"])){
			$ruc =  mysqli_real_escape_string($this->link,$_POST['ruc']);
			$token =  mysqli_real_escape_string($this->link,$_POST['token']);
			
			$users = $this->User->query('select * from users where ruc = \''.$ruc.'\' and token = \''.$token.'\' and activo = \'0\';');
		if($users)
			{
				Util::sessionStart();
				
				$_SESSION["USER"] = $users[0]["User"];
				
				$this->_template = new Template('Users','nuevaclave', 0);
				$this->nuevaclave();
				
			}else{
				$this->set('subtitle','Ingresa un RUC y token v&aacute;lidos.');
			}
		}
		
	}

	function respuestas() {
		$this->set('title','Respuestas - Kronos Facturacion Electronica');
		$this->set('subtitle','Por motivos de seguridad debe seleccionar 3 preguntas y responderlas.');
		
		if(isset($_POST["respuesta1"]) && isset($_POST["respuesta2"]) && isset($_POST["respuesta3"])){
			
			$preg1 = mysqli_real_escape_string($this->link,$_POST['pregunta1']);
			$preg2 = mysqli_real_escape_string($this->link,$_POST['pregunta2']);
			$preg3 = mysqli_real_escape_string($this->link,$_POST['pregunta3']);
			
			$res1 =  strtoupper(mysqli_real_escape_string($this->link,$_POST['respuesta1']));
			$res2 =  strtoupper(mysqli_real_escape_string($this->link,$_POST['respuesta2']));
			$res3 =  strtoupper(mysqli_real_escape_string($this->link,$_POST['respuesta3']));

			Util::sessionStart();			
			$id = $_SESSION["USER"]["id"];
			
			$this->set('respuestas',$this->User->query('INSERT INTO `respuestas`(`id_user`,`id_pregunta`, `respuesta`) VALUES (\''.$id.'\', \''.$preg1.'\', upper(\''.$res1.'\'));'));
			$this->set('respuestas',$this->User->query('INSERT INTO `respuestas`(`id_user`,`id_pregunta`, `respuesta`) VALUES (\''.$id.'\', \''.$preg2.'\', upper(\''.$res2.'\'));'));
			$this->set('respuestas',$this->User->query('INSERT INTO `respuestas`(`id_user`,`id_pregunta`, `respuesta`) VALUES (\''.$id.'\', \''.$preg3.'\', upper(\''.$res3.'\'));'));
			
			if ((!isset($_POST['respuesta4'])) || ($_POST['respuesta4'] == '')){
				$this->set('respuestas',$this->User->query('INSERT INTO `respuestas`(`id_user`,`id_pregunta`, `respuesta`) VALUES (\''.$id.'\', NULL, NULL);'));
			}else{
				$preg4 = mysqli_real_escape_string($this->link,$_POST['pregunta4']);
				$res4 =  strtoupper(mysqli_real_escape_string($this->link,$_POST['respuesta4']));
				$this->set('respuestas',$this->User->query('INSERT INTO `respuestas`(`id_user`,`id_pregunta`, `respuesta`) VALUES (\''.$id.'\', \''.$preg4.'\', upper(\''.$res4.'\'));'));

			}
			$this->_template = new Template('Users','view', 0);
				$this->view();
		}else{
			$this->set('preguntas',$this->Pregunta->selectAll());
		}
		
		
	}
	
	function nuevaclave($tk=null) {
		$this->set('title','Nueva contrase&ntilde;a - Kronos Facturacion Electronica');
		$this->set('subtitle','Ingrese una nueva contrase&ntilde;a para poder continuar.');
		Util::sessionStart();
		
		if( isset($tk) ){
			$userArr = $this->User->query(' select * from users where token = \''. $tk .'\' limit 1');
			if ( !$userArr ){
				$this->_template = new Template('Users','login', 0);
				$this->set('subtitle','El tiempo de espera a expirado, vuelva a intentarlo.');
				Util::sessionLogout();
			}else{
				$this->set('subtitle','Aquí puede cambiar su contraseña');
				$_SESSION['USER'] = $userArr[0]["User"];
				$_SESSION['valid'] = 1;
			}
		}elseif (!isset($_SESSION['USER'])){
			$this->logout();
		}	
		if(isset($_POST["clave_1"]) && isset($_POST["clave_2"])){
			$psw1 =  mysqli_real_escape_string($this->link,$_POST['clave_1']);
			$psw2 =  mysqli_real_escape_string($this->link,$_POST['clave_2']);
			if ($psw1 == $psw2){			
				$id = $_SESSION["USER"]["id"];
				$this->User->query(' select * from users where id = \''. $id .'\' limit 1');
				$this->set('password',$this->User->query('UPDATE `users` SET `password`=\''.hash('md5', $psw1).'\' WHERE id = \''. $id .'\''));
				if( isset($_SESSION['valid'])){
					$this->_template = new Template('Users','facturas', 0,true);
					$this->facturas();
				}else{
					$this->_template = new Template('Users','respuestas', 0);
					$this->respuestas();
				}
				
			}else{
				$this->set('subtitle','Las contrase&ntilde;as no coinciden');
			}
		}
	}
	
	function logout(){
		Util::sessionLogout();
		$this->_template = new Template('Users','login', false);
		$this->login();
		
	}
	
	function download($id = null,$fecha = null) {
		
		Util::sessionStart();
		if (!isset($_SESSION['USER'])){
			$this->logout();
		}
		$this->set('title',$fecha.' - Kronos Facturacion Electronica');
		$this->set('factura',$this->Factura->select($id));
		
	}	
	
	function logg(){
		Util::sessionLogout();
		$this->_template = new Template('Users','facturas', false,true);
		$this->facturas();
	}
	
	
	
	function facturas() {
		
		$this->set('title','Listado de Facturas - Kronos Facturacion Electronica');
		
		Util::sessionStart();
		if (isset($_SESSION['USER'])){
			if(isset($_POST['from']) && isset($_POST['to'])){
				$from = mysqli_real_escape_string($this->link,$_POST['from']);
				$to = mysqli_real_escape_string($this->link,$_POST['to']);
				
				$from = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $from)));
				$to = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $to)));
				
				$this->set('factura',$this->Factura->query('select * from facturas where id_user = \''.$_SESSION["USER"]["id"].'\' and (fecha between \''.$from.'\' and \''.$to.'\')'));	
			}else{
				$this->set('factura',$this->Factura->query('select * from facturas WHERE id_user = \''.$_SESSION["USER"]["id"].'\''));
			}
		}else{
			$this->logout();			
		}
		
		
	}
	
	function recuperarcontrasena() {
		$this->set('title','Respuestas - Kronos Facturacion Electronica');
		$this->set('subtitle','Para poder restablecer la contraseña llena los siguientes campos');
		$this->set('backlink',BASEURL);
		$this->set('preguntas',$this->Pregunta->selectAll());
		
		
		if(isset($_POST["respuesta"]) && isset($_POST["ruc"])){
			$ruc = mysqli_real_escape_string($this->link,$_POST['ruc']);
			$preg = mysqli_real_escape_string($this->link,$_POST['pregunta']);
			$res =  strtoupper(mysqli_real_escape_string($this->link,$_POST['respuesta']));
			Util::sessionStart();
			$userArr = $this->User->query(' select * from users where ruc = \''. $ruc .'\'');
			if (($userArr)){
				$_SESSION['USER'] = $userArr[0]["User"];
				$id = $_SESSION['USER']['id'];
				$valid = $this->User->query('SELECT `id_user` FROM `respuestas` WHERE `respuesta` = upper(\''. $res .'\')  and `id_pregunta` = \''. $preg .'\'');
				$tk = self::genTK(20);
				$this->set('token',$this->User->query('UPDATE `users` SET `token`=\''.$tk.'\' WHERE id = \''. $id .'\''));
				
				if (($valid)){
					$this->set('subtitle_2','Su contraseña ha sido enviado a su correo');
					$to = $_SESSION['USER']['e_mail'];
					$subject = 'Kronos Laboratorios - Recuperar Contraseña';
					$mail_body = "\n	Recientemente hemos recibido una solicitud para recuperar su cuenta de Kronos.\n\n	Se ha verificado la titularidad de esta cuenta con la información que nos ha proporcionado.\n\n	Para reestablecer la contraseña haga click en el siguiente link:\n\n
					". BASEURL .'users/nuevaclave/'. $tk ."\n\n Si no has solicitado la recuperación de tu clave puedes ignorar este correo o proceder a realizar el cambio.";
					$headers  = "From:no-reply@kronoslaboratorios.com";
					mail($to, $subject, $mail_body, $headers);
					Util::sessionLogout();
				}else{
					$this->set('subtitle_2','Por favor verifique su respuesta');
				}
			}else{
				$this->set('subtitle_2','El ruc que ingreso no es valido');
			}
		}	
	}
	
	function recuperarusuario() {
		$this->set('title','Respuestas - Kronos Facturacion Electronica');
		$this->set('subtitle','Para poder restablecer su usuario llena los siguientes campos');
		$this->set('backlink',BASEURL);
		$this->set('preguntas',$this->Pregunta->selectAll());
		
		
		if(isset($_POST["respuesta"]) && isset($_POST["ruc"])){
			$ruc = mysqli_real_escape_string($this->link,$_POST['ruc']);
			$preg = mysqli_real_escape_string($this->link,$_POST['pregunta']);
			$res =  strtoupper(mysqli_real_escape_string($this->link,$_POST['respuesta']));
			Util::sessionStart();
			$userArr = $this->User->query(' select * from users where ruc = \''. $ruc .'\'');
			if (($userArr)){
				$_SESSION['USER'] = $userArr[0]["User"];
				$id = $_SESSION['USER']['id'];
				$valid = $this->User->query('SELECT `id_user` FROM `respuestas` WHERE `respuesta` = upper(\''. $res .'\')  and `id_pregunta` = \''. $preg .'\'');
				$tk = self::genTK(20);
				$this->set('token',$this->User->query('UPDATE `users` SET `token`=\''.$tk.'\' WHERE id = \''. $id .'\''));
				
				if (($valid)){
					$this->set('subtitle_2','Los pasos para recuperar su usuario ha sido enviado a su correo');
					$to = $_SESSION['USER']['e_mail'];
					$subject = 'Kronos Laboratorios - Recuperar Usuario';
					$mail_body = "\n	Recientemente hemos recibido una solicitud para recuperar su cuenta de Kronos.\n\n	Se ha verificado la titularidad de esta cuenta con la información que nos ha proporcionado.\n\n	Su usuario es: ". $_SESSION['USER']['user_name'] ."\n\n Haga click en el siguiente link para iniciar sesión: ". BASEURL."\n\n Si no has solicitado esta información puedes ignorar este correo";
					$headers  = "From:no-reply@kronoslaboratorios.com";
					mail($to, $subject, $mail_body, $headers);
					Util::sessionLogout();
				}else{
					$this->set('subtitle_2','Por favor verifique su respuesta');
				}
			}else{
				$this->set('subtitle_2','El ruc que ingreso no es valido');
			}
		}	
	}
	
	function wsinsert(){
		$this->Resultado = new Resultado(true, "no existen datos");
		if (isset($_POST['ruc']) && isset($_POST['razon']) && isset($_POST['token']) && isset($_POST['valid'])){
			if($_POST['valid'] == "isvalidsi"){
				$valueArr[0]= $_POST['ruc'];
				$valueArr[1]= $_POST['razon'];
				$valueArr[2]= $_POST['token'];
				$this->Resultado = new Resultado(false, "si",$valueArr);
				$this->set('respuestas',$this->User->query('INSERT INTO `config` (`ruc`,`razon_social`,`token`,`activo`) VALUES (\''.strval($valueArr[0]).'\', \''.$valueArr[1].'\', \''.strval($valueArr[2]).'\',0);'));
			}else{
				$this->Resultado = new Resultado(true, "No coincide el identificador");
			}
		}
		
		$this->set('result',$this->Resultado);
			
	}

}






