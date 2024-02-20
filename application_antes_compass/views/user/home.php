<?php $meth = new User(); ?>
<style type="text/css">
	table#tabs-1 tr > th{
		text-align: left;
	}
</style>
<script type="text/javascript">var hcompass=0;</script>
<div>
	<input id="select_active_tab" type="hidden" value="<?php if(isset($tab)) echo $tab;?>">
	<ul  id="tabs" class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><a  role="tab" data-toggle="tab" href="#tabs-1" aria-controls="tabs-1">Datos personales</a></li>
		<li role="presentation" ><a  role="tab" data-toggle="tab" href="#tabs-2" aria-controls="tabs-2">Compass 360</a></li>
		<li role="presentation" ><a  role="tab" data-toggle="tab" href="#tabs-3" aria-controls="tabs-3">Scorecard</a></li>
		<li role="presentation" ><a  role="tab" data-toggle="tab" href="#tabs-4" aria-controls="tabs-4">Plan de acción</a></li>
		<li role="presentation" ><a  role="tab" data-toggle="tab" href="#tabs-5" aria-controls="tabs-5">Preferencias de Desarrollo de Carrera</a></li>
	</ul>
	<div class="tab-content" style="margin-top:15px">
		<div role="tabpanel" class="tab-pane fade in active" id="tabs-1">
			<?php 
			$user = new UserController('User','user','view',0,true,true); 
			$user->view(); 
			$user->ar_destruct();
			unset($user); 
			?>
		</div>


		<div role="tabpanel" class="tab-pane fade col-md-12" id="tabs-2">
			<?php if($hcompass){ ?>
			<div class="col-md-12 no-padding">
				<p>&nbsp;</p>
				<?php 
				$compass = new Multifuente();
				$ceval = array_filter($compass->get_Eval($_SESSION['USER-AD']['id_personal']));
				if(null ==($ceval)){ 
					$rel = new Multifuente_relacion(); 
					$eval_rel = $rel->select_all($_SESSION['USER-AD']['id_personal']);  
					if ($eval_rel): ?>
					<p>Usted ya selecciono a sus evaluadores, se esta esperando una confirmación.</p>
				<?php else: ?>
					<p>Antes de poder asignarle una evaluación debe confirmar la relación de sus evaluadores. <a class="bg-info" href="<?php echo BASEURL.'user/asignar_relacion' ?>">Asignar relación</a></p>
				<?php endif ?>

				<?php	}else{ 
					echo '<script type="text/javascript">window.hcompass=1;</script>';
				echo '<p class="text-center"><i class="fa fa-spinner fa-pulse fa-5x"></i></p>';
				} ?>
			</div>
			<?php }else{ ?>
			<h3 class="bg-warning text-center" style="padding:10px;">No ha sido asignado para esta evaluación </h3>
			<?php } ?>
		</div>


		<div role="tabpanel" class="tab-pane fade" id="tabs-3">
			<?php if($hscorer){ 
			$scorecard = new ScorecardController('Scorecard','scorecard','generacion',0,true,true); 
			$scorecard->generacion($_SESSION['USER-AD']['id_personal']); 
			$scorecard->ar_destruct();
			unset($scorecard); ?>
			<?php }else{ ?>
			<h3 class="bg-warning text-center" style="padding:10px;">No ha sido asignado para esta evaluación </h3>
			<?php } ?>
		</div>



		<div role="tabpanel" class="tab-pane fade" id="tabs-4">
			<?php 
				if($hscorer || $hcompass){ 
					$plan = new MultifuenteController('Multifuente','Multifuente','plan',0,true,true); 
					$plan->plan($_SESSION['USER-AD']['id_personal']); 
					$plan->ar_destruct();
					unset($plan); 
			 	}else{ ?>
					<h3 class="bg-warning text-center" style="padding:10px;">No ha sido asignado para esta evaluación </h3>
				<?php } ?>
		</div>

		<div role="tabpanel" class="tab-pane fade" id="tabs-5">
			<?php 
			$plan = new TestController('Test','test','desarrollo',0,true,true); 
			$plan->Desarrollo(); 
			$plan->ar_destruct();
			unset($plan); 
			?>
		</div>

	</div>
</div>



		<script type="text/javascript">
			$(document).ready(function() {
				var active_tab = $('#select_active_tab').val() || "tabs-1";
				$('#tabs a[href="#'+active_tab+'"]').tab('show');

				$('#tabs a').click(function (e) {
					e.preventDefault();
					$(this).tab('show');
				});
				if(window.hcompass==1){
					var holder = "page_load";
					var id = "tabs-2";
					var controller = "Multifuente";
					var action = "resultados";
					var args=[];
					args.push(<?php echo $_SESSION['USER-AD']['id_personal'] ?>);
					$.post(AJAX + holder, {
						controller:controller,
						action:action,
						args:args,
					}, function(response) {
						$("#preloader").append('<div style="position:absolute;left:50%;top:50%;color:white"><i class="fa fa-spinner fa-pulse fa-5x"></i></div>');
						$("#"+id).empty();
						$("#"+id).append(response);
					});
				}
			});


			var mostrar_plan=function(){
				$('#tabs a[href="#tabs-4"]').tab('show');
			}

		</script>
