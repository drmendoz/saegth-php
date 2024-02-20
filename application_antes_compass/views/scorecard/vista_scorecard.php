<style type="text/css">
.nested-list ol { counter-reset: item }
.nested-list li { display: block }
.nested-list li:before { content: counters(item, ".") " "; counter-increment: item }

.col-xxs-1,.col-xxs-2,.col-xxs-3,.col-xxs-4,.col-xxs-5,.col-xxs-6,.col-xxs-7,.col-xxs-8,.col-xxs-9,.col-xxs-10,.col-xxs-11,.col-xxs-12,.col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12 {
  position: relative;
  min-height: 1px;
  padding-right: 15px;
  padding-left: 15px;
}
</style>
<?php 
$meth = new Scorecard(); 
$success = '<h2><i class="fa fa-check" style="color:green"></i></h2>';
$error = '<h2><i class="fa fa-times" style="color:red"></i></h2>';
?>
<style type="text/css">
  table tr, table td{padding:10px;}
  table.scorecard td{text-align: center;}
</style>
<?php ?>
<div class="form-group">
  <img src="<?php echo BASEURL ?>img/scorecard.png" style="width: 200px;">
  <h3 align="center">SISTEMA DE INFORMACIÓN GENERAL DEL PROCESO</h3>

  <table class="table table-bordered"  style="width: 100%;">
    <tr>
      <td><b>PERSONAL: </b><?php echo $meth->htmlprnt_win($nombre); ?></td>
      <td><b>CARGO: </b><?php echo $meth->htmlprnt($cargo); ?></td>
      <td><b>&Aacute;REA: </b><?php echo $meth->htmlprnt($area); ?></td>
    </tr>
    <tr>
      <td colspan="2"><b>EMPRESA: </b><?php echo $meth->htmlprnt($_SESSION['Empresa']['nombre']); ?></td>
      <td><b>PERIODO DE MEDICIÓN: </b><?php echo $fecha; ?></td>
    </tr>
  </table>
</div>
<div>
 <input type="button" onclick="tableToExcel('testTable3', 'Objetivos')" value="Export SCORECARD" class="btn btn-sm btn-success">
</div>
<br>

<div id="testTable3" class="table-responsive">
	<table  class="table table-bordered"  >
		
    <tbody>
     <tr bgcolor="#A9A9F5">
     <td>#</td>
     <td>Objetivo</td>
     <td>Responsable</td>
     <td>Indicadores</td>
     <td>Inverso</td>
     <td>Uni. Medida</td>
     <td>Meta</td>
     <td>Peso</td>
     <td>Resul. en cifras</td>
     <td>Resultado %</td> 
     <td>Resultado 
         Ponderado 
     </td>     
    </tr>
     <?php 
     
     foreach ($emp as $e)
{

 $obj_sup= $meth->vista_scorecard($e['id'],$fecha,$id_personal);
    $tot1= $meth->total_scorecard($e['id'],$fecha,$id_personal,$scorer->col);
 $count_peso=count($obj_sup);
 $pes=100/$count_peso;

?>
   <tr bgcolor="#CED8F6">     
     <td style="text-align: left !important" colspan="3">
	 <?php echo  $meth->htmlprnt($e['nombre']);?>
     </td>
     <td style="text-align: left !important">
	Acciones delegadas a areas
     </td>
     <td>NO</td><td>%</td><td>100</td>
     <td>
     <?php  echo   round($pes).'%';?>
     </td>
     <td style="text-align: left !important">
	  <?php echo round($tot1["respor"],2).'%';?>
     </td>
     
      <td style="text-align: left !important">
	 <?php echo round($tot1["res"]*100,2).'%';?>
     </td>
     
      <td style="text-align: left !important">
	 <?php echo round(($pes*$tot1["res"]),2).'%';?>
     </td>
     </tr>

<?php 
    
     if(count($obj_sup)>0){
     $num_rows=sizeof($obj_sup);
      $rrr = true;
       $i=0;
   
    }else{
      $num_rows=0;
      $rrr = false;
    }
  $i=0;
     
     
    foreach ($obj_sup as $fields) { $r_scorer = $meth->get_ScorecardRes($fields['id_personal'],$fecha);
    
     $det= $meth->detalle_vista($fields['id'],$id_personal,$fecha);
    $tot1= $meth->total_scorecard1($fields['id'],$id_personal,$fecha,$scorer->col);
    $rows=sizeof($det);
    //print_r($det);
    ?>
   <tr bgcolor="#CED8F6"> 
     <td style="text-align: left !important">
	 <?php echo  $i+1;?>
     </td>
     <td style="text-align: left !important">
	 <?php echo  $meth->htmlprnt($fields['objetivo']);?>
     </td>
     
     <td style="text-align: left !important">
         <?php if ($fields['id_personal']==$id_personal)
	{ 
	?> 
        <a href="<?php echo BASEURL.'scorecard/confirmacion/'.$fields['id_personal'] ?>"><?php echo $meth->htmlprnt_win($meth->get_pname($fields['id_personal'])) ?></a>
	<?php
	}
	else
	{
	 echo $meth->htmlprnt_win($meth->get_pname($fields['id_personal']));
	}
	?>
	
     </td>
     
     <td style="text-align: left !important">
	 <?php echo  $meth->htmlprnt($fields['indicador'].'');?>
     </td>
     <td class="col-md-1">
        <?php 
        switch ($fields["inverso"]) {
          case '0':
          echo "NO";
          break;
          case '1':
          echo "SI";
          break;
         
        }
        ?>
      </td>
     
      <td class="col-md-1">
        <?php 
        switch ($fields["unidad"]) {
          case '0':
          echo "US\$M";
          break;
          case '1':
          echo "%";
          break;
          case '2':
          echo "Fecha";
          break;
          case '3':
          echo "#";
          break;
        }
        ?>
      </td>
     <?php
	
     if(isset($fields["meta"])) $meta = unserialize($fields["meta"]) ?>
            <?php for ($e=0; $e < 1 /*$scorer->col*/; $e++) { ?>
             <td style="text-align: left !important"><?php if(isset($meta[$e]))$m=$meta[$e]; echo $meta[$e] ?></td>
            <?php } ?>
     <td style="text-align: left !important">
    <?php $pes=100/$num_rows; echo  $fields['peso'].'%';?>
     </td>
     
      <td style="text-align: left !important">
	  <?php echo round($fields['lreal'],2).'%';?>
     </td>
     
      <td style="text-align: left !important">
	 <?php $res=($fields["lreal"]/$m); echo  round(($fields["lreal"]/$m)*100,2).'%';?>
     </td>
     
      <td style="text-align: left !important">
	 <?php echo round(($fields["peso"]*$res),2).'%';?>
     </td>
            
	</tr>       
    <?php
    $aux=0;
    $count_peso =count($det);
    
    foreach($det as $d)
     {
     $det2= $meth->detalle_vista2($d['id'],$d['objetivo'],$fecha);
     
      $tot1=$meth->suma_valores($det2,$scorer->col);
      $count_peso1 =count($tot1);
      $aux2=$aux+1 ;
      $aux3=$i+1 .'.';
     ?>
     <tr  bgcolor="#CEECF5">
     <td style="text-align: left !important">
	 <?php echo $aux3.$aux2;?>
     </td>
     
      <td style="text-align: left !important">
	 <?php echo  $meth->htmlprnt($d['objetivo']);?>
     </td>
     
     <td style="text-align: left !important">
        <a href="<?php echo BASEURL.'scorecard/confirmacion/'.$d['id_personal'] ?>"><?php echo $meth->htmlprnt_win($meth->get_pname($d['id_personal'])) ?></a>
	 
     </td>
     
     <td style="text-align: left !important">
	 <?php echo  $meth->htmlprnt($d['indicador']);?>
     </td>
      <td class="col-md-1">
        <?php 
        switch ($d["inverso"]) {
          case '0':
          echo "NO";
          break;
          case '1':
          echo "SI";
          break;
         
        }
        ?>
      </td>
     
     <td class="col-md-1">
        <?php 
        switch ($d["unidad"]) {
          case '0':
          echo "US\$M";
          break;
          case '1':
          echo "%";
          break;
          case '2':
          echo "Fecha";
          break;
          case '3':
          echo "#";
          break;
        }
        ?>
      </td>
     <?php
     if(isset($d["meta"])) $meta = unserialize($d["meta"]) ?>
            <?php for ($e=0; $e < 1 /*$scorer->col*/; $e++) { ?>
             <td style="text-align: left !important"><?php if(isset($meta[$e])) $m=$meta[$e]; echo $meta[$e] ?></td>
            <?php } ?>
     <td style="text-align: left !important">
	 <?php $pes=100/$count_peso; echo  round($d['peso'],2).'%';?>
     </td>
     
     <td style="text-align: left !important">
	  <?php echo round($d['lreal'],2).'%';?>
     </td>
     
      <td style="text-align: left !important">
	  <?php $res=($d["lreal"]/$m); echo  round(($d["lreal"]/$m)*100,2).'%';?>
     </td>
     
      <td style="text-align: left !important">
	 <?php echo round(($d["peso"]*$res),2).'%';?>
     </td>
     
     </tr>
     <?php
     
      /**********************************************************/
     
     $aux4=0;
    $count_peso2 =count($det2);
    foreach($det2 as $d2)
     {
      $aux5=$aux4+1 ;
      $aux6=$aux3.$aux2 .'.';
     ?>
     <tr>
     <td style="text-align: left !important">
	 <?php echo $aux6.$aux5;?>
     </td>
     
      <td style="text-align: left !important">
	 <?php echo  $meth->htmlprnt($d2['objetivo']);?>
     </td>
     
     <td style="text-align: left !important">
        <a href="<?php echo BASEURL.'scorecard/confirmacion/'.$d2['id_personal'] ?>"><?php echo $meth->htmlprnt_win($meth->get_pname($d2['id_personal'])) ?></a>
	 
     </td>
     
     <td style="text-align: left !important">
	 <?php echo  $meth->htmlprnt($d2['indicador']);?>
     </td>
      <td class="col-md-1">
        <?php 
        switch ($d2["inverso"]) {
          case '0':
          echo "NO";
          break;
          case '1':
          echo "SI";
          break;
         
        }
        ?>
      </td>
     
     <td class="col-md-1">
        <?php 
        switch ($d2["unidad"]) {
          case '0':
          echo "US\$M";
          break;
          case '1':
          echo "%";
          break;
          case '2':
          echo "Fecha";
          break;
          case '3':
          echo "#";
          break;
        }
        ?>
      </td>
     <?php
     if(isset($d2["meta"])) $meta = unserialize($d2["meta"]) ?>
            <?php for ($e=0; $e < $scorer->col; $e++) { ?>
             <td style="text-align: left !important"><?php if(isset($meta[$e])) $m=$meta[$e]; echo $meta[$e] ?></td>
            <?php } ?>
     <td style="text-align: left !important">
	 <?php $pes=100/$count_peso2; echo  round($d2["peso"],2).'%';?>
     </td>
     
     <td style="text-align: left !important">
	 <?php echo  $d2["lreal"];?>
     </td>
     
      <td style="text-align: left !important">
	 <?php $res=($d2["lreal"]/$m); echo  round(($d2["lreal"]/$m)*100,2).'%';?>
     </td>
     
      <td style="text-align: left !important">
	 <?php echo round(($d2["peso"]*$res),2).'%';?>
     </td>
     
     </tr>
     <?php
     $aux4+=1;
     }
     
     
     /**********************************************************/
     
     
     
     
     
     
     
     
     /***********************************************************/
     
     
     
     
     
     
     $aux+=1;
        
     
     
     
     }
     $i+=1;
    }
    }
    ?>
  </tbody>
</table>
</div>

 <script type="text/javascript">


  // body...
  var tableToExcel = (function() {
  var uri = 'data:application/vnd.ms-excel;base64,'
    , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><meta http-equiv=Content-Type content="text/x-ms-odc; charset=utf-8"><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
    , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
    , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
  return function(table, name) {
    if (!table.nodeType) table = document.getElementById(table)
    var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
    window.location.href = uri + base64(format(template, ctx))
  }
})()

      

    </script>
