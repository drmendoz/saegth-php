<?php
    $meth = new Admin();
    // var_dump($per_c);
    // var_dump(sizeof($per_c));
    // echo "<br>";
    // //var_dump($per_i);
    // echo "<br>";
    // //var_dump(null != array_filter($per_h) );
?>
<form action="<?php echo BASEURL ?>personal/educacion"  class="form-horizontal" role="form" method="POST">
    <!-- <div class="col-xs-12 col-sm-12">
        <legend>Educaci&oacute;n Formal</legend>

        <div class="row form-group">
            <div class="col-md-6">
                <label class="col-sm-5">T&iacute;tulo</label>
                <div class="col-md-7">
                    <input value="<?php if(isset($ed_f['titulo'])) echo $ed_f['titulo']; ?>" class="form-control" name="titulo" required="required" placeholder="T&iacute;tulo" >
                </div>
            </div>
            <div class="col-md-6">
                <label class="col-sm-5">Carrera</label>
                <div class="col-md-7">
                    <input value="<?php if(isset($ed_f['carrera'])) echo $ed_f['carrera']; ?>" type="text" class="form-control" name="carr" required="required" placeholder="Carrera" >
                </div>
            </div>            
        </div>
        <div class="row form-group">
            <div class="col-md-6">
                <label class="col-sm-5">&Aacute;rea de Estudio</label>
                <div class="col-md-7">
                    <input value="<?php if(isset($ed_f['area_estudio'])) echo $ed_f['area_estudio']; ?>" type="text" class="form-control" name="a_est" required="required" placeholder="&Aacute;rea de Estudio" >
                </div>
            </div>
            <div class="col-md-6">
                <label class="col-sm-5">Instituci&oacute;n</label>
                <div class="col-md-7">
                    <input value="<?php if(isset($ed_f['institucion'])) echo $ed_f['institucion']; ?>" type="text" class="form-control" name="inst" required="required" placeholder="Instituci&oacute;n" >
                </div>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-6">
                <label class="col-sm-5">Pa&iacute;s</label>
                <div class="col-md-7">
                    <input value="<?php if(isset($ed_f['pais'])) echo $ed_f['pais']; ?>" type="text" class="form-control" name="pais" required="required" placeholder="Pa&iacute;s" >
                </div>
            </div>            
            <div class="col-md-6">
                <label class="col-sm-5">Ciudad</label>
                <div class="col-md-7">
                    <input value="<?php if(isset($ed_f['ciudad'])) echo $ed_f['ciudad']; ?>" type="text" class="form-control" name="ciud" required="required" placeholder="Ciudad" >
                </div>
            </div>
        </div>
    </div> -->
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
                            <input type="text" class="form-control" value="<?php if(isset($fields['titulo'])) echo $fields['titulo'] ?>" class="small"  placeholder="T&iacute;tulo" name="titulo[]">
                        </td>
                        <td>
                            <input type="text" class="form-control" value="<?php if(isset($fields['area_estudio'])) echo $fields['area_estudio'] ?>" class="small"  placeholder="&Aacute;rea de Estudio" name="a_est[]">
                        </td>
                        <td>
                            <input type="text" class="form-control" value="<?php if(isset($fields['carrera'])) echo $fields['carrera'] ?>" class="small"  placeholder="Carrera" name="carr[]">
                        </td>
                        <td>
                            <input type="text" class="form-control" value="<?php if(isset($fields['institucion'])) echo $fields['institucion'] ?>" class="small"  placeholder="Instituci&oacute;n" name="inst[]">
                        </td>
                        <td>
                            <input type="text" class="form-control" value="<?php if(isset($fields['pais'])) echo $fields['pais'] ?>" class="small"  placeholder="Pa&iacute;s" name="pais[]">
                        </td>
                        <td>
                            <input type="text" class="form-control" value="<?php if(isset($fields['ciudad'])) echo $fields['ciudad'] ?>" class="small"  placeholder="Ciudad" name="ciud[]">
                        </td>
                        <td>
                            <input type="date" class="form-control" value="<?php if(isset($fields['fecha'])) echo $fields['fecha'] ?>" class="small"  placeholder="Fecha" name="fecha[]">
                        </td>
                    </p>
                </tr>
    <?php } ?>
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
                            <input type="text" class="form-control" value="<?php if(isset($fields['titulo'])) echo $fields['titulo'] ?>" class="small"  placeholder="T&iacute;tulo" name="c_titulo[]">
                        </td>
                        <td>
                            <input type="text" class="form-control" value="<?php if(isset($fields['area_estudio'])) echo $fields['area_estudio'] ?>" class="small"  placeholder="&Aacute;rea de Estudio" name="c_area[]">
                        </td>
                        <td>
                            <input type="text" class="form-control" value="<?php if(isset($fields['horas'])) echo $fields['horas'] ?>" class="small"  placeholder="Horas" name="c_horas[]">
                        </td>
                        <td>
                            <input type="text" class="form-control" value="<?php if(isset($fields['institucion'])) echo $fields['institucion'] ?>" class="small"  placeholder="Instituci&oacute;n" name="c_inst[]">
                        </td>
                        <td>
                            <input type="text" class="form-control" value="<?php if(isset($fields['pais'])) echo $fields['pais'] ?>" class="small"  placeholder="Pa&iacute;s" name="c_pais[]">
                        </td>
                        <td>
                            <input type="text" class="form-control" value="<?php if(isset($fields['ciudad'])) echo $fields['ciudad'] ?>" class="small"  placeholder="Ciudad" name="c_ciud[]">
                        </td>
                        <td>
                            <input type="date" class="form-control" value="<?php if(isset($fields['fecha'])) echo $fields['fecha'] ?>" class="small"  placeholder="Fecha" name="c_fecha[]">
                        </td>
                    </p>
                </tr>
    <?php } ?>
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
                            <input type="text" value="<?php if(isset($fields['titulo'])) echo $fields['titulo'] ?>" class="form-control" class="small"  placeholder="T&iacute;tulo" name="c_titulo_int[]">
                        </td>
                        <td>
                            <input type="text" value="<?php if(isset($fields['area_estudio'])) echo $fields['area_estudio'] ?>" class="form-control" class="small"  placeholder="&Aacute;rea de Estudio" name="c_area_int[]">
                        </td>
                        <td>
                            <input type="text" value="<?php if(isset($fields['horas'])) echo $fields['horas'] ?>" class="form-control" class="small"  placeholder="Horas" name="c_horas_int[]">
                        </td>
                        <td>
                            <input type="date" value="<?php if(isset($fields['institucion'])) echo $fields['institucion'] ?>" class="form-control" class="small"  placeholder="Fecha" name="c_inst_int[]">
                        </td>
                        <td>
                            <input type="text" value="<?php if(isset($fields['pais'])) echo $fields['pais'] ?>" class="form-control" class="small"  placeholder="Pa&iacute;s" name="c_pais_int[]">
                        </td>
                        <td>
                            <input type="text" value="<?php if(isset($fields['ciudad'])) echo $fields['ciudad'] ?>" class="form-control" class="small"  placeholder="Ciudad" name="c_ciud_int[]">
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
                <th>Fecha Final</th><!--
                <th>Descripci&oacute;n Funciones</th> -->
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
                    <p>
                        <td>
                            <a tabIndex="-1" onclick="_deleteRow('dataTable2',this)"  style="color:red"><i class="fa fa-times"></i></a>
                            <div hidden><input type="checkbox" name="chk[]" checked="checked" /></div>
                        </td>
                        <td>
                            <input type="text" value="<?php if(isset($fields['cargo'])) echo $fields['cargo'] ?>" class="form-control" class="small"  placeholder="Cargo" name="hl_cargo[]">
                        </td>
                        <td>
                            <input type="text" value="<?php if(isset($fields['empresa'])) echo $fields['empresa'] ?>" class="form-control" class="small"  placeholder="Empresa" name="hl_emp[]">
                        </td>
                        <td>
                            <input type="date" value="<?php if(isset($fields['f_inicio'])) echo date('Y-m-d',strtotime($fields["f_inicio"]));?>" class="form-control" class="small"  placeholder="Fecha Inicial" name="hl_fini[]">
                        </td>
                        <td>
                            <input type="date" value="<?php if(isset($fields['f_fin'])) echo date('Y-m-d',strtotime($fields["f_fin"]));?>" class="form-control" class="small"  placeholder="Fecha Final" name="hl_ffin[]">
                        </td>
                        <!--
                        <td>
                            <textarea class="form-control" required="required" class="small"  placeholder="Descripci&oacute;n Funciones" name="hl_desc[]"></textarea>
                        </td>
                        -->
                    </p>
                </tr>
    <?php } ?>
            </tbody>
        </table>
        <div class="col-md-12 show-grid" > 
            <input type="button" class="btn btn-default btn-sm" value="Agregar" onClick="addRow('dataTable2',false)" />  
        </div>  
    </div>
    <p>&nbsp;</p>
    <div class="row form-group">
        <div class="col-md-2 col-md-offset-10">            
            <fieldset>
                <input class="btn btn-default btn-sm" type="submit" name="" value="Guardar">
            </fieldset>
        </div>
    </div>
</form>

