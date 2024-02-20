<?php
$plan = new ValoracionController('Valoracion','valoracion','crear',0,true,true); 
$plan->crear($args); 
$plan->ar_destruct();
unset($plan); 