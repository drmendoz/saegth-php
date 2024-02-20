<?php
$meth = new Empresa_area();
$f=array();
// $id = $_SESSION['Empresa']['id'];
?>
<script type="text/javascript">
  $(document).ready(function(){
    setTimeout(function(){ 
      ini_ub();
      $('h4').addClass('txt-info');
     }, 3000);
  });
</script>
<div class="col-md-12">
  <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6 form-group">
    <?php echo $img ?>
  </div>
  <div class="col-lg-3 col-md-4 col-sm-3 col-xs-6 form-group">
    <h3><b><?php echo $meth->htmlprnt($name) ?></b></h3>
    <h5><?php echo $meth->htmlprnt($cargo); ?></h5>
    <?php   if($gmap){ ?>
    <p><div id="localidad"></div></p>
    <?php   } ?>
    <h5>Subdivisiones organizacionales</h5>
    <?php 
    if (isset($id_area)) { 
      echo $meth->select_all_parents($id_area,"string"); 
    } 
    ?>
    <?php   if(isset($carrera)){ ?>
    <small color="grey">Formación Academica: </small>
    <small>
      <?php echo $meth->htmlprnt($carrera); ?>
    </small>
    <?php   }else ?>
    &nbsp;   
  </div>
  <div class="col-lg-7 col-md-6 col-sm-6 col-xs-12 form-group">
    <?php  $tmp = array_filter($d_emp);
    if(!empty($tmp)) {?>
    <h4 class="page-header txt-info">Datos Organizacionales</h4>
    <div class="row">
      <fieldset class="col-xs-6" style="padding: 10px;">
       <div class="row">
        <label class="col-xs-6">Cedula:</label>
        <div class="col-xs-6">
          <?php echo $d_per->get_cedula(); ?>
        </div>
      </div>
      <div class="row">
        <label class="col-xs-6">E-mail:</label>
        <div class="col-xs-6">
          <?php echo $d_per->get_email(); ?>
        </div>
      </div>
      <?php   if(isset($local)){ ?>
      <div class="row">
        <label class="col-xs-6">Localidad:</label>
        <div class="col-xs-6">
          <?php echo $meth->htmlprnt($local); ?>
        </div>
      </div>
      <?php   } ?>
      <?php   if(isset($cargo)){ ?>
      <div class="row">
        <label class="col-xs-6">Cargo:</label>
        <div class="col-xs-6">
          <?php echo $meth->htmlprnt($cargo); ?>
        </div>
      </div>
      <?php   } ?>
      <?php   if(isset($area)){ ?>
      <div class="row">
        <label class="col-xs-6">&Aacute;rea:</label>
        <div class="col-xs-6">
          <?php echo $meth->htmlprnt($area); ?>
        </div>
      </div>
      <?php   } ?>
      <?php   if(isset($g_sal)){ ?>
      <div class="row">
        <label class="col-xs-6">Grado salarial:</label>
        <div class="col-xs-6">
          <?php echo $g_sal; ?>
        </div>
      </div>
      <?php   } ?>
    </fieldset>
    <fieldset class="col-xs-6" style="padding: 10px;">
      <?php   if(isset($tcont)){ ?>
      <div class="row">
        <label class="col-xs-6">Tipo de Contrato:</label>
        <div class="col-xs-6">
          <?php echo $meth->htmlprnt($tcont); ?>
        </div>
      </div>
      <?php   } ?>
      <?php   
      if($cond){
      foreach ($cond as $a => $b) { 
        $id_sup = $meth->SelectColFrom('id_superior','empresa_cond','id',$b);
        $nombre = $meth->SelectColFrom('nombre','empresa_cond','id',$b);

        $nombre_sup = $meth->SelectColFrom('nombre','empresa_cond','id',@reset(reset(reset($id_sup)))); ?>
        <div class="row">
          <label class="col-xs-6"><?php echo $meth->htmlprnt(@reset(reset(reset($nombre_sup)))) ?>:</label>
          <div class="col-xs-6">
            <?php echo $meth->htmlprnt(@reset(reset(reset($nombre)))); ?>
          </div>
        </div>
        <?php   } } ?>
        <?php   if($d_per->fecha_ing!=""){ ?>
        <div class="row">
          <label class="col-xs-6">Fecha de ingreso:</label>
          <div class="col-xs-6">
            <?php echo $d_per->get_fecha_ing(); ?>
          </div>
        </div>
        <?php   } ?>
      </fieldset>
      <fieldset class="col-xs-12" style="padding:10px">

        <?php   if(isset($pid_nombre)){ ?>
        <div class="row">
          <label class="col-xs-3">Superior nombre:</label>
          <div class="col-xs-6">
            <?php echo $meth->htmlprnt($pid_nombre); ?>
          </div>
        </div>
        <?php   } ?>
        <?php   if(isset($pid_cargo)){ ?>
        <div class="row">
          <label class="col-xs-3">Superior cargo:</label>
          <div class="col-xs-6">
            <?php echo $meth->htmlprnt($pid_cargo); ?>
          </div>
        </div>
        <?php   } ?>
      </fieldset>
    </div>
    <div class="row">
      <?php if($_SESSION['USER-AD']['user_rol'] == 1){ ?>
      <h4><a href="<?php echo BASEURL ?>personal/editar_datos_empresa/<?php echo $id ?>">Editar información de la empresa</a></h4>
      <?php } ?>
    </div>
    <?php } ?>  
  </div>
  <div class="clearfix"></div>
</div>
<p>&nbsp;</p>
<?php if($d_per->get_pais()!="") { ?>
<h4 class="page-header txt-info">Datos Personales</h4>
<fieldset class="col-md-6 col-lg-4" style="padding: 10px;">
  <div class="row">
    <label class="col-xs-6">N&uacute;mero Convencional:</label>
    <div class="col-xs-6">
      <?php echo $d_per->get_num_con(); ?>
    </div>
  </div>
  <div class="row">
    <label class="col-xs-6">N&uacute;mero Celular:</label>
    <div class="col-xs-6">
      <?php echo $d_per->get_num_cel(); ?>
    </div>
  </div>

  <div class="row">
    <label class="col-xs-6">Fecha de nacimiento:</label>
    <div class="col-xs-6">
      <?php echo $d_per->get_fecha_nac(); ?>
    </div>
  </div>
</fieldset>
<fieldset class="col-md-6 col-lg-4" style="padding: 10px;">
  <?php  $tmp = array_filter($d_civ);
  if(!empty($tmp)) { ?>
  <?php   if(isset($ecv)){ ?>
  <div class="row">
    <label class="col-xs-6">Estado Civil:</label>
    <div class="col-xs-6">
      <?php echo $ecv; ?>
    </div>
  </div>
  <?php   } ?>
  <?php   if(!empty($n_cony)){ ?>
  <div class="row">
    <label class="col-xs-6">Nombre del cónyuge:</label>
    <div class="col-xs-6">
      <?php echo $meth->htmlprnt($n_cony); ?>
    </div>
  </div>
  <?php   } ?>
  <?php   if(!empty($f_nac_con)){ ?>
  <div class="row">
    <label class="col-xs-6">Nacimiento del cónyuge:</label>
    <div class="col-xs-6">
      <?php echo $meth->print_fecha($f_nac_con); ?>
    </div>
  </div>
  <?php   } ?>
  <?php   if(!empty($f_mat)){ ?>
  <div class="row">
    <label class="col-xs-6">Fecha de matrimonio:</label>
    <div class="col-xs-6">
      <?php echo $meth->print_fecha($f_mat); ?>
    </div>
  </div>
  <?php   } ?>      
  <?php } else {array_push($f,"<a href='".BASEURL."personal/datos_familiar'>Estado Civil<a>"); } ?>    

</fieldset>
<fieldset class="col-md-6 col-lg-4" style="padding: 10px;">
  <?php if($hij){ $a=0;?>
  <legend class="txt-success">Hijos</legend>
  <?php   foreach ($d_hij as $a => $b) { 
    $b = @reset($b);  ?>
    <?php   if($a){ ?> 
    <div class="row">
      <div class="col-xs-12 text-center">
        <legend> </legend>
      </div>
    </div>                            
    <?php   } ?>
    <div class="row">
      <label class="col-xs-6">Nombre:</label>
      <div class="col-xs-6">
        <?php echo $meth->htmlprnt(@reset($b)); ?>
      </div>
    </div>
    <div class="row">
      <label class="col-xs-6">Fecha de nacimiento:</label>
      <div class="col-xs-6">
        <?php echo @next($b);?>
      </div>
    </div>
    <?php   } ?>      
    <?php } ?>       
  </fieldset>
  <?php } else { array_push($f,"<a href='".BASEURL."personal/datos'>Datos Personales<a>"); } ?>    
  <div class="clearfix"></div>
  <?php   if($d_per->get_pais()!=""){ ?>
  <h4 class="page-header txt-info">Dirección domiciliaria</h4>
  <div class="row form-group">
    <div class="col-md-12">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <?php if($gmap){ ?>
            <th>País</th>
            <th>Ciudad</th>
            <?php } ?>
            <th>Número de calle</th>
            <th>Calle principal</th>
            <th>Sector</th>
            <th>Entre las calles</th>
            <th>Manzana</th>
            <th>Villa</th>
            <?php if($gmap){ ?>
            <th>Nombre de Contacto de Emergencia</th>
            <th>Teléfono de Contacto de Emergencia</th>
            <?php } ?>
          </tr>
        </thead>
        <tbody>
          <tr>
            <?php if($gmap){ ?>
            <td><div id="pais">País</div></td>
            <td><div id="ciudad">Ciudad</div></td>
            <?php } ?>
            <td><?php echo $d_per->get_pais(); ?></td>
            <td><?php echo $d_per->get_ciudad(); ?></td>
            <td><?php echo $d_per->get_sector(); ?></td>
            <td><?php echo $d_per->get_calles(); ?></td>
            <td><?php echo $d_per->get_manz(); ?></td>
            <td><?php echo $d_per->get_villa(); ?></td>
            <?php if($gmap){ ?>
            <td><?php echo $meth->htmlprnt($gmap['nombre_vecino']); ?></td>
            <td><?php echo $gmap['tel_vecino']; ?></td>
            <?php } ?>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <!-- MAP -->
  <?php   if(isset($gmap) && $gmap!=""){ ?>
  <div class="row form-group">
    <div class="col-md-6"><?php if($gmap){ 
     $gmap = $gmap['u_gmaps'];?>
     <div class="col-xs-12">
       <div class="row">
         <label class="col-md-12 text-center">Ubicación en google maps:</label>
       </div>
       <fieldset>
         <div hidden><input id="longlat" type="text" value="<?php echo str_replace(")","",str_replace("(", "", $gmap)); ?>"></div>
         <div id="map-canvas"></div>
       </fieldset>
     </div>
     <?php } ?></div> 
     <fieldset  class="col-md-6">
      <div class="row">
        <label class="col-md-12 text-center">Fotografía de la casa:</label>
      </div>
      <div class="row">
        <div class="col-xs-6 col-xs-offset-3">
          <?php echo $img_casa; ?>
        </div>
      </div>
      <?php   } ?>
    </fieldset>
  </div>
  <?php }else{array_push($f,"<a href='".BASEURL."personal/datos'>Datos Personales<a>");} ?>    



  <?php $tmp = array_filter($ed_for); 
  if(!empty($tmp)){ ?>
  <h4 class="page-header txt-info">Formación Académica</h4>
  <div class="row form-group">

    <div class="col-md-12">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th class="col-md-3">Título</th>
            <th hidden style="display:none" class="col-md-3">Carrera</th>
            <th>&Aacute;rea de estudio</th>
            <th>Institución</th>
            <th>País</th>
            <th>Ciudad</th>
            <th>Fecha</th>
          </tr>
        </thead>
        <tbody>
          <?php   foreach ($ed_for as $a => $b) { $obj = new Personal_ed_formal($b); ?>
          <tr>
            <td><?php echo $obj->get_titulo(); ?></td>
            <td hidden><?php echo $obj->get_carrera(); ?></td>
            <td><?php echo $obj->get_area_estudio(); ?></td>
            <td><?php echo $obj->get_institucion(); ?></td>
            <td><?php echo $obj->get_pais(); ?></td>
            <td><?php echo $obj->get_ciudad(); ?></td>
            <td><?php echo $obj->get_fecha(); ?></td>
          </tr>
          <?php   } ?>     
        </tbody>
      </table>
    </div>
  </div>
  <?php }?>

  <?php $tmp = array_filter($cur); 
  if(!empty($tmp)){ ?>
  <h4 class="page-header txt-info">Cursos Realizados</h4>
  <div class="row form-group">
    <div class="col-md-12">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th class="col-md-3">Título</th>
            <th class="col-md-3">&Aacute;rea de estudio</th>
            <th>Institución</th>
            <th>País</th>
            <th>Ciudad</th>
            <th>No. de horas</th>
            <th>Fecha</th>
          </tr>
        </thead>
        <tbody>
          <?php   foreach ($cur as $a => $b) { $obj = new Personal_cursos($b); ?>
          <tr>
            <td><?php echo $obj->get_titulo(); ?></td>
            <td><?php echo $obj->get_area_estudio(); ?></td>
            <td><?php echo $obj->get_institucion(); ?></td>
            <td><?php echo $obj->get_pais(); ?></td>
            <td><?php echo $obj->get_ciudad(); ?></td>
            <td><?php echo $obj->get_horas(); ?></td>
            <td><?php echo $obj->get_fecha(); ?></td>
          </tr>
          <?php   } ?>     
        </tbody>
      </table>
    </div>  
  </div>
  <?php } ?>           


  <?php $tmp =array_filter($cur_int); 
  if(!empty($tmp)){ ?>
  <h4 class="page-header txt-info">Cursos Internos</h4>
  <div class="row form-group">
    <div class="col-md-12">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th class="col-md-3">Título</th>
            <th class="col-md-3">&Aacute;rea de estudio</th>
            <th>País</th>
            <th>Ciudad</th>
            <th>No. de horas</th>
            <th>Fecha</th>
          </tr>
        </thead>
        <tbody>
          <?php   foreach ($cur_int as $a => $b) { $obj = new Personal_cursos($b); ?>
          <tr>
            <td><?php echo $obj->get_titulo(); ?></td>
            <td><?php echo $obj->get_area_estudio(); ?></td>
            <td><?php echo $obj->get_pais(); ?></td>
            <td><?php echo $obj->get_ciudad(); ?></td>
            <td><?php echo $obj->get_horas(); ?></td>
            <td><?php echo $obj->get_fecha(); ?></td>
          </tr>
          <?php   } ?>     
        </tbody>
      </table>
    </div>  
  </div>
  <?php } ?>           
<!-- //test -->
  <?php $tmp = array_filter($hlab);
  if(!empty($tmp)){ ?>
  <h4 class="page-header txt-info">Historia Laboral</h4>
  <div class="row form-group">
    <div class="col-md-12">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th class="col-md-4">Cargo</th>
            <th class="col-md-4">Empresa</th>
            <th>Fecha de inicio</th>
            <th>Fecha de fin</th>
          </tr>
        </thead>
        <tbody>
          <?php   foreach ($hlab as $a => $b) { $obj = new Personal_hlaboral($b); ?>
          <tr>
            <td><?php echo $obj->get_cargo_(); ?></td>
            <td><?php echo $obj->get_empresa(); ?></td>
            <td><?php echo $obj->get_f_inicio(); ?></td>
            <td><?php echo $obj->get_f_fin(); ?></td>
          </tr>
          <?php   } ?>     
        </tbody>
      </table>
    </div>   
  </div>
  <?php } ?>          

  <?php 
if($idiom){
  $tmp = array_filter($idiom);
  if(!empty($tmp)){ ?>
  <h4 class="page-header txt-info">Idiomas</h4>
  <div class="row form-group">
    <div class="col-md-12">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
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
          <?php   
          $obj = new Personal_idioma();
          foreach ($idiom as $a => $b) {  
            $obj->cast($b);
            ?>
            <tr>
            <td><?php echo $obj->getIdioma() ?></td>
            <td><?php echo $obj->getInstitucion() ?></td>
            <td><?php echo $obj->getEntendimiento() ?></td>
            <td><?php echo $obj->getEscrito() ?></td>
            <td><?php echo $obj->getHablado() ?></td>
            <td><?php echo $obj->getLeido() ?></td>
            <td><?php echo $obj->getFecha_desde_() ?></td>
            <td><?php echo $obj->getFecha_hasta_() ?></td>
            </tr>
            <?php   } ?>     
          </tbody>
        </table>
      </div>   
    </div>
    <?php }} ?>        

  <?php 
if($premio){
  $tmp = array_filter($premio);
  if(!empty($tmp)){ ?>
  <h4 class="page-header txt-info">Premios</h4>
  <div class="row form-group">
    <div class="col-md-12">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>Premio</th>
            <th>Institución que otorga</th>
            <th>Item</th>
            <th>Fecha</th>
          </tr>
        </thead>
        <tbody>
          <?php   
          $obj = new Personal_premio();
          foreach ($premio as $a => $b) {  
            $obj->cast($b);
            ?>
            <tr>
            <td><?php echo $obj->getPremio() ?></td>
            <td><?php echo $obj->getInstitucion() ?></td>
            <td><?php echo $obj->getItem() ?></td>
            <td><?php echo $obj->getFecha_() ?></td>
            </tr>
            <?php   } ?>     
          </tbody>
        </table>
      </div>   
    </div>
    <?php }} ?>     


    <?php $f = array_filter($f);if(!empty($f)) { ?>
    <?php if($id==$_SESSION['USER-AD']['id']){ ?>
    <div class="col-md-12">
      <h4 class="txt-warning"><a href="<?php echo BASEURL ?>personal/datos_personales">Información Adicional</a></h4>
    </div>
    <?php } ?>
    <?php } ?>