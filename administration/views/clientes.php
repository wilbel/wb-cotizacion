<div class="container-fluid">
    <div class="contenedor-principal">
        <div class="card-header">
            <h1><?php _e('Cotización'); ?></h1>
        </div>
        <div class="card-body">
            <div class="borde-container">
                <div class="card-header header-titulo"><?php _e("Datos del cliente") ?> </div>
                <div class="card-body">
                    <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST">
                        <?php $this->wbct_presenta_mensaje(); ?>
                        <input type='hidden' name='action' value='wrpoc-post-cliente'>
                        <input type='hidden' name='crud' id="crud" value='<?= $aux ?>'>
                        <input type="hidden" value="<?= $id; ?>" name="id_cliente" id="id_cliente">
                        <div class="form-group row" style="margin-bottom:8px">
                            <label class="col-md-3 col-form-label text-md-right"> <?php _e("Nombre:") ?> </label>
                            <div class="col-md-8">
                                <input class="form-control" type="text" name="nombre_cliente" value="<?= $nombre; ?>" placeholder="Nombre del cliente o empresa" required />
                            </div>
                        </div>
                        <div class="form-group row" style="margin-bottom:8px">
                            <label class="col-md-3 col-form-label text-md-right"><?php _e("Correo electrónico:") ?> </label>
                            <div class="col-md-8">
                                <input class="form-control" type="email" name="email_cliente" value="<?= $email; ?>" placeholder="Email del cliente o empresa" />
                            </div>
                        </div>
                        <div class="form-group row" style="margin-bottom:8px">
                            <label class="col-md-3 col-form-label text-md-right"><?php _e("Cédula/RUC:") ?> </label>
                            <div class="col-md-8">
                                <input class="form-control" type="number" maxlength="13" name="ruc_dni_cliente" value="<?= $dni_ruc; ?>" placeholder="Identificación del cliente o empresa" required />
                            </div>
                        </div>
                        <div class="form-group row" style="margin-bottom:8px">
                            <label class="col-md-3 col-form-label text-md-right"><?php _e("Télefono:") ?></label>
                            <div class="col-md-8">
                                <input class="form-control" type="number" maxlength="12" id="telefono_cliente" name="telefono_cliente" value="<?= $telf; ?>" placeholder="Teléfeno del cliente o empresa" required />
                            </div>
                        </div>
                        <div class="form-group row" style="margin-bottom:8px">
                            <label class="col-md-3 col-form-label text-md-right"><?php _e("Dirección:") ?> </label>
                            <div class="col-md-8">
                                <textarea name="direccion_cliente" class="form-control" rows="5" placeholder="Dirección del cliente"><?= $observa; ?></textarea>
                            </div>

                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-3 offset-md-3">
                                <button style="display:<?= $actig ?>" type="submit" name="registrar" class="btn btn-success btn-block"> <i class="fas fa-save"></i> <?php _e("Agregar Cliente") ?> </button>
                                <button style="display:<?= $actiu ?>" type="submit" name="updatecli" class="btn btn-success btn-block"> <i class="fas fa-save"></i> <?php _e("Editar Cliente") ?> </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <hr>
            <input type="hidden" id="nombre_pagina" value="clientes.php">
            <div class="wr-contenedor-search">
                <div class="wr-input-wrapper">
                    <input type="search" class="wr-input-notifica form-control" id="txt-search-notifica" name="txt-search-notifica" onkeyup="wbct_buscar_informacion('','clientes.php');" placeholder="<?php _e('Buscar'); ?>">
                    <i id="wr-input-icon" class="fas fa-search"></i>
                </div>
            </div>
            <div>
                <div class="wrbodytable"></div>
            </div>
            <hr>
        </div>
    </div>

</div>