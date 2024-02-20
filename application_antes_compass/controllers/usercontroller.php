<?php

class UserController extends Controller {

	protected $link;

	function __construct($model, $controller, $action=null, $type = 0,$full=false,$render=false) {

		parent::__construct($model, $controller, $action, $type,$full,$render);
		$this->link = $this->User->getDBHandle();
	}

	function login($tk=null,$id=null,$usr=null,$cod=null) {
		$this->set('tk',$tk);
		$this->set('title','Alto Desempe&ntilde;o | Log in');
		Util::sessionStart();
		if(DEBUG){
			$this->_logout();
		}else{
			if(!isset($tk)){
				$tk ="home";
			}
			if(isset($cod)){
				$_SESSION['evaluado-sub']['id'] = $cod;
			}else{
				$_SESSION['evaluado-sub']['id'] = $id;
			}
			if(isset($id) && isset($tk) && isset($usr)){				
				$query = (isset($cod)) ? ' select * from users where user_name = \''. $usr .'\' and id_personal = \''. $id .'\' limit 1' : ' select * from users where user_name = \''. $usr .'\' limit 1' ;
				$userArr = $this->User->query($query);
				if (!$userArr){
					$this->_logout();
				}else{
					$_SESSION['USER-AD'] = $userArr[0]["User"];
					$header_info=$this->getHeaderInfo($_SESSION['USER-AD']["user_rol"]);
					$_SESSION['link']=$header_info['link'];
					$_SESSION['nav']=$header_info['navbar'];
					if ($_SESSION['USER-AD']["user_rol"] == 0){
						header("Location: " . BASEURL.$_SESSION['link']);
					}elseif ($_SESSION['USER-AD']["user_rol"] == 1){
						$_SESSION['Empresa']['id'] = $userArr[0]["User"]['id_empresa'];
						$res = $this->User->query('SELECT nombre,admin FROM empresa WHERE id="'. $_SESSION['Empresa']['id'] .'"',1);
						$res = @reset($res);
						$_SESSION['Empresa']['nombre'] = $res['nombre'];
						$_SESSION['Empresa']['admin'] = $res['admin'];
						header("Location: " . BASEURL.$_SESSION['link']);
					}elseif ($_SESSION['USER-AD']["user_rol"] == 2){
						$_SESSION['Empresa']['id'] = $userArr[0]["User"]['id_empresa'];
						$res = $this->User->query('SELECT nombre FROM empresa WHERE id="'. $_SESSION['Empresa']['id'] .'"',1);
						$res = @reset($res);
						$_SESSION['Empresa']['nombre'] = $res['nombre'];
						$res = $this->User->query('SELECT nombre_p FROM personal WHERE id="'. $_SESSION['USER-AD']['id_personal'] .'"',1);
						$res = @reset($res);
						$_SESSION['Personal']['nombre'] = $res['nombre_p'];
						header("Location: " . BASEURL.'user/'.$tk);
					}
				}
			}else{
				$this->_logout();
			}
		}
	}


	function home($tab=null) {
		$this->set('title','Alto Desempe&ntilde;o | Home');
		$this->haySession();
		if(isset($tab))
			$this->set('tab',$tab);
	// TAB 1
		$_SESSION['Personal']['id'] = $_SESSION['USER-AD']['id_personal'];
		$d_emp = $this->User->get_empdat($_SESSION['USER-AD']['id_personal']);
		$res=$this->User->query('SELECT * FROM personal WHERE id IN(SELECT DISTINCT id_evaluado FROM multifuente_evaluadores WHERE relacion=0 AND id_personal='.$_SESSION['USER-AD']['id_personal'].')');
		$this->set('evaluados',$res);
		$res=$this->User->query('SELECT * FROM `multifuente_evaluado` WHERE id_personal='.$_SESSION['USER-AD']['id_personal'].'');
		$this->set('eval',$res);	

	// PREPARA ESTADO DE EVALUACIONES
		$test = $this->User->get_testdat($_SESSION['USER-AD']['id_personal']);
	// TAB 2
		$this->set('hcompass',$test['compass_360']);
		$this->set('hscorer',$test['scorer']);


	}

	function test() {
	//header("Location: " . BASEURL.'user/home');
		$this->set('title','Alto Desempe&ntilde;o | Home');
		$this->haySession();
	// TAB 1
		$_SESSION['Personal']['id'] = $_SESSION['USER-AD']['id_personal'];
		$d_emp = $this->User->get_empdat($_SESSION['USER-AD']['id_personal']);
		$res=$this->User->query('SELECT * FROM personal WHERE id IN(SELECT DISTINCT id_evaluado FROM multifuente_evaluadores WHERE relacion=0 AND id_personal='.$_SESSION['USER-AD']['id_personal'].')');
		$this->set('evaluados',$res);
		$res=$this->User->query('SELECT * FROM `multifuente_evaluado` WHERE id_personal='.$_SESSION['USER-AD']['id_personal'].'');
		$this->set('eval',$res);	

	// PREPARA ESTADO DE EVALUACIONES
		$test = $this->User->get_testdat($_SESSION['USER-AD']['id_personal']);
	// TAB 2
		$this->set('hcompass',$test['compass_360']);
		$this->set('hscorer',$test['scorer']);


	}
/*
	function insights() {
		$this->set('title','Alto Desempe&ntilde;o | Evaluac&oacute;n Insights');
		Util::sessionStart();	

		$result = $this->User->query('SELECT `completo` FROM `test_insights` WHERE `id_personal` ='. $_SESSION['USER-AD']['id_personal'] .'',1);

		$result= @reset($result);

		if($result['completo'] == 1){
			echo '<script>alert("Solo puede realizar esta prueba 1 vez");</script>';
			$this->_logout();
		}

		$nombre = $_SESSION['Personal']['nombre'];
		$nombre = trim($nombre);
		$name = $nombre;
		$nombre = str_replace(" ","_",$nombre);

		$result = $this->User->query('SELECT `id_area`, `id_cargo` FROM `personal_empresa` WHERE `id_personal` ='. $_SESSION['USER-AD']['id_personal'] .'',1);
		$result = @reset($result);


		$area = $this->User->query('SELECT `nombre` FROM `empresa_area` WHERE `id` ='. $result['id_area'] .'',1);
		$area = @reset($area);
		$cargo = $this->User->query('SELECT `nombre` FROM `empresa_cargo` WHERE `id` ='. $result['id_cargo'] .'',1);
		$cargo = @reset($cargo);

		$p_location = $_SERVER['DOCUMENT_ROOT'].'/aldes/public/'; 
		$location = $p_location.'files/insights/';

		if (isset($_POST['aceptar'])){ 
			$archivo = $nombre;

			$array1 = array ("ñ","á","é","í","ó","ú","Ñ");
			$array2 = array ("n","a","e","i","o","u","N");

			$archivo = str_replace($array1,$array2,$archivo);

			$email=EMAIL;

		// crear primero el txt

			$DescriptorFichero = fopen($location.$archivo.".txt","w"); 

			$subject="Alto Desempeño - Evaluacion Insights\n";fputs($DescriptorFichero,$subject);

			$message = "Nombre:".$name." \n";fputs($DescriptorFichero,$message);	
			$message = "Cargo:".$cargo['nombre']."\n";fputs($DescriptorFichero,$message);
			$message = "Departamento: ".$area['nombre']."\n";fputs($DescriptorFichero,$message);
		//$message = "Sexo: ".$sexo."\n\n";fputs($DescriptorFichero,$message);
			$message = "<p>Fecha: ".date('l jS \of F Y h:i:s A')."</p>\n\n";


			$message = "Pregunta 1: \n";fputs($DescriptorFichero,$message);
			$message = "Cuidadoso y evaluador-->".$_POST['1_1']."\n";fputs($DescriptorFichero,$message);
			$message = "Leal y amable -->".$_POST['1_2']."\n";fputs($DescriptorFichero,$message);
			$message = "Influyente y expresivo -->".$_POST['1_3']."\n";fputs($DescriptorFichero,$message);
			$message = "Estratégico y exigente -->".$_POST['1_4']."\n\n";fputs($DescriptorFichero,$message);


			$message = "Pregunta 2: \n";fputs($DescriptorFichero,$message);
			$message = "Amigable y dinámico -->".$_POST['2_1']."\n";fputs($DescriptorFichero,$message);
			$message = "Confiable y moderado -->".$_POST['2_2']."\n";fputs($DescriptorFichero,$message);
			$message = "Enérgico y orientado a resultados -->".$_POST['2_3']."\n";fputs($DescriptorFichero,$message);
			$message = "Metódico y lógico -->".$_POST['2_4']."\n\n";fputs($DescriptorFichero,$message);


			$message = "Pregunta 3: \n";fputs($DescriptorFichero,$message);
			$message = "Tranquilo y mediador -->".$_POST['3_1']."\n";fputs($DescriptorFichero,$message);
			$message = "Decidído y dominante -->".$_POST['3_2']."\n";fputs($DescriptorFichero,$message);
			$message = "Optimista y alegre -->".$_POST['3_3']."\n";fputs($DescriptorFichero,$message);
			$message = "Exacto y objetivo -->".$_POST['3_4']."\n\n";fputs($DescriptorFichero,$message);


			$message = "Pregunta 4: \n";fputs($DescriptorFichero,$message);
			$message = "Seguro de si mismo e intenso -->".$_POST['4_1']."\n";fputs($DescriptorFichero,$message);
			$message = "Ordenado y conciso -->".$_POST['4_2']."\n";fputs($DescriptorFichero,$message);
			$message = "Estable y de trato fácil -->".$_POST['4_3']."\n";fputs($DescriptorFichero,$message);
			$message = "Conversador y simpático -->".$_POST['4_4']."\n\n";fputs($DescriptorFichero,$message);


			$message = "Pregunta 5: \n";fputs($DescriptorFichero,$message);
			$message = "Estructurado y claro -->".$_POST['5_1']."\n";fputs($DescriptorFichero,$message);
			$message = "Desafiante y directo -->".$_POST['5_2']."\n";fputs($DescriptorFichero,$message);
			$message = "Leal y adaptable -->".$_POST['5_3']."\n";fputs($DescriptorFichero,$message);
			$message = "Sociable y activo -->".$_POST['5_4']."\n\n";fputs($DescriptorFichero,$message);


			$message = "Pregunta 6: \n";fputs($DescriptorFichero,$message);
			$message = "Complaciente y colaborador -->".$_POST['6_1']."\n";fputs($DescriptorFichero,$message);
			$message = "Expresivo y optimista -->".$_POST['6_2']."\n";fputs($DescriptorFichero,$message);
			$message = "Enérgico y autoritario -->".$_POST['6_3']."\n";fputs($DescriptorFichero,$message);
			$message = "Pensativo y auto-controlado -->".$_POST['6_4']."\n\n";fputs($DescriptorFichero,$message);



			$message = "Pregunta 7: \n";fputs($DescriptorFichero,$message);
			$message = "Efusivo y persuasivo -->".$_POST['7_1']."\n";fputs($DescriptorFichero,$message);
			$message = "Reflexivo y suspicaz -->".$_POST['7_2']."\n";fputs($DescriptorFichero,$message);
			$message = "Con iniciativa y confianza en si mismo-->".$_POST['7_3']."\n";fputs($DescriptorFichero,$message);
			$message = "Calmado y considerado con los demas -->".$_POST['7_4']."\n\n";fputs($DescriptorFichero,$message);



			$message = "Pregunta 8: \n";fputs($DescriptorFichero,$message);
			$message = "Seguro de si mismo y con determinación -->".$_POST['8_1']."\n";fputs($DescriptorFichero,$message);
			$message = "Extrovertido y alegre -->".$_POST['8_2']."\n";fputs($DescriptorFichero,$message);
			$message = "Fiel y solidario -->".$_POST['8_3']."\n";fputs($DescriptorFichero,$message);
			$message = "Coherente y preciso -->".$_POST['8_4']."\n\n";fputs($DescriptorFichero,$message);

			$message = "Pregunta 9: \n";fputs($DescriptorFichero,$message);
			$message = "Sensible y diplomatico -->".$_POST['9_1']."\n";fputs($DescriptorFichero,$message);
			$message = "Preciso y prudente -->".$_POST['9_2']."\n";fputs($DescriptorFichero,$message);
			$message = "Entusiasta y alentador -->".$_POST['9_3']."\n";fputs($DescriptorFichero,$message);
			$message = "Rápido y orientado a resultados -->".$_POST['9_4']."\n\n";fputs($DescriptorFichero,$message);



			$message = "Pregunta 10: \n";fputs($DescriptorFichero,$message);
			$message = "Dominante y firme -->".$_POST['10_1']."\n";fputs($DescriptorFichero,$message);
			$message = "Conciliador y reservado -->".$_POST['10_2']."\n";fputs($DescriptorFichero,$message);
			$message = "Sociable y animado -->".$_POST['10_3']."\n";fputs($DescriptorFichero,$message);
			$message = "Minucioso y detallista -->".$_POST['10_4']."\n\n";fputs($DescriptorFichero,$message);

			$message = "Pregunta 11: \n";fputs($DescriptorFichero,$message);
			$message = "Centrado en el equipo y espontáneo -->".$_POST['11_1']."\n";fputs($DescriptorFichero,$message);
			$message = "Exacto y racional -->".$_POST['11_2']."\n";fputs($DescriptorFichero,$message);
			$message = "Amistoso y equilibrado -->".$_POST['11_3']."\n";fputs($DescriptorFichero,$message);
			$message = "Centrado en la tarea y franco -->".$_POST['11_4']."\n\n";fputs($DescriptorFichero,$message);


			$message = "Pregunta 12: \n";fputs($DescriptorFichero,$message);
			$message = "Analítico y meticuloso -->".$_POST['12_1']."\n";fputs($DescriptorFichero,$message);
			$message = "Amistoso y divertido -->".$_POST['12_2']."\n";fputs($DescriptorFichero,$message);
			$message = "Competitivo y fuerte -->".$_POST['12_3']."\n";fputs($DescriptorFichero,$message);
			$message = "Ecuánime y cooperativo -->".$_POST['12_4']."\n\n";fputs($DescriptorFichero,$message);


			$message = "Pregunta 13: \n";fputs($DescriptorFichero,$message);
			$message = "De trato personal y apacible -->".$_POST['13_1']."\n";fputs($DescriptorFichero,$message);
			$message = "Abierto y empático -->".$_POST['13_2']."\n";fputs($DescriptorFichero,$message);
			$message = "Observador y formal -->".$_POST['13_3']."\n";fputs($DescriptorFichero,$message);
			$message = "Activo y controlador -->".$_POST['13_4']."\n\n";fputs($DescriptorFichero,$message);

			$message = "Pregunta 14: \n";fputs($DescriptorFichero,$message);
			$message = "Resuelto y capaz de imponerse -->".$_POST['14_1']."\n";fputs($DescriptorFichero,$message);
			$message = "Perfeccionista y cuestionador -->".$_POST['14_2']."\n";fputs($DescriptorFichero,$message);
			$message = "Entusiasta y encantador -->".$_POST['14_3']."\n";fputs($DescriptorFichero,$message);
			$message = "Comprensivo y pacificador -->".$_POST['14_4']."\n\n";fputs($DescriptorFichero,$message);


			$message = "Pregunta 15: \n";fputs($DescriptorFichero,$message);
			$message = "Sistemático y escrupuloso -->".$_POST['15_1']."\n";fputs($DescriptorFichero,$message);
			$message = "Popular y amante de la diversión -->".$_POST['15_2']."\n";fputs($DescriptorFichero,$message);
			$message = "Moderador y promueve el equilibrio -->".$_POST['15_3']."\n";fputs($DescriptorFichero,$message);
			$message = "Audaz y con determinación -->".$_POST['15_4']."\n\n";fputs($DescriptorFichero,$message);


			$message = "Pregunta 16: \n";fputs($DescriptorFichero,$message);
			$message = "Animado y convincente -->".$_POST['16_1']."\n";fputs($DescriptorFichero,$message);
			$message = "Decidido e inmediato -->".$_POST['16_2']."\n";fputs($DescriptorFichero,$message);
			$message = "Analítico y disciplinado -->".$_POST['16_3']."\n";fputs($DescriptorFichero,$message);
			$message = "Tolerante y sosegado -->".$_POST['16_4']."\n\n";fputs($DescriptorFichero,$message);

			$message = "Pregunta 17: \n";fputs($DescriptorFichero,$message);
			$message = "Paciente y empático -->".$_POST['17_1']."\n";fputs($DescriptorFichero,$message);
			$message = "Lógico y controlado -->".$_POST['17_2']."\n";fputs($DescriptorFichero,$message);
			$message = "Centrado en el trabajo y competitivo -->".$_POST['17_3']."\n";fputs($DescriptorFichero,$message);
			$message = "Platicador y espontáneo -->".$_POST['17_4']."\n\n";fputs($DescriptorFichero,$message);

			$message = "Pregunta 18 \n";fputs($DescriptorFichero,$message);
			$message = "Influyente e informal -->".$_POST['18_1']."\n";fputs($DescriptorFichero,$message);
			$message = "Discreto e impulsado por valores -->".$_POST['18_2']."\n";fputs($DescriptorFichero,$message);
			$message = "Imparcial y evaluador -->".$_POST['18_3']."\n";fputs($DescriptorFichero,$message);
			$message = "Desafiante y autoritario -->".$_POST['18_4']."\n\n";fputs($DescriptorFichero,$message);

			$message = "Pregunta 19: \n";fputs($DescriptorFichero,$message);
			$message = "Sistemático y preparado -->".$_POST['19_1']."\n";fputs($DescriptorFichero,$message);
			$message = "Valiente e independiente -->".$_POST['19_2']."\n";fputs($DescriptorFichero,$message);
			$message = "Imaginativo y extrovertido -->".$_POST['19_3']."\n";fputs($DescriptorFichero,$message);
			$message = "Consejero y preocupado por los demás -->".$_POST['19_4']."\n\n";fputs($DescriptorFichero,$message);

			$message = "Pregunta 20: \n";fputs($DescriptorFichero,$message);
			$message = "Le gusta mandar y orientado a la acción -->".$_POST['20_1']."\n";fputs($DescriptorFichero,$message);
			$message = "Espontáneo y animado -->".$_POST['20_2']."\n";fputs($DescriptorFichero,$message);
			$message = "Estudioso y racional -->".$_POST['20_3']."\n";fputs($DescriptorFichero,$message);
			$message = "Pacificador y armonioso -->".$_POST['20_4']."\n\n";fputs($DescriptorFichero,$message);

			$message = "Pregunta 21: \n";fputs($DescriptorFichero,$message);
			$message = "Organizado y juicioso -->".$_POST['21_1']."\n";fputs($DescriptorFichero,$message);
			$message = "Paciente y colaborador -->".$_POST['21_2']."\n";fputs($DescriptorFichero,$message);
			$message = "Fuerte y buen discutidor -->".$_POST['21_3']."\n";fputs($DescriptorFichero,$message);
			$message = "Abierto y busca relacionarse -->".$_POST['21_4']."\n\n";fputs($DescriptorFichero,$message);


			$message = "Pregunta 22: \n";fputs($DescriptorFichero,$message);
			$message = "Objetivo y audaz -->".$_POST['22_1']."\n";fputs($DescriptorFichero,$message);
			$message = "Relajado y pacifico -->".$_POST['22_2']."\n";fputs($DescriptorFichero,$message);
			$message = "Basado en los hechos y formal -->".$_POST['22_3']."\n";fputs($DescriptorFichero,$message);
			$message = "Alegre y agradable -->".$_POST['22_4']."\n\n";fputs($DescriptorFichero,$message);


			$message = "Pregunta 23: \n";fputs($DescriptorFichero,$message);
			$message = "Efusivo y entusiasta -->".$_POST['23_1']."\n";fputs($DescriptorFichero,$message);
			$message = "Vigoroso y realista -->".$_POST['23_2']."\n";fputs($DescriptorFichero,$message);
			$message = "Compasivo y considerado -->".$_POST['23_3']."\n";fputs($DescriptorFichero,$message);
			$message = "Disciplinado y detallistao -->".$_POST['23_4']."\n\n";fputs($DescriptorFichero,$message);

			$message = "Pregunta 24: \n";fputs($DescriptorFichero,$message);
			$message = "Constante y que apoya a los demas -->".$_POST['24_1']."\n";fputs($DescriptorFichero,$message);
			$message = "Independiente y emprendedor -->".$_POST['24_2']."\n";fputs($DescriptorFichero,$message);
			$message = "Reflexivo y minucioso -->".$_POST['24_3']."\n";fputs($DescriptorFichero,$message);
			$message = "Comunicativo y positivo -->".$_POST['24_4']."\n\n";fputs($DescriptorFichero,$message);

			$message = "Pregunta 25: \n";fputs($DescriptorFichero,$message);
			$message = "Cauto y preciso -->".$_POST['25_1']."\n";fputs($DescriptorFichero,$message);
			$message = "Directo y franco -->".$_POST['25_2']."\n";fputs($DescriptorFichero,$message);
			$message = "Expresivo y optimista -->".$_POST['25_3']."\n";fputs($DescriptorFichero,$message);
			$message = "Tolerante y noble -->".$_POST['25_4']."\n\n";fputs($DescriptorFichero,$message);


			fclose($DescriptorFichero); 

			require($p_location.'fpdf/fpdf.php');
			require($p_location.'fpdf/pdf.php');


			$pdf=new PDF();
			$title='Insights Form';
			$pdf->SetTitle($title);
			$pdf->SetAuthor('Insights');
			$pdf->PrintChapter(1,'-',$location.$archivo.'.txt');
			$pdf->Output($location.'/pdf/'.$archivo.'.pdf','f');

		//$subject="Evaluación Insights ".$archivo;
			$this->User->query('REPLACE INTO `pdf_test`(`url`, `id_personal`, `id_test`) VALUES ("files/insights/pdf/'.$archivo.'.pdf","'.$_SESSION['USER-AD']['id_personal'].'",1)');
			$this->User->query('UPDATE `test_insights` SET `completo`=1 WHERE `id_personal`="'.$_SESSION['USER-AD']['id_personal'].'"');

			$message ="<p>Evaluación Insights </p><br>\n";	
			$message .= "<p><b>Nombre: </b>".$name." </p>\n";
			$message .= "<p><b>Cargo: </b>".$cargo['nombre']."</p>\n";
			$message .= "<p><b>Departamento: </b>".$area['nombre']."</p>\n";
			$message .= "<p><b>Fecha: </b>".date('l jS \of F Y h:i:s A')."</p>\n\n";


			$archivodirec = BASEURL.'test/download/'.$_SESSION['USER-AD']['id_personal'].'/1';
			$message .= '<p>Para descargar el archivo en pdf de click <a href="'.$archivodirec.'">aquí</a></p>';
			Util::sendMail($email,$subject,$message);
		}
	}
*/

	function multifuente($cod_evaluado=null) {
		$this->set('title','Alto Desempe&ntilde;o | Evaluac&oacute;n Insights');
		$this->haySession();	
		$cod_evaluado = (isset($cod_evaluado)) ? $cod_evaluado : $_SESSION['evaluado-sub']['id'] ;
		$this->set('cod_evaluado',$cod_evaluado);
		if(!isset($cod_evaluado)){
			$this->set('custom_danger','Ocurrió un error. Por favor vuelva a seguir el link desde la sección de evaluaciones pendientes.');
		}
		$n_eva = self::get_name($cod_evaluado);
		$this->set('nombre_e',$n_eva);
		if(self::get_id($cod_evaluado) == $_SESSION['USER-AD']['id_personal']){
			$result = $this->User->query('SELECT `id`,`resuelto`,`cod_test`,`id_personal` FROM `multifuente_evaluado` WHERE `cod_evaluado` ="'. $cod_evaluado .'"',1);
			$table = 'multifuente_evaluado';
			$rel = "Auto";
		}else{
			$result = $this->User->query('SELECT `id`,`resuelto`,`cod_test`,`id_personal`,`relacion` FROM `multifuente_evaluadores` WHERE `id_personal` ="'. $_SESSION['USER-AD']['id_personal'] .'" And `cod_evaluado` ="'. $cod_evaluado .'"',1);
			$table = 'multifuente_evaluadores';
		}
		$result= @reset($result);
		if (isset($result['relacion'])){
			switch ($result['relacion']){
				case '0':
				$rel = "Gerente";
				break;
				case '1':
				$rel = "Gerente";
				break;
				case '2':
				$rel = "Par";
				break;
				case '3':
				$rel = "Subalterno";
				break;
			}
		}
		$user =  $result['id_personal'];
		if($result['resuelto'] == 1){
			echo '<script>alert("Solo puede realizar esta prueba 1 vez");</script>';
			$this->_logout();
		}
		$test = $this->User->query('SELECT `pregunta`,`cod_pregunta`,`cod_tema` FROM `multifuente_test` WHERE `cod_test` ="'. $result['cod_test'] .'" AND `cod_pregunta` NOT IN(SELECT `cod_pregunta` FROM `multifuente_respuestas` WHERE `cod_evaluado`="'.$cod_evaluado.'" AND `id_personal`='.$_SESSION['USER-AD']['id_personal'].')');
		$this->set('test',$test);
		$cod_test = $result['cod_test'];
		if(isset($_POST['terminar'])){
			$fortalezas = mysqli_real_escape_string($this->link,$_POST['fortalezas']);
			$debilidades = mysqli_real_escape_string($this->link,$_POST['debilidades']);
			$comentarios = mysqli_real_escape_string($this->link,$_POST['comentarios']);
			for($j=0;$j<=$_POST['cant'];$j++){
				if(isset($_POST[$j."_multi"])){
					$cod_tema = $_POST['c_tema'][$j];
					$cod_pregunta = $_POST['c_preg'][$j];
					$respuesta =  $_POST[$j."_multi"];
					$sql = "INSERT INTO multifuente_respuestas(cod_test,cod_tema,cod_pregunta,respuesta,cod_evaluado,fortalezas,debilidades,comentarios,rango,id_personal) VALUES ('".$cod_test."','".$cod_tema."','".$cod_pregunta."','".$respuesta."','".$cod_evaluado."','".$fortalezas."','".$debilidades."','".$comentarios."', '".$rel."',".$user.")";
					$this->User->query($sql);
				}
			}
			if($_POST['terminar'] == 'Terminar'){
				if(!mysqli_error($this->link)){
					$sql = 'UPDATE '.$table.' SET `resuelto`=1 WHERE `id_personal`='.$_SESSION['USER-AD']['id_personal'].' AND cod_evaluado="'.$cod_evaluado.'"';
					$this->User->query($sql);
					$subject = 'Confirmación de recepción y registro de respuestas';	    
					$message = 'Apreciamos su colaboración y dedicación en proporcionar retroalimentación a '.$n_eva;
					$message .=  '<p>Sus respuestas han sido registradas y le ratificamos absoluta confidencialidad y anonimato.</p>';		
					Util::sendMail(self::get_email($cod_evaluado),$subject,$message);
					$this->_template = new Template('Void','render');
					header("Location: ".BASEURL."user/home");
				}else{
					$this->_logout();
				}
			}else{
				// http://localhost/aldes/multifuente/evaluaciones_pendientes
				@header("Location: ".BASEURL."multifuente/evaluaciones_pendientes");
			}
			header("Location: ".BASEURL."multifuente/evaluaciones_pendientes");
		}
	}

	function asignar_relacion(){
		Util::sessionStart();
		$this->set('backlink',false);
		$id_e = $_SESSION['Empresa']['id'];
		$id=$_SESSION['USER-AD']['id_personal'];
		$mr = new Multifuente_relacion(); 
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
				$msg="<p>Estimado/a,</p><p>".$_SESSION['Personal']['nombre']." ha modificado sus evaluadores para la evaluación Compass 360. Es necesario que confirme esta selección antes de proceder, puede descartar a y/o seleccionar nuevos evaluadores.</p><p>En el menú lateral encontrara la opción para confirmar bajo Compass 360 > Selección de evaluadores > subalternos directos</p>";
				$email = $this->User->get_emailById($pid);
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
					);
				$evaluador = new Multifuente_relacion($args);
				$evaluador->insert();
			}
			$_POST=null;
		// $this->_template = new Template('User','home', false);
		// $this->home();
			header("Location: " . BASEURL.$_SESSION['link']);

		}
	}

	function confirmar_relacion($id_evaluado=null){
		Util::sessionStart();
		$this->set('backlink',false);
		$id_e = $_SESSION['Empresa']['id'];
		$id = $_SESSION['USER-AD']['id_personal'];
		$id_evaluado = (isset($id_evaluado)) ? $id_evaluado : $_SESSION['evaluado-sub']['id'] ;
	// $id_evaluado = $_SESSION['evaluado']['id'];
		$this->set('id_evaluado',$id_evaluado);
		$superior = Personal_empresa::withID($id);
		$evaluado = Personal_empresa::withID($id_evaluado);
		$pid = $superior->get_pid_sup();
		$evaluado_pid = $evaluado->get_pid_sup();
		$mr = new Multifuente_relacion();
		$me = new Multifuente_evaluado();
		//$nivel_max = $mr->get_max_nivel($id_evaluado);
		//By JPazmino
		$nivel_max = $mr->get_min_nivel($id_evaluado);
		$all_sel = $mr->select_all($id_evaluado);
		$sel = $mr->select_all_nivel($id_evaluado,$nivel_max);
		$this->set('subtitle','Evaluadores seleccionados');
		$sup=$par=$sub=array();
		$tipo_ingreso = "";
		
		if($nivel_max==3){ 
			$dead = 0;
			$this->set('custom_info',"Se ha completado el proceso de selección.");
		}elseif($id == $evaluado_pid && $nivel_max==2){
			$dead = 0;
			$this->set('custom_info',"Usted ya ha confirmado la selección.");
		}elseif($id != $evaluado_pid && $nivel_max==3){
			$dead = 0;
			$this->set('custom_info',"Usted ya ha confirmado la selección.");
		}else{
			$dead = 1;
		}
		$this->set('dead',$dead);
		$this->set('all_sel', $all_sel);
		if(!$dead){
			$this->set('ger',0);
			$this->set('sup',0);
			$this->set('par',0);
			$this->set('sub',0);
			exit();
		}

		foreach ($sel as $key => $value) {
			$res = $this->User->query_('SELECT * FROM personal_empresa WHERE id_personal='.$value['id_personal'].'',1);
			$res['tipo_ingreso'] = $value['tipo_ingreso'];
			$res['aprovado'] = $value['aprovado'];
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
			
			$tipo_ingreso = $value['tipo_ingreso'];
		}
		$this->set('ger',0);
		$this->set('sup',$sup);
		$this->set('par',$par);
		$this->set('sub',$sub);

		if(isset($_POST['button_r'])){
			$name = $this->User->get_pname($_SESSION['evaluado']['id']);
		// var_dump($pid);
			if($pid==6015 && $nivel_max==2){
				$nivel = $aprob = 3;
			}

			if($pid){
				if($nivel_max==1){
					$nivel = $aprob = 2;
					if($pid==6015 || $pid==6020){
						$pid=6018;
					}

					$msg="<p>Estimado/a,</p><p>".$_SESSION['Personal']['nombre']." ha modificado los evaluadores de ".$name." para la evaluación Compass 360. Es necesario que confirme esta selección antes de proceder, puede descartar a y/o seleccionar nuevos evaluadores.</p><p>En el menú lateral encontrara la opción para confirmar bajo Compass 360 > Selección de evaluadores > subalternos indirectos</p>";
					$email = $this->User->get_emailById($pid);

					$subj = "Selección de evaluadores para ".$name;
					Util::sendMail($email,$subj,$msg);
				}elseif($nivel_max==2)
				$nivel = $aprob = 3;

			}else{
				$nivel = $aprob = 3;
			}
			
			if ($tipo_ingreso == 'E') {
				// 	Obtenemos el test actual del evaluado
				$sql = 'SELECT * FROM multifuente_evaluado WHERE id_empresa = '.$_SESSION['USER-AD']['id_empresa'].' AND id_personal = '.$id_evaluado.' ORDER BY id DESC LIMIT 1';

				$res=$this->User->query_($sql,1);
				$test = $res['cod_test'];
				$fecha = $res['fecha'];
				$f_max = $res['fecha_max'];

				$lp=new listado_personal_op();
				$lp->select($id_evaluado);
				$email = $lp->getEmail();
				$nombre_evaluado = $nombre = $lp->getNombre_();

				$subject="Alto Desempeño - Evaluación multifuentes";
				
				$last_cod = $me->getLastCodEvaluado($id_evaluado,$test);
				$cod_evaluado = $last_cod['cod_evaluado'];
			}
			
			$mi_flag = "";
			$new_evaluadores = '';
			foreach ($_POST['id_per'] as $a => $b) {
				$val = explode(',', $b);
				$mr=new Multifuente_relacion();
				$new_evaluadores.= $val[0].',';
				if($mr->select_id_eval_id_personal($id_evaluado,$val[0])){
					$mr->setRelacion($val[1]);
					$mr->setNivel($nivel);
					$mr->setAprovado($aprob);
					$mr->update();
					$mi_flag = "update";
				}else{
					$args = array(
						"id_evaluado" => $id_evaluado,
						"id_personal" => $val[0],
						"id_empresa" => $id_e,
						"relacion" => $val[1],
						"nivel" => $nivel,
						"aprovado" => $aprob,
						"tipo_ingreso" => 'E'
						);

					$evaluador = new Multifuente_relacion($args);
					$evaluador->insert();
					$mi_flag = "insert";
				}
			}
			
			//	ESTO SOLO APLICA CUANDO SE EDITA UNA EVALUACION, CUANDO SE INGRESA UNA NUEVA SE LA DEJO TAL COMO ESTABA
			if ($tipo_ingreso == 'E') {
				if ($nivel == '3' && $aprob == '3') {
					// Solo se inserta una vez en la tabla de evaluado
					
					$subject="Alto Desempeño - Evaluación multifuentes de ". $nombre ."";
					
					$sql = 'SELECT id_personal,relacion ';
					$sql .= 'FROM multifuente_relacion ';
					$sql .= 'WHERE id_evaluado='.$id_evaluado.' AND aprovado=3 ';
					$sql .= 'AND id_personal in('.substr($new_evaluadores, 0, -1).') ';
					if($tipo_ingreso == 'E')
						$sql .= 'AND tipo_ingreso = "'.$tipo_ingreso.'" ';
					
					$evaluadores=$this->User->query_($sql);
					foreach ($evaluadores as $key => $b) {
						$rel = $b['relacion'];
						$b=$b['id_personal'];
						$arr = $this->User->query('SELECT email FROM personal_datos WHERE id_persona='.$b.'',1);
						
						$lp_evaluador=new listado_personal_op();
						$lp_evaluador->select($b);
						$email = $lp_evaluador->getEmail();
						$nombre = $lp_evaluador->getNombre_();
						
						$this->User->query('INSERT INTO `multifuente_evaluadores`(`id_personal`,`id_evaluado`, `cod_evaluado`, `cod_test`, `fecha`, `fecha_max`, `id_empresa`, `relacion`) VALUES ('.$b.','.$id_evaluado.',"'.$cod_evaluado.'","'.$test.'","'.$fecha.'","'.$f_max.'",'.$_SESSION['Empresa']['id'].','.$rel.')');
						$msg = "<p>Estimado(a)"." ".$nombre.",</p><p>Usted ha sido seleccionado(a) para proporcionar retroalimentación sobre ciertas competencias de ".$nombre_evaluado.". El propósito de esta evaluación es dar retroalimentación a ".$nombre_evaluado." a fin de que pueda mejorar sus competencias organizacionales; por esta razón le solicitamos a usted que sea muy sincero(a) y lo más objetivo posible al momento de responder el cuestionario preparado para este fin. Le garantizamos absoluto anonimato y confidencialidad en sus respuestas.<br></p> 

						<p>Podrá ver esta y todas las evaluaciones pendientes siguendo el link en el menú lateral bajo Compass 360 > Evaluaciones</p><p>Recuerde ingresar su usuario y contraseña previamente enviados. Si por alguna razón debe interrumpir la respuesta al cuestionario, por favor asegúrese de hacer click en el Botón “Grabar y Continuar luego” que está al final del cuestionario.  Usted podrá entrar y salir del cuestionario tantas veces lo requiera utilizando este mismo link (contenido en esta comunicación) sin embargo, le recomendamos enfáticamente que trate de contestar de una sola vez el cuestionario completo.<br></p>

						<br><p>Le solicitamos también que conteste este cuestionario como màximo hasta el ".$f_max.". A fin de facilitarle la comprensión del uso y sobretodo de los beneficios de esta herramienta le invitamos a ver una corta presentación a través de  <a href = 'https://www.youtube.com/watch?v=lhCfx8RbWG4'>Video</a> <br><br></p>


						Desde ya le agradecemos su colaboración.  <p><p>";
						Util::sendMail($email,$subject,$msg);
					}
				}
			}
			//
			$_POST=null;
			header("Location: ".BASEURL."multifuente/directos");
		}
	}

	function confirmar_relacion_final(){
		Util::sessionStart();
		$this->set('backlink','multifuente/asignar');
		$id_e = $_SESSION['Empresa']['id'];

		$sel = $this->User->query('SELECT id_personal,relacion FROM multifuente_relacion WHERE id_evaluado='.$_SESSION['evaluado']['id'].' AND nivel=2');
		if($sel){
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

		if(isset($_POST['button_r'])){
			$pid = $this->User->hasSuperior($_SESSION['USER-AD']['id_personal']);
			$name = $this->User->get_pname($_SESSION['evaluado']['id']);
			if($pid){
				$nivel = $aprob = 2;
				$msg="<p>Estimado/a,</p><p>".$_SESSION['Personal']['nombre']." ha modificado los evaluadores de ".$name." para la evaluación Compass 360. Es necesario que confirme esta selección antes de proceder, puede descartar a y/o seleccionar nuevos evaluadores.</p><p>El siguiente vínculo dirige a la pantalla de confirmación <a href='".BASEURL."user/login/confirmar_relacion_final/".$pid."/".$this->User->get_usrById($pid)."/".$_SESSION['evaluado']['id']."'>Vínculo</a></p>";
				$email = $this->User->get_emailById($pid);
				$subj = "Selección de evaluadores para ".$name;
				Util::sendMail($email,$subj,$msg);
			}else{
				$nivel = $aprob = 3;
			}
			foreach ($_POST['id_per'] as $a => $b) {
				$val = explode(',', $b);
				$this->User->query('INSERT INTO `multifuente_relacion`(`id_evaluado`,`id_personal`,`id_empresa`, `relacion`, `nivel`, `aprovado`) VALUES ('.$_SESSION['evaluado']['id'].','.$val[0].','.$_SESSION['Empresa']['id'].','.$val[1].','.$nivel.','.$aprob.') ON DUPLICATE KEY UPDATE `aprovado`='.$aprob.',`nivel`='.$nivel.'');
			}
		}
	}

	function logout(){
		Util::sessionLogout();
		$this->User->disconnect();
		$this->_template = new Template('Void','render');
		$dispatch = new InicioController('Inicio','inicio','principal',0);
		$dispatch->principal(true);
		header("Location: ".BASEURL);
	}

	function _logout(){
		Util::sessionLogout();
		$this->User->disconnect();
		$this->_template = new Template('Inicio','principal', false);
		exit();
	}

	function makeDir($path)	{
		return is_dir($path) || mkdir($path);
	}

	function tests($dir,$atts=null){
		Util::sessionStart();
		if($_SESSION['USER-AD']['user_rol']==2){

			$id = $_SESSION['USER-AD']['id_personal'];

		// tests disponibles para el personal
			$personal = Personal_test::withID($id);
			$res = $this->User->query('SELECT `compass_360`,`scorer`,`matriz` FROM personal_test WHERE id_personal='.$id.'',1);
			$res = reset($res);
			$compass = $res['compass_360'];
			$scorer = $res['scorer'];
			$matriz = $res['matriz'];
        //revisa si la ficha scorer esta completa
			$ficha = $this->User->query('SELECT * FROM scorer_detalle WHERE id_empresa='.$_SESSION['Empresa']['id'].'',1);
		}
		$nope = "<script>alert('No tiene habilitada esta evaluación');window.history.back();</script>";
		$this->_template = new Template('Void','render');
		switch ($dir) {
			case 'scorer':
			if($ficha){
				if($scorer){
					$dispatch = new ScorecardController('Scorecard','scorecard','generacion');
					$dispatch->generacion($id);
				}else
				echo $nope;
			}else
			echo $nope;
			break;

			case 'scorer_sub':
			if($ficha){
				if($atts==$id){
					header("Location: " . BASEURL.'scorecard/generacion/'.$id);
					$dis = "generacion";
				}else{
					header("Location: " . BASEURL.'scorecard/confirmacion/'.$atts);
					$dis = "confirmacion";
				}
				$dispatch = new ScorecardController('Scorecard','scorecard',$dis);
				$dispatch->{$dis}($atts);
			}else
			echo $nope;
			break;

			case 'plan_de_accion':
			$dispatch = new MultifuenteController('Multifuente','multifuente','plan');
			$dispatch->plan();
			break;

			case 'fase_final':
			if($ficha){
				if($scorer){
					$dispatch = new ScorecardController('Scorecard','scorecard','fase_final');
					$atts = urldecode($atts);
					$atts = explode(";", $atts);
					$dispatch->fase_final($atts);
				}else
				echo $nope;
			}else
			echo $nope;
			break;

			case 'valoracion':
			$ent = Empresa::withID($_SESSION['Empresa']['id']);
			if($ent->valoracion){
				$dispatch = new ValoracionController('Valoracion','valoracion','home');
				$dispatch->home();
			}else
			echo $nope;
			break;

			case 's_res':
			$ent = Empresa::withID($_SESSION['Empresa']['id']);
			if($ent->clima_laboral){
				$dispatch = new SondaController('Sonda','sonda','resultados');
				$dispatch->resultados();
				header("Location: " . BASEURL.'sonda/resultados');
			}else
			echo $nope;
			break;

			case 's_his':
			$ent = Empresa::withID($_SESSION['Empresa']['id']);
			if($ent->clima_laboral){
				$dispatch = new SondaController('Sonda','sonda','historicos');
				$dispatch->historicos();
				header("Location: " . BASEURL.'sonda/historicos');
			}else
			echo $nope;
			break;

			case 's_cres':
			$ent = Empresa::withID($_SESSION['Empresa']['id']);
			if($ent->clima_laboral){
				$dispatch = new SondaController('Sonda','sonda','comparar_resultados');
				$dispatch->comparar_resultados();
				header("Location: " . BASEURL.'sonda/comparar_resultados');
			}else
			echo $nope;
			break;

			/** 20161228 CTP
             *	Menú : Grupos afectados.
            */
            //Sonda actual.
            case 'periodo_anterior':
            $ent = Empresa::withID($_SESSION['Empresa']['id']);
			if($ent->clima_laboral){
				$_SESSION['sondas'] = '';
				$_SESSION['filtros'] = '';
				$_SESSION['args'] = '';
				$_SESSION['rendimiento'] = '';
				$dispatch = new SondaController('Sonda','sonda','otros_promedios_bajos');
				$dispatch->otros_promedios_bajos();
				header("Location: " . BASEURL.'sonda/otros_promedios_bajos');
			}else
			echo $nope;
            break;
            
            //******************************************

			default:
			header("Location: " . BASEURL.$_SESSION['link']);
			break;
		}
	}


















	function view($id_p=null){
		$this->set('title','Alto Desempe&ntilde;o | Vista Personal');
		$this->set('backlink','user/home');
		Util::sessionStart();
		if(isset($id_p))
			$id = $id_p;
		else
			$id = $_SESSION['USER-AD']['id_personal'];
		$b = $this->User->query('SELECT * FROM `personal` WHERE `id`=' . $id . '',1);
		$b = reset($b);
		$this->set('img',$this->User->htmlImage_($b['foto'],'img-responsive img-rounded'));
		$this->set('name',$b['nombre_p']);

		$this->set('id',$id);
		/* DATOS DE EMPRESA */
		$dat = $this->User->query('SELECT * FROM `listado_personal_op` WHERE `id`=' . $b['id'] . '',1);
		$dat = $dat['Listado_personal_op'];

		$this->set('d_emp',$dat);
		$this->set('cargo',$dat['cargo']);
		$this->set('local',$dat['local']);
		$this->set('id_area',$dat['id_area']);
		$this->set('area',$dat['area']);
		$this->set('tcont',$dat['tcont']);
		$this->set('g_sal',$dat['salario']);

		$cond = (unserialize($dat['id_cond']) !== false) ? unserialize($dat['id_cond']) : 0 ;
		$this->set('cond',$cond);

		$this->set('pid',$dat['id_superior']);
		$this->set('pid_nombre',$dat['pid_nombre']);
		$this->set('pid_cargo',$dat['pid_cargo']);

		/* DATOS PERSONALES */
		$d_per = $this->User->query_('SELECT * FROM `personal_datos` WHERE `id_persona`='. $id .'');
		$test = Personal_dato::loadFromId($id);
		$this->set('d_per',$test);
		/* ESTADO CIVIL */
		$d_civ = $this->User->query('SELECT `estado_civil`, `n_conyugue`, `fn_conyugue`, `f_matrimonio`, `t_hijos` FROM `personal_datos_familiar` WHERE `id_personal`='. $id .'');
		if ($d_civ){
			$d_civ = $d_civ[0];
			$d = @reset($d_civ);
			$d_ = @reset($d);
			switch ($d_) {
				case 1:
				$this->set('ecv',"Soltero");
				break;
				case 2:
				$this->set('ecv',"Casado");
				break;
				case 3:
				$this->set('ecv',"Viudo");
				break;
				case 4:
				$this->set('ecv',"Divorciado");
				break;
				case 5:
				$this->set('ecv',"Union Libre");
				break;
			}
			$this->set('n_cony',@next($d));
			$this->set('f_nac_con',@next($d));
			$this->set('f_mat',@next($d));
			$this->set('hij',@next($d));
		}else{
			$this->set('hij',false);
		}
		$this->set('d_civ',$d_civ);

		$this->set('d_hij',$this->User->query('SELECT `nombre_hijo`, `fecha_nacimiento` FROM `personal_datos_hijos` WHERE `id_personal`='. $id .''));	

		/* EDUCACION FORMAL */
		$this->set('ed_for',Personal_ed_formal::select_all($id));
		/* CURSOS */
		$this->set('cur',Personal_cursos::select_all($id));
		/* CURSOS INTERNOS */
		$this->set('cur_int',Personal_cursos_internos::select_all($id));
		/* HISTORIA LABORAL */
		$this->set('hlab',Personal_hlaboral::select_all($id));
		/* IDIOMA */
		$idiom = new personal_idioma();
		$idiom=$idiom->select_all($id_p);
		$this->set('idiom',$idiom);
		/* PREMIO */
		$premio = new personal_premio();
		$premio=$premio->select_all($id_p);
		$this->set('premio',$premio);

		/* GOOGLE MAPS */
		$gmap = $this->User->query_('SELECT * FROM `personal_ugmaps` WHERE  `id_personal`='. $id .'',1);

		@$this->set('img_casa',$this->User->htmlImage_($gmap['foto'],'img-rounded img-responsive'));
		$this->set('gmap',$gmap);
		unset($gmap);
	}

	function get_id($cod){
		$res = $this->User->query('SELECT `id_personal` FROM `multifuente_evaluado` WHERE `cod_evaluado`="'.$cod.'"',1);
		$res = @reset($res);
		$res = @reset($res);
		return $res;
	}

	function get_name($cod){
		$res = $this->User->query('SELECT `nombre_p` FROM `personal` WHERE `id`="'.self::get_id($cod).'"',1);
		$res = @reset($res);
		$res = @reset($res);
		return $res;
	}

	function get_email($cod){
		$res = $this->User->query('SELECT `email` FROM `personal_datos` WHERE `id`="'.self::get_id($cod).'"',1);
		$res = @reset($res);
		$res = @reset($res);
		return $res;
	}

	function get_tema($cod){
		$res = $this->User->query('SELECT tema,descripcion FROM `temas_360` WHERE `cod_tema`="'.$cod.'"',1);
		$res = @reset($res);
		return $res;
	}

	function get_preg($cod){
		$res = $this->User->query('SELECT pregunta FROM `preguntas_360` WHERE `cod_pregunta`="'.$cod.'"',1);
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

	function s_new(){

	}

	function esGerente(){
		Util::sessionStart();
		$res=$this->User->query('SELECT * FROM personal WHERE id IN(SELECT DISTINCT id_evaluado FROM multifuente_evaluadores WHERE relacion=0 AND id_personal='.$_SESSION['USER-AD']['id_personal'].')');
		if($res)
			return true;
		return false;
	}

	function getHeaderInfo($rol){
		$res = $this->User->query('SELECT navbar,link FROM navbar WHERE user_rol='.$rol.'',1);
		return $res['Navbar'];
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