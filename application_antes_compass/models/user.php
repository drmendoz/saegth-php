<?php

class User extends Model {

  public $id;
  public $user_name;
  public $password;
  public $id_empresa;
  public $id_personal;
  public $user_rol;
  public $token;

  public function __construct($parameters = array()) {
    parent::__construct();
    foreach($parameters as $key => $value) {
      $this->$key = $value;
    }
  }

  function insert(){
    $this->query_('INSERT INTO `users` (`user_name`,`password`,`id_empresa`,`id_personal`,`user_rol`,`token`) VALUES ("'.$this->user_name.'","'.$this->password.'",'.$this->id_empresa.','.var_export($this->id_personal,true).','.$this->user_rol.','.var_export($this->token,true).')');
  }

  function verificarUsername($user_name, $password){
    $sql = ' SELECT COUNT(*) as total FROM `users` WHERE user_name = \''. $user_name .'\' AND password = \''. Util::passHasher($password,6) .'\' ';
    $row = $this->query_($sql,1);
    return $row['total'];
  }


  function select($id){
    $row = $this->query_('SELECT * FROM `users` WHERE id_personal='.$id.'',1);
    $this->id = $row['id'];
    $this->user_name = $row['user_name'];
    $this->password = $row['password'];
    $this->id_empresa = $row['id_empresa'];
    $this->id_personal = $row['id_personal'];
    $this->user_rol = $row['user_rol'];
    $this->token = $row['token'];
  }

  public function getResults($x){
    static $y = 1;
    $table = '<table class="col-xs-12" cellpadding="1"><tr align="center">
    <td>P</td>
    <td>1</td>
    <td>2</td>
    <td>3</td>
    <td>4</td>
    <td>5</td>
    <td>M</td>
  </tr>
  <tr align="center">
    <td><input type="radio" required="required" name="'.$x.'_'.$y.'" value="P" /></td>
    <td><input type="radio" required="required" name="'.$x.'_'.$y.'" value="1" /></td>
    <td><input type="radio" required="required" name="'.$x.'_'.$y.'" value="2" /></td>
    <td><input type="radio" required="required" name="'.$x.'_'.$y.'" value="3" /></td>
    <td><input type="radio" required="required" name="'.$x.'_'.$y.'" value="4" /></td>
    <td><input type="radio" required="required" name="'.$x.'_'.$y.'" value="5" /></td>
    <td><input type="radio" required="required" name="'.$x.'_'.$y.'" value="M" /></td>
  </tr></table>';
  echo $table;
  if ($y == 4){
    $y=1;
  }else{
    $y++;
  }
}

public function getResultMulti($x){
  static $y = 1;
  $table = '<table class="col-xs-12" cellpadding="1"><tr align="center">
  <td>1</td>
  <td>2</td>
  <td>3</td>
  <td>4</td>
  <td>5</td>
  <td>NC</td>
</tr>
<tr align="center">
  <td><input type="radio" name="'.$x.'_multi" value="1" /></td>
  <td><input type="radio" name="'.$x.'_multi" value="2" /></td>
  <td><input type="radio" name="'.$x.'_multi" value="3" /></td>
  <td><input type="radio" name="'.$x.'_multi" value="4" /></td>
  <td><input type="radio" name="'.$x.'_multi" value="5" /></td>
  <td><input type="radio" name="'.$x.'_multi" value="NC" /></td>
</tr></table>';
echo $table;
if ($y == 6){
  $y=1;
}else{
  $y++;
}
}

public function getDemo($x){
  switch ($x) {
   case 1:
   $chk1="checked='checked'";
   break;

   case 2:
   $chk2="checked='checked'";
   break;

   case 3:
   $chk3="checked='checked'";
   break;

   case 4:
   $chk4="checked='checked'";
   break;

   case 5:
   $chk5="checked='checked'";
   break;

   case 6:
   $chk6="checked='checked'";
   break;

   case 7:
   $chk7="checked='checked'";
   break;
 }
 $table = '<table class="col-xs-12" border="1" cellpadding="1"><tr align="center">
 <td>P</td>
 <td>1</td>
 <td>2</td>
 <td>3</td>
 <td>4</td>
 <td>5</td>
 <td>M</td>
</tr>
<tr align="center">
  <td><input disabled="disabled" name="demo'.$x .'" type="radio" value="P" ';
    if (isset($chk1)){
     $table .= $chk1;
   } 
   $table .= ' /></td>
   <td><input disabled="disabled" name="demo'.$x .'" type="radio" value="1" ';

    if (isset($chk2)){
     $table .= $chk2;
   } 
   $table .= ' /></td>
   <td><input disabled="disabled" name="demo'.$x .'" type="radio" value="2" ';

    if (isset($chk3)){
     $table .= $chk3;
   } 
   $table .= '/></td>
   <td><input disabled="disabled" name="demo'.$x .'" type="radio" value="3"';

    if (isset($chk4)){
     $table .= $chk4;
   } 
   $table .= ' /></td>
   <td><input disabled="disabled" name="demo'.$x .'" type="radio" value="4" ';

    if (isset($chk5)){
     $table .= $chk5;
   } 
   $table .= '/></td>
   <td><input disabled="disabled" name="demo'.$x .'" type="radio" value="5" ';

    if (isset($chk6)){
     $table .= $chk6;
   } 
   $table .= '/></td>
   <td><input disabled="disabled" name="demo'.$x .'" type="radio" value="M" ';

    if (isset($chk7)){
     $table .= $chk7;
   } 
   $table .= '/></td>
 </tr></table>';
 echo $table;
}

}

?>