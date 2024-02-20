<?php

class ScorecardController extends Controller {

	protected $link;
	
	function __construct($model, $controller, $action, $type = 0,$full=false,$render=false) {

		parent::__construct($model, $controller, $action, $type,$full,$render);

		$this->link = $this->Scorecard->getDBHandle();
	}

	function ficha(){
		$this->adminS();
		$this->set('title','Alto Desempe&ntilde;o | Scorecard');
		if(isset($_POST['button'])){
			$scorer = new Scorer();
			$scorer->res1_min=$_POST['valmin'][0];
			$scorer->res1_max=$_POST['valmax'][0];
			$scorer->res2_min=$_POST['valmin'][1];
			$scorer->res2_max=$_POST['valmax'][1];
			$scorer->res3_min=$_POST['valmin'][2];
			$scorer->res3_max=$_POST['valmax'][2];
			$scorer->res4_min=$_POST['valmin'][3];
			$scorer->res4_max=$_POST['valmax'][3];
			$scorer->res5_min=$_POST['valmin'][4];
			$scorer->res5_max=$_POST['valmax'][4];
			$scorer->vinicial=$_POST['vinicial'];
			$scorer->col=$_POST['col'];
			$scorer->razon=$_POST['razon'];
			$scorer->vfinal=$_POST['vfinal'];
			$scorer->p_score=$_POST['scorep'];
			$scorer->p_compass=$_POST['compassp'];

			$detalle=serialize($scorer);
			$detalle=mysqli_real_escape_string($this->link,$detalle);

			$fecha=date("Y");

			$scorecard = new Scorecard();
			if($scorecard->select($_SESSION["Empresa"]["id"])){
				$scorecard->setDetalle($detalle);
				$scorecard->update();
			}else{
				$scorecard->setId_empresa($_SESSION["Empresa"]["id"]);
				$scorecard->setDetalle($detalle);
				$scorecard->setPeriodo($fecha);
				$scorecard->insert();
			}
			echo mysqli_error($this->link);
			// $_POST=null;
			// header("Location: ".BASEURL."scorecard/ficha");
		}
		if(isset($_POST['reset'])){
			$this->Scorecard->query('UPDATE `scorer_estado` se JOIN personal p ON p.id = se.id_personal SET usuario = 0, jefe = 0, bloqueo = 0, revision = 0, revision_jefe = 0, evaluacion = 0, evaluacion_jefe = 0, activo = 0 WHERE p.id_empresa = '.$_SESSION["Empresa"]["id"].';');
			$scorer = new Scorer();
			$scorer->res1_min=$_POST['valmin'][0];
			$scorer->res1_max=$_POST['valmax'][0];
			$scorer->res2_min=$_POST['valmin'][1];
			$scorer->res2_max=$_POST['valmax'][1];
			$scorer->res3_min=$_POST['valmin'][2];
			$scorer->res3_max=$_POST['valmax'][2];
			$scorer->res4_min=$_POST['valmin'][3];
			$scorer->res4_max=$_POST['valmax'][3];
			$scorer->res5_min=$_POST['valmin'][4];
			$scorer->res5_max=$_POST['valmax'][4];
			$scorer->vinicial=$_POST['vinicial'];
			$scorer->col=$_POST['col'];
			$scorer->razon=$_POST['razon'];
			$scorer->vfinal=$_POST['vfinal'];
			$scorer->p_score=$_POST['scorep'];
			$scorer->p_compass=$_POST['compassp'];

			$detalle=serialize($scorer);
			$detalle=mysqli_real_escape_string($this->link,$detalle);

			$fecha=date("Y");

			$this->Scorecard->query('INSERT INTO scorer_detalle (id_empresa,detalle,estado,periodo) VALUES ('.$_SESSION["Empresa"]["id"].',"'.$detalle.'",1,"'.$fecha.'") ON DUPLICATE KEY UPDATE detalle="'.$detalle.'", periodo='.$fecha.' ;');
			echo mysqli_error($this->link);
			// $_POST=null;
			// header("Location: ".BASEURL."scorecard/ficha");
		}
		$scorer = $this->Scorecard->query_('SELECT detalle,periodo FROM scorer_detalle WHERE id_empresa='.$_SESSION["Empresa"]["id"].' order by id DESC',1);
		if($scorer){
			$this->set('scorer',$scorer['detalle']);
			$this->set('periodo',$scorer['periodo']);
		}else{
			$this->set('periodo',date("Y"));
		}
	}

	function generacion($id,$per=""){
		$this->set('title','Alto Desempe&ntilde;o | ScoreCard');
		//$this->haySession();
		$this->personalSession($id);
		$bloqueo = $this->Scorecard->query('SELECT bloqueo FROM scorer_estado WHERE id_personal='.$id.'',1);
		if($bloqueo){
			$bloqueo = reset($bloqueo);
			$bloqueo = reset($bloqueo);
			$this->set('f',$bloqueo);
		}	else
		$this->set('f',$bloqueo);
		
		if($per==""){
			$scorer = $this->Scorecard->query('SELECT detalle,periodo FROM scorer_detalle WHERE id_empresa='.$_SESSION["Empresa"]["id"].' order by id DESC',1);
			$this->Scorecard->query('UPDATE scorer_estado SET usuario=1 WHERE id_personal='.$id.'');
		}else{
			$per_ = " AND periodo = $per";
			$scorer = $this->Scorecard->query('SELECT detalle,periodo FROM scorer_detalle WHERE id_empresa='.$_SESSION["Empresa"]["id"].$per_.' order by id DESC',1);
		}
		$scorer = reset($scorer);
		$scorer_det = unserialize($scorer['detalle']);
		$this->set('scorer',$scorer_det);

		$pid = $this->Scorecard->hasSuperior($id);
		//$obj_sup = $this->Scorecard->query_('SELECT * from scorer_objetivo WHERE id_personal = '.$pid.' AND periodo='.$scorer['periodo'].'');        $obj_sup = $this->Scorecard->query_('SELECT t.*,ifnull(t.id_padre,t.id)as padre from scorer_objetivo t WHERE id_personal = '.$pid.' AND periodo='.$scorer['periodo'].' order by padre'); 
		if($obj_sup)
			$this->set('obj_sup',$obj_sup);



		$this->set('id',$id);
		$this->set('fecha', $scorer['periodo']);	
		$this->set('ajuste',$this->Scorecard->get_ajuste($id));
		//$obj_def = $this->Scorecard->query_('SELECT * from scorer_objetivo WHERE id_personal = '.$id.' AND periodo='.$scorer['periodo'].'');        $obj_def = $this->Scorecard->query_('SELECT t.*,ifnull(t.id_padre,t.id)as padre from scorer_objetivo t WHERE id_personal = '.$id.' AND periodo='.$scorer['periodo'].' order by padre');        
		if($obj_def)
			$this->set('obj_',$obj_def);
	}

	function confirmacion($id,$per=""){
		$this->set('title','Alto Desempe&ntilde;o | ScoreCard');
		if($this->evalSession($id)){
			if($_SESSION['USER-AD']['user_rol']==2){
				$this->Scorecard->query('UPDATE scorer_estado SET jefe=1 WHERE id_personal='.$id.'');
				$this->set('backlink',BASEURL.'scorecard/home');
			}else{
				$this->set('backlink',BASEURL.'scorecard/admin');
			}
			$bloqueo = $this->Scorecard->query('SELECT bloqueo FROM scorer_estado WHERE id_personal='.$id.'',1);
			$bloqueo = reset($bloqueo);
			$bloqueo = reset($bloqueo);
			$this->set('f',$bloqueo);

			if($per==""){
				$scorer = $this->Scorecard->query('SELECT detalle,periodo FROM scorer_detalle WHERE id_empresa='.$_SESSION["Empresa"]["id"].' order by id DESC',1);
			}else{
				$per_ = " AND periodo = $per";
				$scorer = $this->Scorecard->query('SELECT detalle,periodo FROM scorer_detalle WHERE id_empresa='.$_SESSION["Empresa"]["id"].$per_.' order by id DESC',1);
			}
			$scorer = reset($scorer);
			$scorer_det = unserialize($scorer['detalle']);
			$this->set('scorer',$scorer_det);
			$this->set('fecha', $scorer['periodo']);
		}	
		$this->set('id',$id);
		$this->set('ajuste',$this->Scorecard->get_ajuste($id));
		//$obj_def = $this->Scorecard->query('SELECT * from scorer_objetivo WHERE id_personal = '.$id.' AND periodo='.$scorer['periodo'].'');        $obj_def = $this->Scorecard->query('SELECT t.*,ifnull(t.id_padre,t.id)as padre from scorer_objetivo  t WHERE id_personal = '.$id.' AND periodo='.$scorer['periodo'].' order by padre'); 
		if($obj_def)
			$this->set('obj_',$obj_def);
	}

	function ver_angular($id,$periodo){
		$this->set('title','Alto Desempe&ntilde;o | ScoreCard');
		if($this->evalSession($id)){
			$id_e=$_SESSION['Empresa']['id'];
			$scorer = $this->Scorecard->query_("SELECT detalle FROM scorer_detalle WHERE id_empresa=$id_e AND periodo=$periodo order by id DESC",1);
			$scorer_det = unserialize($scorer['detalle']);
			$this->set('scorer',$scorer_det);
			$this->set('fecha', $periodo);
			$lp = new listado_personal_op();
			$lp->select($id);
			$pid=$lp->getId_superior();
			// echo 'SELECT * from scorer_objetivo WHERE id_personal = '.$pid.' AND periodo='.$periodo.'';
			$obj_sup = $this->Scorecard->query_('SELECT * from scorer_objetivo WHERE id_personal = '.$pid.' AND periodo='.$periodo.'');
			if($obj_sup)
				$this->set('obj_sup',$obj_sup);
		}	

		$this->set('id',$id);
		$this->set('ajuste',$this->Scorecard->get_ajuste($id));
		$obj_def = $this->Scorecard->query('SELECT * from scorer_objetivo WHERE id_personal = '.$id.' AND periodo='.$periodo.'');
		if($obj_def)
			$this->set('obj_',$obj_def);
	}

	function ver($id,$periodo){
		$this->set('title','Alto Desempe&ntilde;o | ScoreCard');
		if($this->evalSession($id)){
			if($_SESSION['USER-AD']['user_rol']==2){
				$this->Scorecard->query('UPDATE scorer_estado SET jefe=1 WHERE id_personal='.$id.'');
				$this->set('backlink',BASEURL.'scorecard/home');
			}else{
				$this->set('backlink',BASEURL.'scorecard/admin');
			}
			$id_e=$_SESSION['Empresa']['id'];
			$scorer = $this->Scorecard->query_("SELECT detalle FROM scorer_detalle WHERE id_empresa=$id_e AND periodo=$periodo order by id DESC",1);
			$scorer_det = unserialize($scorer['detalle']);
			$this->set('scorer',$scorer_det);
			$this->set('fecha', $periodo);
			$lp = new listado_personal_op();
			$lp->select($id);
			$pid=$lp->getId_superior();
			// echo 'SELECT * from scorer_objetivo WHERE id_personal = '.$pid.' AND periodo='.$periodo.'';
			$obj_sup = $this->Scorecard->query_('SELECT * from scorer_objetivo WHERE id_personal = '.$pid.' AND periodo='.$periodo.'');
			if($obj_sup)
				$this->set('obj_sup',$obj_sup);
		}	
		$this->set('id',$id);
		$this->set('ajuste',$this->Scorecard->get_ajuste($id));
		$obj_def = $this->Scorecard->query('SELECT * from scorer_objetivo WHERE id_personal = '.$id.' AND periodo='.$periodo.'');
		if($obj_def)
			$this->set('obj_',$obj_def);
	}

	function revision($id,$per=null){
		$this->set('title','Alto Desempe&ntilde;o | ScoreCard');
		//$this->haySession();
		$this->perOrevalSession($id);
		if($_SESSION['USER-AD']['id_personal']==$id)
			$this->set('backlink',BASEURL.'scorecard/generacion/'.$id);
		else
			$this->set('backlink',BASEURL.'scorecard/confirmacion/'.$id);

		$scorecard_data = new Scorecard();
		$scorer_det = $scorecard_data->get_scorer($_SESSION['Empresa']['id'],$per);;
		$this->set('scorer',$scorer_det['detalle']);
		$this->set('id',$id);
		$this->set('fecha', $scorer_det['periodo']);

		$emp = Scorer_reval::withID($id,0,0,$scorer_det['periodo']);
		$eval = Scorer_reval::withID($id,1,0,$scorer_det['periodo']);
		$emp = $emp->selectAll();
		$eval = $eval->selectAll();
		if($emp || $eval){
			$revision_emp = array();
			$revision_eval = array();
			foreach ($emp as $key => $value) {
				$tmp = new Scorer_reval($value);
				array_push($revision_emp, $tmp);
			}
			foreach ($eval as $key => $value) {
				$tmp = new Scorer_reval($value);
				array_push($revision_eval, $tmp);
			}
			$this->set('revision_emp',$revision_emp);
			$this->set('revision_eval',$revision_eval);
		}
	}

	function evaluacion($id,$per=null){
		$this->set('title','Alto Desempe&ntilde;o | ScoreCard');
		//$this->haySession();
		$this->perOrevalSession($id);
		if($_SESSION['USER-AD']['id_personal']==$id)
			$this->set('backlink',BASEURL.'scorecard/generacion/'.$id);
		else
			$this->set('backlink',BASEURL.'scorecard/confirmacion/'.$id);
		
		$scorecard_data = new Scorecard();
		$scorer_det = $scorecard_data->get_scorer($_SESSION['Empresa']['id'],$per);;
		$this->set('scorer',$scorer_det['detalle']);


		$this->set('id',$id);
		$this->set('fecha', $scorer_det['periodo']);

		$emp = Scorer_reval::withID($id,0,1,$scorer_det['periodo']);
		$eval = Scorer_reval::withID($id,1,1,$scorer_det['periodo']);
		$emp = $emp->selectAll();
		$eval = $eval->selectAll();
		if($emp || $eval){
			$evaluacion_emp = array();
			$evaluacion_eval = array();
			foreach ($emp as $key => $value) {
				$tmp = new Scorer_reval($value);
				array_push($evaluacion_emp, $tmp);
			}
			foreach ($eval as $key => $value) {
				$tmp = new Scorer_reval($value);
				array_push($evaluacion_eval, $tmp);
			}
			$this->set('evaluacion_emp',$evaluacion_emp);
			$this->set('evaluacion_eval',$evaluacion_eval);
		}

	}

	function que_hacer($id,$per=null){
		$this->set('title','Alto Desempe&ntilde;o | ScoreCard');
		$scorecard_data = new Scorecard();
		$scorer_det = $scorecard_data->get_scorer($_SESSION['Empresa']['id'],$per);;
		$this->set('scorer',$scorer_det['detalle']);
		$this->set('id',$id);
		$this->set('fecha', $scorer_det['periodo']);
		//$this->haySession();
		$this->perOrevalSession($id);

	}

	function home(){
		$this->set('title','Alto Desempe&ntilde;o | ScoreCard');
		$this->haySession();

		
		$scorecard_data = new Scorecard();
		$scorer_det = $scorecard_data->get_scorer($_SESSION['Empresa']['id']);;
		$this->set('scorer',$scorer_det['detalle']);

		$lp=new listado_personal_op();
		$lp->select($_SESSION['USER-AD']['id_personal']);


		// $d_emp = $this->Scorecard->get_empdat($_SESSION['USER-AD']['id_personal']);
		$this->set('nombre',$lp->getNombre() );
		$this->set('cargo',$lp->getCargo() );
		$this->set('area',$lp->getArea() );
		$this->set('fecha', $scorer_det['periodo']);

		$ids = $lp->getSubalternos_(false);
		// var_dump($ids);
		// var_dump($ids);
		// $ids = implode(", ", $ids);
		// $sub_a = $this->Scorecard->query('SELECT * FROM scorer_estado WHERE id_personal IN ('.$ids.') AND activo=1');
		$se = new scorer_estado();
		$sub_a = $se->select_all_by_ids($ids);
		

		$this->set('sub_a',$sub_a);
	}
     /*ini sga*/    function vista_scorecard(){        $this->set('title','Alto Desempe&ntilde;o | ScoreCard');        $this->haySession();                 $scorecard_data = new Scorecard();        $scorer_det = $scorecard_data->get_scorer($_SESSION['Empresa']['id']);;        $this->set('scorer',$scorer_det['detalle']);         $lp=new listado_personal_op();        $lp->select($_SESSION['USER-AD']['id_personal']);          // $d_emp = $this->Scorecard->get_empdat($_SESSION['USER-AD']['id_personal']);        $this->set('nombre',$lp->getNombre() );        $this->set('cargo',$lp->getCargo() );        $this->set('area',$lp->getArea() );        $this->set('fecha', $scorer_det['periodo']);        $this->set('id_personal', $_SESSION['USER-AD']['id_personal']);         $ids = $lp->getSubalternos_(false);        // var_dump($ids);        // var_dump($ids);        // $ids = implode(", ", $ids);        // $sub_a = $this->Scorecard->query('SELECT * FROM scorer_estado WHERE id_personal IN ('.$ids.') AND activo=1');        $se = new scorer_estado();        $sub_a = $se->select_all_by_ids($ids);                $obj_sup = $this->Scorecard->query_('SELECT * FROM scorer_objetivo r WHERE id_personal= ' .$_SESSION['USER-AD']['id_personal']. ' and periodo='.$scorer_det['periodo'].'  and id_padre is null');            if($obj_sup)               {                $this->set('obj_sup',$obj_sup);                           }         $this->set('sub_a',$sub_a);                $emp = $this->Scorecard->query_('select e.* from empresa e, users u where e.id=u.id_empresa and u.id_personal= '.$_SESSION['USER-AD']['id_personal']);        $this->set('emp',$emp);    }            function vista_scorecard2(){        $this->set('title','Alto Desempe&ntilde;o | ScoreCard');        $this->haySession();         echo $_SESSION['Empresa']['id'];        $scorecard_data = new Scorecard();        $scorer_det = $scorecard_data->get_scorer($_SESSION['Empresa']['id']);;        $this->set('scorer',$scorer_det['detalle']);         $lp=new listado_personal_op();        $lp->select($_SESSION['USER-AD']['id_personal']);          // $d_emp = $this->Scorecard->get_empdat($_SESSION['USER-AD']['id_personal']);        $this->set('nombre',$lp->getNombre() );        $this->set('cargo',$lp->getCargo() );        $this->set('area',$lp->getArea() );        $this->set('fecha', $scorer_det['periodo']);                $this->set('id_empresa', $_SESSION['Empresa']['id']);                        $ids = $lp->select_all($_SESSION['Empresa']['id']);                // var_dump($ids);        // var_dump($ids);        // $ids = implode(", ", $ids);        // $sub_a = $this->Scorecard->query('SELECT * FROM scorer_estado WHERE id_personal IN ('.$ids.') AND activo=1');        $se = new scorer_estado();        $sub_a = $se->select_all_by_ids($ids);        $obj_sup = $this->Scorecard->query_('SELECT * FROM scorer_objetivo r WHERE r.id_padre is null and r.id_padre_sup is null and periodo='.$scorer_det['periodo']);            if($obj_sup)               {                $this->set('obj_sup__',$obj_sup);                           }                $this->set('sub_a',$ids);                //$emp = $this->Scorecard->query_("SELECT * FROM scorer_objetivo o WHERE o.id in (1129,1130,1131) and periodo=".$scorer_det['periodo']);                $emp = $this->Scorecard->query_("SELECT o.id ,o.objetivo, o.indicador,o.inverso,o.unidad, o.lreal, o.lpond, o.meta, o.peso, o.id_padre, o.id_padre_sup  FROM scorer_objetivo o                  WHERE o.id_padre IS NULL                         AND o.id_padre_sup IS NULL                      AND o.periodo=".$scorer_det['periodo']."                     AND UPPER(o.objetivo) LIKE UPPER('Plan Estrat%')                      ORDER BY id");        $this->set('emp',$emp);    }    /*fin sga*/
	function admin(){
		$this->set('title','Alto Desempe&ntilde;o | ScoreCard');
		$this->adminS();

		$scorecard_data = new Scorecard();
		$scorer_det = $scorecard_data->get_scorer($_SESSION['Empresa']['id']);;
		
		$se = new Scorer_estado();
		$this->set('count',$se->count());
		
		$this->set('scorer',$scorer_det['detalle']);
	}

	function periodo($p){
		$this->set('title','Alto Desempe&ntilde;o | ScoreCard');
		$this->adminS();

		$scorecard_data = new Scorecard();
		$scorer_det = $scorecard_data->get_scorer($_SESSION['Empresa']['id'],$p);;
		
		$se = new Scorer_estado();
		$this->set('count',$se->count());
		
		$this->set('scorer',$scorer_det['detalle']);
		$this->set('periodo',$scorer_det['periodo']);
	}

	function jefe_periodo($p){
		$this->set('title','Alto Desempe&ntilde;o | ScoreCard');
		$this->haySession();

		
		$scorecard_data = new Scorecard();
		$scorer_det = $scorecard_data->get_scorer($_SESSION['Empresa']['id'],$p);;
		$this->set('scorer',$scorer_det['detalle']);

		$lp=new listado_personal_op();
		$lp->select($_SESSION['USER-AD']['id_personal']);


		// $d_emp = $this->Scorecard->get_empdat($_SESSION['USER-AD']['id_personal']);
		$this->set('nombre',$lp->getNombre() );
		$this->set('cargo',$lp->getCargo() );
		$this->set('area',$lp->getArea() );
		$this->set('fecha', $scorer_det['periodo']);

		$ids = $lp->getSubalternos_(false);
		// $ids = implode(", ", $ids);
		// $sub_a = $this->Scorecard->query('SELECT * FROM scorer_estado WHERE id_personal IN ('.$ids.') AND activo=1');
		$se = new scorer_estado();
		$sub_a = $se->select_all_by_ids($ids);
		

		$this->set('sub_a',$sub_a);
	}

	function fase_final($ispost=null){
		$this->set('title','Alto Desempe&ntilde;o | ScoreCard');
		$this->haySession();

		if($_SESSION['USER-AD']['user_rol']==2)
			$this->set('backlink','scorecard/home');
		else
			$this->set('backlink','scorecard/admin');
		

		if(isset($ispost)){
			$ispost = urldecode($ispost);
			$ispost = explode(";", $ispost);
			$_POST['compass'] = $ispost[0];
			$_POST['r_score'] = $ispost[1];
			$_POST['total'] = $ispost[2];
			$_POST['id_e'] = $ispost[3];
		}


		if(!isset($_POST)){
			header("Location: " . BASEURL.$_SESSION['link']);
		}else{
			$com = $_POST['compass'];
			$sco = $_POST['r_score'];
			$pon = $_POST['total'];
			$id_e = $_POST['id_e'];
		}

		
		$scorecard_data = new Scorecard();
		$scorer_det = $scorecard_data->get_scorer($_SESSION['Empresa']['id']);;
		$this->set('scorer',$scorer_det['detalle']);

		$d_emp = $this->Scorecard->get_empdat($id_e);
		$this->set('nombre',$d_emp[0]);
		$this->set('cargo',$d_emp[1]);
		$this->set('area',$d_emp[2]);
		$this->set('fecha', $scorer_det['periodo']);

		$lp = new listado_personal_op();
		$ids = $lp->select($_SESSION['USER-AD']['id_personal'])->getSubalternos_(false);
		if(is_array($ids))
			$ids=implode(",", $ids);
		$sub_a = $this->Scorecard->query('SELECT * FROM scorer_estado WHERE id_personal IN ('.$ids.')');
		
		$this->set('sub_a',$sub_a);
		$this->set('compass',$com);
		$this->set('scorer',$sco);
		$this->set('pond',$pon);
	}

	function estado_proceso($periodo=0){
		Util::sessionStart();
		$this->set('periodo',$periodo);
	}

	function haySession(){
		Util::sessionStart();
		if (!isset($_SESSION['USER-AD'])){
			$this->logout();	
			return false;
		}
		return true;
	}

	function adminS(){
		if($this->haySession()){
			if($_SESSION['USER-AD']['user_rol'] == 2){
				header("Location: " . BASEURL.$_SESSION['link']);
				return false;
			}
			return true;
		}
	}

	function personalSession($id){
		if($this->haySession()){
			if($_SESSION['USER-AD']['user_rol'] == 2 && $_SESSION['USER-AD']['id_personal']!=$id){
				header("Location: " . BASEURL.$_SESSION['link']);
				return false;
			}
			return true;
		}
	}

	function perOrevalSession($id){
		if($this->haySession()){

			$lp = new listado_personal_op();
			$ids = $lp->select($_SESSION['USER-AD']['id_personal'])->getSubalternos_();
			if(($_SESSION['USER-AD']['user_rol'] == 2 && $_SESSION['USER-AD']['id_personal']!=$id) && !in_array($id, $ids)){
				header("Location: " . BASEURL.$_SESSION['link']);
				return false;
			}
			return true;
		}
	}

	function evalSession($id){
		if($this->haySession()){
			$lp = new listado_personal_op();
			$ids = $lp->select($_SESSION['USER-AD']['id_personal'])->getSubalternos_();
			if(!in_array($id, $ids) && $_SESSION['USER-AD']['user_rol']==2){
				header("Location: " . BASEURL.$_SESSION['link']);
				return false;
			}
			return true;
		}
	}

	function logout(){
		Util::sessionLogout();
		$this->Scorecard->disconnect();
		$this->_template = new Template('Inicio','principal', false);
	}
	
}






