<?php
$meth = new Admin();
?>
<form action="<?php echo BASEURL ?>personal/datos_empresa"  class="form-horizontal" role="form" method="POST">
  <legend>Datos Personales</legend>
  <div class="row form-group">
    <div class="col-md-6"> 
      <label class="col-sm-4">Nombre</label>
      <div class="col-md-8">
        <input type="text" class="form-control" name="pr_nombre"  required="required" placeholder="Nombres" >
      </div>
    </div>            
    <div class="col-md-6">
      <label class="col-sm-4">C&eacute;dula</label>
      <div class="col-md-8">
        <input type="text" class="form-control" name="pd_ci" maxlength="13"   placeholder="C&eacute;dula" >
      </div>
    </div>
  </div>
  <div class="row form-group">
    <div class="col-md-6">
      <label class="col-sm-4">Fecha de Nacimiento</label>
      <div class="col-md-8">
        <input type="date" class="form-control" class="small"   name="pd_fn">
      </div>
    </div>
    <div class="col-md-6">
      <label class="col-sm-4">Fecha de Ingreso</label>
      <div class="col-md-8">
        <input type="date" class="form-control" class="small"   name="pd_ing">
      </div>
    </div>
  </div>
  <div class="row form-group">
    <div class="col-md-6">
      <label class="col-sm-4">E-mail</label>
      <div class="col-md-8">
        <input type="email" class="form-control" name="email"  required="required" placeholder="e-mail" >
      </div>
    </div>
    <div class="col-md-6">
      <label class="col-sm-4">Sexo</label>
      <div class="col-md-8">
        <select name="sexo" class="form-control"  >
          <option>- Seleccionar -</option>
          <option value="Masculino">Masculino</option>
          <option value="Femenino">Femenino</option>
        </select>   
      </div>
    </div>
  </div>
  <div class="col-xs-12 col-sm-12">
    <legend>Datos Organizacionales</legend>
    <div class="row form-group">
      <?php   
      $results = $meth->DB_exists_double('empresa_area','id_empresa',$_SESSION["Empresa"]["id"],'nivel',1);
      if ($results){ 
        ?> 
        <div id="area_holder" class="col-md-6 col-sm-6" value="area-holder">
          <div hidden>
            <input type="text"  class="form-control table_name" required="required" value="empresa_area" >
          </div>
          <fieldset>
            <div class="form-group">
              <div class="col-md-12 nested-list" >
                <?php
                echo '<ol>';
                $meth->arrWalkSel('empresa_area',$results,'area-select'); 
                echo '</ol>';
                ?>
              </div>
              <div hidden class="col-md-12">
                <input id="area-select" class="form-control" type="text" readonly="readonly" required="required" name="p_area">
              </div>
            </div>
          </fieldset> 
        </div>
        <?php   
      }
      $results = $meth->DB_exists_double('empresa_local','id_empresa',$_SESSION["Empresa"]["id"],'nivel',0);
      if ($results){ 
        ?> 
        <div id="local_holder" class="col-xs-6 col-sm-6">
          <div hidden>
            <input type="text" class="form-control table_name" required="required" value="empresa_local" >
          </div>
          <fieldset>
            <div class="form-group">
              <label class="col-md-5">Pa&iacute;s</label> 
              <div hidden>
                <input type="text" class="form-control step" value="1" >
              </div>  
              <div class="col-md-6">
                <select name="p_local[]"  required="required" class="parent form-control">
                  <option style="display:none" value="" selected="selected">-- Seleccionar una opci&oacute;n --</option>
                  <?php
                  foreach ($results as $a => $b) {  
                    $b = reset($b); ?>
                    <option value="<?php echo $b['id'];?>"><?php echo $meth->htmlprnt($b['nombre']);?></option>
                    <?php } ?>
                  </select>  
                </div>
              </div>
            </fieldset> 
          </div>
          <?php   } ?>
        </div>
        <div class="row form-group"> 
          <?php 
          $cargos = new Empresa_cargo();
          $cargos = $cargos->select_all($id_e);
          if ($cargos) { 
            ?> 
            <div class="col-xs-6 col-sm-6">
              <fieldset>
                <label class="col-md-5">T&iacute;tulo del cargo</label>  
                <div class="col-md-6">
                  <select class="form-control chosen"  required="required" name="cargo">
                    <option style="display:none" value="" selected="selected">-- Seleccionar una opci&oacute;n --</option>
                    <?php   
                    foreach($cargos as $a => $b){  
                      ?>
                      <option value="<?php echo $b['id'];?>"><?php echo $meth->htmlprnt($b['nombre']);?></option>
                      <?php   
                    } 
                    ?>
                  </select>
                </div>  
              </fieldset>
            </div> 
            <div class="stop">
              <div id="cargo_holder" class="col-xs-6 col-sm-6">
                <div hidden>
                  <input type="text" class="form-control table_name" required="required" value="personal_empresa" >
                </div>
                <fieldset>
                  <div class="form-group">
                    <label class="col-md-5">Cargo a quien reporta</label>  
                    <div class="col-md-6">
                      <select class="form-control cargo-selectr chosen" name="cargo_s">
                        <option style="display:none" value="" selected="selected">-- Seleccionar una opci&oacute;n --</option>
                        <?php
                        foreach($cargos as $a => $b){   ?>
                        <option value="<?php echo $b['id'];?>"><?php echo $meth->htmlprnt($b['nombre']);?></option>
                        <?php
                      } 
                      ?>
                    </select>
                  </div>  
                </div>
                <div class="holder">
                </div>  
              </fieldset>
            </div> 
          </div> 
          <?php
        } 
        $niveles = new empresa_norg();
        $niveles = $niveles->select_all($id_e);
        if ($niveles) { 
          ?> 
          <div class="col-xs-6 col-sm-6">
            <fieldset>
              <label class="col-md-5">Nivel Organizacional</label>  
              <div class="col-md-6">
                <select class="form-control chosen"  required="required" name="n_org">
                  <option style="display:none" value="" selected="selected">-- Seleccionar una opci&oacute;n --</option>
                  <?php
                  foreach($niveles as $a => $b){  
                    ?>
                    <option value="<?php echo $b['id'];?>"><?php echo $meth->htmlprnt($b['nombre']);?></option>
                    <?php
                  } 
                  ?>
                </select>
              </div>  
            </fieldset>
          </div>
          <?php
        } 
        ?>
        <div class="col-xs-6 col-sm-6">
          <fieldset>
            <?php
            $eval = reset($eval);
            foreach ($eval as $key => $value) {
              if($value){ 
                ?>
                <div class="row">
                  <label class="col-md-5"><?php echo ucfirst($key); ?></label>
                  <div class="col-md-7">
                    <input type="checkbox" name="eval[]" value="<?php echo $key; ?>">
                  </div> 
                </div>
                <?php
              } 
            } 
            ?>
          </fieldset>
        </div>
      </div>
      <div class="row form-group">  
        <?php 
        $t_cont = new Empresa_tcont();
        $t_cont = $t_cont->select_all($id_e);
        if ($t_cont) { 
          ?> 
          <div class="col-xs-6 col-sm-6">
            <fieldset>
              <label class="col-md-5">Tipo de contrato</label>  
              <div class="col-md-6">
                <select class="form-control chosen"  required="required" name="t_cont">
                  <option style="display:none" value="" selected="selected">-- Seleccionar una opci&oacute;n --</option>`
                  <?php   
                  foreach($t_cont as $a => $b){
                    ?>
                    <option value="<?php echo $b['id']; ?>"><?php echo $meth->htmlprnt($b['nombre']); ?></option>
                    <?php   
                  } 
                  ?>
                </select>
              </div>  
            </fieldset>
          </div> 
          <?php   
        } 
        if ($cond){ 
          ?> 
          <div class="col-md-6 col-sm-6">
            <fieldset>
              <?php
              foreach($cond as $x => $y){ 
                $y=reset($y);
                ?>
                <div class="row form-group">
                  <label class="col-md-5"><?php echo $meth->htmlprnt($y['nombre']) ?></label>
                  <div class="col-md-6">
                    <select class="form-control"  required="required" name="cond_opcion[]">
                      <option style="display:none" value="" selected="selected">-- Seleccionar una opci&oacute;n --</option>
                      <?php   $c_opc = $meth->DB_exists_double('empresa_cond','id_empresa',$_SESSION["Empresa"]["id"],'id_superior',$y['id']);
                      foreach ($c_opc as $a => $b) {   
                        $b = reset($b); ?>
                        <option value="<?php echo $b['id'];?>"><?php echo $meth->htmlprnt($b['nombre']);?></option>
                        <?php       
                      } 
                      ?>
                    </select>
                  </div>
                </div>
                <?php  
              }
              ?>
            </fieldset>
          </div>
          <?php   
        } 
        ?>
      </div>
      <div class="row form-group">
        <div class="col-md-6 col-sm-6">
          <fieldset>
            <label class="col-md-5">Grado salarial</label>
            <div class="col-md-6">
              <select name="g_sal" class="form-control" >
                <option value="">--Seleccionar una opción--</option>
                <?php 
                foreach ($grados as $key => $value) { $grado=new Grado_salarial($value); 
                  ?>
                  <option value="<?php echo $grado->grado ?>"><?php echo $grado->grado ?></option>
                  <?php 
                } 
                ?>
              </select>
            </div>
          </fieldset>
        </div>
        <div class="col-md-6 col-sm-6">
          <fieldset>
            <div class="row form-group">
              <label class="col-md-5">Notificar cambios de sistema</label>
              <div class="col-md-6">
                <input type="checkbox" name="not_sis" value="1">
              </div>
            </div>
          </fieldset>
        </div>
      </div> 
      <div class="row form-group">
        <div class="col-md-6 col-sm-6">
          <fieldset>
            <label class="col-md-5">Sueldo</label>
            <div class="col-md-6">
              <input id="ThousandSeperator_num" type="hidden"  name="sueldo">
              <input id="ThousandSeperator_commas" class="form-control">
            </div>
          </fieldset>
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
<script type="text/javascript">
$(document).ready(function(){
  $("select.chosen").chosen()
})
</script>
