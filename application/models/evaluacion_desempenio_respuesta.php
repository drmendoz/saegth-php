<?php
	// **********************
	// CLASS DECLARATION
	// **********************

	class Evaluacion_desempenio_respuestas extends Model{ 


	// **********************
	// ATTRIBUTE DECLARATION
	// **********************


		public $id;   
		public $id_def_user;   
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

		function getId_def_user(){
			return $this->id_def_user;
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

		function setId_def_user($val){
			$this->id_def_user =  $val;
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

			$sql =  "SELECT * FROM evaluacion_desempenio_respuestas WHERE id = $id;";
			$row =  $this->query_($sql,1);


			$this->id = $row['id'];

			$this->id_def_user = $row['id_def_user'];

			$this->id_test = $row['id_test'];

			$this->id_pregunta = $row['id_pregunta'];

			$this->respuesta = $row['respuesta'];

			$this->id_user = $row['id_user'];

		}
	}

	// **********************
	// DELETE
	// **********************

		function delete(){
			$sql = "DELETE FROM evaluacion_desempenio_respuestas WHERE id = $id;";
			$result = $this->query_($sql);

		}

	// **********************
	// INSERT
	// **********************

		function insert(){

			$sql = "INSERT INTO evaluacion_desempenio_respuestas ( id_suser,id_test,id_pregunta,respuesta,id_user ) VALUES ( '$this->id_suser','$this->id_test','$this->id_pregunta','$this->respuesta','$this->id_user' )";
	 		//echo "$sql<br>";
			$result = $this->query_($sql);
			$this->id = mysqli_insert_id($this->link);

		}

	// **********************
	// UPDATE
	// **********************

		function update(){



			$sql = " UPDATE evaluacion_desempenio_respuestas SET  id_suser = '$this->id_suser',id_test = '$this->id_test',id_pregunta = '$this->id_pregunta',respuesta = '$this->respuesta' WHERE id = $id ";

			$result = $this->query_($sql);



		}
	}
?>