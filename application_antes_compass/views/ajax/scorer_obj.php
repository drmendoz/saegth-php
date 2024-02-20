<?php
$meth = new Ajax();
if($_REQUEST){
	$err_arr=array();
	$id = $_REQUEST['id'];
	if (isset($_POST['guardar'])){
		$meth->query('DELETE FROM scorer_objetivo WHERE id_personal='.$id.' AND periodo='.$_POST['periodo'].'');
    	$aux=0;
	$aux2="";
	$total=$_POST['total'];
	$sel_pa=$_POST['sel_pa'];
	$no_reg=$_POST['no_reg'];
	$id_padre="";
	foreach ($_POST['obj'] as $a => $b) {
	  $aux+=1;
    		$obj = mysqli_real_escape_string($meth->link,$_POST['obj'][$a]);
    		$ind = mysqli_real_escape_string($meth->link,$_POST['ind'][$a]);
    		if($_POST['alt'])
    			$tname = 'scorer_objetivo';
    		else
    			$tname = 'scorer_objetivo_archivo';
    		// var_dump($_POST['periodo']);
	    	$meth->query('INSERT INTO `'.$tname.'`( `id_personal`, `objetivo`, `indicador`, `unidad`,`periodo`) VALUES ('.$id.',"'.$obj.'","'.$ind.'",'.$_POST['und'][$a].',"'.$_POST['periodo'].'")');
			// echo 'INSERT INTO `'.$tname.'`( `id_personal`, `objetivo`, `indicador`, `unidad`) VALUES ('.$id.',"'.$obj.'","'.$ind.'",'.$_POST['und'][$a].')';
 			if(mysqli_error($meth->link))
 				array_push($err_arr, mysqli_error($meth->link));
			$meta=array();
			$id_a=mysqli_insert_id($meth->link);
			if(isset($_POST['meta'][$a])){
		    	for ($i=0; $i < sizeof($_POST['meta'][$a]); $i++) { 
	    			array_push($meta, $_POST['meta'][$a][$i]);
		    	}
		    	$meta = serialize($meta);
				$meta=mysqli_real_escape_string($meth->link,$meta);
		    	$meth->query('UPDATE `scorer_objetivo` SET `meta`="'.$meta.'" WHERE id='.$id_a.'');
				if(mysqli_error($meth->link))
 				array_push($err_arr, mysqli_error($meth->link)); 
			}
			if(isset($_POST['peso'][$a])){
		    	$meth->query('UPDATE `scorer_objetivo` SET `peso`="'.$_POST['peso'][$a].'" WHERE id='.$id_a.'');
					if(mysqli_error($meth->link))
 				array_push($err_arr, mysqli_error($meth->link)); 
			}
			if(isset($_POST['lreal'][$a])){
		    	$meth->query('UPDATE `scorer_objetivo` SET `lreal`="'.$_POST['lreal'][$a].'" WHERE id='.$id_a.'');
				if(mysqli_error($meth->link))
 				array_push($err_arr, mysqli_error($meth->link)); 
		 
			}
			if(isset($_POST['lpond'][$a])){
		    	$meth->query('UPDATE `scorer_objetivo` SET `lpond`="'.$_POST['lpond'][$a].'" WHERE id='.$id_a.'');
				if(mysqli_error($meth->link))
 				array_push($err_arr, mysqli_error($meth->link)); 
			}
			if(isset($_POST['ppond'][$a])){
		    	$meth->query('UPDATE `scorer_objetivo` SET `ppond`="'.$_POST['ppond'][$a].'" WHERE id='.$id_a.'');
				if(mysqli_error($meth->link))
 				array_push($err_arr, mysqli_error($meth->link)); 
			
			}
		
				       
			if(isset($_POST['inv'][$a])){
		    	$meth->query('UPDATE `scorer_objetivo` SET `inverso`="'.$_POST['inv'][$a].'" WHERE id='.$id_a.'');
			}
			/*ini sga*/
			
			if(isset($_POST['padre'][$a])and !empty($_POST['padre'][$a])){
			  if($aux2!=$_POST['padre'][$a])
                           {			  
			    $pa=$id_a-1;
			    $aux2=$_POST['padre'][$a];
			   }
			   
		    	  $meth->query('UPDATE `scorer_objetivo` SET `id_padre`="'.$pa.'" WHERE id='.$id_a.'');
			  
			}
			if(isset($_POST['padre_sup'][$a])and !empty($_POST['padre_sup'][$a])){
			  $pa_sup=$_POST['padre_sup'][$a];
		    	  $meth->query('UPDATE `scorer_objetivo` SET `id_padre_sup`="'.$pa_sup.'" WHERE id='.$id_a.'');
			  
			}
			
			 if($aux==$_POST['sel'])
			{
			 $id_padre=$id_a;
			}
			
			 if(isset($_POST['sel'])and !empty($_POST['sel'])>0 and $aux>$total){
			  $meth->query('UPDATE `scorer_objetivo` SET `id_padre`="'.$id_padre.'" WHERE id='.$id_a.'');
			}
			 if(isset($_POST['sel_pa'])and !empty($_POST['sel_pa']) and ($aux>$total or $no_reg=="S")){
			  $id_padre_sup=$_POST['sel_pa'];
			  $meth->query('UPDATE `scorer_objetivo` SET `id_padre_sup`="'.$id_padre_sup.'" WHERE id='.$id_a.'');
			}
			
			if(isset($_POST['idobj'][$a])and !empty($_POST['idobj'][$a])){
			  $idobj= $_POST['idobj'][$a];
			  $meth->query('update scorer_objetivo set id_padre_Sup='.$id_a.'  where id_padre_Sup='.$idobj.'   and periodo='.$_POST['periodo'].'');
					  
			}
			
			/*fin sga*/
			if($_POST['ajuste']=="") 
				$_POST['ajuste']=0;
	    	$meth->query('UPDATE `scorer_estado` SET `ajuste`="'.$_POST['ajuste'].'" WHERE id_personal='.$id.'');
	    } 
	    if(array_filter($err_arr))
	    	echo 0;
	    else
	    	echo 1;
    }	
}
	     
?>