<?php

class Valoracion extends Model {
	public $id;
	public $id_empresa;
	public $position;
	public $kh_col1;
	public $kh_col2;
	public $ps_col1;
	public $ps_col2;
	public $ac_col1;
	public $ac_col2;
	public $total;
	public $profile;

	
	public function __construct($parameters = array()) {
		parent::__construct();
		foreach($parameters as $key => $value) {
			$this->$key = $value;
		}
	}

	function insert(){
		$this->query('INSERT INTO valoracion (id_empresa,  position,  kh_col1,  kh_col2,  ps_col1,  ps_col2,  ac_col1,  ac_col2,  total,  profile) VALUES ('.$this->id_empresa.',  "'.$this->position.'",  '.$this->kh_col1.',  '.$this->kh_col2.',  '.$this->ps_col1.',  '.$this->ps_col2.',  '.$this->ac_col1.',  '.$this->ac_col2.',  '.$this->total.', '.$this->profile.')');
		echo mysqli_error($this->link);
		$this->id = mysqli_insert_id($this->link);
	}

	function update(){
		$this->query('UPDATE valoracion SET position="'.$this->position.'",  kh_col1='.$this->kh_col1.',  kh_col2='.$this->kh_col2.',  ps_col1='.$this->ps_col1.',  ps_col2='.$this->ps_col2.',  ac_col1='.$this->ac_col1.',  ac_col2='.$this->ac_col2.',  total='.$this->total.',  profile='.$this->profile.' WHERE id='.$this->id.'');
		echo mysqli_error($this->link);
	}

	function delete(){
		$this->query('DELETE FROM valoracion WHERE id='.$this->id.'');
		echo mysqli_error($this->link);
	}

	function getObj(){
		$this->objetivo = $this->query_('SELECT objetivo FROM valoracion WHERE id='.$this->id.'',1)['objetivo'];
	}

	function select_all(){
		return $this->query_('SELECT * FROM valoracion WHERE id_empresa='.$this->id_empresa.'');
	}

	function getById(){
		$res =$this->query_('SELECT * FROM valoracion WHERE id='.$this->id.'',1);
    echo mysqli_error($this->link);
		return new self($res);
  }

  public static function withID($id) {
  	$tmp = new self(array('id' => $id));	
  	return $tmp->getById();
  }

	function knowhowi(){
		$i = $this->kh_col1;
		if($i==0) $letra = 'L-'; if($i==1) $letra = 'L='; if($i==2) $letra = 'L+';
		if($i==3) $letra = 'A-'; if($i==4) $letra = 'A='; if($i==5) $letra = 'A+';
		if($i==6) $letra = 'B-'; if($i==7) $letra = 'B='; if($i==8) $letra = 'B+';
		if($i==9) $letra = 'C-'; if($i==10) $letra = 'C='; if($i==11) $letra = 'C+';
		if($i==12) $letra = 'D-'; if($i==13) $letra = 'D='; if($i==14) $letra = 'D+';
		if($i==15) $letra = 'E-'; if($i==16) $letra = 'E='; if($i==17) $letra = 'E+';
		if($i==18) $letra = 'F-'; if($i==19) $letra = 'F='; if($i==20) $letra = 'F+';
		if($i==21) $letra = 'G-'; if($i==22) $letra = 'G='; if($i==23) $letra = 'G+';
		if($i==24) $letra = 'H-'; if($i==25) $letra = 'H='; if($i==26) $letra = 'H+';
		return($letra);
	}

	function knowhowj(){
		$j = $this->kh_col2;
		if($j==0) $letra2 = 'T  1'; if($j==1) $letra2 = 'T  2'; if($j==2) $letra2 = 'T  3'; 
		if($j==3) $letra2 = 'I  1'; if($j==4) $letra2 = 'I  2'; if($j==5) $letra2 = 'I  3';
		if($j==6) $letra2 = 'II  1'; if($j==7) $letra2 = 'II  2'; if($j==8) $letra2 = 'II  3'; 
		if($j==9) $letra2 = 'III  1'; if($j==10) $letra2 = 'III  2'; if($j==11) $letra2 = 'III  3'; 
		if($j==12) $letra2 = 'IV  1'; if($j==13) $letra2 = 'IV  2'; if($j==14) $letra2 = 'IV  3'; 
		if($j==15) $letra2 = 'V  1'; if($j==16) $letra2 = 'V  2'; if($j==17) $letra2 = 'V  3'; 
		return($letra2);
	}

	function problemsoli(){
		$i = $this->ps_col1;
		if($i==0) $letra = 'A-'; if($i==1) $letra = 'A+'; 
		if($i==2) $letra = 'B-'; if($i==3) $letra = 'B+'; 
		if($i==4) $letra = 'C-'; if($i==5) $letra = 'C+';
		if($i==6) $letra = 'D-'; if($i==7) $letra = 'D+'; 
		if($i==8) $letra = 'E-'; if($i==9) $letra = 'E+'; 
		if($i==10) $letra = 'F-'; if($i==11) $letra = 'F+';
		if($i==12) $letra = 'G-'; if($i==13) $letra = 'G+'; 
		if($i==14) $letra = 'H-'; if($i==15) $letra = 'H+'; 
		return($letra);
	}

	function problemsolj(){
		$j = $this->ps_col2;
		if($j==0) $letra2 = '1'; 
		if($j==1) $letra2 = '2'; 
		if($j==2) $letra2 = '3'; 
		if($j==3) $letra2 = '4'; 
		if($j==4) $letra2 = '5'; 
		return($letra2);
	}





	function accounti(){
		$i = $this->ac_col1;
		if($i==0) $letra = 'L -'; if($i==1) $letra = 'L ='; if($i==2) $letra = 'L +';
		if($i==3) $letra = 'A -'; if($i==4) $letra = 'A ='; if($i==5) $letra = 'A +';
		if($i==6) $letra = 'B -'; if($i==7) $letra = 'B ='; if($i==8) $letra = 'B +';
		if($i==9) $letra = 'C -'; if($i==10) $letra = 'C ='; if($i==11) $letra = 'C +';
		if($i==12) $letra = 'D -'; if($i==13) $letra = 'D ='; if($i==14) $letra = 'D +';
		if($i==15) $letra = 'E -'; if($i==16) $letra = 'E ='; if($i==17) $letra = 'E+';
		if($i==18) $letra = 'F -'; if($i==19) $letra = 'F ='; if($i==20) $letra = 'F +';
		if($i==21) $letra = 'G -'; if($i==22) $letra = 'G ='; if($i==23) $letra = 'G +';
		if($i==24) $letra = 'H -'; if($i==25) $letra = 'H ='; if($i==26) $letra = 'H +';
		if($i==27) $letra = 'I -'; if($i==28) $letra = 'I ='; if($i==29) $letra = 'I +';
		return($letra);
	}


	function accountj(){
		$j = $this->ac_col2;
		if($j==0) $letra2 = '0 R'; if($j==1) $letra2 = '0 C'; if($j==2) $letra2 = '0 S'; if($j==3) $letra2 = '0 P'; 
		if($j==4) $letra2 = '1 R'; if($j==5) $letra2 = '1 C'; if($j==6) $letra2 = '1 S'; if($j==7) $letra2 = '1 P'; 
		if($j==8) $letra2 = '2 R'; if($j==9) $letra2 = '2 C'; if($j==10) $letra2 = '2 S'; if($j==11) $letra2 = '2 P'; 
		if($j==12) $letra2 = '3 R'; if($j==13) $letra2 = '3 C'; if($j==14) $letra2 = '3 S'; if($j==15) $letra2 = '3 P'; 
		if($j==16) $letra2 = '4 R'; if($j==17) $letra2 = '4 C'; if($j==18) $letra2 = '4 S'; if($j==19) $letra2 = '4 P'; 
		if($j==20) $letra2 = '5 R'; if($j==21) $letra2 = '5 C'; if($j==22) $letra2 = '5 S'; if($j==23) $letra2 = '5 P';  
		return($letra2);
	}

}

