<?php $meth = new Empresa(); ?>
<form action="<?php echo BASEURL ?>empresa/areas" class="register" method="POST">
    <h4 class="page-header"><i class="fa fa-group"></i> Datos de Empresa < <?php echo $meth->htmlprnt($_SESSION['Empresa']['nombre']) ?> ></h4>
    <legend>&Aacute;reas</legend>
    <div class="col-md-12 nested-list">
    <?php 
        $nivel = $meth->DB_exists_double('empresa_area','id_empresa',$_SESSION['Empresa']['id'],'nivel',1);
        echo '<ol>';
            $meth->arrCreate('empresa_area',$nivel);
        echo '</ol>';
    ?>  
    </div>
</form>