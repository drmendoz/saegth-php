

<?php

// **********************
// CLASS DECLARATION
// **********************

class empresa_local extends Model{ 
// class : begin


// **********************
// ATTRIBUTE DECLARATION
// **********************


	public $id;   
	public $id_empresa;   
	public $nivel;   
	public $nombre;   
	public $id_superior;   



// **********************
// CONSTRUCTOR METHOD
// **********************


	public function __construct($parameters = array()) {
		parent::__construct();
		foreach($parameters as $key => $value) {
			$this->$key = $value;
		}
	}


// **********************
// GETTER METHODS
// **********************


	function getId(){
		return $this->id;
	}

	function getId_empresa(){
		return $this->id_empresa;
	}

	function getNivel(){
		return $this->nivel;
	}

	function getNombre(){
		return $this->htmlprnt($this->nombre);
	}

	function getNombre_(){
		return $this->htmlprnt($this->nombre);
	}

	function getId_superior(){
		return $this->id_superior;
	}

// **********************
// SETTER METHODS
// **********************


	function setId($val){
		$this->id =  $val;
	}

	function setId_empresa($val){
		$this->id_empresa =  $val;
	}

	function setNivel($val){
		$this->nivel =  $val;
	}	

	function setNombre($val){
		$this->nombre =  $val;
	}

	function setId_superior($val){
		$this->id_superior =  $val;
	}

// **********************
// SELECT METHOD / LOAD
// **********************

	function select($id){

		$sql =  "SELECT * FROM empresa_local WHERE id = $id;";
		$row =  $this->query_($sql,1);
		$this->id = $row['id'];

		$this->id_empresa = $row['id_empresa'];

		$this->nivel = $row['nivel'];

		$this->nombre = $row['nombre'];

		$this->id_superior = $row['id_superior'];

	}

	function select_all($id){
		return $this->query_('SELECT id,nombre,nivel FROM empresa_local WHERE `id_empresa`='. $id .'');
	}

	function select_all_nivel($id,$niv){
		return $this->query_('SELECT id,nombre,nivel FROM empresa_local WHERE `id_empresa`='. $id .' AND `nivel`='.$niv.' order by nombre ASC');
	}

	function select_all_pid($id,$pid){
		return $this->query_('SELECT id,nombre,nivel FROM empresa_local WHERE `id_empresa`='. $id .' AND `id_superior`='.$pid.' order by nombre ASC');
	}

// **********************
// DELETE
// **********************

	function delete(){
		$sql = "DELETE FROM empresa_local WHERE id = $id;";
		$result = $this->query_($sql);

	}

// **********************
// INSERT
// **********************

	function insert(){

		$sql = "INSERT INTO empresa_local (id_empresa,nivel,nombre,id_superior ) VALUES ('$this->id_empresa','$this->nivel','$this->nombre','$this->id_superior' )";
		$result = $this->query_($sql);
		$this->id = mysql_insert_id($this->link);

	}

// **********************
// UPDATE
// **********************

	function update(){
		$sql = " UPDATE empresa_local SET  id = '$this->id',id_empresa = '$this->id_empresa',nivel = '$this->nivel',nombre = '$this->nombre',id_superior = '$this->id_superior' WHERE id = $id ";
		$result = $this->query_($sql);
	}

// **********************
// CUSTOM METHODS
// **********************

	function es_padre(){
		return $this->query_('SELECT id,nombre FROM empresa_local WHERE `id_superior`='. $this->id .'');
	}

	function get_select_options($id,$sel=null){
		$ctrl = new self();
		$ptr = $ctrl->select_all_nivel($id,0);
		foreach ($ptr as $key => $value) {
			$tmp = new self($value);
			$chk = $tmp->es_padre();
			if($chk){
				echo "<optgroup label=".$tmp->getNombre().">";
				foreach ($chk as $key_ => $value_) {
					$tmp_ = new self($value_);
					$chk_ = $tmp_->es_padre();
					if($sel == $tmp_->getId())
						$t = "selected";
					else
						$t = "";
					echo "<option value='".$tmp_->getId()."'  ".$t.">";
					echo $tmp_->getNombre();
					echo "</option>";
					if($chk_){
						foreach ($chk_ as $key__ => $value__) {
							$tmp__ = new self($value__);
							if($sel == $tmp__->getId())
								$t = "selected";
							else
								$t = "";
							echo "<option value='".$tmp__->getId()."'  ".$t.">";
							echo "-- ".$tmp__->getNombre();
							echo "</option>";
						}
					}
				}
				echo "</optgroup>";
			}else{
				if($sel == $tmp->getId())
					$t = "selected";
				else
					$t = "";
				echo "<option value='".$tmp->getId()."' ".$t.">";
				echo $tmp->getNombre();
				echo "</option>";
			}
		}
	}

	function get_indent(){
		$indent = "";
		echo $this->getNivel();
		for ($i=0; $i < ($this->getNivel()); $i++) { 
			$indent .= "  -  ";
		}
		return $indent;
	}

	function get_select_options_($id,$pid=null,$sel=null){
		$ctrl = new self();
		if($pid==null){
			$ptr = $ctrl->select_all_nivel($id,0);
		}else{
			$ptr = $ctrl->select_all_pid($id,$pid);
		}
		foreach ($ptr as $key => $value) {
			$tmp = new self($value);
			if($sel == $tmp->getId())
				$t = "selected";
			else
				$t = "";
			echo "<option value='".$tmp->getId()."' ".$t." >".$tmp->get_indent().$tmp->getNombre()."</option>";
			$chk = $tmp->es_padre();
			if($chk){
				$tmp->get_select_options_($id,$tmp->getId(),$sel);
			}
		}
	}

	/** 20170101 CTP
	 *	Seleccionar local desde promedios_bajos y otros_promedios_bajos.	
	*/
	function get_select_options_selected_($id,$filtro,$pid=null,$sel=null){
		$ctrl = new self();
		if($pid==null){
			$ptr = $ctrl->select_all_nivel($id,0);
		}else{
			$ptr = $ctrl->select_all_pid($id,$pid);
		}
		foreach ($ptr as $key => $value) {
			$tmp = new self($value);
			if(in_array($tmp->getId(), $filtro))
				$t = "selected='selected'";
			else
				$t = "";
			echo "<option value='".$tmp->getId()."' ".$t." >".$tmp->get_indent().$tmp->getNombre()."</option>";
			$chk = $tmp->es_padre();
			if($chk){
				$tmp->get_select_options_selected_($id,$filtro,$tmp->getId(),$sel);
			}
		}
	}

	//******************************************

	function get_all_children($id){
		/*$sql = 'SELECT  hi.id AS ids
		FROM    (
		SELECT  get_local_child(id, @maxlevel) AS id,
		CAST(@level AS SIGNED) AS lvl
		FROM    (
		SELECT  @start_with := '.$id.',
		@id := @start_with,
		@level := 0,
		@maxlevel := NULL
		) vars, empresa_local
		WHERE   @id IS NOT NULL
		) ho
		JOIN    empresa_local hi
		ON      hi.id = ho.id';*/
		$sql = 	'SELECT e.id AS ids ';
		$sql .= 'FROM empresa_local e ';
		$sql .= 'WHERE e.id = '.$id.' ';
		$sql .= 'OR e.id_superior in ';
		$sql .= '( ';
		$sql .= '	SELECT el.id ';
		$sql .= '	FROM empresa_local el ';
		$sql .= '	WHERE el.id_empresa = '.$_SESSION['Empresa']['id'];
		$sql .= '	AND ( ';
		$sql .= '			el.id = '.$id.' ';
		$sql .= '			OR ';
		$sql .= '			el.id_superior = '.$id.' ';
		$sql .= '		) ';
		$sql .= ') ';
		return $this->query_($sql);
	}

} // class : end

?>

