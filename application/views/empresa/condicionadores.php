<?php $cond = $_SESSION["Empresa"]['condicionadores']; ?>
<form action="<?php echo BASEURL ?>empresa/condicionadores" class="register" method="POST">
     
    <fieldset>
        <legend>Condicionadores</legend>  
        <div class="row">
            <div class="col-md-6 show-grid">
                <table id="dataTable" class="table table-bordered" border="1">
                    <thead>
                        <th>#</th>
                        <th>Nombre</th>
                    </thead>    
                    <tbody>
                        <?php $tmp = array_filter($cond);
                        if (!empty($tmp)){ 
                            foreach ($cond as $a => $b) {
                        ?>
                                <tr>
                                    <p>
                                        <td>
                                            <input type="hidden" type="checkbox" required="required" name="chk[]" value="<?php if(isset($b['Empresa_cond']['id'])){echo $b['Empresa_cond']['id'];}else{echo "";}?>" checked="checked" />
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" required="required" class="small" value="<?php if(isset($b['Empresa_cond']['nombre'])){echo $b['Empresa_cond']['nombre'];}else{echo "";}?>"  name="cd_nombre[]">
                                        </td>
                                    </p>
                                </tr>
                    <?php   }
                        }else{  ?>
                                <tr>
                                    <p>
                                        <td>
                                            <input type="hidden" type="checkbox" required="required" name="chk[]" checked="checked" />
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" required="required" class="small"  name="cd_nombre[]">
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
                <input type="button" class="btn btn-default btn-xs" value="Agregar" onClick="addRow('dataTable')" /> 
                <input type="button" class="btn btn-default btn-xs" value="Remover" onClick="deleteRow('dataTable')"  /> 
            </div>  
        </div>  
        <div class="clear"></div>
        <div class="col-md-3 col-md-offset-9 show-grid">
            <input type="submit" class="btn btn-default btn-xs" name="guardar_datos" value="Guardar">
        </div>
    </fieldset>
</form>