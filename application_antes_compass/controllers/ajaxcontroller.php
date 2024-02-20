
<?php

class AjaxController extends Controller {

	protected $link;
	
	function __construct($model, $controller, $action, $type = 0) {

		parent::__construct($model, $controller, $action, $type);

		$this->link = $this->Ajax->getDBHandle();
	}

	function area_holder(){
		$this->haySession();
	}

	function local_holder(){
		$this->haySession();
	}

	function empresa_holder(){
		$this->haySession();
	}

	function mailer(){
		$this->haySession();
	}

	function p_scorecard(){
		$this->haySession();
	}

	function listado_personal_x_cargo(){
		$this->haySession();
	}

	function page_load(){
		$this->haySession();
	}

	function plan_form_submit(){
		$this->haySession();
	}

	function plan_desarrollo_ajax(){
		$this->haySession();
	}

	function get_login(){

		echo '<form  class="form-inline" method="post" action="<?php echo BASEURL; ?>inicio/principal"><div class="form-group"><input type="text" name="usuario" class="form-control" id="exampleInputName2" placeholder="Usuario"></div><div class="form-group"><input type="password"  name="password"  class="form-control" id="exampleInputEmail2" placeholder="Contraseña"></div><button type="submit" class="btn btn-default">Entrar</button>form>';
	}
//test
	function cobertura_ajax(){
		$this->haySession();
		if($_REQUEST){
			$cobertura = new Cobertura();
			$id_p = $_REQUEST['id_p'];
			$cobertura->delete_all($id_p);
			foreach ($_REQUEST['area'] as $key => $value) {
				$cobertura = new Cobertura();
				$cobertura->setId_personal($id_p);
				$cobertura->setId_area($_REQUEST['area'][$key]);
				$cobertura->setId_cargo($_REQUEST['cargo'][$key]);
				$cobertura->setId_local($_REQUEST['local'][$key]);
				$cobertura->setComentario($_REQUEST['comentario'][$key]);
				$cobertura->setMonth_1($_REQUEST['month_1'][$key]);
				$cobertura->setMonth_2($_REQUEST['month_2'][$key]);
				$cobertura->setMonth_3($_REQUEST['month_3'][$key]);
				$cobertura->setMonth_4($_REQUEST['month_4'][$key]);
				$cobertura->setMonth_5($_REQUEST['month_5'][$key]);
				$cobertura->insert();
				echo mysqli_error($cobertura->link);
			}
		}
	}

	function sonda_tema_ajax(){
		$this->haySession();
		if($_REQUEST){
			$obj = new Sonda_tema();
			$obj->setTema($_REQUEST['tema']);
			$obj->insert();
			if($obj->getError())
				echo "error,";
			else
				echo "1,<a href='".BASEURL."sonda/pregunta/".$obj->getId()."' class='text-upper'>".$obj->getTema()."</a><br>";
		}
	}

	function sonda_tema_desc_ajax(){
		$this->haySession();
		if($_REQUEST){
			$obj = new Sonda_tema();
			$obj->select($_REQUEST['id']);
			$obj->setTema($_REQUEST['tema']);
			$obj->setDescripcion($_REQUEST['desc']);
			$obj->update();
			if($obj->getError())
				echo "error,";
			else
				echo "1,<a href='".BASEURL."sonda/pregunta/".$obj->getId()."' class='text-upper'>".$obj->getTema()."</a><br>,";
		}
	}

	function sonda_pregunta_ajax(){
		$this->haySession();
		if($_REQUEST){
			$obj = new Sonda_pregunta();
			$obj->setId_tema($_REQUEST['tema']);
			$obj->setId_empresa($_REQUEST['empresa']);
			$obj->setPregunta($_REQUEST['pregunta']);
			$obj->setInverso(0);
			$obj->setOp_respuesta(0);
			$obj->setActivo(1);
			
			if($_REQUEST['action'] == 'agrega'){
				$obj->insert();
			}
			else{
				$obj->setId($_REQUEST['id_p']);
				$obj->update();
			}

			if($obj->getError())
				echo "error,".$obj->getError();
			else
				echo "1,<li class='text-upper'>".$obj->getPregunta()."</li>";
		}
	}

	function riesgo_ajax(){
		$this->haySession();
		if($_REQUEST){
			$riesgo = new Riesgo_retencion();
			$id_e = $_SESSION['Empresa']['id'];
			$riesgo->delete_all($id_e);
			foreach ($_REQUEST['id_personal'] as $key => $value) {
				$riesgo = new Riesgo_retencion();
				$riesgo->setId_personal($value);
				$riesgo->setId_empresa($id_e);
				$riesgo->setPosicion($_REQUEST['posicion'][$key]);
				$riesgo->insert();
				echo mysqli_error($riesgo->link);
			}
		}
	}

	function personal_search(){
		$this->haySession();
		static $personal;
		if($_REQUEST){
			if(@array_search($_REQUEST['personal'], $personal)){
				exit();
			}else{
				$personal[] = $_REQUEST['personal'];
			}
		}
	}

	function haySession(){
		Util::sessionStart();
		if (!isset($_SESSION['USER-AD'])){
			$this->logout();	
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

	function hayPersonal(){
		$this->haySession();
		if (!isset($_SESSION['personal'])){
			$this->_template = new Template('Admin','personal_ingreso');
			$this->personal_ingreso();
			exit();
		}
	}

	function get_porcentaje_rp($id_t){
		$this->haySession();
		if($_REQUEST){
			if(isset($_SESSION['rp']['seg']))
				$args = $_SESSION['rp']['seg'];
			else
				$args = "";
			$z = new Rp_user();
			$ids = $_SESSION['rp_ids'] = $z->get_id_x_empresa($_SESSION['Empresa']['id'],$args);

			$y = new Rp_pregunta();
			$preguntas = $y->select_ids_x_tema($id_t);
			$c_ids = explode(",", $ids);
			$count = sizeof($c_ids);
			$w = new Rp_respuesta();
			$porcentajes = $w->get_percent($ids,$preguntas);
			if($w->getError())
				echo "error;";
			else
				echo $porcentajes."-".$count.";";
		}
	}

	function get_porcentaje_rp_pregunta($id_t){
		$this->haySession();
		if($_REQUEST){
			if(isset($_SESSION['rp']['seg']))
				$args = $_SESSION['rp']['seg'];
			else
				$args = "";
			$z = new Rp_user();
			if(isset($_SESSION['rp_ids']))
				$ids = $_SESSION['rp_ids'];
			else
				$ids = $_SESSION['rp_ids'] = $z->get_id_x_empresa($_SESSION['Empresa']['id'],$args);

		// echo $ids."<br>";
			$y = new Rp_pregunta();
			$pregunta = $y->select($id_t);
			$res = $y->getResults($ids);
			if($y->getError())
				echo "error*";
			else
				echo $res."*";
		}
	}

	function scorecard_admin($lim){
		$this->haySession();
		$se = new Scorer_estado(); 
		$res = $se->select_all("LIMIT ".$lim.",10");
		$final = array();

		$scorecard = new Scorecard();
		$scorer = $scorecard->get_scorer($_SESSION['Empresa']['id']);
		$fecha = $scorer['periodo'];
		$scorer = $scorer['detalle'];
		foreach ($res as $key => $value) {
			$r_scorer = $this->Ajax->get_ScorecardRes($value['id_personal'],$fecha);
			$resultado_scorer_p = number_format($r_scorer,2,"."," ").'%';  
			$r_score = $scorecard->scorer_rango($scorer,intval($r_scorer)); 
			$compass = round($this->Ajax->getAvg_test_eval($this->Ajax->get_codEval($value['id_personal'])),2); 
			$p_score = $scorer->p_score;
			$resultado_ponderado = ($r_score * $p_score / 100)+($compass * (100-$p_score) /100);
			$form = '<form method="post" action="'.BASEURL.'scorecard/fase_final'.'">
			<input type="hidden" name="id_e" value="'.$value['id_personal'].'"> 
			<input type="hidden" name="compass" value="'.$compass.'"> 
			<input type="hidden" name="r_score" value="'.$r_score.'"> 
			<input type="hidden" name="total" value="'.$resultado_ponderado.'"> 
			<input type="submit" class="btn btn-info btn-xs" value="Link"></form>';
			$arr = array(
				'id' => $value['id_personal'],
				'nombre' => $se->htmlprnt_win($value['nombre']),
				'cargo' => $se->htmlprnt_win($value['cargo']),
				'usuario' => $se->getIcon($value['usuario']),
				'jefe' => $se->getIcon($value['jefe']),
				'bloqueo' => $se->getIcon($value['bloqueo']),
				'revision' => $se->getIcon($value['revision']),
				'evaluacion' => $se->getIcon($value['evaluacion']),
				'revision_jefe' => $se->getIcon($value['revision_jefe']),
				'evaluacion_jefe' => $se->getIcon($value['evaluacion_jefe']),
				'resultado_scorer_p' => $resultado_scorer_p,
				'resultado_scorer' => $r_score,
				'resultado_compass' => $compass,
				'resultado_ponderado' => $resultado_ponderado,
				'form' => $form
				);



			array_push($final, $arr);
		}
		echo json_encode($final);
	}

	function scorecard_periodo($lim,$periodo=null){
		$this->haySession();
		$se = new Scorer_estado(); 
		$res = $se->select_all("LIMIT ".$lim.",10");
		$final = array();

		$scorecard = new Scorecard();
		$scorer = $scorecard->get_scorer($_SESSION['Empresa']['id'],$periodo);
		$fecha = $scorer['periodo'];
		$scorer = $scorer['detalle'];
		foreach ($res as $key => $value) {
			$r_scorer = $this->Ajax->get_ScorecardRes($value['id_personal'],$fecha);
			$resultado_scorer_p = number_format($r_scorer,2,"."," ").'%';  
			$r_score = $scorecard->scorer_rango($scorer,intval($r_scorer)); 
			$compass = round($this->Ajax->getAvg_test_eval($this->Ajax->get_codEval($value['id_personal'])),2); 
			$p_score = $scorer->p_score;
			$resultado_ponderado = ($r_score * $p_score / 100)+($compass * (100-$p_score) /100);
			$arr = array(
				'id' => $value['id_personal'],
				'nombre' => $se->htmlprnt_win($value['nombre']),
				'cargo' => $se->htmlprnt_win($value['cargo']),
				'fecha' => $fecha,
				'resultado_scorer_p' => $resultado_scorer_p,
				'resultado_scorer' => $r_score,
				'resultado_compass' => $compass,
				'resultado_ponderado' => $resultado_ponderado
				);



			array_push($final, $arr);
		}
		echo json_encode($final);
	}


	function notification(){
		$this->haySession();
		$pe = new Personal_empresa();
		$me = new Multifuente_relacion();

		/*
		$response = array(
			'directo' => $pe->count_sub_id_level_op($_SESSION['USER-AD']['id_personal'],1,1), 
			'indirecto' => $pe->count_sub_id_level_op($_SESSION['USER-AD']['id_personal'],2,2), 
			'pendiente' => $me->count_unresolved($_SESSION['USER-AD']['id_personal']), 
			);
		*/
		//By JPazmino
		$response = array(
				'directo' => $pe->count_sub_id_level_op_($_SESSION['USER-AD']['id_personal'],1,1), 
				'indirecto' => $pe->count_sub_id_level_op__($_SESSION['USER-AD']['id_personal'],2,2), 
				'pendiente' => $me->count_unresolved($_SESSION['USER-AD']['id_personal']), 
				'pendientes_general' => $me->count_unresolvedGeneral($_SESSION['USER-AD']['id_personal']), 
				);
		
		echo json_encode($response);
	}

	function test(){
		$this->haySession();
		echo json_encode($_SESSION['calificacion_desemp']);
	}

	function estado_proceso_scorecard_pais($id,$periodo=null){
		$this->haySession();
		$el = new empresa_local();
		$el->select($id);
		$children = $el->get_all_children($id);
		if($children){
			$child_array = array();
			$test = array();
			foreach ($children as $key => $value) {
				array_push($child_array, $value['ids']);
			}
			$children_string=implode(",", $child_array);
		}else{
			$children_string = $id;
		}

		if($periodo){
			$se = new scorer_estado_periodo();
			$count_array = $se->count_personal_in($children_string,"id_local",$periodo);
		}else{
			$se = new scorer_estado();
			$count_array = $se->count_personal_in($children_string,"id_local");
		}

		$n_empleados=$count_array['n_empleados'];
		if($n_empleados){
			$usuario_n=$count_array['usuario'];
			$usuario_p=number_format(($usuario_n*100/$n_empleados), 2, ',', ' ');
			$jefe_n=$count_array['jefe'];
			$jefe_p=number_format(($jefe_n*100/$n_empleados), 2, ',', ' ');
			$r_empleado_n=$count_array['r_empleado'];
			$r_empleado_p=number_format(($r_empleado_n*100/$n_empleados), 2, ',', ' ');
			$r_jefe_n=$count_array['r_jefe'];
			$r_jefe_p=number_format(($r_jefe_n*100/$n_empleados), 2, ',', ' ');
			$e_empleado_n=$count_array['e_empleado'];
			$e_empleado_p=number_format(($e_empleado_n*100/$n_empleados), 2, ',', ' ');
			$e_jefe_n=$count_array['e_jefe'];
			$e_jefe_p=number_format(($e_jefe_n*100/$n_empleados), 2, ',', ' ');

		// 'icon' => '<i class="fa fa-spinner fa-pulse fa-2x"></i>',;
			$tmp = array(
				'id' => $id,
				'nombre' => $el->getNombre_(), 
				'status' => 'done', 
				'n_empleados' => $n_empleados,
				'usuario' => array('n' => $usuario_n, 'p' => $usuario_p), 
				'jefe' => array('n' => $jefe_n, 'p' => $jefe_p), 
				'r_empleado' => array('n' => $r_empleado_n, 'p' => $r_empleado_p), 
				'r_jefe' => array('n' => $r_jefe_n, 'p' => $r_jefe_p), 
				'e_empleado' => array('n' => $e_empleado_n, 'p' => $e_empleado_p), 
				'e_jefe' => array('n' => $e_jefe_n, 'p' => $e_jefe_p), 
				);
		}else{
			$tmp = array(
				'id' => $id,
				'nombre' => $el->getNombre_(), 
				'status' => 'empty', 
				);
		}
		echo json_encode($tmp);
	}

	function estado_proceso_scorecard_area($id,$periodo=null){
		$this->haySession();
		$el = new empresa_area();
		$el->select($id);
		$children = $el->get_all_children($id);
		if($children){
			$child_array = array($id);
			$test = array();
			foreach ($children as $key => $value) {
				array_push($child_array, $value['ids']);
			}
			$children_string=implode(",", $child_array);
		}else{
			$children_string = $id;
		}

		if($periodo){
			$se = new scorer_estado_periodo();
			$count_array = $se->count_personal_in($children_string,"id_area",$periodo);
		}else{
			$se = new scorer_estado();
			$count_array = $se->count_personal_in($children_string,"id_area");
		}

		$indent="";
		for ($i=0; $i < ($el->getNivel()-1); $i++) { 
			$indent .= "- ";
		}
		$n_empleados=$count_array['n_empleados'];
		if($n_empleados){
			$usuario_n=$count_array['usuario'];
			$usuario_p=number_format(($usuario_n*100/$n_empleados), 2, ',', ' ');
			$jefe_n=$count_array['jefe'];
			$jefe_p=number_format(($jefe_n*100/$n_empleados), 2, ',', ' ');
			$r_empleado_n=$count_array['r_empleado'];
			$r_empleado_p=number_format(($r_empleado_n*100/$n_empleados), 2, ',', ' ');
			$r_jefe_n=$count_array['r_jefe'];
			$r_jefe_p=number_format(($r_jefe_n*100/$n_empleados), 2, ',', ' ');
			$e_empleado_n=$count_array['e_empleado'];
			$e_empleado_p=number_format(($e_empleado_n*100/$n_empleados), 2, ',', ' ');
			$e_jefe_n=$count_array['e_jefe'];
			$e_jefe_p=number_format(($e_jefe_n*100/$n_empleados), 2, ',', ' ');

		// 'icon' => '<i class="fa fa-spinner fa-pulse fa-2x"></i>',
			$tmp = array(
				'id' => $id,
				'nombre' => $indent.$el->getNombre_(), 
				'status' => 'done', 
				'n_empleados' => $n_empleados,
				'usuario' => array('n' => $usuario_n, 'p' => $usuario_p), 
				'jefe' => array('n' => $jefe_n, 'p' => $jefe_p), 
				'r_empleado' => array('n' => $r_empleado_n, 'p' => $r_empleado_p), 
				'r_jefe' => array('n' => $r_jefe_n, 'p' => $r_jefe_p), 
				'e_empleado' => array('n' => $e_empleado_n, 'p' => $e_empleado_p), 
				'e_jefe' => array('n' => $e_jefe_n, 'p' => $e_jefe_p), 
				);
		}else{
			$tmp = array(
				'id' => $id,
				'nombre' => $indent.$el->getNombre_(), 
				'status' => 'empty', 
				);
		}
		echo json_encode($tmp);
	}

	function consolidado_empresa(){
		$this->haySession();
		$id=$_POST['id'];
		$el = new empresa_area();
		$el->select($id);
		$children = $el->get_all_children($id);
		if($children){
			$child_array = array($id);
			$test = array();
			foreach ($children as $key => $value) {
				array_push($child_array, $value['ids']);
			}
			$children_string=implode(",", $child_array);
		}else{
			$children_string = $id;
		}

		$indent="";
		for ($i=0; $i < ($el->getNivel()-1); $i++) { 
			$indent .= "- ";
		}

		$lp = new listado_personal_op();
		$count_array = $lp->consolidado_empresa("id_area",$children_string,$id);
		$tconts = $lp->count_column_on_value($id, "id_area","id_tcont",$_POST['tconts']['tipos']);
		$norgs = $lp->count_column_on_value($id, "id_area","id_norg",$_POST['norgs']['tipos']);
		if($count_array['n_empleados_acumulado']){
			$tmp = array(
				'id' => $id,
				'nombre' => $indent.$el->getNombre_(), 
				'nivel' => $el->getNivel(), 
				'status' => 'done', 
				'icon' => '<i class="fa fa-check fa-2x"></i>',
				'n_empleados' => array('especifico' => round($count_array['n_empleados_especifico'],2),'acumulado'=> round($count_array['n_empleados_acumulado'],2)),
				'hombres' => round($count_array['hombres'],2),
				'mujeres' => round($count_array['mujeres'],2),
				'edad' => round($count_array['edad'],2),
				'antiguedad' => round($count_array['antiguedad'],2),
				'sueldos' => round($count_array['sueldos'],2),
				'tconts' => $tconts,
				'norgs' => $norgs
				);
		}else{
			$tmp = array(
				'id' => $id,
				'nombre' => $indent.$el->getNombre_(), 
				'status' => 'empty', 
				);
		}
		echo json_encode($tmp);
	}

	function elim_pregunta(){
		$this->haySession();
		if($_REQUEST){
			$obj = new Sonda_pregunta();
			$obj->setId($_REQUEST['id_p']);
			$obj->setActivo(0);
			$obj->activa_inactiva();
			if($obj->getError())
				echo "0,".$obj->getError();
			else
				echo "1";
		}
	}

	function sonda_tema_elimina(){
		$this->haySession();
		if($_REQUEST){
			$obj = new Sonda_tema();
			$obj->setId($_REQUEST['id_t']);
			$obj->setActivo(0);
			$obj->activa_inactiva();
			if($obj->getError()){
				echo "0,".$obj->getError();
			}
			else{
				$obj_P = new Sonda_pregunta();
				$obj_P->setId_tema($_REQUEST['id_t']);
				$obj_P->setActivo(0);
				$obj_P->activa_inactiva_preguntas();
				if($obj_P->getError())
					echo "0,".$obj_P->getError();
				else
					echo "1";
			}
		}
	}

	function temas_x_sonda_ajax(){
		$this->haySession();
	}
}






