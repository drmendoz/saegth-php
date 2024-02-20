<?php

// **********************
// CLASS DECLARATION
// **********************

class Sonda_respuesta extends Model{ 


// **********************
// ATTRIBUTE DECLARATION
// **********************


	public $id;   
	public $id_suser;   
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

	function getId_suser(){
		return $this->id_suser;
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

	function setId_suser($val){
		$this->id_suser =  $val;
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

		$sql =  "SELECT * FROM sonda_respuestas WHERE id = $id;";
		$row =  $this->query_($sql,1);


		$this->id = $row['id'];

		$this->id_suser = $row['id_suser'];

		$this->id_test = $row['id_test'];

		$this->id_pregunta = $row['id_pregunta'];

		$this->respuesta = $row['respuesta'];

		$this->id_user = $row['id_user'];

	}

	function countUser_x_test($id_user){
		
		$count = 0;
		$sql =  "SELECT COUNT(*) as total FROM sonda_respuestas WHERE id_user = $id_user;";
		$row =  $this->query_($sql,1);

		$count = $row['total'];

		return $count;
	}

// **********************
// DELETE
// **********************

	function delete(){
		$sql = "DELETE FROM sonda_respuestas WHERE id = $id;";
		$result = $this->query_($sql);

	}

// **********************
// INSERT
// **********************

	function insert(){

		$sql = "INSERT INTO sonda_respuestas ( id_suser,id_test,id_pregunta,respuesta,id_user ) VALUES ( '$this->id_suser','$this->id_test','$this->id_pregunta','$this->respuesta','$this->id_user' )";
 		//echo "$sql<br>";
		$result = $this->query_($sql);
		$this->id = mysqli_insert_id($this->link);

	}

// **********************
// UPDATE
// **********************

	function update(){



		$sql = " UPDATE sonda_respuestas SET  id_suser = '$this->id_suser',id_test = '$this->id_test',id_pregunta = '$this->id_pregunta',respuesta = '$this->respuesta' WHERE id = $id ";

		$result = $this->query_($sql);



	}

// **********************
// RESULTADOS
// **********************

	function get_avg_x_tema($ids,$preguntas){
		// Se excluye a las respuestas (NO SE)
		$sql = "SELECT AVG(respuesta) as res FROM `sonda_respuestas` WHERE id_suser IN ($ids) AND id_pregunta IN($preguntas) AND respuesta<>0 AND respuesta <> 6";
		$result = $this->query_($sql,1);
		return $result['res'];
	}	

	function get_top($ids,$limit,$order){
		$ids=$this->esc($ids);
		$limit=$this->esc($limit);
		$order=$this->esc($order);
		$sql = 'SELECT sp.id_pregunta, ssp.pregunta, AVG(sp.respuesta) as res 
		FROM `sonda_respuestas` as sp
		JOIN `sonda_preguntas` as ssp
		ON sp.id_pregunta = ssp.id
		WHERE id_suser 
		IN ('.$ids.') 
		AND respuesta<>0
		GROUP BY id_pregunta
		ORDER BY res '.$order.'
		LIMIT 1, '.$limit.';';
		$result = $this->query_($sql);
		return $result;

	}	

	function get_avg_x_pregunta($ids,$id,$min_avg = ''){
		$sql = "SELECT AVG(respuesta) as res FROM `sonda_respuestas` WHERE id_suser IN ($ids) AND id_pregunta = $id AND respuesta<>0 AND respuesta <> 6 ";
		if($min_avg != '')
			$sql .= "AND respuesta < 3";
		//echo "$sql<br>";
		$result = $this->query_($sql,1);
		return $result['res'];
	}

	function get_color($prom){
		if ($prom > 3.3333333){
			$color="#00FF00";
		}elseif (($prom >= 1.65)&&($prom <= 3.3333333)) {
			$color="#FFFF00";
		}elseif ($prom < 1.66) {
			$color="#990000;color:white";
		}
		return $color; 
	} 

	function get_percent($ids,$preguntas,$min_avg = ''){
		$per = array();

		$sql = "SELECT count(respuesta) as res FROM `sonda_respuestas` WHERE id_suser IN ($ids) AND id_pregunta IN($preguntas) AND respuesta<>0 AND respuesta < 1.65  AND respuesta <> 6 ";
		if($min_avg != '')
			$sql .= "AND respuesta < 3";
		$result = $this->query_($sql,1);
		$x = $result['res'];

		$sql = "SELECT count(respuesta) as res FROM `sonda_respuestas` WHERE id_suser IN ($ids) AND id_pregunta IN($preguntas) AND respuesta<>0 AND (respuesta  BETWEEN 1.65 AND 3.33)  AND respuesta <> 6 ";
		if($min_avg != '')
			$sql .= "AND respuesta < 3";
		$result = $this->query_($sql,1);
		$y = $result['res'];

		$sql = "SELECT count(respuesta) as res FROM `sonda_respuestas` WHERE id_suser IN ($ids) AND id_pregunta IN($preguntas) AND respuesta<>0 AND respuesta > 3.33  AND respuesta <> 6 ";
		if($min_avg != '')
			$sql .= "AND respuesta < 3";
		$result = $this->query_($sql,1);
		$z = $result['res'];

		$sql = "SELECT count(respuesta) as res FROM `sonda_respuestas` WHERE id_suser IN ($ids) AND id_pregunta IN($preguntas) AND respuesta<>0 AND respuesta = 6 ";
		if($min_avg != '')
			$sql .= "AND respuesta < 3";
		$result = $this->query_($sql,1);
		$zz = $result['res'];
		
		$sql = "SELECT count(respuesta) as res FROM `sonda_respuestas` WHERE id_suser IN ($ids) AND id_pregunta IN($preguntas) AND respuesta<>0 ";
		if($min_avg != '')
			$sql .= "AND respuesta < 3";
		$result = $this->query_($sql,1);
		$total = $result['res'];
		$per[0] = @round((($x*100)/$total),2);
		$per[1] = @round((($y*100)/$total),2);
		$per[2] = @round((($z*100)/$total),2);
		$per[3] = @round((($zz*100)/$total),2);
		return $per;
	}

	function get_percent_x_pregunta($ids,$preguntas,$min_avg = ''){
		$per = array();
		
		$sql = "SELECT count(respuesta) as res FROM `sonda_respuestas` WHERE id_suser IN ($ids) AND id_pregunta IN ($preguntas) AND respuesta<>0 AND respuesta < 1.65  AND respuesta <> 6 ";
		if($min_avg != '')
			$sql .= "AND respuesta < 3";
		$result = $this->query_($sql,1);
		$x = $result['res'];
		
		$sql = "SELECT count(respuesta) as res FROM `sonda_respuestas` WHERE id_suser IN ($ids) AND id_pregunta IN ($preguntas) AND respuesta<>0 AND (respuesta  BETWEEN 1.65 AND 3.33)  AND respuesta <> 6 ";
		if($min_avg != '')
			$sql .= "AND respuesta < 3";
		$result = $this->query_($sql,1);
		$y = $result['res'];
		
		$sql = "SELECT count(respuesta) as res FROM `sonda_respuestas` WHERE id_suser IN ($ids) AND id_pregunta IN ($preguntas) AND respuesta<>0 AND respuesta > 3.33  AND respuesta <> 6 ";
		if($min_avg != '')
			$sql .= "AND respuesta < 3";
		$result = $this->query_($sql,1);
		$z = $result['res'];

		$sql = "SELECT count(respuesta) as res FROM `sonda_respuestas` WHERE id_suser IN ($ids) AND id_pregunta IN ($preguntas) AND respuesta<>0  AND respuesta = 6 ";
		if($min_avg != '')
			$sql .= "AND respuesta < 3";
		$result = $this->query_($sql,1);
		$zz = $result['res'];

		$sql = "SELECT count(respuesta) as res FROM `sonda_respuestas` WHERE id_suser IN ($ids) AND id_pregunta IN ($preguntas) AND respuesta<>0 ";
		if($min_avg != '')
			$sql .= "AND respuesta < 3";

		$result = $this->query_($sql,1);
		$total = $result['res'];
		$per[0] = @round((($x*100)/$total),2);
		$per[1] = @round((($y*100)/$total),2);
		$per[2] = @round((($z*100)/$total),2);
		$per[3] = @round((($zz*100)/$total),2);
		return $per;
	}


} // class : end

?>