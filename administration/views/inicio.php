<div class="container-fluid" style="width: 100%;">
    <div class="col-12">
        <div class="well well-sm cuadrado card-body">
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
        <div id="aux" class="cuadrado">
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12 ">
                        <a href="admin.php?page=wrpro_menu_clientes" class="btn btn-success"> <i class="far fa-user"></i> <?php _e("clientes") ?> </a>
                        <a href="admin.php?page=wrpro_menu_listproforma" class="btn btn-info"><i class="fas fa-file-invoice"></i> <?php _e("Generar proformas") ?> </a>
                    </div>
                </div>
                <?php $this->wrpro_presenta_mensaje(); ?>
                <hr>
                <input type="hidden" id="nombre_pagina" value="inicio.phtml">
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