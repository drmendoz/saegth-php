<?php 
$meth = new Scorecard();
$success = '<h2><i class="fa fa-check" style="color:green"></i></h2>';
$error = '<h2><i class="fa fa-times" style="color:red"></i></h2>';
?>
<style type="text/css">
  table tr, table td{padding:10px;}
  table.scorecard td{text-align: center;}
  select.input-sm {
    height: 22px;
    line-height: 30px;
  }
  input.input-sm{
    margin-left: 10px;
  }
</style>
<div class="form-group">
  <img src="<?php echo BASEURL ?>img/scorecard.png" style="width: 200px;">
  <h3 align="center">SISTEMA DE INFORMACIÓN GENERAL DEL PROCESO</h3>
</div>
<div class="row form-group col-md-12 table-responsive">
	<table class="table-bordered scorecard" id="table" style="width: 100%; line-height: 12px;">
		<thead>
			<tr>
				<th>SUBALTERNOS EN PROCESO</th>
				<th>Cargo</th>
				<th>Ingreso de Usuario</th>
				<th>Ingreso de Jefe</th>
				<th>Bloqueo Jefe</th>
				<th>Revisión</th>
				<th>Evaluación</th>
        <th>Revisión del Jefe</th>
        <th>Evaluación del Jefe</th>
        <th>Resultado Scorercard %</th>
        <th>Resultado Scorercard</th>
        <th>Resultado Compass 360°</th>
        <th>Resultado Ponderado</th>
        <th>Fase Final</th>
      </tr>
    </thead>
    <tbody>
      <?php if(isset($sub_a)){
        $num_rows=sizeof($sub_a);
        $rrr = true;
      }else{
        $num_rows=1;
        $rrr = false;
      } for ($i=0; $i < $num_rows; $i++) { 
        if($rrr){
          $fields=$sub_a[$i]; 
          $r_scorer = $meth->get_ScorecardRes($fields['id_personal']);
        } 
        ?>
        <tr>
          <td style="text-align: left !important"><a href="<?php echo BASEURL.'scorecard/confirmacion/'.$fields['id_personal'] ?>"><?php echo $meth->htmlprnt(trim($fields['nombre'])) ?></a></td>
          <td><?php echo $meth->htmlprnt($fields['cargo']) ?></td>
          <td><?php if($fields['usuario']) echo $success; else echo $error; ?></td>
          <td><?php if($fields['jefe']) echo $success; else echo $error; ?></td>
          <td><?php if($fields['bloqueo']) echo $success; else echo $error; ?></td>
          <td><?php if($fields['revision']) echo $success; else echo $error; ?></td>
          <td><?php if($fields['evaluacion']) echo $success; else echo $error; ?></td>
          <td><?php if($fields['revision_jefe']) echo $success; else echo $error; ?></td>
          <td><?php if($fields['evaluacion_jefe']) echo $success; else echo $error; ?></td>
          <td><?php echo number_format($r_scorer,2,"."," ").'%';  ?></td>
          <td><?php echo $r_score = $meth->scorer_rango($scorer,intval($r_scorer)); ?></td>
          <td><?php echo $compass = round($meth->getAvg_test_eval($meth->get_codEval($fields['id_personal'])),2); ?></td>
          <td>
            <?php 
            $p_score = $scorer->p_score;
            echo $total = ($r_score * $p_score / 100)+($compass * (100-$p_score) /100);
            ?>
          </td>
          <td>
            <form method="post" action="<?php echo BASEURL.'scorecard/fase_final'?>">
              <input type="hidden" name="id_e" value="<?php echo $fields['id_personal'] ?>"> 
              <input type="hidden" name="compass" value="<?php echo $compass ?>"> 
              <input type="hidden" name="r_score" value="<?php echo $r_score ?>"> 
              <input type="hidden" name="total" value="<?php echo $total ?>"> 
              <input type="submit" class="btn btn-info btn-xs" value="Link">
            </form>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>

    <?php 
    function get_cargoById($id,$meth){
      $dat = $meth->query('SELECT * FROM `personal_empresa` WHERE `id_personal`=' . $id . '');
      $dat = $dat[0];
      $dat = reset($dat);
      $d_emp = $meth->query('SELECT ca.nombre 
       FROM empresa_cargo as ca
       WHERE ca.id='.$dat['id_cargo'].'');
      if($d_emp){
       $d_emp = $d_emp[0];
       $tmp=reset($d_emp);
       $car = @reset($tmp);
       $cargo = $car;
       return $cargo;
     }else
     return 0;
   }
   ?>

   <script type="text/javascript" defer>
    $(document).ready(function() {
      setTimeout(function(){ $('#table').DataTable({
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
        }
      } ); }, 2000);
    } );
  </script>
  <script type="text/javascript">
    var $rows = $('#table tbody tr');
    $('#search').keyup(function() {

      var val = '^(?=.*\\b' + $.trim($(this).val()).split(/\s+/).join('\\b)(?=.*\\b') + ').*$',
      reg = RegExp(val, 'i'),
      text;

      $rows.show().filter(function() {
        text = $(this).text().replace(/\s+/g, ' ');
        return !reg.test(text);
      }).hide();
    });
  </script>