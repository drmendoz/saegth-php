<?php

class personal_empresa extends Model {
  public $id;
  public $id_personal;
  public $id_empresa;
  public $id_area;
  public $id_local;
  public $id_cargo;
  public $pid_cg;
  public $pid_sup;
  public $id_norg;
  public $id_tcont;
  public $id_cond;
  public $salario;
  public $not_sup;
  public $sueldo;

  public function __construct($parameters = array()) {
   parent::__construct();
   foreach($parameters as $key => $value) {
    $this->$key = $value;
  }
}

function insert(){
  if(!$this->id_cond){
    $this->id_cond = "N;";
  }
  if(!$this->pid_cg){
    $this->pid_cg = 0;
  }
    // echo 'INSERT INTO personal_empresa (id_personal,id_empresa,id_area,id_local,id_cargo,pid_cg,pid_sup,id_norg,id_tcont,id_cond,salario,not_sup,sueldo) VALUES ('.$this->id_personal.', '.$this->id_empresa.', '.$this->id_area.', '.$this->id_local.', '.$this->id_cargo.', '.var_export($this->pid_cg,true).', '.$this->pid_sup.', '.$this->id_norg.', '.$this->id_tcont.', "'.$this->id_cond.'", '.var_export($this->salario,true).', '.var_export($this->not_sup,true).', '.var_export($this->sueldo,true).')';
  $this->query('INSERT INTO personal_empresa (id_personal,id_empresa,id_area,id_local,id_cargo,pid_cg,pid_sup,id_norg,id_tcont,id_cond,salario,not_sup,sueldo) VALUES ('.$this->id_personal.', '.$this->id_empresa.', '.$this->id_area.', '.$this->id_local.', '.$this->id_cargo.', '.$this->pid_cg.', '.$this->pid_sup.', '.$this->id_norg.', '.$this->id_tcont.', "'.$this->id_cond.'", '.var_export($this->salario,true).', '.var_export($this->not_sup,true).', '.var_export($this->sueldo,true).')');
  $this->id=mysqli_insert_id($this->link);
}

function update(){
  $this->query('UPDATE `personal_empresa` SET id_area='.$this->id_area.',id_local='.$this->id_local.',id_cargo='.$this->id_cargo.',pid_cg='.$this->pid_cg.',pid_sup='.$this->pid_sup.',id_norg='.$this->id_norg.',id_tcont='.$this->id_tcont.',id_cond="'.$this->id_cond.'",salario='.$this->salario.',not_sup='.$this->not_sup.',sueldo='.$this->sueldo.' WHERE id='.$this->id.'');
}

function delete(){
  $this->query('DELETE FROM personal_empresa WHERE id_empresa='.$this->id_empresa.' AND id_personal='.$this->id.'');
}  

function select($id){

  $sql =  "SELECT * FROM personal_empresa WHERE id_personal = $id;";
  $row =  $this->query_($sql,1);
  $this->id = $row['id'];
  $this->id_personal = $row['id_personal'];
  $this->id_empresa = $row['id_empresa'];
  $this->id_area = $row['id_area'];
  $this->id_local = $row['id_local'];
  $this->id_cargo = $row['id_cargo'];
  $this->pid_cg = $row['pid_cg'];
  $this->pid_sup = $row['pid_sup'];
  $this->id_norg = $row['id_norg'];
  $this->id_tcont = $row['id_tcont'];
  $this->id_cond = $row['id_cond'];
  $this->salario = $row['salario'];
  $this->not_sup = $row['not_sup'];
  $this->sueldo = $row['sueldo'];

}

function selectAll(){
  return $this->query_('SELECT * FROM personal_empresa WHERE id_empresa='.$this->id_empresa.'');
}

function select_from_cargo($id){
  return $this->query_('SELECT id_personal FROM personal_empresa WHERE id_cargo='.$id.'');
}

function select_from_tcont($id){
  return $this->query_('SELECT id_personal FROM personal_empresa WHERE id_tcont='.$id.'');
}

function getChildren(){
  return $this->query_('SELECT * FROM personal_empresa WHERE pid_sup='.$this->id.'');
}

function get_pid_sup(){
  return $this->pid_sup;
}

function get_sub_id_level($id, $lvl){

  $sql='SELECT  CONCAT(REPEAT("- ", `level` - 1), CAST(`hi`.`id_personal` AS CHAR)) AS id_personal, 
  `hi`.`id_personal` AS `id`, 
  `p`.`nombre_p` as `nombre`,
  `level`
  FROM    (
  SELECT  get_sub(`id_personal`, @maxlevel) AS `id_personal`,
  CAST(@`level` AS SIGNED) AS `level`
  FROM    (
  SELECT  @`start_with` := '.$id.',
  @`id_personal` := @`start_with`,
  @`level` := 0,
  @`maxlevel` := '.var_export($lvl,true).'
  ) `vars`, `personal_empresa`
  WHERE @`id_personal` IS NOT NULL
  ) `ho`
  JOIN `personal_empresa` `hi`
  ON `hi`.`id_personal` = `ho`.`id_personal`
  JOIN `personal` `p`
  ON `p`.`id` = `hi`.`id_personal`';
  $res = $this->query_($sql);
  return $res;
}

function get_sub_id_level_op($id, $lvl,$aprovado){
  $sql='SELECT
  *
  FROM
  (
  SELECT
  p.nombre_p AS nombre,
  id_evaluado AS id,
  pe.pid_sup AS pid,
  mr.id_empresa,
  MAX(aprovado) AS aprovado
  FROM
  multifuente_relacion AS mr
  INNER JOIN personal AS p ON id_evaluado = p.id
  INNER JOIN personal_empresa AS pe ON pe.id_personal = p.id
  WHERE
  p.id_empresa = '.$_SESSION['Empresa']['id'].'
  GROUP BY
  id_evaluado
  ) q1
  JOIN (
  SELECT
  `hi`.`id_personal` AS `id`,
  `level`
  FROM
  (
  SELECT
  get_sub (`id_personal`, @maxlevel) AS `id_personal`,
  CAST(@`level` AS SIGNED) AS `level`
  FROM
  (
  SELECT
  @`start_with` := '.$id.',
  @`id_personal` := @`start_with`,
  @`level` := 0,
  @`maxlevel` := '.var_export($lvl,true).'
  ) `vars`,
  `personal_empresa`
  WHERE
  @`id_personal` IS NOT NULL
  ) `ho`
  JOIN `personal_empresa` `hi` ON `hi`.`id_personal` = `ho`.`id_personal`
  ) q2 ON q1.id = q2.id
  WHERE
  q1.aprovado = '.$aprovado.'';
  // echo $sql;
  $res = $this->query_($sql);
  return $res;
}

function get_sub_id_level_op_($id, $lvl,$aprovado){
  $sql='SELECT DISTINCT
  *
  FROM
  (
  SELECT
  p.nombre_p AS nombre,
  id_evaluado AS id,
  pe.pid_sup AS pid,
  mr.id_empresa,
  MAX(aprovado) AS aprovado
  FROM
  multifuente_relacion AS mr
  INNER JOIN personal AS p ON id_evaluado = p.id
  INNER JOIN personal_empresa AS pe ON pe.id_personal = p.id
  WHERE
  p.id_empresa = '.$_SESSION['Empresa']['id'].'
  GROUP BY
  id_evaluado ';
  if($aprovado == 1)
  {
    $sql .= 'UNION ALL ';
    $sql .= 'SELECT
  p.nombre_p AS nombre,
  id_evaluado AS id,
  pe.pid_sup AS pid,
  mr.id_empresa,
  MAX(aprovado) AS aprovado
  FROM
  multifuente_relacion AS mr
  INNER JOIN personal AS p ON id_evaluado = p.id
  INNER JOIN personal_empresa AS pe ON pe.id_personal = p.id
  WHERE
  p.id_empresa = '.$_SESSION['Empresa']['id'].'
  AND mr.tipo_ingreso = "E" 
  GROUP BY
  mr.id_evaluado, mr.id_personal ';
  }
  $sql .='
  ) q1
  JOIN (
  SELECT
  `hi`.`id_personal` AS `id`,
  `level`
  FROM
  (
  SELECT
  get_sub (`id_personal`, @maxlevel) AS `id_personal`,
  CAST(@`level` AS SIGNED) AS `level`
  FROM
  (
  SELECT
  @`start_with` := '.$id.',
  @`id_personal` := @`start_with`,
  @`level` := 0,
  @`maxlevel` := '.var_export($lvl,true).'
  ) `vars`,
  `personal_empresa`
  WHERE
  @`id_personal` IS NOT NULL
  ) `ho`
  JOIN `personal_empresa` `hi` ON `hi`.`id_personal` = `ho`.`id_personal`
  ) q2 ON q1.id = q2.id
  WHERE
  q1.aprovado = '.$aprovado.'';
  // echo $sql;
  $res = $this->query_($sql);
  return $res;
}

function get_sub_id_level_op__($id, $lvl,$aprovado){
  $sql='SELECT
  *
  FROM
  (
  SELECT
  p.nombre_p AS nombre,
  id_evaluado AS id,
  pe.pid_sup AS pid,
  mr.id_empresa,
  MAX(aprovado) AS aprovado
  FROM
  multifuente_relacion AS mr
  INNER JOIN personal AS p ON id_evaluado = p.id
  INNER JOIN personal_empresa AS pe ON pe.id_personal = p.id
  WHERE
  p.id_empresa = '.$_SESSION['Empresa']['id'].'
  GROUP BY mr.id_evaluado, mr.aprovado 
  ) q1
  JOIN (
  SELECT
  `hi`.`id_personal` AS `id`,
  `level`
  FROM
  (
  SELECT
  get_sub (`id_personal`, @maxlevel) AS `id_personal`,
  CAST(@`level` AS SIGNED) AS `level`
  FROM
  (
  SELECT
  @`start_with` := '.$id.',
  @`id_personal` := @`start_with`,
  @`level` := 0,
  @`maxlevel` := '.var_export($lvl,true).'
  ) `vars`,
  `personal_empresa`
  WHERE
  @`id_personal` IS NOT NULL
  ) `ho`
  JOIN `personal_empresa` `hi` ON `hi`.`id_personal` = `ho`.`id_personal`
  ) q2 ON q1.id = q2.id
  WHERE
  q1.aprovado = '.$aprovado.'';
  // echo $sql;
  $res = $this->query_($sql);
  return $res;
}

function count_sub_id_level_op($id, $lvl,$aprovado){
  $sql='SELECT
  count(*) as count
  FROM
  (
  SELECT
  p.nombre_p AS nombre,
  id_evaluado AS id,
  pe.pid_sup AS pid,
  mr.id_empresa,
  MAX(aprovado) AS aprovado
  FROM
  multifuente_relacion AS mr
  INNER JOIN personal AS p ON id_evaluado = p.id
  INNER JOIN personal_empresa AS pe ON pe.id_personal = p.id
  WHERE
  p.id_empresa = '.$_SESSION['Empresa']['id'].'
  GROUP BY
  id_evaluado
  ) q1
  JOIN (
  SELECT
  `hi`.`id_personal` AS `id`,
  `level`
  FROM
  (
  SELECT
  get_sub (`id_personal`, @maxlevel) AS `id_personal`,
  CAST(@`level` AS SIGNED) AS `level`
  FROM
  (
  SELECT
  @`start_with` := '.$id.',
  @`id_personal` := @`start_with`,
  @`level` := 0,
  @`maxlevel` := '.var_export($lvl,true).'
  ) `vars`,
  `personal_empresa`
  WHERE
  @`id_personal` IS NOT NULL
  ) `ho`
  JOIN `personal_empresa` `hi` ON `hi`.`id_personal` = `ho`.`id_personal`
  ) q2 ON q1.id = q2.id
  WHERE
  q1.aprovado = '.$aprovado.'';
  // echo $sql;
  $res = $this->query_($sql,1);
  return $res['count'];
}

function count_sub_id_level_op_($id, $lvl,$aprovado){
  $sql='SELECT count(*) as count
  FROM
  (
  SELECT DISTINCT
  p.nombre_p AS nombre,
  id_evaluado AS id,
  pe.pid_sup AS pid,
  mr.id_empresa,
  MAX(aprovado) AS aprovado
  FROM
  multifuente_relacion AS mr
  INNER JOIN personal AS p ON id_evaluado = p.id
  INNER JOIN personal_empresa AS pe ON pe.id_personal = p.id
  WHERE
  p.id_empresa = '.$_SESSION['Empresa']['id'].'
  GROUP BY
  id_evaluado ';
  if($aprovado == 1)
  {
    $sql .= 'UNION ALL ';
    $sql .= 'SELECT DISTINCT
  p.nombre_p AS nombre,
  id_evaluado AS id,
  pe.pid_sup AS pid,
  mr.id_empresa,
  MAX(aprovado) AS aprovado
  FROM
  multifuente_relacion AS mr
  INNER JOIN personal AS p ON id_evaluado = p.id
  INNER JOIN personal_empresa AS pe ON pe.id_personal = p.id
  WHERE
  p.id_empresa = '.$_SESSION['Empresa']['id'].'
  AND mr.tipo_ingreso = "E" 
  GROUP BY
  mr.id_evaluado, mr.id_personal ';
  }
  $sql .='
  ) q1
  JOIN (
  SELECT
  `hi`.`id_personal` AS `id`,
  `level`
  FROM
  (
  SELECT
  get_sub (`id_personal`, @maxlevel) AS `id_personal`,
  CAST(@`level` AS SIGNED) AS `level`
  FROM
  (
  SELECT
  @`start_with` := '.$id.',
  @`id_personal` := @`start_with`,
  @`level` := 0,
  @`maxlevel` := '.var_export($lvl,true).'
  ) `vars`,
  `personal_empresa`
  WHERE
  @`id_personal` IS NOT NULL
  ) `ho`
  JOIN `personal_empresa` `hi` ON `hi`.`id_personal` = `ho`.`id_personal`
  ) q2 ON q1.id = q2.id
  WHERE
  q1.aprovado = '.$aprovado.'';
  // echo $sql;
  $res = $this->query_($sql,1);
  return $res['count'];
}

function count_sub_id_level_op__($id, $lvl,$aprovado){
  $sql='SELECT
  count(*) as count
  FROM
  (
  SELECT
  p.nombre_p AS nombre,
  id_evaluado AS id,
  pe.pid_sup AS pid,
  mr.id_empresa,
  MAX(aprovado) AS aprovado
  FROM
  multifuente_relacion AS mr
  INNER JOIN personal AS p ON id_evaluado = p.id
  INNER JOIN personal_empresa AS pe ON pe.id_personal = p.id
  WHERE
  p.id_empresa = '.$_SESSION['Empresa']['id'].'
  GROUP BY mr.id_evaluado, mr.aprovado 
  ) q1
  JOIN (
  SELECT
  `hi`.`id_personal` AS `id`,
  `level`
  FROM
  (
  SELECT
  get_sub (`id_personal`, @maxlevel) AS `id_personal`,
  CAST(@`level` AS SIGNED) AS `level`
  FROM
  (
  SELECT
  @`start_with` := '.$id.',
  @`id_personal` := @`start_with`,
  @`level` := 0,
  @`maxlevel` := '.var_export($lvl,true).'
  ) `vars`,
  `personal_empresa`
  WHERE
  @`id_personal` IS NOT NULL
  ) `ho`
  JOIN `personal_empresa` `hi` ON `hi`.`id_personal` = `ho`.`id_personal`
  ) q2 ON q1.id = q2.id
  WHERE
  q1.aprovado = '.$aprovado.'';
  // echo $sql;
  $res = $this->query_($sql,1);
  return $res['count'];
}

public static function get_superior($id){
  $obj = new Personal_empresa();
  return $obj->query_('SELECT * FROM `personal_empresa` WHERE `id_personal`='. $id .'');
}

public static function get_pares($pid,$id){
  $obj = new Personal_empresa();
  return $obj->query_('SELECT * FROM `personal_empresa` WHERE `pid_sup`='. $pid .' AND NOT (`id_personal`='.$id.')');
}

public static function get_subalternos($id){
  $obj = new Personal_empresa();
  return $obj->query_('SELECT * FROM `personal_empresa` WHERE `pid_sup`='. $id .'');
}

function getById(){
  $res =$this->query_('SELECT * FROM personal_empresa WHERE id_personal='.$this->id_personal.'',1);
  return new self($res);
}

public static function withID($id) {
  $tmp = new self(array('id_personal' => $id));  
  return $tmp->getById();
}

}


