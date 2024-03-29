<div class="container-fluid">
    <div class="contenedor-principal">
        <div class="card-header config_header">
            <h1><i class="fas fa-bell"></i> <?php _e('WB Cotización'); ?></h1>
        </div>
        <div class="card-body">
            <div class="borde-container">
                <div class="card-header header-titulo"> <?php _e('Datos del producto'); ?> </div>
                <div class="card-body">
                    <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST">
                        <?php $this->wbct_presenta_mensaje(); ?>
                        <input type='hidden' name='action' value='wbct-oper-producto'>
                        <input type='hidden' name='crud' id="crud" value='<?= $aux ?>'>
                        <input type="hidden" value="<?= $id_producto ?>" name="id_producto" id="id_producto">
                        <div class="form-group row" style="margin-bottom:8px">
                            <label for="" class="col-md-4 col-form-label text-md-right">Producto:</label>
                            <div class="col-md-6">
                                <input class="form-control" value="<?= isset($nombre_producto) ? $nombre_producto : ''; ?>" type="text" name="nombre_producto" placeholder="Nombre del producto" required />
                            </div>
                        </div>
                        <div class="form-group row" style="margin-bottom:8px">
                            <label for="" class="col-md-4 col-form-label text-md-right">Descripción:</label>
                            <div class="col-md-6">
                                <textarea class="form-control" type="text" name="descripcion_producto" placeholder="Descripción del producto" required><?= isset($descrip_producto) ? $descrip_producto : ''; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group row" style="margin-bottom:8px">
                            <label for="" class="col-md-4 col-form-label text-md-right">Precio:</label>
                            <div class="col-md-4">
                                <input class="form-control" value="<?= isset($precio_producto) ? $precio_producto : ''; ?>" type="number" step="any" name="precio_producto" placeholder="Precio del producto" required autocomplete="prec_prod" />
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-4 offset-md-4">
                                <button style="display:<?= $boton_registrar ?>" type="submit" name="registrar" class="btn btn-success btn-block">
                                    <i class="fas fa-save"></i> Agregar Producto
                                </button>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-4 offset-md-4">
                                <button style="display:<?= $boton_editar ?>" type="submit" name="updatepro" class="btn btn-success btn-block"> <i class="fas fa-save"></i> Editar Cliente</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <hr>
            <input type="hidden" id="nombre_pagina" value="producto.php">
            <div class="wr-contenedor-search">
                <div class="wr-input-wrapper">
                    <input type="search" class="wr-input-notifica form-control" id="txt-search-notifica" name="txt-search-notifica" onkeyup="wbct_buscar_informacion('','producto.php');" placeholder="<?php _e('Cerca'); ?>">
                    <i id="wr-input-icon" class="fas fa-search"></i>
                </div>
            </div>
            <div>
                <div class="wrbodytable"></div>
            </div>
        </div>

    </div>
</div>