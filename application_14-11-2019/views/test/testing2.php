<?php  
$ea = new empresa_area();
$res = $ea->get_all_children(277);
var_dump($res);
?>