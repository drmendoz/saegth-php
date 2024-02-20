<form action="<?php echo BASEURL ?>multifuente/preguntas_crear" class="register" method="POST">
     
    <fieldset>
        <legend>Crear preguntas</legend>
        <div class="row">
          <div class="col-md-9">
            <div class="row form-group">
              <label class="col-md-2 col-md-offset-3"><h4>Temas</h4></label>   
              <div class="col-md-6">
                <select required="required" class="form-control test-select" name="tema">
                  <option value="">-- Seleccionar tema --</option>
                  <?php 
                    foreach ($temas as $a => $b) {
                      $c = $b['Temas_360'];
                      echo '<option value="'. $c['cod_tema'] .'" >'. Util::htmlprnt($c['tema']) .'</option>';
                    }
                  ?>    
                </select>
              </div>
            </div>
            <div class="col-md-9 col-md-offset-3">
                <table id="dataTable" class="table table-bordered" border="1">
                    <thead>
                        <th>Pregunta</th>
                        <th>PN</th>
                    </thead>    
                    <tbody>
                        <tr>
                          <p>
                              <td class="col-md-10" style="min-width:100%;">
                                  <input type="text" class="form-control" required="required" class="small"  name="preg[]">
                              </td>
                              <td class="col-md-1" style="max-width:100%;">
                                  <input type="checkbox" class="small p_chk" value="0" name="0">
                              </td>
                          </p>
                      </tr>
                    </tbody>
                </table>
            </div>  
        </div>    
        <div class="row">
            <div class="col-md-4 col-md-offset-3 show-grid" > 
                <input type="button" class="btn btn-default btn-xs" value="Agregar nueva pregunta" onClick="addRow('dataTable')" /> 
            </div>  
        </div>    
        <div class="col-md-12 text-center">
            <p>PN : Preguntas Negativas, si se marca la casilla la pregunta sera tomada como negativa,<br>
es decir, 1 sera tomado como 5 y la respueta 5 sera tomado como 1.</p>
        </div>    
        <div class="col-md-3 col-md-offset-9 show-grid">
            <input type="submit" class="btn btn-default btn-xs" name="guardar_datos" value="Guardar">
        </div>
    </fieldset>
</form>

