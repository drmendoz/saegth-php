<?php
$meth = new User(); $ids=array(); $ids[]=$_SESSION['USER-AD']['id_personal']
?>
<style type="text/css">
  .empty-row{padding: 1px !important}
</style>
<form id='form' action="<?php echo BASEURL ?>evaluacion_desempenio/seleccion_evaluadores" method="POST">
  <div class="row">
    <p class="text-center"><?php echo $subtitle; ?></p>
    <p class="text-center">&nbsp;</p>
    <div class="col-xs-12 col-sm-12 row">  
      <?php foreach ($evaluadores as $key => $value) { ?>
      <div class="col-md-6">       
        <?php $key_ = explode(",", $key) ?>
        <legend class="col-md-12"><?php echo $key_[0] ?></legend> 
        <div class="col-md-12">
          <table class="table table-bordered table-striped table-hover table-heading table-datatable" id="<?php echo $key_[1] ?>">
            <thead>
              <tr>
                <th><input type="checkbox" class="table-control"></th>
                <th>Nombre</th>
                <th>Cargo</th>
              </tr>
            </thead>
            <tbody>
              <!-- Start: list_row -->
              <tr><td class="empty-row" colspan="3"></td></tr>
              <?php if ($value != "empty") { ?>

              <?php foreach ($value as $d => $e) { 
                $b = new Personal();
                $b->select($e['id_personal']); 
                $ids[]=$e['id_personal'];
                ?>
                <tr>
                  <td><input type="checkbox" checked name="id_per[]" value="<?php echo $b->id.','.$key_[1]; ?>" ></td>
                  <td><a href="<?php echo BASEURL.'user/view/'.$b->id ?>" target="_blank"><?php echo  $meth->htmlImage_($b->foto,'img-rounded sm-img').$meth->htmlprnt($b->nombre_p); ?></a></td>
                  <td><?php echo $meth->htmlprnt($meth->get_cargo($e['id_cargo'])); ?><div ><input class="relacion" type="hidden" name="rel[]" value="<?php echo $key_[1] ?>"></div></td>
                </tr>
                <?php } ?> 
                <?php } ?>
                <!-- End: list_row -->
              </tbody>
            </table>
          </div>
        </div>
        <?php } ?>
      </div>
      <div id="holder" class="col-xs-12 col-sm-12">
        <legend class="col-md-12">Inclusi&oacute;n de otros</legend>
        <div class="col-md-6">
          <label class="col-md-4">Buscar por nombre</label>
          <div class="col-md-5">
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
          <input id="asignar_relacion" class="btn btn-default btn-xs" type="submit" name="button_r" value="Continuar">
        </div>
      </div>
    </div>
  </form>
  <script type="text/javascript">
    $(document).ready(function(){
      $('.noEnterSubmit').keypress(function(e){
        if ( e.which == 13 ) e.preventDefault();
      });
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
        var val = $(chk).val().split(",");
        val[1] = this.parentNode.id;
        $('#exc').val($('#exc').val()+","+val[0]);
        $(chk).val(val.join(","));
            // alert("[" + this.id + "] received [" + ui.item.html() + "] from [" + ui.sender.attr("id") + "]");
          }
        }).disableSelection();


    $('#asignar_relacion').click(function(event){
      event.preventDefault();
      console.log(event);
      var r = confirm("¿Haz seleccionado a todos tus evaluares?. Si continúa la selección que haya hecho, completa o no, se tendrá como definitiva y será enviada a su supervisor directo para su aprobación/ modificación.");
      if (r == true) {
        $('#form').submit();
      } else {
        txt = "You pressed Cancel!";
      }

    })


  </script>