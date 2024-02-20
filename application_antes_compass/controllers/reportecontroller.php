<?php

class ReporteController extends Controller {

	protected $link;
	protected $dir;
	protected $location;
	
	function __construct($model, $controller, $action, $type = 0, $full = false,$render=false) {

		parent::__construct($model, $controller, $action, $type, $full,$render);

		$this->link = $this->Reporte->getDBHandle();
		$this->location=ROOT.DS.'public'.DS.'files'.DS;
	}



	function respaldo($per=2015){
		$this->haySession();
		$this->set('rol',$_SESSION['USER-AD']['user_rol']);
		if (!($_SESSION['USER-AD']['user_rol']<2)) {
			$this->set('custom_warning',"No tiene el permiso par navegar esta sección ".$_SESSION['USER-AD']['user_rol']);
			$this->set('denied',true);
		}else{
			$this->set('denied',false);

			$se = new Scorer_estado();
			$count = $se->count();
			$this->set('count',$count);
			if(isset($_SESSION['calificacion_desemp'])){
				if(sizeof($_SESSION['calificacion_desemp'])==$count){
					$this->set('cache',1);
				}else{
					$_SESSION['calificacion_desemp']=array();
					$_SESSION['reporte_tiempo']=strftime("%d%b%y %H:%M");
					$this->set('cache',0);
				}
			}else{
				$_SESSION['calificacion_desemp']=array();
				$_SESSION['reporte_tiempo']=strftime("%d%b%y %H:%M");
				$this->set('cache',0);
			}

			$scorecard = new Scorecard();
			$scorer = $scorecard->get_scorer($_SESSION['Empresa']['id'],$per);
			$_SESSION['reporte_fecha'] = $scorer['periodo'];
			$_SESSION['reporte_scorer'] = $scorer['detalle'];
		}
	}

	function test(){
		$this->haySession();
	}

	function calificacion_desemp($lim){
		$this->haySession();
		$se = new Scorer_estado(); 
		$lim = $se->esc($lim);
		$res = $se->select_all("LIMIT ".$lim.",10");
		$final = array();
		$scorecard = new Scorecard();
		foreach ($res as $key => $value) {
			$r_scorer = $this->Reporte->get_ScorecardRes($value['id_personal'],$_SESSION['reporte_fecha']);
			$resultado_scorer_p = number_format($r_scorer,2,"."," ").'%';  
			$r_score = $scorecard->scorer_rango($_SESSION['reporte_scorer'],intval($r_scorer)); 
			$compass = round($this->Reporte->getAvg_test_eval($this->Reporte->get_codEval($value['id_personal'])),2); 
			$p_score = $_SESSION['reporte_scorer']->p_score;
			$resultado_ponderado = ($r_score * $p_score / 100)+($compass * (100-$p_score) /100);
			$arr = array(
				'id' => $value['id_personal'],
				'nombre' => $se->htmlprnt_win($value['nombre']),
				'cedula' => $value['cedula'],
				'resultado_scorer_p' => $resultado_scorer_p,
				'resultado_scorer' => $r_score,
				'resultado_compass' => $compass,
				'resultado_ponderado' => $resultado_ponderado
				);
			array_push($_SESSION['calificacion_desemp'], $arr);
		}
	}

	function compass_test(){
		$this->haySession();
		$mt = new multifuente_test();

		$compass_test = $mt->getTest($_SESSION['Empresa']['id']);
		$_SESSION['respaldo'] = array(
			'compass' => array(
				'compass_test' => array(
					'count' => sizeof($compass_test), 
					'data' => $compass_test, 
					),
				), 
			);
		foreach ($compass_test as $key => $value) {
			$_SESSION['respaldo']['compass']['compass_test']['data'][$key]['nombre_test'] = $mt->htmlprnt_win($value['nombre_test']);
			$compass_temas=$mt->getTemas($value["cod_test"]);
			foreach ($compass_temas as $key_ => $value_) {
				$compass_temas[$key_]['tema'] = $mt->htmlprnt_win($value_['tema']);
			}
			$tmp_tema = array(
				'count' => sizeof($compass_temas), 
				'data' => $compass_temas, 
				);
			$_SESSION['respaldo']['compass']['compass_test']['data'][$key]['temas'] = $tmp_tema;
		}
	}

	function compass_evaluado(){
		$this->haySession();
		$me = new multifuente_evaluado();

		$_SESSION['respaldo']['compass']['evaluados'] = $me->getByEmpresa($_SESSION['Empresa']['id']);
	}




	function makeDir($path)	{
		return is_dir($path) || mkdir($path);
	}

	function chr_($val)	{
		return PHPExcel_Cell::stringFromColumnIndex($val);
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
		$this->Sonda->disconnect();
		$this->_template = new Template('Void','render');
		$dispatch = new InicioController('Inicio','inicio','principal',0);
		$dispatch->principal(true);
	}

}






