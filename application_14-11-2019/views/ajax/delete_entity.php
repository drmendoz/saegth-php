<?php
if($_REQUEST){
	var_dump($_REQUEST);
	$model = ucfirst($_REQUEST['model']);
	$tmp = new $model();
	$tmp->select($_REQUEST['id']);
	$tmp->delete();
}
?>