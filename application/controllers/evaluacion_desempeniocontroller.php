<?php



class Evaluacion_desempenioController extends Controller {

	protected $link;

	

	function __construct($model, $controller, $action, $type = 0,$full=false,$render=false) {



		parent::__construct($model, $controller, $action, $type,$full,$render);



		$this->link = $this->Evaluacion_desempenio->getDBHandle();

	}

	function competencias(){
		$this->haySession();
	}

	function cuestionario(){
		$this->haySession();

		if(array_filter($_POST)){

			if(isset($_POST['guardar'])){
				
				$test_data = array();
				foreach ($_POST['preguntas'] as $key => $value) {
					$data = explode(",", $value);
					$test_data[$data[0]][$data[1]][] = $data[2];
				}

				$cuestionario = new Evaluacion_Desempenio_Cuestionario();
				$cuestionario->setDescripcion($_POST['descripcion']);
				$cuestionario->setTemas($test_data);
				$cuestionario->setIdEmpresa($_SESSION['Empresa']['id']);
				$cuestionario->setEdad($_POST['edad']);
				$cuestionario->setAntiguedad($_POST['antiguedad']);
				$cuestionario->setLocalidad($_POST['localidad']);
				$cuestionario->setDepartamento($_POST['departamento']);
				$cuestionario->setNorg($_POST['norg']);
				$cuestionario->setTcont($_POST['tcont']);
				$cuestionario->setEducacion($_POST['educacion']);
				$cuestionario->setSexo($_POST['sexo']);
				$cuestionario->insert();
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

	function seleccion_evaluadores(){
		Util::sessionStart();
		$this->set('backlink',false);
		$id_e = $_SESSION['Empresa']['id'];
		$id=$_SESSION['USER-AD']['id_personal'];
		$mr = new Evaluacion_desempenio_seleccion_evaladores(); 
		$sel = $mr->select_all_nivel($id,1);
		if(!$sel){
			$evaluadores = array();		
			$this->set('subtitle','Seleccione a los evaluadores');
			$arr = Personal_empresa::withID($id);
			if(isset($arr->pid_cg)){
				$results = Personal_empresa::get_superior($arr->pid_sup);
				if($results)
					$evaluadores['Superior,1'] = $results;
				else
					$evaluadores['Superior,1'] = "empty";
			}
			$results = Personal_empresa::get_pares($arr->pid_sup,$arr->id_personal);
			if($results)
				$evaluadores['Pares,2'] = $results;
			else
				$evaluadores['Pares,2'] = "empty";

			$this->set('par',$results);
			$results = Personal_empresa::get_subalternos($arr->id_personal);
			if($results)
				$evaluadores['Subalternos,3'] = $results;
			else
				$evaluadores['Subalternos,3'] = "empty";
			$this->set('sub',$results);
			$this->set('evaluadores',$evaluadores);
		}else{
			$this->set('subtitle','Evaluadores seleccionados');
			$sup=$par=$sub=array();
			foreach ($sel as $key => $value) {
				$value=reset($value);
				$res = $this->User->query('SELECT * FROM personal_empresa WHERE id_personal='.$value['id_personal'].'',1);
				$res = reset($res);
				switch ($value['relacion']) {
					case 0:
					$sup[]['b']=$res;
					break;
					case 1:
					$sup[]['b']=$res;
					break;
					case 2:
					$par[]['b']=$res;
					break;
					case 3:
					$sub[]['b']=$res;
					break;
				}
			}
			$this->set('ger',0);
			$this->set('sup',$sup);
			$this->set('par',$par);
			$this->set('sub',$sub);
		}

		if(isset($_POST['id_per'])){
			$arr = Personal_empresa::withID($id);
			$pid = $arr->get_pid_sup();
			if($pid){
				$nivel = $aprob = 1;
				if($pid==6015 || $pid==6020){
					$pid=6018;
				}
				$msg="<p>Estimado/a,</p><p>".$_SESSION['Personal']['nombre']." ha modificado sus evaluadores para la Evaluación de Desempeño. Es necesario que confirme esta selección antes de proceder, puede descartar a y/o seleccionar nuevos evaluadores.</p><p>En el menú lateral encontrara la opción para confirmar bajo Evaluación de desempeño > Aprobación de evaluadores > subalternos directos</p>";
				$email = $this->Evaluacion_desempenio->get_emailById($pid);
				$subj = "Selección de evaluadores para ".$_SESSION['Personal']['nombre'];
				Util::sendMail($email,$subj,$msg);
			}else{
				$nivel = $aprob = 3;
			}
			foreach ($_POST['id_per'] as $a => $b) {
				$val = explode(',', $b);
				$args = array(
					"id_evaluado" => $id,
					"id_personal" => $val[0],
					"id_empresa" => $id_e,
					"relacion" => $val[1],
					"nivel" => $nivel,
					"aprovado" => $aprob,
					"tipo_ingreso" => 'I'
					);
				$evaluador = new Evaluacion_desempenio_seleccion_evaladores($args);
				$evaluador->insert();
			}
			
			$_POST=null;
			header("Location: " . BASEURL.$_SESSION['link']);

		}
	}

	function definir(){
		$this->haySession();

		if(array_filter($_POST)){

			if(isset($_POST['guardar'])){

				$evaluacion = new Evaluacion_desempenio();
 				$criterios_escala = array();
 				$criterios_rango_barras = array();

 				foreach ($_POST['escala_etiqueta'] as $key => $value) {
 					$criterios_escala[$key]['escala_etiqueta'] = utf8_decode($_POST['escala_etiqueta'][$key]);
 					$criterios_escala[$key]['escala_valor'] = $_POST['escala_valor'][$key];
 				}
 				

 				if(sizeof($_POST['rango_desde']) != sizeof($_POST['rango_hasta']))
 				{
 					die('Los criterios de las barras y sus rangos no están a la par !!!');
 				}

 				foreach ($_POST['rango_desde'] as $key => $value) {
 					$criterios_rango_barras[$key]['desde'] = $_POST['rango_desde'][$key];
 					$criterios_rango_barras[$key]['hasta'] = $_POST['rango_hasta'][$key];
 				}

				/*
				$target_dir = ROOT.DS.'public'.DS.'uploads'.DS.'evaluacion_desempenio/Definicion/';
				foreach ($_FILES["simbolo"]["error"] as $clave => $error) {
				    if ($error == UPLOAD_ERR_OK) {
						$nombre = $this->Evaluacion_desempenio->htmlprnt_win(basename($_FILES["simbolo"]["name"][$clave]));
						$explode = explode(".", $nombre);
						$file = $explode[0] . '_' . date("dmYHis") . '.' . $explode[1];
						array_push($criterios_simbolo, $file);
						$target_file = $target_dir . $file;
						file_put_contents($target_file, file_get_contents($_FILES["simbolo"]["tmp_name"][$clave]));
				    }
				}
				*/
				$criterios_simbolo = $_POST['simbolo'];
				
 				$evaluacion->setId_empresa($_SESSION['Empresa']['id']);
				$evaluacion->setFecha($_POST['fecha']);
				$evaluacion->setEmail($_POST['email']);
				$evaluacion->setPeriodo(date('Y-m-d'));				
				$evaluacion->setObjetivos($_POST['objetivos_individuales']);
				$evaluacion->setCriteriosEscala($criterios_escala);
				$evaluacion->setCriteriosSimbolos($criterios_simbolo);
				$evaluacion->setCriteriosRangoBarras($criterios_rango_barras);
				$evaluacion->setTextoEncuesta($_POST['texto_encuesta']);
				$evaluacion->setSeleccionEvaluadores($_POST['seleccion_evaluadores']);
				$evaluacion->setCuestionario($_POST['id_cuestionario']);
				$evaluacion->insert();

				//
				$correo = $evaluacion->getEmail();

				$link = BASEURL;
				$subject = 'Encuesta en Línea de Evaluación de Desempeño';
 				$msj = '<p>Estimado/a,</p>';
				$msj .= '<p>'.$evaluacion->getTextoEncuesta().'<p>';
				Util::sendMail($correo,$subject,$msj);
			}
		}
	}

	function test_temp($id_e,$id_t){

		$this->haySession();

		$this->set('id_e',$id_e);

		$this->set('id_t',$id_t);

		$sonda = new Evaluacion_desempenio();
		$sonda->select_($id_e,$id_t);
		$criterios_escala = $sonda->getCriteriosEscala();

		$min_escala = '';
		$max_escala = '';
		$hay_caracter = 0;
		$i = 1;
		$escala_valor = '';

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

		$this->set('min_escala',$min_escala);
		$this->set('max_escala',$max_escala);
		$this->set('hay_caracter',$hay_caracter);
		$this->set('escala_valor',$escala_valor);

		

		if(array_filter($_POST)){

			$id_e = $_SESSION['USER-AD']['id_empresa'];

			//	SEGMENTACION

			$suser = new Evaluacion_desempenio_user();

			$suser->setIdPersonal($_SESSION['USER-AD']['id_personal']);

			$suser->setId_empresa($id_e);

			$suser->setTipoTest($_POST['btnTipEval']);

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

			
			//	Conclusiones Generales de la Evaluación de Desempeño

			$user_foda = new Evaluacion_desempenio_user();

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


			$sonda = new Evaluacion_desempenio();

			$sonda->select($id_e);

			$id_user = $_SESSION['USER-AD']['id'];

			unset($_POST['nuevos_criterios']);
			unset($_POST['hay_caracter']);
			unset($_POST['max_escala']);
			unset($_POST['min_escala']);
			unset($_POST['escala_valor']);

			
			//	RESPUESTA

			foreach ($_POST as $key => $value) {

				$respuesta = new Evaluacion_desempenio_respuestas();

				$respuesta->setId_def_user($suser->getId());

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