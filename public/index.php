<?php	

define('DS', DIRECTORY_SEPARATOR);
define('WEBMAIL', 'informacion@altodesempenio.com');
define('ROOT', dirname(dirname(__FILE__)));
define('FPDF_FONTPATH',ROOT . DS . 'public' . DS . 'font' . DS . '');
define('PHPEXCEL_ROOT',ROOT . DS . 'public' . DS . 'plugins' . DS . '');


if ($_GET) $url = $_GET['url'];
require_once (ROOT . DS . 'library' . DS . 'bootstrap.php');