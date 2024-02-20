<?php $local = $_SESSION["Empresa"]['local']['pais']; ?>
<?php $meth = new Ajax(); ?>
<form action="<?php echo BASEURL ?>empresa/localidades" class="register" method="POST">
  <fieldset>
    <legend>Pa&iacute;s</legend> 
    <div class="row">
      <div class="col-md-6 show-grid">
        <table id="tabla" class="table table-bordered" border="1">
          <thead>
            <th>#</th>
            <th>Nombre</th>
          </thead>    
          <tbody>
            <?php $tmp = array_filter($local);
            if (!empty($tmp)){ 
              foreach ($local as $a => $b) {
				  $valor= $meth->personal_localidad($b['Empresa_local']['id']);
				  if($valor["total"]>0)
	      {
	       $aux="S";
	      }
	      else
	      {
	      $aux="N";
	      }
                ?>
                <tr>
                    <td>
					<a tabIndex="-1" onclick="valida_eliminacion('tabla',this,'<?php echo $aux;?>')"  style="color:red"><i class="fa fa-times"></i> </a>
                      <input type="hidden" type="checkbox" required="required" name="chk[]" value="<?php if(isset($b['Empresa_local']['id'])){echo $b['Empresa_local']['id'];}?>" checked="checked" />
                    </td>
                    <td>
                      <input type="text" class="form-control" required="required" class="small" value="<?php if(isset($b['Empresa_local']['nombre'])){echo $meth->htmlprnt($b['Empresa_local']['nombre']);}?>"  name="lc_nombre[]">
                    </td>
                </tr>
                <?php   }
              }else{  ?>
              <tr>
                <td>
				     <a tabIndex="-1" onclick="valida_eliminacion('tabla',this,0)"  style="color:red"><i class="fa fa-times"></i> </a>
                    <input type="hidden" type="checkbox" required="required" name="chk[]" checked="checked" />
                  </td>
                  <td>
                    <input type="text" class="form-control" required="required" class="small"  name="lc_nombre[]">
                  </td>
                </tr>
              <?php }unset ($valor); ?>
            </tbody>
          </table>
        </div>  
      </div>    

      <div class="row">
        <div class="col-md-3 col-md-offset-6 show-grid" style="margin-top:-70px"> 
          <input type="button" class="btn btn-default btn-xs" value="Agregar" onClick="addRow('tabla')" /> 
          <!--<input type="button" class="btn btn-default btn-xs" value="Remover" onClick="deleteRow('tabla')"  /> -->
		  <input type="submit" class="btn btn-primary btn-xs" name="guardar_datos" value="Guardar"> 
        </div>  
      </div>  
      <!--<div class="col-md-3 col-md-offset-9 show-grid">
        <input type="submit" class="btn btn-primary btn-xs" name="guardar_datos" value="Guardar">
      </div>-->
    </fieldset>
  </form>
  
  <script type="text/javascript">
   
   function valida_eliminacion(tabla,elemento,bandera)
   {
     if (bandera=="N")//N representa que no tiene registros
     {
       _deleteRow(tabla,elemento);
           
     }
     else
     {
      $().toastmessage('showNoticeToast', 'Localidad es dependiente de personas');
     }     
   }
   
   </script>