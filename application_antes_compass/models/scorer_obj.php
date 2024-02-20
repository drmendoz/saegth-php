<?php

class Scorer_obj {
	public $objetivo;
	public $indicador;
	public $inverso;
	public $periodo;
	public $unidad;
	public $meta;
	public $peso;
	public $lreal;
	public $lpond;
	public $ppond;

	function __construct($parameters = array()) {
      foreach($parameters as $key => $value) {
          $this->$key = $value;
      }
  }

}