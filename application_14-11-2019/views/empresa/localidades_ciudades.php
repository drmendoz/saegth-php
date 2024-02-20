<?php 
    $local = $_SESSION["Empresa"]['local']['pais']; 
    $meth = new Admin();
?>
<form action="<?php echo BASEURL ?>empresa/localidades_ciudades" class="register" method="POST">
     
    <fieldset><?php $tmp = array_filter($local);
        if (!empty($tmp)){  
            foreach ($local as $a => $b) {
                $b = reset($b);
                $i = $b['nombre'];
                $id_sup = $b['id'];
                $ciudad=$meth->DB_exists_double('empresa_local','id_empresa',$_SESSION["Empresa"]["id"],'id_superior',$id_sup);
        ?>
                <legend>Ciudad de <?php echo $i; ?></legend>
                <div class="row">
                    <div class="col-md-6 show-grid">
                        <table id="dataTable<?php echo $id_sup ?>" class="table table-bordered" border="1">
                            <thead>
                                <th>#</th>
                                <th>Nombre</th>
                            </thead>    
                            <tbody>
                                <?php $tmp = array_filter($ciudad);
                                if (!empty($tmp)){ 
                                    foreach ($ciudad as $x => $y) {
                                        $y = $y["Empresa_local"];
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
                                                    <input type="text" class="form-control" required="required" class="small" value="<?php echo $meth->htmlprnt($value) ?>"  name="lcc_nombre[]">
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
                                                    <input type="text" class="form-control" required="required" class="small"  name="lcc_nombre[]">
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