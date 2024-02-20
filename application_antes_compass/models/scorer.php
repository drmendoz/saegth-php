<?php

class Scorer {
	public static $num = 1;
	public $res1_min;
	public $res1_max;
	public $res2_min;
	public $res2_max;
	public $res3_min;
	public $res3_max;
	public $res4_min;
	public $res4_max;
	public $res5_min;
	public $res5_max;
	public $vinicial;
	public $col;
	public $razon;
	public $vfinal;
	public $p_score;
	public $p_compass;

	function __construct($parameters = array()) {
      foreach($parameters as $key => $value) {
          $this->$key = $value;
      }
  }

}

class Metas {
	public $colnum;
	public $val;
}
