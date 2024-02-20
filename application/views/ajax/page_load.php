<?php 
if($_REQUEST){
// var_dump($_REQUEST);
	$controller = ucfirst($_REQUEST['controller']);
	$action = $_REQUEST['action'];
	$args = (isset($_REQUEST['args'])) ? $_REQUEST['args'] : null ;
	$class=ucfirst($controller)."Controller";
	$template = new $class($controller,$controller,$action,0,true,true); 
	$template->{$action}($args); 
	$template->ar_destruct();
	unset($template); 
}
?>