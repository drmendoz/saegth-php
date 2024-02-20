<?php
    $meth = new Admin();
    $gmap = str_replace(")","",str_replace("(", "", $datos['u_gmaps']));
    $gmap = explode(',', $gmap);
?>
<script type="text/javascript">
    $(document).ready(function(){
        google.maps.event.addDomListener(window, 'load', initialize({'lat':<?php echo $gmap[0] ?>,'lng':<?php echo $gmap[1] ?>}));
    });
</script>
<form action="<?php echo BASEURL ?>personal/ubicacion" method="POST" enctype="multipart/form-data">
    <h4 class="col-md-12 text-center">Datos B&aacute;sicos  <i class="fa fa-user"></i></h4>
    <div class="row form-group col-xs-12 col-sm-12">
        <legend>Informacion Casa</legend>
        <div class="row col-md-12 form-group">
            <label class="col-sm-4">Foto Casa</label>
            <div class="col-md-7 col-md-offset-1">
                <input accept="image/jpg, image/gif, image/png, image/jpeg" required="required" type="file" name="file" id="file" class="input-file">
            </div>
        </div>
        <div class="row col-md-12">
            <label class="col-sm-4">Vecinos (datos b&aacute;sicos)</label>
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
    <div class="row form-group">
        <div class="col-md-2 col-md-offset-10">            
            <input class="btn btn-default btn-xs" type="submit" name="personal_datos" value="Guardar">
        </div>
    </div>
</form>

