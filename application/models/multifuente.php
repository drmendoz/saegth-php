<?php

class Multifuente extends Model {

	public function __construct($parameters = array()) {
			parent::__construct();
  }

	public static function getEvaluadores($id,$rel,$cod_evaluado){
		$try = new self();
		$res = $try->query_('SELECT count(relacion) as res FROM `multifuente_evaluadores` WHERE id_evaluado='.$id.' AND relacion='.$rel.' AND cod_evaluado="'.$cod_evaluado.'";',1);
		return $res['res'];
	}
	
	public static function getEvaluadoresLast($id,$rel,$cod_evaluado){
		$try = new self();
		$res = $try->query_('SELECT * FROM `multifuente_evaluadores` WHERE id_evaluado='.$id.' AND relacion='.$rel.' AND cod_evaluado="'.$cod_evaluado.'";');
		return $res;
	}

	public static function countResueltos($id,$rel,$cod_evaluado){
		$try = new self();
		$res = $try->query_('SELECT count(relacion) as res FROM `multifuente_evaluadores` WHERE id_evaluado='.$id.' AND resuelto=1 AND relacion='.$rel.' AND cod_evaluado="'.$cod_evaluado.'";',1);
		return $res['res'];
	}

	public static function esResuelto($cod_evaluado){
		$try = new self();
		$res = $try->query_('SELECT ifnull(count(*),0) as res FROM `multifuente_evaluado` WHERE resuelto=1 AND cod_evaluado="'.$cod_evaluado.'";',1);
		return $res['res'];
	}


	function get_Eval($id,$test=null,$eval=null,$periodo_evaluador=null){

		$periodoEvaluador = 0;
		if($periodo_evaluador != null)
		{
			$periodoEvaluador = $periodo_evaluador;
		}

		if(isset($test) && isset($eval)){
			$res = $this->query('SELECT `cod_evaluado`, `cod_test`,`resuelto`,`fecha` FROM `multifuente_evaluado` WHERE `id_personal`='.$id.' AND `cod_evaluado`="'.$eval.'" AND `cod_test`="'.$test.'"',1);
			if($res){
				$otras = $this->query('SELECT `cod_evaluado`, `cod_test`,`resuelto`,`fecha` FROM `multifuente_evaluado` WHERE `id_personal`='.$id.' ORDER by fecha DESC');
				if((sizeof($otras))<2){
					$_SESSION['evaluado']['otras']=null;
				}else{
					$_SESSION['evaluado']['otras']=$otras;
				}
			}
		}elseif(isset($_SESSION['evaluado']['test']) && isset($_SESSION['evaluado']['id'])){
			$res = $this->query('SELECT `cod_evaluado`, `cod_test`,`resuelto`,`fecha` FROM `multifuente_evaluado` WHERE `id_personal`='.$id.' AND `cod_evaluado`="'.$_SESSION['evaluado']['id'].'" AND `cod_test`="'.$_SESSION['evaluado']['test'].'" AND periodo_evaluador='.$periodoEvaluador.'',1);
			if($res){
				$otras = $this->query('SELECT `cod_evaluado`, `cod_test`,`resuelto`,`fecha` FROM `multifuente_evaluado` WHERE `id_personal`='.$id.' AND periodo_evaluador='.$periodoEvaluador.' ORDER by fecha DESC');
				if((sizeof($otras))<2){
					$_SESSION['evaluado']['otras']=null;
				}else{
					$_SESSION['evaluado']['otras']=$otras;
				}
			}else{
				$res = $this->query('SELECT `cod_evaluado`, `cod_test`,`resuelto`,`fecha` FROM `multifuente_evaluado` WHERE `id_personal`='.$id.' AND periodo_evaluador='.$periodoEvaluador.' ORDER by fecha DESC');
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
			$res = $this->query('SELECT `cod_evaluado`, `cod_test`,`resuelto`,`fecha` FROM `multifuente_evaluado` WHERE `id_personal`='.$id.' AND periodo_evaluador='.$periodoEvaluador.' ORDER by fecha DESC');
			if($res){
							if((sizeof($res))<2){
								$_SESSION['evaluado']['otras']=null;
									$res = $res[0];
							}else{
								$_SESSION['evaluado']['otras']=$res;
								$res = $res[0];
							}}
		}
		return $res;
	}
	
	function hayEvaluacionEnCurso($id_personal=null)
	{
		// Permitir para GRUPO LANEC
		if($_SESSION['USER-AD']['id_empresa'] == 471)
		{
			return true;
		}
		
		$sql = 'SELECT MAX(fecha_max) as fecha 
				FROM multifuente_evaluado 
				WHERE id_empresa = '.$_SESSION['USER-AD']['id_empresa'].' ';
		if(!$id_personal)
			$sql .= "AND id_personal = ".$_SESSION['USER-AD']['id_personal'];
		else
			$sql .= "AND id_personal = ".$id_personal;
		$res=$this->query_($sql,1);

		if($res['fecha']){
			if ($res['fecha'] >= date('Y-m-d'))
				return true;
			else
				return false;
		}else{
			$sql = 'SELECT MAX(fecha_max) as fecha 
					FROM multifuente_evaluadores 
					WHERE id_empresa = '.$_SESSION['USER-AD']['id_empresa'].' ';
			if(!$id_personal)
				$sql .= "AND id_personal = ".$_SESSION['USER-AD']['id_personal'];
			else
				$sql .= "AND id_personal = ".$id_personal;
			$res=$this->query_($sql,1);

			if($res['fecha']){
				if ($res['fecha'] >= date('Y-m-d'))
					return true;
				else
					return false;
			}else{
				return false;
			}
		}
	}
}
