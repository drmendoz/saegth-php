<style type="text/css">
	.progress{height: 40px;}
	.progress-bar{
		font-size: 24px;
		padding-top: 8px;
		border-color: rgba(0, 0, 0, 0.3);
		width: calc(100%/3);
	}
	#tblPorcentajes div{
		border: 2px solid #CCC;
		border-radius: 3px;
		margin: 3px;
		height: 15px;
	}
</style>
<script type="text/javascript">
	$(document).ready(function(){
		$('#a_sonda, #g_af').addClass('active-parent active');
		$('#af_ac').addClass('activate');

		$("#tblPorcentajes tr td > div").each(function() {
		    $(this).animate({
				width: $(this).data("width")+"%"
			}, 100);
		});
	});
</script>
<?php 
if(isset($_SESSION['args']))
	$args=$_SESSION['args'];
else
	$args="";

$filtros = (isset($_SESSION['filtros_pb'])) ? $_SESSION['filtros_pb'] : "" ;
$util = new Util();
$util->_x('resultados','titulo');
?>
<?php $util->_x('resultados','segmentacion'); ?>
<p><?php echo $filtros ?></p>
<div class="col-md-12">
	<?php $x = new Sonda_tema(); $x->select($id_tema); ?>
	<table class="table table-bordered table-hover" style="margin-top:50px">
		<tr><th colspan="4"><strong><a href="<?php echo BASEURL ?>sonda/<?php echo $pagina ?>"><?php echo ucfirst($x->getTema()) ?>.-</a></strong> 	<?php $x->getDescripcion() ?></th></tr>
		<?php 

		$xxx = new Rendimiento();
		$xxx->select($_SESSION['Empresa']['id']);
		//Cargamos datos del test a consultar (reemplazamos algunos datos cargados en la funcion principales).
		$xxx->get_test($id_s);
		$temas = $xxx->getTemas();

		$y = new Sonda_pregunta();
		$z = new Sonda_user();
		$w = new Sonda_respuesta();
		$ids = $z->get_id_x_empresa($xxx->getId(),$_SESSION['Empresa']['id'],$args);
		$id_p = $id_p_general = '';
	// $preguntas = $y->select_x_tema($id_tema);
	// var_dump($preguntas);
		$preguntas = $temas[$id_tema];
		$preguntas_id = implode(",", $temas[$id_tema]);
		$graf= $promedio_general = array();
		foreach ($preguntas as $key => $value) {
			$y->select($value);
			echo "<tr>";
	// 	$tema_nombre = ucfirst($value->getTema());
			echo "<td>". ++$key ."</td>";
			$id_p = $y->getId();
			$id_p_general .= $y->getId().',';
			echo "<td><h5>".$y->getPregunta()."</h5></td>";
			if (isset($_SESSION["idspreguntas_pb"])) {
				for ($i=0; $i < count($_SESSION["idspreguntas_pb"]["preguntas"]); $i++) { 
					if ($preguntas_id == $_SESSION["idspreguntas_pb"]["preguntas"][$i]) {
						$ids = $_SESSION["idspreguntas_pb"]["ids"][$i];
					}
				}
			}
			$promedio = $w->get_avg_x_pregunta($ids,$id_p);
			array_push($promedio_general, $promedio);
			$porcentajes = $w->get_percent_x_pregunta($ids,$id_p);
			$graf[$key] = $porcentajes;
			echo "<td class='text-center' style='background-color: ".$w->get_color($promedio)."'><h4>";
			printf("%.2f", $promedio);
			echo "</h4></td>";
			?>
			<td class="col-md-6">
				<table id="tblPorcentajes" border="0" width="100%">
					<tr>
						<td width="90%">
							<div style="background-color: red;" data-width="<?php echo $porcentajes[0] ?>">
						</td>
						<td width="10%" style="text-align: right;"><h5><?php echo $porcentajes[0] ?>% </h5></td>
					</tr>
					<tr>
						<td width="90%">
							<div style="background-color: yellow;" data-width="<?php echo $porcentajes[1] ?>">
						</td>
						<td width="10%" style="text-align: right;"><h5><?php echo $porcentajes[1] ?>% </h5></td>
					</tr>
					<tr>
						<td width="90%">
							<div style="background-color: limegreen;" data-width="<?php echo $porcentajes[2] ?>">
						</td>
						<td width="10%" style="text-align: right;"><h5><?php echo $porcentajes[2] ?>% </h5></td>
					</tr>
				</table>
			</td>
			<?php
			echo "</tr>";

		}
		echo "<tr>";
		echo "<th colspan='2'>Promedio General</th>";
		$p_gen = array_sum($promedio_general)/sizeof($promedio_general);
		$id_p_general = substr($id_p_general, 0, -1);
		$porcentajes_g = $w->get_percent_x_pregunta($ids,$id_p_general);//MODIFICADO get_percent_x_pregunta
		echo "<td class='text-center' style='background-color: ".$w->get_color($p_gen)."'>";
		echo "<h4>".round($p_gen,2)."</h4>";
		echo "</td>";
		?>
		<td>
			<table id="tblPorcentajes" border="0" width="100%">
				<tr>
					<td width="90%">
						<div style="background-color: red;" data-width="<?php echo $porcentajes_g[0] ?>">
					</td>
					<td width="10%" style="text-align: right;"><h5><?php echo $porcentajes_g[0] ?>% </h5></td>
				</tr>
				<tr>
					<td width="90%">
						<div style="background-color: yellow;" data-width="<?php echo $porcentajes_g[1] ?>">
					</td>
					<td width="10%" style="text-align: right;"><h5><?php echo $porcentajes_g[1] ?>% </h5></td>
				</tr>
				<tr>
					<td width="90%">
						<div style="background-color: limegreen;" data-width="<?php echo $porcentajes_g[2] ?>">
					</td>
					<td width="10%" style="text-align: right;"><h5><?php echo $porcentajes_g[2] ?>% </h5></td>
				</tr>
			</table>
		</td>
		<?php
		echo "</tr>";
		echo "<input type='hidden' id='graf' value='".json_encode($graf)."'/>";
		?>
	</table>
</div>