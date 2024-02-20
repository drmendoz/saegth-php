 <?php

 class PersonalController extends Controller {

 	protected $link;

 	function __construct($model, $controller, $action, $type = 0, $full = false,$render=false) {

 		parent::__construct($model, $controller, $action, $type, $full,$render);

 		$this->link = $this->Personal->getDBHandle();
 	}

 	function datos_empresa(){
 		$this->set('title','Alto Desempe&ntilde;o | Datos Basicos');
 		$this->hayPermisoAdmin();
 		$id_e = $_SESSION["Empresa"]["id"];
 		$this->set('id_e',$id_e);
 		$this->set('cond',$this->Personal->DB_exists_double('empresa_cond','id_empresa',$id_e,'nivel','0'));
 		$this->set('eval',$this->Personal->query('select `compass_360`, `scorer`, `matriz` from empresa where id='.$id_e.'',1));
 		$this->set('grados',Grado_salarial::select_all($id_e));
 		if(isset($_POST['gpde'])){
 			$personal = new Personal(array('id_empresa' => $id_e,'nombre_p' => $_POST['pr_nombre']));
 			$personal->insert();
 			if($personal->getError() != ""){
 				$this->set('custom_danger',$personal->getErrorMsg());
 			}else{
 				$id = $personal->id;
 				$sc_estado = Scorer_estado::insertById($id);
 				$p_test = Personal_test::insertById($id);
 				$pdat = array(
 					'id_persona' => $id,
 					'sexo' => (isset($_POST['sexo'])) ? $_POST['sexo'] : null ,
 					'cedula' => (isset($_POST['pd_ci'])) ? $_POST['pd_ci'] : null ,
 					'fecha_nac' => (isset($_POST['pd_fn'])) ? $_POST['pd_fn'] : null ,
 					'fecha_ing' => (isset($_POST['pd_ing'])) ? $_POST['pd_ing'] : null ,
 					'email' => (isset($_POST['email'])) ? $_POST['email'] : null ,
 					);
 				$pdat = new Personal_dato($pdat);
 				$pdat->insert(); 
 				if(isset($_POST['eval'])){
 					foreach ($_POST['eval'] as $key => $value) {
 						$p_test->{$value}=1;
 						switch ($value) {
 							case 'scorer':
 							$sc_estado->activo=1;
 							$sc_estado->update();
 							break;
 						}
 					}
 					$p_test->update();
 				}
 				$nombre =  ucwords($_POST['pr_nombre']); 
 				$user = Util::passHasher($nombre,rand(1,20));
 				$pass = Util::passHasher($nombre,rand(21,30));
 				$user_obj = array(
 					'user_name' => $user, 
 					'password' => Util::passHasher($pass,6), 
 					'user_rol' => 2, 
 					'id_empresa' => $id_e, 
 					'id_personal' => $id, 
 					'token' => $pass, 
 					);
 				$user_obj = new User($user_obj);
 				$user_obj->insert();

 				$subject="Nuevo Usuario y Password para ".$nombre;
 				$mensaje = "Estimado ".$nombre.", el vínculo adjunto lo conducirá directamente a la pantalla de usuario para el personal de la empresa <b>".$this->Personal->htmlprnt($_SESSION['Empresa']['nombre'])."</b>. Por favor recuerde su Usuario y su Contraseña para su uso futuro.<br>
 				<p>&nbsp;</p>Vínculo.- <a style='text-decoration:underline' href = '".BASEURL."'>".BASEURL."</a><br>".
 				"<table><tr><td><b>Usuario<b></td><td>".$user."</td></tr><tr><td><b>Contraseña<b></td><td>".$pass."</td></tr></table>";
 				$correo = $_POST['email'];
 				Util::sendMail($correo,$subject,$mensaje);

 				$p_local = array_filter($_POST['p_local']);
 				$p_local = array_pop($p_local);
 				
 				if(!isset($_POST['pid_sup']))
 					$_POST['pid_sup'] = null;
 				if(!isset($_POST['cond_opcion']))
 					$_POST['cond_opcion'] = null;

 				if($_POST['cond_opcion'] == null)
 					$cond=var_export($_POST['cond_opcion'], true);
 				else
 					$cond=$this->Personal->db_prep($_POST['cond_opcion']);
 				
 				if(isset($_POST['not_sis']))
 					$not_sup=1;
 				else
 					$not_sup=0;
 				$pemp = new Personal_empresa(
 					array(
 						'id_personal' => $id, 
 						'id_empresa' => $id_e, 
 						'id_area' => $_POST['p_area'], 
 						'id_local' => $p_local, 
 						'id_cargo' => $_POST['cargo'], 
 						'pid_cg' => $_POST['cargo_s'], 
 						'pid_sup' => var_export($_POST['pid_sup'], true), 
 						'id_norg' => (isset($_POST['n_org'])) ? $_POST['n_org'] : var_export(null, true),
 						'id_tcont' => (isset($_POST['t_cont'])) ? $_POST['t_cont'] : var_export(null, true), 
 						'id_cond' => $this->Personal->db_prep($_POST['cond_opcion']), 
 						'salario' => $_POST['g_sal'], 
 						'not_sup' => $not_sup, 
 						'sueldo' => $_POST['sueldo'], 
 						)
 					);
 				$pemp->insert();
 				$pemp->getError();
 			}
 		}	
 	}

 	function editar_datos_empresa($id,$t=0){
 		$this->set('title','Alto Desempe&ntilde;o | Datos Basicos');
 		$this->hayPermisoAdmin();
 		$id_e = $this->Personal->get_empById($id);
 		if($this->esPermisoAdmin()){
 			$_SESSION['Empresa']['id'] = $id_e;
 		}
 		 		
 		if(isset($_POST['gpde'])){
 			$dat = $this->Personal->query_('select * from listado_personal_op where id = '.$id.'',1);
 			$query = 'UPDATE `personal` SET `nombre_p`="'.$_POST['pr_nombre'].'" WHERE id='.$id.'';
 			$this->Personal->query($query);
 			echo mysqli_error($this->link);
 			$query = 'UPDATE `personal_datos` SET `cedula`="'.$_POST['pd_ci'].'", `fecha_nac`="'.$_POST['pd_fn'].'", `fecha_ing`="'.$_POST['pd_ing'].'", `email`="'.$_POST['email'].'",`sexo`="'.$_POST['sexo'].'" WHERE `id_persona`='.$id.'';
 			$this->Personal->query($query);

 			if(isset($_POST['eval'])){
 				foreach ($_POST['eval'] as $key => $value) {
 					$sql = 'UPDATE `personal_test` SET `'.$value.'`=1 WHERE id_personal='.$id.'';
 					$this->Personal->query($sql);
 				}
 			}

 			// SENDMAIL
 			if(isset($_POST['sendmail'])){
 				$nombre = $this->Personal->get_pname($id);
 				$user=new User();
 				$user->select($id);
 				$subject="Nuevo Usuario y Password para ".$nombre;
 				$mensaje = "Estimado ".$nombre.", el vínculo adjunto lo conducirá directamente a la pantalla de usuario para el personal de la empresa <b>".$this->Personal->htmlprnt($_SESSION['Empresa']['nombre'])."</b>. Por favor recuerde su Usuario y su Contraseña para su uso futuro. Esta información podrá ser utilizada para las evalaciones que deba realizar. Se le enviará un nuevo correo por cada evaluación, el Usuario y Contraseña serán los mismos. <br>
 				Vínculo.- <a href = '".BASEURL."'>".BASEURL."</a><br><p>&nbsp;</p>".
 				"<table><tr><td><b>Usuario<b></td><td>".$user->user_name."</td></tr><tr><td><b>Contraseña<b></td><td>".$user->token."</td></tr></table>";
 				$correo = $_POST['email'];
 			// echo "<script>Se ha ingresado nuevo personal, un coreo se envia automaticamente a la dirección ingresada</script>";
 				Util::sendMail($correo,$subject,$mensaje);
 				if($t){
 					$this->Personal->query('INSERT INTO personal_empresa (id_personal,id_empresa) VALUES ('.$id.','.$id_e.');');
 					$t=0;
 				}
 			}
//test
 			if (filter_var($_POST['p_area'])){
 				$query = 'UPDATE `personal_empresa` SET `id_area`='.$_POST['p_area'].' WHERE id_personal='.$id.'';
 				$this->Personal->query($query);
 				echo "area".mysqli_error($this->link);
 			}
 			if (array_filter($_POST['p_local'])){
 				$p_local = array_filter($_POST['p_local']);
 				$p_local = array_pop($p_local);
 				$query = 'UPDATE `personal_empresa` SET `id_local`='.$p_local.' WHERE id_personal='.$id.'';
 				$this->Personal->query($query);
 				echo "local".mysqli_error($this->link);
 			}

 			$_POST['pid_sup'] = (isset($_POST['pid_sup'])) ? $_POST['pid_sup'] : $dat['id_superior'] ;
 			$_POST['cargo_s'] = (isset($_POST['pid_sup'])) ? $_POST['cargo_s'] : null ;
 			$_POST['n_org'] = (isset($_POST['n_org'])) ? $_POST['n_org'] : null ;
 			$_POST['t_cont'] = (isset($_POST['t_cont'])) ? $_POST['t_cont'] : null ;
 			$cond_opc = (isset($_POST['cond_opcion'])) ? $this->Personal->db_prep_($_POST['cond_opcion']) : null ;
 			$query = 'UPDATE `personal_empresa` SET `pid_cg`='.var_export($_POST['cargo_s'], true).',`pid_sup`='.var_export($_POST['pid_sup'], true).' WHERE id_personal='.$id.'';
 			$this->Personal->query($query);

 			$query = 'UPDATE `personal_empresa` 
					  SET 	`id_cargo`="'.$_POST['cargo'].'",
					  		`salario`='.var_export($_POST['g_sal'], true).',
						  	`sueldo`='.var_export($_POST['sueldo'], true).',
						  	`id_norg`='.var_export($_POST['n_org'], true).', 
						  	`id_tcont`='.var_export($_POST['t_cont'], true).'';
			
			if(isset($_POST['cond_opcion']))
			{
				$query .= ',`id_cond`='. var_export($cond_opc, true);
			}

			$query .= ' WHERE id_personal='.$id.'';
			//die($query);
 			$this->Personal->query($query);
 			echo mysqli_error($this->link);

 			
 			$sql = (isset($_POST['not_sis'])) ? 'UPDATE `personal_empresa` SET `not_sup`=1 WHERE id_personal='.$id.'' : 'UPDATE `personal_empresa` SET `not_sup`=0 WHERE id_personal='.$id.'' ;
 			$this->Personal->query($sql);

 			$_POST=null;
			// header("Location: " . BASEURL.'personal/editar_datos_empresa');	
 		}	

 		$this->set('id',$id);
 		$this->set('t',$t);
 		$this->set('id_e',$id_e);
 		$this->set('cond',$this->Personal->DB_exists_double('empresa_cond','id_empresa',$id_e,'nivel','0'));
 		$this->set('eval',$this->Personal->query('select `compass_360`, `scorer`, `matriz` from empresa where id='.$_SESSION["Empresa"]["id"].'',1));
 		$this->set('dat',$this->Personal->query_('select * from listado_personal_op where id = '.$id.'',1));
 		$this->set('grados',Grado_salarial::select_all($id_e));
 	}

 	function datos_personales(){
 		$this->set('title','Alto Desempe&ntilde;o | Ingreso Personal');
 		$this->hayEmpresa();
 		$id_e = $_SESSION["Empresa"]["id"];
 		if(isset($_POST['personal_datos'])){
 			$_SESSION['personal']['id'] = $id = $_SESSION['USER-AD']['id_personal'];
 			$file = array_filter($_FILES['file']);
 			if(isset($file['name'])){
 				//$query = $this->Personal->image_prep_($_FILES['file'],'personal','id',$id);
				$query = $this->Personal->image_prep__($_FILES['file'],'personal','id',$id);
 				$this->Personal->query($query);
 			}
 			$query = 'UPDATE `personal_datos` SET `pais`="'.ucwords($_POST['dir_p']).'",`ciudad`="'.ucwords($_POST['dir_ec']).'",`sector`="'.ucwords($_POST['dir_s']).'",`calles`="'.ucwords($_POST['dir_c']).'",`manz`="'.ucwords($_POST['dir_mz']).'",`villa`="'.ucwords($_POST['dir_v']).'",`num_con`="'.$_POST['pd_num'].'",`num_cel`="'.$_POST['pd_cnum'].'" WHERE `id_persona`="'.$_SESSION['Personal']['id'].'"';
 			$this->Personal->query($query);
 			echo mysqli_error($this->link);
 			if (isset($_POST['estado_civil'])){
 				if($_POST['estado_civil']!=""){
 					if(@$_POST['b_hijos']){
 						$_POST['b_hijos'] = 1;
 					}else{
 						$_POST['b_hijos'] = 0;
 					}
 					$pdf = new Personal_datos_familiar();
 					$pdf->setId_personal($_SESSION['USER-AD']['id_personal']);
 					$pdf->setEstado_civil($_POST['estado_civil']);
 					$pdf->setN_conyugue(ucwords($_POST['n_cony']));
 					$pdf->setFn_conyugue($_POST['fn_cony']);
 					$pdf->setF_matrimonio($_POST['fmat']);
 					$pdf->setT_hijos($_POST['b_hijos']);
 					$pdf->insert();
 					if ($_POST['b_hijos']){
 						$pdh = new Personal_datos_hijos();
 						$pdh->delete_all($_SESSION['USER-AD']['id_personal']);
 						$pdh->setId_personal($_SESSION['USER-AD']['id_personal']);
 						foreach ($_POST['h_nombre'] as $a => $b) {
 							$pdh->setNombre_hijo(ucwords($b));
 							$pdh->setFecha_nacimiento($_POST['h_fn'][$a]);
 							$pdh->insert();
 						}
 					}
 				}
 			}		
 			if (isset($_POST['titulo'])){
				// EDUCACION PERSONAL
 				$tmp= array_filter($_POST['titulo']);
 				if(!empty($tmp)){
 					$this->Personal->query('DELETE FROM `personal_ed_formal` WHERE `id_persona`='.$_SESSION['USER-AD']['id_personal'].'');
 					foreach ($_POST['titulo'] as $a => $b) {
 						$this->Personal->query('INSERT INTO `personal_ed_formal`(`id_persona`, `titulo`, `carrera`, `area_estudio`, `institucion`, `pais`, `ciudad`,`fecha`) VALUES ('. $_SESSION['USER-AD']['id_personal'] .',"'.ucwords($_POST['titulo'][$a]).'","'.ucwords($_POST['carr'][$a]).'","'.ucwords($_POST['a_est'][$a]).'","'.ucwords($_POST['inst'][$a]).'","'.ucwords($_POST['pais'][$a]).'","'.ucwords($_POST['ciud'][$a]).'","'.$_POST['fecha'][$a].'")');
 					}
 				}
				// EDUCACION PERSONAL CURSOS
 				$tmp= array_filter($_POST['c_titulo']);
 				if(!empty($tmp)){
 					$this->Personal->query('DELETE FROM `personal_cursos` WHERE `id_persona`='.$_SESSION['USER-AD']['id_personal'].'');
 					foreach ($_POST['c_titulo'] as $a => $b) {
 						$this->Personal->query('INSERT INTO `personal_cursos`(`id_persona`, `titulo`, `area_estudio`, `horas`, `institucion`, `pais`, `ciudad`,`fecha`) VALUES ('. $_SESSION['USER-AD']['id_personal'] .',"'.ucwords($_POST['c_titulo'][$a]).'","'.ucwords($_POST['c_area'][$a]).'","'.ucwords($_POST['c_horas'][$a]).'","'.ucwords($_POST['c_inst'][$a]).'","'.ucwords($_POST['c_pais'][$a]).'","'.ucwords($_POST['c_ciud'][$a]).'","'.$_POST['c_fecha'][$a].'")');
 					}
 				}
				// EDUCACION PERSONAL CURSOS INTERNOS
 				$tmp= array_filter($_POST['c_titulo_int']);
 				if(!empty($tmp)){
 					$this->Personal->query('DELETE FROM `personal_cursos_internos` WHERE `id_persona`='.$_SESSION['USER-AD']['id_personal'].'');
 					foreach ($_POST['c_titulo_int'] as $a => $b) {
 						$this->Personal->query('INSERT INTO `personal_cursos_internos`(`id_persona`, `titulo`, `area_estudio`, `horas`, `institucion`, `pais`, `ciudad`,`fecha`) VALUES ('. $_SESSION['USER-AD']['id_personal'] .',"'.ucwords($_POST['c_titulo_int'][$a]).'","'.ucwords($_POST['c_area_int'][$a]).'","'.ucwords($_POST['c_horas_int'][$a]).'","'.$_SESSION['Empresa']['nombre'].'","'.ucwords($_POST['c_pais_int'][$a]).'","'.ucwords($_POST['c_ciud_int'][$a]).'","'.ucwords($_POST['c_fecha_int'][$a]).'")');
 					}
 				}
				// EDUCACION PERSONAL HISTORIA LABORAL
 				$tmp= array_filter($_POST['hl_cargo']);
 				if(!empty($tmp)){
 					$this->Personal->query('DELETE FROM `personal_hlaboral` WHERE `id_persona`='.$_SESSION['USER-AD']['id_personal'].'');
 					foreach ($_POST['hl_cargo'] as $a => $b) {
 						$this->Personal->query('INSERT INTO `personal_hlaboral`(`id_persona`, `cargo`, `empresa`, `f_inicio`, `f_fin`) VALUES ('. $_SESSION['USER-AD']['id_personal'] .',"'.ucwords($_POST['hl_cargo'][$a]).'","'.ucwords($_POST['hl_emp'][$a]).'","'.$_POST['hl_fini'][$a].'","'.$_POST['hl_ffin'][$a].'")');			
 					}
 				}
				// EDUCACION PERSONAL IDIOMAS
 				$tmp= array_filter($_POST['pi_idioma']);
 				if(!empty($tmp)){
 					$this->Personal->query('DELETE FROM `personal_idioma` WHERE `id_personal`='.$_SESSION['USER-AD']['id_personal'].'');
 					$pi = new personal_idioma();
 					foreach ($_POST['pi_idioma'] as $a => $b) {
 						$pi->setId_personal($_SESSION['USER-AD']['id_personal'])->setIdioma(ucwords($_POST['pi_idioma'][$a]))->setInstitucion(ucwords($_POST['pi_inst'][$a]))->setEntendimiento($_POST['pi_entendimiento'][$a])->setEscrito($_POST['pi_escrito'][$a])->setHablado($_POST['pi_hablado'][$a])->setLeido($_POST['pi_leido'][$a])->setFecha_desde($_POST['pi_fdes'][$a])->setFecha_hasta($_POST['pi_fhas'][$a]);
 						$pi->insert();
 					}
 				}
				// PERSONAL PREMIOS
 				$tmp= array_filter($_POST['prem_premio']);
 				if(!empty($tmp)){
 					$this->Personal->query('DELETE FROM `personal_premio` WHERE `id_personal`='.$_SESSION['USER-AD']['id_personal'].'');
 					$pp = new personal_premio();
 					foreach ($_POST['prem_premio'] as $a => $b) {
 						$pp->setId_personal($_SESSION['USER-AD']['id_personal'])->setPremio(ucwords($_POST['prem_premio'][$a]))->setInstitucion(ucwords($_POST['prem_inst'][$a]))->setItem($_POST['prem_item'][$a])->setFecha($_POST['prem_f'][$a]);
 						$pp->insert();
 						echo mysqli_error($this->link);
 					}
 				}
 			}

 			if(isset($_POST['nombre_vecino'])){
 				$this->Personal->query('INSERT INTO `personal_ugmaps`(`id_personal`,`u_gmaps`,`nombre_vecino`,`tel_vecino`) VALUES ('. $_SESSION['USER-AD']['id_personal'] .',"'.$_POST['u_gm'].'","'.ucwords($_POST['nombre_vecino']).'","'.$_POST['tel_vecino'].'") ON DUPLICATE KEY UPDATE `u_gmaps`="'.$_POST['u_gm'].'",`nombre_vecino`="'.ucwords($_POST['nombre_vecino']).'",`tel_vecino`="'.$_POST['tel_vecino'].'" ');
 				$file = array_filter($_FILES['file-casa']);
 				if(isset($file['name'])){
 					//$query = $this->Personal->image_prep_($_FILES['file-casa'],'personal_ugmaps','id_personal',$id);
					$query = $this->Personal->image_prep__($_FILES['file-casa'],'personal_ugmaps','id_personal',$id);
 					// echo $query;
 					$this->Personal->query($query);
 					echo mysqli_error($this->link);
 				}
 			}
 			@header("Location: " . BASEURL.'user/home');
 		}		
 		$this->set('id',$_SESSION['USER-AD']['id_personal']);
 		$res = $this->Personal->query('SELECT * FROM personal_datos WHERE id_persona='.$_SESSION['USER-AD']['id_personal'].'',1);
 		$this->set('dat_p',@reset($res));
 		$res = $this->Personal->query('SELECT * FROM personal_ugmaps WHERE id_personal='. $_SESSION['USER-AD']['id_personal'] .'',1);
 		if($res)		
 			$this->set('datos',@reset($res));
 		else
 			$this->set('datos',$arr = array('u_gmaps' => "-1.7864638,-78.1368875" ));
 		$res = $this->Personal->query('SELECT * FROM `personal_ed_formal` WHERE `id_persona`='.$_SESSION['USER-AD']['id_personal'].'',1);
 		$res = @reset($res);
 		$this->set('ed_f',$res);
 		$res = $this->Personal->query('SELECT * FROM `personal_ed_formal` WHERE `id_persona`='.$_SESSION['USER-AD']['id_personal'].'');
 		$this->set('ed_for',$res);
 		$res = $this->Personal->query('SELECT * FROM `personal_cursos` WHERE `id_persona`='.$_SESSION['USER-AD']['id_personal'].'');
 		$this->set('per_c',$res);
 		$res = $this->Personal->query('SELECT * FROM `personal_cursos_internos` WHERE `id_persona`='.$_SESSION['USER-AD']['id_personal'].'');
 		$this->set('per_i',$res);
 		$res = $this->Personal->query('SELECT * FROM `personal_hlaboral` WHERE `id_persona`='.$_SESSION['USER-AD']['id_personal'].'');
 		$this->set('per_h',$res);
 		$res = $this->Personal->query('SELECT * FROM `personal_idioma` WHERE `id_personal`='.$_SESSION['USER-AD']['id_personal'].'');
 		$this->set('per_id',$res);
 		$res = $this->Personal->query('SELECT * FROM `personal_premio` WHERE `id_personal`='.$_SESSION['USER-AD']['id_personal'].'');
 		$this->set('per_prem',$res);
 	}

 	function viewall($id=null){
 		$this->set('title','Alto Desempe&ntilde;o | Vista Personal');
 		$this->hayPermisoAdmin();
 		if(isset($id)){
 			$_SESSION["Empresa"]["id"] = $id;
 		}
 		$lp = new listado_personal_op();
 		$result = $lp->select_all($_SESSION['Empresa']['id']);
 		$this->set('result', $result);
 		$result = $lp->select_all($_SESSION['Empresa']['id'],0);
 		$this->set('inactive', $result);
 		// $this->set('result',null);
 	}

 	function viewall_deprecated($id=null){
 		$this->set('title','Alto Desempe&ntilde;o | Vista Personal');
 		$this->hayPermisoAdmin();
 		switch ($_SESSION['USER-AD']['user_rol']) {
 			case 0:
 			$this->set('backlink','empresa/consolidado/'.$id);
 			break;
 		}
 		if(isset($id)){
 			$_SESSION["Empresa"]["id"] = $id;
 		}
 		$arr = $this->Personal->query('SELECT * FROM `empresa_cond` WHERE `id_empresa`=' . $_SESSION["Empresa"]["id"] . ' AND nivel=0');
 		$this->set('condicionadores',$arr);
 		$arr = $this->Personal->query_('SELECT `compass_360`,`scorer`,`matriz`,`clima_laboral` FROM `empresa` WHERE `id`=' . $_SESSION["Empresa"]["id"] . '',1);
 		$this->set('evaluaciones',$arr);
 		if(isset($_POST['filtrar'])){
 			if(isset($_POST['filtro'])){
 				$fields = ',`'.implode('`,`', $_POST['filtro']).'`';
 			}else{
 				$fields = '';
 			}
 			if(isset($_POST['cond'])){
 				$fields .= ',condicionadores';
 			}
 			$sql = 'SELECT `id`,`nombre` '.$fields.' FROM `listado_personal` WHERE `empresa`=' . $_SESSION["Empresa"]["id"] . '';
 			$filtered_val = $this->Personal->query($sql);
 			if(isset($_POST['cond'])){
 				foreach ($filtered_val as $key => $value) {
 					$value=reset($value);
 					$cond = $value['condicionadores'];
 					unset($value['condicionadores']);
 					$cond = unserialize($cond);
 					foreach ($_POST['cond'] as $a => $b) {
 						foreach ($cond as $c => $d) {
 							if($this->Personal->isCondChild($b,$d))
 								$value['cond'.$this->Personal->get_cond($b)] = $d;
 						}
 					}
 					$final[]['listado']=$value;
 				}
 			}else{
 				$final = $filtered_val;
 			}
 			$this->set('resultados',$final);
 		}else{
 			$sql = 'SELECT `id`,`nombre`,`cargo` FROM `listado_personal` WHERE `empresa`=' . $_SESSION["Empresa"]["id"] . ' order by nombre ASC';
 			$final = $this->Personal->query($sql);
 			$this->set('resultados',$final);
 			$sql = 'SELECT `id`,`nombre_p` FROM `personal` WHERE `id_empresa`=' . $_SESSION["Empresa"]["id"] . ' AND `id` NOT IN (SELECT `id` FROM `listado_personal` WHERE `empresa`=' . $_SESSION["Empresa"]["id"] . ' order by nombre ASC)';
 			$final = $this->Personal->query_($sql);
 			$this->set('resultados2',$final);
 		}
 	}

 	function view($id){
 		$this->set('title','Alto Desempe&ntilde;o | Vista Personal');
 		$this->set('backlink','personal/viewall');
 		$this->hayPermisoAdmin();
 		$this->set('id',$id);

 	}

 	function select(){
 		$this->set('title','Alto Desempe&ntilde;o | Vista Personal');
 		$this->hayEmpresa();
 		if (isset($_POST['id'])){
 			$_SESSION['personal']['id'] = $_POST['id'];
 		}
		// var_dump($_SESSION['personal']['id']);
 	}

 	function datos_familiar(){
 		$this->set('title','Alto Desempe&ntilde;o | Datos Basicos');
 		$this->set('backlink',true);
 		@Util::sessionStart();	
 		if (isset($_POST['estado_civil'])){
 			if(@$_POST['b_hijos']){
 				$_POST['b_hijos'] = 1;
 			}else{
 				$_POST['b_hijos'] = 0;
 			}
 			$this->Personal->query('INSERT INTO `personal_datos_familiar`(`id_personal`, `estado_civil`, `n_conyugue`, `fn_conyugue`, `f_matrimonio`, `t_hijos`) VALUES ('. $_SESSION['USER-AD']['id_personal'] .','. $_POST['estado_civil'] .',"'. ucwords($_POST['n_cony']) .'","'. $_POST['fn_cony'] .'","'. $_POST['fmat'] .'",'. $_POST['b_hijos'] .')');
 			echo mysqli_error($this->link);
 			if ($_POST['b_hijos']){
 				foreach ($_POST['h_nombre'] as $a => $b) {
 					$this->Personal->query('INSERT INTO `personal_datos_hijos`(`id_personal`, `nombre_hijo`, `fecha_nacimiento`) VALUES ('. $_SESSION['USER-AD']['id_personal'] .',"'. ucwords($b) .'","'. $_POST['h_fn'][$a] .'")');
 				}
 			}
 			if(mysqli_error($this->link)){
 				$error = mysqli_error($this->link);
 				echo $error;
 				echo "<script>alert('Ha ocurrido un error');</script>";
 			}else{
 				echo "<script>alert('Se han guardado los datos con éxito.');window.location = '".BASEURL.'user/view'."';</script>";
 			}
 		}
 	}

 	function educacion(){
 		$this->set('title','Alto Desempe&ntilde;o | Datos Basicos');
 		$this->set('backlink',true);
 		@Util::sessionStart();			
 		if (isset($_POST['titulo'])){

			// EDUCACION PERSONAL
 			$tmp= array_filter($_POST['titulo']);
 			if(!empty($tmp)){
 				$this->Personal->query('DELETE FROM `personal_ed_formal` WHERE `id_persona`='.$_SESSION['USER-AD']['id_personal'].'');
 				foreach ($_POST['titulo'] as $a => $b) {
 					$this->Personal->query('INSERT INTO `personal_ed_formal`(`id_persona`, `titulo`, `carrera`, `area_estudio`, `institucion`, `pais`, `ciudad`,`fecha`) VALUES ('. $_SESSION['USER-AD']['id_personal'] .',"'.ucwords($_POST['titulo'][$a]).'","'.ucwords($_POST['carr'][$a]).'","'.ucwords($_POST['a_est'][$a]).'","'.ucwords($_POST['inst'][$a]).'","'.ucwords($_POST['pais'][$a]).'","'.ucwords($_POST['ciud'][$a]).'","'.$_POST['fecha'][$a].'")');
 				}
 			}
			// EDUCACION PERSONAL CURSOS
 			$tmp= array_filter($_POST['c_titulo']);
 			if(!empty($tmp)){
 				$this->Personal->query('DELETE FROM `personal_cursos` WHERE `id_persona`='.$_SESSION['USER-AD']['id_personal'].'');
 				foreach ($_POST['c_titulo'] as $a => $b) {
 					$this->Personal->query('INSERT INTO `personal_cursos`(`id_persona`, `titulo`, `area_estudio`, `horas`, `institucion`, `pais`, `ciudad`,`fecha`) VALUES ('. $_SESSION['USER-AD']['id_personal'] .',"'.ucwords($_POST['c_titulo'][$a]).'","'.ucwords($_POST['c_area'][$a]).'","'.ucwords($_POST['c_horas'][$a]).'","'.ucwords($_POST['c_inst'][$a]).'","'.ucwords($_POST['c_pais'][$a]).'","'.ucwords($_POST['c_ciud'][$a]).'","'.$_POST['c_fecha'][$a].'")');
 				}
 			}
			// EDUCACION PERSONAL CURSOS INTERNOS
 			$tmp= array_filter($_POST['c_titulo_int']);
 			if(!empty($tmp)){
 				$this->Personal->query('DELETE FROM `personal_cursos_internos` WHERE `id_persona`='.$_SESSION['USER-AD']['id_personal'].'');
 				foreach ($_POST['c_titulo_int'] as $a => $b) {
					//ucwords($_POST['c_inst_int'][$a])
 					$this->Personal->query('INSERT INTO `personal_cursos_internos`(`id_persona`, `titulo`, `area_estudio`, `horas`, `institucion`, `pais`, `ciudad`) VALUES ('. $_SESSION['USER-AD']['id_personal'] .',"'.ucwords($_POST['c_titulo_int'][$a]).'","'.ucwords($_POST['c_area_int'][$a]).'","'.ucwords($_POST['c_horas_int'][$a]).'","'.$_SESSION['Empresa']['nombre'].'","'.ucwords($_POST['c_pais_int'][$a]).'","'.ucwords($_POST['c_ciud_int'][$a]).'")');
 				}
 			}
			// EDUCACION PERSONAL HISTORIA LABORAL
 			$tmp= array_filter($_POST['hl_cargo']);
 			if(!empty($tmp)){
 				$this->Personal->query('DELETE FROM `personal_hlaboral` WHERE `id_persona`='.$_SESSION['USER-AD']['id_personal'].'');
 				foreach ($_POST['hl_cargo'] as $a => $b) {
 					$this->Personal->query('INSERT INTO `personal_hlaboral`(`id_persona`, `cargo`, `empresa`, `f_inicio`, `f_fin`) VALUES ('. $_SESSION['USER-AD']['id_personal'] .',"'.ucwords($_POST['hl_cargo'][$a]).'","'.ucwords($_POST['hl_emp'][$a]).'","'.$_POST['hl_fini'][$a].'","'.$_POST['hl_ffin'][$a].'")');			
					//$this->Personal->query('INSERT INTO `personal_hlaboral`(`id_persona`, `cargo`, `empresa`, `f_inicio`, `f_fin`, `descripcion`) VALUES ('. $_SESSION['USER-AD']['id_personal'] .',"'.ucwords($_POST['hl_cargo'][$a]).'","'.ucwords($_POST['hl_emp'][$a]).'","'.$_POST['hl_fini'][$a].'","'.$_POST['hl_ffin'][$a].'",NULL)');			
					//,"'.$_POST['hl_desc'][$a].'"
 				}
 			}
 			$err=mysqli_error($this->link);
			// var_dump($err);
 			if($err){
 				echo "<script>alert('Ha ocurrido un error: ".$err."');</script>";
 			}else{
 				echo "<script>alert('Se han guardado los datos con éxito.');window.location = '".BASEURL.'user/view'."';</script>";
 			}
 		}
 		$res = $this->Personal->query('SELECT * FROM `personal_ed_formal` WHERE `id_persona`='.$_SESSION['USER-AD']['id_personal'].'',1);
 		$res = @reset($res);
 		$this->set('ed_f',$res);
 		$res = $this->Personal->query('SELECT * FROM `personal_ed_formal` WHERE `id_persona`='.$_SESSION['USER-AD']['id_personal'].'');
 		$this->set('ed_for',$res);
 		$res = $this->Personal->query('SELECT * FROM `personal_cursos` WHERE `id_persona`='.$_SESSION['USER-AD']['id_personal'].'');
 		$this->set('per_c',$res);
 		$res = $this->Personal->query('SELECT * FROM `personal_cursos_internos` WHERE `id_persona`='.$_SESSION['USER-AD']['id_personal'].'');
 		$this->set('per_i',$res);
 		$res = $this->Personal->query('SELECT * FROM `personal_hlaboral` WHERE `id_persona`='.$_SESSION['USER-AD']['id_personal'].'');
 		$this->set('per_h',$res);
 	}

 	function ubicacion(){
 		$this->set('title','Alto Desempe&ntilde;o | Datos Basicos');
 		$this->set('backlink',true);
 		@Util::sessionStart();	
 		if(isset($_POST['nombre_vecino'])){
 			$this->Personal->query('INSERT INTO `personal_ugmaps`(`id_personal`,`u_gmaps`,`nombre_vecino`,`tel_vecino`) VALUES ('. $_SESSION['USER-AD']['id_personal'] .',"'.$_POST['u_gm'].'","'.ucwords($_POST['nombre_vecino']).'","'.$_POST['tel_vecino'].'") ON DUPLICATE KEY UPDATE `u_gmaps`="'.$_POST['u_gm'].'",`nombre_vecino`="'.ucwords($_POST['nombre_vecino']).'",`tel_vecino`="'.$_POST['tel_vecino'].'" ');
 			$query = $this->Personal->image_prep($_FILES['file'],'personal_ugmaps','id_personal',$_SESSION['USER-AD']['id_personal']);
 			$this->Personal->query($query);
 			if(mysqli_error($this->link)){
 				echo "<script>alert('Ha ocurrido un error');</script>";
 			}else{
 				echo "<script>alert('Se han guardado los datos con éxito.');window.location = '".BASEURL.'user/view'."';</script>";
 			}
 		}
 		$res = $this->Personal->query('SELECT * FROM personal_ugmaps WHERE id_personal='. $_SESSION['USER-AD']['id_personal'] .'',1);
 		if($res)
 			$this->set('datos',@reset($res));
 		else
 			$this->set('datos',$arr = array('u_gmaps' => "-1.7864638,-78.1368875" ));
 	}

 	function subalternos(){
 		$this->haySession();
 		$lp = new listado_personal_op();
 		$lp->setId($_SESSION['USER-AD']['id_personal']);
 		$this->set('res',$lp->getSubalternos__());
 	}



	/*





	*/

	function logout(){
		Util::sessionLogout();
		$this->Personal->disconnect();
		$this->_template = new Template('Inicio','principal', false);
	}

	function cambiar_empresa(){
		@Util::sessionStart();
		$_SESSION['Empresa'] = null;
		$this->hayEmpresa();
	}

	function ingresar_nueva(){
		@Util::sessionStart();
		$_SESSION['Empresa'] = null;
		$this->_template = new Template('Personal','empresa_ingreso');
		$this->empresa_ingreso();		
	}

	function haySession(){
		@Util::sessionStart();
		if (!isset($_SESSION['USER-AD'])){
			$this->logout();	
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

	function hayPermisoAdmin(){
		@Util::sessionStart();
		$session = $this->haySession();
		if ($session && ($_SESSION['USER-AD']['user_rol']==2)) {
			echo "<script>alert('No tiene los permisos necesarios para navegar esta sección');window.location = '".BASEURL.$_SESSION['link']."';</script>";
		}
		return true;
	}

	function esPermisoAdmin(){
		@Util::sessionStart();
		$session = $this->haySession();
		if ($session && !($_SESSION['USER-AD']['user_rol'])) {
			return true;
		}
		return false;
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

	function hayEmpresa(){
		$this->haySession();
		if (!isset($_SESSION['Empresa'])){
			$this->logout();
		}
	}

	function hayPersonal(){
		$this->haySession();
		if (!isset($_SESSION['personal']['id'])){
			$this->_template = new Template('Personal','ingreso');
			$this->datos();
			exit();
		}
	}
}