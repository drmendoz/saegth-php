<?php
$meth = new User();
$ids=array();
?>
<style type="text/css">
  .empty-row{padding: 1px !important}
</style>
<form id="form_body" action="<?php echo BASEURL ?>user/confirmar_relacion/<?php echo $id_evaluado ?>" method="POST">
  <div class="row">
    <p class="text-center"><?php echo $subtitle; ?></p>
    <p class="text-center">&nbsp;</p>
    <div class="col-xs-12 col-sm-12 row">
      <legend class="col-md-12">Relaci&oacute;n directa</legend> 
      <div class="col-md-6">       
        <legend class="col-md-12">Superior</legend> 
        <div hidden>
          <input type="text" class="form-control step" value="<?php echo $_SESSION['multifuente']['id'].','.$_SESSION['multifuente']['id_e'] ?>" >
        </div>  
        <div class="col-md-12">
          <table class="table table-bordered table-striped table-hover table-heading table-datatable" id="1">
            <thead>
              <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Cargo</th>
              </tr>
            </thead>
            <tbody>
              <tr><td class="empty-row" colspan="3"></td></tr>
              <?php 
              if($all_sel){
                  $disabled = "";
                  foreach ($all_sel as $key => $all_e) {
                    if ($all_e['relacion'] == 1) {
                      $ids[]=$all_e['id_personal'];
                      if($sup){
                      foreach ($sup as $d => $e) {
                        $e = reset($e);
                        if ($all_e['id_personal'] == $e['id_personal'] && $e['tipo_ingreso'] != '') {
                          $b = $meth->query('SELECT * FROM `personal` WHERE `id`=' . $e['id_personal'] . '',1);
                          $b = reset($b);
                          ?>
                            <tr style="background-color: #DDD"> 
                              <td><input type="checkbox" name="id_per[]" value="<?php echo $b['id'].',1'; ?>"  checked="checked"></td>
                              <td><a href="<?php echo BASEURL.'admin/personal_view/'.$b['id'] ?>" target="_blank"><?php echo  $meth->htmlImage_($b['foto'],'img-rounded sm-img').$meth->htmlprnt($b['nombre_p']); ?></a></td>
                              <td><?php echo $meth->htmlprnt($meth->get_cargo($e['id_cargo'])); ?><div hidden><input type="text" name="rel[]" value="1"></div></td>
                            </tr>
                          <?php
                          //
                          continue 2;
                        }
                      }
                      }
                      //
                      $b = $meth->query('SELECT * FROM `personal` WHERE `id`=' . $all_e['id_personal'] . '',1);
                      $b = reset($b);

                      $c = $meth->query('SELECT * FROM personal_empresa WHERE id_personal='.$all_e['id_personal'].'',1);
                      $c = reset($c);

                      $disabled = ($all_e['aprovado'] == 3) ? 'disabled' : '';
                      ?>
                      <tr>
                        <td><input type="checkbox" name="id_per[]" value="<?php echo $b['id'].',1'; ?>" checked <?php echo $disabled; ?>></td>
                        <td><a href="<?php echo BASEURL.'admin/personal_view/'.$b['id'] ?>" target="_blank"><?php echo  $meth->htmlImage_($b['foto'],'img-rounded sm-img').$meth->htmlprnt($b['nombre_p']); ?></a></td>
                        <td><?php echo $meth->htmlprnt($meth->get_cargo($c['id_cargo'])); ?><div hidden><input type="text" name="rel[]" value="1"></div></td>
                      </tr>
                      <?php
                    }
                  }
              }
              ?>   
              </tbody>
            </table>
          </div>
        </div>
        <div class="col-md-6">    
          <legend class="col-md-12">Pares</legend> 
          <div hidden>
            <input type="text" class="form-control step" value="<?php echo $_SESSION['multifuente']['id'].','.$_SESSION['multifuente']['id_e'] ?>" >
          </div>  
          <div class="col-md-12">
            <table class="table table-bordered table-hover table-heading table-datatable" id="2">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Nombre</th>
                  <th>Cargo</th>
                </tr>
              </thead>
              <tbody>
                <tr><td class="empty-row" colspan="3"></td></tr>
                <?php 
                  if($all_sel){
                      $disabled = "";
                      foreach ($all_sel as $key => $all_e) {
                        if ($all_e['relacion'] == 2) {
                          $ids[]=$all_e['id_personal'];
                          if ($par) {
                          foreach ($par as $d => $e) {
                            $e = reset($e);
                            if ($all_e['id_personal'] == $e['id_personal'] && $e['tipo_ingreso'] != '') {
                              $b = $meth->query('SELECT * FROM `personal` WHERE `id`=' . $e['id_personal'] . '',1);
                              $b = reset($b);
                              ?>
                              <tr style="background-color: #DDD">
                                <td><input type="checkbox" name="id_per[]" value="<?php echo $b['id'].',2'; ?>"  checked="checked"></td>
                                <td><a href="<?php echo BASEURL.'admin/personal_view/'.$b['id'] ?>" target="_blank"><?php echo  $meth->htmlImage_($b['foto'],'img-rounded sm-img').$meth->htmlprnt($b['nombre_p']); ?></a></td>
                                <td><?php echo $meth->htmlprnt($meth->get_cargo($e['id_cargo'])); ?><div hidden><input type="text" name="rel[]" value="2"></div></td>
                              </tr>
                              <?php
                              //
                              continue 2;
                            }
                          }
                          }
                          //
                          $b = $meth->query('SELECT * FROM `personal` WHERE `id`=' . $all_e['id_personal'] . '',1);
                          $b = reset($b);

                          $c = $meth->query('SELECT * FROM personal_empresa WHERE id_personal='.$all_e['id_personal'].'',1);
                          $c = reset($c);

                          $disabled = ($all_e['aprovado'] == 3) ? 'disabled' : '';
                          ?>
                          <tr>
                            <td><input type="checkbox" name="id_per[]" value="<?php echo $b['id'].',2'; ?>" checked <?php echo $disabled; ?>></td>
                            <td><a href="<?php echo BASEURL.'admin/personal_view/'.$b['id'] ?>" target="_blank"><?php echo  $meth->htmlImage_($b['foto'],'img-rounded sm-img').$meth->htmlprnt($b['nombre_p']); ?></a></td>
                            <td><?php echo $meth->htmlprnt($meth->get_cargo($c['id_cargo'])); ?><div hidden><input type="text" name="rel[]" value="2"></div></td>
                          </tr>
                          <?php
                        }
                      }
                  }
                ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="col-md-6">    
            <legend class="col-md-12">Subalternos</legend> 
            <div hidden>
              <input type="text" class="form-control step" value="<?php echo $_SESSION['multifuente']['id'].','.$_SESSION['multifuente']['id_e'] ?>" >
            </div>  
            <div class="col-md-12">
              <table class="table table-bordered table-striped table-hover table-heading table-datatable" id="3">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Cargo</th>
                  </tr>
                </thead>
                <tbody>
                  <tr><td class="empty-row" colspan="3"></td></tr>
                  <?php
                  if ($all_sel) {
                      $disabled = "";
                      foreach ($all_sel as $key => $all_e) {
                        if ($all_e['relacion'] == 3) {
                          $ids[]=$all_e['id_personal'];
                          if ($sub) {
                          foreach ($sub as $d => $e) {
                            $e = reset($e);
                            if ($all_e['id_personal'] == $e['id_personal'] && $e['tipo_ingreso'] != '') {
                              $b = $meth->query('SELECT * FROM `personal` WHERE `id`=' . $e['id_personal'] . '',1);
                              $b = reset($b);
                              ?>
                              <tr style="background-color: #DDD">
                                <td><input type="checkbox" name="id_per[]" value="<?php echo $b['id'].',3'; ?>" checked="checked"></td>
                                <td><a href="<?php echo BASEURL.'admin/personal_view/'.$b['id'] ?>" target="_blank"><?php echo  $meth->htmlImage_($b['foto'],'img-rounded sm-img').$meth->htmlprnt($b['nombre_p']); ?></a></td>
                                <td><?php echo $meth->htmlprnt($meth->get_cargo($e['id_cargo'])); ?><div hidden><input type="text" name="rel[]" value="3"></div></td>
                              </tr>
                              <?php
                              //
                              continue 2;
                            }
                          }
                          }
                          //
                          $b = $meth->query('SELECT * FROM `personal` WHERE `id`=' . $all_e['id_personal'] . '',1);
                          $b = reset($b);

                          $c = $meth->query('SELECT * FROM personal_empresa WHERE id_personal='.$all_e['id_personal'].'',1);
                          $c = reset($c);

                          $disabled = ($all_e['aprovado'] == 3) ? 'disabled' : '';
                          ?>
                          <tr>
                            <td><input type="checkbox" name="id_per[]" value="<?php echo $b['id'].',3'; ?>" checked <?php echo $disabled; ?>></td>
                            <td><a href="<?php echo BASEURL.'admin/personal_view/'.$b['id'] ?>" target="_blank"><?php echo  $meth->htmlImage_($b['foto'],'img-rounded sm-img').$meth->htmlprnt($b['nombre_p']); ?></a></td>
                            <td><?php echo $meth->htmlprnt($meth->get_cargo($c['id_cargo'])); ?><div hidden><input type="text" name="rel[]" value="3"></div></td>
                          </tr>
                          <?php
                        }
                      }
                  }
                  ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div id="holder" class="col-xs-12 col-sm-12">
            <legend class="col-md-12">Inclusi&oacute;n de otros</legend>
            <div class="col-md-6">
              <label class="col-md-4">Buscar por nombre</label>
              <div class="col-md-5">
                <?php array_push($ids, $id_evaluado) ?>
                <input id="search" type="text" class="form-control noEnterSubmit" name="search" placeholder="Nombre">
                <input type="hidden" id="exc" value="<?php echo implode(',',$ids) ?>" ?>
              </div>
              <div class="col-md-3">
                <a id="ps" class="btn btn-xs btn-info" href="#">Buscar</a>
              </div>
            </div>
            <div class="holder col-md-6">
              <fieldset>
              </fieldset>
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 row">
            <div class="col-md-3 col-md-offset-9 show-grid">
              <input class="btn btn-default btn-xs" type="submit" name="button_r" value="Continuar">
            </div>
          </div>
        </div>
      </form>
      <script type="text/javascript">
        $(document).ready(function(){
          $('.noEnterSubmit').keypress(function(e){
            if ( e.which == 13 ) e.preventDefault();
          });
          var form_body = <?php echo $dead ?>;
          if(form_body==0)
            $('#form_body').remove();
        });
        $("table .table-control").click(function(event){
          var inputs = $(this).parentsUntil('table').parent().find('input[type="checkbox"]');
          if ($(this).is(':checked')) {
            inputs.prop('checked',true);
          } else {
            inputs.prop('checked',false);
          }
        });
        $("table tbody").sortable({
          connectWith: 'table tbody',
          helper: 'clone',
          placeholder: "bg-info",
          revert: true,

          receive: function(event, ui) {
            ui.item.find('.relacion').val(this.parentNode.id);
            var chk = ui.item.context.childNodes[1].childNodes;
			$(chk).prop('checked', true);
            var val = $(chk).val().split(",");
            val[1] = this.parentNode.id;
            $('#exc').val($('#exc').val()+","+val[0]);
            $(chk).val(val.join(","));
          }
        }).disableSelection();
      </script>