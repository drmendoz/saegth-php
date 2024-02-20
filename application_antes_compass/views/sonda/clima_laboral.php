<?php 
$id_e=$_SESSION['Empresa']['id'];
$sonda = new Sonda();
$is = $sonda->select($id_e);
$date_0 = date_create($sonda->fecha);
$date_1 = date_create(date('Y-m-d'));
if($is){ 
	if($date_0 < $date_1){
		$sonda_template = new SondaController('Sonda','sonda','definir',0,true,true); 
		$sonda_template->definir(); 
		$sonda_template->ar_destruct();
		unset($sonda_template);
	}else{
		?>
		<div class="alert alert-info" role="alert">Esta evaluación esta en proceso hasta el <?php echo $sonda->getFecha() ?></div>
		<br>
		<button type="button" class="btn btn-primary"><a style="color: white" href='<?php echo BASEURL ?>sonda/definir_v/<?php echo $sonda->getId(9); ?>'>Actualizar evaluación en proceso</a></button>
		<?php
	}
}else{ 
	$sonda_template = new SondaController('Sonda','sonda','definir',0,true,true); 
	$sonda_template->definir(); 
	$sonda_template->ar_destruct();
	unset($sonda_template); 
} 
?>