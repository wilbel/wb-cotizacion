<div class="container-fluid">
    <div class="contenedor-principal">
        <div class="card-header">
            <h1><?php _e('Cotización'); ?></h1>
        </div>
        <div class="well well-sm  card-body">
            <div class="row">
                <div class="col-md-8">
                    <h1><?php _e("Bienvenido"); ?></h1>
                    <p><?php _e("Saludos cordiales, aquí puede gestionar clientes y  proformas."); ?></p>
                </div>
                <div class="col-md-4">
                    <img class="img-logo" width="50%" src="<?php echo plugin_dir_url(__FILE__) . '../../static/imagenes/icon_wr.png' ?>">
                </div>
            </div>
        </div>
        <div class="borde-container">
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                        <a href="admin.php?page=wrpro_menu_clientes" class="btn btn-success"> <i class="far fa-user"></i> <?php _e("clientes") ?> </a>
                        <a href="admin.php?page=wrpro_menu_listproforma" class="btn btn-info"><i class="fas fa-file-invoice"></i> <?php _e("Generar proformas") ?> </a>
                        <a href="admin.php?page=wrpro_menu_listproforma" class="btn btn-info"><i class="fab fa-product-hunt"></i></i> <?php _e("Productos") ?> </a>
                        <a href="admin.php?page=wrpro_menu_listproforma" class="btn btn-info"><i class="fas fa-wrench"></i></i> <?php _e("Configuraciones") ?> </a>
                    </div>
                </div>
                <?php $this->wrpro_presenta_mensaje(); ?>
                <hr>
                <input type="hidden" id="nombre_pagina" value="inicio.php">
                <div class="wr-contenedor-search">
                    <div class="wr-input-wrapper">
                        <input type="search" class="wr-input-notifica form-control" id="txt-search-notifica" name="txt-search-notifica" onkeyup="wrpro_buscar_informacion('','inicio.phtml');" placeholder="<?php _e('Cerca'); ?>">
                        <i id="wr-input-icon" class="fas fa-search"></i>
                    </div>
                </div>
                <div>
                    <div class="wrbodytable"></div>
                </div>
            </div>
        </div>
    </div>
</div>