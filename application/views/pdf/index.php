<?php	

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));
define('BASEURL', "http://localhost/aldes/");
define('IMGURL', "http://localhost/aldes/public/img");
define('FILEURL', "http://localhost/aldes/public/files");
define('EMAIL', "p.arredondov91@gmail.com");

if ($_GET) $url = $_GET['url'];

require_once (ROOT . DS . 'library' . DS . 'bootstrap.php');