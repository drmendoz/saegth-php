<?php

$meth = new Ajax();

if($_REQUEST)
{
	// var_dump($_REQUEST);
	$fecha = $meth->print_fecha(date("Y-m-d")); 
	$hora = (date("h:i:sa",(time())));
	// $hora = (date("h:i:sa",(time()-7*60*60)));
	$id=$_REQUEST['id'];


	$email = WEBMAIL;
	if($_REQUEST['tipo']!=5){
		$subject = "Modificación de tablero de control Scorecard";
		switch ($_SESSION['USER-AD']['user_rol']) {
			case 1:
			$idp=$_SESSION['USER-AD']['id_personal'];
			break;
			case 2:
			$idp=$_SESSION['USER-AD']['id_empresa'];
			break;
		}	
		$jefe = $meth->get_pname($idp);
		$em = $meth->get_emailById($id);
	}
	switch ($_REQUEST['tipo']) {
		case 1:
		$msg="<p>Se ha modificado el tablero de control scorecard de ".$meth->get_pname($id)." el ".$fecha." ".$hora."</p>";
		$msg.="<p>Modificación realizada por ".$jefe."</p>";
		echo $msg;

		$msj="<p>Se ha modificado su tablero de control scorecard el ".$fecha." ".$hora."</p>";
		$msj.="<p>Modificación realizada por ".$jefe."</p>";
		break;
		
		case 2:
		$msg="<p>".$meth->get_pname($id)." modificó su tablero de control scorecard el ".$fecha." ".$hora."</p>";
		echo $msg;
		$msj = "<p>Has modificado tu scorecard el ".$fecha." ".$hora."</p>";
		break;
		
		case 3:
		$per = Personal_empresa::withID($id);
		if($id == $_SESSION['USER-AD']['id_personal']){
			$msg="<p>".$meth->get_pname($id)." modificó sus comentarios de revisión el ".$fecha." ".$hora."</p>";
			$email .= ",".$meth->get_emailById($per->get_pid_sup());
			$msj = "<p>Has modificado tus comentarios de revisión el ".$fecha." ".$hora."</p>";
		}else{
			$msg = "<p>Has modificado los comentarios de revisión de ".$meth->get_pname($id)." el ".$fecha." ".$hora."</p>";
			$email .= ",".$meth->get_emailById($per->get_pid_sup());
			$msj = "<p>".$meth->get_pname($per->get_pid_sup())." modificó sus comentarios de revisión el ".$fecha." ".$hora."</p>";
		}
		break;
		
		case 4:
		$per = Personal_empresa::withID($id);
		if($id == $_SESSION['USER-AD']['id_personal']){
			$msg="<p>".$meth->get_pname($id)." modificó sus comentarios de evaluación el ".$fecha." ".$hora."</p>";
			$email .= ",".$meth->get_emailById($per->get_pid_sup());
			$msj = "<p>Has modificado tus comentarios de evaluación el ".$fecha." ".$hora."</p>";
		}else{
			$msg = "<p>Has modificado los comentarios de evaluación de ".$meth->get_pname($id)." el ".$fecha." ".$hora."</p>";
			$email .= ",".$meth->get_emailById($per->get_pid_sup());
			$msj = "<p>".$meth->get_pname($per->get_pid_sup())." modificó sus comentarios de evaluación el ".$fecha." ".$hora."</p>";
		}
		break;
		case 5:

		$id=json_decode($_REQUEST['id'], true);
		switch ($id['nivel']) {
			case 1:
			// if($id['pid']==6015 || $id['pid']==6020){
			// 	$id['pid']=6018;
			// }
			$msj="<p>Estimado/a,</p><p>".$id['nombre']." ha seleccionado sus evaluadores para la evaluación Compass 360. Es necesario que confirme esta selección antes de proceder, puede descartar a y/o seleccionar nuevos evaluadores.</p><p>Puede ver esta y otras confirmaciones pendientes siguiendo el vínculo en el menú lateral bajo Compass 360 > Selección de evaluadores > Subalternos directos</p>";
			$email = $meth->get_emailById($id['pid']);
			break;

			case 2:
			if($id['p_pid']==6015 || $id['p_pid']==6020){
				$id['p_pid']=6018;
			}
			$msj="<p>Estimado/a,</p><p>".$id['n_pid']." ha seleccionado los evaluadores de ".$id['nombre']." para la evaluación Compass 360. Es necesario que confirme esta selección antes de proceder, puede descartar a y/o seleccionar nuevos evaluadores.</p><p>Puede ver esta y otras confirmaciones pendientes siguiendo el vínculo en el menú lateral bajo Compass 360 > Selección de evaluadores > Subalternos indirectos </p>";
			$email = $meth->get_emailById($id['p_pid']);
			break;
		}
		// echo $email;
		$em ="informacion@altodesempenio.com";
		$msg=$msj;
		$subject = "Selección de evaluadores para ".$id['nombre'];
		// echo $msj."<br>";
		// echo $subject."<br>";
		break;
	}
	
	Util::sendMail($em,$subject,$msj);
	Util::sendMail($email,$subject,$msg);
}
?>