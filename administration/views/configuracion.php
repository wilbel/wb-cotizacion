<div class="container-fluid">
    <div class="contenedor-principal">
        <div class="card-header">
            <h1><?php _e('Cotización'); ?></h1>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="card-header header-titulo">
                        <h3 style="margin:0"><i class="fas fa-cog"></i> <?php _e('Configuraciones') ?></h3>
                    </div>
                    <?php $this->wrpro_presenta_mensaje(); ?>
                    <div class="borde-container">
                        <div class="card-header header-subtitulo"><?php _e('Iniciar numeración de proformas') ?> </div>
                        <div class="card-body">
                            <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST">
                                <input type='hidden' name='action' value='wbct_configuraciones'>
                                <input type='hidden' name='numeracion' id="numeracion" value='numeracion_proforma'>
                                <div class="form-group row">
                                    <label for="" class="col-md-3 col-form-label text-md-right"><?php _e('Ingresar número para iniciar proformas:') ?> </label>
                                    <div class="col-md-8">
                                        <input class="form-control" type="number" name="numero_codigo" id="numero_codigo" placeholder="Ingresar número para iniciar proformas" required />
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <div class="col-md-3 offset-md-3">
                                        <button type="submit" name="registrar" class="btn btn-success btn-block"> <i class="fas fa-save"></i> <?php _e('Registrar') ?></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="borde-container">
                        <div class="card-header header-subtitulo"> <?php _e('IVA') ?></div>
                        <div class="card-body">
                            <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST">
                                <input type='hidden' name='action' value='wbct_configuraciones'>
                                <input type='hidden' name='wb_configuracion' id="wb_configuracion" value='configuracion_valores'>
                                <div class="form-group row">
                                    <label for="" class="col-md-3 col-form-label text-md-right"><?php _e('Ingresar valor del IVA:') ?></label>
                                    <div class="col-md-8">
                                        <input class="form-control" type="number" step="0.01" name="valorIva" id="valorIva" placeholder="0.12" value="<?= $valor_iva; ?>" required />
                                        <small><?php _e('IVA Ejm:12% = 0.12'); ?></small>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <div class="col-md-3 offset-md-3">
                                        <button type="submit" name="registrar" class="btn btn-success btn-block"> <i class="fas fa-save"></i> <?php _e('Registrar') ?> </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="borde-container">
                        <div class="card-header header-subtitulo"> <?php _e('Condiciones') ?></div>
                        <div class="card-body">
                            <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST">
                                <input type='hidden' name='action' value='wbct_configuraciones'>
                                <input type='hidden' name='wb_condiciones' id="wb_condiciones" value='configuracion_condicion'>
                                <div class="form-group row">
                                    <label for="" class="col-md-3 col-form-label text-md-right"><?php _e('Ingresar las politicas:') ?></label>
                                    <div class="col-md-8" style="margin-bottom: 8px;">
                                        <textarea class="form-control" name="condiciones" id="condiciones" cols="" rows="4" placeholder="Ingresar condiciones"><?= $terminos_condiciones; ?></textarea>
                                        <small><?php _e('Ejm: 1. Se necesita el pago del 50%.'); ?></small>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <div class="col-md-3 offset-md-3">
                                        <button type="submit" name="registrar" class="btn btn-success btn-block"> <i class="fas fa-save"></i> <?php _e('Registrar') ?> </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 ">
                    <p style="font-size: 1em;">
                        <?php printf('En una empresa, las cotizaciones son importantes  porque ayudan con el detalle de los precios y los términos de una transacción propuesta. Por lo general, se utiliza en el contexto de una empresa o negocio que ofrece productos o servicios a sus clientes.') ?>
                    </p>
                    <hr style="border: 2px solid #b8ebe0;">
                    <div class="borde-container">
                        <div class="card-header header-subtitulo"> <?php _e('Logo') ?></div>
                        <div class="card-body">
                            <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST">
                                <input type='hidden' name='action' value='wbct_configuraciones'>
                                <input type='hidden' name='wb_logo' id="wb_logo" value='configuracion_logo'>

                                <div class="form-group row">
                                    <label for="" class="col-md-3 col-form-label text-md-right"><?php _e('Título:') ?></label>
                                    <div class="col-md-8" style="margin-bottom: 8px;">
                                        <input type="text" class="form-control" name="txttitulo" id="txttitulo" value="<?=$titulo;?>">
                                    </div>
                                </div>

                                <div class="wbct-box-imagenes">
                                    <div class="wbct-load-foto">
                                        <img src="<?= $url_imagen ?>" style="max-width:360px" />
                                        '<input id="txtimage" type="hidden" name="txtimage" value="<?=$url_imagen;?>" /> 
                                    </div>
                                </div>

                                <div class="text-center" style="margin:10px">
                                    <button class="btn btn-success" type="reset" id="btnimagen" onclick="wbct_load_logo()"> <i class="far fa-image"></i> <?php _e("Imagen") ?> </button>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-3 offset-md-3">
                                        <button type="submit" name="registrar" class="btn btn-success btn-block"> <i class="fas fa-save"></i> <?php _e('Registrar') ?> </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
        </div>
    </div>
</div>