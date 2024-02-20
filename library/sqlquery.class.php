<?php

class SQLQuery {
  protected $_dbHandle;
  protected $_result;

  /** Connects to database **/

  function connect($address, $account, $pwd, $name) {
    $this->_dbHandle = @mysqli_connect($address, $account, $pwd);

    if ($this->_dbHandle) {
      if (mysqli_select_db($this->_dbHandle,$name)) {
        return 1;
      }else {
        return 0;
      }
    }else {
      return 0;
    }
  }

  function getDBHandle(){
    return $this->_dbHandle;
  }

  /** Disconnects from database **/

  function disconnect() {
    if (@mysqli_close($this->_dbHandle) != 0) {
      return 1;
    }  else {
      return 0;
    }
  }

  function selectAll() {
   $query = 'select * from `'.$this->_table.'`';
   return $this->query($query);
 }

 function select($id) {
  $query = 'select * from `'.$this->_table.'` where `id` = \''.mysqli_real_escape_string($this->_dbHandle, $id).'\'';
  return $this->query($query, 1);    
}
function select_f($id,$field) {
 $query = 'select * from `'.$this->_table.'` where `'.$field.'` = \''.mysqli_real_escape_string($this->_dbHandle, $id).'\'';
 return $this->query($query, 1);    
}


/** Custom SQL Query **/

function query($query, $singleResult = 0) {
  $query = Util::db_print($query);
  $this->_result = mysqli_query($this->getDBHandle(), $query);
  if($this->_result){
    if (preg_match("/select/i",$query)) {
      $result = array();
      $table = array();
      $field = array();
      $tempResults = array();
      $numOfFields = mysqli_field_count($this->_dbHandle);
      for ($i = 0; $i < $numOfFields; ++$i) {
        array_push($table,mysqli_fetch_field_direct($this->_result, $i)->table);
        array_push($field,mysqli_fetch_field_direct($this->_result, $i)->name);
      }
      while ($row = mysqli_fetch_row($this->_result)) {
        for ($i = 0;$i < $numOfFields; ++$i) {
          $table[$i] = trim(ucfirst($table[$i]),"s");
          $tempResults[$table[$i]][$field[$i]] = $row[$i];
        }
        if ($singleResult == 1) {
                        //$this->_dbHandle, 
          mysqli_free_result($this->_result);
          return $tempResults;
        }
        array_push($result,$tempResults);
      }
      mysqli_free_result($this->_result);
      return($result);
    }   
  }
}

function query_($query, $singleResult = 0) {
  $query = Util::db_print($query);
  $this->_result = mysqli_query($this->_dbHandle, $query);
  if($this->_result){
    if (preg_match("/select/i",$query)) {
      $result = array();
      $table = array();
      $field = array();
      $tempResults = array();
      $numOfFields = mysqli_field_count($this->_dbHandle);
      for ($i = 0; $i < $numOfFields; ++$i) {
        array_push($table,mysqli_fetch_field_direct($this->_result, $i)->table);
        array_push($field,mysqli_fetch_field_direct($this->_result, $i)->name);
      }
      while ($row = mysqli_fetch_row($this->_result)) {
        for ($i = 0;$i < $numOfFields; ++$i) {
          $tempResults[$field[$i]] = $row[$i];
        }
        if ($singleResult == 1) {
          mysqli_free_result($this->_result);
          return $tempResults;
        }
        array_push($result,$tempResults);
      }
      mysqli_free_result($this->_result);
      return($result);
    } 
  }
}

/** Get number of rows **/
function getNumRows() {
  return mysqli_num_rows($this->_dbHandle, $this->_result);
}

/** Free resources allocated by a query **/

function freeResult() {
  mysqli_free_result($this->_dbHandle, $this->_result);
}

/** Get error string **/

function mres($string) {
  return mysqli_real_escape_string($this->_dbHandle,$string);
}

function escape(&$string) {
  $string = mysqli_real_escape_string($this->_dbHandle,$string);
}
function getError() {
  return mysqli_error($this->_dbHandle);
}
function getErrno() {
  return mysqli_errno($this->_dbHandle);
}
function getCustomErrmsg($errno){
  switch ($errno) {
    case 1062:
    return "Entrada duplicada";
    break;

    default:
    echo "Ocurrió un error en el último proceso";
    break;
  }
}
}
