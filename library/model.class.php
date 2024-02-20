<?php
class Model extends SQLQuery {
	protected $_model;

	function __construct() {

		$this->connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
		$this->_model = get_class($this);
		$this->_table = strtolower($this->_model)."s";
		$this->link = $this->getDBHandle();
	}

	function __destruct() {
	}



	/* DATABASE QUERIES */



	/* ADMIN FUNCTIONS */

	public function SelectColFrom($col,$table, $field, $where){
		Util::sessionStart();
		// echo 'SELECT '.$col.' FROM '.$table.' where '.$field.' = "'.$where.'"';
		$Arr = $this->query('SELECT '.$col.' FROM '.$table.' where '.$field.' = "'.$where.'"');
		return $Arr;
	}

	public function esc($data){
		return mysqli_real_escape_string($this->getDBHandle(),$data);
	}

	public function db_prep($data){
		return mysqli_real_escape_string($this->getDBHandle(),serialize($data));
	}

	public function db_prep_($data){
		return serialize($data);
	} 

	public function get_dCond($table, $field, $condition, $field_2, $condition_2){
		//echo 'SELECT * FROM '.$table.' WHERE '.$field.' = "'.$condition.'" AND '.$field_2.' = "'.$condition_2.'"';
		$res = $this->query('SELECT * FROM '.$table.' WHERE '.$field.' = "'.$condition.'" AND '.$field_2.' = "'.$condition_2.'"',1);
		return $res;
	}

	public function DB_exists($table, $field, $condition){
		//echo 'SELECT * FROM '.$table.' WHERE '.$field.' = "'.$condition.'"';
		$res = $this->query('SELECT * FROM '.$table.' WHERE '.$field.' = "'.$condition.'"');
		return $res;
	}

	public function DB_exists_double($table, $field, $condition, $field_2, $condition_2){
		$res = $this->query('SELECT * FROM '.$table.' WHERE '.$field.' = "'.$condition.'" AND '.$field_2.' = "'.$condition_2.'"');
		return $res;
	}

	public function DB_exists_not($table, $field, $condition, $field_2, $condition_2){
		//echo 'SELECT * FROM '.$table.' WHERE '.$field.' = "'.$condition.'" AND NOT ('.$field_2.' = "'.$condition_2.'")<br>';
		$res = $this->query('SELECT * FROM '.$table.' WHERE '.$field.' = "'.$condition.'" AND NOT ('.$field_2.' = "'.$condition_2.'")');
		return $res;
	}

	public function DB_exists_not_null($table, $field, $condition, $field_2){
		//echo 'SELECT * FROM '.$table.' WHERE '.$field.' = "'.$condition.'" AND NOT ('.$field_2.' IS NULL)';
		$res = $this->query('SELECT * FROM '.$table.' WHERE '.$field.' = "'.$condition.'" AND NOT ('.$field_2.' IS NULL)');
		return $res;
	}

	public function DB_exists_null($table, $field, $condition, $field_2){
		//echo 'SELECT * FROM '.$table.' WHERE '.$field.' = "'.$condition.'" AND NOT ('.$field_2.' = "'.$condition_2.'")';
		$res = $this->query('SELECT * FROM '.$table.' WHERE '.$field.' = "'.$condition.'" AND ('.$field_2.' IS NULL)');
		return $res;
	}

	public function DB_exists_trip($table, $field, $condition, $field_2, $condition_2, $field_3, $condition_3){
		//echo 'SELECT * FROM '.$table.' WHERE '.$field.' = "'.$condition.'" AND '.$field_2.' = "'.$condition_2.'"';
		$res = $this->query('SELECT * FROM '.$table.' WHERE '.$field.' = "'.$condition.'" AND '.$field_2.' = "'.$condition_2.'" AND '.$field_3.' = "'.$condition_3.'"');
		return $res;
	}

	public function htmlprnt($string){
		// echo str_replace("ASCII", "", mb_detect_encoding($string));
		// return $string;
		return htmlentities($string, ENT_COMPAT, "ISO-8859-1");
		// return mb_convert_encoding($string, "ISO-8859-1", "UTF-8");
	}

	public function htmlprnt_win($string){
		return iconv('Latin1', 'UTF-8', $string);
	}

	public function image_prep_($file,$table,$field,$match){
		$target_dir = ROOT.DS.'public'.DS."uploads/";
		$filet = "p_".$match. $this->htmlprnt_win(basename($file["name"]));
		// var_dump($file);
		$target_file = $target_dir . $filet;
		file_put_contents($target_file, file_get_contents($file["tmp_name"]));
		//$query = 'UPDATE '.$table.' set foto="'.$filet.'" where '.$field.' = '.$match.';';
		
		if(!$this->verificaLogo())
			$query = 'INSERT INTO '.$table.'(id_empresa,areas,foto) VALUES('.$match.',"1","'.$filet.'")';
		else
			$query = 'UPDATE '.$table.' set foto="'.$filet.'" where '.$field.' = '.$match.';';

		return $query;
	}
	
	public function image_prep__($file,$table,$field,$match){
		$target_dir = ROOT.DS.'public'.DS."uploads/";
		$filet = "p_".$match. $this->htmlprnt_win(basename($file["name"]));
		// var_dump($file);
		$target_file = $target_dir . $filet;
		file_put_contents($target_file, file_get_contents($file["tmp_name"]));
		$query = 'UPDATE '.$table.' set foto="'.$filet.'" where '.$field.' = '.$match.';';

		return $query;
	}
	
	public function verificaLogo()
	{
		$file = $this->query_('SELECT COUNT(*) AS total FROM `empresa_datos` WHERE `id_empresa`='. $_SESSION["Empresa"]["id"] .'',1);
		if($file['total'] > 0)
			return true;
		else
			return false;
	}

	public function htmlImage_($imgfp,$class=null){
		if (isset($imgfp)){
			return '<img class="'.$class.'" src="'.BASEURL."uploads/".$this->htmlprnt_win($imgfp).'">';
		}else{
			return '<img alt="no-image" class="'.$class.'" src="'.BASEURL.'img/default.png'.'">';
		}
	}

	public function arrCreate($table,$arr){
		$otag="<ol>";
		$ctag="</ol>";
		$otag_="<li>";
		$ctag_="</li>";
		$tmp = array_filter($arr);
		if(!empty($tmp)){
			foreach ($arr as $a => $b) {
				$b = reset($b);
				$array = $this->DB_exists($table,'id_superior',$b['id']);
				echo $otag_.'<a href="'.BASEURL.'empresa/definir_area/'.$b['nivel'].'/'.$b['id'].'">'.$this->htmlprnt($b['nombre']).'</a>';
				if($array){	
					echo $otag;
					$this->arrCreate($table,$array);
					echo $ctag;
				}
				echo $ctag_;
			}
			return 0;
		}else{
			echo $otag_.'<a href="'.BASEURL.'empresa/definir_area/0'.'">Definir &aacute;rea del nivel 1</a>'.$ctag_;
		}
		return 0;
	}

	public function arrCreate__($table,$arr){
		$otag="<ol>";
		$ctag="</ol>";
		$otag_="<li>";
		$ctag_="</li>";
		$tmp = array_filter($arr);
		if(!empty($tmp)){
			foreach ($arr as $a => $b) {
				$b = reset($b);
				$array = $this->DB_exists($table,'id_superior',$b['id']);
				echo $otag_.'<a href="'.BASEURL.'empresa/definir_area/'.$b['nivel'].'/'.$b['id'].'">'.$this->htmlprnt($b['nombre']).'---->'.$b['id'].'</a>';
				if($array){	
					echo $otag;
					$this->arrCreate__($table,$array);
					echo $ctag;
				}
				echo $ctag_;
			}
			return 0;
		}else{
			echo $otag_.'<a href="'.BASEURL.'empresa/definir_area/0'.'">Definir &aacute;rea del nivel 1</a>'.$ctag_;
		}
		return 0;
	}

	public function arrWalkSel($table,$arr,$sel){
		$otag="<ol>";
		$ctag="</ol>";
		$otag_="<li>";
		$ctag_="</li>";
		$tmp = array_filter($arr);
		if(!empty($tmp)){
			foreach ($arr as $a => $b) {
				$b = reset($b);
				$array = $this->DB_exists($table,'id_superior',$b['id']);
				echo $otag_.'<a class="'.$sel.'" href="#'.$b['id'].'">'.$this->htmlprnt($b['nombre']).'</a>';
				if($array){	
					echo $otag;
					$this->arrWalkSel($table,$array,$sel);
					echo $ctag;
				}
				echo $ctag_;
			}
			return 0;
		}
		return 0;
	}


	/* MULTIFUENTE QUERIES */



	public function get_codEval($id){
		$res = $this->query('select IFNULL(cod_evaluado,0) from multifuente_evaluado where id_personal='.$id.' ORDER BY fecha desc',1);
		if($res){
			$res = reset($res);
			$res = reset($res);
		}
		return $res;
	}

	public function getNum_eval_rango($eval,$rango){
		$sql = 'SELECT COUNT(DISTINCT id_personal) FROM `multifuente_respuestas` WHERE cod_evaluado="'.$eval.'" AND rango="'.$rango.'" ';
		$res = $this->query($sql,1);
		$res = reset($res);
		$res = reset($res);
		return $res;
	}

	public function getAvg_test_eval($eval){
		$x = 0;
		$ger = self::getAvg_test_eval_rango($eval,"Gerente");
		$par = self::getAvg_test_eval_rango($eval,"Par");
		$sub = self::getAvg_test_eval_rango($eval,"Subalterno");
		if($ger>0)
			$x++;
		if($par>0)
			$x++;
		if($sub>0)
			$x++;
		if(!$x)
			$x++;
		return (($ger+$par+$sub)/$x);
	}

	public function getAvg_test_eval_rango($eval,$rango){
		if($eval){
			$sql = 'SELECT SUM(`respuesta`),COUNT(`respuesta`) FROM multifuente_respuestas as mr JOIN preguntas_360 as mp on mr.cod_pregunta = mp.cod_pregunta where mr.rango="'.$rango.'" AND not(mr.respuesta="N") AND mr.cod_evaluado="'.$eval.'" AND mp.negativo="si"';
			$res = $this->query($sql,1);
			$res = reset($res);
			$neg = $res['SUM(`respuesta`)'];
			$tn = $res['COUNT(`respuesta`)'];
			$sql = 'SELECT SUM(`respuesta`),COUNT(`respuesta`) FROM multifuente_respuestas as mr JOIN preguntas_360 as mp on mr.cod_pregunta = mp.cod_pregunta where mr.rango="'.$rango.'" AND not(mr.respuesta="N") AND mr.cod_evaluado="'.$eval.'" AND mp.negativo IS NULL';
			$res = $this->query($sql,1);
			$res = reset($res);
			$pos = $res['SUM(`respuesta`)'];
			$tp = $res['COUNT(`respuesta`)'];
			if(isset($neg) && isset($pos)){
				$neg = $neg/$tn;
				$neg = 6-$neg;
				$total = ($neg+$pos)/(1+$tp);
			}elseif(!isset($neg) && isset($pos)){
				$total = $pos/$tp;
			}elseif(isset($neg) && !isset($pos)){
				$neg = $neg/$tn;
				$total = 6-$neg;
			}elseif(!isset($neg) && !isset($pos)){
				$total = 0;
			}
			return number_format((float)$total, 2, '.', '');
		}else{
			return number_format((float)0, 2, '.', '');
		}
	}

	public function getAvg_tema($cod){
		$sql = 'SELECT SUM(`respuesta`),COUNT(`respuesta`) FROM `multifuente_respuestas` as mr JOIN `preguntas_360` as mp ON mr.cod_pregunta=mp.cod_pregunta WHERE mr.cod_tema="'.$cod.'" AND (mp.negativo="si") AND NOT(mr.rango="Auto" OR mr.respuesta="N")';
		$res = $this->query($sql,1);
		$res = reset($res);
		$neg = $res['SUM(`respuesta`)'];
		$tn = $res['COUNT(`respuesta`)'];
		$sql = 'SELECT SUM(`respuesta`),COUNT(`respuesta`) FROM `multifuente_respuestas` as mr JOIN `preguntas_360` as mp ON mr.cod_pregunta=mp.cod_pregunta WHERE mr.cod_tema="'.$cod.'" AND (mp.negativo IS NULL) AND NOT(mr.rango="Auto" OR mr.respuesta="N")';
		$res = $this->query($sql,1);
		$res = reset($res);
		$pos = $res['SUM(`respuesta`)'];
		$tp = $res['COUNT(`respuesta`)'];
		if(isset($neg) && isset($pos)){
			$neg = $neg/$tn;
			$neg = 6-$neg;
			$total = ($neg+$pos)/(1+$tp);
		}elseif(!isset($neg) && isset($pos)){
			$total = $pos/$tp;
		}elseif(isset($neg) && !isset($pos)){
			$neg = $neg/$tn;
			$total = 6-$neg;
		}elseif(!isset($neg) && !isset($pos)){
			$total = 0;
		}
		return $total;
	}

	public function getAvg_tema_eval($cod,$eval){
		$x = 0;
		$ger = self::getAvg_tema_eval_rango($cod,$eval,"Gerente");
		$par = self::getAvg_tema_eval_rango($cod,$eval,"Par");
		$sub = self::getAvg_tema_eval_rango($cod,$eval,"Subalterno");
		if($ger>0)
			$x++;
		if($par>0)
			$x++;
		if($sub>0)
			$x++;
		if(!$x)
			$x++;
		return (($ger+$par+$sub)/$x);
	}

	public function getAvg_tema_eval_($cod,$eval){
		$x = 0;
		$ger = self::getAvg_tema_eval_rango_($cod,$eval,"Gerente");
		$par = self::getAvg_tema_eval_rango_($cod,$eval,"Par");
		$sub = self::getAvg_tema_eval_rango_($cod,$eval,"Subalterno");
		if($ger>0)
			$x++;
		if($par>0)
			$x++;
		if($sub>0)
			$x++;
		if(!$x)
			$x++;
		return (($ger+$par+$sub)/$x);
	}

	public function getAvg_tema_eval_rango_($cod,$eval,$rango){
		$sql = 'SELECT AVG(`respuesta`) 
				FROM `multifuente_respuestas` AS mr 
				WHERE mr.cod_tema="'.$cod.'" 
				AND mr.cod_evaluado="'.$eval.'" 
				AND (mr.rango="'.$rango.'") 
				AND NOT (mr.respuesta="N") ';
		$res = $this->query($sql,1);
		$res = reset($res);
		$res = reset($res);
		if($res){
			$sql = 'SELECT `id` FROM `preguntas_360`  WHERE `cod_pregunta`="'.$cod.'" AND `negativo` =  "si"';
			$r = $this->query($sql);
			if($r){
				$res = 6-$res;
			}
		}
		return $res;
	}

	public function getInAvg_tema_($cod,$eval){
		$x = 0;
		$ger = self::getInAvg_tema_rang($cod,$eval,"Gerente");
		$par = self::getInAvg_tema_rang($cod,$eval,"Par");
		$sub = self::getInAvg_tema_rang($cod,$eval,"Subalterno");
		if($ger>0)
			$x++;
		if($par>0)
			$x++;
		if($sub>0)
			$x++;
		if(!$x)
			$x++;
		return (($ger+$par+$sub)/$x);
	}

	public function getInAvg_tema_rang($cod,$eval,$rango){
		$sql = 'SELECT AVG(`respuesta`) 
				FROM `multifuente_respuestas` AS mr 
				WHERE mr.cod_tema="'.$cod.'" 
				AND (mr.rango="'.$rango.'") 
				AND NOT((mr.rango="Auto") OR (mr.respuesta="N")) 
				AND (mr.cod_evaluado IN (SELECT `cod_evaluado` FROM multifuente_evaluado WHERE `id_empresa`='.$eval.') )';
		$res = $this->query($sql,1);
		$res = reset($res);
		$res = reset($res);
		if($res){
			$sql = 'SELECT `id` FROM `preguntas_360`  WHERE `cod_pregunta`="'.$cod.'" AND `negativo` =  "si"';
			$r = $this->query($sql);
			if($r){
				$res = 6-$res;
			}
		}
		return $res;
	}

	public function getAvg_tema_eval_rango($cod,$eval,$rango){
		$sql = 'SELECT SUM(`respuesta`),COUNT(`respuesta`) FROM `multifuente_respuestas` as mr JOIN preguntas_360 as mp ON mr.cod_pregunta=mp.cod_pregunta WHERE mr.cod_tema="'.$cod.'" AND mr.cod_evaluado="'.$eval.'" AND (mr.rango="'.$rango.'") AND NOT (mr.respuesta="N") AND mp.negativo="si"';
		$res = $this->query($sql,1);
		$res = reset($res);
		$neg = $res['SUM(`respuesta`)'];
		$tn = $res['COUNT(`respuesta`)'];
		$sql = 'SELECT SUM(`respuesta`),COUNT(`respuesta`) FROM `multifuente_respuestas` as mr JOIN preguntas_360 as mp ON mr.cod_pregunta=mp.cod_pregunta WHERE mr.cod_tema="'.$cod.'" AND mr.cod_evaluado="'.$eval.'" AND (mr.rango="'.$rango.'") AND NOT (mr.respuesta="N") AND mp.negativo IS NULL';
		$res = $this->query($sql,1);
		$res = reset($res);
		$pos = $res['SUM(`respuesta`)'];
		$tp = $res['COUNT(`respuesta`)'];
		if(isset($neg) && isset($pos)){
			$neg = $neg/$tn;
			$neg = 6-$neg;
			$total = ($neg+$pos)/(1+$tp);
		}elseif(!isset($neg) && isset($pos)){
			$total = $pos/$tp;
		}elseif(isset($neg) && !isset($pos)){
			$neg = $neg/$tn;
			$total = 6-$neg;
		}elseif(!isset($neg) && !isset($pos)){
			$total = 0;
		}
		return number_format((float)$total, 2, '.', '');
	}

	public function getAvg_preg($cod){
		$sql = 'SELECT AVG(`respuesta`) FROM `multifuente_respuestas` WHERE NOT((rango="Auto") OR (respuesta="N")) AND `cod_pregunta`="'.$cod.'"';
		$res = $this->query($sql,1);
		$res = reset($res);
		$res = reset($res);
		$sql = 'SELECT `id` FROM `preguntas_360`  WHERE `cod_pregunta`="'.$cod.'" AND `negativo` =  "si"';
		$r = $this->query($sql);
		if($r){
			$res = 6-$res;
		}
		return $res;
	}

	public function getAvg_preg_eval($cod,$eval){
		$x = 0;
		$ger = self::getAvg_preg_rang($cod,$eval,"Gerente");
		$par = self::getAvg_preg_rang($cod,$eval,"Par");
		$sub = self::getAvg_preg_rang($cod,$eval,"Subalterno");
		if($ger>0)
			$x++;
		if($par>0)
			$x++;
		if($sub>0)
			$x++;
		if(!$x)
			$x++;
		return (($ger+$par+$sub)/$x);
	}

	public function getAvg_preg_rang($cod,$eval,$rango){
		$sql = 'SELECT AVG(`respuesta`) FROM `multifuente_respuestas` WHERE NOT(respuesta="N") AND `rango`="'.$rango.'" AND `cod_pregunta`="'.$cod.'" AND `cod_evaluado`="'.$eval.'"';
		$res = $this->query($sql,1);
		$res = reset($res);
		$res = reset($res);
		if($res){
			$sql = 'SELECT `id` FROM `preguntas_360`  WHERE `cod_pregunta`="'.$cod.'" AND `negativo` =  "si"';
			$r = $this->query($sql);
			if($r){
				$res = 6-$res;
			}
		}
		return $res;
	}

	public function getInAvg_preg_($cod,$eval){
		$x = 0;
		$ger = self::getInAvg_preg_rang($cod,$eval,"Gerente");
		$par = self::getInAvg_preg_rang($cod,$eval,"Par");
		$sub = self::getInAvg_preg_rang($cod,$eval,"Subalterno");
		if($ger>0)
			$x++;
		if($par>0)
			$x++;
		if($sub>0)
			$x++;
		if(!$x)
			$x++;
		return (($ger+$par+$sub)/$x);
	}

	public function getInAvg_tema($cod,$eval){
		$sql = 'SELECT SUM(`respuesta`),COUNT(`respuesta`) FROM `multifuente_respuestas` as mr JOIN preguntas_360 as mp ON mr.cod_pregunta=mp.cod_pregunta JOIN multifuente_evaluado as me ON mr.cod_evaluado=me.cod_evaluado WHERE mr.cod_tema="'.$cod.'" AND NOT((mr.rango="Auto") OR (mr.respuesta="N")) AND me.id_empresa='.$eval.' AND mp.negativo="si"';
		$res = $this->query($sql,1);
		$res = reset($res);
		$neg = $res['SUM(`respuesta`)'];
		$tn = $res['COUNT(`respuesta`)'];
		$sql = 'SELECT SUM(`respuesta`),COUNT(`respuesta`) FROM `multifuente_respuestas` as mr JOIN preguntas_360 as mp ON mr.cod_pregunta=mp.cod_pregunta JOIN multifuente_evaluado as me ON mr.cod_evaluado=me.cod_evaluado WHERE mr.cod_tema="'.$cod.'" AND NOT((mr.rango="Auto") OR (mr.respuesta="N")) AND me.id_empresa='.$eval.' AND mp.negativo IS NULL';
		$res = $this->query($sql,1);
		$res = reset($res);
		$pos = $res['SUM(`respuesta`)'];
		$tp = $res['COUNT(`respuesta`)'];
		if(isset($neg) && isset($pos)){
			$neg = $neg/$tn;
			$neg = 6-$neg;
			$total = ($neg+$pos)/(1+$tp);
		}elseif(!isset($neg) && isset($pos)){
			$total = $pos/$tp;
		}elseif(isset($neg) && !isset($pos)){
			$neg = $neg/$tn;
			$total = 6-$neg;
		}elseif(!isset($neg) && !isset($pos)){
			$total = 0;
		}
		return $total;
	}

	public function getInAvg_preg($cod,$eval){
		$sql = 'SELECT AVG(`respuesta`) FROM `multifuente_respuestas` WHERE NOT((rango="Auto") OR (respuesta="N")) AND `cod_pregunta`="'.$cod.'" AND (cod_evaluado IN (SELECT `cod_evaluado` FROM multifuente_evaluado WHERE `id_empresa`='.$eval.') )';
		$res = $this->query($sql,1);
		$res = reset($res);
		$res = reset($res);
		$sql = 'SELECT `id` FROM `preguntas_360`  WHERE `cod_pregunta`="'.$cod.'" AND `negativo` =  "si"';
		$r = $this->query($sql);
		if($r){
			$res = 6-$res;
		}
		return $res;
	}

	public function getInAvg_preg_rang($cod,$eval,$rango){
		$sql = 'SELECT AVG(`respuesta`) FROM `multifuente_respuestas` WHERE NOT(`respuesta`="N") AND `rango`="'.$rango.'" AND `cod_pregunta`="'.$cod.'" AND (cod_evaluado IN (SELECT `cod_evaluado` FROM multifuente_evaluado WHERE `id_empresa`='.$eval.') )';
		$res = $this->query($sql,1);
		$res = reset($res);
		$res = reset($res);
		if($res){
			$sql = 'SELECT `id` FROM `preguntas_360`  WHERE `cod_pregunta`="'.$cod.'" AND `negativo` =  "si"';
			$r = $this->query($sql);
			if($r){
				$res = 6-$res;
			}
		}
		return $res;
	}

	public function get_progressByEval($id){
		// $res = $this->query('SELECT COUNT(`id_personal`) FROM `multifuente_evaluadores` WHERE `fecha_max`>CURDATE() AND `resuelto`=0 AND `id_evaluado`='.$id.'',1);
		$res = $this->query('SELECT COUNT(`id_personal`) FROM `multifuente_evaluadores` WHERE `resuelto`=0 AND `id_evaluado`='.$id.'',1);
		$res = reset($res);
		$_faltan = $test = $res["COUNT(`id_personal`)"];
		// $res = $this->query('SELECT COUNT(`id_personal`) FROM `multifuente_evaluadores` WHERE `fecha_max`>CURDATE() AND `id_evaluado`='.$id.'',1);
		$res = $this->query('SELECT COUNT(`id_personal`) FROM `multifuente_evaluadores` WHERE `id_evaluado`='.$id.'',1);
		$res = reset($res);
		$_total = $test = $res["COUNT(`id_personal`)"];
		// $res = $this->query('SELECT COUNT(`id_personal`) FROM `multifuente_evaluado` WHERE `fecha_max`>CURDATE() AND `resuelto`=0 AND `id_personal`='.$id.'',1);
		$res = $this->query('SELECT COUNT(`id_personal`) FROM `multifuente_evaluado` WHERE `resuelto`=0 AND `id_personal`='.$id.'',1);
		$res = reset($res);
		$faltan = $test = $res["COUNT(`id_personal`)"];
		// $res = $this->query('SELECT COUNT(`id_personal`) FROM `multifuente_evaluado` WHERE `fecha_max`>CURDATE() AND `id_personal`='.$id.'',1);
		$res = $this->query('SELECT COUNT(`id_personal`) FROM `multifuente_evaluado` WHERE `id_personal`='.$id.'',1);
		$res = reset($res);
		$total = $test = $res["COUNT(`id_personal`)"];
		if(!($total || $faltan || $_total || $_faltan))
			return 100;
		return (100-((($_faltan + $faltan) * 100)/($_total+$total)));
	}

	public function get_progressByArea($id){
		// $res = $this->query('SELECT COUNT(`id_personal`) FROM `multifuente_evaluado` WHERE `fecha_max`>CURDATE() AND `resuelto`=0 AND `id_personal` IN (SELECT id_personal FROM personal_empresa WHERE id_area='.$id.')',1);
		$res = $this->query('SELECT COUNT(`id_personal`) FROM `multifuente_evaluado` WHERE `resuelto`=0 AND `id_personal` IN (SELECT id_personal FROM personal_empresa WHERE id_area='.$id.')',1);
		$res = reset($res);
		$_faltan = $test = $res["COUNT(`id_personal`)"];
		// $res = $this->query('SELECT COUNT(`id_personal`) FROM `multifuente_evaluado` WHERE `fecha_max`>CURDATE() AND `id_personal` IN (SELECT id_personal FROM personal_empresa WHERE id_area='.$id.')',1);
		$res = $this->query('SELECT COUNT(`id_personal`) FROM `multifuente_evaluado` WHERE `id_personal` IN (SELECT id_personal FROM personal_empresa WHERE id_area='.$id.')',1);
		$res = reset($res);
		$_total = $test = $res["COUNT(`id_personal`)"];
		if(!$_total)
			return 0;
		else
			return (100-((($_faltan) * 100)/($_total)));
	}

	public function get_cantByArea($id){
		// $res = $this->query('SELECT COUNT(`id_personal`) as total FROM `multifuente_evaluado` WHERE `fecha_max`>CURDATE() AND `resuelto`=1 AND `id_personal` IN (SELECT id_personal FROM personal_empresa WHERE id_area='.$id.')',1);
		$res = $this->query('SELECT COUNT(`id_personal`) as total FROM `multifuente_evaluado` WHERE `id_personal` IN (SELECT id_personal FROM personal_empresa WHERE id_area='.$id.')',1);
		$res = reset($res);
		$total = $test = $res["total"];
		return $total;
	}

	public function get_progressByGerente($id){
		// $res = $this->query('SELECT COUNT(`id_personal`) FROM `multifuente_evaluado` WHERE `fecha_max`>CURDATE() AND `resuelto`=0 AND `id_personal` IN (SELECT DISTINCT id_evaluado FROM multifuente_evaluadores WHERE relacion=0 AND id_personal='.$id.')',1);
		$res = $this->query('SELECT COUNT(`id_personal`) FROM `multifuente_evaluado` WHERE `resuelto`=0 AND `id_personal` IN (SELECT DISTINCT id_evaluado FROM multifuente_evaluadores WHERE (relacion=0 OR relacion=1) AND id_personal='.$id.')',1);
		$res = reset($res);
		$_faltan = $test = $res["COUNT(`id_personal`)"];
		// $res = $this->query('SELECT COUNT(`id_personal`) FROM `multifuente_evaluado` WHERE `fecha_max`>CURDATE() AND `id_personal` IN (SELECT DISTINCT id_evaluado FROM multifuente_evaluadores WHERE relacion=0 AND id_personal='.$id.')',1); //
		$res = $this->query('SELECT COUNT(`id_personal`) FROM `multifuente_evaluado` WHERE `id_personal` IN (SELECT DISTINCT id_evaluado FROM multifuente_evaluadores WHERE (relacion=0 OR relacion=1) AND id_personal='.$id.')',1); //
		$res = reset($res);
		$_total = $test = $res["COUNT(`id_personal`)"];
		if(!$_total)
			return 0;
		else
			return (100-((($_faltan) * 100)/($_total)));
	}

	/* SCORECARD VALUES */

	public function get_ScorecardRes($id,$periodo=2015){
		$res = $this->query_('select ifnull(sum(ppond),0) as res from scorer_objetivo where id_personal='.$id.' and periodo='.$periodo.'',1);
		// var_dump($res);
		$val = $res['res'];
		$val += $val * ($this->get_ajuste($id)/100);
		return $val;
	}

	public function get_ajuste($id){
		$scorer = $this->query_('SELECT ajuste FROM scorer_estado WHERE id_personal='.$id.'',1);
		return $scorer['ajuste'];
	}




	/* GET FROM ID */




	

	public function get_pname($id,$usrol=1){
		Util::sessionStart();
		switch ($usrol) {
			case 1:
			$res = $this->query('SELECT nombre_p FROM `personal` WHERE `id`="'.$id.'"',1);
			break;
			case 2:
			$res = $this->query('SELECT admin FROM `empresa` WHERE `id`="'.$id.'"',1);
			break;
			
			default:
				# code...
			break;
		}	
		$res = @reset($res);
		$res = @reset($res);
		return $res;
	}

	public function get_preg($cod){
		$res = $this->query('SELECT pregunta FROM `preguntas_360` WHERE `cod_pregunta`="'.$cod.'"',1);
		$res = @reset($res);
		$res = @reset($res);
		return self::htmlprnt($res);
	}

	public function get_pregPDF($cod){
		$res = $this->query('SELECT pregunta FROM `preguntas_360` WHERE `cod_pregunta`="'.$cod.'"',1);
		$res = @reset($res);
		$res = @reset($res);
		return $res;
	}

	public function get_tema($cod){
		$res = $this->query('SELECT tema,descripcion FROM `temas_360` WHERE `cod_tema`="'.$cod.'"',1);
		$res = @reset($res);
		return $res;
	}

	public function get_test($cod){
		//echo 'SELECT nombre_test FROM `multifuente_test` WHERE `cod_pregunta`="'.$cod.'"';
		$res = $this->query('SELECT nombre_test FROM `multifuente_test` WHERE `cod_test`="'.$cod.'"',1);
		$res = @reset($res);
		$res = @reset($res);
		return self::htmlprnt($res);
	}

	public function get_id($cod){
		$res = $this->query('SELECT `id_personal` FROM `multifuente_evaluado` WHERE `cod_evaluado`="'.$cod.'"',1);
		$res = @reset($res);
		$res = @reset($res);
		return $res;
	}

	public function get_name($cod){
		$res = $this->query('SELECT `nombre_p` FROM `personal` WHERE `id`="'.self::get_id($cod).'"',1);
		$res = @reset($res);
		$res = @reset($res);
		return $res;
	}

	public function get_emailById($cod){
		$res = $this->query('SELECT `email` FROM `personal_datos` WHERE `id_persona`="'.$cod.'"',1);
		$res = @reset($res);
		$res = @reset($res);
		return $res;
	}

	public function hasSuperior($id){
		$res = $this->query('SELECT `pid_sup` FROM `personal_empresa` WHERE `id_personal`="'.$id.'"',1);
		if($res){
			$res = @reset($res);
			$res = @reset($res);
			return $res;
		}else{
			return false;
		}
	}

	public function get_usrById($id){
		$res = $this->query('SELECT `user_name` FROM `users` WHERE `id_personal`="'.$id.'"',1);
		$res = @reset($res);
		$res = @reset($res);
		return $res;
	}

	public function get_empById($id){
		$res = $this->query('SELECT `id_empresa` FROM `users` WHERE `id_personal`="'.$id.'"',1);
		$res = @reset($res);
		$res = @reset($res);
		return $res;
	}

	public function get_area($cod){
		$res = $this->query('SELECT `nombre` FROM `empresa_area` WHERE `id`="'.$cod.'"',1);
		echo mysqli_error($this->link);
		$res = @reset($res);
		$res = @reset($res);
		return $res;
	}

	public function get_localidad($cod){
		$res = $this->query('SELECT `nombre` FROM `empresa_local` WHERE `id`="'.$cod.'"',1);
		echo mysqli_error($this->link);
		$res = @reset($res);
		$res = @reset($res);
		return $res;
	}

	public function get_cargo($cod){
		$res = $this->query('SELECT `nombre` FROM `empresa_cargo` WHERE `id`="'.$cod.'"',1);
		echo mysqli_error($this->link);
		$res = @reset($res);
		$res = @reset($res);
		return $res;
	}

	public function get_cond($cod){
		$res = $this->query('SELECT `nombre` FROM `empresa_cond` WHERE `id`="'.$cod.'"',1);
		if(!$res)
			return 'No esta definido';
		echo mysqli_error($this->link);
		$res = @reset($res);
		$res = @reset($res);
		return $res;
	}

	public function get_condSup($cod){
		$res = $this->query('SELECT `id_superior` FROM `empresa_cond` WHERE `id`="'.$cod.'"',1);
		echo mysqli_error($this->link);
		$res = @reset($res);
		$res = @reset($res);
		$res = $this->query('SELECT `nombre` FROM `empresa_cond` WHERE `id`="'.$res.'"',1);
		echo mysqli_error($this->link);
		$res = @reset($res);
		$res = @reset($res);
		return $res;
	}

	public function isCondChild($pcd,$cod){
		$res = $this->query('SELECT `id` FROM `empresa_cond` WHERE `id`="'.$cod.'" AND `id_superior`="'.$pcd.'"',1);
		echo mysqli_error($this->link);
		if($res){
			return true;
		}else{
			return false;
		}
	}

	public function get_norg($cod){
		$res = $this->query('SELECT `nombre` FROM `empresa_norg` WHERE `id`="'.$cod.'"',1);
		echo mysqli_error($this->link);
		$res = @reset($res);
		$res = @reset($res);
		return $res;
	}

	public function get_tcont($cod){
		$res = $this->query('SELECT `nombre` FROM `empresa_tcont` WHERE `id`="'.$cod.'"',1);
		echo mysqli_error($this->link);
		$res = @reset($res);
		$res = @reset($res);
		return $res;
	}

	public function get_eciv($cod){
		switch ($cod) {
			case 1:
			$res = 'Soltero';
			break;
			case 2:
			$res = 'Casado';
			break;
			case 3:
			$res = 'Viudo';
			break;
			case 4:
			$res = 'Divorciado';
			break;
			case 5:
			$res = 'Union libre';
			break;
			case 6:
			$res = 'No definido';
			break;
		}
		return $res;
	}

	public function get_empdat($id,$eval=null){
		$dat = $this->query_('SELECT * FROM `listado_personal_op` WHERE `id`=' . $id . '',1);
		$nombre = $dat['nombre'];
		$cargo = $dat['cargo'];
		$area = $dat['area'];
		$local = $dat['local'];
		$tc = $dat['tcont'];
		$nsup = $dat['pid_nombre'];
		if(isset($eval)){
			$sql_periodo = "";
			if (isset($_SESSION['isReinicio'])) {
				$sql_periodo = " AND periodo = ".$_SESSION['isReinicio']['id'];
			}
			$res = $this->query_('SELECT DISTINCT fecha FROM multifuente_evaluadores WHERE id_evaluado='.$id.' AND cod_evaluado="'.$eval.'" '.$sql_periodo.' ORDER BY fecha ASC',1);
			$fecha = $res['fecha'];
			return $dat=array($nombre, $cargo, $area, $nsup, $fecha);
		}
		return $dat=array($nombre, $cargo, $area,$local,$tc,$nsup,$dat['id_norg'],$dat['salario'],0,$dat['id_cond']);
	}

	public function get_testdat($id){
		$nombre = self::get_pname($id);
		$dat = $this->query_('SELECT `compass_360`,`matriz`,`scorer` FROM `personal_test` WHERE `id_personal`=' . $id . '',1);
		return $dat;
	}

	public function get_color($prom){
		if ($prom > 3.32){
			$color="#00FF00";
		}elseif (($prom > 1.65)&&($prom < 3.33)) {
			$color="#FFFF00";
		}elseif ($prom < 1.66) {
			$color="#990000";
		}
		return $color; 
	}

	public function print_fecha($fecha){
		return strftime("%d de %B del %Y",strtotime($fecha));
	}

	public function compass($id){
		$res = $this->query('SELECT `compass_360` FROM `personal_test` WHERE `id_personal`="'.$id.'"',1);
		echo mysqli_error($this->link);
		$res = @reset($res);
		$res = @reset($res);
		return $res;		
	}

	public function get_matriz($id){
		$res = $this->query_('SELECT `valor` FROM `matriz_definicion` WHERE `id_personal`="'.$id.'"',1);
		if($res){
			$res = @reset($res);
			return $res;		
		}else
		return 0;
	}
	
	
	function detalle_vista_hijo($id_padre,$periodo)
	{
	   $otag="<ol>";
		$ctag="</ol>";
		$otag_="<li>";
		$ctag_="</li>";	 
         $det = $this->query_('SELECT t.*,ifnull(t.id_padre,t.id)as padre from scorer_objetivo t WHERE id_padre = '.$id_padre.' AND periodo='.$periodo.'  order by padre');
	  		
		   if (count($det)){
			foreach($det as $d)
                        {
			 echo $otag_.$d["objetivo"];
			 
			   $this->detalle_vista_hijo($d["id"],$periodo);
			 echo $ctag_;
                        }
		}	
	}
	
	function vista_scorecard($id_empresa,$periodo,$id_personal)
	{ 
	  $res = $this->query_('select * from (SELECT s2.id, s2.id_personal, s2.objetivo, s2.indicador, s2.periodo, s2.unidad, s2.meta, s2.peso, s2.lreal, s2.lpond, s2.ppond, s2.inverso, s2.id_padre, s2.id_padre_sup FROM scorer_objetivo r, users u, scorer_objetivo s2  
WHERE r.id_personal=u.id_personal and r.id_personal=u.id_personal and u.id_empresa= '. $id_empresa. '  and r.id_padre is null /*and r.id_padre_sup is null*/ and r.periodo='.$periodo. ' and r.id_personal='.$id_personal.' and r.id_padre_sup=s2.id 
 group by s2.id, s2.id_personal, s2.objetivo, s2.indicador, s2.periodo, s2.unidad, s2.meta, s2.peso, s2.lreal, s2.lpond, s2.ppond, s2.inverso, s2.id_padre, s2.id_padre_sup
union
select s2.id, s2.id_personal, s2.objetivo, s2.indicador, s2.periodo, s2.unidad, s2.meta, s2.peso, s2.lreal, s2.lpond, s2.ppond, s2.inverso, s2.id_padre, s2.id_padre_sup from scorer_objetivo  s2 where id_personal='.$id_personal.' and periodo='.$periodo. '  and id_padre_sup is null) x order by x.id_personal');
	  if($res){
			//$res = @reset($res);
			return $res;		
		}else
		return 0;
	}
	
	function vista_scorecard2($id,$id_empresa,$periodo)
	{ if ($id==1129){
	  $res = $this->query_("SELECT objetivo, indicador FROM scorer_objetivo r, users u  WHERE r.id_personal=u.id_personal and r.periodo=$periodo and objetivo LIKE 'DINAR OE%'  and id_empresa=$id_empresa group by objetivo, indicador");
	  }
	  if ($id==1130){
	  $res = $this->query_("SELECT objetivo, indicador FROM scorer_objetivo r, users u  WHERE r.id_personal=u.id_personal and r.periodo=$periodo and objetivo LIKE 'R MER OE%'  and id_empresa=$id_empresa group by objetivo, indicador");
	  }
	  if ($id==1131){
	  $res = $this->query_("SELECT objetivo, indicador FROM scorer_objetivo r, users u  WHERE r.id_personal=u.id_personal and r.periodo=$periodo and objetivo LIKE 'R PRO OE%'  and id_empresa=$id_empresa group by objetivo, indicador");
	  }
	  if($res){
			//$res = @reset($res);
			return $res;		
		}else
		return 0;
	}
	
	
	function detalle_vista($sup,$id,$periodo)
	{ 
	   $res = $this->query_('SELECT * FROM scorer_objetivo r where r.id_padre_sup='.$sup.' and id_personal='.$id.' and periodo='.$periodo. ' order by objetivo' );
	  if($res){
			//$res = @reset($res);
			return $res;		
		}else
		return 0;
	}
	
	
	
	function detalle_vista2($id,$objetivo,$periodo)
	{ 
	  //$res = $this->query_('SELECT t.*,ifnull(t.id_padre,t.id)as padre from scorer_objetivo t WHERE id_personal = '.$id.' AND periodo='.$periodo.' order by padre');
	  $res = $this->query_('SELECT * FROM scorer_objetivo r WHERE (r.id_padre = '.$id.'  or r.id_padre_sup = '.$id.') and r.periodo='.$periodo.' order by 1');
	  if($res){
			//$res = @reset($res);
			return $res;		
		}else
		return 0;
	}
	
	function objetivo_general($id_empresa,$fecha)
	{ 
	  $res = $this->query_("SELECT  o.id, o.id_personal,CASE WHEN  e.nombre='Dirección Nacional de Registro de Datos Públicos' THEN 'DINARDAP' else e.nombre END empresa,l.nombre localidad,
 a.nombre  area_emp,
p.nombre_p, c.nombre cargo, o.objetivo, o.indicador, o.inverso,o.unidad,  fnc_meta(o.meta) meta, o.peso,  CASE WHEN o.lreal= '' THEN 0 WHEN o.lreal ='NULL' THEN 0 END lreal, CONCAT(((o.lreal/fnc_meta(o.meta))*100),'%') lpond ,  CONCAT(((o.lreal/fnc_meta(o.meta))*o.peso),'%')   ppond
FROM scorer_objetivo o, personal p, empresa e, personal_empresa pe, empresa_area a, empresa_local l, empresa_cargo c
WHERE o.id_personal=p.id
AND p.id_empresa=e.id
AND e.id=pe.id_empresa
AND a.id_empresa=e.id
AND pe.id_area=a.id
AND l.id_empresa=e.id
AND pe.id_local=l.id
AND p.id=pe.id_personal
AND c.id_empresa=e.id
AND c.id=pe.id_cargo
AND o.periodo=$fecha
and e.id=$id_empresa
ORDER BY e.id");
	  if($res){
			//$res = @reset($res);
			return $res;		
		}else
		return 0;
	}
	
	function detalle_vista_p($objetivo,$periodo,$id_empresa)
	{ 
	  $res = $this->query_("SELECT r.* FROM scorer_objetivo r, users u  WHERE r.id_personal=u.id_personal
 and r.periodo=$periodo and id_padre_sup in(SELECT r.id FROM scorer_objetivo r, users u  WHERE r.id_personal=u.id_personal and r.periodo=$periodo 
and objetivo like CONCAT(substr('". $this->htmlprnt($objetivo) ."',1,9),'%')  and id_empresa=$id_empresa)  
and id_empresa=$id_empresa");
	  if($res){
			//$res = @reset($res);
			return $res;		
		}else
		return 0;
	}
	
	function suma_valores($arr,$col)
	{ 
	  $total=count($arr);
	  foreach($arr as $a)
	  {
	    if(isset($a["meta"]))
            {
	      $meta = unserialize($a["meta"]) ;
              for ($e=0; $e < $col; $e++) {
                if(isset($meta[$e]))$m=$meta[$e];
                }
	     }
	     $peso=100/$total;
	     $dat["meta"]+=$m;
	     $dat["lreal"]+=$a["lreal"];
	     $res+= ($a["lreal"]/$m)*$peso;
	     $c+=$peso*$res;
	     $dat["peso"]+=$peso;
	     //$dat["res"]+=$res;
	  }
	  $dat["respor"]=$res;//($dat["lreal"]/$dat["meta"])*$dat["peso"];
	  $dat["res"]=$dat["respor"]/100;
	  $dat["rpond"]=$dat["peso"]*$dat["res"];
	  return $dat;
	}
	
	
	function total_scorecard2($id,$id_empresa,$periodo,$col)
	{ if ($id==1129){
	  $res = $this->query_("SELECT objetivo FROM scorer_objetivo r, users u  WHERE r.id_personal=u.id_personal and r.periodo=$periodo and objetivo LIKE 'DINAR OE%'  and id_empresa=$id_empresa group by objetivo");
	  }
	  if ($id==1130){
	  $res = $this->query_("SELECT objetivo FROM scorer_objetivo r, users u  WHERE r.id_personal=u.id_personal and r.periodo=$periodo and objetivo LIKE 'R MER OE%'  and id_empresa=$id_empresa group by objetivo");
	  }
	  if ($id==1131){
	  $res = $this->query_("SELECT objetivo FROM scorer_objetivo r, users u  WHERE r.id_personal=u.id_personal and r.periodo=$periodo and objetivo LIKE 'R PRO OE%'  and id_empresa=$id_empresa group by objetivo");
	  }
	   $x=0;
	  foreach($res as $b)
	  { 
          //$x+=1;	  
	  //if ($x<=1)
	  //{	   
	  $res1=$this->detalle_vista_p($b["objetivo"],$periodo,$id_empresa);
	  $total=count($res);
	  $peso=100/$total;
	  foreach($res1 as $a)
	  {
	    $total1=count($res1);
	    $peso1=100/$total1;
	    if(isset($a["meta"]))
            {
	      $meta = unserialize($a["meta"]) ;
              for ($e=0; $e < $col; $e++) {
                if(isset($meta[$e]))$m=$meta[$e];
                }
	     }
	                    $resul+= ($a["lreal"]/$m)*$peso1;
			     
	    }
             $r=($resul/100); 
	    
	    $rpond+=($peso*$r);
	     $r2+=$rpond/100; 
	    $resul=0;
	  //}
	  
	  }
	 
	 $dat["rpond"]=$rpond;	
	 $dat["res"]=$dat["rpond"]/100;
	  return $dat;
	}
	
	function total_scorecard ($id_empresa,$periodo,$id_personal,$col)
	{ 
	   $result= $this->vista_scorecard($id_empresa,$periodo,$id_personal);
	    foreach($result as $fields)
	    {
	      $det= $this->detalle_vista($fields['id'],$id_personal,$periodo);
	        $total=count($result);
	        $peso=100/$total;
	         foreach($det as $det2)
		 {
	          $det3= $this->detalle_vista2($det2['id'],$det2['objetivo'],$periodo);
		  $total=count($det3);
		    foreach($det3 as $a)
	           {
			
	           
		    $total1=count($det3);
	            $peso1=100/$total1;
	            if(isset($a["meta"]))
                    {
	             $meta = unserialize($a["meta"]) ;
                     for ($e=0; $e < $col; $e++) {
                       if(isset($meta[$e]))$m=$meta[$e];
                        }      
	             }
	                $resul+= ($a["lreal"]/$m)*$peso1;
		   
		    
		   }
		    $r=($resul/100); 
	           $rpond+=($peso*$r);
                   $r2+=$rpond/100; 
	           $resul=0;
		   }
	       }
	     $dat["rpond"]=$rpond;	
	    $dat["res"]=$dat["rpond"]/100;
	    return $dat;
	}
	
	
	function total_scorecard1 ($id,$id_personal,$periodo,$col)
	{ 
	   
	      $det= $this->detalle_vista($id,$id_personal,$periodo);
	       
	         foreach($det as $det2)
		 {
	          $det3= $this->detalle_vista2($det2['id'],$det2['objetivo'],$periodo);
		  $total=count($det3);
		    foreach($det3 as $a)
	           {
			    if(isset($a["meta"]))
			    {
			      $meta = unserialize($a["meta"]) ;
			      for ($e=0; $e < $col; $e++) {
				if(isset($meta[$e]))$m=$meta[$e];
				}
			     }
			     $peso=100/$total;
			     $dat["meta"]+=$m;
			     $dat["lreal"]+=$a["lreal"];
			     $res+= ($a["lreal"]/$m)*$peso;
			     $c+=$peso*$res;
			     $dat["peso"]+=$peso;
	           }
		  
	         }
	       
	     
	    
	    $dat["respor"]=$res;//($dat["lreal"]/$dat["meta"])*$dat["peso"];
	  $dat["res"]=$dat["respor"]/100;
	  $dat["rpond"]=$dat["peso"]*$dat["res"];
	  return $dat;
	}
	
	public function personal_localidad($id){
		 $res = $this->query_("select count(*)total from personal_empresa where id_local= ".$id);
	 
		if($res){
			$res = @reset($res);
			return $res;		
		}else
		return 0;
	}
	
	public function objetivos_dependientes($id){
		 $res = $this->query_("select count(*)total  from scorer_objetivo where (id_padre_sup =$id or id_padre =$id)");
	 
		if($res){
			$res = @reset($res);
			return $res;		
		}else
		return 0;
	}
	
	public function objetivos_padre_sup($id){
		 $res = $this->query_("select objetivo from scorer_objetivo where id =$id");
	 
		if($res){
			$res = @reset($res);
			return $res;		
		}else
		return 0;
	}
	
	
}
