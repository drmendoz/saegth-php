<?php
    $ciudad = $_SESSION["Empresa"]['local']['ciudad']; 
    $meth = new Admin();
?>
<form action="<?php echo BASEURL ?>empresa/localidades_sucursales" class="register" method="POST">
     
    <fieldset>
        <?php $tmp = array_filter($ciudad);
        if (!empty($tmp)){ 
            foreach ($ciudad as $a => $b) {
                $i = $b['Empresa_local']['nombre'];
                $id_sup = $b['Empresa_local']['id'];
                $sucursal = $meth->DB_exists_double('empresa_local','id_empresa',$_SESSION["Empresa"]["id"],'id_superior',$id_sup);
        ?>
                <legend>Sucursal de <?php echo $i; ?></legend>   
                <div class="row">
                    <div class="col-md-6 show-grid">
                        <table id="dataTable<?php echo $id_sup ?>" class="table table-bordered" border="1">
                            <thead>
                                <th>#</th>
                                <th>Nombre</th>
                            </thead>    
                            <tbody>
                                <?php $t = array_filter($sucursal);
                                if (!empty($t)){ 
                                    foreach ($sucursal as $x => $y) {
                                        $y = reset($y);
                                        if(in_array($id_sup, $y)){
                                            $id = $y['id'];
                                            $value = $y['nombre'];
                                ?>
                                        <tr>
                                            <p>
                                                <td>
                                                    <input type="hidden" type="checkbox" class="lc_chk" required="required" name="chk[]" value="<?php echo $id_sup.','.$id ?>" checked="checked" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" class="small" value="<?php echo $meth->htmlprnt($value) ?>"  name="lcs_nombre[]">
                                                </td>
                                            </p>
                                        </tr>
                            <?php  } }
                                }else{  ?>
                                        <tr>
                                            <p>
                                                <td>
                                                    <input type="hidden" type="checkbox" class="lc_chk" required="required" name="chk[]" value="<?php echo $id_sup ?>,0"checked="checked" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" class="small"  name="lcs_nombre[]">
                                                </td>
                                            </p>
                                        </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>  
                </div>  
            <div class="row">
                <div class="col-md-3 col-md-offset-6 show-grid" style="margin-top:-70px"> 
                    <input type="button" class="btn btn-default btn-xs" value="Agregar" onClick="addRow('dataTable<?php echo $id_sup ?>')" /> 
                    <input type="button" class="btn btn-default btn-xs" value="Remover" onClick="deleteRow('dataTable<?php echo $id_sup ?>')"  /> 
                </div>  
            </div>  
            <?php } }?>
        <div class="col-md-3 col-md-offset-9 show-grid">
            <input type="submit" class="btn btn-default btn-xs" name="guardar_datos" value="Guardar">
        </div>
    </fieldset>
</form>