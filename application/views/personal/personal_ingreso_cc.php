<?php
    $meth = new Admin();
    $cargos = $_SESSION["Empresa"]['cargo'];
    $niveles = $_SESSION["Empresa"]['niveles_organizacionales'];
    $t_cont = $_SESSION['Empresa']['tipo_contrato'];
    $cond = $_SESSION["Empresa"]['condicionadores'];
    $c_opc = $_SESSION['Empresa']['opciones_cond'];
/*
    var_dump($areas);
    var_dump("&nbsp;");
    var_dump($pais);
    var_dump("&nbsp;");
    var_dump($ciudad);
    var_dump("&nbsp;");
    var_dump($sucursal);
    var_dump("&nbsp;");
    var_dump($cargos);
    var_dump("&nbsp;");
    var_dump($niveles);
    var_dump("&nbsp;");
    var_dump($cond);
    var_dump("&nbsp;");*/
?>
<form action="<?php echo BASEURL ?>admin/modificarEmpresa"  class="form-horizontal" role="form" method="POST">
    <h3 class="page-header"><i class="fa fa-user"></i> Ingreso Personal < <?php echo $_SESSION['Empresa']['nombre'] ?> ></h3>
    <h4 class="col-md-12 text-center">Datos B&aacute;sicos  <i class="fa fa-user"></i></h4>
    <div class="row">
        <div class="col-xs-12 col-sm-12">
            <fieldset>
                <legend>Datos Personales</legend>
                <div class="form-group">
                    <label class="col-sm-2">Nombre</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="" required="required" placeholder="Nombres" >
                    </div>
                    <label class="col-sm-2">Fotograf&iacute;a</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="" class="filename" placeholder="Fotograf&iacute;a" disabled />
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-default btn-app-sm" style="margin: 0 !important;"><i class="fa fa-camera"></i><input accept="image/jpg, image/gif, image/png, image/jpeg" type="file" name="file"></button>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2">Direcci&oacute;n</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="" required="required" placeholder="Direcci&oacute;n" >
                    </div>
                    <label class="col-sm-2">Tel&eacute;fono convencional</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="" required="required" placeholder="Tel&eacute;fono convencional" >
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2">Tel&eacute;fono celular</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="" required="required" placeholder="Tel&eacute;fono celular" >
                    </div>
                    <label class="col-sm-2">Foto Casa</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name=""  required="required" class="filename" placeholder="Fotograf&iacute;a" disabled />
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-default btn-app-sm" style="margin: 0 !important;"><i class="fa fa-camera"></i><input accept="image/jpg, image/gif, image/png, image/jpeg" type="file" name="file"></button>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2">Ubicaci&oacute;n Googlemaps</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="" required="required" placeholder="Ubicacion Googlemaps" >
                    </div>
                    <label class="col-sm-2">Vecinos (datos B&aacute;sicos)</label>
                    <div class="col-md-3">
                        <textarea type="text" class="form-control" name="" required="required" placeholder="Vecinos" ></textarea>
                    </div>
                </div>
                <div class="form-group has-feedback">
                    <label class="col-sm-2">C&eacute;dula</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="" required="required" placeholder="C&eacute;dula" >
                    </div>
                    <label class="col-sm-2">Fecha de Nacimiento</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control input_date" placeholder="Fecha de nacimiento">
                        <span class="fa fa-calendar form-control-feedback"></span>
                    </div>
                </div>
                <div class="form-group has-feedback">
                    <label class="col-sm-2">Fecha de Ingreso</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control input_date" placeholder="Fecha de ingreso">
                        <span class="fa fa-calendar form-control-feedback"></span>
                    </div>
                    <label class="col-sm-2">e-mail</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="email" required="required" placeholder="e-mail" >
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2">C&oacute;digo empleado</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="" required="required" placeholder="C&oacute;digo empleado" >
                    </div>
                    <label class="col-sm-2">Grado Salarial</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="" required="required" placeholder="Grado Salarial" >
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
    <h4 class="col-md-12 text-center">Organizaci&oacute;n  <i class="fa fa-building-o"></i></h4>
    <div class="row form-group">
        <div id="area-holder" class="col-md-6 col-sm-6" value="area-holder">
            <legend>&Aacute;reas</legend>
            <div hidden>
                <input type="text" class="form-control table_name" value="empresa_area" >
            </div>
            <fieldset>
                <div class="form-group">
                    <label class="col-md-5">Nivel 1</label>  
                    <div class="col-md-6" id="show_sub_categories">
                        <select name="p_area[]" required="required" class="parent form-control">
                            <option value="" selected="selected">-- Seleccionar una opci&oacute;n --</option>
                            <?php
                            $results = $meth->DB_exists_double('empresa_area','id_empresa',$_SESSION["Empresa"]["id"],'nivel',1);
                            
                            foreach ($results as $a => $b) {  ?>
                                <option value="<?php echo reset($b)['id'];?>"><?php echo reset($b)['nombre'];?></option>
                      <?php } ?>
                        </select>  
                    </div>
                </div>
            </fieldset> 
        </div>
        <div id="local-holder" class="col-xs-6 col-sm-6">
            <legend>Localidad</legend>
            <div hidden>
                <input type="text" class="form-control table_name" value="empresa_local" >
            </div>
            <fieldset>
                <div class="form-group">
                    <label class="col-md-5">Nivel 1</label>  
                    <div class="col-md-6" id="show_sub_categories">
                        <select name="p_local[]" class="parent form-control">
                            <option value="" selected="selected">-- Seleccionar una opci&oacute;n --</option>
                            <?php
                            $results = $meth->DB_exists_double('empresa_local','id_empresa',$_SESSION["Empresa"]["id"],'nivel',0);
                            
                            foreach ($results as $a => $b) {  ?>
                                <option value="<?php echo reset($b)['id'];?>"><?php echo reset($b)['nombre'];?></option>
                      <?php } ?>
                        </select>  
                    </div>
                </div>
            </fieldset> 
        </div>
    </div>
    <div class="row form-group">  
        <div class="col-xs-6 col-sm-6">
            <fieldset>
                <legend>Cargo</legend>
                <label class="col-md-5">T&iacute;tulo al que pertenece</label>  
                <div class="col-md-6">
                    <select class="form-control" name="cargo">
                        <option value="" selected="selected">-- Seleccionar una opci&oacute;n --</option>
                <?php   foreach($cargos as $a => $b){ ?>
                            <option value="<?php echo $a; ?>"><?php echo reset($b)['nombre']; ?></option>
                <?php   } ?>
                    </select>
                </div>  
            </fieldset>
        </div> 
        <div class="col-xs-6 col-sm-6">
            <fieldset>
                <legend>Nivel Organizacional</legend>
                <label class="col-md-5">Nivel Organizacional</label>  
                <div class="col-md-6">
                    <select class="form-control" name="n_org">
                        <option value="" selected="selected">-- Seleccionar una opci&oacute;n --</option>
                <?php   foreach($niveles as $a => $b){ ?>
                            <option value="<?php echo $a; ?>"><?php echo reset($b)['nombre']; ?></option>
                <?php   } ?>
                    </select>
                </div>  
            </fieldset>
        </div>
    </div>
    <div class="row form-group">  
        <div class="col-xs-6 col-sm-6">
            <fieldset>
                <legend>Tipos de contrato</legend>
                <label class="col-md-5">Tipo de contrato</label>  
                <div class="col-md-6">
                    <select class="form-control" name="t_cont">
                        <option value="" selected="selected">-- Seleccionar una opci&oacute;n --</option>`
                <?php   foreach($t_cont as $a => $b){ ?>
                            <option value="<?php echo $a; ?>"><?php echo reset($b)['nombre']; ?></option>
                <?php   } ?>
                    </select>
                </div>  
            </fieldset>
        </div> 
        <div class="col-md-6 col-sm-6">
            <fieldset>
                <legend>Condicionadores</legend>
                <p>(Seleccione los condicionadores. Multiples opciones)</p>
            <?php
                foreach($cond as $x => $y){ ?>
                    <div class="row form-group">
                        <div class="col-md-4">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" checked=""><?php echo reset($y)['nombre'] ?>
                                    <i class="fa fa-square-o small"></i>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <select class="form-control" name="cond_opcion">
                        <option value="" selected="selected">-- Seleccionar una opci&oacute;n --</option>
                    <?php   $c_opc = $meth->DB_exists_double('empresa_cond','id_empresa',$_SESSION["Empresa"]["id"],'id_superior',reset($y)['id']);
                            foreach ($c_opc as $a => $b) { ?>
                                  <option value="<?php echo reset($b)['id']; ?>"><?php echo reset($b)['nombre']; ?></option>
                <?php       } ?>
                            </select>
                        </div>
                    </div>
        <?php   }
            ?>
            </fieldset>
        </div>
    </div>
    <h4 class="col-md-12 text-center">Datos Personales  <i class="fa fa-user"></i></h4>
    <div class="row col-md-12"><legend>Estado Civil</legend></div>
    <div class="row form-group">
        <div class="col-xs-6 col-sm-6">
            <fieldset>
                <label class="col-md-5">Estado Civil</label>  
                <div class="col-md-6">
                    <select name="estado_civil" class="form-control">
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
        <div class="col-xs-6 col-sm-6">
            <fieldset>
                <label class="col-md-5">Hijos</label>  
                <div class="col-sm-6">
                    <input type="text" id="ui-spinner" class="form-control" required="required" placeholder="Cantidad">
                </div>
            </fieldset>
        </div> 
    </div>
    <div class="row form-group">
        <div class="col-md-1 col-md-offset-11">            
            <fieldset>
                <input class="btn btn-default btn-xs" type="submit" name="guardar_personal" value="Guardar">
            </fieldset>
        </div>
    </div>
</form>

