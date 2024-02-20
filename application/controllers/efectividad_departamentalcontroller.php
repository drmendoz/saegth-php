<?php



class Efectividad_departamentalController extends Controller {



	protected $link;

	

	function __construct($model, $controller, $action, $type = 0,$full=false,$render=false) {



		parent::__construct($model, $controller, $action, $type,$full,$render);



		$this->link = $this->Efectividad_departamental->getDBHandle();

	}

	

	function test($id_e,$id_t){

		$this->haySession();

		$this->set('id_e',$id_e);

		$this->set('id_t',$id_t);

		if(array_filter($_POST)){

			$id_e = $_SESSION['USER-AD']['id_empresa'];

			$suser = new Sonda_user();

			$suser->setId_empresa($id_e);

			if(isset($_POST['edad'])){

				$suser->setEdad($_POST['edad']);

				unset($_POST['edad']);

			}

			if(isset($_POST['antiguedad'])){

				$suser->setAntiguedad($_POST['antiguedad']);

				unset($_POST['antiguedad']);

			}

			if(isset($_POST['localidad'])){

				$suser->setLocalidad($_POST['localidad']);

				unset($_POST['localidad']);

			}

			if(isset($_POST['area'])){

				$suser->setDepartamento($_POST['area']);

				unset($_POST['area']);

			}

			if(isset($_POST['norg'])){

				$suser->setNorg($_POST['norg']);

				unset($_POST['norg']);

			}

			if(isset($_POST['tcont'])){

				$suser->setTcont($_POST['tcont']);

				unset($_POST['tcont']);

			}

			if(isset($_POST['educacion'])){

				$suser->setEducacion($_POST['educacion']);

				unset($_POST['educacion']);

			}

			if(isset($_POST['sexo'])){

				$suser->setSexo($_POST['sexo']);

				unset($_POST['sexo']);

			}

			$suser->setId_test($_POST['id_test']);

			unset($_POST['id_test']);

			$suser->insert();

			$sonda = new Efectividad_departamental();

			$sonda->select($id_e);

			foreach ($_POST as $key => $value) {

				$respuesta = new Sonda_respuesta();

				$respuesta->setId_suser($suser->getId());

				$respuesta->setId_test($sonda->getId());

				$respuesta->setId_pregunta($key);

				$respuesta->setRespuesta($value);

				$respuesta->insert();

			}

		}

	}



	function test_temp($id_e,$id_t){

		$this->haySession();

		$this->set('id_e',$id_e);

		$this->set('id_t',$id_t);

		$sonda = new Efectividad_departamental();
		$sonda->select_($id_e,$id_t);
		$criterios_escala = $sonda->getCriteriosEscala();
		$nuevos_criterios = $sonda->getNuevosCriterios();

		$min_escala = '';
		$max_escala = '';
		$hay_caracter = 0;
		$i = 1;
		$escala_valor = '';

		if ($nuevos_criterios == 1) {
			if (is_array($criterios_escala)) {
				foreach ($criterios_escala as $key => $value) {

					$escala_valor = $escala_valor . $criterios_escala[$key]['escala_valor'] . ',';

					if (ctype_alpha($criterios_escala[$key]['escala_valor'])) {
						$hay_caracter = 1;
					}
					if ($key != 0) {
						if ($key == 1) {
							$min_escala = $criterios_escala[$key]['escala_valor'];
						}
						else{
							$max_escala = $criterios_escala[$key]['escala_valor'];
						}
					}
				}
			}

			$escala_valor = substr($escala_valor, 0, -1);
		}
		else{
			$min_escala = 1;
			$max_escala = 5;
			$hay_caracter = 0;
		}

		$this->set('min_escala',$min_escala);
		$this->set('max_escala',$max_escala);
		$this->set('hay_caracter',$hay_caracter);
		$this->set('nuevos_criterios',$nuevos_criterios);
		$this->set('escala_valor',$escala_valor);

		if(array_filter($_POST)){

			$id_e = $_SESSION['USER-AD']['id_empresa'];

			$suser = new Sonda_user();
			
			$suser->setIdPersonal($_SESSION['USER-AD']['id_personal']);

			$suser->setId_empresa($id_e);

			if(isset($_POST['edad'])){

				$suser->setEdad($_POST['edad']);

				unset($_POST['edad']);

			}

			if(isset($_POST['antiguedad'])){

				$suser->setAntiguedad($_POST['antiguedad']);

				unset($_POST['antiguedad']);

			}

			if(isset($_POST['localidad'])){

				$suser->setLocalidad($_POST['localidad']);

				unset($_POST['localidad']);

			}

			if(isset($_POST['area'])){

				$suser->setDepartamento($_POST['area']);

				unset($_POST['area']);

			}

			if(isset($_POST['norg'])){

				$suser->setNorg($_POST['norg']);

				unset($_POST['norg']);

			}

			if(isset($_POST['tcont'])){

				$suser->setTcont($_POST['tcont']);

				unset($_POST['tcont']);

			}

			if(isset($_POST['educacion'])){

				$suser->setEducacion($_POST['educacion']);

				unset($_POST['educacion']);

			}

			if(isset($_POST['sexo'])){

				$suser->setSexo($_POST['sexo']);

				unset($_POST['sexo']);

			}

			$suser->setId_test($_POST['id_test']);

			unset($_POST['id_test']);

			$suser->insert();


			$user_foda = new Sonda_user_foda();

			if (isset($_POST['comentario'])) {
			
				foreach ($_POST['comentario'] as $tipo => $comentario) {
					if (trim($comentario) != '') {
						
						$user_foda->setComentario($comentario);

						$user_foda->setTipo($tipo);

						$user_foda->setId_suser($suser->getId());

						$user_foda->setId_test($id_t);

						$user_foda->insert();
					}
				}

			}

			unset($_POST['comentario']);

			$sonda = new Efectividad_departamental();

			$sonda->select($id_e);

			$id_user = $_SESSION['USER-AD']['id'];

			unset($_POST['nuevos_criterios']);
			unset($_POST['hay_caracter']);
			unset($_POST['max_escala']);
			unset($_POST['min_escala']);
			unset($_POST['escala_valor']);

			foreach ($_POST as $key => $value) {

				if ($value  == 'X') {
					$value = -1;
				}

				$respuesta = new Sonda_respuesta();

				$respuesta->setId_suser($suser->getId());

				$respuesta->setId_test($sonda->getId());

				$respuesta->setId_pregunta($key);

				$respuesta->setRespuesta($value);

				$respuesta->setId_user($id_user);

				$respuesta->insert();

			}

			$this->_template = new Template('Void','render');

			$dispatch = new TempController('Temp','temp','home');

			$dispatch->home();

		}

	}

	function test_temp_foda($id_e,$id_t){

		$this->set('title','Alto Desempe&ntilde;o | ScoreCard');

		$this->haySession();

		$sonda = new Efectividad_departamental();
		
		$sonda->select($id_e,$id_t);

		$custom_email = $sonda->getCustom_email();

		$foda = $sonda->getFoda();

		$this->set('foda',$foda);
	}



	function construccion(){

		$this->haySession();

	}



	function clima_laboral(){

		$this->haySession();

	}



	function definir(){

		$this->haySession();

	}

	function definir_v($id_s){

		$this->haySession();

		if(isset($_POST['submit'])){
			$sonda = new Efectividad_departamental();
			$sonda->select_($_SESSION['Empresa']['id'], $id_s);

			$sonda->setId($id_s);
			$sonda->setId_empresa($_SESSION['Empresa']['id']);
			$sonda->setSegmentacion($_POST['segmentacion']);
			$sonda->setFecha($_POST['fecha']);
			$sonda->update();

			$this->_template = new Template('Void','render');
			$dispatch = new EmpresaController('Empresa','empresa','home',0);
			$dispatch->home();
		}

		$this->set('id_s',$id_s);

	}



	function def_preguntas(){

		$this->haySession();

		if(array_filter($_POST)){

			if(isset($_POST['submit'])){

				$temas = $preguntas = 0;

				foreach ($_POST['preguntas'] as $key => $value) {

					$data = explode(",", $value);

					$test_data[$data[0]][] = $data[1];

				}

				$this->set('test-data',$test_data);

				$sonda = new Efectividad_departamental();

				$sonda->select($_SESSION['Empresa']['id']);

				$sonda->setTemas($test_data);

				$sonda->update();

				$this->_template = new Template('Void','render');

				$id_test = $sonda->getId();



				/*
					USUARIO EN LINEA
				*/

				$correo = $sonda->getEmail();

				$subject = 'Encuesta en Línea de Efectividad Departamental';

				$link = BASEURL;

				$id_e = $_SESSION["Empresa"]["id"];

				$user_class = new User();



				$nombre =  ucwords($_SESSION["Empresa"]["nombre"]);

				$count_user = 0;



				while ($count_user != 1) {

 					$user = Util::passHasher($nombre,rand(1,20));

 					//$pass = Util::passHasher($nombre,rand(21,30));
					$pass = Util::passHasher($nombre,rand(1,1000));

 					$count_user = $user_class->verificarUsername($user, $pass);

 					if($count_user < 1)

 						break;



 					$count_user = 0;

 				}



 				$user_obj = array(

 					'user_name' => $user, 

 					'password' => Util::passHasher($pass,6), 

 					'user_rol' => 10, 

 					'id_empresa' => $id_e, 

 					'id_personal' => null, 

 					'token' => $pass, 

 					);

 				$user_obj = new User($user_obj);

 				$user_obj->insert();

 				$last_user = mysqli_insert_id($user_obj->link);

 				$sonda->insert_test_user($last_user, $id_test);



 				$msj = '<p>Estimado/a,</p>';

				$msj .= '<p>Use el Vínculo, Usuario y Contraseña, proporcionados abajo, para abrir la plantilla de ingreso de respuestas a la Encuesta de Efectividad Departamental aplicadas en Línea.</p>';

				$msj .= "<p>No olvide GRABAR al finalizar de responder.</p>";

				$msj .= "<p><b>Sitio Web: </b><a href='$link' target='_blanck'>$link</a></p>";

				$msj .= "<p><b>Usuario: </b>$user</p>";

				$msj .= "<p><b>Password: </b>$pass</p>";

				Util::sendMail($correo,$subject,$msj);





				/*
					USUARIO EN PAPEL
				*/



				$subject = 'Encuesta en Papel de Efectividad Departamental';

				$link = BASEURL;

				$nombre =  ucwords($_SESSION["Empresa"]["admin"]);

 				$count_user = 0;



 				while ($count_user != 1) {

 					$user = Util::passHasher($nombre,rand(1,20));

 					//$pass = Util::passHasher($nombre,rand(21,30));
					$pass = Util::passHasher($nombre,rand(1,1000));

 					$count_user = $user_class->verificarUsername($user, $pass);

 					if($count_user < 1)

 						break;



 					$count_user = 0;

 				}



 				$user_obj = array(

 					'user_name' => $user, 

 					'password' => Util::passHasher($pass,6), 

 					'user_rol' => 11, 

 					'id_empresa' => $id_e, 

 					'id_personal' => null, 

 					'token' => $pass, 

 					);

 				$user_obj = new User($user_obj);

 				$user_obj->insert();

 				$last_user = mysqli_insert_id($user_obj->link);

 				$sonda->insert_test_user($last_user, $id_test);



				$msg = '<p>Estimado/a,</p>';

				$msg .= '<p>Use el Vínculo, Usuario y Contraseña, proporcionados abajo, para abrir la plantilla de ingreso de respuestas a la Encuesta de Efectividad Departamental aplicadas en Papel.</p>';

				$msg .= "<p>No olvide GRABAR al finalizar de responder.</p>";

				$msg .= "<p><b>Sitio Web: </b><a href='$link' target='_blanck'>$link</a></p>";

				$msg .= "<p><b>Usuario: </b>$user</p>";

				$msg .= "<p><b>Password: </b>$pass</p>";

				Util::sendMail($correo,$subject,$msg);




				//	EMAILS A EMPLEADOS

				$custom_email = $sonda->getCustom_email();echo "custom_email ".$custom_email;

				$nombre_empresa =  strtoupper($_SESSION["Empresa"]["nombre"]);

				if($custom_email == 1){

	 				$sql =	'SELECT lp.id AS id_personal, lp.nombre, lp.email ';
					$sql .=	'FROM `listado_personal_op` AS lp ';
					$sql .=	'WHERE lp.empresa = '.$_SESSION['Empresa']['id'].' ';
					$sql .=	'AND lp.activo = 1 ';

					$result_lp = $this->Efectividad_departamental->query_($sql);

	 				$subject = 'Encuesta Individual de Efectividad Departamental';


	 				if (is_array($result_lp)) {

	 					$nombre =  ucwords($_SESSION["Empresa"]["nombre"]);
						
						$user = "";
	 					$pass = "";

	 					foreach ($result_lp as $key => $value) {

	 						$count_user = 0;



			 				while ($count_user != 1) {

			 					$user = Util::passHasher($nombre,rand(1,1000));

			 					//$pass = Util::passHasher($nombre,rand(21,30));
								$pass = Util::passHasher($nombre,rand(1,1000));

			 					if ($user != "" && $pass != "") {
			 						$count_user = $user_class->verificarUsername($user, $pass);

				 					if($count_user < 1)

				 						break;	
			 					}

			 					$count_user = 0;

			 				}

			 				

			 				$user_obj = array(

			 					'user_name' => $user, 

			 					'password' => Util::passHasher($pass,6), 

			 					'user_rol' => 12, 

			 					'id_empresa' => $id_e, 

			 					'id_personal' => $value['id_personal'], 

			 					'token' => $pass, 

			 					);

			 				$user_obj = new User($user_obj);

			 				$user_obj->insert();

			 				$last_user = mysqli_insert_id($user_obj->link);

							$sonda->insert_test_user($last_user, $id_test);



							$msj = '<p>Estimado/a,</p>';

							$msj .= '<p>Por favor use el vínculo, Usuario y Contraseña que se le indican más abajo a fin de que pueda abrir el cuestionario de Efectividad Departamental contratado por '.$nombre_empresa.'.  Es imprescindible que responda con absoluta sinceridad y que sus respuestas se basen exclusivamente en su propia experiencia. Encontrará más instrucciones una vez que haya ingresado su usuario y contraseña. Este vínculo quedará desactivado una vez que haya respondiedo el cuestionario.</p>';

							$msj .= "<p>Recuerde GRABAR al terminar el cuestionario.  Gracias anticipadas por su dedicación.</p>";

							$msj .= "<p><b>Sitio Web: </b><a href='$link' target='_blanck'>$link</a></p>";

							$msj .= "<p><b>Usuario: </b>$user</p>";

							$msj .= "<p><b>Password: </b>$pass</p>";
							
							if(!Util::sendMail($value['email'],$subject,$msj))
							{
								echo "Error al enviar correo a ".$value['id_personal'].PHP_EOL;
							}
							
	 					}

	 				}

	 			}



				$dispatch = new EmpresaController('Empresa','empresa','home',0);

				$dispatch->home();

			}else{

				$sonda = new Efectividad_departamental();

				if(isset($_POST['guardar'])){
					if(isset($_POST['custom_email']))
	 					$custom_email=1;
	 				else
	 					$custom_email=0;

	 				if(isset($_POST['foda']))
	 					$foda=1;
	 				else
	 					$foda=0;

	 				$criterios_escala = array();

	 				foreach ($_POST['escala_etiqueta'] as $key => $value) {
	 					$criterios_escala[$key]['escala_etiqueta'] = utf8_decode($_POST['escala_etiqueta'][$key]);
	 					$criterios_escala[$key]['escala_valor'] = $_POST['escala_valor'][$key];
	 				}

	 				
	 				$criterios_barras_colores = $_POST['barras_color'];
	 				$criterios_rango_barras = array();

	 				if(sizeof($_POST['barras_desde']) != sizeof($_POST['barras_hasta']))
	 				{
	 					die('Los criterios de las barras y sus rangos no están a la par !!!');
	 				}

	 				foreach ($_POST['barras_desde'] as $key => $value) {
	 					$criterios_rango_barras[$key]['desde'] = $_POST['barras_desde'][$key];
	 					$criterios_rango_barras[$key]['hasta'] = $_POST['barras_hasta'][$key];
	 				}


	 				$sonda->setId_empresa($_SESSION['Empresa']['id']);
	 				$sonda->setTipoSonda('Efectividad_departamental');
					$sonda->setSegmentacion($_POST['segmentacion']);
					$sonda->setFecha($_POST['fecha']);
					$sonda->setEmail($_POST['email']);
					$sonda->setTemas($_POST['temas']);
					$sonda->setPeriodo(date('Y-m-d'));
					$sonda->setCustom_email($custom_email);
					$sonda->setFoda($foda);
					$sonda->setNuevosCriterios($_POST['nuevos_criterios']);
					$sonda->setCriteriosEscala($criterios_escala);
					$sonda->setCriteriosBarrasColores($criterios_barras_colores);
					$sonda->setCriteriosRangoBarras($criterios_rango_barras);
					$sonda->insert();
					$this->set('segmentacion',$_POST['segmentacion']);
					$this->set('temas',$_POST['temas']);
					$this->set('sonda','');

					if(isset($_POST['sonda']) && $_POST['sonda'] != ''){
						$this->set('sonda',$_POST['sonda']);
						$sonda->select_($_SESSION['Empresa']['id'], $_POST['sonda']);
						$temas_sonda = $sonda->getTemas();
						$this->set('temas_sonda',$temas_sonda);
					}
				}else{

					$this->_template = new Template('Efectividad_departamental','definir');
					$this->definir();

					$arrSondas = array('0' => $_POST['sonda']);
					$this->set('arrSondas', $arrSondas);
				}
			}

		}

	}



	function tema(){

		$this->haySession();

	}



	function pregunta($id){

		$this->haySession();

		$this->set('id', $id);

	}



	function resultados($id_s){

		$this->haySession();

		if($_SESSION['Empresa']['id']==439){

			// $this->set('custom_info',"<b>ATENCIÓN - </b>Se están revisando los resultados de esta evaluación.");

		}

		$areas=$edad=$antiguedad=$localidad=$edad=$tcont=$educacion=$sexo=$temas=$filtros="";

		if(isset($_POST['filtro'])){

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

				$areas = " AND `departamento` IN (".implode(",", $ea_ids).")";

				$filtros.=implode(", ", array_map(array($this,'get_area'),$ea_ids));

				$filtros.=".<br>";

			}

			if(isset($_POST['edad'])){

				$filtros.="Edad: ";

				$edad = " AND `edad` IN (".implode(",", $_POST['edad']).")";

				$filtros.=implode(", ", array_map(array($this,'get_edad'),$_POST['edad']));

				$filtros.=".<br>";

			}

			if(isset($_POST['antiguedad'])){

				$filtros.="Antigüedad: ";

				$antiguedad = " AND `antiguedad` IN (".implode(",", $_POST['antiguedad']).")";

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

				$localidad = " AND `localidad` IN (".implode(",", $el_ids).")";

				$filtros.=implode(", ", array_map(array($this,'get_localidad'),$el_ids));

				$filtros.=".<br>";

			}

			if(isset($_POST['norg'])){

				$filtros.="Nivel organizacional: ";

				$edad = " AND `norg` IN (".implode(",", $_POST['norg']).")";

				$filtros.=implode(", ", array_map(array($this,'get_norg'),$_POST['norg']));

				$filtros.=".<br>";

			}

			if(isset($_POST['tcont'])){

				$filtros.="Tipo de contrato: ";

				$tcont = " AND `tcont` IN (".implode(",", $_POST['tcont']).")";

				$filtros.=implode(", ", array_map(array($this,'get_tcont'),$_POST['tcont']));

				$filtros.=".<br>";

			}

			if(isset($_POST['educacion'])){

				$filtros.="Educacion: ";

				$educacion = " AND `educacion` IN (".implode(",", $_POST['educacion']).")";

				$filtros.=implode(", ", array_map(array($this,'get_educacion'),$_POST['educacion']));

				$filtros.=".<br>";

			}

			if(isset($_POST['sexo'])){

				$filtros.="Sexo: ";

				$sexo = " AND `sexo` IN (".implode(",", $_POST['sexo']).")";

				$filtros.=implode(", ", array_map(array($this,'get_sexo'),$_POST['sexo']));

				$filtros.=".<br>";

			}

			if(isset($_POST['temas'])){

				$filtros.="Temas: ";

				$temas = implode(",", $_POST['temas']);

				$filtros.=implode(", ", array_map(array($this,'get_temas'),$_POST['temas']));

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

				'sexo' => $sexo

				);

			$filtros = ($filtros=="") ? "Todos" : $filtros;

			$_SESSION['args']=$args;

			$_SESSION['filtros']=$filtros;

			$_SESSION['temas']=$temas;

			$this->set('args',$args);

			$this->set('filtros',$filtros);

			$this->set('temas',$temas);

			if(isset($_POST['temas'])){
				$this->set('arrTemas',$_POST['temas']);
				$_SESSION['arrTemas'] = $_POST['temas'];
			}
			else{
				$this->set('arrTemas','');
				$_SESSION['arrTemas'] = '';
			}

			$_POST=null;

		}else{

			if(isset($_SESSION['args']))

				$this->set('args',$_SESSION['args']);

			else{

				$this->set('args',"");

				$_SESSION['args']="";

			}

			if(isset($_SESSION['filtros']))

				$this->set('filtros',$_SESSION['filtros']);

			else

				$this->set('filtros',"Todos");

			if(isset($_SESSION['arrTemas']))

				$this->set('arrTemas',$_SESSION['arrTemas']);

			else{

				$this->set('arrTemas',"");

				$_SESSION['arrTemas']="";

			}

		}



		$this->set('id_s', $id_s);

	}



	function resultados_pregunta($id_s,$id_tema){

		$this->haySession();

		$this->set('id_tema',$id_tema);

		$this->set('id_s',$id_s);

	}



	function top($id_s='', $ord, $anio=''){

		$this->haySession();

		$this->set('order',$ord);



		$z = new Sonda_user();

		$args=$_SESSION['args'];

		if(isset($_SESSION['sondas']))

			$sondas = $_SESSION['sondas'];

		

		if(!$anio)

			$ids = $z->get_id_x_empresa($id_s, $_SESSION['Empresa']['id'],$args);

		else

			$ids = $z->get_id_compara($_SESSION['Empresa']['id'], $sondas, $anio, '', $args);

		

		$x = new Sonda_respuesta();

		$top=$x->get_top($ids,10,$ord);

		$this->set('preguntas',$top);	

	}



	function top_seg($id_s, $campo, $valor, $ord){

		$this->haySession();

		$this->set('order',$ord);



		$z = new Sonda_user();

		$ids = $z->get_id_x_segmentacion($_SESSION['Empresa']['id'], $id_s, '', $campo, $valor);

		$x = new Sonda_respuesta();

		$top=$x->get_top($ids,10,$ord);

		$this->set('preguntas',$top);

	}



	function historicos(){

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



	function comparar_resultados(){

		$this->haySession();

		$areas=$edad=$antiguedad=$localidad=$edad=$tcont=$educacion=$sexo=$temaSonda=$temas=$filtros="";print_r($_SESSION);

		if(isset($_POST['filtro'])){

			$_SESSION['args']=null;

			$_SESSION['filtros']=null;

			$arrSondas = array();



			$sonda = new Efectividad_departamental();

			$sonda->select_compara($_SESSION['USER-AD']['id_empresa']);

			$sondas = $sonda->getId();

			

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

				$areas = " AND `departamento` IN (".implode(",", $ea_ids).")";

				$filtros.=implode(", ", array_map(array($this,'get_area'),$ea_ids));

				$filtros.=".<br>";

			}

			if(isset($_POST['edad'])){

				$filtros.="Edad: ";

				$edad = " AND `edad` IN (".implode(",", $_POST['edad']).")";

				$filtros.=implode(", ", array_map(array($this,'get_edad'),$_POST['edad']));

				$filtros.=".<br>";

			}

			if(isset($_POST['antiguedad'])){

				$filtros.="Antigüedad: ";

				$antiguedad = " AND `antiguedad` IN (".implode(",", $_POST['antiguedad']).")";

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

				$localidad = " AND `localidad` IN (".implode(",", $el_ids).")";

				$filtros.=implode(", ", array_map(array($this,'get_localidad'),$el_ids));

				$filtros.=".<br>";

			}

			if(isset($_POST['norg'])){

				$filtros.="Nivel organizacional: ";

				$edad = " AND `norg` IN (".implode(",", $_POST['norg']).")";

				$filtros.=implode(", ", array_map(array($this,'get_norg'),$_POST['norg']));

				$filtros.=".<br>";

			}

			if(isset($_POST['tcont'])){

				$filtros.="Tipo de contrato: ";

				$tcont = " AND `tcont` IN (".implode(",", $_POST['tcont']).")";

				$filtros.=implode(", ", array_map(array($this,'get_tcont'),$_POST['tcont']));

				$filtros.=".<br>";

			}

			if(isset($_POST['educacion'])){

				$filtros.="Educacion: ";

				$educacion = " AND `educacion` IN (".implode(",", $_POST['educacion']).")";

				$filtros.=implode(", ", array_map(array($this,'get_educacion'),$_POST['educacion']));

				$filtros.=".<br>";

			}

			if(isset($_POST['sexo'])){

				$filtros.="Sexo: ";

				$sexo = " AND `sexo` IN (".implode(",", $_POST['sexo']).")";

				$filtros.=implode(", ", array_map(array($this,'get_sexo'),$_POST['sexo']));

				$filtros.=".<br>";

			}

			if(isset($_POST['sondas'])){

				$filtros.="Sondas: ";

				$sondas = implode(",", $_POST['sondas']);

				$filtros.=implode(", ", array_map(array($this,'get_sondas'),$_POST['sondas']));

				$filtros.=".<br>";

			}

			if(isset($_POST['TemaSonda'])){

				$temaSonda = $_POST['TemaSonda'];

			}

			if(isset($_POST['temas'])){

				$filtros.="Temas: ";

				$temas = implode(",", $_POST['temas']);

				$filtros.=implode(", ", array_map(array($this,'get_temas'),$_POST['temas']));

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

				'sexo' => $sexo

				);

			$filtros = ($filtros=="") ? "Todos" : $filtros;

			$_SESSION['args']=$args;

			$_SESSION['sondas']=$sondas;

			$_SESSION['filtros']=$filtros;

			$_SESSION['temaSonda']=$temaSonda;

			$_SESSION['temas']=$temas;

			$this->set('args',$args);

			$this->set('filtros',$filtros);

			$this->set('sondas',$sondas);

			$this->set('temas',$temas);


			if(isset($_POST['sondas'])){
				$this->set('arrSondas',$_POST['sondas']);
				$_SESSION['arrSondas'] = $_POST['sondas'];
			}

			else{
				$this->set('arrSondas','');
				$_SESSION['arrSondas'] = '';
			}


			if(isset($_POST['TemaSonda']))

				$this->set('temaSonda',$_POST['TemaSonda']);

			else

				$this->set('temaSonda','');

			if(isset($_POST['temas'])){
				$this->set('arrTemas',$_POST['temas']);
				$_SESSION['arrTemas'] = $_POST['temas'];
			}
			else{
				$this->set('arrTemas','');
				$_SESSION['arrTemas'] = '';
			}

			$_POST=null;

		}else{

			if(isset($_SESSION['arrTemas']))

				$this->set('arrTemas',$_SESSION['arrTemas']);

			else{

				$this->set('arrTemas',"");

				$_SESSION['arrTemas']="";

			}

			if (isset($_SESSION['temaSonda'])) {

				$this->set('temaSonda',$_SESSION['temaSonda']);

			}else{

				$this->set('temaSonda',"");

				$_SESSION['temaSonda'] = '';

			}

			if (isset($_SESSION['filtros'])) {

				$this->set('filtros',$_SESSION['filtros']);

			}else{

				$this->set('filtros',"Todos");

				$_SESSION['filtros'] = 'Todos';

			}



			if (isset($_SESSION['args'])) {

				$this->set('args',$_SESSION['args']);

			}else{

				$this->set('args',"");

				$_SESSION['args'] = '';

			}



			if (isset($_SESSION['sondas'])) {

				$this->set('sondas',$_SESSION['sondas']);

			}else{

				$sondas = '';

				$this->set('sondas',$sondas);

				$_SESSION['sondas'] = $sondas;

			}



			if (isset($_SESSION['arrSondas'])) 

				$this->set('arrSondas',$_SESSION['arrSondas']);

			else

				$this->set('arrSondas','');

		}

	}



	function compara_resultados_pregunta($id_tema){

		$this->haySession();



		if(isset($_SESSION['args']))

			$args=$_SESSION['args'];

		else

			$args="";



		if(isset($_SESSION['sondas']))

			$sondas=$_SESSION['sondas'];

		else

			$sondas="";



		$filtros = (isset($_SESSION['filtros'])) ? $_SESSION['filtros'] : "Todos" ;



		$this->set('args',$args);

		$this->set('sondas',$sondas);

		$this->set('filtros',$filtros);

		$this->set('id_tema',$id_tema);

	}



	function segmentacion()

	{

		$this->haySession();



		if(isset($_POST['filtro'])){

			$areas=$edad=$antiguedad=$localidad=$edad=$tcont=$educacion=$sexo=$filtros="";

			$arrCompara=null;

			//

			$_SESSION['args']=null;

			$_SESSION['filtros']=null;

			$_SESSION['arrCompara']=null;



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

				$edad = " AND `edad` IN (".implode(",", $_POST['edad']).")";

				$filtros.=implode(", ", array_map(array($this,'get_edad'),$_POST['edad']));

				$filtros.=".<br>";

				$arrCompara['edad'] = $_POST['edad'];

			}

			if(isset($_POST['antiguedad'])){

				$filtros.="Antigüedad: ";

				$antiguedad = " AND `antiguedad` IN (".implode(",", $_POST['antiguedad']).")";

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

				$localidad = " AND `localidad` IN (".implode(",", $el_ids).")";

				$filtros.=implode(", ", array_map(array($this,'get_localidad'),$el_ids));

				$filtros.=".<br>";

			}

			if(isset($_POST['norg'])){

				$filtros.="Nivel organizacional: ";

				$edad = " AND `norg` IN (".implode(",", $_POST['norg']).")";

				$filtros.=implode(", ", array_map(array($this,'get_norg'),$_POST['norg']));

				$filtros.=".<br>";

				$arrCompara['norg'] = $_POST['norg'];

			}

			if(isset($_POST['tcont'])){

				$filtros.="Tipo de contrato: ";

				$tcont = " AND `tcont` IN (".implode(",", $_POST['tcont']).")";

				$filtros.=implode(", ", array_map(array($this,'get_tcont'),$_POST['tcont']));

				$filtros.=".<br>";

				$arrCompara['tcont'] = $_POST['tcont'];

			}

			if(isset($_POST['educacion'])){

				$filtros.="Educacion: ";

				$educacion = " AND `educacion` IN (".implode(",", $_POST['educacion']).")";

				$filtros.=implode(", ", array_map(array($this,'get_educacion'),$_POST['educacion']));

				$filtros.=".<br>";

				$arrCompara['educacion'] = $_POST['educacion'];

			}

			if(isset($_POST['sexo'])){

				$filtros.="Sexo: ";

				$sexo = " AND `sexo` IN (".implode(",", $_POST['sexo']).")";

				$filtros.=implode(", ", array_map(array($this,'get_sexo'),$_POST['sexo']));

				$filtros.=".<br>";

				$arrCompara['sexo'] = $_POST['sexo'];

			}

			if(isset($_POST['sondas'])){

				$filtros.="Sonda: ";

				$sondas = $_POST['sondas'];

				$filtros.= $this->get_sondas($_POST['sondas']);

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

				'sexo' => $sexo

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

						}

						//

						$arrCompara[$i]['nombre'] = $nombre;

						$i++;

					}

				}

			}

			//

			$filtros = ($filtros=="") ? "Todos" : $filtros;

			$_SESSION['args']=$args;

			$_SESSION['sondas']=$sondas;

			$_SESSION['filtros']=$filtros;

			$_SESSION['arrCompara']=$arrCompara;



			$this->set('args',$args);

			$this->set('filtros',$filtros);

			$this->set('sondas',$sondas);

			$this->set('arrCompara',$arrCompara);

			$_POST=null;

		}else{

			if (isset($_SESSION['filtros'])) {

				$this->set('filtros',$_SESSION['filtros']);

			}else{

				$this->set('filtros',"Todos");

				$_SESSION['filtros'] = 'Todos';

			}



			if (isset($_SESSION['args'])) {

				$this->set('args',$_SESSION['args']);

			}else{

				$this->set('args',"");

				$_SESSION['args'] = '';

			}



			if (isset($_SESSION['sondas'])) {

				$this->set('sondas',$_SESSION['sondas']);

			}else{

				$sondas = '';

				$this->set('sondas',$sondas);

				$_SESSION['sondas'] = $sondas;

			}



			if (isset($_SESSION['arrCompara'])) {

				$this->set('arrCompara',$_SESSION['arrCompara']);

			}else{

				$arrCompara = '';

				$this->set('arrCompara',$arrCompara);

				$_SESSION['arrCompara'] = $arrCompara;

			}

		}

	}



	function segmentacion_pregunta($id_tema){

		$this->haySession();



		if(isset($_SESSION['args']))

			$args=$_SESSION['args'];

		else

			$args="";



		if(isset($_SESSION['sondas']))

			$sondas=$_SESSION['sondas'];

		else

			$sondas="";



		if(isset($_SESSION['arrCompara']))

			$arrCompara=$_SESSION['arrCompara'];

		else

			$arrCompara="";



		$filtros = (isset($_SESSION['filtros'])) ? $_SESSION['filtros'] : "Todos" ;



		$this->set('args',$args);

		$this->set('sondas',$sondas);

		$this->set('arrCompara',$arrCompara);

		$this->set('filtros',$filtros);

		$this->set('id_tema',$id_tema);

	}



	/** 20161227 CTP 

     *	Autorizacion de sesion páginas sonda actual y sondas anteriores.

    */

    //Iniciando página (sonda actual), eliminamos el contenido de args y filtros.

    function promedios_bajos(){

		$this->haySession();

		if($_SESSION['Empresa']['id']==439){

			// $this->set('custom_info',"<b>ATENCIÓN - </b>Se están revisando los resultados de esta evaluación.");

		}

		if(isset($_SESSION['args']))

				$this->set('args',""); //$_SESSION['args']);

		else{

			$this->set('args',"");

			$_SESSION['args']="";

		}

		if(isset($_SESSION['filtros']))

			$this->set('filtros',""); //$_SESSION['filtros']);

		else

			$this->set('filtros',"");

	}



	//Resultados de cada pregunta.

	function resultados_pregunta_pb($pagina,$id_s, $id_tema){

		$this->haySession();

		$this->set('pagina',$pagina);

		$this->set('id_s',$id_s);

		$this->set('id_tema',$id_tema);

	}



	//Resultados de mejores, peores preguntas.

	function top_pb($ord){

		$this->haySession();

		$this->set('order',$ord);



		$z = new Sonda_user();

		$args=$_SESSION['args'];

		$ids = $z->get_id_x_empresa($_SESSION['Empresa']['id'],$args);

		$x = new Sonda_respuesta();

		$ids = implode(",", $_SESSION["eval_pb"]);

		$top=$x->get_top($ids,10,$ord);

		$this->set('preguntas',$top);	

	}



	function otros_promedios_bajos(){

		$this->haySession();



		if(isset($_POST['filtro'])){

			$areas=$edad=$antiguedad=$localidad=$edad=$tcont=$educacion=$sexo=$filtros=$preguntas=$args="";

			$arrDatos = array();

			//

			$_SESSION['args']=null;

			$_SESSION['filtros']=null;

			$_SESSION['sondas']=null;

			//

			if(isset($_POST['sondas'])){

				$sondas = $_POST['sondas'];

				$filtros = "Sonda: ";

				$filtros.= $this->get_sondas($_POST['sondas']);

				$filtros.=".<br>";

			}

			// Llamamos los metodos para traer el grupo afectado de la ultima sonda

			$rendimiento = new Rendimiento();

			$z = new Sonda_user();

			$x = new Sonda_tema();

			//Cargamos datos principales (test del año en curso por defecto).

			$rendimiento->select($_SESSION['Empresa']['id']);

			$temas = $rendimiento->getTemas();

			//Obtenemos los usuarios por empresa, según el test.

			$ids = $z->get_id_x_empresa($rendimiento->getId(),$_SESSION['Empresa']['id'],'');

			//

			$preguntas = '';

			foreach ($temas as $key => $value) {

				$preguntas = implode(",", $temas[$key]);

				$rendimiento->calculo_prom_bajos($ids,$key,$preguntas);

			}



			$rendimiento->promedios_bajos($_SESSION['Empresa']['id']);



			if (is_array($rendimiento->arrDatos)) {

				foreach ($rendimiento->arrDatos as $key => $arrValores) {

					$unserialize = unserialize($key);

					array_push($arrDatos, $unserialize);

					/*

					foreach ($unserialize as $tipo => $valor) {

						if ($tipo != 'c_e') {

							$filtro["tipo"] = $tipo;

							$filtro["valor"] = $valor;

							$rendimiento->filtros_criterios($filtro);

							$rendimiento->get_criterios();

						}

					}*/

				}

			}

			//$args = $rendimiento->getArgs();

			//$filtros .= $rendimiento->getCriterios();

			//

			$filtros = ($filtros=="") ? "Todos" : $filtros;

			//$_SESSION['args']=$args;

			$_SESSION['sondas']=$sondas;

			$_SESSION['filtros']=$filtros;

			$_SESSION['rendimiento']=serialize($rendimiento);

			$_SESSION['arrDatos']=$arrDatos;



			//$this->set('args',$args);

			$this->set('filtros',$filtros);

			$this->set('sondas',$sondas);

			$this->set('rendimiento',serialize($rendimiento));

			$this->set('arrDatos',$arrDatos);

		}else{

			if (isset($_SESSION['filtros'])) {

				$this->set('filtros',$_SESSION['filtros']);

			}else{

				$this->set('filtros',"Todos");

				$_SESSION['filtros'] = 'Todos';

			}



			if (isset($_SESSION['arrDatos'])) {

				$this->set('arrDatos',$_SESSION['arrDatos']);

			}else{

				$this->set('arrDatos',"");

				$_SESSION['arrDatos'] = '';

			}



			if (isset($_SESSION['sondas'])) {

				$this->set('sondas',$_SESSION['sondas']);

			}else{

				$sondas = '';

				$this->set('sondas',$sondas);

				$_SESSION['sondas'] = $sondas;

			}



			if (isset($_SESSION['rendimiento'])) {

				$this->set('rendimiento',$_SESSION['rendimiento']);

			}else{

				$rendimiento = '';

				$this->set('rendimiento',$rendimiento);

				$_SESSION['rendimiento'] = $rendimiento;

			}

		}

	}



	function grupos_criticos(){

		$this->haySession();



		$arrSondas = array();



		$rendimiento = new Rendimiento();

		$sql =  "SELECT MAX(ID) as id FROM sonda WHERE id_empresa = ".$_SESSION['Empresa']['id']." AND tipo_sonda = 'Efectividad_departamental' ";

		$row =  $rendimiento->query_($sql,1);

		if($row){

			array_push($arrSondas, $row['id']);

		}



		if(isset($_POST['filtro'])){			

			if(isset($_POST['sondas'])){

				foreach ($_POST['sondas'] as $key => $value) {

					array_push($arrSondas, $value);

				}

			}

		}



		$this->set('arrSondas',$arrSondas);

	}

	function comentarios($id_s){

		$this->haySession();

		$z = new Sonda_user();

		if(isset($_SESSION['args']))
			$args=$_SESSION['args'];
		else
			$args = null;

		$ids = $z->get_id_x_sonda($args, $_SESSION['Empresa']['id'], $id_s);

		$this->set('ids', $ids);

		$this->set('id_s', $id_s);
	}
	
	function enviar_recordatorio(){

		$this->haySession();

		$sonda = new Efectividad_departamental();
		$sonda_user = new Sonda_user();

		$sonda->setId_empresa($_SESSION['Empresa']['id']);
		$sonda->select__();

		$sonda_user->setId_empresa($_SESSION['Empresa']['id']);
		$user_contestados = $sonda_user->getEvaluadosCompletadosEncuenta($sonda->getId());

		$sql =	'SELECT lp.id AS id_personal, lp.nombre as nombre_p, "" as resuelto ';
		$sql .=	'FROM `listado_personal_op` AS lp ';
		$sql .=	'WHERE lp.empresa = '.$_SESSION['Empresa']['id'].' ';
		$sql .=	'AND lp.activo = 1 ';

		$result = $sonda->query_($sql);

		$count_personal = 0;
		$count_completados = count($user_contestados);
		$porc_cumplimiento = 0;

		foreach ($result as $a => $b) {
			if (in_array($b['id_personal'], $user_contestados)){
				$b['resuelto'] = 'Si';
			}
			else{
				$b['resuelto'] = 'No';
			}
			$personal[$a] = $b;
			$count_personal++;
		}

		$nombre_empresa =  strtoupper($_SESSION["Empresa"]["nombre"]);
		$link = BASEURL;

		$porc_cumplimiento = round((($count_completados/$count_personal) * 100));
		
		if(isset($_POST['button'])){
			foreach ($_POST['id'] as $a => $id) {
				
				if ($a <= 50) {
					$result = $sonda_user->credencialesSondaTemporal($id,$sonda->getId(),$sonda->getTipoSonda());

					$user = $result['user_name'];
					$pass = $result['token'];
					$nombre = $this->Efectividad_departamental->get_pname($id);
					$email = $this->Efectividad_departamental->get_emailById($id);
					$subject= "Recordatorio de Evaluación ";
					$message = '<p>Estimado/a, '.strtoupper($sonda->get_pname($id)).'</p>';
					$message .= '<p>Por favor use el vínculo, Usuario y Contraseña que se le indican más abajo a fin de que pueda abrir el cuestionario de Diagnóstico de Efectividad Organizacional contratado por '.$nombre_empresa.'.  Es imprescindible que responda con absoluta sinceridad y que sus respuestas se basen exclusivamente en su propia experiencia. Encontrará más instrucciones una vez que haya ingresado su usuario y contraseña. Este vínculo quedará desactivado una vez que haya respondiedo el cuestionario.</p>';
					$message .= "<p>Recuerde GRABAR al terminar el cuestionario.  Gracias anticipadas por su dedicación.</p>";
					$message .= "<p><b>Sitio Web: </b><a href='$link' target='_blanck'>$link</a></p>";
					$message .= "<p><b>Usuario: </b>$user</p>";
					$message .= "<p><b>Password: </b>$pass</p>";
					
					if(Util::sendMail($email,$subject,$message)){
						$this->set('alert_email',"Se envió un recordatorio a quienes no han terminado la evaluación");
					}else{
						$this->set('alert_email',"Ocurrió un error, intentelo nuevamente. Si el problema persiste comuniquese con soporte@saegth.com");
					}
				}
			}
		}

		$this->set('personal',$personal);
		$this->set('porc_cumplimiento',$porc_cumplimiento);
		$_POST=null;

	}
	
	
	function enviar_email_encuesta(){

		$this->haySession();

		$sonda = new Efectividad_departamental();
		$sonda_user = new Sonda_user();

		$sonda->setId_empresa($_SESSION['Empresa']['id']);
		$sonda->select__();

		$sql =	'SELECT lp.id AS id_personal, lp.nombre as nombre_p, stu.email_enviado AS e_env, CASE stu.email_enviado WHEN 1 THEN "SI" ELSE "NO" END AS "email_enviado" ';
		$sql .=	'FROM sonda_test_users stu ';
		$sql .=	'LEFT JOIN users u ON(u.id = stu.id_user) ';
		$sql .=	'LEFT JOIN listado_personal_op lp ON (lp.id = u.id_personal) ';
		$sql .=	'WHERE stu.id_test = '.$sonda->getId().' ';
		$sql .=	'AND lp.activo = 1 ';
		$sql .=	'AND lp.empresa = '.$_SESSION['Empresa']['id'];

		$personal = $sonda->query_($sql);
		$this->set('personal',$personal);

		$subject = 'Encuesta Individual de Efectividad Organizacional';
		$link = BASEURL;
		$nombre_empresa =  strtoupper($_SESSION["Empresa"]["nombre"]);
		$cont = 1;

		if(isset($_POST['button'])){
			foreach ($_POST['id'] as $a => $id) {

				if ($_POST['email_enviado'][$a] == 0) {
					
					if ($cont <= 50) {
					
						$sql =	"SELECT u.user_name, u.token, stu.id_user ";
						$sql .=	"FROM users u ";
						$sql .=	"LEFT JOIN sonda_test_users stu ON(u.id = stu.id_user) ";
						$sql .=	"WHERE stu.id_test = ".$sonda->getId().' ';
						$sql .=	"AND u.user_rol = 12 ";
						$sql .=	"AND u.id_personal = ".$id;

						$result = $sonda->query_($sql,1);
						
						if ($result) {

							$user = $result['user_name'];
							$pass = $result['token'];

							if ($user != "" && $pass != "") {
								
								$msj = '<p>Estimado/a, '.strtoupper($sonda->get_pname($id)).'</p>';

								$msj .= '<p>Por favor use el vínculo, Usuario y Contraseña que se le indican más abajo a fin de que pueda abrir el cuestionario de Diagnóstico de Efectividad Organizacional contratado por '.$nombre_empresa.'.  Es imprescindible que responda con absoluta sinceridad y que sus respuestas se basen exclusivamente en su propia experiencia. Encontrará más instrucciones una vez que haya ingresado su usuario y contraseña. Este vínculo quedará desactivado una vez que haya respondiedo el cuestionario.</p>';

								$msj .= "<p>Recuerde GRABAR al terminar el cuestionario.  Gracias anticipadas por su dedicación.</p>";

								$msj .= "<p><b>Sitio Web: </b><a href='$link' target='_blanck'>$link</a></p>";

								$msj .= "<p><b>Usuario: </b>$user</p>";

								$msj .= "<p><b>Password: </b>$pass</p>";

								$msj .= "En caso de necesidad de asistencia con esta encuesta y/o reportar algún problema o duda, comuníquese al +593 9 99 11 8694";
								
								if(!Util::sendMail($sonda->get_emailById($id),$subject,$msj))
								{
									die( "Error al enviar correo a ".$sonda->get_pname($id).PHP_EOL);
								}
								else
								{
									$sqlU = "UPDATE sonda_test_users ";
									$sqlU .=	"SET email_enviado = 1 ";
									$sqlU .= "WHERE id_user = ".$result['id_user']." ";
									$sqlU .= "AND id_test = ".$sonda->getId();
									$result = $sonda->query_($sqlU);

									$cont++;
								}
								
								//die($user." - ".$pass." - ".$meth->get_emailById($id)." - ".$meth->get_pname($id));
							}

						}

					}

				}

			}
		}

	}

	//*****************************************************



	//

	function get_edad($cod){

		switch ($cod) {

			case '0':

			return "Menor a 20 años";

			break;

			case '1':

			return "De 21 a 25 años";

			break;

			case '2':

			return "De 26 a 30 años";

			break;

			case '3':

			return "De 31 a 40 años";

			break;

			case '4':

			return "De 41 a 50 años";

			break;

			case '5':

			return "Mas de 50 años";

			break;

		}

	}

	

	function get_antiguedad($cod){

		switch ($cod) {

			case '7':

			return "De 0 a 3 meses";

			break;

			case '1':

			return "De 3 meses a 2 años";

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

			case '6':

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

			return "Universitaria incompleta";

			break;

			case '5':

			return "Universitaria completa";

			break;

			case '6':

			return "Postgrado";

			break;

		}

	}



	function get_area(&$cod){

		$res = $this->Efectividad_departamental->query('SELECT `nombre` FROM `empresa_area` WHERE `id`="'.$cod.'"',1);

		echo mysqli_error($this->link);

		$res = @reset($res);

		$res = @reset($res);

		return $this->Efectividad_departamental->htmlprnt($res);

	}



	function get_localidad($cod){

		$res = $this->Efectividad_departamental->query('SELECT `nombre` FROM `empresa_local` WHERE `id`="'.$cod.'"',1);

		echo mysqli_error($this->link);

		$res = @reset($res);

		$res = @reset($res);

		return $this->Efectividad_departamental->htmlprnt($res);

	}



	function get_cargo($cod){

		$res = $this->Efectividad_departamental->query('SELECT `nombre` FROM `empresa_cargo` WHERE `id`="'.$cod.'"',1);

		echo mysqli_error($this->link);

		$res = @reset($res);

		$res = @reset($res);

		return $this->Efectividad_departamental->htmlprnt($res);

	}



	function get_norg($cod){

		$res = $this->Efectividad_departamental->query('SELECT `nombre` FROM `empresa_norg` WHERE `id`="'.$cod.'"',1);

		echo mysqli_error($this->link);

		$res = @reset($res);

		$res = @reset($res);

		return $this->Efectividad_departamental->htmlprnt($res);

	}



	function get_tcont($cod){

		$res = $this->Efectividad_departamental->query('SELECT `nombre` FROM `empresa_tcont` WHERE `id`="'.$cod.'"',1);

		echo mysqli_error($this->link);

		$res = @reset($res);

		$res = @reset($res);

		return $this->Efectividad_departamental->htmlprnt($res);

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



	function getFechas($id_e){

		$sql = 'SELECT id, fecha FROM sonda WHERE id_empresa = '.$id_e.' and fecha != "" AND tipo_sonda = "Efectividad_departamental" order by id desc';

		$res = $this->Efectividad_departamental->query_($sql);

		echo mysqli_error($this->link);

		return $res;

	}



	function get_sondas($id_s){

		$sql = 'SELECT fecha FROM sonda WHERE id_empresa = '.$_SESSION['USER-AD']['id_empresa'].' and id = '.$id_s.' AND tipo_sonda = "Efectividad_departamental"';

		$res = $this->Efectividad_departamental->query_($sql);

		echo mysqli_error($this->link);

		$res = @reset($res);

		$res = @reset($res);

		$fecha = $res;

		$sonda = new Efectividad_departamental();

		$anio = substr($fecha, 0, 4);

		$mes = substr($fecha, 5, 2);

		$mes = $sonda->parseMonth($mes);

		$dia = substr($fecha, 8, 2);

		$new_fecha = $dia.'-'.$mes.'-'.$anio;

		return $new_fecha;

	}

	function get_temas($cod){

		$res = $this->Efectividad_departamental->query('SELECT `tema` FROM `sonda_temas` WHERE `id`="'.$cod.'"',1);

		echo mysqli_error($this->link);

		$res = @reset($res);

		$res = @reset($res);

		return ucfirst($this->Efectividad_departamental->htmlprnt($res));

	}





	function haySession(){

		Util::sessionStart();

		if (!isset($_SESSION['USER-AD'])){

			$this->logout();

			exit;	

		}

		return true;

	}





	function logout(){

		Util::sessionLogout();

		$this->Efectividad_departamental->disconnect();

		$this->_template = new Template('Void','render');

		$dispatch = new InicioController('Inicio','inicio','principal',0);

		$dispatch->principal(true);

	}

}