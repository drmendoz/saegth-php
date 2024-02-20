<?php
		$meth = new Multifuente();
		$id=$_SESSION['Personal']['id'];
		$res = $meth->get_Eval($id);
		$res = reset($res);
		$cod_evaluado = $_SESSION['evaluado']['id'] = $res['cod_evaluado'];
var_dump($_POST);
if(isset($_POST['update'])){
			$x=0;
			foreach ($_POST['evaluacion'] as $a => $b) {
				switch ($b) {
					case 0:
						
						if($_POST['uori'][$a]=='update')
				 			$meth->query('UPDATE `multifuente_oportunidades` SET `cod_evaluado`="'.$cod_evaluado.'", `accion`="'.$_POST['accion'][$a].'", `tipo`="'.$_POST['tipo'][$a].'", `medicion`="'.$_POST['medicion'][$a].'", `fecha`="'.$_POST['fecha'][$a].'" WHERE `id`="'.$_POST['id'][$a].'"');
						else{
				 			$meth->query('INSERT INTO `multifuente_oportunidades` (`cod_evaluado`,`accion`,`tipo`,`medicion`,`fecha`,`cod_pregunta`) VALUES("'.$cod_evaluado.'","'.$_POST['accion'][$a].'","'.$_POST['tipo'][$a].'","'.$_POST['medicion'][$a].'","'.$_POST['fecha'][$a].'","'.$_POST['cod_p'][$a].'") ');
							echo mysqli_error($meth->link);
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
							// var_dump($s_op->id);
							$s_op->update();
						}
						break;
				}
				// echo mysqli_error($this->link);
			}
		}

?>