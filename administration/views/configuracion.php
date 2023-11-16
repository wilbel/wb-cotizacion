<div class="container-fluid">
    <div class="contenedor-principal">
    <div class="card-header config_header">
            <h1><i class="fas fa-bell"></i> <?php _e('WB Cotización'); ?></h1>
        </div>
        <div class="card-body">
            <div class="card-header header-titulo">
                <h3 style="margin:0"><i class="fas fa-cog"></i> <?php _e('Configuraciones') ?></h3>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <?php $this->wbct_presenta_mensaje(); ?>
                    <div class="borde-container">
                        <div class="card-header header-subtitulo"><?php _e('Iniciar numeración de cotizaciones') ?> </div>
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
                    <div class="borde-container">
                        <div class="card-header header-subtitulo"> <?php _e('Datos de la empresa') ?></div>
                        <div class="card-body">
                            <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST">
                                <input type='hidden' name='action' value='wbct_configuraciones'>
                                <input type='hidden' name='wb_logo' id="wb_logo" value='configuracion_logo'>

                                <div class="form-group row">
                                    <label for="" class="col-md-3 col-form-label text-md-right"><?php _e('Nombre de la empresa:') ?></label>
                                    <div class="col-md-8" style="margin-bottom: 8px;">
                                        <input type="text" class="form-control" name="txttitulo" id="txttitulo" value="<?= $titulo; ?>">
                                    </div>
                                </div>

                                <div class="wbct-box-imagenes">
                                    <div class="wbct-load-foto">
                                        <img src="<?= $url_imagen ?>" style="max-width:260px" />
                                        '<input id="txtimage" type="hidden" name="txtimage" value="<?= $url_imagen; ?>" />
                                    </div>
                                </div>
                                <div class="text-center" style="margin:10px">
                                    <button class="btn btn-success" type="reset" id="btnimagen" onclick="wbct_load_logo()"> <i class="far fa-image"></i> <?php _e("Imagen") ?> </button>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-md-3 col-form-label text-md-right"><?php _e('Titular:') ?></label>
                                    <div class="col-md-8" style="margin-bottom: 8px;">
                                        <input type="text" class="form-control" name="txtpropietario" id="txtpropietario" value="<?= $propietario; ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-md-3 col-form-label text-md-right"><?php _e('Ced/Ruc:') ?></label>
                                    <div class="col-md-8" style="margin-bottom: 8px;">
                                        <input type="text" class="form-control" name="cedulaRuc" id="cedulaRuc" value="<?= $cedulaRuc; ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-md-3 col-form-label text-md-right"><?php _e('Email:') ?></label>
                                    <div class="col-md-8" style="margin-bottom: 8px;">
                                        <input type="email" class="form-control" name="txtemail" id="txtemail" value="<?= $email; ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-md-3 col-form-label text-md-right"><?php _e('Teléfono:') ?></label>
                                    <div class="col-md-8" style="margin-bottom: 8px;">
                                        <input type="text" class="form-control" name="telefono" id="telefono" value="<?= $telefono; ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-md-3 col-form-label text-md-right"><?php _e('Dirección:') ?></label>
                                    <div class="col-md-8" style="margin-bottom: 8px;">
                                        <input type="text" class="form-control" name="direccion" id="direccion" value="<?= $direccion; ?>">
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="" class="col-md-3 col-form-label text-md-right"><?php _e('Descripción:') ?></label>
                                    <div class="col-md-8" style="margin-bottom: 8px;">
                                        <textarea class="form-control" name="descripcion" id="descripcion" cols="30" rows="10" value="<?= $descripcion; ?>"><?= $descripcion; ?></textarea>
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
            </div>
            <hr>
        </div>
    </div>
</div>