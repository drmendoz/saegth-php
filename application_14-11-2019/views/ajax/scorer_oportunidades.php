<?php

if($_REQUEST)
{
	$oportunidad = new Scorer_oportunidad($_POST);
	echo $oportunidad->insert();
}

?>