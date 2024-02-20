<?php

class ScorerController extends Controller {

	protected $link;
	
	function __construct($model, $controller, $action, $type = 0) {

		parent::__construct($model, $controller, $action, $type);

		$this->link = $this->Void->getDBHandle();
	}
	
	function render() {
		$this->set('title','');
	}
	
}






