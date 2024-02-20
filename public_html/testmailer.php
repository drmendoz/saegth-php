<?php
include '../library/phpmailer.class.php';
include '../library/phpmailerautoload.php';
include '../library/smtp.class.php';
$rec = 'valdivieso.paulina@gmail.com';
$subj = 'esto es una prueba de envio';
$msn = 'este es el mensaje';

function mailPrueba($rec,$subj,$mensaje){

		$mail = new PHPMailer();

		$mail->IsSMTP();  // telling the class to use SMTP

		$mail->Host = "mail.saegth.com"; // SMTP server

		$mail->IsHTML(true);

		$mail->CharSet = 'UTF-8';

		$mail->AddReplyTo('informacion@saegth.com', 'Alto Desempeño');

		$mail->SMTPAuth = false; 
		//$mail->Username = 'informacion@saegth.com';
		//$mail->Password = 'G1ng3rBr3w@';

		$mail->Port = 26; 


		

			$mail->SetFrom("informacion@saegth.com", "Alto Desempeño");

			$mail->AddAddress($rec);

			$mail->addCustomHeader("BCC: ".WEBMAIL);

		

		$mail->Subject  = 'prueba123';



		$mensaje .= "<p>Atentamente,</p>\r\n<img src = 'http://www.altodesempenio.com/images/logolargoalde.bmp'>";

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
	
	mailPrueba($rec, $subj, $msn);
	
?>
