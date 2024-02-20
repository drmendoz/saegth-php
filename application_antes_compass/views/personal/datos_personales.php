<?php
$meth = new personal();
$meth->select($id);
$gmap = str_replace(")","",str_replace("(", "", $datos['u_gmaps']));
$gmap = explode(',', $gmap);
?>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?libraries=places&sensor=false"></script>
<script type="text/javascript">
  $(document).ready(function(){
     google.maps.event.addDomListener(window, 'load', initialize({'lat':<?php echo $gmap[0] ?>,'lng':<?php echo $gmap[1] ?>}));
  });
</script>
<form action="<?php echo BASEURL ?>personal/datos_personales" method="POST" enctype="multipart/form-data">
  <h4 class="col-md-12 text-center">Datos B&aacute;sicos  <i class="fa fa-user"></i></h4>
  <div class="col-xs-12 col-sm-12">
    <legend>Datos Personales</legend>
    <div class="row form-group">
      <div class="col-md-6">
        <div class="col-md-12">
          <label class="col-sm-4">Tel&eacute;fono convencional</label>
          <div class="col-md-8">
            <input value="<?php if(isset($dat_p['num_con'])) echo $dat_p['num_con']; ?>" type="text" class="form-control" name="pd_num" maxlength="10" required="required" placeholder="Tel&eacute;fono convencional" >
          </div>
        </div>
        <div class="col-md-12">
          <label class="col-sm-4">Tel&eacute;fono celular</label>
          <div class="col-md-8">
            <input value="<?php if(isset($dat_p['num_cel'])) echo $dat_p['num_cel']; ?>" type="text" class="form-control" name="pd_cnum" maxlength="10" required="required" placeholder="Tel&eacute;fono celular" >
          </div>
        </div>  
        <div class="col-md-12">
          <label class="col-sm-4">Foto</label>
          <div class="col-md-8">
            <input accept="image/jpg, image/gif, image/png, image/jpeg" type="file" name="file" id="file" class="input-file">
            <img src="<?php echo BASEURL.'uploads/'.$meth->foto ?>" height="140" class="thumbnail" alt="Perfil">
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <fieldset style="border: 1px solid #ccc">
          <legend>Direcci&oacute;n</legend>
          <label class="col-sm-5">Sector</label>
          <div class="col-md-7">
            <input value="<?php if(isset($dat_p['sector'])) echo $dat_p['sector']; ?>" type="text" class="form-control" name="dir_s" required="required" placeholder="Sector" >
          </div>
          <label class="col-sm-5">Número de calle</label>
          <div class="col-md-7">
            <input value="<?php if(isset($dat_p['pais'])) echo $dat_p['pais']; ?>" type="text" class="form-control" name="dir_p" required="required" placeholder="Calle" >
          </div>
          <label class="col-sm-5">Calle principal</label>
          <div class="col-md-7">
            <input value="<?php if(isset($dat_p['ciudad'])) echo $dat_p['ciudad']; ?>" type="text" class="form-control" name="dir_ec" required="required" placeholder="Calle Principal" >
          </div>
          <label class="col-sm-5">Intersección con/entre</label>
          <div class="col-md-7">
            <input value="<?php if(isset($dat_p['calles'])) echo $dat_p['calles']; ?>" type="text" class="form-control" name="dir_c" required="required" placeholder="Intersecci&oacute;n" >
          </div>
          <label class="col-sm-5">Manzana</label>
          <div class="col-md-7">
            <input value="<?php if(isset($dat_p['manz'])) echo $dat_p['manz']; ?>" type="text" class="form-control" name="dir_mz" required="required" placeholder="Mz." >
          </div>
          <label class="col-sm-5">Villa</label>
          <div class="col-md-7">
            <input value="<?php if(isset($dat_p['villa'])) echo $dat_p['villa']; ?>" type="text" class="form-control" name="dir_v" required="required" placeholder="Villa" >
          </div>
        </fieldset>
      </div>
      <div class="col-md-6"> 


      </div>
    </div>
    <div class="row form-group">

    </div>
  </div>
  <p>&nbsp;</p>
  <div class="row form-group col-xs-12 col-sm-12">
    <legend>Informacion Adicional</legend>
    <div class="row col-md-12 form-group">
      <label class="col-sm-4">Foto de la casa</label>
      <div class="col-md-7 col-md-offset-1">
        <input accept="image/jpg, image/gif, image/png, image/jpeg" type="file" name="file-casa" id="file" class="input-file">
        <img src="<?php echo BASEURL.'uploads/'.$datos['foto'] ?>" height="140" class="thumbnail" alt="Perfil">
      </div>
    </div>
    <div class="row col-md-12">
      <label class="col-sm-4">Contacto de Emergencia</label>
      <div class="col-md-4 col-md-offset-1">
        <input value="<?php if(isset($datos['nombre_vecino'])) echo $datos['nombre_vecino']; ?>" type="text" class="form-control" name="nombre_vecino" required="required" placeholder="Nombre" >
      </div>
      <div class="col-md-4 col-md-offset-5">
        <input value="<?php if(isset($datos['tel_vecino'])) echo $datos['tel_vecino']; ?>" type="text" class="form-control" name="tel_vecino" required="required" placeholder="Tel&eacute;fono" >
      </div>
    </div>
  </div>
  <div class="row form-group col-xs-12 col-sm-12">
    <div class="row form-group col-md-8">
      <div class="col-md-12">
        <input id="pac-input" class="controls" type="text" placeholder="Search Box">
        <div id="map-canvas"></div>
      </div>
    </div>
    <div class="col-md-4">
      <label class="row col-sm-12">Ubicaci&oacute;n Googlemaps</label>
      <div class="row col-md-12">
        <input value="<?php if(isset($datos['u_gmaps'])) echo $datos['u_gmaps']; ?>" type="text" class="form-control" id="u_googlemaps" readonly="readonly" name="u_gm" required="required" placeholder="Ubicacion Googlemaps" >
      </div>
    </div>
  </div>
  <p>&nbsp;</p>
  <?php 
  $pdf = new Personal_datos_familiar(); 
  $hasFamily = $pdf->select($id);
  $estado_civil = '666';
  if($hasFamily)
    $estado_civil=$pdf->getEstado_civil();
  ?>
  <div class="col-xs-12 col-sm-12">
    <div class="row form-group">
      <div class="col-xs-6 col-sm-6">
        <legend>Estado Civil</legend>
        <fieldset>
          <label class="col-md-5">Estado Civil</label>  
          <div class="col-md-6">
            <select id="estado_civil" name="estado_civil" class="form-control">
              <option style="display:none">-- Seleccionar una opci&oacute;n --</option>
              <option value="1" <?php if($estado_civil=='1') echo "selected";?> >Soltero</option>
              <option value="2" <?php if($estado_civil=='2') echo "selected";?> >Casado</option>                                        
              <option value="3" <?php if($estado_civil=='3') echo "selected";?> >Viudo</option>
              <option value="4" <?php if($estado_civil=='4') echo "selected";?> >Divorciado</option>
              <option value="5" <?php if($estado_civil=='5') echo "selected";?> >Union Libre</option>
            </select>
          </div>
        </fieldset>
      </div> 
      <div id="datos_conyugue" <?php if($estado_civil!="2") echo 'hidden' ?> class="col-xs-6 col-sm-6">
        <legend>Datos del Conyugue</legend>
        <fieldset>
          <div class="form-group">
            <label class="col-md-5">Nombre C&oacute;nyuge</label>
            <div class="input-group col-md-6">
              <input type="text" class="form-control" name="n_cony" placeholder="Nombre"  value="<?php if($pdf->getN_conyugue()) echo $pdf->getN_conyugue() ?>">
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-5">Fecha de Nacimiento</label>
            <div class="col-md-6">
              <input type="date" class="form-control" name="fn_cony" placeholder="Fecha de nacimiento" value="<?php if($pdf->getFn_conyugue()) echo $pdf->getFn_conyugue() ?>">
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-5">Fecha Matrimonio</label>
            <div class="col-md-6">
              <input type="date" class="form-control" name="fmat" placeholder="Fecha de matrimonio" value="<?php if($pdf->getF_matrimonio()) echo $pdf->getF_matrimonio() ?>">
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
            <input type="checkbox" name="b_hijos" id="b_hijos" value="true" <?php if($pdf->getT_hijos()) echo 'checked="checked"' ?>>
          </div>
        </fieldset>
      </div> 
      <?php 
      $hasChildren = true;
      if($pdf->getT_hijos()==0)
        $hasChildren = false;
      ?>
      <div id="hijos" <?php if(!$hasChildren) echo 'hidden' ?> class="col-xs-6 col-sm-6">
        <?php
        if($hasChildren){
          $pdh = new Personal_datos_hijos();
          $dh = $pdh->select_all($id);
        }
        ?>
        <legend>Datos de hijos</legend>
        <table id="dataTable" class="table">
          <thead>
            <th>#</th>
            <th>Nombre</th>
            <th>Fecha de nacimiento</th>
          </thead>    
          <tbody>
            <?php
            foreach ($dh as $key => $value) {
              $pdh->select($value['id']);
              ?>
              <tr>
                <p>
                  <td>
                    <input type="checkbox" required="required" value="<?php echo $pdh->getId() ?>" name="h_chk[]" checked="checked" />
                  </td>
                  <td>
                    <input type="text" class="form-control" class="small"  value="<?php echo $pdh->getNombre_hijo() ?>" name="h_nombre[]">
                  </td>
                  <td>
                    <input type="date" class="form-control" class="small"  value="<?php echo $pdh->getFecha_nacimiento() ?>" name="h_fn[]">
                  </td>
                </p>
              </tr>
              <?php
            }
            if(!$dh){
              ?>
              <tr>
                <p>
                  <td>
                    <input type="checkbox" required="required" name="h_chk[]" checked="checked" />
                  </td>
                  <td>
                    <input type="text" class="form-control" class="small"  name="h_nombre[]">
                  </td>
                  <td>
                    <input type="date" class="form-control" class="small"  name="h_fn[]">
                  </td>
                </p>
              </tr>
              <?php
            }
            ?>
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
  <div class="col-xs-12 col-sm-12">
    <legend>Educaci&oacute;n Formal</legend>
    <table id="informal" class="table">
      <thead>
        <th>#</th>
        <th>T&iacute;tulo</th>
        <th>&Aacute;rea de Estudio</th>
        <th>Carrera</th>
        <th>Instituci&oacute;n</th>
        <th>Pa&iacute;s</th>
        <th>Ciudad</th>
        <th>Fecha</th>
      </thead>    
      <tbody>
        <?php if(null != array_filter($ed_for)){
          $num_rows=sizeof($ed_for);
          $rrr = true;
        }else{
          $num_rows=1;
          $rrr = false;
        } for ($i=0; $i < $num_rows; $i++) { if($rrr){$fields=$ed_for[$i];$fields=reset($fields);} //var_dump($fields)?>
        <tr>
          <p>
            <td>
              <a tabIndex="-1" onclick="_deleteRow('informal',this)"  style="color:red"><i class="fa fa-times"></i></a>
              <div hidden><input type="checkbox" name="chk[]" checked="checked" /></div>
            </td>
            <td>
              <input type="text" class="form-control" value="<?php if(isset($fields['titulo'])) echo $meth->htmlprnt($fields['titulo']) ?>" class="small"  placeholder="T&iacute;tulo" name="titulo[]">
            </td>
            <td>
              <input type="text" class="form-control" value="<?php if(isset($fields['area_estudio'])) echo $meth->htmlprnt($fields['area_estudio']) ?>" class="small"  placeholder="&Aacute;rea de Estudio" name="a_est[]">
            </td>
            <td>
              <input type="text" class="form-control" value="<?php if(isset($fields['carrera'])) echo $meth->htmlprnt($fields['carrera']) ?>" class="small"  placeholder="Carrera" name="carr[]">
            </td>
            <td>
              <input type="text" class="form-control" value="<?php if(isset($fields['institucion'])) echo $meth->htmlprnt($fields['institucion']) ?>" class="small"  placeholder="Instituci&oacute;n" name="inst[]">
            </td>
            <td>
              <input type="text" class="form-control" value="<?php if(isset($fields['pais'])) echo $meth->htmlprnt($fields['pais']) ?>" class="small"  placeholder="Pa&iacute;s" name="pais[]">
            </td>
            <td>
              <input type="text" class="form-control" value="<?php if(isset($fields['ciudad'])) echo $meth->htmlprnt($fields['ciudad']) ?>" class="small"  placeholder="Ciudad" name="ciud[]">
            </td>
            <td>
              <input type="date" class="form-control" value="<?php if(isset($fields['fecha'])) echo $fields['fecha'] ?>" class="small"  placeholder="Fecha" name="fecha[]">
            </td>
          </p>
        </tr>
        <?php } $fields = null;?>
      </tbody>
    </table>

    <div class="col-md-12 show-grid" > 
      <input type="button" class="btn btn-default btn-sm" value="Agregar" onClick="addRow('informal',false)" />  
    </div>  
  </div>
  <div class="col-xs-12 col-sm-12">
    <legend>Cursos</legend>
    <table id="dataTable1" class="table">
      <thead>
        <th>#</th>
        <th>T&iacute;tulo</th>
        <th>&Aacute;rea de Estudio</th>
        <th>Horas</th>
        <th>Instituci&oacute;n</th>
        <th>Pa&iacute;s</th>
        <th>Ciudad</th>
        <th>Fecha</th>
      </thead>    
      <tbody>
        <?php if(null != array_filter($per_c)){
          $num_rows=sizeof($per_c);
          $rrr = true;
        }else{
          $num_rows=1;
          $rrr = false;
        } for ($i=0; $i < $num_rows; $i++) { if($rrr){$fields=$per_c[$i];$fields=reset($fields);} //var_dump($fields)?>
        <tr>
          <p>
            <td>
              <a tabIndex="-1" onclick="_deleteRow('dataTable1',this)"  style="color:red"><i class="fa fa-times"></i></a>
              <div hidden><input type="checkbox" name="chk[]" checked="checked" /></div>
            </td>
            <td>
              <input type="text" class="form-control" value="<?php if(isset($fields['titulo'])) echo $meth->htmlprnt($fields['titulo']) ?>" class="small"  placeholder="T&iacute;tulo" name="c_titulo[]">
            </td>
            <td>
              <input type="text" class="form-control" value="<?php if(isset($fields['area_estudio'])) echo $meth->htmlprnt($fields['area_estudio']) ?>" class="small"  placeholder="&Aacute;rea de Estudio" name="c_area[]">
            </td>
            <td>
              <input type="text" class="form-control" value="<?php if(isset($fields['horas'])) echo $fields['horas'] ?>" class="small"  placeholder="Horas" name="c_horas[]">
            </td>
            <td>
              <input type="text" class="form-control" value="<?php if(isset($fields['institucion'])) echo $meth->htmlprnt($fields['institucion']) ?>" class="small"  placeholder="Instituci&oacute;n" name="c_inst[]">
            </td>
            <td>
              <input type="text" class="form-control" value="<?php if(isset($fields['pais'])) echo $meth->htmlprnt($fields['pais']) ?>" class="small"  placeholder="Pa&iacute;s" name="c_pais[]">
            </td>
            <td>
              <input type="text" class="form-control" value="<?php if(isset($fields['ciudad'])) echo $meth->htmlprnt($fields['ciudad']) ?>" class="small"  placeholder="Ciudad" name="c_ciud[]">
            </td>
            <td>
              <input type="date" class="form-control" value="<?php if(isset($fields['fecha'])) echo $fields['fecha'] ?>" class="small"  placeholder="Fecha" name="c_fecha[]">
            </td>
          </p>
        </tr>
        <?php } $fields = null;?>
      </tbody>
    </table>

    <div class="col-md-12 show-grid" > 
      <input type="button" class="btn btn-default btn-sm" value="Agregar" onClick="addRow('dataTable1',false)" />  
    </div>  
  </div>
  <div class="col-xs-12 col-sm-12">
    <legend>Cursos Internos</legend>
    <table id="dataTable3" class="table">
      <thead>
        <th>#</th>
        <th>T&iacute;tulo</th>
        <th>&Aacute;rea de Estudio</th>
        <th>Horas</th>
        <th>Fecha</th>
        <th>Pa&iacute;s</th>
        <th>Ciudad</th>
      </thead>    
      <tbody>
        <?php if(null != array_filter($per_i)){
          $num_rows=sizeof($per_i);
          $rrr = true;
        }else{
          $num_rows=1;
          $rrr = false;
        } for ($i=0; $i < $num_rows; $i++) { if($rrr){$fields=$per_i[$i];$fields=reset($fields);} //var_dump($fields)?>
        <tr>
          <p>
            <td>
              <a tabIndex="-1" onclick="_deleteRow('dataTable3',this)"  style="color:red"><i class="fa fa-times"></i></a>
              <div hidden><input type="checkbox" name="chk[]" checked="checked" /></div>
            </td>
            <td>
              <input type="text" value="<?php if(isset($fields['titulo'])) echo $meth->htmlprnt($fields['titulo']) ?>" class="form-control" class="small"  placeholder="T&iacute;tulo" name="c_titulo_int[]">
            </td>
            <td>
              <input type="text" value="<?php if(isset($fields['area_estudio'])) echo $meth->htmlprnt($fields['area_estudio']) ?>" class="form-control" class="small"  placeholder="&Aacute;rea de Estudio" name="c_area_int[]">
            </td>
            <td>
              <input type="text" value="<?php if(isset($fields['horas'])) echo $fields['horas'] ?>" class="form-control" class="small"  placeholder="Horas" name="c_horas_int[]">
            </td>
            <td>
              <input type="date" value="<?php if(isset($fields['fecha'])) echo $fields['fecha'] ?>" class="form-control" class="small"  placeholder="Fecha" name="c_fecha_int[]">
            </td>
            <td>
              <input type="text" value="<?php if(isset($fields['pais'])) echo $meth->htmlprnt($fields['pais']) ?>" class="form-control" class="small"  placeholder="Pa&iacute;s" name="c_pais_int[]">
            </td>
            <td>
              <input type="text" value="<?php if(isset($fields['ciudad'])) echo $meth->htmlprnt($fields['ciudad']) ?>" class="form-control" class="small"  placeholder="Ciudad" name="c_ciud_int[]">
            </td>
          </p>
        </tr>
        <?php } ?>
      </tbody>
    </table>
    <div class="col-md-12 show-grid" > 
      <input type="button" class="btn btn-default btn-sm" value="Agregar" onClick="addRow('dataTable3',false)" />  
    </div>  
  </div>
  <div class="col-xs-12 col-sm-12">
    <legend>Historia Laboral</legend>
    <table id="dataTable2" class="table">
      <thead>
        <th>#</th>
        <th>Cargo</th>
        <th>Empresa</th>
        <th>Fecha Inicial</th>
        <th>Fecha Final</th>
      </thead>    
      <tbody>
        <?php if(null != array_filter($per_h)){
          $num_rows=sizeof($per_h);
          $rrr = true;
        }else{
          $num_rows=1;
          $rrr = false;
        } for ($i=0; $i < $num_rows; $i++) { if($rrr){$fields=$per_h[$i];$fields=reset($fields);} //var_dump($fields)?>
        <tr>
          <td>
            <a tabIndex="-1" onclick="_deleteRow('dataTable2',this)"  style="color:red"><i class="fa fa-times"></i></a>
            <div hidden><input type="checkbox" name="chk[]" checked="checked" /></div>
          </td>
          <td>
            <input type="text" value="<?php if(isset($fields['cargo'])) echo $meth->htmlprnt($fields['cargo']) ?>" class="form-control" class="small"  placeholder="Cargo" name="hl_cargo[]">
          </td>
          <td>
            <input type="text" value="<?php if(isset($fields['empresa'])) echo $meth->htmlprnt($fields['empresa']) ?>" class="form-control" class="small"  placeholder="Empresa" name="hl_emp[]">
          </td>
          <td>
            <input type="date" value="<?php if(isset($fields['f_inicio'])) echo date('Y-m-d',strtotime($fields["f_inicio"]));?>" class="form-control" class="small"  placeholder="Fecha Inicial" name="hl_fini[]">
          </td>
          <td>
            <input type="date" value="<?php if(isset($fields['f_fin'])) echo date('Y-m-d',strtotime($fields["f_fin"]));?>" class="form-control" class="small"  placeholder="Fecha Final" name="hl_ffin[]">
          </td>          
        </tr>
        <?php } ?>
      </tbody>
    </table>
    <div class="col-md-12 show-grid" > 
      <input type="button" class="btn btn-default btn-sm" value="Agregar" onClick="addRow('dataTable2',false)" />  
    </div>  
  </div>
  <div class="col-xs-12 col-sm-12">
    <legend>Idiomas</legend>
    <table id="dataTablei" class="table">
      <thead>
        <tr>
          <th>#</th>
          <th>Idioma</th>
          <th>Institución</th>
          <th>Entiende</th>
          <th>Escrito</th>
          <th>Oral</th>
          <th>Lectura</th>
          <th>Fecha desde</th>
          <th>Fecha hasta</th>
        </tr>
      </thead>    
      <tbody>
        <?php if(null != array_filter($per_id)){
          $num_rows=sizeof($per_id);
          $rrr = true;
        }else{
          $num_rows=1;
          $rrr = false;
        } for ($i=0; $i < $num_rows; $i++) { if($rrr){$fields=$per_id[$i];$fields=reset($fields);} //var_dump($fields)?>
        <tr>
          <td>
            <a tabIndex="-1" onclick="_deleteRow('dataTablei',this)"  style="color:red"><i class="fa fa-times"></i></a>
            <div hidden><input type="checkbox" name="chk[]" checked="checked" /></div>
          </td>
          <td>
            <input type="text" value="<?php if(isset($fields['idioma'])) echo $meth->htmlprnt($fields['idioma']) ?>" class="form-control" class="small"  placeholder="Idioma" name="pi_idioma[]">
          </td>
          <td>
            <input type="text" value="<?php if(isset($fields['institucion'])) echo $meth->htmlprnt($fields['institucion']) ?>"class="form-control" class="small"  placeholder="Institucion" name="pi_inst[]">
          </td>
          <td>
            <select name="pi_entendimiento" class="form-control">
              <!-- entendimiento -->
              <option value="" style="display: none">Seleccione una opcion</option> 
              <option <?php if(isset($fields['entendimiento'])){if($fields['entendimiento'] == 0){echo "selected";}}  ?> value="0">Muy básico</option>
              <option <?php if(isset($fields['entendimiento'])){if($fields['entendimiento'] == 1){echo "selected";}}  ?> value="1">Básico</option>
              <option <?php if(isset($fields['entendimiento'])){if($fields['entendimiento'] == 2){echo "selected";}}  ?> value="2">Intermedio</option>
              <option <?php if(isset($fields['entendimiento'])){if($fields['entendimiento'] == 3){echo "selected";}}  ?> value="3">Avanzado</option>
              <option <?php if(isset($fields['entendimiento'])){if($fields['entendimiento'] == 4){echo "selected";}}  ?> value="4">Nativo</option>
            </select>
          </td>
          <td>
          <select name="pi_escrito" class="form-control">
            <!-- escrito -->
              <option value="" style="display: none">Seleccione una opcion</option> 
              <option <?php if(isset($fields['escrito'])){if($fields['escrito'] == 0){echo "selected";}}  ?> value="0">Muy básico</option>
              <option <?php if(isset($fields['escrito'])){if($fields['escrito'] == 1){echo "selected";}}  ?> value="1">Básico</option>
              <option <?php if(isset($fields['escrito'])){if($fields['escrito'] == 2){echo "selected";}}  ?> value="2">Intermedio</option>
              <option <?php if(isset($fields['escrito'])){if($fields['escrito'] == 3){echo "selected";}}  ?> value="3">Avanzado</option>
              <option <?php if(isset($fields['escrito'])){if($fields['escrito'] == 4){echo "selected";}}  ?> value="4">Nativo</option>
            </select>
          </td>
          <td>
          <select name="pi_hablado" class="form-control">
            <!-- hablado -->
              <option value="" style="display: none">Seleccione una opcion</option> 
              <option <?php if(isset($fields['hablado'])){if($fields['hablado'] == 0){echo "selected";}}  ?> value="0">Muy básico</option>
              <option <?php if(isset($fields['hablado'])){if($fields['hablado'] == 1){echo "selected";}}  ?> value="1">Básico</option>
              <option <?php if(isset($fields['hablado'])){if($fields['hablado'] == 2){echo "selected";}}  ?> value="2">Intermedio</option>
              <option <?php if(isset($fields['hablado'])){if($fields['hablado'] == 3){echo "selected";}}  ?> value="3">Avanzado</option>
              <option <?php if(isset($fields['hablado'])){if($fields['hablado'] == 4){echo "selected";}}  ?> value="4">Nativo</option>
            </select>
          </td>
          <td>
            <select name="pi_leido" class="form-control">
              <!-- leido -->
              <option value="" style="display: none">Seleccione una opcion</option> 
              <option <?php if(isset($fields['leido'])){if($fields['leido'] == 0){echo "selected";}}  ?> value="0">Muy básico</option>
              <option <?php if(isset($fields['leido'])){if($fields['leido'] == 1){echo "selected";}}  ?> value="1">Básico</option>
              <option <?php if(isset($fields['leido'])){if($fields['leido'] == 2){echo "selected";}}  ?> value="2">Intermedio</option>
              <option <?php if(isset($fields['leido'])){if($fields['leido'] == 3){echo "selected";}}  ?> value="3">Avanzado</option>
              <option <?php if(isset($fields['leido'])){if($fields['leido'] == 4){echo "selected";}}  ?> value="4">Nativo</option>
            </select>
          </td>
          <td>
            <input type="date" value="<?php if(isset($fields['fecha_desde'])) echo date('Y-m-d',strtotime($fields["fecha_desde"]));?>" class="form-control" class="small"  placeholder="Fecha Inicial" name="pi_fdes[]">
          </td>
          <td>
            <input type="date" value="<?php if(isset($fields['fecha_hasta'])) echo date('Y-m-d',strtotime($fields["fecha_hasta"]));?>" class="form-control" class="small"  placeholder="Fecha Final" name="pi_fhas[]">
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
    <div class="col-md-12 show-grid" > 
      <input type="button" class="btn btn-default btn-sm" value="Agregar" onClick="addRow('dataTablei',false)" />  
    </div>  
  </div>
  <div class="col-xs-12 col-sm-12">
    <legend>Premios</legend>
    <table id="dataTablei2" class="table">
      <thead>
        <tr>
          <th>#</th>
          <th>Premio</th>
          <th>Institución que otorga</th>
          <th>Item</th>
          <th>Fecha</th>
        </tr>
      </thead>    
      <tbody>
        <?php 
        unset($fields);
        if(null != array_filter($per_prem)){
          $num_rows=sizeof($per_prem);
          $rrr = true;
        }else{
          $num_rows=1;
          $rrr = false;
        } for ($i=0; $i < $num_rows; $i++) { if($rrr){$fields=$per_prem[$i];$fields=reset($fields);} //var_dump($fields)?>
        <tr>
          <td>
            <a tabIndex="-1" onclick="_deleteRow('dataTablei2',this)"  style="color:red"><i class="fa fa-times"></i></a>
            <div hidden><input type="checkbox" name="chk[]" checked="checked" /></div>
          </td>
          <td>
            <input type="text" value="<?php if(isset($fields['premio'])) echo $meth->htmlprnt($fields['premio']) ?>" class="form-control" class="small"  placeholder="Premio" name="prem_premio[]">
          </td>
          <td>
            <input type="text" value="<?php if(isset($fields['institucion'])) echo $meth->htmlprnt($fields['institucion']) ?>"class="form-control" class="small"  placeholder="Institucion" name="prem_inst[]">
          </td>
          <td>
            <select name="prem_item[]" class="form-control">
              <option value="-1" style="display: none">Seleccionar opción</option>
              <option <?php if(isset($fields['item'])) if($fields['item'] == "Medalla") echo "selected" ?> value="Medalla">Medalla</option>
              <option <?php if(isset($fields['item'])) if($fields['item'] == "Certificado") echo "selected" ?> value="Certificado">Certificado</option>
              <option <?php if(isset($fields['item'])) if($fields['item'] == "Beca") echo "selected" ?> value="Beca">Beca</option>
              <option <?php if(isset($fields['item'])) if($fields['item'] == "Placa") echo "selected" ?> value="Placa">Placa</option>
              <option <?php if(isset($fields['item'])) if($fields['item'] == "Bono") echo "selected" ?> value="Bono">Bono</option>
            </select>
          </td>
          <td>
            <input type="date" value="<?php if(isset($fields['fecha'])) echo date('Y-m-d',strtotime($fields["fecha"]));?>" class="form-control" class="small"  placeholder="Fecha de entrega" name="prem_f[]">
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
    <div class="col-md-12 show-grid" > 
      <input type="button" class="btn btn-default btn-sm" value="Agregar" onClick="addRow('dataTablei2',false)" />  
    </div>  
  </div>
  <div class="row form-group">
    <div class="col-md-2 col-md-offset-10">            
      <input class="btn btn-default btn-sm" type="submit" name="personal_datos" value="Guardar">
    </div>
  </div>
</form>
<script type="text/javascript">
  $('#estado_civil').change(function(event) {
    if ($(this).val() == 2) {
      $('#datos_conyugue').slideDown("slow");
      $('#datos_conyugue').find('input').attr("required", true);
      event.stopPropagation();
    } else {
      $('#datos_conyugue').slideUp("slow");
      $('#datos_conyugue').find('input').attr("required", false);
    }
  });
</script>