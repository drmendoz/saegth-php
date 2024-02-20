<?php
    $meth = new Admin();
?>
<form action="<?php echo BASEURL ?>personal/datos_familiar"  class="form-horizontal" role="form" method="POST">
    <div class="col-xs-12 col-sm-12">
        <div class="row form-group">
            <div class="col-xs-6 col-sm-6">
                <legend>Estado Civil</legend>
                <fieldset>
                    <label class="col-md-5">Estado Civil</label>  
                    <div class="col-md-6">
                        <select id="estado_civil" required="required" name="estado_civil" class="form-control">
                            <option value="" selected="selected">-- Seleccionar una opci&oacute;n --</option>
                            <option value="1">Soltero</option>
                            <option value="2">Casado</option>                                        
                            <option value="3">Viudo</option>
                            <option value="4">Divorciado</option>
                            <option value="5">Union Libre</option>
                        </select>
                    </div>
                </fieldset>
            </div> 
            <div id="datos_conyugue" hidden class="col-xs-6 col-sm-6">
                <legend>Datos del Conyugue</legend>
                <fieldset>
                    <div class="form-group has-feedback">
                        <label class="col-md-5">Nombre C&oacute;nyuge</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="n_cony" required="required" placeholder="Nombre" >
                            <span class="fa fa-user form-control-feedback"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-5">Fecha de Nacimiento</label>
                        <div class="col-md-6">
                            <input type="date" class="form-control" name="fn_cony" placeholder="Fecha de nacimiento">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-5">Fecha Matrimonio</label>
                        <div class="col-md-6">
                            <input type="date" class="form-control" name="fmat" placeholder="Fecha de matrimonio">
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-xs-6 col-sm-6">
                <legend>Hijos</legend>
                <fieldset>
                    <label class="col-md-5">&iquest;Tiene hijos?</label>  
                    <div class="col-md-6">
                        <input type="checkbox" name="b_hijos" id="b_hijos" value="true">
                    </div>
                </fieldset>
            </div> 
            <div id="hijos" hidden class="col-xs-6 col-sm-6">
                <legend>Datos de hijos</legend>
                <table id="dataTable" class="table">
                    <thead>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Fecha de nacimiento</th>
                    </thead>    
                    <tbody>
                        <tr>
                            <p>
                                <td>
                                    <input type="checkbox" required="required" name="chk[]" checked="checked" />
                                </td>
                                <td>
                                    <input type="text" class="form-control" class="small"  name="h_nombre[]">
                                </td>
                                <td>
                                    <input type="date" class="form-control" class="small"  name="h_fn[]">
                                </td>
                            </p>
                        </tr>
                    </tbody>
                </table>
                <div class="col-md-12 show-grid" > 
                    <input type="button" class="btn btn-default btn-xs" value="Agregar" onClick="addRow('dataTable')" /> 
                    <input type="button" class="btn btn-default btn-xs" value="Remover" onClick="deleteRow('dataTable')"  /> 
                </div>  
            </div>
        </div> 
    </div>
    <p>&nbsp;</p>
    <div class="row form-group">
        <div class="col-md-2 col-md-offset-10">            
            <fieldset>
                <input class="btn btn-default btn-xs" type="submit" name="gpde" value="Guardar">
            </fieldset>
        </div>
    </div>
</form>

