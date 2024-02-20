<?php
$name = explode('/',$test['Pdf_test']['url']);

var_dump($name[count($name) - 1]);

header('Content-disposition: attachment; filename="'.$name[count($name) - 1].'"');
header('Content-type: "text/xml"; charset="utf8"');
readfile($test['Pdf_test']['url']);

?>