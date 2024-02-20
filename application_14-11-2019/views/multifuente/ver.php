<?php $meth = new Util(); //var_dump($test); ?>
  <div class="row">
    <div class="col-md-12 show-grid">
      <h3 align="center">Administrador</h3>
    </div>
  </div>
  <p>&nbsp;</p>
  <div class="row">
    <div class="col-md-12 show-grid">
      <h4 align="center"><strong>Test Generado</strong></h4>
    </div>
  </div>
  <div class="stop">
    <div id="test_holder" class="col-xs-12 col-sm-12">
      <div hidden>
          <input type="text" class="form-control table_name" value="multifuente_test" >
      </div>
        <div class="row form-group">
            <label class="col-md-5"><h4>Test generados</h4></label> 
            <div hidden>
                <input type="text" class="form-control step" value="1" >
            </div>  
            <div class="col-md-6">
        <?php //var_dump($empresas); ?>
               <select required="required" class="form-control test-select" name="empresa" placeholder="Ingreso de nueva empresa">
          <option value="">-- Seleccionar test --</option>
          <?php 
            foreach ($test as $a => $b) {
              $c = $b['Multifuente_test'];
              echo '<option value="'. $c['cod_test'] .'" >'. Util::htmlprnt($c['nombre_test']) .'</option>';
            }
          ?>    
          </select>
            </div>
        </div>
      <fieldset>
      </fieldset> 
  </div>
  </div>