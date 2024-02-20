<?php $meth = new Empresa();$cond = $_SESSION["Empresa"]['condicionadores']; ?>
<form action="<?php echo BASEURL ?>empresa/condicionadores_opciones" class="register" method="POST">
    <?php foreach ($cond as $x => $y) {
        $i = $y['Empresa_cond']['nombre'];
        $id_sup = $y['Empresa_cond']['id'];
    ?>   
        <fieldset>
            <legend>Condicionador: <?php echo $i ?></legend>
            <div class="row">
                <div class="col-md-6 show-grid">
                    <table id="dataTable<?php echo $id_sup ?>" class="table table-bordered" border="1">
                        <thead>
                            <th>#</th>
                            <th>Nombre</th>
                        </thead>    
                        <tbody>
                            <?php 
                            $opc = $meth->query('select id,nombre,id_superior from empresa_cond WHERE nivel=1 AND id_superior='.$id_sup.'');
                            echo mysqli_error($meth->link);
                            $tmp =array_filter($opc); 
                            if (!empty($tmp)){ 
                                foreach ($opc as $a => $b) {
                                    if(($id_sup === $b["Empresa_cond"]['id_superior'])){
                            ?>
                                    <tr>
                                        <p>
                                            <td>
                                                <input type="hidden" type="checkbox" class="lc_chk" required="required" name="chk[]" value="<?php if(isset($b['Empresa_cond']['id'])){echo $id_sup.','.$b['Empresa_cond']['id'];}else{echo "";}?>" checked="checked" />
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" required="required" class="small" value="<?php if(isset($b['Empresa_cond']['nombre'])){echo $b['Empresa_cond']['nombre'];}else{echo "";}?>"  name="co_nombre[]">
                                            </td>
                                        </p>
                                    </tr>
                        <?php   }   }
                            }else{  ?>
                                    <tr>
                                        <p>
                                            <td>
                                                <input type="hidden" type="checkbox" class="lc_chk" required="required" name="chk[]" value="<?php echo $id_sup.',0' ?>" checked="checked" />
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" required="required" class="small" name="co_nombre[]">
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
        </fieldset>
<?php } ?> 
    <div class="col-md-3 col-md-offset-9 show-grid">
        <input type="submit" class="btn btn-default btn-xs" name="guardar_datos" value="Guardar">
    </div>
</form>