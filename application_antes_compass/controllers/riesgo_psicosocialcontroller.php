<?php

class Riesgo_psicosocialController extends Controller {

	protected $link;
	
	function __construct($model, $controller, $action, $type = 0,$full=false,$render=false) {

		parent::__construct($model, $controller, $action, $type,$full,$render);

		$this->link = $this->Riesgo_psicosocial->getDBHandle();
	}

	function test($id_e,$id_t){
		Util::sessionStart();
		$this->set('id_e',$id_e);
		$this->set('id_t',$id_t);
		if(array_filter($_POST)){
			$id_e = $_SESSION['Empresa']['id'];
			$rp_user = new Rp_user();
			$rp_user->setId_empresa($id_e);
			if(isset($_POST['edad'])){
				$rp_user->setEdad($_POST['edad']);
				unset($_POST['edad']);
			}
			if(isset($_POST['antiguedad'])){
				$rp_user->setAntiguedad($_POST['antiguedad']);
				unset($_POST['antiguedad']);
			}
			if(isset($_POST['localidad'])){
				$rp_user->setLocalidad($_POST['localidad']);
				unset($_POST['localidad']);
			}
			if(isset($_POST['area'])){
				$rp_user->setDepartamento($_POST['area']);
				unset($_POST['area']);
			}
			if(isset($_POST['norg'])){
				$rp_user->setNorg($_POST['norg']);
				unset($_POST['norg']);
			}
			if(isset($_POST['tcont'])){
				$rp_user->setTcont($_POST['tcont']);
				unset($_POST['tcont']);
			}
			if(isset($_POST['educacion'])){
				$rp_user->setEducacion($_POST['educacion']);
				unset($_POST['educacion']);
			}
			if(isset($_POST['sexo'])){
				$rp_user->setSexo($_POST['sexo']);
				unset($_POST['sexo']);
			}
			$rp_user->setId_test($_POST['id_test']);
			unset($_POST['id_test']);

			$rp_user->insert();
			echo mysqli_error($this->link);
			$id_user = $_SESSION['USER-AD']['id'];
			// $riesgo_psicosocial = new Riesgo_psicosocial();
			// $riesgo_psicosocial->select($id_e);
			foreach ($_POST as $key => $value) {
				$respuesta = new Rp_respuesta();
				$respuesta->setId_rp_user($rp_user->getId());
				$respuesta->setId_test($rp_user->getId_test());
				$respuesta->setId_pregunta($key);
				$respuesta->setRespuesta($value);
				$respuesta->setId_user($id_user);
				$respuesta->insert();
				echo mysqli_error($this->link);
			}

			$this->_template = new Template('Void','render');
			$dispatch = new TempController('Temp','temp','home');
			$dispatch->home();
		}
	}

	function construccion(){
		Util::sessionStart();
	}
	
	function evaluacion(){
		Util::sessionStart();
		if(isset($_POST['guardar'])){
			$riesgo = new Riesgo_psicosocial();

			if(isset($_POST['custom_email']))
				$custom_email=1;
			else
				$custom_email=0;

			$riesgo->setId_empresa($_SESSION['Empresa']['id']);
			$riesgo->setSegmentacion($_POST['segmentacion']);
			$riesgo->setFecha($_POST['fecha']);
			$riesgo->setEmail($_POST['email']);
			$riesgo->setPeriodo(date('Y-m-d'));
			$riesgo->setCustom_email($custom_email);
			$riesgo->insert();
			$id_test = mysqli_insert_id($riesgo->link);
			$this->_template = new Template('Void','render');
			
			/* EMAIL USUARIOS ENCUESTAS
				EN LINEA
				MANUAL
				A LOS EMPLEADOS DE LA COMPAÑIA
			*/
			$correo = $riesgo->getEmail();
			$subject = 'Encuesta en Línea de Riesgo de Stress Psicosocial';
			$link = BASEURL;
			$id_e = $_SESSION["Empresa"]["id"];
			$user_class = new User();

			$nombre =  ucwords($_SESSION["Empresa"]["nombre"]);
			$count_user = 0;

			while ($count_user != 1) {
				$user = Util::passHasher($nombre,rand(1,20));
				$pass = Util::passHasher($nombre,rand(21,30));
				$count_user = $user_class->verificarUsername($user, $pass);
				if($count_user < 1)
					break;

				$count_user = 0;
			}
			
			$user_obj = array(
				'user_name' => $user, 
				'password' => Util::passHasher($pass,6), 
				'user_rol' => 6, 
				'id_empresa' => $id_e, 
				'id_personal' => null, 
				'token' => null, 
				);
			$user_obj = new User($user_obj);
			$user_obj->insert();
			$last_user = mysqli_insert_id($user_obj->link);
 			$riesgo->insert_test_user($last_user, $id_test);

			$msj = '<p>Estimado/a,</p>';
			$msj .= '<p>Use el Vínculo, Usuario y Contraseña, proporcionados abajo, para abrir la plantilla de ingreso de respuestas al Diagnóstico de "RIESGO DE STRESS PSICOSOCIAL" aplicadas en Línea.</p>';
			$msj .= "<p>No olvide GRABAR al finalizar de responder.</p>";
			$msj .= "<p><b>Sitio Web: </b><a href='$link' target='_blanck'>$link</a></p>";
			$msj .= "<p><b>Usuario: </b>$user</p>";
			$msj .= "<p><b>Password: </b>$pass</p>";
			Util::sendMail($correo,$subject,$msj);
			


			$subject = 'Encuesta en Papel de Riesgo de Stress Psicosocial';
			$link = BASEURL;

			$nombre =  ucwords($_SESSION["Empresa"]["admin"]);
			$count_user = 0;

			while ($count_user != 1) {
				$user = Util::passHasher($nombre,rand(1,20));
				$pass = Util::passHasher($nombre,rand(21,30));
				$count_user = $user_class->verificarUsername($user, $pass);
				if($count_user < 1)
					break;

				$count_user = 0;
			}
			
			$user_obj = array(
				'user_name' => $user, 
				'password' => Util::passHasher($pass,6), 
				'user_rol' => 7, 
				'id_empresa' => $id_e, 
				'id_personal' => null, 
				'token' => null, 
				);
			$user_obj = new User($user_obj);
			$user_obj->insert();
			$last_user = mysqli_insert_id($user_obj->link);
 			$riesgo->insert_test_user($last_user, $id_test);

			$msg = '<p>Estimado/a,</p>';
			$msg .= '<p>Use el Vínculo, Usuario y Contraseña, proporcionados abajo, para abrir la plantilla de ingreso de respuestas al Diagnóstico de "RIESGO DE STRESS PSICOSOCIAL" aplicadas en Papel.</p>';
			$msg .= "<p>No olvide GRABAR al finalizar de responder.</p>";
			$msg .= "<p><b>Sitio Web: </b><a href='$link' target='_blanck'>$link</a></p>";
			$msg .= "<p><b>Usuario: </b>$user</p>";
			$msg .= "<p><b>Password: </b>$pass</p>";
			Util::sendMail($correo,$subject,$msg);

			//Emails a empleados
			$custom_email = $riesgo->getCustom_email();
			$nombre_empresa =  strtoupper($_SESSION["Empresa"]["nombre"]);

			if($custom_email == 1){
				$lp = new listado_personal_op();
 				$result_lp = $lp->select_all($_SESSION['Empresa']['id']);
 				$arrMails = array();

 				if (is_array($result_lp)) {
 					foreach ($result_lp as $key => $value) {
 						array_push($arrMails, $value['email']);
 					}

 					if (is_array($arrMails)) {
 						$subject = 'Encuesta Individual de Riesgo de Stress Psicosocial';
 						foreach ($arrMails as $key => $correo) {

							$nombre =  ucwords($_SESSION["Empresa"]["nombre"]);
							$count_user = 0;

			 				while ($count_user != 1) {
			 					$user = Util::passHasher($nombre,rand(1,20));
			 					$pass = Util::passHasher($nombre,rand(21,30));
			 					$count_user = $user_class->verificarUsername($user, $pass);
			 					if($count_user < 1)
			 						break;

			 					$count_user = 0;
			 				}
			 				
			 				$user_obj = array(
			 					'user_name' => $user, 
			 					'password' => Util::passHasher($pass,6), 
			 					'user_rol' => 9, 
			 					'id_empresa' => $id_e, 
			 					'id_personal' => null, 
			 					'token' => null, 
			 					);
			 				$user_obj = new User($user_obj);
			 				$user_obj->insert();
			 				$last_user = mysqli_insert_id($user_obj->link);
							$riesgo->insert_test_user($last_user, $id_test);

							$msj = '<p>Estimado/a,</p>';
							$msj .= '<p>Por favor use el vínculo, Usuario y Contraseña que se le indican más abajo a fin de que pueda abrir el cuestionario de Diagnóstico de Riesgo de Stress Psicosocial contratado por '.$nombre_empresa.'. Es imprescindible que responda con absoluta sinceridad y que sus respuestas se basen exclusivamente en su propia experiencia. Encontrará más instrucciones una vez que haya ingresado su usuario y contraseña.  Este vínculo quedará desactivado una vez que haya respondiedo el cuestionario.</p>';
							$msj .= "<p>Recuerde GRABAR al terminar el cuestionario. Gracias anticipadas por su dedicación.</p>";
							$msj .= "<p><b>Sitio Web: </b><a href='$link' target='_blanck'>$link</a></p>";
							$msj .= "<p><b>Usuario: </b>$user</p>";
							$msj .= "<p><b>Password: </b>$pass</p>";
							Util::sendMail($correo,$subject,$msj);
 						}
 					}
 				}
 			}
			

			$dispatch = new EmpresaController('Empresa','empresa','home',0);
			$dispatch->home();
		}
	}
	
	function definir(){
		Util::sessionStart();
	}
	function resultados(){
		Util::sessionStart();
		if(isset($_POST['filtro'])){
			// echo "in";
			$areas=$edad=$antiguedad=$localidad=$edad=$tcont=$educacion=$sexo=$filtros=$hijos="";
			if(isset($_POST['departamento'])){
				$ea = new Empresa_area();
				$ea_ids = array();
				foreach ($_POST['departamento'] as $dkey => $dvalue) {
					$ea_res = $ea->get_all_children($dvalue);	
					array_push($ea_ids, $dvalue);
					foreach ($ea_res as $eakey => $eaval) {
						array_push($ea_ids, $eaval['ids']);
					}
				}
				$ea_ids=array_unique($ea_ids);
				$filtros.="Áreas: ";
				$areas = "AND `departamento` IN (".implode(",", $ea_ids).")";
				$filtros.=implode(", ", array_map(array($this,'get_area'),$ea_ids));
				$filtros.=".<br>";
			}
			if(isset($_POST['edad'])){
				$filtros.="Edad: ";
				$edad = "AND `edad` IN (".implode(",", $_POST['edad']).")";
				$filtros.=implode(", ", array_map(array($this,'get_edad'),$_POST['edad']));
				$filtros.=".<br>";
			}
			if(isset($_POST['antiguedad'])){
				$filtros.="Antigüedad: ";
				$antiguedad = "AND `antiguedad` IN (".implode(",", $_POST['antiguedad']).")";
				$filtros.=implode(", ", array_map(array($this,'get_antiguedad'),$_POST['antiguedad']));
				$filtros.=".<br>";
			}
			if(isset($_POST['localidad'])){
				$el = new Empresa_local();
				$el_ids = array();
				foreach ($_POST['localidad'] as $ckey => $cvalue) {
					$el_res = $el->get_all_children($cvalue);	
					array_push($el_ids, $cvalue);
					foreach ($el_res as $elkey => $elval) {
						array_push($el_ids, $elval['ids']);
					}
				}
				$el_ids=array_unique($el_ids);
				// var_dump($el_ids);
				$filtros.="Localidad: ";
				$localidad = "AND `localidad` IN (".implode(",", $el_ids).")";
				$filtros.=implode(", ", array_map(array($this,'get_localidad'),$el_ids));
				$filtros.=".<br>";
			}
			if(isset($_POST['norg'])){
				$filtros.="Nivel organizacional: ";
				$edad = "AND `norg` IN (".implode(",", $_POST['norg']).")";
				$filtros.=implode(", ", array_map(array($this,'get_norg'),$_POST['norg']));
				$filtros.=".<br>";
			}
			if(isset($_POST['tcont'])){
				$filtros.="Tipo de contrato: ";
				$tcont = "AND `tcont` IN (".implode(",", $_POST['tcont']).")";
				$filtros.=implode(", ", array_map(array($this,'get_tcont'),$_POST['tcont']));
				$filtros.=".<br>";
			}
			if(isset($_POST['educacion'])){
				$filtros.="Educacion: ";
				$educacion = "AND `educacion` IN (".implode(",", $_POST['educacion']).")";
				$filtros.=implode(", ", array_map(array($this,'get_educacion'),$_POST['educacion']));
				$filtros.=".<br>";
			}
			if(isset($_POST['sexo'])){
				$filtros.="Sexo: ";
				$sexo = "AND `sexo` IN (".implode(",", $_POST['sexo']).")";
				$filtros.=implode(", ", array_map(array($this,'get_sexo'),$_POST['sexo']));
				$filtros.=".<br>";
			}
			if(isset($_POST['hijos'])){
				$filtros.="Hijos: ";
				$hijos = "AND `hijos` IN (".implode(",", $_POST['hijos']).")";
				$filtros.=implode(", ", array_map(array($this,'get_hijos'),$_POST['hijos']));
				$filtros.=".<br>";
			}
			$args = array(
				'areas' => $areas, 
				'edad' => $edad, 
				'antiguedad' => $antiguedad, 
				'localidad' => $localidad, 
				'edad' => $edad, 
				'tcont' => $tcont, 
				'educacion' => $educacion, 
				'sexo' => $sexo,
				'hijos' => $hijos
				);
			// echo $filtros;
			$filtros = ($filtros=="") ? "Todos" : $filtros;
			$_SESSION['filtros']=$filtros;
			$_SESSION['rp']['seg']=$args;
			$this->set('args',$args);
			$this->set('filtros',$filtros);
			$_POST=null;
			// header("Location: ".BASEURL.$GLOBALS['model_x'].DS.$GLOBALS['action_x']."");
		}else{
			if(isset($_SESSION['rp']['seg']))
				$this->set('args',$_SESSION['rp']['seg']);
			else{
				$this->set('args',"");
				$_SESSION['rp']['seg']="";
			}
			if(isset($_SESSION['filtros']))
				$this->set('filtros',$_SESSION['filtros']);
			else
				$this->set('filtros',"Todos");
		}
	}
	
	function resultados_pregunta($id_tema){
		Util::sessionStart();
		$this->set('id_tema',$id_tema);
	}

	function top($ord, $id_s, $flag, $campo = '', $valor = ''){
		$this->haySession();
		$this->set('order',$ord);
		$this->set('id_s',$id_s);

		$respuesta = new Rp_respuesta;
		$z = new Rp_user();

		if($flag == 'RS'){
			$ids = $z->get_id_x_segmentacion($_SESSION['Empresa']['id'], $id_s, $campo, $valor);
		}else{
			if(isset($_SESSION[$flag]['args']))
				$args = $_SESSION[$flag]['args'];
			else
				$args = "";
			$ids = $z->get_id_x_riesgo($args, $id_s);
		}

		$array=$respuesta->get_top($ids,$ord,10);

		$this->set('res',$array);
	}

	function riesgo_historicos(){
		$this->haySession();
		$new_arrFechas = null;
		$arrFechas = $this->getFechas($_SESSION['USER-AD']['id_empresa']);
		if (is_array($arrFechas)) {
			foreach ($arrFechas as $cont => $arrDatos) {
				$anio = $arrDatos['fecha'];
				$anio = explode('-', $anio);
				$new_arrFechas[$cont]['id'] = $arrDatos['id'];
				$new_arrFechas[$cont]['fecha'] = $arrDatos['fecha'];
			}
		}
		$this->set('new_arrFechas', $new_arrFechas);
	}

	function riesgo_resultados($id_s){
		$this->haySession();
		$riesgo = new Riesgo_psicosocial();
		$filtros = "Riesgo: ".$riesgo->get_fecha_x_id($_SESSION['Empresa']['id'], $id_s);
		$filtros.=".<br>";
		$_SESSION['RR']['filtros'] = $filtros;

		if(isset($_POST['filtro'])){
			$areas=$edad=$antiguedad=$localidad=$edad=$tcont=$educacion=$sexo=$hijos="";
			if(isset($_POST['departamento'])){
				$ea = new Empresa_area();
				$ea_ids = array();
				foreach ($_POST['departamento'] as $dkey => $dvalue) {
					$ea_res = $ea->get_all_children($dvalue);	
					array_push($ea_ids, $dvalue);
					foreach ($ea_res as $eakey => $eaval) {
						array_push($ea_ids, $eaval['ids']);
					}
				}
				$ea_ids=array_unique($ea_ids);
				$filtros.="Áreas: ";
				$areas = "AND `departamento` IN (".implode(",", $ea_ids).")";
				$filtros.=implode(", ", array_map(array($this,'get_area'),$ea_ids));
				$filtros.=".<br>";
			}
			if(isset($_POST['edad'])){
				$filtros.="Edad: ";
				$edad = "AND `edad` IN (".implode(",", $_POST['edad']).")";
				$filtros.=implode(", ", array_map(array($this,'get_edad'),$_POST['edad']));
				$filtros.=".<br>";
			}
			if(isset($_POST['antiguedad'])){
				$filtros.="Antigüedad: ";
				$antiguedad = "AND `antiguedad` IN (".implode(",", $_POST['antiguedad']).")";
				$filtros.=implode(", ", array_map(array($this,'get_antiguedad'),$_POST['antiguedad']));
				$filtros.=".<br>";
			}
			if(isset($_POST['localidad'])){
				$el = new Empresa_local();
				$el_ids = array();
				foreach ($_POST['localidad'] as $ckey => $cvalue) {
					$el_res = $el->get_all_children($cvalue);	
					array_push($el_ids, $cvalue);
					foreach ($el_res as $elkey => $elval) {
						array_push($el_ids, $elval['ids']);
					}
				}
				$el_ids=array_unique($el_ids);
				// var_dump($el_ids);
				$filtros.="Localidad: ";
				$localidad = "AND `localidad` IN (".implode(",", $el_ids).")";
				$filtros.=implode(", ", array_map(array($this,'get_localidad'),$el_ids));
				$filtros.=".<br>";
			}
			if(isset($_POST['norg'])){
				$filtros.="Nivel organizacional: ";
				$edad = "AND `norg` IN (".implode(",", $_POST['norg']).")";
				$filtros.=implode(", ", array_map(array($this,'get_norg'),$_POST['norg']));
				$filtros.=".<br>";
			}
			if(isset($_POST['tcont'])){
				$filtros.="Tipo de contrato: ";
				$tcont = "AND `tcont` IN (".implode(",", $_POST['tcont']).")";
				$filtros.=implode(", ", array_map(array($this,'get_tcont'),$_POST['tcont']));
				$filtros.=".<br>";
			}
			if(isset($_POST['educacion'])){
				$filtros.="Educacion: ";
				$educacion = "AND `educacion` IN (".implode(",", $_POST['educacion']).")";
				$filtros.=implode(", ", array_map(array($this,'get_educacion'),$_POST['educacion']));
				$filtros.=".<br>";
			}
			if(isset($_POST['sexo'])){
				$filtros.="Sexo: ";
				$sexo = "AND `sexo` IN (".implode(",", $_POST['sexo']).")";
				$filtros.=implode(", ", array_map(array($this,'get_sexo'),$_POST['sexo']));
				$filtros.=".<br>";
			}
			if(isset($_POST['hijos'])){
				$filtros.="Hijos: ";
				$hijos = "AND `hijos` IN (".implode(",", $_POST['hijos']).")";
				$filtros.=implode(", ", array_map(array($this,'get_hijos'),$_POST['hijos']));
				$filtros.=".<br>";
			}
			$args = array(
				'areas' => $areas, 
				'edad' => $edad, 
				'antiguedad' => $antiguedad, 
				'localidad' => $localidad, 
				'edad' => $edad, 
				'tcont' => $tcont, 
				'educacion' => $educacion, 
				'sexo' => $sexo,
				'hijos' => $hijos
				);
			
			$filtros = ($filtros=="") ? "Todos" : $filtros;
			$_SESSION['RR']['filtros']=$filtros;
			$_SESSION['RR']['args']=$args;
			$this->set('args',$args);
			$this->set('filtros',$filtros);
			$_POST=null;
		}else{
			if(isset($_SESSION['RR']['args']))
				$this->set('args',$_SESSION['RR']['args']);
			else{
				$this->set('args',"");
				$_SESSION['RR']['args']="";
			}
			if(isset($_SESSION['RR']['filtros']))
				$this->set('filtros',$_SESSION['RR']['filtros']);
			else
				$this->set('filtros',"Todos");
		}

		$this->set('id_s', $id_s);
	}

	function riesgo_resultados_p($id_riesgo, $id_tema){
		Util::sessionStart();
		$this->set('id_riesgo',$id_riesgo);
		$this->set('id_tema',$id_tema);
	}

	function riesgo_comparar(){
		Util::sessionStart();

		if(isset($_POST['filtro'])){
			$areas=$edad=$antiguedad=$localidad=$edad=$tcont=$educacion=$sexo=$hijos=$filtros="";
			$arrSondas = array();

			$riesgo = new Riesgo_psicosocial();
			$riesgo->select_compara($_SESSION['USER-AD']['id_empresa']);
			$riesgos = $riesgo->getId();

			if(isset($_POST['riesgos'])){
				$filtros.="Riesgos: ";
				$riesgos = implode(",", $_POST['riesgos']);
				$filtros.=implode(", ", array_map(array($this,'get_riesgos'),$_POST['riesgos']));
				$filtros.=".<br>";
			}
			if(isset($_POST['departamento'])){
				$ea = new Empresa_area();
				$ea_ids = array();
				foreach ($_POST['departamento'] as $dkey => $dvalue) {
					$ea_res = $ea->get_all_children($dvalue);	
					array_push($ea_ids, $dvalue);
					foreach ($ea_res as $eakey => $eaval) {
						array_push($ea_ids, $eaval['ids']);
					}
				}
				$ea_ids=array_unique($ea_ids);
				$filtros.="Áreas: ";
				$areas = "AND `departamento` IN (".implode(",", $ea_ids).")";
				$filtros.=implode(", ", array_map(array($this,'get_area'),$ea_ids));
				$filtros.=".<br>";
			}
			if(isset($_POST['edad'])){
				$filtros.="Edad: ";
				$edad = "AND `edad` IN (".implode(",", $_POST['edad']).")";
				$filtros.=implode(", ", array_map(array($this,'get_edad'),$_POST['edad']));
				$filtros.=".<br>";
			}
			if(isset($_POST['antiguedad'])){
				$filtros.="Antigüedad: ";
				$antiguedad = "AND `antiguedad` IN (".implode(",", $_POST['antiguedad']).")";
				$filtros.=implode(", ", array_map(array($this,'get_antiguedad'),$_POST['antiguedad']));
				$filtros.=".<br>";
			}
			if(isset($_POST['localidad'])){
				$el = new Empresa_local();
				$el_ids = array();
				foreach ($_POST['localidad'] as $ckey => $cvalue) {
					$el_res = $el->get_all_children($cvalue);	
					array_push($el_ids, $cvalue);
					foreach ($el_res as $elkey => $elval) {
						array_push($el_ids, $elval['ids']);
					}
				}
				$el_ids=array_unique($el_ids);
				// var_dump($el_ids);
				$filtros.="Localidad: ";
				$localidad = "AND `localidad` IN (".implode(",", $el_ids).")";
				$filtros.=implode(", ", array_map(array($this,'get_localidad'),$el_ids));
				$filtros.=".<br>";
			}
			if(isset($_POST['norg'])){
				$filtros.="Nivel organizacional: ";
				$edad = "AND `norg` IN (".implode(",", $_POST['norg']).")";
				$filtros.=implode(", ", array_map(array($this,'get_norg'),$_POST['norg']));
				$filtros.=".<br>";
			}
			if(isset($_POST['tcont'])){
				$filtros.="Tipo de contrato: ";
				$tcont = "AND `tcont` IN (".implode(",", $_POST['tcont']).")";
				$filtros.=implode(", ", array_map(array($this,'get_tcont'),$_POST['tcont']));
				$filtros.=".<br>";
			}
			if(isset($_POST['educacion'])){
				$filtros.="Educacion: ";
				$educacion = "AND `educacion` IN (".implode(",", $_POST['educacion']).")";
				$filtros.=implode(", ", array_map(array($this,'get_educacion'),$_POST['educacion']));
				$filtros.=".<br>";
			}
			if(isset($_POST['sexo'])){
				$filtros.="Sexo: ";
				$sexo = "AND `sexo` IN (".implode(",", $_POST['sexo']).")";
				$filtros.=implode(", ", array_map(array($this,'get_sexo'),$_POST['sexo']));
				$filtros.=".<br>";
			}
			if(isset($_POST['hijos'])){
				$filtros.="Hijos: ";
				$hijos = "AND `hijos` IN (".implode(",", $_POST['hijos']).")";
				$filtros.=implode(", ", array_map(array($this,'get_hijos'),$_POST['hijos']));
				$filtros.=".<br>";
			}

			$args = array(
				'areas' => $areas, 
				'edad' => $edad, 
				'antiguedad' => $antiguedad, 
				'localidad' => $localidad, 
				'edad' => $edad, 
				'tcont' => $tcont, 
				'educacion' => $educacion, 
				'sexo' => $sexo,
				'hijos' => $hijos
				);
			
			$filtros = ($filtros=="") ? "Todos" : $filtros;
			$_SESSION['RC']['filtros']=$filtros;
			$_SESSION['RC']['args']=$args;
			$_SESSION['RC']['riesgos']=$riesgos;
			$this->set('args',$args);
			$this->set('filtros',$filtros);
			$this->set('riesgos',$riesgos);

			if(isset($_POST['riesgos']))
				$this->set('arrRiesgos',$_POST['riesgos']);
			else
				$this->set('arrRiesgos',array());

			$_POST=null;
		}else{
			if(isset($_SESSION['RC']['args']))
				$this->set('args',$_SESSION['RC']['args']);
			else{
				$this->set('args',"");
				$_SESSION['RC']['args']="";
			}
			if(isset($_SESSION['RC']['filtros']))
				$this->set('filtros',$_SESSION['RC']['filtros']);
			else
				$this->set('filtros',"Todos");
			if(isset($_SESSION['RC']['riesgos']))
				$this->set('riesgos',$_SESSION['RC']['riesgos']);
			else{
				$this->set('riesgos',"");
				$_SESSION['RC']['riesgos']="";
			}
			$this->set('arrRiesgos',array());
		}
	}

	function riesgo_comparar_p($id_tema){
		$this->haySession();

		if(isset($_SESSION['RC']['args']))
			$args=$_SESSION['RC']['args'];
		else
			$args="";

		if(isset($_SESSION['RC']['riesgos']))
			$riesgos=$_SESSION['RC']['riesgos'];
		else
			$riesgos="";

		$filtros = (isset($_SESSION['RC']['filtros'])) ? $_SESSION['RC']['filtros'] : "Todos" ;

		$this->set('args',$args);
		$this->set('riesgos',$riesgos);
		$this->set('filtros',$filtros);
		$this->set('id_tema',$id_tema);
	}

	function riesgo_segmentacion(){
		Util::sessionStart();

		if(isset($_POST['filtro'])){
			$areas=$edad=$antiguedad=$localidad=$edad=$tcont=$educacion=$sexo=$hijos=$filtros="";
			$arrCompara=null;
			/*
			if(isset($_POST['departamento'])){
				$ea = new Empresa_area();
				$ea_ids = array();
				foreach ($_POST['departamento'] as $dkey => $dvalue) {
					$ea_res = $ea->get_all_children($dvalue);	
					array_push($ea_ids, $dvalue);
					foreach ($ea_res as $eakey => $eaval) {
						array_push($ea_ids, $eaval['ids']);
					}
				}
				$ea_ids=array_unique($ea_ids);
				$filtros.="Áreas: ";
				$areas = "AND `departamento` IN (".implode(",", $ea_ids).")";
				$filtros.=implode(", ", array_map(array($this,'get_area'),$ea_ids));
				$filtros.=".<br>";
			}
			*/
			if(isset($_POST['departamento'])){
				$ea = new Empresa_area();
				$ea_ids = array();
				foreach ($_POST['departamento'] as $dkey => $dvalue) {
					$arrCompara['departamento'][] = $dvalue;
					array_push($ea_ids, $dvalue);
				}
				$ea_ids=array_unique($ea_ids);
				$filtros.="Áreas: ";
				$areas = " AND `departamento` IN (".implode(",", $ea_ids).")";
				$filtros.=implode(", ", array_map(array($this,'get_area'),$ea_ids));
				$filtros.=".<br>";
			}
			if(isset($_POST['edad'])){
				$filtros.="Edad: ";
				$edad = "AND `edad` IN (".implode(",", $_POST['edad']).")";
				$filtros.=implode(", ", array_map(array($this,'get_edad'),$_POST['edad']));
				$filtros.=".<br>";
				$arrCompara['edad'] = $_POST['edad'];
			}
			if(isset($_POST['antiguedad'])){
				$filtros.="Antigüedad: ";
				$antiguedad = "AND `antiguedad` IN (".implode(",", $_POST['antiguedad']).")";
				$filtros.=implode(", ", array_map(array($this,'get_antiguedad'),$_POST['antiguedad']));
				$filtros.=".<br>";
				$arrCompara['antiguedad'] = $_POST['antiguedad'];
			}
			if(isset($_POST['localidad'])){
				$el = new Empresa_local();
				$el_ids = array();
				foreach ($_POST['localidad'] as $ckey => $cvalue) {
					$el_res = $el->get_all_children($cvalue);	
					array_push($el_ids, $cvalue);
					foreach ($el_res as $elkey => $elval) {
						array_push($el_ids, $elval['ids']);
					}
				}
				$el_ids=array_unique($el_ids);
				$arrCompara['localidad'] = $el_ids;
				// var_dump($el_ids);
				$filtros.="Localidad: ";
				$localidad = "AND `localidad` IN (".implode(",", $el_ids).")";
				$filtros.=implode(", ", array_map(array($this,'get_localidad'),$el_ids));
				$filtros.=".<br>";
			}
			if(isset($_POST['norg'])){
				$filtros.="Nivel organizacional: ";
				$edad = "AND `norg` IN (".implode(",", $_POST['norg']).")";
				$filtros.=implode(", ", array_map(array($this,'get_norg'),$_POST['norg']));
				$filtros.=".<br>";
				$arrCompara['norg'] = $_POST['norg'];
			}
			if(isset($_POST['tcont'])){
				$filtros.="Tipo de contrato: ";
				$tcont = "AND `tcont` IN (".implode(",", $_POST['tcont']).")";
				$filtros.=implode(", ", array_map(array($this,'get_tcont'),$_POST['tcont']));
				$filtros.=".<br>";
				$arrCompara['tcont'] = $_POST['tcont'];
			}
			if(isset($_POST['educacion'])){
				$filtros.="Educacion: ";
				$educacion = "AND `educacion` IN (".implode(",", $_POST['educacion']).")";
				$filtros.=implode(", ", array_map(array($this,'get_educacion'),$_POST['educacion']));
				$filtros.=".<br>";
				$arrCompara['educacion'] = $_POST['educacion'];
			}
			if(isset($_POST['sexo'])){
				$filtros.="Sexo: ";
				$sexo = "AND `sexo` IN (".implode(",", $_POST['sexo']).")";
				$filtros.=implode(", ", array_map(array($this,'get_sexo'),$_POST['sexo']));
				$filtros.=".<br>";
				$arrCompara['sexo'] = $_POST['sexo'];
			}
			if(isset($_POST['hijos'])){
				$filtros.="Hijos: ";
				$hijos = "AND `hijos` IN (".implode(",", $_POST['hijos']).")";
				$filtros.=implode(", ", array_map(array($this,'get_hijos'),$_POST['hijos']));
				$filtros.=".<br>";
				$arrCompara['hijos'] = $_POST['hijos'];
			}
			if(isset($_POST['riesgos'])){
				$filtros.="Riesgos: ";
				$riesgos = $_POST['riesgos'];
				$filtros.=$this->get_riesgos($_POST['riesgos']);
				$filtros.=".<br>";
			}

			$args = array(
				'areas' => $areas, 
				'edad' => $edad, 
				'antiguedad' => $antiguedad, 
				'localidad' => $localidad, 
				'edad' => $edad, 
				'tcont' => $tcont, 
				'educacion' => $educacion, 
				'sexo' => $sexo,
				'hijos' => $hijos
				);
			//
			if (is_array($arrCompara)) {
				$arrTmp = $arrCompara;
				$arrCompara = null;
				$i = 0;
				foreach ($arrTmp as $campo => $arrDatos) {
					foreach ($arrDatos as $cont => $id) {
						$arrCompara[$i]['campo'] = $campo;
						switch ($campo) {
							case 'edad':
								$nombre = $this->get_edad($id);
								$arrCompara[$i]['id'] = $id;
								break;
							case 'antiguedad':
								$nombre = $this->get_antiguedad($id);
								$arrCompara[$i]['id'] = $id;
								break;
							case 'educacion':
								$nombre = $this->get_educacion($id);
								$arrCompara[$i]['id'] = $id;
								break;
							case 'departamento':
								$nombre = $this->get_area($id);
								$arrCompara[$i]['id'] = $id;
								break;
							case 'localidad':
								$nombre = $this->get_localidad($id);
								$arrCompara[$i]['id'] = $id;
								break;
							case 'norg':
								$nombre = $this->get_norg($id);
								$arrCompara[$i]['id'] = $id;
								break;
							case 'tcont':
								$nombre = $this->get_tcont($id);
								$arrCompara[$i]['id'] = $id;
								break;
							case 'sexo':
								$nombre = $this->get_sexo($id);
								$arrCompara[$i]['id'] = $id;
								break;
							case 'hijos':
								$nombre = $this->get_hijos($id);
								$arrCompara[$i]['id'] = $id;
								break;
						}
						//
						$arrCompara[$i]['nombre'] = $nombre;
						$i++;
					}
				}
			}
			//
			$filtros = ($filtros=="") ? "Todos" : $filtros;
			$_SESSION['RS']['filtros']=$filtros;
			$_SESSION['RS']['args']=$args;
			$_SESSION['RS']['riesgos']=$riesgos;
			$_SESSION['RS']['arrCompara']=$arrCompara;
			$this->set('args',$args);
			$this->set('filtros',$filtros);
			$this->set('riesgos',$riesgos);
			$this->set('arrCompara',$arrCompara);

			$_POST=null;
		}else{
			if(isset($_SESSION['RS']['args']))
				$this->set('args',$_SESSION['RS']['args']);
			else{
				$this->set('args',"");
				$_SESSION['RS']['args']="";
			}
			if(isset($_SESSION['RS']['filtros']))
				$this->set('filtros',$_SESSION['RS']['filtros']);
			else
				$this->set('filtros',"Todos");
			if(isset($_SESSION['RS']['riesgos']))
				$this->set('riesgos',$_SESSION['RS']['riesgos']);
			else{
				$this->set('riesgos',"");
				$_SESSION['RS']['riesgos']="";
			}
			if(isset($_SESSION['RS']['arrCompara']))
				$this->set('arrCompara',$_SESSION['RS']['arrCompara']);
			else{
				$this->set('arrCompara',"");
				$_SESSION['RS']['arrCompara']="";
			}
		}
	}

	function riesgo_segmentacion_p($id_tema){
		$this->haySession();

		if(isset($_SESSION['RS']['args']))
			$this->set('args',$_SESSION['RS']['args']);
		else{
			$this->set('args',"");
			$_SESSION['RS']['args']="";
		}
		if(isset($_SESSION['RS']['filtros']))
			$this->set('filtros',$_SESSION['RS']['filtros']);
		else
			$this->set('filtros',"Todos");
		if(isset($_SESSION['RS']['riesgos']))
			$this->set('riesgos',$_SESSION['RS']['riesgos']);
		else{
			$this->set('riesgos',"");
			$_SESSION['RS']['riesgos']="";
		}
		if(isset($_SESSION['RS']['arrCompara']))
			$this->set('arrCompara',$_SESSION['RS']['arrCompara']);
		else{
			$this->set('arrCompara',"");
			$_SESSION['RS']['arrCompara']="";
		}
		$this->set('id_tema',$id_tema);
	}

        function grupos_criticos(){
		$this->haySession();

		$arrRiesgos = array();

		$rendimiento = new Rendimiento();
		$sql =  "SELECT MAX(ID) as id FROM riesgo_psicosocial WHERE id_empresa = ".$_SESSION['Empresa']['id'];
		$row =  $rendimiento->query_($sql,1);
		if($row){
			array_push($arrRiesgos, $row['id']);
		}

		if(isset($_POST['filtro'])){			
			if(isset($_POST['riesgos'])){
				foreach ($_POST['riesgos'] as $key => $value) {
					array_push($arrRiesgos, $value);
				}
			}
		}

		$this->set('arrRiesgos',$arrRiesgos);
	}


	/////////////////////////////////////////////////////////////////////////
	function get_riesgos($id_s){
		$sql = 'SELECT fecha FROM riesgo_psicosocial WHERE id_empresa = '.$_SESSION['USER-AD']['id_empresa'].' and id = '.$id_s;
		$res = $this->Riesgo_psicosocial->query_($sql);
		echo mysqli_error($this->link);
		$res = @reset($res);
		$res = @reset($res);
		$fecha = $res;
		$sonda = new Riesgo_psicosocial();
		$anio = substr($fecha, 0, 4);
		$mes = substr($fecha, 5, 2);
		$mes = $sonda->parseMonth($mes);
		$dia = substr($fecha, 8, 2);
		$new_fecha = $dia.'-'.$mes.'-'.$anio;
		return $new_fecha;
	}
	function getFechas($id_e){
		$sql = 'SELECT id, fecha FROM riesgo_psicosocial WHERE id_empresa = '.$id_e.' and fecha != "" order by id desc';
		$res = $this->Riesgo_psicosocial->query_($sql);
		echo mysqli_error($this->link);
		return $res;
	}
	function get_edad($cod){
		switch ($cod) {
			case '0':
			return "Menor a 20 años";
			break;
			case '1':
			return "De 20 a 25 años";
			break;
			case '2':
			return "De 25 a 30 años";
			break;
			case '3':
			return "De 30 a 40 años";
			break;
			case '4':
			return "De 40 a 50 años";
			break;
			case '5':
			return "Más 50 años";
			break;
		}
	}
	function get_sexo($cod){
		switch ($cod) {
			case '0':
			return "Masculino";
			break;
			case '1':
			return "Femenino";
			break;
			case '2':
			return "N/E";
			break;
		}
	}
	function get_hijos($cod){
		switch ($cod) {
			case '0':
			return "Sí";
			break;
			case '1':
			return "No";
			break;
			case '2':
			return "N/E";
			break;
		}
	}
	function get_antiguedad($cod){
		switch ($cod) {
			case '0':
			return "Menor a 1 años";
			break;
			case '1':
			return "De 1 a 2 años";
			break;
			case '2':
			return "De 2 a 5 años";
			break;
			case '3':
			return "De 5 a 10 años";
			break;
			case '4':
			return "De 10 a 15 años";
			break;
			case '5':
			return "De 15 a 20 años";
			break;
			case '5':
			return "Más 20 años";
			break;
		}
	}
	function get_educacion($cod){
		switch ($cod) {
			case '0':
			return "Primaria incompleta";
			break;
			case '1':
			return "Primaria completa";
			break;
			case '2':
			return "Secundaria incompleta ";
			break;
			case '3':
			return "Secundaria completa ";
			break;
			case '4':
			return "Universidtaria incompleta";
			break;
			case '5':
			return "Universitaria completa";
			break;
			case '5':
			return "Postgrado";
			break;
		}
	}
	function get_area(&$cod){
		$res = $this->Riesgo_psicosocial->query('SELECT `nombre` FROM `empresa_area` WHERE `id`="'.$cod.'"',1);
		echo mysqli_error($this->link);
		$res = @reset($res);
		$res = @reset($res);
		return $this->Riesgo_psicosocial->htmlprnt($res);
	}
	function get_localidad($cod){
		$res = $this->Riesgo_psicosocial->query('SELECT `nombre` FROM `empresa_local` WHERE `id`="'.$cod.'"',1);
		echo mysqli_error($this->link);
		$res = @reset($res);
		$res = @reset($res);
		return $this->Riesgo_psicosocial->htmlprnt($res);
	}
	function get_cargo($cod){
		$res = $this->Riesgo_psicosocial->query('SELECT `nombre` FROM `empresa_cargo` WHERE `id`="'.$cod.'"',1);
		echo mysqli_error($this->link);
		$res = @reset($res);
		$res = @reset($res);
		return $this->Riesgo_psicosocial->htmlprnt($res);
	}
	function get_norg($cod){
		$res = $this->Riesgo_psicosocial->query('SELECT `nombre` FROM `empresa_norg` WHERE `id`="'.$cod.'"',1);
		echo mysqli_error($this->link);
		$res = @reset($res);
		$res = @reset($res);
		return $this->Riesgo_psicosocial->htmlprnt($res);
	}
	function get_tcont($cod){
		$res = $this->Riesgo_psicosocial->query('SELECT `nombre` FROM `empresa_tcont` WHERE `id`="'.$cod.'"',1);
		echo mysqli_error($this->link);
		$res = @reset($res);
		$res = @reset($res);
		return $this->Riesgo_psicosocial->htmlprnt($res);
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
?>