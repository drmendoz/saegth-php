<?php

// **********************
// CLASS DECLARATION
// **********************

class Empresa_area extends Model {
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
  return $this->htmlprnt_win($this->nombre);
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


function insert(){
  $this->query('INSERT INTO empresa_area (id_empresa,nombre,nivel,id_superior) VALUES ('.$this->id_empresa.',"'.$this->nombre.'",'.$this->nivel.','.var_export($this->id_superior, true).')');
  $this->id=mysqli_insert_id($this->link);
}

function update(){
  $this->query('UPDATE `empresa_area` SET `nombre`="'.$this->nombre.'" WHERE id='.$this->id.'');
}

function clear_db(){
  $this->query('DELETE FROM empresa_area WHERE id_empresa='.$this->id_empresa.' AND id_superior='.$this->id_superior.'');
}

function delete(){
  $this->query('DELETE FROM empresa_area WHERE id_empresa='.$this->id_empresa.' AND id_superior='.$this->id.'');
  $this->query('DELETE FROM empresa_area WHERE id_empresa='.$this->id_empresa.' AND id='.$this->id.'');
}

function selectAll(){
  return $this->query_('SELECT * FROM empresa_area WHERE id_empresa='.$this->id_empresa.'');
}

function getChildren(){
  return $this->query_('SELECT * FROM empresa_area WHERE id_superior='.$this->id.'');
}

// **********************
// SELECT METHOD / LOAD
// **********************

function select($id){

  $sql =  "SELECT * FROM empresa_area WHERE id = $id;";
  $row =  $this->query_($sql,1);

  $this->id = $row['id'];

  $this->id_empresa = $row['id_empresa'];

  $this->nivel = $row['nivel'];

  $this->nombre = $row['nombre'];

  $this->id_superior = $row['id_superior'];

}

function select_all($id){
  return $this->query_('SELECT id,nombre FROM empresa_area WHERE `id_empresa`='. $id .'');
}

function select_all_nivel($id,$niv){
  return $this->query_('SELECT id,nombre,nivel FROM empresa_area WHERE `id_empresa`='. $id .' AND `nivel`='.$niv.'');
}

function select_nivel($id,$niv){
  return $this->query('SELECT * FROM empresa_area WHERE `id_empresa`='. $id .' AND `nivel`='.$niv.'');
}

function select_all_hijos($id,$pid){
  return $this->query_('SELECT id,nombre,nivel FROM empresa_area WHERE `id_empresa`='. $id .' AND `id_superior`='.$pid.'');
}

function select_all_parents($id,$type,$sep=";"){
  $res = $this->query_("SELECT T2.nombre
    FROM (
    SELECT
    @r AS _id,
    (SELECT @r := id_superior FROM empresa_area WHERE id = _id) AS id_superior,
    @l := @l + 1 AS lvl
    FROM
    (SELECT @r := $id, @l := 0) vars,
    empresa_area m
    WHERE @r <> 0) T1
    JOIN empresa_area T2
    ON T1._id = T2.id
    ORDER BY T2.nivel asc;");
  $ret=array();
  foreach ($res as $key => $value) {
    array_push($ret, $this->htmlprnt($value['nombre']));
  }
  switch ($type) {
    case 'array':
    return $ret;
    break;
    case 'string':
    return implode($sep." ", $ret);
    break;

    default:
    return "";
    break;
  }
}


// **********************
// CUSTOM METHODS
// **********************

function get_indent(){
  $indent = "";
  for ($i=1; $i < $this->getNivel(); $i++) { 
    $indent .= "  -  ";
  }
  return $indent;
}

function es_padre(){
  return $this->query_('SELECT id,nombre FROM empresa_area WHERE `id_superior`='. $this->id .'');
}

function get_select_options($id,$pid=null,$sel=null){
  $ctrl = new self();
  if($pid==null){
    $ptr = $ctrl->select_all_nivel($id,1);
  }else{
    $ptr = $ctrl->select_all_hijos($id,$pid);
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
      $tmp->get_select_options($id,$tmp->getId(),$sel);
    }
  }
}

/** 20170101 CTP
 *  Seleccionar area desde promedios_bajos y otros_promedios_bajos.
*/
function get_select_options_selected($id,$filtro,$pid=null,$sel=null){
  $ctrl = new self();
  if($pid==null){
    $ptr = $ctrl->select_all_nivel($id,1);
  }else{
    $ptr = $ctrl->select_all_hijos($id,$pid);
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
      $tmp->get_select_options_selected($id,$filtro,$tmp->getId(),$sel);
    }
  }
}

//******************************************

function get_all_children($id){
  $sql = 'SELECT  hi.id AS ids
  FROM    (
  SELECT  hierarchy_connect_by_parent_eq_prior_id_with_level_and_loop(id, @maxlevel) AS id,
  CAST(@level AS SIGNED) AS lvl
  FROM    (
  SELECT  @start_with := '.$id.',
  @id := @start_with,
  @level := 0,
  @maxlevel := NULL
  ) vars, empresa_area
  WHERE   @id IS NOT NULL
  ) ho
  JOIN    empresa_area hi
  ON      hi.id = ho.id';
    // echo $sql;
  return $this->query_($sql);
}

function getADS($id){
  $sql="SELECT CONCAT_WS('***', `t3`.`nombre`, `t2`.`nombre`, `t1`.`nombre`) AS `path`
  FROM empresa_area AS t1
  LEFT JOIN empresa_area AS t2 ON t2.id = t1.id_superior
  LEFT JOIN empresa_area AS t3 ON t3.id = t2.id_superior
  LEFT JOIN empresa_area AS t4 ON t4.id = t3.id_superior
  WHERE t1.id = $id;";

  return $this->query_($sql,1);
}

function getTree($id){
  $sql="SELECT  hi.id as id, CONCAT(REPEAT('    ', lvl - 1), hi.id) AS treeitem,
hi.nombre as nombre,
CONCAT(REPEAT('- ', lvl - 1), hi.nombre) as nombre_,
        hierarchy_sys_connect_by_path('/', hi.id) AS path,
        id_superior, lvl,
        CASE
            WHEN lvl >= @maxlevel THEN 1
            ELSE COALESCE(
            (
            SELECT  0
            FROM    empresa_area hl
            WHERE   hl.id_superior = ho.id
                    AND hl.id <> @start_with
            LIMIT 1
            ), 1)
        END AS is_leaf
FROM    (
        SELECT  hierarchy_connect_by_parent_eq_prior_id_with_level_and_loop(id, @maxlevel) AS id,
                CAST(@level AS SIGNED) AS lvl
        FROM    (
                SELECT  @start_with := $id,
                        @id := @start_with,
                        @level := 0,
                        @maxlevel := NULL
                ) vars, empresa_area
        WHERE   @id IS NOT NULL
        ) ho
JOIN    empresa_area hi
ON      hi.id = ho.id";
  return $this->query_($sql);
}

}