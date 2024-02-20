<?php

// **********************
// CLASS DECLARATION
// **********************

class rp_respuesta extends Model{ 
// class : begin


// **********************
// ATTRIBUTE DECLARATION
// **********************


	public $id_rp_user;   
	public $id_test;   
	public $id_pregunta;   
	public $respuesta;
	public $id_user;



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

	function getId_rp_user(){
		return $this->id_rp_user;
	}

	function getId_test(){
		return $this->id_test;
	}

	function getId_pregunta(){
		return $this->id_pregunta;
	}

	function getRespuesta(){
		return $this->respuesta;
	}

	function getId_user(){
		return $this->id_user;
	}

// **********************
// SETTER METHODS
// **********************


	function setId($val){
		$this->id =  $val;
	}

	function setId_rp_user($val){
		$this->id_rp_user =  $val;
	}

	function setId_test($val){
		$this->id_test =  $val;
	}

	function setId_pregunta($val){
		$this->id_pregunta =  $val;
	}

	function setRespuesta($val){
		$this->respuesta =  $val;
	}

	function setId_user($val){
		$this->id_user =  $val;
	}

// **********************
// SELECT METHOD / LOAD
// **********************

	function select($id){

		$sql =  "SELECT * FROM rp_respuestas WHERE id = $id;";
		$row =  $this->query_($sql,1);


		$this->id = $row['id'];

		$this->id_rp_user = $row['id_rp_user'];

		$this->id_test = $row['id_test'];

		$this->id_pregunta = $row['id_pregunta'];

		$this->respuesta = $row['respuesta'];

		$this->id_user = $row['id_user'];

	}

	function countUser_x_test($id_user){
		
		$count = 0;
		$sql =  "SELECT COUNT(*) as total FROM rp_respuestas WHERE id_user = $id_user;";
		$row =  $this->query_($sql,1);

		$count = $row['total'];

		return $count;
	}

// **********************
// DELETE
// **********************

	function delete(){
		$sql = "DELETE FROM rp_respuestas WHERE id = $id;";
		$result = $this->query_($sql);

	}

// **********************
// INSERT
// **********************

	function insert(){

		$sql = "INSERT INTO rp_respuestas ( id_rp_user,id_test,id_pregunta,respuesta,id_user ) VALUES ( '$this->id_rp_user','$this->id_test','$this->id_pregunta','$this->respuesta','$this->id_user' )";
		$result = $this->query_($sql);
		$this->id = mysqli_insert_id($this->link);

	}

// **********************
// UPDATE
// **********************

	function update(){



		$sql = " UPDATE rp_respuestas SET  id_rp_user = '$this->id_rp_user',id_test = '$this->id_test',id_pregunta = '$this->id_pregunta',respuesta = '$this->respuesta' WHERE id = $id ";

		$result = $this->query_($sql);



	}


// **********************
// RESULTADOS
// **********************
	function get_top($ids,$ord,$limit=10,$return=false)	{
		$x = new Rp_tema(); 
		$tema_arr=$x->select_all();
		
		$y=new rp_pregunta();
		$array=$porcentaje=array();

		if (is_array($tema_arr)) {
			foreach ($tema_arr as $key => $value) {
				$preg = $y->select_x_tema_($value->id, $ids);
				foreach ($preg as $key_ => $value_) {
					array_push($array, $value_);
					array_push($porcentaje, $value_['porcentaje']);
				}
			}
		}
		
		if ($ord) {
			array_multisort($porcentaje, SORT_DESC, $array);		
		}else{
			array_multisort($porcentaje, SORT_ASC, $array);
		}
		if($return){
			$array2=$array;
			$final = sizeof($array);
			$offset = $final-$limit;
			$fin[0] = array_splice($array, 0, $limit);
			$fin[1] = array_splice($array2, $offset, $final);
			return $fin;
		}else{
			return array_splice($array, 0, $limit);
		}
	}

	function get_avg_x_tema($ids,$preguntas){
		$sql = "SELECT AVG(respuesta) as res FROM $this->_table WHERE id_rp_user IN ($ids) AND id_pregunta IN($preguntas) AND respuesta <> 0";
		$result = $this->query_($sql,1);
		return $result['res'];
	}	

	function get_avg_x_pregunta($ids,$id){
		$sql = "SELECT AVG(respuesta) as res FROM $this->_table WHERE id_rp_user IN ($ids) AND id_pregunta = $id AND respuesta <> 0";
		$result = $this->query_($sql,1);
		return $result['res'];
	}	


	function get_res_x_pregunta($ids,$id){
		$sql = "SELECT respuesta as res FROM $this->_table WHERE id_rp_user IN ($ids) AND id_pregunta = $id AND respuesta <> 0";
		// echo $sql;	
		$result = $this->query_($sql);
		$res=array();

		if (is_array($result)) {
			foreach ($result as $key => $value) {
				array_push($res, $value['res']);
			}
		}

		return $res;
	}	

	function get_color($prom){
		if ($prom < 65){
			$color="#00FF00";
		}elseif (($prom >= 65)&&($prom < 75)) {
			$color="#FFFF00";
		}elseif (($prom >= 75)&&($prom < 85)) {
			$color="#FFA500";
		}elseif ($prom >= 85) {
			$color="#990000; color: #f8f8f8;";
		}
		return $color; 
	} 

	function get_percent_($ids,$preguntas){
		$per = array();
		$result = $this->query_("SELECT count(respuesta) as res FROM $this->_table WHERE id_rp_user IN ($ids) AND id_pregunta IN($preguntas) AND respuesta < 1.65 AND respuesta <> 0;",1);
		$x = $result['res'];
		$result = $this->query_("SELECT count(respuesta) as res FROM $this->_table WHERE id_rp_user IN ($ids) AND id_pregunta IN($preguntas) AND (respuesta  BETWEEN 1.65 AND 3.33) AND respuesta <> 0;",1);
		$y = $result['res'];
		$result = $this->query_("SELECT count(respuesta) as res FROM $this->_table WHERE id_rp_user IN ($ids) AND id_pregunta IN($preguntas) AND respuesta > 3.33 AND respuesta <> 0;",1);
		$z = $result['res'];
		$result = $this->query_("SELECT count(respuesta) as res FROM $this->_table WHERE id_rp_user IN ($ids) AND id_pregunta IN($preguntas) AND respuesta <> 0;",1);
		$total = $result['res'];
		$per[0] = round((($x*100)/$total),2);
		$per[1] = round((($y*100)/$total),2);
		$per[2] = round((($z*100)/$total),2);
		return $per;
	}

	function get_percent($ids,$preguntas){
		$p_arr = explode(",", $preguntas);
		$rp = new rp_pregunta();
		$total =0;
		foreach ($p_arr as $key => $value) {
			$rp->select($value);
			$res_arr = $rp->getMaxval();
			$res['min'] = $res_arr[0];
			$max = $res_arr[1];
			$count_res = $this->count($ids,$value);
			if($rp->inverso){
				$avg = $this->get_res_x_pregunta($ids,$value);
				foreach ($avg as $key_ => $value_) {
					$avg[$key_] = ($max+1)-$value_;
				}
				$avg = @(array_sum($avg) / count($avg));
			}else{
				$avg = $this->get_avg_x_pregunta($ids,$value);
			}		
			$total += $avg * 100 / $max ;
		}
		return round($total/sizeof($p_arr),2);
	}

	function get_percent_x_pregunta($ids,$rp){
		$res_arr = $rp->getMaxval();
		$count_res = $this->count($ids,$rp->id);
		$max = $res_arr[1];
		if($rp->inverso){
			$avg = $this->get_res_x_pregunta($ids,$rp->id);
			foreach ($avg as $key => $value) {
				$avg[$key] = ($max+1)-$value;
			}
			$avg = @(array_sum($avg) / count($avg));
		}else{
			$avg = $this->get_avg_x_pregunta($ids,$rp->id);
		}		
		$total = $avg * 100 / $max ;
		return round($total,2);
	}

	function get_percent_x_pregunta_($ids,$preguntas){
		$per = array();
		$result = $this->query_("SELECT count(respuesta) as res FROM $this->_table WHERE id_rp_user IN ($ids) AND id_pregunta = $preguntas AND respuesta < 1.65 AND respuesta <> 0;",1);
		$x = $result['res'];
		$result = $this->query_("SELECT count(respuesta) as res FROM $this->_table WHERE id_rp_user IN ($ids) AND id_pregunta = $preguntas AND (respuesta  BETWEEN 1.65 AND 3.33) AND respuesta <> 0;",1);
		$y = $result['res'];
		$result = $this->query_("SELECT count(respuesta) as res FROM $this->_table WHERE id_rp_user IN ($ids) AND id_pregunta = $preguntas AND respuesta > 3.33 AND respuesta <> 0;",1);
		$z = $result['res'];
		$result = $this->query_("SELECT count(respuesta) as res FROM $this->_table WHERE id_rp_user IN ($ids) AND id_pregunta = $preguntas AND respuesta <> 0;",1);
		$total = $result['res'];
		$per[0] = round((($x*100)/$total),2);
		$per[1] = round((($y*100)/$total),2);
		$per[2] = round((($z*100)/$total),2);
		return $per;
	}







	function count_respuesta($ids,$id,$res){
		$result = $this->query_("SELECT count(respuesta) as res FROM $this->_table WHERE id_rp_user IN ($ids) AND id_pregunta = $id AND respuesta = $res;",1);
		return $result['res'];
	}


	function count($ids,$id){
		// echo "SELECT count(respuesta) as res FROM $this->_table WHERE id_rp_user IN ($ids) AND id_pregunta = $id AND respuesta <> 0;";
		$result = $this->query_("SELECT count(respuesta) as res FROM $this->_table WHERE id_rp_user IN ($ids) AND id_pregunta = $id AND respuesta <> 0;",1);
		return $result['res'];
	}








}

?>