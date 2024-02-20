  <link rel="stylesheet" type="text/css" href="<?php echo BASEURL ?>public/plugins/slick/slick.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="<?php echo BASEURL ?>public/plugins/slick/slick-theme.css" rel="stylesheet">
  <script src="<?php echo BASEURL ?>public/plugins/slick/slick.min.js"></script>
  <div class="col-md-12">
  	<div class="page-width">
	  <?php if (DEBUG) { ?>
	  <div class="alert alert-info" role="alert">El sistema está en mantenimiento. </div>
	  <?php } ?>
  	<?php if($isBlocked){ ?>
  	<div class="alert alert-danger" role="alert">Tiene 3 intentos fallidos. Debe esperar <span id="txt"></span> segundos para poder intentar iniciar sesión nuevamente.</div>
  	<?php	} ?>
  	<?php if(isset($disclaimer) && !$isBlocked){ ?>
  	<div class="alert alert-warning" role="alert">Se necesita un nombre de Usuario y un Password Correcto Para poder Ingresar. <?php echo $disclaimer; ?></div>
  	<?php	} ?>
  	<?php if(isset($info)){ ?>
  	<div class="alert alert-info" role="alert"><?php echo $info; ?></div>
  	<?php	} ?>
  		
  	</div>
  	<div class="alde">
  		<?php 
  		$imgs = scandir(ROOT.DS.'public'.DS.'img'.DS.'logos',SCANDIR_SORT_ASCENDING);
  		unset($imgs[0]);
  		unset($imgs[1]);
  		?>
  		<?php foreach ($imgs as $key => $value) { ?>
  		<div>
  			<img class="img-responsive center-block" src="<?php echo BASEURL.'public'.DS.'img'.DS.'logos'.DS.$value?>" alt="" />
  		</div>
  		<?php	} ?>
  	</div>
  </div>

  <div class="clearfix"></div>
  <p>&nbsp;</p>

  <div class="course-info">
  	<div class="page-width">

  		<div class="col-md-4 form-group">
  			<div class="center-block text-center">
  				<img class="center-block" src="<?php echo BASEURL?>/public/img/Compass.png" alt="" width="300" />
  			</div>
  		</div>
  		<div class="col-md-4 form-group">
  			<div class="center-block text-center">
  				<img class="center-block" src="<?php echo BASEURL?>/public/img/DI.png" width="300" />
  			</div>
  		</div>
  		<div class="col-md-4 form-group">
  			<div class="center-block text-center">
  				<img class="center-block" src="<?php echo BASEURL?>/public/img/Sonda.png" width="300" /> 
  			</div>
  		</div>
  		<div class="clearfix"></div>
  		<div class="col-md-4 form-group">
  			<div class="center-block text-center">
  				<img class="center-block" src="<?php echo BASEURL?>/public/img/scorecard.png" width="300" /> 
  			</div>
  		</div>
  		<div class="col-md-4 form-group">
  			<div class="center-block text-center">
  				<img class="center-block" src="<?php echo BASEURL?>/public/img/riesgopsicosocial.png" width="300" /> 
  			</div>
  		</div>
  		<div class="col-md-4 form-group">
  			<div class="center-block text-center">
  				<img class="center-block" src="<?php echo BASEURL?>/public/img/Selector.png" width="300" /> 
  			</div>
  		</div>
  		<div class="clearfix"></div>
  	</div>
  </div>
  <script type="text/javascript">			
  	var isBlocked = '<?php echo $isBlocked ?>';
  	var time_block = '<?php echo $time_block ?>';
  	var today = new Date(time_block);
  	var now = new Date();
  	var m = today.getMinutes();
  	var nm = now.getMinutes();
  	var s = today.getSeconds();
  	var ns = now.getSeconds();
  	var block_time = <?php echo TIME_PERIOD ?>;
  	var d_m = nm - m;
  	d_m = block_time - 1 - d_m;
  	var d_s = ns - s;
  	if(d_s<0){
  		d_s = -d_s;
  		d_m++;
  	}
  	function startTime() {
  		d_s = checkTime(d_s);
  		if(d_s==0){
  			if(d_m == 0){
  				window.location.reload();
  			}else	
  			d_m = checkTime(d_m);
  		}

  		document.getElementById('txt').innerHTML = d_m + ":" + d_s;
  		if(d_s==0 && d_m==0)
  			window.location.reload();
  		else
  			var t = setTimeout(startTime, 1000);
  	}
  	function checkTime(i) {
  		i = parseInt(i);
  		if(i==0)
  			i=59;
  		else
  			i--;
  		if (i < 10) {i = "0" + i};  
		// console.log(i);
		return i;
	}
	$(document).ready(function(){
		if(isBlocked==1)
			startTime();
		$('.alde').slick({
			dots: true,
			lazyLoad: 'progressive',
			infinite: true,
			speed: 200,
			slidesToShow: 1,
			centerMode: true,
			variableWidth: true,
			/*adaptiveHeight: true,*/
			autoplay: true,
			autoplaySpeed: 3000,
		});
	});
</script>



