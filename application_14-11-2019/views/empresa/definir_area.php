<?php 
$meth = new Void();
if(isset($area)){
  $area=reset($area);  
  $nivel = $area['nivel'];
  $nombre = $area['nombre'];
  $msg = 'Subarea de '.$meth->htmlprnt($nombre);
}else{
  $nivel = 1;
  $nombre = '';
  $msg = '&Aacute;rea del nivel '.$meth->htmlprnt($nivel);
} 
$i=intval($nv);
$i++;
?>
<form action="<?php echo BASEURL.'empresa/definir_area/'.$nv ?>" class="register" method="POST">
   
  <input type="hidden" required="required" name="pid" checked="checked" value="<?php if(isset($id)) echo $id; ?>" />
  <fieldset>
    <legend>
      <?php  echo $msg ?> 
      <input type="submit" class="btn btn-danger btn-sm" name="eliminar" value="Eliminar">
    </legend>   
    <div class="row">
      <div class="col-md-6 show-grid">
        <table id="dataTable<?php echo $i ?>" class="table table-bordered" border="1">
          <thead>
            <th width="8">#</th>
            <th width="2"></th>
            <th>Nombre del área</th>
          </thead>    
          <tbody>
            <?php
            if(!$children)
              $children = array("");    
            foreach ($children as $key => $value) { ?>
                <tr>
                  <p>
                    <td width="8">
                      <input type="checkbox" class="id_da" name="chk[]" checked="checked" value="<?php if(isset($value['id'])) echo $value['id']; ?>" />
                    </td>
                    <td width="2"><input type="hidden" class="form-control nivel-area" readonly="readonly" required="required" name="nv_nivel[]" value="<?php if(isset($value['nivel'])) echo $value['nivel']; else echo $i; ?>"></td>
                    <td>
                      <input type="text" class="form-control" class="small" name="nv_nombre[]" value="<?php if(isset($value['nombre'])) echo $meth->htmlprnt($value['nombre']); ?>">
                    </td>
                  </p>
                </tr>
              <?php } ?>
          </tbody>
        </table>
      </div>  
    </div>
    <?php if($nv > 0){ ?>
    <div class="row">
      <div class="col-md-3 col-md-offset-6 show-grid" style="margin-top:-70px"> 
        <div class="btn-group" role="group" aria-label="...">
          <input type="button" class="btn btn-default btn-xs" value="Agregar" onClick="addRow('dataTable<?php echo $i ?>')" /> 
          <input type="button" class="btn btn-default btn-xs" value="Remover" onClick="deleteRow('dataTable<?php echo $i ?>')"  /> 
        </div>
      </div>  
    </div>
    <?php } ?>   
    <div class="col-md-3 col-md-offset-9 show-grid">
      <input type="submit" class="btn btn-success btn-sm" name="guardar_datos" value="Guardar">
      <a href="<?php echo BASEURL.'empresa/crear_areas' ?>" class="btn btn-info btn-sm" >Volver</a>
    </div>
  </fieldset>
</form>