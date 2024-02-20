<?php $norg = $_SESSION["Empresa"]['niveles_organizacionales']; ?>
<form action="<?php echo BASEURL ?>empresa/niveles_organizacionales" class="register" method="POST">
     
    <fieldset>
        <legend>Niveles Organizacionales</legend>
        <div class="row">
            <div class="col-md-6 show-grid">
                <table id="dataTable" class="table table-bordered" border="1">
                    <thead>
                        <th>#</th>
                        <th>Nombre</th>
                    </thead>    
                    <tbody>
                        <?php
                        $tmp=array_filter($norg);
                        if (!empty($tmp)){ 
                            foreach ($norg as $a => $b) {

                        ?>
                                <tr>
                                    <p>
                                        <td>
                                            <input type="hidden" type="checkbox" required="required" name="chk[]" value="<?php if(isset($b['Empresa_norg']['id'])){echo $b['Empresa_norg']['id'];}else{echo "";}?>" checked="checked" />
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" required="required" class="small" value="<?php if(isset($b['Empresa_norg']['nombre'])){echo $b['Empresa_norg']['nombre'];}else{echo "";}?>"  name="no_nombre[]">
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
                                            <input type="text" class="form-control" required="required" class="small"  name="no_nombre[]">
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
        <div class="col-md-3 col-md-offset-9 show-grid">
            <input type="submit" class="btn btn-default btn-xs" name="guardar_datos" value="Guardar">
        </div>
    </fieldset>
</form>