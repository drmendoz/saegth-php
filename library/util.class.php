<?php

class Util{



	// public static $x=0;

	// public static $url = array();



	// public static function set_backlink();



	public $model = "";

	public $view = "";



	public static function sessionStart() {

		if (!isset($_SESSION) && (session_id() == '')) {

			@session_start();

		}

	}



	public static function sessionPermission() {

		self::sessionStart();

		if (!isset($_SESSION["USER-AD"])) {

			return false;

		}

		return true;

	}



	public static function sessionLogout() {

		self::sessionStart();

		$_SESSION = null;

		session_destroy();

	}

	

	public static function passHasher($pass,$a){

		for ($x = 0; $x < $a ; $x++){

			$pass = hash('gost', $pass);

			$pass = hash('adler32', $pass);

			$pass = hash('crc32', $pass);

		}

		return $pass;

	}



	public static function htmlprnt($string){

		return htmlentities($string, ENT_COMPAT, "ISO-8859-1");

	}



	public static function db_print($string){

		// echo str_replace("ASCII", "", mb_detect_encoding($string)) ;

		return mb_convert_encoding($string, "ISO-8859-1", "UTF-8");

		// return $string;

	}



	public static function if_checked ($needle,$haystack){ 

		if(isset($haystack)){

			if (in_array($needle, $haystack)){

				echo 'checked="checked"';

			}

		}

	}



	public static function sendMail($rec,$subj,$mensaje){

		$mail = new PHPMailer();

		$mail->IsSMTP();  // telling the class to use SMTP

		$mail->Host = "localhost"; // SMTP server

		$mail->IsHTML(true);

		$mail->CharSet = 'UTF-8';

		$mail->AddReplyTo('informacion@saegth.com', 'Alto Desempeño');

		//2018-01-05 cambiando para prueba de autenticacion
		//$mail->SMTPAuth = false; // Authentication must be disabled
		
		$mail->SMTPAuth = true;
		$mail->Username = 'informacion@saegth.com';
		$mail->Password = 'G1ng3rBr3w@';
		$mail->Port = 26;

		if(DEBUG_MAIL){

			$mail->SetFrom("p.arredondov91@gmail.com", "Alto Desempeño");

			$mail->AddAddress('p.arredondov91@gmail.com');

			//$mail->SetFrom("informacion@localhost.com", "Alto Desempeño");

		}else{	

			$mail->SetFrom("informacion@saegth.com", "Alto Desempeño");

			$mail->AddAddress($rec);

			$mail->addCustomHeader("BCC: ".WEBMAIL);

		}

		$mail->Subject  = $subj;



		$mensaje .= "<p>Atentamente,</p>\r\n<img src = 'http://www.saegth.com/images/logolargoalde.bmp'>";

		//$mensaje .= " <p><b> Telefax:</b>      (593 4) 229 1645<br><b>Email:</b>        informacion@altodesempenio.com<br></p> ";	

		$mail->Body = $mensaje;

		if(!$mail->Send()) {

			$headers = 'From: informacion@saegth.com' . "\r\n";

			$headers .= 'Reply-To: informacion@saegth.com' . "\r\n";

			$headers .= 'X-Mailer: PHP/' . phpversion() . "\r\n";	



			//HTML version of message

			$headers .= "MIME-Version: 1.0\r\n";

			$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

			

			mail($rec, $subj, $mensaje, $headers);

		}

		return true;

		//$email.=','.'p.arredondov91@gmail.com';

	}

	public static function nav_encode($nav) {

		$nav = serialize($nav);

		$nav = base64_encode($nav);

		return $nav;

	}



	/**

	 * Returns decrypted original string

	 */

	public static function nav_decode($nav) {

		$nav = base64_decode($nav);

		$nav = unserialize($nav);

		$nav = str_replace('LINKHERE', BASEURL, $nav);

		return $nav;

	}



	public function _x($a,$p){

		$values = array(

			'sonda' => array(

				'resultados' => array(

					'titulo' => '<h4>DIAGNÓSTICO DE CLIMA ORGANIZACIONAL</h4>',

					'segmentacion' => '<h5>Criterios de Segmentación:</h5>',

					'titulo2' => 'Factores',

					), 

				), 
			'efectividad_departamental' => array(

				'resultados' => array(

					'titulo' => '<h4>DIAGNÓSTICO DE EFECTIVIDAD ORGANIZACIONAL</h4>',

					'segmentacion' => '<h5>Criterios de Segmentación:</h5>',

					'titulo2' => 'Factores',

					), 

				), 

			'riesgo_psicosocial' => array(

				'resultados' => array(

					'titulo' => '<h4>RIESGO DE ESTR&Eacute;S PSICOSOCIAL</h4>',

					'segmentacion' => '<h5>Criterios de Segmentación:</h5>',

					'titulo2' => 'Factores',

					), 

				), 

			);

		// var_dump($GLOBALS['model_x']);

		echo $values[$GLOBALS['model_x']][$a][$p];

	}



}
