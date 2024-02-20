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
<div class="form-group">
  <img src="<?php echo BASEURL ?>img/scorecard.png" style="width: 200px;">
  <h3 align="center">SISTEMA DE INFORMACIÓN GENERAL DEL PROCESO</h3>

<!-- <a href="<?php echo BASEURL.'pdf/scorecard/'.$_SESSION['Empresa']['id'] ?>" class="btn btn-sm btn-info">Generar PDF</a>-->
</div>
<div>


 <input type="button" onclick="tableToExcel('testTable', 'Objetivos')" value="Objetivos Estrategicos" class="btn btn-sm btn-success">
 <input type="button" onclick="tableToExcel('testTable2', 'Objetivos')" value="Scorcard" class="btn btn-sm btn-success">

</div>
<br>
<div  id="testTable" class="table-responsive">
	<table class="table table-bordered"  >

		
    <tbody>
     <tr bgcolor="#A9A9F5">
     <td>#</td>
     <td><h6><strong>Objetivo</strong></h6></td>
     <td><h6><strong>Responsable</strong></h6></td>
     <td><h6><strong>Indicadores</strong></h6></td>
     <td><h6><strong>Inverso</strong></h6></td>
     <td><h6><strong>Uni. Medida</strong></h6></td>
     <td><h6><strong>Meta</strong></h6></td>
     <td><h6><strong>Peso</strong></h6></td>
     <td><h6><strong>Resul. en cifras</strong></h6></td>
     <td><h6><strong>Resultado %</strong></h6></td> 
     <td><h6><strong>Resultado 
         Ponderado </strong></h6>
     </td>     
    </tr>
     <?php 
     $count_peso=count($emp);
     $pes=round(100/$count_peso,2);
     //$pes=100;
     
     foreach ($emp as $e)
{
 $obj_sup= $meth->detalle_vista2($e['id'],$e['objetivo'],$fecha);
  
//$obj_sup= $meth->vista_scorecard2($e['id'],$id_empresa,$fecha);
   
     $tot0="";
     //$tot0=$meth->total_scorecard2($e['id'],$id_empresa,$fecha,$scorer->col);
	 $tot0= $meth->total_scorecard($e['id'],$e['periodo'],$e['id_personal'],$scorer->col);
?>
   <tr bgcolor="#CED8F6">     
     <td style="text-align: left !important" colspan="3"><h6>
	 <?php echo  $meth->htmlprnt($e['objetivo']);?></h6>
     </td>
     <td style="text-align: left !important"><h6>
	<?php echo  $meth->htmlprnt($e['indicador']);?></h6>
     </td>
     <td><h6>NO</h6></td><td><h6>
	 <?php
	 //echo  $meth->htmlprnt($e['unidad']);
	 switch ($e["unidad"]) {
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
	 </h6></td><td><h6>100</h6></td>
     <td><h6>
     <?php  echo   round($pes,2).'%';?></h6>
     </td>
      <td style="text-align: left !important"><h6>
	  <?php echo round($tot0["rpond"],2).'%';?></h6>
     </td> 
     
      <td style="text-align: left !important"><h6>
	 <?php echo round(($tot0["res"]*100),2).'%';?></h6>
     </td> 
     
      <td style="text-align: left !important"><h6>
	 <?php echo round(($pes*$tot0["res"]),2).'%';?></h6>
     </td>
     </tr>

<?php 
     $empresa=$e['id'];
    if(count($obj_sup)>0){
     $num_rows=count($obj_sup);
      $rrr = true;
       $i=0;
   
    }else{
      $num_rows=0;
      $rrr = false;
    }
  $i=0;
    foreach ($obj_sup as $fields) { $r_scorer = $meth->get_ScorecardRes($fields['id_personal'],$fecha);
    unset($tot1);
    $det= $meth->detalle_vista_p($fields['objetivo'],$fecha,$id_empresa);
    $tot1=$meth->suma_valores($det,$scorer->col);
    $rows=sizeof($det);
    //print_r($det);
    ?>
    <tr  bgcolor="#CEECF5">
     <td style="text-align: left !important"><h6>
	 <?php echo  $i+1;?></h6>
     </td>
     <td style="text-align: left !important"><h6>
	 <?php echo  $meth->htmlprnt($fields['objetivo']);?></h6>
     </td>
     
     <td style="text-align: left !important"><h6>
        <a href="<?php echo BASEURL.'scorecard/confirmacion/'.$fields['id_personal'] ?>"><?php echo $meth->htmlprnt_win($meth->get_pname($fields['id_personal'])) ?></a></h6>
	 
     </td>
     
     <td style="text-align: left !important"><h6>
	 <?php echo  $meth->htmlprnt($fields['indicador']);?></h6>
     </td>
     <td class="col-md-1"><h6>
        NO   </h6>
      </td>
     
      <td class="col-md-1"><h6><!-- % -->
      <?php //echo $fields['unidad'];
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
	  ?> </h6>
      </td>
     <td class="col-md-1"><h6>
       100</h6>
      </td>
     <td style="text-align: left !important"><h6>
	 <?php $pes1=100/$num_rows; echo  round((100/$num_rows),2).'%';?></h6>
     </td>
     
     <td style="text-align: left !important"><h6>
	  <?php echo round($tot1["respor"],2).'%';?></h6>
     </td>
     
      <td style="text-align: left !important"><h6>
	 <?php echo round(($tot1["res"]*100),2).'%';?></h6> 
     </td>
     
      <td style="text-align: left !important"><h6>
	 <?php echo round(($pes1*$tot1["res"]),2).'%';?></h6>
     </td>
     
	       
	</tr>       
    <?php
    $aux=0;
    $count_peso1 =count($det);
    foreach($det as $d)
     {
      $aux2=$aux+1 ;
      $aux3=$i+1 .'.';
     ?>
     <tr>
     <td style="text-align: left !important"><h6>
	 <?php echo $aux3.$aux2;?></h6>
     </td>
     
      <td style="text-align: left !important"><h6>
	 <?php echo  $meth->htmlprnt($d['objetivo']);?></h6>
     </td>
     
     <td style="text-align: left !important"><h6>
        <a href="<?php echo BASEURL.'scorecard/confirmacion/'.$d['id_personal'] ?>"><?php echo $meth->htmlprnt_win($meth->get_pname($d['id_personal'])) ?></a></h6>
	 
     </td>
     
     <td style="text-align: left !important"><h6>
	 <?php echo  $meth->htmlprnt($d['indicador']);?></h6>
     </td>
      <td class="col-md-1"><h6>
        <?php 
        switch ($d["inverso"]) {
          case '0':
          echo "NO";
          break;
          case '1':
          echo "SI";
          break;
         
        }
        ?></h6>
      </td>
     
     <td class="col-md-1"><h6>
        <?php //echo $d["unidad"];
		
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
        ?></h6>
      </td>
     <?php
     if(isset($d["meta"])) $meta = unserialize($d["meta"]) ?>
            <?php for ($e=0; $e < 1 /*$scorer->col*/; $e++) { ?>
             <td style="text-align: left !important"><h6><?php if(isset($meta[$e])) $m=$meta[$e]; echo $meta[$e]?></h6></td>
            <?php } ?>
     <td style="text-align: left !important"><h6>
	 <?php $pes2=100/$count_peso1; echo  round((100/$count_peso1),2);?></h6>
     </td>
     
     <td style="text-align: left !important"><h6>
	 <?php echo  $d["lreal"];?></h6>
     </td>
     
      <td style="text-align: left !important"><h6>
	 <?php $res=($d["lreal"]/$m); echo  round((($d["lreal"]/$m)*100),2).'%';?></h6>
     </td>
     
      <td style="text-align: left !important"><h6>
	 <?php echo round(($pes2*$res),2).'%';?></h6>
     </td>
     
     </tr>
     <?php
     
     
      /**********************************************************/
     $det2= $meth->detalle_vista2($d['id'],$d['objetivo'],$fecha);
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
	 <?php $pes=100/$count_peso2; echo  round((100/$count_peso2),2).'%';?>
     </td>
     
     <td style="text-align: left !important">
	 <?php echo  $d2["lreal"];?>
     </td>
     
      <td style="text-align: left !important">
	 <?php $res=$d["lreal"]/$m; echo  round(($d2["lreal"]/$m),2).'%';?>
     </td>
     
      <td style="text-align: left !important">
	 <?php echo round(($pes*$res),2).'%';?>
     </td>
     
     </tr>
     <?php
     $aux4+=1;
     }
     
     
     /**********************************************************/
     
     
     
     $aux+=1;
     }
     $i+=1;
    }
    }
    ?>
  </tbody>
</table>
</div >


<div id="testTable2" class="table-responsive">
<table class="table table-bordered">
<tr bgcolor="#A9A9F5">
<td>Empresa</td><td>Localidad</td><td>Área</td><td>Usuario</td><td>Cargo</td>
<td>Objetivo<br>Primario</td><td>Objetivo<br>Secundario</td><td>Inverso</td><td>Unidad<br>Medida </td><td>Meta</td>
<td>Peso</td><td>Logro Real</td><td>Logro Porcentual</td><td>Logro Ponderado</td>
</tr>
<?php 

$obj_general= $meth->objetivo_general($id_empresa,$fecha);

 foreach($obj_general as $obj)
 {
  ?>
  <tr>
  <td ><h6>
  <?php echo $meth->htmlprnt($obj["empresa"]) ?></h6>
  </td>
  <td ><h6>
  <?php echo $obj["localidad"] ?></h6>
  </td>
   <td ><h6>
  <?php echo $meth->htmlprnt($obj["area_emp"]) ?></h6>
  </td>
   <td ><h6>
  <?php echo $meth->htmlprnt($obj["nombre_p"]) ?></h6>
  </td>
   <td ><h6>
  <?php echo $meth->htmlprnt($obj["cargo"]) ?></h6>
  </td>
   <td ><h6>
  <?php echo $meth->htmlprnt($obj["objetivo"]) ?></h6>
  </td>
   <td ><h6>
  <?php echo $meth->htmlprnt($obj["indicador"]) ?></h6>
  </td>
   <td ><h6>
  <?php 
   switch ($obj["inverso"]) {
          case '0':
          echo "NO";
          break;
          case '1':
          echo "SI";
          break;
        }	  ?></h6>
  </td>
   <td ><h6>
        <?php 
        switch ($obj["unidad"]) {
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
        ?></h6>
      </td>
   
   <td ><h6>
   <?php
     if(isset($obj["meta"])) $meta = unserialize($obj["meta"]) ?>
            <?php for ($e=0; $e < 1; $e++) { ?>
             <td style="text-align: left !important"><h6><?php if(isset($meta[$e])) $m=$meta[$e]; echo $meta[$e]?></h6></td>
            <?php } ?>
   
  <?php /*echo $meth->htmlprnt($obj["meta"])*/ ?></h6>
  </td>
   <td ><h6>
  <?php echo $meth->htmlprnt($obj["peso"]) ?></h6>
  </td>
  
  <td ><h6>
  <?php echo $meth->htmlprnt($obj["lreal"]) ?></h6>
  </td>
  <td ><h6>
  <?php echo $meth->htmlprnt($obj["lpond"]) ?></h6>
  </td>
  <td ><h6>
  <?php echo $meth->htmlprnt($obj["ppond"]) ?></h6>
  </td>
  
  
  </tr>
  <?php
 }

?>
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