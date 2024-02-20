<?php 
class TestController extends Controller {
	
	protected $link;
	function __construct($model, $controller, $action=null, $type = 0,$full=false,$render=false) {
		parent::__construct($model, $controller, $action, $type,$full,$render);
		$this->link = $this->Test->getDBHandle();
	}

	function get_area(&$cod){
		$res = $this->Test->query('SELECT `nombre` FROM `empresa_area` WHERE `id`="'.$cod.'"',1);
		echo mysqli_error($this->link);
		$res = @reset($res);
		$res = @reset($res);
		return $this->Test->htmlprnt($res);
	}

	function get_localidad($cod){
		$res = $this->Test->query('SELECT `nombre` FROM `empresa_local` WHERE `id`="'.$cod.'"',1);
		echo mysqli_error($this->link);
		$res = @reset($res);
		$res = @reset($res);
		return $this->Test->htmlprnt($res);
	}

	function get_cargo($cod){
		$res = $this->Test->query('SELECT `nombre` FROM `empresa_cargo` WHERE `id`="'.$cod.'"',1);
		echo mysqli_error($this->link);
		$res = @reset($res);
		$res = @reset($res);
		return $this->Test->htmlprnt($res);
	}

	function get_norg($cod){
		$res = $this->Test->query('SELECT `nombre` FROM `empresa_norg` WHERE `id`="'.$cod.'"',1);
		echo mysqli_error($this->link);
		$res = @reset($res);
		$res = @reset($res);
		return $this->Test->htmlprnt($res);
	}

	function get_tcont($cod){
		$res = $this->Test->query('SELECT `nombre` FROM `empresa_tcont` WHERE `id`="'.$cod.'"',1);
		echo mysqli_error($this->link);
		$res = @reset($res);
		$res = @reset($res);
		return $this->Test->htmlprnt($res);
	}

	function download($id_p = null,$id_t = null) {
		$this->set('title','Alto Desempe&ntilde;o');
		$this->set('test',$this->Test->get_dCond("pdf_test", "id_personal", $id_p, "id_test", $id_t));
	}
	
	function matriz(){
		$this->set('title','Alto Desempe&ntilde;o | Matriz');
		$this->esAdmin();
		$final=null;
		$filtros=$filtro_sql=$g_filtro="";
		if(isset($_POST['filtro'])){
			$areas=$localidades=$cargos=$norgs=$tconts="";
			if(isset($_POST['areas'])){
				$filtros.="Áreas: ";
				$areas = "AND `area` IN (";
				$areas .= implode(",", $_POST['areas']).")";
				$filtros.=implode(", ", array_map(array($this,'get_area'),$_POST['areas']));
				$filtros.=".<br>";
			}
			if(isset($_POST['localidades'])){
				$filtros.="Localidades: ";
				$localidades = "AND `localidad` IN (";
				$localidades .= implode(",", $_POST['localidades']).")";
				$filtros.=implode(", ", array_map(array($this,'get_localidad'),$_POST['localidades']));
				$filtros.=".<br>";
			}
			if(isset($_POST['cargos'])){
				$filtros.="Cargos: ";
				$cargos = "AND `cargo` IN (";
				$cargos .= implode(",", $_POST['cargos']).")";
				$filtros.=implode(", ", array_map(array($this,'get_cargo'),$_POST['cargos']));
				$filtros.=".<br>";
			}
			if(isset($_POST['norgs'])){
				$filtros.="Niveles organizacionales: ";
				$norgs = "AND `niveles organizacionales` IN (";
				$norgs .= implode(",", $_POST['norgs']).")";
				$filtros.=implode(", ", array_map(array($this,'get_norg'),$_POST['norgs']));
				$filtros.=".<br>";
			}
			if(isset($_POST['tconts'])){
				$filtros.="Tipos de contrato: ";
				$tconts = "AND `contrato` IN (";
				$tconts .= implode(",", $_POST['tconts']).")";
				$filtros.=implode(", ", array_map(array($this,'get_tcont'),$_POST['tconts']));
				$filtros.=".<br>";
			}
			$filtro_sql=$sql = 'SELECT `id`,`nombre` FROM `listado_personal` WHERE `empresa`=' . $_SESSION["Empresa"]["id"] . ' AND matriz=1 AND scorer=1 AND `compass_360`=1 '.$areas." ".$localidades." ".$cargos." ".$norgs." ".$tconts.'';
			$final = $this->Test->query_($sql);
		}elseif(isset($_POST['guardar'])){
			foreach ($_POST['id'] as $id_key => $id) {
				if(!isset($_POST['matval'][$id_key]))
					$val=0;
				else
					$val=$_POST['matval'][$id_key];
				$insert = "INSERT INTO matriz_definicion (id_personal,valor) VALUES (".$id.",".$val.") ON DUPLICATE KEY UPDATE valor=".$val."";
				$this->Test->query($insert);
				echo mysqli_error($this->link);
			}
			if(isset($_SESSION['matriz']['filtro'])){
				$final = $this->Test->query_($_SESSION['matriz']['filtro']);
				$filtro_sql=$_SESSION['matriz']['filtro'];
				$filtros=$_SESSION['matriz']['filtro_verbal'];
				if(isset($_POST['g_filtro'])){
					$filtro_nombre = $this->Test->esc($_POST['g_filtro'])." ".strftime("%d%b%y %H:%M");
					$filtro_sql = $this->Test->esc($_SESSION['matriz']['filtro']);
					$filtro_verbal = $this->Test->esc($_SESSION['matriz']['filtro_verbal']);
					$t="INSERT INTO `matriz_filtros`(`id_empresa`, `nombre`, `sql`, `verbal`) VALUES (".$_SESSION['Empresa']['id'].",\"".$filtro_nombre."\",\"".$filtro_sql."\",\"".$filtro_verbal."\")";
					$this->Test->query($t);
				echo mysqli_error($this->link);
					$g_filtro=$_POST['g_filtro'];
				}
				// $_SESSION['matriz']['filtro']=null;
			}
			$this->set('sql',$_SESSION['matriz']['filtro']);
			if(isset($_POST['g_ver'])){
				$this->_template = new Template('Test','matriz_grafica');
				$this->matriz_grafica();
			}
		}elseif(isset($_POST['previos_btn'])){
			$mf = new matriz_filtros();
			$mf->select($_POST['previos']);
			$filtros=$mf->getVerbal();
			$filtro_sql=$mf->getSql();
			$g_filtro=$mf->getNombre();
			$final = $this->Test->query_($filtro_sql);
		}
		$this->set('g_filtro',$g_filtro);
		$this->set('resultados',$final);
		$this->set('filtros',$filtros);
		$_SESSION['matriz']['filtro_verbal']=$filtros;
		$_SESSION['matriz']['filtro']=$filtro_sql;

		$_POST=null;

		$scorer = $this->Test->query('SELECT detalle,periodo FROM scorer_detalle WHERE id_empresa='.$_SESSION["Empresa"]["id"].'',1);
		$scorer = reset($scorer);
		$scorer_det = unserialize($scorer['detalle']);
		$this->set('scorer',$scorer_det);
		$this->datosEmpresa($_SESSION["Empresa"]["id"]);
	}

	function matriz_grafica(){
		$this->set('title','Alto Desempe&ntilde;o | Matriz');
		$this->esAdmin();

		if(isset($_POST['filtro'])){
			$areas=$localidades=$cargos=$norgs=$tconts="";
			if(isset($_POST['areas'])){
				$areas = "AND `area` IN (";
				$areas .= implode(",", $_POST['areas']).")";
			}
			if(isset($_POST['localidades'])){
				$localidades = "AND `localidad` IN (";
				$localidades .= implode(",", $_POST['localidades']).")";
			}
			if(isset($_POST['cargos'])){
				$cargos = "AND `cargo` IN (";
				$cargos .= implode(",", $_POST['cargos']).")";
			}
			if(isset($_POST['norgs'])){
				$norgs = "AND `niveles organizacionales` IN (";
				$norgs .= implode(",", $_POST['norgs']).")";
			}
			if(isset($_POST['tconts'])){
				$tconts = "AND `contrat` IN (";
				$tconts .= implode(",", $_POST['tconts']).")";
			}
			$sql = 'SELECT `id`,`nombre` FROM `listado_personal` WHERE `empresa`=' . $_SESSION["Empresa"]["id"] . ' AND matriz=1 AND scorer=1 AND `compass_360`=1 '.$areas." ".$localidades." ".$cargos." ".$norgs." ".$tconts.'';
			$final = $this->Test->query_($sql);
			$this->set('sql',$sql);
			$this->set('resultados',$final);
		}else{
			$sql = 'SELECT `id`,`nombre` FROM `listado_personal` WHERE `empresa`=' . $_SESSION["Empresa"]["id"] . ' AND matriz=1 AND scorer=1 AND `compass_360`=1';
			$final = $this->Test->query_($sql);
			$this->set('resultados',$final);
		}
		$this->datosEmpresa($_SESSION["Empresa"]["id"],2);

		$scorer = $this->Test->query('SELECT detalle,periodo FROM scorer_detalle WHERE id_empresa='.$_SESSION["Empresa"]["id"].'',1);
		$scorer = reset($scorer);
		$scorer_det = unserialize($scorer['detalle']);
		$this->set('scorer',$scorer_det);

	}

	function generacion_scorecard($id){
		$this->set('title','Alto Desempe&ntilde;o | ScoreCard');
		$this->personalSession($id);

		$scorer = $this->Test->query('SELECT detalle,periodo FROM scorer_detalle WHERE id_empresa='.$_SESSION["Empresa"]["id"].'',1);
		$scorer = reset($scorer);
		$scorer_det = unserialize($scorer['detalle']);
		$this->set('scorer',$scorer_det);

		$d_emp = $this->Test->get_empdat($id);
		$this->set('id',$id);
		$this->set('nombre',$d_emp[0]);
		$this->set('cargo',$d_emp[1]);
		$this->set('area',$d_emp[2]);
		$this->set('fecha', $scorer['periodo']);
		if (isset($_POST['guardar'])){
			$this->Test->query('DELETE FROM scorer_objetivo WHERE id_personal='.$id.'');
			foreach ($_POST['obj'] as $a => $b) {
				$obj = mysqli_real_escape_string($this->link,$_POST['obj'][$a]);
				$ind = mysqli_real_escape_string($this->link,$_POST['ind'][$a]);
				$this->Test->query('INSERT INTO `scorer_objetivo`( `id_personal`, `objetivo`, `indicador`, `periodo`, `unidad`) VALUES ('.$id.',"'.$obj.'","'.$ind.'",'.$_POST['inv'][$a].','.$_POST['und'][$a].')');
				$meta=array();
				$id_a=mysqli_insert_id($this->link);
				if(isset($_POST['meta0'][$a])){
					for ($i=0; $i < $scorer_det->col; $i++) { 
						array_push($meta, $_POST['meta'.$i][$a]);
					}
					$meta = serialize($meta);
					$meta=mysqli_real_escape_string($this->link,$meta);
					$this->Test->query('UPDATE `scorer_objetivo` SET `meta`="'.$meta.'" WHERE id='.$id_a.'');
				}
				if(isset($_POST['peso'][$a])){
					$this->Test->query('UPDATE `scorer_objetivo` SET `peso`="'.$_POST['peso'][$a].'" WHERE id='.$id_a.'');
				}
				if(isset($_POST['lreal'][$a])){
					$this->Test->query('UPDATE `scorer_objetivo` SET `lreal`="'.$_POST['lreal'][$a].'" WHERE id='.$id_a.'');
				}
				if(isset($_POST['lpond'][$a])){
					$this->Test->query('UPDATE `scorer_objetivo` SET `lpond`="'.$_POST['lpond'][$a].'" WHERE id='.$id_a.'');
				}
				if(isset($_POST['ppond'][$a])){
					$this->Test->query('UPDATE `scorer_objetivo` SET `ppond`="'.$_POST['ppond'][$a].'" WHERE id='.$id_a.'');
				}
			} 
		}		
		$obj_def = $this->Test->query('SELECT * from scorer_objetivo WHERE id_personal = '.$id.'');
		if($obj_def)
			$this->set('obj_',$obj_def);
	}

	function riesgo_retencion(){
		$this->esAdmin();
		if(isset($_POST)){
			$areas=$localidades=$cargos=$norgs=$tconts=$filtros="";
			if(isset($_POST['areas'])){
				$filtros.="Áreas: ";
				$areas = "AND `id_area` IN (";
				$areas .= implode(",", $_POST['areas']).")";
				$filtros.=implode(", ", array_map(array($this,'get_area'),$_POST['areas']));
				$filtros.=".<br>";
			}
			if(isset($_POST['localidades'])){
				$filtros.="Localidades: ";
				$localidades = "AND `id_local` IN (";
				$localidades .= implode(",", $_POST['localidades']).")";
				$filtros.=implode(", ", array_map(array($this,'get_localidad'),$_POST['localidades']));
				$filtros.=".<br>";
			}
			if(isset($_POST['cargos'])){
				$filtros.="Cargos: ";
				$cargos = "AND `id_cargo` IN (";
				$cargos .= implode(",", $_POST['cargos']).")";
				$filtros.=implode(", ", array_map(array($this,'get_cargo'),$_POST['cargos']));
				$filtros.=".<br>";
			}
			if(isset($_POST['norgs'])){
				$filtros.="Niveles organizacionales: ";
				$norgs = "AND `id_norg` IN (";
				$norgs .= implode(",", $_POST['norgs']).")";
				$filtros.=implode(", ", array_map(array($this,'get_norg'),$_POST['norgs']));
				$filtros.=".<br>";
			}
			if(isset($_POST['tconts'])){
				$filtros.="Tipos de contrato: ";
				$tconts = "AND `id_tcont` IN (";
				$tconts .= implode(",", $_POST['tconts']).")";
				$filtros.=implode(", ", array_map(array($this,'get_tcont'),$_POST['tconts']));
				$filtros.=".<br>";
			}
			$riesgo = new riesgo_retencion();
			$riesgo_array = $riesgo->select_all_ids($_SESSION['Empresa']['id']);
			if(array_filter($riesgo_array)){
				$riesgo_ids = array();
				foreach ($riesgo->select_all_ids($_SESSION['Empresa']['id']) as $key => $value) {
					array_push($riesgo_ids, $value['id_personal']);
				}
				$riesgo_sql = "AND id NOT IN (".implode(",", $riesgo_ids).")";
			}else{
				$riesgo_sql = "";
			}
			if($filtros==""){
				$sql = "SELECT `id`,`nombre` FROM `listado_personal_op` WHERE `empresa`=999999999999999999999999999999999999";
			}else
			$sql = 'SELECT `id`,`nombre`,`criticidad` FROM `listado_personal_op` WHERE activo=1 AND `empresa`=' . $_SESSION["Empresa"]["id"] . ' '.$areas." ".$localidades." ".$cargos." ".$norgs." ".$tconts." ".$riesgo_sql.'';
				// echo $sql;
			if(isset($_POST['guardar'])){
				// foreach ($_POST['id'] as $id_key => $id) {
				// 	if(!isset($_POST['matval'][$id_key]))
				// 		$val=0;
				// 	else
				// 		$val=$_POST['matval'][$id_key];
				// 	$insert = "INSERT INTO matriz_definicion (id_personal,valor) VALUES (".$id.",".$val.") ON DUPLICATE KEY UPDATE valor=".$val."";
				// 	$this->Test->query($insert);
				// 	echo mysqli_error($this->link);
				// }
				// $final = $this->Test->query_($sql);
				// $this->set('sql',$sql);
				// $this->set('resultados',$final);
				// if(isset($_POST['g_ver'])){
				// 	$this->_template = new Template('Test','matriz_grafica');
				// 	$this->matriz_grafica();
				// }
			}
			$final = $this->Test->query_($sql);
			$this->set('sql',$sql);
			$this->set('resultados',$final);
			$this->set('filtros',$filtros);

			//$_POST=null;
		}
		$this->datosEmpresa($_SESSION["Empresa"]["id"]);
	}

	function desarrollo($id=null){
		Util::sessionStart();
		if(!$id)
			$id = $_SESSION['Personal']['id'];
		// $cod_evaluado = $_SESSION['evaluado']['id'];
		// $d_emp = $this->Test->get_empdat($id,$cod_evaluado);
		$lp = new listado_personal_op();
		$lp->select($id);

		if(($id != $_SESSION['Personal']['id']) && ($_SESSION['Personal']['id']!=$lp->getId_superior())){
			$this->set('custom_danger',"<h3>Necesita ser el usuario o superior para ver o modificar esta plantilla.</h3>");
		}

		$this->set('nombre',$lp->getNombre());
		$this->set('cargo',$lp->getCargo());
		$this->set('area',$lp->getArea());
		$this->set('superior',$lp->getPid_nombre());
		// $this->set('fecha',$lp->getNombre());
		$this->set('id',$id);

		$scorer = $this->Test->query('SELECT detalle,periodo FROM scorer_detalle WHERE id_empresa='.$_SESSION["Empresa"]["id"].'',1);
		$scorer = reset($scorer);
		$scorer_det = unserialize($scorer['detalle']);
		$this->set('scorer',$scorer_det);
	}

	function preferencias_sublaternos($id=null){
		Util::sessionStart();
	}

	function cobertura(){
		$this->esAdmin();
		$ids = new Plan_desarrollo();
		$ids = $ids->select_all_x_empresa($_SESSION['Empresa']['id']);
		$this->set('ids',$ids);
	}

	function cover($id){
		Util::sessionStart();
		$this->set('id',$id);
	}

	function upload(){
		Util::sessionStart();
	}

	function testing(){
		Util::sessionStart();
	}

	function testing1(){
		Util::sessionStart();
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

	function testing2(){
		Util::sessionStart();
	}

	function testing3(){
		Util::sessionStart();
	}

	function upload_sonda(){
		Util::sessionStart();
	}

	function upload_rp(){
		Util::sessionStart();
	}

	function datosEmpresa($id,$modal_id=1){
		$res = $this->Test->query('SELECT id,nombre FROM empresa_area WHERE id_empresa='.$id.'');
		if($res){
			$this->set('areas',$res);
		}
		$res = $this->Test->query('SELECT id,nombre FROM empresa_local WHERE id_empresa='.$id.' AND NOT(nivel=0)');
		if($res){
			$this->set('local',$res);
		}
		$res = $this->Test->query('SELECT id,nombre FROM empresa_cargo WHERE id_empresa='.$id.'');
		if($res){
			$this->set('cargos',$res);
		}
		$res = $this->Test->query('SELECT id,nombre FROM empresa_norg WHERE id_empresa='.$id.'');
		if($res){
			$this->set('norgs',$res);
		}
		$res = $this->Test->query('SELECT id,nombre FROM empresa_tcont WHERE id_empresa='.$id.'');
		if($res){
			$this->set('tconts',$res);
		}
		$res = $this->Test->query('SELECT id,nombre FROM empresa_tcont WHERE id_empresa='.$id.'');
		if($res){
			$this->set('tconts',$res);
		}
		$res = $this->Test->query('SELECT id,nombre,nivel,id_superior FROM empresa_cond WHERE id_empresa='.$id.'');
		if($res){
			$this->set('cond',$res);
		}
		$res = $this->Test->query('SELECT activo FROM modal WHERE id_empresa='.$id.' AND modal_id='.$modal_id.'',1);
		if($res){
			$res = reset($res);
			$res = reset($res);
			$this->set('mod',$res);
		}else
		$this->set('mod',true);

	}











	function haySession(){
		Util::sessionStart();
		if (!isset($_SESSION['USER-AD'])){
			$this->logout();	
		}
		return true;
	}

	function esAdmin(){
		Util::sessionStart();
		if (!isset($_SESSION['USER-AD'])){
			$this->logout();	
			if($_SESSION['USER-AD']['user_rol']==2)
				$this->logout();	
		}
		return true;
	}

	function personalSession($id){
		if($this->haySession()){
			if($_SESSION['USER-AD']['user_rol'] == 2 && $_SESSION['USER-AD']['id_personal']!=$id){
				header("Location: " . BASEURL.$_SESSION['link']);
			}
			return true;
		}
	}

	function logout(){
		Util::sessionLogout();
		$this->Test->disconnect();
		$this->_template = new Template('Inicio','principal', false);
	}

}