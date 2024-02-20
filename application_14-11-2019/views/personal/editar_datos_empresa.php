<?php
$meth = new Admin();
?>
<style type="text/css">
  .chosen-container.chosen-container-single{
    width: 100% !important;
  }
</style>
<form action="<?php echo BASEURL ?>personal/editar_datos_empresa/<?php echo $id.'/'.$t ?>"  class="form-horizontal" role="form" method="POST">
  <p> <span style="font-size: 2em">Datos Personales</span> | <span style="font-size: 1.3em "> Reenviar correo con datos de ingreso </span><input type="checkbox" name="sendmail" ></p> 
  <!-- ROW 1 -->
  <!-- //test -->
  <div class="row form-group">
    <div class="col-md-6"> 
      <label class="col-sm-4">Nombre</label>
      <div class="col-md-8">
        <input type="text" class="form-control" name="pr_nombre"  placeholder="Nombres" value="<?php echo $meth->htmlprnt($dat['nombre']) ?>">
      </div>
    </div>            
    <div class="col-md-6">
      <label class="col-sm-4">C&eacute;dula</label>
      <div class="col-md-8">
        <input type="text" class="form-control" name="pd_ci" maxlength="13"  placeholder="C&eacute;dula" value="<?php echo $dat['cedula'] ?>">
      </div>
    </div>
  </div>
  <!-- ROW 2 -->
  <div class="row form-group">
    <div class="col-md-6">
      <label class="col-sm-4">Fecha de Nacimiento</label>
      <div class="col-md-8">
        <input type="date" class="form-control" class="small"  name="pd_fn" value="<?php echo trim($dat['fecha de nacimiento']) ?>">
      </div>
    </div>
    <div class="col-md-6">
      <label class="col-sm-4">Fecha de Ingreso</label>
      <div class="col-md-8">
        <input type="date" class="form-control" class="small"  name="pd_ing" value="<?php echo trim($dat['fecha de ingreso']) ?>">
      </div>
    </div>
  </div>
  <!-- ROW 3 -->
  <div class="row form-group">
    <div class="col-md-6">
      <label class="col-sm-4">E-mail</label>
      <div class="col-md-8">
        <input type="email" class="form-control" name="email"  placeholder="e-mail" value="<?php echo $dat['email'] ?>">
      </div>
    </div>
    <div class="col-md-6">
      <label class="col-sm-4">Sexo</label>
      <div class="col-md-8">
        <select name="sexo" class="form-control" >
        <option style="display:none">- Seleccionar -</option>
          <option value="Masculino" <?php if($dat['sexo'] == "Masculino") echo "selected" ?>>Masculino</option>
          <option value="Femenino" <?php if($dat['sexo'] == "Femenino") echo "selected" ?>>Femenino</option>
        </select>   
      </div>
    </div>
  </div>
  <legend>Datos Organizacionales</legend>
  <!-- ROW 4 -->
  <div class="row form-group">
    <div class="col-md-6">
      <?php   $results = $meth->DB_exists_double('empresa_area','id_empresa',$_SESSION["Empresa"]["id"],'nivel',1);
      if ($results){ ?> 
      <label class="col-sm-4 col-md-4">&Aacute;reas</label> 
      <div class=" col-sm-8 col-md-8">
        <div class="input-group">
          <input class="form-control" type="text" readonly="readonly" value="<?php echo $meth->htmlprnt($dat['area']) ?>">
          <span class="input-group-btn">
            <button class="btn btn-default btn-sm" data-toggle="collapse" data-target="#collapseArea" aria-expanded="false" aria-controls="collapseArea" onclick="event.preventDefault()">Editar</button>
          </span>
        </div>
      </div>
      <div class="col-md-12 nested-list" >
        <div class="collapse" id="collapseArea">
          <div class="well">
            <div id="area_holder" value="area-holder">
              <div hidden><input type="text" hidden  class="form-control table_name" required="required" value="empresa_area" ></div>
              <fieldset>
                <?php
                echo '<ol>';
                $meth->arrWalkSel('empresa_area',$results,'area-select'); 
                echo '</ol>';
                ?>
                <div hidden class="col-md-12">
                  <input id="area-select" class="form-control" type="text" readonly="readonly" name="p_area">
                </div>
              </fieldset> 
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php   } ?>
    <div class="col-md-6">
      <?php   
      $local = new empresa_local();
      $results = $local->select_all_nivel($id_e,0);
      if ($results){ ?> 
      <label class="col-sm-4 col-md-4">Locación</label> 
      <div class=" col-sm-8 col-md-8">
        <div class="input-group">
          <input class="form-control" type="text" readonly="readonly" value="<?php echo $meth->htmlprnt($dat['local']) ?>">
          <span class="input-group-btn">
            <button class="btn btn-default btn-sm" data-toggle="collapse" data-target="#collapseLocation" aria-expanded="false" aria-controls="collapseLocation" onclick="event.preventDefault()">Editar</button>
          </span>
        </div>
      </div>
      <div class="col-md-12">
        <div class="collapse" id="collapseLocation">
          <div  id="local_holder" class="well">
            <div hidden>
              <input type="text" class="form-control table_name" required="required" value="empresa_local" >
            </div>  
            <fieldset>
              <div class="form-group">
                <label class="col-sm-5 col-md-5">País</label> 
                <div hidden><input type="text" class="form-control step" value="1" ></div>
                <div class="col-md-6">
                  <select name="p_local[]" class="parent form-control">
                    <option value="" style="display:none">-- Seleccionar una opción --</option>
                    <?php
                    foreach ($results as $a => $b) { ?>
                    <option value="<?php echo $b['id'];?>"><?php echo $meth->htmlprnt($b['nombre']);?></option>
                    <?php } ?>
                  </select>  
                </div>
              </div>
              <div class="clearfix"></div>
            </fieldset> 
          </div>
        </div>
      </div>
      <?php   } ?>
    </div>
  </div>
  <!-- ROW 5 -->
  <div class="row form-group"> 

    <?php
    $cargos_obj = new Empresa_cargo();
    $cargos = $cargos_obj->select_all($id_e);
    if ($cargos) { 
      ?> 
      <div class="col-md-6">
        <fieldset>
          <label class="col-md-4">T&iacute;tulo del cargo</label>  
          <div class="col-md-8">
            <select class="form-control chosen" name="cargo">
              <option value="" style="display:none">-- Seleccionar una opción --</option>
              <?php $cargos_obj->get_select_options($_SESSION['Empresa']['id'],$dat['id_cargo']) ?>
            </select>
          </div>  
        </fieldset>
      </div> 
      <div class="col-xs-6 col-sm-6">
        <label class="col-sm-4 col-md-4">Nombre del superior</label> 
        <div class=" col-sm-8 col-md-8">
          <div class="input-group">
            <input class="form-control" type="text" readonly="readonly" value="<?php echo $meth->htmlprnt($dat['pid_nombre']) ?>">
            <span class="input-group-btn">
              <button class="btn btn-default btn-sm" data-toggle="collapse" data-target="#collapseSuperior" aria-expanded="false" aria-controls="collapseSuperior" onclick="event.preventDefault()">Editar</button>
            </span>
          </div>
        </div>
        <div class="col-md-12 nested-list" >
          <div class="collapse" id="collapseSuperior">
            <div class="stop well">
              <div id="cargo_holder">
                <div hidden class="col-xs-6 col-sm-6">
                  <input type="text" class="form-control table_name" required="required" value="personal_empresa" >
                </div>
                <fieldset>
                  <div class="form-group">
                    <label class="col-md-5">Cargo a quien reporta</label>  
                    <div class="col-md-6">
                      <select class="form-control cargo-selectr chosen" name="cargo_s">
                        <option value="" style="display:none">-- Seleccionar una opción --</option>
                        <?php   foreach($cargos as $a => $b){   ?>
                        <option value="<?php echo $b['id'];?>"><?php echo $meth->htmlprnt($b['nombre']);?></option>
                        <?php   } ?>
                      </select>
                    </div>  
                  </div>  
                </fieldset>
              </div>  
            </div>
          </div>
        </div>
      </div>
      <?php   } ?>
    </div>
    <!-- ROW 6 -->
    <div class="row form-group"> 
      <?php 
      $niveles = new empresa_norg();
      $niveles = $niveles->select_all($id_e);
      if ($niveles) { 
        ?> 
        <div class="col-xs-6 col-sm-6">
          <fieldset>
            <label class="col-md-4">Nivel Organizacional</label>  
            <div class="col-md-8">
              <select class="form-control chosen" name="n_org">
                <option value="" style="display:none">-- Seleccionar una opción --</option>
                <?php   foreach($niveles as $a => $b){ ?>
                <option value="<?php echo $b['id'];?>" <?php if($b['id']==$dat['id_norg']) echo "selected" ?>><?php echo $meth->htmlprnt($b['nombre']);?></option>
                <?php   } ?>
              </select>
            </div>  
          </fieldset>
        </div>
        <?php   } ?>
        <div class="col-xs-6 col-sm-6">
          <fieldset>
            <?php $datest = $meth->get_testdat($id) ?>
            <?php $eval = reset($eval);
            foreach ($eval as $key => $value) {
              if($value){ ?>
              <div class="row">
                <label class="col-md-5"><?php echo ucfirst($key); ?></label>
                <div class="col-md-7">
                  <input type="checkbox" name="eval[]" <?php if($datest[$key]) echo "checked" ?> value="<?php echo $key; ?>">
                </div> 
              </div>
              <?php } ?>        
              <?php } ?>
            </fieldset>
          </div>
        </div>
        <!-- ROW 7 -->
        <div class="row form-group">  
          <?php 
          $t_cont = new Empresa_tcont();
          $t_cont = $t_cont->select_all($id_e);
          if ($t_cont) { 
            ?> 
            <div class="col-xs-6 col-sm-6">
              <fieldset>
                <label class="col-md-4">Tipo de contrato</label>  
                <div class="col-md-8">
                  <select class="form-control chosen" name="t_cont">
                    <option value="" style="display:none">-- Seleccionar una opción --</option>
                    <?php echo $dat['id_tcont']; ?>
                    <?php   foreach($t_cont as $a => $b){ ?>
                    <option value="<?php echo $b['id']; ?>" <?php if($dat['id_tcont']==$b['id']) echo "selected" ?> ><?php echo $meth->htmlprnt($b['nombre']); ?></option>
                    <?php   } ?>
                  </select>
                </div>  
              </fieldset>
            </div> 
            <?php   } ?>
            <?php if ($cond){ ?> 
            <div class="col-md-6 col-sm-6">
              <fieldset>
                <?php
                foreach($cond as $x => $y){ 
                  $y=reset($y);?>
                  <div class="row form-group">
                    <label class="col-md-4"><?php echo $meth->htmlprnt($y['nombre']) ?></label>
                    <div class="col-md-8">
                      <select class="form-control"  name="cond_opcion[]">
                        <option value="" style="display:none">-- Seleccionar una opción --</option>
                        <?php   $c_opc = $meth->DB_exists_double('empresa_cond','id_empresa',$_SESSION["Empresa"]["id"],'id_superior',$y['id']);
                        foreach ($c_opc as $a => $b) {   
                          $b = reset($b); 
                          ?>
                          <option value="<?php echo $b['id'];?>" <?php if(@in_array($b['id'], unserialize($dat['id_cond']))) echo "selected" ?>><?php echo $meth->htmlprnt($b['nombre']);?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                    <?php   }
                    ?>
                  </fieldset>
                </div>
                <?php   } ?>
              </div> 
              <!-- ROW 8 -->
              <div class="row form-group">
                <div class="col-md-6 col-sm-6">
                  <fieldset>
                    <label class="col-md-4">Grado salarial</label>
                    <div class="col-md-8">
                      <select name="g_sal" class="form-control chosen" >
                        <option value="" style="display:none">--Seleccionar una opción--</option>
                        <?php foreach ($grados as $key => $value) { $grado=new Grado_salarial($value); ?>
                        <option value="<?php echo $grado->grado ?>" <?php if($grado->grado==$dat['salario']) echo "selected" ?>><?php echo $grado->grado ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </fieldset>
                </div>
                <!--
                <div class="col-md-6 col-sm-6">
                  <fieldset>
                    <div class="row form-group">
                      <label class="col-md-5">Notificar cambios de sistema al superior</label>
                      <div class="col-md-7">
                        <input type="checkbox" name="not_sis" value="1" <?php //if ($dat[8]) echo "checked" ?>>
                      </div>
                    </div>
                  </fieldset>
                </div>-->
              </div>
              <div class="row form-group">
                <div class="col-md-6 col-sm-6">
                  <fieldset>
                    <label class="col-md-4">Sueldo</label>
                    <div class="col-md-8">
                      <input id="ThousandSeperator_num" type="hidden"  name="sueldo">
                      <input id="ThousandSeperator_commas" class="form-control" value="<?php $salario = (isset($dat['sueldo'])) ? $dat['sueldo'] : "" ; echo $salario ?>">
                    </div>
                  </fieldset>
                </div>
              </div> 
              <p>&nbsp;</p>
              <div class="row form-group">
                <div class="col-md-2 col-md-offset-10">            
                  <fieldset>
                    <input class="btn btn-default btn-sm" type="submit" name="gpde" value="Guardar">
                  </fieldset>
                </div>
              </div>
            </form>

            <script type="text/javascript">
              $(document).ready(function(){
                $('#ThousandSeperator_commas').val(addCommas($('#ThousandSeperator_commas').val()));

                $("select.chosen").chosen()
              });
            </script>