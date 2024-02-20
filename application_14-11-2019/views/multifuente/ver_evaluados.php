<?php
$meth = new Util();
?>
<div class="row">
  <div class="col-md-12 show-grid">
    <h3 align="center">Administrador</h3>
  </div>
</div>
<p>&nbsp;</p>
<form action="<?php echo BASEURL ?>multifuente/asignar" method="POST">
  <div id="multifuente_holder" class="col-xs-12 col-sm-12">
    <div hidden>
      <input type="text" class="form-control table_name" value="personal" >
    </div>
    <div class="row form-group">
      <label class="col-md-5">Elegir empresa</label> 
      <div hidden>
        <input type="text" class="form-control step" value="1" >
      </div>  
      <div class="col-md-6">
       <select required="required" class="form-control empresa-select" name="selectEmpresa" placeholder="Ingreso de nueva empresa">
        <option>-- Seleccione una empresa --</option>
        <?php   
        foreach ($empresas as $a => $b) {
          $sel = "";
          if(isset($_SESSION['Empresa']['id'])){ 
            if($_SESSION['Empresa']['id'] == $c['id']){
              $sel = "selected";
            }
          }
          $c = $b['Empresa'];
          echo '<option value="'. $c['id'] .
          $sel.
          '" >'.
          Util::htmlprnt($c['nombre']) .
          '</option>';
        }
        ?>    
      </select> 
    </div>
  </div>
  <fieldset>
  </fieldset> 
</div>
</form>
