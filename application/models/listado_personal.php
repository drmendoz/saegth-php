

<?php

// **********************
// CLASS DECLARATION
// **********************

class Listado_personal extends Model 
{ // class : begin


// **********************
// ATTRIBUTE DECLARATION
// **********************

public $id;   // (normal Attribute)
public $nombre;   // (normal Attribute)
public $empresa;   // (normal Attribute)
public $sexo;   // (normal Attribute)
public $fecha de nacimiento;   // (normal Attribute)
public $fecha de ingreso;   // (normal Attribute)
public $area;   // (normal Attribute)
public $localidad;   // (normal Attribute)
public $cargo;   // (normal Attribute)
public $superior;   // (normal Attribute)
public $niveles organizacionales;   // (normal Attribute)
public $contrato;   // (normal Attribute)
public $condicionadores;   // (normal Attribute)
public $estado civil;   // (normal Attribute)
public $compass_360;   // (normal Attribute)
public $scorer;   // (normal Attribute)
public $matriz;   // (normal Attribute)


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


function getid()
{
return $this->id;
}

function getnombre()
{
return $this->nombre;
}

function getempresa()
{
return $this->empresa;
}

function getsexo()
{
return $this->sexo;
}

function getfecha de nacimiento()
{
return $this->fecha de nacimiento;
}

function getfecha de ingreso()
{
return $this->fecha de ingreso;
}

function getarea()
{
return $this->area;
}

function getlocalidad()
{
return $this->localidad;
}

function getcargo()
{
return $this->cargo;
}

function getsuperior()
{
return $this->superior;
}

function getniveles organizacionales()
{
return $this->niveles organizacionales;
}

function getcontrato()
{
return $this->contrato;
}

function getcondicionadores()
{
return $this->condicionadores;
}

function getestado civil()
{
return $this->estado civil;
}

function getcompass_360()
{
return $this->compass_360;
}

function getscorer()
{
return $this->scorer;
}

function getmatriz()
{
return $this->matriz;
}

// **********************
// SETTER METHODS
// **********************


function setid($val)
{
$this->id =  $val;
}

function setnombre($val)
{
$this->nombre =  $val;
}

function setempresa($val)
{
$this->empresa =  $val;
}

function setsexo($val)
{
$this->sexo =  $val;
}

function setfecha de nacimiento($val)
{
$this->fecha de nacimiento =  $val;
}

function setfecha de ingreso($val)
{
$this->fecha de ingreso =  $val;
}

function setarea($val)
{
$this->area =  $val;
}

function setlocalidad($val)
{
$this->localidad =  $val;
}

function setcargo($val)
{
$this->cargo =  $val;
}

function setsuperior($val)
{
$this->superior =  $val;
}

function setniveles organizacionales($val)
{
$this->niveles organizacionales =  $val;
}

function setcontrato($val)
{
$this->contrato =  $val;
}

function setcondicionadores($val)
{
$this->condicionadores =  $val;
}

function setestado civil($val)
{
$this->estado civil =  $val;
}

function setcompass_360($val)
{
$this->compass_360 =  $val;
}

function setscorer($val)
{
$this->scorer =  $val;
}

function setmatriz($val)
{
$this->matriz =  $val;
}

// **********************
// SELECT METHOD / LOAD
// **********************

function select($id)
{

$sql =  "SELECT * FROM listado_personal WHERE  = $id;";
$result =  $this->database->query($sql);
$result = $this->database->result;
$row = mysql_fetch_object($result);


$this->id = $row->id;

$this->nombre = $row->nombre;

$this->empresa = $row->empresa;

$this->sexo = $row->sexo;

$this->fecha de nacimiento = $row->fecha de nacimiento;

$this->fecha de ingreso = $row->fecha de ingreso;

$this->area = $row->area;

$this->localidad = $row->localidad;

$this->cargo = $row->cargo;

$this->superior = $row->superior;

$this->niveles organizacionales = $row->niveles organizacionales;

$this->contrato = $row->contrato;

$this->condicionadores = $row->condicionadores;

$this->estado civil = $row->estado civil;

$this->compass_360 = $row->compass_360;

$this->scorer = $row->scorer;

$this->matriz = $row->matriz;

}

// **********************
// DELETE
// **********************

function delete($id)
{
$sql = "DELETE FROM listado_personal WHERE  = $id;";
$result = $this->database->query($sql);

}

// **********************
// INSERT
// **********************

function insert()
{
$this-> = ""; // clear key for autoincrement

$sql = "INSERT INTO listado_personal ( id,nombre,empresa,sexo,fecha de nacimiento,fecha de ingreso,area,localidad,cargo,superior,niveles organizacionales,contrato,condicionadores,estado civil,compass_360,scorer,matriz ) VALUES ( '$this->id','$this->nombre','$this->empresa','$this->sexo','$this->fecha de nacimiento','$this->fecha de ingreso','$this->area','$this->localidad','$this->cargo','$this->superior','$this->niveles organizacionales','$this->contrato','$this->condicionadores','$this->estado civil','$this->compass_360','$this->scorer','$this->matriz' )";
$result = $this->database->query($sql);
$this-> = mysql_insert_id($this->database->link);

}

// **********************
// UPDATE
// **********************

function update($id)
{



$sql = " UPDATE listado_personal SET  id = '$this->id',nombre = '$this->nombre',empresa = '$this->empresa',sexo = '$this->sexo',fecha de nacimiento = '$this->fecha de nacimiento',fecha de ingreso = '$this->fecha de ingreso',area = '$this->area',localidad = '$this->localidad',cargo = '$this->cargo',superior = '$this->superior',niveles organizacionales = '$this->niveles organizacionales',contrato = '$this->contrato',condicionadores = '$this->condicionadores',estado civil = '$this->estado civil',compass_360 = '$this->compass_360',scorer = '$this->scorer',matriz = '$this->matriz' WHERE  = $id ";

$result = $this->database->query($sql);



}


} // class : end

?>
 
