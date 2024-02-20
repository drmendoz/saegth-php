<?php
class Template {

	protected $variables = array();
	protected $_controller;
	protected $_action;
	protected $_type;
	protected $_full;

	function __construct($controller,$action, $type = 0, $full = false) {
		$this->_controller = lcfirst($controller);
		$this->_action = $action;
		$this->_type = $type;
		//0 normal
		//1 download
		//2 webservice		
		$this->_full = $full;
		if($controller!='navbar'){
			$GLOBALS['model_x'] = $controller;
			$GLOBALS['action_x'] = $action;
		}
		if (($controller == 'user') && ($action == 'login')){
			$this->_full = true;
		}
	}

	/** Set Variables **/

	function set($name,$value) {
		$this->variables[$name] = $value;
	}

	/** Display Template **/

	function render() {
		extract($this->variables);
		
		if($this->_type == 0){
			if($this->_full){
				$headerfile = ROOT . DS . 'application' . DS . 'views' . DS . $this->_controller . DS . 'header-full.php';
				$footerfile = ROOT . DS . 'application' . DS . 'views' . DS . $this->_controller . DS . 'footer-full.php';	
			}else{
				$headerfile = ROOT . DS . 'application' . DS . 'views' . DS . $this->_controller . DS . 'header.php';
				$footerfile = ROOT . DS . 'application' . DS . 'views' . DS . $this->_controller . DS . 'footer.php';
			}
			if (file_exists($headerfile)) {
				include ($headerfile);
			} else {
				include (ROOT . DS . 'application' . DS . 'views' . DS . 'header.php');
			}
			$does = file_exists(ROOT . DS . 'application' . DS . 'views' . DS . $this->_controller . DS . $this->_action . '.php');
			if ($does)
				include (ROOT . DS . 'application' . DS . 'views' . DS . $this->_controller . DS . $this->_action . '.php');
			else
				include (ROOT . DS . 'application' . DS . 'views' . DS . '404.php');
	
			if (file_exists($footerfile)) {
				include ($footerfile);
			} else {
				include (ROOT . DS . 'application' . DS . 'views' . DS . 'footer.php');
			}
		}elseif($this->_type == 1){
			include (ROOT . DS . 'application' . DS . 'views' . DS . 'download.php');
		}else{
			include (ROOT . DS . 'application' . DS . 'views' . DS . 'webservice.php');
		}
	}
	/** Display Template **/

	function render_() {
		extract($this->variables);
		
			$does = file_exists(ROOT . DS . 'application' . DS . 'views' . DS . $this->_controller . DS . $this->_action . '.php');
			if ($does)
				include (ROOT . DS . 'application' . DS . 'views' . DS . $this->_controller . DS . $this->_action . '.php');
			else
				include (ROOT . DS . 'application' . DS . 'views' . DS . '404.php');
	}

	function render_ajax() {
		extract($this->variables);
		
			$does = file_exists(ROOT . DS . 'application' . DS . 'views' . DS . $this->_controller . DS . $this->_action . '.php');
			if ($does)
				include (ROOT . DS . 'application' . DS . 'views' . DS . $this->_controller . DS . $this->_action . '.php');
	}

}
