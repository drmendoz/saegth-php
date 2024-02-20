<?php 
	$meth=new Ajax();
	if($_REQUEST){
		switch ($_POST['campo']) {
			case 'eval':
				$field='evaluacion';
				break;
			case 'revi':
				$field='revision';
				break;
		}
		$meth->query('UPDATE SET '.$field.'='.$_POST['valor'].' WHERE id_personal='.$_POST['id'].'');
		echo $_POST['valor'];
	}

?>