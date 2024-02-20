<?php $meth = new Admin(); ?>
<form action="<?php echo BASEURL ?>personal/ingreso" enctype="multipart/form-data" role="form" method="POST">
    <h3 class="page-header"><i class="fa fa-user"></i> Ingreso Personal < <?php echo $_SESSION['Empresa']['nombre'] ?> ></h3>
    <div class="row form-group">
        <div class="col-md-12">
            <legend>Datos Personales</legend>
            <div class="col-md-6"> 
                <label class="col-sm-4">Nombre</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="pr_nombre" required="required" placeholder="Nombres" >
                </div>
            </div>
            <div class="col-md-6">
                <div class="col-md-12">
                    <input accept="image/jpg, image/gif, image/png, image/jpeg" type="file" name="file" id="file" class="input-file">
                </div>
            </div>
        </div>
    </div>
    <?php if (isset($error)){ ?>
            <p class="bg-danger text-center"><?php echo $error ?></p>
    <?php } ?>    
    <div class="row form-group">
        <div class="col-md-2 col-md-offset-10">            
            <fieldset>
                <input class="btn btn-default btn-xs" type="submit" required="required" name="guardar_personal" value="Guardar">
            </fieldset>
        </div>
    </div>
</form>