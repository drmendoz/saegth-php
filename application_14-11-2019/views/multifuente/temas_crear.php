<form action="<?php echo BASEURL ?>multifuente/temas_crear" class="register" method="POST">
     
    <fieldset>
        <legend>Cargos</legend>
        <div class="row">
            <div class="col-md-9">
                <table id="dataTable" class="table table-bordered" border="1">
                    <thead>
                        <th>Tema</th>
                        <th>Decripci&oacute;n</th>
                    </thead>    
                    <tbody>
                        <tr>
                          <p>
                              <td class="col-md-4" style="min-width:100%;">
                                  <input type="text" class="form-control" required="required" class="small"  name="temas[]">
                              </td>
                              <td class="col-md-8" style="max-width:100%;">
                                  <textarea type="text" class="form-control" required="required" class="small"  name="descripcion[]"></textarea>
                              </td>
                          </p>
                      </tr>
                    </tbody>
                </table>
            </div>  
        </div>    
        <div class="row">
            <div class="col-md-4 show-grid" > 
                <input type="button" class="btn btn-default btn-xs" value="Agregar nuevo tema" onClick="addRow('dataTable')" /> 
                <input type="button" class="btn btn-default btn-xs" value="Remover" onClick="deleteRow('dataTable')"  /> 
            </div>  
        </div>    
        <div class="col-md-3 col-md-offset-9 show-grid">
            <input type="submit" class="btn btn-default btn-xs" name="guardar_datos" value="Guardar">
        </div>
    </fieldset>
</form>