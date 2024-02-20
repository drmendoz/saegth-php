<?php

class EmpresaController extends Controller {

	protected $link;
	
	function __construct($model, $controller, $action, $type = 0, $full = false,$render=false) {

		parent::__construct($model, $controller, $action, $type, $full,$render);

		$this->link = $this->Empresa->getDBHandle();
	}

	function home(){
		$this->set('title','Alto Desempe&ntilde;o | Administrador');
		$this->hayPermiso();
	}

	function modificar(){
		$this->set('title','Alto Desempe&ntilde;o | Modificar empresa');
		$this->hayPermiso();
		$res = $this->Empresa->query('SELECT nombre,admin FROM empresa WHERE id="'. $_SESSION['Empresa']['id'] .'"',1);
		$res = reset($res);
		$_SESSION['Empresa']['nombre'] = $res['nombre'];
		$_SESSION['Empresa']['admin'] = $res['admin'];
	}

	function crear_areas(){
		$this->set('title','Alto Desempe&ntilde;o | &Aacute;reas');
		$this->set('backlink','empresa/modificar');
		$this->hayPermiso();
		if(isset($_POST['AD_NIVEL'])){
			if(!$this->Empresa->DB_exists('empresa_datos','id_empresa', $_SESSION["Empresa"]["id"])){
				$query = 'INSERT INTO `empresa_datos` (`id_empresa`,`areas`) VALUES ('.$_SESSION["Empresa"]["id"].','.$_POST["AD_NIVEL"].')';
			}else{
				$query = 'UPDATE `empresa_datos` SET `areas`='.$_POST["AD_NIVEL"].' WHERE `id_empresa`='.$_SESSION["Empresa"]["id"].'';
			}
			$_SESSION['Empresa']['niveles']['cantidad'] = $_POST['AD_NIVEL'];
			$this->Empresa->query($query);
			/*
			$this->_template = new Template('Empresa','areas_niveles');
			$this->areas_niveles();
			*/
			header("Location: " . BASEURL.'empresa/areas');
		}else{
		}
		$_POST=null;

	}

	function mostrar_areas(){
		$this->set('title','Alto Desempe&ntilde;o | &Aacute;reas');
		$this->set('backlink','empresa/modificar');
		$this->hayPermiso();
		if(isset($_POST['AD_NIVEL'])){
			if(!$this->Empresa->DB_exists('empresa_datos','id_empresa', $_SESSION["Empresa"]["id"])){
				$query = 'INSERT INTO `empresa_datos` (`id_empresa`,`areas`) VALUES ('.$_SESSION["Empresa"]["id"].','.$_POST["AD_NIVEL"].')';
			}else{
				$query = 'UPDATE `empresa_datos` SET `areas`='.$_POST["AD_NIVEL"].' WHERE `id_empresa`='.$_SESSION["Empresa"]["id"].'';
			}
			$_SESSION['Empresa']['niveles']['cantidad'] = $_POST['AD_NIVEL'];
			$this->Empresa->query($query);
			/*
			$this->_template = new Template('Empresa','areas_niveles');
			$this->areas_niveles();
			*/
			header("Location: " . BASEURL.'empresa/areas');
		}else{
		}
		$_POST=null;

	}

	function definir_area($nv,$id=null){
		$this->set('title','Alto Desempe&ntilde;o | &Aacute;reas');
		$this->set('backlink','empresa/crear_areas');
		$this->hayPermiso();
		if(isset($id)){
			$this->set('area',$this->Empresa->query('SELECT * FROM empresa_area WHERE id='.$id.'',1));
			$this->set('id',$id);
		}
		$id_e = $_SESSION["Empresa"]["id"];
		if(isset($_POST['guardar_datos'])){
			foreach ($_POST['chk'] as $a => $b) {

				$area_dat=array( 
					'id_empresa' => $id_e,
					'id' => $b,
					'nombre' => $_POST['nv_nombre'][$a],
					'id_superior' => $_POST['pid'],
					'nivel' => $_POST['nv_nivel'][$a]
					);
				$area = new Empresa_area($area_dat);
				if($b != 'on' && $b != '' ){
					$area->update();										
				}else{
					$area->insert();
				}
			}
			$_POST=null;
			if($a<=1){
				$nv = intval($nv);
				$nv++;
				$this->_template = new Template('Empresa','definir_area');
				$this->definir_area($nv,$area->id);
				// header("Location: " . BASEURL.'empresa'.DS.'definir_area'.DS.$nv.DS.$area->id);
			}else{
				// $this->_template = new Template('Empresa','crear_areas');
				// $this->crear_areas();
				header("Location: " . BASEURL.'empresa'.DS.'crear_areas');
			}
		}elseif(isset($_POST['eliminar'])){
			$nivel = new Empresa_area(array('id' => $_POST['pid'],'id_empresa' => $_SESSION["Empresa"]["id"]));
			$nivel->delete();
			$this->_template = new Template('Empresa','crear_areas');
			$this->crear_areas();
			header("Location: " . BASEURL.'empresa'.DS.'crear_areas');
		}
		$this->set('nv',$nv);
		$parent = new Empresa_area(array('id' => $id));
		$this->set('children',$parent->getChildren());
	}

	function localidades(){
		$this->set('title','Alto Desempe&ntilde;o | Localidades Pais');
		$this->set('backlink','empresa/modificar');
		$this->hayPermiso();
		if(isset($_POST['lc_nombre'])){
			foreach ($_POST['lc_nombre'] as $a => $b) {
				if(!$this->Empresa->DB_exists_double('empresa_local','id_empresa',$_SESSION["Empresa"]["id"],'id',$_POST['chk'][$a])){
					$query = 'INSERT INTO `empresa_local` (`id_empresa`,`nivel`,`nombre`) VALUES ('.$_SESSION["Empresa"]["id"].',0,"'.ucwords($b).'")';
				}else{
					$query = 'UPDATE `empresa_local` SET `nombre`="'.ucwords($b).'" WHERE `id_empresa`='.$_SESSION["Empresa"]["id"].' AND `id`='.$_POST['chk'][$a].'';
				}
				$this->Empresa->query($query);
			}
			$_SESSION["Empresa"]['local']['pais'] = $this->Empresa->DB_exists_double('empresa_local','id_empresa',$_SESSION["Empresa"]["id"],'nivel','0');
			$this->_template = new Template('Empresa','localidades_ciudades');
			$this->localidades_ciudades();
			header("Location: " . BASEURL.'empresa/localidades_ciudades');	
		}else{
			$_SESSION["Empresa"]['local']['pais'] = $this->Empresa->DB_exists_double('empresa_local','id_empresa',$_SESSION["Empresa"]["id"],'nivel','0');
		}
		$_POST=null;
	}

	function localidades_ciudades(){
		$this->set('title','Alto Desempe&ntilde;o | Localidades');
		$this->set('backlink','empresa/localidades');
		$this->hayPermiso();
		if(isset($_POST['lcc_nombre'])){
			foreach ($_POST['lcc_nombre'] as $a => $b) {
				$ids=explode(',', $_POST['chk'][$a]);
				if(!$this->Empresa->DB_exists_double('empresa_local','id_empresa',$_SESSION["Empresa"]["id"],'id',$ids[1])){
					$query = 'INSERT INTO `empresa_local` (`id_empresa`,`nivel`,`nombre`,`id_superior`) VALUES ('.$_SESSION["Empresa"]["id"].',1,"'.ucwords($b).'",'.$ids[0].')';
				}else{
					$query = 'UPDATE `empresa_local` SET `nombre`="'.ucwords($b).'" WHERE `id_empresa`='.$_SESSION["Empresa"]["id"].' AND `id`='.$ids[1].'';
				}
				$this->Empresa->query($query);
			}	
			$_SESSION["Empresa"]['local']['ciudad'] = $this->Empresa->DB_exists_double('empresa_local','id_empresa',$_SESSION["Empresa"]["id"],'nivel','1');
			$this->_template = new Template('Empresa','localidades_sucursales');
			$this->localidades_sucursales();	
			header("Location: " . BASEURL.'empresa/localidades_sucursales');
		}else{
			$_SESSION["Empresa"]['local']['ciudad'] = $this->Empresa->DB_exists_double('empresa_local','id_empresa',$_SESSION["Empresa"]["id"],'nivel','1');
		}
		$_POST=null;
	}

	function localidades_sucursales(){
		$this->set('title','Alto Desempe&ntilde;o | Localidades');
		$this->set('backlink','empresa/localidades_ciudades');
		$this->hayPermiso();
		if(isset($_POST['lcs_nombre'])){
			foreach ($_POST['lcs_nombre'] as $a => $b) {
				$ids=explode(',', $_POST['chk'][$a]);
				if (!empty($b)){
					if(!$this->Empresa->DB_exists_double('empresa_local','id_empresa',$_SESSION["Empresa"]["id"],'id',$ids[1])){
						$query = 'INSERT INTO `empresa_local` (`id_empresa`,`nivel`,`nombre`,`id_superior`) VALUES ('.$_SESSION["Empresa"]["id"].',2,"'.ucwords($b).'",'.$ids[0].')';
					}else{
						$query = 'UPDATE `empresa_local` SET `nombre`="'.ucwords($b).'" WHERE `id_empresa`='.$_SESSION["Empresa"]["id"].' AND `id`='.$ids[1].'';
					}
					$this->Empresa->query($query);
				}	
			}	
			$_SESSION["Empresa"]['local']['sucursal'] = $this->Empresa->DB_exists_double('empresa_local','id_empresa',$_SESSION["Empresa"]["id"],'nivel','2');
			$this->_template = new Template('Empresa','modificar');
			$this->modificar();	
			header("Location: " . BASEURL.'empresa/modificar');
		}else{
			$_SESSION["Empresa"]['local']['sucursal'] = $this->Empresa->DB_exists_double('empresa_local','id_empresa',$_SESSION["Empresa"]["id"],'nivel','2');
		}
		$_POST=null;
	}

	function cargo(){
		$this->set('title','Alto Desempe&ntilde;o | Cargos');
		$this->set('backlink','empresa/modificar');
		$this->hayPermiso();
		$cargo = new empresa_cargo();
		if(isset($_POST['cg_nombre'])){
			$id_e = $_SESSION["Empresa"]["id"];
			foreach ($_POST['cg_nombre'] as $a => $b) {
				$cargo->setNombre($b);
				if($_POST['chk'][$a]==""){
					$cargo->setId_empresa($id_e);
					$cargo->setId_superior($_POST['cg_crit'][$a]);
					$cargo->insert();
				}else{
					$cargo->setId($_POST['chk'][$a]);	
					$cargo->setId_superior($_POST['cg_crit'][$a]);
					$cargo->update();
					echo mysqli_error($this->link);
				}
			}
			// $this->_template = new Template('Empresa','modificar');
			// $this->modificar();	
		}
		$_POST=null;
	}

	function niveles_organizacionales(){
		$this->set('title','Alto Desempe&ntilde;o | Niveles Organizacionales');
		$this->set('backlink','empresa/modificar');
		$this->hayPermiso();
		if(isset($_POST['no_nombre'])){
			foreach ($_POST['no_nombre'] as $a => $b) {
				if(!$this->Empresa->DB_exists_double('empresa_norg','id_empresa',$_SESSION["Empresa"]["id"],'id',$_POST['chk'][$a])){
					$query = 'INSERT INTO `empresa_norg` (`id_empresa`,`nombre`) VALUES ('.$_SESSION["Empresa"]["id"].',"'.ucwords($b).'")';
				}else{
					$query = 'UPDATE `empresa_norg` SET `nombre`="'.ucwords($b).'" WHERE `id_empresa`='.$_SESSION["Empresa"]["id"].' AND `id`='.$_POST['chk'][$a].'';
				}
				$this->Empresa->query($query);
			}
			$_SESSION["Empresa"]['niveles_organizacionales'] = $this->Empresa->DB_exists('empresa_norg','id_empresa',$_SESSION["Empresa"]["id"]);
			$this->_template = new Template('Empresa','modificar');
			$this->modificar();	
			header("Location: " . BASEURL.'empresa/modificar');
		}else{
			$_SESSION["Empresa"]['niveles_organizacionales'] = $this->Empresa->DB_exists('empresa_norg','id_empresa',$_SESSION["Empresa"]["id"]);
		}
		$_POST=null;
	}

	function tipo_contrato(){
		$this->set('title','Alto Desempe&ntilde;o | Tipos de Contrato');
		$this->set('backlink','empresa/modificar');
		$this->hayPermiso();
		if(isset($_POST['tc_nombre'])){
			$tcont = new empresa_tcont();
			$id_e = $_SESSION["Empresa"]["id"];
			foreach ($_POST['tc_nombre'] as $a => $b) {
				$tcont->setNombre($b);
				if($_POST['chk'][$a]==""){
					$tcont->setId_empresa($id_e);
					$tcont->insert();
				}else{
					$tcont->setId($_POST['chk'][$a]);				
					$tcont->update();
					echo mysqli_error($this->link);
				}
			}
			// $this->_template = new Template('Empresa','modificar');
			// $this->modificar();	
		}
		$_POST=null;
	}
	
	function condicionadores(){
		$this->set('title','Alto Desempe&ntilde;o | Condicionadores');
		$this->set('backlink','empresa/modificar');
		$this->hayPermiso();
		if(isset($_POST['cd_nombre'])){
			foreach ($_POST['cd_nombre'] as $a => $b) {
				if(!$this->Empresa->DB_exists_double('empresa_cond','id_empresa',$_SESSION["Empresa"]["id"],'id',$_POST['chk'][$a])){
					$query = 'INSERT INTO `empresa_cond` (`id_empresa`,`nombre`,`nivel`) VALUES ('.$_SESSION["Empresa"]["id"].',"'.ucwords($b).'",0)';
				}else{
					$query = 'UPDATE `empresa_cond` SET `nombre`="'.ucwords($b).'" WHERE `id_empresa`='.$_SESSION["Empresa"]["id"].' AND `id`='.$_POST['chk'][$a].'';
				}
				//echo $query;
				$this->Empresa->query($query);
			}
			$_SESSION["Empresa"]['condicionadores'] = $this->Empresa->DB_exists_double('empresa_cond','id_empresa',$_SESSION["Empresa"]["id"],'nivel','0');
			$this->_template = new Template('Empresa','condicionadores_opciones');
			$this->condicionadores_opciones();
			header("Location: " . BASEURL.'empresa/condicionadores_opciones');	
		}else{
			$_SESSION["Empresa"]['condicionadores'] = $this->Empresa->DB_exists_double('empresa_cond','id_empresa',$_SESSION["Empresa"]["id"],'nivel','0');
		}
		$_POST=null;
	}
	
	function condicionadores_opciones(){
		$this->set('title','Alto Desempe&ntilde;o | Condicionadores');
		$this->set('backlink','empresa/condicionadores');
		$this->hayPermiso();
		if(isset($_POST['co_nombre'])){
			foreach ($_POST['co_nombre'] as $a => $b) {
				$ids=explode(',', $_POST['chk'][$a]);
				if(!$this->Empresa->DB_exists_double('empresa_cond','id_empresa',$_SESSION["Empresa"]["id"],'id',$ids[1])){
					$query = 'INSERT INTO `empresa_cond` (`id_empresa`,`nombre`,`nivel`,`id_superior`) VALUES ('.$_SESSION["Empresa"]["id"].',"'.ucwords($b).'",1,'.$ids[0].')';
				}else{
					$query = 'UPDATE `empresa_cond` SET `nombre`="'.ucwords($b).'" WHERE `id_empresa`='.$_SESSION["Empresa"]["id"].' AND `id`='.$ids[1].'';
				}
				//echo $query;
				$this->Empresa->query($query);
			}
			$this->_template = new Template('Empresa','modificar');
			$this->modificar();	
			header("Location: " . BASEURL.'empresa/modificar');
		}
		$_POST=null;
	}

	function grado_salarial(){
		$this->set('title','Alto Desempe&ntilde;o | &Aacute;reas');
		$this->set('backlink','empresa/modificar');
		$this->hayPermiso();
		$id_e = $_SESSION['Empresa']['id'];
		if(isset($_POST['guardar_datos'])){
			Grado_salarial::clear_db($id_e);
			foreach ($_POST['grado'] as $key => $value) {
				$gsal=Grado_salarial::create($value,$_POST['r_min'][$key],$_POST['r_med'][$key],$_POST['r_max'][$key],$id_e);
				$gsal->insert();
			}
		}
		$res = Grado_salarial::select_all($id_e);
		$this->set('grados',$res);
		$_POST=null;
	}

	function logo(){
		$this->set('title','Alto Desempe&ntilde;o | Logo');
		$this->set('backlink','empresa/modificar');
		$this->hayPermiso();
		if (isset($_FILES['file'])){
			$query = $this->Empresa->image_prep_($_FILES['file'],'empresa_datos','id_empresa',$_SESSION["Empresa"]["id"]);
			$this->Empresa->query($query);
		}
		$file = $this->Empresa->query_('SELECT `foto` FROM `empresa_datos` WHERE `id_empresa`='. $_SESSION["Empresa"]["id"] .'',1);
		if(array_filter($file)){
			$tmp = array_filter($file);
			$_SESSION['logo'] = $this->Empresa->htmlImage_($tmp['foto'],"img-responsive center-block");
		}else{
			$_SESSION['logo'] = '<img alt="No hay logo" width="200" height="150" src="'.BASEURL.'public/img/default.png">';
		}
	}

	function consolidado($id=null){
		$this->set('title','Alto Desempe&ntilde;o | Ver Empresa');
		$this->haySession();
		if(isset($id) && (!$_SESSION['USER-AD']['user_rol'])){
			$_SESSION["Empresa"]["id"] = $id;
		}
		$this->set('id',$_SESSION["Empresa"]["id"]);
		/* LOGO EMPRESA */
		$emp = new Empresa();
		$emp->select($_SESSION["Empresa"]["id"]);
		$emp->getFoto();
		$file = $emp->foto;
		// $file = $emp->foto;

		if($file){
			if(array_filter($file)){
				$tmp = array_filter($file);
				//$file,$table,$field,$match
				$_SESSION['logo'] = $emp->htmlImage_($tmp['foto'],'res-img');
				$_SESSION['file'] = true;
			}else{
				$_SESSION['file'] = false;
			}
		}
		switch ($_SESSION['USER-AD']['user_rol']) {
			case 1:
			$this->set('user_rol','admin');
			break;
			
			default:
			$this->set('user_rol','user');
			break;
		}
		$tmp = array(
			'id' => null,
			'nombre' => null, 
			'nivel' => null, 
			'status' => 'loading', 
			'icon' => '<i class="fa fa-spinner fa-pulse fa-2x"></i>',
			'n_empleados' => null,
			'hombres' => null,
			'mujeres' => null,
			'edad' => null,
			'antiguedad' => null,
			'sueldos' => null
			);
		$final = array();
		$ea = new empresa_area();
		$hey = $ea->select_nivel($_SESSION['Empresa']['id'],1);
		$inicial = $hey[0]['Empresa_area'];
		$tmp['id'] = $inicial['id'];
		$tmp['nombre'] = $ea->htmlprnt_win($inicial['nombre']);
		array_push($final, $tmp);
		$res = $ea->getTree($inicial['id']);
		if($res){
			foreach ($res as $key => $value) {
				$tmp['id'] = $value['id'];
				$tmp['nombre'] = $ea->htmlprnt_win($value['nombre_']);
				array_push($final, $tmp);
			}
			$json = json_encode($final);

			$et = new empresa_tcont();
			$tconts_array = $et->select_all($_SESSION['Empresa']['id'],true);
			$tconts = array(
				'tipos' => $tconts_array,
				'conteo' => sizeof($tconts_array), 
				);
			$tconts = json_encode($tconts, JSON_PRETTY_PRINT);
			$this->set('tconts',$tconts);

			$en = new empresa_norg();
			$norgs_array = $en->select_all($_SESSION['Empresa']['id'],true);
			$norgs = array(
				'tipos' => $norgs_array,
				'conteo' => sizeof($norgs_array), 
				);
			$norgs = json_encode($norgs, JSON_PRETTY_PRINT);
			$this->set('norgs',$norgs);
		}else{
			$json = "";	
		}
		$this->set('json',$json);
	} 

	function multifuente(){
		$this->hayEmpresa();
		$this->set('title','Alto Desempe&ntilde;o');
		$evaluados=$this->Empresa->query('SELECT DISTINCT `id_personal` FROM `multifuente_evaluado` WHERE `id_empresa`='.$_SESSION["Empresa"]["id"].'');
		$this->set('evaluados',$evaluados);
	}

	function info(){
		$this->hayEmpresa();
	}


	//SELECT DISTINCT id_evaluado FROM multifuente_evaluadores WHERE relacion=0 AND id_personal='.$id.'');
	/*

























	*/

	function logout(){
		Util::sessionLogout();
		$this->Empresa->disconnect();
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
		$this->_template = new Template('Empresa','empresa_ingreso');
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
		if ($session && ($_SESSION['USER-AD']['user_rol']==2)) {
			echo "<script>alert('No tiene los permisos necesarios para navegar esta sección');window.location = '".BASEURL.$_SESSION['link']."';</script>";
		}
		return true;
	}

	function hayEmpresa(){
		$this->haySession();
		if (!isset($_SESSION['Empresa'])){
			$this->logout();
		}
	}

	function hayPersonal(){
		$this->haySession();
		if (!isset($_SESSION['personal']['id'])){
			$this->_template = new Template('Empresa','personal_ingreso');
			$this->personal_ingreso();
			exit();
		}
	}	

	function get_tema($cod){
		$res = $this->Empresa->query('SELECT tema,descripcion FROM `temas_360` WHERE `cod_tema`="'.$cod.'"',1);
		$res = @reset($res);
		return $res;
	}

	function get_emailById($id){
		$res = $this->Empresa->query('SELECT `email` FROM `personal_datos` WHERE `id`="'.$id.'"',1);
		$res = @reset($res);
		$res = @reset($res);
		return $res;
	}
	//nombre,nombre_evaluado,fecha,cod_evaluado,usr,fecha_max
	function get_MsgEvaluadores($nombre,$nombre_evaluado,$fecha,$cod_evaluado,$usr,$fecha_max){
		$message = "<p>Estimado(a) ".$nombre.",</p><p>Este es un recordatorio automático para que complete la evaluación de ".$nombre_evaluado ." la cual le fue enviada el ".$fecha.".  Gracias por su colaboración.</p>";
		$message .= "<p>El link adjunto <a href = '".BASEURL."user/login/multifuente/".$cod_evaluado."/".$usr."'> Evaluación multifuentes</a> llevará directamente al cuestionario.</p><p>Si por alguna razón debe interrumpir la respuesta al cuestionario, por favor asegúrese de hacer click en el Botón “Grabar y Continuar luego” que está al final del cuestionario.  Usted podrá entrar y salir del cuestionario tantas veces lo requiera utilizando este mismo link (contenido en esta comunicación) sin embargo, le recomendamos enfáticamente que trate de contestar de una sola vez el cuestionario completo.</p><p>Le solicitamos también que conteste este cuestionario como máximo hasta el ".$fecha_max.". A fin de facilitarle la comprensión del uso y sobretodo de los beneficios de esta herramienta le invitamos a ver una corta presentación a través de  <a href = 'http://youtu.be/KF_b9jeLam0'>Video</a> </p><p>Desde ya le agradecemos su colaboración. </p>";
		return $message;
	}


	function get_MsgEvaluado($nombre,$fecha,$cod_evaluado,$usr,$fecha_max){
		$message = "<p>Estimado(a) ".$nombre.",</p><p>Este es un recordatorio automático para que complete su evaluación; la cual le fue enviada el ".$fecha.".  Gracias por su colaboración.</p>";
		$message .= "<p>El link adjunto <a href = '".BASEURL."user/login/multifuente/".$cod_evaluado."/".$usr."'> Evaluación multifuentes</a> llevará directamente al cuestionario.</p><p>Si por alguna razón debe interrumpir la respuesta al cuestionario, por favor asegúrese de hacer click en el Botón “Grabar y Continuar luego” que está al final del cuestionario.  Usted podrá entrar y salir del cuestionario tantas veces lo requiera utilizando este mismo link (contenido en esta comunicación) sin embargo, le recomendamos enfáticamente que trate de contestar de una sola vez el cuestionario completo.</p><p>Le solicitamos también que conteste este cuestionario como máximo hasta el ".$fecha_max.". A fin de facilitarle la comprensión del uso y sobretodo de los beneficios de esta herramienta le invitamos a ver una corta presentación a través de  <a href = 'http://youtu.be/KF_b9jeLam0'>Video</a> </p><p>Desde ya le agradecemos su colaboración. </p>";
		return $message;
	}

	
}

