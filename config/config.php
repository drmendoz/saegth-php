<?php

/** Configuration Variables **/


define ('TIME_PERIOD',30);
define ('ATTEMPTS_NUMBER',3);
define ('TBL_ATTEMPTS','LoginAttempts');
define ('DEBUG',false);

date_default_timezone_set('America/Bogota');
setlocale(LC_TIME, 'es-ES');


if($_SERVER['HTTP_HOST'] == "localhost"){
	define ('DEBUG_MAIL',true);
	define ('DEVELOPMENT_ENVIRONMENT',true);
	define('DB_NAME', 'aldepyt');
	define('DB_USER', 'root');
	define('DB_PASSWORD', '');
	define('DB_HOST', 'localhost');
	define('BASEURL', 'http://localhost/aldes/');
}else{
	define ('DEBUG_MAIL',false);
	define ('DEVELOPMENT_ENVIRONMENT',false);
	define('DB_NAME', 'saegthco_db');
	define('DB_USER', 'saegthco_db');
	define('DB_PASSWORD', 'Nintendo64!');
	define('DB_HOST', 'localhost');
	define('BASEURL', 'http://'.$_SERVER['HTTP_HOST'].'/');
}