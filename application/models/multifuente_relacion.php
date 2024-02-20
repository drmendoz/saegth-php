<?php
class Multifuente_relacion extends Model {
	public $id;
  public $id_evaluado;
  public $id_personal;
  public $id_empresa;
  public $relacion;
  public $nivel;
  public $aprovado;
  public $tipo_ingreso;
  public $periodo_evaluador;

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

function getId_evaluado(){
  return $this->id_evaluado;
}

function getId_personal(){
  return $this->id_personal;
}

function getId_empresa(){
  return $this->id_empresa;
}

function getRelacion(){
  return $this->relacion;
}

function getRelacion_($rel){
  switch ($rel) {
    case 1:
    return "Superior";
    break;
    case 2:
    return "Par";
    break;
    case 3:
    return "Subalterno";
    case 4:
    return "Autoevaluación";
    break;
  }
}

function getNivel(){
  return $this->nivel;
}

function getAprovado(){
  return $this->aprovado;
}

function getTipoIngreso(){
  return $this->tipo_ingreso;
}

function getPeriodoEvaluador(){
  return $this->periodo_evaluador;
}

// **********************
// SETTER METHODS
// **********************


function setId($val){
  $this->id =  $val;
}

function setId_evaluado($val){
  $this->id_evaluado =  $val;
}

function setId_personal($val){
  $this->id_personal =  $val;
}

function setId_empresa($val){
  $this->id_empresa =  $val;
}

function setRelacion($val){
  $this->relacion =  $val;
}

function setNivel($val){
  $this->nivel =  $val;
}

function setAprovado($val){
  $this->aprovado =  $val;
}

function setTipoIngreso($val){
  $this->tipo_ingreso =  $val;
}

function setPeriodoEvaluador($val){
  $this->periodo_evaluador =  $val;
}

// **********************
// SELECT METHOD / LOAD
// **********************

function select($id){

  $sql =  "SELECT * FROM $this->_table WHERE id = $id;";
  $row =  $this->query_($sql,1);


  $this->id = $row['id'];

  $this->id_evaluado = $row['id_evaluado'];

  $this->id_personal = $row['id_personal'];

  $this->id_empresa = $row['id_empresa'];

  $this->relacion = $row['relacion'];

  $this->nivel = $row['nivel'];

  $this->aprovado = $row['aprovado'];
  
  $this->tipo_ingreso = $row['tipo_ingreso'];
  
  $this->periodo_evaluador = $row['periodo_evaluador'];
}

function select_id_eval_id_personal($id_eval,$id_personal,$periodo_evaluador){
  $sql =  "SELECT * FROM multifuente_relacion WHERE id_evaluado = $id_eval AND id_personal=$id_personal AND periodo_evaluador = ".$periodo_evaluador;
  $row =  $this->query_($sql,1);
  if($row){

    $this->id = $row['id'];

    $this->id_evaluado = $row['id_evaluado'];

    $this->id_personal = $row['id_personal'];

    $this->id_empresa = $row['id_empresa'];

    $this->relacion = $row['relacion'];

    $this->nivel = $row['nivel'];

    $this->aprovado = $row['aprovado'];
    return true;
  }else


  return false;
}



function select_all($id,$periodo_evaluador){
  return $this->query_('SELECT * FROM multifuente_relacion WHERE `id_evaluado`='. $id .' AND periodo_evaluador='.$periodo_evaluador.'');
}

function select_all__($id,$periodo_evaluador){
  return $this->query_('SELECT * FROM multifuente_relacion WHERE `id_evaluado`='. $id .' AND relacion != 3 AND periodo_evaluador='.$periodo_evaluador.'');
}

function select_all_nivel($id,$niv,$periodo_evaluador){
  return $this->query_('SELECT * FROM multifuente_relacion WHERE `id_evaluado`='. $id .' AND `nivel`='.$niv.' AND periodo_evaluador='.$periodo_evaluador.'');
}

function get_max_nivel($id){
  $respuesta =  $this->query_('SELECT MAX(nivel) as nivel FROM multifuente_relacion WHERE `id_evaluado`='. $id .'',1);
  return $respuesta['nivel'];
}

function get_min_nivel($id,$periodo_evaluador){
  $respuesta =  $this->query_('SELECT MIN(nivel) as nivel FROM multifuente_relacion WHERE `id_evaluado`='. $id .' AND periodo_evaluador='.$periodo_evaluador.'',1);
  return $respuesta['nivel'];
}

function list_progress($id){
  $sql='SELECT p.nombre_p  as nombre,
  id_evaluado as id,
  (select  nombre_p  from personal where id=pe.pid_sup) as nombre_pid,
  pe.pid_sup as pid,
  (select nombre_p  from personal where id=ppe.pid_sup) as nombre_ppid,
  ppe.pid_sup as p_pid,
  mr.id_empresa, 
  MAX(aprovado) AS aprovado 
  FROM multifuente_relacion as mr
  INNER JOIN personal as p
  ON id_evaluado = p.id
  INNER JOIN personal_empresa as pe
  ON pe.id_personal = p.id
  INNER JOIN personal_empresa as ppe
  ON ppe.id_personal = pe.pid_sup
  WHERE p.id_empresa='.$id.'
  GROUP BY id_evaluado';
    // echo $sql."<br>";
  $respuesta =  $this->query_($sql);
  echo $this->getError();
  return $respuesta;
}

function select_unresolved($id){
  $sql='SELECT
  me.id_evaluado AS id,
  p.nombre_p,
  me.cod_evaluado,
  me.cod_test,
  me.relacion,
  me.periodo_evaluador
  FROM
  multifuente_evaluadores me
  JOIN personal p ON me.id_evaluado = p.id
  WHERE
  id_personal = '.$id.'
  AND resuelto = 0
  UNION
  SELECT
  me.id_personal AS id,
  p.nombre_p,
  me.cod_evaluado,
  me.cod_test,
  me.relacion,
  me.periodo_evaluador
  FROM
  multifuente_evaluado me
  JOIN personal p ON me.id_personal = p.id
  WHERE
  id_personal = '.$id.'
  AND resuelto = 0';
  //echo $sql;
  $res =  $this->query_($sql);

  $mpe = new Multifuente_periodos_evaluador();
  foreach ($res as $key => $value) {
    $isReinicio = $mpe->last_periodoEvaluador($value['id'], $_SESSION['Empresa']['id']);
    if($value['periodo_evaluador'] != $isReinicio['id'])
    {
      unset($res[$key]);
    }
  }

  echo $this->getError();
  return $res;
}

function count_unresolved__($id){
  $res = $this->select_unresolved($id);
  $count = 0;
  $count_reinicio = 0;
  $mpe = new Multifuente_periodos_evaluador();

  foreach ($res as $key => $value) {
    $isReinicio = $mpe->last_periodoEvaluador($value['id'], $_SESSION['Empresa']['id']);
    if($value['periodo_evaluador'] != $isReinicio['id'])
    {
      $count_reinicio++;
    }
    else
    {
      $count++;
    }
  }

  if ($count_reinicio > 0){
    return $count_reinicio;
  }
  else{
    return $count;
  }
}

function count_unresolved($id){
  $sql="SELECT (
  SELECT
  count(*) AS count
  FROM
  multifuente_evaluadores me
  JOIN personal p ON me.id_evaluado = p.id
  WHERE
  id_personal = $id
  AND resuelto = 0
  )
  +
  (
  SELECT
  count(*)
  FROM
  multifuente_evaluado me
  JOIN personal p ON me.id_personal = p.id
  WHERE
  id_personal = $id
  AND resuelto = 0
  ) as count";
  $res =  $this->query_($sql,1);
  return $res['count'];
}

function count_unresolved_($id){
  $hoy = date('Y-m-d');
  $sql = "SELECT (
                  SELECT count(*) AS count
                  FROM multifuente_evaluadores me
                  JOIN personal p ON me.id_evaluado = p.id
                  WHERE id_evaluado = $id
                  AND resuelto = 0
                  AND fecha >= $hoy
                 )
        +
                 (
                  SELECT count(*)
                  FROM multifuente_evaluado me
                  JOIN personal p ON me.id_personal = p.id
                  WHERE id_personal = $id
                  AND resuelto = 0
                  AND fecha >= $hoy
                 ) as count";
  //echo $sql;
  $res =  $this->query_($sql,1);
  return $res['count'];
}

function select_sub($id){
  $sql='SELECT
  me.id_evaluado AS id,
  p.nombre_p,
  me.cod_evaluado,
  me.cod_test,
  me.relacion
  FROM
  multifuente_evaluadores me
  JOIN personal p ON me.id_evaluado = p.id
  WHERE
  id_personal = '.$id.'';
  $res =  $this->query_($sql);
  echo $this->getError();
  return $res;
}

function count_unresolvedGeneral($id)
{
  $cont = 0;
  $res = $this->select_unresolved($id);
  if($res){
    foreach ($res as $key => $value) {
      $count = $this->count_unresolved_($value['id']);
      if ($count > 0) {
        $cont++;
      }
    }
  }
  return $cont;
}

// **********************
// INSERT
// **********************

function insert(){

  $sql = "INSERT INTO multifuente_relacion ( id,id_evaluado,id_personal,id_empresa,relacion,nivel,aprovado,tipo_ingreso,periodo_evaluador ) VALUES ( '$this->id','$this->id_evaluado','$this->id_personal','$this->id_empresa','$this->relacion','$this->nivel','$this->aprovado', '$this->tipo_ingreso', '$this->periodo_evaluador' )";
  $result = $this->query_($sql);
  $this->id = mysqli_insert_id($this->link);

}

// **********************
// UPDATE
// **********************

function update(){



  $sql = " UPDATE multifuente_relacion SET  id_evaluado = '$this->id_evaluado',id_personal = '$this->id_personal',id_empresa = '$this->id_empresa',relacion = '$this->relacion',nivel = '$this->nivel',aprovado = '$this->aprovado' WHERE id = $this->id ";

  $result = $this->query_($sql);



}

// **********************
// DELETE
// **********************

function delete(){
  $sql = "DELETE FROM multifuente_relacion WHERE id = $id;";
  $result = $this->query_($sql);

}

}