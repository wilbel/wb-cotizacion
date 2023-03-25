<div class="container-fluid">
    <div class="contenedor-principal">
        <div class="card-header">
            <h1><?php _e('Cotización'); ?></h1>
        </div>
        <div class="well well-sm  card-body">
            <div class="row">
                <div class="col-md-8">
                    <h1><?php _e("Bienvenido"); ?></h1>
                    <p><?php _e("Saludos cordiales, aquí puede gestionar clientes y  Cotizaciones."); ?></p>


                    <p style="font-size: 1em;">
                        <?php printf('En una empresa, las cotizaciones son importantes  porque ayudan con el detalle de los precios y los términos de una transacción propuesta. Por lo general, se utiliza en el contexto de una empresa o negocio que ofrece productos o servicios a sus clientes.') ?>
                    </p>


                </div>
                <div class="col-md-4">
                    <img class="img-logo" width="50%" src="<?=$url_imagen; ?>">
                </div>
            </div>
        </div>
        <div class="borde-container">
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                        <a href="admin.php?page=wbct_menu_clientes" class="btn btn-success"> <i class="far fa-user"></i> <?php _e("clientes") ?> </a>
                        <a href="admin.php?page=wbct_menu_cotizacion" class="btn btn-info"><i class="fas fa-file-invoice"></i> <?php _e("Generar proformas") ?> </a>
                        <a href="admin.php?page=wbct_menu_producto" class="btn btn-info"><i class="fab fa-product-hunt"></i></i> <?php _e("Productos") ?> </a>
                        <a href="admin.php?page=wbct_menu_configuracion" class="btn btn-info"><i class="fas fa-wrench"></i></i> <?php _e("Configuraciones") ?> </a>
                    </div>
                </div>
                <?php $this->wrpro_presenta_mensaje(); ?>
                <hr>
                <input type="hidden" id="nombre_pagina" value="inicio.php">
                <div class="wr-contenedor-search">
                    <div class="wr-input-wrapper">
                        <input type="search" class="wr-input-notifica form-control" id="txt-search-notifica" name="txt-search-notifica" onkeyup="wbct_buscar_informacion('','inicio.php');" placeholder="<?php _e('Cerca'); ?>">
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