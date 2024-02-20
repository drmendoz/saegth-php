<?php $meth = new Scorecard(); ?>
<style type="text/css">
  table#scorer textarea{width:250px; max-width: 250px;}
  table#scorer select{width: 100px !important;}
  input[type="text"]{width: 60px !important; min-width: 75px;}

  .first_cell{
    width: 8px;
  }
  table#scorer tr, table#scorer td{padding:10px;}
  table#fasefinal table tr, table#fasefinal table td{padding:inherit;}
  table#obj th,table#scorer th,th.objind{text-align: center !important}
  table#scorer tbody tr td input,
  table#scorer tbody tr td{text-align: right;}
  table#scorer tbody tr td input[type="date"]{width: 160px;}

  table#obj tbody tr td{text-align: right;}
  table#obj tbody tr td.objind{text-align: left;}
  table#obj tbody tr td:first-child{width: 15px}
  table#obj tbody tr td input[type="date"]{width: 160px;}
</style>
<input type="hidden" id="bloqueo" value='<?php echo $f;?>'>
<input type="hidden" id="id" value='<?php echo $_SESSION['USER-AD']['id_personal'] ?>'>
<input type="hidden" id="autor" value='<?php if($_SESSION['USER-AD']['id_personal'] == $id) echo 0; else echo 1 ?>'>
<input type="hidden" id="vinicial" value='<?php echo $scorer->vinicial ?>'>
<input type="hidden" id="razon" value='<?php echo $scorer->razon ?>'>
<input type="hidden" id="periodo" value='<?php echo $fecha ?>'>
<input type="hidden" id="col" value='<?php echo $scorer->col ?>'>
<?php $meth->header_set($id,$fecha); ?>
<p>&nbsp;</p>
<?php $estado = Scorer_estado::withID($id); ?>
<?php if(isset($obj_sup)){ ?>
<h4 class='form-group'>Objetivos del jefe</h4>
<table class="table-bordered" width="100%" id="obj">
  <thead>
    <tr>
      <th class="first_cell">#</th>
	   <th></th>
      <th>Objetivo</th>
      <th>Indicador</th>
      <th>Unidad de medida</th>
      <?php
      $m = 15;
      $n = $m / $scorer->col;
      $n = ceil($n); 
      for ($i=0; $i < $scorer->col; $i++) { 
        $fond = "FF".dechex($m).dechex($n)."00";  
        if($scorer->col=="1" || ($scorer->vinicial + ($scorer->razon * $i))==100){ $col_m = $i; ?>
        <th style="background: #<?php echo $fond ?>">
          <?php echo "Meta"; ?>
        </th>
        <?php } $m -= $n;} ?>
        <th>Peso %</th>
    </tr> 
  </thead>
  <tbody >
    <?php
      $num_rows=sizeof($obj_sup);
      $rrr = true;
     for ($i=0; $i < $num_rows; $i++) { if($rrr){$fields=new Scorer_obj($obj_sup[$i]);} $arr_padre[$fields->id]=$i+1; ?>
    <tr>
      <td class="first_cell"><p><?php echo $i+1; ?></p></td>
	   <td> <input type="checkbox" name="selp[]" class="selp form-horizontal" title="Seleccionar padre"  value="<?php echo $fields->id; ?>" onclick="alertaChecked('<?php echo $fields->id; ?>')" /></td>
      <td class="col-md-5 objind"><?php if(isset($fields->objetivo)) echo $meth->htmlprnt($fields->objetivo); else echo "N/D";?></td>
      <td class="col-md-4 objind"><?php if(isset($fields->indicador)) echo $meth->htmlprnt($fields->indicador); else echo "N/D";?></td>
      <td class="col-md-1">
        <?php 
        switch ($fields->unidad) {
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
      <?php if(isset($fields->meta)) $meta = unserialize($fields->meta) ?>
      <?php for ($e=0; $e < $scorer->col; $e++) { ?>
      <?php if($col_m==$e){ ?>
      <td class="col-md-1">
        <?php if(isset($meta[$e])) echo $meta[$e]; else echo "N/D";?>
      </td>
      <?php } ?>
      <?php } ?>
      <td class="col-md-1">
        <?php if(isset($fields->peso)) echo $meth->htmlprnt($fields->peso)."%"; else echo "N/D";?>
      </td>
    </tr>        
    <?php   } unset($fields); ?>
  </tbody>
</table>

      <?php } ?>
<p>&nbsp;</p>
<p>&nbsp;</p>
<h4 class='form-group'>Mi Scorecard</h4>
<form action="<?php echo BASEURL ?>scorecard/generacion/<?php echo $id; ?> " method="POST">
  <div style="overflow-x: auto;">
    <table class="table-bordered" id="scorer">
      <thead>
        <tr>
          <th width="15" class="no-padding">#</th>
          <th width="15" class="no-padding"> </th>
		  <th width="15" class="no-padding"> </th>
		  <th width="15" class="no-padding">Obj Superior </th>
          <th>Objetivo</th>
          <th>Indicador</th>
  <?php if($scorer->col==1){ ?>
          <th>Inverso</th>
  <?php } ?>
          <th>Unidad de medida</th>
          <?php
          $m = 15;
          $n = $m / $scorer->col;
          $n = ceil($n); 
          for ($i=0; $i < $scorer->col; $i++) { 
            $fond = "FF".dechex($m).dechex($n)."00"; ?> 
            <th style="background: #<?php echo $fond ?>">
              <?php 
              if($scorer->col=="1" || ($scorer->vinicial + ($scorer->razon * $i))==100)  
                echo "Meta";
              else
                echo $scorer->vinicial + ($scorer->razon * $i);
              ?>
            </th>
            <?php $m -= $n;} ?>
            <th>Peso %</th>
            <th>Logro Real</th>
            <th>Logro Ponderado %</th>
            <th>Puntaje Ponderado %</th>
            <th>Plan De Acción</th>
          </tr> 
        </thead>
        <tbody >
          <?php if(isset($obj_)){
            $num_rows=sizeof($obj_);
            $rrr = true;
          }else{
            $num_rows=1;
            $rrr = false;
          } 
	  $aux4=0;
	  for ($i=0; $i < $num_rows; $i++) { if($rrr){$fields=new Scorer_obj($obj_[$i]);} 
            $aux4+=1;
	     ?>
          <tr>
            <td><span class='counter'><?php echo $i+1; ?></span></td>
            <td> <input type="checkbox" name="sel[]" class="sel form-horizontal" title="Seleccionar padre"  value="1" /></td>
	     <input type="hidden" name="padre[]" class="form-control padre"  value="<?php if(isset($fields->id_padre)) echo $meth->htmlprnt($fields->id_padre); ?>">
	     <input type="hidden" name="padre_sup[]" class="form-control padre_sup"  value="<?php if(isset($fields->id_padre_sup)) echo $meth->htmlprnt($fields->id_padre_sup); ?>">
	     <input type="hidden" name="idobj[]" class="form-control idobj"  value="<?php if(isset($fields->id)) echo $meth->htmlprnt($fields->id); ?>">
            <td>
              <?php
                if(!$f){
			$valor= $meth->objetivos_dependientes($fields->id);
	      if($valor["total"]>0)
	      {
	       $aux="S";
	      }
	      else
	      {
	      $aux="N";
	      }
              ?>
              <input type="hidden" value="">
               <!--<a tabIndex="-1" class="elim" style="color:red">-->
	      <a tabIndex="-1" onclick="valida_eliminacion('scorer',this,'<?php echo $aux;?>')"  style="color:red"><i class="fa fa-times"></i> </a>
                <!--<i class="fa fa-times grow"></i>
	      </a>-->
              <?php
                }else{
              ?>
              &nbsp;
              <?php 
                }
              ?>
            </td>
            <td><?php  echo $arr_padre[$fields->id_padre_sup]; ?></td>
			<td><textarea style="width:300px" required="required" name="obj[]"class="form-control obj"><?php if(isset($fields->objetivo)) echo $meth->htmlprnt($fields->objetivo); ?></textarea></td>
            <td><textarea style="width:300px" required="required" name="ind[]"class="form-control ind"><?php if(isset($fields->indicador)) echo $meth->htmlprnt($fields->indicador); ?></textarea></td>
            <?php if($scorer->col==1){ ?>
            <td>
              <select class="inv">
                <option <?php if(isset($fields->inverso)){if ($fields->inverso=="0"){ echo "selected";}} ?> value="0">No</option>
                <option <?php if(isset($fields->inverso)){if ($fields->inverso=="1"){ echo "selected";}} ?> value="1">Si</option>
              </select>
            </td>
    <?php } ?>
            <td>
              <select name="und[]" required="required" class="und form-control">
                <option <?php if(isset($fields->unidad)){if ($fields->unidad=="0"){ echo "selected";}} ?> value="0">US$M</option>
                <option <?php if(isset($fields->unidad)){if ($fields->unidad=="1"){ echo "selected";}} ?> value="1">%</option>
                <option <?php if(isset($fields->unidad)){if ($fields->unidad=="2"){ echo "selected";}} ?> value="2">Fecha</option>
                <option <?php if(isset($fields->unidad)){if ($fields->unidad=="3"){ echo "selected";}} ?> value="3">#</option>
              </select>
            </td>
            <?php if(isset($fields->meta)) $meta = unserialize($fields->meta) ?>
            <?php for ($e=0; $e < $scorer->col; $e++) { ?>
            <td><input type="text" required="required" value="<?php if(isset($meta[$e])) echo $meta[$e] ?>" name="meta<?php echo $e ?>[]" class="form-control meta"></td>
            <?php } ?>
            <td>
              <div class="input-group">
                <input type="text" class="peso form-control" aria-describedby="basic-addon2" value="<?php if(isset($fields->peso)) echo $meth->htmlprnt($fields->peso) ?>" name="peso[]">
                <span class="input-group-addon" id="basic-addon2">%</span>
              </div>
            </td>
            <td><input type="text" value="<?php if(isset($fields->lreal)) echo $meth->htmlprnt($fields->lreal) ?>" name="lreal[]" class="form-control l_real"></td>
            <td>
              <div class="input-group">
                <input type="text" tabIndex="-1" readonly="readonly" aria-describedby="basic-addon2" value="<?php if(isset($fields->lpond)) echo $fields->lpond ?>" name="lpond[]" class="hiddencomma form-control l_pond">
                <span class="input-group-addon" id="basic-addon2">%</span>
              </div>
            </td>
            <td>
              <div class="input-group">
                <input type="text" tabIndex="-1" readonly="readonly" aria-describedby="basic-addon3" value="<?php if(isset($fields->ppond)) echo $fields->ppond ?>" name="ppond[]" class="hiddencomma form-control p_pond">
                <span class="input-group-addon" id="basic-addon3">%</span>
              </div>
            </td>
            <td><button class="ag_plan btn-info btn-xs btn" data-loading-text="...">Agregar</button></td>
          </tr>        
          <?php   } if($scorer->col==1) $scorer->col++ ;?>
		  <input type="hidden" id="total" class="form-control total"  value="<?php echo $aux4; ?>">
	  <input type="hidden" id="sel_pa" class="form-control total"  value="">
	  <?php
	   if(!$rrr){?>
	   <input type="hidden" id="no_reg" class="form-control no_reg"  value="S">
	   <?php
	   }
	  ?>
          <tr>
            <td colspan="<?php echo $scorer->col+7 ?>"> Suma Peso %</td>
            <td>
              <div class="input-group">
                <input tabIndex="-1" id="sum_peso"; readonly="readonly" type="text" class="form-control">
                <span class="input-group-addon">%</span>
              </div>
            </td>
            <td colspan="2">Total puntaje ponderado</td>
            <td>
              <div class="input-group">
                <input tabIndex="-1" id="sum_ponderado" readonly="readonly" type="text" class="form-control">
                <span class="input-group-addon" id="basic-addon3">%</span>
              </div>
            </td>
          </tr>  
          <tr>
            <td colspan="<?php echo $scorer->col+6 ?>"></td>
            <td colspan="2">Factor de ajuste</td>
            <?php  ?>
            <td>
              <div class="input-group">
                <input type="text" id="f_ajuste" disabled type="number" class="form-control" value="<?php echo $ajuste ?>">
                <span class="input-group-addon" id="basic-addon3">%</span>
              </div>
            </td>
          </tr> 
          <tr>
            <td colspan="<?php echo $scorer->col+6 ?>"></td>
            <td colspan="2">Total puntaje ponderado ajustado</td>
            <?php  ?>
            <td>
              <div class="input-group">
                <input tabIndex="-1" id="p_ajustado" readonly="readonly" type="text" class="form-control">
                <span class="input-group-addon" id="basic-addon3">%</span>
              </div>
            </td>
          </tr>
          <tr>
            <td colspan="<?php echo $scorer->col+6 ?>">
            <div class="btn-group" role="group" aria-label="...">
              <input type="submit"  id="addrow" class="btn btn-sm btn-info" data-loading-text="Guardando..." value="Agregar nuevo objetivo">
              <a href="<?php echo BASEURL.'pdf/scorecard/'.$id ?>" class="btn btn-sm btn-info">Generar PDF</a>
              <input type="submit" id="submit" name="guardar" data-loading-text="Guardando..." class="btn btn-sm btn-success" value="Guardar ScoreCard">
              <a href="<?php echo BASEURL.'scorecard/home' ?>" class="btn btn-sm btn-danger" >Salir</a>
              </div>
            </td>
            <td colspan="2">Puntaje Scorecard</td>
            <?php  ?>
            <td><input tabIndex="-1" id="p_scorecard" readonly="readonly" type="text" class="form-control pull-right"></td>
          </tr> 
        </tbody>
      </table>
      <p>&nbsp;</p>
    </div>
    <p>&nbsp;</p>

  </form>

<?php 
  $scorecard = new ScorecardController('Scorecard','scorecard','revision',0,true,true); 
  $scorecard->revision($_SESSION['USER-AD']['id_personal'],$fecha); 
  $scorecard->ar_destruct();
  unset($scorecard); 
  $scorecard = new ScorecardController('Scorecard','scorecard','evaluacion',0,true,true); 
  $scorecard->evaluacion($_SESSION['USER-AD']['id_personal'],$fecha); 
  $scorecard->ar_destruct();
  unset($scorecard); 
  $scorecard = new ScorecardController('Scorecard','scorecard','que_hacer',0,true,true); 
  $scorecard->que_hacer($_SESSION['USER-AD']['id_personal'],$fecha); 
  $scorecard->ar_destruct();
  unset($scorecard); 
?>

<script type="text/javascript">

  $(document).ready(function(){
    getPeso();
    getPsum();
    var ajuste = document.getElementById('f_ajuste');
    if ($(ajuste).val() == "") $(ajuste).val(0);
    if (isNaN($(ajuste).val())) {
      setError(this);
    }
    p_scorecard($(ajuste).val());
    var und = $('.und');
    $.each(und,function(index,value){
      inDate(value);
    });
    var block = document.getElementById('bloqueo');
    var isblk = $(block).val() 
    if(isblk==1){
      $('#scorer input').prop("disabled", true);
      $('#scorer textarea').prop("disabled", true);
      $('#scorer select').prop("disabled", true);
    }
    $('#add').click(function(){
      if(isblk==1)
        event.preventDefault();
      else
        getAll();
    });



  });

 $('#submit').click(function(){
    event.preventDefault();
    id=$('#id').val();
    if(saveform(this,false, 'S'))
      ajaxmailer(2,id);
      //var a=0;
    else
      $(this).button('reset');
        var n = $( "input:checked" ).length;
       //if(n>0)
       //{
        setTimeout(function(){ location.reload(); }, 3000);
       //}
  });

  $('#addrow').click(function(){
    event.preventDefault();
    //if(saveform(this,false))
      addRow('scorer',true);
    //$().toastmessage('showNoticeToast', 'Se ha agregado un objetivo');
    var n = $( "input:checked" ).length;
  //$( "div" ).text( n + (n === 1 ? " is" : " are") + " checked!" );
  if(n==0)
  {
   $().toastmessage('showNoticeToast', 'No ha seleccionado un objetivo padre');
  }
    stuff();
    getPeso();
    getPsum();
    processReal(this);
    p_scorecard();
   });
  
  var countChecked = function() {
  var n = $( "input:checked" ).length;
  //$( "div" ).text( n + (n === 1 ? " is" : " are") + " checked!" );
  if(n>1)
  {
   $("input:checked").prop("checked", "");
   $().toastmessage('showNoticeToast', 'Se debe seleccionar solo un objetivo');
   document.getElementById('sel_pa').value="";
    
  }
};
countChecked();
 
$( "input[type=checkbox]" ).on( "click", countChecked );

function alertaChecked(valor){ 
    var n = $( "input:checked" ).length;
	 if(n>0)
     {
       document.getElementById('sel_pa').value = valor;
     }
     else
     {
       document.getElementById('sel_pa').value = "";
     }
   
}
function valida_eliminacion(tabla,elemento,bandera)
   {
     if (bandera=="N")//Uno representa que no tiene registros
     {
       _deleteRow(tabla,elemento);
           
     }
     else
     {
      $().toastmessage('showNoticeToast', 'Objetivo es dependiente de sus subordinados');
     }     
   }
</script>