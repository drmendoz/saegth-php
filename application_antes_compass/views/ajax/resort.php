<?php

$meth = new Ajax();

if($_REQUEST)
{	
	if(!$_REQUEST['res']){
		$meth->connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
	}else{
		$meth->disconnect();
	}
}
?>