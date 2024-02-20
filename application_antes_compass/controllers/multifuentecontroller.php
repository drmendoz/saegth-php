<?php

class MultifuenteController extends Controller {

	protected $link;
	
	function __construct($model, $controller, $action, $type = 0, $full = false,$render=false) {

		parent::__construct($model, $controller, $action, $type, $full,$render);

		$this->link = $this->Multifuente->getDBHandle();
	}
	
	function home(){
		$this->haySession();
		$this->set('backlink','admin/home');
	}
	
	function evaluado(){
		$this->haySession();
		$this->set('backlink','multifuente/home');
		$arr = $this->Multifuente->query('SELECT * FROM `empresa` WHERE 1 ORDER BY `nombre` ASC');
		$this->set('empresas',$arr);
	}
	
	function crear(){
		$this->haySession();
		$this->set('backlink','multifuente/home');
		$arr = $this->Multifuente->query('SELECT * FROM `empresa` WHERE 1 ORDER BY `nombre` ASC');
		$this->set('empresas',$arr);
		if(isset($_POST['button'])){
			$filas = $this->Multifuente->query('SELECT COUNT(id) FROM `multifuente_test`',1);
			$filas=@reset($filas);
			$filas=@reset($filas);
			$cod_test = 'test'.$filas.date('y-m-d');
			$_emp = explode(';', $_POST["empresa"]);
			$id_e=$_emp[0];  
			$nombre =$_emp[1].' / '.$_POST["nombre"];
			$desc =$_POST["descrip"];
			$_SESSION['test']['cod_test'] = $cod_test;
			$_SESSION['test']['id_e'] = $id_e;
			$_SESSION['test']['nombre'] = $nombre;
			$_SESSION['test']['desc'] = $desc;
			$this->_template = new Template('Multifuente','crear_temas');
			$this->crear_temas();
			header("Location: " . BASEURL.'multifuente/crear_temas');
		}
	}
	
	function eliminar(){
		$this->hayPermiso();
		$this->set('backlink','multifuente/home');
		$empresa = "";
		if(isset($_SESSION['Empresa']['id']))
			$empresa = "WHERE id_empresa=".$_SESSION['Empresa']['id'];
		if(isset($_POST['button'])){
			foreach ($_POST['id_per'] as $a => $b) {
				$b = explode(",",$b);
				$id_p = $b[0];
				$c_t = $b[1]; 
				$this->Multifuente->query('DELETE FROM `multifuente_evaluado` WHERE id_personal='.$id_p.' AND cod_evaluado="'.$c_t.'"');
				$this->Multifuente->query('DELETE FROM `multifuente_evaluadores` WHERE cod_evaluado="'.$c_t.'" AND id_evaluado='.$id_p.'');
				$this->set('msg','Evaluado eliminado correctamente');
				$this->_template = new Template('Multifuente','eliminar');
				$this->eliminar();
				header("Location: " . BASEURL.'multifuente/eliminar');
			}
		}else{
			$arr = $this->Multifuente->query('SELECT id_personal,cod_test,cod_evaluado FROM `multifuente_evaluado` '.$empresa.' ORDER BY `fecha` DESC');
			$this->set('results',$arr);
			$this->set('msg','No hay personal ingresado');
		}
	}

	function crear_temas(){
		$this->haySession();
		
		$arr = $this->Multifuente->query('SELECT cod_tema, tema FROM temas_360 Order by tema ASC');
		$this->set('temas',$arr);
		
		if(isset($_POST['tema'])){
			$_SESSION['test']['tema'] = $_POST['tema'];

			$this->_template = new Template('Multifuente','crear_preguntas');
			$this->crear_preguntas();
			header("Location: " . BASEURL.'multifuente/crear_preguntas');
		}

	}

	function crear_preguntas(){
		$this->haySession();
		$this->set('backlink','multifuente/crear_temas');
		$arr = $this->Multifuente->query('SELECT cod_pregunta, pregunta FROM preguntas_360 Where cod_tema = "'.$_SESSION['test']['tema'].'" Order by id ASC');
		$this->set('preguntas',$arr);
		if(isset($_POST['chk'])){
			foreach ($_POST['chk'] as $a => $b) {
				$s = explode(',', $b);
				$cd=$s[0];  
				$c =$s[1];
				$preg = $_POST['pregunta'][$c];
				$this->Multifuente->query("INSERT into multifuente_test (id_empresa,cod_tema,cod_pregunta,pregunta,cod_test,nombre_test,descripcion) VALUES ('".$_SESSION['test']['id_e']."','".$_SESSION['test']['tema']."','".$cd."','".$preg."','".$_SESSION['test']['cod_test']."','".$_SESSION['test']['nombre']."','".$_SESSION['test']['desc']."')");
				echo "INSERT into multifuente_test (id_empresa,cod_tema,cod_pregunta,pregunta,cod_test,nombre_test,descripcion) VALUES ('".$_SESSION['test']['id_e']."','".$_SESSION['test']['tema']."','".$cd."','".$preg."','".$_SESSION['test']['cod_test']."','".$_SESSION['test']['nombre']."','".$_SESSION['test']['desc']."')";
				echo "<br>";
				echo mysqli_insert_id($this->link);
				echo "<br>";
			}

			$this->_template = new Template('Multifuente','crear_temas');
			$this->crear_temas();
			header("Location: " . BASEURL.'multifuente/crear_temas');
		}
	}

	function asignar(){
		$this->haySession();
		$this->set('backlink','multifuente/home');
		$arr = $this->Multifuente->query('SELECT * FROM empresa Order by nombre ASC');
		$this->set('empresas',$arr);

		
		if(isset($_POST['button'])){
			$_SESSION['multifuente']['id'] = $_POST['id_per'];
			$_SESSION['multifuente']['id_e'] = $_POST['selectEmpresa'];

			$this->_template = new Template('Multifuente','asignar_relacion');
			$this->asignar_relacion();
			header("Location: " . BASEURL.'multifuente/asignar_relacion');

		}
	}

	function ver_evaluados(){
		$this->haySession();
		$this->set('backlink','multifuente/home');
		$arr = $this->Multifuente->query('SELECT * FROM empresa Order by nombre ASC');
		$this->set('empresas',$arr);

		
		if(isset($_POST['button'])){
			$_SESSION['multifuente']['id'] = $_POST['id_per'];
			$_SESSION['multifuente']['id_e'] = $_POST['selectEmpresa'];

			$this->_template = new Template('Multifuente','asignar_relacion');
			$this->asignar_relacion();
			header("Location: " . BASEURL.'multifuente/asignar_relacion');

		}
	}

	function asignar_test(){
		$this->haySession();
		$this->set('backlink','multifuente/asignar');

		if(isset($_POST['button'])){
			foreach ($_POST['id_per'] as $a => $c) {
				$fecha=date("Y-m-d");

				$lp=new listado_personal_op();
				$lp->select($c);
				$email = $lp->getEmail();
				$nombre_evaluado = $nombre = $lp->getNombre_();

				$arr = $this->Multifuente->query_('SELECT user_name,password FROM users WHERE id_personal='.$c.'',1);
				echo mysqli_error($this->link);
				$usr=$arr['user_name'];

				$subject="Alto Desempeño - Evaluación multifuentes";
				
				$filas = $this->Multifuente->query_('SELECT COUNT(id) as count FROM `multifuente_evaluado`',1);
				$filas=$filas['count'];
				$cod_evaluado = $usr.'_'.$filas;

				$msg = "<p>Estimado(a)"." ".$nombre.",</p><p>Usted ha sido seleccionado(a) para participar en el programa de 360 grados de retroalimentación de Alto Desempeño. El propósito de esta evaluación es darle retroalimentación a fin de que pueda mejorar sus competencias organizacionales, por esta razón le solicitamos  que conteste el cuestionario adjunto de manera sincera y objetiva.<br> </p>
				<p>Podrá ver esta y todas las evaluaciones pendientes siguendo el link en el menú lateral bajo Compass 360 > Evaluaciones</p><p> Recuerde ingresar su usuario y contraseña previamente enviados. Si por alguna razón debe interrumpir la respuesta al cuestionario, por favor asegúrese de hacer click en el Botón “Grabar y Continuar luego” que está al final del cuestionario.  Usted podrá entrar y salir del cuestionario tantas veces lo requiera utilizando este mismo link (contenido en esta comunicación) sin embargo, le recomendamos enfáticamente que trate de contestar de una sola vez el cuestionario completo.</p>


				<p>Le solicitamos también que conteste este cuestionario como màximo hasta el ".$_POST['f_max'].". A fin de facilitarle la comprensión del uso y sobretodo de los beneficios de esta herramienta le invitamos a ver una corta presentación a través de  <a href = 'https://www.youtube.com/watch?v=lhCfx8RbWG4'>Video</a> <br></p>


				<br>Desde ya le agradecemos su colaboración. <br><br>";

				Util::sendMail($email,$subject,$msg);

				$this->Multifuente->query('INSERT INTO `multifuente_evaluado`(`id_personal`, `cod_evaluado`, `cod_test`, `fecha`, `fecha_max`, `id_empresa`) VALUES ('.$c.',"'.$cod_evaluado.'","'.$_POST['test'].'","'.$fecha.'","'.$_POST['f_max'].'",'.$_SESSION['Empresa']['id'].')');
				//echo mysqli_error($this->link);
				$subject="Alto Desempeño - Evaluación multifuentes de ". $nombre ."";
				$evaluadores=$this->Multifuente->query_('SELECT id_personal,relacion FROM multifuente_relacion WHERE id_evaluado='.$c.' AND aprovado=3');
				foreach ($evaluadores as $key => $b) {
					$rel = $b['relacion'];
					$b=$b['id_personal'];
					$arr = $this->Multifuente->query('SELECT email FROM personal_datos WHERE id_persona='.$b.'',1);
					
					$lp_evaluador=new listado_personal_op();
					$lp_evaluador->select($b);
					$email = $lp_evaluador->getEmail();
					$nombre = $lp_evaluador->getNombre_();				
					
					$this->Multifuente->query('INSERT INTO `multifuente_evaluadores`(`id_personal`,`id_evaluado`, `cod_evaluado`, `cod_test`, `fecha`, `fecha_max`, `id_empresa`, `relacion`) VALUES ('.$b.','.$c.',"'.$cod_evaluado.'","'.$_POST['test'].'","'.$fecha.'","'.$_POST['f_max'].'",'.$_SESSION['Empresa']['id'].','.$rel.')');
					$msg = "<p>Estimado(a)"." ".$nombre.",</p><p>Usted ha sido seleccionado(a) para proporcionar retroalimentación sobre ciertas competencias de ".$nombre_evaluado.". El propósito de esta evaluación es dar retroalimentación a ".$nombre_evaluado." a fin de que pueda mejorar sus competencias organizacionales; por esta razón le solicitamos a usted que sea muy sincero(a) y lo más objetivo posible al momento de responder el cuestionario preparado para este fin. Le garantizamos absoluto anonimato y confidencialidad en sus respuestas.<br></p> 

					<p>Podrá ver esta y todas las evaluaciones pendientes siguendo el link en el menú lateral bajo Compass 360 > Evaluaciones</p><p>Recuerde ingresar su usuario y contraseña previamente enviados. Si por alguna razón debe interrumpir la respuesta al cuestionario, por favor asegúrese de hacer click en el Botón “Grabar y Continuar luego” que está al final del cuestionario.  Usted podrá entrar y salir del cuestionario tantas veces lo requiera utilizando este mismo link (contenido en esta comunicación) sin embargo, le recomendamos enfáticamente que trate de contestar de una sola vez el cuestionario completo.<br></p>

					<br><p>Le solicitamos también que conteste este cuestionario como màximo hasta el ".$_POST['f_max'].". A fin de facilitarle la comprensión del uso y sobretodo de los beneficios de esta herramienta le invitamos a ver una corta presentación a través de  <a href = 'https://www.youtube.com/watch?v=lhCfx8RbWG4'>Video</a> <br><br></p>


					Desde ya le agradecemos su colaboración.  <p><p>";
					Util::sendMail($email,$subject,$msg);
				}
			}
			header("Location: " . BASEURL.'multifuente/home');
		}else{
			$test = $this->Multifuente->query('SELECT DISTINCT `nombre_test` ,  `cod_test`  FROM multifuente_test WHERE id_empresa='.$_SESSION['Empresa']['id'].'');
			$this->set('test',$test);
			$sql = 'SELECT p.id, p.nombre,p.cargo,p.area,p.foto, ifnull(me.cod_test,"No ha sido asignado") as codigo,ifnull(me.fecha,"-") as fecha_e FROM listado_personal_op as p 
			JOIN evaluadores_aprovados as ea
			JOIN personal_test as pt 
			ON p.id=ea.id 
			LEFT JOIN multifuente_evaluado as me
			ON p.id=me.id_personal
			WHERE ea.id_empresa='.$_SESSION['Empresa']['id'].' AND pt.`compass_360`=1 AND pt.id_personal=ea.id;';
				// echo $sql;
			$evaluado = $this->Multifuente->query_($sql);
			$this->set('evaluado',$evaluado);
		}
	}

	function ver(){
		$this->haySession();
		$this->set('backlink','multifuente/home');
		$arr = $this->Multifuente->query('SELECT distinct cod_test, nombre_test FROM multifuente_test Order by nombre_test ASC');
		$this->set('test',$arr);

		
		if(isset($_POST['button'])){
			

			$filas = $this->Multifuente->query('SELECT COUNT(id) FROM `multifuente_test`',1);
			$filas=@reset($filas);
			$filas=@reset($filas);

			$cod_test = 'test'.$filas.date('y-m-d');
			$_emp = explode(';', $_POST["empresa"]);
			$id_e=$_emp[0];  
			$nombre =$_emp[1].' / '.$_POST["nombre"];
			
			$desc =$_POST["descrip"];

			foreach ($_POST['chk'] as $a => $b) {
				$s = explode(',', $b);
				$cd=$s[0];  
				$c =$s[1];
				$cod_tema=$s[2];
				$preg = $_POST['pregunta'][$c];
				$this->Multifuente->query("INSERT into multifuente_test (id_empresa,cod_tema,cod_pregunta,pregunta,cod_test,nombre_test,descripcion) VALUES ('".$id_e."','".$cod_tema."','".$cd."','".$preg."','".$cod_test."','".$nombre."','".$desc."')");
			}
			$_SESSION['mensaje'] = 'Test '.$nombre.' clonado';
			$this->_template = new Template('Multifuente','home');
			$this->home();
			header("Location: " . BASEURL.'multifuente/home');
		}

	}

	function temas_crear(){
		$this->haySession();
		if(isset($_POST['guardar_datos'])){
			foreach ($_POST['temas'] as $a => $b) {
				$filas = $this->Multifuente->query('SELECT COUNT(id) FROM `temas_360`',1);
				$filas=@reset($filas);
				$filas=@reset($filas);
				$user = substr(md5(rand()),0,6);

				$codigo_tema = 'tema_'.$filas.$user;
				$this->Multifuente->query("INSERT into temas_360 (tema,cod_tema,descripcion) VALUES ('".$b."','".$codigo_tema."','".$_POST["descripcion"][$a]."')");
			}
			if($a<1){
				$_SESSION['mensaje'] = 'Se ha creado '.($a+1).' tema';
			}else{
				$_SESSION['mensaje'] = 'Se han creado '.($a+1).' temas';
			}

			$this->_template = new Template('Multifuente','home');
			$this->home();
			header("Location: " . BASEURL.'multifuente/home');
		}
	}

	function preguntas_crear(){
		$this->haySession();
		$arr = $this->Multifuente->query('SELECT distinct cod_tema, tema FROM temas_360 Order by tema ASC');

		$this->set('temas',$arr);
		if(isset($_POST['guardar_datos'])){
			foreach ($_POST['preg'] as $a => $b) {
				$filas = $this->Multifuente->query('SELECT COUNT(id) FROM `preguntas_360`',1);
				$filas=@reset($filas);
				$filas=@reset($filas);
				$user = substr(md5(rand()),0,6);
				$cod_tema=$_POST['tema'];
				$codigo_pregunta = 'pregunta_'.$filas.$user;
				if(isset($_POST[$a])){
					$query="INSERT into preguntas_360 (cod_pregunta,pregunta,cod_tema,negativo) VALUES ('".$codigo_pregunta."','".$b."','".$cod_tema."','si')";
				}else{
					$query="INSERT into preguntas_360 (cod_pregunta,pregunta,cod_tema) VALUES ('".$codigo_pregunta."','".$b."','".$cod_tema."')";
				}
				$this->Multifuente->query($query);
			}
			if($a<1){
				$_SESSION['mensaje'] = 'Se ha creado '.($a+1).' pregunta';
			}else{
				$_SESSION['mensaje'] = 'Se han creado '.($a+1).' preguntas';
			}

			$this->_template = new Template('Multifuente','home');
			$this->home();
			header("Location: " . BASEURL.'multifuente/home');
		}
	}



	/*




	*/

	function resultados($id=null,$test=null,$eval=null){
		Util::sessionStart();	
		$this->set('title','Alto Desempe&ntilde;o');
		if(func_num_args()==1){
			if(is_array($id)){
				$args = $id;
				$id= $args[0];
			}
		}
		if(!isset($id)){
			$id=$_SESSION['Personal']['id'];
			$this->set('backlink',false);
		}else{
			$this->set('backlink','multifuente/home');

		}
		$res = $this->get_Eval($id,$test,$eval);
		if(isset($res)){
			$temas=array();
			$cod_test = $_SESSION['evaluado']['test'] = $res['cod_test'];
			$cod_evaluado = $_SESSION['evaluado']['id'] = $res['cod_evaluado'];
			$resuelto = $res['resuelto'];
			$res = $this->Multifuente->query_("SELECT DISTINCT cod_tema from multifuente_respuestas where cod_test ='".$cod_test."' and cod_evaluado = '".$cod_evaluado."' order by cod_tema asc");
			foreach ($res as $a => $b) {
				array_push($temas, $b['cod_tema']);
			}
			$this->set('temas',$temas);
			$this->set('id',$id);
			$this->set('cod_evaluado',$cod_evaluado);
			// $comentarios = $this->Multifuente->query('SELECT DISTINCT  `fortalezas` ,  `debilidades` ,  `comentarios` FROM  `multifuente_respuestas` WHERE  `cod_evaluado` =  "'.$cod_evaluado.'"');
			// $this->set('comentarios',$comentarios);
		}else{
			//echo "<script>alert('Usted no ha sido asignado a esta evaluación.');window.history.back();</script>";
		}
		$d_emp = $this->Multifuente->get_empdat($id,$cod_evaluado);
		$this->set('nombre',$d_emp[0]);
		$this->set('cargo',$d_emp[1]);
		$this->set('area',$d_emp[2]);
		$this->set('superior',$d_emp[3]);
		$this->set('fecha',$d_emp[4]);
	}

	function tema($id,$cod_tema=null){
		Util::sessionStart();
		if(func_num_args()==1){
			$args = $id;
			$id= $args[0];
			$cod_tema = $args[1];
		}
		$this->set('backlink','multifuente/resultados/'.$id);
		$tema = $this->Multifuente->get_tema($cod_tema);
		$cod_test = $_SESSION['evaluado']['test'];
		$cod_evaluado = $_SESSION['evaluado']['id'];
		$d_emp = $this->Multifuente->get_empdat($id,$cod_evaluado);
		$this->set('nombre',$d_emp[0]);
		$this->set('cargo',$d_emp[1]);
		$this->set('area',$d_emp[2]);
		$this->set('superior',$d_emp[3]);
		$this->set('fecha',$d_emp[4]);
		if($tema){
			$preg=array();
			$_SESSION['evaluado']['tema'] = $cod_tema;
			$cod_preguntas =  $this->Multifuente->query("Select DISTINCT cod_pregunta from multifuente_respuestas where cod_tema = '".$cod_tema."' AND cod_test ='".$cod_test."' and cod_evaluado = '".$cod_evaluado."'");
			foreach ($cod_preguntas as $c => $d) {
				$d = reset($d);
				array_push($preg, $d['cod_pregunta']);
			}
			$name = $this->Multifuente->get_pname($id);
			$this->set('nombre',$name);
			$this->set('cod_evaluado',$cod_evaluado);
			$this->set('pr',$tema);
			$this->set('preg',$preg);
			$this->set('id',$id);
			$this->set('cod_tema',$cod_tema);
		}	
	}

	function pregunta($id,$cod_preg=null){
		Util::sessionStart();	
		if(func_num_args()==1){
			$args = $id;
			$id= $args[0];
			$cod_preg = $args[1];
		}
		$this->set('backlink','multifuente/tema/'.$id.'/'.$_SESSION['evaluado']['tema']);
		$cod_evaluado = $_SESSION['evaluado']['id'];
		$d_emp = $this->Multifuente->get_empdat($id,$cod_evaluado);
		$this->set('nombre',$d_emp[0]);
		$this->set('cargo',$d_emp[1]);
		$this->set('area',$d_emp[2]);
		$this->set('superior',$d_emp[3]);
		$this->set('fecha',$d_emp[4]);
		$cod_tema = $_SESSION['evaluado']['tema'];
		$cod_test = $_SESSION['evaluado']['test'];
		$name = $this->Multifuente->get_pname($id);
		$this->set('nombre',$name);
		$this->set('cod_tema',$cod_tema);
		$this->set('cod',$cod_preg);
		$this->set('id',$id);
		$this->set('cod_evaluado',$cod_evaluado);
	}

	function comentarios($id=null,$test=null,$eval=null){
		Util::sessionStart();		
		if(!isset($id)){
			$id=$_SESSION['Personal']['id'];
			$res = $this->get_Eval($id,$test,$eval);
			$res = reset($res);
			$cod_test = $_SESSION['evaluado']['test'] = $res['cod_test'];
			$cod_evaluado = $_SESSION['evaluado']['id'] = $res['cod_evaluado'];
		}
		$this->set('backlink','multifuente/resultados/'.$id);
		$cod_evaluado = $_SESSION['evaluado']['id'];
		$d_emp = $this->Multifuente->get_empdat($id,$cod_evaluado);
		$this->set('nombre',$d_emp[0]);
		$this->set('cargo',$d_emp[1]);
		$this->set('area',$d_emp[2]);
		$this->set('superior',$d_emp[3]);
		$this->set('fecha',$d_emp[4]);
		$comentarios = $this->Multifuente->query('SELECT DISTINCT  `fortalezas` ,  `debilidades` ,  `comentarios` FROM  `multifuente_respuestas` WHERE  `cod_evaluado` =  "'.$cod_evaluado.'"');
		$this->set('comentarios',$comentarios);
	}

	function oportunidades($id=null,$test=null,$eval=null){
		Util::sessionStart();		
		if(!isset($id)){
			$id=$_SESSION['Personal']['id'];
			$res = $this->get_Eval($id,$test,$eval);
			$res = reset($res);
			$cod_test = $_SESSION['evaluado']['test'] = $res['cod_test'];
			$cod_evaluado = $_SESSION['evaluado']['id'] = $res['cod_evaluado'];
		}
		$this->set('backlink','multifuente/resultados/'.$id);
		$cod_evaluado = $_SESSION['evaluado']['id'];
		$d_emp = $this->Multifuente->get_empdat($id,$cod_evaluado);
		$this->set('nombre',$d_emp[0]);
		$this->set('cargo',$d_emp[1]);
		$this->set('area',$d_emp[2]);
		$this->set('superior',$d_emp[3]);
		$this->set('fecha',$d_emp[4]);
		$cod_test = $_SESSION['evaluado']['test'];

		$res_rango = $this->Multifuente->query('Select distinct rango from multifuente_respuestas where cod_evaluado ="'.$cod_evaluado.'" order by rango');
		$tot_rango = sizeof($res_rango);
		if($res_rango){
			foreach ($res_rango as $c => $d) {
				$d=reset($d);
				$array_nombres[] = $d['rango'];
			}
			$preguntas = $this->Multifuente->query('SELECT DISTINCT a.cod_pregunta
				FROM `multifuente_respuestas` as a
				INNER JOIN `preguntas_360` as b
				ON a.cod_pregunta = b.cod_pregunta
				WHERE a.cod_evaluado="'.$cod_evaluado.'"');
			$fortalezas=array();
			foreach ($preguntas as $a => $b) {
				$b = reset($b);
				$b = reset($b);
				foreach ($array_nombres as $c => $rango) {
					$res_fortaleza = $this->Multifuente->getAvg_preg_rang($b,$cod_evaluado,$rango);
					$fortalezas[$rango]['respuesta'][$a] = $res_fortaleza; 
					$fortalezas[$rango]['cod_preguna'][$a] = $b; 
				}
			}
			foreach ($array_nombres as $c => $rango) {
				asort($fortalezas[$rango]['respuesta']);
				$count=0;
				foreach ($fortalezas[$rango]['respuesta'] as $key => $value) {
					if ($value > 0) {
						$final[$rango][$count] = array('preg' => $fortalezas[$rango]['cod_preguna'][$key],'val' => $value);
						if($count==9)
							break;
						$count++;
					}
				}
			}	
			$this->set('final',$final);
			$this->set('res_rango',$res_rango);
			$this->set('tot_rango',$tot_rango);
			$this->set('array_nombres',$array_nombres);
		}
	}

	function definir_plan($id=null){
		Util::sessionStart();	
		if(!isset($id)){
			$id=$_SESSION['Personal']['id'];
		}
		$this->set('backlink','multifuente/oportunidades'.DS.$id);
		$cod_test = $_SESSION['evaluado']['test'];
		$cod_evaluado = $_SESSION['evaluado']['id'];
		if(!isset($_POST['opt_m']) && !isset($_POST['plan'])){
			echo "<script>window.location = '".BASEURL.$_SESSION['link']."';</script>";
		}elseif(isset($_POST['plan'])){
			foreach ($_POST['cod_p'] as $a => $b) {
				$this->Multifuente->query('
					INSERT INTO `multifuente_oportunidades`(`cod_evaluado`, `cod_pregunta`, `accion`,`tipo`, `medicion`, `fecha`) 
					VALUES ("'.$cod_evaluado.'","'.$b.'","'.mysqli_real_escape_string($this->link,$_POST['accion'][$a]).'","'.mysqli_real_escape_string($this->link,$_POST['tipo'][$a]).'","'.mysqli_real_escape_string($this->link,$_POST['medicion'][$a]).'","'.$_POST['fecha'][$a].'")
					ON DUPLICATE KEY UPDATE 
					accion="'.mysqli_real_escape_string($this->link,$_POST['accion'][$a]).'",
					tipo="'.mysqli_real_escape_string($this->link,$_POST['tipo'][$a]).'",
					medicion= "'.mysqli_real_escape_string($this->link,$_POST['medicion'][$a]).'",
					fecha = "'.$_POST['fecha'][$a].'"');
				echo mysqli_error($this->link);
			}
			$this->_template = new Template('Void','render');
			$dispatch = new UserController('User','user','home');
			$dispatch->home('tabs-4');

		}
	}

	function plan($id,$eval=null){
		Util::sessionStart();

		// $id=$_SESSION['Personal']['id'];
		$res = $this->get_Eval($id);
		// $res = reset($res);
		// $this->set('backlink','multifuente/resultados');
		
		$cod_evaluado = $res['cod_evaluado'];
		$d_emp = $this->Multifuente->get_empdat($id,$cod_evaluado);
		$this->set('nombre',$d_emp[0]);
		$this->set('cargo',$d_emp[1]);
		$this->set('area',$d_emp[2]);
		$this->set('superior',$d_emp[3]);
		$this->set('fecha',$d_emp[4]);
		$this->set('id',$id);

		if(isset($_POST['update'])){
			$x=0;
			foreach ($_POST['evaluacion'] as $a => $b) {
				switch ($b) {
					case 0:
					
					if($_POST['uori'][$a]=='update')
						$this->Multifuente->query('UPDATE `multifuente_oportunidades` SET `cod_evaluado`="'.$cod_evaluado.'", `accion`="'.$_POST['accion'][$a].'", `tipo`="'.$_POST['tipo'][$a].'", `medicion`="'.$_POST['medicion'][$a].'", `fecha`="'.$_POST['fecha'][$a].'" WHERE `id`="'.$_POST['id'][$a].'"');
					else{
						$this->Multifuente->query('INSERT INTO `multifuente_oportunidades` (`cod_evaluado`,`accion`,`tipo`,`medicion`,`fecha`,`cod_pregunta`) VALUES("'.$cod_evaluado.'","'.$_POST['accion'][$a].'","'.$_POST['tipo'][$a].'","'.$_POST['medicion'][$a].'","'.$_POST['fecha'][$a].'","'.$_POST['cod_p'][$a].'") ');
						echo mysqli_error($this->link);
					}$x++;
					break;
					case 1:
					$atts = array(
						'id' => $_POST['id'][$a], 
						'id_personal' => $id, 
						'accion' => $_POST['accion'][$a], 
						'tipo' => $_POST['tipo'][$a], 
						'medicion' => $_POST['medicion'][$a], 
						'fecha' => $_POST['fecha'][$a], 
						);
					$s_op = new Scorer_oportunidad($atts);
					if($_POST['uori'][$a]=='update')
						$s_op->update();
					else{
						$s_op->getObj();
						$s_op->insert();
						$s_op->update();
					}
					break;
				}
				// echo mysqli_error($this->link);
			}
		}

		$plans=0;
		$plan = $this->Multifuente->query('SELECT * FROM `multifuente_oportunidades` as mo JOIN `multifuente_evaluado` as me ON mo.cod_evaluado=me.cod_evaluado WHERE me.id_personal='.$id.' ');
		if($plan){
			$this->set('plan',$plan);
			$plans++;
		}
		$plan = new Scorer_oportunidad(array('id_personal' => $id));
		$scorer_plan = $plan->selectAll();
		if($scorer_plan){
			$this->set('scorer_plan',$scorer_plan);
			$plans++;
		}
		$this->set('plans',$plans);

	}	

	function fortalezas($id=null,$test=null,$eval=null){
		Util::sessionStart();	
		if(!isset($id)){
			$id=$_SESSION['Personal']['id'];
			$res = $this->get_Eval($id,$test,$eval);
			$res = reset($res);
			$cod_test = $_SESSION['evaluado']['test'] = $res['cod_test'];
			$cod_evaluado = $_SESSION['evaluado']['id'] = $res['cod_evaluado'];
		}
		$this->set('backlink','user/multifuente_resultados/'.$id);
	    //$this->set('id',$id);
		if(!isset($test) && !isset($eval)){
			$cod_test = $_SESSION['evaluado']['test'];
			$cod_evaluado = $_SESSION['evaluado']['id'];
		}
		$d_emp = $this->Multifuente->get_empdat($id,$cod_evaluado);
		$this->set('nombre',$d_emp[0]);
		$this->set('cargo',$d_emp[1]);
		$this->set('area',$d_emp[2]);
		$this->set('superior',$d_emp[3]);
		$this->set('fecha',$d_emp[4]);
		//LIMIT 1
		$res_rango = $this->Multifuente->query('Select distinct rango from multifuente_respuestas where cod_evaluado ="'.$cod_evaluado.'" order by rango');
		$tot_rango = sizeof($res_rango);
		if($res_rango){
			foreach ($res_rango as $c => $d) {
				$d=reset($d);
				$array_nombres[] = $d['rango'];
			}
			$preguntas = $this->Multifuente->query('SELECT DISTINCT a.cod_pregunta
				FROM `multifuente_respuestas` as a
				INNER JOIN `preguntas_360` as b
				ON a.cod_pregunta = b.cod_pregunta
				WHERE a.cod_evaluado="'.$cod_evaluado.'" ');
			$fortalezas=array();
			foreach ($preguntas as $a => $b) {
				$b = reset($b);
				$b = reset($b);
				foreach ($array_nombres as $c => $rango) {
					$res_fortaleza = $this->Multifuente->getAvg_preg_rang($b,$cod_evaluado,$rango);
					$fortalezas[$rango]['respuesta'][$a] = $res_fortaleza; 
					$fortalezas[$rango]['cod_preguna'][$a] = $b; 
				}
			}
			foreach ($array_nombres as $c => $rango) {
				arsort($fortalezas[$rango]['respuesta']);
				$count=0;
				foreach ($fortalezas[$rango]['respuesta'] as $key => $value) {
					$final[$rango][$count] = array('preg' => $fortalezas[$rango]['cod_preguna'][$key],'val' => $value);
					if($count==9)
						break;
					$count++;
				}
			}	
			$this->set('final',$final);
			$this->set('res_rango',$res_rango);
			$this->set('tot_rango',$tot_rango);
			$this->set('array_nombres',$array_nombres);
		}
	}

	function gerente(){
		Util::sessionStart();
		$this->set('title','Alto Desempe&ntilde;o');
		$this->set('backlink','user/home');
		$res=$this->Multifuente->query('SELECT * FROM personal WHERE id IN(SELECT DISTINCT id_evaluado FROM multifuente_evaluadores WHERE relacion=0 AND id_personal='.$_SESSION['USER-AD']['id_personal'].')');
		$this->set('evaluados',$res);
	}

	function plan_de_accion(){
		Util::sessionStart();
		$this->set('title','Alto Desempe&ntilde;o');
		if($_SESSION['USER-AD']['user_rol']<=1){
			$query='SELECT lp.nombre, lp.cargo, lp.area, lp.pid_nombre, mo.cod_pregunta, mo.accion, mo.tipo, mo.medicion, me.fecha FROM multifuente_oportunidades mo JOIN multifuente_evaluado me ON mo.cod_evaluado=me.cod_evaluado join listado_personal_op lp ON me.id_personal=lp.id WHERE me.id_empresa='.$_SESSION['USER-AD']['id_empresa'].'';
			$result=$this->Multifuente->query_($query);
		}else{
			$query='SELECT * FROM `multifuente_oportunidades` mo JOIN multifuente_evaluado me ON mo.cod_evaluado=me.cod_evaluado JOIN listado_personal_op lp ON me.id_personal = lp.id WHERE lp.id_superior='.$_SESSION['USER-AD']['id_personal'].'';
			$result=$this->Multifuente->query_($query);
		}
		$this->set('evaluados',$result);
	}

	function resultados_evaluados(){
		$this->haySession();
		$this->set('title','Alto Desempe&ntilde;o');
		$this->set('backlink','multifuente/home');
		$this->set('custom_text','Resultados por evaluados');

		if($_SESSION['USER-AD']['user_rol']<=1){
			$query='SELECT * FROM listado_personal_op WHERE activo=1 AND id IN(SELECT DISTINCT id_personal FROM multifuente_evaluado WHERE id_empresa='.$_SESSION['Empresa']['id'].')';
			$result=$this->Multifuente->query($query);
			$this->set('evaluados',$result);
		}else{
			$query='SELECT lpo.id, lpo.nombre, lpo.foto, lpo.cargo, lpo.area FROM listado_personal_op lpo JOIN multifuente_evaluado me ON me.id_personal = lpo.id WHERE activo=1 AND lpo.id_superior = '.$_SESSION['USER-AD']['id_personal'].'';
			$result=$this->Multifuente->query($query);
			$this->set('evaluados',$result);
		}
	}

	function resultados_departamentos(){
		$this->hayEmpresa();
		$this->set('title','Alto Desempe&ntilde;o');
		$this->set('backlink','multifuente/home');
		$this->set('custom_text','Resultados por departamentos');

		$res=$this->Multifuente->query_('SELECT ea.id, ea.nombre, ( SELECT COUNT(`id_personal`) AS total FROM `multifuente_evaluado` WHERE `id_personal` IN ( SELECT id_personal FROM personal_empresa WHERE id_area = ea.id )) as cant FROM empresa_area ea WHERE `id_empresa` ='.$_SESSION["Empresa"]["id"].'');
		$this->set('departamento',$res);
	}

	function resultados_departamento($id){
		$this->hayEmpresa();
		$this->set('title','Alto Desempe&ntilde;o');
		$this->set('backlink','multifuente/resultados_departamentos');		
		$this->set('custom_text','Resultados por departamento');

		$this->set('id',$id);
		$res=$this->Multifuente->query('SELECT * FROM listado_personal_op lpo JOIN multifuente_evaluado me ON me.id_personal = lpo.id WHERE id_area ='.$id.'');
		$this->set('evaluados',$res);
	}

	function estado_relacion(){
		$this->hayPermisoAdmin();
	}


	function estatus_evaluados(){
		$this->hayEmpresa();
		$this->set('title','Alto Desempe&ntilde;o');
		$this->set('backlink','multifuente/home');	
		$this->set('custom_text','Estatus por evaluados');
		if(isset($_POST['button'])){
			foreach ($_POST['id'] as $a => $id) {
				$nombre_evaluado = $this->Multifuente->get_pname($id);
				// $evaluadores=$this->Multifuente->query('SELECT `id_personal`,`fecha`,`cod_evaluado`,`fecha_max` FROM `multifuente_evaluadores` WHERE `fecha_max`>CURDATE() AND `resuelto`=0 AND `id_evaluado`='.$id.'');
				$evaluadores=$this->Multifuente->query('SELECT `id_personal`,`fecha`,`cod_evaluado`,`fecha_max` FROM `multifuente_evaluadores` WHERE `resuelto`=0 AND `id_evaluado`='.$id.'');
				foreach ($evaluadores as $key => $value) {
					$value=reset($value);
					$email = $this->Multifuente->get_emailById($value['id_personal']);
					$subject= "Recordatorio de Evaluación ".$nombre_evaluado;
					$usr = $this->Multifuente->get_usrById($value['id_personal']);
					$nombre = $this->Multifuente->get_pname($value['id_personal']);
					$fecha = $value['fecha'];
					$fecha_max = $value['fecha_max'];
					$cod_evaluado = $value['cod_evaluado'];
					$message = self::get_MsgEvaluadores($nombre,$nombre_evaluado,$fecha,$cod_evaluado,$usr,$fecha_max);
					Util::sendMail($email,$subject,$message);
				}
				// $evaluado=$this->Multifuente->query('SELECT `id_personal`,`fecha`,`cod_evaluado`,`fecha_max` FROM `multifuente_evaluado` WHERE `fecha_max`>CURDATE() AND `resuelto`=0 AND `id_personal`='.$id.'');
				$evaluado=$this->Multifuente->query('SELECT `id_personal`,`fecha`,`cod_evaluado`,`fecha_max` FROM `multifuente_evaluado` WHERE `resuelto`=0 AND `id_personal`='.$id.'');
				foreach ($evaluado as $key => $value) { 
					$value=reset($value);
					$email = $this->Multifuente->get_emailById($value['id_personal']);
					$subject= "Recordatorio de Evaluación ";
					$usr = $this->Multifuente->get_usrById($value['id_personal']);
					$nombre = $this->Multifuente->get_pname($value['id_personal']);
					$fecha = $value['fecha'];
					$fecha_max = $value['fecha_max'];
					$cod_evaluado = $value['cod_evaluado'];
					$message = self::get_MsgEvaluado($nombre,$fecha,$cod_evaluado,$usr,$fecha_max);
					Util::sendMail($email,$subject,$message);				
				}
			}
			echo "<script>alert('Se ha enviado un correo a quienes no han terminado la evaluacion')</script>";
		}
		$res=$this->Multifuente->query('SELECT * FROM `listado_personal_op` WHERE `id` IN (SELECT DISTINCT `id_personal` FROM `multifuente_evaluado` WHERE id_empresa='.$_SESSION["Empresa"]["id"].')');
		$this->set('evaluados',$res);
	}

	function estatus_evaluado($_id){
		$this->hayEmpresa();
		$this->set('title','Alto Desempe&ntilde;o');
		$this->set('backlink','empresa/multifuente');
		$this->set('id',$_id);
		if(isset($_POST['button'])){
			foreach ($_POST['id'] as $a => $id) {
				$nombre_evaluado = $this->Multifuente->get_pname($_id);
				if($_id == $id){
					// $res=$this->Multifuente->query_('SELECT `id_personal`,`fecha`,`cod_evaluado`,`fecha_max` FROM `multifuente_evaluado` WHERE `fecha_max`>CURDATE() AND `resuelto`=0 AND `id_personal`='.$id.'');
					$res=$this->Multifuente->query_('SELECT `id_personal`,`fecha`,`cod_evaluado`,`fecha_max` FROM `multifuente_evaluado` WHERE `resuelto`=0 AND `id_personal`='.$id.'');
				}else{
					// $res=$this->Multifuente->query_('SELECT `id_personal`,`fecha`,`cod_evaluado`,`fecha_max` FROM `multifuente_evaluadores` WHERE `fecha_max`>CURDATE() AND `resuelto`=0 AND `id_personal`='.$id.' AND `id_evaluado`='.$_id.'');		
					$res=$this->Multifuente->query_('SELECT `id_personal`,`fecha`,`cod_evaluado`,`fecha_max` FROM `multifuente_evaluadores` WHERE `resuelto`=0 AND `id_personal`='.$id.' AND `id_evaluado`='.$_id.'');		
				}	
				foreach ($res as $key => $value) { 
					if($res){
						$nombre = $this->Multifuente->get_pname($id);
						if($_id == $id){
							$message = "<p>Estimado(a) ".$nombre.",</p><p>Este es un recordatorio automático para que complete su evaluación; la cual le fue enviada el ".$value['fecha'].".  Gracias por su colaboración.</p>";
						}else{
							$message = "<p>Estimado(a) ".$nombre.",</p><p>Este es un recordatorio automático para que complete la evaluación de ".$nombre_evaluado ." la cual le fue enviada el ".$value['fecha'].".  Gracias por su colaboración.</p>";
						}
						$email = $this->Multifuente->get_emailById($id);
						$subject= "Recordatorio de Evaluación ";
						$usr = $this->Multifuente->get_usrById($id);
						$message .= "<p>Puede ver esta y otras evaluaciones pendientes siguiendo el vínculo en el menú lateral bajo Compass 360 > Evaluaciones.</p><p>Si por alguna razón debe interrumpir la respuesta al cuestionario, por favor asegúrese de hacer click en el Botón “Grabar y Continuar luego” que está al final del cuestionario.  Usted podrá entrar y salir del cuestionario tantas veces lo requiera utilizando este mismo link (contenido en esta comunicación) sin embargo, le recomendamos enfáticamente que trate de contestar de una sola vez el cuestionario completo.</p><p>Le solicitamos también que conteste este cuestionario como máximo hasta el ".$value['fecha_max'].". A fin de facilitarle la comprensión del uso y sobretodo de los beneficios de esta herramienta le invitamos a ver una corta presentación a través de  <a href = 'http://youtu.be/KF_b9jeLam0'>Video</a> </p><p>Desde ya le agradecemos su colaboración. </p>";
						if(Util::sendMail($email,$subject,$message)){
							$this->set('custom_success',"Se envió un recordatorio a quienes no han terminado la evaluación");
						}else{
							$this->set('custom_danger',"Ocurrió un error, intentelo nuevamente. Si el problema persiste comuniquese con soporte@saegth.com");
						}
					}			
				}
			}
			$_POST=null;
		}
		// $evaluadores=$this->Multifuente->query_('SELECT `id_personal`,`fecha`,`cod_evaluado`,`relacion`,`resuelto` FROM `multifuente_evaluadores` WHERE `fecha_max`>CURDATE() AND `id_evaluado`='.$_id.' ORDER BY `fecha` DESC');
		$evaluadores=$this->Multifuente->query_('SELECT `id_personal`,`fecha`,`cod_evaluado`,`relacion`,`resuelto` FROM `multifuente_evaluadores` WHERE `id_evaluado`='.$_id.' ORDER BY `fecha` DESC');
		$this->set('n_ev',$this->Multifuente->get_pname($_id));	
		$this->set('evaluados',$evaluadores);	
		// $evaluado=$this->Multifuente->query_('SELECT `id_personal`,`fecha`,`cod_evaluado`,`relacion`,`resuelto` FROM `multifuente_evaluado` WHERE `fecha_max`>CURDATE() AND `id_personal`='.$_id.' ORDER BY `fecha` DESC');	
		$evaluado=$this->Multifuente->query_('SELECT `id_personal`,`fecha`,`cod_evaluado`,`relacion`,`resuelto` FROM `multifuente_evaluado` WHERE `id_personal`='.$_id.' ORDER BY `fecha` DESC');	
		$this->set('evaluado',$evaluado);
	}

	function estatus_departamento(){
		$this->hayEmpresa();
		$this->set('title','Alto Desempe&ntilde;o');
		$this->set('backlink','empresa/multifuente');	
		$this->set('custom_text','Estatus por departamento');

		$res=$this->Multifuente->query('SELECT `id`,`nombre` FROM `empresa_area` WHERE `id_empresa`='.$_SESSION["Empresa"]["id"].'');
		$this->set('departamento',$res);

		if(isset($_POST['button'])){
			// $evaluadores=$this->Multifuente->query('SELECT `id_personal`,`fecha`,`cod_evaluado`,`fecha_max` FROM `multifuente_evaluadores` WHERE `fecha_max`>CURDATE() AND `resuelto`=0 AND `id_empresa`='.$_SESSION["Empresa"]["id"].'');
			$evaluadores=$this->Multifuente->query('SELECT `id_personal`,`fecha`,`cod_evaluado`,`fecha_max` FROM `multifuente_evaluadores` WHERE `resuelto`=0 AND `id_empresa`='.$_SESSION["Empresa"]["id"].'');
			foreach ($evaluadores as $key => $value) {
				$value=reset($value);
				$nombre_evaluado = $this->Multifuente->get_name($value['cod_evaluado']);
				$email = $this->Multifuente->get_emailById($value['id_personal']);
				$subject= "Recordatorio de Evaluación ".$nombre_evaluado;
				$usr = $this->Multifuente->get_usrById($value['id_personal']);
				$nombre = $this->Multifuente->get_pname($value['id_personal']);
				$fecha = $value['fecha'];
				$fecha_max = $value['fecha_max'];
				$cod_evaluado = $value['cod_evaluado'];
				$message = self::get_MsgEvaluadores($nombre,$nombre_evaluado,$fecha,$cod_evaluado,$usr,$fecha_max);
				Util::sendMail($email,$subject,$message);
			}
			// $evaluado=$this->Multifuente->query('SELECT `id_personal`,`fecha`,`cod_evaluado`,`fecha_max` FROM `multifuente_evaluado` WHERE `fecha_max`>CURDATE() AND `resuelto`=0 AND `id_empresa`='.$_SESSION["Empresa"]["id"].'');
			$evaluado=$this->Multifuente->query('SELECT `id_personal`,`fecha`,`cod_evaluado`,`fecha_max` FROM `multifuente_evaluado` WHERE `resuelto`=0 AND `id_empresa`='.$_SESSION["Empresa"]["id"].'');
			foreach ($evaluado as $key => $value) { 
				$value=reset($value);
				$nombre_evaluado = $this->Multifuente->get_name($value['cod_evaluado']);
				$email = $this->Multifuente->get_emailById($value['id_personal']);
				$subject= "Recordatorio de Evaluación ";
				$usr = $this->Multifuente->get_usrById($value['id_personal']);
				$nombre = $this->Multifuente->get_pname($value['id_personal']);
				$fecha = $value['fecha'];
				$fecha_max = $value['fecha_max'];
				$cod_evaluado = $value['cod_evaluado'];
				$message = self::get_MsgEvaluado($nombre,$fecha,$cod_evaluado,$usr,$fecha_max);
				Util::sendMail($email,$subject,$message);				
			}
			echo "<script>alert('Se ha enviado un correo a quienes no han terminado la evaluacion')</script>";
		}
	}

	function estatus_departamentos($id){
		$this->hayEmpresa();
		$this->set('title','Alto Desempe&ntilde;o');
		$this->set('backlink','empresa/estatus_departamento');	
		$this->set('custom_text','Estatus por departamento');
		$this->set('id',$id);
		$res=$this->Multifuente->query('SELECT * FROM listado_personal_op WHERE id IN(SELECT DISTINCT a.id_personal FROM multifuente_evaluado AS a INNER JOIN personal_empresa AS b ON a.id_personal=b.id_personal WHERE b.id_area ='.$id.')');
		$this->set('evaluados',$res);
		if(isset($_POST['button'])){
			foreach ($_POST['id'] as $a => $id) {
				$nombre_evaluado = $this->Multifuente->get_pname($id);
				// $evaluadores=$this->Multifuente->query('SELECT `id_personal`,`fecha`,`cod_evaluado`,`fecha_max` FROM `multifuente_evaluadores` WHERE `fecha_max`>CURDATE() AND `resuelto`=0 AND `id_evaluado`='.$id.'');
				$evaluadores=$this->Multifuente->query('SELECT `id_personal`,`fecha`,`cod_evaluado`,`fecha_max` FROM `multifuente_evaluadores` WHERE `resuelto`=0 AND `id_evaluado`='.$id.'');
				foreach ($evaluadores as $key => $value) {
					$value=reset($value);
					$email = $this->Multifuente->get_emailById($value['id_personal']);
					$subject= "Recordatorio de Evaluación ".$nombre_evaluado;
					$usr = $this->Multifuente->get_usrById($value['id_personal']);
					$nombre = $this->Multifuente->get_pname($value['id_personal']);
					$fecha = $value['fecha'];
					$fecha_max = $value['fecha_max'];
					$cod_evaluado = $value['cod_evaluado'];
					$message = self::get_MsgEvaluadores($nombre,$nombre_evaluado,$fecha,$cod_evaluado,$usr,$fecha_max);
					Util::sendMail($email,$subject,$message);
				}
				// $evaluado=$this->Multifuente->query('SELECT `id_personal`,`fecha`,`cod_evaluado`,`fecha_max` FROM `multifuente_evaluado` WHERE `fecha_max`>CURDATE() AND `resuelto`=0 AND `id_personal`='.$id.'');
				$evaluado=$this->Multifuente->query('SELECT `id_personal`,`fecha`,`cod_evaluado`,`fecha_max` FROM `multifuente_evaluado` WHERE `resuelto`=0 AND `id_personal`='.$id.'');
				foreach ($evaluado as $key => $value) { 
					$value=reset($value);
					$email = $this->Multifuente->get_emailById($value['id_personal']);
					$subject= "Recordatorio de Evaluación ";
					$usr = $this->Multifuente->get_usrById($value['id_personal']);
					$nombre = $this->Multifuente->get_pname($value['id_personal']);
					$fecha = $value['fecha'];
					$fecha_max = $value['fecha_max'];
					$cod_evaluado = $value['cod_evaluado'];
					$message = self::get_MsgEvaluado($nombre,$fecha,$cod_evaluado,$usr,$fecha_max);
					Util::sendMail($email,$subject,$message);				
				}
			}
			echo "<script>alert('Se ha enviado un correo a quienes no han terminado la evaluacion')</script>";
		}
	}

	function estatus_gerentes(){
		$this->hayEmpresa();
		$this->set('title','Alto Desempe&ntilde;o');
		$this->set('backlink','empresa/multifuente');	
		$this->set('custom_text','Estatus por gerente');
		$sql = "SELECT
			p.id AS id,
			nombre_p,
			100-(
				SELECT
					COUNT(*) AS total
				FROM
					multifuente_evaluadores me2
				WHERE
					(
						me2.relacion = 0
						OR me2.relacion = 1
					)
				AND me2.resuelto = 0
				AND me2.id_personal = p.id
			) *100/COUNT(*) as porcentaje
		FROM
			multifuente_evaluadores me
		JOIN personal p ON p.id = me.id_personal
		WHERE
			(
				me.relacion = 0
				OR me.relacion = 1
			)
		AND me.id_empresa = ".$_SESSION['Empresa']['id']."
		GROUP BY
			nombre_p";
		$res=$this->Multifuente->query_($sql);
		$this->set('gerentes',$res);

		if(isset($_POST['button'])){
			// $evaluadores=$this->Multifuente->query('SELECT `id_personal`,`fecha`,`cod_evaluado`,`fecha_max` FROM `multifuente_evaluadores` WHERE `fecha_max`>CURDATE() AND `resuelto`=0 AND `id_empresa`='.$_SESSION["Empresa"]["id"].'');
			$evaluadores=$this->Multifuente->query('SELECT `id_personal`,`fecha`,`cod_evaluado`,`fecha_max` FROM `multifuente_evaluadores` WHERE `resuelto`=0 AND `id_empresa`='.$_SESSION["Empresa"]["id"].'');
			foreach ($evaluadores as $key => $value) {
				$value=reset($value);
				$nombre_evaluado = $this->Multifuente->get_name($value['cod_evaluado']);
				$email = $this->Multifuente->get_emailById($value['id_personal']);
				$subject= "Recordatorio de Evaluación ".$nombre_evaluado;
				$usr = $this->Multifuente->get_usrById($value['id_personal']);
				$nombre = $this->Multifuente->get_pname($value['id_personal']);
				$fecha = $value['fecha'];
				$fecha_max = $value['fecha_max'];
				$cod_evaluado = $value['cod_evaluado'];
				$message = self::get_MsgEvaluadores($nombre,$nombre_evaluado,$fecha,$cod_evaluado,$usr,$fecha_max);
				Util::sendMail($email,$subject,$message);
			}
			// $evaluado=$this->Multifuente->query('SELECT `id_personal`,`fecha`,`cod_evaluado`,`fecha_max` FROM `multifuente_evaluado` WHERE `fecha_max`>CURDATE() AND `resuelto`=0 AND `id_empresa`='.$_SESSION["Empresa"]["id"].'');
			$evaluado=$this->Multifuente->query('SELECT `id_personal`,`fecha`,`cod_evaluado`,`fecha_max` FROM `multifuente_evaluado` WHERE `resuelto`=0 AND `id_empresa`='.$_SESSION["Empresa"]["id"].'');
			foreach ($evaluado as $key => $value) { 
				$value=reset($value);
				$nombre_evaluado = $this->Multifuente->get_name($value['cod_evaluado']);
				$email = $this->Multifuente->get_emailById($value['id_personal']);
				$subject= "Recordatorio de Evaluación ";
				$usr = $this->Multifuente->get_usrById($value['id_personal']);
				$nombre = $this->Multifuente->get_pname($value['id_personal']);
				$fecha = $value['fecha'];
				$fecha_max = $value['fecha_max'];
				$cod_evaluado = $value['cod_evaluado'];
				$message = self::get_MsgEvaluado($nombre,$fecha,$cod_evaluado,$usr,$fecha_max);
				Util::sendMail($email,$subject,$message);				
			}
			echo "<script>alert('Se ha enviado un correo a quienes no han terminado la evaluacion')</script>";
		}
	}

	function estatus_gerente($id){
		$this->hayEmpresa();
		$this->set('title','Alto Desempe&ntilde;o');
		$this->set('backlink','empresa/estatus_departamento');
		$this->set('custom_text','Estatus por gerente');
		$this->set('id',$id);
		$res=$this->Multifuente->query_('SELECT * FROM listado_personal_op lp JOIN multifuente_evaluadores me ON lp.id = me.id_evaluado WHERE ( me.relacion = 0 OR me.relacion = 1 ) AND me.id_personal = '.$id.' AND activo = 1');
		$this->set('evaluados',$res);
		if(isset($_POST['button'])){
			foreach ($_POST['id'] as $a => $id) {
				$nombre_evaluado = $this->Multifuente->get_pname($id);
				// $evaluadores=$this->Multifuente->query('SELECT `id_personal`,`fecha`,`cod_evaluado`,`fecha_max` FROM `multifuente_evaluadores` WHERE `fecha_max`>CURDATE() AND `resuelto`=0 AND `id_evaluado`='.$id.'');
				$evaluadores=$this->Multifuente->query('SELECT `id_personal`,`fecha`,`cod_evaluado`,`fecha_max` FROM `multifuente_evaluadores` WHERE `resuelto`=0 AND `id_evaluado`='.$id.'');
				foreach ($evaluadores as $key => $value) {
					$value=reset($value);
					$email = $this->Multifuente->get_emailById($value['id_personal']);
					$subject= "Recordatorio de Evaluación ".$nombre_evaluado;
					$usr = $this->Multifuente->get_usrById($value['id_personal']);
					$nombre = $this->Multifuente->get_pname($value['id_personal']);
					$fecha = $value['fecha'];
					$fecha_max = $value['fecha_max'];
					$cod_evaluado = $value['cod_evaluado'];
					$message = self::get_MsgEvaluadores($nombre,$nombre_evaluado,$fecha,$cod_evaluado,$usr,$fecha_max);
					Util::sendMail($email,$subject,$message);
				}
				// $evaluado=$this->Multifuente->query('SELECT `id_personal`,`fecha`,`cod_evaluado`,`fecha_max` FROM `multifuente_evaluado` WHERE `fecha_max`>CURDATE() AND `resuelto`=0 AND `id_personal`='.$id.'');
				$evaluado=$this->Multifuente->query('SELECT `id_personal`,`fecha`,`cod_evaluado`,`fecha_max` FROM `multifuente_evaluado` WHERE `resuelto`=0 AND `id_personal`='.$id.'');
				foreach ($evaluado as $key => $value) { 
					$value=reset($value);
					$email = $this->Multifuente->get_emailById($value['id_personal']);
					$subject= "Recordatorio de Evaluación ";
					$usr = $this->Multifuente->get_usrById($value['id_personal']);
					$nombre = $this->Multifuente->get_pname($value['id_personal']);
					$fecha = $value['fecha'];
					$fecha_max = $value['fecha_max'];
					$cod_evaluado = $value['cod_evaluado'];
					$message = self::get_MsgEvaluado($nombre,$fecha,$cod_evaluado,$usr,$fecha_max);
					Util::sendMail($email,$subject,$message);				
				}
			}
			echo "<script>alert('Se ha enviado un correo a quienes no han terminado la evaluacion')</script>";
		}
	}
	
	function eval_edit_test_actual()
	{
		$this->haySession();
		$this->set('backlink','multifuente/evaluados');

		if ($_SESSION['USER-AD']['user_rol'] != 1) {
			$dispatch = new MultifuenteController('Multifuente','multifuente','edit_eval_curso');
			$dispatch->edit_eval_curso();
			header("Location: " . BASEURL.'multifuente/edit_eval_curso');
		}

		$test = $this->Multifuente->query('SELECT DISTINCT `nombre_test` ,  `cod_test`  FROM multifuente_test WHERE id_empresa='.$_SESSION['Empresa']['id'].'');
		$this->set('test',$test);

		$sql = 'SELECT p.id, p.nombre,p.cargo,p.area,p.foto, ifnull(me.cod_test,"No ha sido asignado") as codigo,ifnull(MAX(me.fecha),"-") as fecha_e 
				FROM listado_personal_op as p 
				JOIN evaluadores_aprovados as ea
				JOIN personal_test as pt 
				ON p.id=ea.id 
				LEFT JOIN multifuente_evaluado as me
				ON p.id=me.id_personal
				WHERE ea.id_empresa='.$_SESSION['Empresa']['id'].' 
				AND pt.`compass_360`=1 
				AND pt.id_personal=ea.id 
				GROUP BY 1 ;';
		//echo $sql;
		$evaluado = $this->Multifuente->query_($sql);
		$this->set('evaluado',$evaluado);
	}
	
	function edit_eval_curso($id_p = null)
	{
		Util::sessionStart();
		$this->set('backlink',false);
		
		$mf = new Multifuente();

		if($mf->hayEvaluacionEnCurso($id_p))
			$this->set('existe', true);
		else
			$this->set('existe', false);

		$id_e = $_SESSION['Empresa']['id'];
		$id=($id_p) ? $id_p : $_SESSION['USER-AD']['id_personal'];

		$res = $this->get_Eval($id,null,null);
		$evaluadores = array();

		if(isset($res)){
			$cod_test = $_SESSION['evaluado']['test'] = $res['cod_test'];
			$cod_evaluado = $_SESSION['evaluado']['id'] = $res['cod_evaluado'];
			
			$this->set('subtitle','Evaluadores seleccionados');

			$superior = Multifuente::getEvaluadoresLast($id,1,$cod_evaluado);
			if($superior)
				$evaluadores['Superior,1'] = $superior;
			else
				$evaluadores['Superior,1'] = "empty";

			$pares = Multifuente::getEvaluadoresLast($id,2,$cod_evaluado);
			if($pares)
				$evaluadores['Pares,2'] = $pares;
			else
				$evaluadores['Pares,2'] = "empty";

			$subalternos = Multifuente::getEvaluadoresLast($id,3,$cod_evaluado);
			if($subalternos)
				$evaluadores['Subalternos,3'] = $subalternos;
			else
				$evaluadores['Subalternos,3'] = "empty";

			$this->set('evaluadores',$evaluadores);
		}else{
			$this->set('subtitle','Seleccione a los evaluadores');
			$this->set('evaluadores',$evaluadores);
		}

		if(isset($_POST['id_per_edit'])){
			$arr = Personal_empresa::withID($id);
			$pid = $arr->get_pid_sup();

			$arr_sup = Personal_empresa::withID($pid);
			$pid_sup = $arr_sup->get_pid_sup();
			
			if($pid){
				$nivel = $aprob = 1;
				if($pid==6015 || $pid==6020){
					$pid=6018;
				}

				// Se envia correo al jefe inmediato y al jefe del jefe, sobre los cambios hechos
				$msg="<p>Estimado/a,</p><p>".$_SESSION['Personal']['nombre']." ha modificado sus evaluadores para la evaluación Compass 360. Es necesario que confirme esta selección antes de proceder, puede descartar a y/o seleccionar nuevos evaluadores.</p><p>En el menú lateral encontrara la opción para confirmar bajo Compass 360 > Selección de evaluadores > subalternos directos</p>";
				$email = $this->Multifuente->get_emailById($pid);
				$email_sup = $this->Multifuente->get_emailById($pid_sup);

				$subj = "Selección de evaluadores para ".$_SESSION['Personal']['nombre'];
				Util::sendMail($email,$subj,$msg);
				Util::sendMail($email_sup,$subj,$msg);
			}else{
				$nivel = $aprob = 3;
			}

			// Verificar los usuarios existentes, solo guardar los nuevos
			foreach ($_POST['id_per_edit'] as $a => $b) {
				$val = explode(',', $b);
				$args = array(
					"id_evaluado" => $id,
					"id_personal" => $val[0],
					"id_empresa" => $id_e,
					"relacion" => $val[1],
					"nivel" => $nivel,
					"aprovado" => $aprob,
					"tipo_ingreso" => "E"
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
	
	function reiniciar()
	{
		$this->haySession();
		$mp = new Multifuente_periodos();
		
		$sql = 'SELECT p.id, p.nombre,p.cargo,p.area,p.foto, ifnull(me.cod_test,"No ha sido asignado") as codigo,ifnull(MAX(me.fecha),"-") as fecha_e 
				FROM listado_personal_op as p 
				JOIN evaluadores_aprovados as ea
				JOIN personal_test as pt 
				ON p.id=ea.id 
				LEFT JOIN multifuente_evaluado as me
				ON p.id=me.id_personal
				WHERE ea.id_empresa='.$_SESSION['Empresa']['id'].' 
				AND pt.`compass_360`=1 
				AND pt.id_personal=ea.id 
				GROUP BY 1 ;';
		//echo $sql;
		$evaluado = $this->Multifuente->query_($sql);
		$this->set('evaluado',$evaluado);

		if(isset($_POST['reiniciar'])){
			
			// Inactivamos los periodos creados
			$mp->setActivo('I');
			$mp->update();

			$mp->setPeriodo(date('Y'));
			$mp->setId_empresa($_SESSION['Empresa']['id']);
			$mp->setActivo('A');
			$mp->insert();

			if(isset($_POST['id_per'])){

				foreach ($_POST['id_per'] as $key => $id_personal) {
					
					$mp->insert_periodos_evaluador($mp->getId(),$id_personal,$_SESSION['Empresa']['id']);

				}

			}else{

				foreach ($evaluado as $a => $b) {

					$mp->setPeriodo(date('Y'));
					$mp->setId_personal($b['id']);
					$mp->setId_empresa($_SESSION['Empresa']['id']);
					$mp->setActivo('A');
					$mp->insert();

				}

			}

		}
	}
	
	function progreso(){
		$this->hayPermisoAdmin();
	}

	function directos(){
		$this->haySession();
	}

	function indirectos(){
		$this->haySession();
	}

	function evaluaciones_pendientes(){
		$this->haySession();
		
		$new_array = null;
		$me = new Multifuente_relacion();		
		$res = $me->select_unresolved($_SESSION['USER-AD']['id_personal']);
		if($res){
			foreach ($res as $key => $value) {
				$count = $me->count_unresolved_($value['id']);
				if ($count < 1) {
					unset($res[$key]);
				}
			}
		}

		$this->set('res', $res);
	}

	/*



	*/

	function logout(){
		Util::sessionLogout();
		$this->Multifuente->disconnect();
		$this->_template = new Template('Inicio','principal', false);
	}

	function cambiar_empresa(){
		Util::sessionStart();
		$_SESSION['Empresa'] = null;
		$this->hayEmpresa();
	}

	function haySession(){
		Util::sessionStart();
		if (!isset($_SESSION['USER-AD'])){
			$this->logout();	
		}
		return true;
	}	

	function hayPermisoAdmin(){
		Util::sessionStart();
		$session = $this->haySession();
		if ($session && ($_SESSION['USER-AD']['user_rol']==2)) {
			echo "<script>alert('No tiene los permisos necesarios para navegar esta sección');window.location = '".BASEURL.$_SESSION['link']."';</script>";
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

	function hayPermisoGerente(){
		$this->haySession();
		if (!(($_SESSION['USER-AD']['user_rol']<2)||$this->esGerente())) {
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

	function esGerente(){
		$this->haySession();
		$res=$this->Multifuente->query('SELECT * FROM personal WHERE id IN(SELECT DISTINCT id_evaluado FROM multifuente_evaluadores WHERE relacion=0 AND id_personal='.$_SESSION['USER-AD']['id_personal'].')');
		if($res){
			return true;
		}else{
			return false;
		}
	}

	function estaHabilitado(){
		$this->haySession();
		$res=$this->Multifuente->query('SELECT `compass_360` FROM personal_test WHERE id_personal='.$_SESSION['USER-AD']['id_personal'].'',1);
		if($res){
			$res=reset($res);
			$res=reset($res);
		}
		return $res;
	}

	function get_Eval($id,$test=null,$eval=null){		
		Util::sessionStart();
		if(isset($test) && isset($eval)){
			$res = $this->Multifuente->query_('SELECT `cod_evaluado`, `cod_test`,`resuelto`,`fecha` FROM `multifuente_evaluado` WHERE `id_personal`='.$id.' AND `cod_evaluado`="'.$eval.'" AND `cod_test`="'.$test.'"',1);
			if($res){
				$otras = $this->Multifuente->query_('SELECT `cod_evaluado`, `cod_test`,`resuelto`,`fecha` FROM `multifuente_evaluado` WHERE `id_personal`='.$id.' ORDER by fecha DESC');
				if((sizeof($otras))<2){
					$_SESSION['evaluado']['otras']=null;
				}else{
					$_SESSION['evaluado']['otras']=$otras;
				}
			}
		}elseif(isset($_SESSION['evaluado']['test']) && isset($_SESSION['evaluado']['id'])){
			$res = $this->Multifuente->query_('SELECT `cod_evaluado`, `cod_test`,`resuelto`,`fecha` FROM `multifuente_evaluado` WHERE `id_personal`='.$id.' AND `cod_evaluado`="'.$_SESSION['evaluado']['id'].'" AND `cod_test`="'.$_SESSION['evaluado']['test'].'"',1);
			if($res){
				$otras = $this->Multifuente->query_('SELECT `cod_evaluado`, `cod_test`,`resuelto`,`fecha` FROM `multifuente_evaluado` WHERE `id_personal`='.$id.' ORDER by fecha DESC');
				if((sizeof($otras))<2){
					$_SESSION['evaluado']['otras']=null;
				}else{
					$_SESSION['evaluado']['otras']=$otras;
				}
			}else{
				$res = $this->Multifuente->query_('SELECT `cod_evaluado`, `cod_test`,`resuelto`,`fecha` FROM `multifuente_evaluado` WHERE `id_personal`='.$id.' ORDER by fecha DESC');
				if($res){
					if((sizeof($res))<2){
						$_SESSION['evaluado']['otras']=null;
						$res = $res[0];
					}else{
						$_SESSION['evaluado']['otras']=$res;
						$res = $res[0];
					}}
				}
			}else{
				$res = $this->Multifuente->query_('SELECT `cod_evaluado`, `cod_test`,`resuelto`,`fecha` FROM `multifuente_evaluado` WHERE `id_personal`='.$id.' ORDER by fecha DESC');
				if($res){
					if((sizeof($res))<2){
						$_SESSION['evaluado']['otras']=null;
						$res = $res[0];
					}else{
						$_SESSION['evaluado']['otras']=$res;
						$res = $res[0];
					}
				}
			}
			return $res;
		}


		function get_MsgEvaluadores($nombre,$nombre_evaluado,$fecha,$cod_evaluado,$usr,$fecha_max){
			$message = "<p>Estimado(a) ".$nombre.",</p><p>Este es un recordatorio automático para que complete la evaluación de ".$nombre_evaluado ." la cual le fue enviada el ".$fecha.".  Gracias por su colaboración.</p>";
			$message .= "<p>Puede ver esta y otras evaluaciones pendientes siguiendo el vínculo en el menú lateral bajo Compass 360 > Evaluaciones.</p><p>Si por alguna razón debe interrumpir la respuesta al cuestionario, por favor asegúrese de hacer click en el Botón “Grabar y Continuar luego” que está al final del cuestionario.  Usted podrá entrar y salir del cuestionario tantas veces lo requiera utilizando este mismo link (contenido en esta comunicación) sin embargo, le recomendamos enfáticamente que trate de contestar de una sola vez el cuestionario completo.</p><p>Le solicitamos también que conteste este cuestionario como máximo hasta el ".$fecha_max.". A fin de facilitarle la comprensión del uso y sobretodo de los beneficios de esta herramienta le invitamos a ver una corta presentación a través de  <a href = 'http://youtu.be/KF_b9jeLam0'>Video</a> </p><p>Desde ya le agradecemos su colaboración. </p>";
			return $message;
		}


		function get_MsgEvaluado($nombre,$fecha,$cod_evaluado,$usr,$fecha_max){
			$message = "<p>Estimado(a) ".$nombre.",</p><p>Este es un recordatorio automático para que complete su evaluación; la cual le fue enviada el ".$fecha.".  Gracias por su colaboración.</p>";
			$message .= "<p>Puede ver esta y otras evaluaciones pendientes siguiendo el vínculo en el menú lateral bajo Compass 360 > Evaluaciones.</p><p>Si por alguna razón debe interrumpir la respuesta al cuestionario, por favor asegúrese de hacer click en el Botón “Grabar y Continuar luego” que está al final del cuestionario.  Usted podrá entrar y salir del cuestionario tantas veces lo requiera utilizando este mismo link (contenido en esta comunicación) sin embargo, le recomendamos enfáticamente que trate de contestar de una sola vez el cuestionario completo.</p><p>Le solicitamos también que conteste este cuestionario como máximo hasta el ".$fecha_max.". A fin de facilitarle la comprensión del uso y sobretodo de los beneficios de esta herramienta le invitamos a ver una corta presentación a través de  <a href = 'http://youtu.be/KF_b9jeLam0'>Video</a> </p><p>Desde ya le agradecemos su colaboración. </p>";
			return $message;
		}

	}



