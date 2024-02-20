<?php
class Controller {

	protected $_model;
	protected $_controller;
	protected $_action;
	protected $_template;
	protected $_autorender;

	function __construct($model, $controller, $action, $type = 0, $full = false,$render=false) {

		$this->_controller = $controller;
		$this->_action = $action;
		$this->_model = $model;

		$this->$model = new $model;
		$this->_autorender = $render;
		$this->_template = new Template($controller,$action, $type, $full,$render);

	}

	function getAction(){
		return $this->_action;
	}
	function getRender(){
		return $this->_autorender;
	}

	function set($name,$value) {
		$this->_template->set($name,$value);
	}

	function ar_destruct(){
		$this->_template->render_();
	}

	function ajax_destruct(){
		$this->_template->render__();
	}

	function __destruct() {
		//var_dump($this->getRender()." ".$this->getAction());
		if ($this->getRender()) {
			//$this->_template->render_();
		}else{
			$this->_template->render();
		}
	}

}
