<?php

//require_once (ROOT . DS . 'application' . DS . 'controllers' . DS . 'multifuentecontroller.php');

class Multifuente_estatus_proceso extends Model {
    
    public $error;
    public $filtro;
    public $listado;
    public $fecha_inicio;
    public $fecha_tope;
    public $fecha_actual;
    public $dias_transcurridos;
    public $dias_restantes;
    public $dias_adicionales;
    public $cuestionarios_asignados;
    public $cuestionarios_respondidos;
    public $cuestionarios_no_respondidos;
    public $ratio_cumplimiento_fecha;
    public $ratio_cumplimiento_dia1;
    public $ratio_cumplimiento_dia2;
    public $ratio_cumplimiento_proyectado1;
    public $ratio_cumplimiento_proyectado2;
    public $ratio_cumplimiento_proyectado_actual1;

  public function __construct($parameters = array()) {
    parent::__construct();
    foreach($parameters as $key => $value) {
      $this->$key = $value;
    }
  }

  // **********************
  // GETTER METHODS
  // **********************
  function geterror(){
    return $this->error;
  }

  function getfiltro(){
    return $this->filtro;
  }

  function getlistado(){
    return $this->listado;
  }

  function getfecha_inicio(){
    return $this->fecha_inicio;
  }

  function getfecha_tope(){
    return $this->fecha_tope;
  }

  function getfecha_actual(){
    return $this->fecha_actual;
  }

  function getdias_transcurridos(){
    return $this->dias_transcurridos;
  }

  function getdias_restantes(){
    return $this->dias_restantes;
  }

  function getdias_adicionales(){
    return $this->dias_adicionales;
  }

  function getcuestionarios_asignados(){
    return $this->cuestionarios_asignados;
  }

  function getcuestionarios_respondidos(){
    return $this->cuestionarios_respondidos;
  }

  function getcuestionarios_no_respondidos(){
    return $this->cuestionarios_no_respondidos;
  }

  function getratio_cumplimiento_fecha(){
    return $this->ratio_cumplimiento_fecha;
  }

  function getratio_cumplimiento_dia1(){
    return $this->ratio_cumplimiento_dia1;
  }

  function getratio_cumplimiento_dia2(){
    return $this->ratio_cumplimiento_dia2;
  }

  function getratio_cumplimiento_proyectado1(){
    return $this->ratio_cumplimiento_proyectado1;
  }

  function getratio_cumplimiento_proyectado2(){
    return $this->ratio_cumplimiento_proyectado2;
  }

  function getratio_cumplimiento_proyectado_actual1(){
    return $this->ratio_cumplimiento_proyectado_actual1;
  }

  // **********************
  // SETTER METHODS
  // **********************
  function seterror($val){
    $this->error =  $val;
  }

  function setfiltro($val){
    $this->filtro =  $val;
  }

  function setlistado($val){
    $this->listado =  $val;
  }

  function setfecha_inicio($val){
    $this->fecha_inicio =  $val;
  }

  function setfecha_tope($val){
    $this->fecha_tope =  $val;
  }

  function setfecha_actual($val){
    $this->fecha_actual =  $val;
  }

  function setdias_transcurridos($val){
    $this->dias_transcurridos =  $val;
  }

  function setdias_restantes($val){
    $this->dias_restantes =  $val;
  }

  function setdias_adicionales($val){
    $this->dias_adicionales =  $val;
  }

  function setcuestionarios_asignados($val){
    $this->cuestionarios_asignados =  $val;
  }

  function setcuestionarios_respondidos($val){
    $this->cuestionarios_respondidos =  $val;
  }

  function setcuestionarios_no_respondidos($val){
    $this->cuestionarios_no_respondidos =  $val;
  }

  function setratio_cumplimiento_fecha($val){
    $this->ratio_cumplimiento_fecha =  $val;
  }

  function setratio_cumplimiento_dia1($val){
    $this->ratio_cumplimiento_dia1 =  $val;
  }

  function setratio_cumplimiento_dia2($val){
    $this->ratio_cumplimiento_dia2 =  $val;
  }

  function setratio_cumplimiento_proyectado1($val){
    $this->ratio_cumplimiento_proyectado1 =  $val;
  }

  function setratio_cumplimiento_proyectado2($val){
    $this->ratio_cumplimiento_proyectado2 =  $val;
  }

  function setratio_cumplimiento_proyectado_actual1($val){
    $this->ratio_cumplimiento_proyectado_actual1 =  $val;
  }

  function obtenerDatos()
  {
    $listado = array();
    $i = 0;

    $cuestionarios_asignados = 0;
    $cuestionarios_respondidos = 0;
    $cuestionarios_no_respondidos = 0;
    $ratio_cumplimiento_fecha = 0;
    $ratio_cumplimiento_dia1 = 0;
    $ratio_cumplimiento_dia2 = 0;
    $ratio_cumplimiento_proyectado1 = 0;
    $ratio_cumplimiento_proyectado2 = 0;

    //  FECHAS
    $sql = 'SELECT * FROM `multifuente_evaluado` where id_empresa = '.$_SESSION["Empresa"]["id"].' ORDER BY id DESC limit 0,1';
    $fechas = $this->query_($sql, 1);
    $this->fecha_inicio = date_format(date_create($fechas['fecha']),"d/m/Y");
    $this->fecha_tope = date_format(date_create($fechas['fecha_max']),"d/m/Y");
    $this->fecha_actual = date_format(date_create(date('d-m-Y')),"d/m/Y");

    //  DIAS
    $fecha2 = new DateTime(date_format(date_create(date('d-m-Y')),"Y-m-d"));
    $fecha1 = new DateTime(date_format(date_create($fechas['fecha']),"Y-m-d"));
    $diff = $fecha1->diff($fecha2);
    //$this->dias_transcurridos = $diff->days;
	$this->dias_transcurridos = $diff->format('%R%a');

    $fecha2 =  new DateTime(date_format(date_create($fechas['fecha_max']),"Y-m-d"));
    $fecha1 = new DateTime(date_format(date_create(date('d-m-Y')),"Y-m-d"));
    $diff = $fecha1->diff($fecha2, false);
    //$this->dias_restantes = $diff->days;
	$this->dias_restantes = $diff->format('%R%a');

    $fecha2 =  new DateTime(date_format(date_create(date('d-m-Y')),"Y-m-d"));
    $fecha1 = new DateTime(date_format(date_create($fechas['fecha_max']),"Y-m-d"));
    $diff = $fecha1->diff($fecha2);
    //$this->dias_adicionales = $diff->days;
	$this->dias_adicionales = $diff->format('%R%a');

    //  EVALUADORES
    $sql = 'select DISTINCT a.id_personal 
          from multifuente_evaluadores as a 
          inner join 
          listado_personal_op as b on b.id = a.id_personal 
          where a.id_empresa = '.$_SESSION["Empresa"]["id"].' 
                and 
                a.periodo_evaluador = '.$fechas["periodo_evaluador"].' 
          order by b.nombre asc';
    $evaluadores = $this->query_($sql);

    if (count($evaluadores) > 0) {
      foreach ($evaluadores as $key => $value) {
        $sql = 'select DISTINCT a.id_evaluado, a.resuelto 
                from multifuente_evaluadores as a 
                where a.id_empresa = '.$_SESSION["Empresa"]["id"].' 
                      and 
                      a.periodo_evaluador = '.$fechas["periodo_evaluador"].' 
                      and
                      a.id_personal = '.$value["id_personal"].';';
        $evaluado = $this->query_($sql);

        if (count($evaluado) > 0) {
          $i = 0;
          $evaluados = 0;
          $evaluados_contestados = 0;
          $porcentaje_evaluador = 0;
          $antes_listado = array();
          foreach ($evaluado as $key_eval => $value_eval) {

            $cumplimiento = 0;
            $lista_evaluadores = 0;
            $lista_evaluadores_contestados = 0;

            $sql = 'select * 
                    from multifuente_evaluadores as a 
                    where a.id_empresa = '.$_SESSION["Empresa"]["id"].' 
                          and 
                          a.id_evaluado = '.$value_eval['id_evaluado'].'
                          and
                          a.id_personal = '.$value["id_personal"].' 
                          and 
                          a.periodo_evaluador = '.$fechas["periodo_evaluador"];
            $array_evaluadores = $this->query_($sql);
            if (count($array_evaluadores) > 0) {
              foreach ($array_evaluadores as $key => $value) {
                $lista_evaluadores++;

                if ($value['resuelto'] == 1) {
                  $lista_evaluadores_contestados++;
                }
              }
            }

            $calculo = ($lista_evaluadores_contestados / $lista_evaluadores) * 100;
            $calculo = number_format($calculo, 0);

            $antes_listado[$value["id_personal"]][$i]['id_evaluado'] = $value_eval['id_evaluado'];
            $antes_listado[$value["id_personal"]][$i]['resuelto'] = $value_eval['resuelto'];
            $antes_listado[$value["id_personal"]][$i]['cumplimiento'] = ($calculo > 0) ? $calculo : 0;

            if ($value_eval["resuelto"] == 1){
              $evaluados_contestados++;
              $cuestionarios_respondidos++;
            }
            else{
              $cuestionarios_no_respondidos++;
            }

            $evaluados++;
            $cuestionarios_asignados++;
            $i++;
          }

          $porcentaje_evaluador = ($evaluados_contestados / $evaluados) * 100;
          $porcentaje_evaluador = number_format($porcentaje_evaluador, 0);
          
          foreach ($antes_listado as $key => $value) {
            $clave = $key.'-'.$porcentaje_evaluador;
            $listado[$clave] = $value;
          }
        }
      }
    }

    $this->cuestionarios_asignados = $cuestionarios_asignados;
    $this->cuestionarios_respondidos = $cuestionarios_respondidos;
    $this->cuestionarios_no_respondidos = $cuestionarios_no_respondidos;

    $ratio_cumplimiento_fecha = ($cuestionarios_no_respondidos != 0) ? $cuestionarios_respondidos / $cuestionarios_no_respondidos : 0;
    $this->ratio_cumplimiento_fecha = round($ratio_cumplimiento_fecha);

    //$ratio_cumplimiento_dia1 = ($this->dias_transcurridos != 0) ? $cuestionarios_respondidos / $this->dias_transcurridos : 0;
    $ratio_cumplimiento_dia0 = (abs($this->dias_transcurridos) + abs($this->dias_adicionales));
    $ratio_cumplimiento_dia1 = ($ratio_cumplimiento_dia0 != 0) ? $this->cuestionarios_respondidos / $ratio_cumplimiento_dia0 : 0;
    $this->ratio_cumplimiento_dia1 = round(abs($ratio_cumplimiento_dia1), 2);

    $ratio_cumplimiento_dia2 = ($cuestionarios_asignados != 0) ? abs($ratio_cumplimiento_dia1) / $cuestionarios_asignados : 0;
    $this->ratio_cumplimiento_dia2 = round($ratio_cumplimiento_dia2, 2);

    $fecha1 = new DateTime(date_format(date_create($fechas['fecha_max']),"Y-m-d"));
    $fecha2 = new DateTime(date_format(date_create($fechas['fecha']),"Y-m-d"));
    $diff = $fecha1->diff($fecha2);
    $dias_transcurridos_tope = $diff->days;

    $ratio_cumplimiento_proyectado1 = abs($this->dias_restantes) * abs($this->ratio_cumplimiento_dia1);
    $this->ratio_cumplimiento_proyectado1 = round($ratio_cumplimiento_proyectado1);

    $ratio_cumplimiento_proyectado2 = (abs($ratio_cumplimiento_proyectado1) / $cuestionarios_asignados) * 100;
    $this->ratio_cumplimiento_proyectado2 = round($ratio_cumplimiento_proyectado2, 2);

    $this->ratio_cumplimiento_proyectado_actual1 = abs($this->ratio_cumplimiento_dia1) * (abs($this->dias_transcurridos) + abs($this->dias_adicionales));

    $this->listado = $listado;
  }

  function obtenerEvaluadoresPorEvaluado($id_evaluado)
  {
    $listado = array();

    $sql = 'SELECT * FROM `multifuente_evaluado` where id_empresa = '.$_SESSION["Empresa"]["id"].' ORDER BY id DESC limit 0,1';
    $fechas = $this->query_($sql, 1);

    $cumplimiento = 0;
    $lista_evaluadores = 0;
    $lista_evaluadores_contestados = 0;
    $i = 0;

    $sql = 'select a.id_personal, b.nombre, a.resuelto, a.relacion 
            from multifuente_evaluadores as a 
            inner join
            listado_personal_op as b on b.id = a.id_personal 
            where a.id_empresa = '.$_SESSION["Empresa"]["id"].' 
                  and 
                  a.id_evaluado = '.$id_evaluado.' 
                  and 
                  a.periodo_evaluador = '.$fechas["periodo_evaluador"].' 
            union
            select a.id_personal, b.nombre, a.resuelto, a.relacion 
            from multifuente_evaluado as a 
            inner join
            listado_personal_op as b on b.id = a.id_personal 
            where a.id_empresa = '.$_SESSION["Empresa"]["id"].' 
                  and 
                  a.id_personal = '.$id_evaluado.' 
                  and 
                  a.periodo_evaluador = '.$fechas["periodo_evaluador"].'';
    
    $array_evaluadores = $this->query_($sql);
    if (count($array_evaluadores) > 0) {
      foreach ($array_evaluadores as $key => $value) {
        $lista_evaluadores++;

        if ($value['resuelto'] == 1) {
          $lista_evaluadores_contestados++;
        }

        $listado[$id_evaluado][$i]['id_personal'] = $value['id_personal'];
        $listado[$id_evaluado][$i]['nombre'] = $value['nombre'];

        $relacion = '';
        if ($value['relacion'] == 1)
          $relacion = 'Superior';
        else if ($value['relacion'] == 2)
          $relacion = 'Par';
        else if ($value['relacion'] == 3)
          $relacion = 'Subalterno';
        else
          $relacion = 'Autoevaluado';

        $listado[$id_evaluado][$i]['relacion'] = $relacion;

        $listado[$id_evaluado][$i]['resuelto'] = $value['resuelto'];
        $listado[$id_evaluado][$i]['cumplimiento'] = ($value['resuelto'] == 0) ? 0 : 100;
        $i++;
      }
    }

    return $listado;
  }

  function notificacionEvaluadores($codigo_evaluador)
  {
    if ($codigo_evaluador == 'X') {
      try
      {
        $sql = 'SELECT * FROM `multifuente_evaluado` where id_empresa = '.$_SESSION["Empresa"]["id"].' ORDER BY id DESC limit 0,1';
        $fechas = $this->query_($sql, 1);

        $sql = 'select DISTINCT a.id_evaluado, a.id_personal, b.nombre, a.fecha, a.fecha_max 
                  from multifuente_evaluadores as a 
                  inner join
                  listado_personal_op as b on b.id = a.id_evaluado 
                  where a.id_empresa = '.$_SESSION["Empresa"]["id"].' 
                        and 
                        a.periodo_evaluador = '.$fechas["periodo_evaluador"].'';
        $evaluado = $this->query_($sql);
        $meth = new Multifuente();
        $cont = new MultifuenteController('Multifuente','multifuente','get_MsgEvaluadores');

        foreach ($evaluado as $key => $value) {
          $email = $meth->get_emailById($value['id_personal']);
          $subject= "Recordatorio de Evaluación ";
          $usr = $meth->get_usrById($value['id_personal']);
          $nombre = $meth->get_pname($value['id_personal']);
          $fecha = $value['fecha'];
          $fecha_max = $value['fecha_max'];
          $cod_evaluado = $value['id_evaluado'];
          $nombre_evaluado = $value["nombre"];
          $message = $cont->get_MsgEvaluadores($nombre,$nombre_evaluado,$fecha,$cod_evaluado,$usr,$fecha_max,$value['id_personal']);
          Util::sendMail($email,$subject,$message);
        }
      } catch (Exception $e) {
        $this->setError("Error: ".$e->getMessage());
      }
    }
    else{
      try
      {
        $sql = 'SELECT * FROM `multifuente_evaluado` where id_empresa = '.$_SESSION["Empresa"]["id"].' ORDER BY id DESC limit 0,1';
        $fechas = $this->query_($sql, 1);

        $sql = 'select DISTINCT a.id_evaluado, a.id_personal, b.nombre, a.fecha, a.fecha_max 
                  from multifuente_evaluadores as a 
                  inner join
                  listado_personal_op as b on b.id = a.id_evaluado 
                  where a.id_empresa = '.$_SESSION["Empresa"]["id"].' 
                        and 
                        a.periodo_evaluador = '.$fechas["periodo_evaluador"].' 
                        and
                        a.id_personal = '.$codigo_evaluador;
        $evaluado = $this->query_($sql);
        $meth = new Multifuente();
        $cont = new MultifuenteController('Multifuente','multifuente','get_MsgEvaluadores');

        foreach ($evaluado as $key => $value) {
          $email = $meth->get_emailById($value['id_personal']);
          $subject= "Recordatorio de Evaluación ";
          $usr = $meth->get_usrById($value['id_personal']);
          $nombre = $meth->get_pname($value['id_personal']);
          $fecha = $value['fecha'];
          $fecha_max = $value['fecha_max'];
          $cod_evaluado = $value['id_evaluado'];
          $nombre_evaluado = $value["nombre"];
          $message = $cont->get_MsgEvaluadores($nombre,$nombre_evaluado,$fecha,$cod_evaluado,$usr,$fecha_max,$value['id_personal']);
          Util::sendMail($email,$subject,$message);
        }
      } catch (Exception $e) {
        $this->setError("Error: ".$e->getMessage());
      }
    }
  }
}