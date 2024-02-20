<?php 
$id_e=$_SESSION['Empresa']['id'];
$rp = new Riesgo_psicosocial();
$is = $rp->select($id_e);
$date_0 = date_create($rp->fecha);
$date_1 = date_create(date('Y-m-d'));
if($is){ 
	if($date_0 < $date_1){
	$rp_template = new Riesgo_psicosocialController('Riesgo_psicosocial','riesgo_psicosocial','definir',0,true,true); 
	$rp_template->definir(); 
	$rp_template->ar_destruct();
	unset($rp_template);  
}else{
	?>
	<div class="alert alert-info" role="alert">Esta evaluación esta en proceso hasta el <?php echo $rp->htmlprnt(strftime("%A %d de %B del %Y",strtotime($rp->getFecha()))) ?></div>
	<?php
}
}else{ 
	$rp_template = new Riesgo_psicosocialController('Riesgo_psicosocial','riesgo_psicosocial','definir',0,true,true); 
	$rp_template->definir(); 
	$rp_template->ar_destruct();
	unset($rp_template); 
} ?>