<ul class="nav nav-tabs" role="tablist">
  <li role="presentation" class="active"><a href="#active" aria-controls="active" role="tab" data-toggle="tab">Listado personal</a></li>
  <li role="presentation"><a href="#inactive" aria-controls="inactive" role="tab" data-toggle="tab">Personal inactivo</a></li>
</ul>

<div class="tab-content">
  <div  role="tabpanel" class="tab-pane active" id="active">
    <p>&nbsp;</p>
    <!-- <div class="btn-toolbar" role="toolbar" aria-label="...">
      <a data-column="1" class="toggle-vis btn btn-info">Nombre</a>
      <a data-column="2" class="toggle-vis btn btn-info">Cedula</a>
      <a data-column="3" class="toggle-vis btn btn-info">Email</a>
      <a data-column="4" class="toggle-vis btn btn-info">Sexo</a>
      <a data-column="5" class="toggle-vis btn btn-info">Area</a>
      <a data-column="6" class="toggle-vis btn btn-info">País</a>
      <a data-column="7" class="toggle-vis btn btn-info">Ciudad</a>
      <a data-column="8" class="toggle-vis btn btn-info">Localidad</a>
      <a data-column="9" class="toggle-vis btn btn-info">Cargo</a>
      <a data-column="10" class="toggle-vis btn btn-info">Nivel Organizacional</a>
      <a data-column="11" class="toggle-vis btn btn-info">Tipo De Contrato</a> -->
      <?php  
      $e = new empresa();
      $e->select($_SESSION['Empresa']['id']);
      if ($e->getCompass_360()) {
        //echo '<a data-column="12" class="toggle-vis btn btn-info">Compass 360</a>'; 
      }
      if ($e->getScorer()) {
        //echo '<a data-column="13" class="toggle-vis btn btn-info">Scorecard</a>'; 
      }
      if ($e->getMatriz()) {
        //echo '<a data-column="14" class="toggle-vis btn btn-info">Matriz</a>'; 
      }
      ?>
      <!-- <a data-column="15" class="toggle-vis btn btn-info">Superior</a>
      <a data-column="16" class="toggle-vis btn btn-info">Activo</a>
    </div> -->
    <div class="container-fluid my-own-class table-responsive">
      <table id="table" class="table table-bordered table-hover consulta">
        <thead>
          <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Cedula</th>
            <th>Email</th>
            <th>Sexo</th>
            <th>Area</th>
            <th>País</th>
            <th>Ciudad</th>
            <th>Localidad</th>
            <th>Cargo</th>
            <th>Nivel Organizacional</th>
            <th>Tipo De Contrato</th>
            <th>Compass 360</th>
            <th>Scorecard</th>
            <th>Matriz</th>
            <th>Superior directo</th>
            <th>Activo</th>
          </tr>
        </thead>
        <tbody>
          <?php  
          $lp = new listado_personal_op();
          foreach ($result as $key => $value) {
            $lp->cast($value);
            ?>
            <tr>
              <td><?php echo $key+1 ?></td>
              <td><a href="<?php echo BASEURL.'personal/view/'.$lp->id ?>"><?php echo $lp->getNombre() ?></a></td>
              <td><?php echo $lp->getCedula() ?></td>
              <td><?php echo $lp->getEmail() ?></td>
              <td><?php echo $lp->getSexo() ?></td>
              <td><?php echo $lp->getArea() ?></td>
              <td><?php echo $lp->getPais() ?></td>
              <td><?php echo $lp->getCiudad() ?></td>
              <td><?php echo $lp->getLocal() ?></td>
              <td><?php echo $lp->getCargo() ?></td>
              <td><?php echo $lp->getNiveles_organizacionales() ?></td>
              <td><?php echo $lp->getTcont() ?></td>
              <td><?php echo $lp->getCompass_360_() ?></td>
              <td><?php echo $lp->getScorer_() ?></td>
              <td><?php echo $lp->getMatriz_() ?></td>
              <td><?php echo $lp->getPid_nombre() ?></td>
              <td><?php echo $lp->getActivo_() ?></td>
            </tr>
            <?php 
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
  <div role="tabpanel" class="tab-pane" id="inactive">

    <p>&nbsp;</p>
    <table id="table2" class="table table-bordered">
      <thead>
        <tr>
          <th>#</th>
          <th>Nombre</th>
          <th>Area</th>
          <th>Localidad</th>
          <th>Cargo</th>
          <th>Activo</th>
        </tr>
      </thead>
      <tbody>
        <?php  
        $lp = new listado_personal_op();
        foreach ($inactive as $key => $value) {
          $lp->cast($value);
          ?>
          <tr>
            <td><?php echo $key+1 ?></td>
            <td><a href="<?php echo BASEURL.'personal/view/'.$lp->id ?>"><?php echo $lp->getNombre() ?></a></td>
            <td><?php echo $lp->getArea() ?></td>
            <td><?php echo $lp->getLocal() ?></td>
            <td><?php echo $lp->getCargo() ?></td>
            <td><?php echo $lp->getActivo_() ?></td>
          </tr>
          <?php 
        }
        ?>
      </tbody>
    </table>
  </div>
</div>


<script type="text/javascript">
 $(document).ready(function(){
  setTimeout(function(){ 
    var options = {
      "language": {
        "lengthMenu": "Mostrar _MENU_ entradas por página",
        "zeroRecords": "No hay resultados",
        "info": "Mostrando página _PAGE_ de _PAGES_",
        "infoEmpty": "No hay resultados",
        "infoFiltered": "(Filtrado de _MAX_ entradas totales)",
        "search":         "Buscar:",
        "paginate": {
          "first":      "First",
          "last":       "Last",
          "next":       "Siguiente",
          "previous":   "Anterior"
        },
      },
      "lengthMenu": [[50, 100, -1], [50, 100, "Todos"]],
      "bAutoWidth": false
    }
    var table = $('#table').DataTable(options);

    yadcf.init(table, [
      {column_number : 6, filter_default_label: "Filtrar país"},
      {column_number : 7, filter_default_label: "Filtrar ciudad", cumulative_filtering: true}
      ]);
    $('#table2').DataTable(options);
    $('a.toggle-vis').on( 'click', function (e) {
      e.preventDefault();
      var column = table.column( $(this).attr('data-column') );
      column.visible( ! column.visible() );

    } );
    // table.column(2).visible(false);
    // table.column(3).visible(false);
    // table.column(4).visible(false);
    // table.column(7).visible(false);
    // table.column(8).visible(false);
    // table.column(10).visible(false);
    // table.column(11).visible(false);
    // table.column(12).visible(false);
    // table.column(13).visible(false);
    // table.column(14).visible(false);
    // table.column(15).visible(false);
    // table.column(16).visible(false);
  }, 700);
})

</script>

<style type="text/css">
  @media (min-width: 992px) {
    .container-fluid.my-own-class {
      overflow-x: scroll;
      white-space: nowrap;
    }
    .container-fluid.my-own-class .col-md-12 {
      display: inline-block;
      vertical-align: top;
      float: none;
    }
  }

  .dataTables_wrapper {
    overflow: visible;
  }
</style>